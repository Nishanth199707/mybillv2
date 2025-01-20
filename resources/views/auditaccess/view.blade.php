@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Audit Access Requests</h5>
                        <a href="{{ route('audit-access.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Create New Request
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Auditor</th>
                                        <th>Client</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($auditAccesses as $index => $access)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $access->auditor->name }}</td>
                                        <td>{{ $access->targetUser->name }}</td>
                                        {{-- <td>
                                            <span class="badge bg-{{ $access->status === 'approved' ? 'success' : ($access->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($access->status) }}
                                            </span>
                                        </td> --}}
                                        <td>
                                            @if ($access->status === 'pending')
                                            <a href="{{ route('audit-access.change-status', ['auditAccess' => $access->id, 'status' => 'approved']) }}" class="btn btn-sm btn-success">
                                                Approve
                                            </a>
                                            <a href="{{ route('audit-access.change-status', ['auditAccess' => $access->id, 'status' => 'rejected']) }}" class="btn btn-sm btn-danger">
                                                Reject
                                            </a>
                                            @else
                                            <button class="btn btn-sm {{ $access->status === 'approved' ? 'btn-success' : 'btn-danger' }}" readonly>
                                                {{ ucfirst($access->status) }}
                                            </button>
                                            @endif
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
@endsection
