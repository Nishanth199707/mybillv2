@include('front.header')
{{-- @php
echo '
<pre>';
    print_r($plan);
@endphp --}}

<section class="pt-130 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('sadamin.saregisterpost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row  mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">GSTIN</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gstavailable" id="inlineRadio1" value="yes">
                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gstavailable" id="inlineRadio2" value="no" checked>
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                            @if ($errors->has('gstavailable'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('gstavailable') }}</strong>
                                </span>
                            @endif

                            <div id="gstin-container" style="display: none;">
                                <!-- <label class="form-label">GSTIN</label> -->
                                <input type="text" class="form-control" name="gstin" id="gstin" value="{{ old('gstin') }}" placeholder="Enter the Company GSTIN" />
                                <input type="hidden" class="form-control" name="gstin_status" id="gstin_status" value=""  />
                                <input type="hidden" class="form-control" name="gstin_reponse" id="gstin_reponse" value=""  />
                                @if ($errors->has('gstin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gstin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control checkgst" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Enter the Company Name" />
                            @if ($errors->has('company_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    {{-- </div>






                    <div class="row mb-3"> --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone_no') is-invalid @enderror"
                                name="phone_no" placeholder="Enter the Phone No" value="{{ old('phone_no') }}" />
                            @error('phone_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    {{-- </div>
                    <div class="row mb-3"> --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control checkgst" id="address" name="address" rows="2" placeholder="Enter the Address">{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                    {{-- </div>
                    <div class="row mb-3"> --}}

                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                class="form-control checkgst" />
                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" id="pincode" name="pincode" value="{{ old('pincode') }}"
                                class="form-control checkgst" />
                            @if ($errors->has('pincode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pincode') }}</strong>
                                </span>
                            @endif
                        </div>
                    {{-- </div> --}}



                    <!-- <div class="row mb-3">

                        </div> -->

                    {{-- <div class="row mb-3"> --}}


                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <select name="state" id="state" class="form-select checkgst">
                                <option value="" selected>Select State</option>
                                <option value="Andhra Pradesh" {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                <option value="Arunachal Pradesh" {{ old('state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                <option value="Assam" {{ old('state') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                <option value="Bihar" {{ old('state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                <option value="Chhattisgarh" {{ old('state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                <option value="Goa" {{ old('state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                <option value="Haryana" {{ old('state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                <option value="Himachal Pradesh" {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                <option value="Jharkhand" {{ old('state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                <option value="Madhya Pradesh" {{ old('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                <option value="Manipur" {{ old('state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                <option value="Meghalaya" {{ old('state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                <option value="Mizoram" {{ old('state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                <option value="Nagaland" {{ old('state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                <option value="Odisha" {{ old('state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option value="Rajasthan" {{ old('state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                <option value="Sikkim" {{ old('state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                <option value="Tamil Nadu" {{ old('state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                <option value="Tripura" {{ old('state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                <option value="Uttar Pradesh" {{ old('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                <option value="Andaman and Nicobar Islands" {{ old('state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                <option value="Chandigarh" {{ old('state') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                <option value="Lakshadweep" {{ old('state') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                <option value="Puducherry" {{ old('state') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                            </select>
                            @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" id="country" name="country" readonly value="India"
                                class="form-control checkgst" />
                            @if ($errors->has('country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="business_category">Business Category</label>
                            @php
                                $businesstypecat = [
                                    'Accounting & CA',
                                    'Interior Designer',
                                    'Automobiles/ Auto parts',
                                    'Salon & Spa',
                                    'Book / Stationary Store',
                                    'Construction Materials & Equipment',
                                    'Repairing/ Plumbing/ Electrician',
                                    'Chemicals & Fertilizers',
                                    'Computer Equipments & Softwares',
                                    'Electrical & Electronics Equipments',
                                    'Fashion Accessory/ Cosmetics',
                                    'Tailoring/ Boutique',
                                    'Fruit And Vegetable',
                                    'General Merchant',
                                    'Pharmacy/ Medical',
                                    'Hardware Store',
                                    'Industrial Machinery & Equipment',
                                    'Mobile & Accessories',
                                    'Nursery/ Plants',
                                    'Petroleum Bulk Stations & Terminals/ Petrol',
                                    'Restaurant/ Hotel',
                                    'Footwear',
                                    'Paper & Paper Products',
                                    'FMCG Products',
                                    'Dairy Farm Products/ Poultry',
                                    'Furniture',
                                    'Garment/Fashion & Hosiery',
                                    'Jewellery & Gems',
                                    'Sweet Shop/ Bakery/ Gifts & Toys',
                                    'Laundry/Washing/ Dry clean',
                                    'Coaching & Training',
                                    'Renting & Leasing',
                                    'Fitness Center',
                                    'Tours & Travels',
                                ];
                            @endphp
                            <select name="business_category" id="business_category" class="form-select">
                                <option value="">Select Business Category</option>
                                @foreach ($businesstypecat as $val)
                                    <option value="{{ $val }}"
                                        @if (old('business_category') == $val) selected @endif>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('business_category'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('business_category') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Business Type</label>
                            <select name="business_type" id="business_type" class="form-select">
                                @php
                                    $businesstypeuser = ['Retailer', 'Wholesaler', 'Distributer'];
                                @endphp
                                <option value="">Select Business Type</option>
                                @foreach ($businesstypeuser as $val)
                                    <option @if (old('business_type') == $val) selected @endif
                                        value="{{ $val }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('business_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('business_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" class="form-control" name="logo"
                                value="{{ old('logo') }}" />
                            @if ($errors->has('logo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end mb-3">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>


            </div>

        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleGSTINField() {
        const gstinContainer = document.getElementById('gstin-container');
        const gstAvailableYes = document.getElementById('inlineRadio1');

        if (gstAvailableYes.checked) {
            gstinContainer.style.display = 'block';
            // $('.checkgst').addClass('readonly');
        } else {
            gstinContainer.style.display = 'none';
            // $('.checkgst').removeClass('readonly');
        }
    }

    document.getElementById('inlineRadio1').addEventListener('change', toggleGSTINField);
    document.getElementById('inlineRadio2').addEventListener('change', toggleGSTINField);

    toggleGSTINField();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set up the CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#gstin").on('input', function () {
            var gstin = $(this).val();
            if (gstin.length == 15) {
                $.ajax({
                    url: '{{ url('search') }}/' + gstin,
                    type: 'GET',
                    success: function (data) {
                        var response = JSON.parse(data);
                        console.log(response.data);
                        if (response.data) {
                            $('#company_name').val(response.data.lgnm);
                            $('#address').val(
                                response.data.pradr.addr.bnm + ', ' +
                                response.data.pradr.addr.st + ', ' +
                                response.data.pradr.addr.loc + ', ' +
                                response.data.pradr.addr.dst + ', ' +
                                response.data.pradr.addr.bno
                            );
                            $('#city').val(response.data.pradr.addr.dst);
                            $('#pincode').val(response.data.pradr.addr.pncd);
                            $('#state').val(response.data.pradr.addr.stcd);
                            $('#country').val('India');
                            $('#gstin_status').val(response.status_cd);
                            $('#gstin_reponse').val(data);
                        } else {
                            console.error("Unexpected response structure: ", response);
                        }
                    },
                    error: function (xhr) {
                        // Handle the error
                    }
                });
            }
        });
    });
</script>

{{-- @section('content') --}}






@include('front.footer')
