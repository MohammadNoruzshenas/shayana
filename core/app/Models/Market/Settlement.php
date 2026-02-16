<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $casts = ['to' => 'array','from' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusValueAttribute()
    {
        switch ($this->status){
            case 0:
                $result = 'بررسی نشده';
                break;
                  case 1:
                $result = 'پرداخت شده';
                break;
                  case 2:
                $result = 'رد شده';
                break;
                case 3:
                    $result = 'لغو شده';
                    break;
                    case 4:
                        $result = 'برگشت داده شده';
                        break;
                  default :
                $result = '-';
        }
        return $result;
    }

}
