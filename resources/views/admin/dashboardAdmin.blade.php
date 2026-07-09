@extends('layouts.admin')
@section('link')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Siswa</p>
                        <h3 class="counter" data-target={{ $siswa }}>{{ $siswa }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-purple">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div class="stat-info">
                        <p>Alat Layak Pakai</p>
                        <h3 class="counter" data-target={{ $alat }}>{{ $alat }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-orange">
                        <i class="fa-solid fa-hand-holding"></i>
                    </div>
                    <div class="stat-info">
                        <p>Alat Dipinjam</p>
                        <h3 class="counter" data-target={{ $alatDipinjam }}>{{ $alatDipinjam }}</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-indigo">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <p>Terlambat</p>
                        <h3 class="counter" data-target={{ $terlambat }}>{{ $terlambat }}</h3>
                    </div>
                </div>

            </div>

            <div class="row g-3 m-0">
                <div class="col-md-7 mb-0 pl-0 pr-2 box-chart">
                    <div class="pd-20 card-kondisi card-box">
                        <h4 class="h4 text-dark d-flex align-items-center gap-2">
                            Distribusi Kondisi Alat

                        </h4>
                        <hr class="my-1">

                        <div id="chart8"></div>

                        <hr class="m-0">

                        <div class="table-responsive">
                            <table class="data-table table hover multiple-select-row py-0 px-2 border-0"
                                style="background: #e9edf9b1 !important; border-radius: 22px;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tipe Alat</th>
                                        <th>Kode Alat</th>
                                        <th>Lokasi Rak</th>
                                        <th>Kondisi Alat</th>
                                    </tr>
                                </thead>
                                <tbody id="list-alat">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Klik chart untuk melihat data
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 mb-0 pl-2 pr-0 box-permintaan">
                    <div class="pd-20 card-box height-100-p booking-card">

                        <h4 class="h4 text-dark d-flex align-items-center gap-2">
                            Permintaan Peminjaman
                            <span id="tanggalBadge" class="chip chip-date ml-2"></span>
                        </h4>

                        <hr class="my-1">

                        <div class="booking-header p-2 mt-2">
                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <label class="form-label label">Tanggal</label>
                                    <input type="text" class="form-control" id="bookingDate">
                                </div>

                                <div class="col-md-4">

                                    <button type="button" id="btn-booking-search" class="btn btn-universal w-100 p-1">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 🔥 ISI DARI AJAX -->
                        <div class="booking-content" id="booking-content">
                            <div class="text-center py-5 empty-state">
                                {{-- <div style="font-size: 50px;">📅</div> --}}
                                {{-- <h5 class="mt-3 text-dark">Pilih tanggal</h5>
                                <p class="text-muted mb-0">
                                    lalu klik tombol search
                                </p> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="pd-20 card-box height-100-p lacak-card">
                <h4 class="h4 text-dark d-flex align-items-center gap-2">
                    Lacak Penggunaan Alat
                </h4>
                <hr class="my-1">
                <div class="lacak-header p-2 mt-2">

                    {{-- <form action="{{ route('tracking.alat') }}" method="GET"> --}}
                    <div class="row align-items-end">




                        <div class="col-md-7">
                            <label class="form-label label">Kode alat</label>

                            <div class="input-wrapper">
                                <button class="filter-btn" id="filterBtn" data-toggle="modal" data-target="#filterModal">
                                    <i class="fa fa-sliders"></i>
                                    <span class="filter-badge" id="filterBadge">0</span>
                                </button>

                                <input type="text" name="kode_alat" class="form-control input-with-icon" id="kode-alat"
                                    placeholder="Masukkan kode alat...">
                            </div>
                        </div>
                        <div class="col-md-3">

                            <button id="btn-tracking-search" class="btn btn-universal w-100 p-1" type="button">
                                <i class="fa fa-search"></i>Search
                            </button>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
                <div class="lacak-content" id="lacak-content">

                    <!-- SUMMARY (hidden awal) -->
                    <div class="mini-track-grid mb-3 d-none" id="track-summary"></div>

                    <!-- TABLE (hidden awal) -->
                    <div class="table-wrapper d-none" id="track-table-wrapper">

                        <table class="data-table table hover multiple-select-row py-0 px-2 border-0"     style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Peminjaman</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Keterlambatan</th>
                                    <th>Kondisi Kembali</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>

                            <tbody id="track-table"></tbody>
                        </table>

                    </div>

                    <div class="text-center py-5 empty-state" id="track-empty">

                        <div style="font-size: 55px;">🔎</div>

                        <h5 class="mt-3" style="color: #296087;">
                            Lacak Alat
                        </h5>

                        <p class="text-muted mb-0" style="font-size: 13px; font-weight: 500;">
                            Masukkan kode alat untuk mulai pencarian
                        </p>
                    </div>
                    <!-- LOADING SPINNER -->
                    <div class="text-center py-5 d-none" id="track-loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2" style="font-size: 13px;">
                            Mencari data...
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">
                        <i class="fa fa-filter mr-2"></i> Filter Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="filter-card mb-3">
                        <div class="filter-label-wrapper mb-2">
                            <i class="bi bi-calendar-check filter-icon"></i>
                            <div class="filter-label">Range Tanggal</div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div style="font-size:11px;color:#6b7280;margin-bottom:4px;">Start</div>
                                <input type="text" id="startDate" class="form-control search-box filter-input"
                                    placeholder="📅 Pilih tanggal">
                            </div>

                            <div class="col-6">
                                <div style="font-size:11px;color:#6b7280;margin-bottom:4px;">End</div>
                                <input type="text" id="endDate" class="form-control search-box filter-input"
                                    placeholder="📅 Pilih tanggal">
                            </div>
                        </div>
                    </div>
                    <div class="filter-card">
                        <div class="filter-label-wrapper">
                            <i class="bi bi-exclamation-triangle filter-icon"></i>
                            <div class="filter-label">Kondisi Kembali</div>
                        </div>
                        <select id="filterKondisi" class="form-control filterKondisi filter-input" >
                            <option value="">All Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="perlu perbaikan">Perlu Perbaikan</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>
                <div class=" footer modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal" id="apply-filter"><i
                            class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('deskap/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/apexcharts-setting.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        window.summary = @json($summary);
        window.detail = @json($detail);
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    {{-- <script src="{{ asset('js/dashboardAdmin.js') }}"></script> --}}
@endpush
