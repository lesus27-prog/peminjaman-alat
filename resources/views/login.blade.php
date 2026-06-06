<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiPinjam</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-smkn7-resmi.jpg') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-smkn7-resmi.jpg') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-smkn7-resmi.jpg') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/button.css') }}" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  
</head>

<body>

    <div class="login-container">
        <div class="left-side">

            <div class="brand">
                <img src="{{ asset('coba.png') }}" alt="Logo" class="logo">

                <div class="brand-text">
                    SiPinjam
                </div>
            </div>

            <div class="left-content">
                <h1 class="title">
                    Sistem Informasi <br>
                    <span>Peminjaman Alat</span>
                </h1>

                <div class="desc">
                    Jurusan Teknik Komputer Jaringan - SMKN 7 Surabaya
                </div>
            </div>

        </div>
        {{-- <div class="left-side">
            <div class="logo">
                <img src="{{ asset('coba.png') }}" alt="Logo">
            </div>

            <h1 class="title">
                Sistem Informasi <br>
                <span>Peminjaman Alat</span>
            </h1>

            <div class="desc">
                Jurusan Teknik Komputer Jaringan - SMKN 7 Surabaya

            </div>
        </div> --}}

        <div class="right-side">
            <div class="login-box">

                <h2>Login</h2>
                <p>Silahkan Login untuk melanjutkan!</p>

                @if (session('error'))
                    <div class="alert alert-danger text-center" id="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="input-wrapper">
                            <i class="icon-copy dw dw-user1"></i>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan username"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="dw dw-padlock1"></i>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="btn-login">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('form').on('submit', function() {
            $('#btn-login')
                .prop('disabled', true)
                .html(`
                <span class="spinner-border spinner-border-sm mr-2"></span>
                Loading...
            `);
        });

        setTimeout(function() {
            $('#alert-error').fadeOut(400, function() {
                $(this).remove();
            });
        }, 3000);
    </script>

</body>

</html>
