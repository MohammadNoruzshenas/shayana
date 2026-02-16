@extends('customer.layouts.master')
@section('head-tag')
    <title>پروفایل کاربری</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/sweetalert/sweetalert2.css') }}">
    <script src="{{ asset('dashboard/js/sweetalert/sweetalert2.min.js') }}"></script>
    
    <!-- LG TV Browser Compatibility Styles -->
    <style>
        /* Ensure tabs work without JavaScript as fallback */
        .tab:not(.hidden) {
            display: flex !important;
        }
        
        /* Ensure hidden tabs are actually hidden */
        .tab.hidden {
            display: none !important;
        }
        
        /* Ensure visible tabs are shown properly */
        .tab:not(.hidden) {
            display: flex !important;
        }
        
        /* Ensure tab buttons are clickable */
        .tabbtn {
            cursor: pointer !important;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* LG TV specific optimizations */
        @media screen and (max-width: 1920px) {
            .tabbtn:hover {
                background-color: rgba(var(--main), 0.1) !important;
            }
            
            .tabbtn:focus {
                outline: 2px solid rgba(var(--main), 0.5) !important;
                outline-offset: 2px;
            }
        }
    </style>

    <style>
        table,
        th,
        td {
            border: none;
            border-bottom: 1px solid rgb(107 114 128) !important;
        }

        .btn {
            bor
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn {
            border: 1px solid transparent;
            margin: 0 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            line-height: 1.25;
            border-radius: 0.25rem;
            transition: all 0.15s ease-in-out;
        }
    </style>
@endsection
@section('content')


    <section class="container my-5 content lg:blur-0">

        <div class="flex flex-col justify-between gap-5 lg:flex-row">
            <div class="flex flex-col items-center w-full p-6 bg-gray lg:w-3/12 rounded-3xl bg-gray dark:bg-dark h-min"
                data-aos="fade-left">
                <div class="flex flex-col items-center gap-4 mb-4">
                    @if (auth()->user()->image)
                        <img src="{{ auth()->user()->image }}"
                            class="rounded-full h-14 w-14 ring-2 ring-gray-300 dark:ring-gray-500" alt="avatar">
                    @endif

                    <span class="text-xl font-bold text-main"> سلام {{ auth()->user()->full_name }} عزیز!</span>

                </div>
{{--                <div data-tabopen="tab1"--}}
{{--                    class="flex items-center w-full gap-2 p-2 font-medium rounded-lg cursor-pointer text-main tabbtn bg-secondary">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                        stroke="currentColor" class="w-6 h-6">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />--}}
{{--                    </svg>--}}

{{--                    پیشخوان--}}
{{--                </div>--}}
                <div data-tabopen="tab1" onclick="switchTab('tab1', this)"
                    class="flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round"
                            d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                    </svg>

                    دوره نسل دو زبانه
                </div>

                <div data-tabopen="tab3" onclick="switchTab('tab3', this)"
                    class="flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>

                   پروفایل من
                </div>
{{--                @if ($plans->count() > 0)--}}
{{--                    <div data-tabopen="tab4"--}}
{{--                        class="flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                            stroke="currentColor" class="w-6 h-6">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />--}}
{{--                        </svg>--}}

{{--                        اشتراک ویژه--}}
{{--                    </div>--}}
{{--                @endif--}}
                <div data-tabopen="tab5" onclick="switchTab('tab5', this)"
                    class="flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                    </svg>



                    پشتیبانی
                </div>
{{--                <div data-tabopen="tab6"--}}
{{--                    class="flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                        stroke="currentColor" class="w-6 h-6">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />--}}
{{--                    </svg>--}}




{{--                    تاریخچه تراکنش--}}
{{--                </div>--}}

                <div data-tabopen="tab8" onclick="switchTab('tab8', this)"
                     class="flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>

                   برنامه من
                </div>




                <div class="flex items-center w-full gap-2 p-2 font-medium text-red-500 cursor-pointer ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>

                    <a href="{{ route('auth.logout') }}"> خروج از سیستم</a>
                </div>
            </div>
{{--            <div class="flex flex-col items-center w-full lg:w-9/12 " data-aos="fade-down">--}}

{{--                <div id="tab1"--}}
{{--                    class="flex flex-col items-center w-full gap-2 p-5 bg-gray tab rounded-3xl dark:bg-dark">--}}
{{--                    <div class="flex flex-col justify-between w-full gap-5 lg:flex-row">--}}
{{--                        <div class="w-full h-auto py-3 dark:bg-secondary  bg-gray-200 rounded-2xl">--}}
{{--                            <div class="flex items-center justify-center gap-4 ">--}}
{{--                                <div class="p-4 bg-white border rounded-full dark:bg-transparent dark:border-main ">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"--}}
{{--                                        viewBox="0 0 32 32" fill="none">--}}
{{--                                        <path--}}
{{--                                            d="M16.4937 2.86644L28.4937 7.66641C28.9603 7.85307 29.3337 8.41306 29.3337 8.9064V13.3331C29.3337 14.0664 28.7337 14.6664 28.0003 14.6664H4.00033C3.26699 14.6664 2.66699 14.0664 2.66699 13.3331V8.9064C2.66699 8.41306 3.04033 7.85307 3.507 7.66641L15.507 2.86644C15.7737 2.75977 16.227 2.75977 16.4937 2.86644Z"--}}
{{--                                            class="stroke-main" stroke-width="2" stroke-miterlimit="10"--}}
{{--                                            stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path--}}
{{--                                            d="M29.3337 29.3333H2.66699V25.3333C2.66699 24.6 3.26699 24 4.00033 24H28.0003C28.7337 24 29.3337 24.6 29.3337 25.3333V29.3333Z"--}}
{{--                                            class="stroke-main" stroke-width="2" stroke-miterlimit="10"--}}
{{--                                            stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path d="M5.33301 24V14.6667" class="stroke-main" stroke-width="2"--}}
{{--                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path d="M10.667 24V14.6667" class="stroke-main" stroke-width="2"--}}
{{--                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path d="M16 24V14.6667" class="stroke-main" stroke-width="2"--}}
{{--                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path d="M21.333 24V14.6667" class="stroke-main" stroke-width="2"--}}
{{--                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path d="M26.667 24V14.6667" class="stroke-main" stroke-width="2"--}}
{{--                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path d="M1.33301 29.3333H30.6663" class="stroke-main" stroke-width="2"--}}
{{--                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                        <path--}}
{{--                                            d="M16 11.3333C17.1046 11.3333 18 10.4379 18 9.33331C18 8.22874 17.1046 7.33331 16 7.33331C14.8954 7.33331 14 8.22874 14 9.33331C14 10.4379 14.8954 11.3333 16 11.3333Z"--}}
{{--                                            class="stroke-main" stroke-width="2" stroke-miterlimit="10"--}}
{{--                                            stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <div class="flex flex-col items-center gap-1">--}}
{{--                                    <span class="font-bold text-main">{{ $course }} دوره</span>--}}
{{--                                    <span class="text-sm text-[#7B7B7B] dark:text-white/80"> در سایت وجود دارد</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-full h-auto py-3 dark:bg-secondary  bg-gray-200 rounded-2xl">--}}
{{--                            <div class="flex items-center justify-center gap-4 ">--}}
{{--                                <div class="p-4 bg-white border rounded-full dark:bg-transparent dark:border-main">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"--}}
{{--                                        viewBox="0 0 32 32" fill="none">--}}
{{--                                        <path--}}
{{--                                            d="M13.4 3.37332L5.37336 8.61332C2.80003 10.2933 2.80003 14.0533 5.37336 15.7333L13.4 20.9733C14.84 21.92 17.2134 21.92 18.6534 20.9733L26.64 15.7333C29.2 14.0533 29.2 10.3067 26.64 8.62665L18.6534 3.38665C17.2134 2.42665 14.84 2.42665 13.4 3.37332Z"--}}
{{--                                            class="stroke-main" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round" />--}}
{{--                                        <path--}}
{{--                                            d="M7.5065 17.44L7.49316 23.6933C7.49316 25.3867 8.79983 27.2 10.3998 27.7333L14.6532 29.1467C15.3865 29.3867 16.5998 29.3867 17.3465 29.1467L21.5998 27.7333C23.1998 27.2 24.5065 25.3867 24.5065 23.6933V17.5067"--}}
{{--                                            class="stroke-main" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round" />--}}
{{--                                        <path d="M28.5 20V12" class="stroke-main" stroke-width="1.5"--}}
{{--                                            stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <div class="flex flex-col items-center gap-1">--}}
{{--                                    <span class="font-bold text-main">{{ $orders->count() }} دوره</span>--}}
{{--                                    <span class="text-sm text-[#7B7B7B] dark:text-white/80"> ثبت نام کرده اید </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-full h-auto py-3 dark:bg-secondary  bg-gray-200 rounded-2xl">--}}
{{--                            <div class="flex items-center justify-center gap-4 ">--}}
{{--                                <div class="p-4 bg-white border rounded-full dark:bg-transparent dark:border-main">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"--}}
{{--                                        viewBox="0 0 32 32" fill="none">--}}
{{--                                        <path fill-rule="evenodd" clip-rule="evenodd"--}}
{{--                                            d="M22.0073 31.3008C26.6959 30.1914 30.3521 26.5776 31.4217 21.9781C32.3774 17.8684 32.145 13.5798 30.7505 9.59201L30.5433 8.99958C29.0089 4.61166 25.1757 1.37261 20.5133 0.524254L19.2366 0.291949C17.0972 -0.0973163 14.9028 -0.0973164 12.7635 0.291949L11.4867 0.524262C6.82437 1.37261 2.99115 4.61165 1.45671 8.99955L1.24953 9.592C-0.145011 13.5798 -0.377437 17.8684 0.578249 21.9781C1.64787 26.5776 5.30411 30.1914 9.99266 31.3008C13.933 32.2331 18.067 32.2331 22.0073 31.3008ZM11.7851 7.4668C12.0258 6.90636 11.7564 6.26122 11.1832 6.02583C10.6101 5.79045 9.95031 6.05396 9.7096 6.6144L9.33215 7.49316C8.63429 9.11793 8.45888 10.912 8.82926 12.6366C9.41704 15.3735 11.6453 17.4874 14.4607 17.979L14.6689 18.0154C15.5493 18.1691 16.4507 18.1691 17.3312 18.0154L17.5393 17.979C20.3548 17.4874 22.583 15.3735 23.1708 12.6366C23.5412 10.912 23.3658 9.11793 22.6679 7.49316L22.2905 6.6144C22.0497 6.05396 21.39 5.79045 20.8168 6.02583C20.2437 6.26121 19.9742 6.90636 20.2149 7.4668L20.5924 8.34557C21.1132 9.55816 21.2441 10.8971 20.9677 12.1842C20.5686 14.0427 19.0554 15.4782 17.1436 15.812L16.9355 15.8484C16.3167 15.9564 15.6833 15.9564 15.0646 15.8484L14.8565 15.812C12.9446 15.4782 11.4315 14.0427 11.0324 12.1842C10.7559 10.8971 10.8868 9.55816 11.4077 8.34557L11.7851 7.4668Z"--}}
{{--                                            class="fill-main" />--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <div class="flex flex-col items-center gap-1">--}}
{{--                                    <span class="font-bold text-main">{{ $cartItems }} دوره</span>--}}
{{--                                    <span class="text-sm text-[#7B7B7B] dark:text-white/80">در انتظار پرداخت</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-col w-full h-auto gap-5 p-3 dark:bg-secondary  bg-gray-200 rounded-2xl">--}}
{{--                        @if ($plans->count() > 0 || $subscription)--}}
{{--                            <div class="flex items-center justify-center gap-4 lg:justify-start ">--}}
{{--                                <div--}}
{{--                                    class="p-4 bg-white border rounded-full dark:bg-transparent dark:border-main lg:rounded-3xl">--}}
{{--                                    <svg id="icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">--}}
{{--                                        <path--}}
{{--                                            d="M35.42,188.21,243.17,457.67a16.17,16.17,0,0,0,25.66,0L476.58,188.21a16.52,16.52,0,0,0,.95-18.75L407.06,55.71A16.22,16.22,0,0,0,393.27,48H118.73a16.22,16.22,0,0,0-13.79,7.71L34.47,169.46A16.52,16.52,0,0,0,35.42,188.21Z"--}}
{{--                                            fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                            stroke-width="32" />--}}
{{--                                        <line x1="48" y1="176" x2="464" y2="176"--}}
{{--                                            fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                            stroke-width="32" />--}}
{{--                                        <polyline points="400 64 352 176 256 48" fill="none" stroke="#000"--}}
{{--                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />--}}
{{--                                        <polyline points="112 64 160 176 256 48" fill="none" stroke="#000"--}}
{{--                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />--}}
{{--                                        <line x1="256" y1="448" x2="160" y2="176"--}}
{{--                                            fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                            stroke-width="32" />--}}
{{--                                        <line x1="256" y1="448" x2="352" y2="176"--}}
{{--                                            fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                            stroke-width="32" />--}}
{{--                                    </svg>--}}

{{--                                </div>--}}
{{--                                <div class="flex flex-col items-center gap-1">--}}
{{--                                    <span class="text-sm font-bold lg:text-2xl text-main">اشتراک ویژه</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}



{{--                            <div--}}
{{--                                class="flex flex-col flex-wrap items-center justify-between gap-5 p-4 rounded-xl dark:bg-secondary  bg-gray-200 lg:flex-row">--}}
{{--                                <div class="flex items-center gap-4">--}}
{{--                                    @if ($subscription)--}}
{{--                                        <div class="flex flex-col gap-2">--}}
{{--                                            @php--}}
{{--                                                $data = json_decode($subscription->plan_object);--}}
{{--                                            @endphp--}}
{{--                                            <span class="text-xl font-black text-main">{{ $data->name }}</span>--}}
{{--                                            <div--}}
{{--                                                class="flex justify-between w-full text-[#828282]  dark:text-white/80 flex-wrap">--}}
{{--                                                <span>{{ \Carbon\Carbon::today()->diffInDays($subscription->expirydate, false) }}--}}
{{--                                                    روز مانده تا انقضا</span>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                </div>--}}
{{--                            @else--}}
{{--                                <div class="flex flex-col gap-2">--}}
{{--                                    <span class="text-xl font-black text-main">شما اشتراک فعالی ندارید</span>--}}
{{--                                    <div class="flex justify-between w-full text-[#828282]  dark:text-white/80 flex-wrap">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}




{{--                    </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                @forelse ($notifactions as $notification)--}}
{{--                    <div--}}
{{--                        class="flex flex-col items-center justify-between w-full h-auto gap-2 p-6 rounded-lg dark:bg-secondary  bg-gray-200 dark:text-white/80 text-secondary lg:flex-row">--}}

{{--                        <p class="w-full lg:w-10/12">--}}
{{--                            {{ $notification->description }}--}}
{{--                        </p>--}}
{{--                        <span class="flex items-center justify-center w-full gap-2 text-sm lg:w-2/12 ">--}}

{{--                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                            </svg>--}}

{{--                        </span>--}}
{{--                    </div>--}}
{{--                @empty--}}
{{--                    <div--}}
{{--                        class="flex flex-col items-center justify-between w-full h-auto gap-2 p-6 rounded-lg dark:bg-secondary  bg-gray-200 text-white/80 lg:flex-row">--}}

{{--                        <p class="w-full lg:w-10/12">--}}
{{--                            درحال حاظر اعلانی ندارید--}}
{{--                        </p>--}}

{{--                    </div>--}}
{{--                @endforelse--}}

{{--            </div>--}}

            <div id="tab1" class="flex flex-col hidden w-full gap-4 p-5 bg-gray tab rounded-3xl dark:bg-dark">
                @forelse ($orders as $order)
                    @if ($order->singleProduct)
                        <div
                            class="flex flex-col items-center justify-between gap-5 p-4 rounded-xl dark:bg-secondary  bg-gray-200 lg:flex-row">
                            <div class="flex items-center gap-2">
                                <img src="{{ $order->singleProduct->image }}" class="object-cover w-24 rounded-xl"
                                    alt="">
                                <div class="flex flex-col gap-2">
                                    <span class="text-xl font-black text-main"><a
                                            href="{{ route('customer.course.singleCourse', $order->singleProduct->slug) }}">{{ $order->singleProduct->title }}</a></span>
                                    <span class="text-xs dark:text-white/80 text-secondary">
                                        @if ('get_course_option' == 1)
                                            برای مشاهده این دوره از اسپات پلیر استفاده کنید.
                                        @endif
                                    </span>
                                </div>
                            </div>


                            @if ($order->singleProduct->get_course_option == 1)
                                <div class="flex items-center w-full gap-2 lg:w-5/12">
{{--                                    <button data-modal-target="Guidemodal" data-modal-toggle="Guidemodal"--}}
{{--                                        class=" w-full  text-white bg-main/70 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center  flex items-center gap-2 justify-center"--}}
{{--                                        type="button">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />--}}
{{--                                        </svg>--}}

{{--                                        راهنما--}}
{{--                                    </button>--}}

                                    <button data-license="{{ $order->license }}"
                                        class="flex items-center gap-2 w-full  text-white bg-main/70 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center licenseBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>


                                        کپی
                                        لایسنس</button>

                                </div>
                            @else
                                <div class="flex items-center w-full gap-2 lg:w-4/12">
                                    <a href="{{ route('customer.course.singleCourse', $order->singleProduct->slug) }}"
                                        class="flex items-center gap-3 w-full  text-white bg-main/70 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                        </svg>
                                        <span>

                                            مشاهده دوره
                                        </span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                @empty

                    <div
                        class="flex flex-col items-center justify-between gap-5 p-4 rounded-xl dark:bg-secondary  bg-gray-200 lg:flex-row">

                        <div class="flex items-center gap-2">
                            <svg class="w-14 h-14 stroke-main" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>

                            <div class="flex flex-col gap-2">
                                <span class="text-xl font-black text-main"> دوره ای خریداری نکرده اید
                                </span>
                                <span class="text-xs dark:text-white/80 text-secondary"> برای خرید به صفحه محصولات
                                    مراجعه کنید
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center w-full gap-2 lg:w-4/12">
                            <a href="{{ route('customer.courses') }}"
                                class="flex items-center gap-3 w-full  text-white bg-main/70 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <span>

                                    رفتن به صفحه دوره
                                </span>
                            </a>
                        </div>

                    </div>
                @endforelse



            </div>


            <div id="tab3" class="flex flex-col hidden w-full gap-4 p-5 bg-gray tab rounded-3xl dark:bg-dark">

                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-6 gap-6 ">
                    @csrf
                    <div class="col-span-6">
                        <input type="file" name="image" id="avatarInput" hidden>
                        <div class="relative flex items-center justify-center group">
                            @if (auth()->user()->image)
                                <img src="{{ auth()->user()->image }}"
                                    class="w-24 h-24 rounded-full cursor-pointer ring-2 ring-gray-300 dark:ring-gray-500"
                                    alt="avatar">
                            @else
                                <svg class="w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d=" M17.982 18.725A7.488
                                                7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963
                                                0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016
                                                0z" />
                                </svg>
                            @endif

                            <div id="changeAvatar" onclick="document.querySelector('#avatarInput').click()"
                                class="absolute z-50 flex items-center justify-center w-24 h-24 font-bold text-white duration-200 rounded-full opacity-0 cursor-pointer bg-black/70 group-hover:opacity-100">
                                تغیر عکس
                            </div>
                        </div>


                        @error('image')
                            <center>
                                <span class="font-bold text-red-500 ">{{ $message }}</span>
                            </center>
                        @enderror
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="FirstName" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            نام :
                        </label>

                        <input type="text" id="FirstName" value="{{ auth()->user()->first_name }}" name="first_name"
                            class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @error('first_name')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="col-span-6 sm:col-span-3">
                        <label for="LastName" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            نام خانوادگی :
                        </label>

                        <input type="text" id="LastName" value="{{ auth()->user()->last_name }}" name="last_name"
                            class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @error('last_name')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6">
                        <label for="Email" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            ایمیل :
                        </label>

                        @if (empty(auth()->user()->email))
                            <input type="email" id="Email" value="{{ auth()->user()->email }}" name="email"
                                class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @else
                            <input type="email" id="Email" value="{{ auth()->user()->email }}" disabled
                                title="ایمیل  قابل تغییر نیست" name="email"
                                class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @endif
                        @error('email')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="col-span-6 sm:col-span-3">
                        <label for="Password" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            رمز عبور :
                        </label>

                        <input type="password" id="Password" name="password"
                            class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @error('password')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="PasswordConfirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            تایید رمز عبور
                        </label>

                        <input type="password" id="PasswordConfirmation" name="password_confirmation"
                            class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @error('password_confirmation')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-6">
                        <label for="number" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            شماره موبایل
                        </label>
                        @if (empty(auth()->user()->mobile))
                            <input type="text" id="number" value="{{ auth()->user()->mobile }}" name="mobile"
                                class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @else
                            <input type="text" id="number" value="{{ auth()->user()->mobile }}" disabled
                                title="شماره موبایل قابل تغییر نیست" name="mobile"
                                class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @endif
                        @error('mobile')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>
                    {{--
            <div class="col-span-6">
                <label for="MarketingAccept" class="flex gap-4">
                    <input type="checkbox" id="MarketingAccept" name="marketing_accept"
                        class="w-5 h-5 rounded-md shadow-sm bg-none checked:bg-main" />

                    <span class="text-sm text-gray-700 dark:text-white/80">
                        می‌خواهم ایمیل‌هایی درباره رویدادها، به‌روزرسانی‌های محصول و
                        اطلاعیه های شرکت دریافت کنم
                    </span>
                </label>
            </div> --}}

                    <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                        <button
                            class="inline-block px-12 py-3 text-sm font-medium text-white transition border rounded-md bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main">
                            ذخیره تغیرات
                        </button>
                    </div>
                </form>
            </div>

            <div id="tab4" class="flex flex-col hidden w-full gap-4 p-5 bg-gray tab rounded-3xl dark:bg-dark">
                @forelse ($plans as $plan)
                    <div
                        class="flex flex-col flex-wrap items-center justify-between gap-5 p-4 rounded-xl dark:bg-secondary  bg-gray-200 lg:flex-row">
                        <div class="flex items-center gap-4">
                            {{-- <img src="" class="object-cover w-14 h-14 rounded-xl"
                    alt=""> --}}
                            <div class="flex flex-col gap-2">
                                <span class="text-xl font-black text-main lg:text-center">{{ $plan->name }}</span>


                                <div
                                    class="flex lg:justify-center items-center w-full text-[#828282]  dark:text-white/80 flex-wrap gap-1">

                                    <span>قیمت : </span>
                                    <div class="flex flex-wrap items-center gap-1">
                                        <div class="flex items-center w-full gap-1 lg:w-min"></div>
                                        @if ($plan->activeCommonDiscount() && $plan->price != 0)
                                            <span class="relative inline-block h-5 line-through  ">
                                                {{ $plan->price == 0 ? 'رایگان' : priceFormat($plan->price) . ' تومان' }}
                                            </span>
                                        @endif

                                        <!--<span class="font-bold  text-main"> </span>-->
                                        <div class="flex  items-center gap-3">
                                            <div class="text-xl text-main font-bold space-x-1.5 flex items-center">
                                                <span class=" ">
                                                    {{ $plan->final_plan_price_value }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <ul role="list"
                                    class="mt-8 grid grid-cols-1 gap-4 text-sm leading-6  text-secondary dark:text-white/80 sm:grid-cols-2 sm:gap-6">
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        دسترسی به دوره های ویژه
                                    </li>
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        دسترسی به مقالات ویژه
                                    </li>
                                    <li class="flex gap-x-3">
                                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        دسترسی به پادکست های ویژه
                                    </li>

                                </ul>
                            </div>
                        </div>
{{--                        <form action="{{ route('customer.profile.buySubscribe', $plan) }}" method="post">--}}
{{--                            @csrf--}}
{{--                            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"--}}
{{--                                class="flex items-center gap-1 px-4 py-2 text-sm font-bold text-white bg-main rounded-xl hover:bg-main/90 @if (Auth::user()->hasActivceSubscribe()) delete @endif">--}}

{{--                                خرید اشتراک--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                        d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />--}}
{{--                                </svg>--}}

{{--                                </svg>--}}

{{--                            </button>--}}
{{--                            <div class="bg-red-500 text-white px-4 py-1 rounded-lg mt-5 text-center hover:bg-main">اشتراک--}}
{{--                                {{ $plan->subscription_day }} روزه </div>--}}

{{--                        </form>--}}
                        <p class="w-full font-light text-justify text-secondary dark:text-white/80">
                            {{ $plan->description }}</p>

                    </div>
                @empty
                    <div class="flex flex-col gap-2">
                        <span class="text-xl font-black text-main">پلنی یافت نشد</span>
                    </div>
                @endforelse



            </div>
            {{-- tickets --}}
            <div id="tab5" class="flex flex-col hidden w-full gap-4 p-5 bg-gray tab rounded-3xl dark:bg-dark ">
                <div class=" flex  items-center justify-between mb-5">
                    <h2 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">بخش پشتیبانی</h2>
                    <button
                            type="button"
                            onclick="openAddTicket()"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition bg-main rounded-lg hover:bg-main/80 focus:outline-none focus:ring-2 focus:ring-main/50">
                        ایجاد تیکت جدید
                    </button>
     
{{--                        <p--}}
{{--                            class="flex items-center gap-2 px-8 py-3  ">--}}
{{--                            برای  پشتیبانی با آیدی زیر در ارتباط باشید : shayana_support--}}
{{--                        </p>--}}
{{--<p><a href="https://t.me/shayana_support">کلیک کنید</a></p>--}}
                   
                </div>
                @livewire('ticket-pagination')

            </div>
            {{-- endtickets --}}

            <div id="tab6" class="flex flex-col hidden w-full gap-4 p-4 bg-gray tab rounded-3xl dark:bg-dark ">
                <div class="flex items-center justify-between ">
                    <h2 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">تاریخچه تراکنش </h2>
                </div>



                <section>
                    <div class="w-full mb-8 overflow-hidden">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full " style="border : none !important">
                                <thead>
                                    <tr class="text-md tracking-wide text-center text-secondary dark:text-white/80   ">

                                        <th class="px-4 py-3">وضعیت</th>
                                        <th class="px-4 py-3">کد تراکنش</th>
                                        <th class="px-4 py-3">قیمت</th>
                                        <th class="px-4 py-3">ساعت</th>
                                        <th class="px-4 py-3">تاریخ</th>

                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($payments as $payment)
                                        <tr class="text-center text-secondary dark:text-white/80 ">
                                            <td>
                                                @if ($payment->status == 0)
                                                    <p
                                                        class="flex items-center justify-center  gap-2 text-sm  text-red-500">
                                                        رد شده
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18 18 6M6 6l12 12" />
                                                        </svg>
                                                    </p>
                                                @else
                                                    <p
                                                        class="flex items-center justify-center gap-2 text-sm  text-teal-500">
                                                        تایید شده
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="h-6 w-6 ">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                        </svg>

                                                    </p>
                                                @endif

                                            </td>
                                            <td>
                                                {{ $payment->transaction_id ?? '-' }}
                                            </td>
                                            <td> {{ priceFormat($payment->amount) }} تومان</td>
                                            <td> {{ jalalidate($payment->created_at, 'H:s') }}</td>
                                            <td> {{ jalalidate($payment->created_at, 'Y/m/d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{ $payments->links('customer.layouts.paginate') }}

            </div>

            <div id="tab7" class="flex flex-col hidden w-full gap-4 p-4 bg-gray tab rounded-3xl dark:bg-dark ">
                <div class="flex items-center justify-between ">
                    <h2 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">اقساط من</h2>
                </div>

                <section>
                    <div class="w-full mb-8 overflow-hidden">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full " style="border : none !important">
                                <thead>
                                    <tr class="text-md tracking-wide text-center text-secondary dark:text-white/80   ">
                                        <th class="px-4 py-3">دوره</th>
                                        <th class="px-4 py-3">مبلغ قسط</th>
                                        <th class="px-4 py-3">تاریخ سررسید</th>
                                        <th class="px-4 py-3">وضعیت پرداخت</th>
                                        <th class="px-4 py-3">تاریخ پرداخت</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @forelse ($installments as $installment)
                                        <tr class="text-center text-secondary dark:text-white/80 ">
                                            <td class="px-4 py-3">
                                                @if($installment->course)
                                                    <div class="flex items-center gap-2">
                                                        @if($installment->course->image)
                                                            <img src="{{ $installment->course->image }}" class="w-10 h-10 rounded object-cover" alt="">
                                                        @endif
                                                        <span class="text-sm">{{ $installment->course->title }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-500">دوره حذف شده</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ number_format($installment->installment_amount) }} تومان
                                            </td>
                                                                                         <td class="px-4 py-3">
                                                 {{ jalalidate($installment->installment_date, 'Y/m/d') }}
                                             </td>
                                            <td class="px-4 py-3">
                                                @if ($installment->installment_passed_at)
                                                    <p class="flex items-center justify-center gap-2 text-sm text-teal-500">
                                                        پرداخت شده
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="h-6 w-6 ">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                        </svg>
                                                    </p>
                                                @else
                                                    @php
                                                        $installmentDate = \Carbon\Carbon::parse($installment->installment_date);
                                                        $isOverdue = $installmentDate->isPast();
                                                    @endphp
                                                    @if($isOverdue)
                                                        <p class="flex items-center justify-center gap-2 text-sm text-red-500">
                                                            منقضی شده
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                                            </svg>
                                                        </p>
                                                    @else
                                                        <p class="flex items-center justify-center gap-2 text-sm text-yellow-500">
                                                            در انتظار پرداخت
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </p>
                                                    @endif
                                                @endif
                                            </td>
                                                                                         <td class="px-4 py-3">
                                                 @if($installment->installment_passed_at)
                                                     {{ jalalidate($installment->installment_passed_at, 'Y/m/d H:i') }}
                                                 @else
                                                     <span class="text-gray-400">-</span>
                                                 @endif
                                             </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center gap-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                                    </svg>
                                                    <span class="text-lg font-medium">قسطی برای نمایش وجود ندارد</span>
                                                    <span class="text-sm">شما هیچ قسط آینده یا گذشته ای ندارید</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($installments->count() > 0)
                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <h4 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-2">خلاصه اقساط:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div class="text-center">
                                    <span class="block text-2xl font-bold text-green-600">{{ $installments->where('installment_passed_at', '!=', null)->count() }}</span>
                                    <span class="text-gray-600 dark:text-gray-400">پرداخت شده</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-2xl font-bold text-red-600">
                                        {{ $installments->where('installment_passed_at', null)->filter(function($installment) {
                                            return \Carbon\Carbon::parse($installment->installment_date)->isPast();
                                        })->count() }}
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400">منقضی شده</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-2xl font-bold text-yellow-600">
                                        {{ $installments->where('installment_passed_at', null)->filter(function($installment) {
                                            return \Carbon\Carbon::parse($installment->installment_date)->isFuture();
                                        })->count() }}
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400">آینده</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>
            </div>

            <div id="tab8" class="flex flex-col hidden w-full gap-4 p-5 bg-gray tab rounded-3xl dark:bg-dark">
                <div class="flex items-center justify-between ">
                    <h2 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">برنامه هفتگی من</h2>
                    <a href="{{ route('customer.schedule.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition bg-main rounded-lg hover:bg-main/80 focus:outline-none focus:ring-2 focus:ring-main/50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 17.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        مشاهده همه برنامه‌ها
                    </a>
                </div>

                @if(isset($schedules) && $schedules->count() > 0)
                    <!-- Schedule Info -->
                    <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <span class="block text-lg font-bold text-blue-600 dark:text-blue-300">
                                    {{ \Morilog\Jalali\Jalalian::fromCarbon($schedules->first()->week_start_date)->format('Y/m/d') }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-400">تاریخ شروع هفته</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-lg font-bold text-green-600 dark:text-green-300">
                                    {{ $schedules->count() }} برنامه هفتگی
                                </span>
                                <span class="text-gray-600 dark:text-gray-400">تعداد برنامه‌ها</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-lg font-bold text-green-600">
                                    فعال
                                </span>
                                <span class="text-gray-600 dark:text-gray-400">وضعیت</span>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Schedule Tables -->
                    @foreach($schedules as $scheduleIndex => $schedule)
                        <div class="w-full mb-8 overflow-hidden">
                            <div class="mb-4 p-3 bg-gradient-to-r from-purple-100 to-blue-100 dark:from-purple-900/30 dark:to-blue-900/30 rounded-lg">
                                <h4 class="text-lg font-bold text-purple-700 dark:text-purple-300">
                                    برنامه {{ $scheduleIndex + 1 }}: {{ $schedule->title ?? 'برنامه هفتگی' }}
                                </h4>
                               
                            </div>
                            <div class="w-full overflow-x-auto">
                                <table class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                                            <th class="px-4 py-3 text-center font-bold">روز / تایم</th>
                                            <th class="px-4 py-3 text-center font-bold">تایم 1</th>
                                            <th class="px-4 py-3 text-center font-bold">تایم 2</th>
                                            <th class="px-4 py-3 text-center font-bold">تایم 3</th>
                                            <th class="px-4 py-3 text-center font-bold">تایم 4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $daysOfWeek = ['روز اول', 'روز دوم', 'روز سوم', 'روز چهارم', 'روز پنجم', 'روز ششم', 'روز هفتم'];
                                            $organizedSchedule = $schedule->organized_schedule;
                                        @endphp
                                        @foreach($daysOfWeek as $dayIndex => $dayName)
                                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-6 bg-gradient-to-r from-red-500 to-pink-500 text-dark-500 font-bold text-center">
                                                    {{ $dayName }}
                                                </td>
                                                @for($slot = 1; $slot <= 4; $slot++)
                                                    @php
                                                        $currentItem = $organizedSchedule[$dayIndex]['slots'][$slot] ?? null;
                                                    @endphp
                                                    <td class="px-4 py-4 text-center {{ $currentItem ? 'bg-green-50 dark:bg-green-900/20' : 'bg-gray-50 dark:bg-gray-800' }}">
                                                        @if($currentItem)
                                                            <div class="space-y-2">
                                                                @if($currentItem->lession)
                                                                    @php
                                                                        $course = $currentItem->lession->season->parent->course;
                                                                        $selectedMainSeason = $currentItem?->lession?->season->parent;
                                                                        $selectedSeason = $currentItem?->lession?->season;
                                                                        $selectedLesion = $currentItem?->lession;
                                                                    @endphp
                                                                    <div class="font-bold text-green-700 dark:text-green-300 text-sm">
                                                                        🎯 {{ $selectedLesion->title }}
                                                                    </div>
                                                                    <div class="font-bold text-green-700 dark:text-green-300 text-sm">
                                                                        {{ $selectedMainSeason->title.'-'.$selectedSeason->title }}
                                                                    </div>
                                                                    @if($currentItem->lession->season )

                                                                        <div class="flex justify-center gap-2 mt-2">
                                                                            @if(!is_null($currentItem->lession->link))
                                                                                {{-- Download Video Icon --}}
                                                                                <a href="{{ route('customer.lesson.video.download', ['course' => $course->slug, 'lession' => $currentItem->lession]) }}" 
                                                                                   class="flex items-center gap-1 px-2 py-1 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors"
                                                                                   title="دانلود مستقیم ویدیو">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                                                    </svg>
                                                                                    <span>دانلود</span>
                                                                                </a>
                                                                                
                                                                                {{-- Open Video in New Window Icon --}}
                                                                                <a href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $currentItem->lession]) }}" 
                                                                                   target="_blank"
                                                                                   class="flex items-center gap-1 px-2 py-1 text-xs text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors"
                                                                                   title="باز کردن ویدیو در صفحه جدید">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                                                    </svg>
                                                                                    <span>باز کردن</span>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                                @if($currentItem->notes)
                                                                    <div class="text-xs text-gray-600 dark:text-gray-400 italic bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                                                        📝 {{ $currentItem->notes }}
                                                                    </div>
                                                                @endif
                                                                @if(!$currentItem->lession && !$currentItem->notes)
                                                                    <div class="text-gray-400 dark:text-gray-500 text-sm italic">
                                                                        ❌ تایم خالی
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="text-gray-400 dark:text-gray-500 text-sm italic">
                                                                ❌ تایم خالی
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- No Schedule Found -->
                    <div class="text-center py-16">
                        <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 002.25 2.25v7.5" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">برنامه‌ای برای شما تعریف نشده است</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">در حال حاضر هیچ برنامه هفتگی‌ای برای شما تنظیم نشده است.</p>
                        <p class="text-gray-500 dark:text-gray-400">لطفاً با پشتیبانی تماس بگیرید.</p>

                    </div>
                @endif
            </div>

        </div>

    </section>



    <div id="Guidemodal" tabindex="-1"
        class="fixed top-0 bg-secondary left-0 right-0 hidden w-full p-4 md:inset-0 h-screen max-h-full"
        style="z-index: 100000!important;">
        <div class="relative w-full max-w-4xl max-h-full overflow-x-hidden overflow-y-auto top-0">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-secondary dark:text-white/80">
                        نحوه دسترسی به دوره:
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg ltr:ml-auto rtl:mr-auto hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="Guidemodal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-8 text-secondary dark:text-white/80">
                    <span><span class="text-red-500"> توجه : </span> به منظور حفظ حق کپی رایت، دسترسی به دوره فقط در
                        اسپات پلیر و بر روی یک سیستم امکان پذیر
                        است!
                    </span>
                    <div class="flex flex-col gap-3">
                        <span class="px-3 text-center rounded w-fit bg-secondary text-white/80">قدم اول:</span>
                        <p class="font-light text-md">ابتدا از طریق لینک های زیر برنامه اسپات پلیر را متناسب با سیستم
                            عامل خود دانلود و سپس نصب کنید.
                        </p>
                        <div class="flex items-center gap-2">
                            <a class="px-4 text-sm duration-200 border rounded border-main text-main hover:bg-main/40"
                                href="https://app.spotplayer.ir/assets/bin/spotplayer/setup.exe">دانلود نسخه ویندوز</a>
                            <a class="px-4 text-sm duration-200 border rounded border-main text-main hover:bg-main/40"
                                href="https://app.spotplayer.ir/assets/bin/spotplayer/setup.dmg">دانلود نسخه مک</a>
                            <a class="px-4 text-sm duration-200 border rounded border-main text-main hover:bg-main/40"
                                href="https://app.spotplayer.ir/assets/bin/spotplayer/setup.apk">دانلود نسخه اندروید</a>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="px-3 text-center rounded w-fit bg-secondary text-white/80">قدم دوم:</span>
                        <p class="font-light text-md">لایسنس مخصوص به خودتان را در قسمت لایسنس ها کپی کنید و در برنامه
                            اسپات پلیر وارد کنید تا دوره هایی که شرکت کردید را برایتان بیاورد.
                        </p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="px-3 text-center rounded w-fit bg-secondary text-white/80">محل وارد کردن لایسنس:

                        </span>
                        <p class="font-light text-md">اگر برای بار اول برنامه اسپات پلیر را نصب میکنید به محض ورود، صفحه
                            وارد کردن لایسنس را برایتان باز میکند و نیاز است که در کادر بزرگ بالا لایسنس را وارد کنید و
                            تایید را بزنید. اگر از قبل برنامه اسپات پلیر را داشتید بر روی علامت + در سمت راست و بالای
                            اسپات پلیر کلیک بکنید تا قسمت وارد کردن لایسنس را بیاورد و سپس لایسنس را وارد کنید.


                        </p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="px-3 text-center rounded bg-amber-400 w-fit text-white/80">مشکلات احتمالی:
                        </span>
                        <p class="font-light text-md">اگر با خطای 'دفعات مجاز استفاده از این لایسنس تمام شده است.'
                            برخورد کردید به این معنی است که قبلا از لایسنس استفاده شده و یا در سیستم عامل اشتباهی وارد
                            میشود(در صورت حل نشدن مشکل با پشتیبانی در تماس باشید)

                            اگر لایسنس‌ وارد شد اما در هنگام پخش ویدیو با خطا مواجه شدید به دلیل نصب برنامه هایی است که
                            صفحه لپتاپ را ریکورد و یا share میکنند. برای رفع این مشکل باید این برنامه هارا حذف کنید.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="addTicket" tabindex="-1"
        class="fixed top-0 bg-secondary left-0 right-0 hidden w-full p-4 md:inset-0 h-screen max-h-full"
        style="z-index: 100000!important;">
        <div class="relative w-full  max-h-full overflow-x-hidden overflow-y-auto ">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-secondary dark:text-white/80">
                        ثبت پیام جدید
                    </h3>
                    <button type="button" onclick="closeAddTicket()"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg ltr:ml-auto rtl:mr-auto hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                     >
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <form action="{{ route('customer.profile.ticket.create') }}" method="POST"
                    enctype="multipart/form-data" class="grid grid-cols-6 gap-6 p-5">
                    @csrf
                    <div class="col-span-6 ">
                        <label for="Title" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            عنوان
                        </label>

                        <input type="text" id="Title" value="{{ old('subject') }}" name="subject"
                            class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none" />
                        @error('subject')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-6 ">
                        <label for="MainText" class="block text-sm font-medium text-gray-700 dark:text-white/80">
                            توضیحات راجب پیام
                        </label>
                        <textarea id="MainText" name="description"
                            class="w-full mt-1 text-sm text-gray-700 bg-white border-gray-200 rounded-md shadow-sm dark:text-white/80 dark:bg-secondary dark:border-none"
                            cols="10" rows="10">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="col-span-6 ">

                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div id="dropzone-box"
                                    class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-500 dark:text-gray-400">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"> PNG, JPG (MAX. Saze 500Kb)</p>
                                </div>
                                <input onchange="document.querySelector('#dropzone-box').innerText =  this.files[0].name"
                                    id="dropzone-file" name="file" type="file" class="hidden" />
                            </label>


                        </div>
                        @error('file')
                            <span class="font-bold text-red-500 ">{{ $message }}</span>
                        @enderror
                    </div>




                    <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                        <button
                            class="inline-block px-12 py-3 text-sm font-medium text-white transition border rounded-md bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main">
                            ارسال پیام
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

@endsection
@section('script')
    @if (Auth::user()->hasActivceSubscribe())
        <script>
            $(document).ready(function() {
                var element = $('.' + 'delete');

                element.on('click', function(e) {

                    e.preventDefault();

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success mx-2',
                            cancelButton: 'btn btn-danger mx-2'
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: 'شما اشتراک فعال دارید با این کار اشتراک قبلی پاک خواهد شد!',
                        text: "شما میتوانید درخواست خود را لغو نمایید",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'بله داده حذف شود.',
                        cancelButtonText: 'خیر درخواست لغو شود.',
                        reverseButtons: true
                    }).then((result) => {

                        if (result.value == true) {
                            $(this).parent().submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
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
    @endif

    <!-- LG TV Compatible Tab Switching Script -->
    <script>
        // Simple inline tab switching function for maximum compatibility
        function switchTab(tabId, buttonElement) {
            try {
                // Hide all tabs first - use a more robust approach
                var allTabs = document.getElementsByClassName('tab');
                
                // Convert to array to avoid live collection issues
                var tabsArray = [];
                for (var i = 0; i < allTabs.length; i++) {
                    tabsArray.push(allTabs[i]);
                }
                
                // Hide all tabs
                for (var i = 0; i < tabsArray.length; i++) {
                    var tab = tabsArray[i];
                    // Remove all display-related classes first
                    if (tab.classList) {
                        tab.classList.remove('flex', 'flex-col');
                        tab.classList.add('hidden');
                    } else {
                        // Fallback for older browsers
                        var className = tab.className;
                        className = className.replace(/\bflex\b/g, '').replace(/\bflex-col\b/g, '');
                        if (className.indexOf('hidden') === -1) {
                            className = className + ' hidden';
                        }
                        tab.className = className.replace(/\s+/g, ' ').trim();
                    }
                }
                
                // Show target tab
                var targetTab = document.getElementById(tabId);
                if (targetTab) {
                    if (targetTab.classList) {
                        targetTab.classList.remove('hidden');
                        targetTab.classList.add('flex', 'flex-col');
                    } else {
                        // Fallback for older browsers
                        var className = targetTab.className;
                        className = className.replace(/\bhidden\b/g, '');
                        className = className + ' flex flex-col';
                        targetTab.className = className.replace(/\s+/g, ' ').trim();
                    }
                }
                
                // Reset all button styles
                var allButtons = document.getElementsByClassName('tabbtn');
                var baseClasses = 'flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn';
                var activeClasses = 'flex items-center w-full gap-2 p-2 font-medium rounded-lg cursor-pointer text-main tabbtn bg-main/20';
                
                for (var i = 0; i < allButtons.length; i++) {
                    allButtons[i].className = baseClasses;
                }
                
                // Set active button style
                if (buttonElement) {
                    buttonElement.className = activeClasses;
                }
                
                // Save to localStorage if available
                if (typeof(Storage) !== "undefined") {
                    try {
                        localStorage.setItem("openTab", tabId);
                    } catch (e) {
                        // localStorage might not be available
                    }
                }
            } catch (e) {
                // Silently handle any errors
            }
        }

        // LG TV Compatible Tab Switching Implementation
        function initLGTVCompatibleTabs() {
            try {
                // Check if we're on an LG TV or similar limited browser
                var isLimitedBrowser = false;
                try {
                    // Test for modern JavaScript support
                    eval('const test = () => {};');
                } catch (e) {
                    isLimitedBrowser = true;
                }
                
                // Force LG TV mode for testing - remove this line in production if needed
                // isLimitedBrowser = true;
                
                // Get all tab elements and buttons using traditional methods
                var tabs = document.getElementsByClassName('tab');
                var tabBtns = document.getElementsByClassName('tabbtn');
                
                // Convert NodeList to Array for better compatibility
                var tabsArray = [];
                var tabBtnsArray = [];
                
                for (var i = 0; i < tabs.length; i++) {
                    tabsArray.push(tabs[i]);
                }
                
                for (var i = 0; i < tabBtns.length; i++) {
                    tabBtnsArray.push(tabBtns[i]);
                }
                
                // Hide all tabs function
                function hideAllTabs() {
                    for (var i = 0; i < tabsArray.length; i++) {
                        var tab = tabsArray[i];
                        if (tab.classList) {
                            tab.classList.add('hidden');
                        } else {
                            // Fallback for browsers without classList
                            tab.className = tab.className + ' hidden';
                        }
                    }
                }
                
                // Show specific tab function
                function showTab(tabId) {
                    var targetTab = document.getElementById(tabId);
                    if (targetTab) {
                        if (targetTab.classList) {
                            targetTab.classList.remove('hidden');
                        } else {
                            // Fallback for browsers without classList
                            targetTab.className = targetTab.className.replace(/\bhidden\b/g, '');
                        }
                    }
                }
                
                // Reset all tab buttons styles
                function resetTabButtonsStyles() {
                    var baseClasses = 'flex items-center w-full gap-2 p-2 font-medium cursor-pointer text-main tabbtn';
                    for (var i = 0; i < tabBtnsArray.length; i++) {
                        tabBtnsArray[i].className = baseClasses;
                    }
                }
                
                // Set active tab button style
                function setActiveTabButtonStyle(button) {
                    var activeClasses = 'flex items-center w-full gap-2 p-2 font-medium rounded-lg cursor-pointer text-main tabbtn bg-main/20';
                    button.className = activeClasses;
                }
                
                // Tab click handler function
                function handleTabClick(button) {
                    return function() {
                        try {
                            hideAllTabs();
                            
                            var tabId = button.getAttribute('data-tabopen');
                            if (tabId) {
                                // Save to localStorage if available
                                if (typeof(Storage) !== "undefined") {
                                    localStorage.setItem("openTab", tabId);
                                }
                                
                                showTab(tabId);
                                resetTabButtonsStyles();
                                setActiveTabButtonStyle(button);
                            }
                        } catch (e) {
                            console.log('Tab switching error:', e);
                        }
                    };
                }
                
                // Add click listeners to all tab buttons
                for (var i = 0; i < tabBtnsArray.length; i++) {
                    var button = tabBtnsArray[i];
                    
                    // Try modern addEventListener first, fallback to attachEvent for IE
                    if (button.addEventListener) {
                        button.addEventListener('click', handleTabClick(button));
                    } else if (button.attachEvent) {
                        button.attachEvent('onclick', handleTabClick(button));
                    } else {
                        button.onclick = handleTabClick(button);
                    }
                }
                
                // Initialize default tab
                function initializeDefaultTab() {
                    var defaultTab = 'tab1';
                    
                    // Check localStorage for saved tab
                    if (typeof(Storage) !== "undefined") {
                        var savedTab = localStorage.getItem('openTab');
                        if (savedTab) {
                            defaultTab = savedTab;
                        }
                    }
                    
                    hideAllTabs();
                    showTab(defaultTab);
                    resetTabButtonsStyles();
                    
                    // Set active button style for default tab
                    for (var i = 0; i < tabBtnsArray.length; i++) {
                        var button = tabBtnsArray[i];
                        if (button.getAttribute('data-tabopen') === defaultTab) {
                            setActiveTabButtonStyle(button);
                            break;
                        }
                    }
                }
                
                // Initialize on load
                initializeDefaultTab();
                
                // Also try to initialize when DOM is ready (for better compatibility)
                if (document.readyState === 'loading') {
                    if (document.addEventListener) {
                        document.addEventListener('DOMContentLoaded', initializeDefaultTab);
                    } else if (document.attachEvent) {
                        document.attachEvent('onreadystatechange', function() {
                            if (document.readyState === 'complete') {
                                initializeDefaultTab();
                            }
                        });
                    }
                } else {
                    initializeDefaultTab();
                }
                
            } catch (e) {
                console.log('Tab initialization error:', e);
                // Fallback: try to show first tab
                try {
                    var firstTab = document.getElementById('tab1');
                    if (firstTab && firstTab.classList) {
                        firstTab.classList.remove('hidden');
                    }
                } catch (fallbackError) {
                    console.log('Fallback error:', fallbackError);
                }
            }
        }
        
                 // Initialize tabs when page loads
         // Multiple initialization methods for maximum compatibility
         function initializePage() {
             // Run both initialization methods
             initLGTVCompatibleTabs();
             
             // Also try simple initialization
             try {
                 var defaultTab = 'tab1';
                 
                 // Check for saved tab
                 if (typeof(Storage) !== "undefined") {
                     try {
                         var savedTab = localStorage.getItem('openTab');
                         if (savedTab) {
                             defaultTab = savedTab;
                         }
                     } catch (e) {
                         // localStorage error
                     }
                 }
                 
                 // Find the button for default tab and trigger it
                 var buttons = document.getElementsByClassName('tabbtn');
                 for (var i = 0; i < buttons.length; i++) {
                     if (buttons[i].getAttribute('data-tabopen') === defaultTab) {
                         switchTab(defaultTab, buttons[i]);
                         break;
                     }
                 }
             } catch (e) {
                 // Fallback: just show first tab
                 switchTab('tab1', null);
             }
         }
         
         if (document.readyState === 'loading') {
             // If document is still loading
             if (document.addEventListener) {
                 document.addEventListener('DOMContentLoaded', initializePage);
             } else if (document.attachEvent) {
                 document.attachEvent('onreadystatechange', function() {
                     if (document.readyState === 'complete') {
                         initializePage();
                     }
                 });
             }
             // Fallback with timeout
             setTimeout(initializePage, 1000);
         } else {
             // Document is already loaded
             initializePage();
         }
         
         // Also initialize on window load as additional fallback
         if (window.addEventListener) {
             window.addEventListener('load', initializePage);
         } else if (window.attachEvent) {
             window.attachEvent('onload', initializePage);
         } else {
             window.onload = initializePage;
         }
         
         // Immediate initialization attempt
         setTimeout(function() {
             try {
                 // Find tab1 button and activate it
                 var tab1Button = null;
                 var buttons = document.getElementsByClassName('tabbtn');
                 for (var i = 0; i < buttons.length; i++) {
                     if (buttons[i].getAttribute('data-tabopen') === 'tab1') {
                         tab1Button = buttons[i];
                         break;
                     }
                 }
                 switchTab('tab1', tab1Button);
             } catch (e) {
                 // Silent fail
             }
         }, 100);

        function openAddTicket() {
            document.getElementById('addTicket').classList.remove('hidden');
        }

        function closeAddTicket() {
            document.getElementById('addTicket').classList.add('hidden');
        }
    </script>
@endsection
