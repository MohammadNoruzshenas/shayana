@extends('customer.layouts.master')
@section('head-tag')
<title>{{$page->title}}</title>

@endsection
@section('content')
<section class="container content lg:blur-0">
    <div class="flex items-center justify-between w-full my-7">
        <h1 class="text-lg font-bold lg:text-3xl text-secondary dark:text-white/80">{{ $page->title }}</h1>
        <a href="{{ route('customer.home') }}"
            class="flex items-center gap-2 text-lg font-bold lg:text-lg group text-main"> بازگشت
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                class="duration-200 rtl:rotate-180 group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none">
                <path d="M14.4302 5.92999L20.5002 12L14.4302 18.07" class="stroke-main" stroke="#4A6DFF"
                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M3.5 12H20.33" stroke="#4A6DFF" class="stroke-main" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <div class="flex flex-col justify-between h-auto gap-6 py-5 lg:flex-row">
        <div class="flex flex-col w-full gap-10">
            <div class="flex flex-col gap-10 p-5 bg-white  shadow-lg rounded-2xl  dark:bg-dark dark:shadow-none"
                data-aos="fade-up">
                <div class="flex flex-col gap-5 dark:text-white/80 text-secondary">
                    {!! $page->body !!}

                </div>
</section>

@endsection
