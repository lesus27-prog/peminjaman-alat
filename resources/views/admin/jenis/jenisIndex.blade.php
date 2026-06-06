@extends('layouts.admin')
@section('title', 'Data Jenis Alat')
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
                            <h4>Data Jenis Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Alat</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Jenis Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-universal btn-add" type="button">
                            <i class="fa fa-plus"></i></i>Add New
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-box">
                <div class="toolbar-wrapper">
                    <div class="search-wrapper mb-2">
                        <i class="fa fa-search search-wrapper-icon"></i>
                        <input type="text" class="form-control search-box-wrapper" placeholder="Search..."
                            id="searchInput">
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
                                    <th>Jenis Alat</th>
                                    <th>Jumlah Tipe</th>
                                    <th>Total Alat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jns as $index => $jenis)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>{{ ucwords($jenis->nama_jenis) }}</td>
                                        <td>{{ $jenis->tipeAlat->count() }}</td>
                                        <td>{{ $jenis->tipeAlat->sum('stok') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-jenis="{{ $jenis->id_jenis }}"
                                                    data-nama-jenis="{{ ucwords($jenis->nama_jenis) }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-jenis="{{ $jenis->id_jenis }}"
                                                    data-nama-jenis="{{ ucwords($jenis->nama_jenis) }}" title="Delete">
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
    <div class="modal modal-add fade" id="modal-add-data-jenis" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="myLargeModalAdd"><i class="bi bi-box-seam mr-3"></i>Tambah Data
                        Jenis Alat</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="add-jenis-form" method="POST" action="{{ route('jenis.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="card-modal-add">
                            <div class="form-group row align-items-center">
                                <label for="nama" class="col-md-3 col-form-label">Nama Jenis</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" name="nama_jenis" id="nama"
                                        placeholder="Masukkan Nama Jenis">
                                    <small id="error-jenis" class="text-danger d-none ml-1"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal"><i
                                class="fa-solid fa-arrow-left"></i>Batal</button>
                        <button type="submit" class="btn btn-universal" id="btn-submit"> <i
                                class="fa fa-paper-plane"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-edit fade" id="modal-edit-data-jenis" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="myLargeModalLabel"><i
                            class="fa-solid fa-pen-to-square mr-3"></i>Edit Data Jenis Alat</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="edit-jenis-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="card-modal-edit">
                            <input type="hidden" id="id-jenis" name="id_jenis">
                            <div class="form-group row align-items-center">
                                <label for="nama-jenis" class="col-md-3 col-form-label">Nama Jenis</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="nama-jenis" name="nama_jenis"
                                        placeholder="Masukkan Nama Jenis">
                                    <small id="error-edit-jenis" class="text-danger d-none ml-1"></small>
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
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/dataTable.js') }}"></script>
    <script src="{{ asset('js/dataJenis.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('store_success'))
                $('#store-success-text').html(
                    'Data jenis alat dengan nama <strong>{{ session('store_success') }}</strong> berhasil disimpan'
                );

                $('#store-success').modal('show');

                setTimeout(function() {
                    $('#store-success').modal('hide');
                }, 3000);
            @endif

            @if (session('store_error'))
                toastr.error("{{ session('store_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif

            @if (session('update_success'))
                $('#update-success-text').html(
                    'Data jenis alat dengan nama <strong>{{ session('update_success') }}</strong> berhasil di update'
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
                let idJenis = $(this).data("id-jenis");
                let namaJenis = $(this).data("nama-jenis");

                Swal.fire({
                    title: "Yakin?",
                    html: "Anda ingin menghapus <strong>" + namaJenis + "</strong>?",
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
                            action: "/delete-jenis/" + idJenis,
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
                    html: "Data jenis alat dengan nama <strong>{{ session('delete_success') }}</strong> berhasil dihapus",
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
        });
    </script>
@endpush
