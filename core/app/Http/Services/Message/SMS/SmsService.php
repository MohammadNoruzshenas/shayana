<?php

namespace App\Http\Services\Message\SMS;

use App\Http\Interfaces\MessageInterface;
use App\Http\Services\Message\SMS\MeliPayamakService;
use App\Models\Setting\SmsPanel;
use Illuminate\Support\Facades\Cache;

class SmsService implements MessageInterface
{

    private $text;
    private $to;
    private $isFlash = true;



    public function fire()
    {
        $smsPanel = SmsPanel::where('status',1)->first();
        if (is_null($smsPanel) || $smsPanel->username == null || $smsPanel->password == null || $smsPanel->number == null) {
            echo 'پنل اس ام اسی یافت نشد';
            exit;
         }

        switch ($smsPanel->name_en) {
            case 'Melipayamak':
                $meliPayamak = new MeliPayamakService();
                return $meliPayamak->sendSmsSoapClient($smsPanel->number, $this->to, $this->text, $this->isFlash);
                break;
            case 'Ippanel':
                $Ippanel = new Ippanel();
                return $Ippanel->send($this->to, $this->text);

            default:
                return false;
                break;
        }
    }


    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }


    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getIsFlash()
    {
        return $this->to;
    }

    public function setIsFlash($flash)
    {
        $this->isFlash = $flash;
    }
}
