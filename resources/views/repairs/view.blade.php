@extends('layouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Repair Requests</h5>
                        </div>
                        <div class="card-body">

                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('repairs.create') }}">
                                        <i class="fa fa-plus"></i> Create New Repair Request
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" id="date-from" class="form-control" placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" id="date-to" class="form-control" placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <select id="repair-status-filter" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="waiting_for_spare">Waiting for Spare</option>
                                        <option value="returned">Returned</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button id="filter-button" class="btn btn-secondary btn-filter">Filter</button>
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('gst.Servicereport') }}" class="btn btn-outline-primary">Excel</a>
                                        <a href="javascript:void(0);"
                                            class="btn btn-outline-primary btn-download contenttopdf1">Pdf</a>
                                        <a href="#" class="btn btn-outline-success">Share</a>
                                    </div>
                                </div>
                            </div>



                            <div class="table-responsive">
                                <table id="zero-config" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ACK No</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Date</th>
                                            <th>Complaint</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize DataTable
            $('#filter-button').click(function() {
                $('#zero-config').DataTable().ajax.reload();
            });

            var table = $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('repairs.index') }}",

                    data: function(d) {
                        d.status = $('#repair-status-filter').val();
                        d.date_from = $('#date-from').val();
                        d.date_to = $('#date-to').val();
                        console.log({
                            status: d.status,
                            date_from: d.date_from,
                            date_to: d.date_to
                        });
                    }

                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'service_no',
                        title: 'ACK No'
                    },
                    {
                        data: 'customer_name',
                        title: 'Customer Name'
                    },
                    {
                        data: 'phone',
                        title: 'Phone'
                    },
                    {
                        data: 'date',
                        title: 'Date'
                    },
                    {
                        data: 'complaint_remark',
                        title: 'Complaint',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'max-width': '100px',
                                'white-space': 'normal',
                                'word-wrap': 'break-word',
                                'overflow-wrap': 'break-word'
                            });
                        }
                    },
                    {
                        data: 'status',
                        title: 'Status',
                        orderable: false,
                        searchable: false,

                    },
                    {
                        data: 'action',
                        title: 'Actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    sInfo: "Showing page _PAGE_ of _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Search...",
                    sLengthMenu: "Results : _MENU_"
                },
                stripeClasses: [],
                lengthMenu: [7, 10, 20, 50],
                pageLength: 10
            });

            // Reload table when the filter changes
            $('#repair-status-filter').on('change', function() {
                table.ajax.reload();
            });

            $(".export").click(function(event) {
                event.preventDefault();
                const filter = $('#repair-status-filter').val();
                window.location.href = "{{ route('gst.Servicereport') }}" + "?filter=" + filter;
            });
            $(".contenttopdf1").click(function (event) {
    event.preventDefault();
    const filter = $('#repair-status-filter').val();
    const date_from = $('#date-from').val();
    const date_to = $('#date-to').val();

    // Fetch filtered data via AJAX
    $.ajax({
        url: "{{ route('repairs.index') }}",
        type: "GET",
        data: {
            status: filter,
            date_from: date_from,
            date_to: date_to
        },
        success: function (response) {
            if (response.data && response.data.length > 0) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Extract data for the PDF
                const data = response.data.map((row, index) => [
                    index + 1,
                    row.service_no ,
                    row.date ,
                    row.customer_name ,
                    row.phone ,
                    row.complaint_remark 
                ]);

                // Add PDF Title
                doc.text("Repair Service Report", 14, 10);

                // Add Table to PDF
                doc.autoTable({
                    head: [['#', 'ACK No', 'Date', 'Customer Name', 'Phone', 'Complaint']],
                    body: data,
                    startY: 20,
                    styles: {
                        overflow: 'linebreak',
                        cellWidth: 'auto'
                    }
                });

                // Save PDF
                doc.save("service_report.pdf");
            } else {
                alert("No data available for the selected filters.");
            }
        },
        error: function () {
            alert("Failed to generate PDF. Please try again.");
        }
    });
});

            // Update status on change
            $(document).on('change', '.status-select', function() {
                const repairId = $(this).data('id');
                const status = $(this).val();
                $.ajax({
                    url: `/repairs/${repairId}/update_status`,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: function(response) {
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function(error) {
                        alert('Error updating status.');
                    }
                });
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
@endsection
