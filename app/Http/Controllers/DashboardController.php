<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardAdmin(DashboardService $dashboardService)
    {
        return view('admin.dashboardAdmin', $dashboardService->dashboardAdmin());
    }

    public function dashboardKabeng(DashboardService $dashboardService)
    {
        return view('kabeng.dashboardKabeng', $dashboardService->dashboardKabeng());
    }

    public function dashboardSiswa(DashboardService $dashboardService)
    {
        return view('siswa.dashboardSiswa', $dashboardService->dashboardSiswa());
    }

    public function tracking(Request $request, DashboardService $dashboardService)
    {
        return $dashboardService->tracking($request);
    }

    public function permintaanPinjam(Request $request, DashboardService $dashboardService)
    {
        return $dashboardService->permintaanPinjam($request);
    }
}
