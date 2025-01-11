@extends('layouts.v2.app')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Profit Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                    <tr class="table-primary">
                                        <th>Expense</th>
                                        <th>Amount</th>
                                    </tr>
                                    <tr>
                                        <td>Opening Stock</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Purchase</td>
                                        <td>{{ $total_purchase }}</td>
                                    </tr>
                                    <?php $total_expense = 0; ?>
                                    @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_name }}</td>
                                        <td>{{ $expense->price }}</td>
                                    </tr>
                                    <?php $total_expense += $expense->price; ?>
                                    @endforeach
                                    <tr class="table-primary">
                                        <td>Total Expense</td>
                                        <td>{{ $total_expense + $total_purchase }}</td>
                                    <tr class="table-primary">
                                        <td>Income</td>
                                        <td>Amount</td>
                                    </tr>
                                    <tr>
                                        <td>Sales</td>
                                        <td>{{ $total_sales }}</td>
                                    </tr>
                                    <tr>
                                        <td>Closing Stock</td>
                                        <td></td>
                                    </tr>

                                    <tr class="table-primary">
                                        <td>Profit</td>
                                        <td>{{ $total_sales - ($total_expense + $total_purchase) }}</td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-backdrop fade"></div>
</div>

<!-- Content wrapper -->

@push('stylecss')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endpush

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

@endsection
