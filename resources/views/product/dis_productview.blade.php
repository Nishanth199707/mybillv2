@extends('layouts.v2.app')
@section('content')
<style>
    .dt-pagination .paginate_button {
        color: #333;
        padding: 5px 10px;
        border-radius: 4px;
        background-color: #f1f1f1;
        margin: 0 2px;
        cursor: pointer;
    }

    .dt-pagination .paginate_button.current {
        background-color: #007bff;
        color: white;
    }
</style>

<!-- Content wrapper -->
<div class="content-wrapper">

    {{-- @if (session('success'))
        <div class="alert alert-success">
            <ul class="mb-0">
                {{ session('success') }}
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    @php
    $user_id = session('user_id');
    $businessCategory = App\Models\Business::where('user_id', $user_id)
    ->select('business_category', 'gstavailable')
    ->first();
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">View Product</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-2">
                                <label class="form-label" for="categoryFilter">Category</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="all">All</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="subcategoryFilter">Subcategory</label>
                                <select id="subcategoryFilter" class="form-select">
                                    <option value="all">All</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Brand</th>
                                        <th>Name</th>
                                        <th>Item Type</th>
                                        <th>Purchase Price</th>
                                        <th>Sale Price</th>
                                        <th>Stock</th>
                                        <th class="no-content">Action</th>
                                    </tr>

                                </thead>
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

<script type="text/javascript">
    $(document).ready(function() {
        const gstAvailable = "<?php echo $businessCategory->gstavailable; ?>";

        // Function to fetch categories
        $.ajax({
            url: "{{ route('productcategory.categoryindex') }}",
            method: 'GET',
            success: function(data) {
                // Populate category filter options
                $.each(data, function(index, category) {
                    $('#categoryFilter').append(
                        `<option value="${category.name}">${category.name}</option>`
                    );
                });
            }
        });

        // Change event for category filter
        $('#categoryFilter').change(function() {
            var categoryId = $(this).val();
            if (categoryId !== 'all') {
                $.ajax({
                    url: '{{ url('get-brands') }}/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subcategoryFilter').empty().append('<option value="all">All</option>');
                        $.each(data, function(key, value) {
                            $('#subcategoryFilter').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to fetch subcategories.');
                    }
                });
            } else {
                $('#subcategoryFilter').empty().append('<option value="all">All</option>');
            }
        });




        var table = $('#zero-config').DataTable({
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('product.disablelist') }}",
                data: function(d) {
                    d.categoryFilter = $('#categoryFilter').val();
                    d.subcategoryFilter = $('#subcategoryFilter').val();
                }
            },
            columns: [{
                    data: null,
                    render: (data, type, row, meta) => meta.row + 1,
                    title: '#'
                },
                {
                    data: 'image',
                    title: 'Image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'category_name',
                    title: 'Brand'
                },
                {
                    data: 'item_name',
                    title: 'Name',
                    render: function(data) {
                        const maxCharsPerLine = 16;
                        return data.length > maxCharsPerLine ?
                            data.substring(0, maxCharsPerLine) + '<br>' + data.substring(maxCharsPerLine) :
                            data;
                    }
                },
                {
                    data: 'item_type',
                    title: 'Item Type'
                },
                // Conditional column for Purchase Price
                gstAvailable !== 'no' ? {
                    data: 'purchase_price',
                    title: 'Purchase Price',
                    render: function(data, type, row) {
                        const gstRate = row.gst_rate / 100;
                        const purchasePrice = parseFloat(data);
                        if (!isNaN(purchasePrice) && !isNaN(gstRate)) {
                            const totalPrice = purchasePrice * (1 + gstRate);
                            return Math.round(totalPrice);
                        }
                        return 'N/A';
                    }
                } : {
                    data: 'purchase_price',
                    title: 'Purchase Price'
                },
                // Conditional column for Sale Price
                gstAvailable !== 'no' ?
                {
                    data: 'sale_price',
                    title: 'Sale Price',
                    render: function(data, type, row) {
                        const gstRate = row.gst_rate / 100;
                        // console.log(gstRate);
                        const salePrice = parseFloat(data);
                        if (!isNaN(salePrice) && !isNaN(gstRate)) {
                            const totalPrice = salePrice * (1 + gstRate);
                            return Math.round(totalPrice);
                        }
                        return 'N/A';
                    }
                } :
                {
                    data: 'sale_price',
                    title: 'Sale Price'
                },

                {
                    data: 'stock',
                    title: 'Stock'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    title: 'Action'
                }
            ],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 10
        });



        // Re-draw table on filter change
        $('#categoryFilter, #subcategoryFilter').change(function() {
            table.draw();
        });
    });
</script>
@endsection
