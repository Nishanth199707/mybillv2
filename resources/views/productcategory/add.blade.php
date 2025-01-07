@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add Product Category</h4> -->

              <!-- Basic Layout -->
              <div class="row">
                <div class="col-6">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                      <h5 class="mb-0">Product Category</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">

                      <form method="POST" action="{{ route('productcategory.store') }}" enctype="multipart/form-data">
                      @csrf
                     <!-- <div class="mb-3">
                          <label class="form-label">Image</label>
                          <input type="file" class="form-control" name="image" value="{{ old('image') }}" />
                          @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @enderror
                        </div>-->
                        <div class="mb-3">
                          <label class="form-label">Name</label>
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter the Product Category Name" />
                          @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @enderror
                        </div>




                        <div class="mb-3">
                          <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            @php
                            $businessstatus=['active' => "Active", 'inactive' => "Inactive"];
                            @endphp
                            @foreach ($businessstatus as $key => $val)
                                <option
                                 @if(old('status') == $val) selected @endif
                                 value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-3">
                          <label class="form-label">Description</label>
                          <textarea class="form-control" name="description" value="{{ old('description') }}" rows="4" cols="10" placeholder="Enter the description"></textarea>
                          @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div style="text-align: right;">
                           <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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
