@extends('admin.layouts.master')
@section('head-tag')
<title>دوره ها</title>
@endsection

<style>
/* Hide the additional buttons initially */
.collapse {
    z-index: 10;
    display: none;
    flex-direction: column;
    position: absolute;
    top: 25px;
    left: 25px;
    background: rgb(17, 17, 17);
    justify-content: center;
    align-items: end;
    width: 150px;
    border-radius: 10px;
    padding: 10px;
    gap: 2px;

}
.collapse a {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding:3px;
    border-radius: 5px;
}
.collapse a:hover{
    background-color:#a1a1aa;
}

.show-more-btn {
    border: none;
    background-color: transparent;
    cursor: pointer;
    transform: translateY(6px);

}

.show-more-btn:focus {
    outline: none;
}
</style>
@section('breadcrumb')
<li><a href="{{ route('admin.market.course.index') }}" title="دوره ها">دوره ها</a></li>
@endsection
@section('content')
<div class="tab__box">
    <div class="tab__items">
        <a class="tab__item @if(request('confirmation_status') == null) is-active @endif" href="{{ route('admin.market.course.index') }}">لیست دوره ها</a>
        <a class="tab__item @if(request('confirmation_status') == 1) is-active @endif" href="{{ route('admin.market.course.index') }}?confirmation_status=1">دوره های تایید
            شده</a>

        <a class="tab__item @if(request('confirmation_status') == 2) is-active @endif" href="{{ route('admin.market.course.index') }}?confirmation_status=2">دوره های تایید
            نشده</a>
        {{-- <a class="tab__item" href="{{ route('admin.market.course.index') }}?confirmation_status=3">ویرایش شده درحال
        بررسی</a> --}}
        <a class="tab__item @if(request('confirmation_status') == 3) is-active @endif" href="{{ route('admin.market.course.index') }}?confirmation_status=3">بررسی نشده</a>

        @permission('create_course')
        <a class="tab__item " href="{{ route('admin.market.course.create') }}">ایجاد دوره جدید</a>
        @endpermission

    </div>
</div>


