<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bill/favicon.png" rel="icon" />
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts
======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

    <!-- Stylesheet
======================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/stylesheet.css') }}" />

</head>

<body>

    <div class="container-fluid invoice-container" id="invoice_main">
        <!-- Header -->
        <header>
            <div class="row gy-3">
                <div class="col-12 text-center">
                    <h2 class="text-4">Tax Invoice</h4>
                </div>
                <div class="col-sm-3">
                    <img style="width: 100%;" id="logo" src="{{asset('uploads/' . $business->logo)}}" title="MyDailyBill" alt="MyDailyBill" />
                </div>
                <div class="col-sm-7">
                    <h4 class="text-4 mb-1">{{ $business->company_name}}.</h4>
                    <p class="lh-base mb-0 text-capitalize">
                        {{ $business->address.','.$business->city.'-'.$business->pincode.','.$business->state.','.$business->country }}
                    </p>
                </div>
                <div class="col-sm-2">
                    <strong>Invoice No:</strong> {{ $sale->invoice_no }}
                </div>
            </div>
            <hr>
        </header>

        <!-- Main Content -->

        <main>
            <div class="row gy-3">
                <div class="col-sm-4">
                    <!-- <p class="mb-1"><strong>Order ID:</strong> OD223244238</p> -->
                    <p class="mb-1"><strong>Order Date:</strong> {{ $sale->invoice_date }}</p>
                    <p class="mb-1"><strong>Invoice Date:</strong> {{ $sale->invoice_date }}</p>
                    <!-- <p class="mb-1"><strong>PAN:</strong> AGGC30K44E</p> -->
                </div>
                <div class="col-sm-4"> <strong>Bill To:</strong>
                    <address>
                        {{ $party->name }}<br />
                        @if($party->billing_address_1){{ $party->billing_address_1 }}<br />@endif
                        @if($party->billing_address_2){{ $party->billing_address_2 }}<br />@endif
                        @if($party->billing_pincode){{ $party->billing_pincode }}<br />@endif
                    </address>
                </div>
                <div class="col-sm-4"> <strong>Ship To:</strong>
                    <address>
                        {{ $party->name }}<br />
                        @if($party->shipping_address_1){{ $party->shipping_address_1 }}<br />@endif
                        @if($party->shipping_address_2){{ $party->shipping_address_2 }}<br />@endif
                        @if($party->billing_pincode){{ $party->shipping_pincode }}<br />@endif
                    </address>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table border mb-0">
                    <thead>
                        <tr class="bg-light">
                            <td class="col-3"><strong>Particulars</strong></td>
                            <!-- <td class="col-2 text-center"><strong>HSN Code</strong></td> -->
                            <td class="col-2 text-center"><strong>Rate Per Qty</strong></td>
                            <td class="col-1 text-center"><strong>QTY</strong></td>
                            <!-- <td class="col-2 text-center"><strong>Amount</strong></td> -->
                            <!-- <td class="col-2 text-center"><strong>GST Rate</strong></td> -->
                            <td class="col-2 text-end"><strong>TOTAL</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saledetail as $key => $val)
                        <tr>
                            <td class="col-3">{{ $val->item_description}}</td>
                            <!-- <td class="col-2 text-center">{{ $val->hsn_code}}</td> -->
                            <td class="col-2 text-center">{{ $val->rpqty}}</td>
                            <td class="col-1 text-center">{{ $val->qty}}</td>
                            <!-- <td class="col-1 text-center">{{ $val->amount }}</td> -->
                            <!-- <td class="col-2 text-center">{{ $val->gst}}</td> -->
                            <td class="col-2 text-end">{{ $val->total_amount}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table border border-top-0 mb-0">


                    <!-- <tr class="bg-light">
                    <td class="text-end border-end-0 mb-0 pb-0" colspan="5" style="border-bottom:0px"></td>
                        <td class="text-center fw-700">Taxable</td>
                        <td class="text-center fw-700">CGST</td>
                        <td class="text-center fw-700">SGST</td>
                        <td class="text-center fw-700">IGST</td>
                        <td class="text-end"><strong>Sub Total:</strong></td>
                        <td class="col-sm-2 text-end">Rs. {{ $sale->net_amount }}</td>
                    </tr> -->


                    <tr class="bg-light">
                        <td class="text-end" colspan="5"></td>

                        <td class="text-end"><strong>Grand Total:</strong></td>
                        <td class="text-end">Rs. {{ $sale->net_amount }}</td>
                    </tr>
                </table>
            </div>
        </main>
        <!-- Footer -->
        <footer class="mt-5">


            <div class="text-end mb-4">
            <img style="width: 100%;" height="100" id="logo" src="{{asset('uploads/' . $business->signature)}}" title="MyDailyBill" alt="MyDailyBill" />
                <div class="lh-1 text-black-50">Thank You!</div>
                <div class="lh-1 text-black-50 text-0"><small>For Shopping with us</small></div>
            </div>


            <hr class="my-2">
            <div class="text-center">
                <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="bx bx-print"></i> Print &
                        Download</a><a href="{{ route('sale.create') }}" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-solid fa-cart-shopping"></i> Add New Sale</a> </div>
            </div>
        </footer>
    </div>
    <!-- Container -->
    <!-- <div class="container-fluid invoice-container">
        <header>
            <div class="row gy-3">
                <div class="col-12 text-center">
                    <h2 class="text-4">Tax Invoice</h4>
                </div>
                <div class="col-sm-3">
                    <img id="logo" src="bill/logo.png" title="Koice" alt="Koice" />
                </div>
                <div class="col-sm-7">
                    <h4 class="text-4 mb-1">Sold By: Koice Inc.</h4>
                    <p class="lh-base mb-0">Ship-from Address: Koice Inc, 2705 N. Enterprise St, Orange, CA 92865</p>
                </div>
                <div class="col-sm-2">
                    <strong>Invoice No:</strong> 16835
                </div>
            </div>
            <hr>
        </header>

        <main>
            <div class="row gy-3">
                <div class="col-sm-4">
                    <p class="mb-1"><strong>Order ID:</strong> OD223244238</p>
                    <p class="mb-1"><strong>Order Date:</strong> 05/12/2022</p>
                    <p class="mb-1"><strong>Invoice Date:</strong> 05/12/2022</p>
                    <p class="mb-1"><strong>PAN:</strong> AGGC30K44E</p>
                    <p><strong>CIN:</strong> U5260910KA2017PTC0306</p>
                </div>
                <div class="col-sm-4"> <strong>Bill To:</strong>
                    <address>
                        Smith Rhodes<br />
                        15 Hodges Mews, High Wycombe<br />
                        HP12 3JL<br />
                        United Kingdom
                    </address>
                </div>
                <div class="col-sm-4"> <strong>Ship To:</strong>
                    <address>
                        Smith Rhodes<br />
                        15 Hodges Mews, High Wycombe<br />
                        HP12 3JL<br />
                        United Kingdom
                    </address>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table border mb-0">
                    <thead>
                        <tr class="bg-light">
                            <td class="col-5"><strong>Product</strong></td>
                            <td class="col-1 text-center"><strong>QTY</strong></td>
                            <td class="col-2 text-center"><strong>Price</strong></td>
                            <td class="col-2 text-center"><strong>Discount</strong></td>
                            <td class="col-2 text-end"><strong>Total</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-5">
                                NUUVO C11 2023 (Cool Blue, 128 GB)
                                <p class="text-0 text-black-50 lh-base mb-0">Warranty: 1 Year Warranty for Mobile and 6
                                    Months for Accessories</p>
                                <p class="text-1 mb-0">1. [IMEI/Serial No: 862065058646712 ]</p>
                            </td>
                            <td class="col-1 text-center">1</td>
                            <td class="col-2 text-center">$299</td>
                            <td class="col-2 text-center">$25.00</td>
                            <td class="col-2 text-end">$274.00</td>
                        </tr>
                        <tr>
                            <td class="col-5">
                                Flip Cover for NUUVO C11 2023
                                <p class="text-0 text-black-50 lh-base mb-0">Brown, Pack of: 1</p>
                            </td>
                            <td class="col-1 text-center">1</td>
                            <td class="col-2 text-center">$3</td>
                            <td class="col-2 text-center">$0.00</td>
                            <td class="col-2 text-end">$3.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table border border-top-0 mb-0">
                    <tr class="bg-light">
                        <td class="text-end"><strong>Sub Total:</strong></td>
                        <td class="col-sm-2 text-end">$277.00</td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end"><strong>Tax:</strong></td>
                        <td class="col-sm-2 text-end">$15.00</td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end"><strong>Grand Total:</strong></td>
                        <td class="col-sm-2 text-end">$292.00</td>
                    </tr>
                </table>
            </div>
        </main>
        <footer class="mt-5">


            <div class="text-end mb-4">
                <img id="logo" src="bill/logo-sm.png" title="Koice" alt="Koice" /><br>
                <div class="lh-1 text-black-50">Thank You!</div>
                <div class="lh-1 text-black-50 text-0"><small>For Shopping with us</small></div>
            </div>

            <p class="text-0 mb-0"><strong>Returns Policy:</strong> At Koice we try to deliver perfectly each and every
                time. But in the off-chance that you need to return the item, please do so with the original Brand
                box/price
                tag, original packing and invoice without which it will be really difficult for us to act on your
                request. Please help us in helping you. Terms and conditions apply.</p>
            <hr class="my-2">
            <p class="text-center">Helpline: 1800 222 9888</p>
            <div class="text-center">
                <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()"
                        class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print &
                        Download</a> </div>
            </div>
        </footer>
    </div> -->
</body>

</html>
