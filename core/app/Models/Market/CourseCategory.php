<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;


class CourseCategory extends Model
{
    use HasFactory,SoftDeletes,Sluggable;
    protected $fillable = ['title','parent_id','status','show_in_menu','slug','svg_code','meta_description'];
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'title'
            ]
        ];

    }
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

}
