<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function activeCommonDiscount()
    {
        $common =  CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', 'App\Models\Market\Plan']])->first();

        if ($common) {
            if ($common->commonable_id != null && $common->commonable_id == $this->id) {
                return CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', 'App\Models\Market\Plan']])->first();
            }
            if ($common->commonable_id == null)
                return CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', 'App\Models\Market\Plan']])->first();
        }
        $common =  CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', null]])->first();
        if ($common) {
            return $common;
        }
        return null;
    }

    public function getFinalPlanPriceValueAttribute()
    {

        if ($this->activeCommonDiscount()) {

            $price =  $this->price - $this->price * ($this->activeCommonDiscount()->percentage / 100);
            $result = $price == 0 ? 'رایگان' : priceFormat($price) . ' تومان';
        } else {
            $result = $this->price == 0 ? 'رایگان' : priceFormat($this->price) . ' تومان';
        }
        return $result;
    }



    public function planDiscount()
    {
        $planPrice = $this->price;
        $planDiscount = empty($this->activeCommonDiscount()) ? 0 : $planPrice * ($this->activeCommonDiscount()->percentage / 100);
        return $planDiscount;
    }
    public function planFinalPrice()
    {
        $planPrice = $this->price;
        $planDiscount = $this->planDiscount();
        return $planPrice - $planDiscount;
    }

}
