<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Installment;
use App\Models\Market\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Installment::with(['user', 'course']);

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'paid') {
                $query->whereNotNull('installment_passed_at');
            } elseif ($request->payment_status == 'unpaid') {
                $query->whereNull('installment_passed_at');
            }
        }

        $installments = $query->orderBy('installment_date', 'desc')->get();
        
        // Get data for filter dropdowns
        $courses = Course::select('id', 'title')->get();
        $users = User::select('id', 'first_name', 'last_name')->get();
        
        return view('admin.market.installment.index', compact('installments', 'courses', 'users'));
    }

    public function toggleStatus(Installment $installment)
    {
        try {
            if ($installment->installment_passed_at) {
                // Mark as not passed
                $installment->installment_passed_at = null;
                $checked = false;
            } else {
                // Mark as passed
                $installment->installment_passed_at = now();
                $checked = true;
            }
            
            $installment->save();

            return response()->json([
                'status' => true,
                'checked' => $checked
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false
            ]);
        }
    }
}
