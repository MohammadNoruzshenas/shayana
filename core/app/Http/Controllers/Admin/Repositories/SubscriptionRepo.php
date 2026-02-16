<?php

namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Market\Subscription;

class SubscriptionRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Subscription::query();
    }
    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->join("users", "subscriptions.user_id", 'users.id')->select("subscriptions.*", "users.email")->where("email", "like", "%" . $email . "%");
        }
        return $this;
    }
    public function activeSub($status)
    {
        if ($status == 1) {
            $this->query->where('status', 1)->where('expirydate', '>', now());
        } elseif($status == 2) {
            $this->query->where('status', 1)->where('expirydate', '<', now());
        }
        elseif($status == 3) {
            $this->query->where('payment_status', 0);
        }
        return $this;
    }
    public function paginateParents($paginate)
    {

        return $this->query->latest()->paginate($paginate);
    }
}
