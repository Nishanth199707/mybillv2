@extends('layouts.v2.app')
@section('content')
    <style>
        .invalid-feedback {
            display: block;
        }

        .totalstyle1 {
            width: 50%;
            border: 0;
            /* height: 100%; */
            /* margin-left: 20px; */
        }

        .totalstyle {
            /* width: 50%; */
            border: 0;
            /* height: 100%; */
            /* margin-left: 20px; */
            /* overflow: hidden; */
            position: relative;
            padding: 0;
            background: inherit;
            font-weight: bolder;
            font-size: 30px;
        }

        .totalstyle1:focus,
        .totalstyle:focus {
            outline: none;
            /* This removes the focus outline */
            /* Your other styles */
        }

        .totalstyle--input:focus {
            outline: none;
            /* Removes the default focus outline */
            /* Additional styles if needed */
        }

        .gsttable tr,
        .gsttable {
            width: 100%;
        }

        /* .gsttable td:nth-child(1) {
                width: 10%;
            } */

        .gsttable td {
            width: 17%;
            display: inline-block;
            /* overflow: hidden; */
            margin: 5px;
            text-align: center;
            /* display: inline-flex; */
        }


        .avl_stock {
            padding: 0 10px;
        }

        /* .card {
                background-color: #114b3a;
                color: #fff !important;
            } */
        .border {
            border: solid 1px #dee2e6 !important;
        }

        #addrow {
            font-size: 12px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Layout -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Add New Expense</h5>
                        </div>
                        <div id="validation-errors-sale"></div>
                        <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST"
                            action="{{ route('expense.update') }}" id="saleForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                            <div class="card-body p-32" id="tblData">
                                <div class="row mb-3">
                                    <div class="col-md-2 fv-plugins-icon-container">
                                        <label class="form-label" for="formValidationName">Expense No</label>
                                        <input type="text" id="formValidationName" class="form-control" required
                                            value="{{ $expense->expense_ref }}" name="expense_no" readonly>

                                    </div>
                                    <div class="col-md-2 fv-plugins-icon-container">
                                        <label class="form-label" for="formValidationName">Expense Date</label>
                                        <input type="text" class="form-control" id="datetimepicker9" required
                                            name="expense_date" value="{{ $expense->dateofexpense }}">
                                        @if ($errors->has('purchase_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('purchase_date') }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <span id="alertentries"></span>
                                </div>
                                <div class="col-6" style="text-align:right;"><button type="button"
                                        class="btn btn-primary addrowcontainer float-right mb-2">Add New Row</button>
                                </div>

                                <!-- <hr> -->
                            </div>
                            <div class="m-1  justify-content-between align-items-center" id="addrow">

                                <div class="row">
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>Expense Type</b>
                                    </div>
                                    <div class="col-md-4 border p-1 text-center">
                                        <b>Expense Name</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>Amount</b>
                                    </div>
                                    <div class="col-md-4 border p-1 text-center">
                                        <b>Description</b>
                                    </div>
                                </div>

                                @foreach ($expensedetails as $key => $expenseDetail)
                                <div class="row">
                                    <div class="col-md-2 border p-2">
                                        {{-- <input class="form-control gstperc" dataid="1" type="text"
                                            name="expence_type1" id="expence_type1"> --}}
                                            <select name="expence_type1" id="expence_type1" class="form-select expence_type">
                                                <option value="">Select Expense Type</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @if($category->id == $expenseDetail->expensecategory_id) {{'selected'}} @endif >{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="border p-2 col-md-4">
                                                <input type="text" class="form-control product_id"
                                                    name="product_id1" id="product_id1" value="{{ $expenseDetail->expense_name }}"/>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="text"
                                            dataid="1" name="amount1" id="taxableamount1"  value="{{ $expenseDetail->price }}">
                                    </div>
                                    <div class="col-md-4 border p-2">
                                        <input class="form-control total_amount" type="text"
                                            id="description1" name="description1"  value="{{ $expenseDetail->description }}">
                                    </div>
                                </div>
                                @endforeach




                            </div>

                            <div class="m-1  justify-content-between align-items-center">
                                <div style="display: flex;justify-content: flex-end;margin-top: 10px;">
                                    <input type="hidden" readonly class="totalstyle" name="totalAmountDisplay"
                                        id="totalAmountDisplay" value="{{ $expense->amount }}" />
                                    <div class="col-md-3 border p-2">
                                        <b class="mt-1">Net Amount: ₹</b> <input readonly type="text"
                                            class="totalstyle"  name="net_amount" id="netAmount" value="{{ $expense->amount }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="col-md-4 fv-plugins-icon-container">
                                            <label class="form-label">Cash Type</label>
                                            <select name="cash_type" required id="cash_type" class="form-select">
                                                @php
                                                    $cash_type = ['cash' => 'Cash', 'credit' => 'Credit'];
                                                @endphp
                                                @foreach ($cash_type as $key => $val)
                                                    <option @if ($expense->cash_type == $key) selected @endif
                                                        value="{{ $key }}">{{ $val }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cash_type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cash_type') }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                         <div style="text-align: right;">

                             <button id="saleFormSubmit" type="submit"
                                 class="btn btn-primary float-right mb-2">Bill</button>
                         </div>
                         <input type="hidden" name="totQues" id="totQues" value="{{ count($expensedetails) }}" />
                </form>
            </div>
        </div>
    </div>

</div>
</div>
<!-- / Content -->
</div>
</div>
<div class="content-backdrop fade"></div>
</div>

<script>
      document.addEventListener('DOMContentLoaded', function() {
        initCalculation();
        document.querySelectorAll('.addrowcontainer').forEach(function(button) {
            button.addEventListener('click', function() {
                var extCnt = parseInt(document.getElementById("totQues").value, 10);
                var cIncr = extCnt + 1;
                document.getElementById("totQues").value = cIncr;

                document.getElementById("addrow").insertAdjacentHTML('beforeend',
                    `<div class="row mb-3">` +
                    `<div class="border col-md-2 p-2">` +
                    `<select name="expence_type${cIncr}" id="expence_type${cIncr}" class="form-select expence_type">` +
                    `<option value="">Select Expense Type</option>` +
                    `@foreach ($categories as $category)` +
                    `<option value="{{ $category->id }}">{{ $category->name }}</option>` +
                    `@endforeach` +
                    `</select>` +
                    `</div>` +
                    `<div class="col-md-4 border p-2"><input class="form-control product_id" type="text" dataid="${cIncr}" name="product_id${cIncr}" id="product_id${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control amountbox" type="text" dataid="${cIncr}" name="amount${cIncr}" id="taxableamount${cIncr}"></div>` +
                    `<div class="col-md-4 border p-2"><input class="form-control " type="text" name="description${cIncr}" id="description${cIncr}"></div>` +
                    `</div>`
                );
                initCalculation();
            });
        });
    });

    function initCalculation() {
        document.querySelectorAll('.amountbox').forEach(function(element) {
            element.addEventListener('input', function() {
                var total = 0;
                document.querySelectorAll('.amountbox').forEach(function(element) {
                    total += parseFloat(element.value);
                });
                document.getElementById('netAmount').value = total;
            });
        });
        $('.expence_type').select2();
    }
</script>
<script>
    $(document).ready(function() {
        $('.expence_type').select2();
    });
</script>
@endsection
