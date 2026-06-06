@extends('layouts.admin')
@section('title', 'Tambah Data Akun User')
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
                                <li class="breadcrumb-item d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-house"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('akun.index') }}">Data Akun User</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Data Akun User
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
                                <h5 class="mb-0 text-white">
                                    <i class="fa-solid fa-user-plus"></i>Tambah Data Akun User
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('akun.store') }}" method="post">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="username">Username</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Masukkan username" style="border-radius: 10px;" required>
                                        </div>
                                        <small id="username-error" class="text-danger d-none ml-1"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Masukkan password" style="border-radius: 10px;" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="conf-pwd">Konfirmasi Password</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="conf-pwd" name="conf_pwd"
                                                placeholder="Masukkan konfirmasi password" style="border-radius: 10px;"
                                                required>
                                        </div>
                                        <small id="pwd-error" class="text-danger d-none ml-1"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="role">Role</label>
                                        <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                            </div>
                                            <select name="role" id="role" name="role" required
                                                class="form-control" style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="admin">Admin</option>
                                                <option value="kabeng">Kabeng</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 d-flex justify-content-end mb-1 gap-2">
                                        <a href="{{ route('akun.index') }}" class="btn-action btn-back mr-2">
                                            <i class="fa-solid fa-arrow-left"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-universal" id="btn-submit">
                                            <i class="fa fa-paper-plane"></i>Submit
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
    <script src="{{ asset('js/addAkunUser.js') }}"></script>
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
