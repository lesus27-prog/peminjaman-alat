@extends('layouts.admin')
@section('title', 'Laporan Kondisi Alat')
@section('link')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection

@section('content')
    @php
        function badgeClass($kondisi)
        {
            if ($kondisi == 'rusak') {
                return 'badge-soft-danger';
            } elseif ($kondisi == 'perlu perbaikan') {
                return 'badge-soft-warning';
            } else {
                return 'badge-soft-dark';
            }
        }

    @endphp
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Alat Bermasalah</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                     Alat Bermasalah
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
                                    <th>Jenis Alat</th>
                                    <th>Tipe Alat</th>
                                    <th>Kode Alat</th>
                                    <th>Kondisi Alat</th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($kondisi as $item)
                                    <tr>

                                        <td>
                                            <div class="no-badge">
                                                {{ $loop->iteration }}.
                                            </div>
                                        </td>

                                        <td>
                                            {{ ucwords($item->tipeAlat->jenisAlat->nama_jenis) }}
                                        </td>
                                        <td>
                                            {{ ucwords($item->tipeAlat->nama_tipe) }}
                                        </td>
                                        <td>
                                            {{ ucwords($item->kode_alat) }}
                                        </td>
                                        <td>
                                            {{ ucwords($item->kondisi_alat) }}
                                        </td>


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
                            <i class="bi bi-people-fill filter-icon"></i>
                            <div class="filter-label">Jenis Alat</div>
                        </div>
                        <select id="filterJenis" class="form-control filterJenis filter-input">
                            <option value="">All Jenis</option>
                            @foreach ($jenis as $item)
                                <option value="{{ $item->nama_jenis }}">{{ ucwords($item->nama_jenis) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-card mb-3">
                        <div class="filter-label-wrapper">
                            <i class="bi bi-people-fill filter-icon"></i>
                            <div class="filter-label">Tipe Alat</div>
                        </div>
                        <select id="filterTipe" class="form-control filterTipe filter-input">
                            <option value="">All Tipe</option>
                            @foreach ($tipe as $item)
                                <option value="{{ $item->nama_tipe }}">{{ ucwords($item->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-card mb-3">
                        <div class="filter-label-wrapper">
                            <i class="bi bi-people-fill filter-icon"></i>
                            <div class="filter-label">Kondisi Alat</div>
                        </div>
                        <select id="filterKondisi" class="form-control filterKondisi filter-input">
                            <option value="">All Kondisi</option>
                            <option value="rusak">Rusak</option>
                            <option value="perlu perbaikan">Perlu Perbaikan</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light btn-back" id="btnResetFilter">
                        <i class="bi bi-arrow-counterclockwise"></i>Reset
                    </button>
                    <button class="btn btn-primary btn-universal" id="btnApplyFilter">
                        <i class="bi bi-check2-circle"></i>Terapkan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/dataTable.js') }}"></script>
    <script src="{{ asset('js/kondisiAlat.js') }}"></script>
@endpush
