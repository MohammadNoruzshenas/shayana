<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SecureRecordRequest;
use App\Models\Log\Log;
use App\Models\Setting\SecureRecord;
use Database\Seeders\SecureSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SecureRecordController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_setting')) {
                abort(403);
            }
            return $next($request);
        });
    }
    public function index()
    {
        $secureRecord = SecureRecord::first();
        if ($secureRecord === null) {
            $default = new SecureSeeder();
            $default->run();
            $secureRecord = SecureRecord::first();
        }
        return view('admin.setting.secure.index', compact('secureRecord'));
    }
    public function update(SecureRecordRequest $request)
    {
        $inputs = $request->all();

        $secureRecord = SecureRecord::first();


        $file = base_path() . DIRECTORY_SEPARATOR . '.env';
        if (!file_exists($file)) {
            return redirect()->back()->with('swal-error', 'در ویرایش اطلاعات مشکلی به وجود امده است');
        }

        // MAIL_MAILER
        $oldLines = 'MAIL_MAILER="' . $secureRecord->mail_transport . '"';
        $newLines = 'MAIL_MAILER="' . $inputs['mail_transport'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        // MAIL_HOST
        $oldLines = 'MAIL_HOST="' . $secureRecord->mail_host . '"';
        $newLines = 'MAIL_HOST="' . $inputs['mail_host'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        // MAIL PORT
        $oldLines = 'MAIL_PORT="' . $secureRecord->mail_port . '"';
        $newLines = 'MAIL_PORT="' . $inputs['mail_port'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        //MAIL USERNAME
        $oldLines = 'MAIL_USERNAME="' . $secureRecord->mail_username . '"';
        $newLines = 'MAIL_USERNAME="' . $inputs['mail_username'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        //MAIL PASSWORD
        $oldLines = 'MAIL_PASSWORD="' . $secureRecord->mail_password . '"';
        $newLines = 'MAIL_PASSWORD="' . $inputs['mail_password'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        //MAIL encyption
        $oldLines = 'MAIL_ENCRYPTION="' . $secureRecord->mail_encyption . '"';
        $newLines = 'MAIL_ENCRYPTION="' . $inputs['mail_encyption'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        //recapcha site key
        $oldLines = 'RECAPTCHA_SITE_KEY="' . $secureRecord->recaptcha_site_key . '"';
        $newLines = 'RECAPTCHA_SITE_KEY="' . $inputs['recaptcha_site_key'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        //recapcha secret key
        $oldLines = 'RECAPTCHA_SECRET_KEY="' . $secureRecord->recaptcha_secret_key . '"';
        $newLines = 'RECAPTCHA_SECRET_KEY="' . $inputs['recaptcha_secret_key'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);



        // s3 key
        $oldLines = 'S3_KEY="' . $secureRecord->s3_key . '"';
        $newLines = 'S3_KEY="' . $inputs['s3_key'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        // SMS OTPFROM
        $oldLines = 'S3_SECRET="' . $secureRecord->s3_secret . '"';
        $newLines = 'S3_SECRET="' . $inputs['s3_secret'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        // SMS OTPFROM
        $oldLines = 'S3_BUCKET="' . $secureRecord->s3_bucket . '"';
        $newLines = 'S3_BUCKET="' . $inputs['s3_bucket'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        // SMS OTPFROM
        $oldLines = 'S3_ENDPOINT="' . $secureRecord->s3_endpoint . '"';
        $newLines = 'S3_ENDPOINT="' . $inputs['s3_endpoint'] . '"';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);







        $secureRecord->update($inputs);

        Cache::clear();
        Artisan::call('queue:restart');
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش تنظیمات سرویس وبسایت',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->back()->with('swal-success', 'تنظیمات با موفقیت ثبت شد');
    }
}
