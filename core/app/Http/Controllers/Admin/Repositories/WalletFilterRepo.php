<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Market\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletFilterRepo{
    public $query;

    public function __construct()
    {
        $this->query = Wallet::query();
    }


    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }
    public function searchEmail($email)
    {
        if ($email){
            $this->query->join("users", "wallets.user_id", 'users.id')->select("wallets.*", "users.email")->where("email", "like", "%" . $email . "%");
        }else{
            $this->query->join("users", "wallets.user_id", 'users.id')->select("wallets.*", "users.email")->where("email", "like", "%" . Auth::user()->email . "%");
        }
        return $this;
    }
    public function searchPrice($price)
    {
        if ($price)
            $this->query->where("price", "like", "%" . $price . "%");
        return $this;
    }
}
