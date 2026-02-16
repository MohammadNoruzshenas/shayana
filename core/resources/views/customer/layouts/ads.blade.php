@if ($ads)
<div
class="sticky flex items-center justify-center font-bold bg-white  shadow-lg top-50 rounded-2xl  dark:bg-dark dark:shadow-none h-auto text-secondary dark:text-white/80 " data-aos="fade-down">
<a class="w-full h-full" href="{{ $ads->link }}">
    <img class="w-full h-full rounded-2xl " src="{{ asset($ads->banner) }}" alt="">
</a>
</div>



@endif
