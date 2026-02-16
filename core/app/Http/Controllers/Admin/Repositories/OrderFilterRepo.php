<?php

namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Market\Order;

class OrderFilterRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Order::query();
    }


    public function paginateParents($status = null)
    {
        return $this->query->latest()->paginate(20);
    }

    public function amount($amount)
    {
        if (!is_null($amount))
            $this->query->where('order_final_amount',$amount);
           return $this;
    }

    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->join("users", "orders.user_id", 'users.id')->select("orders.*", "users.email")->where("email", "like", "%" . $email . "%");
        }

        return $this;
    }
    public function payment_status($payment_status)
    {
            if(isset($payment_status)){
                $this->query->where("payment_status",  $payment_status == 4 ? 0 : $payment_status);
                return $this;
            }else{
                return $this;
            }
    }

}
