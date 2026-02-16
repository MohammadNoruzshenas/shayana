@extends('customer.layouts.master')
@section('head-tag')
    <title>برنامه‌های هفتگی من</title>
@endsection

@section('content')
<section class="container my-5 content lg:blur-0">
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 bg-gray rounded-3xl dark:bg-dark">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-main/10 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-main">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 002.25 2.25v7.5" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">برنامه‌های هفتگی من</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">مشاهده و مدیریت تمامی برنامه‌های هفتگی شما</p>
                </div>
            </div>
            <a href="{{ route('customer.profile') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-white/80 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                بازگشت به پروفایل
            </a>
        </div>



        <!-- Schedules List -->
        <div class="p-6 bg-gray rounded-3xl dark:bg-dark">
            @if($schedules->count() > 0)
                <div class="space-y-6">
                    @foreach($schedules->groupBy('week_start_date') as $weekStartDate => $weekSchedules)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                            <!-- Week Header -->
                            <div class="bg-gradient-to-r from-main/10 to-blue-500/10 dark:from-main/20 dark:to-blue-500/20 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-main/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-main">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 002.25 2.25v7.5" />
                                            </svg>
                                        </div>
                                        <div>

                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $weekSchedules->count() }} برنامه در این هفته</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Week Schedules -->
                            <div class="p-4 space-y-4">
                                @foreach($weekSchedules as $schedule)
                                    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h4 class="text-lg font-semibold text-secondary dark:text-white/80">
                                                        {{ $schedule->title ?? 'برنامه هفتگی' }}
                                                    </h4>
                                                    <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                                                        {{ $schedule->status_value }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        ایجاد شده: {{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->created_at)->format('Y/m/d H:i') }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                        </svg>
                                                        {{ $schedule->scheduleItems->count() }} آیتم
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('customer.schedule.show', $schedule) }}" 
                                                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition bg-main rounded-lg hover:bg-main/80 focus:outline-none focus:ring-2 focus:ring-main/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    مشاهده جزئیات
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $schedules->links('customer.layouts.paginate') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 002.25 2.25v7.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">هیچ برنامه‌ای یافت نشد</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">در حال حاضر هیچ برنامه هفتگی‌ای برای شما تعریف نشده است.</p>
                    <p class="text-gray-500 dark:text-gray-400">لطفاً با پشتیبانی تماس بگیرید تا برنامه‌های هفتگی شما تنظیم شود.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection 