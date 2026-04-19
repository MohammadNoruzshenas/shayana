@extends('customer.layouts.master')

@section('head-tag')
    <title>{{ $event->title }} - جزئیات رویداد</title>
    <meta name="description" content="{{ substr(strip_tags($event->description), 0, 160) ?? 'جزئیات رویداد' }}">
@endsection

@section('content')
    <section class="container my-5 content lg:blur-0">
        <div class="flex flex-col gap-6">

            {{-- Header --}}
            <div class="flex items-center justify-between p-6 bg-gray rounded-3xl dark:bg-dark">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-blue-600 dark:text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">{{ $event->title }}</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($event->publish_date)
                                {{ \Morilog\Jalali\Jalalian::forge($event->publish_date)->format('%A، %d %B %Y') }}
                            @else
                                رویداد
                            @endif
                        </p>
                    </div>
                </div>
                <a href="javascript:history.back()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-white/80 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    بازگشت
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Content --}}
                <div class="lg:col-span-2 flex flex-col gap-6">

                    {{-- Cover Image --}}
                    @if($event->image)
                        <div class="rounded-2xl overflow-hidden shadow-lg">
                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                                class="w-full h-72 object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    @endif

                    {{-- Description --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-secondary dark:text-white/80 mb-4">توضیحات رویداد</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            @if($event->description)
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {!! $event->description !!}
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">توضیحی برای این رویداد وجود ندارد.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Event Video --}}
                    @if($event->file_path)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-secondary dark:text-white/80 mb-4">ویدیو رویداد</h3>
                            <div class="rounded-2xl overflow-hidden bg-black aspect-video shadow-inner">
                                <video class="w-full h-full" controls poster="{{ $event->image ? asset($event->image) : '' }}">
                                    <source src="{{ asset($event->file_path) }}" type="video/mp4">
                                    مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                </video>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ asset($event->file_path) }}" download
                                    class="inline-flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    دانلود ویدیو
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 sticky top-4">
                        <h3 class="text-lg font-bold text-secondary dark:text-white/80 mb-6">اطلاعات رویداد</h3>

                        {{-- Publish Date --}}
                        @if($event->publish_date)
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">تاریخ برگزاری</label>
                                <div class="flex items-center gap-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                    </svg>
                                    <span class="text-blue-700 dark:text-blue-400 font-medium">
                                        {{ \Morilog\Jalali\Jalalian::forge($event->publish_date)->format('%A، %d %B %Y') }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- Link --}}
                        @if($event->link)
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">لینک رویداد</label>
                                <a href="{{ $event->link }}" target="_blank"
                                    class="flex items-center gap-2 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors font-medium break-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-5 h-5 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                    </svg>
                                    ورود به رویداد
                                </a>
                            </div>
                        @endif

                        {{-- Created date --}}
                        <div class="pt-5 border-t border-gray-100 dark:border-gray-700">
                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">تاریخ ثبت</label>
                            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ \Morilog\Jalali\Jalalian::fromCarbon($event->created_at)->format('Y/m/d') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
