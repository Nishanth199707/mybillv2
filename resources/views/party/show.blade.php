@extends('layouts.v2.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <br>
        <div class="card">
            <div class="card-body">
                <header class="d-flex justify-content-between align-items-center mb-4">
                    <h1>{{ strtoupper($data->name) }}</h1>
                    <div>
                        <!-- Button to Open Modal -->
                        @if ($data->transaction_type == 'sale')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#transactionModal">
                                Add Receipt
                            </button>
                        @elseif ($data->transaction_type == 'purchase')
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#transactionModal">
                                Add Payment
                            </button>
                        @endif

                    </div>
                </header>

                <!-- Tabs navs -->
                <ul class="nav nav-tabs custom-nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile"
                            role="tab" aria-controls="pills-profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-transactions-tab" data-bs-toggle="pill" href="#pills-transactions"
                            role="tab" aria-controls="pills-transactions" aria-selected="false">Transactions</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-ledger-tab" data-bs-toggle="pill" href="#pills-ledger" role="tab"
                            aria-controls="pills-ledger" aria-selected="false">Ledger (statement)</a>
                    </li>
                </ul>

                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="pills-tabContent">

                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        <section>
                            <div class="row">
                                <!-- General Details Card -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            General Details
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>Party Name<br><strong>{{ strtoupper($data->name) }}</strong></p>
                                                    <p>Mobile Number<br><strong>{{ $data->phone_no }}</strong></p>
                                                    <p>Email<br><strong>{{ $data->email }}</strong></p>
                                                    <p>Closing Balance<br><strong>₹ {{ $closingBalance }}</strong></p>
                                                </div>
                                                <div class="col-6">
                                                    <p>Party Type<br><strong>{{ $data->party_type }}</strong></p>
                                                    <p>Party Category<br><strong>-</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Details Card -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            Business Details
                                        </div>
                                        <div class="card-body">
                                            <p>GSTIN<br><strong>{{ $data->gstin }}</strong></p>
                                            <p>PAN Number<br><strong>-</strong></p>
                                            <p>Billing
                                                Address<br><strong>{{ $data->billing_address_1 }},<br>{{ $data->billing_address_2 }},<br>{{ $data->billing_pincode }}.</strong>
                                            </p>
                                            <p>Shipping Address<br><strong>
                                                    @if ($data->shipping_address_1 || $data->shipping_address_2 || $data->shipping_pincode)
                                                        @if ($data->shipping_address_1)
                                                            {{ $data->shipping_address_1 }},
                                                        @else
                                                            -,
                                                        @endif

                                                        @if ($data->shipping_address_2)
                                                            {{ $data->shipping_address_2 }},
                                                        @else
                                                            -,
                                                        @endif

                                                        @if ($data->shipping_pincode)
                                                            {{ $data->shipping_pincode }}.
                                                        @else
                                                            -.
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </strong></p>
                                            {{-- <a href="#">Manage Shipping Addresses (1)</a> --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- Credit Details Card -->
                                {{-- <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        Credit Details
                                    </div>
                                    <div class="card-body">
                                        <p>Credit Period<br><strong>0 Days</strong></p>
                                        <p>Credit Limit<br><strong>₹ 0</strong></p>
                                    </div>
                                </div>
                            </div> --}}

                                <!-- Custom Fields Card -->
                                {{-- <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        Custom Fields
                                    </div>
                                    <div class="card-body">
                                        <p>Now you can add custom item fields like Colour, Size, ID Number, etc.</p>
                                        <button class="btn btn-outline-secondary">+</button>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                        </section>
                    </div>

                    <!-- Transactions Tab -->
                    <div class="tab-pane fade" id="pills-transactions" role="tabpanel"
                        aria-labelledby="pills-transactions-tab">
                        <form id="transactionsFilterForm" class="actions mb-4 d-flex align-items-center">
                            <select class="form-select" style="max-width: 150px" id="timePeriodSelectTransactions" name="time_period" aria-label="Select time period">
                                <option value="all" {{ request('time_period') == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="365_days" {{ request('time_period') == '365_days' ? 'selected' : '' }}>Last 365 Days</option>
                                <option value="30_days" {{ request('time_period') == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="7_days" {{ request('time_period') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                            </select>

                            <select class="form-select ms-2" style="max-width: 150px" id="transactionTypeSelectTransactions" name="transaction_type" aria-label="Select Transaction Type">
                                <option value="{{ $data->transaction_type }}">{{ $data->transaction_type }}</option>
                            </select>

                            <button type="button" class="btn btn-primary ms-2" id="filterTransactionsButton">Filter</button>
                        </form>






                        <section class="transaction-table">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Invoice No</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data->transaction_type == 'sale')
                                            @foreach ($salesQuery as $payment)
                                                <tr>
                                                    <td>{{ $payment->invoice_date ?? '-' }}</td>
                                                    <td>{{ ucfirst($payment->bill_type) }}</td>
                                                    <td>{{ $payment->invoice_no ?? '-' }}</td>
                                                    <td>{{ number_format($payment->net_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge {{ $payment->cash_type === 'cash' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $payment->cash_type === 'cash' ? 'Paid' : 'Unpaid' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @elseif ($data->transaction_type == 'purchase')
                                            @foreach ($purchasesQuery as $payment)
                                                <tr>
                                                    <td>{{ $payment->purchase_date ?? '-' }}</td>
                                                    <td>{{ ucfirst($payment->bill_type) }}</td>
                                                    <td>{{ $payment->purchase_no ?? '-' }}</td>
                                                    <td>{{ number_format($payment->net_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge {{ $payment->cash_type === 'cash' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $payment->cash_type === 'cash' ? 'Paid' : 'Unpaid' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </section>



                    </div>

                    <!-- Ledger (Statement) Tab -->
                    <div class="tab-pane fade" id="pills-ledger" role="tabpanel" aria-labelledby="pills-ledger-tab">

                        <form id="ledgerFilterForm" class="mb-4 d-flex align-items-center ">
                            <!-- Time Period Select -->
                            <select class="form-control me-2" style="max-width: 200px;" id="timePeriodSelectLedger" name="time_period" aria-label="Select time period">
                                <option value="all" {{ request('time_period') == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="365_days" {{ request('time_period') == '365_days' ? 'selected' : '' }}>Last 365 Days</option>
                                <option value="30_days" {{ request('time_period') == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="7_days" {{ request('time_period') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                            </select>

                            <!-- Transaction Type Select -->
                            <select class="form-control me-2" style="max-width: 200px;" id="transactionTypeSelectLedger" name="transaction_type" aria-label="Select Transaction Type">
                                <option value="{{ $data->transaction_type }}">{{ $data->transaction_type }}</option>
                            </select>

                            <!-- Filter Button -->
                            <button type="button"  class="btn btn-primary me-2" id="filterLedgerButton">Filter</button>

                            <!-- Button Group (Download, Print, Share) -->
                            <div class="btn-group">
                                <a href="#" class="btn btn-outline-primary">Download</a>
                                <a href="#" class="btn btn-outline-secondary">Print</a>
                                <a href="#" class="btn btn-outline-success">Share</a>
                            </div>
                        </form>


                        <section class="mb-4">
                            <h2>
                                @if (Auth::user())
                                    {{ Auth::user()->name }}
                                @endif
                            </h2>
                            {{-- <p>Phone no: 9600633665</p> --}}
                            <p>To, <strong>{{ strtoupper($data->name) }}</strong></p>
                            <div class="date-info">
                                <p id="ledger-date-range">{{ $startDate ? $startDate->format('d M Y') : 'No Start Date' }} -
                                    {{ $endDate ? $endDate->format('d M Y') : 'No End Date' }}</p>
                                <p id="ledger-balance-info">
                                    {{ request('transaction_type') == 'purchase' ? 'Total Payable' : 'Total Receivable' }}
                                    <strong>₹ {{ number_format($closingBalance, 2) }}</strong>
                                </p>
                            </div>
                        </section>

                        <section class="ledger-table">
                            <div class="table-responsive">
                                <table class="table dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Voucher</th>
                                            <th style="max-width: 100px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">Remark</th>
                                            <th>Payment Type</th>
                                            <th>Credit</th>
                                            <th>Debit</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Opening Balance</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>₹ {{ number_format($data->opening_balance, 2) }}</td>
                                        </tr>
                                        @foreach ($payments as $index => $payment)
                                            <tr>
                                                <td>{{ $payment->paid_date ?? '-' }}</td>
                                                <td>{{ $payment->invoice_no ?? '-' }}</td>
                                                <td style="max-width: 100px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                                                    {{ $payment->remark }}
                                                </td>
                                                <td>{{ $payment->mode_of_payment }}</td>
                                                <td>{{ number_format($payment->credit, 2) }}</td>
                                                <td>{{ number_format($payment->debit, 2) }}</td>
                                                <td>{{ number_format($payment->closing_balance, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Closing Balance</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>₹ {{ number_format($closingBalance, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </section>
                    </div>

                </div>
                <!-- Tabs content -->
            </div>
        </div>
        <!-- Modal Structure -->
        <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel">
                            @if ($data->transaction_type == 'sale')
                                Add Receipt
                            @elseif ($data->transaction_type == 'purchase')
                                Add Payment
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('partypayment.ajaxsave') }}">
                            @csrf
                            <!-- Party Name -->
                            <div class="mb-3">
                                <label for="partyName" class="form-label">Party Name</label>
                                <input type="text" class="form-control" id="partyName" name="partyname" value="{{ strtoupper($data->name) }}" readonly>
                                <input type="hidden" name="partyid" value="{{ $data->id }}">
                            </div>

                            <!-- Transaction Type (Radio Buttons) -->
                            <div class="mb-3">
                                <label for="transactionType" class="form-label">Transaction Type</label>
                                <div>
                                    <input type="radio" id="sale" name="transaction_type" value="sale"   {{ $data->transaction_type == 'purchase' ? 'disabled' : '' }} {{ $data->transaction_type == 'sale' ? 'checked' : '' }}>
                                    <label for="sale">Sale</label>
                                    <input type="radio" id="purchase" name="transaction_type" value="purchase"   {{ $data->transaction_type == 'sale' ? 'disabled' : '' }} {{ $data->transaction_type == 'purchase' ? 'checked' : '' }}>
                                    <label for="purchase">Purchase</label>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="paid_date" id="date" required>
                            </div>

                            <!-- Balance -->
                            <div class="mb-3">
                                <label for="balance" class="form-label">Balance</label>
                                <input type="number" class="form-control" id="balance" value="{{ $closingBalance }}" readonly required>
                            </div>

                            <!-- Adjust Payment -->
                            <div class="mb-3">
                                <label for="adjustPayment" class="form-label">Adjust Payment</label>
                                <div>
                                    <input type="radio" id="adjustYes" name="adjust_payment" value="yes">
                                    <label for="adjustYes">Yes</label>
                                    <input type="radio" id="adjustNo" name="adjust_payment" value="no" checked>
                                    <label for="adjustNo">No</label>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" name="cash_received" id="amount" required>
                            </div>

                            <!-- Remark -->
                            <div class="mb-3">
                                <label for="remark" class="form-label">Remark</label>
                                <input type="text" class="form-control" id="remark" name="remark">
                            </div>

                            <!-- Mode of Payment -->
                            <div class="mb-3" id="modeOfPaymentContainer">
                                <label for="modeOfPayment" class="form-label">Mode of Payment</label>
                                <select id="modeOfPayment" name="mode_of_payment" class="form-select" required onchange="toggleTransactionFields()"   title="Please Select Payment Type">
                                    <option value="">Select</option>
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>

                            <!-- Transaction Number (Hidden by Default) -->
                            <div class="mb-3" id="transactionNumberContainer" style="display: none;">
                                <label for="transactionNumber" class="form-label">Transaction Number</label>
                                <input type="text" class="form-control" name="transaction_number" id="transactionNumber">
                            </div>

                            <!-- Cheque Fields (Hidden by Default) -->
                            <div class="mb-3" id="chequeFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="chequeNumber" class="form-label">Cheque Number</label>
                                        <input type="text" class="form-control" name="transaction_number" id="chequeNumber">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="collectionDate" class="form-label">Collection Date</label>
                                        <input type="date" class="form-control" name="collection_date" id="collectionDate">
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="saveBtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateContent(tabId, data) {
                if (tabId === 'pills-transactions') {
                    const tbody = document.querySelector('#pills-transactions .table tbody');
                    tbody.innerHTML = '';

                    data.sales.forEach(sale => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                   <td>${sale.invoice_date}</td>
                        <td>${sale.bill_type}</td>
                        <td>${sale.invoice_no}</td>
                        <td>${formatAmount(sale.net_amount)}</td>
                        <td><span class="badge ${sale.cash_type === 'cash' ? 'bg-success' : 'bg-danger'}">${sale.cash_type === 'cash' ? 'Paid' : 'Unpaid'}</span></td>


                `;
                        tbody.appendChild(row);
                    });

                    data.purchases.forEach(purchase => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                                    <td>${purchase.purchase_date}</td>
                        <td>${purchase.bill_type}</td>
                        <td>${purchase.purchase_no}</td>
                        <td>${formatAmount(purchase.net_amount)}</td>
                        <td><span class="badge ${purchase.cash_type === 'cash' ? 'bg-success' : 'bg-danger'}">${purchase.cash_type === 'cash' ? 'Paid' : 'Unpaid'}</span></td>
               `;
                        tbody.appendChild(row);
                    });
                } else if (tabId === 'pills-ledger') {
                    const tbody = document.querySelector('#pills-ledger .table tbody');
                    tbody.innerHTML = ''; // Clear existing content

                    let html = '';

                    // Opening Balance Row
                    html += `
            <tr>
                <td>Opening Balance</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                 <td>-</td>
                <td>₹ {{ $data->opening_balance }}.00</td>
            </tr>
            `;

                    // Sales Rows
                    data.sales.forEach(sale => {
                        html += `
                <tr>
                    <td>${sale.paid_date !== null ? sale.paid_date : '-'}</td>
                    <td>${sale.invoice_no !== null ? sale.invoice_no : '-'}</td>
                    <td>${sale.remark !== null ? sale.remark : '-'}</td>
                    <td>${sale.mode_of_payment !== null ? sale.mode_of_payment : '-'}</td>
                    <td>${sale.credit !== null ? formatAmount(sale.credit) : '-'}</td>
                    <td>${sale.debit !== null ? formatAmount(sale.debit) : '-'}</td>
                    <td>${sale.closing_balance !== null ? formatAmount(sale.closing_balance) : '-'}</td>
                </tr>
                `;
                    });

                    // Purchases Rows
                    data.purchases.forEach(purchase => {
                        html += `
                <tr>
                    <td>${purchase.paid_date !== null ? purchase.paid_date : '-'}</td>
                    <td>${purchase.invoice_no !== null ? purchase.invoice_no : '-'}</td>
                    <td>${purchase.remark !== null ? purchase.remark : '-'}</td>
                    <td>${purchase.mode_of_payment !== null ? purchase.mode_of_payment : '-'}</td>
                    <td>${purchase.credit !== null ? formatAmount(purchase.credit) : '-'}</td>
                    <td>${purchase.debit !== null ? formatAmount(purchase.debit) : '-'}</td>
                    <td>${purchase.closing_balance !== null ? formatAmount(purchase.closing_balance) : '-'}</td>
                </tr>
                `;
                    });

                    // Closing Balance Row
                    html += `
            <tr>
                <td>Closing Balance</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                 <td>-</td>
                <td>₹ ${formatAmount(data.closingBalance)}</td>
            </tr>
            `;

                    // Insert the generated rows into the table body
                    tbody.innerHTML = html;

                    // Update date range and total balance information
                    const dateRangeElement = document.querySelector('#ledger-date-range');
                    const balanceInfoElement = document.querySelector('#ledger-balance-info');

                    const startDate = data.startDate ? formatDate(data.startDate) : 'No Start Date';
                    const endDate = data.endDate ? formatDate(data.endDate) : 'No End Date';
                    const transactionType = data.transactionType === 'purchase' ? 'Total Payable' :
                        'Total Receivable';

                    dateRangeElement.innerHTML = `${startDate} - ${endDate}`;
                    balanceInfoElement.innerHTML =
                        `${transactionType} <strong>₹ ${formatAmount(data.closingBalance)}</strong>`;
                }
            }

            // Helper function to format dates
            function formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).replace(/ /g, ' ');
            }

            // Helper function to format amounts
            function formatAmount(amount) {
                return Number(amount).toFixed(2);
            }

            document.getElementById('filterTransactionsButton').addEventListener('click', function() {
                const form = document.getElementById('transactionsFilterForm');
                const formData = new FormData(form);

                fetch('{{ route('party.filter.transactions', $partyId) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.ok ? response.json() : Promise.reject(
                        'Network response was not ok.'))
                    .then(data => updateContent('pills-transactions', data))
                    .catch(error => console.error('Error:', error));
            });

            document.getElementById('filterLedgerButton').addEventListener('click', function() {
                const form = document.getElementById('ledgerFilterForm');
                const formData = new FormData(form);

                fetch('{{ route('party.filter.ledger', $partyId) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.ok ? response.json() : Promise.reject(
                        'Network response was not ok.'))
                    .then(data => updateContent('pills-ledger', data))
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
    <script>
        document.getElementById('modeOfPayment').addEventListener('change', function() {
            const transactionNumberContainer = document.getElementById('transactionNumberContainer');
            const chequeFields = document.getElementById('chequeFields');
            if (this.value === 'cheque') {
                transactionNumberContainer.style.display = 'none'; // Hide transaction number
                chequeFields.style.display = 'block'; // Show cheque fields
            } else {
                chequeFields.style.display = 'none'; // Hide cheque fields
                if (this.value !== 'cash') {
                    transactionNumberContainer.style.display =
                        'block'; // Show transaction number for non-cash payments
                } else {
                    transactionNumberContainer.style.display = 'none'; // Hide transaction number for cash
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Set today's date as the default value
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        });

        // JavaScript to handle the visibility of mode of payment
        document.addEventListener('DOMContentLoaded', function() {
            const adjustPaymentYes = document.getElementById('adjustYes');
            const adjustPaymentNo = document.getElementById('adjustNo');
            const modeOfPaymentContainer = document.getElementById('modeOfPaymentContainer');

            function toggleModeOfPayment() {
                if (adjustPaymentYes.checked) {
                    modeOfPaymentContainer.style.display = 'none';
                } else {
                    modeOfPaymentContainer.style.display = 'block';
                }
            }

            adjustPaymentYes.addEventListener('change', toggleModeOfPayment);
            adjustPaymentNo.addEventListener('change', toggleModeOfPayment);

            // Initial toggle
            toggleModeOfPayment();
        });
    </script>
@endsection
