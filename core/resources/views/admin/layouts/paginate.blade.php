<br>
@if($paginator->hasPages())

<div class="pagination">
	<a href="{{$paginator->previousPageUrl()}}" title="first page"><svg fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg></a>
    {{-- @if ($paginator->onFirstPage())
    @else
     	<a href="{{ $paginator->previousPageUrl() }}" title="previous page"><svg fill="currentColor"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></a>
    @endif --}}


    @foreach ($elements as $element)
    @if (is_string($element))
        <span>...</span>
@endif
    @if (is_array($element))
    @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
            <a href="#" class="page-active">{{ $page }}</a>
        @else
            <a href="{{ $url }}">{{ $page }}</a>
        @endif
    @endforeach
@endif
@endforeach




<a href="{{$paginator->nextPageUrl()}}" title="next page"><svg fill="currentColor"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></a>


</div>
@endif



