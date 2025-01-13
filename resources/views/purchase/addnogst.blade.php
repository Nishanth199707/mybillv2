@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<style>
    .invalid-feedback {
        display: block;
    }

    .totalstyle1 {
        width: 50%;
        border: 0;
    }

    .totalstyle {
        border: 0;
        position: relative;
        padding: 0;
        background: inherit;
        font-weight: bolder;
        font-size: 30px;
    }

    .totalstyle1:focus,
    .totalstyle:focus {
        outline: none;

    }

    .totalstyle--input:focus {
        outline: none;
    }

    .gsttable tr,
    .gsttable {
        width: 100%;
    }

    .gsttable td {
        width: 17%;
        display: inline-block;
        margin: 5px;
        text-align: center;
    }


    .avl_stock {
        padding: 0 10px;
    }

    .border {
    border: solid 1px #dee2e6 !important;
}
#addrow{font-size: 12px;}

</style>
<div class="content-wrapper">
    <script type="text/javascript">
        $(document).ready(function() {

            $('.eighteen').css({
                'display': 'none'
            });
            $('.twelve').css({
                'display': 'none'
            });
            $('.five').css({
                'display': 'none'
            });
        });
    </script>
    <!-- Content -->
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add Purchase</h4> -->

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Add New Purchase</h5>
                        <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div id="validation-errors-sale"></div>
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('purchase.store') }}" id="saleForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body p-32" id="tblData">
                            <div class="row mb-3">
                                <div class="col-md-4 fv-plugins-icon-container" id="tblDataparty">
                                    <label class="form-label">Party</label>
                                    <div class="border p-2 input-group col-md-4">
                                        <input type="text" required class="form-control party" id="party" required name="party" value="">
                                        <input type="hidden" required class="party" id="partyid" required name="partyid" value="">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal1">+</button>
                                    </div>
                                </div>

                                <div class="col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="formValidationName">Purchase Date</label>
                                    <input type="text" class="form-control" id="datetimepicker9" required name="purchase_date" value="{{ date('d-m-Y') }}">
                                    @if ($errors->has('purchase_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('purchase_date') }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="formValidationName">Purchase No</label>
                                    <input type="text" id="formValidationName" required class="form-control" value="" name="purchase_no">

                                </div>
                                <div class="col-md-4 fv-plugins-icon-container">
                                    <label class="form-label">Address</label>
                                    <textarea style="border: 2px solid transparent" class="form-control party" id="party_detail" disabled></textarea>
                                    <small>Phone : </small>
                                    <input style="border: 2px solid transparent" type="text" class="party"
                                        id="partyphone" disabled>

                                    <input type="hidden" class="state"
                                        id="state">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"><button type="button" class="btn btn-primary addrowcontainer float-right mb-2">Add New Row</button></div>

                                <div class="col-6">
                                    <span id="alertentries"></span>
                                </div>
                                <!-- <hr> -->
                            </div>
                            <div class="m-1  justify-content-between align-items-center" id="addrow">

                                <div class="row">
                                    <div class="col-md-4 border p-1 text-center">
                                        <b>Particulars</b>
                                    </div>
                                    <div class="col-md-3 border p-1 text-center">
                                        <b>Rate Per Qty</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>QTY</b>
                                    </div>



                                    <div class="col-md-3 border p-1 text-center">
                                        <b>TOTAL AMOUNT</b>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description1" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description1" />
                                        <input type="hidden" class="form-control product_id" name="product_id1" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button> -->
                                        <div class="input-group mb-2">
                                            <div id="imei-fields" style="display: none;">
                                                <br>
                                                <div class="imei-fields-container" data-row="1">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field"
                                                            name="imei[1][]" placeholder="ENTER IMEI" />
                                                        <button type="button"
                                                            class="btn btn-outline-secondary add-imei"
                                                            data-row="1">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <input class="form-control uprice" type="number" dataid="1" name="rpqty1" id="rpqty1">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="number" dataid="1" name="qty1" id="qty1">
                                    </div>


                                    <div class="col-md-3 border p-2">
                                        <input class="form-control" type="number" readonly="readonly" id="total_amount1" name="total_amount1">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description2" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description2" />
                                        <input type="hidden" class="form-control product_id" name="product_id2" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button> -->
                                        <div class="input-group mb-2">
                                            <div id="imei-fields" style="display: none;">
                                                <br>
                                                <div class="imei-fields-container" data-row="2">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field"
                                                            name="imei[2][]" placeholder="ENTER IMEI" />
                                                        <button type="button"
                                                            class="btn btn-outline-secondary add-imei"
                                                            data-row="2">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <input class="form-control uprice" type="text" dataid="2" name="rpqty2" id="rpqty2">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text" dataid="2" name="qty2" id="qty2">
                                    </div>


                                    <div class="col-md-3 border p-2">
                                        <input class="form-control" type="number" readonly="readonly" id="total_amount2" name="total_amount2">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description3" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description3" />
                                        <input type="hidden" class="form-control product_id" name="product_id3" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button> -->
                                        <div class="input-group mb-2">
                                            <div id="imei-fields" style="display: none;">
                                                <br>
                                                <div class="imei-fields-container" data-row="3">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field"
                                                            name="imei[3][]" placeholder="ENTER IMEI" />
                                                        <button type="button"
                                                            class="btn btn-outline-secondary add-imei"
                                                            data-row="3">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <input class="form-control uprice" type="text" dataid="3" name="rpqty3" id="rpqty3">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text" dataid="3" name="qty3" id="qty3">
                                    </div>


                                    <div class="col-md-3 border p-2">
                                        <input class="form-control" type="number" readonly="readonly" id="total_amount3" name="total_amount3">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description4" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description4" />
                                        <input type="hidden" class="form-control product_id" name="product_id4" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button> -->
                                        <div class="input-group mb-2">
                                            <div id="imei-fields" style="display: none;">
                                                <br>
                                                <div class="imei-fields-container" data-row="4">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field"
                                                            name="imei[4][]" placeholder="ENTER IMEI" />
                                                        <button type="button"
                                                            class="btn btn-outline-secondary add-imei"
                                                            data-row="4">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <input class="form-control uprice" type="text" dataid="4" name="rpqty4" id="rpqty4">
                                    </div>


                                    <div class="col-md-2 border p-2">
                                        <input class="form-control gstperc" dataid="4" type="text" name="gst4" id="gst4">
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <input class="form-control" type="number" readonly="readonly" id="total_amount4" name="total_amount4">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description5" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description5" />
                                        <input type="hidden" class="form-control product_id" name="product_id5" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button> -->
                                        <div class="input-group mb-2">
                                            <div id="imei-fields" style="display: none;">
                                                <br>
                                                <div class="imei-fields-container" data-row="5">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field"
                                                            name="imei[5][]" placeholder="ENTER IMEI" />
                                                        <button type="button"
                                                            class="btn btn-outline-secondary add-imei"
                                                            data-row="5">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <input class="form-control uprice" type="text" dataid="5" name="rpqty5" id="rpqty5">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text" dataid="5" name="qty5" id="qty5">
                                    </div>


                                    <div class="col-md-3 border p-2">
                                        <input class="form-control" type="number" readonly="readonly" id="total_amount5" name="total_amount5">
                                    </div>
                                </div>
                            </div>

                            <div class="m-1  justify-content-between align-items-center">

                                <div class="row">




                                    <div class="col-md-3 border p-2">
                                        <!-- Total Amount: ₹ -->
                                         <input readonly class="totalstyle" type="hidden" name="totalAmountDisplay" id="totalAmountDisplay" value="0" />

                                    </div>

                                    <div class="col-md-4 border p-2">
                                        <div class="">

                                            <!-- <table class="gsttable">
                                                <tr class="eighteen">
                                                    <td>18%</td>
                                                    <td>CGST: ₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_18_cgst" id="taxAmount_18_cgst"></td>
                                                    <td>SGST: ₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_18_sgst" id="taxAmount_18_sgst"></td>
                                                </tr>
                                                <tr class="twelve">
                                                    <td>12%</td>
                                                    <td>CGST: ₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_12_cgst" id="taxAmount_12_cgst"></td>
                                                    <td>SGST: ₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_12_sgst" id="taxAmount_12_sgst"></td>
                                                </tr>
                                                <tr class="five">
                                                    <td>5%</td>
                                                    <td>CGST: ₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_5_cgst" id="taxAmount_5_cgst"></td>
                                                    <td>SGST: ₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_5_sgst" id="taxAmount_5_sgst"></td>
                                                </tr>
                                            </table> -->
                                            <!-- <div class="col-md-2 p-2">
                                                <b class="mt-1">18%</b>
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <b class="mt-1">CGST: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount_18_cgst" id="taxAmount_18_cgst">
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <b class="mt-1">SGST: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount_18_sgst" id="taxAmount_18_sgst">
                                            </div> -->
                                        </div>
                                        <!-- <div class="row twelve">
                                            <div class="col-md-2 p-2">
                                                <b class="mt-1">12%</b>
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <b class="mt-1">CGST: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount_12_cgst" id="taxAmount_12_cgst">
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <b class="mt-1">SGST: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount_12_sgst" id="taxAmount_12_sgst">
                                            </div>
                                        </div>
                                        <div class="row five">
                                            <div class="col-md-2 p-2">
                                                <b class="mt-1">5%</b>
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <b class="mt-1">CGST: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount_5_cgst" id="taxAmount_5_cgst">
                                            </div>
                                            <div class="col-md-5 p-2">
                                                <b class="mt-1">SGST: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount_5_sgst" id="taxAmount_5_sgst">
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-2 border p-2"></div>
                                    <div class="col-md-3 border p-2">
                                        <b class="mt-1">Net Amount: ₹</b> <input readonly type="text" class="totalstyle" value="0" name="net_amount" id="netAmount">



                                    </div>
                                </div>

                                <div class="row mt-0">
                                    <!-- <div class="col-md-3">
                                <label>CGST (%)</label>
                                <input type="text" class="form-control border-bottom" placeholder="CGST Rate" name="cgst_rate" id="cgst" oninput="calculateNetAmount()">
                                <span class="float-right gststyle" id="cgstDisplay">0</span>
                                <input type="hidden" id="cgstAmount" name="cgst_amount" value="0">
                                </div>

                                 <div class="col-md-3">
                                <label>SGST (%)</label>
                                <input type="text" class="form-control border-bottom" placeholder="SGST Rate" name="sgst_rate" id="sgst" oninput="calculateNetAmount()">
                                <span class="float-right gststyle" id="sgstDisplay">0</span>
                                <input type="hidden" id="sgstAmount" name="sgst_amount" value="0">
                                </div>

                                <div class="col-md-3">
                                    <label>IGST (%)</label>
                                    <input type="text" class="form-control border-bottom" placeholder="IGST Rate" name="igst_rate" id="igst" oninput="calculateNetAmount()">
                                    <span class="float-right gststyle" id="igstDisplay">0</span>
                                    <input type="hidden" id="igstAmount" name="igst_amount" value="0">
                                </div> -->

                                    <!-- <div class="col-md-3">
                                    <ul style="list-style: none;float: right;">
                                        <li>
                                            <b>Total Amount:</b> ₹ <span type="text" id="totalAmountDisplay">0</span>
                                        </li>
                                        <li>
                                            <b>Tax:</b> ₹ <span type="text" id="taxDisplay">0</span>
                                            <input type="hidden" value="0" name="tax_amount" id="taxAmount">
                                        </li>
                                        <li>
                                            <b>Net Amount:</b> ₹ <span type="text" id="netAmountDisplay">0</span>
                                            <input type="hidden" value="0" name="net_amount" id="netAmount">
                                        </li>
                                    </ul>
                                </div> -->
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <!-- <div class="form-group">
                                        <input type="text" name="declaration" class="form-control border-bottom" id="validationCustom05" placeholder="Declaration">
                                    </div> -->
                                        <input type="hidden" name="totQues" id="totQues" value="5" /></td>
                                        <input type="hidden" value="" name="purchase_url" id="purchase_url">

                                        <div class="col-md-4 fv-plugins-icon-container">
                                            <label class="form-label">Cash Type</label>
                                            <select name="cash_type" required id="cash_type" class="form-select">
                                                <option value="">Select Cash Type</option>
                                                @php
                                                $cash_type = [ 'cash' => 'Cash','credit' => 'Credit'];
                                                @endphp
                                                @foreach ($cash_type as $key => $val)
                                                <option @if(old('cash_type')==$key) selected @endif value="{{$key}}">{{$val}}</option>
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
                            </div>


                            <!-- <button type="submit" class="btn btn-primary">Send</button> -->
                            <button id="saleFormSubmit" type="submit" class="btn btn-primary float-right mb-2">Bill</button>

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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="validation-errors-product"></div>

                <form method="POST" id="productForm" action="{{ route('product.ajaxsave') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" value="{{ old('image') }}" />
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
                            <input class="form-check-input" type="radio" checked name="item_type" id="inlineRadio1" value="sale">
                            <label class="form-check-label" for="inlineRadio1">Sale</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="item_type" id="inlineRadio2" value="service">
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
                            <option @if(old('category')==$val->name) selected @endif
                                value="{{$val->name}}">{{$val->name}}</option>
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
                        <input type="text" class="form-control" name="item_code_barcode" value="{{ old('item_code_barcode') }}" />
                        @if ($errors->has('item_code_barcode'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('item_code_barcode') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="item_name" value="{{ old('item_name') }}" />
                        @if ($errors->has('item_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('item_name') }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Sale Price</label>
                        <input type="text" class="form-control" name="sale_price" value="{{ old('sale_price') }}" />
                        @if ($errors->has('sale_price'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sale_price') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">GST Rate</label>
                        <input type="text" class="form-control" name="gst_rate" value="{{ old('gst_rate') }}" />
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
                            <option @if(old('units')==$val) selected @endif value="{{$key}}">{{$val}}</option>
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
                        <input type="text" class="form-control" name="stock" value="{{ old('stock') }}" />
                        @if ($errors->has('stock'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('stock') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">HSN Code</label>
                        <input type="text" class="form-control" name="hsn_code" value="{{ old('hsn_code') }}" />
                        @if ($errors->has('hsn_code'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('hsn_code') }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" value="{{ old('description') }}" rows="4" cols="10" placeholder="Enter the description"></textarea>
                        @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @enderror
                    </div>



                    <button type="submit" id="saveBtn" class="btn btn-primary">Send</button>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="basicModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="validation-errors-party"></div>
                <form method="POST" id="partyForm" action="{{ route('party.ajaxsave') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Type and Party Type -->
                    <div class="mb-3 row">
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <div>
                                <input type="radio" id="sale" name="transaction_type" value="sale"
                                 disabled  />
                                <label for="sale">Sale</label>
                                <input type="radio" id="purchase" name="transaction_type" value="purchase" checked  />
                                <label for="purchase">Purchase</label>
                            </div>
                            @if ($errors->has('transaction_type'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('transaction_type') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Party Type</label>
                            <select name="party_type" id="party_type" class="form-select">
                                @php
                                $party_type = [
                                'unregistered' => 'Unregistered',

                                ];
                                @endphp
                                @foreach ($party_type as $key => $val)
                                <option value="{{ $key }}"
                                    @if (old('party_type', 'unregistered' )==$key) selected @endif>{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('party_type'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('party_type') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <select class="form-control" name="state">
                                    <option value="">Select State</option>
                                    <option value="Andhra Pradesh" {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh" {{ old('state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                    <option value="Assam" {{ old('state') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                    <option value="Bihar" {{ old('state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                    <option value="Chhattisgarh" {{ old('state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                    <option value="Goa" {{ old('state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                    <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                    <option value="Haryana" {{ old('state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                    <option value="Himachal Pradesh" {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                    <option value="Jharkhand" {{ old('state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                    <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                    <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                    <option value="Madhya Pradesh" {{ old('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                    <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                    <option value="Manipur" {{ old('state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                    <option value="Meghalaya" {{ old('state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                    <option value="Mizoram" {{ old('state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                    <option value="Nagaland" {{ old('state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                    <option value="Odisha" {{ old('state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                    <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                    <option value="Rajasthan" {{ old('state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                    <option value="Sikkim" {{ old('state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                    <option value="Tamil Nadu" {{ old('state') == 'Tamil Nadu' ? 'selected' : 'selected' }}>Tamil Nadu</option>
                                    <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                    <option value="Tripura" {{ old('state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                    <option value="Uttar Pradesh" {{ old('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                    <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                    <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                    <option value="Andaman and Nicobar Islands" {{ old('state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                    <option value="Chandigarh" {{ old('state') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                    <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                    <option value="Lakshadweep" {{ old('state') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                    <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                    <option value="Puducherry" {{ old('state') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                                </select>
                                @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Opening Balance</label>
                                <input type="text" class="form-control" name="opening_balance" placeholder="0" value="0" />
                                @if ($errors->has('opening_balance'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('opening_balance') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Party Details Section -->
                    <h5>Party Details</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" />
                                @if ($errors->has('name'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Phone No</label>
                                <input type="text" class="form-control" name="phone_no"
                                    value="{{ old('phone_no') }}" />
                                @if ($errors->has('phone_no'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" />
                                @if ($errors->has('email'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="gstin-field" class="mb-3" style="display: none;">
                                <label class="form-label">GSTIN</label>
                                <input type="text" class="form-control" name="gstin"
                                    value="{{ old('gstin') }}" />
                                @if ($errors->has('gstin'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('gstin') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <h5>Address</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Business Address</h6>
                            <div class="mb-3">
                                <label class="form-label">Address 1</label>
                                <input type="text" class="form-control" name="billing_address_1"
                                    id="billing_address_1" value="{{ old('billing_address_1') }}" />
                                @if ($errors->has('billing_address_1'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('billing_address_1') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address 2</label>
                                <input type="text" class="form-control" name="billing_address_2"
                                    id="billing_address_2" value="{{ old('billing_address_2') }}" />
                                @if ($errors->has('billing_address_2'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('billing_address_2') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" class="form-control" name="billing_pincode"
                                    id="billing_pincode" value="{{ old('billing_pincode') }}" />
                                @if ($errors->has('billing_pincode'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('billing_pincode') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6" id="shipping-address-section">
                            <h6>Shipping Address</h6>
                            <div>
                                <input type="radio" id="same_address_yes" name="same_address" value="yes" />
                                <label for="same_address_yes">Same as Business Address</label>
                                <input type="radio" id="same_address_no" name="same_address" value="no"
                                    checked />
                                <label for="same_address_no">Different Address</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address 1</label>
                                <input type="text" class="form-control" name="shipping_address_1"
                                    id="shipping_address_1" value="{{ old('shipping_address_1') }}" />
                                @if ($errors->has('shipping_address_1'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('shipping_address_1') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address 2</label>
                                <input type="text" class="form-control" name="shipping_address_2"
                                    id="shipping_address_2" value="{{ old('shipping_address_2') }}" />
                                @if ($errors->has('shipping_address_2'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('shipping_address_2') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" class="form-control" name="shipping_pincode"
                                    id="shipping_pincode" value="{{ old('shipping_pincode') }}" />
                                @if ($errors->has('shipping_pincode'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('shipping_pincode') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="partysaveBtn" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="basicModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <img id="logo" src="bill/logo.png" title="MyDailyBill" alt="MyDailyBill" />
                            </div>
                            <div class="col-sm-7">
                                <h4 class="text-4 mb-1">Sold By: MyDailyBill Inc.</h4>
                                <p class="lh-base mb-0">Ship-from Address: MyDailyBill Inc, 2705 N. Enterprise St, Orange, CA 92865</p>
                            </div>
                            <div class="col-sm-2">
                                <strong>Invoice No:</strong> 16835
                            </div>
                        </div>
                        <hr>
                    </header>

                    <!-- Main Content -->
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
                    <!-- Footer -->
                    <footer class="mt-5">


                        <div class="text-end mb-4">
                            <img id="logo" src="bill/logo-sm.png" title="MyDailyBill" alt="MyDailyBill" /><br>
                            <div class="lh-1 text-black-50">Thank You!</div>
                            <div class="lh-1 text-black-50 text-0"><small>For Shopping with us</small></div>
                        </div>

                        <p class="text-0 mb-0"><strong>Returns Policy:</strong> At MyDailyBill we try to deliver perfectly each and every
                            time. But in the off-chance that you need to return the item, please do so with the original Brand
                            box/price
                            tag, original packing and invoice without which it will be really difficult for us to act on your
                            request. Please help us in helping you. Terms and conditions apply.</p>
                        <hr class="my-2">
                        <p class="text-center">Helpline: 1800 222 9888</p>
                        <div class="text-center">
                            <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print &
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
                    `<div class="border p-2 input-group col-md-4" style="width: 33.33333333%;"><input class="form-control product_name" tabindex="1" name="item_description${cIncr}" /><input type="hidden" class="form-control product_id" name="product_id${cIncr}" /> <div class="input-group mb-2"> <div id="imei-fields" style="display: none;">
                        <br>
                        <div class="imei-fields-container" data-row="${cIncr}">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control imei-field" name="imei[${cIncr}][]" placeholder="ENTER IMEI" />
                                <button type="button" class="btn btn-outline-secondary add-imei" data-row="${cIncr}">+</button>
                            </div>
                        </div>
                    </div></div></div>` +
                    `<div class="col-md-3 border p-2"><input class="form-control uprice" type="text" dataid="${cIncr}" name="rpqty${cIncr}" id="rpqty${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control qtybox" tabindex="1" type="number" dataid="${cIncr}" name="qty${cIncr}" id="qty${cIncr}"></div>` +
                    // `<div class="col-md-2 border p-2"><input class="form-control amountbox" tabindex="1" type="number" dataid="${cIncr}" name="amount${cIncr}" id="taxableamount${cIncr}"></div>` +
                    //`<div class="col-md-1 border p-2"><input class="form-control gstperc" type="text" dataid="${cIncr}" name="gst${cIncr}" id="gst${cIncr}"><input class="gstvaldata" type="hidden" dataid="${cIncr}" name="gstvaldata${cIncr}" id="gstvaldata${cIncr}"></div>` +
                    `<div class="col-md-3 border p-2"><input class="form-control" type="number" name="total_amount${cIncr}" id="total_amount${cIncr}" readonly></div>` +
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
                // var gstValue = document.getElementById("gst" + dRecid).value;
                // if (gstValue === "") {
                //     gstValue = 0;
                // }
                // if (qtyValue === "") {
                //     qtyValue = 0;
                // }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }

                // if (gstValue > 0) {
                //     var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                //     var percentage = parseFloat(gstValue) / 100;
                //     var gstAmount = totValue * percentage; // Calculating GST (18%)
                //     var totalAmountWithGST = totValue + gstAmount;

                // document.getElementById("taxableamount" + dRecid).value = totValue;
                //     document.getElementById("gstvaldata" + dRecid).value = gstAmount.toFixed(2);
                //     document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount', gstValue);
                //     document.getElementById("taxableamount" + dRecid).setAttribute('data-taxable-amount', gstValue);

                //     document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2); // Fixed to 2 decimal places
                // } else {
                var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                // document.getElementById("taxableamount" + dRecid).value = totValue;

                document.getElementById("total_amount" + dRecid).value = totValue;
                // document.getElementById("gst" + dRecid).value = gstValue;
                // document.getElementById("gstvaldata" + dRecid).value = gstValue;

                // }
                /*
                // Initialize a variable to store the total sum
                let total_Amount = 0;

                // Find all elements with data-gst-amount equal to 18
                const total_Amount_elements = document.querySelectorAll('[data-taxable-amount="' + gstValue + '"]');

                // Loop through each total_Amount_element
                total_Amount_elements.forEach(total_Amount_element => {
                    // Retrieve the corresponding total_row_ value and add it to the total sum
                    const total_row_Value = parseFloat(total_Amount_element.value); // Assuming total_row_ contains numeric values
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
                    const gstvaldataValue = parseFloat(element.value); // Assuming gstvaldata contains numeric values
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

                */
                // var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                // document.getElementById("total_amount" + dRecid).value = totValue;
                finalTotalValue();
            });
        });

        document.querySelectorAll('.uprice').forEach(function(element) {
            element.addEventListener('keyup', function() {
                var dRecid = this.getAttribute("dataid");
                var qtyValue = document.getElementById("qty" + dRecid).value;
                // var gstValue = document.getElementById("gst" + dRecid).value;
                var uPriceVal = this.value;
                // if (gstValue === "") {
                //     gstValue = 0;
                // }
                // if (qtyValue === "") {
                //     qtyValue = 0;
                // }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }
                // if (gstValue > 0) {
                //     var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                //     var percentage = parseFloat(gstValue) / 100;
                //     var gstAmount = totValue * percentage; // Calculating GST (18%)
                //     var totalAmountWithGST = totValue + gstAmount;
                //     document.getElementById("gstvaldata" + dRecid).value = gstAmount;
                //     document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount', gstValue);
                //     document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2); // Fixed to 2 decimal places
                // } else {
                var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                document.getElementById("total_amount" + dRecid).value = totValue;
                // document.getElementById("gst" + dRecid).value = gstValue;
                // document.getElementById("gstvaldata" + dRecid).value = gstValue;

                // }
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
                // var gstValue = this.value;
                // if (gstValue === "") {
                //     gstValue = 0;
                // }
                // if (qtyValue === "") {
                //     qtyValue = 0;
                // }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }

                // if (gstValue > 0) {
                //     var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                //     var percentage = parseFloat(gstValue) / 100;
                //     var gstAmount = totValue * percentage; // Calculating GST (18%)
                //     var totalAmountWithGST = totValue + gstAmount;
                //     document.getElementById("gstvaldata" + dRecid).value = gstAmount;
                //     document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount', gstValue);

                //     document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2); // Fixed to 2 decimal places
                // } else {
                var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                document.getElementById("total_amount" + dRecid).value = totValue;
                // document.getElementById("gst" + dRecid).value = gstValue;
                // document.getElementById("gstvaldata" + dRecid).value = gstValue;

                // }

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

<script type="text/javascript">
    var path = "{{ route('purchaseautocomplete') }}";

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
                                        sale_price: product.sale_price,
                                        gst_rate: product.gst_rate,
                                        id: product.id,
                                        stock: product.stock,
                                        imei_required: product.imei

                                    };
                                }));
                            } else {
                                var default_val = 0;
                                // $(this).val(ui.item.label);
                                console.log($(this).closest("div").parent().find('.uprice').val());
                                $(this).closest("div").parent().find('.uprice').val('0');
                                $(this).closest("div").parent().find('.gstperc').val('0');
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
                    $(this).closest("div").parent().find('.qtybox').attr('data-avail-qty', ui.item.stock);
                    console.log(ui);
                    if (ui.item.imei_required === "yes") {
                        console.log("IMEI required");
                        $(this).closest("div").parent().find('#imei-fields').show();
                    } else {
                        console.log("IMEI not required");
                        $(this).closest("div").parent().find('#imei-fields').remove();
                        $(this).closest("div").parent().find('.add-imei').remove();
                    }

                    return false;
                }
            });
        });
    });
    var partypath = "{{ route('partyautocomplete') }}";

    $(document).ready(function() {
        // Initialize autocomplete only once
        $('.party').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: partypath,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        partysearch: request.term,
                        type: "purchase"
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            response(data.map(function(party) {
                                return {
                                    label: party.name,
                                    id: party.id,
                                    party_detail: [
                                        party.billing_address_1,
                                        party.billing_address_2,
                                        party.billing_pincode
                                    ].filter(Boolean).join(', '),
                                    partyphone: party.phone_no,
                                    state: party.state
                                };
                            }));
                        } else {
                            console.log("No matching party found.");
                            response([]); // Send an empty response
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data: ", status, error);
                    }
                });
            },
            select: function(event, ui) {
                $(this).val(ui.item.label);
                $('#partyid').val(ui.item.id);
                $('#party_detail').val(ui.item.party_detail);
                $('#partyphone').val(ui.item.partyphone);
                $('#state').val(ui.item.state);
                return false; // Prevent default behavior
            }
        });
    });


    // $(document).ready(function(){
    //     $('.row').each(function(){
    //         $(this).closest('div').parent().find('.gstperc').val('18');
    //     });
    // });
</script>


<script type="text/javascript">
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
                        $('#validation-errors-product').append('<div class="alert alert-danger">' + value + '</div');
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
                        $('#validation-errors-party').append('<div class="alert alert-danger">' + value + '</div');
                    });

                }
            });
        });



    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const partyTypeSelect = document.getElementById('party_type');
        const gstinField = document.getElementById('gstin-field');
        const saleRadio = document.getElementById('sale');
        const purchaseRadio = document.getElementById('purchase');
        const shippingAddressSection = document.getElementById('shipping-address-section');

        function toggleGstinField() {
            if (partyTypeSelect.value === 'registered') {
                gstinField.style.display = 'block';
            } else {
                gstinField.style.display = 'none';
            }
        }

        function toggleAddressFields() {
            if (saleRadio.checked) {
                shippingAddressSection.style.display = 'block';
            } else {
                shippingAddressSection.style.display = 'none';
            }
        }

        // Initial checks
        toggleGstinField();
        toggleAddressFields();

        // Add event listeners
        partyTypeSelect.addEventListener('change', toggleGstinField);
        saleRadio.addEventListener('change', toggleAddressFields);
        purchaseRadio.addEventListener('change', toggleAddressFields);

        // Address copy functionality
        const sameAddressRadio = document.getElementById('same_address_yes');
        const differentAddressRadio = document.getElementById('same_address_no');

        const billingAddressFields = {
            address1: document.getElementById('billing_address_1'),
            address2: document.getElementById('billing_address_2'),
            pincode: document.getElementById('billing_pincode')
        };

        const shippingAddressFields = {
            address1: document.getElementById('shipping_address_1'),
            address2: document.getElementById('shipping_address_2'),
            pincode: document.getElementById('shipping_pincode')
        };

        function copyAddress() {
            if (sameAddressRadio.checked) {
                shippingAddressFields.address1.value = billingAddressFields.address1.value;
                shippingAddressFields.address2.value = billingAddressFields.address2.value;
                shippingAddressFields.pincode.value = billingAddressFields.pincode.value;
            } else {
                shippingAddressFields.address1.value = '';
                shippingAddressFields.address2.value = '';
                shippingAddressFields.pincode.value = '';
            }
        }

        // Add event listeners for radio buttons
        sameAddressRadio.addEventListener('change', copyAddress);
        differentAddressRadio.addEventListener('change', copyAddress);
    });
</script>
<script>
       $(document).on('input', '.imei-field', function() {
        var imeiField = $(this);

        if (imeiField.val().trim() !== '') {
            var row = imeiField.closest('.imei-fields-container').data('row');
            var nextRow = imeiField.closest('.input-group').next('.input-group');
            if (nextRow.length === 0) {
                addImeiRow(row);
            }

            updateQuantity(row);
            calculateRow(row);
            finalTotalValue();
        }
        function addImeiRow(row) {
        var container = $(`.imei-fields-container[data-row="${row}"]`);

        var newInput = `
        <div class="input-group mb-2">
            <input type="text" class="form-control imei-field" name="imei[${row}][]" placeholder="ENTER IMEI" />
            <button type="button" class="btn btn-outline-secondary remove-imei">Remove</button>
        </div>
    `;

        container.append(newInput);

        // Handle removing an IMEI field
        container.find('.remove-imei').on('click', function() {
            $(this).parent().remove();
            updateQuantity(row);
            calculateRow(row);
            finalTotalValue();
        });

        updateQuantity(row);
    }
    });

    function updateQuantity(row) {
        var imeiFields = $(`.imei-fields-container[data-row="${row}"] .imei-field`);
        var quantityField = $(`#qty${row}`);
        var filledCount = imeiFields.filter(function() {
            return $(this).val().trim() !== '';
        }).length;
        quantityField.val(filledCount);
        finalTotalValue(row);
    }

    function calculateRow(aaa) {
        var price = $(`#rpqty`+aaa).val();
        var qty = $(`#qty`+aaa).val();
        var line_total = price * qty;
        $(`#total_amount`+aaa).val(line_total);
    }


    function finalTotalValue() {
        var totItems = document.getElementById("totQues").value;
        var toPrice = 0;
        // var gstPrice = 0;

        for (var i = 1; i <= totItems; i++) {
            var indiItemPriceElement = document.getElementById("total_amount" + i);
            // var gstItemPriceElement = document.getElementById("gstvaldata" + i);

            if (indiItemPriceElement !== null && indiItemPriceElement !== undefined) {
                var indiItemPrice = indiItemPriceElement.value;
                if (indiItemPrice !== "") {
                    toPrice += parseFloat(indiItemPrice);
                }
            }

            // if (gstItemPriceElement !== null && gstItemPriceElement !== undefined) {
            //     var gstItemPrice = gstItemPriceElement.value;
            //     if (gstItemPrice !== "") {
            //         gstPrice += parseFloat(gstItemPrice);
            //     }
            // }
        }

        var withOutGst = toPrice; //- gstPrice

        document.getElementById("totalAmountDisplay").value = toPrice.toFixed(2);
        // document.getElementById("taxAmount").value = gstPrice.toFixed(2);
        // document.getElementById("netAmountDisplay").value = toPrice.toFixed(2);
        document.getElementById("netAmount").value = toPrice.toFixed(2);
    }
</script>
@endsection
