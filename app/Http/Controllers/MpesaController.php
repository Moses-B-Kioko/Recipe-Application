<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MpesaController extends Controller
{
    public function stkPush(Request $request)
    {
        $mobile = $request->input('mobile');
        $amount = $request->input('amount');

        // Get M-Pesa access token
        $accessTokenResponse = Http::withBasicAuth(
            env('DazGAAljSIQIVV1FePeRry1oBdjiEAAao6TAYZHjZhAKUdso'), 
            env('1xoYZkggRDkREZWnCuhMIErisSDVwIBudY6c0qE1DzgfEB8jq5kFhXBxAPeR5yAA')
        )->post('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        if (!$accessTokenResponse->successful()) {
            return response()->json(['success' => false, 'message' => 'Failed to get access token.'], 500);
        }

        $accessToken = $accessTokenResponse['access_token'];

        // STK Push
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(
            env('174379') . env('MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjQxMTIyMTgzMzIy') . $timestamp
        );

        $stkPushResponse = Http::withToken($accessToken)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                "BusinessShortCode" => env('174379'),
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $mobile,
                "PartyB" => env('174379'),
                "PhoneNumber" => $mobile,
                "CallBackURL" => route('checkout.mpesa.callback'),
                "AccountReference" => "TheBookery",
                "TransactionDesc" => "Payment for Order",
            ]);

        if ($stkPushResponse->successful()) {
            return response()->json(['success' => true, 'message' => 'STK Push sent to your phone.']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to initiate STK Push.'], 500);
    }

    public function callback(Request $request)
    {
        // Handle the callback data from Safaricom here
        $callbackData = $request->all();

        // Implement logic to update the order/payment status based on the callback
        \Log::info($callbackData);

        return response()->json(['success' => true]);
    }
}
