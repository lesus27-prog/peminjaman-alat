<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\AkunUser;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function siswaIndex()
    {
        $siswas = Siswa::with('akunUser')
            ->whereHas('akunUser', function ($query) {
                $query->where('status_akun', 'aktif');
            })
            ->get();

        $view = Auth::user()->role === 'admin'
            ? 'admin.siswa.siswaIndex'
            : 'kabeng.laporanSiswaIndex';
        return view($view, compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                Rule::unique('siswa', 'nis')
            ],
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'tahun_masuk' => 'required|string'
        ]);

        try {
            DB::beginTransaction();
            $akun_user = AkunUser::create([
                'username' => $request->nis,
                'password' => Hash::make($request->nis),
                'role' => 'siswa',
                'fcm_token' => null
            ]);

            $siswa = Siswa::create([
                'id_akun_user' => $akun_user->id_akun_user,
                'nama_siswa' => strtolower($request->nama_siswa),
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tahun_masuk' => $request->tahun_masuk
            ]);

            DB::commit();
            return redirect()
                ->route('siswa.index')
                ->with('store_success', ucwords(strtolower($request->nama_siswa)));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('store_error', 'Data siswa gagal ditambahkan');
        }
    }

    public function update(Request $request, $idSiswa)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                Rule::unique('siswa', 'nis')->ignore($idSiswa, 'id_siswa'),
            ],
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'tahun_masuk' => 'required|string'
        ]);

        $siswa = Siswa::findOrFail($idSiswa);
        try {
            DB::beginTransaction();
            $siswa->update([
                'nama_siswa' => strtolower($request->nama_siswa),
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tahun_masuk' => $request->tahun_masuk
            ]);

            $siswa->akunUser()->update([
                'username' => $request->nis,
                'password' => Hash::make($request->nis)
            ]);

            DB::commit();
            return redirect()
                ->route('siswa.index')
                ->with('update_success', ucwords(strtolower($siswa->nama_siswa)));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('update_error', 'Data siswa gagal diupdate');
        }
    }

    public function delete($idSiswa)
    {
        try {
            DB::beginTransaction();
            $siswa = Siswa::findOrFail($idSiswa);
            $namaSiswa = ucwords(strtolower($siswa->nama_siswa));
            $siswa->akunUser()->delete();
            $siswa->delete();
            DB::commit();
            return redirect()
                ->route('siswa.index')
                ->with('delete_success', $namaSiswa);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('delete_error', 'Data gagal dihapus');
        }
    }

    public function checkNis(Request $request)
    {
        $nis = $request->nis;
        $id = $request->id_siswa;

        $exists = Siswa::where('nis', $nis)
            ->when($id, function ($q) use ($id) {
                return $q->where('id_siswa', '!=', $id);
            })
            ->exists();

        return response()->json([
            'exist' => $exists
        ]);
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()
                ->route('siswa.index')
                ->with('upload_success', 'Data siswa berhasil diimport');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('upload_error', 'Gagal mengimpor data siswa. Periksa file format!');
        }
    }

    public function tahunAjaranBaru()
    {
        try {
            DB::beginTransaction();
            $tahunSekarang = date('Y');
            $siswaNonaktif = Siswa::with('akunUser')
                ->where('tahun_masuk', '<=', $tahunSekarang - 3)
                ->get();

            foreach ($siswaNonaktif as $siswa) {
                $siswa->akunUser()->update([
                    'status_akun' => 'nonaktif'
                ]);
            }

            Siswa::where('tahun_masuk', $tahunSekarang - 2)
                ->update([
                    'kelas' => DB::raw("REPLACE(kelas, 'xi ', 'xii ')")
                ]);

            Siswa::where('tahun_masuk', $tahunSekarang - 1)
                ->update([
                    'kelas' => DB::raw("REPLACE(kelas, 'x ', 'xi ')")
                ]);

            DB::commit();
            return back()->with(
                'update_tab_success',
                'Tahun ajaran baru berhasil diupdate'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(
                'update_tab_error',
                'Tahun ajaran baru gagal diupdate'
            );
        }
    }

    public function exportLaporanSiswa(Request $request)
    {
        $query = Siswa::query();

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $siswas = $query->get();
        $pdf = Pdf::loadView('exportSiswa', compact('siswas'));

        return $pdf->download('Laporan Data Siswa.pdf');
    }
}
