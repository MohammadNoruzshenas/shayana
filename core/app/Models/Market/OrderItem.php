<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function singleProduct()
    {
        return $this->belongsTo(Course::class,'course_id');

    }
    public function user()
    {
        return $this->belongsTo(User::class,'teacher_id');

    }
    public function order()
    {
        return $this->belongsTo(Order::class);

    }


}
