
<div>
        @foreach ($tickets as $ticket)
        <br>
        <div class="flex items-center justify-between pb-3 border-b border-b-main/20">
            <span class="text-xl font-medium dark:text-white/80"><a href="{{ route('customer.profile.ticket.show',$ticket) }}">{{ $ticket->subject }}</a></span>
            <span class="px-5 py-1 text-white  rounded-xl  @if ($ticket->status == 1) bg-green-400 @endif @if ($ticket->status == 2)
                bg-yellow-400 @endif
                @if($ticket->status == 0)
                bg-red-400 @endif">{{ $ticket->status_value }}</span>
        </div>

       @endforeach
      </tbody>
    </table>
    {{ $tickets->links('vendor.livewire.tailwind') }}
</div>

     {{--
  <!-- paginate -->
  {{ $tickets->links('vendor.livewire.tailwind') }}
  <!-- endpaginate --> --}}
