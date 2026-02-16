<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusValueAttribute()
    {
        switch ($this->status){
                case 0:
                $result = 'پرداخت نشده';
                break;
                case 1 :
                    $result = 'پرداخت شده';
                break;
                    default :
                $result = '-';
                break;
        }
        return $result;
    }
    public function getPayForValueAttribute()
    {
        switch ($this->pay_for){
                case 0:
                $result = 'نامشخص';
                break;
                case 1 :
                    $result = ' سفارش';
                break;
                case 2 :
                    $result = ' اشتراک';
                    break;
                case 3 :
                     $result = ' تبلیغات';
                break;
                    default :
                $result = 'نامشخص';
                break;
        }
        return $result;
    }

    //find payment
    // public function getDayPayments($day, $status)
    // {
    //     return Payment::whereDate("created_at", $day)->where("status", $status)->latest();
    // }
    // public function getDaySuccessPayments($day)
    // {
    //     return $this->getDayPayments($day, 1)->where('user_id',auth()->user()->id)->sum("amount");
    // }

}
