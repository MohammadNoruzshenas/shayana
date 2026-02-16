<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Repositories\AdminUserFilterRepo;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('show_admin')) {
                abort(403);
            }
            return $next($request);
        });

    }
    public function index(AdminUserFilterRepo $repo)
    {
        $users = $repo->status(request('status'))->first_name(request('first_name'))->last_name(request('last_name'))->email(request('email'))->mobile(request('mobile'))->username(request('username'))->paginateParents(20);
        return view('admin.user.admin-user.index',compact('users'));
    }
    public function permissions(User $admin,Request $request)
    {
        $permissions = Permission::all();
        return view('admin.user.admin-user.permissions',compact('admin','permissions'));
    }
    public function permissionsStore(Request $request,User $admin)
    {

        $validated = $request->validate([
            'permissions' => 'nullable|exists:permissions,id|array'
        ]);

        $admin->permissions()->sync($request->permissions);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'سطح دسترسی با موفقیت ویرایش شد');
    }
    public function roles(User $admin)
    {
        $roles = Role::all();
        return view('admin.user.admin-user.roles',compact('admin','roles'));
    }
    public function rolesStore(User $admin,Request $request)
    {

        $validated = $request->validate([
            'roles' => 'nullable|exists:roles,id|array'
        ]);

        $admin->roles()->sync($request->roles);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'نقش کاربر با موفقیت ویرایش شد');
    }
}
