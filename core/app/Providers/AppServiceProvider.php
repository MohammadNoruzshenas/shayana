<?php

namespace App\Providers;

use App\Models\Content\Menu;
use App\Models\Market\Course;
use App\Models\Market\Settlement;
use App\Models\Ticket\Ticket;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->usePublicPath(realpath(base_path().'/../public_html'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom validation rule for week start date
        Validator::extend('week_start', function ($attribute, $value, $parameters, $validator) {
            return isWeekStartDate($value);
        });

        // Custom validation message
        Validator::replacer('week_start', function ($message, $attribute, $rule, $parameters) {
            return  __('validation.attributes.week_start_date') . ' باید شروع هفته (شنبه) باشد.';
        });

        view()->composer('customer.layouts.header', function ($view) {
            $menus = Menu::where('status', 1)->orderBy('priority', 'desc')->get();
            $view->with('menus', $menus);
        });
        view()->composer('admin.layouts.side-bar', function ($view) {
            $newTicket = Ticket::where('status', 2)->first();
            $newSettlements = Settlement::where('status', 0)->first();
            $newCourse = Course::where('confirmation_status', 0)->first();
            $view->with(['newTickets' => $newTicket, 'newSettlements' => $newSettlements, 'newCourse' => $newCourse]);
        });


    }
}
