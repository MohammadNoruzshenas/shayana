<?php

namespace App\Models\Content;

use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Podcast extends Model
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
       return $this->belongsTo(PodcastCategory::class);
    }
    public function podcaster()
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
    public function linkPodcast($link)
    {

        $media = Media::where('media', $link)->first();
        if ($media && !is_null($link)) {
                if (Storage::disk($media->storage_space)->exists($link)) {
                    // while (ob_get_level() > 0) ob_get_flush();
                    if ($media->storage_space == 's3') {
                        $temporarySignedUrl = Storage::disk($media->storage_space)->temporaryUrl($link, now()->addDay());
                        return $temporarySignedUrl;
                    }
                } else {
                    return asset($link);
                }
            }
           return $link;
        }

}
