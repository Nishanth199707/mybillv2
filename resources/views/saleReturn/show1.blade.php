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
    {{--
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    --}}
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('v2/src/assets/css/light/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>



    <style>
        .invoice-container1 {
            width: 210mm;
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
        .table tr {
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


        /* .t3,
        th,
        td { */
        /* border: 0.5pt solid #303030; */
        /* border-collapse: collapse;
        } */

        /* th,
        td {
            text-align: left;
            vertical-align: top
        } */

        body {
            /* border: 0.5pt solid #303030; */
            border-collapse: collapse;
            word-wrap: break-word;
            font-family: 'sans-serif', 'Arial';
            font-size: 11px;
            margin: 0px;
            /*height: 210mm;*/
        }



        .row1 {
            display: flex;
            border-top: none;
            margin: 2px;
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

        .footer {
            padding: 5px;
            border-top: 1px solid #ddd;
            /* Optional, for visual separation */
        }

        .image-container {
            width: 50px;
            height: 50px;
            text-align: center;
        }

        table {
            page-break-inside: auto !important;
        }

        tr {
            position: static !important;
            page-break-inside: avoid !important;
            page-break-after: auto !important;
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
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="middle-content container-xxl p-0">
                <div class="row invoice layout-top-spacing layout-spacing">
                    <div class="col-md-12">
                        <div class="doc-container">
                            <div class="row">
                                <div class="col-xl-9">
                                    <div class="invoice-container">
                                        <div class="invoice-inbox">
                                            <div class="invoice-container1" id="ct">
                                                <!-- Main Content -->
                                                <main>
                                                    <!-- Header -->
                                                    <header>
                                                        <!-- <div class="col-sm-12"
                                                            style="height: fit-content;display: flex;justify-content: center;">
                                                            <div class="col-md-3 image-container">
                                                            <img style="width: 100%;" id="logo"
                                                                src="{{ asset('uploads/' . $business->logo) }}"
                                                                title="MyDailyBill" alt="MyDailyBill" />
                                                            </div>
                                                            
                                                        </div> -->
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <span class=""
                                                                    style="padding-left: 10px"><strong>Inv
                                                                        Date:</strong>
                                                                    {{ $salereturn->return_invoice_date }}</span>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <h3 style="text-align: center;">
                                                                    <strong>{{ $business->company_name }}</strong>
                                                                </h3>
                                                                <p class="lh-base mb-0 text-capitalize"
                                                                    style="text-align: center;">
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
                                                            <div class="col-sm-3"
                                                                style="display: flex;justify-content: flex-end;">
                                                                <span class=""
                                                                    style="margin-right: 10px;"><strong>Invoice
                                                                        No:</strong>
                                                                    {{ $salereturn->return_invoice_date }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="row gy-3">
                                                            <div class="col-12 text-center">
                                                                <h3>Tax Invoice</h3>
                                                            </div>
                                                        </div>
                                                    </header>
                                                    <div class="row gy-3" style="background: whitesmoke;margin: 0px;">
                                                        @if ($setting->shipping_address == 'yes')
                                                        <div class="col-sm-4" style="">
                                                            @else
                                                            <div class="col-sm-8" style="">
                                                                @endif
                                                                <strong>Bill To:</strong>
                                                                <span style="line-height: 1.1;">
                                                                    {{ $party->name }}<br />
                                                                    @if ($party->billing_address_1)
                                                                    {{ $party->billing_address_1 }}<br />
                                                                    @endif
                                                                    @if ($party->billing_address_2)
                                                                    {{ $party->billing_address_2 }},
                                                                    @endif
                                                                    @if ($party->billing_pincode)
                                                                    {{ $party->billing_pincode }}<br>
                                                                    @endif
                                                                    @if ($party->phone_no)
                                                                    Ph: {{ $party->phone_no }}<br />
                                                                    @endif
                                                                    @if (session('gstavailable') == 'yes')

                                                                    @if ($party->gstin)
                                                                    <p><strong>GSTIN:</strong> {{ $party->gstin }}</p>
                                                                    @endif
                                                                    @endif
                                                                </span>
                                                            </div>

                                                            @if ($setting->shipping_address == 'yes')
                                                            <div class="col-sm-4"
                                                                style="display: flex;justify-content: center;">
                                                                <span style="line-height: 1.1;">
                                                                    <strong>Ship To:</strong>
                                                                    {{ $party->name }}<br />
                                                                    @if ($party->shipping_address_1)
                                                                    {{ $party->shipping_address_1 }}<br />
                                                                    @endif
                                                                    @if ($party->shipping_address_2)
                                                                    {{ $party->shipping_address_2 }},
                                                                    @endif
                                                                    @if ($party->billing_pincode)
                                                                    {{ $party->shipping_pincode }}<br />
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            @else
                                                            @endif
                                                            <div class="col-sm-4" style="">
                                                                @if ($setting->purchase_order_date == 'yes')
                                                                <span style="margin-left: 85px;"><strong>PO Date:</strong>
                                                                    {{ $salereturn->purchase_order_date }}</span><br>
                                                                @else
                                                                @endif
                                                                @if ($setting->purchase_order_number == 'yes')
                                                                <span style="margin-left: 85px;"><strong>PO No:</strong>
                                                                    {{ $salereturn->purchase_order_number }}</span><br>
                                                                @else
                                                                @endif
                                                                @if ($setting->vehicle_no == 'yes')
                                                                <span style="margin-left: 85px;"><strong>Vehicle
                                                                        No:</strong>
                                                                    {{ $salereturn->vehicle_no }}</span><br>
                                                                @else
                                                                @endif

                                                                <span style="margin-left: 85px;"><strong>Payment Mode:
                                                                    </strong>{{ strtoupper($salereturn->cash_type) }}</span><br>

                                                            </div>
                                                        </div>
                                                        <div class="table-responsive ">


                                                            <table class="table table-bordered">
                                                                <thead>


                                                                    <tr class="bg-light">
                                                                        <th class="t3 col-2 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            Particulars</th>
                                                                        <th class="t3 col-1 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            HSN CODE</th>
                                                                        <th class="t3 col-2 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            RATE</th>
                                                                        <th class="t3 col-1 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            QTY</th>
                                                                        <th class="t3 col-2 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            DIS</th>
                                                                        <th class="t3 col-2 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            AMOUNT</th>
                                                                        @if (session('gstavailable') == 'yes')
                                                                        <th class="t3 col-2 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            GST %</th>
                                                                        @endif
                                                                        <th class="t3 col-2 text-center"
                                                                            style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                                                            TOTAL</th>
                                                                    </tr>

                                                                </thead>
                                                                <tbody style="height:250px !important">
                                                                    @foreach ($saledetail as $key => $val)
                                                                    <tr>
                                                                        <td style="text-align: center;" class="col-2">
                                                                            {{ $val->item_description }}
                                                                        </td>
                                                                        <td style=";text-align: center;"
                                                                            class="col-1 text-center">
                                                                            {{ $val->hsn_code }}
                                                                        </td>
                                                                        <td style="text-align: center;"
                                                                            class="col-2 text-center">
                                                                            {{ $val->rpqty }}
                                                                        </td>


                                                                        <td style="text-align: center;"
                                                                            class="col-1 text-center">
                                                                            {{ $val->qty }}
                                                                        </td>

                                                                        <td style="text-align: center;"
                                                                            class="col-2 text-center">
                                                                            {{ $val->discount }}
                                                                        </td>
                                                                        <td style="text-align: center;"
                                                                            class="col-2 text-center">
                                                                            {{ $val->amount }}
                                                                        </td>
                                                                        @if (session('gstavailable') == 'yes')
                                                                        <td style="text-align: center;"
                                                                            class="col-2 text-center">
                                                                            {{ $val->gst }}
                                                                        </td>
                                                                        @endif
                                                                        <td style="text-align: center;"
                                                                            class="col-2 text-end">
                                                                            {{ $val->total_amount }}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        @if (session('gstavailable') == 'yes')
                                                        <div class="row1">
                                                            <div class="col-md-6" style="padding: 2px;">


                                                                <table class="table taxable" style="margin: 0px;">
                                                                    <thead style="border: 0.5pt solid#303030">
                                                                        <tr>
                                                                            <th class="text-center" style="padding: 5px;">
                                                                                Rate</th>
                                                                            <th class="text-center"
                                                                                style="padding: 5px; width:90px;">
                                                                                Taxable
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
                                                                        @if ($salereturn->tax_amount_28_cgst)
                                                                        <tr class="bg-light">
                                                                            <td class="text-end">28%</td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->taxable28Amount }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->tax_amount_28_cgst }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->tax_amount_28_sgst }}
                                                                            </td>
                                                                            <td class="text-end">0</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if ($salereturn->tax_amount_18_cgst)
                                                                        <tr class="bg-light">
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                18%
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                {{ $salereturn->taxable18Amount }}
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                {{ $salereturn->tax_amount_18_cgst }}
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                {{ $salereturn->tax_amount_18_sgst }}
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">0
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                        @if ($salereturn->tax_amount_12_cgst)
                                                                        <tr class="bg-light">
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                12%
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                {{ $salereturn->taxable12Amount }}
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                {{ $salereturn->tax_amount_12_cgst }}
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">
                                                                                {{ $salereturn->tax_amount_12_sgst }}
                                                                            </td>
                                                                            <td class="text-end" style="padding: 4px;">0
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                        @if ($salereturn->tax_amount_5_cgst)
                                                                        <tr class="bg-light">
                                                                            <td class="text-end">5%</td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->taxable5Amount }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->tax_amount_5_cgst }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->tax_amount_5_sgst }}
                                                                            </td>
                                                                            <td class="text-end">0</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if ($salereturn->tax_amount_3_cgst)
                                                                        <tr class="bg-light">
                                                                            <td class="text-end">3%</td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->taxable3Amount }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->tax_amount_3_cgst }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->tax_amount_3_sgst }}
                                                                            </td>
                                                                            <td class="text-end">0</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if ($salereturn->tax_amount_0)
                                                                        <tr class="bg-light">
                                                                            <td class="text-end">0%</td>
                                                                            <td class="text-end">
                                                                                {{ $salereturn->taxable0Amount }}
                                                                            </td>
                                                                            <td class="text-end" colspan="3">0</td>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td class="text-end fw-700" style="padding: 4px;">
                                                                                Total</td>
                                                                            <td class="text-end fw-700" style="padding: 4px;">
                                                                                {{ $salereturn->taxable18Amount }}
                                                                            </td>
                                                                            <td class="text-end fw-700" style="padding: 4px;">
                                                                                {{ $salereturn->tax_amount_18_cgst }}
                                                                            </td>
                                                                            <td class="text-end fw-700" style="padding: 4px;">
                                                                                {{ $salereturn->tax_amount_18_sgst }}
                                                                            </td>
                                                                            <td class="text-end fw-700" style="padding: 4px;">
                                                                                0
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6" style="padding: 2px;margin: 0px;">
                                                                <table class="table">
                                                                    <tr class="bg-light">
                                                                        <td class="text-end"
                                                                            style="border: 0.5pt solid #303030;">
                                                                            <strong>Sub Total:</strong>
                                                                        </td>
                                                                        <td class="text-end"
                                                                            style="border: 0.5pt solid #303030;">
                                                                            Rs.
                                                                            {{ $salereturn->totalAmountDisplay }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="bg-light">
                                                                        <td class="text-end"
                                                                            style="padding: 4px;border: 0.5pt solid #303030;">
                                                                            <strong>Total Tax:</strong>
                                                                        </td>
                                                                        <td class="text-end"
                                                                            style="padding: 4px;border: 0.5pt solid #303030;">
                                                                            Rs.
                                                                            {{ $salereturn->tax_amount }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-end"
                                                                            style="padding: 4px;border: 0.5pt solid #303030;">
                                                                            <strong>Grand Total:</strong>
                                                                        </td>
                                                                        <td class="text-end" id="grandTotal"
                                                                            style="padding: 4px;border: 0.5pt solid #303030;">
                                                                            Rs.
                                                                            {{ $salereturn->net_amount }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="row1">
                                                            <div class="col-md-6" style="padding: 2px;">

                                                            </div>
                                                            <div class="col-md-6" style="padding: 2px;margin: 0px;">
                                                                <table class="table">
                                                                    <tr class="bg-light">
                                                                        <td class="text-end"
                                                                            style="border: 0.5pt solid #303030;">
                                                                            <strong>Sub Total:</strong>
                                                                        </td>
                                                                        <td class="text-end"
                                                                            style="border: 0.5pt solid #303030;">
                                                                            Rs.
                                                                            {{ $salereturn->totalAmountDisplay }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-end"
                                                                            style="padding: 4px;border: 0.5pt solid #303030;">
                                                                            <strong>Grand Total:</strong>
                                                                        </td>
                                                                        <td class="text-end" id="grandTotal"
                                                                            style="padding: 4px;border: 0.5pt solid #303030;">
                                                                            Rs.
                                                                            {{ $salereturn->net_amount }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <span class="inline"
                                                                        style=" display: inline;font-weight:bold">Rupees.
                                                                        :</span>
                                                                    <span class="text-start" id="grandTotalInWords"
                                                                        style="display: inline;font-weight:bold;">
                                                                    </span>
                                                                </td>

                                                            </tr>
                                                        </table>

                                                        @if ($setting->description == 'yes')
                                                        <div class="row2" style="margin-top:5px; ">


                                                            <div class="col-md-12">
                                                                <table class="table">


                                                                    <thead style="border: 0.5pt solid #303030;margin:0;padding:0;">

                                                                        <th class="text-start fw-700" colspan="5"
                                                                            style="padding:3px!important;">
                                                                            Description</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="5" style="padding: 1px;">

                                                                                <p
                                                                                    style="line-height:1.2;font-weight:bold;font-size:11px;">
                                                                                    {{ $setting->description_text }}
                                                                                </p>

                                                                                {{-- <img style=""
                                                                                                        class="img-responsive"
                                                                                                        id=""
                                                                                                        src="{{ asset('uploads/des/des.PNG' ) }}"
                                                                                title="" alt="" />
                                                                                --}}
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            @else
                                                            @endif



                                                        </div>
                                                </main>

                                                <!-- Footer -->



                                                <footer class="footer">
                                                    <div class="row">
                                                        <!-- Receiver Signature Section -->
                                                        <div class="col-6 text-left" style="margin-top:85px;">
                                                            <div class="receiver-signature">
                                                                <span style="font-size:15px;"><strong>Receiver
                                                                        Signature</strong></span>
                                                            </div>
                                                        </div>

                                                        <!-- Signature Container Section -->
                                                        <div class="col-6 ">
                                                            <div class="signature-container">
                                                                <div class="company-name text-right">
                                                                    <p style="font-size:15px; margin-right:45px">
                                                                        FOR
                                                                        <strong>{{ $business->company_name }}</strong>
                                                                    </p>
                                                                </div>
                                                                <div style="display: flex;justify-content: flex-end;">
                                                                    <div class="seal-signature-space text-right"
                                                                        style="margin-right:60px;width:50px;hight:50px;">
                                                                        @if ($setting->signature == 'yes')
                                                                        <img style="width:100%;" id="logo"
                                                                            src="{{ asset('settings_uploads/' . $setting->signature_image) }}"
                                                                            title="MyDailyBill" alt="MyDailyBill" />
                                                                        @else
                                                                        <div style="width:40%; height: 50px;"></div>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                                <div class="authorized-signatory text-right"
                                                                    style="padding-right:38px;">
                                                                    <span style="font-size:15px;"><strong>Authorized
                                                                            Signatory</strong></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span style="text-align:center;font-size:15px;font-weight:bold;">
                                                            Thanks For Visiting!!!</span>
                                                    </div>
                                                </footer>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
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