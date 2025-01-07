<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bill/favicon.png" rel="icon" />
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900'
        type='text/css'>

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('bill/stylesheet.css') }}" />

    <style>
        .invoice-container {
            width: 100%;
            /* Make container full width */
            max-width: 800px;
            /* Optional: set a maximum width */
            margin: auto;
            /* Center-align the container */
            border: 0.5pt solid #303030;
            padding: 20px;
            box-sizing: border-box;
            /* Include padding and border in width */
        }

        .table {
            width: 100%;
            /* Make table full width */
            border-collapse: collapse;
            /* Ensure borders don't double up */
            table-layout: fixed;
            /* Ensure columns are of fixed width */
        }

        .table th,
        .table td {
            border: 0.5pt solid #303030;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        /* Example column widths */
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
            border: 0.5pt solid #303030;
            border-collapse: collapse;
        }

        th,
        td {
            /*padding: 5px;*/
            text-align: left;
            vertical-align: top
        }

        body {
            border: 0.5pt solid #303030;
            border-collapse: collapse;
            word-wrap: break-word;
            font-family: 'sans-serif', 'Arial';
            font-size: 11px;
            /*height: 210mm;*/
        }


        .watermarked {
            position: relative;
            padding: 20px;
            /* Adjust padding as needed */
            background: white;
            /* Ensure background is not transparent */
        }

        .watermarked::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('http://127.0.0.1:8000/uploads/clogo_1725429193.jpg') no-repeat center center;
            background-size: contain;
            opacity: 0.1;
            /* Adjust opacity for visibility */
            pointer-events: none;
            /* Ensure watermark does not interfere with interactions */
            z-index: -1;
            /* Ensure watermark is behind content */
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

        .footer {
            padding: 20px;
            border-top: 1px solid #ddd;
            /* Optional, for visual separation */
        }



        @media print {
    body {
        margin: 0;
        padding: 0;
        font-size: 10pt; /* Adjust base font size */
    }

    .invoice-container {
        width: 210mm; /* A4 width */
        height: auto; /* Let height be auto */
        overflow: hidden; /* Prevent overflow */
        margin: 0 auto; /* Center the content */
        page-break-inside: avoid; /* Prevent breaks inside this div */
        border: 1px solid #303030; /* Optional: add border for clarity */
    }

    header, main, footer {
        page-break-inside: avoid; /* Avoid breaks inside sections */
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        border: 1px solid #303030;
    }

    /* Prevent page breaks for rows */
    .row1, .row2 {
        page-break-after: avoid; 
    }

    /* Hide elements not needed for print */
    .no-print {
        display: none;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    h2, h3, h4, p {
        margin: 0;
    }

    /* Prevent margins on body */
    @page {
        border: 1px solid #fff;
    }
}
    </style>
</head>

<body>
    <button class="btn btn-secondary" onclick="window.location.href='{{ route('quotations.index') }}'">Back</button>
    <div class="container-fluid invoice-container watermarked" id="invoice_main">
        <!-- Header -->
        

        <!-- Main Content -->
        <main>
        <header>
            <div class="row gy-3" style="width: 99.9%!important;margin-left:.2px;">
                <div class="col-12 text-center">
                    <h2 class=" text-4">Quotation</h2>
                </div>
                <div class="col-sm-3" style="border: 0.5pt solid #303030;border-right:none;padding:2px;">
                    <img style="width: 100%;" height="100" id="logo"
                        src="{{ asset('uploads/' . $business->logo) }}" title="MyDailyBill" alt="MyDailyBill" />
                </div>
                <div class="col-sm-7" style="border: 0.5pt solid #303030;padding:10px;">
                    <h3 class="mb-1"><strong>{{ $business->company_name }}</strong></h3>
                    <p class="lh-base mb-0 text-capitalize">
                        <strong>
                            {{ $business->address . ',' . $business->city . '-' . $business->pincode . ',' . $business->state . ',' . $business->country }}
                            <br> Phone No : {{ $business->phone_no }} ,<br> Email :{{ $business->email }}
                        </strong>
                        <br>
                        <strong>GSTIN : {{ $business->gstin }}</strong>
                    </p>
                </div>
                <div class="col-sm-2" style="border: 0.5pt solid #303030; border-left: none; ">
                    <p class="" style="font-size:small;padding:0;margin:0">Invoice No:</p>
                    <strong>{{ $quotation->quotation_no }}</strong>
                    <hr style="color:black;">

                    <p class="" style="font-size:small;padding:0;margin:0">Payment Mode:</p>
                    <strong>{{ strtoupper($quotation->cash_type) }}</strong>
                </div>

            </div>
        </header>
            <div class="row gy-3" style="width: 99.9%!important;margin-left:0.2px; ">
                <div class="col-sm-4" style="border-left: 0.5pt solid #303030;">
                    <p class="mb-1"><strong>Order Date:</strong> {{ $quotation->quotation_date }}</p>
                    <p class="mb-1"><strong>Invoice Date:</strong> {{ $quotation->quotation_date }}</p>

                </div>
                <div class="col-sm-4" style="border-left: 0.5pt solid #303030;"> <strong>Bill To:</strong>
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
                        @if ($party->gstin)
                        <p><strong>GSTIN:</strong> {{ $party->gstin }}</p>
                        @endif
                    </address>
                </div>
                <div class="col-sm-4" style="border: 0.5pt solid #303030;border-bottom:none;border-top:none;">
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
            </div>
            <div class="table-responsive ">


                <table class="table t2 border mb-0">
                    <thead>


                        <tr class="bg-light">
                            <th class="t3 col-12" style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">
                                Particulars</th>
                            <th class="t3 col-1 text-center"
                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">HSN CODE</th>
                            <th class="t3 col-1 text-center"
                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">RATE</th>
                            <th class="t3 col-1 text-center"
                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">QTY</th>
                           
                            <th class="t3 col-1 text-center"
                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">AMOUNT</th>
                          
                            <th class="t3 col-1 text-end"
                                style="border-bottom: 0.5pt solid #303030; text-transform: uppercase;">TOTAL</th>
                        </tr>

                    </thead>
                    <tbody style="height:309px">
                        @foreach ($quotationDetails as $key => $val)
                        <tr class="t3">
                            <td class="t3 col-12">{{ $val['item_description']  }}</td>
                            <td class="t3 col-1 text-center">{{ $val['hsn_code'] ?? 'N/A' }}</td>
                            <td class="t3 col-1 text-center">{{ $val['rpqty'] }}</td>
                            <td class="t3 col-1 text-center">{{ $val['qty'] }}</td>
                            <td class="t3 col-1 text-center">{{ $val['amount'] }}</td>
                            <td class="t3 col-1 text-end">{{ $val['total_amount'] }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>

            </div>
            <div class="row1">
                <div class="col-md-6">
                    <table class="table taxable">
                        <thead style="border: 0.5pt solid#303030; border-right: 0.5pt solid transparent!important;" >
                            <tr>
                                <th class="text-center" style="padding: 5px;">GST %</th>
                                <th class="text-center" style="padding: 5px; width:90px;">Taxable</th>
                                <th class="text-center" style="padding: 5px;">CGST</th>
                                <th class="text-center" style="padding: 5px;">SGST</th>
                                <th class="text-center" style="padding: 5px;">IGST</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($quotation->tax_amount_28_cgst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 6px;">28%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable28Amount }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_28_cgst }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_28_sgst }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_18_cgst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 4px;">18%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable18Amount }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_18_cgst }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_18_sgst }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_12_cgst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 6px;">12%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable12Amount }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_12_cgst }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_12_sgst }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_5_cgst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 6px;">5%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable5Amount }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_5_cgst }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_5_sgst }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_3_cgst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 6px;">3%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable3Amount }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_3_cgst }}</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_3_sgst }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_0)
                            <tr class="bg-light">
                                <td class="text-end">0%</td>
                                <td class="text-end">{{ $quotation->taxable0Amount }}</td>
                                <td class="text-end" colspan="3">0</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_28_igst)
                            <tr class="bg-light">
                                <td class="text-end">28%</td>
                                <td class="text-end">{{ $quotation->taxable28Amount }}</td>
                                <td class="text-end">0</td>
                                <td class="text-end">0</td>
                                <td class="text-end">{{ $quotation->tax_amount_28_igst }}</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_18_igst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 4px;">18%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable18Amount }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_18_igst }}</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_12_igst)
                            <tr class="bg-light">
                                <td class="text-end" style="padding: 6px;">12%</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->taxable12Amount }}</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                                <td class="text-end" style="padding: 6px;">0</td>
                                <td class="text-end" style="padding: 6px;">{{ $quotation->tax_amount_12_igst }}</td>
                            </tr>
                            @endif
                            @if ($quotation->tax_amount_5_igst)
                            <tr class="bg-light">
                                <td class="text-end">5%</td>
                                <td class="text-end">{{ $quotation->taxable5Amount }}</td>
                                <td class="text-end">0</td>
                                <td class="text-end">0</td>
                                <td class="text-end">{{ $quotation->tax_amount_5_igst }}</td>
                            </tr>
                            @endif

                          
                            <tr>
                                <td colspan="5" style="padding: 7px;">
                                    <span class="inline" style=" display: inline;font-weight:bold">Rupees. :</span>
                                    <p class="text-start" id="grandTotalInWords"
                                        style="display: inline;font-weight:bold;"></p>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr class="bg-light" >
                            <td style="padding:6px!important;" class="text-end"><strong>Sub Total:</strong></td>
                            <td style="padding:6px!important;" class="text-end">Rs. {{ $quotation->totalAmountDisplay }}</td>
                        </tr>
                        <tr class="bg-light">
                            <td style="padding:6px!important;" class="text-end"><strong>Total Tax:</strong></td>
                            <td style="padding:6px!important;" class="text-end">Rs. {{ $quotation->tax_amount }}</td>
                        </tr>
                        <tr>
                            <td style="padding:7px!important;" class="text-end"><strong>Grand Total:</strong></td>
                            <td style="padding:7px!important;" class="text-end" id="grandTotal">Rs. {{ $quotation->net_amount }}</td>
                        </tr>

                    </table>
                </div>
            </div>

            <div class="row2" style="margin-top:-17px; ">
               
                <div class="col-md-12">
                  

                        <table class="table " style="">
                            <thead style="border: 0.5pt solid #303030;margin:0;padding:0;">

                                <th class="text-start fw-700" style="padding:3px" colspan="5">Description</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" style="padding: 1px;">
                                        <p style="line-height:1.1;font-weight:bold;">We declare that this invoice shows the
                                            actual price of the goods described and that all particulars are true and
                                            correct.</p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
        </main>

        <!-- Footer -->



        <footer class="footer">
            <div class="row">
                <!-- Receiver Signature Section -->
                <div class="col-6 text-left" style="margin-top:92px;">
                    <div class="receiver-signature">
                        <p style="font-size:15px;"><strong>Receiver Signature</strong></p>
                    </div>
                </div>

                <!-- Signature Container Section -->
                <div class="col-6 ">
                    <div class="signature-container">
                        <div class="company-name text-right">
                            <p style="font-size:15px; margin-right:45px"><strong>{{ $business->company_name }}</strong></p>
                        </div>
                        <div class="seal-signature-space text-right" style="margin-right:60px;">
                            <img style="width:40%; height: 50px;" id="logo"
                                src="{{ asset('uploads/' . $business->signature) }}" title="MyDailyBill"
                                alt="MyDailyBill" />
                        </div>
                        <div class="authorized-signatory text-right" style="padding-right:38px;">
                            <p style="font-size:15px;"><strong>Authorized Signatory</strong></p>
                        </div>
                    </div>
                </div>
                <p style="text-align:center;font-size:15px;font-weight:bold;">Thanks For Visiting!!!</p>
            </div>
        </footer>




    </div>

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

</body>

</html>