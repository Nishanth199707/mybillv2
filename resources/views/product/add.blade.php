@extends('layouts.v2.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-1">
                        <h5 class="mb-0">Add New Product</h5>
                    </div>
                    <div class="card-body">
                        <form id="product-form" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
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
                                        <option value="">Select Category</option>
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
                                    @if($businessCategory->business_category == 'Accounting & CA')
                                    <label class="form-label">SAC Code</label>
                                    @else
                                    <label class="form-label">HSN Code</label>
                                    @endif
                                    {{-- <input type="text" class="form-control" name="hsn_code"
                                        value="{{ old('hsn_code') }}" /> --}}
                                        <select name="hsn_code" id="hsn_code" class="form-select">
                                            {{-- @foreach ($hsncode as $code)
                                            <option @if (old('hsn_code')==$val) selected @endif
                                                value="{{ $code->code }}">{{ $code->code.'-'.$code->description }}</option>
                                            @endforeach --}}
                                        </select>
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
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Stock</label>
                                    <input type="text" class="form-control" id="stock" name="stock"
                                        value="{{ old('stock', '0') }}" />
                                    @if ($errors->has('stock'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stock') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            <!-- Checkbox to Show Modal -->
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

                                <!-- IMEI Modal -->
                                <div id="imeiModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imeiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imeiModalLabel">Add IMEI</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="imei-fields-container">
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field" name="imei[1][]" placeholder="ENTER IMEI"  />
                                                        <button type="button" class="btn btn-outline-danger remove-imei">Remove</button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary add-imei" data-row="1">Add IMEI</button>
                                            </div>
                                            <div class="modal-footer" style="background-color: white;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success save-imei">Save IMEI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Display IMEI Values Outside Modal -->
                                <div class="col-md-3 mb-1">
                                    <div id="imeiDisplayContainer" >
                                        <h5>IMEI Values:</h5>
                                        <ul id="imeiList"></ul>
                                    </div>
                                </div>
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

                            @if($businessCategory->business_category != 'Accounting & CA')
                            <!-- Purchase Details -->
                            <h5 class="mt-4 mb-4">Purchase Details</h5>
                            @if($businessCategory->gstavailable != 'no')
                                <div class="row" id="purchase-details">
                                        <div class="col-md-3 mb-1">
                                            <label class="form-label" for="purchase_type">Price Type</label>
                                            <select class="form-select" id="purchase_type" name="purchase_type">
                                                <option value="with_tax" selected>With Tax</option>
                                                <option value="without_tax">Without Tax</option>
                                            </select>
                                        </div>
                                </div>

                                    <div class="row" id="purchasedetails">
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
                            @endif


                            <div style="text-align: right;">
                                <button type="submit" id="save-button" class="btn btn-primary">Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->


    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<script>
    $(document).ready(function() {

        // $('#brand-container').hide();

        $('#category').change(function() {
            var categoryId = $(this).val();


            if (categoryId) {



                $.ajax({
                    url: '{{ url('get-brands') }}/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#product_category').empty().append('<option value="">Select Brand</option>');

                        $.each(data, function(key, value) {
                            $('#product_category').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to fetch brands.');
                    }
                });
            } else {
                $('#brand-container').hide();
            }
        });
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    const imeiCheckbox = document.getElementById('imeiCheckbox');
    const imeiFieldsContainer = document.getElementById('imeiFieldsContainer');

    imeiCheckbox.addEventListener('change', function () {
        if (this.checked) {
            imeiFieldsContainer.style.display = 'block';
        } else {
            imeiFieldsContainer.style.display = 'none';
        }
    });
});
</script>

<script>
$(document).ready(function () {
    // Show modal when checkbox is checked
    $('#imeiCheckbox').change(function () {
        if ($(this).is(':checked')) {
            $('#imeiModal').modal('show');
            $('#stock').addClass('readonly');
        }else{
            $('#stock').removeClass('readonly');
        }
    });

    // Add new IMEI field dynamically
    $(document).on('click', '.add-imei', function () {
        addImeiRow();
    });

    // Remove an IMEI field
    $(document).on('click', '.remove-imei', function () {
        $(this).closest('.input-group').remove();
    });

    $('.save-imei').click(function () {
        var imeiValues = [];
        $('.imei-field').each(function () {
            var imei = $(this).val().trim();
            if (imei) {
                imeiValues.push(imei);
            }
        });
        var imeiCount = imeiValues.length;
        $('#stock').val(imeiCount);
        var imeiList = $('#imeiList');
        imeiList.empty(); // Clear existing list
        imeiValues.forEach(function (imei) {
            imeiList.append(`<li>${imei}</li>`);
        });

        $('#imeiModal').modal('hide');
    });

    // Automatically open the next row when the current row is filled
    $(document).on('input', '.imei-field', function () {
        if ($(this).val().trim() !== '') {
            var nextRow = $(this).closest('.input-group').next('.input-group');
            if (nextRow.length === 0) {
                addImeiRow();
            }
        }
    });

    function addImeiRow() {
        var rowId = $('.imei-fields-container').data('row') || 0;
        var imeiGroup = `
            <div class="input-group mb-2">
                <input type="text" class="form-control imei-field" name="imei[${rowId}][]" placeholder="ENTER IMEI" />
                <button type="button" class="btn btn-outline-danger remove-imei">Remove</button>
            </div>
        `;
        $('.imei-fields-container').append(imeiGroup);
        const inputs = document.querySelectorAll('.imei-field');
                    inputs.forEach((input, index) => {
                        input.addEventListener('keypress', function(event) {
                        if (event.key === 'Enter') {
                        event.preventDefault(); // Prevent form submission on Enter
                            const nextInput = inputs[index + 1]; // Get the next input element
                            if (nextInput) {
                        nextInput.focus(); // Focus on the next input
                    }
                }
                });
            });
    }
});


</script>
<!-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const modalFieldsContainer = document.querySelector('.modal-fields-container');
    const addModalArrayButton = document.getElementById('addModalArray');

    let modalCount = 1; // Start with one prepopulated modal group

    // Add a new set of fields dynamically
    addModalArrayButton.addEventListener('click', () => {
        modalCount++;
        const fieldGroup = `
            <div class="modal-field-group mb-3" id="modal-group-${modalCount}">
                <h6>Modal ${modalCount}</h6>
                <input type="text" name="modals[${modalCount}][imei1]" class="form-control mb-2" placeholder="IMEI 1" required>
                <input type="text" name="modals[${modalCount}][imei2]" class="form-control mb-2" placeholder="IMEI 2">
                <input type="text" name="modals[${modalCount}][imei3]" class="form-control mb-2" placeholder="IMEI 3">
                <input type="text" name="modals[${modalCount}][imei4]" class="form-control mb-2" placeholder="IMEI 4">
                <input type="text" name="modals[${modalCount}][imei5]" class="form-control mb-2" placeholder="IMEI 5">
                <button type="button" class="btn btn-danger btn-sm remove-modal-group" data-group-id="${modalCount}">Remove</button>
            </div>
        `;
        modalFieldsContainer.insertAdjacentHTML('beforeend', fieldGroup);
    });

    // Remove a group of fields
    modalFieldsContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-modal-group')) {
            const groupId = event.target.getAttribute('data-group-id');
            document.getElementById(`modal-group-${groupId}`).remove();
        }
    });
});
    </script> -->
