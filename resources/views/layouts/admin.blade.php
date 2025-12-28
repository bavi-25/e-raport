<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="/assets/img/preloader.png" alt="preloader" height="300" width="300">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block mt-1">
                        {{-- <h3>{{ $tenant }}</h3> --}}
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->


                    <!-- Messages Dropdown Menu -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-comments"></i>
                            <span class="badge badge-danger navbar-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/assets/img/user1-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 mr-3 img-circle">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-right text-sm text-danger"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">Call me whenever you can...</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/assets/img/user8-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            John Pierce
                                            <span class="float-right text-sm text-muted"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">I got your message bro</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/assets/img/user3-128x128.jpg" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Nora Silvester
                                            <span class="float-right text-sm text-warning"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">The subject goes here</p>
                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li> --}}

                    <!-- Notifications Dropdown Menu -->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <span class="float-right text-muted text-sm">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                                <span class="float-right text-muted text-sm">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li> --}}

                    <!-- User Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="far fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('profile.index') }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="/" class="brand-link">
                    <img src="/assets/img/logo.png" alt="E-Raport Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">E-Raport</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">

                            <li class="nav-item">
                                <a href="/dashboard"
                                    class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                                    <svg class="nav-icon" viewBox="0 0 32 32" fill="currentColor" width="18" height="18"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="24" y="21" width="2" height="5" />
                                        <rect x="20" y="16" width="2" height="10" />
                                        <path d="M11,26a5.0059,5.0059,0,0,1-5-5H8a3,3,0,1,0,3-3V16a5,5,0,0,1,0,10Z" />
                                        <path
                                            d="M28,2H4A2.002,2.002,0,0,0,2,4V28a2.0023,2.0023,0,0,0,2,2H28a2.0027,2.0027,0,0,0,2-2V4A2.0023,2.0023,0,0,0,28,2Zm0,9H14V4H28ZM12,4v7H4V4ZM4,28V13H28.0007l.0013,15Z" />
                                    </svg>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-header">Master Data</li>
                            @role('SuperAdmin')
                            <li class="nav-item">
                                <a href="{{ route('super_admin.tenants.index') }}"
                                    class="nav-link {{ request()->routeIs('super_admin.tenants.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-school"></i>
                                    <p>Tenant</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/" class="nav-link">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        Roles
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>
                            @endrole
                            @role('Kepala Sekolah|Admin')
                            <li class="nav-item">
                                <a href="{{ route('school.tenant.index') }}"
                                    class="nav-link {{ request()->routeIs('school.tenant.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-school"></i>
                                    <p>
                                        School
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.subjects.index') }}"
                                    class="nav-link {{ request()->routeIs('school.subjects.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-book-open"></i>
                                    <p>
                                        Subjects
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.academic_year.index') }}"
                                    class="nav-link {{ request()->routeIs('school.academic_year.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-calendar"></i>
                                    <p>
                                        Academic Years
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.grade_levels.index') }}"
                                    class="nav-link {{ request()->routeIs('school.grade_levels.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        Grade Levels
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.class_rooms.index') }}"
                                    class="nav-link {{ request()->routeIs('school.class_rooms.*') ? 'active' : '' }}">
                                    <svg class="nav-icon" width="18" height="18" viewBox="0 0 512.001 512.001"
                                        fill="currentColor" aria-hidden="true" focusable="false">
                                        <g>
                                            <g>
                                                <path
                                                    d="M467.309,16.768H221.454c-6.128,0-11.095,4.967-11.095,11.095v86.451l12.305-7.64c3.131-1.945,6.475-3.257,9.884-3.978
                                        V38.958h223.665v160.016H232.549v-25.89l-22.19,13.778v23.208c0,6.128,4.967,11.095,11.095,11.095h245.855
                                        c6.127,0,11.095-4.967,11.095-11.095V27.863C478.404,21.735,473.436,16.768,467.309,16.768z" />
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M306.001,78.356c-2.919-3.702-8.285-4.335-11.986-1.418l-38.217,30.133c3.649,2.385,6.85,5.58,9.301,9.527
                                        c0.695,1.117,1.298,2.266,1.834,3.431l37.651-29.687C308.286,87.424,308.92,82.057,306.001,78.356z" />
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <circle cx="121.535" cy="31.935" r="31.935" />
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M252.01,124.728c-4.489-7.229-13.987-9.451-21.218-4.963l-31.206,19.375c-0.13-25.879-0.061-12.145-0.144-28.811
                                        c-0.101-20.005-16.458-36.281-36.464-36.281h-15.159c-12.951,33.588-8.779,21.12-19.772,49.63l4.623-20.131
                                        c0.32-1.508,0.088-3.08-0.655-4.43l-6.264-11.393l5.559-10.109c0.829-1.508-0.264-3.356-1.985-3.356h-15.271
                                        c-1.72,0-2.815,1.848-1.985,3.356l5.57,10.13l-6.276,11.414c-0.728,1.325-0.966,2.865-0.672,4.347l4.005,20.172
                                        c-2.159-5.599-17.084-44.306-19.137-49.63H80.093c-20.005,0-36.363,16.275-36.464,36.281l-0.569,113.2
                                        c-0.042,8.51,6.821,15.443,15.331,15.486c0.027,0,0.052,0,0.079,0c8.473,0,15.364-6.848,15.406-15.331l0.569-113.2
                                        c0-0.018,0-0.036,0-0.053c0.024-1.68,1.399-3.026,3.079-3.013c1.68,0.012,3.034,1.378,3.034,3.058l0.007,160.381
                                        c14.106-0.6,27.176,4.488,36.981,13.423v-62.568h7.983v71.773c5.623,8.268,8.914,18.243,8.914,28.974
                                        c0,9.777-2.732,18.928-7.469,26.731c4.866,0.023,9.592,0.669,14.099,1.861c6.076-5.271,13.385-9.151,21.437-11.136
                                        c0-279.342-0.335-106.627-0.335-229.418c0-1.779,1.439-3.221,3.218-3.224c1.779-0.004,3.224,1.432,3.232,3.211
                                        c0.054,10.807,0.224,44.59,0.283,56.351c0.028,5.579,3.07,10.708,7.953,13.407c4.874,2.694,10.835,2.554,15.583-0.394
                                        l54.604-33.903C254.276,141.458,256.499,131.957,252.01,124.728z" />
                                            </g>
                                        </g>
                                        <g>
                                            <circle cx="429.221" cy="322.831" r="33.803" />
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M511.459,405.811c-0.107-21.176-17.421-38.404-38.598-38.404c-9.137,0-76.583,0-84.781,0
                                        c3.637,7.068,5.704,15.069,5.704,23.55c0,9.005-2.405,18.413-7.5,26.782c18.904,0.764,35.468,10.91,45.149,25.897h40.579v-37.43
                                        c0-1.842,1.46-3.352,3.301-3.415s3.402,1.345,3.526,3.182l0.19,37.661h32.621L511.459,405.811z" />
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M290.469,390.956c0-8.629,2.138-16.763,5.894-23.92c-22.009,0-47.852,0-75.267,0c3.472,6.939,5.437,14.756,5.437,23.029
                                        c0,9.721-2.73,18.926-7.469,26.731c15.558,0.074,29.912,6.538,40.283,17.267c10.054-9.822,23.759-15.914,38.836-15.995
                                        C292.948,409.616,290.469,400.126,290.469,390.956z" />
                                            </g>
                                        </g>
                                        <g>
                                            <path
                                                d="M264.819,288.655c-18.668,0-33.804,15.132-33.804,33.803c0,18.628,15.107,33.803,33.804,33.803
                                      c18.518,0,33.803-14.965,33.803-33.803C298.622,303.808,283.517,288.655,264.819,288.655z" />
                                        </g>
                                        <g>
                                            <circle cx="82.786" cy="322.458" r="33.803" />
                                        </g>
                                        <g>
                                            <path d="M422.533,473.807c-0.105-21.178-17.42-38.406-38.597-38.406c-2.246,0-82.969,0-85.507,0
                                      c-21.176,0-39.601,17.227-39.708,38.404l-0.275-0.891c-0.105-21.092-17.341-38.404-38.597-38.404c-24.544,0-59.795,0-85.507,0
                                      c-21.176,0-39.601,17.227-39.708,38.404L94.442,512h32.621l0.191-38.922c0.008-1.622,1.327-2.93,2.948-2.926
                                      c1.621,0.004,2.932,1.32,2.932,2.941v38.908c19.121,0,68.483,0,86.392,0v-38.908c0-1.736,1.405-3.144,3.141-3.149
                                      c1.735-0.004,3.149,1.397,3.158,3.133l0.191,38.923c6.669,0,58.238,0,65.134,0l0.191-38.031c0.009-1.621,1.328-2.928,2.949-2.924
                                      c1.621,0.004,2.931,1.32,2.931,2.941v38.016c19.121,0,68.483,0,86.392,0v-38.016c0-1.736,1.405-3.144,3.141-3.149
                                      c1.735-0.004,3.149,1.397,3.158,3.133l0.191,38.031h32.621L422.533,473.807z" />
                                        </g>
                                        <circle cx="175.934" cy="389.933" r="34.198" />
                                        <circle cx="342.07" cy="390.821" r="34.198" />
                                    </svg>
                                    <p>Class Rooms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.assessment_components.index') }}"
                                    class="nav-link {{ request()->routeIs('school.assessment_components.*') ? 'active' : '' }}">
                                    <svg class="nav-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.1206 1.02129C12.109 1.0067 12.9592 1.54344 13.7096 2.29199L13.7104 2.29285L14.9707 3.5531C15.1118 3.34249 15.2753 3.14257 15.461 2.95679C17.0025 1.4153 19.5018 1.4153 21.0433 2.9568C22.5848 4.49829 22.5848 6.99754 21.0433 8.53904C20.8575 8.72481 20.6576 8.88828 20.447 9.02939L21.7072 10.2896L21.708 10.2905C22.4565 11.0408 22.9932 11.891 22.9787 12.8794C22.9642 13.8602 22.41 14.6797 21.7058 15.3789C21.7054 15.3793 21.7049 15.3798 21.7045 15.3802L20.4287 16.656C19.9519 17.1327 19.3279 17.0824 18.9512 16.9234C18.5783 16.7659 18.1803 16.4041 18.0897 15.8508C18.0262 15.4628 17.8456 15.0914 17.5452 14.791C16.7847 14.0306 15.5518 14.0306 14.7914 14.791C14.0309 15.5515 14.0309 16.7844 14.7914 17.5448C15.0917 17.8452 15.4631 18.0259 15.8511 18.0894C16.4044 18.18 16.7663 18.5779 16.9237 18.9509C17.0827 19.3276 17.1331 19.9516 16.6564 20.4283L15.377 21.7077C14.6777 22.412 13.8591 22.965 12.8794 22.9795C11.8922 22.994 11.0429 22.4585 10.2938 21.7112L9.0295 20.4469C8.88841 20.6575 8.72496 20.8573 8.53922 21.0431C6.99773 22.5846 4.49847 22.5846 2.95698 21.0431C1.41549 19.5016 1.41549 17.0023 2.95698 15.4608C3.14272 15.2751 3.3426 15.1116 3.55317 14.9706L2.29294 13.7103C1.54353 12.9591 1.00681 12.1089 1.02141 11.1205C1.03589 10.1397 1.59009 9.32029 2.29424 8.62107L3.57165 7.34366C4.0484 6.86691 4.67249 6.9173 5.04916 7.07633C5.4221 7.23378 5.82003 7.59563 5.91062 8.14898C5.97414 8.53701 6.15479 8.90842 6.45519 9.20882C7.21563 9.96926 8.44856 9.96926 9.209 9.20882C9.96945 8.44837 9.96945 7.21545 9.20901 6.455C8.90861 6.1546 8.53719 5.97396 8.14917 5.91043C7.59581 5.81984 7.23397 5.42191 7.07652 5.04897C6.91749 4.6723 6.86709 4.04821 7.34384 3.57146L8.61978 2.29553C9.32039 1.58996 10.1398 1.03576 11.1206 1.02129Z" />
                                    </svg>
                                    <p>Components</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.students.index') }}"
                                    class="nav-link {{ request()->routeIs('school.students.*') ? 'active' : '' }}">
                                    <svg class="nav-icon" width="18" height="18" viewBox="0 0 31.283 31.284"
                                        aria-hidden="true" focusable="false" fill="currentColor">
                                        <g>
                                            <g>
                                                <path d="M31.283,16.65h-3.74l-0.645-5.814c0.086-0.629,0.199-1.585,0.242-2.571c0.074-1.683,0.325-7.028-4.521-7.028
                                        c-4.848,0-4.715,4.462-4.715,4.462l0.353,5.789l-0.536,5.162h-4.158l-0.144-6.16l-2.72-0.001c0,0-0.509,1.561-1.906,1.643
                                        c-1.399,0.081-1.928-1.643-1.928-1.643H6.053H5.139H4.431L4.254,16.65H0v2.31h1.568v11.01H2.56v-11.01h2.521l-0.142,0.733
                                        l-0.058,0.846H3.865v0.628H5.23v8.02h2.749v-8.02h1.526v8.02h2.749v-8.02h1.249v-0.628h-0.82l-0.1-1.276l-0.088-0.303h7.157
                                        l-0.043,0.251l0.457,1.339h-2.474v0.657h2.843L20.4,28.416h-0.16v0.785h0.156h1.53h0.142v-0.785h-0.105l0.325-7.208h0.994
                                        l0.284,7.208h-0.113v0.785h0.145h0.07h1.42H25.1h0.184v-0.785H25.1v-0.366c-0.004,0-0.01-5.285-0.012-6.843h2.587v-0.657h-2.36
                                        l0.574-1.351h0.053l-0.094-0.24h3.209v11.289h0.991V18.959h1.235V16.65z M18.875,5.145c1.045-0.071,4.691-0.399,4.785-1.579
                                        c0.345,0.636,2.164,2.232,2.9,2.354c-0.166,1.609-1.306,2.927-2.83,3.337v1.349h0.006l0.49,0.232l-1.537,2.767l-1.502-2.852
                                        l0.383-0.096V9.219c-1.572-0.491-2.715-1.959-2.715-3.694C18.854,5.396,18.861,5.27,18.875,5.145z M19.293,16.65l0.413-3.196
                                        c0.367,1.24,0.713,2.382,0.713,2.382l-0.133,0.814H19.293z M25.238,16.65l-0.207-0.91c0,0,0.199-1.312,0.438-2.693l0.496,3.604
                                        H25.238z" />
                                                <path
                                                    d="M5.317,5.142c-0.046,0.152-0.093,0.304-0.12,0.464c-0.032,0.199-0.05,0.405-0.05,0.613c0,2.051,1.662,3.712,3.713,3.712
                                        c2.049,0,3.712-1.661,3.712-3.712c0-0.41-0.083-0.797-0.205-1.167l0.754-1.04l-1.35-0.476l0.264-1.381l-1.65,0.472L9.626,1.036
                                        L8.217,2.504L7.125,1.24L6.612,2.911l-1.75-0.574l0.659,1.476L4.246,4.171L5.317,5.142z" />
                                            </g>
                                        </g>
                                    </svg>
                                    <p>Students</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.class_subjects.index') }}"
                                    class="nav-link {{ request()->routeIs('school.class_subjects.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-book-reader"></i>
                                    <p>
                                        Class Subjects
                                    </p>
                                </a>
                            </li>
                            @endrole
                            @role('Guru')
                            <li class="nav-item">
                                <a href="{{ route('school.attendance.index') }}"
                                    class="nav-link {{ request()->routeIs('school.attendance.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-journal-whills"></i>
                                    <p>
                                        Attendances
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.grade_entries.index') }}"
                                    class="nav-link {{ request()->routeIs('school.grade_entries.*') ? 'active' : '' }}">

                                    <svg class="nav-icon" width="18" height="18" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" focusable="false" viewBox="0 0 1800 1800"
                                        fill="currentColor">
                                        <g>
                                            <path
                                                d="M241.023,324.818c0.252,0,0.505,0.035,0.758,0.035h465.68c17.266,0,31.256-13.99,31.256-31.252
                                                                            c0-17.262-13.99-31.247-31.256-31.247H351.021h-109.24c-17.258,0-31.252,13.985-31.252,31.247
                                                                            C210.529,310.605,224.121,324.412,241.023,324.818z" />
                                            <path
                                                d="M210.529,450.306c0,17.257,13.994,31.252,31.252,31.252h769.451c17.262,0,31.256-13.995,31.256-31.252
                                                                            c0-17.266-13.994-31.252-31.256-31.252H241.781C224.523,419.054,210.529,433.04,210.529,450.306z" />
                                            <path
                                                d="M1011.232,575.751H241.781c-8.149,0-15.549,3.147-21.116,8.261c-6.213,5.712-10.136,13.879-10.136,22.987
                                                                            c0,17.262,13.994,31.26,31.252,31.26h769.451c17.262,0,31.256-13.999,31.256-31.26c0-9.108-3.923-17.275-10.141-22.987
                                                                            C1026.781,578.898,1019.386,575.751,1011.232,575.751z" />
                                            <path
                                                d="M1011.232,732.461H241.781c-17.258,0-31.252,13.99-31.252,31.247c0,17.262,13.994,31.257,31.252,31.257
                                                                            h769.451c17.262,0,31.256-13.995,31.256-31.257C1042.488,746.451,1028.494,732.461,1011.232,732.461z" />
                                            <path
                                                d="M1011.232,889.157H241.781c-8.149,0-15.549,3.147-21.116,8.261c-6.213,5.713-10.136,13.879-10.136,22.987
                                                                            c0,17.257,13.994,31.261,31.252,31.261h769.451c17.262,0,31.256-14.004,31.256-31.261c0-9.108-3.923-17.274-10.141-22.987
                                                                            C1026.781,892.305,1019.386,889.157,1011.232,889.157z" />
                                            <path
                                                d="M1011.232,1045.867H241.781c-17.258,0-31.252,13.99-31.252,31.243c0,17.271,13.994,31.265,31.252,31.265
                                                                            h769.451c17.262,0,31.256-13.994,31.256-31.265C1042.488,1059.857,1028.494,1045.867,1011.232,1045.867z" />
                                            <path
                                                d="M1011.232,1202.576H241.781c-17.258,0-31.252,13.995-31.252,31.252c0,17.258,13.994,31.252,31.252,31.252
                                                                            h769.451c17.262,0,31.256-13.994,31.256-31.252C1042.488,1216.571,1028.494,1202.576,1011.232,1202.576z" />
                                            <path
                                                d="M1011.232,1359.273H241.781c-8.149,0-15.549,3.151-21.116,8.265c-6.213,5.713-10.136,13.875-10.136,22.987
                                                                            c0,17.258,13.994,31.261,31.252,31.261h769.451c17.262,0,31.256-14.003,31.256-31.261c0-9.112-3.923-17.274-10.141-22.987
                                                                            C1026.781,1362.425,1019.386,1359.273,1011.232,1359.273z" />
                                            <path
                                                d="M1233.542,251.228l-49.851-45.109L1052.136,87.076l-59.185-53.554c-5.293-4.792-11.947-7.421-18.786-7.836
                                                                            h-3.49H83.676c-45.688,0-82.858,37.375-82.858,83.316v1583.612c0,45.94,37.17,83.316,82.858,83.316h1078.562
                                                                            c45.68,0,82.845-37.376,82.845-83.316V277.08v-3.182C1244.646,264.73,1240.261,256.589,1233.542,251.228z M1003.117,125.864
                                                                            l131.119,118.657h-131.119V125.864z M1183.691,1692.613c0,12.094-9.622,21.926-21.454,21.926H83.676
                                                                            c-11.836,0-21.467-9.832-21.467-21.926V109.001c0-12.089,9.631-21.925,21.467-21.925h857.857V275.38
                                                                            c0,17.052,13.785,30.862,30.786,30.862h211.372V1692.613z" />
                                            <path
                                                d="M1798.578,180.737c-7.049-88.305-81.114-158.02-171.205-158.02c-0.004,0-0.004,0-0.004,0
                                                                            c-45.889,0-89.033,17.874-121.479,50.32c-29.18,29.175-46.519,67.005-49.73,107.699h-0.586v13.609c0,0.06-0.005,0.115-0.005,0.175
                                                                            c0,0.026,0.005,0.056,0.005,0.082l-0.005,1369.26h0.197c0.557,5.404,2.522,10.731,6.047,15.373l141.135,185.91
                                                                            c5.803,7.648,14.851,12.136,24.447,12.136c9.601-0.004,18.646-4.496,24.447-12.14l141.093-185.897
                                                                            c3.528-4.65,5.494-9.982,6.051-15.391h0.197V180.737H1798.578z M1549.299,116.448c20.854-20.855,48.578-32.339,78.07-32.339h0.004
                                                                            c50.24,0,92.746,33.723,106.076,79.718h-212.19C1526.358,146.098,1535.896,129.852,1549.299,116.448z M1595.372,1502.468
                                                                            l-78.413,0.005l0.005-1260.345h220.828v1260.336h-81.103l0.009-1016.486l-61.335,0.004L1595.372,1502.468z M1627.382,1695.821
                                                                            l-100.171-131.963l200.338-0.004L1627.382,1695.821z" />
                                        </g>
                                    </svg>

                                    <p>
                                        Grade Entries
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('school.assessments.index') }}"
                                    class="nav-link {{ request()->routeIs('school.assessments.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>
                                        Assessments
                                    </p>
                                </a>
                            </li>
                            @endrole
                            @role('Wali Kelas')

                            <li class="nav-item">
                                <a href="{{ route('school.enrollments.index') }}"
                                    class="nav-link {{ request()->routeIs('school.enrollments.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-id-badge"></i>
                                    <p>
                                        Enrollments
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('school.report.index') }}"
                                    class="nav-link {{ request()->routeIs('school.report.*') ? 'active' : '' }}">
                                    <svg class="nav-icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 32 32" fill="currentColor" width="18" height="18">
                                        <style type="text/css">
                                            .feather_een {
                                                fill: currentColor;
                                            }
                                        </style>
                                        <path class="feather_een"
                                            d="M8,10.5L8,10.5C8,10.224,8.224,10,8.5,10h3c0.276,0,0.5,0.224,0.5,0.5v0c0,0.276-0.224,0.5-0.5,0.5h-3
                                            C8.224,11,8,10.776,8,10.5z M8.5,13h3c0.276,0,0.5-0.224,0.5-0.5v0c0-0.276-0.224-0.5-0.5-0.5h-3C8.224,12,8,12.224,8,12.5v0
                                            C8,12.776,8.224,13,8.5,13z M30,8v18c0,1.657-1.343,3-3,3H5c-1.657,0-3-1.343-3-3V8c0-1.657,1.343-3,3-3c0,0,0.448-1,1-1h3.092
                                            C9.299,3.419,9.849,3,10.5,3s1.201,0.419,1.408,1H14c0.552,0,1,0.448,1,1h12C28.657,5,30,6.343,30,8z M6,15h8V5h-2v2.5
                                            c0,0.892-0.783,1.605-1.697,1.487C9.547,8.89,9,8.21,9,7.448V7.25c0-0.276,0.224-0.5,0.5-0.5h0c0.276,0,0.5,0.224,0.5,0.5V7.5
                                            c0,0.303,0.271,0.544,0.584,0.493C10.83,7.953,11,7.721,11,7.472L11,5H6V15z M28.976,26.242C28.447,26.708,27.76,27,27,27H5
                                            c-0.76,0-1.447-0.292-1.976-0.758C3.145,27.231,3.978,28,5,28h22C28.022,28,28.855,27.231,28.976,26.242z M29,8c0-1.105-0.895-2-2-2
                                            H15v9c0,0.552-0.448,1-1,1H6c-0.552,0-1-0.448-1-1l0-9C3.895,6,3,6.895,3,8v16c0,1.105,0.895,2,2,2h22c1.105,0,2-0.895,2-2V8z
                                            M26.691,14.038C26.63,14.013,26.565,14,26.5,14h-4c-0.276,0-0.5,0.224-0.5,0.5s0.224,0.5,0.5,0.5h2.793l-3,3h-1.586l-1.854-1.854
                                            c-0.195-0.195-0.512-0.195-0.707,0L15.293,19H11.5c-0.133,0-0.260,0.053-0.354,0.146L8.293,22H5.5C5.224,22,5,22.224,5,22.5
                                            S5.224,23,5.5,23h3c0.133,0,0.26-0.053,0.354-0.146L11.707,20H15.5c0.133,0,0.26-0.053,0.354-0.146l2.646-2.646l1.646,1.646
                                            C20.24,18.947,20.367,19,20.5,19h2c0.133,0,0.26-0.053,0.354-0.146L26,15.707V18.5c0,0.276,0.224,0.5,0.5,0.5s0.5-0.224,0.5-0.5v-4
                                            c0-0.065-0.013-0.13-0.038-0.191C26.911,14.187,26.813,14.089,26.691,14.038z" />
                                    </svg>
                                    <p>Reports</p>
                                </a>
                            </li>
                            @endrole

                            @role('Siswa')
                            <li class="nav-item">
                                <a href="{{ route('student.enrollment.index') }}"
                                    class="nav-link {{ request()->routeIs('student.enrollment.*') ? 'active' : '' }}">
                                    <i class="nav-icon far fa-id-badge"></i>
                                    <p>
                                        Enrollments
                                    </p>
                                </a>
                            </li>
                            @endrole
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">{{ $page }}</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2025 <a href="https://adminlte.io">Buana Aviora</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="/assets/plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="/assets/plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="/assets/plugins/moment/moment.min.js"></script>
        <script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/assets/js/adminlte.js"></script>

        <!-- DataTables  & Plugins -->
        <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="/assets/plugins/jszip/jszip.min.js"></script>
        <script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <!-- Select2 -->
        <script src="/assets/plugins/select2/js/select2.full.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- Toastr -->
        <script src="/assets/plugins/toastr/toastr.min.js"></script>
        <!-- ChartJS -->
        <script src="/assets/plugins/chart.js/Chart.min.js"></script>

        <script>
            $(function () {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "searching": true,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons()
                .container()
                .appendTo('#example1_wrapper .col-md-6:eq(0)');

                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });

                $('.select2').select2()

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
          });
        </script>
        <script>
            // Swal.fire({
            //     title: 'Welcome!',
            //     text: 'Selamat datang di aplikasi E-Raport.',
            //     icon: 'success',
            // })
            @if (session('success'))
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                })
            @endif
            @if (session('error'))
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                })
            @endif
        </script>
        <script>
            $(".form-delete").on("submit", function(e) {
                e.preventDefault();
                let form = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This data will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
        @stack('scripts')
    </body>

</html>