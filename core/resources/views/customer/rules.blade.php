@extends('customer.layouts.master')
@section('head-tag')
<title>قوانین و مقررات - {{cache('templateSetting')['title']}}</title>
<style>
    .rules-content h1,
    .rules-content h2,
    .rules-content h3,
    .rules-content h4 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4A6DFF;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
    }
    .rules-content h1:first-child,
    .rules-content h2:first-child {
        margin-top: 0;
    }
    .rules-content p {
        line-height: 2;
        margin-bottom: 1rem;
        color: inherit;
    }
    .rules-content ul,
    .rules-content ol {
        padding-right: 2rem;
        list-style: disc;
        line-height: 2;
        margin-bottom: 1rem;
        color: inherit;
    }
    .rules-content ol {
        list-style: decimal;
    }
    .rules-content li {
        margin-bottom: 0.5rem;
    }
    .rules-content hr {
        margin: 2rem 0;
        border: 0;
        border-top: 2px solid #e5e7eb;
    }
    .rules-content strong {
        font-weight: bold;
    }
    .rules-content em {
        font-style: italic;
    }
    .rules-content a {
        color: #4A6DFF;
        text-decoration: underline;
    }
    .rules-content a:hover {
        opacity: 0.8;
    }
</style>
@endsection

@section('content')
<section class="container content lg:blur-0">
    <div class="flex items-center justify-between w-full my-7">
        <h1 class="text-lg font-bold lg:text-3xl text-secondary dark:text-white/80">قوانین و مقررات سایت</h1>
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
        <div class="flex flex-col w-full gap-10">
            <div class="flex flex-col gap-10 p-5 bg-white shadow-lg rounded-2xl dark:bg-dark dark:shadow-none"
                data-aos="fade-up">
                <div class="flex flex-col gap-5 dark:text-white/80 text-secondary prose prose-lg max-w-none">
                    
                    @if($setting && $setting->rules)
                        <div class="rules-content">
                            {!! $setting->rules !!}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

