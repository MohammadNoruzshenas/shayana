<?php

namespace App\Http\Services\Payment\Gateway;

use Illuminate\Support\Facades\Cache;

class ZarinPal
{

    public static function zarinpal($amount, $object, $payment, $callbackRoute)
    {
        $CallbackURL = route($callbackRoute, [$object, $payment]);
        $data = array(

            "merchant_id" => Cache::get('gateway')->token,
            "amount" => $amount,
            "callback_url" => "$CallbackURL",
            "description" => "خرید",
        );
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    header('Location: https://www.zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
                    exit;
                }
            } else {
                echo 'خطا در برقراری ';
                exit;
            }
        }
    }

    public static function zarinpalVerify($amount, $onlinePayment)
    {
        $Authority = $_GET['Authority'];
        $data = array("merchant_id" =>  Cache::get('gateway')->token, "authority" => $Authority, "amount" => $amount);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $onlinePayment->update([
            'bank_second_response' => $result,
            'transaction_id' => $result['data'] ? $result['data']['ref_id'] : null,
            'gateway' => 'ZarinPal'
        ]);


        if (isset($result['data']['code']) && $result['data']['code'] == 100) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }
}
