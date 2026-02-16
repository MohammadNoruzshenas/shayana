<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Market\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentFilterRepo{
    public $query;

    public function __construct()
    {
        $this->query = Payment::query();
    }

    public function payFor($value)
    {

        if (!is_null($value)) {

            $this->query->where("pay_for", $value);
        }

        return $this;
    }
    public function searchTransaction($value)
    {

        if (!is_null($value)) {
            $this->query->where("transaction_id", $value);
        }

        return $this;
    }
    public function searchAfterDate($date)
    {

        if (!is_null($date)) {

            $this->query->whereDate("created_at", ">=", $date);
        }

        return $this;
    }

    public function searchBeforeDate($date)
    {
        if (!is_null($date)) {

            $this->query->whereDate("created_at", "<=", $date);
        }

        return $this;
    }
    public function amount($amount)
    {
        if (!is_null($amount)) {

            $this->query->where("amount", $amount);
        }

        return $this;
    }

    public function email($email)
    {

        if (!is_null($email)) {
            $this->query->join("users", "payments.user_id", 'users.id')->select("payments.*", "users.email")->where("email", "like", "%" . $email . "%");
        }
        return $this;
    }

    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }

}
