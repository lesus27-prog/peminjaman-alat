@extends('layouts.siswa')
@section('title', 'Daftar Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/src/plugins/switchery/switchery.min.css') }}" />
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
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="#">Dashboard Siswa</a>
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

                    <!-- TANGGAL -->
                    <div class="col-md-3">
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

                    <!-- JAM -->
                    <div class="col-md-3">
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
                                <option value="10:55:00">10:55</option>
                                <option value="19:58:00">19:58</option>
                                <option value="13:45:00">13:45</option>
                                <option value="14:30:00">14:30</option>
                                <option value="15:15:00">15:15</option>
                            </select>
                        </div>
                    </div>

                    <!-- JENIS -->
                    <div class="col-md-3">
                        <label class="filter-label">Jenis</label>
                        <select id="filterJenis" class="form-control form-input">
                            <option value="">All Jenis</option>
                            @foreach ($jenis as $jns)
                                <option value="{{ $jns->nama_jenis }}">{{ $jns->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TIPE -->
                    <div class="col-md-3">
                        <label class="filter-label">Tipe</label>
                        <select id="filterTipe" class="form-control form-input">
                            <option value="">All Tipe</option>
                            @foreach ($tipes as $tipe)
                                <option value="{{ $tipe->nama_tipe }}">{{ $tipe->nama_tipe }}</option>
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
                            <div class="col-12 d-flex justify-content-between align-items-center mb-1">
                                <div id="show-entries" class="ml-0"></div>
                                <div class="d-flex align-items-center">
                                    <span class="mr-2"><i class="bi bi-list"></i></span>
                                    <input type="checkbox" class="switch-btn" id="toggle-view" />
                                    <span class="ml-2"><i class="bi bi-grid"></i></span>
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
                                                            alt="{{ $tipe->nama_tipe }}"
                                                            style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                                    </div>
                                                    <div class="d-flex flex-column ms-2 pl-2">
                                                        <span class="fw-bold text-truncate "
                                                            style="max-width: 150px;">{{ $tipe->nama_tipe }}</span>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $tipe->jenisAlat->nama_jenis }}</td>
                                            <td>
                                                @if ($tipe->stok > 0)
                                                    <span class="status-pill available stok-tersedia">Tersedia
                                                        :
                                                        {{ $tipe->stok }}</span>
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
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="da-card alat-card" data-id="{{ $tipe->id_tipe }}"
                                            data-jenis="{{ strtolower($tipe->jenisAlat->nama_jenis) }}"
                                            data-nama="{{ strtolower($tipe->nama_tipe) }}">
                                            <div class="da-card-photo image-wrapper">
                                                <img src="{{ asset('storage/' . $tipe->gambar) }}"
                                                    alt="{{ $tipe->nama_tipe }}" />
                                            </div>
                                            <div class="kop-line"></div>
                                            <div class="da-card-content pb-0">
                                                <h5 class="h5 text-center">{{ $tipe->nama_tipe }}</h5>
                                                <p class="mb-0 text-center">{{ $tipe->jenisAlat->nama_jenis }}
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
                        <div class="card-body py-3">
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <small class="text-muted">Tanggal Pakai</small>
                                    <h6 id="modal-tanggal-mulai" class="font-weight-bold mb-0"></h6>
                                    <input type="hidden" name="tanggal_mulai" id="hidden-tanggal-mulai">
                                </div>
                                <div class="col-md-6">
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
                                        <option value="12:15:00">12:15</option>
                                        <option value="17:37:00">17:37</option>
                                        <option value="13:00:00">13:00</option>
                                        <option value="13:45:00">13:45</option>
                                        <option value="14:30:00">14:30</option>
                                        <option value="15:15:00">15:15</option>
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
                    <button type="button" class="btn btn-back px-4" data-dismiss="modal"> <i
                            class="fa-solid fa-circle-xmark"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-universal px-4 font-weight-bold" id="btn-konfirmasi">
                        <i class="fa fa-thumbs-up mr-1"></i> Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('deskap/src/plugins/switchery/switchery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('deskap/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/daftarAlat.js') }}"></script>
    <script>
        // let table;
        // $(document).ready(function() {
        // function syncCard() {
        //     let visibleIds = [];

        //     table.rows({
        //         page: 'current'
        //     }).every(function() {
        //         let id = $(this.node()).data('id');
        //         if (id) visibleIds.push(id);
        //     });

        //     $('.alat-card').closest('.col-lg-3').hide();

        //     visibleIds.forEach(function(id) {
        //         $('.alat-card[data-id="' + id + '"]')
        //             .closest('.col-lg-3')
        //             .show();
        //     });
        // }

        // if (!$.fn.DataTable.isDataTable('.data-table')) {
        //     table = $('.data-table').DataTable({
        //         responsive: false,
        //         autoWidth: false,
        //         pageLength: 10,
        //         lengthChange: true,
        //         dom: 'lrtip',
        //         ordering: false,
        //         language: {
        //             search: "",
        //             zeroRecords: "Data tidak ditemukan",
        //             info: "Showing _START_ to _END_ of _TOTAL_ entries",
        //             lengthMenu: "_MENU_",
        //             paginate: {
        //                 next: ">>",
        //                 previous: "<<"
        //             }
        //         }
        //     });

        //     $('#show-entries').html($('.dataTables_length').detach());
        //     $('#show-entries').prepend('<span class="me-1">Show :</span>');
        //     table.on('draw', function() {
        //         syncCard();
        //     });
        // }

        // let timeout;
        // $('#searchInput').on('input', function() {
        //     clearTimeout(timeout);
        //     timeout = setTimeout(() => {
        //         table.search(this.value).draw();
        //     }, 300);
        // });
        // let delayTimer;
        // $('#searchInput').on('keyup', function() {
        //     clearTimeout(delayTimer);
        //     let value = this.value;
        //     delayTimer = setTimeout(function() {
        //         table.search(value).draw();
        //     }, 300);
        // });

        // let isCari = false;
        // let tglMulai;

        // let fpTglMulai = flatpickr("#tanggal-mulai", {
        //     locale: "id",
        //     minDate: "today",
        //     altInput: true,
        //     altInputClass: "form-control form-input",
        //     altFormat: "l, d F Y",
        //     disable: [date => date.getDay() === 0 || date.getDay() === 6],
        //     onChange: function(selectedDates) {
        //         if (!selectedDates.length) return;

        //         if (isCari) {
        //             reset();
        //             // $('#box-ketersediaan').removeClass('active');
        //             // $('#modal-detail-peminjaman').modal('hide');
        //             isCari = false;
        //         }
        //         tglMulai = selectedDates[0];

        //         let daysAdded = 0;
        //         let tempDate = new Date(tglMulai);
        //         while (daysAdded < 3) {
        //             tempDate.setDate(tempDate.getDate() + 1);
        //             if (tempDate.getDay() !== 0 && tempDate.getDay() !== 6) daysAdded++;
        //         }
        //         let tglMax = tempDate;

        //         fpTglSelesai.set('minDate', tglMulai);
        //         fpTglSelesai.set('maxDate', tglMax);

        //         fpTglSelesai.clear();
        //         $('#jam-selesai').val('');
        //         $('#jam-selesai option').prop('disabled', false).css('color', '');

        //         updateJamKembali();
        //         checkNextButton();
        //     }
        // });

        // let fpTglSelesai = flatpickr("#tanggal-selesai", {
        //     locale: "id",
        //     altInput: true,
        //     altFormat: "l, d F Y",
        //     disable: [date => date.getDay() === 0 || date.getDay() === 6],
        //     onChange: updateJamKembali
        // });

        // function updateJamKembali() {
        //     let jamMulai = $('#jam-mulai').val();
        //     let tglSelesaiVal = $('#tanggal-selesai').val();

        //     if (!jamMulai || !tglSelesaiVal || !tglMulai) return;

        //     let tglSelesai = new Date(fpTglSelesai.input.value);

        //     let [jamMulaiNum, menitMulaiNum] = jamMulai.split(':').map(Number);

        //     let isSameDay = tglSelesai.toDateString() === tglMulai.toDateString();

        //     let maxDate = fpTglSelesai.config.maxDate;
        //     let isMaxDay = maxDate && tglSelesai.toDateString() === new Date(maxDate).toDateString();

        //     $('#jam-selesai option').each(function() {
        //         let val = $(this).val();
        //         if (!val) return;

        //         let [jamValNum, menitValNum] = val.split(':').map(Number);

        //         let disable = false;

        //         if (isSameDay) {
        //             disable =
        //                 (jamValNum < jamMulaiNum) ||
        //                 (jamValNum === jamMulaiNum && menitValNum <= menitMulaiNum);
        //         } else if (isMaxDay) {
        //             disable =
        //                 (jamValNum > jamMulaiNum) ||
        //                 (jamValNum === jamMulaiNum && menitValNum > menitMulaiNum);
        //         }

        //         $(this).prop('disabled', disable)
        //             .css('color', disable ? '#aaa' : '');
        //     });

        //     let selected = $('#jam-selesai').val();
        //     if (selected) {
        //         let [jam, menit] = selected.split(':').map(Number);

        //         let invalid =
        //             (isSameDay && (jam < jamMulaiNum || (jam === jamMulaiNum && menit <= menitMulaiNum))) ||
        //             (isMaxDay && (jam > jamMulaiNum || (jam === jamMulaiNum && menit > menitMulaiNum)));

        //         if (invalid) $('#jam-selesai').val('');
        //     }

        // }

        // $('#jam-mulai').on('change', function() {
        //     if (isCari) {
        //         reset();
        //         // $('#box-ketersediaan').removeClass('active');
        //         // $('#modal-detail-peminjaman').modal('hide');
        //         isCari = false;
        //     }

        //     $('#jam-selesai').val('');
        //     updateJamKembali();
        // });

        // $('#tanggal-selesai').on('change', updateJamKembali);

        // $('#filterJenis').select2({
        //     placeholder: "All Jenis",
        //     allowClear: true,
        //     width: '100%'
        // });

        // $('#filterTipe').select2({
        //     placeholder: "All Tipe",
        //     allowClear: true,
        //     width: '100%'
        // });

        // $('#filterJenis').on('change', function() {
        //     let val = $(this).val();
        //     table.column(2).search(val || '').draw();
        // });

        // $('#filterTipe').on('change', function() {
        //     let val = $(this).val();
        //     table.column(1).search(val || '').draw();
        // });

        // $('#btn-cari').on('click', function() {

        //     let tanggalMulai = $('#tanggal-mulai').val();
        //     let jamMulai = $('#jam-mulai').val();

        //     if (!tanggalMulai || !jamMulai) {
        //         toastr.warning('Silahkan pilih tanggal dan jam!');
        //         return;
        //     }

        //     isCari = true;

        //     let formatTglMulai = new Date(tanggalMulai).toLocaleDateString('id-ID', {
        //         weekday: 'long',
        //         year: 'numeric',
        //         month: 'long',
        //         day: 'numeric'
        //     });

        //     $('#tanggal').text(formatTglMulai);
        //     $('#jam').text(jamMulai);

        //     $.ajax({
        //         url: "/check-alat",
        //         // url: "{{ route('alat.check') }}",
        //         type: "GET",
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             tanggal: tanggalMulai,
        //             jam: jamMulai
        //         },
        //         beforeSend: function() {
        //             $('#btn-cari').prop('disabled', true).text('Loading...');
        //         },
        //         success: function(response) {

        //             $('.btn-pinjam').each(function() {
        //                 let jamKey = jamMulai;
        //                 let id = parseInt($(this).data('id'));
        //                 let stokTersedia = response[id]?.[jamKey] ?? 0;
        //                 let row = $(this).closest('tr');
        //                 let card = $('.alat-card[data-id="' + id + '"]');

        //                 row.find('.jumlah')
        //                     .attr('data-stok', stokTersedia)
        //                     .val(stokTersedia > 0 ? 1 : 0);

        //                 card.find('.jumlah')
        //                     .attr('data-stok', stokTersedia)
        //                     .val(stokTersedia > 0 ? 1 : 0);

        //                 if (stokTersedia > 0) {
        //                     card.find('.stok-tersedia')
        //                         .removeClass('empty')
        //                         .addClass('available')
        //                         .text('Tersedia : ' + stokTersedia);

        //                     row.find('.stok-tersedia')
        //                         .removeClass('empty')
        //                         .addClass('available')
        //                         .text('Tersedia : ' + stokTersedia);

        //                 } else {
        //                     card.find('.stok-tersedia')
        //                         .removeClass('available')
        //                         .addClass('empty')
        //                         .text('Tidak Tersedia');

        //                     row.find('.stok-tersedia')
        //                         .removeClass('available')
        //                         .addClass('empty')
        //                         .text('Tidak Tersedia');
        //                 }

        //                 if (stokTersedia <= 0) {
        //                     $(this)
        //                         .prop('disabled', true)
        //                         .removeClass('btn-custom')
        //                         .addClass('btn-secondary')
        //                         .text('Habis');

        //                     row.find('.btn-tambah, .btn-kurang')
        //                         .prop('disabled', true);

        //                     card.addClass('disabled-card');

        //                     card.find('.btn-pinjam')
        //                         .prop('disabled', true)
        //                         .removeClass('btn-custom')
        //                         .addClass('btn-secondary')
        //                         .text('Habis');

        //                     card.find('.btn-tambah, .btn-kurang')
        //                         .prop('disabled', true);

        //                 } else {
        //                     $(this)
        //                         .prop('disabled', false)
        //                         .removeClass('btn-secondary')
        //                         .addClass('btn-custom')
        //                         .text('Pinjam');

        //                     row.find('.btn-tambah, .btn-kurang')
        //                         .prop('disabled', false);

        //                     card.removeClass('disabled-card');

        //                     card.find('.btn-pinjam')
        //                         .prop('disabled', false)
        //                         .removeClass('btn-secondary')
        //                         .addClass('btn-custom')
        //                         .text('Pinjam');

        //                     card.find('.btn-tambah, .btn-kurang')
        //                         .prop('disabled', false);
        //                 }
        //             });

        //             $('#box-ketersediaan').addClass('active').slideDown(400);
        //             $('html, body').animate({
        //                 scrollTop: $('#box-ketersediaan').offset().top - 80
        //             }, 500);

        //             // applyFilter();
        //             // reindexTable();
        //         },
        //         complete: function() {
        //             $('#btn-cari').prop('disabled', false).html('<i class="fa-solid fa-magnifying-glass"></i> Cari');;
        //         }
        //     });
        //     checkNextButton();
        // });

        // function reset() {
        //     fpTglMulai.clear();
        //     $('#jam-mulai').val('');
        //     $('#filterJenis').val(null).trigger('change');
        //     $('#filterTipe').val(null).trigger('change');
        //     table.search('').columns().search('').draw();
        //     $('#box-ketersediaan').removeClass('active').slideUp(300);
        //     $('.alat-table, .alat-card').removeClass('active');
        //     $('.btn-pinjam')
        //         .removeClass('btn-danger')
        //         .addClass('btn-custom')
        //         .text('Pinjam');

        //     $('.jumlah').val(1);
        //     $('.btn-kurang').prop('disabled', true);

        //     $('.btn-tambah').each(function() {
        //         let stok = parseInt($(this).siblings('.jumlah').data('stok') || 0);
        //         $(this).prop('disabled', stok <= 1);
        //     });

        //     // if (fpTglSelesai) fpTglSelesai.clear();

        //     // $('#jam-selesai').val('');
        //     // $('#jam-selesai option').prop('disabled', false).css('color', '');

        //     // $('#list-alat').html('');
        //     // $('#hidden-input').html('');
        //     // $('#modal-tanggal-mulai').text('');
        //     // $('#modal-jam-mulai').text('');

        //     // $('.alat-card').show();
        // }

        // $('#btn-reset').on('click', function() {
        //     reset();
        //     checkNextButton();
        //     // applyFilter();
        // });

        // var elem = document.querySelector('#toggle-view');
        // var switchery = new Switchery(elem, {
        //     size: 'small',
        //     color: '#28a745',
        //     secondaryColor: '#f56767'
        // });

        // function toggleView(isCard) {
        //     if (isCard) {
        //         $('#view-card').fadeIn(200);
        //         $('#view-table').hide();
        //     } else {
        //         $('#view-table').fadeIn(200);
        //         $('#view-card').hide();
        //     }
        // }

        // $('#toggle-view').on('change', function() {
        //     toggleView($(this).is(':checked'));
        // });

        // toggleView($('#toggle-view').is(':checked'));

        // $(document).on('click', '.btn-tambah, .btn-kurang', function() {
        //     let parent = $(this).closest('[data-id]');
        //     let id = parent.data('id');
        //     let input = parent.find('.jumlah');
        //     let jumlah = parseInt(input.val());
        //     let stok = parseInt(input.data('stok'));

        //     if ($(this).hasClass('btn-tambah') && jumlah < stok) jumlah++;
        //     if ($(this).hasClass('btn-kurang') && jumlah > 1) jumlah--;

        //     $(`[data-id="${id}"]`).each(function() {
        //         let jml = $(this).find('.jumlah');
        //         let s = parseInt(jml.data('stok'));

        //         jml.val(jumlah);

        //         $(this).find('.btn-kurang').prop('disabled', jumlah <= 1);
        //         $(this).find('.btn-tambah').prop('disabled', jumlah >= s);
        //     });

        // });

        // function toggleAlat(idTipe) {
        //     let alatTable = $(`.alat-table[data-id="${idTipe}"]`);
        //     let alatCard = $(`.alat-card[data-id="${idTipe}"]`);

        //     let btnTablePinjam = alatTable.find('.btn-pinjam');
        //     let btnCardPinjam = alatCard.find('.btn-pinjam');

        //     if (alatTable.hasClass('active') || alatCard.hasClass('active')) {
        //         alatTable.removeClass('active');
        //         alatCard.removeClass('active');

        //         btnTablePinjam.removeClass('btn-danger')
        //             .addClass('btn-custom')
        //             .text('Pinjam');

        //         btnCardPinjam.removeClass('btn-danger')
        //             .addClass('btn-custom')
        //             .text('Pinjam');

        //     } else {
        //         alatTable.addClass('active');
        //         alatCard.addClass('active');

        //         btnTablePinjam.addClass('btn-danger')
        //             .removeClass('btn-custom')
        //             .text('Batal');

        //         btnCardPinjam.addClass('btn-danger')
        //             .removeClass('btn-custom')
        //             .text('Batal');
        //     }
        // }

        // $(document).on('click', '.btn-pinjam', function(e) {
        //     e.stopPropagation();
        //     let idTipe = $(this).data('id');
        //     toggleAlat(idTipe);
        //     checkNextButton();
        // });

        // $('#btn-next').prop('disabled', true);

        // function checkNextButton() {
        //     let tanggalMulai = fpTglMulai.selectedDates.length > 0;
        //     let jamMulai = $('#jam-mulai').val();
        //     $('#btn-next').prop('disabled', !(tanggalMulai || jamMulai));
        // }

        // checkNextButton();
        // $('#tanggal_pakai, #jam_pakai, .btn-pinjam').on('change click', checkNextButton);

        // function checkKonfirmasiButton() {
        //     let jumlahAlat = $('#list-alat tr').length;
        //     $('#btn-konfirmasi').prop('disabled', jumlahAlat === 0);
        // }

        // $('#btn-next').on('click', function() {
        //     let alatDipilih = $('.alat-table.active, .alat-card.active').length > 0;

        //     if (!alatDipilih) {
        //         toastr.error('Silakan pilih minimal 1 alat');
        //         return;
        //     }

        //     let tglMulaiFormat = fpTglMulai.altInput.value;
        //     let tglMulaiAsli = fpTglMulai.input.value;
        //     let jamMulai = $('#jam-mulai').val();

        //     $('#modal-tanggal-mulai').text(tglMulaiFormat);
        //     $('#modal-jam-mulai').text(jamMulai);

        //     $('#hidden-tanggal-mulai').val(tglMulaiAsli);
        //     $('#hidden-jam-mulai').val(jamMulai);

        //     $('#list-alat').html('');
        //     $('#hidden-input').html('');

        //     let alat = {};
        //     $('.alat-table.active, .alat-card.active').each(function() {
        //         let id = $(this).data('id');
        //         let nama = $(this).data('nama');
        //         let jumlah = parseInt($(this).find('.jumlah').val()) || 1;

        //         alat[id] = {
        //             nama,
        //             jumlah
        //         };
        //     });

        //     let index = 0;
        //     for (let id in alat) {
        //         let item = alat[id];

        //         $('#list-alat').append(`
    //             <tr data-index="${index}" data-id="${id}">
    //                 <td>${index + 1}</td>
    //                 <td>${item.nama}</td>
    //                 <td>${item.jumlah}</td>
    //                <td class="text-center">
    //                     <button type="button" class="btn btn-sm btn-delete">
    //                          <i class="fa-solid fa-trash-can"></i>
    //                     </button>
    //                 </td>
    //                                         </tr>
    //                                         `);

        //         $('#hidden-input').append(`
    //             <input type="hidden" name="alat[${index}][id]" value="${id}">
    //             <input type="hidden" name="alat[${index}][jumlah]" value="${item.jumlah}">
    //         `);

        //         index++;
        //     }
        //     checkKonfirmasiButton();
        //     $('#modal-detail-peminjaman').modal('show');

        // function modalDeleteAlat(id) {
        //     let alat = $(`.alat-table[data-id="${id}"], .alat-card[data-id="${id}"]`);

        //     alat.removeClass('active')
        //         .find('.btn-pinjam')
        //         .removeClass('btn-danger')
        //         .addClass('btn-custom')
        //         .text('Pinjam');

        //     alat.find('.jumlah').val(1);
        //     alat.find('.btn-kurang').prop('disabled', true);

        //     alat.find('.btn-tambah').each(function() {
        //         let stok = parseInt($(this).siblings('.jumlah').data('stok')) || 0;
        //         $(this).prop('disabled', stok <= 1);
        //     });
        // }

        // $(document).on('click', '.btn-delete', function() {
        //     let row = $(this).closest('tr');
        //     let id = row.data('id');

        //     modalDeleteAlat(id);
        //     row.remove();

        //     $(`#hidden-input input[value="${id}"]`).remove();
        //     $('#list-alat tr').each(function(index) {
        //         $(this).find('td:first').text(index + 1);
        //     });
        //     checkKonfirmasiButton();
        // });

        });
        // });
    </script>
    <script>
        @if (session('success'))
            toastr.success(
                "{{ session('success') }}",
                "Berhasil", {
                    progressBar: true,
                    closeButton: true,
                    timeOut: 3000,
                    positionClass: "toast-top-right"
                }
            );
        @endif
    </script>
@endpush
