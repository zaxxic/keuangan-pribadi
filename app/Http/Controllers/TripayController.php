<?php

namespace App\Http\Controllers;

use App\Models\SubscriberTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripayController extends Controller
{
    public function getPaymentChannels()
    {

        $apiKey = config('tripay.api_key');
        // dd($apiKey);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/merchant/payment-channel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response)->data;
        // dd($response);
        return $response ? $response : $error;
    }

    function requestTransaction($method, $package)
    {

        $apiKey = config('tripay.api_key');
        $privateKey   = config('tripay.privite_key');
        $merchantCode = config('tripay.merchent_kcode');
        // dd($apiKey, $privateKey, $merchantCode);
        $merchantRef  = 'PX-' . time();

        $user = Auth()->user();
        $transaction = new SubscriberTransaction();

        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $package->amount,
            'customer_name'  => $user->name,
            'customer_email' => $user->email,
            //  'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'name'        => $package->title,
                    'price'       => $package->amount,
                    'quantity'    => 1,

                ],

            ],
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $package->amount, $privateKey)
        ];
        // dd(json_decode($package));




        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        // dd($response);
        $response = json_decode($response)->data;
        $transaction->amount = $response->amount;
        $transaction->status = $response->status;
        $transaction->merchant_ref = $response->merchant_ref;
        $transaction->reference = $response->reference;
        $transaction->user_id = $user->id;
        $transaction->package_id = $package->id;
        $transaction->save();

        // dd($response);
        return $response ? $response : $error;
    }

    function detail($reference)
    {

        $apiKey = config('tripay.api_key');

        $payload = ['reference'    => $reference];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        $response = json_decode($response)->data;
        // dd($response);

        curl_close($curl);

        return $response ? $response : $error;
    }
}
