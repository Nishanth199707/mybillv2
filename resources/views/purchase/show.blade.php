<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bill/favicon.png" rel="icon" />
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/stylesheet.css') }}" />

    <style>   
            .invoice-container {
                position: relative;
                overflow: hidden; 
            }
            .invoice-container::before {
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

    <div class="container-fluid invoice-container" id="invoice_main">
        <!-- Header -->
        <header>
            <div class="row gy-3">
                <div class="col-12 text-center">
                    <h2 class="text-4">Purchase Invoice</h2>
                </div>
                <div class="col-sm-3">
                    <img style="width: 100%;" id="logo" src="{{asset('uploads/' . $business->logo)}}" title="MyDailyBill" alt="MyDailyBill" />
                </div>
                <div class="col-sm-7">
                    <h4 class="text-4 mb-1">{{ $business->company_name }}.</h4>
                    <p class="lh-base mb-0 text-capitalize">
                        {{ $business->address . ',' . $business->city . '-' . $business->pincode . ',' . $business->state . ',' . $business->country }}
                    </p>
                </div>
                <div class="col-sm-2">
                    <strong>Purchase No:</strong> {{ $purchase->purchase_no }}
                </div>
            </div>
            <hr>
        </header>

        <!-- Main Content -->
        <main>
            <div class="row gy-3">
                <div class="col-sm-4">
                    <p class="mb-1"><strong>Order Date:</strong> {{ $purchase->purchase_date }}</p>
                    <p class="mb-1"><strong>Purchase Date:</strong> {{ $purchase->purchase_date }}</p>
                </div>
                <div class="col-sm-4"> <strong>Bill To:</strong>
                    <address>
                        {{ $party->name }}<br />
                        {{ $party->billing_address_1 }}<br />
                        {{ $party->billing_address_2 }}<br />
                        {{ $party->billing_pincode }}<br />
                    </address>
                </div>
                <div class="col-sm-4"> <strong>Ship To:</strong>
                    <address>
                        {{ $party->name }}<br />
                        {{ $party->shipping_address_1 }}<br />
                        {{ $party->shipping_address_2 }}<br />
                        {{ $party->shipping_pincode }}<br />
                    </address>
                </div>
            </div>

            <!-- Table for Purchase Details -->
            <div class="table-responsive">
                <table class="table border mb-0">
                    <thead>
                        <tr class="bg-light">
                            <td class="col-3"><strong>Particulars</strong></td>
                            <td class="col-2 text-center"><strong>HSN Code</strong></td>
                            <td class="col-2 text-center"><strong>Rate Per Qty</strong></td>
                            <td class="col-1 text-center"><strong>QTY</strong></td>
                            <td class="col-2 text-center"><strong>GST Rate</strong></td>
                            <td class="col-2 text-end"><strong>TOTAL</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchasedetail as $key => $val)
                        <tr>
                            <td class="col-3">{{ $val->item_description }}</td>
                            <td class="col-2 text-center">{{ $val->hsn_code }}</td>
                            <td class="col-2 text-center">{{ $val->rpqty }}</td>
                            <td class="col-1 text-center">{{ $val->qty }}</td>
                            <td class="col-2 text-center">{{ $val->gst }}</td>
                            <td class="col-2 text-end">{{ $val->total_amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table for Sub Total, Tax, and Grand Total -->
            <div class="table-responsive">
                <table class="table border border-top-0 mb-0">
                    <tr class="bg-light">
                        <td class="text-end"><strong>Sub Total:</strong></td>
                        <td class="col-sm-2 text-end">Rs. {{ $purchase->totalAmountDisplay }}</td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end"><strong>Total Tax:</strong><br>
                        @if($purchase->tax_amount_18_cgst)
                            9% CGST Rs. {{ $purchase->tax_amount_18_cgst }}<br>
                            9% SGST Rs. {{ $purchase->tax_amount_18_sgst }}<br>
                        @endif
                        @if($purchase->tax_amount_12_cgst)
                            6% CGST Rs. {{ $purchase->tax_amount_12_cgst }}<br>
                            6% SGST Rs. {{ $purchase->tax_amount_12_sgst }}<br>
                        @endif
                        @if($purchase->tax_amount_5_cgst)
                            2.5% CGST Rs. {{ $purchase->tax_amount_5_cgst }}<br>
                            2.5% SGST Rs. {{ $purchase->tax_amount_5_sgst }}<br>
                        @endif
                        </td>
                        <td class="col-sm-2 text-end">Rs. {{ $purchase->tax_amount }}</td>
                    </tr>

                    <tr class="bg-light">
                        <td class="text-end"><strong>Grand Total:</strong></td>
                        <td class="col-sm-2 text-end">Rs. {{ $purchase->net_amount }}</td>
                    </tr>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-5">
            <div class="text-end mb-4">
                <img id="logo" src="{{asset('uploads/' . $business->logo)}}" title="MyDailyBill" alt="MyDailyBill" width="50"/><br>
                <div class="lh-1 text-black-50">Thank You!</div>
                <div class="lh-1 text-black-50 text-0"><small>For Shopping with us</small></div>
            </div>

            <hr class="my-2">
            <div class="text-center">
                <div class="btn-group btn-group-sm d-print-none"> 
                    <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print & Download</a> 
                </div>
            </div>
        </footer>
    </div>

</body>

</html>
