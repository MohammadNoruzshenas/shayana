<?php

namespace App\Models\Content;

use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes,Sluggable;
    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'title'
            ]
        ];

    }
    protected $casts = ['image' => 'array'];

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
    public function category()
    {
       return $this->belongsTo(PostCategory::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->morphMany('App\Models\Content\Comment', 'commentable');
    }
    public function activeComments()
    {
        return $this->comments()->latest()->where('approved', 1)->whereNull('parent_id')->paginate(20);
    }

}
