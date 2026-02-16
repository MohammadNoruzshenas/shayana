<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Content\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::whereNull('parent_id')->paginate(20);
        return view('admin.contact.index', compact('contacts'));
    }
    public function show(Contact $contact)
    {
        $contact->update(['status' => 1]);
        return view('admin.contact.show', compact('contact'));
    }
    public function answer(Request $request, Contact $contact)
    {
        $inputs = $request->all();
        $inputs['title'] = $contact->title;
        $inputs['description'] = $request->description;
        $inputs['full_name'] = auth()->user()->full_name;
        $inputs['email'] = auth()->user()->email;
        $inputs['parent_id'] = $contact->id;
        Contact::create($inputs);
        Contact::whereId($contact->id)->update(['status' => 2, 'sned_message' => $inputs['send_message']]);
        if ($inputs['send_message'] == 1) {
            $smsService = new SmsService();
            $smsService->setTo(['0' . $contact->phone]);
            $smsService->setText($request->description);
            $smsService->setIsFlash(true);
            $messagesService = new MessageService($smsService);
            $messagesService->send();
        } else {
            $emailService = new EmailService();
            $title = 'پاسخی به تماس ' . $contact->title . ' داده شده ';
            $details = [
                'title' => $title,
                'body' => $contact->description
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', Cache::get('templateSetting')->title);
            $emailService->setSubject($title);
            $emailService->setTo($contact->email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
        }
        return redirect()->route('admin.contact.index')->with('swal-success', 'پاسخ شما با موفقیت ثبت شد');
    }
}
