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
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="#" class="nav-link" style="color: #fff; font-weight:bold;">
                        MY DAILY BILL
                    </a>
                </li>
            </ul>

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
                                @if ($business != null)
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
                                    @if ($business != null)
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
                            <!-- <a href="{{ route('business.indexshow') }}"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>Profile</span>
                            <!-- </a> -->
                        </div>




                    </div>

                </li>
            </ul>

        </header>

    </div>
    <!--  END NAVBAR  -->
    <br>
    <br>
    <br>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h3>Subscription Expired</h3>
                    </div>
                    <div class="card-body">
                        <?php

                        use App\Models\Plan;

                        // Fetch all plans
                        $plan = Plan::all();

                        ?>

                        <p class="mb-4">Your subscription plan has expired. To continue enjoying our services, please renew your plan.</p>
                        <a href="{{ route('pricing') }}" class="btn btn-primary" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Renew Subscription</a>
                        </div>
                    <div class="card-footer text-muted">
                       

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('v2/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('v2/layouts/vertical-light-menu/app.js') }}"></script>

    <script src="{{ asset('v2/src/plugins/src/highlight/highlight.pack.js') }}"></script>
    <!-- END GLOBAL MANDATORY STYLES -->

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('v2/src/plugins/src/table/datatable/datatables.js') }}"></script>




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