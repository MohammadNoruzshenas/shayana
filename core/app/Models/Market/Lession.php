<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\URL;

class Lession extends Model
{
    use HasFactory,sluggable;

    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'title'
            ]
        ];

    }

    protected $fillable = ['course_id','user_id','season_id','title','number','time','link','file_link','is_free','slug','body','confirmation_status','status','body','is_video','installment_show_count'];

    public function season()
    {
       return $this->belongsTo(Season::class);
    }
    public function course()
    {
       return $this->belongsTo(Course::class);
    }
    public function getConfirmationStatusValueAttribute()
    {
        switch($this->confirmation_status){
            case 0:
            $result = 'رد شده';
           break;
           case 1:
             $result = 'تایید شده';
            break;
            default:
             $result = 'در حال انتظار';
            break;
        }
        return $result;
    }
    public function downloadLink()
    {
        return URL::temporarySignedRoute('media.download', now()->addDay() , ['lession' => $this->id]);
    }
    public function downloadFileLink()
    {
        return URL::temporarySignedRoute('media.download.file', now()->addDay() , ['lession' => $this->id]);
    }


}
