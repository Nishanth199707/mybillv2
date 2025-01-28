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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    

    <style>
        html,
        body {
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
            margin: 5px 0;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 10pt;
            }

            .invoice-container {
                width: 210mm;
                height: auto;
                overflow: hidden;
                margin: 0 auto;
                page-break-inside: avoid;
                border: 1px solid #303030;
                margin-bottom: 0;
            }

            .no-print {
                display: none;
            }

            .button-container {
                display: none;
            }
        }

        .button-container {
            width: 20%;
            max-width: 200px;
            margin: auto;
            float: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            gap: 5px;
            padding: 15px;
            margin-top: -10px;
        }

        .button-container .btn {
            width: 100%;
            text-align: center;
            padding: 10px 20px;
            font-size: 14px;
        }

        .btn-print {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .btn-print:hover {
            background-color: #0056b3;
        }

        .btn-download {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .btn-download:hover {
            background-color: #218838;
        }

        .btn-back {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
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
                    <td>{{ $repair_det->name }}</td>
                    <td><strong>Address:</strong></td>
                    <td >{{ $repair->address }}</td>
                    <td><strong>Service No:</strong></td>
                    <td >{{ $repair->service_no }}</td>
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
                      <td> <strong>SIM :</strong> {{ $repair->sim  }} | <strong>SIM No.:</strong> {{ $repair->sim_details }} |</td>
                      <td> <strong>Battery :</strong> {{ $repair->battery  }} | <strong>Battery No.:</strong> {{ $repair->battery_details }}</td>
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
                        <h4>Model</h4>
                        {{ $repair->model }}
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
                <div class="footer-center">
                    <img width="75" height="75" id="pattern" src="{{ asset('pattern/pattern.PNG') }}" title="" alt="pattern" />
                </div>
                <div class="footer-right">
                    <p> <b>Estimated Amount: ₹ {{ $repair->estimated_amount }}</b> </p>
                    <p> <b>Cash Received: ₹ {{ $repair->cash_received }}</b> </p>
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
                    <td >{{ $repair->address }}</td>
                    <td><strong>Service No:</strong></td>
                    <td >{{ $repair->service_no }}</td>
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
                      <td> <strong>SIM :</strong> {{ $repair->sim  }} | <strong>SIM No.:</strong> {{ $repair->sim_details }} |</td>
                      <td> <strong>Battery :</strong> {{ $repair->battery  }} | <strong>Battery No.:</strong> {{ $repair->battery_details }}</td>
                 </tr>
            </table>


            <!-- Estimated Amount Section -->
            <table class="section-table1" border="1">
                <tr>
                    <td>
                        <h4>Date</h4>
                        {{ $repair->date }}
                    </td>
                    <td>
                        <h4>Model</h4>
                        {{ $repair->model }}
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
                <div class="footer-center">
                    <img width="75" height="75" id="pattern" src="{{ asset('pattern/pattern.PNG') }}" title="" alt="pattern" />
                </div>
                <div class="footer-right">
                    <p> <b>Estimated Amount: ₹ {{ $repair->estimated_amount }}</b> </p>
                    <p> <b>Cash Received: ₹ {{ $repair->cash_received }}</b> </p>
                    <p> <b>Estimated Delivery: {{ $repair->estimated_delivery_date }}</b>  </p>
                </div>
            </footer>
        </main>
    </div>

    <!-- Buttons aligned vertically on the right -->
    <div class="button-container">
        <a href="javascript:void(0);" onclick="window.print()" class="btn btn-print action-print">Print</a>
        <a href="javascript:void(0);" class="btn btn-download" onclick="downloadPDF()">Download</a>
        <a href="{{ route('repairs.index') }}" class="btn btn-back">Back</a>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        async function downloadPDF() {
            const { jsPDF } = window.jspdf;
    
            // Reference to the invoice container
            const invoice = document.getElementById('invoice_main');
    
            // Generate a canvas from the invoice HTML
            await html2canvas(invoice, { scale: 2 }).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4'); // Portrait, millimeters, A4 size
    
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
    
                // Calculate dimensions to fit the content
                const imgWidth = canvas.width * 0.264583; // px to mm
                const imgHeight = canvas.height * 0.264583; // px to mm
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
    
                // Add image to PDF
                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth * ratio, imgHeight * ratio);
    
                // Save the PDF
                pdf.save('Service_Invoice.pdf');
            });
        }
    </script>
    
        
    
</body>

</html>
