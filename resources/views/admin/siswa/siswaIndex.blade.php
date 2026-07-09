@extends('layouts.admin')
@section('title', 'Data Siswa')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
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
                            <h4>Data Siswa</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">User</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Siswa
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="d-flex flex-column align-items-end gap-2">
                            <button class="btn btn-universal btn-new-year w-100 mb-2" type="button"
                                title="Tahun Ajaran Baru">
                                <i class="fa fa-refresh"></i>
                                Tahun Ajaran Baru
                            </button>
                            <a href="{{ route('siswa.add') }}" class="w-100">
                                <button class="btn btn-universal w-100" type="button" title="Tambah">
                                    <i class="fa fa-plus"></i>
                                    Add New
                                </button>
                            </a>
                        </div>
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
                    <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end m-0 p-0">
                        <button onclick="exportPdf()" type="button" class="btn-universal" title="Download">
                            <i class="fa fa-download"></i>
                            Export
                        </button>
                        <button type="button" class="btn-universal ml-3 btn-import" data-toggle="modal"
                            data-target="#modal-import-data-siswa" title="Upload">
                            <i class="fa fa-upload"></i>
                            Import
                        </button>
                    </div>
                </div>
                <div id="show-entries" class="ml-0 mt-3"></div>
                <div class="pb-20">
                    <div class="table-responsive p-0 m-0">
                        <table class="data-table table hover table-hover multiple-select-row py-3 px-4 border-0"
                            style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Nomor Induk Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tahun Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswas as $index => $siswa)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>{{ ucwords($siswa->nama_siswa) }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ strtoupper($siswa->kelas) }}</td>
                                        <td>{{ ucwords($siswa->jenis_kelamin) }}</td>
                                        <td>{{ $siswa->tahun_masuk }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-siswa="{{ $siswa->id_siswa }}"
                                                    data-nama-siswa="{{ ucwords($siswa->nama_siswa) }}"
                                                    data-nis="{{ $siswa->nis }}" data-kelas="{{ $siswa->kelas }}"
                                                    data-jenis-kelamin="{{ $siswa->jenis_kelamin }}"
                                                    data-tahun-masuk="{{ $siswa->tahun_masuk }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-siswa="{{ $siswa->id_siswa }}"
                                                    data-nama-siswa="{{ ucwords($siswa->nama_siswa) }}" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
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
                    <div class="filter-card">
                        <div class="filter-label-wrapper">
                            <i class="bi bi-mortarboard-fill filter-icon"></i>
                            <div class="filter-label">Kelas</div>
                        </div>
                        <select id="filterKelas" class="form-control filterKelas filter-input">
                            <option value="">All Kelas</option>
                            <option value="x tkj 1">X TKJ 1</option>
                            <option value="x tkj 2">X TKJ 2</option>
                            <option value="xi tkj 1">XI TKJ 1</option>
                            <option value="xi tkj 2">XI TKJ 2</option>
                            <option value="xii tkj 1">XII TKJ 1</option>
                            <option value="xii tkj 2">XII TKJ 2</option>
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

    <div class="modal fade modal-edit" id="modal-edit-data-siswa" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white" id="myLargeModalLabel"><i
                            class="fa-solid fa-pen-to-square"></i>Edit Data Siswa</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="edit-data-siswa" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="card-modal-edit">
                            <input type="hidden" id="id-siswa" name="id_siswa">
                            <div class="form-group row align-items-center">
                                <label for="nama-siswa" class="col-md-3 col-form-label">Nama Siswa</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="nama-siswa" name="nama_siswa"
                                        placeholder="Masukkan Nama Siswa" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="nis" class="col-md-3 col-form-label">NIS</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="nis" name="nis"
                                        placeholder="Masukkan NIS" required>
                                    <small id="error-nis" class="text-danger d-none"></small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="kelas" class="col-md-3 col-form-label">Kelas</label>
                                <div class="col-md-9 position-relative">
                                    <select id="kelas" name="kelas" class="form-control" required>
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="x tkj 1">X TKJ 1</option>
                                        <option value="x tkj 2">X TKJ 2</option>
                                        <option value="xi tkj 1">XI TKJ 1</option>
                                        <option value="xi tkj 2">XI TKJ 2</option>
                                        <option value="xii tkj 1">XII TKJ 1</option>
                                        <option value="xii tkj 2">XII TKJ 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="jenis-kelamin" class="col-md-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-md-9 position-relative">
                                    <select id="jenis-kelamin" name="jenis_kelamin" class="form-control" required>
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="laki-laki">Laki-Laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="tahun-masuk" class="col-md-3 col-form-label">Tahun Masuk</label>
                                <div class="col-md-9 position-relative">
                                    <select id="tahun-masuk" name="tahun_masuk" class="form-control" required>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $tahunSekarang = date('Y');
                                        @endphp
                                        @for ($i = $tahunSekarang; $i >= $tahunSekarang - 3; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer modal-footer pt-0">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-arrow-left"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-universal" id="btn-edit">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-import" id="modal-import-data-siswa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white"><i class="fa fa-upload"></i>Upload Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswa.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="file" class="form-control" accept=".csv,.xlsx,.xls" name="file" required>
                            <small class="form-text">File yang diterima: .csv, .xlsx, .xls</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Format File:</strong> Nama, Nis, Kelas, Jenis Kelamin, Tahun Masuk<br>
                            <small>Contoh: Giorgio, 22325/455.001, X TKJ 1, Laki-Laki, 2026</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal"> <i
                                class="fa-solid fa-arrow-left"></i>Batal</button>
                        <button type="submit" class="btn btn-universal"> <i
                                class="fa-solid fa-paper-plane"></i>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="store-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="store-success-text"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="upload-success-text"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Update Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="update-success-text"></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/dataTable.js') }}"></script>
    <script src="{{ asset('js/dataSiswa.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('store_success'))
                $('#store-success-text').html(
                    'Data siswa dengan nama <strong>{{ session('store_success') }}</strong> berhasil disimpan'
                );

                $('#store-success').modal('show');

                setTimeout(function() {
                    $('#store-success').modal('hide');
                }, 3000);
            @endif

            @if (session('upload_success'))
                $('#upload-success-text').html("{{ session('upload_success') }}");

                $('#upload-success').modal('show');

                setTimeout(function() {
                    $('#upload-success').modal('hide');
                }, 3000);
            @endif

            @if (session('upload_error'))
                toastr.error("{{ session('upload_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif


            @if ($errors->has('file'))
                toastr.error("Gunakan format Excel (.xlsx, .xls, .csv)", "File Tidak Valid", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif

            @if (session('update_success'))
                $('#update-success-text').html(
                    'Data siswa dengan nama <strong>{{ session('update_success') }}</strong> berhasil di update'
                );

                $('#update-success').modal('show');

                setTimeout(function() {
                    $('#update-success').modal('hide');
                }, 3000);
            @endif

            @if (session('update_error'))
                toastr.error("{{ session('update_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif

            $(document).on("click", ".btn-delete", function(e) {
                e.preventDefault();

                let idSiswa = $(this).data("id-siswa");
                let namaSiswa = $(this).data("nama-siswa");

                Swal.fire({
                    title: "Yakin?",
                    html: "Anda ingin menghapus <strong>" + namaSiswa + "</strong>?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-success margin-5",
                        cancelButton: "btn btn-danger margin-5",
                    },
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $("<form>", {
                            method: "POST",
                            action: "/delete-siswa/" + idSiswa,
                        });

                        let token = $("<input>", {
                            type: "hidden",
                            name: "_token",
                            value: "{{ csrf_token() }}",
                        });

                        let method = $("<input>", {
                            type: "hidden",
                            name: "_method",
                            value: "DELETE",
                        });

                        form.append(token, method).appendTo("body").submit();
                    }
                });
            });

            @if (session('delete_success'))
                Swal.fire({
                    title: "Deleted!",
                    html: "Data siswa dengan nama <strong>{{ session('delete_success') }}</strong> berhasil dihapus",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if (session('delete_error'))
                Swal.fire({
                    title: "Gagal!",
                    text: "{{ session('delete_error') }}",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            $(document).on("click", ".btn-new-year", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Tahun Ajaran Baru?",
                    html: ` Data siswa akan diperbarui:
        <br><br>
        <b>X → XI</b><br>
        <b>XI → XII</b><br>
        <b>XII → Tidak Aktif</b>
        `,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, lanjutkan!",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-success margin-5",
                        cancelButton: "btn btn-danger margin-5",
                    },
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $("<form>", {
                            method: "POST",
                            action: "/tahun-ajaran-baru",
                        });

                        let token = $("<input>", {
                            type: "hidden",
                            name: "_token",
                            value: "{{ csrf_token() }}",
                        });

                        form.append(token).appendTo("body").submit();
                    }
                });
            });

            @if (session('update_tab_success'))
                Swal.fire({
                    title: "Update Berhasil!",
                    text: "{{ session('update_tab_success') }}",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if (session('update_tab_error'))
                Swal.fire({
                    title: "Gagal!",
                    text: "{{ session('update_tab_error') }}",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            let timer;
            let nisAwal = '';

            $('#nis').on('input', function() {

                clearTimeout(timer);

                let nis = $(this).val().trim();
                let id = $('#id-siswa').val();

                $('#error-nis').addClass('d-none').text('');

                $('#btn-edit').prop('disabled', false);

                // kalau kosong atau sama dengan NIS awal → aman
                if (nis === '' || nis === nisAwal) return;

                timer = setTimeout(function() {

                    $.ajax({
                        url: '/siswa/check-nis',
                        method: 'POST',
                        data: {
                            nis: nis,
                            id_siswa: id,
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function(res) {

                            if (res.exist) {
                                $('#error-nis')
                                    .removeClass('d-none')
                                    .text('NIS sudah digunakan');

                                $('#btn-edit').prop('disabled', true);
                            } else {
                                $('#error-nis').addClass('d-none').text('');
                                $('#btn-edit').prop('disabled', false);
                            }
                        }
                    });

                }, 400);
            });
        });
    </script>
@endpush
