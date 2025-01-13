@extends('layouts.v2.app')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Edit User</h5>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" 
                                       value="{{ old('name', $user->name) }}" placeholder="John Doe" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $user->email) }}" autocomplete="off" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password <small>(leave blank if not changing)</small></label>
                                <input type="password" class="form-control" name="password" autocomplete="off" />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- User Type -->
                            <div class="mb-3">
                                <label class="form-label">User Type</label>
                                <select name="usertype" class="form-select">
                                    <option value="">Select User Type</option>
                                    @php
                                        $typeuser = ["superadmin", "user", "manager", "staff", "admin"];
                                    @endphp
                                    @foreach ($typeuser as $type)
                                        <option value="{{ $type }}" 
                                            {{ old('usertype', $user->usertype) === $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('usertype')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Parent User -->
                            @if (isset($parentUsers) && count($parentUsers) > 0)
                                <div class="mb-3">
                                    <label class="form-label">Parent User (Optional)</label>
                                    <select name="parent_user_id" class="form-select">
                                        <option value="">None</option>
                                        @foreach ($parentUsers as $parent)
                                            <option value="{{ $parent->id }}" 
                                                {{ old('parent_user_id', $user->parent_user_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }} ({{ $parent->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <!-- Permissions -->
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                @php
                                    $permissions = json_decode($user->permissions, true) ?? [];
                                @endphp
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[view_orders]" class="form-check-input" 
                                           {{ isset($permissions['view_orders']) && $permissions['view_orders'] ? 'checked' : '' }}>
                                    <label class="form-check-label">View Orders</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[edit_orders]" class="form-check-input" 
                                           {{ isset($permissions['edit_orders']) && $permissions['edit_orders'] ? 'checked' : '' }}>
                                    <label class="form-check-label">Edit Orders</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[manage_users]" class="form-check-input" 
                                           {{ isset($permissions['manage_users']) && $permissions['manage_users'] ? 'checked' : '' }}>
                                    <label class="form-check-label">Manage Users</label>
                                </div>
                                @error('permissions')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
@endsection
