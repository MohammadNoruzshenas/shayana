@foreach ($menus->where('parent', null) as $menu)
    @if ($menu->children->count() > 0)
        <li class="relative cursor-pointer hover:text-main group">
            <a class="flex items-center gap-1" href="{{ $menu->url }}">
                <span class="firstlevel">{{ $menu->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 duration-200 group-hover:rotate-180">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </a>
            @include('customer.layouts.subMenu')
        </li>
    @else
        <li class="cursor-pointer hover:text-main "><a href="{{ $menu->link() }}">{{ $menu->name }}</a></li>
    @endif
@endforeach
