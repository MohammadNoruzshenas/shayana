@extends('customer.layouts.master')
@section('head-tag')
    <title>سبد خرید</title>
    <style>
        button:disabled,
        button[disabled] {
            border: 1px solid #999999;
            background-color: #cccccc;
            color: #666666;
        }
    </style>
@endsection
@section('content')
    <section class="container content lg:blur-0">
        <div class="flex items-center justify-between w-full my-7">
            <h1 class="text-lg font-bold lg:text-3xl text-secondary dark:text-white/80">سبد خرید</h1>
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
            <div data-aos="fade-down"
                class="flex flex-col w-full  gap-5 p-5 bg-white  shadow-lg  rounded-2xl  dark:bg-dark dark:shadow-none h-min">
                @php
                    $totalProductPrice = 0;
                    $totalDiscount = 0;
                @endphp
                @forelse ($cartItems as $cartItem)
                    @php
                        $totalProductPrice += $cartItem->cartItemProductPrice();
                        if ($cartItem->course->activeCommonDiscount() && $cartItem->course->types == 1) {
                            $totalDiscount +=
                                $cartItem->course->price *
                                ($cartItem->course->activeCommonDiscount()->percentage / 100);
                        }
                    @endphp
                    <div class="flex items-center justify-between gap-5 p-4 rounded-xl bg-main/20 lg:flex-row">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset($cartItem->course->image) }}" class="object-cover w-24  rounded-xl"
                                alt="">
                            <div class="flex flex-col gap-2">
                                <span class="text-xl font-black text-main">{{ $cartItem->course->title }}</span>
                                <div class="flex items-center text-xs gap-x-1 dark:text-white/80 text-secondary">

                                    <span class="line-through opacity-80">
                                        @if ($cartItem->course->activeCommonDiscount())
                                            {{ $cartItem->course->course_price_value }}
                                        @endif

                                    </span>
                                    <span class="text-main">
                                        {{ $cartItem->course->final_course_price_value }}

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <a href="{{ route('customer.sales-process.remove-from-cart', $cartItem) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 text-red-500 transition-all cursor-pointer hover:scale-110">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg></a>


                        </div>
                    </div>
                @empty
                    <div
                        class="flex flex-col items-center justify-between gap-5 p-4 rounded-xl bg-main/20 lg:flex-row w-full">
                        <div class="flex items-center gap-2 flex-1 ">
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

                        <a href="{{ route('customer.courses') }}"
                            class="flex items-center gap-2 justify-center text-white bg-main/70 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>

                            بریم خرید


                        </a>
                    </div>
                @endforelse

            </div>

            @if ($cartItems->count() > 0)
                <div data-aos="fade-left"
                    class="flex flex-col w-full gap-5 p-5 bg-white border shadow-lg lg:w-1/3 rounded-2xl border-main/20 dark:bg-dark dark:shadow-none dark:text-white/80 text-secondary h-min">
                    <div
                        class="flex justify-between w-full text-xl font-bold border-b  border-b-[#D1D1D1] border-dashed pb-2 ">
                        جمع کل :
                        <div class="flex items-center text-main gap-x-1">
                            <span class=" price">
                                {{ $totalProductPrice }} </span>
                            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 2" viewBox="0 0 51.29 27.19"
                                class="w-8 h-8">
                                <path
                                    d="M36.48 22.85c1.78-.83 2.93-1.81 3.45-2.94h-1.65c-2.53 0-4.69-.66-6.47-1.97-.59.68-1.23 1.2-1.93 1.55s-1.54.53-2.5.53c-1.03 0-1.87-.18-2.51-.53-.65-.35-1.14-.96-1.5-1.83-.35-.87-.56-2.08-.63-3.62-.02-.28-.04-.6-.04-.97s-.01-.72-.04-1.07c-.14-3.42-.28-6.26-.42-8.51l-5.8 1.37c.73 1.64 1.34 3.34 1.83 5.08.49 1.75.74 3.58.74 5.5 0 1.6-.37 3.12-1.11 4.57-.74 1.46-1.85 2.64-3.32 3.57-1.48.93-3.27 1.39-5.38 1.39s-3.82-.45-5.21-1.34C2.61 22.74 1.6 21.6.96 20.22c-.63-1.38-.95-2.84-.95-4.36 0-1.2.13-2.28.4-3.25.27-.97.63-1.93 1.07-2.87l2.39 1.34c-.38.92-.65 1.71-.83 2.39-.18.68-.26 1.48-.26 2.39 0 1.76.49 3.19 1.48 4.29s2.63 1.65 4.92 1.65c1.55 0 2.87-.32 3.96-.95 1.09-.63 1.9-1.44 2.43-2.43.53-.98.79-1.98.79-2.99 0-2.65-.82-5.82-2.46-9.5l1.69-3.52L22.38.79c.16-.05.39-.07.67-.07.54 0 .98.19 1.32.56s.53.88.58 1.51c.14 2.04.27 5.02.39 8.94.02.38.04.75.04 1.13s.01.71.04 1.02c.05 1.03.22 1.78.53 2.25s.81.7 1.51.7c.84 0 1.52-.18 2.04-.53.52-.35.97-1 1.37-1.93.75-1.71 1.33-2.96 1.74-3.75.41-.79.94-1.46 1.58-2.04.64-.57 1.44-.86 2.37-.86 1.83 0 3.27.94 4.31 2.83s1.69 4.06 1.95 6.53c1.57-.02 2.77-.13 3.61-.33.83-.2 1.41-.49 1.72-.88.32-.39.47-.89.47-1.5 0-.75-.16-1.67-.49-2.76-.33-1.09-.69-2.1-1.09-3.04l2.43-1.23c1.22 3.1 1.83 5.44 1.83 7.04 0 1.83-.67 3.18-2 4.04-1.34.87-3.53 1.34-6.58 1.41-.49 2.21-1.8 3.93-3.92 5.19-2.12 1.25-4.68 1.98-7.69 2.16l-1.2-2.88c2.6-.14 4.8-.63 6.58-1.46ZM10.38 5.66l.11 3.31-3.2.28-.46-3.31 3.55-.28Zm25.1 10.83c.88.28 1.81.42 2.8.42h1.93c-.16-1.67-.55-3.08-1.16-4.26-.61-1.17-1.38-1.76-2.32-1.76-.75 0-1.42.45-2.02 1.34-.6.89-1.11 1.92-1.53 3.1.66.49 1.42.88 2.3 1.16ZM43.64.21C45.06.07 46.43 0 47.74 0c.96 0 1.67.02 2.11.07l-.21 2.81c-.42-.05-1.08-.07-1.97-.07-1.2 0-2.44.07-3.73.21s-2.44.32-3.45.53L39.86.81c1.1-.26 2.36-.46 3.78-.6Z"
                                    data-name="Layer 1" style="fill: currentcolor;"></path>
                            </svg>
                        </div>
                    </div>
                    <form action="{{ route('customer.sales-process.copan-discount') }}" method="post">
                        @csrf
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">کد
                            تخفیف</label>
                        <div class="relative">
                            <input type="text" name="copan"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 0 focus:border-main dark:focus:bg-secondary dark:bg-secondary dark:border-gray-600 dark:placeholder-white-80 dark:text-white"
                                placeholder="کد تخفیف">
                            <button type="submit"
                                class="text-white absolute left-2.5 bottom-2.5 bg-main/90 hover:bg-main focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-4 py-2">اعمال</button>
                        </div>
                    </form>
                    @error('copan')
                        <p class="font-bold text-red-500">{{ $message }}</p>
                    @enderror
                    {{-- @dd( Session::get('data')) --}}
                    <p>{{ Session::get('copan') }}</p>
                    @if ($totalDiscount > 0)
                        <div class="flex items-center justify-between">
                            <span>تخفیف عمومی : </span>
                            <div class="flex items-center text-red-500 gap-x-1">
                                <span class=" price">
                                    {{ $totalDiscount }} </span>
                                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 2" viewBox="0 0 51.29 27.19"
                                    class="w-5 h-5">
                                    <path
                                        d="M36.48 22.85c1.78-.83 2.93-1.81 3.45-2.94h-1.65c-2.53 0-4.69-.66-6.47-1.97-.59.68-1.23 1.2-1.93 1.55s-1.54.53-2.5.53c-1.03 0-1.87-.18-2.51-.53-.65-.35-1.14-.96-1.5-1.83-.35-.87-.56-2.08-.63-3.62-.02-.28-.04-.6-.04-.97s-.01-.72-.04-1.07c-.14-3.42-.28-6.26-.42-8.51l-5.8 1.37c.73 1.64 1.34 3.34 1.83 5.08.49 1.75.74 3.58.74 5.5 0 1.6-.37 3.12-1.11 4.57-.74 1.46-1.85 2.64-3.32 3.57-1.48.93-3.27 1.39-5.38 1.39s-3.82-.45-5.21-1.34C2.61 22.74 1.6 21.6.96 20.22c-.63-1.38-.95-2.84-.95-4.36 0-1.2.13-2.28.4-3.25.27-.97.63-1.93 1.07-2.87l2.39 1.34c-.38.92-.65 1.71-.83 2.39-.18.68-.26 1.48-.26 2.39 0 1.76.49 3.19 1.48 4.29s2.63 1.65 4.92 1.65c1.55 0 2.87-.32 3.96-.95 1.09-.63 1.9-1.44 2.43-2.43.53-.98.79-1.98.79-2.99 0-2.65-.82-5.82-2.46-9.5l1.69-3.52L22.38.79c.16-.05.39-.07.67-.07.54 0 .98.19 1.32.56s.53.88.58 1.51c.14 2.04.27 5.02.39 8.94.02.38.04.75.04 1.13s.01.71.04 1.02c.05 1.03.22 1.78.53 2.25s.81.7 1.51.7c.84 0 1.52-.18 2.04-.53.52-.35.97-1 1.37-1.93.75-1.71 1.33-2.96 1.74-3.75.41-.79.94-1.46 1.58-2.04.64-.57 1.44-.86 2.37-.86 1.83 0 3.27.94 4.31 2.83s1.69 4.06 1.95 6.53c1.57-.02 2.77-.13 3.61-.33.83-.2 1.41-.49 1.72-.88.32-.39.47-.89.47-1.5 0-.75-.16-1.67-.49-2.76-.33-1.09-.69-2.1-1.09-3.04l2.43-1.23c1.22 3.1 1.83 5.44 1.83 7.04 0 1.83-.67 3.18-2 4.04-1.34.87-3.53 1.34-6.58 1.41-.49 2.21-1.8 3.93-3.92 5.19-2.12 1.25-4.68 1.98-7.69 2.16l-1.2-2.88c2.6-.14 4.8-.63 6.58-1.46ZM10.38 5.66l.11 3.31-3.2.28-.46-3.31 3.55-.28Zm25.1 10.83c.88.28 1.81.42 2.8.42h1.93c-.16-1.67-.55-3.08-1.16-4.26-.61-1.17-1.38-1.76-2.32-1.76-.75 0-1.42.45-2.02 1.34-.6.89-1.11 1.92-1.53 3.1.66.49 1.42.88 2.3 1.16ZM43.64.21C45.06.07 46.43 0 47.74 0c.96 0 1.67.02 2.11.07l-.21 2.81c-.42-.05-1.08-.07-1.97-.07-1.2 0-2.44.07-3.73.21s-2.44.32-3.45.53L39.86.81c1.1-.26 2.36-.46 3.78-.6Z"
                                        data-name="Layer 1" style="fill: currentcolor;"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                    @if (Session::get('data'))
                        <input type="hidden" form="myForm" name="copan" value="{{ Session::get('data')['code'] }}"
                            hidden
                            class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 0 focus:border-main dark:focus:bg-secondary dark:bg-secondary dark:border-gray-600 dark:placeholder-white-80 dark:text-white"
                            placeholder="کد تخفیف">
                        <div class="flex items-center justify-between">
                            <span>تخفیف کوپن : </span>
                            <div class="flex items-center text-red-500 gap-x-1">
                                <span class=" price">
                                    {{ ($totalProductPrice - $totalDiscount) * (Session::get('data')->amount / 100) }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 2" viewBox="0 0 51.29 27.19"
                                    class="w-5 h-5">
                                    <path
                                        d="M36.48 22.85c1.78-.83 2.93-1.81 3.45-2.94h-1.65c-2.53 0-4.69-.66-6.47-1.97-.59.68-1.23 1.2-1.93 1.55s-1.54.53-2.5.53c-1.03 0-1.87-.18-2.51-.53-.65-.35-1.14-.96-1.5-1.83-.35-.87-.56-2.08-.63-3.62-.02-.28-.04-.6-.04-.97s-.01-.72-.04-1.07c-.14-3.42-.28-6.26-.42-8.51l-5.8 1.37c.73 1.64 1.34 3.34 1.83 5.08.49 1.75.74 3.58.74 5.5 0 1.6-.37 3.12-1.11 4.57-.74 1.46-1.85 2.64-3.32 3.57-1.48.93-3.27 1.39-5.38 1.39s-3.82-.45-5.21-1.34C2.61 22.74 1.6 21.6.96 20.22c-.63-1.38-.95-2.84-.95-4.36 0-1.2.13-2.28.4-3.25.27-.97.63-1.93 1.07-2.87l2.39 1.34c-.38.92-.65 1.71-.83 2.39-.18.68-.26 1.48-.26 2.39 0 1.76.49 3.19 1.48 4.29s2.63 1.65 4.92 1.65c1.55 0 2.87-.32 3.96-.95 1.09-.63 1.9-1.44 2.43-2.43.53-.98.79-1.98.79-2.99 0-2.65-.82-5.82-2.46-9.5l1.69-3.52L22.38.79c.16-.05.39-.07.67-.07.54 0 .98.19 1.32.56s.53.88.58 1.51c.14 2.04.27 5.02.39 8.94.02.38.04.75.04 1.13s.01.71.04 1.02c.05 1.03.22 1.78.53 2.25s.81.7 1.51.7c.84 0 1.52-.18 2.04-.53.52-.35.97-1 1.37-1.93.75-1.71 1.33-2.96 1.74-3.75.41-.79.94-1.46 1.58-2.04.64-.57 1.44-.86 2.37-.86 1.83 0 3.27.94 4.31 2.83s1.69 4.06 1.95 6.53c1.57-.02 2.77-.13 3.61-.33.83-.2 1.41-.49 1.72-.88.32-.39.47-.89.47-1.5 0-.75-.16-1.67-.49-2.76-.33-1.09-.69-2.1-1.09-3.04l2.43-1.23c1.22 3.1 1.83 5.44 1.83 7.04 0 1.83-.67 3.18-2 4.04-1.34.87-3.53 1.34-6.58 1.41-.49 2.21-1.8 3.93-3.92 5.19-2.12 1.25-4.68 1.98-7.69 2.16l-1.2-2.88c2.6-.14 4.8-.63 6.58-1.46ZM10.38 5.66l.11 3.31-3.2.28-.46-3.31 3.55-.28Zm25.1 10.83c.88.28 1.81.42 2.8.42h1.93c-.16-1.67-.55-3.08-1.16-4.26-.61-1.17-1.38-1.76-2.32-1.76-.75 0-1.42.45-2.02 1.34-.6.89-1.11 1.92-1.53 3.1.66.49 1.42.88 2.3 1.16ZM43.64.21C45.06.07 46.43 0 47.74 0c.96 0 1.67.02 2.11.07l-.21 2.81c-.42-.05-1.08-.07-1.97-.07-1.2 0-2.44.07-3.73.21s-2.44.32-3.45.53L39.86.81c1.1-.26 2.36-.46 3.78-.6Z"
                                        data-name="Layer 1" style="fill: currentcolor;"></path>
                                </svg>
                            </div>
                        </div>
                    @endif

                    @php
                        $TotalPrice = $totalProductPrice - $totalDiscount;
                        if (Session::get('data')) {
                            $TotalPrice = $TotalPrice - $TotalPrice * (Session::get('data')->amount / 100);
                        }
                    @endphp
                    <div class="flex items-center justify-between">
                        <span>قابل پرداخت : </span>
                        <div class="flex items-center text-teal-600 dark:text-teal-300 gap-x-1">
                            <span class=" price">
                                {{ $TotalPrice }} </span>
                            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 2" viewBox="0 0 51.29 27.19"
                                class="w-5 h-5">
                                <path
                                    d="M36.48 22.85c1.78-.83 2.93-1.81 3.45-2.94h-1.65c-2.53 0-4.69-.66-6.47-1.97-.59.68-1.23 1.2-1.93 1.55s-1.54.53-2.5.53c-1.03 0-1.87-.18-2.51-.53-.65-.35-1.14-.96-1.5-1.83-.35-.87-.56-2.08-.63-3.62-.02-.28-.04-.6-.04-.97s-.01-.72-.04-1.07c-.14-3.42-.28-6.26-.42-8.51l-5.8 1.37c.73 1.64 1.34 3.34 1.83 5.08.49 1.75.74 3.58.74 5.5 0 1.6-.37 3.12-1.11 4.57-.74 1.46-1.85 2.64-3.32 3.57-1.48.93-3.27 1.39-5.38 1.39s-3.82-.45-5.21-1.34C2.61 22.74 1.6 21.6.96 20.22c-.63-1.38-.95-2.84-.95-4.36 0-1.2.13-2.28.4-3.25.27-.97.63-1.93 1.07-2.87l2.39 1.34c-.38.92-.65 1.71-.83 2.39-.18.68-.26 1.48-.26 2.39 0 1.76.49 3.19 1.48 4.29s2.63 1.65 4.92 1.65c1.55 0 2.87-.32 3.96-.95 1.09-.63 1.9-1.44 2.43-2.43.53-.98.79-1.98.79-2.99 0-2.65-.82-5.82-2.46-9.5l1.69-3.52L22.38.79c.16-.05.39-.07.67-.07.54 0 .98.19 1.32.56s.53.88.58 1.51c.14 2.04.27 5.02.39 8.94.02.38.04.75.04 1.13s.01.71.04 1.02c.05 1.03.22 1.78.53 2.25s.81.7 1.51.7c.84 0 1.52-.18 2.04-.53.52-.35.97-1 1.37-1.93.75-1.71 1.33-2.96 1.74-3.75.41-.79.94-1.46 1.58-2.04.64-.57 1.44-.86 2.37-.86 1.83 0 3.27.94 4.31 2.83s1.69 4.06 1.95 6.53c1.57-.02 2.77-.13 3.61-.33.83-.2 1.41-.49 1.72-.88.32-.39.47-.89.47-1.5 0-.75-.16-1.67-.49-2.76-.33-1.09-.69-2.1-1.09-3.04l2.43-1.23c1.22 3.1 1.83 5.44 1.83 7.04 0 1.83-.67 3.18-2 4.04-1.34.87-3.53 1.34-6.58 1.41-.49 2.21-1.8 3.93-3.92 5.19-2.12 1.25-4.68 1.98-7.69 2.16l-1.2-2.88c2.6-.14 4.8-.63 6.58-1.46ZM10.38 5.66l.11 3.31-3.2.28-.46-3.31 3.55-.28Zm25.1 10.83c.88.28 1.81.42 2.8.42h1.93c-.16-1.67-.55-3.08-1.16-4.26-.61-1.17-1.38-1.76-2.32-1.76-.75 0-1.42.45-2.02 1.34-.6.89-1.11 1.92-1.53 3.1.66.49 1.42.88 2.3 1.16ZM43.64.21C45.06.07 46.43 0 47.74 0c.96 0 1.67.02 2.11.07l-.21 2.81c-.42-.05-1.08-.07-1.97-.07-1.2 0-2.44.07-3.73.21s-2.44.32-3.45.53L39.86.81c1.1-.26 2.36-.46 3.78-.6Z"
                                    data-name="Layer 1" style="fill: currentcolor;"></path>
                            </svg>
                        </div>
                    </div>
                    <form action="{{ route('customer.sales-process.payment') }}" method="post" id="myForm">
                        @csrf
                    </form>
                    @if (is_null(cache('gateway')) || cache('settings')['stop_selling'] == 1)
                        <button
                            class=" w-full  text-white bg-main/90  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center  flex items-center gap-2 justify-center"
                            type="button" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            پرداخت موقتا غیرفعال است
                        </button>
                    @else
                        <button
                            class=" w-full  text-white bg-main/90 hover:bg-main  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center  flex items-center gap-2 justify-center"
                            type="button" onclick="document.getElementById('myForm').submit();ButtonDisableR()" id="SubmitButtonPay">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            پرداخت
                        </button>
                    @endif


                </div>
            @endif


        </div>

        </div>



    </section>

@endsection
@section('script')
<script>
    function ButtonDisableR() {
    setTimeout(() => {
        document.getElementById("SubmitButtonPay").setAttribute("disabled", "true");
    }, 1);
    }
    function submitReset(){
        document.getElementById("SubmitButtonPay").disabled = false;
    }
</script>
@endsection
