<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Jobs\SendConfirmStudentJob;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BulkSMSRecord;
use App\Http\Requests\Admin\Notify\BulkSMSRequest;


class BulkSMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('show-bulk-sms') || !$this->user->can('create-bulk-sms')) {
                abort(403);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of bulk SMS records
     */
    public function index()
    {
        $records = BulkSMSRecord::with(['creator', 'sms'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notify.bulk-sms.index', compact('records'));
    }

    /**
     * Display the specified bulk SMS record
     */
    public function show(BulkSMSRecord $bulkSMSRecord)
    {
        $bulkSMSRecord->load(['creator', 'sms']);
        return view('admin.notify.bulk-sms.show', compact('bulkSMSRecord'));
    }

    /**
     * Show the form for bulk SMS sending
     */
    public function create()
    {
        $persianMonths = [
            1 => 'فروردین',
            2 => 'اردیبهشت',
            3 => 'خرداد',
            4 => 'تیر',
            5 => 'مرداد',
            6 => 'شهریور',
            7 => 'مهر',
            8 => 'آبان',
            9 => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند'
        ];

        // Generate years (current year and next few years)
        $currentYear = 1403; // Current Persian year, adjust as needed
        $years = [];
        for ($i = $currentYear; $i <= $currentYear + 5; $i++) {
            $years[$i] = $i;
        }

        return view('admin.notify.bulk-sms.create', compact('persianMonths', 'years'));
    }

    /**
     * Process and send bulk SMS
     */
    public function store(BulkSMSRequest $request)
    {
        $user = \auth()->user();



        try {
            // Process Excel file
            $file = $request->file('excel_file');
            $data = Excel::toArray([], $file);
            
            // Get the first sheet
            $rows = $data[0];

            // Skip header row
            $originalRows = $rows;
            array_shift($rows);

            $smsType = $request->sms_type;

            // Create bulk SMS record
            $bulkRecordData = [
                'excel_data' => $originalRows,
                'sms_type' => $smsType,
                'file_name' => $file->getClientOriginalName(),
            ];


            $bulkRecord = BulkSMSRecord::create([
                'creator_id' => Auth::id(),
                'data' => $bulkRecordData,
                'total_count' => count($rows),
                'status' => BulkSMSRecord::STATUS_PENDING,
            ]);
            $phoneNumbers = [];
            $messages = [];

            foreach ($rows as $row) {
                if (empty($row[0]) || empty($row[1])) {
                    continue; // Skip empty rows
                }

                $name = trim($row[1]);
                $parentName = trim($row[2]);
                $phoneNumber = trim($row[0]);
                $phoneNumbers [] = formatPhoneNumber($phoneNumber);
                if ($smsType === 'confirm') {
                    $messages[] = __('sms.confirmStudent', ['supportName' =>$user->first_name , 'studentName' =>$name , 'parentName' => $parentName ]);
                }else{
                    $messages[] = __('sms.rejectStudent', ['supportName' => $user->first_name, 'studentName' => $name , 'parentName' => $parentName]);
                }

            }

           SendConfirmStudentJob::dispatch($phoneNumbers,$messages);



                return redirect()->route('admin.notify.bulk-sms.index')->with('swal-success', "پیامک‌ها با موفقیت در صف ارسال قرار گرفتند.");

        } catch (\Exception $e) {

            return redirect()->back()->with('swal-error', 'خطا در پردازش فایل: ' . $e->getMessage());
        }
    }

    /**
     * Validate phone number format
     */
    private function isValidPhoneNumber($phoneNumber)
    {
        // Remove any non-digit characters
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
        
        // Check if it's a valid Iranian mobile number
        return preg_match('/^(\+98|0098|98|0)?9[0-9]{9}$/', $phoneNumber);
    }

    /**
     * Send SMS using the configured panel
     */
    private function sendSMS($phoneNumber, $message, $smsPanel)
    {
        try {
            // Normalize phone number
            $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
            if (substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = '98' . substr($phoneNumber, 1);
            } elseif (substr($phoneNumber, 0, 2) !== '98') {
                $phoneNumber = '98' . $phoneNumber;
            }

            // Here you would implement the actual SMS sending logic
            // This is a placeholder - replace with your SMS provider's API
            
            // For demonstration, we'll just log it or return true
            // In a real implementation, you would call your SMS service here
            
            return true; // Assume success for now
            
        } catch (\Exception $e) {
            \Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }
} 