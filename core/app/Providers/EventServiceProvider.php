<?php

namespace App\Providers;

use App\Events\BuyCourse;
use App\Events\NewLession;
use App\Events\NewLicenseSpotPlayer;
use App\Events\PaymentSettlements;
use App\Events\RegisterAccount;
use App\Listeners\BuyCourseSendMessage;
use App\Listeners\LicenseSpotPlayer;
use App\Listeners\NewLessionSendMessage;
use App\Listeners\PaymentSettlementsSendMessage;
use App\Listeners\RegisterAccountSendMessage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        BuyCourse::class => [
            BuyCourseSendMessage::class,
        ],
        NewLession::class => [
            NewLessionSendMessage::class,
        ],
        PaymentSettlements::class => [
            PaymentSettlementsSendMessage::class,
        ],
        RegisterAccount::class => [
            RegisterAccountSendMessage::class,
        ],
        NewLicenseSpotPlayer::class => [
            LicenseSpotPlayer::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
