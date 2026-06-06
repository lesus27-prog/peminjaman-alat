<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailAlat;
use App\Models\JenisAlat;
use App\Models\TipeAlat;
use App\Services\TipeAlatService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TipeAlatController extends Controller
{
    public function tipeIndex()
    {
        $tipes = TipeAlat::with('jenisAlat')->get();
        $jenis = JenisAlat::all();
        $view = Auth::user()->role === 'admin'
            ? 'admin.tipe.tipeIndex'
            : 'kabeng.laporanAlatIndex';

        return view($view, compact('tipes', 'jenis'));
    }

    public function kondisiAlatIndex()
    {
        $kondisi = DetailAlat::with('tipeAlat.jenisAlat')
            ->where('kondisi_alat', '!=', 'baik')
            ->get();

        $jenis = JenisAlat::all();
        $tipe = TipeAlat::all();

        $view = Auth::user()->role === 'admin'
            ? 'admin.tipe.kondisiAlatIndex'
            : 'kabeng.laporanKondisiAlatIndex';

        return view($view, compact('kondisi', 'jenis', 'tipe'));
    }

    public function add()
    {
        $jenis = JenisAlat::all();
        return view('admin.tipe.add', compact('jenis'));
    }

    public function store(Request $request, TipeAlatService $tipeAlatService)
    {
        $request->validate([
            'id_jenis' => 'required',
            'nama_tipe' => 'required|string|unique:tipe_alat,nama_tipe',
            'stok' => 'required|integer|min:1',
            'lokasi_rak' => 'required|string',
            'gambar' => 'nullable|image'
        ]);

        try {
            DB::beginTransaction();
            $tipe = TipeAlat::create([
                'id_jenis' => $request->id_jenis,
                'nama_tipe' => strtolower($request->nama_tipe),
                'stok' => $request->stok,
                'lokasi_rak' => strtolower($request->lokasi_rak),
                'gambar' => ''
            ]);

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $namaFile = $tipe->id_tipe . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/gambarTipe'), $namaFile);
                $tipe->update(['gambar' => 'gambarTipe/' . $namaFile]);
            }

            $tipeAlatService->generateQr($tipe, $tipe->stok);
            DB::commit();
            return redirect()
                ->route('tipe.index')
                ->with('store_success', ucwords(strtolower($tipe->nama_tipe)));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('store_error', 'Data tipe gagal ditambahkan');
        }
    }

    public function update(Request $request, $idTipe)
    {
        $request->validate([
            'nama_tipe' => [
                'required',
                'string',
                Rule::unique('tipe_alat', 'nama_tipe')->ignore($idTipe, 'id_tipe')
            ],
            'lokasi_rak' => 'required|string',
            'gambar' => 'nullable|image'
        ]);

        try {
            $tipe = TipeAlat::findOrFail($idTipe);
            $dataUpdate = [
                'nama_tipe' => strtolower($request->nama_tipe),
                'lokasi_rak' => strtolower($request->lokasi_rak),
                'id_jenis' => $request->id_jenis
            ];

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $namaFile = $tipe->id_tipe . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/gambarTipe'), $namaFile);
                $dataUpdate['gambar'] = 'gambarTipe/' . $namaFile;
            }

            $tipe->update($dataUpdate);
            return redirect()
                ->route('tipe.index')
                ->with('update_success', ucwords(strtolower($tipe->nama_tipe)));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('update_error', 'Data gagal diupdate');
        }
    }

    public function checkNamaTipe(Request $request)
    {
        $nama = $request->nama_tipe;
        $id = $request->id_tipe;

        $query = TipeAlat::where('nama_tipe', $nama);
        if ($id) {
            $query->where('id_tipe', '!=', $id);
        }

        $exists = $query->exists();
        return response()->json([
            'exist' => $exists
        ]);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $tipe = TipeAlat::findOrFail($id);
            $namaTipe = $tipe->nama_tipe;
            $tipe->detailAlat()->delete();
            $tipe->delete();
            DB::commit();
            return redirect()
                ->route('tipe.index')
                ->with('delete_success', ucwords($namaTipe));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('delete_error', 'Data gagal dihapus');
        }
    }

    public function exportLaporanAlat(Request $request)
    {
        $query = TipeAlat::with('jenisAlat');

        if ($request->idJenis) {
            $query->where('id_jenis', $request->idJenis);
        }

        $tipes = $query->get()->groupBy('id_jenis');

        $pdf = Pdf::loadView('exportAlat', compact('tipes'));
        return $pdf->download('Laporan Data Alat.pdf');
    }

    public function exportKondisi(Request $request)
    {

        $query = DetailAlat::with('tipeAlat.jenisAlat');

        if ($request->jenis) {
            $query->whereHas('tipeAlat.jenisAlat', function ($q) use ($request) {
                $q->where('nama_jenis', $request->jenis);
            });
        }

        if ($request->tipe) {
            $query->whereHas('tipeAlat', function ($q) use ($request) {
                $q->where('nama_tipe', $request->tipe);
            });
        }

        if ($request->kondisi) {
            $query->where('kondisi_alat', $request->kondisi);
        } else {
            $query->where('kondisi_alat', '!=', 'baik');
        }

        $kondisi = $query->get()->groupBy(function ($item) {
            return $item->tipeAlat->jenisAlat->nama_jenis;
        });

        $pdf = Pdf::loadView('exportKondisi', compact('kondisi'));

        return $pdf->download('Laporan Kondisi Alat Bermasalah.pdf');
    }
}
