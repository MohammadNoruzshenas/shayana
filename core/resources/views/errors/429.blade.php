@extends('customer.layouts.master')
@section('content')
<section class="container content lg:blur-0">

    <div class="flex flex-col items-center justify-center w-full gap-5 py-5">
        <br>
       <h1 class="text-2xl font-bold text-main lg:text-3xl ">تعداد درخواست زیادی ارسال کردید لطفا چند دقیقه دیگه تلاش کنید</h1>
       <a href="{{ route('customer.home') }}"
       class="  text-white bg-main/70 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center  flex items-center gap-2 justify-center"
       type="button">
       برگشت به خانه
   </a>
    </div>

</section>
@endsection
