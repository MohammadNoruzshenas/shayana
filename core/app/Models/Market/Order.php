<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

        public function user()
        {
            return $this->belongsTo(User::class);
        }


        public function getPaymentStatusValueAttribute()
        {
            switch ($this->payment_status){
                case 0:
                    $result = 'پرداخت نشده';
                    break;
                      case 1:
                    $result = 'پرداخت شده';
                    break;
                      case 3:
                    $result = 'پرداخت شده توسط سایت';
                    break;
                      default :
                    $result = 'برگشت داده شده';
            }
            return $result;
        }
        public function orderItems()
        {
            return $this->hasMany(OrderItem::class);
        }
        public function copan()
        {
            return $this->belongsTo(Copan::class);
        }
              public function commonDiscount()
        {
            return $this->belongsTo(CommonDiscount::class);
        }
        public function payment()
        {
            return $this->belongsTo(Payment::class);
        }



}
