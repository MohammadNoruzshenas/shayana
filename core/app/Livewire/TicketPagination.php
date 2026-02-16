<?php

namespace App\Livewire;

use App\Models\Ticket\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
class TicketPagination extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.ticket-pagination', [
            'tickets' =>  Ticket::where(['user_id'=> Auth::user()->id,'ticket_id' => null])->latest()->paginate(5),
        ]);
    }
}


