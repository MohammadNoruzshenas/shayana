<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Log\Log;

class LogFilterRepo{
    public $query;

    public function __construct()
    {
        $this->query = Log::query();
    }

    public function email($email)
    {

        if (!is_null($email)) {
            $this->query->join("users", "logs.user_id", 'users.id')->select("logs.*", "users.email")->where("email", "like", "%" . $email . "%");
        }
        return $this;
    }
    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }

}
