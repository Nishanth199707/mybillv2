<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Invoice</title>
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('v2/layouts/vertical-light-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('v2/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('v2/src/assets/css/light/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/src/assets/css/dark/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    
</head>
<body class="layout-boxed">
    
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

 

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container " id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

 

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                  
                    <div class="row invoice layout-top-spacing layout-spacing">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            
                            <div class="doc-container">
    
                                <div class="row">
    
                                    <div class="col-xl-9">
    
                                        <div class="invoice-container">
                                            <div class="invoice-inbox">
                                                
                                                <div id="ct" class="">
                                                    <div class="invoice-00001">
                                                        <div class="content-section">
                                                            <div class="inv--head-section inv--detail-section">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-12 mr-auto">
                                                                        <div class="d-flex">
                                                                            <img class="company-logo"  id="logo"
                                                                            src="{{ asset('uploads/' . $business->logo) }}" alt="company">
                                                                            <h3 class="in-heading align-self-center">{{ $business->company_name }}</h3>
                                                                        </div>
                                                                        <p class="inv-street-addr mt-3">{{ $business->address }}</p>
                                                                        <p class="inv-email-address">{{ $business->email }}</p>
                                                                        <p class="inv-email-address">{{ $business->phone_no }}</p>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-6 text-sm-end">
                                                                        <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4">
                                                                            <span class="inv-title">Invoice : </span> 
                                                                            <span class="inv-number">#{{ $sale->invoice_no }}</span>
                                                                        </p>
                                                                        <p class="inv-created-date mt-sm-5 mt-3">
                                                                            <span class="inv-title">Invoice Date : </span>
                                                                            <span class="inv-date">{{ $sale->invoice_date}}</span>
                                                                        </p>
                                                                        <p class="inv-due-date">
                                                                            <span class="inv-title">Due Date : </span>
                                                                            <span class="inv-date">{{ $sale->invoice_date }}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                
                                                            <div class="inv--detail-section inv--customer-detail-section">
                                                                <div class="row">
                                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                                        <p class="inv-to">Invoice To</p>
                                                                    </div>
                                                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                                        <h6 class="inv-title">Invoice From</h6>
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                                        <p class="inv-customer-name">{{ $party->name }}</p>
                                                                        <p class="inv-street-addr">{{ $party->billing_address_1 }}</p>
                                                                        <p class="inv-email-address">{{ $party->email }}</p>
                                                                        <p class="inv-email-address">{{ $party->_no }}</p>
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1 text-sm-end">
                                                                        <p class="inv-customer-name">{{ $business->name }}</p>
                                                                        <p class="inv-street-addr">{{ $business->address }}</p>
                                                                        <p class="inv-email-address">{{ $business->email }}</p>
                                                                        <p class="inv-email-address">{{ $business->phone_no }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                
                                                            <div class="inv--product-table-section">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">S.No</th>
                                                                                <th scope="col">Items</th>
                                                                                <th class="text-end" scope="col">Qty</th>
                                                                                <th class="text-end" scope="col">Price</th>
                                                                                <th class="text-end" scope="col">Amount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($saledetail as $index => $item)
                                                                                <tr>
                                                                                    <td>{{ $index + 1 }}</td>
                                                                                    <td>
                                                                                        @php
                                                                                            $maxCharsPerLine = 16; // Set the max characters per line
                                                                                            $itemDescription = $item->item_description; // Get the item description
                                                                                        @endphp
                                                                                    
                                                                                        @if(strlen($itemDescription) > $maxCharsPerLine)
                                                                                            @for($i = 0; $i < strlen($itemDescription); $i += $maxCharsPerLine)
                                                                                                {{ substr($itemDescription, $i, $maxCharsPerLine) }}<br>
                                                                                            @endfor
                                                                                        @else
                                                                                            {{ $itemDescription }}
                                                                                        @endif
                                                                                    </td>
                                                                                    
                                                                                    <td class="text-end">{{ $item->qty }}</td>
                                                                                    <td class="text-end">Rs.{{ number_format($item->amount, 2) }}</td>
                                                                                    <td class="text-end">Rs.{{ number_format($item->total_amount, 2) }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                
                                                            <div class="inv--total-amounts">
                                                                <div class="row mt-4">
                                                                    <div class="col-sm-5 col-12 order-sm-0 order-1"></div>
                                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                                        <div class="text-sm-end">
                                                                            <div class="row">
                                                                                <div class="col-sm-8 col-7">
                                                                                    <p class="">Sub Total :</p>
                                                                                </div>
                                                                                <div class="col-sm-4 col-5">
                                                                                    <p class="">{{ 'Rs.' . number_format($sale->totalAmountDisplay, 2) }}</p>
                                                                                </div>
                                                                                @if (session('gstavailable') == 'yes')
                                                                                <div class="col-sm-8 col-7">
                                                                                    <p class="">Tax  :</p>
                                                                                </div>
                                                                                <div class="col-sm-4 col-5">
                                                                                    <p class="">{{ 'Rs.' . number_format($sale->tax_amount, 2) }}</p>
                                                                                </div>
                                                                                @endif
                                                                                {{-- <div class="col-sm-8 col-7">
                                                                                    <p class=" discount-rate">Shipping :</p>
                                                                                </div>
                                                                                <div class="col-sm-4 col-5">
                                                                                    <p class="">{{ 'Rs.' . number_format($sale->shipping, 2) }}</p>
                                                                                </div> --}}
                                                                                {{-- <div class="col-sm-8 col-7">
                                                                                    <p class=" discount-rate">Discount 5% :</p>
                                                                                </div>
                                                                                <div class="col-sm-4 col-5">
                                                                                    <p class="">{{ 'Rs.' . number_format($sale->discount, 2) }}</p>
                                                                                </div> --}}
                                                                                <div class="col-sm-8 col-7 ">
                                                                                    <h4 class="">Grand Total : </h4>
                                                                                </div>
                                                                                <div class="col-sm-4 col-5 ">
                                                                                    <h4 class="">{{ 'Rs.' . number_format($sale->net_amount, 2) }}</h4>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="inv--note" >
                                                                <div class="row mt-4">
                                                                    <div class="col-sm-12 col-12 " >
                                                                        <p>Note: {{ $setting->description_text }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                
        
        
                                            </div>
        
                                        </div>
    
                                    </div>
    
                                    <div class="col-xl-3">
    
                                        <div class="invoice-actions-btn">
    
                                            <div class="invoice-action-btn">

                                                <div class="row">
                                                    {{-- <div class="col-xl-12 col-md-3 col-sm-6">
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-send">Send Invoice</a>
                                                    </div> --}}
                                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                                        <a href="javascript:void(0);" class="btn btn-secondary btn-print  action-print">Print</a>
                                                    </div>
                                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-download">Download</a>
                                                    </div>
                                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                                    <a href="{{route('sale.index')}}"
                                                        class="btn btn-danger btn-download contenttopdf">Back</a>
                                                </div>
                                                </div>

                                            </div>
                                            
                                        </div>
                                        
                                    </div>
    
                                </div>
                                
                            </div>
    
                        </div>
                    </div>

                </div>

            </div>

          
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('v2/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('v2/layouts/vertical-light-menu/app.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('v2/src/assets/js/apps/invoice-preview.js') }}"></script>
</body>
</html>