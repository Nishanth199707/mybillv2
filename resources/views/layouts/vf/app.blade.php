<html lang="en" class="sidebar-noneoverflow">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>MyDailyBill</title>
    <meta name="robots" content="noindex,nofollow">


    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logosymbol.ico') }}" />
   


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <!-- BEGIN PAGE LEVEL STYLES -->

    <link rel="stylesheet" href="{{ asset('assetscss/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/icofont.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/meanmenu.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/slick.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/animated-headlines.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/shortcodes.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assetscss/responsive.css') }}">
	<script src="{{ asset('assetsjs/modernizr-3.11.2.min.js') }}"></script>
    <!-- END PAGE LEVEL STYLES -->

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
    <div class="header-container">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="index.html">
                        {{-- <img src="{{ asset('vf/src/assets/img/logo.svg') }}" class="navbar-logo" alt="logo"> --}}
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="#" class="nav-link">
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

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-container">
                            <div class="avatar avatar-sm avatar-indicators avatar-online">
                                @if ($business)
                                <img src="{{ asset('uploads/' . $business->logo) }}" alt="User Avatar"
                                    class="rounded-circle" />
                                @else
                                <img alt="avatar" src="{{ asset('vf/src/assets/img/profile-30.png') }}"
                                    class="rounded-circle">
                                @endif

                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                <div class="emoji me-2">
                                    @if ($business)
                                    <img src="{{ asset('uploads/' . $business->logo) }}" alt="User Avatar"
                                        class="rounded-circle" />
                                    @else
                                    <img alt="avatar" src="{{ asset('vf/src/assets/img/profile-30.png') }}"
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
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4vf"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> <span>Profile</span>
                            </a>
                        </div>

                        <div class="dropdown-item">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg> <span>Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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

            <nav id="sidebar" class="side_bar">
                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
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
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu">
                                    <rect x="4" y="4" width="16" height="16" rx="2" ry="2">
                                    </rect>
                                    <rect x="9" y="9" width="6" height="6"></rect>
                                    <line x1="9" y1="1" x2="9" y2="4"></line>
                                    <line x1="15" y1="1" x2="15" y2="4"></line>
                                    <line x1="9" y1="20" x2="9" y2="23"></line>
                                    <line x1="15" y1="20" x2="15" y2="23"></line>
                                    <line x1="20" y1="9" x2="23" y2="9"></line>
                                    <line x1="20" y1="14" x2="23" y2="14"></line>
                                    <line x1="1" y1="9" x2="4" y2="9"></line>
                                    <line x1="1" y1="14" x2="4" y2="14"></line>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu">
                                    <rect x="4" y="4" width="16" height="16" rx="2" ry="2">
                                    </rect>
                                    <rect x="9" y="9" width="6" height="6"></rect>
                                    <line x1="9" y1="1" x2="9" y2="4"></line>
                                    <line x1="15" y1="1" x2="15" y2="4"></line>
                                    <line x1="9" y1="20" x2="9" y2="23"></line>
                                    <line x1="15" y1="20" x2="15" y2="23"></line>
                                    <line x1="20" y1="9" x2="23" y2="9"></line>
                                    <line x1="20" y1="14" x2="23" y2="14"></line>
                                    <line x1="1" y1="9" x2="4" y2="9"></line>
                                    <line x1="1" y1="14" x2="4" y2="14"></line>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu">
                                    <rect x="4" y="4" width="16" height="16" rx="2" ry="2">
                                    </rect>
                                    <rect x="9" y="9" width="6" height="6"></rect>
                                    <line x1="9" y1="1" x2="9" y2="4"></line>
                                    <line x1="15" y1="1" x2="15" y2="4"></line>
                                    <line x1="9" y1="20" x2="9" y2="23"></line>
                                    <line x1="15" y1="20" x2="15" y2="23"></line>
                                    <line x1="20" y1="9" x2="23" y2="9"></line>
                                    <line x1="20" y1="14" x2="23" y2="14"></line>
                                    <line x1="1" y1="9" x2="4" y2="9"></line>
                                    <line x1="1" y1="14" x2="4" y2="14"></line>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
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
                    @if($business->business_category == 'Mobile & Accessories')

                    <li class="menu {{ Route::is('repairs.index') ? 'active' : '' }}">
                        <a href="{{ route('repairs.index') }}" class="dropdown-toggle">
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
                        </a>
                    </li>
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
                            <li><b class="pl-3">OUTWARD</b></li>
                            <li class="{{ Route::is('partypayment.addPayment') ? 'active' : '' }}"><a
                                    href="{{ route('partypayment.addPayment') }}"> Add Payment </a></li>
                            <li class="{{ Route::is('payment.payment') ? 'active' : '' }}"><a
                                    href="{{ route('payment.payment') }}"> View Payment </a></li>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-box">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                    </path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
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
                    @if($business->business_category == 'Mobile & Accessories')
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
                    <!-- Reports Menu -->
                    <li
                        class="menu {{ Route::is('sale.gstreport') || Route::is('purchase.gstreport') ? 'active' : '' }}">
                        <a href="#reports" data-bs-toggle="collapse"
                            aria-expanded="{{ Route::is('sale.gstreport') || Route::is('purchase.gstreport') ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-settings">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v4h2zm0 6h-2v6h2z"></path>
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
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Sales">
                    <header class="header navbar navbar-expand-sm">
                        <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12">
                                </line>
                                <line x1="3" y1="6" x2="21" y2="6">
                                </line>
                                <line x1="3" y1="18" x2="21" y2="18">
                                </line>
                            </svg>
                        </a>

                        <div class="d-flex breadcrumb-content">
                            <div class="page-header">

                                <div class="page-title">
                                </div>

                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="#" style="font-weight: bold;color:black;font-size:27px;">
                                                @if (Auth::user())
                                                {{ strtoupper(Auth::user()->name) }}
                                                @endif
                                            </a>
                                        </li>
                                        {{-- <li class="breadcrumb-item active" aria-current="page">Sales</li> --}}
                                    </ol>
                                </nav>

                            </div>
                        </div>
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
                                            data-icon="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;24&quot; height=&quot;24&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; class=&quot;feather feather-settings&quot;><circle cx=&quot;12&quot; cy=&quot;12&quot; r=&quot;3&quot;></circle><path d=&quot;M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51vf1a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z&quot;></path></svg>"
                                            href="javascript:void(0);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-settings">
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <path
                                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51vf1a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
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
                </div>
            </div>
            <!--  END BREADCRUMBS  -->



            <div class="row layout-top-spacing">

                <!-- @include('layouts.flash-messages') -->
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>



 
    </div>
    <!-- END MAIN CONTAINER -->


    <!-- END GLOBAL MANDATORY STYLES -->

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>@stack('scripts')

    <script src="{{ asset('vf/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('vf/jquery-migrate-3.3.2.min.js') }}"></script>
	<script src="{{ asset('vf/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('vf/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('vf/slick.min.js') }}"></script>
	<script src="{{ asset('vf/jquery.ajaxchimp.min.js') }}"></script>
	<script src="{{ asset('vf/plugins.js') }}"></script>
	<script src="{{ asset('vfjs/main.js') }}"></script>
</body>

</html>