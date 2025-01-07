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
    <meta name="robots" content="noindex,nofollow">

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
    <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

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
    </style>

    @stack('stylecss')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    @if (Auth::user())
                        <h4 class="text-center font-weight-bold">
                            {{ strtoupper(Auth::user()->name) }}
                        </h4>
                    @endif
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none"
                        onclick="toggleMenu()">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active open">
                        <a href="{{ route('superadmin.home') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Dashboards">Dashboard</div>
                        </a>
                    </li>

                    <!-- Party -->
                    <li class="menu-item">
                        <a href="{{ route('party.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div data-i18n="Party">Party</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('party.create') }}" class="menu-link">
                                    <div data-i18n="Add Party">Add Party</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('party.index') }}" class="menu-link">
                                    <div data-i18n="View Party">View Party</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Product -->
                    <li class="menu-item">
                        <a href="{{ route('product.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-box"></i>
                            <div data-i18n="Products">Products</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('product.create') }}" class="menu-link">
                                    <div data-i18n="Add Product">Add Product</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('product.index') }}" class="menu-link">
                                    <div data-i18n="View Product">View Product</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('productcategory.create') }}" class="menu-link">
                                    <div data-i18n="Add Product Category">Add Product Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('productcategory.index') }}" class="menu-link">
                                    <div data-i18n="View Product Category">View Product Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('productsubcategory.create') }}" class="menu-link">
                                    <div data-i18n="Add Product Sub Category">Add Sub Category</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('productsubcategory.index') }}" class="menu-link">
                                    <div data-i18n="View Product Sub Category">View Sub Category</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Purchase -->
                    <li class="menu-item">
                        <a href="{{ route('purchase.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-receipt"></i>
                            <div data-i18n="Purchase">Purchase</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('purchase.create') }}" class="menu-link">
                                    <div data-i18n="Add Purchase">Add Purchase</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('purchase.index') }}" class="menu-link">
                                    <div data-i18n="View Purchase">View Purchase</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('purchasereturns.index') }}" class="menu-link">
                                    <div data-i18n="Purchase Return">Purchase Return</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('repairs.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-receipt"></i>
                            <div data-i18n="Quotation">Service</div>
                        </a>
                    </li>

                    <!-- Sales -->
                    <li class="menu-item">
                        <a href="{{ route('sale.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-credit-card"></i>
                            <div data-i18n="Sales">Sales</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('sale.create') }}" class="menu-link">
                                    <div data-i18n="Add Sale">Add Sale</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('sale.index') }}" class="menu-link">
                                    <div data-i18n="View Sale">View Sale</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('salereturns.index') }}" class="menu-link">
                                    <div data-i18n="Sales Return">Sales Return</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Delivery Chellan">Delivery Chellan</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('quotations.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-receipt"></i>
                            <div data-i18n="Quotation">Quotation</div>
                        </a>
                    </li>
                  

                    <!-- Payments -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-credit-card-front"></i>
                            <div data-i18n="Payments">Payments</div>
                        </a>
                        <ul class="menu-sub">
                             <li class="menu-item">
                                <a href="#" class="menu-link menu-toggle">
                                   
                                   INWARD
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="{{route('partypayment.receivePayment')}}" class="menu-link">
                                            <div data-i18n="Add Receipt">Add Receipt</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('payment.receipt')}}" class="menu-link">
                                            <div data-i18n="View Receipt">View Receipt</div>
                                        </a>
                                    </li>
                                </ul>
                        </ul>
                         <ul class="menu-sub">
                             <li class="menu-item">
                                <a href="#" class="menu-link menu-toggle">
                                    <div data-i18n="Payouts">OUTWARD</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="{{route('partypayment.addPayment')}}" class="menu-link">
                                            <div data-i18n="Add Payment">Add Payment</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{route('payment.payment')}}" class="menu-link">
                                            <div data-i18n="View Payment">View Payment</div>
                                        </a>
                                    </li>
                                </ul>
                        </ul>
                    </li>

                      <!-- Payout -->
                      <li class="menu-item">
                        <a href="{{ route('financiers.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-money"></i>
                            <div data-i18n="Payouts">Payouts</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('financiers.create') }}" class="menu-link">
                                    <div data-i18n="Add Financier">Add Financier</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('financiers.index') }}" class="menu-link">
                                    <div data-i18n="View Financiers">View Financiers</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Report -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Reports</div>
                        </a>

                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('sale.gstreport') }}" class="menu-link">
                                    <div data-i18n="Without menu">Sales Report</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('purchase.gstreport') }}" class="menu-link">
                                    <div data-i18n="Without menu">Purchase Report</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Without menu">Stock Report</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Without menu">Partywise Report</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link menu-toggle">
                                    <div data-i18n="Without menu">Gst Report</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="#" class="menu-link">
                                            <div data-i18n="Without menu">GSTR 1</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#" class="menu-link">
                                            <div data-i18n="Without menu">GSTR 2</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#" class="menu-link">
                                            <div data-i18n="Without menu">GSTR 3B</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                        </ul>
                    </li>
                    <!-- Others -->
                    <li class="menu-item">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-dots-horizontal-rounded"></i>
                            <div data-i18n="Others">Others</div>
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <div data-i18n="Stock Ledger">Stock Ledger</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Settings -->
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="Settings">Settings</div>
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
                                            @php
                                                $business = \App\Models\Business::where(
                                                    'user_id',
                                                    Auth::user()->id,
                                                )->first();
                                            @endphp

                                            @if ($business)
                                                <img src="{{ asset('uploads/' . $business->logo) }}"
                                                    alt="User Avatar" class="w-px-40  rounded-circle"
                                                    style="border: 1pt solid rgba(168, 168, 168, 0.459);" />
                                            @else
                                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar"
                                                    class="w-px-40 h-auto rounded-circle" />
                                            @endif

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
                                        @if (Auth::user())
                                            <a href="{{ route('business.indexshow') }}" class="dropdown-item">
                                                <div data-i18n="Layouts">My Profile</div>
                                            </a>
                                        @endif
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


                @include('layouts.flash-messages')
                @yield('content')

                 @include('layouts.footer')
            </div>
            <!-- / Layout page -->


        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    {{-- wave container --}}
    <div class="wave-container">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18v44h-352z" />
            </defs>
            <g class="parallax">
                <use href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg>
    </div>


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script> -->
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datepicker/js/bootstrap-datepicker.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js') }}"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                $('#datetimepicker9').datepicker({
                    format: 'dd-mm-yyyy',
                    "setDate": new Date()
                });
            });

        });
    </script>
    @stack('scripts')
</body>

</html>
