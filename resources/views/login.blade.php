<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login - SiPinjam</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/style.css') }}" />
    <link rel="stylesheet" href="{{ 'css/universal.css' }}">
    <link rel="stylesheet" href="{{ 'css/button.css' }}">
    <link rel="stylesheet" href="{{ 'css/login.css' }}">
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="#">
                    <img src="{{ asset('logo.png') }}" alt="" />
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div
                    class="col-12 col-lg-5 d-flex flex-column justify-content-center left-panel text-center text-lg-left">
                    <h1 class="title">
                        Sistem Informasi<br>
                        <span style="color:#3668a9">Peminjaman Alat Laboratorium</span>
                    </h1>
                    <p class="subtitle">
                        Jurusan Teknik Komputer Jaringan - SMKN 7 Surabaya
                    </p>
                </div>

                <div class="col-lg-5 d-flex justify-content-center p-0">
                    <div class="login-box m-0" style="width:100%; max-width:420px;">
                        <div class="login-title text-center mb-2">
                            <h2>Login</h2>
                            <p class="text-muted mb-3">Silakan masuk untuk melanjutkan</p>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger text-center">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="input-group custom">
                                <input type="text" class="form-control" placeholder="Username" name="username"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon-copy dw dw-user1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="dw dw-padlock1"></i>
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-universal btn-block" id="btn-login">
                                Masuk
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $('form').on('submit', function() {
            $('#btn-login')
                .prop('disabled', true)
                .text('Loading...');
        });

        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    </script>
</body>

</html>


{{-- <!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('deskap/vendors/images/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('deskap/vendors/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('deskap/vendors/images/favicon-16x16.png') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/style.css') }}" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
        crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="{{ asset('deskap/vendors/images/deskapp-logo.svg') }}" alt="" />
                </a>
            </div>

        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('logo.png') }}" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To DeskApp</h2>
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('siswa.login') }}" method="post">
                            @csrf
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="Username"
                                    name="username" required />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********"
                                    name="password"required />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                        <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">


                                        <button class="btn btn-primary btn-lg btn-block " type="submit">Sign
                                            In</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="{{ asset('deskap/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/layout-settings.js') }}"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script>
        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    </script>
</body>

</html>

 --}}
