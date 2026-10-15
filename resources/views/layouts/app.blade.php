<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>

<style>
    @media (max-width: 767px) {
        .navbar-brand {
            position: absolute;
            left: 0 !important;
            /* Pastikan benar-benar ke kiri */
            margin-left: 0 !important;
            /* Hilangkan margin tambahan */
            padding-left: 5px !important;
            /* Beri sedikit padding jika terlalu mepet */
            font-size: 1.2rem;
            /* Perkecil ukuran jika perlu */
        }

        .nav-link {
            position: absolute;
            right: 0 !important;
            /* Pastikan benar-benar ke kiri */
            margin-right: 0 !important;
            /* Hilangkan margin tambahan */
            padding-right: 0px !important;
            /* Beri sedikit padding jika terlalu mepet */
        }
    }


    .nav-link {
        position: relative;
        color: #FFFFFF !important;
    }

    #app {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .navbar {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background-color: #00007a;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1050;
    }

    .dropdown-menu {
        z-index: 1055;
        background-color: #010164 !important;
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: #010164 !important;
        /* Biru terang */
        color: #ffffff !important;
    }

    .navbar-brand {
        position: relative;
        margin-left: 95px;
        font-size: 1.5rem;
        font-weight: bold;
        background: linear-gradient(90deg, #dddddd, #ffffff);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .nav-link {
        position: relative;
        right: 95px;
        font-size: 1em;
        font-weight: 500;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .nav-link:hover {
        color: rgb(221, 221, 221) !important;
        transform: scale(1.1);
    }

    /* Beri padding pada main agar tidak tertutup navbar */
    main {
        padding-top: 8px;
    }

    /* Warna utama */
    /* Warna utama */
    /* ====== Warna Dasar ====== */
    body {
        background-color: #f5f7fa;
        /* Abu muda kebiruan */
        color: #2c3e50;
        /* Abu kebiruan gelap */
    }

    /* ====== Navbar ====== */
    .navbar {
        background-color: #001f3f !important;
        /* Biru Navy */
    }

    /* ====== Card ====== */
    .card {
        background-color: #ffffff;
        /* Putih */
        border: 1px solid #d1d9e0;
        /* Border abu kebiruan */
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        /* Shadow lembut */
    }

    /* ====== Teks Muted (Tambahkan Abu & Biru Muda) ====== */
    .text-muted {
        color: #7a8ca5 !important;
        /* Abu kebiruan lembut */
    }

    /* ====== Tombol Utama ====== */
    .btn-primary {
        background-color: #024d97 !important;
        /* Biru Navy */
        border-color: #023c77 !important;
    }

    .btn-primary:hover {
        background-color: #002855 !important;
        /* Biru Navy lebih gelap */
        border-color: #002855 !important;
    }

    /* ====== Tombol Sekunder (Gunakan Warna Abu Hijau) ====== */
    .btn-secondary {
        background-color: #6c8c7b !important;
        /* Abu kehijauan */
        border-color: #6c8c7b !important;
    }

    .btn-secondary:hover {
        background-color: #5a7766 !important;
        /* Abu kehijauan lebih gelap */
        border-color: #5a7766 !important;
    }

    /* ====== Tombol Alternatif (Gunakan Biru Muda) ====== */
    .btn-info {
        background-color: #a0c4ff !important;
        /* Biru Muda */
        border-color: #a0c4ff !important;
        color: #003366 !important;
    }

    .btn-info:hover {
        background-color: #8db5e6 !important;
        /* Biru Muda lebih gelap */
        border-color: #8db5e6 !important;
        color: #ffffff !important;
    }

    /* ====== Input Form (Tambahkan Warna Hangat) ====== */
    .form-control {
        background-color: #ffffff;
        /* Putih */
        border: 1px solid #bfcde0;
        /* Biru abu muda */
        color: #2c3e50;
        /* Abu kebiruan gelap */
    }

    .form-control:focus {
        border-color: #5c85d6 !important;
        /* Biru pastel */
        box-shadow: 0 0 5px rgba(92, 133, 214, 0.5);
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-0" href="{{ route('landing') }}">EventZone</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <a class="nav-link text-white" href="{{ route('landing') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list" style="color: #FFFFFF"></i>
                                </div>Home
                            </a>
                            <li class="nav-item text-white">
                                <a class="nav-link text-white" href="{{ route('tickets') }}">Event</a>
                            </li>
                            <li class="nav-item text-white">
                                <a class="nav-link text-white" href="{{ route('user.dashboard') }}">History</a>
                            </li>
                            <li class="nav-item dropdown">
                                @if (Auth::check() && Auth::user())
                                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        @if (Auth::check() && Auth::user()->hasRole('admin'))
                                            <li><a class="dropdown-item text-white"
                                                    href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item text-white" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); confirmLogout();">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @else
                                    <a class="nav-link text-white" href="#">
                                        {{ Auth::user()->name }}
                                    </a>
                                @endif
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <main class="content flex-grow-1">
            @yield('content')
        </main>
    </div>
    <footer class="text-white py-3" style="background-color:#001f3f;">
        <div class="container">
            <div class="row">
                <!-- Tentang -->
                <div class="col-md-4 offset-md-1"> <!-- Tambahkan offset-md-1 -->
                    <h5 class="fw-bold">About Us</h5>
                    <p class="text-white">We are the best platform to buy concert event tickets easily and safely.</p>
                </div>

                <!-- Kontak -->
                <div class="col-md-4">
                    <h5 class="fw-bold text-start">Contact Us</h5>
                    <!-- Text hanya h5 yang center -->
                    <p class="text-white mb-1"><i class="bi bi-telephone"></i> +62 812-3456-7890</p>
                    <p class="text-white mb-1"><i class="bi bi-envelope"></i> support@namawebsite.com</p>
                    <p class="text-white"><i class="bi bi-geo-alt"></i> Malang, Indonesia</p>
                </div>

                <!-- Media Sosial -->
                <div class="col-md-3">
                    <h5 class="fw-bold">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <i class="bi bi-facebook fs-4" style="color: white;"></i>
                        <i class="bi bi-instagram fs-4" style="color: white;"></i>
                        <i class="bi bi-twitter fs-4" style="color: white;"></i>
                        <i class="bi bi-youtube fs-4" style="color: white;"></i>
                    </div>
                </div>
            </div>

            <hr class="border-light my-2">

            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} EventZone. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>


</body>

</html>
