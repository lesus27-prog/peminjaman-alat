@extends('layouts.siswa')
@section('title', 'Profil Siswa')
@section('link')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header mb-0">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Profil</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardSiswa.index') }}">Dashboard Siswa</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Profil
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="profile-wrapper">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="avatar">
                            {{ collect(explode(' ', trim($siswa->nama_siswa)))->filter()->map(fn($kata) => strtoupper(substr($kata, 0, 1)))->take(2)->implode('') ?:
                                'NA' }}
                        </div>
                        <div>
                            <h4 class="info-title">{{ strtoupper($siswa->nama_siswa) }}</h4>
                            <div class="info-sub">{{ $siswa->akunUser->username }} •
                                {{ ucwords($siswa->akunUser->status_akun) }}
                            </div>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-box">
                            <div class="label">Nama Lengkap</div>
                            <div class="value">{{ ucwords($siswa->nama_siswa) }}</div>
                        </div>
                        <div class="info-box">
                            <div class="label">Nomor Induk Siswa</div>
                            <div class="value">{{ $siswa->nis }}</div>
                        </div>
                        <div class="info-box">
                            <div class="label">Kelas</div>
                            <div class="value">{{ strtoupper($siswa->kelas) }}</div>
                        </div>
                        <div class="info-box">
                            <div class="label">Jenis Kelamin</div>
                            <div class="value">{{ ucwords($siswa->jenis_kelamin) }}</div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-section h-100 m-0">
                                <div class="form-title">🔒 Ganti Password</div>
                                <form action="{{ route('profile.updatePassword', $siswa->akunUser->id_akun_user) }}"
                                    method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-12 pb-3">
                                            <input type="password" class="form-control" placeholder="Password baru"
                                                name="password_baru" id="password_baru">
                                        </div>
                                        <div class="col-12 pb-3">
                                            <input type="password" class="form-control" placeholder="Konfirmasi password"
                                                name="conf_pwd" id="conf_pwd">
                                            <small id="pwd-error" class="text-danger d-none "></small>
                                        </div>
                                        <div class="col-12 mt-1">
                                            <button class="btn btn-universal w-100" type="submit" id="btn-update-password">
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="col-md-6 box-edit-username">
                            <div class="form-section h-100 m-0">
                                <div class="form-title">🧑‍💻 Ganti Username</div>
                                <form action="{{ route('profile.updateUsername', $siswa->akunUser->id_akun_user) }}"
                                    method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-12 pb-3">
                                            <input type="text" class="form-control" placeholder="Username baru"
                                                id="username_baru" name="username_baru">
                                        </div>
                                        <div class="col-12 pb-3">
                                            <input type="text" class="form-control" placeholder="Konfirmasi username"
                                                id="conf_username" name="conf_username">
                                            <small id="conf-username-error" class="text-danger d-none ml-1"></small>
                                        </div>
                                        <div class="col-12 mt-1">
                                            <button class="btn btn-universal-revert w-100" type="submit"
                                                id="btn-update-username">
                                                Update Username
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
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
    <script src="{{ asset('js/profile.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('update_success'))
                $('#update-success-text').html(
                    '{{ session('update_success') }}'
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
        });
    </script>
@endpush
