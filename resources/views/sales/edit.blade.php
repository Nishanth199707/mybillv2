@extends('layouts.v2.app')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <script disabled type="text/javascript">
            $(document).ready(function() {
                @if (!empty($sale->tax_amount_28_cgst))
                @else
                    $('.twentyeight').css({
                        'display': 'none'
                    });
                @endif

                @if (!empty($sale->tax_amount_18_cgst))
                @else
                    $('.eighteen').css({
                        'display': 'none'
                    });
                @endif

                @if (!empty($sale->tax_amount_12_cgst))
                @else

                    $('.twelve').css({
                        'display': 'none'
                    });
                @endif

                @if (!empty($sale->tax_amount_5_cgst))
                @else

                    $('.five').css({
                        'display': 'none'
                    });
                @endif


            });
        </script>

        <!-- Content -->
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Edit Sale</h4>

            <!-- Basic Layout -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Edit Sale</h5>
                            <!-- <small class="text-muted float-end">Default label</small> -->
                        </div>
                        <div id="validation-errors-sale"></div>
                        <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST"
                            action="{{ route('sale.update', $sale->id) }}" id="saleForm" type="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input disabled type="hidden" id="sale_id" name="sale_id" value="{{ $sale->id }}">

                            <div class="card-body p-32" id="tblData">
                                <div class="row mb-3">
                                    <div class="col-md-4 fv-plugins-icon-container" id="tblDataparty">
                                        <label class="form-label">Party</label>
                                        <div class="border p-2 input-group col-md-4">
                                            <input disabled type="text" class="form-control party" id="party"
                                                required name="party" value="{{ $sale->party }}">
                                            <input disabled type="hidden" class="party" id="partyid" required
                                                name="partyid" value="{{ $sale->party_id }}">
                                            <button disabled type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#basicModal1">+</button>
                                        </div>
                                    </div>

                                    <div class="col-md-4 fv-plugins-icon-container">
                                        <label class="form-label" for="formValidationName">Invoice Date</label>
                                        <input disabled type="text" class="form-control" id="datetimepicker9" required
                                            name="invoice_date" value="{{ $sale->invoice_date }}">
                                        @if ($errors->has('invoice_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('invoice_date') }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="formValidationName">Invoice No</label>
                                    <input disabled type="text" id="formValidationName" class="form-control" readonly
                                        placeholder="John Doe" value="{{ $invoice_no }}" name="invoice_no">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"><button disabled type="button"
                                        class="btn btn-primary addrowcontainer float-right mb-2">Add New Row</button>
                                </div>

                                <div class="col-6">
                                    <span id="alertentries"></span>
                                </div>
                                <!-- <hr> -->
                            </div>
                            <div class="m-1  justify-content-between align-items-center" id="addrow">

                                <div class="row">
                                    <div class="col-md-3 border p-1 text-center">
                                        <b>Particulars</b>
                                    </div>
                                    <div class="col-md-1 border p-1 text-center">
                                        <b>Rate</b>
                                    </div>
                                    <div class="col-md-1 border p-1 text-center">
                                        <b>QTY</b>
                                    </div>
                                    <div class="col-md-1 border p-1 text-center">
                                        <b>DISCOUNT</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>AMOUNT</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>GST Rate</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>TOTAL AMOUNT</b>
                                    </div>
                                </div>

                                @foreach ($saledetail as $key => $val)
                                    <div class="row">

                                        <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                            <input class="form-control product_name" tabindex="1"
                                                name="item_description{{ $key + 1 }}"
                                                value="{{ $val->item_description }}" />
                                            <input disabled type="hidden" class="form-control product_id"
                                                name="product_id{{ $key + 1 }}" value="{{ $val->product_id }}" />
                                            <input disabled type="hidden" name="sale_detail_id{{ $key + 1 }}"
                                                value="{{ $val->id }}" />
                                            <button disabled type="button" class="btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                        </div>
                                        <div class="col-md-1 border p-2">
                                            <input class="form-control uprice" disabled type="text" dataid="1"
                                                name="rpqty{{ $key + 1 }}" id="rpqty{{ $key + 1 }}"
                                                value="{{ $val->rpqty }}">
                                        </div>
                                        <div class="col-md-1 border p-2">
                                            <input class="form-control qtybox" tabindex="1" disabled type="text"
                                                dataid="{{ $key + 1 }}" name="qty{{ $key + 1 }}"
                                                id="qty{{ $key + 1 }}" value="{{ $val->qty }}">
                                        </div>
                                        <div class="col-md-1 border p-2">
                                            <input class="form-control discount" tabindex="1" disabled
                                                type="text" dataid="{{ $key + 1 }}"
                                                name="dis{{ $key + 1 }}" id="dis{{ $key + 1 }}"
                                                value="{{ $val->discount }}">
                                        </div>
                                        <div class="col-md-2 border p-2">
                                            <input class="form-control amountbox" tabindex="1" disabled
                                                type="text" dataid="{{ $key + 1 }}"
                                                name="amount{{ $key + 1 }}"
                                                id="taxableamount{{ $key + 1 }}" name="{{ $val->amount }}">
                                        </div>

                                        <div class="col-md-2 border p-2">
                                            <input class="form-control gstperc" dataid="1" disabled
                                                type="text" name="gst{{ $key + 1 }}"
                                                id="gst{{ $key + 1 }}" value="{{ $val->gst }}">
                                            <input class="gstvaldata" disabled type="hidden"
                                                dataid="{{ $key + 1 }}" name="gstvaldata{{ $key + 1 }}"
                                                id="gstvaldata{{ $key + 1 }}" value="{{ $val->gstvaldata }}">
                                        </div>
                                        <div class="col-md-2 border p-2">
                                            <input class="form-control" disabled type="text" readonly="readonly"
                                                id="total_amount{{ $key + 1 }}"
                                                name="total_amount{{ $key + 1 }}"
                                                value="{{ $val->total_amount }}">
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="m-1  justify-content-between align-items-center">

                                <div class="row">




                                    <!-- <div class="col-md-3 border p-2"> -->
                                    <input disabled type="hidden" readonly class="totalstyle"
                                        name="totalAmountDisplay" id="totalAmountDisplay" value="0" /><br>
                                    <!-- <input disabled type="hidden" readonly class="totalstyle1" name="taxable28Amount" id="taxable28Amount" value="0" /><br>
                                        <input disabled type="hidden" readonly class="totalstyle1" name="taxable18Amount" id="taxable18Amount" value="0" /><br>
                                        <input disabled type="hidden" readonly class="totalstyle1" name="taxable12Amount" id="taxable12Amount" value="0" /><br>
                                        <input disabled type="hidden" readonly class="totalstyle1" name="taxable5Amount" id="taxable5Amount" value="0" /> -->

                                    <!-- </div> -->

                                    <div class="col-md-7 border p-2">
                                        <div class="">
                                            <table class="gsttable">
                                                <tr>
                                                    <td>Rate</td>
                                                    <td>Taxable</td>
                                                    <td>CGST: ₹ </td>
                                                    <td>SGST: ₹ </td>
                                                    <td>IGST: ₹ </td>
                                                </tr>
                                                <tr class="twentyeight">
                                                    <td>28%</td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable28Amount"
                                                            id="taxable28Amount"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_cgst"
                                                            id="taxAmount_28_cgst"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_sgst"
                                                            id="taxAmount_28_sgst"></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr class="eighteen">
                                                    <td>18%</td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable18Amount"
                                                            id="taxable18Amount"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_cgst"
                                                            id="taxAmount_18_cgst"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_sgst"
                                                            id="taxAmount_18_sgst"></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr class="twelve">
                                                    <td>12%</td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable12Amount"
                                                            id="taxable12Amount"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_cgst"
                                                            id="taxAmount_12_cgst"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_sgst"
                                                            id="taxAmount_12_sgst"></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr class="five">
                                                    <td>5%</td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable5Amount"
                                                            id="taxable5Amount"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_cgst"
                                                            id="taxAmount_5_cgst"></td>
                                                    <td>₹ <input disabled type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_sgst"
                                                            id="taxAmount_5_sgst"></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>

                                        </div>

                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <b class="mt-1">Tax: ₹</b> <input disabled type="text" readonly
                                            value="0" class="totalstyle" name="tax_amount" id="taxAmount"
                                            value="{{ $sale->tax_amount }}">
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <b class="mt-1">Net Amount: ₹</b> <input readonly disabled type="text"
                                            class="totalstyle" value="0" name="net_amount" id="netAmount"
                                            value="{{ $sale->net_amount }}">

                                        <input type="hidden" name="net_amount" value="{{ $sale->net_amount }}">

                                    </div>
                                </div>

                                <div class="row mt-0">

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <input disabled type="hidden" name="totQues" id="totQues"
                                            value="5" />
                                        <input disabled type="hidden" name="invoice_url" id="invoice_url"
                                            value="">

                                        <div class="row">
                                            <div class="col-md-4 fv-plugins-icon-container">
                                                <label class="form-label">Cash Type</label>
                                                <select name="cash_type" disabled required id="cash_type"
                                                    class="form-select">

                                                    <option value="cash"
                                                        @if ($sale->cash_type == 'cash') selected @endif>Cash</option>
                                                    <option value="credit"
                                                        @if ($sale->cash_type == 'credit') selected @endif>Credit
                                                    </option>
                                                    <option value="emi"
                                                        @if ($sale->cash_type == 'emi') selected @endif>EMI</option>
                                                </select>
                                                @if ($errors->has('cash_type'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cash_type') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-4 fv-plugins-icon-container">
                                                <div id="cash_received_field" style="display: none;">
                                                    <label class="form-label">Cash Received</label>
                                                    <input disabled type="text" class="form-control"
                                                        name="cash_received" value="{{ $sale->cash_received }}"
                                                        id="CashReceived" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- EMI Details Section -->
                            <div id="emi_fields" class="form-row">
                                <div class="row">
                                    @if ($emi)

                                        <div class="col-md-3 form-group">
                                            <label for="bank" class="form-label">Financier</label>

                                            <div class="input-group col-md-4">
                                                <input type="hidden" name="financier_name" id="loan_no"
                                                    value="{{ $emi->financier_name }}" class="form-control">
                                                <select id="financier" class="form-control" disabled
                                                    name="financier_name">
                                                    <option value="">-- Select Financier --</option>

                                                </select>

                                                <button disabled type="button" class="btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#financierModal">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="loan_no" class="form-label">Loan No.</label>
                                            <input type="text" name="loan_no" id="loan_no"
                                                value="{{ $emi->loan_no }}" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="credit_amount" class="form-label">Initial Payment</label>
                                            <input type="text" name="initial_payment" id="credit_amount"
                                                value="{{ $emi->initial_payment }}" class="form-control">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label for="emi" class="form-label">EMI</label>
                                            <input type="text" name="emi" id="emi" class="form-control"
                                                value="{{ $emi->emi }}">
                                        </div>
                                        <div class="col-md-1 form-group">
                                            <label for="scheme" class="form-label">Scheme</label>
                                            <input type="text" name="scheme" id="scheme" class="form-control"
                                                value="{{ $emi->scheme }}">
                                        </div>
                                    @else
                                        <div class="col-md-3 form-group">
                                            <label for="bank" class="form-label">Financier</label>
                                            <div class="input-group col-md-4">
                                                <select id="financier" class="form-control" name="financier_name">
                                                    <option value="">-- Select Financier --</option>
                                                </select>
                                                <button disabled type="button" class="btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#financierModal">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="loan_no" class="form-label">Loan No.</label>
                                            <input disabled type="text" name="loan_no" id="loan_no"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="credit_amount" class="form-label">Initial Payment</label>
                                            <input disabled type="text" name="initial_payment" id="credit_amount"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label for="emi" class="form-label">EMI</label>
                                            <input disabled type="text" name="emi" id="emi"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-1 form-group">
                                            <label for="scheme" class="form-label">Scheme</label>
                                            <input disabled type="text" name="scheme" id="scheme"
                                                class="form-control">
                                        </div>

                                    @endif

                                </div>
                            </div>

                            <br>
                            <!-- <button disabled type="submit" class="btn btn-primary">Send</button> -->
                            <button id="saleFormSubmit" type="submit"
                                class="btn btn-primary float-right mb-2">Bill</button>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- / Content -->



<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Product</h5>
                <button disabled type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="validation-errors-product"></div>

                <form method="POST" id="productForm" action="{{ route('product.ajaxsave') }}" encdisabled
                    type="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input disabled type="file" class="form-control" name="image"
                            value="{{ old('image') }}" />
                        @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @enderror
                </div>



                <div class="col-md mb-3">
                    <!-- <small class="fw-medium d-block">Item Type</small> -->
                    <label class="form-label pl-5">Item Type</label>
                    <div class="form-check form-check-inline pl-5 mt-3">
                        <input class="form-check-input" disabled type="radio" checked name="item_type"
                            id="inlineRadio1" value="sale">
                        <label class="form-check-label" for="inlineRadio1">Sale</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" disabled type="radio" name="item_type"
                            id="inlineRadio2" value="service">
                        <label class="form-check-label" for="inlineRadio2">Service</label>
                    </div>
                    @if ($errors->has('item_type'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('item_type') }}</strong>
                        </span>
                    @enderror

            </div>




            <div class="mb-3">
                <label class="form-label">Product Category</label>
                <select name="category" id="category" class="form-select">

                    @foreach ($productcategory as $val)
                        <option @if (old('category') == $val->name) selected @endif
                            value="{{ $val->name }}">{{ $val->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('category') }}</strong>
                    </span>
                @enderror
        </div>


        <div class="mb-3">
            <label class="form-label">Item Code/Barcode</label>
            <input disabled type="text" class="form-control" name="item_code_barcode"
                value="{{ old('item_code_barcode') }}" />
            @if ($errors->has('item_code_barcode'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('item_code_barcode') }}</strong>
                </span>
            @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input disabled type="text" class="form-control" name="item_name"
            value="{{ old('item_name') }}" />
        @if ($errors->has('item_name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('item_name') }}</strong>
            </span>
        @enderror
</div>


<div class="mb-3">
    <label class="form-label">Sale Price</label>
    <input disabled type="text" class="form-control" name="sale_price"
        value="{{ old('sale_price') }}" />
    @if ($errors->has('sale_price'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('sale_price') }}</strong>
        </span>
    @enderror
</div>

<div class="mb-3">
<label class="form-label">GST Rate</label>
<input disabled type="text" class="form-control" name="gst_rate"
    value="{{ old('gst_rate') }}" />
@if ($errors->has('gst_rate'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('gst_rate') }}</strong>
    </span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Status</label>
<select name="units" id="units" class="form-select">
@php
    $unitArr = [
        'pcs' => 'Pieces',
        'packets' => 'Packets',
        'g' => 'Grams',
        'kg' => 'Kilogram',
        'l' => 'Liter',
        'ml' => 'Milli Liter',
    ];
@endphp
@foreach ($unitArr as $key => $val)
    <option @if (old('units') == $val) selected @endif
        value="{{ $key }}">{{ $val }}</option>
@endforeach
</select>
@if ($errors->has('units'))
<span class="invalid-feedback" role="alert">
    <strong>{{ $errors->first('units') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Stock</label>
<input disabled type="text" class="form-control" name="stock"
value="{{ old('stock') }}" />
@if ($errors->has('stock'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('stock') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">HSN Code</label>
<input disabled type="text" class="form-control" name="hsn_code"
value="{{ old('hsn_code') }}" />
@if ($errors->has('hsn_code'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('hsn_code') }}</strong>
</span>
@enderror
</div>


<div class="mb-3">
<label class="form-label">Description</label>
<textarea class="form-control" name="description" value="{{ old('description') }}" rows="4" cols="10"
    placeholder="Enter the description"></textarea>
@if ($errors->has('description'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('description') }}</strong>
</span>
@enderror
</div>



<button disabled type="submit" id="saveBtn" class="btn btn-primary">Send</button>
</form>
</div>
<!-- <div class="modal-footer">
<button disabled type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
Close
</button>
<button disabled type="button" class="btn btn-primary">Save changes</button>
</div> -->
</div>
</div>
</div>

<div class="modal fade" id="basicModal1" tabindex="-1" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel1">Edit Party</h5>
<button disabled type="button" class="btn-close" data-bs-dismiss="modal"
aria-label="Close"></button>
</div>
<div class="modal-body">
<div id="validation-errors-party"></div>
<form method="POST" id="partyForm" action="{{ route('party.ajaxsave') }}" encdisabled
type="multipart/form-data">
@csrf

<div class="mb-3">
<label class="form-label">Party Type</label>
<select name="party_type" id="party_type" class="form-select">
@php
    $party_type = [
        'registered' => 'Registered',
        'unregistered' => 'Un Registered',
    ];
@endphp
@foreach ($party_type as $key => $val)
<option @if (old('party_type') == $key) selected @endif
value="{{ $key }}">{{ $val }}</option>
@endforeach
</select>
@if ($errors->has('party_type'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('party_type') }}</strong>
</span>
@enderror
</div>



<div class="mb-3">
<label class="form-label">Name</label>
<input disabled type="text" class="form-control" name="name"
value="{{ old('name') }}" />
@if ($errors->has('name'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('name') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">GSTIN</label>
<input disabled type="text" class="form-control" name="gstin"
value="{{ old('gstin') }}" />
@if ($errors->has('gstin'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('gstin') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Phone No</label>
<input disabled type="text" class="form-control" name="phone_no"
value="{{ old('phone_no') }}" />
@if ($errors->has('phone_no'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('phone_no') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input disabled type="text" class="form-control" name="email"
value="{{ old('email') }}" />
@if ($errors->has('email'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('email') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Business Address 1</label>
<input disabled type="text" class="form-control" name="billing_address_1"
value="{{ old('billing_address_1') }}" />
@if ($errors->has('billing_address_1'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('billing_address_1') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Business Address 2</label>
<input disabled type="text" class="form-control" name="billing_address_2"
value="{{ old('billing_address_2') }}" />
@if ($errors->has('billing_address_2'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('billing_address_2') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Business Pincode</label>
<input disabled type="text" class="form-control" name="billing_pincode"
value="{{ old('billing_pincode') }}" />
@if ($errors->has('billing_pincode'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('billing_pincode') }}</strong>
</span>
@enderror
</div>


<div class="mb-3">
<label class="form-label">Shipping Address 1</label>
<input disabled type="text" class="form-control" name="shipping_address_1"
value="{{ old('shipping_address_1') }}" />
@if ($errors->has('shipping_address_1'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('shipping_address_1') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Shipping Address 2</label>
<input disabled type="text" class="form-control" name="shipping_address_2"
value="{{ old('shipping_address_2') }}" />
@if ($errors->has('shipping_address_2'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('shipping_address_2') }}</strong>
</span>
@enderror
</div>

<div class="mb-3">
<label class="form-label">Shipping Pincode</label>
<input disabled type="text" class="form-control" name="shipping_pincode"
value="{{ old('shipping_pincode') }}" />
@if ($errors->has('shipping_pincode'))
<span class="invalid-feedback" role="alert">
<strong>{{ $errors->first('shipping_pincode') }}</strong>
</span>
@enderror
</div>





<button disabled type="submit" id="partysaveBtn" class="btn btn-primary">Send</button>
</form>
</div>

</div>
</div>
</div>


<div class="modal fade" id="basicModal2" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel1">Invoice</h5>
<button disabled type="button" class="btn-close" data-bs-dismiss="modal"
aria-label="Close"></button>
</div>
<div class="modal-body">
<div id="validation-errors-party"></div>


<div class="container-fluid invoice-container">
<!-- Header -->
<header>
<div class="row gy-3">
<div class="col-12 text-center">
<h2 class="text-4">Tax Invoice</h4>
</div>
<div class="col-sm-3">
<img id="logo" src="{{ asset('uploads/' . $business->logo) }}"
title="MyDailyBill" alt="MyDailyBill" />
</div>
<div class="col-sm-7">
<h4 class="text-4 mb-1">Sold By: {{ $business->company_name }}.</h4>
<p class="lh-base mb-0 text-capitalize">Ship-from Address:
{{ $business->address . ',' . $business->city . '-' . $business->pincode . ',' . $business->state . ',' . $business->country }}
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
<p><strong>GSTIN:</strong> {{ $party->gstin }}</p>
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
<div class="table-responsive">
<table class="table border mb-0">
<thead>
<tr class="bg-light">
<td class="col-3"><strong>Particulars</strong></td>
<td class="col-2"><strong>HSN Code</strong></td>
<td class="col-2"><strong>Rate Per Qty</strong></td>
<td class="col-1 text-center"><strong>QTY</strong></td>
<!-- <td class="col-2 text-center"><strong>Price</strong></td> -->
<td class="col-2 text-center"><strong>GST Rate</strong></td>
<td class="col-2 text-end"><strong>TOTAL</strong></td>
</tr>
</thead>
<tbody>
@foreach ($saledetail as $key => $val)
<tr>
<td class="col-3">{{ $val->item_description }}</td>
<td class="col-2 text-center">{{ $val->rpqty }}</td>
<td class="col-2 text-center">{{ $val->rpqty }}</td>
<td class="col-1 text-center">{{ $val->qty }}</td>
<td class="col-2 text-center">{{ $val->gst }}</td>
<td class="col-2 text-end">{{ $val->total_amount }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="table-responsive">
<table class="table border border-top-0 mb-0">
<tr class="bg-light">
<td class="text-end"><strong>Sub Total:</strong></td>
<td class="col-sm-2 text-end">{{ $sale->totalAmountDisplay }}</td>
</tr>
<tr class="bg-light">
<td class="text-end"><strong>Tax:</strong></td>
<td class="col-sm-2 text-end">$15.00</td>
</tr>
<tr class="bg-light">
<td class="text-end"><strong>Grand Total:</strong></td>
<td class="col-sm-2 text-end">{{ $sale->net_amount }}</td>
</tr>
</table>
</div>
</main>
<!-- Footer -->
<footer class="mt-5">


<div class="text-end mb-4">
<img id="logo" src="bill/logo-sm.png" title="MyDailyBill" alt="MyDailyBill" /><br>
<div class="lh-1 text-black-50">Thank You!</div>
<div class="lh-1 text-black-50 text-0"><small>For Shopping with us</small></div>
</div>

<p class="text-0 mb-0"><strong>Returns Policy:</strong> At MyDailyBill we try to deliver
perfectly each and every
time. But in the off-chance that you need to return the item, please do so with the original
Brand
box/price
tag, original packing and invoice without which it will be really difficult for us to act on
your
request. Please help us in helping you. Terms and conditions apply.</p>
<hr class="my-2">
<p class="text-center">Helpline: 1800 222 9888</p>
<div class="text-center">
<div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()"
class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i>
Print &
Download</a> </div>
</div>
</footer>
</div>

</div>

</div>
</div>
</div>


<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initCalculation();
        document.querySelectorAll('.addrowcontainer').forEach(function(button) {
            button.addEventListener('click', function() {
                var extCnt = document.getElementById("totQues").value;
                var cIncr = parseInt(extCnt) + 1;
                document.getElementById("totQues").value = parseInt(extCnt) + 1;
                document.getElementById("addrow").insertAdjacentHTML('beforeend',
                    `<div class="row mb-3">` +
                    `<div class="border p-2 input-group col-md-4" style="width: 33.33333333%;"><input class="form-control product_name" tabindex="1" name="item_description${cIncr}" /><input disabled type="hidden" class="form-control product_id" name="product_id${cIncr}" /><button disabled type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control uprice" disabled type="text" dataid="${cIncr}" name="rpqty${cIncr}" id="rpqty${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control qtybox" tabindex="1" disabled type="number" dataid="${cIncr}" name="qty${cIncr}" id="qty${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control discount"  disabled type="text" dataid="${cIncr}" name="dis${cIncr}" id="dis${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control amountbox" tabindex="1" disabled type="number" dataid="${cIncr}" name="amount${cIncr}" id="taxableamount${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control gstperc" disabled type="text" dataid="${cIncr}" name="gst${cIncr}" id="gst${cIncr}"><input class="gstvaldata" disabled type="hidden" dataid="${cIncr}" name="gstvaldata${cIncr}" id="gstvaldata${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control" disabled type="text" name="total_amount${cIncr}" id="total_amount${cIncr}"></div>` +
                    `</div>`
                );
                initCalculation();
            });
        });
    });

    function roundoff($amount) {
        var number = $amount;
        var decimalPlaces = 2;
        var roundedNumber = Math.round(number * Math.pow(10, decimalPlaces)) / Math.pow(10, decimalPlaces);
        return roundedNumber;
    }




    function initCalculation() {
        document.querySelectorAll('.qtybox').forEach(function(element) {
            element.addEventListener('keyup', function() {
                var dRecid = this.getAttribute("dataid");
                var avlqty = this.getAttribute("data-avail-qty");
                document.getElementById("alertentries").innerHTML = 'Available Quantity ' + avlqty;

                var qtyValue = this.value;
                // var taxable_value = document.getElementById("amount" + dRecid).value;

                var uPriceVal = document.getElementById("rpqty" + dRecid).value;
                var gstValue = document.getElementById("gst" + dRecid).value;
                if (gstValue === "") {
                    gstValue = 0;
                }
                if (qtyValue === "") {
                    qtyValue = 0;
                }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }

                if (gstValue > 0) {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                    var percentage = parseFloat(gstValue) / 100;
                    var gstAmount = totValue * percentage; // Calculating GST (18%)
                    var totalAmountWithGST = totValue + gstAmount;

                    document.getElementById("taxableamount" + dRecid).value = totValue;
                    document.getElementById("gstvaldata" + dRecid).value = gstAmount.toFixed(2);
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount',
                        gstValue);
                    document.getElementById("taxableamount" + dRecid).setAttribute(
                        'data-taxable-amount', gstValue);

                    document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(
                        2); // Fixed to 2 decimal places
                } else {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));

                    document.getElementById("total_amount" + dRecid).value = totValue;
                    document.getElementById("gst" + dRecid).value = gstValue;
                    document.getElementById("gstvaldata" + dRecid).value = gstValue;

                }

                // Initialize a variable to store the total sum
                let total_Amount = 0;

                // Find all elements with data-gst-amount equal to 18
                const total_Amount_elements = document.querySelectorAll('[data-taxable-amount="' +
                    gstValue + '"]');

                // Loop through each total_Amount_element
                total_Amount_elements.forEach(total_Amount_element => {
                    // Retrieve the corresponding total_row_ value and add it to the total sum
                    const total_row_Value = parseFloat(total_Amount_element
                        .value); // Assuming total_row_ contains numeric values
                    if (!isNaN(total_row_Value)) { // Check if the value is numeric
                        total_Amount += total_row_Value;

                        if (gstValue == 28) {
                            $('.twentyeight').css({
                                'display': 'block'
                            });
                            document.getElementById("taxable28Amount").value = total_Amount;
                        }

                        if (gstValue == 18) {
                            $('.eighteen').css({
                                'display': 'block'
                            });
                            document.getElementById("taxable18Amount").value = total_Amount;
                        }
                        if (gstValue == 12) {
                            $('.twelve').css({
                                'display': 'block'
                            });
                            document.getElementById("taxable12Amount").value = total_Amount;
                        }
                        if (gstValue == 5) {
                            $('.five').css({
                                'display': 'block'
                            });
                            document.getElementById("taxable12Amount").value = total_Amount;
                        }

                    }
                });



                // Initialize a variable to store the total sum
                let totalGstAmount = 0;

                // Find all elements with data-gst-amount equal to 18
                const elements = document.querySelectorAll('[data-gst-amount="' + gstValue + '"]');

                // Loop through each element
                elements.forEach(element => {
                    // Retrieve the corresponding gstvaldata value and add it to the total sum
                    const gstvaldataValue = parseFloat(element
                        .value); // Assuming gstvaldata contains numeric values
                    if (!isNaN(gstvaldataValue)) { // Check if the value is numeric
                        totalGstAmount += gstvaldataValue / 2;

                        if (gstValue == 28) {
                            $('.twentyeight').css({
                                'display': 'block'
                            });
                            document.getElementById("taxAmount_28_cgst").value = totalGstAmount;
                            document.getElementById("taxAmount_28_sgst").value = totalGstAmount;
                        }

                        if (gstValue == 18) {
                            $('.eighteen').css({
                                'display': 'block'
                            });
                            document.getElementById("taxAmount_18_cgst").value = totalGstAmount;
                            document.getElementById("taxAmount_18_sgst").value = totalGstAmount;
                        }
                        if (gstValue == 12) {
                            $('.twelve').css({
                                'display': 'block'
                            });
                            document.getElementById("taxAmount_12_cgst").value = totalGstAmount;
                            document.getElementById("taxAmount_12_sgst").value = totalGstAmount;
                        }
                        if (gstValue == 5) {
                            $('.five').css({
                                'display': 'block'
                            });
                            document.getElementById("taxAmount_5_cgst").value = totalGstAmount;
                            document.getElementById("taxAmount_5_sgst").value = totalGstAmount;
                        }

                    }
                });

                document.querySelectorAll('.discount').forEach(function(element) {
                    element.addEventListener('keyup', function() {
                        var dRecid = this.getAttribute("dataid");
                        var qtyValue = document.getElementById("qty" + dRecid).value;
                        var uPriceVal = document.getElementById("rpqty" + dRecid).value;
                        var gstValue = document.getElementById("gst" + dRecid).value;
                        var DisVal = this.value || 0;


                        if (gstValue === "") {
                            gstValue = 0;
                        }
                        if (qtyValue === "") {
                            qtyValue = 0;
                        }
                        if (uPriceVal === "") {
                            uPriceVal = 0;
                        }
                        if (DisVal === "") {
                            DisVal = 0;
                        }

                        var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                        var totdiscValue = totValue - parseFloat(DisVal);
                        var totalAmountWithGST = totdiscValue;

                        if (gstValue > 0) {
                            var percentage = parseFloat(gstValue) / 100;
                            var gstAmount = totdiscValue * percentage;
                            totalAmountWithGST += gstAmount;
                        }

                        document.getElementById("taxableamount" + dRecid).value =
                            totdiscValue
                            .toFixed(2);
                        document.getElementById("gstvaldata" + dRecid).value = (
                                gstValue > 0) ?
                            gstAmount
                            .toFixed(2) : 0;
                        document.getElementById("total_amount" + dRecid).value =
                            totalAmountWithGST
                            .toFixed(2);


                        // Initialize a variable to store the total sum
                        let total_Amount = 0;

                        const total_Amount_elements = document.querySelectorAll(
                            '[data-taxable-amount="' +
                            gstValue + '"]');

                        // Loop through each total_Amount_element
                        total_Amount_elements.forEach(total_Amount_element => {
                            // Retrieve the corresponding total_row_ value and add it to the total sum
                            const total_row_Value = parseFloat(
                                total_Amount_element
                                .value);
                            console.log("row Amount = " + total_row_Value);
                            if (!isNaN(
                                    total_row_Value
                                )) { // Check if the value is numeric
                                total_Amount += total_row_Value;

                                if (gstValue == 28) {
                                    $('.twentyeight').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxable28Amount")
                                        .value = total_Amount;
                                }

                                if (gstValue == 18) {
                                    $('.eighteen').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxable18Amount")
                                        .value = total_Amount;
                                }
                                if (gstValue == 12) {
                                    $('.twelve').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxable12Amount")
                                        .value = total_Amount;
                                }
                                if (gstValue == 5) {
                                    $('.five').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxable5Amount")
                                        .value = total_Amount;
                                }

                            }
                        });



                        // Initialize a variable to store the total sum
                        let totalGstAmount = 0;

                        // Find all elements with data-gst-amount equal to 18
                        const elements = document.querySelectorAll(
                            '[data-gst-amount="' + gstValue + '"]');

                        // Loop through each element
                        elements.forEach(element => {
                            // Retrieve the corresponding gstvaldata value and add it to the total sum
                            const gstvaldataValue = parseFloat(element
                                .value
                            ); // Assuming gstvaldata contains numeric values

                            console.log(gstvaldataValue);
                            if (!isNaN(
                                    gstvaldataValue
                                )) { // Check if the value is numeric
                                totalGstAmount += gstvaldataValue / 2;

                                if (gstValue == 28) {
                                    $('.twentyeight').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxAmount_28_cgst")
                                        .value = totalGstAmount;
                                    document.getElementById("taxAmount_28_sgst")
                                        .value = totalGstAmount;
                                }

                                if (gstValue == 18) {
                                    $('.eighteen').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxAmount_18_cgst")
                                        .value = totalGstAmount;
                                    document.getElementById("taxAmount_18_sgst")
                                        .value = totalGstAmount;
                                }
                                if (gstValue == 12) {
                                    $('.twelve').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxAmount_12_cgst")
                                        .value = totalGstAmount;
                                    document.getElementById("taxAmount_12_sgst")
                                        .value = totalGstAmount;
                                }
                                if (gstValue == 5) {
                                    $('.five').css({
                                        'display': 'block'
                                    });
                                    document.getElementById("taxAmount_5_cgst")
                                        .value = totalGstAmount;
                                    document.getElementById("taxAmount_5_sgst")
                                        .value = totalGstAmount;
                                }

                            }
                        });
                        finalTotalValue();
                    });
                });
                // var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                // document.getElementById("total_amount" + dRecid).value = totValue;
                finalTotalValue();
            });
        });

        document.querySelectorAll('.uprice').forEach(function(element) {
            element.addEventListener('keyup', function() {
                var dRecid = this.getAttribute("dataid");
                var qtyValue = document.getElementById("qty" + dRecid).value;
                var gstValue = document.getElementById("gst" + dRecid).value;
                var uPriceVal = this.value;
                if (gstValue === "") {
                    gstValue = 0;
                }
                if (qtyValue === "") {
                    qtyValue = 0;
                }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }
                if (gstValue > 0) {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                    var percentage = parseFloat(gstValue) / 100;
                    var gstAmount = totValue * percentage; // Calculating GST (18%)
                    var totalAmountWithGST = totValue + gstAmount;
                    document.getElementById("gstvaldata" + dRecid).value = gstAmount;
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount',
                        gstValue);
                    document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(
                        2); // Fixed to 2 decimal places
                } else {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                    document.getElementById("total_amount" + dRecid).value = totValue;
                    document.getElementById("gst" + dRecid).value = gstValue;
                    document.getElementById("gstvaldata" + dRecid).value = gstValue;

                }
                // var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                // document.getElementById("total_amount" + dRecid).value = totValue;
                // document.getElementById("gst" + dRecid).value = gstValue;
                finalTotalValue();
            });
        });

        document.querySelectorAll('.gstperc').forEach(function(element) {
            element.addEventListener('keyup', function() {
                var dRecid = this.getAttribute("dataid");
                var qtyValue = document.getElementById("qty" + dRecid).value;
                var uPriceVal = document.getElementById("rpqty" + dRecid).value;
                var gstValue = this.value;
                if (gstValue === "") {
                    gstValue = 0;
                }
                if (qtyValue === "") {
                    qtyValue = 0;
                }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }

                if (gstValue > 0) {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                    var percentage = parseFloat(gstValue) / 100;
                    var gstAmount = totValue * percentage; // Calculating GST (18%)
                    var totalAmountWithGST = totValue + gstAmount;
                    document.getElementById("gstvaldata" + dRecid).value = gstAmount;
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount',
                        gstValue);

                    document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(
                        2); // Fixed to 2 decimal places
                } else {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                    document.getElementById("total_amount" + dRecid).value = totValue;
                    document.getElementById("gst" + dRecid).value = gstValue;
                    document.getElementById("gstvaldata" + dRecid).value = gstValue;

                }

                finalTotalValue();
            });
        });

        // document.querySelectorAll('.qtybox').forEach(function(element) {
        //     element.addEventListener('keyup', function() {
        //         // document.addEventListener('DOMContentLoaded', function() {
        //         var gstpercValues = [];
        //         var elements = document.querySelectorAll('.gstperc');
        //         elements.forEach(function(element) {
        //             var value = element.value;
        //             gstpercValues.push(value);
        //         });
        //         console.log(gstpercValues);
        //     });
        // });
    }

    function finalTotalValue() {
        var totItems = document.getElementById("totQues").value;
        var toPrice = 0;
        var gstPrice = 0;

        for (var i = 1; i <= totItems; i++) {
            var indiItemPriceElement = document.getElementById("total_amount" + i);
            var gstItemPriceElement = document.getElementById("gstvaldata" + i);

            if (indiItemPriceElement !== null && indiItemPriceElement !== undefined) {
                var indiItemPrice = indiItemPriceElement.value;
                if (indiItemPrice !== "") {
                    toPrice += parseFloat(indiItemPrice);
                }
            }

            if (gstItemPriceElement !== null && gstItemPriceElement !== undefined) {
                var gstItemPrice = gstItemPriceElement.value;
                if (gstItemPrice !== "") {
                    gstPrice += parseFloat(gstItemPrice);
                }
            }
        }
        console.log('toPrice ' + toPrice);
        console.log('gstPrice ' + gstPrice);
        var withOutGst = toPrice - gstPrice;

        document.getElementById("totalAmountDisplay").value = withOutGst.toFixed(2);
        document.getElementById("taxAmount").value = gstPrice.toFixed(2);
        // document.getElementById("netAmountDisplay").value = toPrice.toFixed(2);
        document.getElementById("netAmount").value = Math.round(toPrice);
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCalculation();
        triggerInitialCalculations();
    });

    function triggerInitialCalculations() {
        document.querySelectorAll('.qtybox').forEach(function(element) {
            var event = new Event('keyup');
            element.dispatchEvent(event);
        });
    }
</script>

<script disabled type="text/javascript">
    var path = "{{ route('autocomplete') }}";

    $(document).ready(function() {
        $("#tblData").delegate('.product_name', 'focus', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            // response(data); // Pass the received data to response function
                            if (data.length > 0) {
                                response(data.map(function(product) {
                                    return {
                                        label: product.item_name,
                                        sale_price: product
                                            .sale_price,
                                        gst_rate: product.gst_rate,
                                        id: product.id,
                                        stock: product.stock,

                                    };
                                }));
                            } else {
                                var default_val = 0;
                                // $(this).val(ui.item.label);
                                console.log($(this).closest("div").parent()
                                    .find('.uprice').val());
                                $(this).closest("div").parent().find('.uprice')
                                    .val('0');
                                $(this).closest("div").parent().find('.gstperc')
                                    .val('0');
                                // Handle case where response is empty
                                // For example, display a message or take appropriate action
                                console.log("No matching products found.");
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).closest("div").parent().find('.uprice').val(ui.item.sale_price);
                    $(this).closest("div").parent().find('.gstperc').val(ui.item.gst_rate);
                    $(this).closest("div").parent().find('.product_id').val(ui.item.id);
                    $(this).closest("div").parent().find('.qtybox').attr('data-avail-qty',
                        ui.item.stock);

                    return false;
                }
            });
        });
    });
    var partypath = "{{ route('partyautocomplete') }}";

    $(document).ready(function() {
        $("#tblDataparty").delegate('.party', 'focus', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: partypath,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            partysearch: request.term
                        },
                        success: function(data) {
                            // response(data); // Pass the received data to response function
                            if (data.length > 0) {
                                response(data.map(function(party) {
                                    return {
                                        label: party.name,
                                        id: party.id
                                    };
                                }));
                            } else {
                                console.log("No matching party found.");
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $('#partyid').val(ui.item.id);
                    // $(this).closest("div").parent().find('.party').val(ui.item.label);
                    // $(this).closest("div").parent().find('.gstperc').val(ui.item.gst_rate);
                    return false;
                }
            });
        });
    });


    // $(document).ready(function(){
    //     $('.row').each(function(){
    //         $(this).closest('div').parent().find('.gstperc').val('18');
    //     });
    // });
</script>


<script disabled type="text/javascript">
    $(function() {

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#ajaxmodal').click(function() {
            // $('#saveBtn').val("create-product");
            // $('#product_id').val('');
            $('#productForm').trigger("reset");
            // $('#modelHeading').html("Create New Product");
            $('#basicModal').modal('show');
        });

        $('#basicModal1').modal('hide');
        $('#basicModal2').modal('hide');

        $('#basicModal1').click(function() {

            $('#basicModal1').modal('show');
        });


        /*------------------------------------------
        --------------------------------------------
        Create Product Code
        --------------------------------------------
        --------------------------------------------*/
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('product.ajaxsave') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#productForm').trigger("reset");
                    $('#basicModal').modal('hide');
                    // table.draw();

                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('#saveBtn').html('Save Changes');
                    $('#validation-errors-product').html('');
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#validation-errors-product').append(
                            '<div class="alert alert-danger">' + value + '</div'
                        );
                    });

                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        Create party Code
        --------------------------------------------
        --------------------------------------------*/



        $('#partysaveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#partyForm').serialize(),
                url: "{{ route('party.ajaxsave') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#partyForm').trigger("reset");
                    $('#basicModal1').modal('hide');
                    // table.draw();
                    $('#party').html('<option value="">-- Select Party --</option>');
                    $.each(data.party, function(key, value) {
                        $("#party").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });


                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('#partysaveBtn').html('Save Changes');

                    $('#validation-errors-party').html('');
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#validation-errors-party').append(
                            '<div class="alert alert-danger">' + value + '</div'
                        );
                    });

                }
            });
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const businessCategory = '{{ $businessCategory }}'; // Get the business category from the controller

        // Function to update cash type options based on business category
        function updateCashTypeOptions() {
            const cashTypeSelect = document.getElementById('cash_type');
            const emiOption = document.createElement('option');
            emiOption.value = 'emi';
            emiOption.textContent = 'EMI';

            // Clear EMI option if not needed
            if (businessCategory !== 'mobile-accessories') {
                for (let i = 0; i < cashTypeSelect.options.length; i++) {
                    if (cashTypeSelect.options[i].value === 'emi') {
                        cashTypeSelect.remove(i);
                        break;
                    }
                }
            } else {
                // Add EMI option if needed
                if (!Array.from(cashTypeSelect.options).some(option => option.value === 'emi')) {
                    cashTypeSelect.appendChild(emiOption);
                }
            }


            updateFinancierDropdown()

        }

        function toggleEmiFields() {
            const cashType = document.getElementById('cash_type').value;
            const emiFields = document.getElementById('emi_fields');
            const cashReceivedField = document.getElementById('cash_received_field');
            cashReceivedField.style.display = (cashType === 'cash') ? 'block' : 'none';
            emiFields.style.display = (cashType === 'emi') ? 'flex' : 'none';
        }

        // Attach event listener to the cash_type select element
        document.getElementById('cash_type').addEventListener('change', toggleEmiFields);


        // Initialize fields based on pre-selected values
        toggleEmiFields();
        updateCashTypeOptions();
    });
