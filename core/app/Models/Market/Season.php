<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['title','number','course_id','user_id','confirmation_status','status','parent_id'];


    public function getConfirmationStatusValueAttribute()
    {

        switch($this->confirmation_status)
        {

            case 0:
                $result = 'رد شده';
                break;
            case 1:
                $result = 'تایید شده';
                break;
            default:
            $result = 'درحال بررسی';
            break;
        }
        return $result;

    }
    public function lession()
    {
        return $this->hasMany(Lession::class)->orderBy('number', 'asc');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function parent()
    {
        return $this->belongsTo(Season::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Season::class, 'parent_id');
    }

}
