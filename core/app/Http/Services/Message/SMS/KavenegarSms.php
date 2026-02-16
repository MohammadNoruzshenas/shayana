<?php

namespace App\Http\Services\Message\SMS;

use Illuminate\Support\Facades\Config;

use Kavenegar;

class KavenegarSms
{

    public function send()
    {
        $sender = "90005961";
        $receptor = "09377362289";
        $message = "سلام از لوکال";
        $api = new \Kavenegar\KavenegarApi("736475456353483531786C33324135736373783255444171476F555A62486C365054736242492B724C74773D");
        $api->Send($sender,$receptor,$message);
    }

    public function sendSms()
    {
        $result =  Kavenegar::Send("0018018949161",["09377362289"],[ "سلام از لوکال"]);
        $response = json_encode($result);
       return $response;
    }

}
