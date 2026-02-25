@extends('customer.layouts.master')
@section('head-tag')
    <title>جزئیات برنامه هفتگی - {{ $schedule->title ?? 'برنامه هفتگی' }}</title>
@endsection

@section('content')
    <section class="container my-5 content lg:blur-0">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 bg-gray rounded-3xl dark:bg-dark">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-main/10 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-main">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 002.25 2.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">
                            {{ $schedule->title ?? 'برنامه هفتگی' }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            هفته {{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->week_start_date)->format('Y/m/d') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.schedule.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-white/80 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 17.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        همه برنامه‌ها
                    </a>
                    <a href="{{ route('customer.profile') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-white/80 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        پروفایل
                    </a>
                </div>
            </div>

            <!-- Schedule Info -->
            <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    <div class="text-center">
                        <span class="block text-lg font-bold text-blue-600 dark:text-blue-300">
                            {{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->week_start_date)->format('Y/m/d') }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">تاریخ شروع هفته</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-lg font-bold text-green-600 dark:text-green-300">
                            {{ $schedule->scheduleItems->count() }} آیتم
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">تعداد برنامه‌ها</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-lg font-bold text-green-600">
                            {{ $schedule->status_value }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">وضعیت</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-lg font-bold text-purple-600 dark:text-purple-400">
                            {{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->created_at)->format('Y/m/d H:i') }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">تاریخ ایجاد</span>
                    </div>
                </div>
            </div>

            <!-- Weekly Schedule Table -->
            <div class="w-full bg-gray rounded-3xl dark:bg-dark">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-secondary dark:text-white/80 mb-6">جدول برنامه هفتگی</h3>

                    <!-- Responsive Schedule Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @php
                            $daysOfWeek = [
                                ['name' => 'روز اول', 'color' => '#ED1C24'],
                                ['name' => 'روز دوم', 'color' => '#F15A25'],
                                ['name' => 'روز سوم', 'color' => '#68C184'],
                                ['name' => 'روز چهارم', 'color' => '#FFD400'],
                                ['name' => 'روز پنجم', 'color' => '#BD1A8D'],
                                ['name' => 'روز ششم', 'color' => '#14B1E7'],
                                ['name' => 'روز هفتم', 'color' => '#2E3192'],
                            ];
                            $organizedSchedule = $schedule->organized_schedule;
                        @endphp
                        @foreach ($daysOfWeek as $dayIndex => $day)
                            <div
                                class="rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden backdrop-blur-sm hover:shadow-2xl dark:hover:shadow-2xl dark:hover:shadow-gray-900/50 transition-all duration-500 ease-out transform hover:-translate-y-1 hover:scale-105 scroll-smooth">
                                <!-- Day Header -->
                                <div style="background: linear-gradient(135deg, {{ $day['color'] }} 0%, {{ $day['color'] }}dd 100%)"
                                    class="px-6 py-4 border-b text-white transition-all duration-500">
                                    <h4 class="text-lg font-semibold tracking-wide">
                                        {{ $day['name'] }}
                                    </h4>
                                </div>

                                <!-- Time Slots -->
                                <div
                                    class="px-6 py-4 space-y-3 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent hover:scrollbar-thumb-gray-400 dark:hover:scrollbar-thumb-gray-500 scroll-smooth">
                                    @for ($slot = 1; $slot <= 4; $slot++)
                                        @php
                                            $currentItem = $organizedSchedule[$dayIndex]['slots'][$slot] ?? null;
                                        @endphp
                                        <div
                                            class="pb-3 {{ $slot !== 4 ? 'border-b border-gray-200 dark:border-gray-700' : '' }} transition-all duration-300">
                                            <div
                                                class="text-xs font-medium text-gray-400 dark:text-gray-500 mb-2 transition-colors duration-300">
                                                تایم {{ $slot }}
                                            </div>

                                            @if ($currentItem)
                                                @if ($currentItem->lession)
                                                    @php
                                                        $course = $currentItem->lession->season->parent->course;
                                                        $selectedMainSeason = $currentItem?->lession?->season->parent;
                                                        $selectedSeason = $currentItem?->lession?->season;
                                                        $selectedLesion = $currentItem?->lession;
                                                    @endphp
                                                    <div style="border-left: 4px solid {{ $day['color'] }}"
                                                        class="rounded-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-3 space-y-2 transition-all duration-300 hover:shadow-md dark:hover:shadow-lg dark:hover:shadow-gray-900/30 hover:border-opacity-50 hover:scale-105 origin-left cursor-default">
                                                        <div style="color: {{ $day['color'] }}"
                                                            class="text-sm font-bold transition-all duration-300">
                                                            {{ $selectedLesion->title }}
                                                        </div>
                                                        <div style="color: {{ $day['color'] }}; opacity: 0.8"
                                                            class="text-xs font-medium transition-opacity duration-300 group-hover:opacity-100">
                                                            {{ $selectedMainSeason->title }} -
                                                            {{ $selectedSeason->title }}
                                                        </div>

                                                        @if ($currentItem->notes)
                                                            <div style="background-color: {{ $day['color'] }}15; border-left: 2px solid {{ $day['color'] }}"
                                                                class="text-xs italic p-2 rounded">
                                                                📝 {{ $currentItem->notes }}
                                                            </div>
                                                        @endif

                                                        @if ($currentItem->lession->season)
                                                            <div class="flex gap-2 pt-2">
                                                                @if (!is_null($currentItem->lession->link))
                                                                    <a href="{{ route('customer.lesson.video.download', ['course' => $course->slug, 'lession' => $currentItem->lession]) }}"
                                                                        style="color: {{ $day['color'] }}; border: 1px solid {{ $day['color'] }}; background-color: {{ $day['color'] }}08"
                                                                        class="flex-1 inline-flex items-center justify-center gap-1 px-2 py-1.5 text-xs font-medium rounded-md hover:shadow-md hover:scale-110 hover:bg-opacity-50 transition-all duration-300 ease-out transform"
                                                                        title="دانلود ویدیو">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="currentColor"
                                                                            class="w-4 h-4 transition-transform duration-300 group-hover:scale-110">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                                        </svg>
                                                                        دانلود
                                                                    </a>
                                                                    <a href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $currentItem->lession]) }}"
                                                                        target="_blank"
                                                                        style="color: {{ $day['color'] }}; border: 1px solid {{ $day['color'] }}; background-color: {{ $day['color'] }}08"
                                                                        class="flex-1 inline-flex items-center justify-center gap-1 px-2 py-1.5 text-xs font-medium rounded-md hover:shadow-md hover:scale-110 hover:bg-opacity-50 transition-all duration-300 ease-out transform"
                                                                        title="باز کردن ویدیو">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="currentColor"
                                                                            class="w-4 h-4 transition-transform duration-300 group-hover:scale-110">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                                        </svg>
                                                                        باز کردن
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        @if ($currentItem->game)
                                                            <div class="pt-2">
                                                                <a href="{{ route('customer.game.show', $currentItem->game) }}"
                                                                    target="_blank"
                                                                    style="color: white; background-color: {{ $day['color'] }}"
                                                                    class="w-full inline-flex items-center justify-center gap-1 px-2 py-1.5 text-xs font-medium rounded-md hover:shadow-lg hover:scale-110 transition-all duration-300 ease-out transform"
                                                                    title="انجام بازی">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor"
                                                                        class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                                    </svg>
                                                                    بازی
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="text-xs text-gray-400 dark:text-gray-500 italic">
                                                        خالی
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-xs text-gray-400 dark:text-gray-500 italic">
                                                    خالی
                                                </div>
                                            @endif
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
