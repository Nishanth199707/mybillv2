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
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .invoice-container, .invoice-container1 {
            width: 100%;
            max-width: 800px;
            margin: auto;
            border: 0.5pt solid #303030;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
            margin-bottom: 10px; /* Reduced space between invoices */
        }

        .info-table, .info-table1 {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th, .info-table td,
        .info-table1 th, .info-table1 td {
            border: 0.5pt solid #303030;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .section-table, .section-table1 {
            width: 100%;
            border-collapse: collapse;
        }

        .section-table td,
        .section-table1 td {
            border: 0.5pt solid #303030;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        body {
            display: flex;
            flex-direction: column;
            word-wrap: break-word;
            font-size: 11px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            border-top: 1px solid #ddd;
            page-break-after: avoid;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            text-align: right;
        }

        .dashed-border {
            border-top: 1px dashed #303030;
            margin: 5px 0; /* Space around the dashed border */
        }

        .logo {
            text-align: center;
            margin-bottom: 20px; /* Space below the logo */
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 10pt;
            }

            .invoice-container, .invoice-container1 {
                width: 210mm; /* A4 width */
                height: auto;
                overflow: hidden;
                margin: 0 auto;
                page-break-inside: avoid; /* Prevent breaks inside this div */
                border: 1px solid #303030;
                margin-bottom: 0; /* No margin at bottom for printing */
            }

            footer {
                page-break-inside: avoid; /* Avoid breaks inside footer */
            }

            .no-print {
                display: none; /* Hide the print button in print mode */
            }
        }

        .print-button {
            margin: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <button class="print-button no-print" onclick="window.print()">Print Invoice</button>

    <div class="container-fluid invoice-container" id="invoice_main">
        <main style="border:1px solid black;">
            <div class="logo">
                <h3 class="text-center"> {{$business->company_name}}</h3>

                {{-- <img style="width: 100%;" height="100" id="logo"
                src="{{ asset('uploads/' . $business->logo) }}" title="MyDailyBill" alt="MyDailyBill" /> --}}
    </div>
            <h5 class="text-center">Mobile Service Acknowledgment</h5>

            <!-- Customer Information Section -->
            <table class="info-table">
                <tr>
                    <td><strong>Customer Name:</strong></td>
                    <td>{{ $repair->customer_name }}</td>
                    <td><strong>Address:</strong></td>
                    <td colspan="3">{{ $repair->address }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $repair->phone }}</td>
                    <td><strong>IMEI:</strong></td>
                    <td>{{ $repair->imei }}</td>
                    <td><strong>PIN:</strong></td>
                    <td>{{ $repair->mobile_pin }}</td>
                </tr>
            </table>

            <!-- Complaint/Remark Section -->
            <h4>Complaint/Remark</h4>
            <table class="section-table">
                <tr>
                    <td>{{ $repair->complaint_remark }}</td>
                </tr>
            </table>

            <!-- Phone Condition Section -->
            <h4>Phone Condition</h4>
            <table class="info-table1">
                 <tr>
                      <td> <strong>SIM :</strong> {{ $repair->sim ? 'Yes' : 'No' }} | <strong>SIM No.:</strong> {{ $repair->sim_details }} |</td>
                      <td> <strong>Battery :</strong> {{ $repair->battery ? 'Yes' : 'No' }} | <strong>Battery No.:</strong> {{ $repair->battery_details }}</td>
                 </tr>
            </table>

            <!-- Estimated Amount Section -->
            <table class="section-table">
                <tr>
                    <td>
                        <h4>Date</h4>
                        {{ $repair->date }}
                    </td>
                    <td>
                        <h4>Received By</h4>
                        {{ $repair->received_by }}
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <footer class="footer">
                <div class="footer-left">
                    <p>________________________</p>
                    <p>Customer Signature</p>
                </div>
                <div class="footer-right">
                    <p> <b>Estimated Amount: ₹ {{ number_format($repair->estimated_amount, 2) }}</b> </p>
                    <p> <b>Estimated Delivery: {{ $repair->estimated_delivery_date }}</b>  </p>
                </div>
            </footer>
        </main>

        <div class="dashed-border"></div> <!-- Dashed border here -->

        <main style="border:1px solid black;">
            <div class="logo">
                <div class="logo">
                    <h3 class="text-center"> {{$business->company_name}}</h3>
                    {{-- <img style="width: 100%;" height="100" id="logo"
                    src="{{ asset('uploads/' . $business->logo) }}" title="MyDailyBill" alt="MyDailyBill" /> --}}
        </div>
       </div>
            <h5 class="text-center">Mobile Service Acknowledgment</h5>

            <!-- Customer Information Section -->
            <table class="info-table1">
                <tr>
                    <td><strong>Customer Name:</strong></td>
                    <td>{{ $repair->customer_name }}</td>
                    <td><strong>Address:</strong></td>
                    <td colspan="3">{{ $repair->address }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $repair->phone }}</td>
                    <td><strong>IMEI:</strong></td>
                    <td>{{ $repair->imei }}</td>
                    <td><strong>PIN:</strong></td>
                    <td>{{ $repair->mobile_pin }}</td>
                </tr>
            </table>

            <!-- Complaint/Remark Section -->
            <h4>Complaint/Remark</h4>
            <table class="section-table1">
                <tr>
                    <td>{{ $repair->complaint_remark }}</td>
                </tr>
            </table>

            <!-- Phone Condition Section -->
            <h4>Phone Condition</h4>
            <table class="info-table1">
                 <tr>
                      <td> <strong>SIM :</strong> {{ $repair->sim ? 'Yes' : 'No' }} | <strong>SIM No.:</strong> {{ $repair->sim_details }} |</td>
                      <td> <strong>Battery :</strong> {{ $repair->battery ? 'Yes' : 'No' }} | <strong>Battery No.:</strong> {{ $repair->battery_details }}</td>
                 </tr>
            </table>


            <!-- Estimated Amount Section -->
            <table class="section-table">
                <tr>
                    <td>
                        <h4>Date</h4>
                        {{ $repair->date }}
                    </td>
                    <td>
                        <h4>Received By</h4>
                        {{ $repair->received_by }}
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <footer class="footer">
                <div class="footer-left">
                    <p> Received in Good Condition</p>
                    <p>________________________</p>
                    <p>Customer Signature</p>
                </div>
                <div class="footer-right">
                    <p> <b>Estimated Amount: ₹ {{ number_format($repair->estimated_amount, 2) }}</b> </p>
                    <p> <b>Estimated Delivery: {{ $repair->estimated_delivery_date }}</b>  </p>
                </div>
            </footer>
        </main>
    </div>

</body>

</html>
