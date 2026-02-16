@extends('customer.layouts.master')
@section('head-tag')
    <title> {{ $course->title }}</title>
    <meta name="description" content="{{ $course->summary }}" />
    <link rel="stylesheet" href="{{ asset('customer/css/star.css') }}">
    <meta property="og:title" content="{{ $course->title }}">
    <meta property="og:description" content="{{ $course->summary }}">
    <meta property="og:image" content="{{ asset($course->image) }}">
    <meta property="og:url" content="{{ route('customer.course.singleCourse', $course->slug) }}">
    <meta name="twitter:title" content="{{ $course->title }}">
    <meta name="twitter:description" content="{{ $course->body }}">
    <meta name="twitter:url" content="{{ asset($course->image) }}">
    <meta name="twitter:card" content="{{ $course->summary }}">
    <link rel="stylesheet" href="{{ asset('customer/css/plyr.css') }}" />
    <style>
        /* Ensure accordion hidden class works with high specificity */
        .hidden {
            display: none !important;
        }
        
        /* Smooth accordion transitions */
        [id^="accordion-flush-body"] {
            transition: all 0.3s ease;
        }
        
        /* Ensure accordion content is visible when not hidden */
        [id^="accordion-flush-body"]:not(.hidden) {
            display: block !important;
        }
    </style>
@endsection


