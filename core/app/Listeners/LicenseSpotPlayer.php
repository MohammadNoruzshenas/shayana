<?php

namespace App\Listeners;

use App\Models\Market\OrderItem;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class LicenseSpotPlayer
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (!$event->course->spot_api_key) {
            //ای پی ای پیش فرض
            $event->course->spot_api_key =  Cache::get('settings')->spot_api_key;
        }

        $url = 'https://panel.spotplayer.ir/license/edit/';
        $api = $event->course->spot_api_key;
        $spot_course_license = $event->course->spot_course_license;
        $headers = array('$API: ' . $api, '$LEVEL: -1', 'content-type: application/json');
        $data = array(
            "test" => false,
            "course" => array($spot_course_license),
            "name" => $event->user->FullName ?? $event->user->email,
            "watermark" => array("texts" => array(array("text" => $event->user->mobile ?? $event->user->email)))
        );
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            $headers
        );
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        $newItem =  OrderItem::where('id', $event->newItem)->first();
        if (isset($data['key'])) {
            $newItem->update(['license' => $data['key']]);
        } else {
            $newItem->update(['license' => $data['ex']['msg']]);
        }
    }
}
