<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSetting extends Model
{
    use HasFactory;
    protected $casts = ['logo' => 'array', 'icon' => 'array'];


    protected $guarded = ['id'];
}
