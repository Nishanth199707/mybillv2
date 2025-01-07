@extends('layouts.v2.app')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Edit Product</h4> -->

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-1">
                        <h5 class="mb-0">Edit Product</h5>
                    </div>
                    <div class="card-body">
                        <form id="product-form" method="POST" action="{{ route('product.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Product Details -->
                            <h5 class="mb-4">Product Details</h5>
                            <div class="row">
                                <div class="col-md-2 mb-1">
                                    <label class="form-label">Item Type</label>
                                    <select name="item_type" id="item_type" class="form-select">
                                        <option value="sale" @if ($product->item_type == 'sale') selected @endif>Sale
                                        </option>
                                        <option value="service" @if ($product->item_type == 'service') selected @endif>
                                            Service</option>
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
                                        @foreach ($productCategory as $val)
                                        <option @if ($product->category == $val->name) selected @endif
                                            value="{{ $val->name }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-1"> <label for="product_category" class="form-label">Select
                                        Brand</label>
                                    <select name="sub_category" id="product_category" class="form-select" required>
                                        <option value="">Select Brand</option>
                                        @foreach ($ProductsubCategory as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            @if ($subcategory->id == $product->sub_category_id) selected @endif>
                                            {{ $subcategory->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product_categories_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_categories_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Item Name</label>
                                    <input type="text" class="form-control" name="item_name"
                                        value="{{ $product->item_name }}" />
                                    @error('item_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-1">
                                    <label class="form-label">HSN Code</label>
                                    <input type="text" class="form-control" name="hsn_code"
                                        value="{{ $product->hsn_code }}" />
                                    @error('hsn_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-md-3 mb-1">
                                    <label class="form-label">Item Code / Barcode</label>
                                    <input type="text" class="form-control" name="item_code_barcode"
                                    value="{{ $product->item_code_barcode }}" />
                                    @if ($errors->has('item_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('item_code_barcode') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Product Image</label>
                                    @if ($product->image)
                                    <img src="{{ asset('uploads/product/' . $product->image) }}" width="100"
                                        height="100" alt="">
                                    @endif
                                    <input type="file" class="form-control" name="image" />
                                    @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Product Description</label>
                                    <textarea class="form-control" name="description" rows="2" placeholder="Enter the description">{{ $product->description }}</textarea>
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
                                            @if ($product->units == $key) selected @endif>{{ $val }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('units')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                @if($businessCategory->gstavailable != 'no')

                                <div class="col-md-3 mb-1">
                                    <label class="form-label">GST Rate (%)</label>
                                    <select class="form-select" id="gst_rate" name="gst_rate">
                                        <option value="">Select GST Rate</option>
                                        <option value="28" {{ $product->gst_rate == '28' ? 'selected' : '' }}>28%</option>
                                        <option value="18" {{ $product->gst_rate == '18' ? 'selected' : '' }}>18%</option>
                                        <option value="12" {{ $product->gst_rate == '12' ? 'selected' : '' }}>12%</option>
                                        <option value="5" {{ $product->gst_rate == '5' ? 'selected' : '' }}>5%</option>
                                    </select>
                                    @error('gst_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @else
                                @endif
                                <div class="col-md-3 mb-1">
                                    <label class="form-label">Stock</label>
                                    <input type="text" id="stock" class="form-control <?php if($product->imei == 'yes'){ echo 'readonly';} ?>" name="stock"
                                        value="{{ $product->stock }}" />
                                    @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @if($product->imei == 'yes')
                                <div class="col-md-3 mb-1">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imeiModal"> Edit IMEI</button>
                                </div>
                                  <!-- IMEI Modal -->
                                  <div id="imeiModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imeiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imeiModalLabel">Edit IMEI</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="imei-fields-container">
                                                    @foreach ($unsoldProducts as $index => $product)
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field" name="imei[1][]" placeholder="ENTER IMEI" value="{{ $product->field_value}}" />
                                                        <button type="button" class="btn btn-outline-danger remove-imei">Remove</button>
                                                    </div>
                                                    @endforeach
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control imei-field" name="imei[1][]" placeholder="ENTER IMEI"  />
                                                        <button type="button" class="btn btn-outline-danger remove-imei">Remove</button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary add-imei" data-row="1">Add IMEI</button>
                                            </div>
                                            <div class="modal-footer" style="background-color: white;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success save-imei">Update IMEI</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                  <!-- Display IMEI Values Outside Modal -->
                                  <div class="col-md-3 mb-1">
                                    <div id="imeiDisplayContainer" >
                                        <h5>IMEI Values:</h5>
                                        <ul id="imeiList">
                                            @foreach ($unsoldProducts as $index => $product)
                                            <li>{{ $product->field_value }}</li>
                                            @endforeach
                                        </ul>
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
                                        <option value="" disabled>Select</option>
                                        <option value="with_tax" {{ $product->price_type == 'with_tax' ? 'selected' : '' }}>With Tax</option>
                                        <option value="without_tax" {{ $product->price_type == 'without_tax' ? 'selected' : '' }}>Without Tax</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-1" id="including-tax-container">
                                    <label class="form-label">Sales Price (Including Tax)</label>
                                    <input type="text" class="form-control" id="including_tax" name="including_tax" />
                                    @error('including_tax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-1" id="sale-price-container">
                                    <label class="form-label">Taxable Amount (Sale Price)</label>
                                    <input type="text" class="form-control" id="sale_price" name="sale_price" value="{{ $product->sale_price }}" />
                                    @error('sale_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-1" id="gst-amount-container">
                                    <label class="form-label">GST Amount</label>
                                    <input type="text" class="form-control" id="gst_amount" name="gst_amount" readonly value="{{ $product->gst_amount }}" />
                                    @error('gst_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @else
                            <div class="col-md-3 mb-1" id="sale-price-container">
                                <label class="form-label">Taxable Amount (Sale Price)</label>
                                <input type="text" class="form-control" id="sale_price" name="sale_price" value="{{ $product->sale_price }}" />
                                @error('sale_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif

                            <!-- Purchase Details -->
                            <h5 class="mt-4 mb-4">Purchase Details</h5>
                            @if($businessCategory->gstavailable != 'no')

                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <label class="form-label" for="purchase_type">Price Type</label>
                                    <select class="form-select" id="purchase_type" name="purchase_type">
                                        <option value="" disabled>Select</option>
                                        <option value="with_tax" {{ $product->purchase_type == 'with_tax' ? 'selected' : '' }}>With Tax</option>
                                        <option value="without_tax" {{ $product->purchase_type == 'without_tax' ? 'selected' : '' }}>Without Tax</option>
                                    </select>
                                </div>

                                <!-- <div class="col-md-3 mb-1">
                                    <label class="form-label" for="purchase_gst_rate">GST Rate (%)</label>
                                    <select class="form-select" id="gst_rate" name="gst_rate">
                                        <option value="">Select GST Rate</option>
                                        <option value="28" {{ $product->gst_rate == '28' ? 'selected' : '' }}>28%</option>
                                        <option value="18" {{ $product->gst_rate == '18' ? 'selected' : '' }}>18%</option>
                                        <option value="12" {{ $product->gst_rate == '12' ? 'selected' : '' }}>12%</option>
                                        <option value="5" {{ $product->gst_rate == '5' ? 'selected' : '' }}>5%</option>
                                    </select>
                                    @error('purchase_gst_rate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> -->
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
                                        value="{{ $product->purchase_price }}" />
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
                            <!-- Taxable Amount (Purchase Price) Field -->
                            <div class="col-md-3 mb-1" id="purchase-price-container">
                                <label class="form-label">Taxable Amount (Purchase Price)</label>
                                <input type="text" class="form-control" id="purchase_price" name="purchase_price"
                                    value="{{ $product->purchase_price }}" />
                                @if ($errors->has('purchase_price'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('purchase_price') }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="mt-4 text-end" >
                                <button type="submit" class="btn btn-primary">Save Product</button>
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
        // Sale Fields
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

        // Function to update sale fields based on price_type and GST rate
        function updateSalesFields() {
            const selectedType = priceTypeSelect.value;
            const gstRate = parseFloat(gstRateField.value) || 0;

            if (selectedType === 'with_tax') {
                includingTaxField.readOnly = false;
                salePriceField.readOnly = true;

                const includingTax = parseFloat(includingTaxField.value) || 0;
                // alert(includingTax);
                if (gstRate > 0 && includingTax != 0) {
                    const taxableAmount = includingTax / (1 + gstRate / 100);
                    const gstAmount = includingTax - taxableAmount;

                    salePriceField.value = taxableAmount.toFixed(2);
                    gstAmountField.value = gstAmount.toFixed(2);
                } else if (gstRate > 0 && includingTax === 0) {
                    const taxableAmount = parseFloat(salePriceField.value) || 0;
                    const gstAmount = taxableAmount * (gstRate / 100);
                    const includingTax = taxableAmount + gstAmount;

                    salePriceField.value = taxableAmount.toFixed(2);
                    gstAmountField.value = gstAmount.toFixed(2);
                    includingTaxField.value = includingTax.toFixed(2);
                } else {
                    alert("Invalid GST rate or taxable amount.");
                }

            } else {
                includingTaxField.readOnly = true;
                salePriceField.readOnly = false;

                const taxableAmount = parseFloat(salePriceField.value) || 0;
                if (gstRate > 0 && taxableAmount > 0) {
                    const gstAmount = taxableAmount * (gstRate / 100);
                    const includingTax = taxableAmount + gstAmount;

                    includingTaxField.value = includingTax.toFixed(2);
                    gstAmountField.value = gstAmount.toFixed(2);
                }
            }
        }

        // Function to update purchase fields based on purchase_type and GST rate
        function updatePurchaseFields() {
            const selectedType = purchaseTypeSelect.value;
            const gstRate = parseFloat(gstRateField.value) || 0;

            if (selectedType === 'with_tax') {
                purchaseIncludingTaxField.readOnly = false;
                purchasePriceField.readOnly = true;
                purchaseGstAmountField.readOnly = true;

                const includingTax = parseFloat(purchaseIncludingTaxField.value) || 0;

                if (gstRate > 0 && includingTax != 0) {
                    const taxableAmount = includingTax / (1 + gstRate / 100);
                    const gstAmount = includingTax - taxableAmount;

                    purchasePriceField.value = taxableAmount.toFixed(2);
                    purchaseGstAmountField.value = gstAmount.toFixed(2);
                } else if (gstRate > 0 && includingTax === 0) {
                    const taxableAmount = parseFloat(purchasePriceField.value) || 0;
                    const gstAmount = taxableAmount * (gstRate / 100);
                    const includingTax = taxableAmount + gstAmount;

                    purchasePriceField.value = taxableAmount.toFixed(2);
                    purchaseGstAmountField.value = gstAmount.toFixed(2);
                    purchaseIncludingTaxField.value = includingTax.toFixed(2);
                } else {
                    alert("Invalid GST rate or taxable amount.");
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

        // Function to initialize fields and trigger calculation based on existing values
        function initializeFields() {
            // Get current values for price type and purchase type
            const priceType = priceTypeSelect.value;
            const purchaseType = purchaseTypeSelect.value;

            // Trigger sales and purchase fields calculation based on the initial values
            if (priceType) {
                updateSalesFields(); // Trigger sale field calculations
            }

            if (purchaseType) {
                updatePurchaseFields(); // Trigger purchase field calculations
            }
        }

        // Event Listeners (for changes made by the user)
        priceTypeSelect.addEventListener('change', updateSalesFields);
        includingTaxField.addEventListener('input', updateSalesFields);
        salePriceField.addEventListener('input', updateSalesFields);
        gstRateField.addEventListener('change', updateSalesFields);

        purchaseTypeSelect.addEventListener('change', updatePurchaseFields);
        purchaseIncludingTaxField.addEventListener('input', updatePurchaseFields);
        purchasePriceField.addEventListener('input', updatePurchaseFields);
        gstRateField.addEventListener('change', updatePurchaseFields);

        // Auto-trigger calculation on page load
        initializeFields();
    });
</script>
<script>
$(document).ready(function () {
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
    }
});


</script>



@endsection