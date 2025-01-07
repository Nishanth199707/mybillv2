@include('front.header')
<br>
<br>
<div class="container text-center my-5 mt-10">
    <div class="card shadow-lg p-4">
        <h2 class="text-success mb-4">Payment Confirmation</h2>
        <p class="fs-5">Your payment was successful! Here are the details:</p>
        <div class="border rounded p-3 mb-4">
            <p class="mb-2"><strong>Provider Reference ID:</strong> {{ $providerReferenceId }}</p>
            <p class="mb-2"><strong>Transaction ID:</strong> {{ $transactionId }}</p>
        </div>
        <h3 class="mt-4">
            Continue to your dashboard
            <a href="{{ route('superadmin.home') }}" class="btn btn-primary ms-2">Go to Dashboard</a>
        </h3>
    </div>
</div>

@include('front.footer')