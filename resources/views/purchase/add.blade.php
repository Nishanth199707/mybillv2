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
        @if (session()->has('success'))
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
                        <form class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST"
                            action="{{ route('purchase.store') }}" id="saleForm" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body p-32" id="tblData">



                                <div class="row mb-3">

                                    <div class="col-md-3 fv-plugins-icon-container" id="tblDataparty">
                                        <label class="form-label">Party</label>
                                        <div class="border p-2 input-group col-md-4">
                                            <input type="text" required class="form-control party" id="party"
                                                required name="party" value="">
                                            <input type="hidden" required class="party" id="partyid" required
                                                name="partyid" value="">
                                                <input type="hidden" class="state"
                                        id="state">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#basicModal1">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 fv-plugins-icon-container">
                                        <label class="form-label">Address</label>
                                        <textarea style="border: 2px solid transparent" class="form-control party" id="party_detail" disabled></textarea>
                                        <small>Phone : </small>
                                        <input style="border: 2px solid transparent" type="text" required class="party"
                                            id="partyphone" disabled>
                                    </div>
                                    <div class="col-md-2 fv-plugins-icon-container">
                                        <label class="form-label" for="formValidationName">Purchase Bill No</label>
                                        <input type="text" id="formValidationName" class="form-control" required
                                            value="" name="purchase_no">

                                    </div>
                                    <div class="col-md-2 fv-plugins-icon-container">
                                        <label class="form-label" for="formValidationName">Purchase Date</label>
                                        <input type="text" class="form-control" id="datetimepicker9" required
                                            name="purchase_date" value="{{ date('d-m-Y') }}">
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
                                    <div class="col-md-3 border p-1 text-center">
                                        <b>Particulars</b>
                                    </div>
                                    <div class="col-md-2 border p-1 text-center">
                                        <b>Rate </b>
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
                                    <div class="col-md-1 border p-1 text-center">
                                        <b>SALE AMOUNT</b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <div class="elemimei" style="width: 100%;">
                                            <div class="input-group mb-2">
                                                <input class="form-control product_name"
                                                    name="item_description1" />
                                                <input type="hidden" class="form-control product_id"
                                                    name="product_id1" />
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                            </div>
                                                <div class="imei-fields1" id="imei-fields" style="display: none;">
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
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="1"
                                            name="rpqty1" id="rpqty1">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox"  type="text"
                                            dataid="1" name="qty1" id="qty1">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox"   type="text"
                                            dataid="1" name="amount1" id="taxableamount1">
                                    </div>

                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="1" type="text"
                                            name="gst1" id="gst1">
                                        <input class="gstvaldata" type="hidden" dataid="1" name="gstvaldata1"
                                            id="gstvaldata1">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control total_amount" type="text" readonly="readonly"
                                            id="total_amount1" name="total_amount1">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control saleamount"   type="text"
                                            dataid="1" name="saleamount1" id="saleamount1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <div class="elemimei" style="width: 100%;">
                                            <div class="input-group mb-2">
                                                <input class="form-control product_name"
                                                    name="item_description2" />
                                                <input type="hidden" class="form-control product_id"
                                                    name="product_id2" />
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                            </div>
                                                <div class="imei-fields2" id="imei-fields" style="display: none;">
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
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="2"
                                            name="rpqty2" id="rpqty2">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox"   type="text"
                                            dataid="2" name="qty2" id="qty2">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox"   type="text"
                                            dataid="2" name="amount2" id="taxableamount2">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="2" type="text"
                                            name="gst2" id="gst2">
                                        <input class="gstvaldata" type="hidden" dataid="2" name="gstvaldata2"
                                            id="gstvaldata2">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control total_amount" type="text" readonly="readonly"
                                            id="total_amount2" name="total_amount2">
                                    </div>
                                    <div class="col-md-1 border p-2"> <!-- Added column for sale amount -->
                                        <input class="form-control saleamount"   type="text"
                                            dataid="2" name="saleamount2" id="saleamount2">
                                    </div>
                                </div>


                                <!-- Row 3 -->
                                <div class="row">
                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <div class="elemimei" style="width: 100%;">
                                            <div class="input-group mb-2">
                                                <input class="form-control product_name"
                                                    name="item_description3" />
                                                <input type="hidden" class="form-control product_id"
                                                    name="product_id3" />
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                            </div>
                                                <div class="imei-fields3" id="imei-fields" style="display: none;">
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
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="3"
                                            name="rpqty3" id="rpqty3">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox"   type="text"
                                            dataid="3" name="qty3" id="qty3">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox"   type="text"
                                            dataid="3" name="amount3" id="taxableamount3">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="3" type="text"
                                            name="gst3" id="gst3">
                                        <input class="gstvaldata" type="hidden" dataid="3" name="gstvaldata3"
                                            id="gstvaldata3">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control total_amount" type="text" readonly="readonly"
                                            id="total_amount3" name="total_amount3">
                                    </div>
                                    <div class="col-md-1 border p-2"> <!-- Added column for sale amount -->
                                        <input class="form-control saleamount"   type="text"
                                            dataid="3" name="saleamount3" id="saleamount3">
                                    </div>
                                </div>


                                <!-- Row 4 -->
                                <div class="row">
                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <div class="elemimei" style="width: 100%;">
                                            <div class="input-group mb-2">
                                                <input class="form-control product_name"
                                                    name="item_description4" />
                                                <input type="hidden" class="form-control product_id"
                                                    name="product_id4" />
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                            </div>
                                            {{-- @if ($businessCategory->business_category === 'Mobile & Accessories') --}}
                                                <div class="imei-fields4" id="imei-fields" style="display: none;">
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
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="4"
                                            name="rpqty4" id="rpqty4">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox"   type="text"
                                            dataid="4" name="qty4" id="qty4">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox"   type="text"
                                            dataid="4" name="amount4" id="taxableamount4">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="4" type="text"
                                            name="gst4" id="gst4">
                                        <input class="gstvaldata" type="hidden" dataid="4" name="gstvaldata4"
                                            id="gstvaldata4">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control total_amount" type="text" readonly="readonly"
                                            id="total_amount4" name="total_amount4">
                                    </div>
                                    <div class="col-md-1 border p-2"> <!-- Added column for sale amount -->
                                        <input class="form-control saleamount"   type="text"
                                            dataid="4" name="saleamount4" id="saleamount4">
                                    </div>
                                </div>


                                <!-- Row 5 -->
                                <div class="row">
                                    <div class="border p-2 input-group col-md-3" style="width: 25%;">
                                        <div class="elemimei" style="width: 100%;">
                                            <div class="input-group mb-2">
                                                <input class="form-control product_name"
                                                    name="item_description5" />
                                                <input type="hidden" class="form-control product_id"
                                                    name="product_id5" />
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>
                                            </div>
                                            {{-- @if ($businessCategory->business_category === 'Mobile & Accessories') --}}
                                                <div class="imei-fields5" id="imei-fields" style="display: none;">
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
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control uprice" type="text" dataid="5"
                                            name="rpqty5" id="rpqty5">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control qtybox"   type="text"
                                            dataid="5" name="qty5" id="qty5">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control amountbox"   type="text"
                                            dataid="5" name="amount5" id="taxableamount5">
                                    </div>
                                    <div class="col-md-1 border p-2">
                                        <input class="form-control gstperc" dataid="5" type="text"
                                            name="gst5" id="gst5">
                                        <input class="gstvaldata" type="hidden" dataid="5" name="gstvaldata5"
                                            id="gstvaldata5">
                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <input class="form-control total_amount" type="text" readonly="readonly"
                                            id="total_amount5" name="total_amount5">
                                    </div>
                                    <div class="col-md-1 border p-2"> <!-- Added column for sale amount -->
                                        <input class="form-control saleamount"   type="text"
                                            dataid="5" name="saleamount5" id="saleamount5">
                                    </div>
                                </div>


                            </div>

                            <div class="m-1  justify-content-between align-items-center">

                                <div class="row">




                                    <!-- <div class="col-md-3 border p-2"> -->
                                    <!-- Total Amount: ₹ -->
                                    <input type="hidden" readonly class="totalstyle" name="totalAmountDisplay"
                                        id="totalAmountDisplay" value="0" />

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
                                                <tr class="rate-28">
                                                    <td>28%</td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable28Amount"
                                                            id="taxable28Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_cgst"
                                                            id="taxAmount_28_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_28_sgst"
                                                            id="taxAmount_28_sgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                        class="totalstyle1" name="tax_amount_28_igst"
                                                        id="taxAmount_28_igst"></td>
                                                </tr>
                                                <tr class="rate-18">
                                                    <td>18%</td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable18Amount"
                                                            id="taxable18Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_cgst"
                                                            id="taxAmount_18_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_18_sgst"
                                                            id="taxAmount_18_sgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                        class="totalstyle1" name="tax_amount_18_igst"
                                                        id="taxAmount_18_igst"></td>
                                                </tr>
                                                <tr class="rate-12">
                                                    <td>12%</td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable12Amount"
                                                            id="taxable12Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_cgst"
                                                            id="taxAmount_12_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_12_sgst"
                                                            id="taxAmount_12_sgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                        class="totalstyle1" name="tax_amount_12_igst"
                                                        id="taxAmount_12_igst"></td>
                                                </tr>
                                                <tr class="rate-5">
                                                    <td>5%</td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable5Amount"
                                                            id="taxable5Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_cgst"
                                                            id="taxAmount_5_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_5_sgst"
                                                            id="taxAmount_5_sgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                        class="totalstyle1" name="tax_amount_5_igst"
                                                        id="taxAmount_5_igst"></td>
                                                </tr>
                                                <tr class="rate-0">
                                                    <td>0%</td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="taxable0Amount"
                                                            id="taxable0Amount"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_0_cgst"
                                                            id="taxAmount_0_cgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                            class="totalstyle1" name="tax_amount_0_sgst"
                                                            id="taxAmount_0_sgst"></td>
                                                    <td>₹ <input type="text" readonly value="0"
                                                        class="totalstyle1" name="tax_amount_0_igst"
                                                        id="taxAmount_0_igst"></td>
                                                </tr>
                                            </table>


                                        </div>

                                    </div>
                                    <div class="col-md-2 border p-2">
                                        <b class="mt-1">Tax: ₹</b> <input type="text" readonly value="0"
                                            class="totalstyle" name="tax_amount" id="taxAmount">
                                    </div>
                                    <div class="col-md-3 border p-2">
                                        <b class="mt-1">Net Amount: ₹</b> <input readonly type="text"
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
                                    <div class="col-md-12">
                                        <!-- <div class="form-group">
                                        <input type="text" name="declaration" class="form-control border-bottom" id="validationCustom05" placeholder="Declaration">
                                    </div> -->
                                        <input type="hidden" name="totQues" id="totQues" value="5" /></td>
                                        <input type="hidden" value="" name="purchase_url" id="purchase_url">
                                        <input type="hidden" name="purchase_cat"
                                            value="{{ $businessCategory->business_category }}" id="purchase_cat">

                                        <div class="col-md-4 fv-plugins-icon-container">
                                            <label class="form-label">Cash Type</label>
                                            <select name="cash_type" required id="cash_type" class="form-select">
                                                <option value="">Select Cash Type</option>
                                                @php
                                                    $cash_type = ['cash' => 'Cash', 'credit' => 'Credit'];
                                                @endphp
                                                @foreach ($cash_type as $key => $val)
                                                    <option @if (old('cash_type') == $key) selected @endif
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
                        </div>


                        <!-- <button type="submit" class="btn btn-primary">Send</button> -->
                         <div style="text-align: right;">

                             <button id="saleFormSubmit" type="submit"
                                 class="btn btn-primary float-right mb-2">Bill</button>
                         </div>

                </form>
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
                <input type="hidden" id="row_value" value="">
                <!-- Product Details -->
                <h5 class="mb-4">Product Details</h5>
                <div class="row">
                    <div class="col-md-2 mb-1">
                        <label class="form-label">Item Type</label>
                        <select name="item_type" id="item_type" class="form-select">
                            <option value="sale" @if (old('item_type') == 'sale') selected @endif>Sale</option>
                            <option value="service" @if (old('item_type') == 'service') selected @endif>Service
                            </option>
                        </select>
                        @error('item_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-1">
                        <label class="form-label">Product Category</label>
                        <select name="category" id="category" class="form-select">
                            @foreach ($productcategory as $val)
                                <option value="{{ $val->name }}"
                                    @if (old('category') == $val->name) selected @endif>{{ $val->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-1">
                        <label for="product_category" class="form-label">Select Brand</label>
                        <select name="sub_category" id="product_category" class="form-select" required>
                            <option value="">Select Brand</option>
                            @foreach ($productsubcategory as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('product_categories_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="item_name"
                            value="{{ old('item_name') }}" />
                        @error('item_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1">
                        <label class="form-label">HSN Code</label>
                        <input type="text" class="form-control" name="hsn_code"
                            value="{{ old('hsn_code') }}" />
                        @error('hsn_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-1">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" />
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1">
                        <label class="form-label">Product Description</label>
                        <textarea class="form-control" name="description" rows="2" placeholder="Enter the description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
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
                                <option value="{{ $key }}"
                                    @if (old('units') == $key) selected @endif>{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('units')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1">
                        <label class="form-label">Stock</label>
                        <input type="text" class="form-control" name="stock"
                            value="{{ old('stock', '0') }}" />
                        @error('stock')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 mb-1">
                    <input
                        class="form-check-input"
                        style="border-color: black;"
                        type="checkbox"
                        name="imeiCheckbox"
                        id="imeiCheckbox"
                        value="yes"
                    >
                    <label class="form-check-label" for="imeiCheckbox">
                        Include IMEI
                    </label>
                </div>

                <hr>

                <!-- Sale Details -->
                <h5 class="mt-4 mb-4">Sale Details</h5>
                <div class="row">
                    <div class="col-md-4 mb-1">
                        <label class="form-label">Price Type</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="price_type" id="with_tax"
                                value="with_tax" checked>
                            <label class="form-check-label" for="with_tax">With Tax</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="price_type" id="without_tax"
                                value="without_tax">
                            <label class="form-check-label" for="without_tax">Without Tax</label>
                        </div>
                    </div>

                    <div class="col-md-3 mb-1">
                        <label class="form-label">GST Rate (%)</label>
                        <input type="text" class="form-control" name="gst_rate" id="gst_rate"
                            value="{{ $businessCategory->business_category === 'Mobile & Accessories' ? '18' : old('gst_rate') }}" />
                        @error('gst_rate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-1" id="including-tax-container">
                        <label class="form-label">Sales Price (Including Tax)</label>
                        <input type="text" class="form-control" id="including_tax" name="including_tax"
                            value="{{ old('including_tax') }}" />
                        @error('including_tax')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1" id="sale-price-container">
                        <label class="form-label">Taxable Amount (Sale Price)</label>
                        <input type="text" class="form-control" id="sale_price" name="sale_price"
                            value="{{ old('sale_price') }}" />
                        @error('sale_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1" id="gst-amount-container">
                        <label class="form-label">GST Amount</label>
                        <input type="text" class="form-control" id="gst_amount" name="gst_amount" readonly />
                        @error('gst_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Purchase Details -->
                <h5 class="mt-4 mb-4">Purchase Details</h5>
                <div class="row">
                    <div class="col-md-4 mb-1">
                        <label class="form-label">Price Type</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="purchase_type"
                                id="purchase_with_tax" value="purchase_with_tax" checked>
                            <label class="form-check-label" for="purchase_with_tax">With Tax</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="purchase_type"
                                id="purchase_without_tax" value="purchase_without_tax">
                            <label class="form-check-label" for="purchase_without_tax">Without Tax</label>
                        </div>
                    </div>

                    <div class="col-md-3 mb-1">
                        <label class="form-label">GST Rate (%)</label>
                        <input type="text" class="form-control" name="purchase_gst_rate"
                            id="purchase_gst_rate"
                            value="{{ $businessCategory->business_category === 'Mobile & Accessories' ? '18' : old('purchase_gst_rate') }}" />
                        @error('purchase_gst_rate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-1" id="purchase-including-tax-container">
                        <label class="form-label">Purchase Price (Including Tax)</label>
                        <input type="text" class="form-control" id="purchase_including_tax"
                            name="purchase_including_tax" value="{{ old('purchase_including_tax') }}" />
                        @error('purchase_including_tax')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1" id="purchase-price-container">
                        <label class="form-label">Taxable Amount (Purchase Price)</label>
                        <input type="text" class="form-control" id="purchase_price" name="purchase_price"
                            value="{{ old('purchase_price') }}" />
                        @error('purchase_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-1" id="purchase-gst-amount-container">
                        <label class="form-label">GST Amount</label>
                        <input type="text" class="form-control" id="purchase_gst_amount"
                            name="purchase_gst_amount" readonly />
                        @error('purchase_gst_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div style="text-align: right;">
                    <button type="submit" id="saveBtn" class="btn btn-primary">Save</button>
                </div>
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
                        <input type="hidden" id="purchase" name="transaction_type" value="purchase">
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
                                    @if (old('party_type', 'unregistered') == $key) selected @endif>{{ $val }}</option>
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
                                <option value="Andhra Pradesh"
                                    {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh
                                </option>
                                <option value="Arunachal Pradesh"
                                    {{ old('state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh
                                </option>
                                <option value="Assam" {{ old('state') == 'Assam' ? 'selected' : '' }}>Assam
                                </option>
                                <option value="Bihar" {{ old('state') == 'Bihar' ? 'selected' : '' }}>Bihar
                                </option>
                                <option value="Chhattisgarh"
                                    {{ old('state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                <option value="Goa" {{ old('state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat
                                </option>
                                <option value="Haryana" {{ old('state') == 'Haryana' ? 'selected' : '' }}>Haryana
                                </option>
                                <option value="Himachal Pradesh"
                                    {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh
                                </option>
                                <option value="Jharkhand" {{ old('state') == 'Jharkhand' ? 'selected' : '' }}>
                                    Jharkhand</option>
                                <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>
                                    Karnataka</option>
                                <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala
                                </option>
                                <option value="Madhya Pradesh"
                                    {{ old('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh
                                </option>
                                <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>
                                    Maharashtra</option>
                                <option value="Manipur" {{ old('state') == 'Manipur' ? 'selected' : '' }}>Manipur
                                </option>
                                <option value="Meghalaya" {{ old('state') == 'Meghalaya' ? 'selected' : '' }}>
                                    Meghalaya</option>
                                <option value="Mizoram" {{ old('state') == 'Mizoram' ? 'selected' : '' }}>Mizoram
                                </option>
                                <option value="Nagaland" {{ old('state') == 'Nagaland' ? 'selected' : '' }}>
                                    Nagaland</option>
                                <option value="Odisha" {{ old('state') == 'Odisha' ? 'selected' : '' }}>Odisha
                                </option>
                                <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab
                                </option>
                                <option value="Rajasthan" {{ old('state') == 'Rajasthan' ? 'selected' : '' }}>
                                    Rajasthan</option>
                                <option value="Sikkim" {{ old('state') == 'Sikkim' ? 'selected' : '' }}>Sikkim
                                </option>
                                <option value="Tamil Nadu"
                                    {{ old('state') == 'Tamil Nadu' ? 'selected' : 'selected' }}>Tamil Nadu
                                </option>
                                <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>
                                    Telangana</option>
                                <option value="Tripura" {{ old('state') == 'Tripura' ? 'selected' : '' }}>Tripura
                                </option>
                                <option value="Uttar Pradesh"
                                    {{ old('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>
                                    Uttarakhand</option>
                                <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>
                                    West Bengal</option>
                                <option value="Andaman and Nicobar Islands"
                                    {{ old('state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman
                                    and Nicobar Islands</option>
                                <option value="Chandigarh" {{ old('state') == 'Chandigarh' ? 'selected' : '' }}>
                                    Chandigarh</option>
                                <option value="Dadra and Nagar Haveli and Daman and Diu"
                                    {{ old('state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>
                                    Dadra and Nagar Haveli and Daman and Diu</option>
                                <option value="Lakshadweep" {{ old('state') == 'Lakshadweep' ? 'selected' : '' }}>
                                    Lakshadweep</option>
                                <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi
                                </option>
                                <option value="Puducherry" {{ old('state') == 'Puducherry' ? 'selected' : '' }}>
                                    Puducherry</option>
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
                            <input type="text" class="form-control" name="opening_balance" placeholder="0"
                                value="0" />
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
                        <input type="radio" id="same_address_yes" name="same_address"
                            value="yes" />
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
<div style="text-align: right;">

    <button type="submit" id="partysaveBtn" class="btn btn-primary">Send</button>
</div>
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
            <footer class="mt-5">


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
        triggerInitialCalculations();

        var businessCategory = document.getElementById("purchase_cat").value;
        // alert(businessCategory);
        // Add new rows functionality
        document.querySelectorAll('.addrowcontainer').forEach(function(button) {
            button.addEventListener('click', function() {
                var extCnt = parseInt(document.getElementById("totQues").value, 10);
                var cIncr = extCnt + 1;
                document.getElementById("totQues").value = cIncr;

                document.getElementById("addrow").insertAdjacentHTML('beforeend',
                    `<div class="row mb-3">` +
                    `<div class="border p-2 input-group col-md-3" style="width: 25%;">` +
                    `<div class="elemimei" style="width: 100%;">` +
                    `<div class="input-group mb-2">` +
                    `<input class="form-control product_name"   name="item_description${cIncr}" />` +
                    `<input type="hidden" class="form-control product_id" name="product_id${cIncr}" />` +
                    `<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">+</button>` +
                    `</div>` +
                        `<div class="imei-fields${cIncr}" id="imei-fields" style="display: none;">
                        <br>
                        <div class="imei-fields-container" data-row="${cIncr}">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control imei-field" name="imei[${cIncr}][]" placeholder="ENTER IMEI" />
                                <button type="button" class="btn btn-outline-secondary add-imei" data-row="${cIncr}">+</button>
                            </div>
                        </div>
                    </div>`  +
                    `</div>` +
                    `</div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control uprice" type="text" dataid="${cIncr}" name="rpqty${cIncr}" id="rpqty${cIncr}"></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control qtybox" type="text" dataid="${cIncr}" name="qty${cIncr}" id="qty${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control amountbox" type="text" dataid="${cIncr}" name="amount${cIncr}" id="taxableamount${cIncr}" readonly></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control gstperc" type="text" dataid="${cIncr}" name="gst${cIncr}" id="gst${cIncr}">
            <input class="gstvaldata" type="hidden" dataid="${cIncr}" name="gstvaldata${cIncr}" id="gstvaldata${cIncr}"></div>` +
                    `<div class="col-md-2 border p-2"><input class="form-control total_amount" type="text" name="total_amount${cIncr}" id="total_amount${cIncr}" readonly></div>` +
                    `<div class="col-md-1 border p-2"><input class="form-control saleamount" type="text" name="saleamount${cIncr}" id="saleamount${cIncr}"></div>` +
                    `</div>`
                );


                initCalculation();
            });
        });
    });

    function roundoff(amount) {
        return Math.round(amount * 100) / 100;
    }

    function initCalculation() {
        document.querySelectorAll('.qtybox, .uprice, .gstperc').forEach(function(element) {
            element.addEventListener('input', function() {
                var dRecid = this.getAttribute("dataid");
                console.log(`Input event triggered for row ${dRecid}`);
                calculateRow(dRecid);
                updateTotals();
            });
        });


        document.querySelectorAll('.imei-field').forEach(function(element) {
            element.addEventListener('input', function() {
                var row = $(this).closest('.imei-fields-container').data('row');
                updateQuantity(row);
                calculateRow(row);
                updateTotals();
            });
        });
    }

    function calculateRow(dRecid) {
        var qtyValue = parseFloat(document.getElementById("qty" + dRecid).value) || 0;
        var uPriceVal = parseFloat(document.getElementById("rpqty" + dRecid).value) || 0;
        var gstValue = parseFloat(document.getElementById("gst" + dRecid).value) || 0;

        var totValue = qtyValue * uPriceVal;
        var gstAmount =  totValue * (gstValue / 100);
        var totalAmountWithGST = totValue + gstAmount;

        document.getElementById("taxableamount" + dRecid).value = totValue.toFixed(2);
        document.getElementById("gstvaldata" + dRecid).value = gstAmount.toFixed(2);
        document.getElementById("total_amount" + dRecid).value = totalAmountWithGST.toFixed(2);

        console.log(
            `Row ${dRecid} - Qty: ${qtyValue}, Unit Price: ${uPriceVal}, GST: ${gstValue}, Total: ${totValue.toFixed(2)}, GST Amount: ${gstAmount.toFixed(2)}, Total with GST: ${totalAmountWithGST.toFixed(2)}`
        );
    }

    function updateTotals() {
    let totalPrice = 0;
    let gstAmount = 0;
    const gstRates = [0,5, 12, 18, 28];
    const gstAmountElements = {};
    const businessState = document.getElementById("state").value; // Get the business state (e.g., "Tamil Nadu")

    // Initialize GST Amount Elements
    gstRates.forEach(rate => {
        gstAmountElements[rate] = 0;
    });

    // Calculate total price and GST amounts
    document.querySelectorAll('.total_amount').forEach(element => {
        totalPrice += parseFloat(element.value) || 0;
    });

    document.querySelectorAll('.gstvaldata').forEach(element => {
        const gstValue = parseFloat(element.value) || 0;
        const parentRow = element.closest('.row');
        const gstPerc = parseFloat(parentRow.querySelector('.gstperc').value) || 0;

        if (gstPerc > 0) {
            gstAmount += gstValue;
            gstAmountElements[gstPerc] = (gstAmountElements[gstPerc] || 0) + gstValue;
        }
    });

    const withOutGst = totalPrice - gstAmount;
    document.getElementById("totalAmountDisplay").value = withOutGst.toFixed(2);
    document.getElementById("taxAmount").value = gstAmount.toFixed(2);
    document.getElementById("netAmount").value = Math.round(totalPrice);

    // Update GST Table
    gstRates.forEach(rate => {
        const taxableElement = document.getElementById(`taxable${rate}Amount`);
        const cgstElement = document.getElementById(`taxAmount_${rate}_cgst`);
        const sgstElement = document.getElementById(`taxAmount_${rate}_sgst`);
        const igstElement = document.getElementById(`taxAmount_${rate}_igst`);
        const taxableAmount = gstAmountElements[rate] || 0;

        // Update taxable amount
        if (taxableElement) {
            taxableElement.value = withOutGst.toFixed(2);
        }

        // Handle GST Calculation for CGST/SGST or IGST
        if (taxableAmount > 0) {
            if (businessState !== "Tamil Nadu") {
                // If business is not in Tamil Nadu, apply IGST
                if (igstElement) {
                    const igstAmount = taxableAmount;
                    igstElement.value = igstAmount.toFixed(2);
                }
                // Hide CGST and SGST if applicable
                if (cgstElement) cgstElement.value = "";
                if (sgstElement) sgstElement.value = "";
            } else {
                // If business is in Tamil Nadu, apply CGST and SGST
                if (cgstElement && sgstElement) {
                    const cgstAmount = taxableAmount / 2;
                    const sgstAmount = taxableAmount / 2;

                    cgstElement.value = cgstAmount.toFixed(2);
                    sgstElement.value = sgstAmount.toFixed(2);
                }
                // Hide IGST if applicable
                if (igstElement) igstElement.value = "";
            }

            const row = document.querySelector(`tr.rate-${rate}`);
            if (row) row.style.display = '';  // Show the row if there is taxable amount
        } else {
            if(rate == 0 && totalPrice > 0){
                const row = document.querySelector(`tr.rate-${rate}`);
                if (row) row.style.display = '';
                }else{
                    const row = document.querySelector(`tr.rate-${rate}`);
                    if (row) row.style.display = 'none';  // Hide the row if there is no taxable amount
                }

        }
    });

    // console.log(
    //     `Total Amount: ${totalPrice.toFixed(2)}, IGST Total: ${igstAmount.toFixed(2)}, GST Total: ${gstAmount.toFixed(2)}, Amount Without GST: ${withOutGst.toFixed(2)}`
    // );
}


    function triggerInitialCalculations() {
        document.querySelectorAll('.qtybox, .uprice, .gstperc').forEach(function(element) {
            var event = new Event('input');
            element.dispatchEvent(event);
        });
    }


    function triggerInitialCalculations() {
        document.querySelectorAll('.qtybox, .uprice, .gstperc').forEach(function(element) {
            var event = new Event('input');
            element.dispatchEvent(event);
        });
    }

    var path = "{{ route('purchaseautocomplete') }}";

    $(document).ready(function() {
        $(document).on('focus', '.product_name', function() {
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
                                    return {
                                        label: product.item_name,
                                        purchase_price: product
                                            .purchase_price,
                                        gst_rate: product.gst_rate,
                                        id: product.id,
                                        sale_price: (product
                                            .sale_price +
                                            product.sale_price *
                                            (product.gst_rate /
                                                100)).toFixed(
                                            2),
                                        stock: product.stock,
                                        imei_required: product.imei
                                    };
                                }));
                            } else {
                                var $parent = $(this).closest(".row");
                                $parent.find('.uprice').val('0');
                                $parent.find('.gstperc').val('0');
                                $parent.find('.product_id').val('');
                            }
                        }.bind(this)
                    });
                },
                select: function(event, ui) {
                    var $parent = $(this).closest(".row");

                    // Populate product details
                    $parent.find('.product_name').val(ui.item.label);
                    $parent.find('.uprice').val(ui.item.purchase_price);
                    $parent.find('.gstperc').val(ui.item.gst_rate);
                    $parent.find('.product_id').val(ui.item.id);
                    $parent.find('.qtybox').attr('data-avail-qty', ui.item.stock);
                    $parent.find('.saleamount').val(ui.item.sale_price);
                    if (ui.item.imei_required === "yes") {
                        $parent.find('#imei-fields').show();
                    } else {
                        $parent.find('#imei-fields').remove();
                        $parent.find('.add-imei').remove();
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

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#basicModal').on('hidden.bs.modal', function() {
            $('#productForm').trigger("reset");
            $('#productForm').find('input, select').removeClass('is-invalid');
        });

        $('#productForm').submit(function(event) {
    event.preventDefault();
    var formData = $(this).serialize();
    var row_value = $("#row_value").val();

    $.post("{{ route('product.ajaxsave') }}", formData, function(data) {
        if (data.success) {
            $.each(data.product, function(key, value) {
                var sale_price1 = (value.sale_price + value.sale_price * (value.gst_rate / 100)).toFixed(2);
                $('[name="item_description' + row_value + '"]').val(value.item_name);
                $('[name="product_id' + row_value + '"]').val(value.id);
                $('#qtybox' + row_value).attr('data-avail-qty', value.stock);
                $('#gst' + row_value).val(value.gst_rate);
                $('#rpqty' + row_value).val(value.purchase_price);
                $('#saleamount' + row_value).val(sale_price1);

                if (value.imei == "yes") {
                    $('.imei-fields'+ row_value).show();
                } else {
                    $('.imei-fields'+ row_value).remove();
                    $('.imei-fields'+ row_value).find('.add-imei').remove();
                }
                alert(value.imei);
            });
            $('#basicModal').modal('hide');
        } else {
            alert('Error: ' + data.message);
        }
    }).fail(function() {
        alert('An error occurred while adding the product.');
    });
});


    });


    $(document).on('input', '.imei-field', function () {
    var imeiField = $(this);
    var row = imeiField.closest('.imei-fields-container').data('row');
    var nextRow = imeiField.closest('.input-group').next('.input-group');

    if (nextRow.length === 0) {
        addImeiRow(row);
    }

    updateQuantity(row);
    calculateRow(row);
    updateTotals();

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
        container.find('.remove-imei').last().on('click', function () {
            $(this).parent().remove();
            updateQuantity(row);
            calculateRow(row);
            updateTotals();
        });

        updateQuantity(row);
    }
});

// Add keydown event listener for Enter key navigation
$(document).on('keydown', '.imei-field', function (event) {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent form submission on Enter
        var inputs = document.querySelectorAll('.imei-field');
        var index = Array.prototype.indexOf.call(inputs, this);
        var nextInput = inputs[index + 1]; // Get the next input element
        if (nextInput) {
            nextInput.focus(); // Focus on the next input
        }
    }
});


    function updateQuantity(row) {
        var imeiFields = $(`.imei-fields-container[data-row="${row}"] .imei-field`);
        var quantityField = $(`#qty${row}`);
        var filledCount = imeiFields.filter(function() {
            return $(this).val().trim() !== '';
        }).length;
        quantityField.val(filledCount);
        calculateRow(row);
    }

    // $('#saleForm').submit(function(event) {
    //     var hasInvalidInput = false;

    //     $('.imei-field').each(function() {
    //         var value = $(this).val().trim();
    //         if (/^[0-9]{15}$/.test(value)) {
    //             hasInvalidInput = true;
    //             $(this).get(0).setCustomValidity(
    //                 'Barcode detected. Please correct or remove the barcode.');
    //         } else {
    //             $(this).get(0).setCustomValidity('');
    //         }
    //     });

    //     if (hasInvalidInput) {
    //         event.preventDefault();
    //         alert('Form submission stopped: Please correct or remove any barcodes detected in IMEI fields.');
    //     }
    // });

    $('#saleForm').on('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    });

    $('#saleFormSubmit').on('click', function() {
        $('#saleForm').requestSubmit();
    });

    $('#saleForm').find('.imei-fields-container').each(function() {
        var row = $(this).data('row');
        updateQuantity(row);
    });




    // partyadd
    $('#partysaveBtn').click(function (e) {
    e.preventDefault();
    $(this).html('Sending..');

            $.ajax({
                data: $('#partyForm').serialize(),
                url: "{{ route('party.ajaxsave') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#partyForm').trigger("reset");
                    $('#basicModal1').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#partysaveBtn').html('Save Changes');

                    $.each(data.party, function (key, value) {
                        $('.party').val(value.name);        // Set the value
                        $('#partyid').val(value.id);
                        $('#party_detail').val(value.billing_address_1 + ' ,' + value.billing_address_2 + ' ,' + value.billing_address_3);
                        $('#partyphone').val(value.phone_no);
                        $('#state').val(value.state);
                    });
                },
                error: function (xhr) {
                    console.log('Error:', xhr);
                    $('#partysaveBtn').html('Save Changes');

                    $('#validation-errors-party').html('');
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('#validation-errors-party').append(
                            '<div class="alert alert-danger">' + value + '</div>'
                        );
                    });
                }
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
            alert('a');
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

        document.querySelectorAll('input[name="same_address"]').forEach(function (element) {
            element.addEventListener('change', function () {
                if (this.value === 'yes') {
                    copyBillingToShipping();
                } else {
                    clearShippingAddress();
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const includingTaxField = document.getElementById('including_tax');
        const salePriceField = document.getElementById('sale_price');
        const gstRateField = document.getElementById('gst_rate');
        const gstAmountField = document.getElementById('gst_amount');
        const priceTypeRadios = document.querySelectorAll('input[name="price_type"]');
        const includingTaxContainer = document.getElementById('including-tax-container');
        const salePriceContainer = document.getElementById('sale-price-container');
        const gstAmountContainer = document.getElementById('gst-amount-container');

        const purchaseTypeRadios = document.querySelectorAll('input[name="purchase_type"]');
        const purchaseIncludingTaxField = document.getElementById('purchase_including_tax');
        const purchasePriceField = document.getElementById('purchase_price');
        const purchaseGstAmountField = document.getElementById('purchase_gst_amount');
        const purchaseIncludingTaxContainer = document.getElementById('purchase-including-tax-container');
        const purchasePriceContainer = document.getElementById('purchase-price-container');
        const purchaseGstAmountContainer = document.getElementById('purchase-gst-amount-container');

        function updateFields() {
            const selectedPriceType = document.querySelector('input[name="price_type"]:checked').value;
            const selectedPurchaseType = document.querySelector('input[name="purchase_type"]:checked').value;

            // Sale section
            if (selectedPriceType === 'with_tax') {
                includingTaxContainer.style.display = 'block';
                salePriceContainer.style.display = 'block';
                gstAmountContainer.style.display = 'block';
                calculateSalePriceFromIncludingTax();
            } else {
                includingTaxContainer.style.display = 'none';
                salePriceContainer.style.display = 'block';
                gstAmountContainer.style.display = 'none';
                gstAmountField.value = '';
                salePriceField.value = '';
            }

            // Purchase section
            if (selectedPurchaseType === 'purchase_with_tax') {
                purchaseIncludingTaxContainer.style.display = 'block';
                purchasePriceContainer.style.display = 'block';
                purchaseGstAmountContainer.style.display = 'block';
                calculatePurchaseFields();
            } else {
                purchaseIncludingTaxContainer.style.display = 'none';
                purchasePriceContainer.style.display = 'block';
                purchaseGstAmountContainer.style.display = 'none';
                purchaseGstAmountField.value = '';
                purchasePriceField.value = '';
            }
        }

        function calculateSalePriceFromIncludingTax() {
            const gstRate = parseFloat(gstRateField.value.trim()) || 0;
            const includingTax = parseFloat(includingTaxField.value.trim()) || 0;

            if (gstRate > 0 && includingTax > 0) {
                const salePrice = includingTax / (1 + gstRate / 100);
                const gstAmount = includingTax - salePrice;
                salePriceField.value = salePrice.toFixed(2);
                gstAmountField.value = gstAmount.toFixed(2);
            } else {
                salePriceField.value = '';
                gstAmountField.value = '';
            }
        }

        function calculateIncludingTaxFromSalePrice() {
            const gstRate = parseFloat(gstRateField.value.trim()) || 0;
            const salePrice = parseFloat(salePriceField.value.trim()) || 0;

            if (gstRate > 0 && salePrice > 0) {
                const gstAmount = salePrice * (gstRate / 100);
                const includingTax = salePrice + gstAmount;
                gstAmountField.value = gstAmount.toFixed(2);
                includingTaxField.value = includingTax.toFixed(2);
            } else {
                gstAmountField.value = '';
                includingTaxField.value = '';
            }
        }

        function calculatePurchaseFields() {
            const gstRate = parseFloat(gstRateField.value.trim()) || 0;
            const purchaseIncludingTax = parseFloat(purchaseIncludingTaxField.value.trim()) || 0;

            if (gstRate > 0 && purchaseIncludingTax > 0) {
                const purchasePrice = purchaseIncludingTax / (1 + gstRate / 100);
                const gstAmount = purchaseIncludingTax - purchasePrice;
                purchasePriceField.value = purchasePrice.toFixed(2);
                purchaseGstAmountField.value = gstAmount.toFixed(2);
            } else {
                purchasePriceField.value = '';
                purchaseGstAmountField.value = '';
            }
        }

        function calculatePurchaseIncludingTaxFromPrice() {
            const gstRate = parseFloat(gstRateField.value.trim()) || 0;
            const purchasePrice = parseFloat(purchasePriceField.value.trim()) || 0;

            if (gstRate > 0 && purchasePrice > 0) {
                const gstAmount = purchasePrice * (gstRate / 100);
                const purchaseIncludingTax = purchasePrice + gstAmount;
                purchaseGstAmountField.value = gstAmount.toFixed(2);
                purchaseIncludingTaxField.value = purchaseIncludingTax.toFixed(2);
            } else {
                purchaseGstAmountField.value = '';
                purchaseIncludingTaxField.value = '';
            }
        }

        function handlePriceTypeChange() {
            updateFields();
        }

        // Attach event listeners to radio buttons
        priceTypeRadios.forEach(radio => {
            radio.addEventListener('change', handlePriceTypeChange);
        });

        purchaseTypeRadios.forEach(radio => {
            radio.addEventListener('change', handlePriceTypeChange);
        });

        // Attach event listeners to fields to recalculate values
        includingTaxField.addEventListener('input', function() {
            if (document.querySelector('input[name="price_type"]:checked').value === 'with_tax') {
                calculateSalePriceFromIncludingTax();
            }
        });

        gstRateField.addEventListener('input', function() {
            calculateSalePriceFromIncludingTax();
            if (document.querySelector('input[name="purchase_type"]:checked').value ===
                'purchase_with_tax') {
                calculatePurchaseFields();
            }
        });

        salePriceField.addEventListener('input', function() {
            if (document.querySelector('input[name="price_type"]:checked').value === 'with_tax') {
                calculateIncludingTaxFromSalePrice();
            }
        });

        purchaseIncludingTaxField.addEventListener('input', function() {
            if (document.querySelector('input[name="purchase_type"]:checked').value ===
                'purchase_with_tax') {
                calculatePurchaseFields();
            }
        });

        purchasePriceField.addEventListener('input', function() {
            if (document.querySelector('input[name="purchase_type"]:checked').value ===
                'purchase_with_tax') {
                calculatePurchaseIncludingTaxFromPrice();
            }
        });

        // Initial call to set fields based on default selection
        updateFields();
    });
</script>
<script>
    document.querySelectorAll('.btn-primary[data-bs-toggle="modal"]').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('.row');
        const dataid = row.querySelector('.qtybox').getAttribute('dataid');
        $("#row_value").val(dataid);
    });
});
</script>
@endsection
