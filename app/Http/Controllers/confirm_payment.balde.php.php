@include('front.header')

  
@section('content')

@php
print_r($providerReferenceId);
print_r($transactionId);
die;
@endphp

@endsection
  


@include('front.footer')
