<?php

namespace App\Models\Content;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['body', 'parent_id', 'author_id', 'commentable_id', 'commentable_type', 'approved', 'status','view_in_home'];


    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function answers()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function getApprovedValueAttribute()
    {
        switch ($this->approved){
                case 0:
                $result = 'درحال بررسی';
                break;
                case 1 :
                    $result = 'تایید شده';
                break;
                  case 2:
                    $result = 'رد شده';
                    break;
                    default :
                $result = 'نامشخص';
                break;
        }
        return $result;
    }


}
