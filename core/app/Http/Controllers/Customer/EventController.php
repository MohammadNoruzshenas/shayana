<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('customer.event.show', compact('event'));
    }
}
