@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.log.index') }}">لاگ ها</a></li>
@endsection

@section('content')

    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
        <div class="t-header-search">
            <form action="" method="get">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box" placeholder="جستجوی در ">
                    <div class="t-header-search-content ">
                        <input type="text" class="text" name="email" value="{{ request('email') }}"
                            placeholder="ایمیل کاربر">

                        <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                    </div>
                </div>
            </form>

        </div>

        <form action="{{ route('admin.log.destory') }}" method="post">
            @csrf
            @method('delete')
            @if($canDeleteLog)
            <button class="btn delete-btn">پاک کردن لاگ ها</button>
            <p>رکورد های قابل پاک کردن:  {{$canDeleteLog}}</p>
            @endif

        </form>

    </div>

    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>ایمیل</th>
                    <th>توضیحات</th>
                    <th>ای پی</th>
                    <th>زمان</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr role="row" class="">
                        <td><a href="">{{ $loop->iteration }}</a></td>
                        <td><a href="">{{ $log->user->email }}</a></td>
                        <td>{{ Str::limit($log->description, 20, '...') }}</td>
                        <td>{{ $log->ip}}</td>
                        <td>{{\Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                        <td>
                                <a href="{{ route('admin.log.show',$log) }}"
                                    class="item-eye mlg-15" title="مشاهده">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
         <!-- paginate -->
         {{ $logs->links('admin.layouts.paginate') }}
         <!-- endpaginate -->
@endsection