<div class="bg-white padding-20">
    <div class="t-header-search">
        <form action="">
            <div class="t-header-searchbox font-size-13">
                <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در دوره ها">
                <div class="t-header-search-content ">
                    <input type="text" class="text" value="{{ request()->title }}" name="title"
                        placeholder="عنوان دوره">
                    <input type="text" class="text" value="{{ request()->email }}" name="email"
                        placeholder="ایمیل مدرس">

                    <button type="submit" class="btn btn-webamooz_net">جستجو</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table__box">
    <table class="table"style="background: #252A34 !important;">

        <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>شناسه</th>
                <th>عنوان</th>
                <th>تصویر</th>
                <th>مدرس دوره</th>
                <th>قیمت (تومان)</th>
                <th>قیمت نهایی (تومان)</th>
                <th>نوع دریافت</th>

                <th>سود مدرس</th>
                <th>جزئیات</th>
                <th>تعداد دانشجویان</th>
                <th>وضعیت تایید</th>
                <th>وضعیت دوره</th>
                <th>عملیات</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($courses as $course)
            <tr role="row">
                <td><a href="">{{ $loop->iteration }}</a></td>
                <td>{{ $course->title }}</td>
                <td>
                    <img src="{{ asset($course->image) }}" alt="" width="100" height="50">
                </td>
                <td><a
                        href="{{ route('admin.user.user-information.index', $course->teacher) }}">{{ $course->teacher->FullName }}</a>
                </td>
                <td>
                        @if($course->types == 2)
                        {{'اشتراک ویژه'}}
                        @else
                        {{ $course->price == 0 ? 'رایگان' : priceFormat($course->price) . ' تومان' }}
                        @endif

                     </td>
                <td>{{$course->final_course_price_value}}</td>
                     <td>
                        {{ $course->get_course_option == 0 ? 'دانلودی' : 'اسپات پلیر' }}</p>
                    </td>

                <td>{{ $course->percent }}%</td>

                <td><a href="{{ route('admin.market.course.details', $course->id) }}" class="color-2b4a83">مشاهده</a>
                </td>
                <td><a class="color-2b4a83"
                        href="{{ route('admin.market.course.showStudentsCourse', $course) }}">{{ count($course->students) }}</a>
                </td>
                <td @if ($course->confirmation_status == 0) class="text-warning" @endif
                    @if ($course->confirmation_status == 1) class="text-success" @endif
                    @if ($course->confirmation_status == 2) class="text-danger" @endif
                    @if ($course->confirmation_status == 3) class="text-warning" @endif>
                    {{ $course->confirmation_status_value }}
                </td>
                <td @if ($course->status == 1) class="text-success" @endif
                    @if ($course->status == 2) class="text-warning"
                    @else
                    class="text-danger" @endif>
                    {{ $course->status_value }}
                <td>
                    <form action="{{ route('admin.market.course.destory', $course->id) }}" method="post"
                        class="expandable-form" style="position: relative;">
                        @csrf


                        <div class="collapse" id="showMoreButtons{{ $loop->index }}" style="display:none; ">
                            @method('delete')
                            @permission('delete_course')
                            <a href="" class="item-delete  delete" style="" title="حذف">
                            حذف<i class="fa-solid fa-trash"></i></a>
                            @endpermission

                            @permission('edit_course')
                            <a href="{{ route('admin.market.course.edit', $course->id) }}" class="item-edit "
                                title="ویرایش">ویرایش<i class="fa-solid fa-edit"></i></a>
                            @endpermission
                            <a href="{{ route('customer.course.singleCourse', $course->slug) }}" target="_blank"
                                class="item-eye " title="مشاهده"> مشاهده<i class="fa-solid fa-eye"></i></a>
                            @permission('manage_course')
                            <a href="{{ route('admin.market.course.rejection', $course->id) }}"
                                class="item-reject " title="رد">رد<i class="fa-solid fa-xmark"></i></a>
                            <a href="{{ route('admin.market.course.lockCourse', $course->id) }}"
                                class="item-lock " title="قفل دوره">قفل دوره<i class="fa-solid fa-lock"></i></a>
                            <a href="{{ route('admin.market.course.confirmation', $course->id) }}"
                                class="item-confirm " title="تایید">تایید<i class="fa-solid fa-check"></i></a>
                            @endpermission
                            @permission('manage_financial')
                            <a href="{{ route('admin.market.course.statistics', $course->id) }}"
                                class="item-confirm " title="امار">امار<i class="fa-solid fa-chart-bar"></i></a>
                            @endpermission
                        </div>

                        <button class="show-more-btn" type="button"
                            onclick="toggleShowMoreButtons('{{ $loop->index }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="#fff" width="24px  " height="24px    ">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</div>
<!-- paginate -->
{{ $courses->links('admin.layouts.paginate') }}
<!-- endpaginate -->

</div>
@endsection
@section('script')
<script>
    function toggleShowMoreButtons(index) {
        var showMoreButtons = document.getElementById("showMoreButtons" + index);

        if (showMoreButtons.style.display === "none") {
            showMoreButtons.style.display = "flex";
        } else {
            showMoreButtons.style.display = "none";
        }
    }
    </script>
    <script>

        $(document).ready(function () {
            var element = $('.' + 'delete');

            element.on('click', function(e){

                e.preventDefault();

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass:{
                        confirmButton : 'btn btn-success mx-2',
                        cancelButton : 'btn btn-danger mx-2'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                         title: 'آیا از حذف کردن داده مطمن هستید؟',
                            text: "شما میتوانید درخواست خود را لغو نمایید",
                             icon: 'warning',
                             showCancelButton: true,
                            confirmButtonText: 'بله داده حذف شود.',
                            cancelButtonText: 'خیر درخواست لغو شود.',
                            reverseButtons: true
                            }).then((result) => {

                                if(result.value == true){
                                    $(this).parent().parent().submit();
                                }
                                else if(result.dismiss === Swal.DismissReason.cancel){
                                    swalWithBootstrapButtons.fire({
                                             title: 'لغو درخواست',
                                             text: "درخواست شما لغو شد",
                                             icon: 'error',
                                             confirmButtonText: 'باشه.'
                                    })
                                }

                            })

            })

        })


    </script>
@endsection
