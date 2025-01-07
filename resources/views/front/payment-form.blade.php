@include('front.header')
<section id="" class=" pt-110 pb-110">

    @if (session('success'))
        <div class="alert alert-success">
            <ul class="mb-0">
                {{ session('success') }}
            </ul>
        </div>
    @endif
    @if ($plan->id != '4')
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col col-lg-4"
                    style="padding: 20px;border-radius:5px; background:linear-gradient(to right,#ff746e, #ff9e6f)">
                    <div class="award-card-sm">
                        <div class="d-flex justify-content-between flex-column flex-sm-row">
                            <h3 style="color:#fff;">{{ $plan->name }}<br>(Validity {{ $plan->yearly }} Year)</h3>
                            <div class="d-flex">
                                <h3 style="color:#fff;">₹ <s>{{ $plan->sale_price }}</s> ₹ {{ $plan->offer_price }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-auto">
                </div>
                <div class="col col-lg-4"
                    style="padding: 20px;border-radius:5px; background:linear-gradient(to left,#ff746e, #ff9e6f)">
                    <div class="award-card-sm">
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-3">
                            <span style="color:#fff;">Offer Price</span>
                            <div class="d-flex">
                                <span style="color:#fff;">₹ {{ $plan->offer_price }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-3">
                            <span style="color:#fff;">Discount Price</span>
                            <div class="d-flex">
                                <span style="color:#fff;">₹ {{ $plan->sale_price - $plan->offer_price}}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-3">
                            <span style="color:#fff;">Total AMount</span>
                            <div class="d-flex">
                                <span style="color:#fff;">₹ {{ $plan->offer_price }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-column ">
                            <form action="{{ route('check-login') }}" method="post">
                                {{-- <form action="{{ route('front.pay-now') }}" method="post"> --}}
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                @if ($user !== null)
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                @endif
                                <input type="hidden" name="amount" value="{{ $plan->sale_price }}">
                                <button type="submit" class="btn btn-primary" style="float: right">Pay Now</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                </div>
                <div class="col col-lg-4"
                    style="padding: 20px;border-radius:5px; background:linear-gradient(to right,#ff746e, #ff9e6f)">
                    <div class="award-card-sm">
                        <div class="d-flex justify-content-between flex-column flex-sm-row">
                            <h3 style="color:#fff;">{{ $plan->name }}<br>(Validity 30 Days)</h3>
                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-column">
                        <form action="{{ route('check-login') }}" method="post">
                            {{-- <form action="{{ route('front.pay-now') }}" method="post"> --}}
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            @if ($user !== null)
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                            @endif
                            <input type="hidden" name="amount" value="{{ $plan->sale_price }}">
                            <button type="submit" class="btn btn-primary" style="float: right">Subscribe Now</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-auto">
                </div>
              
            </div>
        </div>
        @endif
</section>
@include('front.footer')
