<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Content\Post;
use App\Models\Market\Course;
use App\Models\Market\Lession;
use App\Models\Setting\FooterLink;
use App\Models\Setting\Gateway;
use App\Models\Setting\SecureRecord;
use App\Models\Setting\Setting;
use App\Models\Setting\TemplateSetting;
use App\Models\User;
class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
               // $smsPanel = Cache::rememberForever('smsPanel', function () {
        //     return SmsPanel::where('status',1)->first();
        // });
        //start Cache
        Cache::rememberForever('settings', function () {
            return Setting::first();
        });
        Cache::rememberForever('templateSetting', function () {
            return TemplateSetting::first();
        });
        Cache::rememberForever('secureRecord', function () {
            return SecureRecord::first();
        });
        $gateway = Cache::rememberForever('gateway', function () {
            return Gateway::where('status',1)->first();
        });
        $footer_links = Cache::rememberForever('footerLinks', function () {
            return FooterLink::where('position', 1)->get();
        });
        $footer_links2 = Cache::rememberForever('footerLinks2', function () {
            return FooterLink::where('position', 2)->get();
        });
        //EndCache
    }
}
