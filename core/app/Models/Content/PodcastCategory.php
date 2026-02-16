<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PodcastCategory extends Model
{
    use HasFactory,SoftDeletes,Sluggable;
    protected $fillable = ['title','parent_id','status','show_in_menu','slug','meta_description'];
    public function sluggable(): array
    {
        return[
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];

    }
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }
    public function podcasts()

    {
        return $this->hasMany(Podcast::class, 'category_id');

    }
}
