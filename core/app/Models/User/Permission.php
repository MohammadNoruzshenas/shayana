<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description', 'status'];


    public function roles()
    {

        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public static $defaultPermissions = [
        [
            'name' => 'show_category',
            'description' => 'نمایش دسته بندی',
            'status' => 1
        ],
        [
            'name' => 'create_category',
            'description' => 'افزودن دسته بندی',
            'status' => 1
        ],
        [
            'name' => 'edit_category',
            'description' => 'ویرایش دسته بندی',
            'status' => 1
        ],
        [
            'name' => 'delete_category',
            'description' => 'پاک کردن دسته بندی',
            'status' => 1
        ],
        [
            'name' => 'show_course',
            'description' => 'نمایش دوره',
            'status' => 1
        ],
        [
            'name' => 'create_course',
            'description' => 'افزودن دوره',
            'status' => 1
        ],
        [
            'name' => 'edit_course',
            'description' => 'ویرایش دوره',
            'status' => 1
        ],
        [
            'name' => 'delete_course',
            'description' => 'پاک کردن دوره',
            'status' => 1
        ],
        [
            'name' => 'manage_course',
            'description' => ' مدیریت دوره (تایید رد)',
            'status' => 1
        ],

        [
            'name' => 'own_course',
            'description' => 'مدیریت دوره های خود',
            'status' => 1
        ],
        [
            'name' => 'show_lession',
            'description' => 'نمایش جلسات دوره',
            'status' => 1
        ],
        [
            'name' => 'create_lession',
            'description' => 'اضافه کردن جلسه و سرفصل',
            'status' => 1
        ],
        [
            'name' => 'edit_lession',
            'description' => 'ویرایش جلسات دوره',
            'status' => 1
        ],
        [
            'name' => 'delete_lession',
            'description' => 'حذف جلسات دوره',
            'status' => 1
        ],
        [
            'name' => 'add_student_course',
            'description' => 'اضافه کردن دانشجو به دوره',
            'status' => 1
        ],
        [
            'name' => 'show_user',
            'description' => 'نمایش کاربران',
            'status' => 1
        ],
        [
            'name' => 'create_user',
            'description' => 'افزودن کاربر',
            'status' => 1
        ],
        [
            'name' => 'edit_user',
            'description' => 'ویرایش کاربر',
            'status' => 1
        ],
        [
            'name' => 'delete_user',
            'description' => 'پاک کردن کاربر',
            'status' => 1
        ],
        [
            'name' => 'show_menu',
            'description' => 'نمایش منو',
            'status' => 1
        ],
        [
            'name' => 'create_menu',
            'description' => 'افزودن منو',
            'status' => 1
        ],
        [
            'name' => 'edit_menu',
            'description' => 'ویرایش منو',
            'status' => 1
        ],
        [
            'name' => 'delete_menu',
            'description' => 'پاک کردن منو',
            'status' => 1
        ],

        [
            'name' => 'show_post',
            'description' => 'نمایش پست ها',
            'status' => 1
        ],
        [
            'name' => 'create_post',
            'description' => 'افزودن پست',
            'status' => 1
        ],
        [
            'name' => 'edit_post',
            'description' => 'ویرایش پست',
            'status' => 1
        ],
        [
            'name' => 'delete_post',
            'description' => 'پاک کردن پست',
            'status' => 1
        ],
        [
            'name' => 'manage_post',
            'description' => 'مدیریت پست ها',
            'status' => 1
        ],
        [
            'name' => 'show_categoryPost',
            'description' => 'نمایش دسته بندی پست ها',
            'status' => 1
        ],
        [
            'name' => 'create_categoryPost',
            'description' => 'افزودن دسته بندی پست ها',
            'status' => 1
        ],
        [
            'name' => 'edit_categoryPost',
            'description' => 'ویرایش  دسته بندی پست ها',
            'status' => 1
        ],
        [
            'name' => 'delete_categoryPost',
            'description' => 'پاک کردن دسته بندی پست ها',
            'status' => 1
        ],
        [
            'name' => 'show_ads',
            'description' => 'نمایش تبلیغات',
            'status' => 1
        ],
        [
            'name' => 'create_ads',
            'description' => 'افزودن تبلیغات',
            'status' => 1
        ],
        [
            'name' => 'edit_ads',
            'description' => 'ویرایش تبلیغات',
            'status' => 1
        ],

        [
            'name' => 'delete_ads',
            'description' => 'پاک کردن تبلیغات',
            'status' => 1
        ],

        [
            'name' => 'manage_comment',
            'description' => 'مدیریت نظرات ',
            'status' => 1
        ],

        [
            'name' => 'manage_discount',
            'description' => 'مدیریت تخفیف ها',
            'status' => 1
        ],
        [
            'name' => 'manage_financial',
            'description' => 'مدیریت مالی (سفارشات و تراکنش ها درخواست تسویه حساب )',
            'status' => 1
        ],
        [
            'name' => 'manage_notification',
            'description' => 'مدیریت اطلاع رسانی ها',
            'status' => 1
        ],
        [
            'name' => 'manage_setting',
            'description' => 'مدیریت تنظیمات',
            'status' => 1
        ],
        [
            'name' => 'manage_template_setting',
            'description' => 'مدیریت تنظیمات قالب',
            'status' => 1
        ],

        [
            'name' => 'show_admin',
            'description' => 'مشاهده مدیران',
            'status' => 1
        ],
        [
            'name' => 'manage_access',
            'description' => 'مدیریت دسترسی ها',
            'status' => 1
        ],
        [
            'name' => 'manage_uploader',
            'description' => 'مدیریت اپلودر',
            'status' => 1
        ],
        [
            'name' => 'create_media',
            'description' => 'افزودن مدیا',
            'status' => 1
        ],

        [
            'name' => 'manage_slider',
            'description' => 'مدیریت اسلایدر',
            'status' => 1
        ],
        [
            'name' => 'manage_pages',
            'description' => 'مدیریت  صفحه ساز',
            'status' => 1
        ],
        [
            'name' => 'manage_faqs',
            'description' => 'مدیریت  سوالات متداول',
            'status' => 1
        ],
        [
            'name' => 'manage_ticket',
            'description' => 'مدیریت  تیکت ها',
            'status' => 1
        ],
        [
            'name' => 'manage_subscribe',
            'description' => 'مدیریت  اشتراک ها |پلن ها',
            'status' => 1
        ],
        [
            'name' => 'manage_logs',
            'description' => 'مدیریت  رخداد ها',
            'status' => 1
        ],
        [
            'name' => 'show_information',
            'description' => 'نمایش اطلاعات (داشبورد)',
            'status' => 1
        ],
        [
            'name' => 'show_categoryPodcast',
            'description' => 'نمایش دسته بندی پادکست ها',
            'status' => 1
        ],
        [
            'name' => 'create_categoryPodcast',
            'description' => 'افزودن دسته بندی پادکست ها',
            'status' => 1
        ],
        [
            'name' => 'edit_categoryPodcast',
            'description' => 'ویرایش دسته بندی پادکست ها',
            'status' => 1
        ],
        [
            'name' => 'delete_categoryPodcast',
            'description' => 'پاک کردن دسته بندی پادکست ها',
            'status' => 1
        ],
        [
            'name' => 'show_podcast',
            'description' => 'نمایش پادکست',
            'status' => 1
        ],
        [
            'name' => 'create_podcast',
            'description' => 'افزودن پادکست',
            'status' => 1
        ],
        [
            'name' => 'edit_podcast',
            'description' => 'ویرایش پادکست',
            'status' => 1
        ],
        [
            'name' => 'delete_podcast',
            'description' => 'پاک کردن پادکست',
            'status' => 1
        ],

        [
            'name' => 'manage_podcast',
            'description' => 'مدیریت پادکست ها',
            'status' => 1
        ],
    ];
}
