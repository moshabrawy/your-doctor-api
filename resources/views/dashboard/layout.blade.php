<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard | Doctor Appointment System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    @notifyCss
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.jpg') }}" />
</head>

<body>
    @auth('admin')
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="{{ route('Dashboard') }}"><img
                            src="{{ asset('assets/images/logo.png') }}" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="{{ route('Dashboard') }}"><img
                            src="{{ asset('assets/images/logo-mini.png') }}" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    {{-- <div class="search-field d-none d-md-block">
                        <form class="d-flex align-items-center h-100" action="#">
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <i class="input-group-text border-0 mdi mdi-magnify"></i>
                                </div>
                                <input type="text" class="form-control bg-transparent border-0"
                                    placeholder="Search projects">
                            </div>
                        </form>
                    </div> --}}
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown"
                                aria-expanded="false">
                                @if (auth('admin')->user()->avatar != null)
                                    <div class="nav-profile-img">
                                        <img class="profile_img_icon" src="{{ asset(auth('admin')->user()->avatar) }}"
                                            alt="profile" title="profile">
                                        <span class="availability-status online"></span>
                                    </div>
                                @else
                                    <div class="nav-profile-img">
                                        <img class="profile_img_icon" src="{{ asset('assets/images/faces/admin.png') }}"
                                            alt="profile" title="profile">
                                        <span class="availability-status online"></span>
                                    </div>
                                @endif
                                <div class="nav-profile-text">
                                    <p class="mb-1 text-black">{{ auth('admin')->user()->name }}</p>
                                </div>
                            </a>
                            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="{{ route('AdminProfile') }}">
                                    <i class="mdi mdi-account-circle mr-2 text-success"></i> Edit Profile </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('Logout') }}">
                                    <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
                            </div>
                        </li>
                        <li class="nav-item d-none d-lg-block full-screen-link">
                            <a class="nav-link">
                                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                            </a>
                        </li>
                        <li class="nav-item nav-logout d-none d-lg-block">
                            <a class="nav-link" href="{{ route('Logout') }}">
                                <i class="mdi mdi-power"></i>
                            </a>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <a href="{{ route('AdminProfile') }}" class="nav-link">
                                <div class="nav-profile-image">
                                    @if (auth('admin')->user()->avatar != null)
                                        <img class="profile_img_icon" src="{{ asset(auth('admin')->user()->avatar) }}"
                                            alt="profile">
                                    @else
                                        <img class="profile_img_icon" src="{{ asset('assets/images/faces/admin.png') }}"
                                            alt="profile">
                                    @endif
                                    <span class="login-status online"></span>
                                    <!--change to offline or busy as needed-->
                                </div>
                                <div class="nav-profile-text d-flex flex-column">
                                    <span class="font-weight-bold mb-2">{{ auth('admin')->user()->name }}</span>
                                    <span class="text-secondary text-small">Adminstraitor</span>
                                </div>
                                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Dashboard') }}">
                                <span class="menu-title">Dashboard</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-toggle="collapse" href="#doctors-pages"
                                aria-expanded="false" aria-controls="Specialties-pages">
                                <span class="menu-title">Doctors</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-radiobox-marked menu-icon"></i>
                            </a>
                            <div class="collapse" id="doctors-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('doctors.create') }}">
                                            <span class="menu-title">Add New</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('doctors.index') }}">
                                            <span class="menu-title">Manage</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-toggle="collapse" href="#patients-pages"
                                aria-expanded="false" aria-controls="Specialties-pages">
                                <span class="menu-title">Patients</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-radiobox-marked menu-icon"></i>
                            </a>
                            <div class="collapse" id="patients-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('patients.create') }}">
                                            <span class="menu-title">Add New</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('patients.index') }}">
                                            <span class="menu-title">Manage</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link collapsed" data-toggle="collapse" href="#Specialties-pages"
                                aria-expanded="false" aria-controls="Specialties-pages">
                                <span class="menu-title">Specialties</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-radiobox-marked menu-icon"></i>
                            </a>
                            <div class="collapse" id="Specialties-pages">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('specialties.create') }}">
                                            <span class="menu-title">Add New</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('specialties.index') }}">
                                            <span class="menu-title">Manage</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('appointments.index') }}">
                                <span class="menu-title">Appointments</span>
                                <i class="mdi mdi-bookmark-outline menu-icon"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center">
                            <span class="text-muted text-center d-block d-sm-inline-block">Copyright © 2022 <a
                                    href="#" target="_blank">Your Doctor</a>. All rights reserved.</span>
                        </div>
                    </footer>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
    @endauth

    <!-- plugins:js -->
    <x-notify::notify />
    @notifyJs
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/alerts.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- End custom js for this page -->
</body>

</html>
