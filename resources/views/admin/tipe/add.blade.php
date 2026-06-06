@extends('layouts.admin')
@section('title', 'Tambah Data Tipe Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10 pt-2">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="fa-solid fa-house"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('tipe.index') }}">Data Tipe Alat</a>
                                </li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Data Tipe Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section id="basic-horizontal-layouts p-0">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-12">
                        <div class="card mb-2" style="border-radius: 10px;">
                            <div class="card-header bg-primary text-white ">
                                <h5 class="mb-0 text-white"><i class="bi bi-tools mr-3"></i>Tambah Data Tipe Alat</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('tipe.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="id-jenis">Jenis Alat</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                                            </div>
                                            <select name="id_jenis" id="id-jenis" required class="form-control" style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                @foreach ($jenis as $jns)
                                                    <option value="{{ $jns->id_jenis }}">{{ ucwords($jns->nama_jenis) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nama-tipe">Nama Tipe</label>
                                        <div class="input-group mb-0" id="input-nama-tipe">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="nama-tipe" name="nama_tipe"
                                                placeholder="Masukkan Nama Tipe" style="border-radius: 10px;" required>
                                        </div>
                                        <small id="error-add-tipe" class="text-danger d-none ml-1"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="stok">Stok</label>
                                        <div class="input-group mb-0" id="input-stok">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-archive"></i></span>
                                            </div>
                                            <input type="number" min="1" class="form-control" id="stok"
                                                name="stok" placeholder="Masukkan Stok" style="border-radius: 10px;" required>
                                        </div>
                                        <small id="error-stok" class="text-danger d-none ml-1"></small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="lokasi-rak">Lokasi Rak</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-layers"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="lokasi-rak" name="lokasi_rak"
                                                placeholder="Masukkan Lokasi Rak" style="border-radius: 10px;" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="gambar">Gambar</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                            </div>
                                            <input type="file" class="form-control" id="gambar" name="gambar"
                                                style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 d-flex justify-content-end mb-1 gap-2">
                                        <a href="{{ route('tipe.index') }}" class="btn-action btn-back mr-2">
                                            <i class="fa-solid fa-arrow-left"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-universal">
                                            <i class="fa fa-paper-plane"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/addTipe.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('store_error'))
                toastr.error("{{ session('store_error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000,
                    progressBar: true,
                    closeButton: true
                });
            @endif
        });
    </script>
@endpush