@section('content')
    <section class="container content lg:blur-0">
        <div class="flex items-center justify-between w-full my-7">
            <h1 class="text-lg font-bold lg:text-3xl text-secondary dark:text-white/80">{{ $course->title }}</h1>
            <a href="{{ route('customer.courses') }}"
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

        <div class="flex flex-col justify-between h-auto gap-6 py-5 lg:flex-row text-a-color">

            <div class="flex flex-col w-full gap-10 lg:w-2/3">
                <div class=" overflow-hidden  flex flex-col gap-10 p-5 bg-white  shadow-lg rounded-2xl  dark:bg-dark dark:shadow-none contentDiv relative"
                    style="max-height: 40rem;" data-aos="fade-down">
                    @if ($course->video_link)
                        <video class="transition-all duration-300 rounded-xl hover:scale-[.98]" id="player" playsinline
                            preload="none" controls data-poster="{{ asset($course->image) }}">
                            <source src="{{ $showOnlineVideo }}" type="video/mp4" />
                        </video>
                    @else
                        <img src="{{ asset($course->image) }}" alt="{{ $course->title }}"
                            class="transition-all duration-300 rounded-xl hover:scale-[.98]">
                    @endif
                    <div class="flex flex-col gap-5 dark:text-white/80 text-secondary text-a-color">
                        {!! $course->body !!}
{{--                        @if ($course->prerequisite)--}}
{{--                            <div class="flex flex-col gap-5">--}}
{{--                                <h3 class="text-2xl font-bold text-main">پیش نیاز های این دوره آموزشی</h3>--}}
{{--                                <p class="text-[#7D7D7D] font-light text-sm text-justify dark:text-white/80">برای این دوره--}}
{{--                                    نیاز--}}
{{--                                    به--}}
{{--                                    آشنایی با <span class="text-main">{{ $course->prerequisite }}</span></p>--}}
{{--                            </div>--}}
{{--                        @endif--}}



                    </div>

                    <div
                        class="absolute bottom-0 right-0 left-0 h-80 bg-gradient-to-t from-white dark:from-gray-800 flex justify-center items-end p-5 overlayDiv">

                    </div>
                    <button
                        class="inline-flex absolute left-0 right-0  items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-main/90 rounded-lg hover:bg-main showMoreBtn"
                        style="    width: max-content;
                 left: 0;
             right: 0;
             bottom:0;
                margin: 10px auto;"
                        onclick="toggleShowMore(this); return false;">مشاهده
                        بیشتر</button>

                </div>
                <div class="overflow-hidden p-5 bg-white  shadow-lg verflow-hidden rounded-2xl  dark:bg-dark dark:shadow-none mainForm py-10"
                    data-aos="fade-up">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-secondary lg:text-2xl dark:text-white">سبک ها </h2>

                    </div>
                    <div id="showLesson" class="flex flex-col text-main gap-6  rounded-lg"
                        @forelse ($course->season()->whereNull('parent_id')->where('confirmation_status', 1)->orderBy('number','asc')->get() as $mainSeason)
                            <!-- Main Season Accordion -->
                            <h2 id="accordion-flush-heading-main-{{ $mainSeason->id }}">
                                <button
                                    class="flex items-center justify-between w-full px-3 py-5 font-medium text-left text-gray-500 dark:border-gray-700 dark:text-gray-400  dark:bg-secondary rounded-lg bg-gray-200"
                                    data-accordion-target="#accordion-flush-body-main-{{ $mainSeason->id }}"
                                    aria-expanded="false" aria-controls="accordion-flush-body-main-{{ $mainSeason->id }}"
                                    onclick="toggleMainAccordion(this); return false;">
                                    <span class="lg:text-2xl font-bold">{{ $mainSeason->title }}</span>
                                    <svg viewBox="0 0 26 30" xmlns="http://www.w3.org/2000/svg" data-accordion-icon
                                        class="w-5 h-5 shrink-0 " style="rotate: 270deg;" aria-hidden="true"
                                        fill="currentColor">
                                        <path
                                            d="M1.423 12.1725C1.5643 12.0275 2.0977 11.4075 2.5945 10.8975C5.5073 7.69 13.1059 2.44 17.0831 0.8375C17.687 0.58 19.2141 0.035 20.03 0C20.8117 0 21.557 0.18 22.2681 0.545C23.1547 1.055 23.8658 1.8575 24.2555 2.805C24.5063 3.4625 24.896 5.43 24.896 5.465C25.2857 7.6175 25.5 11.115 25.5 14.98C25.5 18.6625 25.2857 22.0175 24.9666 24.2025C24.9301 24.2375 24.5404 26.6825 24.1142 27.52C23.3324 29.05 21.8054 30 20.1712 30H20.03C18.9657 29.9625 16.7275 29.0125 16.7275 28.9775C12.9647 27.3725 5.5414 22.38 2.558 19.0625C2.558 19.0625 1.7177 18.21 1.3524 17.6775C0.782502 16.9125 0.500002 15.965 0.500002 15.0175C0.500002 13.96 0.819002 12.975 1.423 12.1725Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-flush-body-main-{{ $mainSeason->id }}"
                                class="hidden dark:bg-secondary px-3  rounded-lg"
                                aria-labelledby="accordion-flush-heading-main-{{ $mainSeason->id }}">

                                <!-- Child Seasons -->
                                @forelse ($mainSeason->children()->where('confirmation_status', 1)->orderBy('number','asc')->get() as $childSeason)
                                    <div class="my-4">
                                        <h3 id="accordion-flush-heading-child-{{ $childSeason->id }}">
                                            <button
                                                class="child-accordion-btn flex items-center justify-between w-full px-3 py-4 font-medium text-left text-gray-600 dark:border-gray-600 dark:text-gray-300 dark:bg-gray-700 rounded-lg bg-gray-100 ml-4"
                                                data-child-target="#accordion-flush-body-child-{{ $childSeason->id }}"
                                                aria-expanded="false" aria-controls="accordion-flush-body-child-{{ $childSeason->id }}"
                                                onclick="toggleChildAccordion(this); return false;">
                                                <span class="lg:text-lg">{{ $childSeason->title }}</span>
                                                <svg viewBox="0 0 26 30" xmlns="http://www.w3.org/2000/svg" class="child-accordion-icon w-4 h-4 shrink-0 transition-transform duration-200" style="rotate: 270deg;" aria-hidden="true"
                                                    fill="currentColor">
                                                    <path
                                                        d="M1.423 12.1725C1.5643 12.0275 2.0977 11.4075 2.5945 10.8975C5.5073 7.69 13.1059 2.44 17.0831 0.8375C17.687 0.58 19.2141 0.035 20.03 0C20.8117 0 21.557 0.18 22.2681 0.545C23.1547 1.055 23.8658 1.8575 24.2555 2.805C24.5063 3.4625 24.896 5.43 24.896 5.465C25.2857 7.6175 25.5 11.115 25.5 14.98C25.5 18.6625 25.2857 22.0175 24.9666 24.2025C24.9301 24.2375 24.5404 26.6825 24.1142 27.52C23.3324 29.05 21.8054 30 20.1712 30H20.03C18.9657 29.9625 16.7275 29.0125 16.7275 28.9775C12.9647 27.3725 5.5414 22.38 2.558 19.0625C2.558 19.0625 1.7177 18.21 1.3524 17.6775C0.782502 16.9125 0.500002 15.965 0.500002 15.0175C0.500002 13.96 0.819002 12.975 1.423 12.1725Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </h3>
                                        <div id="accordion-flush-body-child-{{ $childSeason->id }}"
                                            class="hidden px-3 ml-8 rounded-lg"
                                            aria-labelledby="accordion-flush-heading-child-{{ $childSeason->id }}">

                                            <!-- Lessons for Child Season -->
                                            @forelse ($childSeason->lession->where('confirmation_status', 1) as $lession)
                                                <div
                                                    class="md:flex items-center gap-2.5 flex-wrap space-y-3.5 md:space-y-0 p-3 md:py-4  group justify-between my-5 bg-gray-200 dark:bg-dark rounded-lg">

                                                    <span class="flex items-center gap-x-1.5 md:gap-x-2.5 shrink-0  ">
                                                        <span
                                                            class="flex items-center justify-center w-5 h-5 text-xs transition-colors bg-white rounded-md shrink-0 md:w-7 md:h-7 md:text-base text-zinc-700 dark:text-white dark:bg-gray-800 group-hover:bg-main group-hover:text-white">{{ $loop->iteration }}</span>
                                                        <h4
                                                            class="text-sm transition-colors text-zinc-700 dark:text-white group-hover:text-main">
                                                            @if ($course->hasStudent() || $lession->is_free == 0)
                                                                <a
                                                                    href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $lession]) }}">
                                                            @endif
                                                            {{ $lession->title }}

                                                            </a>


                                                        </h4>

                                                    </span>
                                                    <div class="flex items-center gap-x-1.5 md:gap-x-2">

                                                        @if ($course->hasStudent() || $lession->is_free == 0)
                                                            @if (!is_null($lession->link))

                                                                <a
                                                                    href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $lession]) }}">
                                                                    <svg class="w-5 h-6 transition-colors md:w-6 md:h-6 text-zinc-700 dark:text-white/80 hover:text-main"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                                                                    </svg>
                                                                </a>
                                                            @endif

                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="w-5 h-6 transition-colors md:w-6 md:h-6 text-red-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                            </svg>
                                                        @endif

                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-secondary dark:text-white/80" style="margin-top: 7px">هنوز جلسه ای
                                                    برای این
                                                    سرفصل منتشر نشده است</p>
                                            @endforelse

                                        </div>
                                    </div>
                                @empty
                                    <p class="text-secondary dark:text-white/80 p-3">هنوز زیر سرفصلی برای این سرفصل منتشر نشده است</p>
                                @endforelse

                            </div>
                        @empty
                            <div
                                class="p-5   shadow-lg verflow-hidden rounded-2xl  dark:shadow-none my-5 bg-main/20 text-main">
                                <p>
                                    هنوز سرفصلی منتشر نشده است :(
                            </div>
                        @endforelse

                    </div>

                </div>
                @if ($course->activeFaqs()->count() >= 1)
                    <div class="overflow-hidden p-5 bg-white  shadow-lg verflow-hidden rounded-2xl  dark:bg-dark dark:shadow-none mainForm contentDiv py-10 relative"
                        style="max-height: 18rem;" data-aos="fade-up">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-secondary lg:text-2xl dark:text-white">سوالات متداول </h2>
                        </div>
                        <div class="flex flex-col text-main gap-6  rounded-lg">
                            @foreach ($course->activeFaqs()->get() as $faq)
                                <h2 id="accordion-flush-heading-{{ $faq->id }}">
                                    <button
                                        class="flex items-center justify-between w-full px-3 py-5 font-medium text-left text-gray-500 dark:border-gray-700 dark:text-gray-400 dark:bg-secondary rounded-lg  bg-gray-200"
                                        data-accordion-target="#accordion-flush-body-{{ $faq->id }}"
                                        aria-expanded="false" aria-controls="accordion-flush-body-{{ $faq->id }}"
                                        onclick="toggleMainAccordion(this); return false;">
                                        <span class="lg:text-2xl">{{ $faq->question }}</span>
                                        <svg viewBox="0 0 26 30" xmlns="http://www.w3.org/2000/svg" data-accordion-icon
                                            class="w-5 h-5 shrink-0 " style="rotate: 270deg;" aria-hidden="true"
                                            fill="currentColor">
                                            <path
                                                d="M1.423 12.1725C1.5643 12.0275 2.0977 11.4075 2.5945 10.8975C5.5073 7.69 13.1059 2.44 17.0831 0.8375C17.687 0.58 19.2141 0.035 20.03 0C20.8117 0 21.557 0.18 22.2681 0.545C23.1547 1.055 23.8658 1.8575 24.2555 2.805C24.5063 3.4625 24.896 5.43 24.896 5.465C25.2857 7.6175 25.5 11.115 25.5 14.98C25.5 18.6625 25.2857 22.0175 24.9666 24.2025C24.9301 24.2375 24.5404 26.6825 24.1142 27.52C23.3324 29.05 21.8054 30 20.1712 30H20.03C18.9657 29.9625 16.7275 29.0125 16.7275 28.9775C12.9647 27.3725 5.5414 22.38 2.558 19.0625C2.558 19.0625 1.7177 18.21 1.3524 17.6775C0.782502 16.9125 0.500002 15.965 0.500002 15.0175C0.500002 13.96 0.819002 12.975 1.423 12.1725Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-flush-body-{{ $faq->id }}" class="hidden mb-3  px-5"
                                    aria-labelledby="accordion-flush-heading-{{ $faq->id }}">
                                    <p
                                        class="text-secondary dark:text-white/80 px-3 dark:bg-secondary bg-gray-200 py-5 rounded-lg">
                                        {{ $faq->answer }}
                                    </p>
                                </div>
                            @endforeach

                        </div>
                        <div
                            class="absolute bottom-0 right-0 left-0 h-80 bg-gradient-to-t from-white dark:from-gray-800 flex justify-center items-end p-5 overlayDiv">

                        </div>
                        <button
                            class="inline-flex absolute left-0 right-0  items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-main/90 rounded-lg hover:bg-main showMoreBtn"
                            style="    width: max-content;
                 left: 0;
             right: 0;
             bottom:0;
                margin: 10px auto;"
                            onclick="toggleShowMore(this); return false;">مشاهده
                            بیشتر</button>
                    </div>
                @endif

                <div class="p-5 bg-white  shadow-lg verflow-hidden rounded-2xl dark:bg-dark dark:shadow-none mainForm"
                    data-aos="fade-up">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-secondary lg:text-2xl dark:text-white">کامنت ها </h2>
                    </div>

                    @auth
                        <form method="post" action="{{ route('customer.course.add-comment', $course) }}" class="mb-6">
                            <input type="text" hidden id="idInp" name="replay">
                            @csrf
                            @error('body')
                                <span class="font-bold text-red-500">{{ $message }}</span>
                            @enderror

                            <div class="px-4 py-2 mb-4  border border-gray-500 dark:border-gray-200 rounded-lg rounded-t-lg dark:bg-secondary">
                                <label for="comment" class="sr-only">Your comment</label>
                                <textarea id="commentTextarea" name="body" id="comment" rows="6" class="w-full px-0 text-sm border-0 text-secondary focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-secondary bg-transparent"
                                    placeholder="کامنت خود را بنوسید ..." required></textarea>
                            </div>

                            <button type="submit"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-main/90 rounded-lg hover:bg-main">
                                ارسال کامنت
                            </button>
                        </form>
                    @endauth
                    @guest
                        <div class="p-5   shadow-lg verflow-hidden rounded-2xl  dark:shadow-none my-5 bg-main/20 text-main">
                            <p>
                                جهت نظر دادن وارد شوید
                        </div>
                    @endguest

                    @foreach ($course->activeComments() as $activeComment)
                        <article
                            class="p-6 text-base bg-gray-200 rounded-lg dark:bg-secondary mt-3 shadow-lg dark:shadow-none  "
                            data-aos="fade-down">
                            <footer class="flex items-center justify-between mb-2">
                                <div class="flex gap-3 flex-col">
                                    <p
                                        class="inline-flex items-center  text-sm font-semibold text-secondary rtl:ml-3 dark:text-white">
                                        @if ($activeComment->user->image)
                                            <img class="object-cover w-6 h-6  rounded-full ml-2"
                                                src="{{ asset($activeComment->user->image) }}"
                                                alt="{{ $activeComment->user->full_name }}">
                                        @endif
                                        {{ $activeComment->user->full_name }}
                                        @if ($activeComment->user->is_admin == 1)
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-main ">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                            </svg>
                                        @endif

                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ jalaliDate($activeComment->created_at) }}</p>
                                </div>

                            </footer>
                            <p class="text-secondary dark:text-white/80 mr-2">{!! $activeComment->body !!}</p>
                            @auth

                                <div class="flex items-center mt-4 space-x-4">
                                    <button type="button" class="flex items-center text-sm font-medium text-main "
                                        onclick="document.querySelector('#idInp').value = {{ $activeComment->id }} ;
                                        document.querySelector('#commentTextarea').placeholder =
                                        'در پاسخ به {{ $activeComment->user->full_name }}'; document.querySelector('.mainForm').scrollIntoView(); document.querySelector('#commentTextarea').focus()">
                                        <svg class="mr-1.5 rtl:ml-1.5 w-3.5 h-3.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
                                        </svg>
                                        پاسخ
                                    </button>
                                </div>
                            @endauth

                        </article>
                        @foreach ($activeComment->answers()->where('approved', 1)->get() as $commentAnswer)
                            <article
                                class="p-6 my-3 ml-6 text-base bg-gray-200 rounded-lg rtl:mr-6 rtl:lg:mr-12 lg:ml-12 dark:bg-secondary shadow-lg dark:shadow-none ">
                                <footer class="flex items-center justify-between mb-2">
                                    <div class="flex gap-3 flex-col">
                                        <p
                                            class="inline-flex items-center text-sm font-semibold text-secondary rtl:ml-3 dark:text-white">
                                            @if ($commentAnswer->user->image)
                                                <img class="object-cover w-6 h-6  rounded-full ml-2"
                                                    src="{{ asset($commentAnswer->user->image) }}"
                                                    alt="{{ $commentAnswer->user->full_name }}">
                                            @endif
                                            {{ $commentAnswer->user->full_name }}
                                            @if ($activeComment->user->is_admin == 1)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 mr-2 text-main ">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                </svg>
                                            @endif

                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ jalaliDate($commentAnswer->created_at) }}</p>
                                    </div>


                                </footer>
                                <p class="text-gray-500 dark:text-gray-400 mr-2"> {!! $commentAnswer->body !!}
                                </p>

                            </article>
                        @endforeach
                    @endforeach

                </div>


            </div>
            <div class="flex flex-col w-full gap-10 lg:w-1/3 h-auto">
                <div class="flex flex-col w-full gap-5 p-5 bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none h-auto"
                    data-aos="fade-down" id="buyProduct">
                    <div class="flex justify-between w-full text-[#828282]  dark:text-white/80">
                        <span>قیمت :</span>
                        @if ($course->activeCommonDiscount())
                            <span
                                class="relative inline-block h-5 text-sm line-through  text-zinc-700 dark:text-slate-400">
                                {{ $course->course_price_value }}
                        @endif
                        </span>
                        <div class="text-xl text-main font-bold space-x-1.5 flex items-center">
                            <span>
                                {{ $course->final_course_price_value }}
                            </span>
                        </div>
                    </div>







                    @if ($course->hasStudent())
                        @php
                            $messageButton = 'شما به دوره دسترسی دارید';
                            $canRegister = null;
                            $linkButton = null;
                        @endphp
                    @elseif ($course->status == 0 || $course->status == 3)
                        @php
                            $messageButton = 'فروش دوره متوقف شده است';
                            $canRegister = null;
                            $linkButton = null;
                        @endphp
                    @elseif (cache('settings')->stop_selling == 1)
                        @php
                            $messageButton = 'امکان خرید دوره غیرفعال است';
                            $canRegister = null;
                            $linkButton = null;
                        @endphp
                    @elseif(auth()->check() && $course->teacher_id == auth()->user()->id)
                        @php
                            $messageButton = 'شما مدرس دوره هستید';
                            $canRegister = null;
                            $linkButton = null;
                        @endphp
                    @elseif(
                        (!$course->hasStudent() && is_null($course->maximum_registration)) ||
                            count($course->students) < $course->maximum_registration)
                        @php
                            $messageButton = 'ثبت نام';
                            $canRegister = true;
                            $linkButton = route('customer.sales-process.add-to-cart', $course);
                        @endphp
                    @elseif(!is_null($course->maximum_registration) && count($course->students) > $course->maximum_registration)
                        @php
                            $messageButton = 'ظرفیت دوره پر شده است';
                            $canRegister = null;
                            $linkButton = null;
                        @endphp
                    @elseif ($course->types == 2 && !$course->hasStudent())
                        @php
                            $messageButton = 'برای دسترسی به دوره باید اشتراک Vip تهیه کنید';
                            $linkButton = route('customer.profile');
                            $canRegister = null;
                        @endphp
                    @else
                        @php
                            $messageButton = 'ثبت نام در دوره غیرفعال شده است';
                            $canRegister = null;
                            $linkButton = null;
                        @endphp
                    @endif

                    @if (isset($canRegister))
                        <form action="{{ $linkButton }}" method="post">
                            @csrf
                        @elseif(isset($linkButton))
                            <a href="{{ $linkButton }}">
                    @endif
                    <div class="relative w-full hover:scale-[.98] duration-200">
                        <button class="w-full py-3 text-white bg-main rounded-3xl">
                            {{ $messageButton }}
                        </button>
                        <svg class="absolute z-50 right-3 top-3" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M2 8.505H22" stroke="white" stroke-width="2" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 16.505H8" stroke="white" stroke-width="2" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10.5 16.505H14.5" stroke="white" stroke-width="2" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M6.44 3.505H17.55C21.11 3.505 22 4.385 22 7.895V16.105C22 19.615 21.11 20.495 17.56 20.495H6.44C2.89 20.505 2 19.625 2 16.115V7.895C2 4.385 2.89 3.505 6.44 3.505Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>


                    </a>

                    </form>
                    @if (!$course->hasStudent())
                        @if (!is_null($course->maximum_registration) && count($course->students) < $course->maximum_registration)
                            <p class="font-bold text-red-500 text-center">ظرفیت باقی مانده
                                {{ $course->maximum_registration - count($course->students) }} نفر</p>
                        @endif
                    @endif

                </div>

                <div class="flex flex-col items-center w-full p-6 bg-white  shadow-lg rounded-2xl  dark:bg-dark dark:shadow-none gap-4 h-auto"
                    data-aos="fade-down">
                    @if ($course->teacher->image)
                        <img src="{{ asset($course->teacher->image) }}"
                            class="rounded-full h-24 w-24 ring-2 ring-gray-300 dark:ring-gray-500"
                            alt="{{ $course->teacher->full_name }}">
                    @endif

                    <a href="{{ route('customer.teacher', $course->teacher->username) }}">
                        <h2 class="text-xl font-bold text-main"> {{ $course->teacher->full_name }} </h2>
                    </a>
                    <span class="text-[#7D7D7D] dark:text-white/80">{{ $course->teacher->headline }}</span>


                    @if (cache('templateSetting')['show_social_user'])
                        <div class="flex gap-2">




                            @if ($course->teacher->instagram)
                                <!-- Instagram -->
                                <a href="https://instagram.com/{{ $course->teacher->instagram }}">
                                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                                        class="mb-2 inline-block rounded-xl px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition  ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg hover:scale-[.98] duration-300"
                                        style="background-color: #c13584">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                        </svg>
                                    </button>
                                </a>
                            @endif

                            @if ($course->teacher->telegram)
                                <!-- Telegram -->
                                <a href="https://t.me/{{ $course->teacher->telegram }}">
                                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                                        class="mb-2 inline-block rounded-xl px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg hover:scale-[.98] duration-300"
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
                @if (cache('templateSetting')['show_rate'] == 1)
                    <div class="flex flex-col w-full gap-5 p-5 bg-white  shadow-lg rounded-2xl  dark:bg-dark dark:shadow-none h-auto"
                        data-aos="fade-up">
                        <div class="flex  justify-center lg:justify-between flex-wrap items-center gap-3 w-full">
                            <span class="text-[#828282]  dark:text-white/80 text-sm font-light">امتیاز دوره
                                {{ number_format($course->ratingsAvg(), 0) }} از {{ $course->ratingsCount() }} رای</span>


                            @if (
                                $course->hasStudent() &&
                                    auth()->user()->getRate($course->id)->count() <= 0)
                                <div class="flex items-center">
                                    <form class="container" action="{{ route('customer.course.add-rate', $course) }}"
                                        method="POST">
                                        <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                            @csrf
                                            <input type="radio" id="star5" name="rating" value="5" /><label
                                                for="star5" title="5 star"></label>
                                            <input type="radio" id="star4" name="rating" value="4" /><label
                                                for="star4" title="4 star"></label>
                                            <input type="radio" id="star3" name="rating" value="3" /><label
                                                for="star3" title="3 star"></label>
                                            <input type="radio" id="star2" name="rating" value="2" /><label
                                                for="star2" title="2 star"></label>
                                            <input type="radio" id="star1" name="rating" value="1" /><label
                                                for="star1" title="1 star"></label>
                                        @else
                                            <div class="flex items-center"
                                                style="user-select: none; cursor: not-allowed; pointer-events: none;">
                                                <form class="container"
                                                    action="{{ route('customer.course.add-rate', $course) }}"
                                                    method="POST">
                                                    <div
                                                        class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                                        @csrf
                                                        <input type="radio" id="star5"
                                                            @if (number_format($course->ratingsAvg(), 0) == 5) checked @endif
                                                            name="rating" value="4.5" /><label for="star5"
                                                            title="5 star"></label>
                                                        <input type="radio" id="star4"
                                                            @if (number_format($course->ratingsAvg(), 0) == 4) checked @endif
                                                            name="rating" value="4" /><label for="star4"
                                                            title="4 star"></label>
                                                        <input type="radio" id="star3"
                                                            @if (number_format($course->ratingsAvg(), 0) == 3) checked @endif
                                                            name="rating" value="3" /><label for="star3"
                                                            title="3 star"></label>
                                                        <input type="radio" id="star2"
                                                            @if (number_format($course->ratingsAvg(), 0) == 2) checked @endif
                                                            name="rating" value="2" /><label for="star2"
                                                            title="2 star"></label>
                                                        <input type="radio" id="star1"
                                                            @if (number_format($course->ratingsAvg(), 0) == 1) checked @endif
                                                            name="rating" value="1" /><label for="star1"
                                                            title="1 star"></label>
                            @endif


                        </div>
                        <div>
                            @if (
                                $course->hasStudent() &&
                                    auth()->user()->getRate($course->id)->count() <= 0)
                                <button class="w-full py-3 text-white bg-main rounded-3xl">ثبت امتیاز</button>
                            @endif
                        </div>
                        </form>
                    </div>
            </div>
        </div>
        @endif


        <!--<div data-aos="fade-down" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-2 gap-4 lg:gap-7 select-none">-->
        <!--    @if ($course->types != 2)-->
        <!--    <div-->
        <!--        class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">-->
        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--            stroke="currentColor" class="w-8 lg:w-10 h-8 lg:h-10 transition-colors text-main">-->
        <!--            <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5">-->
        <!--            </path>-->
        <!--        </svg>-->
        <!--        <p class="text-sm md:text-base text-center transition-colors">-->

        <!--            {{ count($course->students) }}-->
        <!--            دانشجو-->

        <!--        </p>-->
        <!--    </div>-->
        <!--    @endif-->

        <!--    <div-->
        <!--        class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">-->
        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--            stroke="currentColor" class="w-8 lg:w-10 h-8 lg:h-10 transition-colors text-main">-->
        <!--            <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z">-->
        <!--            </path>-->
        <!--        </svg>-->
        <!--        <p class="text-sm md:text-base text-center transition-colors">-->
        <!--            {{ $course->lessons()->where('confirmation_status', 1)->count() }} جلسه</p>-->
        <!--    </div>-->
        <!--    <div-->
        <!--        class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">-->
        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--            stroke="currentColor" class="w-8 lg:w-10 h-8 lg:h-10 transition-colors text-main">-->
        <!--            <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>-->
        <!--        </svg>-->
        <!--        <p class="text-sm md:text-base text-center transition-colors">{{ $course->formattedDuration() }}-->
        <!--        </p>-->
        <!--    </div>-->

        <!--    <div-->
        <!--        class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">-->

        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--            class="w-8 lg:w-10 h-8 lg:h-10 transition-colors text-main" stroke="currentColor" class="w-6 h-6">-->
        <!--            <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />-->
        <!--        </svg>-->



        <!--        <p class="text-sm md:text-base text-center transition-colors">-->
        <!--            {{ $course->status_value }}</p>-->
        <!--    </div>-->

        <!--    <div-->
        <!--        class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">-->

        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--            stroke="currentColor" class="w-8 lg:w-10 h-8 lg:h-10 transition-colors text-main">-->
        <!--            <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />-->
        <!--        </svg>-->
        <!--        <p class="text-sm md:text-base text-center transition-colors">-->
        <!--            {{ $course->get_course_option == 0 ? 'دانلودی' : 'اسپات پلیر' }}</p>-->
        <!--    </div>-->
        <!--    <div-->
        <!--        class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">-->

        <!--        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
        <!--            stroke="currentColor" class="w-8 lg:w-10 h-8 lg:h-10 transition-colors text-main">-->
        <!--            <path stroke-linecap="round" stroke-linejoin="round"-->
        <!--                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />-->
        <!--        </svg>-->


        <!--        <p class="text-sm md:text-base text-center transition-colors">-->
        <!--            {{ $course->lessons()->orderby('created_at', 'desc')->where('confirmation_status', 1)->latest()->first() != null ? \Carbon\Carbon::parse($course->lessons()->orderby('created_at', 'desc')->where('confirmation_status', 1)->latest()->first()->created_at)->diffForHumans() : 'جلسه ای منتشر نشده است' }}-->
        <!--        </p>-->
        <!--    </div>-->


        <!--</div>-->
        <div
            class="flex justify-center items-center flex-col gap-3 bg-white  dark:bg-dark transition rounded-2xl px-4 lg:px-7 py-6 xl:py-12 shadow-lg dark:shadow-none dark:text-white hover:scale-95 duration-200">
            <div class="flex items-center gap-2   border-b-[#D1D1D1] border-dashed pb-2 text-[#828282] dark:text-white/80">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    class="w-6 h-6 text-main" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>

                <span>درصد پیشرفت
                    دوره</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-main text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                    style="width: {{ $course->progress }}%;">{{ $course->progress }}%</div>
            </div>
        </div>

