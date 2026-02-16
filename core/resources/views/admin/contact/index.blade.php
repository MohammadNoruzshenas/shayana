@extends('admin.layouts.master')
@section('breadcrumb')
    <li><a href="{{ route('admin.contact.index') }}">تماس ها</a></li>
@endsection
@section('content')
    <div class="tab__box">

    </div>
    <table class="table">

        <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>#</th>
                <th>نام و نام خانوادگی </th>
                <th>عنوان </th>
                <th>وضعیت </th>
                <th>شماره </th>
                <th>ایمیل</th>
                <th>عملیات</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $contact->full_name }}</td>
                    <td>{{ $contact->title }}</td>
                    <td
                        class="
                            @if ($contact->status == 0) text-danger @endif
                            @if ($contact->status == 1) text-blue @endif
                            @if ($contact->status == 2) text-success @endif
                        ">
                        {{ $contact->status_value }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->email }}</td>


                    <td>
                        <a href="{{ route('admin.contact.show', $contact) }}" class="item-eye mlg-15"
                            title="مشاهده"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    </div>
    </div>
    <!-- paginate -->
    {{ $contacts->links('admin.layouts.paginate') }}
    <!-- endpaginate -->
    </div>
@endsection

