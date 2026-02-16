<?php

namespace App\Http\Services\Message\SMS;

use Illuminate\Support\Facades\Config;


class Kavenegar
{

    public function send()
    {
        $sender = "1000xxxxx";
        $receptor = "0919xxxxxxx";
        $message = "Hello PHP!";
        $api = new \Kavenegar\KavenegarApi("Your API Key");
        $api->Send($sender,$receptor,$message);
    }

}
