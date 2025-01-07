@extends('layouts.v2.app')
@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> GST Report</h4> --}}

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">GST Report</h5>
                        <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">
                        <div style="margin: 20px 0px;">
                            <strong>Date Filter:</strong>
                            <input type="text" name="daterange" value="" />
                            <button class="btn btn-primary btn-sm filter">Filter</button>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a class="btn btn-primary btn-sm mb-3" href="{{ route('gst.export') }}"><i class="fa fa-arrow-left"></i> Export</a>
                        </div>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Party</th>
                                    <th>Invoice Date</th>
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




    <!-- / Content -->

 

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<script type="text/javascript">
    $(function() {

        $('input[name="daterange"]').daterangepicker({
            startDate: moment().subtract(1, 'M'),
            endDate: moment()
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('gstreport.index') }}",
                data: function(d) {
                    alert(d.from_date);
                    d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [{
                    data: 'id',
                    name: 'ID'
                },
                {
                    data: 'party',
                    name: 'Party'
                },
                {
                    data: 'invoice_date',
                    name: 'Invoice Date'
                },
                {
                    data: 'invoice_no',
                    name: 'Invoice No'
                },
                {
                    data: 'net_amount',
                    name: 'Net Amount'
                },
            ]
        });

        $(".filter").click(function() {
            table.draw();
        });

    });
</script>

@endsection
