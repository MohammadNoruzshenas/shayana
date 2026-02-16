<?php

namespace App\Http\Services\Message\SMS;

use App\Models\Setting\SmsPanel;
use Illuminate\Support\Facades\Config;


class Ippanel
{

    private $username;
    private $password;
    private $number;

    public function __construct()
    {

        $this->username = SmsPanel::where('status', 1)->first()->username;
        $this->password = SmsPanel::where('status', 1)->first()->password;
        $this->number = SmsPanel::where('status', 1)->first()->number;
    }

    public function send(array $to, $text)
    {

        $url = "https://ippanel.com/services.jspd";

        $rcpt_nm = $to;
        $param = array(
            'uname' => $this->username,
            'pass' => $this->password,
            'from' => $this->number,
            'message' => $text,
            'to' => json_encode($rcpt_nm),
            'op' => 'send'
        );

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($handler);
        $response2 = json_decode($response2);
        $res_code = $response2[0];
        $res_data = $response2[1];
        return true;
    }
}
