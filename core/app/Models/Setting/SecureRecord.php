<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecureRecord extends Model
{
    use HasFactory;
    protected $table = 'tbl_secure_records';
    protected $guarded = ['id'];
}
