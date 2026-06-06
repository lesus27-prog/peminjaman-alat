@extends('layouts.admin')
@section('title', 'Data Tipe Alat')
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
                            <h4>Data Tipe Alat</h4>
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
                                    Data Tipe Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{ route('tipe.add') }}">
                            <button class="btn btn-universal" type="button">
                                <i class="fa fa-plus"></i>
                                Add New
                            </button>
                        </a>
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
                                    <th>Aksi</th>
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
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('detail.index', $tipe->id_tipe) }}"
                                                    class="btn btn-icon btn-view" title="Lihat Detail">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-tipe="{{ $tipe->id_tipe }}"
                                                    data-nama-tipe="{{ ucwords($tipe->nama_tipe) }}"
                                                    data-id-jenis="{{ $tipe->jenisAlat->id_jenis }}"
                                                    data-gambar="{{ asset('storage/' . $tipe->gambar) }}"
                                                    data-stok="{{ $tipe->stok }}"
                                                    data-lokasi-rak="{{ ucwords($tipe->lokasi_rak) }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-tipe="{{ $tipe->id_tipe }}"
                                                    data-nama-tipe="{{ ucwords($tipe->nama_tipe) }}" title="Delete">
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
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal"><i class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-edit fade" id="modal-edit-data-tipe" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="myLargeModalLabel"><i
                            class="fa-solid fa-pen-to-square mr-3"></i>Edit Data Tipe Alat</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="edit-tipe-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="card-modal-edit">
                            <input type="hidden" id="id-tipe" name="id_tipe">
                            <div class="form-group row align-items-center">
                                <label for="id-jenis" class="col-md-3 col-form-label">Nama Jenis</label>
                                <div class="col-md-9 position-relative">
                                    <select name="id_jenis" id="id-jenis" required class="form-control">
                                        <option value=""disabled>--Pilih--</option>
                                        @foreach ($jenis as $jns)
                                            <option value="{{ $jns->id_jenis }}">{{ ucwords($jns->nama_jenis) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="nama-tipe" class="col-md-3 col-form-label">Nama tipe</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="nama-tipe" name="nama_tipe"
                                        placeholder="Masukkan Nama Tipe" required>
                                    <small id="error-edit-tipe" class="text-danger d-none ml-1"></small>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="stok" class="col-md-3 col-form-label">Stok</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="stok" name="stok"
                                        placeholder="Masukkan Stok Alat" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="lokasi-rak" class="col-md-3 col-form-label">Lokasi Rak</label>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="lokasi-rak" name="lokasi_rak"
                                        placeholder="Masukkan Lokasi Rak" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="gambar" class="col-md-3 col-form-label">Gambar</label>
                                <div class="col-md-9 position-relative">
                                    <input type="file" class="form-control" id="gambar" name="gambar">
                                    <div class="mt-2">
                                        <img id="preview-gambar" src="" width="80px" class="img-thumbnail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-arrow-left"></i>Batal</button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa-solid fa-floppy-disk"></i>Simpan Perubahan</button>
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
<script src="{{ asset('js/dataTipe.js') }}"></script>
<script>
    $(document).ready(function() {
        @if (session('store_success'))
            $('#store-success-text').html(
                'Data tipe alat dengan nama <strong>{{ session('store_success') }}</strong> berhasil disimpan'
            );

            $('#store-success').modal('show');

            setTimeout(function() {
                $('#store-success').modal('hide');
            }, 3000);
        @endif

        @if (session('update_success'))
            $('#update-success-text').html(
                'Data tipe alat dengan nama <strong>{{ session('update_success') }}</strong> berhasil di update'
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
            let idTipe = $(this).data("id-tipe");
            let namaTipe = $(this).data("nama-tipe");

            Swal.fire({
                title: "Yakin?",
                html: "Anda ingin menghapus <strong>" + namaTipe + "</strong>?",
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
                        action: "/delete-tipe/" + idTipe,
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
                html: "Data tipe alat dengan nama <strong>{{ session('delete_success') }}</strong> berhasil dihapus",
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
