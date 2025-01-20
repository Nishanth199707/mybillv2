@extends('layouts.v2.app')

@section('content')
    <div class="container">
        <h1>Edit Audit Access Request</h1>
        <form action="{{ route('audit-access.update', $auditAccess->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="auditor_id">Select Auditor</label>
                <select name="auditor_id" id="auditor_id" class="form-control">
                    @foreach ($auditors as $auditor)
                        <option value="{{ $auditor->id }}" {{ $auditAccess->auditor_id == $auditor->id ? 'selected' : '' }}>
                            {{ $auditor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="target_user_id">Select Target User</label>
                <select name="target_user_id" id="target_user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $auditAccess->target_user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="reason">Reason</label>
                <textarea name="reason" id="reason" class="form-control">{{ $auditAccess->reason }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
