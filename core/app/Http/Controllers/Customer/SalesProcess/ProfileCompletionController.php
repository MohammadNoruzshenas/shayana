<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;

class ProfileCompletionController extends Controller
{
    public function profileCompletion()
    {
        return redirect()->route('customer.profile')->with('swal-error','لطفا اطلاعات حساب خود را کامل کنید');
    }
}
