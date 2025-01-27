@extends('layouts.v2.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Layout -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Quotation</h5>
                            <div>
                                <button id="print-quotation" class="btn btn-outline-secondary me-2">Print</button>
                                <button id="download-quotation-pdf" class="btn btn-outline-primary">Download PDF</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                <a class="btn btn-primary btn-sm mb-3" href="{{ route('quotations.create') }}">
                                    <i class="fa fa-arrow-left"></i> Add New Quotation
                                </a>
                            </div>
                            <div class="table-responsive" id="quotation-table-wrapper">
                                <table id="zero-config" class="table dt-table-hover">
                                    <thead id="table-head">
                                        <tr>
                                            <th>#</th>
                                            <th>Party</th>
                                            <th>Quotation Date</th>
                                            <th>Quotation No</th>
                                            <th>Net Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#zero-config')) {
                $('#zero-config').DataTable().destroy();
            }

            var table = $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('quotations.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1;
                        },
                        title: '#'
                    },
                    {
                        data: 'party',
                        title: 'Party'
                    },
                    {
                        data: 'quotation_date',
                        title: 'Quotation Date'
                    },
                    {
                        data: 'quotation_no',
                        title: 'Quotation No'
                    },
                    {
                        data: 'net_amount',
                        title: 'Net Amount'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        title: 'Action'
                    }
                ],
                dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    sInfo: "Showing page _PAGE_ of _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Search...",
                    sLengthMenu: "Results :  _MENU_",
                },
                stripeClasses: [],
                lengthMenu: [7, 10, 20, 50],
                pageLength: 10
            });

            // Print Quotation
           
    // Print Table with Data excluding Action column
    document.getElementById('print-quotation').addEventListener('click', function () {
        const actionColumnIndex = 5; // Index of the Action column (0-based index)
        const table = document.getElementById('zero-config');
        const actionCells = table.querySelectorAll(`td:nth-child(${actionColumnIndex + 1}), th:nth-child(${actionColumnIndex + 1})`);

        // Hide the Action column
        actionCells.forEach(cell => {
            cell.style.display = 'none';
        });

        // Create a printable view
        const printWindow = window.open('', '', 'height=600,width=800');
        const tableClone = table.cloneNode(true); // Clone the table to keep the original intact
        tableClone.querySelectorAll(`td:nth-child(${actionColumnIndex + 1}), th:nth-child(${actionColumnIndex + 1})`).forEach(cell => {
            cell.remove(); // Remove Action column cells from the clone
        });

        printWindow.document.write(`
            <html>
                <head>
                    <title>Quotation</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    <h2>Quotation Table</h2>
                    ${tableClone.outerHTML}
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();

        // Restore the Action column
        actionCells.forEach(cell => {
            cell.style.display = '';
        });
    });




            // Download Quotation as PDF
            document.getElementById('download-quotation-pdf').addEventListener('click', function() {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                // Add Title
                doc.text('Quotation Report', 14, 10);

                // Fetch Data from DataTable
                const tableData = table.rows().data().toArray().map((row, index) => [
                    index + 1,
                    row.party,
                    row.quotation_date,
                    row.quotation_no,
                    `₹ ${parseFloat(row.net_amount).toFixed(2)}`
                ]);

                // Add Table to PDF
                doc.autoTable({
                    head: [
                        ['#', 'Party', 'Quotation Date', 'Quotation No', 'Net Amount']
                    ],
                    body: tableData,
                    startY: 20,
                    styles: {
                        fontSize: 10,
                        overflow: 'linebreak'
                    },
                    theme: 'grid'
                });

                // Save PDF
                doc.save('quotation_report.pdf');
            });
        });
    </script>
@endsection
