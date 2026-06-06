@extends('layouts.admin')
@section('title', 'Data Detail Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Data Detail Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Alat</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('tipe.index') }}">Data Tipe Alat</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucwords($tipe->nama_tipe) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-universal btn-add" type="button">
                            <i class="fa fa-plus"></i>Add New
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
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
                    <button onclick="exportPdf({{ $idTipe }})" type="button" class="btn-universal" title="Download">
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
                                    <th>Kode Alat</th>
                                    <th>Kondisi Alat</th>
                                    <th>Status Alat</th>
                                    <th>QR Code</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $index => $detail)
                                    <tr>
                                        <td>
                                            <div class="no-badge">{{ $index + 1 }}.</div>
                                        </td>
                                        <td>{{ $detail->kode_alat }}</td>
                                        <td>{{ ucwords($detail->kondisi_alat) }}</td>
                                        <td>{{ ucwords($detail->status_alat) }}</td>
                                        <td>
                                            <div class="qr-box">
                                                <img class="qr-img" src="{{ asset('storage/' . $detail->qr_code) }}">
                                                <div class="garis"></div>
                                                <div class="kode-wrapper">
                                                    <img class="logo-kecil"
                                                        src="https://smkkotadijawatimur.wordpress.com/wp-content/uploads/2017/04/logo-smkn7-resmi.jpg?w=255">
                                                    <span class="kode">{{ $detail->kode_alat }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-icon btn-edit"
                                                    data-id-detail="{{ $detail->id_detail_alat }}"
                                                    data-kondisi-alat="{{ $detail->kondisi_alat }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-delete"
                                                    data-id-detail="{{ $detail->id_detail_alat }}"
                                                    data-kode-alat="{{ $detail->kode_alat }}" title="Delete">
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
                            <i class="bi bi-exclamation-triangle filter-icon"></i>
                            <div class="filter-label">Kondisi Alat</div>
                        </div>
                        <select id="filterKondisi" class="form-control filterKondisi filter-input">
                            <option value="">All Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="perlu perbaikan">Perlu Perbaikan</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-light btn-back"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                    <button class="btn btn-primary btn-universal" id="btn-apply-filter"><i
                            class="bi bi-check2-circle"></i>Terapkan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-add-data-detail" id="modal-add-data-detail" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white" id="myLargeModalLabel">
                        <i class="fa-solid fa-file-circle-plus"></i> Tambah Alat
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <form action="{{ route('detail.store', $idTipe) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Masukkan jumlah" min="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-arrow-left"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa-solid fa-qrcode"></i>Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-edit-data-detail" id="modal-edit-data-detail" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="myLargeModalLabel">
                        <i class="fa-solid fa-pen-to-square mr-3"></i>Edit Data Detail Alat
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <form id="edit-detail-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="id-detail-alat" name="id_detail_alat">
                        <div class="form-group row align-items-center">
                            <label for="kondisi-alat" class="col-md-3 col-form-label">Kondisi Alat</label>
                            <div class="col-md-9 position-relative">
                                <select name="kondisi_alat" id="kondisi-alat" required class="form-control">
                                    <option value=""disabled>--Pilih--</option>
                                    <option value="baik">Baik</option>
                                    <option value="perlu perbaikan">Perlu Perbaikan</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="footer modal-footer">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-arrow-left"></i>Batal</button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa-solid fa-floppy-disk"></i>Simpan Perubahan</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/dataTable.js') }}"></script>
    <script src="{{ asset('js/dataDetail.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('store_success'))
                $('#store-success-text').html(
                    '<strong>{{ session('store_success') }}</strong>'
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
                    'Data detail alat dengan kode alat <strong>{{ session('update_success') }}</strong> berhasil di update'
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
                let idDetail = $(this).data("id-detail");
                let kodeAlat = $(this).data("kode-alat");

                Swal.fire({
                    title: "Yakin?",
                    html: "Anda ingin menghapus <strong>" + kodeAlat + "</strong>?",
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
                            action: "/delete-detail/" + idDetail,
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
                    html: "Data detail alat dengan kode <strong>{{ session('delete_success') }}</strong> berhasil dihapus",
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
