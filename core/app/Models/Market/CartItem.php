<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function cartItemProductPrice()
    {
        return $this->course->price;
    }
    public function cartItemProductDiscount()
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $courseDiscount = empty($this->course->activeCommonDiscount()) ? 0 : $cartItemProductPrice * ($this->course->activeCommonDiscount()->percentage / 100);
        return $courseDiscount;
    }
    public function cartItemFinalPrice()
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $productDiscount = $this->cartItemProductDiscount();
        return $cartItemProductPrice - $productDiscount;
    }



}
