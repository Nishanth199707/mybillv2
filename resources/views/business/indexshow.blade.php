<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed layout-compact"
    dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>MyDailyBill</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logosymbol.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datepicker/css/datepicker.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" /> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .invalid-feedback {
            display: block;
        }

        .totalstyle1 {
            width: 50%;
            border: 0;
            /* height: 100%; */
            /* margin-left: 20px; */
        }

        .totalstyle {
            /* width: 50%; */
            border: 0;
            /* height: 100%; */
            /* margin-left: 20px; */
            /* overflow: hidden; */
            position: relative;
            padding: 0;
            background: inherit;
            font-weight: bolder;
            font-size: 30px;
        }

        .totalstyle1:focus,
        .totalstyle:focus {
            outline: none;
            /* This removes the focus outline */
            /* Your other styles */
        }

        .totalstyle--input:focus {
            outline: none;
            /* Removes the default focus outline */
            /* Additional styles if needed */
        }

        .gsttable tr,
        .gsttable {
            width: 100%;
        }

        /* .gsttable td:nth-child(1) {
            width: 10%;
        } */

        .gsttable td {
            width: 17%;
            display: inline-block;
            /* overflow: hidden; */
            margin: 5px;
            text-align: center;
            /* display: inline-flex; */
        }


        .avl_stock {
            padding: 0 10px;
        }

        /* .card {
            background-color: #114b3a;
            color: #fff !important;
        } */



        .blur {
            filter: blur(1px);
            /* Adjust the blur amount as needed */
            pointer-events: none;
            /* Prevent interactions with the blurred content */
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
            /* White overlay with opacity */
            backdrop-filter: blur(1px);
            /* Blur effect */
            z-index: 999;
            /* Ensure it appears above other content */
            display: none;
            /* Hidden by default */
            align-items: center;
            justify-content: center;
        }

        .overlay.active {
            display: flex;
            /* Show overlay when active */
        }
    </style>

    @stack('stylecss')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper blur  layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    {{-- <a href="{{ url('/') }}" class="app-brand-link"> --}}
                    {{-- <span class="app-brand-logo demo">
                            <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                    <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                    <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                                    <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                                    <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                                </defs>
                                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                        <g id="Icon" transform="translate(27.000000, 15.000000)">
                                            <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                <mask id="mask-2" fill="white">
                                                    <use xlink:href="#path-1"></use>
                                                </mask>
                                                <use fill="#696cff" xlink:href="#path-1"></use>
                                                <g id="Path-3" mask="url(#mask-2)">
                                                    <use fill="#696cff" xlink:href="#path-3"></use>
                                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                                </g>
                                                <g id="Path-4" mask="url(#mask-2)">
                                                    <use fill="#696cff" xlink:href="#path-4"></use>
                                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                                </g>
                                            </g>
                                            <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                                <use fill="#696cff" xlink:href="#path-5"></use>
                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </span> --}}
                  
                        @if (Auth::user())
                            <h5 style="text-align: center;font-weight:bold;">

                            @php
                                echo strtoupper(Auth::user()->name);
                            @endphp
                            </h5>

                        @endif
                    {{-- </a> --}}

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item active open">
                        <a href="{{ route('superadmin.home') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Dashboards">Dashboards</div>
                        </a>

                    </li>


                    <!-- Users -->
                    {{-- <li class="menu-item">
                        <a href="{{ route('users.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Users</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('users.create') }}" class="menu-link">
                                    <div data-i18n="Without menu">Add User</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('users.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View User</div>
                                </a>
                            </li>

                        </ul>
                    </li> --}}

                    <!-- Business Profile -->
                    {{-- <li class="menu-item">
                        <a href="{{ route('business.index')}}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Business</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('business.create')}}" class="menu-link">
                                    <div data-i18n="Without menu">Add Business</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('business.index')}}" class="menu-link">
                                    <div data-i18n="Without menu">View Business</div>
                                </a>
                            </li>

                        </ul>
                    </li> --}}


                    <!-- Party -->

                    <li class="menu-item">
                        <a href="{{ route('party.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Party</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('party.create') }}" class="menu-link">
                                    <div data-i18n="Without menu">Add Party</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('party.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View Party</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- Product -->

                    <li class="menu-item">
                        <a href="{{ route('product.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Products</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('product.create') }}" class="menu-link">
                                    <div data-i18n="Without menu">Add Product</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('product.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View Product</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="{{ route('productcategory.create') }}" class="menu-link">
                                    <div data-i18n="Without menu">Add Product Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('productcategory.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View Product Category</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- Sale -->

                    <li class="menu-item">
                        <a href="{{ route('sale.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Sales</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('sale.create') }}" class="menu-link">
                                    <div data-i18n="Without menu">Add Sale</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('sale.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View Sale</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('salesreturn.index') }}" class="menu-link">
                                    <div data-i18n="Without menu"> Sales Return</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('purchase.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Purchase</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('purchase.create') }}" class="menu-link">
                                    <div data-i18n="Without menu">Add Purchase</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('purchase.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View Purchase</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('purchasereturn.index') }}" class="menu-link">
                                    <div data-i18n="Without menu"> Purchase Return</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('gstreport.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Reports</div>
                        </a>

                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('gstreport.index') }}" class="menu-link">
                                    <div data-i18n="Without menu">View Purchase</div>
                                </a>
                            </li>



                        </ul>
                    </li>

                    <!-- Others -->

                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Others</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Without menu">Delivery Chellan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Without menu">Stock Ledger</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- profile -->

                    <li class="menu-item">
                        <a href="{{ route('business.indexshow') }}" class="menu-link ">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">My Profile</div>
                        </a>

                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-fluid navbar align-items-center bg-navbar-theme">
                    <div class="position-absolute w-100 text-center">
                        <h1 class="my-0"
                            style="color: #114b3a; text-shadow: 6px 6px 12px rgba(255, 255, 255, 0.63); letter-spacing: 12px; font-weight: bold;">
                            MY DAILY BILL
                        </h1>

                    </div>
                    <div class="d-flex align-items-center w-100">
                        <!-- Centered Title -->

                        <!-- User Name, Avatar, and Dropdown -->
                        <ul class="navbar-nav d-flex align-items-center ms-auto me-3 p-0">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center"
                                    href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="d-flex align-items-center">
                                        @if (Auth::user())
                                            <span class="me-1">{{ Auth::user()->name }}</span>
                                        @endif
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar"
                                                class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                {{-- <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div> --}}
                                                <div class="flex-grow-1">
                                                    @if (Auth::user())
                                                        <span
                                                            class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                                        <small class="text-muted">{{ Auth::user()->type }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>








                <!-- / Navbar -->



            </div>
            <!-- / Layout page -->


        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <div class="overlay active">
        <div class="card">

            <div class="card-body text-center py-5 ">
                <i class="bx bx-info-circle text-primary" style="font-size: 48px;"></i>
                <h5 class="my-4" style="font-size: 30px;">No Business Details Available</h5>
                <p class="text-muted mb-4" style="font-weight:bold;font-size:24px;">It looks like you haven't completed your business profile yet. Please
                    complete your profile to continue.</p>
                <a href="{{ route('business.create') }}" class="btn btn-outline-primary btn-lg">Complete Your
                    Profile</a>
            </div>
        </div>
    </div>


</body>

</html>
