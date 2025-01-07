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
                        <h5 class="mb-0">View Purchase</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary btn-sm mb-3" href="{{ route('purchase.create') }}">
                                <i class="fa fa-arrow-left"></i> Add New Purchase
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Party</th>
                                        <th>Purchase Date</th>
                                        <th>Purchase No</th>
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



    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        // Destroy existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#zero-config')) {
            $('#zero-config').DataTable().destroy();
        }

        // Initialize DataTable
        var table = $('#zero-config').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('purchase.index') }}"
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1;
                    },
                    title: '#'
                },
                {
                    data: 'party',
                    title: 'Party'
                },
                {
                    data: 'purchase_date',
                    title: 'Purchase Date'
                },
                {
                    data: 'purchase_no',
                    title: 'Purchase No'
                },
                {
                    data: 'net_amount',
                    title: 'Net Amount'
                },
                {
                    data: 'action',
                    title: 'Action',
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
    });
</script>
@endsection
