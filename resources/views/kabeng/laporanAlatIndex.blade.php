@extends('layouts.kabeng')
@section('title', 'Laporan Data Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tipe.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Laporan Data Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardKabeng.index') }}">Dashboard Kabeng</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Laporan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                   Laporan Data Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-box">
                <div class="toolbar-wrapper">
                    <div class="search-wrapper mb-2">
                        <i class="fa fa-search search-wrapper-icon"></i>
                        <input type="text" class="form-control search-box-wrapper" placeholder="Search..."
                            id="searchInput">
                        <button class="filter-btn" id="filterBtn" data-toggle="modal" data-target="#filterModal">
                            <i class="fa fa-sliders"></i>
                            <span class="filter-badge" id="filterBadge">0</span>
                        </button>
                    </div>
                    <button onclick="exportPdf()" type="button" class="btn-universal" title="Download">
                        <i class="fa fa-download"></i>
                        Export
                    </button>
                </div>
                <div id="show-entries" class="ml-0 mt-3"></div>
                <div class="pb-20">
                    <div class="table-responsive p-0 m-0">
                        <table class="data-table table hover table-hover multiple-select-row py-3 px-4 border-0"
                            style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipe Alat</th>
                                    <th>Stok</th>
                                    <th>Lokasi Rak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipes as $index => $tipe)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>
                                            <span style="display:none">
                                                JENIS_{{ $tipe->jenisAlat->nama_jenis }}
                                            </span>
                                            <div class="tipe-wrapper">
                                                <img src="{{ asset('storage/' . $tipe->gambar) }}"
                                                    alt="{{ ucwords($tipe->nama_tipe) }}" class="img-tipe">
                                                <div class="tipe-text">
                                                    <div class="nama-tipe">{{ ucwords($tipe->nama_tipe) }}</div>
                                                    <div class="jenis-tipe">
                                                        Jenis : {{ ucwords($tipe->jenisAlat->nama_jenis) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $tipe->stok }}</td>
                                        <td>{{ ucwords($tipe->lokasi_rak) }}</td>                                    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <div class="filter-label-wrapper">
                            <i class="fa-solid fa-box filter-icon"></i>
                            <div class="filter-label">Jenis Alat</div>
                        </div>
                        <select id="filterJenis" class="form-control filterJenis filter-input">
                            <option value="">All Jenis</option>
                            @foreach ($jenis as $jns)
                                <option value="{{ $jns->nama_jenis }}" data-id="{{ $jns->id_jenis }}">
                                    {{ ucwords($jns->nama_jenis) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="footer modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal"><i class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/dataTable.js') }}"></script>
    <script src="{{ asset('js/dataTipe.js') }}"></script>
@endpush
