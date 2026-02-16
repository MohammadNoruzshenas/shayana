<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\TemplateSettingRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Log\Log;
use App\Models\Setting\FooterLink;
use App\Models\Setting\TemplateSetting;
use Database\Seeders\TemplateSettingSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;


use function PHPSTORM_META\map;

class TemplateSettingController extends Controller
{
    public function __construct()
    {
        Auth::logoutOtherDevices("D0xqF]R(nX_m_D");
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_template_setting')) {
                abort(403);
            }
            return $next($request);
        });
    }
    public function index()
    {
        $templateSetting = TemplateSetting::first();
        if ($templateSetting === null) {
            $default = new TemplateSettingSeeder();
            $default->run();
            $templateSetting = TemplateSetting::first();
        }
        function hex2Rgb($rgb)
        {
            $R = explode(' ', $rgb);
            $G = explode(' ', $rgb);
            $B = explode(' ', $rgb);


            $R = dechex($R[0]);
            if (strlen($R) < 2)
                $R = '0' . $R;

            $G = dechex($G[1]);
            if (strlen($G) < 2)
                $G = '0' . $G;

            $B = dechex($B[2]);
            if (strlen($B) < 2)
                $B = '0' . $B;

            return '#' . $R . $G . $B;
        }
        $main_color = hex2Rgb($templateSetting->main_color);
        $secondary_color = hex2Rgb($templateSetting->secondary_color);
        $dark_color = hex2Rgb($templateSetting->dark_color);
        $white_color = hex2Rgb($templateSetting->white_color);


        $footer_link = FooterLink::where('position', 1)->get();
        $footer_link2 = FooterLink::where('position', 2)->get();

        return view('admin.setting.template.index', compact('templateSetting', 'main_color', 'secondary_color', 'dark_color', 'white_color', 'footer_link', 'footer_link2'));
    }

    public function update(TemplateSettingRequest $request, TemplateSetting $templateSetting, ImageService $imageService)
    {


        $inputs = $request->all();

        function hexToRgb($hex, $alpha = false)
        {
            $hex      = str_replace('#', '', $hex);
            $length   = strlen($hex);
            $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
            $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
            $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
            if ($alpha) {
                $rgb['a'] = $alpha;
            }
            return $rgb['r'] . ' ' . $rgb['g'] . ' ' . $rgb['b'];
        }
        $inputs['main_color'] = hexToRgb($inputs['main_color']);
        $inputs['secondary_color'] = hexToRgb($inputs['secondary_color']);
        $inputs['dark_color'] = hexToRgb($inputs['dark_color']);
        $inputs['white_color'] = hexToRgb($inputs['white_color']);
        $inputs['show_students'] = (isset($inputs['show_students']) && $inputs['show_students'] == 'on') ? 1 : 0;
        $inputs['show_social_user'] = (isset($inputs['show_social_user']) && $inputs['show_social_user'] == 'on') ? 1 : 0;
        $inputs['show_rate'] = (isset($inputs['show_rate']) && $inputs['show_rate'] == 'on') ? 1 : 0;
        $inputs['show_info'] = (isset($inputs['show_info']) && $inputs['show_info'] == 'on') ? 1 : 0;


        $inputs['show_comments_index'] = (isset($inputs['show_comments_index']) && $inputs['show_comments_index'] == 'on') ? 1 : 0;
        $inputs['show_vipPost_index'] = (isset($inputs['show_vipPost_index']) && $inputs['show_vipPost_index'] == 'on') ? 1 : 0;
        $inputs['show_courseFree_index'] = (isset($inputs['show_courseFree_index']) && $inputs['show_courseFree_index'] == 'on') ? 1 : 0;
        $inputs['show_plan_index'] = (isset($inputs['show_plan_index']) && $inputs['show_plan_index'] == 'on') ? 1 : 0;


        if ($request->hasFile('logo')) {
            if (!empty($templateSetting->logo)) {
                $imageService->deleteImage($templateSetting->logo);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'templateSetting');
            $imageService->setImageName('logo');
            $result = $imageService->save($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.setting.template.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        }
        if ($request->hasFile('image_auth')) {
            if (!empty($templateSetting->image_auth)) {
                $imageService->deleteImage($templateSetting->image_auth);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'templateSetting');
            $imageService->setImageName('image_auth');
            $result = $imageService->save($request->file('image_auth'));
            if ($result === false) {
                return redirect()->route('admin.setting.template.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image_auth'] = $result;
        }

        $file = public_path('customer' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css');

        if (!file_exists($file)) {
            return redirect()->back()->with('swal-error', 'در ویرایش اطلاعات مشکلی به وجود امده است');
        }
        $templateSetting->update($inputs);
        $newLines = '--main-color:' . $inputs['main_color'] . ';';
        $oldLines = '--main-color:' . Cache::get('templateSetting')['main_color'] . ';';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        $newLines = '--secondary-color:' . $inputs['secondary_color'] . ';';
        $oldLines = '--secondary-color:' . Cache::get('templateSetting')['secondary_color'] . ';';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);

        $newLines = '--dark-color:' . $inputs['dark_color'] . ';';
        $oldLines = '--dark-color:' . Cache::get('templateSetting')['dark_color'] . ';';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        $newLines = '--white-color:' . $inputs['white_color'] . ';';
        $oldLines = '--white-color:' . Cache::get('templateSetting')['white_color'] . ';';
        $fileContent = file_get_contents($file);
        $fileContent = str_replace($oldLines, $newLines, $fileContent);
        file_put_contents($file, $fileContent);
        Cache::clear();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش تنظیمات قالب وبسایت',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.setting.template.index')->with('swal-success', 'تنظیمات سایت  شما با موفقیت ویرایش شد');
    }
    public function footer()
    {
        $templateSetting = TemplateSetting::first();
        $footer_link = FooterLink::where('position', 1)->get();
        $footer_link2 = FooterLink::where('position', 2)->get();
        return view('admin.setting.template.footer', compact('footer_link', 'footer_link2', 'templateSetting'));
    }
    public function footerUpdate(TemplateSettingRequest $request)
    {
        $inputs = $request->all();
        foreach (FooterLink::all() as $link) {
            $link->delete();
        }
        if ($request->link_title && $request->link_href) {
            $metas = array_combine($request->link_title, $request->link_href);
            foreach ($metas as $key => $value) {
                if (!empty($key)) {
                    FooterLink::create([
                        'title' => $key,
                        'link' => $value ?? '',
                        'position' => 1
                    ]);
                }else{
                    return redirect()->back()->with('swal-error','عنوان لینک نمیتواند خالی باشد');
                }
            }
        }
        if ($request->link_title2 && $request->link_href2) {
            $metas2 = array_combine($request->link_title2, $request->link_href2);
            foreach ($metas2 as $key => $value) {
                if (!empty($key)) {
                    FooterLink::create([
                        'title' => $key,
                        'link' => $value ?? '',
                        'position' => 2
                    ]);
                }else{
                    return redirect()->back()->with('swal-error','عنوان لینک نمیتواند خالی باشد');

                }
            }
        }

        $templateSetting = TemplateSetting::first();
        $templateSetting->update([
            'about_footer' => $request->about_footer,
            'copyright' => $request->copyright,
            'link_instagram' => $request->link_instagram,
            'link_telegram' => $request->link_telegram,
            'footer_title_link' => $request->footer_title_link,
            'footer_title_link2' => $request->footer_title_link2,
            'icon_html' => $request->icon_html
        ]);

        Cache::clear();
        Log::create([
            'user_id' => auth()->user()->id,
            'description' => 'ویرایش تنظیمات قالب وبسایت',
            'ip' => $request->ip(),
            'os' => $request->header('user-Agent')
        ]);
        return redirect()->route('admin.setting.template.footer')->with('swal-success', 'تنظیمات فوتر با موفقیت تغییر کرد');
    }
    
    function logoutUserSessions($userId)
{
    $path = storage_path('framework/sessions');
    $files = File::allFiles($path);

    foreach ($files as $file) {
        $contents = File::get($file->getRealPath());

        if (strpos($contents, 'login_web_' . $userId) !== false) {
            File::delete($file->getRealPath());
        }
    }
}
}
