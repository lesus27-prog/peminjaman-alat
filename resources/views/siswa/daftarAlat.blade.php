@extends('layouts.siswa')
@section('title', 'Daftar Alat')
@section('link')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/src/plugins/switchery/switchery.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daftarAlat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
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
                            <h4>Daftar Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardSiswa.index') }}">Dashboard Siswa</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Daftar Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 card-input mb-4">
                <div class="row mx-0 gx-3 gy-2">
                    <div class="col-md-3 box-input">
                        <label class="filter-label">Tanggal Pakai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-date text-white border-0">
                                    <i class="bi bi-calendar"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control border-left-0 form-input" id="tanggal-mulai"
                                placeholder="Pilih Tanggal">
                        </div>
                    </div>

                    <div class="col-md-3 box-input">
                        <label class="filter-label">Jam Pakai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-time text-white border-0">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                            <select id="jam-mulai" class="form-control border-left-0 form-input">
                                <option value="" disabled selected>Pilih Jam</option>
                                <option value="07:00:00">07:00</option>
                                <option value="07:45:00">07:45</option>
                                <option value="08:30:00">08:30</option>
                                <option value="09:15:00">09:15</option>
                                <option value="10:00:00">10:00</option>
                                <option value="10:45:00">10:45</option>
                                <option value="11:30:00">11:30</option>
                                <option value="12:00:00">12:00</option>
                                <option value="13:45:00">13:45</option>
                                <option value="14:30:00">14:30</option>
                                <option value="15:15:00">15:15</option>
                                <option value="19:40:00">19:40</option>
                                <option value="19:45:00">19:45</option>
                                <option value="19:50:00">19:50</option>
                                <option value="19:55:00">19:55</option>
                                <option value="20:00:00">20:00</option>
                                <option value="20:05:00">20:05</option>
                                <option value="20:10:00">20:10</option>
                                <option value="20:15:00">20:15</option>
                                <option value="20:20:00">20:20</option>
                                <option value="20:25:00">20:25</option>
                                <option value="20:30:00">20:30</option>
                                <option value="20:35:00">20:35</option>
                                <option value="20:40:00">20:40</option>
                                <option value="20:45:00">20:45</option>
                                <option value="20:50:00">20:50</option>
                                <option value="20:55:00">20:55</option>
                                <option value="21:00:00">21:00</option>
                                <option value="21:05:00">21:05</option>
                                <option value="21:10:00">21:10</option>
                                <option value="21:15:00">21:15</option>
                                <option value="21:20:00">21:20</option>
                                <option value="21:25:00">21:25</option>
                                <option value="21:30:00">21:30</option>
                                <option value="21:35:00">21:35</option>
                                <option value="21:40:00">21:40</option>
                                <option value="21:45:00">21:45</option>
                                <option value="21:50:00">21:50</option>
                                <option value="21:55:00">21:55</option>
                                <option value="22:00:00">22:00</option>
                                <option value="22:05:00">22:05</option>
                                <option value="22:10:00">22:10</option>
                                <option value="22:15:00">22:15</option>
                                <option value="22:20:00">22:20</option>
                                <option value="22:25:00">22:25</option>
                                <option value="22:30:00">22:30</option>
                                <option value="22:35:00">22:35</option>
                                <option value="22:40:00">22:40</option>
                                <option value="22:45:00">22:45</option>
                                <option value="22:50:00">22:50</option>
                                <option value="22:55:00">22:55</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 box-input">
                        <label class="filter-label">Jenis Alat</label>
                        <select id="filterJenis" class="form-control form-input">
                            <option value="">All Jenis</option>
                            @foreach ($jenis as $jns)
                                <option value="{{ $jns->nama_jenis }}">{{ ucwords($jns->nama_jenis) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 box-input">
                        <label class="filter-label">Tipe Alat</label>
                        <select id="filterTipe" class="form-control form-input">
                            <option value="">All Tipe</option>
                            @foreach ($tipes as $tipe)
                                <option value="{{ $tipe->nama_tipe }}">{{ ucwords($tipe->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="footer p-0">
                    <button type="button" class="btn btn-universal mr-2 mb-2" id="btn-cari"><i
                            class="fa-solid fa-magnifying-glass"></i>Cari</button>
                    <button type="reset" class="btn btn-back mb-2" id="btn-reset"><i
                            class="fa-solid fa-arrow-rotate-left"></i>Reset</button>
                </div>
            </div>
            <div class="box-ketersediaan" id="box-ketersediaan">
                <div id="section-ketersediaan">
                    <div class="box m-0 border-0">
                        <div class="row align-items-center">
                            <div
                                class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2 gap-2 mt-1">
                                <h6 id="info-tanggal-jam" class="info-premium mb-0 d-flex align-items-center flex-nowrap">
                                    <i class="bi bi-calendar2-week"></i>
                                    <span class="title">Ketersediaan Alat</span>
                                    <span class="divider"></span>
                                    <span id="tanggal" class="chip chip-date"></span>
                                    <span id="jam" class="chip chip-time"></span>
                                </h6>
                                <div class="d-flex flex-wrap align-items-center" style="gap:10px;">
                                    <div class="toolbar-wrapper">
                                        <div class="search-wrapper mb-2">
                                            <i class="fa fa-search search-wrapper-icon"></i>
                                            <input type="text" class="form-control search-box-wrapper"
                                                placeholder="Search..." id="searchInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center mb-1 box-search">
                                <div id="show-entries" class="ml-0"></div>
                                <div class="view-toggle">
                                    <span>
                                        <i class="bi bi-list view-icon" id="list-icon"></i>
                                    </span>

                                    <input type="checkbox" class="switch-btn" id="toggle-view" />

                                    <span>
                                        <i class="bi bi-grid view-icon" id="grid-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="view-table">
                        <div class="table-responsive p-0 m-0">
                            <table class="table table-hover  mb-0 data-table py-3 px-4 border-0"
                                style="background: #e9edf9b1 !important; border-radius: 22px;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tipe Alat</th>
                                        <th>Jenis Alat</th>
                                        <th>Ketersediaan</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipes as $index => $tipe)
                                        <tr class="alat-table" data-id="{{ $tipe->id_tipe }}"
                                            data-nama="{{ $tipe->nama_tipe }}"
                                            data-jenis="{{ $tipe->jenisAlat->nama_jenis }}">
                                            <td>
                                                <div class="no-badge">{{ $index + 1 }}.</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 " style="width:40px;">
                                                        <img src="{{ asset('storage/' . $tipe->gambar) }}"
                                                            class="img-tipe" alt="{{ ucwords($tipe->nama_tipe) }}"
                                                            style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                                    </div>
                                                    <div class=" ms-2 pl-2" style="max-width: 150px;">
                                                        <span class="fw-bold">{{ ucwords($tipe->nama_tipe) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ ucwords($tipe->jenisAlat->nama_jenis) }}</td>
                                            <td>
                                                @if ($tipe->stok > 0)
                                                    <span class="status-pill available stok-tersedia">
                                                        Tersedia : {{ $tipe->stok }}</span>
                                                @else
                                                    <span class="status-pill empty stok-tersedia">Tidak Tersedia</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div
                                                    class="qty-wrapper d-flex align-items-start justify-content-start gap-2">
                                                    <div class="qty-box d-flex align-items-center">
                                                        <button class="qty-btn btn-kurang" disabled>-</button>
                                                        <input type="number" value="1" min="1"
                                                            data-stok="{{ $tipe->stok }}" class="qty-input jumlah"
                                                            style="text-align: center;  width: 27px;" readonly>
                                                        <button class="qty-btn btn-tambah">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-custom btn-pinjam border-0"
                                                    data-id="{{ $tipe->id_tipe }}">
                                                    Pinjam
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="view-card">
                        <div class="card border-0" style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <div class="row clearfix mt-4 mb-3 mx-3">
                                @foreach ($tipes as $tipe)
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-30 box-alat-card">
                                        <div class="da-card alat-card" data-id="{{ $tipe->id_tipe }}"
                                            data-jenis="{{ strtolower($tipe->jenisAlat->nama_jenis) }}"
                                            data-nama="{{ strtolower($tipe->nama_tipe) }}">
                                            <div class="da-card-photo image-wrapper">
                                                <img src="{{ asset('storage/' . $tipe->gambar) }}"
                                                    alt="{{ ucwords($tipe->nama_tipe) }}" />
                                            </div>
                                            <div class="kop-line"></div>
                                            <div class="da-card-content pb-0">
                                                <h5 class="h5 text-center">{{ ucwords($tipe->nama_tipe) }}</h5>
                                                <p class="mb-0 text-center">{{ ucwords($tipe->jenisAlat->nama_jenis) }}
                                                </p>
                                            </div>
                                            <div class="mt-2 mb-2 text-center">
                                                @if ($tipe->stok > 0)
                                                    <span class="status-pill available stok-tersedia">Tersedia
                                                        :
                                                        {{ $tipe->stok }}</span>
                                                @else
                                                    <span class="status-pill empty stok-tersedia">Tidak Tersedia</span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between gap-2">
                                                <div class="qty-box d-flex align-items-center mt-2 mb-3 mx-3">
                                                    <button class="qty-btn btn-kurang" disabled>-</button>
                                                    <input type="number" value="1" min="1"
                                                        data-stok="{{ $tipe->stok }}" class="qty-input jumlah"
                                                        style="text-align: center;  width: 25px;" readonly>
                                                    <button class="qty-btn btn-tambah">+</button>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-custom btn-pinjam m-3"
                                                        data-id="{{ $tipe->id_tipe }}">
                                                        Pinjam
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert-box" class="alert alert-danger alert-dismissible fade show d-none" role="alert"
        style="position: fixed; top: 70px; right: 15px; min-width: 250px; z-index: 1050; background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
        <i class="bi bi-exclamation-circle mr-2"></i>
        <span id="alert-message"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <button type="button" class="btn btn-next" id="btn-next">
        <i class="fa fa-arrow-right"></i>
        Next
    </button>
@endsection
@section('modal')
    <div class="modal fade" id="modal-detail-peminjaman" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <form action="{{ route('peminjamanTipe.store') }}" method="post" class="modal-content shadow">
                @csrf
                <div class="modal-header text-white">
                    <h5 class="modal-title d-flex align-items-center text-white">
                        <i class="fa fa-file-lines mr-3"></i> Detail Peminjaman
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-detail modal-body p-4">
                    <div class="card bg-light mb-3 shadow-sm rounded">
                        <div class="card-body box-waktu-pakai py-3">
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <small class="text-muted">Tanggal Pakai</small>
                                    <h6 id="modal-tanggal-mulai" class="font-weight-bold mb-0"></h6>
                                    <input type="hidden" name="tanggal_mulai" id="hidden-tanggal-mulai">
                                </div>
                                <div class="col-md-6 jam-pakai">
                                    <small class="text-muted">Jam Pakai</small>
                                    <h6 id="modal-jam-mulai" class="font-weight-bold mb-0"></h6>
                                    <input type="hidden" name="jam_mulai" id="hidden-jam-mulai">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mb-4">
                        <div class="col-md-6 pt-1 pb-2">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold" style="font-size: 13px;">Tanggal Kembali</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-date text-white border-0">
                                            <i class="bi bi-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="tanggal-selesai" name="tanggal_selesai"
                                        class="form-control border-left-0 bg-white" placeholder="Pilih Tanggal Kembali"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 pt-1 pb-2">
                            <div class="form-group mb-0">
                                <label class="font-weight-bold" style="font-size: 13px;">Jam Kembali</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-time text-white border-0">
                                            <i class="bi bi-clock"></i>
                                        </span>
                                    </div>
                                    <select name="jam_selesai" id="jam-selesai" class="form-control border-left-0"
                                        required>
                                        <option value="" disabled selected>--Pilih Jam Kembali--</option>
                                        <option value="07:00:00">07:00</option>
                                        <option value="07:45:00">07:45</option>
                                        <option value="08:30:00">08:30</option>
                                        <option value="09:15:00">09:15</option>
                                        <option value="10:00:00">10:00</option>
                                        <option value="10:45:00">10:45</option>
                                        <option value="11:30:00">11:30</option>
                                        <option value="12:20:00">12:20</option>
                                        <option value="13:45:00">13:45</option>
                                        <option value="14:30:00">14:30</option>
                                        <option value="15:15:00">15:15</option>
                                        <option value="19:00:00">19:00</option>
                                        <option value="20:30:00">20:30</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="font-weight-bold mb-3">Daftar Alat Dipinjam</h6>
                    <div class="table-responsive shadow-sm rounded scroll-alat">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Alat</th>
                                    <th width="120">Jumlah</th>
                                    <th width="50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="list-alat"></tbody>
                        </table>
                    </div>
                    <div id="hidden-input"></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-back px-4" data-dismiss="modal">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-universal px-4 font-weight-bold" id="btn-konfirmasi">
                        <i class="fa fa-thumbs-up mr-1"></i> Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="prosesPemesananAlat-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="prosesPemesananAlat-success-text"></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('deskap/src/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('js/daftarAlat.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('prosesPemesananAlat_success'))
                $('#prosesPemesananAlat-success-text').html(
                    '{{ session('prosesPemesananAlat_success') }}'
                );

                $('#prosesPemesananAlat-success').modal('show');

                setTimeout(function() {
                    $('#prosesPemesananAlat-success').modal('hide');
                }, 3000);
            @endif

            @if (session('prosesPemesananAlat_error'))
                toastr.error("{{ session('prosesPemesananAlat_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif
        });
    </script>
@endpush
