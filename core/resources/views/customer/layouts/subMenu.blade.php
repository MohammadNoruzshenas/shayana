<ul class="absolute top-0 left-0 z-10 hidden p-2 mt-5 bg-white rounded-lg shadow-lg w-44 min-w-max group-hover:block dark:bg-dark ">
    @foreach ($menu->children as $child)
        <a  href="{{ $child->link() }}">
        <li class="p-1 text-sm text-gray-600 whitespace-no-wrap rounded md:text-base hover:text-gray-800 dark:hover:text-gray-800 text-secondary dark:text-white/80 hover:bg-gray-200">
                <span class="">{{ $child->name }}</span>
        </li>
    </a>
    @endforeach
    </ul>
