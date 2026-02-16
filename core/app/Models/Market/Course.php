<?php

namespace App\Models\Market;

use App\Http\Controllers\Admin\Repositories\CourseRepo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;
use Nagy\LaravelRating\Traits\Rateable;

class Course extends Model
{
    protected $fillable = ['title', 'price', 'category_id', 'video_link', 'teacher_id', 'image', 'types', 'progress', 'status', 'body', 'slug', 'percent', 'confirmation_status', 'get_course_option', 'spot_api_key', 'spot_course_license', 'prerequisite', 'summary', 'priority', 'maximum_registration','published_at'];
    use HasFactory, SoftDeletes, sluggable, Rateable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }
    protected $casts = ['image' => 'array'];

    public function teacher()
    {
        return $this->BelongsTo(User::class, 'teacher_id');
    }

    public function getStatusValueAttribute()
    {
        switch ($this->status) {
            case 1:
                $result = 'درحال برگزاری';
                break;
            case 2:
                $result = 'تکمیل شده';
                break;
            case 3:
                $result = 'توقف فروش';
                break;
            case 4:
                $result = 'پیش فروش';
                break;
            default:
                $result = 'قفل شده';
                break;
        }
        return $result;
    }
    public function getStatusStyleValueAttribute()
    {
        switch ($this->status) {
            case 0:
                $result = 'red';
                break;
            case 1:
                $result = 'green';
                break;
            case 2:
                $result = 'blue';
                break;
            case 4:
                $result = 'blue';
                break;
            default:
                $result = 'red';
                break;
        }
        return $result;
    }

    public function getCourseLevelValueAttribute()
    {
        switch ($this->course_level) {
            case 0:
                $result = 'مقدماتی';
                break;
            case 1:
                $result = 'متوسط';
                break;
            case 2:
                $result = 'پیشرفته';
                break;
            default:
                $result = 'مقدماتی تا پیشرفته';
                break;
        }
        return $result;
    }
    public function getConfirmationStatusValueAttribute()
    {
        switch ($this->confirmation_status) {
            case 0:
                $result = 'در حال بررسی ';
                break;
            case 1:
                $result = 'تایید شده';
                break;
            case 2:
                $result = 'رد شده';
                break;
            case 3:
                $result = 'ویرایش شده درحال بررسی';
                break;
            default:
                $result = '-';
                break;
        }
        return $result;
    }


    public function students()
    {
        return $this->belongsToMany(User::class, 'order_items', 'course_id', 'user_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lession::class);
    }
    public function season()
    {
        return $this->hasMany(Season::class);
    }

    public function orderItem()
    {
        $this->hasMany(orderItem::class, 'course_id');
    }
    public function getDuration()
    {
        return (new CourseRepo())->getDuration($this->id);
    }
    public function formattedDuration()
    {
        $duration = $this->getDuration();
        $h = round($duration / 60) < 10 ?  round($duration / 60) : round($duration / 60);
        $m = ($duration % 60) < 10 ? '0' . ($duration % 60) : ($duration % 60);
        $h = empty($h) ? '00:00:00' : $h . ' ساعت';
        return $h;
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
    public function comments()
    {
        return $this->morphMany('App\Models\Content\Comment', 'commentable');
    }
    public function activeComments()
    {
        return $this->comments()->latest()->where('approved', 1)->whereNull('parent_id')->paginate(20);
    }
    public function faqs()
    {
        return $this->morphMany('App\Models\Content\Faq', 'faq');
    }
    public function activeFaqs()
    {
        return $this->faqs()->latest()->where('status', 1)->take(20);
    }
    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }
    public function hasStudent()
    {
        if (Auth::check()) {
            if ($this->types == 2) {
                return Auth::user()->hasActivceSubscribe();
            }
            return (bool) OrderItem::where(['course_id' => $this->id, 'user_id' => Auth::user()->id, 'status' => 1])->first();
        }
        return false;
    }



    public function activeCommonDiscount()
    {

        $common =  CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', 'App\Models\Market\Course']])->first();
        if ($common) {
            if ($common->commonable_id != null && $common->commonable_id == $this->id && $this->types == 1) {
                return CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', 'App\Models\Market\Course']])->first();
            }
            if ($common->commonable_id == null && $this->types == 1)

                return CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', 'App\Models\Market\Course']])->first();
        }
        $common =  CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['commonable_type', null]])->first();
        if ($common && $this->types == 1) {
            return $common;
        }
        return null;
    }
    public function downloadLinks(): array
    {
        $links = [];
        foreach (resolve(CourseRepo::class)->getLessons($this->id) as $lesson) {

            $links[] = $lesson->downloadLink();
        }
        return $links;
    }
    public function getCoursePriceValueAttribute()
    {
        switch ($this->types) {
            case 0:
                $result = 'رایگان';
                break;
            case 1:
                $result = $this->price == 0 ? 'رایگان' : priceFormat($this->price) . ' تومان';
                break;
            case 2:
                $result = 'اشتراک ویژه';
                break;
            default:
                $result = '-';
                break;
        }
        return $result;
    }

    public function getFinalCoursePriceValueAttribute()
    {
        switch ($this->types) {
            case 0:
                $result = 'رایگان';
                break;
            case 1:
                if ($this->activeCommonDiscount()) {
                    $price =  $this->price - $this->price * ($this->activeCommonDiscount()->percentage / 100);
                    $result = $price == 0 ? 'رایگان' : priceFormat($price) . ' تومان';
                } else {
                    $result = $this->price == 0 ? 'رایگان' : priceFormat($this->price) . ' تومان';
                }
                break;
            case 2:
                $result = 'اشتراک ویژه';
                break;
            default:
                $result = '-';
                break;
        }
        return $result;
    }
}
