@extends('customer.layouts.master')
@section('head-tag')
<title> {{ $post->title }}</title>
<meta name="description" content="{{ $post->summary }}" />
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->summary }}">
<meta property="og:image" content="{{ asset($post->image) }}">
<meta property="og:url" content="{{ route('customer.singlePost', $post->slug) }}">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{{ $post->body }}">
<meta name="twitter:url" content="{{ asset($post->image) }}">
<meta name="twitter:card" content="{{ $post->summary }}">
@endsection
@section('content')




<section class="container content lg:blur-0">
        <div class="flex items-center justify-between w-full my-7">
            <h1 class="text-lg font-bold lg:text-3xl text-secondary dark:text-white/80">{{ $post->title }}</h1>
            <a href="{{ route('customer.blogs') }}"
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
            <div class="flex flex-col w-full gap-10 lg:w-2/3 ">
                <div id="contentDiv"
                    class="rounded-2xl bg-white shadow-lg dark:bg-dark dark:shadow-none duration-300">
                    <div class="relative flex flex-col gap-10 p-5 pb-20 ">
                        <div class="w-full flex items-center justify-center hidden" id="closeDiv">
                            <button type="button"
                                class=" flex-shrink-0 inline-flex justify-center w-12 h-12 items-center text-white/80  rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white bg-main">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close banner</span>
                            </button>
                        </div>
                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                            class="transition-all duration-300 rounded-xl hover:scale-[.98]">
                        <div class="flex items-center gap-x-1 dark:text-white/80">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 mb-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>


                            {{ jalaliDate($post->created_at) }}
                        </div>
                        <main class=" dark:text-white/80 text-secondary text-xl" style="line-height: 1.8; ">
                            <article class="text-a-color">
                                @if ($post->is_vip == 1)
                                    @if (auth()->check() && auth()->user()->hasActivceSubscribe())
                                        {!! $post->body !!}
                                    @else
                                        {!! Str::limit(
                                            $post->body,
                                            $post->limit_body,
                                            '<p class="text-red-500"><br>برای مشاهده ادامه مطلب نیاز به تهیه اشتراک ویژه میباشد ! </p>',
                                        ) !!}
                                        <a href="{{ route('customer.profile') }}">
                                            <div
                                                class="absolute bottom-0 right-0 left-0 h-70 bg-gradient-to-t from-white dark:from-gray-800 flex justify-center items-end p-5 overlayDiv">
                                                <button
                                                    class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-main/90 rounded-lg hover:bg-main showMoreBtn">خرید
                                                    اشتراک <button>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    {!! $post->body !!}
                                @endif


                            </article>
                    </div>
                </div>



                <div class="p-5 bg-white  shadow-lg verflow-hidden rounded-2xl  dark:bg-dark dark:shadow-none mainForm"
                    data-aos="zoom-in-down">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-secondary lg:text-2xl dark:text-white">کامنت ها </h2>
                    </div>
                    @auth

                        <form method="post" action="{{ route('customer.blog.add-comment', $post) }}" class="mb-6">
                            <input type="text" hidden id="idInp" name="replay">
                            @csrf
                            @error('body')
                            <span class="font-bold text-red-500">{{$message}}</span>
                        @enderror
                            <div
                                class="px-4 py-2 mb-4  border border-gray-500 dark:border-gray-200 rounded-lg rounded-t-lg dark:bg-secondary dark:border-gray-700">
                                <label for="comment" class="sr-only">Your comment</label>
                                <textarea id="commentTextarea" name="body" id="comment" rows="6"
                                    class="w-full px-0 text-sm border-0 text-secondary focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-secondary bg-transparent"
                                    placeholder="کامنت خود را بنوسید ..." required></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-main/90 rounded-lg hover:bg-main">
                                ارسال کامنت
                            </button>
                        </form>
                    @endauth
                    @guest
                    <div
                    class="p-5   shadow-lg verflow-hidden rounded-2xl  dark:shadow-none my-5 	bg-main/20 text-main" >
                    <p >
                        جهت نظر دادن وارد شوید
                </div>
                    @endguest
                    @foreach ($post->activeComments() as $activeComment)
                        <article
                            class="p-6 text-base bg-gary rounded-lg dark:bg-secondary mt-3 shadow-lg dark:shadow-none  "
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
                                @if($activeComment->user->is_admin == 1)
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
                                class="p-6 my-3 ml-6 text-base bg-gray rounded-lg rtl:mr-6 rtl:lg:mr-12 lg:ml-12 dark:bg-secondary shadow-lg dark:shadow-none border border-main/20shadow-lg dark:shadow-none border border-main/20">
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
                                @if($activeComment->user->is_admin == 1)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-main ">
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
                    {{ $post->activeComments()->links('customer.layouts.paginate') }}
                </div>
            </div>
            <div class="flex flex-col w-full gap-10 lg:w-1/3 h-auto">
                <div class="p-4 lg:p-7 bg-white dark:bg-dark transition-all rounded-2xl sticky top-20    z-10 shadow-lg dark:shadow-none  hidden lg:block h-auto"
                    data-aos="zoom-in">
                    <button id="scaleBtn"
                        class="relative  flex justify-center items-center transition-all w-full rounded-lg  px-6  py-4 gap-2 text-sm lg:text-main hover:ring-8 ring-main opacity-100 cursor-pointer  bg-main text-white"><span
                            class="transition-allvisible opacity-100">بزرگ نمایی</span><span
                            class="transition-all visible opacity-100"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                            </svg></span></button>
                </div>

                <div class="flex flex-col items-center w-full p-6 bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none gap-4 h-auto"
                    data-aos="zoom-in-up">
                    @if ($post->author->image)
                        <img src="{{ asset($post->author->image) }}"
                            class="rounded-full h-24 w-24 ring-2 ring-gray-300 dark:ring-gray-500"
                            alt="{{ $post->author->full_name }}">
                    @endif
                  <a href="{{ route('customer.teacher', $post->author->username) }}"> <h2 class="text-xl font-bold text-main"> {{ $post->author->full_name }} </h2></a>
                    <span class="text-[#7D7D7D] dark:text-white/80">{{ $post->author->headline }}</span>


                    @if (cache('templateSetting')['show_social_user'])
                        <div class="flex gap-2">




                            @if ($post->author->instagram)
                                <a href="https://instagram.com/{{ $post->author->instagram }}">
                                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                                        class="mb-2 inline-block rounded-xl px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-lg transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg hover:scale-[.98] duration-300"
                                        style="background-color: #c13584">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                        </svg>
                                    </button>
                                </a>
                            @endif

                            @if ($post->author->telegram)
                                <a href="https://t.me/{{ $post->author->telegram }}">
                                    <button type="button" data-te-ripple-init data-te-ripple-color="light"
                                        class="mb-2 inline-block rounded-xl px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-lg transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg hover:scale-[.98] duration-300"
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
                @if ($relatedPosts->count() > 0)
                    <div class="flex flex-col w-full gap-5 p-5 bg-white  shadow-lg rounded-2xl dark:bg-dark  dark:shadow-none"
                        data-aos="fade-up">
                        <span class="border-[#D1D1D1]/50 border-b text-main pb-4">مقاله های مرتبط</span>
                        <div class="flex flex-col gap-4">
                            @foreach ($relatedPosts as $relatedPost)
                                <div class="flex items-center gap-4 dark:bg-secondary bg-gray p-2 rounded-lg">
                                    <img src="{{ asset($relatedPost->image) }}"
                                        class="object-cover rounded-xl  w-24" alt=" {{ $relatedPost->title }}">
                                    <div class="flex flex-col w-full gap-1">
                                        <a href="{{ route('customer.singlePost', $relatedPost->slug) }}"><span
                                                class="text-lg font-bold text-dark dark:text-white/80 hover:text-main">
                                                {{ $relatedPost->title }}</span></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @include('customer.layouts.ads')

            </div>
        </div>


    </section>

    <script>
        const scaleBtn = document.querySelector("#scaleBtn")
        const contentDiv = document.querySelector("#contentDiv")
        const closeDiv = document.querySelector("#closeDiv")
        scaleBtn.addEventListener("click", () => {
            contentDiv.className =
                'fixed inset-0 z-[10000] overflow-auto  transition-all mb-5  bg-white border shadow-lg  border-main/20 dark:bg-dark dark:shadow-none duration-300'
            closeDiv.classList.remove("hidden")
            scrollTo(0, 0)

        })
        closeDiv.addEventListener("click", () => {
            contentDiv.className =
                'rounded-2xl bg-white border shadow-lg  border-main/20 dark:bg-dark dark:shadow-none duration-300'
            closeDiv.classList.add("hidden")
        })
    </script>

@endsection
