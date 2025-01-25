<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bill/favicon.png" rel="icon" />
    <meta name="author" content="harnishdesign.net">



    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('v2/layouts/vertical-light-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .noto-sans-tamil {
            font-family: "Noto Sans Tamil", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('v2/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('v2/src/assets/css/light/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>



    <style>
        .invoice-container1 {
            width: 100%;
            /* Make container full width */
            max-width: 800px;
            /* Optional: set a maximum width */
            margin: auto;
            /* Center-align the container */
            border: 1px solid rgb(0, 0, 0);
            padding: 20px;
            margin-top: 2px;
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            border: 0.5pt solid #303030;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 25%;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 15%;
        }


        .t3,
        th,
        td {
            /* border: 0.5pt solid #303030; */
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            vertical-align: top
        }

        body {
            /* border: 0.5pt solid #303030; */
            border-collapse: collapse;
            word-wrap: break-word;
            font-family: 'sans-serif', 'Arial';
            font-size: 11px;
            /*height: 210mm;*/
        }




        .row1 {
            display: flex;
            border-top: none;
        }

        .row2 {
            display: flex;

        }

        .col-md-6 {
            display: flex;
            flex-direction: column;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .table_body td {
            border-bottom: none !important;
            border-top: none !important;
        }

        .table_body tr {
            border-bottom: none !important;
            /* Removes the bottom border */
        }

        .footer {
            /* padding: 20px; */
            padding-right: 20px;
            padding-left: 20px;
            /* border-top: 1px solid #ddd; */
            /* Optional, for visual separation */
        }

        .heading-with-underline {
            display: inline-block;
            border-bottom: 2px solid black;
            /* Adjust thickness and color */
            padding-bottom: 5px;
            /* Add space between text and underline */
            text-transform: uppercase;
        }

        @media print {
            body {
                visibility: hidden;
            }

            .invoice-container {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
            }

            .invoice-inbox {
                padding: 10px;
            }
        }
    </style>

    <style>
        .invoice-container1 {
            position: relative;
            overflow: hidden;
        }

        .invoice-container1::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50%;
            height: 50%;
            background-image: url('{{ asset('uploads/' . $business->logo) }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            opacity: 0.2;
            z-index: 1;
            transform: translate(-50%, -50%);
        }
    </style>

</head>

<body>
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content ">
        <div class="layout-px-spacing">
            <div class="middle-content container-xxl p-0">
                <div class="row invoice layout-top-spacing layout-spacing">
                    <div class="col-md-12">
                        <div class="doc-container">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="invoice-container">
                                        <div class="invoice-inbox">
                                            <div class="invoice-container1" id="ct">
                                                <!-- Main Content -->
                                                <main>
                                                    <!-- Header -->
                                                    <header>
                                                        <div class="row gy-3"
                                                            style="width: 100%!important;margin-left:.2px;">
                                                            <div class="col-12 text-center">
                                                                <h4 class="heading-with-underline text-4">Tax Invoice
                                                                </h4>
                                                            </div>
                                                            <div class="col-sm-3"
                                                                style="border: 0.5pt solid #303030;border-right:none;padding:2px;">
                                                                <img style="width: 100%;" height="100" id="logo"
                                                                    src="{{ asset('uploads/' . $business->logo) }}"
                                                                    title="MyDailyBill" alt="MyDailyBill" />
                                                            </div>
                                                            <div class="col-sm-7"
                                                                style="border: 0.5pt solid #303030;padding:10px;">
                                                                <h3 class="mb-1">
                                                                    <strong>{{ $business->company_name }}</strong>
                                                                </h3>
                                                                <p class="lh-base mb-0 text-capitalize">
                                                                    <strong>
                                                                        {{ $business->address . ',' . $business->city . '-' . $business->pincode . ',' . $business->state . ',' . $business->country }}
                                                                        <br> Phone No : {{ $business->phone_no }} ,<br>
                                                                        Email :{{ $business->email }}
                                                                    </strong>
                                                                    @if (session('gstavailable') == 'yes')
                                                                        <br>
                                                                        <strong>GSTIN : {{ $business->gstin }}</strong>
                                                                    @endif

                                                                </p>
                                                            </div>
                                                            <div class="col-sm-2"
                                                                style="border: 0.5pt solid #303030; border-left: none; ">
                                                                <p class=""
                                                                    style="font-size:small;padding:0;margin:0">Invoice
                                                                    No:</p>
                                                                <strong>{{ $sale->invoice_no }}</strong>
                                                                @if($sale->ewayBillNo)
                                                                <p class=""  style="padding:0;margin:0">E-Way Bill No:<br><strong>{{ $sale->ewayBillNo }}</strong>
                                                                </p>
                                                                @endif
                                                                <hr style="margin:0px;">
                                                                <p class=""><strong>Inv Date:</strong><br>
                                                                    {{ $sale->invoice_date }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </header>
                                                    <div class="row gy-3"
                                                        style="width: 100%!important;margin-left:0.1px; ">
                                                        @if ($setting->shipping_address == 'yes')
                                                            <div class="col-sm-4"
                                                                style="border-left: 0.5pt solid #303030;">
                                                            @else
                                                                <div class="col-sm-8"
                                                                    style="border-left: 0.5pt solid #303030;border-right: 0.5pt solid #303030;">
                                                        @endif
                                                        <strong>Bill To:</strong>
                                                        <address style="line-height: 1.1;">
                                                            {{ $party->name }}<br />
                                                            @if ($party->billing_address_1)
                                                                {{ $party->billing_address_1 }}<br />
                                                            @endif
                                                            @if ($party->billing_address_2)
                                                                {{ $party->billing_address_2 }}<br />
                                                            @endif
                                                            @if ($party->billing_pincode)
                                                                {{ $party->billing_pincode }}<br />
                                                            @endif
                                                            @if ($party->phone_no)
                                                                Ph: {{ $party->phone_no }}<br />
                                                            @endif
                                                            @if (session('gstavailable') == 'yes')
                                                                @if ($party->gstin)
                                                                    <p><strong>GSTIN:</strong> {{ $party->gstin }}</p>
                                                                @endif
                                                            @endif


                                                        </address>
                                                    </div>
                                                    @if ($setting->shipping_address == 'yes')
                                                        <div class="col-sm-4"
                                                            style="border: 0.5pt solid #303030;border-bottom:none;border-top:none;">
                                                            <strong>Ship To:</strong>
                                                            <address style="line-height: 1.1;">
                                                                {{ $party->name }}<br />
                                                                @if ($party->shipping_address_1)
                                                                    {{ $party->shipping_address_1 }}<br />
                                                                @endif
                                                                @if ($party->shipping_address_2)
                                                                    {{ $party->shipping_address_2 }}<br />
                                                                @endif
                                                                @if ($party->billing_pincode)
                                                                    {{ $party->shipping_pincode }}<br />
                                                                @endif
                                                            </address>
                                                        </div>
                                                    @else
                                                    @endif
                                                    <div class="col-sm-4" style="border-right: 0.5pt solid #303030;">
                                                        @if ($setting->purchase_order_date == 'yes')
                                                        @if ($business->business_category != 'Accounting & CA')
                                                        <p class="mb-1"><strong>PO Date:</strong>
                                                            @else
                                                            <p class="mb-1"><strong>Q Date:</strong>
                                                                @endif
                                                                {{ $sale->purchase_order_date }}
                                                            </p>
                                                        @else
                                                        @endif
                                                        @if ($setting->purchase_order_number == 'yes')
                                                        @if ($business->business_category != 'Accounting & CA')
                                                        <p class="mb-1"><strong>Q No:</strong>   
                                                                     @else
                                                            <p class="mb-1"><strong>Q No:</strong>         
                                                                   @endif
                                                                {{ $sale->purchase_order_number }}
                                                            </p>
                                                        @else
                                                        @endif
                                                        @if ($setting->vehicle_no == 'yes')
                                                            <p class="mb-1"><strong>Vehicle No:</strong>
                                                                {{ $sale->vehicle_no }}
                                                            </p>
                                                        @else
                                                        @endif

                                                        <p class=""><strong>Payment Mode:
                                                            </strong>{{ strtoupper($sale->cash_type) }}</p>

                                                    </div>
                                            </div>
                                            <div class="table-responsive ">


                                                <table class="table t2 border mb-0">
                                                    <thead>


                                                        <tr class="bg-light">
                                                            <th class="t3 col-2 text-left"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase; width:35%">
                                                                Particulars</th>
                                                            <th class="t3 col-1 text-center"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                HSN CODE</th>
                                                            <th class="t3 col-1 text-center"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                RATE</th>
                                                            <th class="t3 col-1 text-center"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                QTY</th>
                                                            <th class="t3 col-1 text-center"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                DIS</th>
                                                            <th class="t3 col-1 text-center"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;width: 10%;">
                                                                AMOUNT</th>
                                                            @if (session('gstavailable') == 'yes')
                                                                <th class="t3 col-1 text-center"
                                                                    style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                    GST %</th>
                                                            @endif
                                                            <th class="t3 col-2 text-center"
                                                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;width: 13%">
                                                                TOTAL</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody class="table_body" style="height:250px !important">
                                                        @foreach ($saledetail as $key => $val)
                                                            <tr class="t3" style="height:10px !important">
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: left;"
                                                                    class="col-2">
                                                                    <?php
                                                                    $itemDescription = $val->item_description;

                                                                    // Use preg_replace to add "IMEI" before numbers in parentheses
                                                                    $updatedDescription = preg_replace_callback(
                                                                        '/\((\d+)\)/', // Match numbers inside parentheses
                                                                        function ($matches) {
                                                                            return '(IMEI ' . $matches[1] . ')';
                                                                        },
                                                                        $itemDescription,
                                                                    );

                                                                    echo $updatedDescription;
                                                                    ?>
                                                                </td>
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: center;"
                                                                    class="col-1 text-center">
                                                                    {{ $val->hsn_code }}
                                                                </td>
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: center;"
                                                                    class="col-2 text-center">
                                                                    {{ $val->rpqty }}
                                                                </td>
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: center;"
                                                                    class="col-1 text-center">
                                                                    {{ $val->qty }}
                                                                </td>
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: center;"
                                                                    class="col-2 text-center">
                                                                    {{ $val->discount }}
                                                                </td>
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: center;"
                                                                    class="col-2 text-center">
                                                                    {{ $val->amount }}
                                                                </td>
                                                                @if (session('gstavailable') == 'yes')
                                                                    <td class="t3"
                                                                        style="border:  0.5pt solid #303030;text-align: center;"
                                                                        class="col-2 text-center">
                                                                        {{ $val->gst }}
                                                                    </td>
                                                                @endif
                                                                <td class="t3"
                                                                    style="border:  0.5pt solid #303030;text-align: center;"
                                                                    class="col-2 text-end">
                                                                    {{ $val->total_amount }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="t3">
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-2">
                                                            </td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-1 text-center">
                                                            </td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-2 text-center">
                                                            </td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-1 text-center">
                                                            </td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-2 text-center">
                                                            </td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-2 text-center"></td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-2 text-center">
                                                            </td>
                                                            <td class="t3"
                                                                style="border:  0.5pt solid #303030;text-align: center;"
                                                                class="col-2 text-end">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                                <div class="row1">
                                                    @if (session('gstavailable') == 'yes')
                                                    <div class="col-md-6">

                                                        <table class="table taxable">
                                                            <thead style="border: 0.5pt solid#303030">
                                                                <tr>
                                                                    <th class="text-center" style="padding: 5px;">
                                                                        Rate</th>
                                                                    <th class="text-center"
                                                                        style="padding: 5px; width:90px;">Taxable
                                                                    </th>
                                                                    <th class="text-center" style="padding: 5px;">
                                                                        CGST</th>
                                                                    <th class="text-center" style="padding: 5px;">
                                                                        SGST</th>
                                                                    <th class="text-center" style="padding: 5px;">
                                                                        IGST</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($sale->tax_amount_28_cgst)
                                                                    <tr class="bg-light">
                                                                        <td class="text-center">28%</td>
                                                                        <td class="text-center">
                                                                            {{ $sale->taxable28Amount }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sale->tax_amount_28_cgst }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sale->tax_amount_28_sgst }}
                                                                        </td>
                                                                        <td class="text-center">0</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($sale->tax_amount_18_cgst)
                                                                    <tr class="bg-light">
                                                                        <td class="text-center" style="padding: 4px;">
                                                                            18%
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            {{ $sale->taxable18Amount }}
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            {{ $sale->tax_amount_18_cgst }}
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            {{ $sale->tax_amount_18_sgst }}
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            0
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if ($sale->tax_amount_12_cgst)
                                                                    <tr class="bg-light">
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            12%
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            {{ $sale->taxable12Amount }}
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            {{ $sale->tax_amount_12_cgst }}
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            {{ $sale->tax_amount_12_sgst }}
                                                                        </td>
                                                                        <td class="text-center" style="padding: 6px;">
                                                                            0
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if ($sale->tax_amount_5_cgst)
                                                                    <tr class="bg-light">
                                                                        <td class="text-center">5%</td>
                                                                        <td class="text-center">
                                                                            {{ $sale->taxable5Amount }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sale->tax_amount_5_cgst }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sale->tax_amount_5_sgst }}
                                                                        </td>
                                                                        <td class="text-center">0</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($sale->tax_amount_3_cgst)
                                                                    <tr class="bg-light">
                                                                        <td class="text-center">3%</td>
                                                                        <td class="text-center">
                                                                            {{ $sale->taxable3Amount }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sale->tax_amount_3_cgst }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sale->tax_amount_3_sgst }}
                                                                        </td>
                                                                        <td class="text-center">0</td>
                                                                    </tr>
                                                                @endif
                                                                @if ($sale->tax_amount_0)
                                                                    <tr class="bg-light">
                                                                        <td class="text-center">0%</td>
                                                                        <td class="text-center">
                                                                            {{ $sale->taxable0Amount }}
                                                                        </td>
                                                                        <td class="text-center" colspan="3">0</td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td class="text-center fw-700"
                                                                        style="padding: 6px;">
                                                                        Total</td>
                                                                    <td class="text-center fw-700"
                                                                        style="padding: 6px;">
                                                                        {{ $sale->totalAmountDisplay }}
                                                                    </td>
                                                                    <td class="text-center fw-700"
                                                                        style="padding: 6px;">
                                                                        {{ $sale->total_cgst }}
                                                                    </td>
                                                                    <td class="text-center fw-700"
                                                                        style="padding: 6px;">
                                                                        {{ $sale->total_sgst }}
                                                                    </td>
                                                                    <td class="text-center fw-700"
                                                                        style="padding: 6px;">
                                                                        {{ $sale->total_igst }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" style="padding: 8px;">
                                                                        <span class="inline"
                                                                            style=" display: inline;font-weight:bold">Rupees.
                                                                            :</span>
                                                                        <p class="text-start" id="grandTotalInWords"
                                                                            style="display: inline;font-weight:bold;">
                                                                        </p>
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table">
                                                            <tr class="bg-light">
                                                                <td class="text-end"><strong>Sub Total:</strong>
                                                                </td>
                                                                <td class="text-end">Rs.
                                                                    {{ $sale->totalAmountDisplay }}
                                                                </td>
                                                            </tr>
                                                            <tr class="bg-light">
                                                                <td class="text-end"><strong>Total Tax:</strong>
                                                                </td>
                                                                <td class="text-end">Rs. {{ $sale->tax_amount }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-end"><strong>Grand Total:</strong>
                                                                </td>
                                                                <td class="text-end" id="grandTotal">Rs.
                                                                    {{ $sale->net_amount }}
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                    @else
                                                    <div class="col-md-6">


                                                        <table class="table taxable">
                                                            <thead style="border: 0.5pt solid#303030">

                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td colspan="5" style="padding: 8px;">
                                                                        <span class="inline"
                                                                            style=" display: inline;font-weight:bold">Rupees.
                                                                            :</span>
                                                                        <p class="text-start" id="grandTotalInWords"
                                                                            style="display: inline;font-weight:bold;">
                                                                        </p>
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table">
                                                            <tr class="bg-light">
                                                                <td class="text-end"><strong>Sub Total:</strong>
                                                                </td>
                                                                <td class="text-end">Rs.
                                                                    {{ $sale->totalAmountDisplay }}
                                                                </td>
                                                            </tr>
                                                            @if (session('gstavailable') == 'yes')

                                                            <tr class="bg-light">
                                                                <td class="text-end"><strong>Total Tax:</strong>
                                                                </td>
                                                                <td class="text-end">Rs. {{ $sale->tax_amount }}
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td class="text-end"><strong>Grand Total:</strong>
                                                                </td>
                                                                <td class="text-end" id="grandTotal">Rs.
                                                                    {{ $sale->net_amount }}
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                    @endif
                                                </div>

                                            @if ($setting->description == 'yes')
                                                <div class="row2" style="margin-top:-17px;">
                                                    @if ($sale->cash_type == 'cash' || $sale->cash_type == 'credit')
                                                        <div class="col-md-12">
                                                            <table class="table">
                                                            @else
                                                                @if ($setting->emi == 'no')
                                                                    <div class="col-md-12">
                                                                        <table class="table">
                                                                        @else
                                                                            <div class="col-md-6">
                                                                                <table class="table"
                                                                                    style="margin-bottom:-10px;">
                                                                @endif
                                                    @endif
                                                    <thead style="border: 0.5pt solid #303030; margin: 0; padding: 0;">
                                                        <th class="text-start fw-700" colspan="5"
                                                            style="padding: 3px!important;">Description</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="5" style="padding: 1px;">
                                                                <p
                                                                    style="line-height: 1.2; font-weight: bold; font-size: 11px;">
                                                                    {{ $setting->description_text }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>

                                                @if ($setting->emi == 'yes')
                                                    @if ($sale->cash_type != 'cash' && $sale->cash_type != 'credit')
                                                        <div class="col-md-6">
                                                            <table
                                                                style="border: 0.5pt solid #303030; border-left: none; margin-bottom: -10px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th
                                                                            style="padding: 12px; border: 0.5pt solid #303030;">
                                                                            Loan No.</th>
                                                                        <th style="padding: 12px; border: 0.5pt solid #303030;"
                                                                            class="text-start">Financier</th>
                                                                        <th
                                                                            style="padding: 12px; border: 0.5pt solid #303030;">
                                                                            IP</th>
                                                                        <th
                                                                            style="padding: 12px; border: 0.5pt solid #303030;">
                                                                            EMI</th>
                                                                        <th
                                                                            style="padding: 12px; border: 0.5pt solid #303030;">
                                                                            Scheme</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="padding: 10px; color: red; border: 0.5pt solid #303030;">
                                                                            {{ $emi->loan_no }}
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; color: red; border: 0.5pt solid #303030;">
                                                                            {{ $emi->financier_name }}
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; color: red; border: 0.5pt solid #303030;">
                                                                            {{ $emi->initial_payment }}
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; color: red; border: 0.5pt solid #303030;">
                                                                            {{ $emi->emi }}
                                                                        </td>
                                                                        <td
                                                                            style="padding: 10px; color: red; border: 0.5pt solid #303030;">
                                                                            {{ $emi->scheme }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                @endif
                                        </div>
                                        @endif


                                        </main>

                                        <!-- Footer -->



                                        <footer class="footer">
                                            <div class="row">
                                                <!-- Receiver Signature Section -->
                                                <div class="col-6 text-left" style="margin-top:92px;">
                                                    <div class="receiver-signature">
                                                        <p style="font-size:15px;"><strong>Receiver
                                                                Signature</strong></p>
                                                    </div>
                                                </div>

                                                <!-- Signature Container Section -->
                                                <div class="col-6 ">
                                                    <div class="signature-container">
                                                        <div class="company-name text-right">
                                                            <p style="font-size:15px; margin-right:45px">
                                                                FOR <strong>{{ $business->company_name }}</strong>
                                                            </p>
                                                        </div>

                                                        <div class="seal-signature-space text-right"
                                                            style="margin-right:60px;">
                                                            @if ($setting->signature == 'yes')
                                                                <img style="width:40%; height: 50px;" id="logo"
                                                                    src="{{ asset('settings_uploads/' . $setting->signature_image) }}"
                                                                    title="MyDailyBill" alt="MyDailyBill" />
                                                            @else
                                                                <div style="width:40%; height: 50px;"></div>
                                                            @endif

                                                        </div>
                                                        <div class="authorized-signatory text-right"
                                                            style="padding-right:38px;">
                                                            <p style="font-size:15px;"><strong>Authorized
                                                                    Signatory</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p style="text-align:center;font-size:15px;font-weight:bold;">
                                                    Thanks For Visiting!!!</p>
                                            </div>
                                        </footer>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice-actions-btn">
                                <div class="invoice-action-btn">
                                    <div class="row">
                                        <!-- <div class="col-xl-12 col-md-3 col-sm-6">
                                                    <a href="javascript:void(0);" class="btn btn-primary btn-send">Send
                                                        Invoice</a>
                                                </div> -->
                                        <div class="col-xl-12 col-md-3 col-sm-6">
                                            <a href="javascript:void(0);"
                                                class="btn btn-secondary btn-print action-print">Print</a>
                                        </div>
                                        <div class="col-xl-12 col-md-3 col-sm-6">
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-download contenttopdf">Download</a>
                                        </div>
                                        <div class="col-xl-12 col-md-3 col-sm-6">
                                            <a href="{{ route('sale.index') }}"
                                                class="btn btn-danger btn-download contenttopdf">Back</a>
                                        </div>
                                        {{-- <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="./app-invoice-edit.html"
                                                    class="btn btn-dark btn-edit">Edit</a>
                                            </div> --}}
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

    <script>
        function numberToWords(num) {
            if (num === 0) return 'zero';

            const belowTwenty = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
                'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            ];
            const tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
            const thousands = ['', 'thousand', 'lakh', 'crore']; // For Indian numbering system

            function convertChunk(number) {
                let str = '';

                if (number >= 100) {
                    str += belowTwenty[Math.floor(number / 100)] + ' hundred ';
                    number %= 100;
                }

                if (number >= 20) {
                    str += tens[Math.floor(number / 10)] + ' ';
                    number %= 10;
                }

                if (number > 0) {
                    str += belowTwenty[number] + ' ';
                }

                return str.trim();
            }

            function convertGroup(number, index) {
                let str = '';
                if (index === 0) { // For numbers less than thousand
                    str += convertChunk(number);
                } else {
                    if (number > 0) {
                        str += convertChunk(number) + ' ' + thousands[index] + ' ';
                    }
                }
                return str.trim();
            }

            let words = '';
            let chunkIndex = 0;

            // Convert the number into Indian numbering system chunks
            while (num > 0) {
                let chunk;
                if (chunkIndex === 0) { // For less than thousand
                    chunk = num % 1000;
                    num = Math.floor(num / 1000);
                } else if (chunkIndex === 1) { // For lakh and below
                    chunk = num % 100;
                    num = Math.floor(num / 100);
                } else { // For crore and above
                    chunk = num % 10000000;
                    num = Math.floor(num / 10000000);
                }
                words = convertGroup(chunk, chunkIndex) + ' ' + words;
                chunkIndex++;
            }
            // Capitalize the first letter of each word
            words = words.trim().replace(/\b\w/g, char => char.toUpperCase());
            return words.trim() + ' only';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const totalAmountElement = document.getElementById('grandTotal');
            const totalAmountInWordsElement = document.getElementById('grandTotalInWords');

            if (totalAmountElement && totalAmountInWordsElement) {
                // Extract and clean the numeric value from the text content
                const totalAmountText = totalAmountElement.innerText.replace(/[^0-9]/g, '').trim();
                const totalAmount = parseFloat(totalAmountText);

                if (!isNaN(totalAmount)) {
                    const totalAmountInWords = numberToWords(totalAmount);
                    totalAmountInWordsElement.innerText = totalAmountInWords;
                } else {
                    totalAmountInWordsElement.innerText = 'Invalid amount';
                }
            } else {
                console.error('Required HTML elements not found.');
            }
        });
    </script>




    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('v2/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('v2/src/plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('v2/layouts/vertical-light-menu/app.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('v2/src/assets/js/apps/invoice-preview.js') }}"></script>
    <script src="{{ asset('v2/src/assets/js/apps/download.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>


</body>

</html>
