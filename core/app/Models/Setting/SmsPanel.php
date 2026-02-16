<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsPanel extends Model
{
    use HasFactory;
    protected $fillable = ['username','password','number'];

}
