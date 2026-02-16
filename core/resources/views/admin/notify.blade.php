@extends('admin.layouts.master')
@section('head-tag')
<title>پیشخوان - اطلاع رسانی</title>
    <link rel="stylesheet" href="{{ asset('dashboard/css/dashboard.css') }}">
@endsection
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="row">  <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">دوره های در انتظار تایید
                </div>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>بنر</th>
                                <th>نام</th>
                                <th>قیمت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($courses as $course)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($course->image) }}" alt="" width="100"
                                            height="50">
                                    </td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">

                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{ $course->title }}</div>
                                                    <div class="widget-subheading opacity-7">
                                                        {{ $course->teacher->full_name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">

                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">
                                                        @if ($course->types == 2)
                                                            {{ 'اشتراک ویژه' }}
                                                        @else
                                                            {{ $course->price == 0 ? 'رایگان' : priceFormat($course->price) . ' تومان' }}
                                                        @endif
                                                    </div>
                                                    @if ($course->price != 0)
                                                        <div class="widget-subheading opacity-7">
                                                            سود مدرس : {{ $course->percent }}%
                                                        </div>
                                                    @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.market.course.rejection', $course->id) }}"
                                            class="item-reject" title="رد"><i class="fa-solid fa-xmark"></i></a>
                                        <a href="{{ route('admin.market.course.confirmation', $course->id) }}"
                                            class="item-confirm mr-1" title="تایید"><i
                                                class="fa-solid fa-check"></i></a>
                                        <a href="{{ route('customer.course.singleCourse', $course->slug) }}"
                                            target="_blank" class="item-eye mr-1" title="مشاهده"> <i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('admin.market.course.edit', $course->id) }}"
                                            class="item-edit mr-1" title="ویرایش"><i
                                                class="fa-solid fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<div class="row">
