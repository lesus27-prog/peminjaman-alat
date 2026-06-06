<?php

namespace App\Http\Controllers;

use App\Models\JenisAlat;
use App\Models\TipeAlat;
use App\Services\AlatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarAlatController extends Controller
{
    public function daftarAlatIndex()
    {
        $jenis = JenisAlat::all();
        $tipes = TipeAlat::with('jenisAlat')->get();

        $view = Auth::user()->role === 'admin'
            ? 'admin.daftarAlat'
            : 'siswa.daftarAlat';
        return view($view, compact('jenis', 'tipes'));
    }

    public function check(Request $request, AlatService $alatService)
    {
        $result = $alatService->check(
            $request->tglMulai,
            $request->jamMulai
        );

        return response()->json($result);
    }
}
