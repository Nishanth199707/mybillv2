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
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add Sale</h4> -->

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Add New Sale</h5>
                        <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div id="validation-errors-sale"></div>
                    <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" autocomplete="off" method="POST"
                        action="{{ route('sale.store') }}" id="saleForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body " id="tblData">

                            <div class="row ">

                                <div class="col-md-4 fv-plugins-icon-container" id="tblDataparty">
                                    <label class="form-label">Party</label>
                                    <div class="border input-group col-md-4">
                                        <input type="text" required class="form-control party" id="party"
                                            required name="party" value="">
                                            <input type="hidden" class="party_gst" id="party_gst" value="">
                                            <input type="hidden" class="gst_auth" id="gst_auth" value="{{ $businessCategory->gst_auth }}">
                                        <input type="hidden" required class="party" id="partyid" required
                                            name="partyid" value="">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal1" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 fv-plugins-icon-container">
                                    <label class="form-label" for="formValidationName">Invoice No</label>
                                    <input type="text" id="formValidationName" class="form-control" readonly
                                        placeholder=" " value="{{ $invoice_no }}" name="invoice_no">

                                </div>
                                <div class="col-md-2 fv-plugins-icon-container">
                                    <label class="form-label" for="formValidationName">Invoice Date</label>
                                    <input type="text" class="form-control" id="datetimepicker9" required
                                        name="invoice_date" value="{{ date('d-m-Y') }}">
                                    @if ($errors->has('invoice_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('invoice_date') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @if($setting->purchase_order_number == 'yes')
                                <div class="col-md-2">
                                    <label class="form-label">PO No</label>
                                    <input type="text" class="form-control" value="" name="purchase_order_number">
                                </div>
                                @else
                                @endif
                                @if($setting->purchase_order_date == 'yes')
                                <div class="col-md-2">
                                    <label class="form-label">PO Date</label>
                                    <input type="date" class="form-control" value="" name="purchase_order_date">
                                </div>
                                @else
                                @endif
                            </div>

                            <div class="row ">
                                <div class="col-md-4 fv-plugins-icon-container">
                                    <label class="form-label">Address</label>
                                    <textarea style="border: 2px solid transparent" class="form-control party" id="party_detail" disabled></textarea>
                                    <small>Phone : </small>
                                    <input style="border: 2px solid transparent" type="text" class="party"
                                        id="partyphone" disabled>

                                    <input type="hidden" class="state"
                                        id="state">
                                </div>

                                @if($setting->vehicle_no == 'yes')
                                <div class="col-md-2">
                                    <label class="form-label">Vehicle Number</label>
                                    <input type="text" class="form-control" value="" name="vehicle_no">
                                </div>
                                @else
                                @endif
                                <div class="col-6" style="text-align:right;"><button type="button"
                                        class="btn btn-primary addrowcontainer  mb-2" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Add New Row</button>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-6">
                                    {{-- <span id="alertentries"></span> --}}
                                </div>
                                <!-- <hr> -->
                            </div>
                            <div class="m-1  justify-content-between align-items-center" id="addrow">

                                <div class="row">
                                    <div class="col-md-3 border p-1 text-center">
                                        <b>Particulars</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>Rate </b>
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
                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <input class="form-control product_name" tabindex="1"
                                            name="item_description1" />
                                        <input type="hidden" class="form-control product_id" name="product_id1" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">+</button> -->
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="1"
                                            name="rpqty1" id="rpqty1">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text"
                                            dataid="1" name="qty1" id="qty1">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control discount" tabindex="1" type="text"
                                            dataid="1" name="dis1" id="dis1">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="text"
                                            dataid="1" name="amount1" id="taxableamount1">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="1" type="text"
                                            name="gst1" id="gst1">
                                        <input class="gstvaldata" type="hidden" dataid="1" name="gstvaldata1"
                                            id="gstvaldata1">
                                    </div>

                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="number" readonly="readonly"
                                            id="total_amount1" name="total_amount1">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <input class="form-control product_name" tabindex="1"
                                            name="item_description2" />
                                        <input type="hidden" class="form-control product_id" name="product_id2" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">+</button> -->
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="2"
                                            name="rpqty2" id="rpqty2">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text"
                                            dataid="2" name="qty2" id="qty2">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control discount" tabindex="1" type="text"
                                            dataid="2" name="dis2" id="dis2">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="text"
                                            dataid="2" name="amount2" id="taxableamount2">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="2" type="text"
                                            name="gst2" id="gst2">
                                        <input class="gstvaldata" type="hidden" dataid="2" name="gstvaldata2"
                                            id="gstvaldata2">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly"
                                            id="total_amount2" name="total_amount2">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <input class="form-control product_name" tabindex="1"
                                            name="item_description3" />
                                        <input type="hidden" class="form-control product_id" name="product_id3" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">+</button> -->
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="3"
                                            name="rpqty3" id="rpqty3">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text"
                                            dataid="3" name="qty3" id="qty3">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control discount" tabindex="1" type="text"
                                            dataid="3" name="dis3" id="dis3">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="text"
                                            dataid="3" name="amount3" id="taxableamount3">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="3" type="text"
                                            name="gst3" id="gst3">
                                        <input class="gstvaldata" type="hidden" dataid="3" name="gstvaldata3"
                                            id="gstvaldata3">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly"
                                            id="total_amount3" name="total_amount3">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <input class="form-control product_name" tabindex="1"
                                            name="item_description4" />
                                        <input type="hidden" class="form-control product_id" name="product_id4" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">+</button> -->
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="4"
                                            name="rpqty4" id="rpqty4">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text"
                                            dataid="4" name="qty4" id="qty4">
                                        <input class="gstvaldata" type="hidden" dataid="4" name="gstvaldata4"
                                            id="gstvaldata4">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control discount" tabindex="1" type="text"
                                            dataid="4" name="dis4" id="dis4">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="text"
                                            dataid="4" name="amount4" id="taxableamount4">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="4" type="text"
                                            name="gst4" id="gst4">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly"
                                            id="total_amount4" name="total_amount4">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <input class="form-control product_name" tabindex="1"
                                            name="item_description5" />
                                        <input type="hidden" class="form-control product_id" name="product_id5" />
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">+</button> -->
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="5"
                                            name="rpqty5" id="rpqty5">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox" tabindex="1" type="text"
                                            dataid="5" name="qty5" id="qty5">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control discount" value tabindex="1" type="text"
                                            dataid="5" name="dis5" id="dis5">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox" tabindex="1" type="text"
                                            dataid="5" name="amount5" id="taxableamount5">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="5" type="text"
                                            name="gst5" id="gst5">
                                        <input class="gstvaldata" type="hidden" dataid="5" name="gstvaldata5"
                                            id="gstvaldata5">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control" type="text" readonly="readonly"
                                            id="total_amount5" name="total_amount5">
                                    </div>
                                </div>
                            </div>

                            <div class="m-1  justify-content-between align-items-center">

                                <div class="row">




                                    <!-- <div class="col-md-3 border p-2"> -->
                                    <input type="hidden" readonly class="totalstyle" name="totalAmountDisplay"
                                        id="totalAmountDisplay" value="0" /><br>
                                    <!-- <input type="hidden" readonly class="totalstyle1" name="taxable28Amount" id="taxable28Amount" value="0" /><br>
                                        <input type="hidden" readonly class="totalstyle1" name="taxable18Amount" id="taxable18Amount" value="0" /><br>
                                        <input type="hidden" readonly class="totalstyle1" name="taxable12Amount" id="taxable12Amount" value="0" /><br>
                                        <input type="hidden" readonly class="totalstyle1" name="taxable5Amount" id="taxable5Amount" value="0" /> -->

                                    <!-- </div> -->

                                    <div class="col-md-7 border p-2">
                                        <div class="">

                                            <table class="gsttable" id="gstTable">
                                                <tr class="col-12">
                                                    <td class="col-4">Rate</td>
                                                    <td class="col-2">Taxable</td>
                                                    <td class="col-2">CGST: ₹ </td>
                                                    <td class="col-2">SGST: ₹ </td>
                                                    <td class="col-2">IGST: ₹ </td>
                                                </tr>
                                                <tr class="col-12 twentyeight">
                                                    <td class="col-4">28%</td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable28Amount"
                                                            id="taxable28Amount"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_cgst"
                                                            id="taxAmount_28_cgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_sgst"
                                                            id="taxAmount_28_sgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_igst"
                                                            id="taxAmount_28_igst"></td>
                                                </tr>
                                                <tr class="col-12 eighteen">
                                                    <td class="col-4">18%</td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable18Amount"
                                                            id="taxable18Amount"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_cgst"
                                                            id="taxAmount_18_cgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_sgst"
                                                            id="taxAmount_18_sgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_igst"
                                                            id="taxAmount_18_igst"></td>
                                                </tr>
                                                <tr class="col-12 twelve">
                                                    <td class="col-4">12%</td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable12Amount"
                                                            id="taxable12Amount"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_cgst"
                                                            id="taxAmount_12_cgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_sgst"
                                                            id="taxAmount_12_sgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_igst"
                                                            id="taxAmount_12_igst"></td>
                                                </tr>
                                                <tr class="col-12 five">
                                                    <td class="col-4">5%</td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable5Amount"
                                                            id="taxable5Amount"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_cgst"
                                                            id="taxAmount_5_cgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_sgst"
                                                            id="taxAmount_5_sgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_igst"
                                                            id="taxAmount_5_igst"></td>
                                                </tr>
                                                <tr class="col-12 zero">
                                                    <td class="col-4">0%</td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable0Amount"
                                                            id="taxable0Amount"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_0_cgst"
                                                            id="tax_amount_0_cgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_0_sgst"
                                                            id="tax_amount_0_sgst"></td>
                                                    <td class="col-2">₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_0_igst"
                                                            id="tax_amount_0_igst"></td>
                                                </tr>
                                            </table>

                                        </div>

                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <b class="">Total: ₹</b> <input type="text" readonly value="0"
                                            class="totalstyle" name="Total" id="TotalAmount">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <b class="">Total Tax: ₹</b> <input type="text" readonly
                                            value="0" class="totalstyle" style="font-size:18px;"
                                            name="tax_amount" id="taxAmount">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <b class="mt-1">Total Amount: ₹</b> <input readonly type="text"
                                            class="totalstyle" value="0" name="net_amount" id="netAmount">



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
                                    <input type="hidden" name="totQues" id="totQues" value="5" />
                                    <input type="hidden" name="invoice_url" id="invoice_url">
                                    <div class="col-md-4 e-bill">
                                        @if($businessCategory->gst_auth == 1)
                                        <input type="checkbox" name="e_bill" id="e_bill" value="1">
                                        <input type="hidden" name="gstin" id="gstin" value="{{$businessCategory->gstin}}">
                                        <label for="e_bill">E-Bill</label>
                                        @else
                                        <input type="checkbox" name="e_bill" id="e_bill" value="1" disabled>
                                        <span class="text-danger">Setup the E-Bill</span>
                                        @endif
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('.e_bill_content').hide();
                                            $('#e_bill').change(function() {
                                                if ($(this).is(':checked')) {
                                                    $('.e_bill_content').show();
                                                } else {
                                                    $('.e_bill_content').hide();
                                                }
                                            });
                                        });
                                    </script>
                                     <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Transaction Type</label>
                                                <select class="form-select select2" name="transactionType" id="transactionType">
                                                    <option value="1">Regular</option>
                                                    <option value="2">Bill To - Ship To</option>
                                                    <option value="3">Bill From - Dispatch From</option>
                                                    <option value="4">Combination of 2 and 3</option>
                                                </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Transaction Mode</label>
                                                <select class="form-select select2" name="transMode" id="transMode">
                                                    <option value="1">Road</option>
                                                    <option value="2">Rail</option>
                                                    <option value="3">Air</option>
                                                    <option value="4">Ship</option>
                                                    <option value="5">inTransit</option>
                                                </select>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#vehicleType').val('R');
                                                $('#transMode').change(function() {
                                                    if ($(this).val() == 1) {
                                                       $('#vehicleType').val('R');
                                                    } else {
                                                        $('#vehicleType').val('O');
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Transaction Distance</label>
                                            <input type="text" class="form-control" name="transDistance"
                                                id="transDistance" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Transporter Doc. No</label>
                                            <input type="text" class="form-control" name="transDocNo"
                                                id="transDocNo" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Vehicle No</label>
                                            <input type="text" class="form-control" name="vehicleNo"
                                                id="vehicleNo" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Vehicle Type</label>
                                            <select class="form-select select2" name="vehicleType" id="vehicleType" readonly>
                                                <option value="R">Regular</option>
                                                <option value="O">ODC(Over Dimentional Cargo)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Transporter Name</label>
                                            <input type="text" class="form-control" name="transporterName"
                                                id="transporterName" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container e_bill_content">
                                        <div >
                                            <label class="form-label">Transporter ID</label>
                                            <input type="text" class="form-control" name="transporterId"
                                                id="transporterId" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container">
                                        <div id="cash_received_field" style="display: none;">
                                            <label class="form-label">Cash Received</label>
                                            <input type="text" class="form-control" name="cash_received"
                                                id="CashReceived" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container">
                                        <label class="form-label">Cash Type</label>
                                        <select name="cash_type" required id="cash_type" class="form-select">
                                            <option value="">Select Cash Type</option>
                                            <option value="cash" @if (old('cash_type')=='cash' ) selected @endif>
                                                Cash</option>
                                            <option value="credit" @if (old('cash_type')=='credit' ) selected @endif>
                                                Credit</option>
                                            <option value="online" @if (old('cash_type')=='online' ) selected @endif>
                                                Online</option>
                                        </select>
                                        @if ($errors->has('cash_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cash_type') }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>


                            <!-- cash Received -->



                            <!-- EMI Details Section -->
                            <div id="emi_fields" class="form-row">
                                <div class="row">

                                    <div class="col-md-3 form-group">
                                        <label for="bank" class="form-label">Financier</label>

                                        <div class="input-group col-md-4">
                                            <select id="financier" class="form-control" name="financier_name">
                                                <option value="">-- Select Financier --</option>
                                            </select>

                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#financierModal">+</button> -->
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="loan_no" class="form-label">Loan No.</label>
                                        <input type="text" name="loan_no" id="loan_no" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="credit_amount" class="form-label">Initial Payment</label>
                                        <input type="text" name="initial_payment" id="credit_amount"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="emi" class="form-label">Monthly EMI</label>
                                        <input type="text" name="emi" id="emi" class="form-control">
                                    </div>
                                    <div class="col-md-1 form-group">
                                        <label for="scheme" class="form-label">Scheme</label>
                                        <input type="text" name="scheme" id="scheme" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <button id="saleFormSubmit" type="submit"
                                    class="btn btn-primary float-right mb-2" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Bill</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<!-- / Content -->



<div class="modal fade bd-example-modal-xl" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="validation-errors-product"></div>

                <form method="POST" id="productForm" action="{{ route('product.ajaxsave') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Product Details -->
                    <h5 class="mb-4">Product Details</h5>
                    <div class="row">
                        <div class="col-md-2 mb-1">
                            <label class="form-label">Item Type</label>
                            <select name="item_type" id="item_type" class="form-select">
                                <option value="sale" @if (old('item_type')=='sale' ) selected @endif>Sale
                                </option>
                                <option value="service" @if (old('item_type')=='service' ) selected @endif>
                                    Service</option>
                            </select>
                            @if ($errors->has('item_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('item_type') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-1">
                            <label class="form-label">Product Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Select Category</option> <!-- Placeholder Option -->
                                @foreach ($productcategory as $val)
                                <option @if (old('category')==$val->name) selected @endif value="{{ $val->name }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="col-md-2 mb-1" id="brand-container">
                            <label for="product_category" class="form-label">Select Brand</label>
                            <select name="sub_category" id="product_category" class="form-select" required>
                                <option value="">Select Brand</option>
                            </select>
                            @if ($errors->has('sub_category'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sub_category') }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="col-md-3 mb-1">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="item_name"
                                value="{{ old('item_name') }}" />
                            @if ($errors->has('item_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('item_name') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="form-label">HSN Code</label>
                            <input type="text" class="form-control" name="hsn_code"
                                value="{{ old('hsn_code') }}" />
                            @if ($errors->has('hsn_code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('hsn_code') }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <label class="form-label">Item Code / Barcode</label>
                            <input type="text" class="form-control" name="item_code_barcode"
                                value="{{ old('item_code_barcode') }}" />
                            @if ($errors->has('item_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('item_code_barcode') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="image" />
                            @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="form-label">Product Description</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="Enter the description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="form-label">Units</label>
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
                                <option @if (old('units')==$val) selected @endif
                                    value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('units'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('units') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1">
                            <label class="form-label">Stock</label>
                            <input type="text" class="form-control" name="stock"
                                value="{{ old('stock', '0') }}" />
                            @if ($errors->has('stock'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('stock') }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if($businessCategory->gstavailable != 'no')
                        <div class="col-md-3 mb-1">
                            <label class="form-label">GST Rate (%)</label>
                            <select class="form-select" id="gst_rate" name="gst_rate">
                                <option value="">Select GST Rate</option>
                                <option value="28">28 %</option>
                                <option value="18">18 %</option>
                                <option value="12">12 %</option>
                                <option value="5">5 %</option>
                            </select>

                            @if ($errors->has('gst_rate'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('gst_rate') }}</strong>
                            </span>
                            @enderror
                        </div>
                        @else
                        @endif
                    </div>
                    <hr>
                    <!-- Sale Details -->
                    <h5 class="mt-4 mb-4">Sale Details</h5>
                    @if($businessCategory->gstavailable != 'no')
                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <label class="form-label" for="price_type">Price Type</label>
                            <select class="form-select" id="price_type" name="price_type">
                                <option value="with_tax">With Tax</option>
                                <option value="without_tax">Without Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1" id="including-tax-container">
                            <label class="form-label">Sales Price (Including Tax)</label>
                            <input type="text" class="form-control" id="including_tax"
                                name="including_tax" value="{{ old('including_tax') }}" />
                            @if ($errors->has('including_tax'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('including_tax') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1" id="sale-price-container">
                            <label class="form-label">Taxable Amount (Sale Price)</label>
                            <input type="text" class="form-control" id="sale_price" name="sale_price"
                                value="{{ old('sale_price') }}" />
                            @if ($errors->has('sale_price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sale_price') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-1" id="gst-amount-container">
                            <label class="form-label">GST Amount</label>
                            <input type="text" class="form-control" id="gst_amount" name="gst_amount"
                                readonly />
                            @if ($errors->has('gst_amount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('gst_amount') }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-3 mb-1" id="sale-price-container">
                            <label class="form-label">Taxable Amount (Sale Price)</label>
                            <input type="text" class="form-control" id="sale_price" name="sale_price"
                                value="{{ old('sale_price') }}" />
                            @if ($errors->has('sale_price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sale_price') }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <!-- Purchase Details -->
                    <h5 class="mt-4 mb-4">Purchase Details</h5>
                    @if($businessCategory->gstavailable != 'no')
                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <label class="form-label" for="purchase_type">Price Type</label>
                            <select class="form-select" id="purchase_type" name="purchase_type">
                                <option value="with_tax" selected>With Tax</option>
                                <option value="without_tax">Without Tax</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Purchase Price (Including Tax) Field -->
                        <div class="col-md-3 mb-1" id="purchase-including-tax-container">
                            <label class="form-label">Purchase Price (Including Tax)</label>
                            <input type="text" class="form-control" id="purchase_including_tax"
                                name="purchase_including_tax" value="{{ old('purchase_including_tax') }}" />
                            @if ($errors->has('purchase_including_tax'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('purchase_including_tax') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Taxable Amount (Purchase Price) Field -->
                        <div class="col-md-3 mb-1" id="purchase-price-container">
                            <label class="form-label">Taxable Amount (Purchase Price)</label>
                            <input type="text" class="form-control" id="purchase_price" name="purchase_price"
                                value="{{ old('purchase_price') }}" />
                            @if ($errors->has('purchase_price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('purchase_price') }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- GST Amount Field -->
                        <div class="col-md-3 mb-1" id="purchase-gst-amount-container">
                            <label class="form-label">GST Amount</label>
                            <input type="text" class="form-control" id="purchase_gst_amount" name="purchase_gst_amount"
                                readonly />
                            @if ($errors->has('purchase_gst_amount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('purchase_gst_amount') }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @else
                    <div class="col-md-3 mb-1" id="purchase-price-container">
                        <label class="form-label">Taxable Amount (Purchase Price)</label>
                        <input type="text" class="form-control" id="purchase_price" name="purchase_price"
                            value="{{ old('purchase_price') }}" />
                        @if ($errors->has('purchase_price'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('purchase_price') }}</strong>
                        </span>
                        @enderror
                    </div>
                    @endif

                    <button type="submit" id="saveBtn" class="btn btn-primary" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Save</button>
                </form>
            </div>
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
                                    checked />
                                <label for="sale">Sale</label>
                                <input type="radio" id="purchase" name="transaction_type" value="purchase" />
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
                                'registered' => 'Registered',
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

                    <button type="submit" id="partysaveBtn" class="btn btn-primary" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Save</button>
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
                                <p class="lh-base mb-0">Ship-from Address: MyDailyBill Inc, 2705 N. Enterprise St,
                                    Orange, CA 92865</p>
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
                                            <p class="text-0 text-black-50 lh-base mb-0">Warranty: 1 Year Warranty for
                                                Mobile and 6
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
                    <div class="mt-5">


                        <div class="text-end mb-4">
                            <img id="logo" src="bill/logo-sm.png" title="MyDailyBill"
                                alt="MyDailyBill" /><br>
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
                                    class="btn btn-light border text-black-50 shadow-none"><i
                                        class="fa fa-print"></i>
                                    Print &
                                    Download</a> </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Financier Modal -->
<div class="modal fade" id="financierModal" tabindex="-1" aria-labelledby="financierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="financierModalLabel">Add Financier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Financier Form -->
                <form id="financierForm" method="POST" action="{{ route('financiers.ajaxsave') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Financier Name</label>

                        <input type="text" class="form-control" name="financier_name"
                            placeholder="Financier Name" />
                        <span class="invalid-feedback" id="financier_name_error" role="alert"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Agent Code</label>
                        <input type="text" class="form-control" name="agent_code" placeholder="Agent Code" />
                        <span class="invalid-feedback" id="agent_code_error" role="alert"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Executive Name</label>
                        <input type="text" class="form-control" name="executive_name"
                            placeholder="Executive Name" />
                        <span class="invalid-feedback" id="executive_name_error" role="alert"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Executive Phone</label>
                        <input type="text" class="form-control" name="executive_phone"
                            placeholder="Executive Phone" />
                        <span class="invalid-feedback" id="executive_phone_error" role="alert"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="text" class="form-control" name="company_email"
                            placeholder="Company Email" />
                        <span class="invalid-feedback" id="company_email_error" role="alert"></span>
                    </div>
                    <button type="submit" id="financierSaveBtn" class="btn btn-primary" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->



<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
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
                        type: "sale"
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            response(data.map(function(party) {
                                $("#party_gst").val(party.gst_profile);
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

    $(document).ready(function() {
        // Product Autocomplete
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
                            if (data.length > 0) {
                                response(data.map(function(product) {
                                    console.log(product);
                                    // Safely access purchase_custom_details and its properties
                                    var imeiValue = product.field_value ? product.field_value : '';
                                    return {
                                        label: product.item_name + (imeiValue !== '' ? ' (' + imeiValue + ')' : ''),
                                        sale_price: (product
                                            .sale_price +
                                            product.sale_price *
                                            (product.gst_rate /
                                                100)).toFixed(
                                            2) || '0',
                                        gst_rate: product
                                            .gst_rate || '0',
                                        discount: '0',
                                        id: product.id
                                    };
                                }));
                            } else {
                                $(this).closest("div").parent().find('.uprice')
                                    .val('0');
                                $(this).closest("div").parent().find('.gstperc')
                                    .val('0');
                                console.log("No matching products found.");
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    // Set the values from the selected item
                    $(this).val(ui.item.label);
                    $(this).closest("div").parent().find('.uprice').val(ui.item.sale_price);
                    $(this).closest("div").parent().find('.gstperc').val(ui.item.gst_rate);
                    $(this).closest("div").parent().find('.discount').val(ui.item.discount);
                    $(this).closest("div").parent().find('.product_id').val(ui.item.id);

                    // Move focus to qtybox
                    $(this).closest("div").parent().find('.qtybox').focus();


                    // Prevent form submission
                    return false;
                }
            });
        });

        // Prevent form submission when Enter is pressed
        $(document).on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault(); // Prevent form submission
            }
        });




        // Handle barcode scanning and auto-filling
        $(document).on('input', '.product_name', function() {
            var input = $(this);
            var scanValue = input.val().trim();

            if (scanValue.length >= 12) { // Adjust this condition based on your expected barcode length
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: scanValue
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            var product = data[
                                0]; // Assuming the barcode matches only one product

                            // Safely access purchase_custom_details and its properties
                            var imeiValue = product.field_value ? product.field_value :
                                'N/A';

                            // Update input value
                            input.val(product.item_name + ' (IMEI: ' + imeiValue + ')');

                            // Safely update other fields, assuming they exist
                            var salePrice = product.sale_price || '0';
                            var gstRate = product.gst_rate || '0';
                            var discount = '0';

                            input.closest("div").parent().find('.uprice').val(salePrice);
                            input.closest("div").parent().find('.gstperc').val(gstRate);
                            input.closest("div").parent().find('.discount').val(discount);
                            input.closest("div").parent().find('.product_id').val(product
                                .id);
                        } else {
                            // Handle case when no matching products are found
                            input.closest("div").parent().find('.uprice').val('0');
                            input.closest("div").parent().find('.gstperc').val('0');
                            console.log("No matching products found.");
                        }

                    }
                });
            }
        });
    });
</script>
@endsection
@push('scripts')
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
                    `<div class="border p-2 input-group col-md-4" style="width:25%;"><input class="form-control product_name" tabindex="1" name="item_description${cIncr}" /><input type="hidden" class="form-control product_id" name="product_id${cIncr}" /></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control uprice" type="text" dataid="${cIncr}" name="rpqty${cIncr}" id="rpqty${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control qtybox" tabindex="1" type="number" dataid="${cIncr}" name="qty${cIncr}" id="qty${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control discount"  type="text" dataid="${cIncr}" name="dis${cIncr}" id="dis${cIncr}"></div>` +
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
                // document.getElementById("alertentries").innerHTML = 'Available Quantity ' + avlqty;

                var qtyValue = this.value;
                // var taxable_value = document.getElementById("amount" + dRecid).value;
                var DisVal = document.getElementById("dis" + dRecid).value || 0;
                var gstValue = document.getElementById("gst" + dRecid).value;

                // Get the quantity value from the input field
                var uPriceVal = document.getElementById("rpqty" + dRecid).value;
                var quantity = parseFloat(uPriceVal);
                var gstAmt = (uPriceVal / (1 + gstValue / 100));
                var finalValue = gstAmt;
                uPriceVal = finalValue.toFixed(2);

                if (gstValue === "") {
                    gstValue = 0;
                }
                if (qtyValue === "") {
                    qtyValue = 0;
                }
                if (uPriceVal === "") {
                    uPriceVal = 0;
                }



                if (gstValue != '') {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                    var totdiscValue = totValue - DisVal;
                    var percentage = parseFloat(gstValue) / 100;
                    var gstAmount = totdiscValue * percentage;
                    var totalAmountWithGST = totdiscValue + gstAmount;

                    document.getElementById("taxableamount" + dRecid).value = Math.round(totdiscValue);
                    document.getElementById("gstvaldata" + dRecid).value = Math.round(gstAmount);
                    document.getElementById("gstvaldata" + dRecid).setAttribute('data-gst-amount',
                        gstValue);
                    document.getElementById("taxableamount" + dRecid).setAttribute(
                        'data-taxable-amount', gstValue);

                    document.getElementById("total_amount" + dRecid).value = Math.round(totalAmountWithGST); // Fixed to 2 decimal places
                } else {
                    var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));

                    document.getElementById("total_amount" + dRecid).value = Math.round(totValue);
                    document.getElementById("gst" + dRecid).value = Math.round(gstValue);
                    document.getElementById("gstvaldata" + dRecid).value = Math.round(gstValue);

                }
                let total_Amount = 0;
                const total_Amount_elements = document.querySelectorAll('[data-taxable-amount="' +
                    gstValue + '"]');

                total_Amount_elements.forEach(total_Amount_element => {
                    const total_row_Value = parseFloat(total_Amount_element.value);
                    if (!isNaN(total_row_Value)) {
                        total_Amount += total_row_Value;

                        // Display elements based on GST value
                        if (gstValue == 28) {
                            $('.twentyeight').show();
                            document.getElementById("taxable28Amount").value = total_Amount;
                        }
                        if (gstValue == 18) {
                            $('.eighteen').show();
                            document.getElementById("taxable18Amount").value = total_Amount;
                        }
                        if (gstValue == 12) {
                            $('.twelve').show();
                            document.getElementById("taxable12Amount").value = total_Amount;
                        }
                        if (gstValue == 5) {
                            $('.five').show();
                            document.getElementById("taxable5Amount").value = total_Amount;
                        }
                        if (gstValue == 0 && total_Amount > 0) {
                            $('.zero').show();
                            document.getElementById("taxable0Amount").value = total_Amount;
                        }else{
                            $('.zero').hide();
                        }
                    }
                });

                // Initialize total GST amount
                let totalGstAmount = 0;
                const elements = document.querySelectorAll('[data-gst-amount="' + gstValue + '"]');

                elements.forEach(element => {
                    const gstvaldataValue = parseFloat(element.value);
                    if (!isNaN(gstvaldataValue)) {
                        totalGstAmount += gstvaldataValue / 2;
                        var businessState = document.getElementById("state").value;
                        // Update corresponding GST fields based on GST value
                        if (businessState != "Tamil Nadu") {
                            if (gstValue == 28) {
                                $('.twentyeight').show();

                                document.getElementById("taxAmount_28_igst").value = gstvaldataValue.toFixed(2);
                            }
                            if (gstValue == 18) {
                                $('.eighteen').show();

                                document.getElementById("taxAmount_18_igst").value = gstvaldataValue.toFixed(2);
                            }
                            if (gstValue == 12) {
                                $('.twelve').show();

                                document.getElementById("taxAmount_12_igst").value = gstvaldataValue.toFixed(2);
                            }
                            if (gstValue == 5) {
                                $('.five').show();

                                document.getElementById("taxAmount_5_igst").value = gstvaldataValue.toFixed(2);
                            }
                        } else {
                            if (gstValue == 28) {
                                $('.twentyeight').show();
                                document.getElementById("taxAmount_28_cgst").value = totalGstAmount.toFixed(2);
                                document.getElementById("taxAmount_28_sgst").value = totalGstAmount.toFixed(2);
                            }
                            if (gstValue == 18) {
                                $('.eighteen').show();
                                document.getElementById("taxAmount_18_cgst").value = totalGstAmount.toFixed(2);
                                document.getElementById("taxAmount_18_sgst").value = totalGstAmount.toFixed(2);
                            }
                            if (gstValue == 12) {
                                $('.twelve').show();
                                document.getElementById("taxAmount_12_cgst").value = totalGstAmount.toFixed(2);
                                document.getElementById("taxAmount_12_sgst").value = totalGstAmount.toFixed(2);
                            }
                            if (gstValue == 5) {
                                $('.five').show();
                                document.getElementById("taxAmount_5_cgst").value = totalGstAmount.toFixed(2);
                                document.getElementById("taxAmount_5_sgst").value = totalGstAmount.toFixed(2);
                            }
                        }
                    }
                });


                document.querySelectorAll('.discount').forEach(function(element) {
                    element.addEventListener('keyup', function() {
                        var dRecid = this.getAttribute("dataid");
                        var qtyValue = parseFloat(document.getElementById("qty" +
                            dRecid).value) || 0;
                        var uPriceVal = parseFloat(document.getElementById("rpqty" +
                            dRecid).value) || 0;
                        var gstValue = parseFloat(document.getElementById("gst" +
                            dRecid).value) || 0;
                        var DisVal = parseFloat(this.value) || 0;

                        var gstAmt = uPriceVal / (1 + gstValue / 100);
                        var finalValue = gstAmt;
                        uPriceVal = finalValue.toFixed(2);
                        var totValue = qtyValue * uPriceVal;
                        var totdiscValue = totValue - DisVal;

                        var totalAmountWithGST = totdiscValue;
                        if (gstValue > 0) {
                            var percentage = gstValue / 100;
                            var gstAmount = totdiscValue * percentage;
                            totalAmountWithGST += gstAmount;
                        }

                        // Update DOM elements with calculated values
                        document.getElementById("taxableamount" + dRecid).value =
                            totdiscValue.toFixed(2);
                        document.getElementById("gstvaldata" + dRecid).value = (
                            gstValue > 0) ? gstAmount.toFixed(2) : 0;
                        document.getElementById("total_amount" + dRecid).value =
                            totalAmountWithGST.toFixed(2);

                        // Initialize total sum for taxable amounts and GST amounts
                        let total_Amount = 0;
                        const total_Amount_elements = document.querySelectorAll(
                            '[data-taxable-amount="' + gstValue + '"]');

                        total_Amount_elements.forEach(total_Amount_element => {
                            const total_row_Value = parseFloat(
                                total_Amount_element.value);
                            if (!isNaN(total_row_Value)) {
                                total_Amount += total_row_Value;

                                // Display elements based on GST value
                                if (gstValue == 28) {
                                    $('.twentyeight').show();
                                    document.getElementById("taxable28Amount")
                                        .value = total_Amount;
                                }
                                if (gstValue == 18) {
                                    $('.eighteen').show();
                                    document.getElementById("taxable18Amount")
                                        .value = total_Amount;
                                }
                                if (gstValue == 12) {
                                    $('.twelve').show();
                                    document.getElementById("taxable12Amount")
                                        .value = total_Amount;
                                }
                                if (gstValue == 5) {
                                    $('.five').show();
                                    document.getElementById("taxable5Amount")
                                        .value = total_Amount;
                                }
                            }
                        });

                        // Initialize total GST amount
                        let totalGstAmount = 0;
                        const elements = document.querySelectorAll(
                            '[data-gst-amount="' + gstValue + '"]');

                        elements.forEach(element => {
                            const gstvaldataValue = parseFloat(element.value);
                            if (!isNaN(gstvaldataValue)) {
                                totalGstAmount += gstvaldataValue / 2;
                                var businessState = document.getElementById("state").value;
                                // Update corresponding GST fields based on GST value
                                if (businessState != "Tamil Nadu") {
                                    if (gstValue == 28) {
                                        $('.twentyeight').show();

                                        document.getElementById("taxAmount_28_igst").value = gstvaldataValue.toFixed(2);
                                    }
                                    if (gstValue == 18) {
                                        $('.eighteen').show();

                                        document.getElementById("taxAmount_18_igst").value = gstvaldataValue.toFixed(2);
                                    }
                                    if (gstValue == 12) {
                                        $('.twelve').show();

                                        document.getElementById("taxAmount_12_igst").value = gstvaldataValue.toFixed(2);
                                    }
                                    if (gstValue == 5) {
                                        $('.five').show();

                                        document.getElementById("taxAmount_5_igst").value = gstvaldataValue.toFixed(2);
                                    }
                                } else {
                                    if (gstValue == 28) {
                                        $('.twentyeight').show();
                                        document.getElementById("taxAmount_28_cgst").value = totalGstAmount.toFixed(2);
                                        document.getElementById("taxAmount_28_sgst").value = totalGstAmount.toFixed(2);
                                    }
                                    if (gstValue == 18) {
                                        $('.eighteen').show();
                                        document.getElementById("taxAmount_18_cgst").value = totalGstAmount.toFixed(2);
                                        document.getElementById("taxAmount_18_sgst").value = totalGstAmount.toFixed(2);
                                    }
                                    if (gstValue == 12) {
                                        $('.twelve').show();
                                        document.getElementById("taxAmount_12_cgst").value = totalGstAmount.toFixed(2);
                                        document.getElementById("taxAmount_12_sgst").value = totalGstAmount.toFixed(2);
                                    }
                                    if (gstValue == 5) {
                                        $('.five').show();
                                        document.getElementById("taxAmount_5_cgst").value = totalGstAmount.toFixed(2);
                                        document.getElementById("taxAmount_5_sgst").value = totalGstAmount.toFixed(2);
                                    }
                                }
                            }
                        });

                        finalTotalValue(); // Call to update final total if needed
                    });
                });

                // var totValue = (parseFloat(qtyValue) * parseFloat(uPriceVal));
                // document.getElementById("total_amount" + dRecid).value = Math.round(totValue);
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

        document.getElementById("totalAmountDisplay").value = parseFloat(withOutGst.toFixed(2));
        document.getElementById("TotalAmount").value = parseFloat(withOutGst.toFixed(2));
        document.getElementById("taxAmount").value = gstPrice.toFixed(2);
        document.getElementById("netAmount").value = Math.round(toPrice);
        document.getElementById("CashReceived").value = Math.round(toPrice);
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
                    $('.modal-backdrop').hide();
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


        // financier

        $('#financierSaveBtn').click(function(e) {
            e.preventDefault(); // Prevent the default form submission
            var $this = $(this);
            $this.html('Sending..'); // Change button text to indicate processing

            $.ajax({
                url: $('#financierForm').attr('action'), // Get the form action URL
                method: 'POST',
                data: $('#financierForm').serialize(), // Serialize the form data
                dataType: 'json',
                success: function(response) {
                    // Reset the form fields
                    $('#financierForm').trigger('reset');
                    // Hide the modal
                    $('#financierModal').modal('hide');


                    // Reset button text
                    $this.html('Save');

                    // Clear validation errors
                    $('.invalid-feedback').html('');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $this.html('Save'); // Reset button text

                    // Handle validation errors
                    $('.invalid-feedback').html(''); // Clear any existing errors
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#' + key + '_error').html('<strong>' + value[0] +
                                '</strong>');
                        });
                    } else {
                        console.error('Unexpected error format:', xhr.responseJSON);
                    }
                }
            });
        });







        /*------------------------------------------
        --------------------------------------------
        Create Sale Code
        --------------------------------------------
        -------------------------------------------- */


    });
</script>
<script>
    // Function to update the financier dropdown
    function updateFinancierDropdown() {
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
                    $.each(response.financiers, function(key, value) {
                        $('#financier').append('<option value="' + value.financier_name + '">' +
                            value.financier_name + '</option>');
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const businessCategory = '<?php echo $businessCategory->business_category; ?>'; // Get the business category from the controller
        // alert(businessCategory);
        // Function to update cash type options based on business category
        function updateCashTypeOptions() {
            const cashTypeSelect = document.getElementById('cash_type');
            const emiOption = document.createElement('option');

            emiOption.value = 'emi';
            emiOption.textContent = 'Emi';

            // Clear EMI option if not needed
            if (businessCategory !== 'Mobile & Accessories') {
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
        }

        function toggleFields() {
            const cashType = document.getElementById('cash_type').value;
            const emiFields = document.getElementById('emi_fields');
            const cashReceivedField = document.getElementById('cash_received_field');

            // Show/hide EMI fields and Cash Received field based on selected cash type
            emiFields.style.display = (cashType === 'emi') ? 'flex' : 'none';
            cashReceivedField.style.display = (cashType === 'cash') ? 'block' : 'none';
        }

        // Attach event listener to the cash_type select element
        document.getElementById('cash_type').addEventListener('change', toggleFields);

        // Initialize fields based on pre-selected values if needed
        toggleFields();

        // Initialize fields based on pre-selected values
        updateCashTypeOptions();
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
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Fields
        const priceTypeSelect = document.getElementById('price_type');
        const includingTaxField = document.getElementById('including_tax');
        const salePriceField = document.getElementById('sale_price');
        const gstAmountField = document.getElementById('gst_amount');
        const gstRateField = document.getElementById('gst_rate');

        // Purchase Fields
        const purchaseTypeSelect = document.getElementById('purchase_type');
        const purchaseIncludingTaxField = document.getElementById('purchase_including_tax');
        const purchasePriceField = document.getElementById('purchase_price');
        const purchaseGstAmountField = document.getElementById('purchase_gst_amount');
        const purchaseGstRateField = document.getElementById('gst_rate');

        function updateSalesFields() {
            const selectedType = priceTypeSelect.value;
            const gstRate = parseFloat(gstRateField.value) || 0;

            if (selectedType === 'with_tax') {
                includingTaxField.readOnly = false;
                salePriceField.readOnly = true;
                gstAmountField.readOnly = true;

                const includingTax = parseFloat(includingTaxField.value) || 0;
                if (gstRate > 0 && includingTax > 0) {
                    const taxableAmount = includingTax / (1 + gstRate / 100);
                    const gstAmount = includingTax - taxableAmount;

                    salePriceField.value = taxableAmount.toFixed(2);
                    gstAmountField.value = gstAmount.toFixed(2);
                }
            } else {
                includingTaxField.readOnly = true;
                salePriceField.readOnly = false;
                gstAmountField.readOnly = true;

                const taxableAmount = parseFloat(salePriceField.value) || 0;
                if (gstRate > 0 && taxableAmount > 0) {
                    const gstAmount = taxableAmount * (gstRate / 100);
                    const includingTax = taxableAmount + gstAmount;

                    includingTaxField.value = includingTax.toFixed(2);
                    gstAmountField.value = gstAmount.toFixed(2);
                }
            }
        }

        function updatePurchaseFields() {
            const selectedType = purchaseTypeSelect.value;
            const gstRate = parseFloat(purchaseGstRateField.value) || 0;

            if (selectedType === 'with_tax') {
                purchaseIncludingTaxField.readOnly = false;
                purchasePriceField.readOnly = true;
                purchaseGstAmountField.readOnly = true;

                const includingTax = parseFloat(purchaseIncludingTaxField.value) || 0;
                if (gstRate > 0 && includingTax > 0) {
                    const taxableAmount = includingTax / (1 + gstRate / 100);
                    const gstAmount = includingTax - taxableAmount;

                    purchasePriceField.value = taxableAmount.toFixed(2);
                    purchaseGstAmountField.value = gstAmount.toFixed(2);
                }
            } else {
                purchaseIncludingTaxField.readOnly = true;
                purchasePriceField.readOnly = false;
                purchaseGstAmountField.readOnly = true;

                const taxableAmount = parseFloat(purchasePriceField.value) || 0;
                if (gstRate > 0 && taxableAmount > 0) {
                    const gstAmount = taxableAmount * (gstRate / 100);
                    const includingTax = taxableAmount + gstAmount;

                    purchaseIncludingTaxField.value = includingTax.toFixed(2);
                    purchaseGstAmountField.value = gstAmount.toFixed(2);
                }
            }
        }

        // Event Listeners
        priceTypeSelect.addEventListener('change', updateSalesFields);
        includingTaxField.addEventListener('input', updateSalesFields);
        salePriceField.addEventListener('input', updateSalesFields);
        gstRateField.addEventListener('change', updateSalesFields);

        purchaseTypeSelect.addEventListener('change', updatePurchaseFields);
        purchaseIncludingTaxField.addEventListener('input', updatePurchaseFields);
        purchasePriceField.addEventListener('input', updatePurchaseFields);
        purchaseGstRateField.addEventListener('change', updatePurchaseFields);

        // Initial Updates
        updateSalesFields();
        updatePurchaseFields();
    });
</script>
@endpush
@push('stylecss')
<style>
    .form-group {
        margin-bottom: 15px;
    }

    #emi_fields {
        display: none;
    }
</style>
@endpush
