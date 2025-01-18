<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Business;

class ApiController extends Controller
{
    public function search(Request $request,$gstin)
    {
        $client_id = env('MASTERGST_CLIENT_ID');
        $client_secret = env('MASTERGST_CLIENT_SECRET');
        $email = env('MASTERGST_MAILID');
        $gsturl = env('GST_BASE_URL');

        if ($gstin) {
            try {
                // Make the API call with SSL verification disabled
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                ])->withoutVerifying()->get($gsturl.'/public/search', [
                    'email' => $email,
                    'gstin' => $gstin, // Use the GSTIN from the request
                ]);

                // Check for a successful response
                if ($response->successful()) {
                    echo json_encode($response->json());
                    die;
                }

                // Handle non-successful response
                return response()->json(['error' => 'Unable to fetch data', 'details' => $response->body()], $response->status());

            } catch (\Exception $e) {
                // Handle exceptions
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }
        } else {
            // Handle case when GSTIN is not provided
            return response()->json(['error' => 'GSTIN is required'], 400);
        }
    }

    public function gstAuth(Request $request)
    {
        $gst_id = $request->gst_id;
        $e_password = $request->e_password;
        $business_id = $request->business_id;
        $client_id = env('MASTERGST_CLIENT_ID');
        $client_secret = env('MASTERGST_CLIENT_SECRET');
        $email = env('MASTERGST_MAILID');
        $gsturl = env('GST_BASE_URL');
        // $ipAddress = $request->ip();
        $ipAddress = $_SERVER['SERVER_ADDR'] ?? getHostByName(getHostName());
        try {
            // Make the API call with SSL verification disabled
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'ip_address' => $ipAddress,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'gstin' => $gst_id,
            ])->withoutVerifying()->get($gsturl.'/ewaybillapi/v1.03/authenticate', [
                'email' => $email,
                'username' => $gst_id,
                'password' => $e_password,
            ]);

            // Check for a successful response
            if ($response->successful()) {
                $data = $response->json();
                $data['date'] = date('d-m-Y');
                $Business = Business::find($business_id);
                if ($Business) {
                    $Business->update([
                        'gst_auth' => $data['status_cd'],
                        'auth_response' =>json_encode($data),
                    ]);

                    echo json_encode($response->json());
                    die;
                } else {
                    return response()->json(['error' => 'Business not found'], 404);
                }
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


}
