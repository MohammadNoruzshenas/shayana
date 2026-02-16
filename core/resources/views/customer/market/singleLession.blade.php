@extends('customer.layouts.master')
@section('head-tag')
    <title>{{ $lession->title }} - {{ $course->title }}</title>
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
@endsection
@section('content')
    <section class="container content lg:blur-0">
        <div class="flex items-center justify-between w-full my-7">
            <h1 class="text-2xl font-bold lg:text-3xl text-secondary dark:text-white/80">{{ $course->title }}/
                {{ $lession->title }}</h1>
            <a href="{{ route('customer.courses') }}"
                class="flex items-center gap-2 text-lg font-bold lg:text-lg group text-main"> برگشت به دوره ها
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
                <div class="flex flex-col gap-3 p-5 bg-white  shadow-lg rounded-2xl  dark:bg-dark dark:shadow-none">
                    @if (isset($linkOnlieVideo))
                        <video class="transition-all duration-300 rounded-xl hover:scale-[.98]" id="player" playsinline
                            controls data-poster="{{ asset($course->image) }}">
                            <source src="{{ $linkOnlieVideo }}" type="video/mp4" />
                        </video>
                    @endif
                    <div class="w-full my-5 flex justify-end items-center gap-3 flex-col lg:flex-row ">
                        @if(!is_null($lession->link))
                    <a class="w-full lg:w-auto" href="{{ $linkOnlieVideo }}" >
                        <button
                            class="flex w-full lg:w-auto justify-center items-center gap-2 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main">
                            باز کردن ویدیو در صفحه جدید
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"  viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>


                        </button>
                    </a>
                    @endif
                </div>
                    <div class="flex flex-col gap-2 dark:text-white/80 text-secondary text-a-color">
                        {!! $lession->body !!}
                        <div class="w-full my-5 flex justify-end items-center gap-3 flex-col lg:flex-row ">
                                @if(!is_null($lession->link))
                            <a class="w-full lg:w-auto" href="{{ route('customer.lesson.video.download', ['course' => $course->slug, 'lession' => $lession]) }}" >
                                <button
                                    class="flex w-full lg:w-auto justify-center items-center gap-2 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main">
                                    دانلود مستقیم ویدیو
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"  viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>


                                </button>
                            </a>
                            @endif
                        </div>



                    </div>



                </div>



            </div>
            <div class="flex flex-col w-full gap-10 lg:w-1/3 h-auto">


                <div id="showLesson" class="flex flex-col text-main gap-6 rounded-lg h-auto sticky top-50" data-aos="fade-down">
                    @forelse ($course->season()->whereNull('parent_id')->where('confirmation_status', 1)->orderBy('number','asc')->get() as $mainSeason)
                        <!-- Main Season Accordion -->
                        <h2 id="accordion-flush-heading-main-{{ $mainSeason->id }}">
                            <button
                                class="flex items-center justify-between w-full px-3 py-5 font-medium text-left text-gray-500 dark:border-gray-700 dark:text-gray-400 dark:bg-secondary rounded-lg bg-gray-200"
                                data-accordion-target="#accordion-flush-body-main-{{ $mainSeason->id }}"
                                aria-expanded="false" aria-controls="accordion-flush-body-main-{{ $mainSeason->id }}">
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
                            class="hidden dark:bg-secondary px-3 rounded-lg"
                            aria-labelledby="accordion-flush-heading-main-{{ $mainSeason->id }}">

                            <!-- Child Seasons -->
                            @forelse ($mainSeason->children()->where('confirmation_status', 1)->orderBy('number','asc')->get() as $childSeason)
                                <div class="my-4">
                                    <h3 id="accordion-flush-heading-child-{{ $childSeason->id }}">
                                        <button
                                            class="child-accordion-btn flex items-center justify-between w-full px-3 py-4 font-medium text-left text-gray-600 dark:border-gray-600 dark:text-gray-300 dark:bg-gray-700 rounded-lg bg-gray-100 ml-4"
                                            data-child-target="#accordion-flush-body-child-{{ $childSeason->id }}"
                                            aria-expanded="false" aria-controls="accordion-flush-body-child-{{ $childSeason->id }}"
                                            onclick="toggleChildAccordion(this)">
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
                                        @forelse ($childSeason->lession->where('confirmation_status', 1) as $singleLession)
                                            <div
                                                class="md:flex items-center gap-2.5 flex-wrap space-y-3.5 md:space-y-0 p-3 md:py-4 group justify-between my-5 bg-gray-200 dark:bg-dark rounded-lg">

                                                <span class="flex items-center gap-x-1.5 md:gap-x-2.5 shrink-0">
                                                    <span
                                                        class="flex items-center justify-center w-5 h-5 text-xs transition-colors bg-white rounded-md shrink-0 md:w-7 md:h-7 md:text-base text-zinc-700 dark:text-white dark:bg-gray-800 group-hover:bg-main group-hover:text-white">{{ $loop->iteration }}</span>
                                                    <h4
                                                        class="text-sm transition-colors text-zinc-700 dark:text-white group-hover:text-main">
                                                        @if ($course->hasStudent() || $singleLession->is_free == 0)
                                                            <a
                                                                href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $singleLession]) }}">
                                                        @endif
                                                        <span @if ($lession->id == $singleLession->id) class="text-main font-bold" @endif>
                                                            {{ $singleLession->title }}
                                                        </span>
                                                        @if ($course->hasStudent() || $singleLession->is_free == 0)
                                                            </a>
                                                        @endif
                                                    </h4>
                                                </span>
                                                <div class="flex items-center gap-x-1.5 md:gap-x-2">

                                                    @if ($course->hasStudent() || $singleLession->is_free == 0)
                                                        @if (!is_null($singleLession->link))
                                                            <a
                                                                href="{{ route('customer.course.showLession', ['course' => $course->slug, 'lession' => $singleLession]) }}">
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
                            class="p-5 shadow-lg overflow-hidden rounded-2xl dark:shadow-none my-5 bg-main/20 text-main">
                            <p>
                                هنوز سرفصلی منتشر نشده است :(
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>



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
