@extends('layouts.siswa')
@section('title', 'Riwayat Peminjaman')
@section('link')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Riwayat Peminjaman</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardSiswa.index') }}">Dashboard Siswa</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Riwayat Peminjaman
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-4 box-riwayat">
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
                </div>
                <div id="show-entries" class="ml-0 mt-3"></div>
                <div class="table-responsive p-0 m-0">
                    <table class="table table-hover align-middle data-table py-3 px-4 border-0" id="tableData"
                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Alat</th>
                                <th>Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>
                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                                    <td class="td-detail">
                                        <button class="btn-detail-soft btn-detail">
                                            <span class="icon-wrap">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </button>
                                        <div class="detail-alat mt-2" style="display:none;">
                                            @foreach ($item->tipeAlat as $detail)
                                                <div class="mb-3 pb-2 border-bottom">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-semibold">
                                                            {{ ucwords($detail->nama_tipe) }}
                                                        </span>
                                                        <small class="text-muted">
                                                            x{{ $detail->pivot->quantity }}
                                                        </small>
                                                    </div>
                                                    <div class="mt-2 ps-2">
                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                            <div class="text-muted small">
                                                                • {{ $alat->kode_alat }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->is_terlambat == 1)
                                            <span class="badge badge-soft-danger rounded-pill" data-status="terlambat">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="badge badge-soft-success rounded-pill" data-status="tepat waktu">
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                            <i class="bi bi-tools filter-icon"></i>
                            <div class="filter-label">Tipe Alat</div>
                        </div>
                        <select id="filterTipe" class="form-control filterTipe filter-input">
                            <option value="">All Tipe</option>
                            @foreach ($tipes as $tipe)
                                <option value="{{ $tipe->nama_tipe }}">{{ ucwords($tipe->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-card">
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
                </div>
                <div class="modal-footer justify-content-between footer">
                    <button class="btn btn-light btn-back"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal"><i class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/riwayatPinjam.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.search.push(function(settings, data) {

                let dateStr = data[2];
                if (!dateStr) return true;

                function parseDate(str) {
                    let [day, month, year] = str.split(" ");
                    let months = {
                        "Jan": 0,
                        "Feb": 1,
                        "Mar": 2,
                        "Apr": 3,
                        "May": 4,
                        "Jun": 5,
                        "Jul": 6,
                        "Aug": 7,
                        "Sep": 8,
                        "Oct": 9,
                        "Nov": 10,
                        "Dec": 11
                    };
                    return new Date(year, months[month], day);
                }

                let rowDate = parseDate(dateStr);

                let start = filterState.start;
                let end = filterState.end;

                if (start && !end) return rowDate >= start;
                if (!start && end) return rowDate <= end;
                if (start && end) return rowDate >= start && rowDate <= end;

                return true;
            });
        });
    </script>
@endpush
