<?php

namespace App\Models\Notify;

use App\Models\Market\Course;
use App\Models\Notify\EmailFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    protected $table = 'public_mail';

    use HasFactory, SoftDeletes;


    protected $fillable = ['subject', 'body', 'status', 'published_at','receive_it','course_id'];

    public function files(){
        return $this->hasMany(EmailFile::class, 'public_mail_id');
    }
    public function course() {
        return $this->belongsTo(Course::class);
    }

}
