<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Models\User;

class AdminUserFilterRepo{
    public $query;

    public function __construct()
    {
        $this->query = User::query()->where('is_admin',1);
    }


    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }


    public function first_name($first_name)
    {
        if ($first_name)
        $this->query->where("first_name", $first_name);
        return $this;
    }

    public function last_name($last_name)
    {
        if ($last_name)

        $this->query->where("last_name", "like", "%" . $last_name . "%");
        return $this;
    }
    public function mobile($mobile)
    {
        if ($mobile)
        $this->query->where("mobile", $mobile);
        return $this;
    }

    public function username($username)
    {
        if ($username)

        $this->query->where("username", "like", "%" . $username . "%");
        return $this;
    }
    public function email($email)
    {
        if ($email)

        $this->query->where("email", "like", "%" . $email . "%");
        return $this;
    }
    public function status($status)
    {
        if ($status)

        $this->query->where("status", "like", "%" . $status . "%");
        return $this;
    }
}
