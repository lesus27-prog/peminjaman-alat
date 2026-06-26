<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-smkn7-resmi.jpg') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-smkn7-resmi.jpg') }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('logo-smkn7-resmi.jpg') }}" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- CSS -->

    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('deskap/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet"
        type="text/css"href="{{ asset('deskap/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/style.css') }}" />
    @yield('link')

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
</head>

<body>
    {{-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ asset('deskap/vendors/images/deskapp-logo.svg') }}" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div> --}}

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Search Here" />
                        <div class="dropdown">
                            <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                <i class="ion-arrow-down-c"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">From</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="header-right">

            {{-- <div class="user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                        <i class="icon-copy dw dw-notification"></i>
                        <span class="badge notification-active"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="notification-list mx-h-350 customscroll">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('deskap/vendors/images/img.jpg') }}" alt="" />
                                        <h3>John Doe</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('deskap/vendors/images/photo1.jpg') }}" alt="" />
                                        <h3>Lea R. Frith</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('deskap/vendors/images/photo2.jpg') }}" alt="" />
                                        <h3>Erik L. Richards</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('deskap/vendors/images/photo2.jpg') }}" alt="" />
                                        <h3>John Doe</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('deskap/vendors/images/photo2.jpg') }}" alt="" />
                                        <h3>Renee I. Hansen</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('deskap/vendors/images/photo2.jpg') }}" alt="" />
                                        <h3>Vicki M. Coleman</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <span class="user-icon">
                            <img src="{{ asset('user.png') }}" alt="" />
                        </span>
                        <span class="user-name">
                            Hi, {{ implode(' ', array_slice(explode(' ', ucwords(Auth::user()->username)), 0, 2)) }} 👋
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item border-0 bg-transparent">
                                <i class="dw dw-logout"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="github-link">
                <a href="https://github.com/dropways/deskapp" target="_blank"><img src="vendors/images/github.svg"
                        alt="" /></a>
            </div>
        </div>
    </div>

    <div class="left-side-bar sidebar-light">
        <div class="brand-logo">
            <a href="{{ route('dashboardAdmin.index') }}">
                <img src="{{ asset('logo.png') }}" alt="" class="dark-logo" />
                <img src="{{ asset('logo.png') }}" alt="" class="light-logo" />
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li class="dropdown">
                        <a href="{{ route('dashboardAdmin.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-house-door-fill"></span><span class="mtext">Dashboard
                                Admin</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-people-fill"></span><span class="mtext">User</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
                            <li><a href="{{ route('akun.index') }}">Data Akun User</a></li>

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-tools"></span><span class="mtext">Alat</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('jenis.index') }}">Data Jenis Alat</a></li>
                            <li><a href="{{ route('tipe.index') }}">Data Tipe Alat</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('alat.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-ui-checks"></span><span class="mtext">Daftar Alat</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('peminjamanAdmin.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-file-earmark-post"></span><span class="mtext">Data
                                Peminjaman</span>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="{{ route('riwayatPinjamAdminKabeng.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-bookmarks-fill"></span><span class="mtext">Riwayat
                                Peminjaman</span>
                        </a>
                    </li>
                    {{-- <li class="dropdown">
                        <a href="{{ route('kondisiAlat.index') }}" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-bookmarks-fill"></span><span class="mtext">Alat
                                Bermasalah</span>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        @yield('content')
    </div>

    <!-- js -->
    <script src="{{ asset('deskap/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('deskap/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('deskap/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('deskap/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('deskap/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('deskap/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('deskap/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>


    <!-- Datatable Setting js -->

    {{-- <script src="{{ asset('deskap/vendors/scripts/dashboard3.js') }}"></script> --}}
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @yield('modal')
    @stack('scripts')
</body>

</html>
