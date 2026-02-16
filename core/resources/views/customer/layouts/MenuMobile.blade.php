@foreach ($menus->where('parent', null) as $menu)
    @if ($menu->children->count() > 0)
        <div class="flex flex-col " id="accordion" data-accordion="collapse" data-active-classes="!text-main pb-5">
            <h2 id="accordion-heading-{{ $menu->id }}">
                <button type="button"
                    class="flex items-center justify-between w-full gap-2 font-medium text-secondary dark:text-white/80"
                    data-accordion-target="#accordion-body-{{ $menu->id }}" aria-expanded="false"
                    aria-controls="accordion-body-{{ $menu->id }}">
                    <span class="text-sm">{{ $menu->name }}</span>
                    <svg data-accordion-icon class="w-3 h-3  shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-body-{{ $menu->id }}" class="hidden px-4"
                aria-labelledby="accordion-heading-{{ $menu->id }}">
                <ul class="flex flex-col gap-3 text-sm">
                    @foreach ($menu->children as $subMenu)
                        <li class="cursor-pointer hover:text-main "><a
                                href="{{ $subMenu->link() }}">{{ $subMenu->name }}</a></li>
                    @endforeach
                </ul>
            </div>

        </div>
    @else
        <li class="w-full cursor-pointer hover:text-main"><a href="{{ $menu->link() }}">{{ $menu->name }}</a></li>
    @endif
@endforeach
