<?php

namespace App\Models\Notify;

use App\Models\Market\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function course() {
        return $this->belongsTo(Course::class);
    }
}
