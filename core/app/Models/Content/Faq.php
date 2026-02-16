<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;


class Faq extends Model
{
    use HasFactory,sluggable,SoftDeletes;
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'question'
            ]
        ];
    }
    public function faq()
    {
        return $this->morphTo();
    }


    protected $fillable = ['question', 'answer', 'slug', 'status','faq_id','faq_type'];
}
