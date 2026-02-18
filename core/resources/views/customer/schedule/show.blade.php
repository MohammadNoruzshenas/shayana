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
            <div class="w-full overflow-hidden bg-gray rounded-3xl dark:bg-dark">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-secondary dark:text-white/80 mb-6">جدول برنامه هفتگی</h3>
                    <div class="w-full overflow-x-auto">
                        <table
                            class="w-full border-collapse bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg">
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
                                    $daysOfWeek = [
                                        'روز اول',
                                        'روز دوم',
                                        'روز سوم',
                                        'روز چهارم',
                                        'روز پنجم',
                                        'روز ششم',
                                        'روز هفتم',
                                    ];
                                    $organizedSchedule = $schedule->organized_schedule;
                                @endphp
                                @foreach ($daysOfWeek as $dayIndex => $dayName)
                                    <tr
                                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td
                                            class="px-4 py-6 bg-gradient-to-r from-red-500 to-pink-500 text-dark-500 font-bold text-center">
                                            {{ $dayName }}
                                        </td>
                                        @for ($slot = 1; $slot <= 4; $slot++)
                                            @php
                                                $currentItem = $organizedSchedule[$dayIndex]['slots'][$slot] ?? null;
                                            @endphp
                                            <td
                                                class="px-4 py-4 text-center {{ $currentItem ? 'bg-green-50 dark:bg-green-900/20' : 'bg-gray-50 dark:bg-gray-800' }}">
                                                @if ($currentItem)
                                                    <div class="space-y-2">
                                                        @if ($currentItem->lession)
                                                            @php
                                                                $course = $currentItem->lession->season->parent->course;
                                                                $selectedMainSeason =
                                                                    $currentItem?->lession?->season->parent;
                                                                $selectedSeason = $currentItem?->lession?->season;
                                                                $selectedLesion = $currentItem?->lession;
                                                            @endphp
                                                            <div class="space-y-2">
                                                                <div
                                                                    class="font-bold text-green-700 dark:text-green-300 text-sm">
                                                                    🎯 {{ $selectedLesion->title }}
                                                                </div>
                                                                <div
                                                                    class="font-bold text-green-700 dark:text-green-300 text-sm">
                                                                    {{ $selectedMainSeason->title . '-' . $selectedSeason->title }}
                                                                </div>
                                                                @if ($currentItem->lession->season)
                                                                    <div class="flex justify-center gap-2 mt-2 flex-wrap">
                                                                        @if (!is_null($currentItem->lession->link))
                                                                            {{-- Download Video Icon --}}
                                                                            <a href="{{ route('customer.lesson.video.download', ['course' => $course->slug, 'lession' => $currentItem->lession]) }}"
                                                                                class="flex items-center gap-1 px-2 py-1 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors"
                                                                                title="دانلود مستقیم ویدیو">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke-width="1.5" stroke="currentColor"
                                                                                    class="w-4 h-4">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                                                </svg>
                                                                                <span>دانلود</span>
                                                                            </a>

                                                                            {{-- Open Video in New Window Icon --}}
                                                                            <a href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $currentItem->lession]) }}"
                                                                                target="_blank"
                                                                                class="flex items-center gap-1 px-2 py-1 text-xs text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors"
                                                                                title="باز کردن ویدیو در صفحه جدید">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke-width="1.5" stroke="currentColor"
                                                                                    class="w-4 h-4">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                                                </svg>
                                                                                <span>باز کردن</span>
                                                                            </a>
                                                                        @endif
                                                                        @if ($currentItem->game)
                                                                            <a href="{{ route('customer.game.show', $currentItem->game) }}"
                                                                                class="flex items-center gap-1 px-2 py-1 text-xs text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 transition-colors"
                                                                                title="مشاهده جزئیات بازی" target="_blank">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke-width="1.5"
                                                                                    stroke="currentColor" class="w-4 h-4">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M14.25 6.087c0-.355.186-.676.461-.841A6.52 6.52 0 0021 4.5c.355 0 .676.186.84.461a.844.844 0 00.15.427m-8.25 0a2.25 2.25 0 00-1.5-2.25v2.25m0 0c0 1.235.92 2.25 2.25 2.25s2.25-1.015 2.25-2.25m0 0V6.087a2.25 2.25 0 00-1.5-2.25M12 21c4.485 0 8.25-1.979 8.25-4.5S16.485 12 12 12m0 0c-4.485 0-8.25 1.979-8.25 4.5S7.515 21 12 21" />
                                                                                </svg>
                                                                                <span>بازی</span>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if ($currentItem->game)
                                                            {{-- Game Content --}}
                                                            <div
                                                                class="space-y-2 {{ $currentItem->lession ? 'mt-4' : '' }}">
                                                                <div
                                                                    class="font-bold text-purple-700 dark:text-purple-300 text-sm ">
                                                                    🎮 {{ $currentItem->game->title }}
                                                                </div>
                                                                <div
                                                                    class="font-semibold text-purple-600 dark:text-purple-400 text-xs text-center">
                                                                    {{ $currentItem->game->mainSeason->title ?? '' }}
                                                                    @if ($currentItem->game->mainSeason && $currentItem->game->subSeason)
                                                                        -
                                                                    @endif
                                                                    {{ $currentItem->game->subSeason->title ?? '' }}
                                                                </div>
                                                                <div class="flex justify-center gap-2 mt-2">
                                                                    <a href="{{ route('customer.game.show', $currentItem->game) }}"
                                                                        class="flex items-center gap-1 px-2 py-1 text-xs text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 transition-colors"
                                                                        title="مشاهده جزئیات بازی" target="_blank">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-4 h-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M14.25 6.087c0-.355.186-.676.461-.841A6.52 6.52 0 0021 4.5c.355 0 .676.186.84.461a.844.844 0 00.15.427m-8.25 0a2.25 2.25 0 00-1.5-2.25v2.25m0 0c0 1.235.92 2.25 2.25 2.25s2.25-1.015 2.25-2.25m0 0V6.087a2.25 2.25 0 00-1.5-2.25M12 21c4.485 0 8.25-1.979 8.25-4.5S16.485 12 12 12m0 0c-4.485 0-8.25 1.979-8.25 4.5S7.515 21 12 21" />
                                                                        </svg>
                                                                        <span>بازی</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($currentItem->notes)
                                                            <div
                                                                class="text-xs text-gray-600 dark:text-gray-400 italic bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                                                📝 {{ $currentItem->notes }}
                                                            </div>
                                                        @endif
                                                        @if (!$currentItem->lession && !$currentItem->game && !$currentItem->notes)
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
            </div>


        </div>
    </section>
@endsection
