<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <nav class="sb-topnav navbar navbar-expand navbar-light  bg-light">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('landing') }}">Admin Dashboard</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars" style="color: #FFFFFF"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                    <a class="dropdown-item text-white" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); confirmLogout();">
                        Logout
            </a>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading" style="color: #FFFFFF">Core</div>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"
                                        style="color: #FFFFFF"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading" style="color: #FFFFFF">Data</div>
                            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Data
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> --}}
                            <a class="nav-link" href="{{ route('admin.event.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"
                                        style="color: #FFFFFF"></i></div>Events
                            </a>
                            <a class="nav-link" href="{{ route('admin.category.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chair" style="color: #FFFFFF"></i></div>
                                Categories
                            </a>
                            <a class="nav-link" href="{{ route('admin.ticket.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt" style="color: #FFFFFF"></i>
                                </div>Tickets
                            </a>
                            <a class="nav-link" href="{{ route('admin.fee.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill" style="color: #FFFFFF"></i>
                                </div>fees
                            </a>
                            <a class="nav-link" href="{{ route('admin.ticket_fee.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill" style="color: #FFFFFF"></i>
                                </div>Ticket Fee
                            </a>
                            <a class="nav-link" href="{{ route('admin.transaction') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-history" style="color: #FFFFFF"></i>
                                </div>Transaction
                            </a>
                            {{-- <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    
                                </nav>
                            </div> --}}
                            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> --}}
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                        aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#pagesCollapseError" aria-expanded="false"
                                        aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer" style="background-color: #024a7a; color: #FFFFFF;">
                        <div class="small" style="color: #FFFFFF">Logged in as:</div>
                        {{ Auth::user()->name }}
                    </div>
                </nav>
            </div>
            @yield('content')
        </div>
    </div>




        <script>
            function confirmLogout() {
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- #region -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <style>
        .sb-sidenav.sb-sidenav-light,
        .sb-topnav.navbar-light.bg-light {
            background-color: #0165a8;
            /* Warna biru muda */
        }

        .sb-sidenav.sb-sidenav-light .sb-sidenav-menu .nav-link {
            color: #FFFFFF;
            /* Warna teks putih untuk kontras */
        }

        .sb-topnav.navbar-light.bg-light {
            background-color: #0165a8 !important;
            /* Warna biru muda */
        }

        .sb-topnav.navbar-light .navbar-nav .nav-link {
            color: #FFFFFF !important;
            /* Warna teks putih untuk kontras */
        }

        .sb-topnav.navbar-light .navbar-nav .nav-link:hover {
            color: #ffffff;
            /* Warna teks kuning saat hover */
        }

        .sb-topnav.navbar-light .navbar-brand {
            color: #FFFFFF;
            /* Warna teks putih untuk brand */
        }
    </style>
</body>