<div class="col-md-12 col-lg-6">
    <div class="main-card mb-3 card">
        <div class="card-header">
            جلسات در انتظار تایید
        </div>
        <div class="table-responsive">
            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>عنوان</th>
                        <th>سرفصل</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lessions as $lession)
                        <tr>
                            <td class="text-center text-muted">{{ $loop->iteration }}</td>


                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left">

                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">{{ $lession->title }}</div>
                                            <div class="widget-subheading opacity-7">
                                                {{ $lession->time }} دقیقه </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left">

                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">{{ $lession->season->title }}</div>
                                            <div class="widget-subheading opacity-7">
                                                {{ $lession->course->title }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>

                                @if(auth()->user()->can('delete_lession') || auth()->user()->can('manage_course'))
                                <form
                                    action="{{ route('admin.market.course.lession.destory', ['course' => $lession->course, 'lession' => $lession->id,'season' => $lession->season]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="item-delete mlg-15 delete" data-id="1" title="حذف">
                                        <li class="fa-solid fa-trash"></li>
                                    </button>
                                    @endif
                                    @if (auth()->user()->can('manage_course') || auth()->user()->can('own_course'))
                                    <a href="{{ route('admin.market.course.lession.reject', ['course' => $lession->course, 'lession' => $lession]) }}"
                                        class="item-reject mlg-15" title="رد">
                                        <li class="fa-solid fa-xmark"></li>
                                    </a>
                                    <a href="{{ route('admin.market.course.lession.pending', ['course' => $lession->course,'season' => $lession->season, 'lession' => $lession->id]) }}"
                                        class="item-lock mlg-15" title="قفل ">
                                        <li class="fa-solid fa-lock"></li>
                                    </a>
                                    <a href="{{ route('admin.market.course.lession.accept', ['course' => $lession->course, 'lession' => $lession,'season' => $lession->season]) }}"
                                        class="item-confirm mlg-15" title="تایید">
                                        <li class="fa-solid fa-check"></li>
                                    </a>
                                    @endif
                                    @if(auth()->user()->can('edit_lession') || auth()->user()->can('manage_course'))
                                    <a href="{{ route('admin.market.course.lession.edit', ['course' => $lession->course, 'lession' => $lession->id]) }}"
                                        class="item-edit " title="ویرایش">
                                        <li class="fa-solid fa-edit"></li>
                                    </a>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="col-md-12 col-lg-6">
    <div class="main-card mb-3 card">
        <div class="card-header">
            سرفصل های در انتظار تایید
        </div>
        <div class="table-responsive">
            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>نام</th>
                        <th>دوره</th>

                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seasons as $season)

                        <tr>
                            <td class="text-center text-muted">{{ $loop->iteration }}</td>
                            <td class="text-center text-muted">{{ $season->title }}</td>

                            <td class="text-center text-muted">{{ $season->course->title }}</td>

                            <td>
                                @if (auth()->user()->can('delete_session') || auth()->user()->can('manage_course'))
                                    <form
                                        action="{{ route('admin.market.course.session.destroy', ['course' => $season->course->id, 'season' => $season->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="item-delete mlg-15 delete" title="حذف">
                                            <li class="fa-solid fa-trash"></li>
                                        </button>
                                @endif
                                @if (auth()->user()->can('own_course') || auth()->user()->can('manage_course'))
                                    @if ($season->confirmation_status == 1)
                                        <a href="{{ route('admin.market.course.session.reject', ['course' => $season->course->id, 'season' => $season->id]) }}"
                                            class="item-reject mlg-15" title="رد">
                                            <li class="fa-solid fa-xmark"></li>
                                        </a>
                                    @elseif ($season->confirmation_status == 2)
                                        <a href="{{ route('admin.market.course.session.accept', ['course' => $season->course->id, 'season' => $season->id]) }}"
                                            class="item-confirm mlg-15" title="تایید">
                                            <li class="fa-solid fa-check"></li>
                                            <a href="{{ route('admin.market.course.session.reject', ['course' => $season->course->id, 'season' => $season->id]) }}"
                                                class="item-reject mlg-15" title="رد">
                                                <li class="fa-solid fa-xmark"></li>
                                        </a>
                                        @else
                                        <a href="{{ route('admin.market.course.session.accept', ['course' => $season->course->id, 'season' => $season->id]) }}"
                                            class="item-confirm mlg-15" title="تایید">
                                            <li class="fa-solid fa-check"></li>
                                    @endif
                                @endif
                                @if (auth()->user()->can('edit_lession') || auth()->user()->can('manage_course'))
                                    <a href="{{ route('admin.market.course.session.edit', ['course' => $season->course->id, 'season' => $season->id]) }}"
                                        class="item-edit " title="ویرایش">
                                        <li class="fa-solid fa-edit"></li>
                                    </a>
                                @endif

                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        پادکست های در انتظار تایید
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>بنر</th>
                                    <th>نام</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($podcasts as $podcast)
                                    <tr>
                                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset($podcast->image) }}" alt="" width="100"
                                                height="50">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">

                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">{{ $podcast->title }}</div>
                                                        <div class="widget-subheading opacity-7">
                                                            {{ $podcast->podcaster->full_name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @permission('delete_podcast')
                                                <form action="{{ route('admin.content.podcast.destory', $podcast->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="item-delete mlg-15 delete" style="" title="حذف">
                                                        <li class="fa-solid fa-trash"></li>
                                                    </button>
                                                @endpermission
                                                <a href="{{ route('customer.singlePodcast', $podcast->slug) }}" target="_blank"
                                                    class="item-eye mlg-15" title="مشاهده">
                                                    <li class="fa-solid fa-eye"></li>
                                                </a>
                                                @permission('manage_podcast')
                                           @if($podcast->confirmation_status == 1)
                                                    <a href="{{ route('admin.content.podcast.reject', $podcast->id) }}" class="item-reject mlg-15"
                                                        title="رد">
                                                        <li class="fa-solid fa-xmark"></li>
                                                    </a>
                                                    @elseif ($podcast->confirmation_status == 2)
                                                    <a href="{{ route('admin.content.podcast.reject', $podcast->id) }}" class="item-reject mlg-15"
                                                        title="رد">
                                                        <li class="fa-solid fa-xmark"></li>
                                                    </a>
                                                    <a href="{{ route('admin.content.podcast.accept', $podcast->id) }}" class="item-confirm mlg-15"
                                                        title="تایید">
                                                        <li class="fa-solid fa-check"></li>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('admin.content.podcast.accept', $podcast->id) }}" class="item-confirm mlg-15"
                                                        title="تایید">
                                                        <li class="fa-solid fa-check"></li>
                                                    </a>
                                                    @endif
                                                @endpermission
                                                @permission('edit_podcast')
                                                <a href="{{ route('admin.content.podcast.edit', $podcast->id) }}" class="item-edit "
                                                    title="ویرایش">
                                                    <li class="fa-solid fa-edit"></li>
                                                </a>
                                                @endpermission
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-12 col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-header">مقاله های در انتظار تایید
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>بنر</th>
                                    <th>نام</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset($post->image) }}" alt="" width="100"
                                                height="50">
                                        </td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <div class="widget-content-left">

                                                        </div>
                                                    </div>
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">{{ $post->title }}</div>
                                                        <div class="widget-subheading opacity-7">
                                                            {{ $post->author->full_name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @permission('delete_post')
                                                <form action="{{ route('admin.content.post.destory', $post->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="item-delete mlg-15 delete" style="" title="حذف">
                                                        <li class="fa-solid fa-trash"></li>
                                                    </button>
                                                @endpermission
                                                <a href="{{ route('customer.singlePost', $post->slug) }}"
                                                    target="_blank" class="item-eye mlg-15" title="مشاهده">
                                                    <li class="fa-solid fa-eye"></li>
                                                </a>
                                                @permission('manage_post')
                                                    @if ($post->confirmation_status == 1)
                                                        <a href="{{ route('admin.content.post.reject', $post->id) }}"
                                                            class="item-reject mlg-15" title="رد">
                                                            <li class="fa-solid fa-xmark"></li>
                                                        </a>
                                                    @elseif ($post->confirmation_status == 2)
                                                        <a href="{{ route('admin.content.post.reject', $post->id) }}"
                                                            class="item-reject mlg-15" title="رد">
                                                            <li class="fa-solid fa-xmark"></li>
                                                            <a href="{{ route('admin.content.post.accept', $post->id) }}"
                                                                class="item-confirm mlg-15" title="تایید">
                                                                <li class="fa-solid fa-check"></li>
                                                            </a>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.content.post.accept', $post->id) }}"
                                                            class="item-confirm mlg-15" title="تایید">
                                                            <li class="fa-solid fa-check"></li>
                                                        </a>
                                                    @endif
                                                @endpermission
                                                @permission('edit_post')
                                                    <a href="{{ route('admin.content.post.edit', $post->id) }}"
                                                        class="item-edit " title="ویرایش">
                                                        <li class="fa-solid fa-edit"></li>
                                                    </a>
                                                @endpermission
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
    <script src="{{ asset('dashboard/js/main-dashboard.js') }}"></script>

@endsection
