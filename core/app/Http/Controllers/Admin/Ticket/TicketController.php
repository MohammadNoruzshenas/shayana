<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Http\Services\File\FileService;
use App\Jobs\SendEmailAnswerTicket;
use App\Models\Setting\NotificationSetting;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if (!$this->user->can('manage_ticket')) {
                abort(403);
            }
            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = request('status');
        if(isset($status))
        {
            $tickets = Ticket::where('ticket_id',null)->where('status',$status == 3 ? 0 : $status)->latest()->with('children',function ($q){
                $q->orderBy('created_at','desc');
            })->paginate(20);
        }else{
            $tickets = Ticket::where('ticket_id',null)->latest()->with('children',function ($q){
                $q->orderBy('created_at','desc');
            })->paginate(20);
        }
        $tickets->appends(request()->query());

        return view('admin.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {

        return view('admin.ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function answer(TicketRequest $request, Ticket $ticket,FileService $fileService)
    {

        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 1;
        $inputs['user_id'] = auth()->user()->id;
        $inputs['ticket_id'] = $ticket->id;
        DB::transaction(function () use ($inputs,$fileService,$request) {
        $answerticket = Ticket::create($inputs);
        if ($request->hasFile('file')) {
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            $result = $fileService->moveToPublic($request->file('file'));
            // $result = $fileService->moveToStorage($request->file('file'));
            $fileFormat = $fileService->getFileFormat();
            $inputs['ticket_id'] = $answerticket->id;
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
            $inputs['user_id'] = auth()->user()->id;
            $file = TicketFile::create($inputs);
        }
        });
        Ticket::whereId($ticket->id)->update(['status' => $inputs['status']]);

        $notificationSetting = NotificationSetting::where('name','tickets')->first();
        if($notificationSetting->status == 1)
        {
           // SendEmailAnswerTicket::dispatch($ticket->user_id,$ticket->subject); //todo deactivate jobs
        }
        return redirect()->route('admin.ticket.index')->with('swal-success', 'پاسخ شما با موفقیت ثبت شد');
    }


    public function change(Ticket $ticket){
        $ticket->status = $ticket->status == 0 ? 1 : 0;
        $result = $ticket->save();
        return redirect()->route('admin.ticket.index')->with('swal-success', 'تغییر شما با موفقیت حذف شد');
    }
}