</script>
<script>
    // Function to update the financier dropdown
    function updateFinancierDropdown() {

        @if (!empty($emi->financier_name))
            const selectedFinancier = '{{ $emi->financier_name }}';
        @endif

        $.ajax({
            url: '/fetch-financiers', // Replace with your actual endpoint
            method: 'GET', // Assuming you are using GET for fetching data
            dataType: 'json',
            success: function(response) {
                console.log('AJAX Response:', response);

                if (response.financiers && Array.isArray(response.financiers)) {
                    // Clear existing options in the dropdown
                    $('#financier').html('<option value="">-- Select Financier --</option>');

                    // Iterate through each financier and append options
                    response.financiers.forEach(value => {
                        const option = document.createElement("option");
                        option.value = value.financier_name;
                        option.textContent = value.financier_name;

                        if (value.financier_name === selectedFinancier) {
                            option.selected = true; // Pre-select the option if it matches
                        }

                        $('#financier').append(option);
                    });

                } else {
                    console.error('No financiers data found or data is not in the expected format.');
                }
            },
            error: function(xhr) {
                console.log('AJAX Error:', xhr);
                console.error('Error fetching financiers:', xhr.responseText);
            }
        });
    }

    // Bind the function to the click event of the select element
    $('#financier').click(function() {
        // Check if the dropdown has no options other than the default
        if ($('#financier option').length <= 1) {
            updateFinancierDropdown();
        }
    });

    // Initial call to populate the dropdown when the document is ready
    $(document).ready(function() {
        updateFinancierDropdown();
    });
</script>
@endsection
