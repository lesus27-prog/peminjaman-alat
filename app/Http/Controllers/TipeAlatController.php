<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisAlat;
use App\Models\TipeAlat;
use App\Services\TipeAlatService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TipeAlatController extends Controller
{
    public function tipeIndex()
    {
        $tipes = TipeAlat::with('jenisAlat')->get();
        $jenis = JenisAlat::all();
        return view('admin.tipe.tipeIndex', compact('tipes', 'jenis'));
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
            // $extension = $request->file('gambar')->getClientOriginalExtension();
            // $gambarPath = 'gambarTipe/' . $tipe->id_tipe . '.' . $extension;
            // $gambar = $request->file('gambar')->storeAs('public', $gambarPath);

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $namaFile = $tipe->id_tipe . '.' . $file->getClientOriginalExtension();

                // Pindahkan ke storage/app/public/gambarTipe
                $file->move(storage_path('app/public/gambarTipe'), $namaFile);

                // Simpan path relatif ke DB
                $tipe->update(['gambar' => 'gambarTipe/' . $namaFile]);
            }

            // $tipeAlatService->generateQr($tipe, $tipe->stok);

            DB::commit();
            return redirect()->route('tipe.index')->with('store_success', ucwords(strtolower($tipe->nama_tipe)));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data tipe gagal ditambahkan');
        }
    }


    public function update(Request $request, $id)
    {
       
        $request->validate([
            'nama_tipe' => [
                'required',
                'string',
                Rule::unique('tipe_alat', 'nama_tipe')->ignore($id, 'id_tipe')
            ],
            'lokasi_rak' => 'required|string',
            'gambar' => 'nullable|image'
        ]);

        try {
            $tipe = TipeAlat::findOrFail($id);
            $dataUpdate = [
                'nama_tipe' => strtolower($request->nama_tipe),
                'lokasi_rak' => strtolower($request->lokasi_rak),
                'id_jenis' => $request->id_jenis
            ];

            // Kalau ada gambar baru
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar'); // ✅ pakai file()
                $namaFile = $tipe->id_tipe . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/gambarTipe'), $namaFile);
                $dataUpdate['gambar'] = 'gambarTipe/' . $namaFile; // update path gambar
            }

            $tipe->update($dataUpdate);
            return redirect()->route('tipe.index')->with('update_success', ucwords(strtolower($tipe->nama_tipe)));
        } catch (\Exception $e) {
            return redirect()->back()->with('error' . 'Data gagal diupdate');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $tipe = TipeAlat::findOrFail($id);
            $tipe->detailAlat()->delete();
            $tipe->delete();
            DB::commit();
            return redirect()->route('tipe.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }

    public function exportPdf(Request $request)
    {
        if ($request->idJenis) {
            $tipes = TipeAlat::where('id_jenis', $request->idJenis)->get();
        } else {
            $tipes = TipeAlat::all();
        }

        $pdf = Pdf::loadView('admin.tipe.exportPdf', compact('tipes'));

        return $pdf->download('Data Tipe Alat.pdf');
    }
}
