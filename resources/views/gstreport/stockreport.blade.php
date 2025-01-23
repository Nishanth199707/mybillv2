@extends('layouts.v2.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Stock Report</h5>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; align-items: center; gap: 10px; margin: 20px 0px;">

                                <div>
                                    <strong>Category:</strong>
                                    <select id="categoryFilter" class="form-control">
                                        <option value="all">All </option>
                                    </select>
                                </div>

                                <div>
                                    <strong>Subcategory (Brand):</strong>
                                    <select id="subcategoryFilter" class="form-control">
                                        <option value="all">All </option>
                                    </select>
                                </div>

                                <div>
                                    <button class="btn btn-primary mt-3 filter">Filter</button>
                                </div>
                                <div class="btn-group text-end">
                                <button href="{{ route('gst.stockreport') }}" class="btn btn-outline-primary mt-3 export">Excel</button>
                                <button href="javascript:void(0);" class="btn btn-outline-primary btn-download contenttopdf1 mt-3">Pdf</button>
                                <button href="#" class="btn btn-outline-success mt-3">Share</button>
                            </div>
                            </div>
                            <div style="margin-bottom: 20px;" class="text-end">
                             <h5>Total Stock Amount: <span id="total-sale-amount">0.00</span></h5>
                            </div>
                            <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                <a class="btn btn-primary mb-3 export" href="{{ route('gst.stockreport') }}"><i class="fa fa-arrow-left"></i> Excel</a>
                            </div> -->

                            <table id="zero-config" class="table dt-table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Stock Price</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>IMEI</th>
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

    @push('stylecss')
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @endpush

    @push('scripts')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script type="text/javascript">
            $(function() {
                // Fetch categories
                $.ajax({
                    url: "{{ route('productcategory.categoryindex') }}",
                    method: 'GET',
                    success: function(data) {
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

                // Fetch subcategories when category is selected
                $('#categoryFilter').change(function() {

                    var categoryId = $(this).val();
                    // alert(categoryId);
                    if (categoryId) {
                        $.ajax({
                            url: '/get-brands/' + categoryId,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#subcategoryFilter').empty().append('<option value="all">ALL </option>');
                                $.each(data, function(key, value) {
                                    $('#subcategoryFilter').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            },
                            error: function() {
                                alert('Unable to fetch subcategories (brands).');
                            }
                        });
                    } else {
                        $('#subcategoryFilter').empty().append('<option value="all">All</option>');
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
                        url: "{{ route('stock.gstreport') }}",
                        data: function(d) {
                            const category = $('#categoryFilter').val();
                            const subcategory = $('#subcategoryFilter').val();
                            d.category = category;
                            d.subcategory = subcategory;
                        },
                        error: function(xhr, error, thrown) {
                            console.error("AJAX Error: ", error);
                            console.error("XHR: ", xhr);
                        },
                        dataSrc: function(json) {
                            console.log("Fetched Data:", json);
                            $('#total-sale-amount').text(json.total_amount.toFixed(2));
                            return json.data;
                        }
                    },
                    columns: [
                        {
                            data: null,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.settings._iDisplayStart + meta.row + 1;
                            },
                            title: '#'
                        },
                        { data: 'item_name', title: 'Product Name' },
                        { data: 'total_stock', title: 'Stock' },
                        { data: 'price_det', title: 'Price' },
                        { data: 'stock_price', title: 'Stock Price' },
                        { data: 'category', title: 'Category' },
                        { data: 'subcategory_name', title: 'Subcategory' },
                        { data: 'imei_list', title: 'IMEI' }
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

                // Filter button click event
                $(".filter").click(function() {
                    table.draw();
                });

                // Export button click event
                $(".export").click(function(event) {
                    event.preventDefault();

                    const category = $('#categoryFilter').val();
                    const subcategory = $('#subcategoryFilter').val();


                window.location.href = "{{ route('gst.stockreport') }}"  + "?category=" + category +
                        "&subcategory=" + subcategory ;
                });

                   // PDF Download Functionality
        $(".contenttopdf1").click(function (event) {
            event.preventDefault();

            const category = $('#categoryFilter').val();
            const subcategory = $('#subcategoryFilter').val();

            // Fetch data from the server
            $.ajax({
                url: "{{ route('stock.gstreport') }}",
                type: 'GET',
                data: {
                    category: category,
                    subcategory: subcategory
                },
                success: function (response) {
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();

                    // Add Title
                    doc.text("Stock GST Report", 14, 10);
                    doc.setFontSize(10);

                    // Process data for the table
                    const tableData = response.data.map((row, index) => [
                        index + 1,
                        row.item_name,
                        row.total_stock,
                        row.category,
                        row.subcategory_name,
                        row.imei_list
                        .replace(/<br\s*\/?>/gi, '\n')
                        ]);


                    // Generate PDF Table
                    doc.autoTable({
                        head: [['#', 'Product Name', 'Stock', 'Category', 'Subcategory', 'IMEI']],
                        body: tableData,
                        startY: 20
                    });

                    // Save the PDF
                    doc.save("stock_gst_report.pdf");
                },
                error: function () {
                    alert("Failed to fetch data for PDF. Please try again.");
                }
            });
        });
            });
        </script>
    @endpush
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
@endsection
