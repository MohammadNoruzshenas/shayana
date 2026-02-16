<?php

namespace App\Http\Services\Payment;

use App\Http\Services\Payment\Gateway\Aqayepardakht;
use App\Http\Services\Payment\Gateway\idPay;
use App\Http\Services\Payment\Gateway\Pay;
use App\Http\Services\Payment\Gateway\ZarinPal;
use App\Models\Setting\Gateway;
use Illuminate\Support\Facades\Cache;

class PaymentService
{

    public function payment($amount, $object, $payment, $callBackRoute)
    {
        $gateway = Gateway::where('status', 1)->first();

        if (is_null($gateway)) {
            echo 'درگاه بانکی انتخاب نشده است';
            exit;
        }
        switch ($gateway->name_en) {
            case 'Zarinpal':
                $result =  ZarinPal::zarinpal($amount, $object, $payment, $callBackRoute);
                break;
            case 'Pay':
                $result = Pay::pay($amount, $object, $payment, $callBackRoute);
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }
    public function verify($amount = null, $onlinePayment = null, $object = null)
    {
        $gateway = Gateway::where('status', 1)->first();
        switch ($gateway->name_en) {
            case 'Zarinpal':
                $result = ZarinPal::zarinpalVerify($amount, $onlinePayment);
                break;
            case 'Pay':
                $result = Pay::payVerify($onlinePayment);
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }
}
