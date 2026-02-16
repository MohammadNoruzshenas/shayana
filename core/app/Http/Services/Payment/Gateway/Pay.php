<?php

namespace App\Http\Services\Payment\Gateway;

use Illuminate\Support\Facades\Cache;

class Pay
{

    //start pay.ir
    public static function pay($amount, $object, $payment, $callbackRoute)
    {
        $callbackRoute = route($callbackRoute, [$object, $payment]);
        $params = [
            'api'          => Cache::get('gateway')->token,
            'amount'       => $amount,
            'redirect'     => $callbackRoute,
            'factorNumber' => $object->id,
            'description'  => 'خرید',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/pg/send');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($res);
        if ($result->status) {
            $go = "https://pay.ir/pg/$result->token";
            header("Location: $go");
            exit;
        } else {
            echo $result->errorMessage;
            exit;
        }
    }
    public static function payVerify($onlinePayment)
    {
        $api = 'test';
        $token = $_GET['token'];
        $params = [
            'api'  => $api,
            'token' => $token,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/pg/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($res);
        $onlinePayment->update([
            'bank_second_response' => $res,
            'transaction_id' => $result ? $result->transId : null,

            'gateway' => 'pay'
        ]);
        if (isset($result->status)) {
            if ($result->status == 1) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            if ($_GET['status'] == 0) {
                return ['success' => false];
            }
        }
    }

    //endpay
}
