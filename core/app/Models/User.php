<?php

namespace App\Models;


use App\Models\Market\Course;
use App\Models\Market\Installment;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Subscription;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Nagy\LaravelRating\Traits\CanRate;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'username',
        'is_admin',
        'mobile',
        'headline',
        'bio',
        'ip',
        'telegram',
        'image',
        'cart',
        'shaba',
        'balance',
        'email_verified_at',
        'active_key',
        'status',
        'email',
        'instagram',
        'parent_name',
        'age',
        'gender',
        'birth'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'image' => 'array'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission)->count();
    }

    // public function hasPermission($permission)
    // {
    //     foreach($this->permissions as $permissionUser)
    //     {

    //         if( $permissionUser->name === $permission)
    //         {
    //            return true;
    //         }


    //     }
    //     return false;
    // }
    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission) || $this->hasPermissionThroughRole($permission);
    }

    // public function hasPermissionThroughRole($permission)
    // {
    //     foreach ($permission->roles() as $role) {
    //         if ($this->roles->contains($role)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }


    public function hasPermissionThroughRole($permission)
    {
        $roles = Auth::user()->roles;
        foreach ($roles as $role) {
            $permissionsRole = $role->permissions;
            foreach ($permissionsRole as $permissionRole) {
                if ($permissionRole->name === $permission) {
                    return true;
                }
            }
        }
        return false;
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusValueAttribute()
    {
        switch ($this->status) {
            case 0:
                $result = 'غیر فعال';
                break;
            case 1:
                $result =  'فعال';
                break;
            default:
                $result = 'نامشخص';
        }
        return $result;
    }
    public function subscribe()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function hasActivceSubscribe()
    {
        return (bool) Subscription::where(['user_id' => $this->id, 'status' => 1])->where('expirydate', '>', now())->first();
    }
    public function courseTeacher()
    {
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }

    public function getRate($course)
    {
        $result = DB::select('
            SELECT * FROM ratings WHERE model_id =' . $this->id . ' AND rateable_id = ' . $course . '
            ');
        $result = collect($result);
        return $result;
    }


    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
