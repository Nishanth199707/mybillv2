@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <script type="text/javascript">
        $(document).ready(function() {

            $('.twentyeight').css({
                'display': 'none'
            });
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
        <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span>  Sale Return / Credit Note</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"></h5>
                        <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div id="validation-errors-sale"></div>
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" autocomplete="off" method="POST" action="{{ route('sale.store') }}" id="saleForm" enctype="multipart/form-data">
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
                                    <label class="form-label" for="formValidationName">Invoice Date</label>
                                    <input type="text" class="form-control" id="datetimepicker9" required name="invoice_date" value="{{ date('d-m-Y') }}">
                                    @if ($errors->has('invoice_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('invoice_date') }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 fv-plugins-icon-container">
                                    <label class="form-label" for="formValidationName">Invoice No</label>
                                    <input type="text" id="formValidationName" class="form-control" readonly placeholder="John Doe" value="{{ $invoice_no}}" name="invoice_no">

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
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>Rate Per Qty</b>
                                    </div>
                                    <div class="col-md-1 border p-1 text-center">
                                        <b>QTY</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>AMOUNT</b>
                                    </div>

                                    <div class="col-md-1 border p-1 text-center">
                                        <b>GST Rate</b>
                                    </div>

                                    <div class="col-md-2 border p-1 text-center">
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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="number" dataid="1" name="rpqty1" id="rpqty1">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="number" dataid="1" name="qty1" id="qty1">
                                    </div>

                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="number" dataid="1" name="amount1" id="taxableamount1">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="1" type="number" name="gst1" id="gst1">
                                        <input class="gstvaldata" type="hidden" dataid="1" name="gstvaldata1" id="gstvaldata1">
                                    </div>

                                    <div class="col-md-2 border p-2">
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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="2" name="rpqty2" id="rpqty2">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="number" dataid="2" name="qty2" id="qty2">
                                    </div>

                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="number" dataid="2" name="amount2" id="taxableamount2">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="2" type="text" name="gst2" id="gst2">
                                        <input class="gstvaldata" type="hidden" dataid="2" name="gstvaldata2" id="gstvaldata2">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly" id="total_amount2" name="total_amount2">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description3" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description3" />
                                        <input type="hidden" class="form-control product_id" name="product_id3" />
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="3" name="rpqty3" id="rpqty3">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="number" dataid="3" name="qty3" id="qty3">
                                    </div>

                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="number" dataid="3" name="amount3" id="taxableamount3">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="3" type="text" name="gst3" id="gst3">
                                        <input class="gstvaldata" type="hidden" dataid="3" name="gstvaldata3" id="gstvaldata3">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly" id="total_amount3" name="total_amount3">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description4" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description4" />
                                        <input type="hidden" class="form-control product_id" name="product_id4" />
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="4" name="rpqty4" id="rpqty4">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="number" dataid="4" name="qty4" id="qty4">
                                        <input class="gstvaldata" type="hidden" dataid="4" name="gstvaldata4" id="gstvaldata4">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="number" dataid="4" name="amount4" id="taxableamount4">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="4" type="text" name="gst4" id="gst4">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly" id="total_amount4" name="total_amount4">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-md-4 border p-2">
                                        <input class="form-control product_name" tabindex="1" name="item_description5" />
                                    </div> -->
                                    <div class="border p-2 input-group col-md-4" style="width: 33.33333333%;">
                                        <input class="form-control product_name" tabindex="1" name="item_description5" />
                                        <input type="hidden" class="form-control product_id" name="product_id5" />
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="5" name="rpqty5" id="rpqty5">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="number" dataid="5" name="qty5" id="qty5">
                                    </div>

                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="number" dataid="5" name="amount5" id="taxableamount5">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="5" type="text" name="gst5" id="gst5">
                                        <input class="gstvaldata" type="hidden" dataid="5" name="gstvaldata5" id="gstvaldata5">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly" id="total_amount5" name="total_amount5">
                                    </div>
                                </div>
                            </div>

                            <div class="m-1  justify-content-between align-items-center">

                                <div class="row">




                                    <!-- <div class="col-md-3 border p-2"> -->
                                        <input type="hidden" readonly class="totalstyle" name="totalAmountDisplay" id="totalAmountDisplay" value="0" /><br>
                                        <!-- <input type="hidden" readonly class="totalstyle1" name="taxable28Amount" id="taxable28Amount" value="0" /><br>
                                        <input type="hidden" readonly class="totalstyle1" name="taxable18Amount" id="taxable18Amount" value="0" /><br>
                                        <input type="hidden" readonly class="totalstyle1" name="taxable12Amount" id="taxable12Amount" value="0" /><br>
                                        <input type="hidden" readonly class="totalstyle1" name="taxable5Amount" id="taxable5Amount" value="0" /> -->

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
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="taxable28Amount" id="taxable28Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_28_cgst" id="taxAmount_28_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_28_sgst" id="taxAmount_28_sgst"></td>
                                                    <td>-</td>
                                                </tr>
                                                <tr class="eighteen">
                                                    <td>18%</td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="taxable18Amount" id="taxable18Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_18_cgst" id="taxAmount_18_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_18_sgst" id="taxAmount_18_sgst"></td>
                                                    <td>-</td>
                                                </tr>
                                                <tr class="twelve">
                                                    <td>12%</td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="taxable12Amount" id="taxable12Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_12_cgst" id="taxAmount_12_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_12_sgst" id="taxAmount_12_sgst"></td>
                                                    <td>-</td>
                                                </tr>
                                                <tr class="five">
                                                    <td>5%</td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="taxable5Amount" id="taxable5Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_5_cgst" id="taxAmount_5_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0" class="totalstyle1" name="tax_amount_5_sgst" id="taxAmount_5_sgst"></td>
                                                    <td>-</td>
                                                </tr>
                                            </table>

                                        </div>

                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <b class="mt-1">Total Tax: ₹</b> <input type="text" readonly value="0" class="totalstyle" name="tax_amount" id="taxAmount">
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <b class="mt-1">Total Amount: ₹</b> <input readonly type="text" class="totalstyle" value="0" name="net_amount" id="netAmount">



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
                                        <input type="hidden" value="" name="invoice_url" id="invoice_url">

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

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script>
            , made with ❤️ by
            <a href="https://themeselection.com" target="_blank" class="footer-link fw-medium">ThemeSelection</a>
        </div>
        <!-- <div class="d-none d-lg-inline-block">
            <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
            <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

            <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

            <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank" class="footer-link">Support</a>
        </div> -->
    </div>
</footer>
<!-- / Footer -->

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
                        <div class="border p-2 input-group col-md-4">

                        <select name="category" id="category" class="form-select">

                            @foreach ($productcategory as $val)
                            <option @if(old('category')==$val->name) selected @endif
                                value="{{$val->name}}">{{$val->name}}</option>
                            @endforeach
                        </select>

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal1">+</button>
                                    </div>

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

<div class="modal fade" id="basicModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="validation-errors-party"></div>
                <form method="POST" id="partyForm" action="{{ route('party.ajaxsave') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Party Type</label>
                        <select name="party_type" id="party_type" class="form-select">
                            @php
                            $party_type = [
                            'registered' => 'Registered',
                            'unregistered' => 'Un Registered'
                            ];
                            @endphp
                            @foreach ($party_type as $key => $val)
                            <option @if(old('party_type')==$key) selected @endif value="{{$key}}">{{$val}}</option>
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
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">GSTIN</label>
                        <input type="text" class="form-control" name="gstin" value="{{ old('gstin') }}" />
                        @if ($errors->has('gstin'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gstin') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone No</label>
                        <input type="text" class="form-control" name="phone_no" value="{{ old('phone_no') }}" />
                        @if ($errors->has('phone_no'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone_no') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Address 1</label>
                        <input type="text" class="form-control" name="billing_address_1" value="{{ old('billing_address_1') }}" />
                        @if ($errors->has('billing_address_1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('billing_address_1') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Address 2</label>
                        <input type="text" class="form-control" name="billing_address_2" value="{{ old('billing_address_2') }}" />
                        @if ($errors->has('billing_address_2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('billing_address_2') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Pincode</label>
                        <input type="text" class="form-control" name="billing_pincode" value="{{ old('billing_pincode') }}" />
                        @if ($errors->has('billing_pincode'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('billing_pincode') }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Shipping Address 1</label>
                        <input type="text" class="form-control" name="shipping_address_1" value="{{ old('shipping_address_1') }}" />
                        @if ($errors->has('shipping_address_1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('shipping_address_1') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Address 2</label>
                        <input type="text" class="form-control" name="shipping_address_2" value="{{ old('shipping_address_2') }}" />
                        @if ($errors->has('shipping_address_2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('shipping_address_2') }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Pincode</label>
                        <input type="text" class="form-control" name="shipping_pincode" value="{{ old('shipping_pincode') }}" />
                        @if ($errors->has('shipping_pincode'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('shipping_pincode') }}</strong>
                        </span>
                        @enderror
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
                    `<div class="border p-2 input-group col-md-4" style="width: 33.33333333%;"><input class="form-control product_name" tabindex="1" name="item_description${cIncr}" /><input type="hidden" class="form-control product_id" name="product_id${cIncr}" /><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control uprice" type="text" dataid="${cIncr}" name="rpqty${cIncr}" id="rpqty${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control qtybox" tabindex="1" type="number" dataid="${cIncr}" name="qty${cIncr}" id="qty${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control amountbox" tabindex="1" type="number" dataid="${cIncr}" name="amount${cIncr}" id="taxableamount${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control gstperc" type="text" dataid="${cIncr}" name="gst${cIncr}" id="gst${cIncr}"><input class="gstvaldata" type="hidden" dataid="${cIncr}" name="gstvaldata${cIncr}" id="gstvaldata${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control" type="text" name="total_amount${cIncr}" id="total_amount${cIncr}"></div>` +
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
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount', gstValue);
                    document.getElementById("taxableamount" + dRecid).setAttribute('data-taxable-amount', gstValue);

                    document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2); // Fixed to 2 decimal places
                } else {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));

                    document.getElementById("total_amount" + dRecid).value = totValue;
                    document.getElementById("gst" + dRecid).value = gstValue;
                    document.getElementById("gstvaldata" + dRecid).value = gstValue;

                }

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
                            document.getElementById("taxable5Amount").value = total_Amount;
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
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount', gstValue);
                    document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2); // Fixed to 2 decimal places
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
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount', gstValue);

                    document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2); // Fixed to 2 decimal places
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

        var withOutGst = toPrice - gstPrice;

        document.getElementById("totalAmountDisplay").value = withOutGst.toFixed(2);
        document.getElementById("taxAmount").value = gstPrice.toFixed(2);
        // document.getElementById("netAmountDisplay").value = toPrice.toFixed(2);
        document.getElementById("netAmount").value = toPrice.toFixed(2);
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
                                        sale_price: product.sale_price,
                                        gst_rate: product.gst_rate,
                                        id: product.id,
                                        // stock: product.stock,

                                    };
                                }));
                            } else {
                                var default_val = 0;
                                // $(this).val(ui.item.label);
                                // console.log($(this).closest("div").parent().find('.uprice').val());
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
                    // $(this).closest("div").parent().find('.qtybox').attr('data-avail-qty', ui.item.stock);

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


        /*------------------------------------------
        --------------------------------------------
        Create Sale Code
        --------------------------------------------
        -------------------------------------------- */
        {{-- $('#saleFormSubmit').click(function(e) {
                    e.preventDefault();
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#saleForm').serialize(),
                        url: "{{ route('sale.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            var invoice_id = data.invoice_id;
                            console.log(data);
                            $('#saleForm').trigger("reset");
                            $('#invoice_url').val("{{ route('invoice', ':invoice_id') }}".replace(':invoice_id', invoice_id));
                            // table.draw();
                            // location.href = "{{ route('invoice', ':invoice_id') }}".replace(':invoice_id', invoice_id);
                            // var redirectUrl = "{{ route('invoice', ':invoice_id') }}".replace(':invoice_id', invoice_id);
                            // location.href = redirectUrl;

                            $.ajax({
                                url: "{{ route('invoice', ':invoice_id') }}".replace(':invoice_id', invoice_id),
                                type: 'GET',
                                dataType: 'json',

                                success: function(in_data) {
                                    console.log(in_data);
                                    $('#basicModal2').modal('show');

                                    // alert(data.success);
                                }
                            });

                        },
                        error: function(xhr) {
                            console.log('Error:', xhr);
                            $('#saveBtn').html('Save Changes');
                            $('#validation-errors-sale').html('');
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#validation-errors-sale').append('<div class="alert alert-danger">' + value + '</div');
                            });

                        }
                    });
                });
                --}}

    });
</script>

@endsection
