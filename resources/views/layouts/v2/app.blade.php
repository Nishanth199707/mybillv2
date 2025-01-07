<html lang="en" class="sidebar-noneoverflow">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>MyDailyBill</title>
    <meta name="robots" content="noindex,nofollow">


    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logosymbol.ico') }}" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('v2/layouts/vertical-light-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('v2/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('v2/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v2/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('v2/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v2/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css">
    <!--  END CUSTOM STYLE FILE  -->


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('v2/src/plugins/src/table/datatable/datatables.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('v2/src/plugins/css/light/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('v2/src/plugins/css/dark/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL STYLES -->

    <script type="text/javascript">
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>

    <style>
        .card-body {

            padding: 0;

        }

        .form-control {
            padding: 5px;
        }

        .modal-body {
            background-color: white;
        }

        .modal-header {
            background-color: white;
            color: black;
        }

        /* .disabled{
            color: black;
        } */
        .btn-primary {
            background-color: #ff756e !important;
            border-color: #ff756e;
        }
        .readonly {
            background-color: #f0f0f0;
            pointer-events: none; /* Prevent interaction */
            color: #999; /* Gray out text */
        }
    </style>



</head>

<body class="" data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100">
    @php
    use App\Models\Business;
    $user_id = session('user_id');
    $business = Business::select('*')->where('user_id', $user_id)->first();

    @endphp
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container" style="background:linear-gradient(to right,#ff9e6f, #ff746e );">
        <header class="header navbar navbar-expand-sm expand-header">
            <div id="sidebars">

                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom" style="color: #fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>
            </div>
            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="#">
                        <img src="https://mydailybill.com/vf/images/logo.jpeg" class="navbar" alt="logo">
                        <!-- https://mydailybill.com/vf/images/logo.jpeg -->
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="#" class="nav-link" style="color: #fff; font-weight:bold;">
                        MY DAILY BILL
                    </a>
                </li>
            </ul>
            <header class="header navbar navbar-expand-sm">








                <ul class="navbar-nav flex-row ms-auto breadcrumb-action-dropdown">

                    <!-- <li class="nav-item more-dropdown">
                                <div class="dropdown  custom-dropdown-icon">
                                    <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>Settings</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-chevron-down custom-dropdown-arrow">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">

                                        <a class="dropdown-item" data-value="Settings"
                                            data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-settings&quot;><circle cx=&quot;12&quot; cy=&quot;12&quot; r=&quot;3&quot;></circle><path d=&quot;M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z&quot;></path></svg>"
                                            href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-settings">
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <path
                                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                </path>
                                            </svg> Settings
                                        </a>

                                        <a class="dropdown-item" data-value="Mail"
                                            data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-mail&quot;><path d=&quot;M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z&quot;></path><polyline points=&quot;22,6 12,13 2,6&quot;></polyline></svg>"
                                            href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-mail">
                                                <path
                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                </path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg> Mail
                                        </a>

                                        <a class="dropdown-item" data-value="Print"
                                            data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-printer&quot;><polyline points=&quot;6 9 6 2 18 2 18 9&quot;></polyline><path d=&quot;M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2&quot;></path><rect x=&quot;6&quot; y=&quot;14&quot; width=&quot;12&quot; height=&quot;8&quot;></rect></svg>"
                                            href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-printer">
                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                <path
                                                    d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                </path>
                                                <rect x="6" y="14" width="12" height="8"></rect>
                                            </svg> Print
                                        </a>

                                        <a class="dropdown-item" data-value="Download"
                                            data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-download&quot;><path d=&quot;M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4&quot;></path><polyline points=&quot;7 10 12 15 17 10&quot;></polyline><line x1=&quot;12&quot; y1=&quot;15&quot; x2=&quot;12&quot; y2=&quot;3&quot;></line></svg>"
                                            href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-download">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3">
                                                </line>
                                            </svg> Download
                                        </a>

                                        <a class="dropdown-item" data-value="Share"
                                            data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-share-2&quot;><circle cx=&quot;18&quot; cy=&quot;5&quot; r=&quot;3&quot;></circle><circle cx=&quot;6&quot; cy=&quot;12&quot; r=&quot;3&quot;></circle><circle cx=&quot;18&quot; cy=&quot;19&quot; r=&quot;3&quot;></circle><line x1=&quot;8.59&quot; y1=&quot;13.51&quot; x2=&quot;15.42&quot; y2=&quot;17.49&quot;></line><line x1=&quot;15.41&quot; y1=&quot;6.51&quot; x2=&quot;8.59&quot; y2=&quot;10.49&quot;></line></svg>"
                                            href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-share-2">
                                                <circle cx="18" cy="5" r="3"></circle>
                                                <circle cx="6" cy="12" r="3"></circle>
                                                <circle cx="18" cy="19" r="3"></circle>
                                                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49">
                                                </line>
                                                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49">
                                                </line>
                                            </svg> Share
                                        </a>

                                    </div>

                                </div>
                            </li> -->
                </ul>
            </header>
            <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">

                <li class="nav-item theme-toggle-item">
                    <a href="javascript:void(0);" class="nav-link theme-toggle">
                    </a>
                </li>

                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="drodpown-title message">
                            <h6 class="d-flex justify-content-between"><span class="align-self-center">Messages</span>
                                <span class="badge badge-primary">9 Unread</span>
                            </h6>
                        </div>

                    </div>

                </li>
                <a href="#" style="font-weight: bold;color:#fff;font-size:27px;">
                    @if (Auth::user())
                    {{ strtoupper(Auth::user()->name) }}
                    @endif
                </a>
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                @if ($business->logo != null)
                                <img src="{{ asset('uploads/' . $business->logo) }}" alt="User Avatar"
                                    class="rounded-circle" />
                                @else
                                <img alt="avatar" src="{{ asset('v2/src/assets/img/profile-30.png') }}"
                                    class="rounded-circle">
                                @endif

                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    @if ($business->logo != null)
                                    <img src="{{ asset('uploads/' . $business->logo) }}" alt="User Avatar"
                                        class="rounded-circle" />
                                    @else
                                    <img alt="avatar" src="{{ asset('v2/src/assets/img/profile-30.png') }}"
                                        class="rounded-circle">
                                    @endif
                                </div>
                                <div class="media-body">
                                    @if (Auth::user())
                                    <h5 class="me-1">{{ Auth::user()->name }}</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('business.indexshow') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>Profile</span>
                            </a>
                        </div>

                        <div class="dropdown-item">
                            <a href="{{ route('superadmin.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('superadmin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        </a>

                    </div>

                </li>
            </ul>

        </header>

    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sbar-open" id="container">

        <div class="overlay show"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar" class="side_bar" style="margin-top:-40px;
    ">


                <!-- Sidebar content goes here -->

                <!-- Button to show sidebar when collapsed -->



                <div class="navbar-nav theme-brand flex-row  text-center">
                    <!-- <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{ route('superadmin.home') }}">
                                <img src="../src/assets/img/logo.svg" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{ route('superadmin.home') }}" class="nav-link">
                                @if (Auth::user())
                                {{ strtoupper(Auth::user()->name) }}
                                @endif
                            </a>
                        </div>
                    </div> -->

                </div>
                <!-- <div class="shadow-bottom"></div> -->

                <ul class="list-unstyled menu-categories" id="accordionExample">


                    <li class="menu {{ Route::is('superadmin.home') ? 'active' : '' }}">
                        <a href="{{ route('superadmin.home') }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Dashboard</span>
                            </div>

                        </a>

                    </li>
                    <!-- Products Menu -->
                    <li class="menu menu-heading">
                        <div class="heading">
                            <svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">

                                <rect x="0" fill="none" width="20" height="20" />

                                <g>

                                    <path d="M17 8h1v11H2V8h1V6c0-2.76 2.24-5 5-5 .71 0 1.39.15 2 .42.61-.27 1.29-.42 2-.42 2.76 0 5 2.24 5 5v2zM5 6v2h2V6c0-1.13.39-2.16 1.02-3H8C6.35 3 5 4.35 5 6zm10 2V6c0-1.65-1.35-3-3-3h-.02c.63.84 1.02 1.87 1.02 3v2h2zm-5-4.22C9.39 4.33 9 5.12 9 6v2h2V6c0-.88-.39-1.67-1-2.22z" />

                                </g>

                            </svg>
                            <span>Products</span>
                        </div>
                    </li>
                    <li
                        class="menu {{ Request::routeIs('productcategory.create') || Request::routeIs('productsubcategory.create') || Request::routeIs('product.create') || Request::routeIs('productcategory.index') || Request::routeIs('productsubcategory.index') || Request::routeIs('product.index') ? 'active' : '' }}">
                        <a href="#products" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::routeIs('productcategory.create') || Request::routeIs('productsubcategory.create') || Request::routeIs('product.create') || Request::routeIs('productcategory.index') || Request::routeIs('productsubcategory.index') || Request::routeIs('product.index') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg width="800px" height="800px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">

                                    <rect x="0" fill="none" width="20" height="20" />

                                    <g>

                                        <path d="M17 8h1v11H2V8h1V6c0-2.76 2.24-5 5-5 .71 0 1.39.15 2 .42.61-.27 1.29-.42 2-.42 2.76 0 5 2.24 5 5v2zM5 6v2h2V6c0-1.13.39-2.16 1.02-3H8C6.35 3 5 4.35 5 6zm10 2V6c0-1.65-1.35-3-3-3h-.02c.63.84 1.02 1.87 1.02 3v2h2zm-5-4.22C9.39 4.33 9 5.12 9 6v2h2V6c0-.88-.39-1.67-1-2.22z" />

                                    </g>

                                </svg>
                                <span>Product</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::routeIs('productcategory.create') || Request::routeIs('productsubcategory.create') || Request::routeIs('product.create') || Request::routeIs('productcategory.index') || Request::routeIs('productsubcategory.index') || Request::routeIs('product.index') ? 'show' : '' }}"
                            id="products" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('productcategory.create') ? 'active' : '' }}"><a
                                    href="{{ route('productcategory.create') }}">Add Category</a></li>
                            <li class="{{ Request::routeIs('productsubcategory.create') ? 'active' : '' }}"><a
                                    href="{{ route('productsubcategory.create') }}">Add Sub Category</a></li>
                            <li class="{{ Request::routeIs('product.create') ? 'active' : '' }}"><a
                                    href="{{ route('product.create') }}">Add Product</a></li>
                            <li class="{{ Request::routeIs('productcategory.index') ? 'active' : '' }}"><a
                                    href="{{ route('productcategory.index') }}">View Category</a></li>
                            <li class="{{ Request::routeIs('productsubcategory.index') ? 'active' : '' }}"><a
                                    href="{{ route('productsubcategory.index') }}">View Sub Category</a></li>
                            <li class="{{ Request::routeIs('product.index') ? 'active' : '' }}"><a
                                    href="{{ route('product.index') }}">View Product</a></li>
                        </ul>
                    </li>

                    <!-- Party Menu -->
                    <li class="menu menu-heading">
                        <div class="heading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>Party</span>
                        </div>
                    </li>
                    <li
                        class="menu {{ Request::routeIs('party.create') || Request::routeIs('party.index') ? 'active' : '' }}">
                        <a href="#party" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::routeIs('party.create') || Request::routeIs('party.index') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg fill="#506690" width="800px" height="800px" viewBox="-2 -1.5 24 24" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-users">
                                    <path d='M3.534 11.07a1 1 0 1 1 .733 1.86A3.579 3.579 0 0 0 2 16.26V18a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1.647a3.658 3.658 0 0 0-2.356-3.419 1 1 0 1 1 .712-1.868A5.658 5.658 0 0 1 14 16.353V18a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3v-1.74a5.579 5.579 0 0 1 3.534-5.19zM7 1a4 4 0 0 1 4 4v2a4 4 0 1 1-8 0V5a4 4 0 0 1 4-4zm0 2a2 2 0 0 0-2 2v2a2 2 0 1 0 4 0V5a2 2 0 0 0-2-2zm9 17a1 1 0 0 1 0-2h1a1 1 0 0 0 1-1v-1.838a3.387 3.387 0 0 0-2.316-3.213 1 1 0 1 1 .632-1.898A5.387 5.387 0 0 1 20 15.162V17a3 3 0 0 1-3 3h-1zM13 2a1 1 0 0 1 0-2 4 4 0 0 1 4 4v2a4 4 0 0 1-4 4 1 1 0 0 1 0-2 2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z' />
                                </svg>
                                <span>Party</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::routeIs('party.create') || Request::routeIs('party.index') ? 'show' : '' }}"
                            id="party" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('party.create') ? 'active' : '' }}"><a
                                    href="{{ route('party.create') }}">Add Party</a></li>
                            <li class="{{ Request::routeIs('party.index') ? 'active' : '' }}"><a
                                    href="{{ route('party.index') }}">View Party</a></li>
                        </ul>
                    </li>



                    <!-- Purchase Menu -->
                    <li
                        class="menu {{ Request::is('purchase*') || Route::is('purchase.create') || Route::is('purchase.index') || Route::is('purchasereturns.index') ? 'active' : '' }}">
                        <a href="#purchase" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::is('purchase*') || Route::is('purchase.create') || Route::is('purchase.index') || Route::is('purchasereturns.index') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128" xml:space="preserve">
                                    <path d="M104.6 44.3c-.5-.7-1.3-1.1-2.1-1.1L36 42.7l-3.6-15.5c-.3-1.2-1.4-2-2.7-2.1L13.4 25c-1.6 0-2.8 1.1-2.7 2.7 0 1.6 1.1 2.8 2.7 2.7l14.2.1L45.8 106c.3 1.2 1.4 2 2.7 2.1l39.4.4c.3-.1.4 0 .7 0 1.2-.3 2-1.4 2-2.6 0-1.6-1.1-2.8-2.7-2.7l-37.3-.3-2.8-11.2L92.9 87c1.1-.1 2-.9 2.3-2l9.9-38c.1-1.1-.1-2.1-.5-2.7m-67.3 3.9 15.5.2-.2 16.1-11.6-.1zm15.2 37.2-6.1.7-4-16.4 10.1.1zM74.4 83 58 84.8l.1-14.9 16.5.1zM58.2 64.4l.2-16.1 16.2.2-.1 16zm32.2 17-10.6.8.1-12.2h13.3zm4.3-16.7-14.6-.1.2-16.1 18.7.2z" />
                                    <circle transform="matrix(.00897 -1 1 .00897 -68.454 163.429)" cx="48.2" cy="116.2" r="5.4" />
                                    <circle transform="matrix(.00897 -1 1 .00897 -29.734 203.24)" cx="87.7" cy="116.6" r="5.4" />
                                </svg>
                                <span>Purchase</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('purchase*') || Route::is('purchase.create') || Route::is('purchase.index') || Route::is('purchasereturns.index') ? 'show' : '' }}"
                            id="purchase" data-bs-parent="#accordionExample">
                            <li class="{{ Route::is('purchase.create') ? 'active' : '' }}"><a
                                    href="{{ route('purchase.create') }}">Add Purchase</a></li>
                            <li class="{{ Route::is('purchase.index') ? 'active' : '' }}"><a
                                    href="{{ route('purchase.index') }}">View Purchase</a></li>
                            <li class="{{ Route::is('purchasereturns.index') ? 'active' : '' }}"><a
                                    href="{{ route('purchasereturns.index') }}">Purchase Return</a></li>
                        </ul>
                    </li>

                    <!-- Sales Menu -->
                    <li
                        class="menu {{ Route::is('sale.create') || Route::is('sale.index') || Route::is('salereturns.index') ? 'active' : '' }}">
                        <a href="#sales" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('sale.create') || Route::is('sale.index') || Route::is('salereturns.index') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="800px" height="800px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                                    <g>
                                        <polygon fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" points="21.903,5 55,38.097 34.097,59 1,25.903
	                                    	1,5 	" />
                                        <polyline fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" points="29.903,5 63,38.097 42.097,59 	" />
                                        <circle fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" cx="14" cy="18" r="5" />
                                    </g>
                                </svg>
                                <span>Sales</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Route::is('sale.create') || Route::is('sale.index') || Route::is('salereturns.index') ? 'show' : '' }}"
                            id="sales" data-bs-parent="#accordionExample">
                            <li class="{{ Route::is('sale.create') ? 'active' : '' }}"><a
                                    href="{{ route('sale.create') }}">Add Sale</a></li>
                            <li class="{{ Route::is('sale.index') ? 'active' : '' }}"><a
                                    href="{{ route('sale.index') }}">View Sale</a></li>
                            <li class="{{ Route::is('salereturns.index') ? 'active' : '' }}"><a
                                    href="{{ route('salereturns.index') }}">Sales Return</a></li>
                        </ul>
                    </li>

                    <!-- Quotation Menu -->
                    <li class="menu {{ Route::is('quotations.index') ? 'active' : '' }}">
                        <a href="{{ route('quotations.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-map">
                                    <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                                    <line x1="8" y1="2" x2="8" y2="18"></line>
                                    <line x1="16" y1="6" x2="16" y2="22"></line>
                                </svg>
                                <span>Quotation</span>
                            </div>
                        </a>
                    </li>

                    <!-- Service Menu -->

                    @if($business != null)
                    @if($business->business_category == 'Mobile & Accessories')
                    <!-- Service Menu -->
                    <li class="menu {{ Route::is('repairs.index') || Route::is('repairs.create') || Route::is('repairs.cashReceived')  ? 'active' : '' }}">
                        <a href="#service" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('repairs.index') || Route::is('repairs.create') || Route::is('repairs.cashReceived')  ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                                <span>Service</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{  Route::is('repairs.index') || Route::is('repairs.create') || Route::is('repairs.cashReceived')  ? 'show' : '' }}"
                            id="service" data-bs-parent="#accordionExample">
                            <li class="{{ Route::is('repairs.create') ? 'active' : '' }}">
                                <a href="{{ route('repairs.create') }}">

                                    Add Service
                                </a>
                            </li>
                            <li class="{{ Route::is('repairs.index') ? 'active' : '' }}">
                                <a href="{{ route('repairs.index') }}">

                                    View Service
                                </a>
                            </li>
                            <li class="{{ Route::is('repairs.cashReceived') ? 'active' : '' }}">
                                <a href="{{ route('repairs.cashReceived') }}">

                                    Service Cash
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @endif
                    <!-- Payments Menu -->
                    <li
                        class="menu {{ Route::is('partypayment.receivePayment') || Route::is('payment.receipt') || Route::is('partypayment.addPayment') || Route::is('payment.payment') || Route::is('payment.cheque') ? 'active' : '' }}">
                        <a href="#payments" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('partypayment.receivePayment') || Route::is('payment.receipt') || Route::is('partypayment.addPayment') || Route::is('payment.payment') || Route::is('payment.cheque') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                                <span>Payments</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Route::is('partypayment.receivePayment') || Route::is('payment.receipt') || Route::is('partypayment.addPayment') || Route::is('payment.payment') || Route::is('payment.cheque') ? 'show' : '' }}"
                            id="payments" data-bs-parent="#accordionExample">
                            <li><b class="pl-3">INWARD</b></li>
                            <li class="{{ Route::is('partypayment.receivePayment') ? 'active' : '' }}"><a
                                    href="{{ route('partypayment.receivePayment') }}"> Add Receipt </a></li>
                            <li class="{{ Route::is('payment.receipt') ? 'active' : '' }}"><a
                                    href="{{ route('payment.receipt') }}"> View Receipt </a></li>
                            <li class="{{ Route::is('payment.receipt') ? 'active' : '' }}"><a
                                    href="{{ route('payment.receipt') }}"> Creditors </a></li>
                            <li><b class="pl-3">OUTWARD</b></li>
                            <li class="{{ Route::is('partypayment.addPayment') ? 'active' : '' }}"><a
                                    href="{{ route('partypayment.addPayment') }}"> Add Payment </a></li>
                            <li class="{{ Route::is('payment.payment') ? 'active' : '' }}"><a
                                    href="{{ route('payment.payment') }}"> View Payment </a></li>
                            <li class="{{ Route::is('payment.payment') ? 'active' : '' }}"><a
                                    href="{{ route('payment.payment') }}"> Debtors </a></li>
                            <li><b class="pl-3">CHEQUE</b></li>
                            <li class="{{ Route::is('payment.cheque') ? 'active' : '' }}"><a
                                    href="{{ route('payment.cheque') }}"> View Cheque </a></li>
                        </ul>
                    </li>

                    <!-- Cash & Bank Menu -->
                    <li class="menu {{ Route::is('sales.cash_received_ledger') || Route::is('sales.bankLedger') ? 'active' : '' }}">
                        <a href="#cashBank" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('sales.cash_received_ledger') || Route::is('sales.bankLedger') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="d-flex align-items-center">
                                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                    width="800px" height="800px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve">
                                    <g>
                                        <path d="M45.1,10.9H6.9c-2.4,0-4.4,2-4.4,4.4v21.3c0,2.4,2,4.4,4.4,4.4h38.2c2.4,0,4.4-2,4.4-4.4V15.4
                                                C49.5,12.9,47.5,10.9,45.1,10.9z M12,36.6c0-2.9-2.3-5.1-5.1-5.1v-11c2.9,0,5.1-2.3,5.1-5.1H40c0,2.9,2.3,5.1,5.1,5.1v11
                                                c-2.9,0-5.1,2.3-5.1,5.1H12z" />
                                        <circle cx="26" cy="25.6" r="7.3" />
                                    </g>
                                </svg>
                                <span>Cash & Bank</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Route::is('sales.cash_received_ledger') || Route::is('sales.bankLedger') ? 'show' : '' }}"
                            id="cashBank" data-bs-parent="#accordionExample">

                            <li class="{{ Route::is('sales.cash_received_ledger') ? 'active' : '' }}">
                                <a href="{{ route('sales.cash_received_ledger') }}"> Cash </a>
                            </li>

                            <li class="{{ Route::is('sales.bankLedger') ? 'active' : '' }}">
                                <a href="{{ route('sales.bankLedger') }}"> Bank </a>
                            </li>
                        </ul>
                    </li>



                    <!-- Finance Menu -->
                    @if($business != null)
                    @if($business->business_category == 'Mobile & Accessories' )
                    <li
                        class="menu {{ Route::is('financiers.create') || Route::is('financiers.index') ? 'active' : '' }}">
                        <a href="#payouts" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('financiers.create') || Route::is('financiers.index') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                                <span>Finance</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Route::is('financiers.create') || Route::is('financiers.index') ? 'show' : '' }}"
                            id="payouts" data-bs-parent="#accordionExample">
                            <li class="{{ Route::is('financiers.create') ? 'active' : '' }}"><a
                                    href="{{ route('financiers.create') }}"> Add Financier </a></li>
                            <li class="{{ Route::is('financiers.index') ? 'active' : '' }}"><a
                                    href="{{ route('financiers.index') }}"> View Financier </a></li>
                        </ul>
                    </li>
                    @endif
                    @endif
                    <!-- Reports Menu -->
                    <li
                        class="menu {{ Route::is('sale.gstreport') || Route::is('purchase.gstreport') ? 'active' : '' }}">
                        <a href="#reports" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('sale.gstreport') || Route::is('purchase.gstreport') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 295.238 295.238" style="enable-background:new 0 0 295.238 295.238;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <rect x="85.714" y="100" style="fill:#F9BA48;" width="100" height="66.667" />
                                            <path style="fill:#333333;" d="M276.19,0H28.571c-7.876,0-14.286,6.41-14.286,14.286v138.095c0,7.876,6.41,14.286,14.286,14.286
                                                h38.095v85.714H4.762v9.524c0,18.381,14.952,33.333,33.333,33.333h133.333c18.381,0,33.333-14.952,33.333-33.333v-95.238h71.429
                                                c7.876,0,14.286-6.41,14.286-14.286V14.286C290.476,6.41,284.067,0,276.19,0z M23.81,152.381V14.286
                                                c0-2.624,2.138-4.762,4.762-4.762h23.81v147.619h-23.81C25.948,157.143,23.81,155.005,23.81,152.381z M38.095,285.714
                                                c-13.129,0-23.81-10.681-23.81-23.81h119.048c0,9.319,3.843,17.757,10.024,23.81H38.095z M195.238,261.905
                                                c0,13.129-10.681,23.81-23.81,23.81h-4.762c-13.129,0-23.81-10.681-23.81-23.81v-9.524H76.19V100
                                                c0-13.129,10.681-23.81,23.81-23.81h105.262c-6.181,6.052-10.024,14.49-10.024,23.81L195.238,261.905L195.238,261.905z
                                                M219.048,66.667H100c-5.119,0-9.948,1.19-14.286,3.262V57.143h133.333v9.524H219.048z M219.048,78.21v7.505h-9.4
                                                C212.09,82.481,215.29,79.857,219.048,78.21z M204.762,100c0-1.629,0.167-3.224,0.481-4.762h23.329V76.19v-9.524V47.619H76.19
                                                v29.095c-5.88,6.015-9.523,14.229-9.523,23.286v57.143h-4.762V9.524h171.428v147.619h-28.571V100z M280.952,85.714v66.667
                                                c0,2.624-2.138,4.762-4.762,4.762h-33.333V85.714V9.524h33.333c2.624,0,4.762,2.138,4.762,4.762V85.714z" />
                                            <rect x="33.333" y="52.381" style="fill:#333333;" width="9.524" height="38.095" />
                                            <rect x="33.333" y="100" style="fill:#333333;" width="9.524" height="14.286" />
                                            <path style="fill:#333333;" d="M261.905,66.667c-10.505,0-19.048,8.543-19.048,19.048s8.543,19.048,19.048,19.048
                                                    c10.505,0,19.048-8.543,19.048-19.048S272.409,66.667,261.905,66.667z M261.905,95.238c-5.252,0-9.524-4.271-9.524-9.524
                                                    c0-5.252,4.271-9.524,9.524-9.524s9.524,4.271,9.524,9.524C271.429,90.967,267.157,95.238,261.905,95.238z" />
                                            <rect x="85.714" y="180.952" style="fill:#333333;" width="100" height="9.524" />
                                            <rect x="85.714" y="204.762" style="fill:#333333;" width="100" height="9.524" />
                                            <rect x="85.714" y="228.571" style="fill:#333333;" width="100" height="9.524" />
                                        </g>
                                    </g>
                                </svg>
                                <span>Reports</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Route::is('sale.gstreport') || Route::is('purchase.gstreport') || Route::is('stock.gstreport') ? 'show' : '' }}"
                            id="reports" data-bs-parent="#accordionExample">
                            <li class="{{ Route::is('sale.gstreport') ? 'active' : '' }}"><a
                                    href="{{ route('sale.gstreport') }}"> Sales Report </a></li>
                            <li class="{{ Route::is('purchase.gstreport') ? 'active' : '' }}"><a
                                    href="{{ route('purchase.gstreport') }}"> Purchase Report </a></li>
                            <li class="{{ Route::is('stock.gstreport') ? 'active' : '' }}"><a
                                    href="{{ route('stock.gstreport') }}"> Stock Report </a></li>
                        </ul>
                    </li>

                    <!-- Settings Menu -->
                    <li class="menu {{ Route::is('settings.index') || Route::is('business.indexshow')  ? 'active' : '' }}">
                        <a href="#settings" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('settings.index') || Route::is('settings.invoice') || Route::is('settings.profile') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg width="800" height="800" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                                    <path class="clr-i-outline clr-i-outline-path-1" d="M18.1 11c-3.9 0-7 3.1-7 7s3.1 7 7 7 7-3.1 7-7-3.1-7-7-7m0 12c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5" />
                                    <path class="clr-i-outline clr-i-outline-path-2" d="m32.8 14.7-2.8-.9-.6-1.5 1.4-2.6c.3-.6.2-1.4-.3-1.9l-2.4-2.4c-.5-.5-1.3-.6-1.9-.3l-2.6 1.4-1.5-.6-.9-2.8C21 2.5 20.4 2 19.7 2h-3.4c-.7 0-1.3.5-1.4 1.2L14 6c-.6.1-1.1.3-1.6.6L9.8 5.2c-.6-.3-1.4-.2-1.9.3L5.5 7.9c-.5.5-.6 1.3-.3 1.9l1.3 2.5c-.2.5-.4 1.1-.6 1.6l-2.8.9c-.6.2-1.1.8-1.1 1.5v3.4c0 .7.5 1.3 1.2 1.5l2.8.9.6 1.5-1.4 2.6c-.3.6-.2 1.4.3 1.9l2.4 2.4c.5.5 1.3.6 1.9.3l2.6-1.4 1.5.6.9 2.9c.2.6.8 1.1 1.5 1.1h3.4c.7 0 1.3-.5 1.5-1.1l.9-2.9 1.5-.6 2.6 1.4c.6.3 1.4.2 1.9-.3l2.4-2.4c.5-.5.6-1.3.3-1.9l-1.4-2.6.6-1.5 2.9-.9c.6-.2 1.1-.8 1.1-1.5v-3.4c0-.7-.5-1.4-1.2-1.6m-.8 4.7-3.6 1.1-.1.5-.9 2.1-.3.5 1.8 3.3-2 2-3.3-1.8-.5.3q-1.05.6-2.1.9l-.5.1-1.1 3.6h-2.8l-1.1-3.6-.5-.1-2.1-.9-.5-.3-3.3 1.8-2-2 1.8-3.3-.3-.5Q8 22.05 7.7 21l-.1-.5L4 19.4v-2.8l3.4-1 .2-.5c.2-.8.5-1.5.9-2.2l.3-.5-1.7-3.3 2-2 3.2 1.8.5-.3c.7-.4 1.4-.7 2.2-.9l.5-.2L16.6 4h2.8l1.1 3.5.5.2q1.05.3 2.1.9l.5.3 3.3-1.8 2 2-1.8 3.3.3.5q.6 1.05.9 2.1l.1.5 3.6 1.1z" />
                                    <path fill="none" d="M0 0h36v36H0z" />
                                </svg>
                                <span>Settings</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Route::is('settings.index') || Route::is('business.indexshow')  ? 'show' : '' }}"
                            id="settings" data-bs-parent="#accordionExample">
                            <li class="{{ Route::is('settings.index') ? 'active' : '' }}">
                                <a href="{{ route('settings.index') }}">

                                    Invoice Settings
                                </a>
                            </li>
                            <li class="{{ Route::is('business.indexshow') ? 'active' : '' }}">
                                <a href="{{ route('business.indexshow') }}">

                                    Profile Settings
                                </a>
                            </li>
                            @if ($business->gstavailable == 'yes')
                            <li class="{{ Route::is('ebill.settings') ? 'active' : '' }}">
                                <a href="{{ route('ebill.settings') }}">
                                    E-way Bill Settings
                                </a>
                            </li>
                            @endif

                        </ul>
                    </li>

                    <div class="ps__rail-y" style="top: 932px; height: 666px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 372px; height: 265px;"></div>
                    </div>
                </ul>

            </nav>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">


            {{-- <div class="container"> --}}

            <!--  BEGIN BREADCRUMBS  -->
            <!-- <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Sales">

                </div>
            </div> -->
            <!--  END BREADCRUMBS  -->



            <div class="row " style="margin-top: -30px;">

                <!-- @include('layouts.flash-messages') -->
                @yield('content')
                @include('layouts.footer')
            </div>
            {{-- @include('layouts.footer') --}}
        </div>



        {{-- </div> --}}
        <!--  END CONTENT AREA  -->


        <!--  BEGIN FOOTER  -->
        {{-- <div class="footer-wrapper">
        <div class="footer-section f-section-1">
            <p class="">Copyright © <span class="dynamic-year">{{ date('Y');}}</span> <a target="_blank" href="#"></a></p>
    </div>

    </div> --}}
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('v2/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('v2/layouts/vertical-light-menu/app.js') }}"></script>

    <script src="{{ asset('v2/src/plugins/src/highlight/highlight.pack.js') }}"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
    {{-- <script src="{{ asset('v2/src/assets/js/scrollspyNav.js') }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>@stack('scripts')
    <script src="{{ asset('v2/src/plugins/src/table/datatable/datatables.js') }}"></script>


    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebars');
            const sidebarCollapseBtn = document.querySelector('.sidebarCollapse');
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebarBtnCollapse = document.querySelector('.sidebarbuttonCollapse');
            // Function to toggle sidebar collapse/expand
            sidebarCollapseBtn.addEventListener('click', function() {
                alert(0);
                sidebar.classList.toggle('collapsed');
            });

            // Function to expand sidebar when the toggle button inside the collapsed sidebar is clicked
            sidebarBtnCollapse.addEventListener('click', function() {
                alert(1);
                sidebar.classList.remove('collapsed');
            });
        });
    </script> -->

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Function to clear local storage, session storage, and cookies
            function clearAllClientSideData() {
                // Clear Local Storage
                localStorage.clear();

                // Clear Session Storage
                sessionStorage.clear();

                // Clear Cookies
                // Loop through all cookies and delete them
                document.cookie.split(";").forEach(function(cookie) {
                    let cookieName = cookie.split("=")[0];
                    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
                });
            }

            // Call this function after logout or when session should be cleared
            clearAllClientSideData();

            if (window.location.href.includes('login')) {
                clearAllClientSideData();
            }

        });
    </script>
</body>

</html>
