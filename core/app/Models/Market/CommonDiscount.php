<?php

namespace App\Models\Market;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonDiscount extends Model
{
    use HasFactory;
    protected $table = 'common_discount';
    protected $guarded = ['id'];

    public function activeCommonDiscounts()
    {
        return $this->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->first();
    }
    public function commonable()
    {
        return $this->morphTo();
    }
    public function getCommonDiscountTypeValueAttribute()
    {
        switch ($this->commonable_type) {
            case 'App\Models\Market\Course':
                $result = 'دوره ها';
                break;
            case 'App\Models\Market\Plan':
                $result = 'اشتراک ها';
                break;
            default:
                $result = 'همه اقلام سایت';
                break;
        }
        return $result;
    }
}
