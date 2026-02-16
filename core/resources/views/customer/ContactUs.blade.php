-@extends('customer.layouts.master')
@section('head-tag')
    <title>{{ $contactUs->title }}</title>
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <style>
         #map{
             height:400px;
         }
     </style>
@endsection
@section('content')
    <section class="container content lg:blur-0">
        <section id="contact">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20" data-aos="fade-up">
                <div class="mb-4">
                    <div class="mb-6 max-w-3xl text-center sm:text-center md:mx-auto md:mb-12">

                        <h2
                            class="font-heading mb-4 font-bold tracking-tight text-gray-900 dark:text-white text-3xl sm:text-5xl">
                            {{ $contactUs->title }}
                        </h2>
                        <p class="mx-auto mt-4 max-w-3xl text-xl text-gray-600 dark:text-slate-400">
                            {{ $contactUs->second_text }}
                        </p>
                    </div>
                </div>
                <div class="flex items-stretch justify-center mt-10">
                    <div class="grid md:grid-cols-2" data-aos="fade-up">
                        <div class="h-full pr-6">
                            <p class="mt-3 mb-5 text-justify text-gray-600 dark:text-slate-400">
                                {!! $contactUs->description !!}
                            </p>
                            <ul class="mb-6 md:mb-0">
{{--                                @if ($contactUs->address)--}}
{{--                                    <li class="flex">--}}
{{--                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"--}}
{{--                                                stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">--}}
{{--                                                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>--}}
{{--                                                <path--}}
{{--                                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">--}}
{{--                                                </path>--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                        <div class="mr-4 mb-4">--}}
{{--                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">--}}
{{--                                                آدرس ما--}}

{{--                                            </h3>--}}
{{--                                            <p class="text-gray-600 dark:text-slate-400">{!! $contactUs->address !!}</p>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
                                @if ($contactUs->instagram)
                                    <li class="flex">
                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">
<a class="dark:text-white/80" href="https://instagram.com/diyanasaam">
                      <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
<path d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"></path>
</svg>
                    </a>
                                        </div>
                                        <div class="mr-4 mb-4">
                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                              اینستاگرام
                                            </h3>
                                            <p class="text-gray-600 dark:text-slate-400">{!! $contactUs->instagram !!} </p>

                                        </div>
                                    </li>
                                @endif
                                                                @if ($contactUs->telegram)
                                    <li class="flex">
                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">
                                            <a class="dark:text-white/80" href="https://t.me/{!! $contactUs->telegram !!}">

                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
<path d="M 25 2 C 12.309288 2 2 12.309297 2 25 C 2 37.690703 12.309288 48 25 48 C 37.690712 48 48 37.690703 48 25 C 48 12.309297 37.690712 2 25 2 z M 25 4 C 36.609833 4 46 13.390175 46 25 C 46 36.609825 36.609833 46 25 46 C 13.390167 46 4 36.609825 4 25 C 4 13.390175 13.390167 4 25 4 z M 34.087891 14.035156 C 33.403891 14.035156 32.635328 14.193578 31.736328 14.517578 C 30.340328 15.020578 13.920734 21.992156 12.052734 22.785156 C 10.984734 23.239156 8.9960938 24.083656 8.9960938 26.097656 C 8.9960938 27.432656 9.7783594 28.3875 11.318359 28.9375 C 12.146359 29.2325 14.112906 29.828578 15.253906 30.142578 C 15.737906 30.275578 16.25225 30.34375 16.78125 30.34375 C 17.81625 30.34375 18.857828 30.085859 19.673828 29.630859 C 19.666828 29.798859 19.671406 29.968672 19.691406 30.138672 C 19.814406 31.188672 20.461875 32.17625 21.421875 32.78125 C 22.049875 33.17725 27.179312 36.614156 27.945312 37.160156 C 29.021313 37.929156 30.210813 38.335938 31.382812 38.335938 C 33.622813 38.335938 34.374328 36.023109 34.736328 34.912109 C 35.261328 33.299109 37.227219 20.182141 37.449219 17.869141 C 37.600219 16.284141 36.939641 14.978953 35.681641 14.376953 C 35.210641 14.149953 34.672891 14.035156 34.087891 14.035156 z M 34.087891 16.035156 C 34.362891 16.035156 34.608406 16.080641 34.816406 16.181641 C 35.289406 16.408641 35.530031 16.914688 35.457031 17.679688 C 35.215031 20.202687 33.253938 33.008969 32.835938 34.292969 C 32.477938 35.390969 32.100813 36.335938 31.382812 36.335938 C 30.664813 36.335938 29.880422 36.08425 29.107422 35.53125 C 28.334422 34.97925 23.201281 31.536891 22.488281 31.087891 C 21.863281 30.693891 21.201813 29.711719 22.132812 28.761719 C 22.899812 27.979719 28.717844 22.332938 29.214844 21.835938 C 29.584844 21.464938 29.411828 21.017578 29.048828 21.017578 C 28.923828 21.017578 28.774141 21.070266 28.619141 21.197266 C 28.011141 21.694266 19.534781 27.366266 18.800781 27.822266 C 18.314781 28.124266 17.56225 28.341797 16.78125 28.341797 C 16.44825 28.341797 16.111109 28.301891 15.787109 28.212891 C 14.659109 27.901891 12.750187 27.322734 11.992188 27.052734 C 11.263188 26.792734 10.998047 26.543656 10.998047 26.097656 C 10.998047 25.463656 11.892938 25.026 12.835938 24.625 C 13.831938 24.202 31.066062 16.883437 32.414062 16.398438 C 33.038062 16.172438 33.608891 16.035156 34.087891 16.035156 z"></path>
</svg>
                    </a>
                                        </div>
                                        <div class="mr-4 mb-4">
                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                              تلگرام
                                            </h3>
                                            <p class="text-gray-600 dark:text-slate-400">{!! $contactUs->telegram !!} </p>

                                        </div>
                                    </li>
                                    <li class="flex">
                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">
                                            <a class="dark:text-white/80" href="https://ble.ir/diyanasaam">

                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
<path d="M 25 2 C 12.309288 2 2 12.309297 2 25 C 2 37.690703 12.309288 48 25 48 C 37.690712 48 48 37.690703 48 25 C 48 12.309297 37.690712 2 25 2 z M 25 4 C 36.609833 4 46 13.390175 46 25 C 46 36.609825 36.609833 46 25 46 C 13.390167 46 4 36.609825 4 25 C 4 13.390175 13.390167 4 25 4 z M 34.087891 14.035156 C 33.403891 14.035156 32.635328 14.193578 31.736328 14.517578 C 30.340328 15.020578 13.920734 21.992156 12.052734 22.785156 C 10.984734 23.239156 8.9960938 24.083656 8.9960938 26.097656 C 8.9960938 27.432656 9.7783594 28.3875 11.318359 28.9375 C 12.146359 29.2325 14.112906 29.828578 15.253906 30.142578 C 15.737906 30.275578 16.25225 30.34375 16.78125 30.34375 C 17.81625 30.34375 18.857828 30.085859 19.673828 29.630859 C 19.666828 29.798859 19.671406 29.968672 19.691406 30.138672 C 19.814406 31.188672 20.461875 32.17625 21.421875 32.78125 C 22.049875 33.17725 27.179312 36.614156 27.945312 37.160156 C 29.021313 37.929156 30.210813 38.335938 31.382812 38.335938 C 33.622813 38.335938 34.374328 36.023109 34.736328 34.912109 C 35.261328 33.299109 37.227219 20.182141 37.449219 17.869141 C 37.600219 16.284141 36.939641 14.978953 35.681641 14.376953 C 35.210641 14.149953 34.672891 14.035156 34.087891 14.035156 z M 34.087891 16.035156 C 34.362891 16.035156 34.608406 16.080641 34.816406 16.181641 C 35.289406 16.408641 35.530031 16.914688 35.457031 17.679688 C 35.215031 20.202687 33.253938 33.008969 32.835938 34.292969 C 32.477938 35.390969 32.100813 36.335938 31.382812 36.335938 C 30.664813 36.335938 29.880422 36.08425 29.107422 35.53125 C 28.334422 34.97925 23.201281 31.536891 22.488281 31.087891 C 21.863281 30.693891 21.201813 29.711719 22.132812 28.761719 C 22.899812 27.979719 28.717844 22.332938 29.214844 21.835938 C 29.584844 21.464938 29.411828 21.017578 29.048828 21.017578 C 28.923828 21.017578 28.774141 21.070266 28.619141 21.197266 C 28.011141 21.694266 19.534781 27.366266 18.800781 27.822266 C 18.314781 28.124266 17.56225 28.341797 16.78125 28.341797 C 16.44825 28.341797 16.111109 28.301891 15.787109 28.212891 C 14.659109 27.901891 12.750187 27.322734 11.992188 27.052734 C 11.263188 26.792734 10.998047 26.543656 10.998047 26.097656 C 10.998047 25.463656 11.892938 25.026 12.835938 24.625 C 13.831938 24.202 31.066062 16.883437 32.414062 16.398438 C 33.038062 16.172438 33.608891 16.035156 34.087891 16.035156 z"></path>
</svg>
                    </a>
                                        </div>
                                        <div class="mr-4 mb-4">
                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                              بله
                                            </h3>
                                            <p class="text-gray-600 dark:text-slate-400">diyanasaam </p>

                                        </div>
                                    </li>
                                    <li class="flex">
                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">
                                            <a class="dark:text-white/80" href="https://rubika.ir/Diyanasaam">

                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
<path d="M 25 2 C 12.309288 2 2 12.309297 2 25 C 2 37.690703 12.309288 48 25 48 C 37.690712 48 48 37.690703 48 25 C 48 12.309297 37.690712 2 25 2 z M 25 4 C 36.609833 4 46 13.390175 46 25 C 46 36.609825 36.609833 46 25 46 C 13.390167 46 4 36.609825 4 25 C 4 13.390175 13.390167 4 25 4 z M 34.087891 14.035156 C 33.403891 14.035156 32.635328 14.193578 31.736328 14.517578 C 30.340328 15.020578 13.920734 21.992156 12.052734 22.785156 C 10.984734 23.239156 8.9960938 24.083656 8.9960938 26.097656 C 8.9960938 27.432656 9.7783594 28.3875 11.318359 28.9375 C 12.146359 29.2325 14.112906 29.828578 15.253906 30.142578 C 15.737906 30.275578 16.25225 30.34375 16.78125 30.34375 C 17.81625 30.34375 18.857828 30.085859 19.673828 29.630859 C 19.666828 29.798859 19.671406 29.968672 19.691406 30.138672 C 19.814406 31.188672 20.461875 32.17625 21.421875 32.78125 C 22.049875 33.17725 27.179312 36.614156 27.945312 37.160156 C 29.021313 37.929156 30.210813 38.335938 31.382812 38.335938 C 33.622813 38.335938 34.374328 36.023109 34.736328 34.912109 C 35.261328 33.299109 37.227219 20.182141 37.449219 17.869141 C 37.600219 16.284141 36.939641 14.978953 35.681641 14.376953 C 35.210641 14.149953 34.672891 14.035156 34.087891 14.035156 z M 34.087891 16.035156 C 34.362891 16.035156 34.608406 16.080641 34.816406 16.181641 C 35.289406 16.408641 35.530031 16.914688 35.457031 17.679688 C 35.215031 20.202687 33.253938 33.008969 32.835938 34.292969 C 32.477938 35.390969 32.100813 36.335938 31.382812 36.335938 C 30.664813 36.335938 29.880422 36.08425 29.107422 35.53125 C 28.334422 34.97925 23.201281 31.536891 22.488281 31.087891 C 21.863281 30.693891 21.201813 29.711719 22.132812 28.761719 C 22.899812 27.979719 28.717844 22.332938 29.214844 21.835938 C 29.584844 21.464938 29.411828 21.017578 29.048828 21.017578 C 28.923828 21.017578 28.774141 21.070266 28.619141 21.197266 C 28.011141 21.694266 19.534781 27.366266 18.800781 27.822266 C 18.314781 28.124266 17.56225 28.341797 16.78125 28.341797 C 16.44825 28.341797 16.111109 28.301891 15.787109 28.212891 C 14.659109 27.901891 12.750187 27.322734 11.992188 27.052734 C 11.263188 26.792734 10.998047 26.543656 10.998047 26.097656 C 10.998047 25.463656 11.892938 25.026 12.835938 24.625 C 13.831938 24.202 31.066062 16.883437 32.414062 16.398438 C 33.038062 16.172438 33.608891 16.035156 34.087891 16.035156 z"></path>
</svg>
                    </a>
                                        </div>
                                        <div class="mr-4 mb-4">
                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                              روبیکا
                                            </h3>
                                            <p class="text-gray-600 dark:text-slate-400">Diyanasaam </p>

                                        </div>
                                    </li>
                                @endif
                                @if ($contactUs->working_hours)
                                    <li class="flex">
                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                                <path d="M12 7v5l3 3"></path>
                                            </svg>
                                        </div>
                                        <div class="mr-4 mb-4">
                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                                ساعات کار
                                            </h3>
                                            <p class="text-gray-600 dark:text-slate-400">{!! $contactUs->working_hours !!}</p>
                                            </p>
                                        </div>
                                    </li>
                                @endif
                                @if ($contactUs->email)
                                    <li class="flex">
                                        <div class="flex h-10 w-10 items-center justify-center rounded text-white bg-main">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"  width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                                              </svg>


                                        </div>
                                        <div class="mr-4 mb-4">
                                            <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                                آدرس ایمیل
                                            </h3>
                                            <p class="text-gray-600 dark:text-slate-400">{!! $contactUs->email !!}</p>
                                            </p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        @if ($contactUs->isActive_form == 1)
                            <div class="card h-fit max-w-6xl p-5 md:p-12" id="form" data-aos="fade-up">
                                <h2 class="mb-4 text-2xl font-bold dark:text-white">فرم تماس با ما</h2>
                                <form id="contactForm" action="{{route('customer.contactStore')}}" method="post">
                                    @csrf
                                    <div class="mb-6">
                                        <div class="mx-0 mb-1 sm:mb-4">
{{--                                            <div class="mx-0 mb-1 sm:mb-4">--}}
{{--                                                <label for="title"--}}
{{--                                                    class="pb-1 text-xs uppercase tracking-wider"></label><input--}}
{{--                                                    type="text" id="title" autocomplete="title" name="title"--}}
{{--                                                    value="{{old('title')}}"--}}
{{--                                                    placeholder="عنوان"--}}
{{--                                                    class="mb-2 w-full rounded-md border border-gray-400 py-2 pl-2 pr-4 shadow-md dark:text-gray-300 sm:mb-0 dark:bg-dark focus:border-main focus:ring-0 focus:outline-none  placeholder:font-bold  "--}}
{{--                                                    >--}}
{{--                                                    @error('title')--}}
{{--                                                    <span class="font-bold text-red-500">{{$message}}</span>--}}

{{--                                                    @enderror--}}

{{--                                            </div>--}}
                                            <div class="mx-0 mb-1 sm:mb-4">
                                                <label for="full_name"
                                                    class="pb-1 text-xs uppercase tracking-wider"></label><input
                                                    type="text" id="full_name" autocomplete="given-name" name="full_name"
                                                    value="{{old('full_name')}}"
                                                    placeholder="نام و نام خانوادگی"
                                                    class=" mb-2 w-full rounded-md border border-gray-400 py-2 pl-2 pr-4 shadow-md dark:text-gray-300 sm:mb-0 dark:bg-dark focus:border-main focus:ring-0 focus:outline-none  placeholder:font-bold  "
                                                    >
                                                    @error('full_name')
                                                    <span class="font-bold text-red-500">{{$message}}</span>

                                                    @enderror

                                            </div>
                                            <div class="mx-0 mb-1 sm:mb-4">
                                                <label for="phone"
                                                    class="pb-1 text-xs uppercase tracking-wider"></label><input
                                                    type="text" id="phone" autocomplete="phone" name="phone"
                                                    value="{{old('phone')}}"
                                                    placeholder="شماره موبایل"
                                                    class="mb-2 w-full rounded-md border border-gray-400 py-2 pl-2 pr-4 shadow-md dark:text-gray-300 sm:mb-0 dark:bg-dark focus:border-main focus:ring-0 focus:outline-none  placeholder:font-bold  "
                                                    >
                                                    @error('phone')
                                                    <span class="font-bold text-red-500">{{$message}}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="mx-0 mb-1 sm:mb-4">
                                            <label for="textarea" class="pb-1 text-xs uppercase tracking-wider"></label>
                                            <textarea id="textarea" name="description" cols="30" rows="5" placeholder="پیام خود را بنویسید"
                                                class="mb-2 w-full rounded-md border border-gray-400 py-2 pl-2 pr-4 shadow-md dark:text-gray-300 sm:mb-0 dark:bg-dark focus:border-main focus:ring-0 focus:outline-none  placeholder:font-bold  ">{{old('description')}}</textarea>
                                                @error('description')
                                                <span class="font-bold text-red-500">{{$message}}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="w-full bg-main text-white px-6 py-3 font-xl rounded-md sm:mb-0">
                                            پیام خود را ارسال کنید</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection
