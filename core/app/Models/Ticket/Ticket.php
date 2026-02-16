<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ticket extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['subject', 'description', 'status', 'seen',  'user_id',  'ticket_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusValueAttribute()
    {
       switch($this->status)
       {
        case 0:
            $result = 'بسته';
            break;
        case 1:
           $result =  'در انتظار پاسخ کاربر';
           break;
           default:
           $result = 'در انتظار بررسی';
       }
       return $result;
    }



    public function parent()
    {
        return $this->belongsTo($this, 'ticket_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany($this, 'ticket_id')->with('children');
    }

    public function file()
    {
        return $this->hasOne(TicketFile::class);
    }

}
