@extends('customer.layouts.master')

@section('head-tag')
    <title>{{ $game->title ?? 'بازی' }} - جزئیات</title>
    <meta name="description" content="{{ substr($game->description, 0, 160) ?? 'جزئیات بازی' }}">
@endsection

@section('content')
    <section class="container my-5 content lg:blur-0">
        <div class="flex flex-col gap-6">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 bg-gray rounded-3xl dark:bg-dark">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 text-purple-600 dark:text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.25 6.087c0-.355.186-.676.461-.841A6.52 6.52 0 0021 4.5c.355 0 .676.186.84.461a.844.844 0 00.15.427m-8.25 0a2.25 2.25 0 00-1.5-2.25v2.25m0 0c0 1.235.92 2.25 2.25 2.25s2.25-1.015 2.25-2.25m0 0V6.087a2.25 2.25 0 00-1.5-2.25M12 21c4.485 0 8.25-1.979 8.25-4.5S16.485 12 12 12m0 0c-4.485 0-8.25 1.979-8.25 4.5S7.515 21 12 21" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">{{ $game->title }}
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">بازی</p>
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
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Game Image -->
                    @if ($game->image)
                        <div class="mb-6 rounded-2xl overflow-hidden shadow-lg bg-gray-200 dark:bg-gray-700">
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->title }}"
                                class="w-full h-auto hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div
                            class="mb-6 rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900/30 dark:to-blue-900/30 h-96 flex items-center justify-center">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.25 6.087c0-.355.186-.676.461-.841A6.52 6.52 0 0021 4.5c.355 0 .676.186.84.461a.844.844 0 00.15.427m-8.25 0a2.25 2.25 0 00-1.5-2.25v2.25m0 0c0 1.235.92 2.25 2.25 2.25s2.25-1.015 2.25-2.25m0 0V6.087a2.25 2.25 0 00-1.5-2.25M12 21c4.485 0 8.25-1.979 8.25-4.5S16.485 12 12 12m0 0c-4.485 0-8.25 1.979-8.25 4.5S7.515 21 12 21" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">تصویر موجود نیست</p>
                            </div>
                        </div>
                    @endif

                    <!-- Description -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 mb-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-secondary dark:text-white/80 mb-4">توضیحات</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            @if ($game->description)
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">
                                    {!! nl2br(e($game->description)) !!}
                                </p>
                            @else
                                <p class="text-gray-500 dark:text-gray-400 italic">توضیحی برای این بازی وجود ندارد.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Info Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-secondary dark:text-white/80 mb-6">اطلاعات بازی</h3>

                        <!-- Course -->
                        @if ($game->course)
                            <div class="mb-6">
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">دوره</label>
                                <div class="flex items-center gap-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5 text-blue-600 dark:text-blue-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 015.824 20.285a2.25 2.25 0 002.25 2.25h10.851A2.25 2.25 0 0021 20.285a48.627 48.627 0 01.005-6.285c-.05-.189-.122-.373-.204-.554m0 0a23.933 23.933 0 01-.07-1.148m0 0a60.672 60.672 0 015.346 4.613c.307.355.617.71.854 1.005.5.581.851 1.243.851 1.997 0 1.325-1.073 2.25-2.25 2.25h-10.5c-1.177 0-2.25-.75-2.25-2c0-.75.424-1.41.987-1.844.173-.14.371-.276.570-.42m0 0A23.933 23.933 0 0015 12a23.933 23.933 0 01-7.5-4m0 0v.008m0 0v13.5" />
                                    </svg>
                                    <a href="{{ route('customer.course.singleCourse', $game->course->slug) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                        {{ $game->course->title }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Main Season -->
                        @if ($game->mainSeason)
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">فصل</label>
                                <div
                                    class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg">
                                    <p class="text-green-700 dark:text-green-400 font-medium">{{ $game->mainSeason->title }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Sub Season -->
                        @if ($game->subSeason)
                            <div class="mb-6">
                                <label
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">زیرفصل</label>
                                <div
                                    class="p-3 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 rounded-lg">
                                    <p class="text-orange-700 dark:text-orange-400 font-medium">
                                        {{ $game->subSeason->title }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Created Date -->
                        <div class="mb-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">تاریخ
                                ایجاد</label>
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8.25v4.5m0 4.5v.008v.008m0 0a6.003 6.003 0 01-5.824-3.769m.5-2.6A6.003 6.003 0 0112 2.25a6.003 6.003 0 015.824 3.769m-1.325 6.985a6.003 6.003 0 01-5.824 3.769m7.228-7.953a6 6 0 00-5.396-3.075c-1.804 0-3.414.663-4.646 1.757" />
                                </svg>
                                <span>{{ \Morilog\Jalali\Jalalian::fromCarbon($game->created_at)->format('Y/m/d H:i') }}</span>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