{{--        @if ($relatedCourses->count() > 0)--}}
{{--            <div class="flex flex-col w-full gap-5 p-5 bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none"--}}
{{--                data-aos="fade-up">--}}
{{--                <span class="border-[#D1D1D1]/50 border-b text-main pb-4">دوره های مرتبط</span>--}}
{{--                <div class="flex flex-col gap-4">--}}
{{--                    @foreach ($relatedCourses as $relatedCourse)--}}
{{--                        <div class="flex items-center gap-4 dark:bg-secondary bg-gray-200 p-2 rounded-lg">--}}
{{--                            <img src="{{ asset($relatedCourse->image) }}" class="object-cover rounded-xl  w-24"--}}
{{--                                alt="{{ $relatedCourse->title }}">--}}
{{--                            <div class="flex flex-col w-full gap-1">--}}
{{--                                <a href="{{ route('customer.course.singleCourse', $relatedCourse->slug) }}"><span--}}
{{--                                        class="text-lg font-bold text-dark dark:text-white/80  hover:text-main">{{ $relatedCourse->title }}</span></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}
        @include('customer.layouts.ads')
        </div>

        </div>
        @if (!$course->hasStudent())
            <a href="#buyProduct"
                class="flex items-center gap-2 px-8 py-3 text-sm font-medium text-white border  bg-main border-main shrink-0  transition-all duration-300 rounded-xl hover:scale-[.98] lg:hidden"
                style="position: fixed; bottom:10px ; right:20px; z-index:50
">خرید دوره</a>
        @endif


    </section>


@endsection
@section('script')
    <script src="{{ asset('customer/js/plyr.js') }}"></script>
        <script>
        // Wrap everything in IIFE to avoid conflicts with other scripts
        (function() {
            'use strict';
            
            // Initialize Plyr with fallback for older browsers
            try {
                if (typeof Plyr !== 'undefined' && document.getElementById('player')) {
                    const player = new Plyr('#player');
                }
            } catch (e) {
                // Plyr initialization failed - continue without video player
            }
            
            // Utility function to safely add/remove classes and control visibility
            function safeClassToggle(element, className, add) {
                if (!element) return;
                try {
                    if (element.classList) {
                        if (add) {
                            element.classList.add(className);
                        } else {
                            element.classList.remove(className);
                        }
                    }
                    
                    // Force display control with inline styles to override any CSS conflicts
                    if (className === 'hidden') {
                        if (add) {
                            element.style.display = 'none';
                            element.style.visibility = 'hidden';
                        } else {
                            element.style.display = '';
                            element.style.visibility = '';
                        }
                    }
                } catch (e) {
                    // Silent fail for CSS operations
                }
            }
            
            // Prevent double-firing
            var lastClickTime = 0;
            
            // Global functions for maximum compatibility
            window.toggleMainAccordion = function(button) {
                // Prevent rapid double-clicks (both onclick and addEventListener firing)
                var now = Date.now();
                if (now - lastClickTime < 100) {
                    return true;
                }
                lastClickTime = now;
                
                try {
                    if (!button) return;
                    
                    var targetId = button.getAttribute('data-accordion-target');
                    if (!targetId) return false;
                    
                    var targetElement = document.querySelector(targetId);
                    if (!targetElement) return false;
                    
                    var icon = button.querySelector('[data-accordion-icon]');
                    var isExpanded = button.getAttribute('aria-expanded') === 'true';
                    
                    if (isExpanded) {
                        // Close accordion
                        safeClassToggle(targetElement, 'hidden', true);
                        button.setAttribute('aria-expanded', 'false');
                        if (icon && icon.style) {
                            icon.style.transform = 'rotate(270deg)';
                        }
                    } else {
                        // Open accordion
                        safeClassToggle(targetElement, 'hidden', false);
                        button.setAttribute('aria-expanded', 'true');
                        if (icon && icon.style) {
                            icon.style.transform = 'rotate(0deg)';
                        }
                    }
                    return true;
                } catch (e) {
                    console.error('Error in toggleMainAccordion:', e);
                    return false;
                }
            };
            
            window.toggleChildAccordion = function(button) {
                try {
                    if (!button) return false;
                    
                    var targetId = button.getAttribute('data-child-target');
                    if (!targetId) return false;
                    
                    var targetElement = document.querySelector(targetId);
                    if (!targetElement) return false;
                    
                    var icon = button.querySelector('.child-accordion-icon');
                    var isExpanded = button.getAttribute('aria-expanded') === 'true';
                    
                    if (isExpanded) {
                        safeClassToggle(targetElement, 'hidden', true);
                        button.setAttribute('aria-expanded', 'false');
                        if (icon && icon.style) {
                            icon.style.transform = 'rotate(270deg)';
                        }
                    } else {
                        safeClassToggle(targetElement, 'hidden', false);
                        button.setAttribute('aria-expanded', 'true');
                        if (icon && icon.style) {
                            icon.style.transform = 'rotate(0deg)';
                        }
                    }
                    return true;
                } catch (e) {
                    console.error('Error in toggleChildAccordion:', e);
                    return false;
                }
            };
            
            window.toggleShowMore = function(button) {
                try {
                    if (!button) return false;
                    
                    var contentDiv = null;
                    
                    // Try modern method first
                    if (button.closest) {
                        contentDiv = button.closest('.contentDiv');
                    }
                    
                    // Fallback: search up the parent tree
                    if (!contentDiv) {
                        var parent = button.parentElement;
                        while (parent && parent !== document.body) {
                            if (parent.classList && parent.classList.contains('contentDiv')) {
                                contentDiv = parent;
                                break;
                            }
                            parent = parent.parentElement;
                        }
                    }
                    
                    if (!contentDiv) return false;
                    
                    var overlayDiv = contentDiv.querySelector('.overlayDiv');
                    var currentMaxHeight = contentDiv.style.maxHeight;
                    var isOpen = currentMaxHeight === 'none' || currentMaxHeight === '';
                    
                    if (isOpen) {
                        // Close: set max height and show overlay
                        contentDiv.style.maxHeight = '40rem';
                        if (overlayDiv) {
                            safeClassToggle(overlayDiv, 'hidden', false);
                        }
                        button.innerHTML = 'مشاهده بیشتر';
                    } else {
                        // Open: remove max height and hide overlay
                        contentDiv.style.maxHeight = 'none';
                        if (overlayDiv) {
                            safeClassToggle(overlayDiv, 'hidden', true);
                        }
                        button.innerHTML = 'مشاهده کمتر';
                    }
                    return true;
                } catch (e) {
                    console.error('Error in toggleShowMore:', e);
                    return false;
                }
            };
            
            // Safe event listener addition
            function safeAddEventListener(element, event, handler) {
                try {
                    if (element && element.addEventListener) {
                        element.removeEventListener(event, handler);
                        element.addEventListener(event, handler);
                        return true;
                    }
                } catch (e) {
                    // Silent fail for event listener operations
                }
                return false;
            }
            
            // Event handlers
            function handleMainAccordionClick(e) {
                try {
                    if (e && e.preventDefault) e.preventDefault();
                    if (e && e.stopPropagation) e.stopPropagation();
                    return window.toggleMainAccordion(this);
                } catch (error) {
                    console.error('Error in handleMainAccordionClick:', error);
                    return false;
                }
            }
            
            function handleShowMoreClick(e) {
                try {
                    if (e && e.preventDefault) e.preventDefault();
                    if (e && e.stopPropagation) e.stopPropagation();
                    return window.toggleShowMore(this);
                } catch (error) {
                    console.error('Error in handleShowMoreClick:', error);
                    return false;
                }
            }
            
            // Safe initialization that won't be affected by other script errors
            function initializeAccordions() {
                try {
                    // Main accordion buttons
                    var mainButtons = document.querySelectorAll('[data-accordion-target]');
                    
                    for (var i = 0; i < mainButtons.length; i++) {
                        var button = mainButtons[i];
                        if (button && !button.onclick) {
                            // Only add event listener if button doesn't have onclick handler
                            safeAddEventListener(button, 'click', handleMainAccordionClick);
                        }
                    }
                    
                    // Show more buttons
                    var showMoreButtons = document.querySelectorAll('.showMoreBtn');
                    
                    for (var j = 0; j < showMoreButtons.length; j++) {
                        var showButton = showMoreButtons[j];
                        if (showButton) {
                            safeAddEventListener(showButton, 'click', handleShowMoreClick);
                        }
                    }
                } catch (e) {
                    console.error('Error in initializeAccordions:', e);
                }
            }
            
            // Multiple initialization strategies to ensure it works
            function safeInitialize() {
                try {
                    // Wait a bit to let other scripts finish
                    setTimeout(initializeAccordions, 200);
                } catch (e) {
                    console.error('Error in safeInitialize:', e);
                }
            }
            
            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', safeInitialize);
            } else {
                safeInitialize();
            }
            
            // Also initialize on window load as backup
            window.addEventListener('load', function() {
                setTimeout(safeInitialize, 500);
            });
            
        })(); // End IIFE
    </script>
@endsection
