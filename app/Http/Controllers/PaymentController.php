<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentModel;
use PayOS\PayOS;

class PaymentController extends Controller
{
    //
    public function handlePayOSWebhook(Request $request)
    {
        $body = json_decode($request->getContent(), true);
       
        // Handle webhook test
        if (in_array($body["data"]["description"], ["Ma giao dich thu nghiem", "VQRIO123"])) {
            return response()->json([
                "error" => 0,
                "message" => "Ok",
                "data" => $body["data"]
            ]);
        }

        // Check webhook data integrity 
        $PAYOS_CHECKSUM_KEY = env('PAYOS_CHECKSUM_KEY');
        $PAYOS_CLIENT_ID = env('PAYOS_CLIENT_ID');
        $PAYOS_API_KEY = env('PAYOS_API_KEY');
        $webhookData = $body["data"];
        $payOS = new PayOS($PAYOS_CLIENT_ID, $PAYOS_API_KEY, $PAYOS_CHECKSUM_KEY);
        $payOS->verifyPaymentWebhookData($webhookData);
 
        
       

        /**
         * Source code uses data of webhook
         * ....
         * ....
         */
        return response()->json([
            "error" => 0,
            "message" => "Ok",
            "data" => $webhookData
        ]);
    }
}
