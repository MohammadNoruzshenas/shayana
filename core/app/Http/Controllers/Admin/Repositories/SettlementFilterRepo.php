<?php

namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Content\Post;
use App\Models\Market\Settlement;

class SettlementFilterRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Settlement::query();
    }
    public function amount($amount)
    {
        if (!is_null($amount))
            $this->query->where('amount',$amount);
           return $this;
    }

    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }
    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->join("users", "settlements.user_id", 'users.id')->select("settlements.*", "users.email")->where("email", "like", "%" . $email . "%");

        }

        return $this;
    }

    // public function last_name($last_name)
    // {
    //     if ($last_name)

    //     $this->query->whereHas('user', function ($query) use ($last_name) {
    //         $query->where('last_name', 'like', '%' . $last_name . '%');
    //     });
    //     return $this;
    // }
    public function username($username)
    {
        if ($username)
        $this->query->whereHas('user', function ($query) use ($username) {
            $query->where('username', 'like', '%' . $username . '%');
        });
        return $this;
    }
    public function email($email)
    {
        if ($email)
        $this->query->whereHas('user', function ($query) use ($email) {
            $query->where('email', 'like', '%' . $email . '%');
        });
        return $this;
    }

    public function status($status)
    {
        if(isset($status))
        {


            $this->query->where('status',$status == 3 ? 0 : $status);
            return $this;
        }else{
            return $this;
        }
}

}
