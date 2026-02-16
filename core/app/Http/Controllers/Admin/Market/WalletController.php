<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Repositories\WalletFilterRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\WalletRequest;
use App\Models\Log\Log;
use App\Models\Market\Wallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index(WalletFilterRepo $repo, Request $request)
    {
        // check can access to page
        $user = auth()->user();
        if ($user->can('manage_financial')) {
            $wallets =  $repo->searchEmail(request('email'))->searchPrice(request("price"))->paginateParents(20);
        } else {
            $wallets =  $repo->searchEmail(Auth::user()->email)->searchPrice(request("price"))->paginateParents(20);
        }
        $wallets->appends(request()->query());

        return view('admin.market.wallet.index', compact('wallets'));
    }
    public function create()
    {
        $user = auth()->user();
        if (!$user->can('manage_financial')) {
            abort(403);
        }
        return view('admin.market.wallet.create');
    }
    public function store(WalletRequest $request)
    {
        $user = auth()->user();
        if (!$user->can('manage_financial')) {
            abort(403);
        }
        $inputs = $request->all();
        $user = User::where('email', $inputs['email'])->first();
        DB::transaction(function () use ($inputs, $user, $request) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'price' => $inputs['price'],
                'type' => $inputs['type'],
                'description' => $inputs['description'],
            ]);
            if ($inputs['type'] == 1) {
                $user->increment('balance', $inputs['price']);
            } else {
                $user->decrement('balance', $inputs['price']);
            }
            $address = route("admin.market.wallet.detail", $wallet);
            Log::create([
                'user_id' => auth()->user()->id,
                'description' => 'کیف پول : ' . $user->email . ' ایدی عملیات انجام شده:  ' . '<a class="text-success" href=' . "$address" . '>' . $wallet->id . '</a>',
                'ip' => $request->ip(),
                'os' => $request->header('user-Agent')
            ]);
        });
        return redirect()->route('admin.market.wallet.index')->with('swal-success', 'عملیات با موفقیت انجام شد');
    }
    public function detail(Wallet $wallet)
    {
        $user = auth()->user();
        if ($wallet->user_id == Auth::user()->id || $user->can('manage_financial')) {
            return view('admin.market.wallet.detail', compact('wallet'));
        }
        abort(403);
    }
}
