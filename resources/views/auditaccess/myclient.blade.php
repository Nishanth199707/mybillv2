@extends('layouts.v2.app')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Client List</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>
                                                <!-- Trigger Modal -->
                                                <button class="btn btn-primary btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#reportModal" 
                                                        data-client-id="{{ $client->id }}" 
                                                        data-client-name="{{ $client->name }}">
                                                    Download Reports
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Download Reports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="client-name" class="fw-bold"></p>

                <!-- Sales Report Form -->
                <form method="GET" id="salesReportForm">
                    <div class="mb-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Format</label>
                        <select name="format" class="form-control">
                            <option value="csv">CSV</option>
                            {{-- <option value="pdf">PDF</option> --}}
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Download Sales Report</button>
                </form>

                <!-- Purchase Report Form -->
                <form method="GET" id="purchaseReportForm">
                    <div class="mb-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-secondary w-100">Download Purchase Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const reportModal = document.getElementById('reportModal');
    reportModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const clientId = button.getAttribute('data-client-id');
        const clientName = button.getAttribute('data-client-name');

        document.getElementById('client-name').innerText = `Client: ${clientName}`;

        const salesReportForm = document.getElementById('salesReportForm');
        salesReportForm.action = `/audit-access/${clientId}/sale-report`;

        const purchaseReportForm = document.getElementById('purchaseReportForm');
        purchaseReportForm.action = `/audit-access/${clientId}/purchase-report`;
    });
</script>
@endsection
