@extends('layouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Edit User</h4>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Sub-User</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('subuser.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $user->name) }}" required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $user->email) }}" required />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                  <label class="form-label">Permissions</label>
                              
                                  <div class="form-check">
                                      <input type="checkbox" name="permissions[service]" id="service" value="true"
                                          class="form-check-input"
                                          {{ isset($permissions['service']) && $permissions['service'] === 'true' ? 'checked' : '' }}>
                                      <label for="service" class="form-check-label">Service</label>
                                  </div>
                              
                                  <div class="form-check">
                                      <input type="checkbox" name="permissions[cash_bank]" id="cash_bank" value="true"
                                          class="form-check-input"
                                          {{ isset($permissions['cash_bank']) && $permissions['cash_bank'] === 'true' ? 'checked' : '' }}>
                                      <label for="cash_bank" class="form-check-label">Cash & Bank</label>
                                  </div>
                              
                                  <div class="form-check">
                                      <input type="checkbox" name="permissions[payment]" id="payment" value="true"
                                          class="form-check-input"
                                          {{ isset($permissions['payment']) && $permissions['payment'] === 'true' ? 'checked' : '' }}>
                                      <label for="payment" class="form-check-label">Payments</label>
                                  </div>
                              
                                  <div class="form-check">
                                      <input type="checkbox" name="permissions[report]" id="report" value="true"
                                          class="form-check-input"
                                          {{ isset($permissions['report']) && $permissions['report'] === 'true' ? 'checked' : '' }}>
                                      <label for="report" class="form-check-label">Reports</label>
                                  </div>
                              
                                  @if ($errors->has('permissions'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('permissions') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              


                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('subuser.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
