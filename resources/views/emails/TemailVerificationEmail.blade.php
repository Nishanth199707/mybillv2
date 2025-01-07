<h1>Email Verification Mail</h1>

  

Please verify your email with bellow link: 

<a href="{{ route('front.user.verify', ['token' => $token, 'p_register_verify' => $p_register_verify]) }}" class="verification-link">Verify Email</a>