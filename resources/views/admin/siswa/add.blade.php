@extends('layouts.admin')
@section('title', 'Tambah Data Siswa')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                                <li class="breadcrumb-item d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-house"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>

                                <li class="breadcrumb-item">
                                    <a href="{{ route('siswa.index') }}">Data Siswa</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Data Siswa
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
                            <div class="card-header">
                                <h5 class="mb-0 text-white"><i class="fa-solid fa-user-plus"></i>Tambah Data Siswa</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('siswa.store') }}" method="post">
                                    @csrf

                                    <!-- US phone mask -->
                                    <div class="form-group mb-3">
                                        <label for="nama-siswa">Nama Siswa</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="nama-siswa" name="nama_siswa"
                                                placeholder="Masukkan nama siswa" style="border-radius: 10px;" required>
                                        </div>
                                    </div>
                                    <!-- US phone mask -->
                                    <div class="form-group mb-3">
                                        <label for="nis">Nomor Induk Siswa</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="nis" name="nis"
                                                placeholder="Masukkan nis siswa" style="border-radius: 10px;" required>
                                        </div>
                                        <small id="error-nis" class="text-danger d-none mt-1 ml-1"></small>
                                    </div>
                                    <!-- US phone mask -->
                                    <div class="form-group mb-3">
                                        <label for="kelas">Kelas</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                            </div>
                                            <select name="kelas" id="kelas" name="kelas" required
                                                class="form-control" style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="x tkj 1">X TKJ 1</option>
                                                <option value="x tkj 2">X TKJ 2</option>
                                                <option value="xi tkj 1">XI TKJ 1</option>
                                                <option value="xi tkj 2">XI TKJ 2</option>
                                                <option value="xii tkj 1">XII TKJ 1</option>
                                                <option value="xii tkj 2">XII TKJ 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="jenis-kelamin">Jenis Kelamin</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                            </div>
                                            <select name="jenis_kelamin" id="jenis-kelamin" required class="form-control"
                                                style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="laki-laki">Laki-Laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tahun-masuk">Tahun Masuk</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="bi bi-gender-ambiguous"></i></span>
                                            </div>
                                            @php
                                                $tahunSekarang = date('Y');
                                            @endphp

                                            <select name="tahun_masuk" id="tahun-masuk" class="form-control" required>
                                                <option value="" disabled selected>--Pilih--</option>

                                                @for ($i = $tahunSekarang; $i >= $tahunSekarang - 3; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            {{-- <select name="tahun_masuk" id="tahun-masuk" required class="form-control"
                                                style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2025</option>
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 d-flex justify-content-end mb-1 gap-2">
                                        <a href="{{ route('siswa.index') }}" class="btn-action btn-back mr-2">
                                            <i class="fa-solid fa-arrow-left"></i>
                                            Batal
                                        </a>
                                        <button type="submit" class="btn btn-universal" id="btn-submit">
                                            <i class="fa-solid fa-paper-plane"></i>
                                            Simpan
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
{{-- @section('modal')
    
@endsection --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     <script src="{{ asset('js/addSiswa.js') }}"></script>
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
