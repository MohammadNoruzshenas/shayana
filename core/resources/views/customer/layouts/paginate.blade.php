<br>
@if($paginator->hasPages())

<div class="pagination">
    @if ($paginator->onFirstPage())
    @else
	<a class="dark:bg-dark dark:text-white/80" href="{{$paginator->previousPageUrl()}}" title="first page"><svg fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg></a>
    @endif



    @foreach ($elements as $element)
    @if (is_string($element))
        <li class="disabled"><span>{{ $element }}</span></li>
    @endif
    @if (is_array($element))
        @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
                <a href="#"  class="dark:text-white/80 " style="color:#fff ;	background-color: rgb(var(--main-color));" class="page-active">{{ $page }}</a>
            @else
                <a href="{{ $url }}" class="dark:bg-dark dark:text-white/80">{{ $page }}</a>
            @endif
        @endforeach
    @endif
@endforeach


@if($paginator->hasMorePages())
<a class="dark:bg-dark dark:text-white/80" href="{{$paginator->nextPageUrl()}}" title="next page"><svg fill="currentColor"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></a>
@endif

</div>
@endif


