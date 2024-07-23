<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>Urakka Sol</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Plugin -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/assets/owl.carousel.min.css') }}">

    <!-- APP CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body class="sidebar-expand counter-scroll">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ url('/login') }}">
                <h2>URAKKA SOL <br> ADMIN DASHBOARD</h2>
            </a>
            <div class="sidebar-close" id="sidebar-close">
                <i class='bx bx-left-arrow-alt'></i>
            </div>
        </div>
        <!-- SIDEBAR MENU -->
        <div class="simlebar-sc" data-simplebar>
            <ul class="sidebar-menu tf">
                <li class="sidebar-submenu">
                    <a href="#" class="sidebar-menu-dropdown">
                        <i class='bx bxs-home'></i>
                        <span>Police Users</span>
                        <div class="dropdown-icon">
                            <i class='bx bx-chevron-down'></i>
                        </div>
                    </a>
                    <ul class="sidebar-menu sidebar-menu-dropdown-content">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/adduser') }}">
                                Add user
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/listuser') }}">
                                List user
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-submenu">
                    <a href="#" class="sidebar-menu-dropdown">
                        <i class='bx bxs-bolt'></i>
                        <span>Master Tables</span>
                        <div class="dropdown-icon"><i class='bx bx-chevron-down'></i></div>
                    </a>
                    <ul class="sidebar-menu sidebar-menu-dropdown-content">
                        <li>
                            <a href="{{ route('reportType.master') }}">
                                Report Type Master
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subdivision.master') }}">
                                Sub-Division Master
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('appConfigMessage.master') }}">
                                App Config Master
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-submenu">
                    <a href="#" class="sidebar-menu-dropdown">
                        <i class='bx bxs-user'></i>
                        <span>Reports</span>
                        <div class="dropdown-icon"><i class='bx bx-chevron-down'></i></div>
                    </a>
                    <ul class="sidebar-menu sidebar-menu-dropdown-content">
                        <li>
                            <a href="{{ url('/getReportList') }}">
                                Report List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.subdivmismatchlist') }}">
                                Sub Division Mismatch
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- END SIDEBAR -->
    @yield('content')

    <div class="overlay"></div>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/apexchart.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

    <!-- APP JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/shortcode.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>


</body>

</html>
