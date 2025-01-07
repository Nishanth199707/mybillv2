<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;


class PaymentController extends Controller
{
  //

  public function index(Request $request)
  {

    // dd($request->session()->get('previous_data'));

    $user = Auth::user();
    // dd($request->session()->all());

    $plan_previous = $request->session()->get('previous_data');
    $plan_id =  $plan_previous['plan_id'];
    // dd($plan_sssid);

    $plan = Plan::find($plan_id);

    // dd($request,$plan , $plan_id,$user);
    return view('front.payment-form', compact('plan', 'user'));
  }

  // Check login and redirect appropriately
  public function checkLogin(Request $request)
  {
    // Validate the incoming request
    $request->validate([
      'plan_id' => 'required|integer',
      'amount' => 'required|numeric',
    ]);


    if (!Auth::check()) {
      // Save the intended URL (payment page) and session data
      $sessionData = [
        'plan_id' => $request->plan_id,
        'amount' => $request->amount,
        'redirect_after_register' => route('front.payment'),
      ];
      $request->session()->put('previous_data', $sessionData);
      return redirect()->route('front_purchase_register');
    } else {
      // If logged in, proceed to payment page with request data
      // return redirect()->route('front.pay-now', [$request]);
      return app(PaymentController::class)->submitPaymentForm($request);
    }
  }


  public function showRegisterForm(Request $request)
  {
    // dd($request);
    return view('front.register', compact('request')); // Make sure you have a view file for this
  }


  public function submitPaymentForm(Request $request)
  {
    // dd($request);
    if ($request->plan_id == 4) {

      $transactionId = 'TXN' . uniqid();

      $data = [
        'plan_id' => $request->plan_id,
        'user_id' => $request->user_id,
        'amount' => $request->amount,
        'transaction_id' => $transactionId,
        'payment_status' => 'Completed',
        'response_msg' => 'Trail User',
        'providerReferenceId' => '',
        'merchantOrderId' => '',
        'checksum' => ''
      ];

      Payment::create($data);

      $providerReferenceId = '';

      return view('front.confirm_payment', compact('providerReferenceId', 'transactionId'));
    }

    $request->validate([
      'amount' => 'required'
    ], [
      'amount' => 'Amount is Required'
    ]);

    $plan_id = $request->input('plan_id');
    $user_id = $request->input('user_id');
    $amount = $request->input('amount');
    if ($amount != '') {

      $merchantId = 'M22KMQGKT7PXJ';

      $apiKey = '784015fb-4382-4a23-b6ba-e055e9fe123f';

      $redirectUrl = route('front.confirm');
      $order_id = uniqid();


      $transaction_data = array(
        'merchantId' => "$merchantId",
        'merchantTransactionId' => "$order_id",
        "merchantUserId" => $order_id,
        'amount' => $amount * 100,
        'redirectUrl' => "$redirectUrl",
        'redirectMode' => "POST",
        'callbackUrl' => "$redirectUrl",
        "paymentInstrument" => array(
          "type" => "PAY_PAGE",
        )
      );


      $encode = json_encode($transaction_data);
      $payloadMain = base64_encode($encode);
      $salt_index = 1; //key index 1
      $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
      $sha256 = hash("sha256", $payload);
      $final_x_header = $sha256 . '###' . $salt_index;
      $request = json_encode(array('request' => $payloadMain));

      $curl = curl_init();

      curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => [
          "Content-Type: application/json",
          "X-VERIFY: " . $final_x_header,
          "accept: application/json"
        ],
      ]);

      $response = curl_exec($curl);
      // dd($response);

      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $res = json_decode($response);

        // Store information into database

        $data = [
          'plan_id' => $plan_id,
          'user_id' => $user_id,
          'amount' => $amount,
          'transaction_id' => $order_id,
          'payment_status' => 'PAYMENT_PENDING',
          'response_msg' => $response,
          'providerReferenceId' => '',
          'merchantOrderId' => '',
          'checksum' => ''
        ];

        Payment::create($data);

        // end database insert

        if (isset($res->code) && ($res->code == 'PAYMENT_INITIATED')) {

          $payUrl = $res->data->instrumentResponse->redirectInfo->url;

          return redirect()->away($payUrl);
        } else {
          //HANDLE YOUR ERROR MESSAGE HERE
          dd('ERROR : ' . $res);
        }
      }
    }
  }


  public function confirmPayment(Request $request)
  {
    // dd($request);
    if ($request->code == 'PAYMENT_SUCCESS') {
      $transactionId = $request->transactionId;
      $merchantId = $request->merchantId;
      $providerReferenceId = $request->providerReferenceId;
      $merchantOrderId = $request->merchantOrderId;
      $checksum = $request->checksum;
      $status = $request->code;

      //Transaction completed, You can add transaction details into database


      $data = [
        'providerReferenceId' => $providerReferenceId,
        'checksum' => $checksum,
        'payment_status' => $status,

      ];
      if ($merchantOrderId != '') {
        $data['merchantOrderId'] = $merchantOrderId;
      }

      Payment::where('transaction_id', $transactionId)->update($data);

      return view('front.confirm_payment', compact('providerReferenceId', 'transactionId'));
    } else {

      //HANDLE YOUR ERROR MESSAGE HERE
      dd('ERROR : ' . $request->code . ', Please Try Again Later.');
    }
  }
}
