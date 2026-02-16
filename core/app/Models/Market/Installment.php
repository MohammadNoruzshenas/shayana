<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class Installment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'order_id',
        'course_id', 
        'user_id',
        'installment_date',
        'installment_amount',
        'installment_passed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