<!-- Bootstrap CSS -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->

<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Fetch the necessary elements
    const itemTypeField = document.getElementById('item_type');
    const stockField = document.querySelector('#stock')?.closest('.col-md-3');
    const imeiCheckboxField = document.querySelector('#imeiCheckbox')?.closest('.col-md-3');
    const imeiModal = document.getElementById('imeiModal');
    const purchaseDetail = document.getElementById('purchase-details');
    const purchaseDetailRow = document.getElementById('purchasedetails');
    const imeiDisplayContainer = document.getElementById('imeiDisplayContainer');
    const purchasepricecontainer = document.getElementById('purchase-price-container');


    // Function to toggle fields visibility
    function toggleFields() {
        if (itemTypeField && itemTypeField.value === 'service') {
            // Hide stock and IMEI-related fields
            if (stockField) stockField.style.display = 'none';
            if (imeiCheckboxField) imeiCheckboxField.style.display = 'none';

            if (imeiDisplayContainer) imeiDisplayContainer.style.display = 'none';

            if (purchaseDetail) purchaseDetail.style.display = 'none';
            if (purchaseDetailRow) purchaseDetailRow.style.display = 'none';
            if (purchasepricecontainer) purchasepricecontainer.style.display = 'none';


            // Ensure IMEI modal is closed if open
            if (imeiModal) {
                const modalInstance = bootstrap.Modal.getOrCreateInstance(imeiModal);
                modalInstance.hide();
            }
        } else {
            // Show stock and IMEI-related fields
            if (stockField) stockField.style.display = '';
            if (imeiCheckboxField) imeiCheckboxField.style.display = '';
            if (purchaseDetail) purchaseDetail.style.display = '';
            if (purchaseDetailRow) purchaseDetailRow.style.display = '';
        }
    }

    // Initial toggle check on page load
    toggleFields();

    // Add event listener to dropdown for dynamic updates
    if (itemTypeField) {
        itemTypeField.addEventListener('change', toggleFields);
    }
});
</script>

<script>
$(document).ready(function() {
    $('#hsn_code').select2({
        ajax: {
            url: '{{ route('hsn.codes') }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data.results, function (item) {
                        return {
                            text: item.code + ' - ' + item.description,
                            id: item.code
                        };
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });
});
</script>


@endsection
