@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Sale Report</h5>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; align-items: center; gap: 10px; margin: 20px 0px;">
                            <div>
                                <strong>From Date:</strong>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="" />
                            </div>
                            <div>
                                <strong>To Date:</strong>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="" />
                            </div>

                            <!-- Category Filter Dropdown -->
                            <div>
                                <strong>Category:</strong>
                                <select id="categoryFilter" class="form-control">
                                    <option value="all">All Category</option>
                                    <!-- Categories will be loaded dynamically -->
                                </select>
                            </div>

                            <!-- Subcategory (Brand) Filter Dropdown -->
                            <div>
                                <strong>Subcategory (Brand):</strong>
                                <select id="subcategoryFilter" class="form-control">
                                    <option value="all">All Subcategory</option>
                                    <!-- Subcategories (Brands) will be loaded dynamically -->
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div>
                                <button class="btn btn-primary mt-3 filter">Filter</button>

                            </div>
                            <div class="btn-group text-end">
                                <button href="{{ route('gst.salereport') }}" class="btn btn-outline-primary mt-3 export">Excel</button>
                                <button href="javascript:void(0);" class="btn btn-outline-primary btn-download contenttopdf1 mt-3">Pdf</button>
                                <button href="#" class="btn btn-outline-success mt-3">Share</button>
                            </div>
                        </div>




                        <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a class="btn btn-primary  mb-3 export" href="{{ route('gst.salereport') }}"><i
                                    class="fa fa-arrow-left"></i> Export</a>
                        </div> -->
                        <div style="margin-bottom: 20px;" class="text-end">
                            <h5>Total Sale Amount: <span id="total-sale-amount">0.00</span></h5>
                        </div>
                        <table id="zero-config" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Party</th>
                                    <th>Invoice Date</th>
                                    <th>Brand</th>
                                    <th>Product</th>
                                    <th>Invoice No</th>
                                    <th>Net Amount</th>
                                </tr>
                            </thead>
                        </table>
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
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(function() {
        // Load Categories into the Category Filter dropdown
        $.ajax({
            url: "{{ route('productcategory.categoryindex') }}", // Adjust to the correct route
            method: 'GET',
            success: function(data) {
                // Append categories to the category filter
                $.each(data, function(index, category) {
                    $('#categoryFilter').append(
                        `<option value="${category.name}">${category.name}</option>`
                    );
                });
            },
            error: function() {
                alert('Unable to fetch categories.');
            }
        });

        // Load Subcategories (Brands) based on selected Category
        $('#categoryFilter').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/get-brands/' + categoryId, // Adjust URL as per your backend
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Empty the Subcategory dropdown and append new options
                        $('#subcategoryFilter').empty().append(
                            '<option value="all">ALL Subcategory</option>');
                        $.each(data, function(key, value) {
                            $('#subcategoryFilter').append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Unable to fetch subcategories (brands).');
                    }
                });
            } else {
                // If no category selected, clear the subcategory dropdown
                $('#subcategoryFilter').empty().append('<option value="">Select Subcategory</option>');
            }
        });

        // Initialize DataTable
        if ($.fn.DataTable.isDataTable('#zero-config')) {
            $('#zero-config').DataTable().destroy();
        }

        var table = $('#zero-config').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('sale.gstreport') }}",
                data: function(d) {
                    const startDate = $('#from_date').val();
                    const endDate = $('#to_date').val();
                    const category = $('#categoryFilter')
                        .val();
                    const subcategory = $('#subcategoryFilter')
                        .val();


                    d.from_date = startDate;
                    d.to_date = endDate;
                    d.category = category;
                    d.subcategory = subcategory;



                    console.log("From Date:", startDate);
                    console.log("To Date:", endDate);
                    console.log("Selected Category:", category);
                    console.log("Selected Subcategory:", subcategory);

                },
                error: function(xhr, error, thrown) {

                    console.error("AJAX Error: ", error);
                    console.error("XHR: ", xhr);
                },
                dataSrc: function(json) {
                    // Update Total Sale Amount
                    $('#total-sale-amount').text(json.totalAmount.toFixed(2));
                    return json.data;
                }
            },
            columns: [{
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1;
                    },
                    title: '#'
                },
                {
                    data: 'party',
                    name: 'party'
                },
                {
                    data: 'invoice_date',
                    name: 'invoice_date'
                },
                {
                    data: 'name',
                    name: 'Brand'
                },
                {
                    data: 'item_description',
                    name: 'product'
                },
                {
                    data: 'invoice_no',
                    name: 'invoice_no'
                },
                {
                    data: 'net_amount',
                    name: 'net_amount'
                }
            ],
            dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                oPaginate: {
                    sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                sInfo: "Showing page _PAGE_ of _PAGES_",
                sLengthMenu: "Results : _MENU_",
            },
            stripeClasses: [],
            lengthMenu: [7, 10, 20, 50],
            pageLength: 10
        });

        $(".filter").click(function() {
            console.log("Filter button clicked");
            table.draw();
        });

        $(".export").click(function(event) {
            event.preventDefault();
            const startDate = $('#from_date').val();
            const endDate = $('#to_date').val();
            const category = $('#categoryFilter').val();
            const subcategory = $('#subcategoryFilter').val();
            const product = $('#productFilter').val();

            window.location.href = "{{ route('gst.salereport') }}" + "?from_date=" + startDate +
                "&to_date=" + endDate + "&category=" + category +
                "&subcategory=" + subcategory;
        });

        // PDF Export Functionality
        $(".contenttopdf1").click(function(event) {
            event.preventDefault();

            const startDate = $('#from_date').val();
            const endDate = $('#to_date').val();
            const category = $('#categoryFilter').val();
            const subcategory = $('#subcategoryFilter').val();

            // Fetch filtered data via AJAX
            $.ajax({
                url: "{{ route('sale.gstreport') }}",
                type: "GET",
                data: {
                    from_date: startDate,
                    to_date: endDate,
                    category: category,
                    subcategory: subcategory
                },
                success: function(response) {
                    const {
                        jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF();

                    // Title
                    doc.text("GST Sales Report", 14, 10);
                    doc.setFontSize(10);

                    // Table Data
                    const tableData = response.data.map((row, index) => [
                        index + 1,
                        row.party,
                        row.invoice_date,
                        row.name,
                        row.item_description,
                        row.invoice_no,
                        row.net_amount
                    ]);

                    // Create Table
                    doc.autoTable({
                        head: [
                            ['#', 'Party', 'Invoice Date', 'Brand', 'Product', 'Invoice No', 'Net Amount']
                        ],
                        body: tableData,
                        startY: 20,
                        styles: {
                            overflow: 'linebreak',
                            cellWidth: 'auto'
                        }
                    });

                    // Save PDF
                    doc.save("gst_sales_report.pdf");
                },
                error: function() {
                    alert("Failed to generate PDF. Please try again.");
                }
            });
        });
    });
</script>
@endpush
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
@endsection
