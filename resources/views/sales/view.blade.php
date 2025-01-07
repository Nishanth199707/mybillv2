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
                        <h5 class="mb-0">View Sale</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">

                            <div class="col-4">
                                <a class="btn btn-primary btn-sm mb-3" href="{{ route('sale.create') }}">
                                   <i class="fa fa-arrow-left"></i> Add New Sale
                                </a>
                            </div>

                            <div class="col-4 filter-center">
                                  <span id="searchLabel" style="font-size:15px;font-weight:bold;">&nbsp;&nbsp;Name&nbsp;/&nbsp;IMEI&nbsp;/&nbsp;Phone No&nbsp;:</span>
                                  <input type="text" required class="form-control" id="customSearch" placeholder="Search" style="transition: width 0.3s ease;">
                            </div>
                                <div class="col-4"></div>
                            </div>
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="max-width: 100px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">Party</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
                                        <th style="max-width: 150px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">Item</th>
                                        <th>Phone</th>
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
        // $('#customSearch').css('width', '150px'); 
        // $('#searchLabel').css('width', 'auto');  

        // $('#customSearch').on('input', function () {
        //     var inputLength = $(this).val().length; 
        //     var minWidth = 150; 
        //     var maxWidth = 400; 

 
        //     var newWidth = Math.min(Math.max(minWidth + inputLength * 10, minWidth), maxWidth);
            
        //     $(this).css('width', newWidth + 'px');

         
        //     $('#searchLabel').css('width', newWidth + 'px'); 
        // });
        
        // Initialize DataTable if it hasn't been initialized already
        var table = $('#zero-config').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('sale.index') }}",
        error: function(xhr, error, code) {
            console.error('Error fetching data:', error);
            alert('Failed to load data.');
        }
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
            name: 'party',
            createdCell: function (td, cellData, rowData, row, col) {
                $(td).css({
                    'max-width': '100px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word',
                    'overflow-wrap': 'break-word'
                });
            }
        },
        { data: 'invoice_date', name: 'invoice_date' },
        { data: 'invoice_no', name: 'invoice_no' },
        {
            data: 'item_description',
            name: 'item_description',
            createdCell: function (td, cellData, rowData, row, col) {
                $(td).css({
                    'max-width': '150px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word',
                    'overflow-wrap': 'break-word'
                });
            }
        },
        { data: 'phone_no', name: 'phone_no' },
        { data: 'net_amount', name: 'net_amount' },
        {
            data: 'action',
            title: 'Action',
            orderable: false,
            searchable: false
        }
    ],
    dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l>>>" + // Remove search field
         "<'table-responsive'tr>" +
         "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
    oLanguage: {
        oPaginate: {
            sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
            sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
        },
        sInfo: "Showing page _PAGE_ of _PAGES_",
        sLengthMenu: "Results : _MENU_",
    },
    lengthMenu: [7, 10, 20, 50],
    pageLength: 10
});

        // Attach event listener to the custom search input
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw(); // Trigger DataTable search
        });
    });
</script>
@endsection
