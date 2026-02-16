@extends('customer.layouts.master')
@section('head-tag')
<title>{{$user->full_name}}</title>
@endsection
@section('content')
<section class="container mt-10 content lg:blur-0">
    <div class="flex flex-col justify-between gap-5 lg:flex-row my-5 py-16 ">
        <div class="flex flex-col items-center w-full p-6  lg:w-3/12 shadow-lg rounded-3xl dark:bg-dark  dark:shoadow-none dark:text-white/80  h-min gap-4 bg-gray"
            data-aos="fade-left">
            @if ($user->image)
            <img src="{{ asset($user->image) }}" class="rounded-full h-24 w-24 ring-2 ring-gray-300 dark:ring-gray-500"
                alt="avatar">
            @endif

            <h2 class="text-xl font-bold text-main"> {{ $user->full_name }} </h2>
            <span class="text-[#7D7D7D] dark:text-white/80">{{ $user->headline }}</span>
            <p>{{ $user->bio }}</p>

            @if (cache('templateSetting')['show_social_user'])
            <div class="flex gap-2">




                @if ($user->instagram)
                <!-- Instagram -->
                <a href="https://instagram.com/{{$user->instagram}}">
                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                        class="mb-2 inline-block rounded-xl px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                        style="background-color: #c13584">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </button>
                </a>
                @endif

                @if ($user->telegram)
                <!-- Telegram -->
                <a href="https://t.me/{{$user->telegram}}">
                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                        class="mb-2 inline-block rounded-xl px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                        style="background-color: #0088cc">
                        <svg class="h-4 w-4" fill="currentColor" viewbox="0 0 24 24" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            xml:space="preserve" xmlns:serif="http://www.serif.com/"
                            style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                            <path id="telegram-1"
                                d="M18.384,22.779c0.322,0.228 0.737,0.285 1.107,0.145c0.37,-0.141 0.642,-0.457 0.724,-0.84c0.869,-4.084 2.977,-14.421 3.768,-18.136c0.06,-0.28 -0.04,-0.571 -0.26,-0.758c-0.22,-0.187 -0.525,-0.241 -0.797,-0.14c-4.193,1.552 -17.106,6.397 -22.384,8.35c-0.335,0.124 -0.553,0.446 -0.542,0.799c0.012,0.354 0.25,0.661 0.593,0.764c2.367,0.708 5.474,1.693 5.474,1.693c0,0 1.452,4.385 2.209,6.615c0.095,0.28 0.314,0.5 0.603,0.576c0.288,0.075 0.596,-0.004 0.811,-0.207c1.216,-1.148 3.096,-2.923 3.096,-2.923c0,0 3.572,2.619 5.598,4.062Zm-11.01,-8.677l1.679,5.538l0.373,-3.507c0,0 6.487,-5.851 10.185,-9.186c0.108,-0.098 0.123,-0.262 0.033,-0.377c-0.089,-0.115 -0.253,-0.142 -0.376,-0.064c-4.286,2.737 -11.894,7.596 -11.894,7.596Z" />
                        </svg>
                    </button>
                </a>
                @endif



            </div>
            @endif


        </div>
        <div class="flex flex-col items-center w-full lg:w-9/12   h-min "
            data-aos="fade-down">
            
        
        
        <div class="flex  w-full  gap-3 gap-y-14 flex-col lg:flex-row flex-wrap  w-full   rounded-3xl "
            data-aos="fade-down">
            @foreach ($user->courseTeacher->where('confirmation_status',1) as $course)
            <div
            class="relative top-10 flex flex-col items-center justify-center w-full  shadow-lg rounded-3xl dark:bg-dark   dark:shoadow-none lg:w-[32%]  ">
            <div class="relative flex items-center justify-center w-11/12 h-40 -top-10">
                <img src="{{ asset($course->image) }}" class="absolute z-50 object-cover w-full h-full rounded-3xl"
                    alt="">
                <div style="color:{{ $course->status_style_value }}"
                    class="absolute z-50 flex items-center gap-2 p-1 px-3 text-sm text-teal-500 bg-white rounded-lg left-4 bottom-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                    </svg>
                    {{ $course->status_value }}
                </div>

            </div>
            <div class="flex flex-col justify-start w-full gap-3 px-10 -mt-5 lg:px-3">
                <a href="{{ route('customer.course.singleCourse',$course->slug)}}">
                    <h3
                        class="pb-2 text-lg lg:text-xl font-bold border-b text-secondary dark:text-white/80 border-b-main/30 hover:text-main hover:font-bold dark:hover:text-main">
                        {{ $course->title }}</h3>
                </a>
                </h3>
                <div class="flex justify-between gap-3">
                    <a href="{{ route('customer.teacher', $course->teacher->username) }}">
                        <div class="flex items-center gap-2 text-main">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>

                            <span class="mt-1">{{ $course->teacher->full_name }}</span>
                        </div>
                    </a>
                    <div class="flex items-center gap-2 text-[#B6B6B6]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                            <path
                                d="M17.4168 9.49998C17.4168 13.87 13.8702 17.4166 9.50016 17.4166C5.13016 17.4166 1.5835 13.87 1.5835 9.49998C1.5835 5.12998 5.13016 1.58331 9.50016 1.58331C13.8702 1.58331 17.4168 5.12998 17.4168 9.49998Z"
                                stroke="#B6B6B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12.437 12.0175L9.98286 10.5529C9.55536 10.2996 9.20703 9.69002 9.20703 9.19127V5.94543"
                                stroke="#B6B6B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mt-1">{{ $course->formattedDuration() }}</span>
                    </div>
                </div>


                <div class="flex flex-wrap items-center justify-between w-full mt-10 mb-5">
                    <a class="px-4 py-2 text-sm font-bold text-white duration-200 bg-main/80 rounded-xl hover:bg-main hover:scale-95"
                        href="{{ route('customer.course.singleCourse',$course->slug)}}">
                        ثبت نام در دوره
                    </a>
                    <div class="flex flex-col items-start gap-1 ">

                        @if ($course->activeCommonDiscount())
                        <span
                            class="relative inline-block h-5 text-sm line-through  text-zinc-700 dark:text-slate-400 ">
                            {{ $course->course_price_value }}
                            @endif

                        </span>
                        <div class="text-xl text-main font-bold space-x-1.5 flex items-center">
                            <span class="">
                                {{ $course->final_course_price_value }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            @endforeach
        </div>


    </div>
        </div>

    </div>

    @if($user->courseTeacher->first())

  
    @endif


</section>
@endsection
