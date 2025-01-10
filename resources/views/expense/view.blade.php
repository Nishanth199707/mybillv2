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
                    <h2 class="text-4">Expense</h2>
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
                    <strong>Expense Ref:</strong> {{ $expense->expense_ref }}
                    <strong>Payment Ref:</strong> {{ $payment->invoice_no }}
                </div>
            </div>
            <hr>
        </header>

        <!-- Main Content -->
        <main>
            <div class="row gy-3">
                <div class="col-sm-4">
                    <p class="mb-1"><strong>Expense Date:</strong> {{ $expense->dateofexpense }}</p>
                </div>
            </div>

            <!-- Table for Purchase Details -->
            <div class="table-responsive">
                <table class="table border mb-0">
                    <thead>
                        <tr class="bg-light">

                            <td class="col-2 text-center"><strong>Expense Type</strong></td>
                            <td class="col-2 text-center"><strong>Expense Name</strong></td>
                            <td class="col-2 text-center"><strong>Description</strong></td>
                            <td class="col-1 text-center"><strong>Amount</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expensedetails as $key => $val)
                        <tr>
                            <td class="col-2 text-center">{{ $val->name }}</td>
                            <td class="col-2 text-center">{{ $val->expense_name }}</td>
                            <td class="col-2 text-center">{{ $val->description }}</td>
                            <td class="col-1 text-center">{{ $val->price }}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-light">
                            <td></td>
                            <td></td>
                            <td class="text-center"><strong>Grand Total:</strong></td>
                            <td class="col-sm-2 text-center">Rs. {{ $expense->amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-5">
            <div class="text-end mb-4">
                <img id="logo" src="{{asset('uploads/' . $business->logo)}}" title="MyDailyBill" alt="MyDailyBill" width="50"/><br>
                <div class="lh-1 text-black-50">Thank You!</div>
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
