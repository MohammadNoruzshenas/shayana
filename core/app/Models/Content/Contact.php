<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getStatusValueAttribute()
    {
        switch ($this->status) {
            case 0:
                $result = 'دیده نشده';
                break;
            case 1:
                $result =  'دیده شده';
                break;
            case 2:
                $result =  'پاسخ داده شده';
                break;
            default:
                $result = 'خطا نامشخص';
        }
        return $result;
    }



    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }
}
