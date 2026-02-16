<div
		class="overLayMenu h-screen fixed ltr:-ml-[70%] rtl:-mr-[70%] bg-gray duration-500 ease-in-out z-[10000000] w-2/3 lg:hidden p-5 flex items-center flex-col gap-5 dark:bg-dark dark:text-white/80 overflow-auto	">
		<div class="flex justify-end w-full">
        <button  type="button" class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-white/80  rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white closeMenu">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close banner</span>
        </button>
    </div>
        <form action="{{ route('customer.courses') }}" method="get">
            <div class="flex items-center gap-3 lg:hidden w-full">
        <div class="relative w-full">
            <label for="Search" class="sr-only"> Search </label>

    <input
      type="text"
      id="Search"
      name="search"
      value="{{request()->search}}"
      placeholder="جست و جو کنید ... "
      class="w-full rounded-xl border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm dark:bg-secondary bg-white dark:border-gray-700 dark:text-white/80  focus:ring-0 dark:focus:border-main  focus:border-main focus:outline-none"
    />

    <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
      <button type="button" class="text-gray-600 hover:text-gray-700 ">
        <span class="sr-only">Search</span>

        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
          />
        </svg>
      </button>
    </span>
  </div>
</form>
		</div>

		<ul class="flex flex-col w-full gap-6 mt-5 text-sm text-secondary dark:text-white/80">


            @include('customer.layouts.MenuMobile')

		</ul>


	</div>
    @if (cache('templateSetting')['sticky_banner'])
        <div data-aos="fade-down" id="sticky-banner" tabindex="-1" class="flex justify-between w-full gap-2 p-4 bg-main dark:bg-main/60 item-center">
        <div class="flex items-center mx-auto">
            <p class="flex items-center gap-2 text-sm font-normal text-white">
                <span class="flex items-center justify-center w-6 h-6 gap-2 p-1 bg-gray-200 rounded-full dark:bg-gray-600">
                    <svg class="w-3 h-3 dark:text-white text-dark" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path d="M15 1.943v12.114a1 1 0 0 1-1.581.814L8 11V5l5.419-3.871A1 1 0 0 1 15 1.943ZM7 4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2v5a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V4ZM4 17v-5h1v5H4ZM16 5.183v5.634a2.984 2.984 0 0 0 0-5.634Z"/>
                    </svg>
                </span>
                <span>{{cache('templateSetting')['sticky_banner']}}
            </p>
        </div>
        <div class="flex items-center">
            <button data-dismiss-target="#sticky-banner" type="button" class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-white/80  rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close banner</span>
            </button>
        </div>
    </div>
    @endif


        <header   class="py-4 backdrop-blur-lg   sticky top-0 z-[10000] bg-gray dark:bg-dark shadow-lg shadow-main/10  dark:shadow-none" >
            <div class="container flex items-center justify-between w-full">
               <div class="flex items-center gap-10">
               <a href="{{route('customer.home')}}" class="flex items-center gap-x-1">
                     <image class="w-10 h-10" src="{{asset(cache('templateSetting')['logo'])}}">


                </a>
                <ul class="items-center hidden gap-6 text-sm lg:flex dark:text-white/80 text-secondary">
                    @include('customer.layouts.menu')
                </ul>
               </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('customer.courses') }}" method="get">
        <div class="relative hidden lg:block">
        <label for="Search" class="sr-only"> Search </label>
        <input
          type="text"
          id="Search"
          name="search"
          value="{{request()->search}}"
          placeholder="جست و جو کنید ... "
          class="w-full rounded-xl border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm dark:bg-secondary bg-white dark:border-gray-700 dark:text-white/80  focus:ring-0 dark:focus:border-main  focus:border-main focus:outline-none"
        />

        <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
          <button type="submit" class="text-gray-600 hover:text-gray-700 ">
            <span class="sr-only">Search</span>

            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-4 h-4"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
              />
            </svg>
          </button>
        </span>
      </div>

                    </form>

                    <svg xmlns="http://www.w3.org/2000/svg " id="lightModeBtn" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="none"
                        class="w-6 h-6 duration-500 cursor-pointer stroke-white/80 hover:scale-110 dark:hover:stroke-yellow-300 hover:rotate-180 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z">
                        </path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" id="DarkModeBtn" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6 duration-500 cursor-pointer hover:scale-110 hover:stroke-violet-600 stroke-slate-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z">
                        </path>
                    </svg>
                    @guest
                    <a class="lg:flex hidden" href="{{ route('auth.customer.loginForm') }}">
                    <button class="border border-main px-5 py-1.5 font-bold rounded-xl hover:bg-transparent bg-main text-white/80 hover:text-main	flex gap-2 items-center ">
                     ثبت نام | ورود
                    </button>
                  </a>
                    @endguest
                  @auth
                  <a class="lg:flex hidden" href="@if (auth()->user()->is_admin == 1)
                    {{ route('admin.index') }}
                    @else
                    {{ route('customer.profile') }}
                  @endif "><button class="border border-main px-5 py-1.5 font-bold rounded-xl text-white hover:bg-transparent bg-main text-white/80 hover:text-main	flex gap-2 items-center " >


                   <span>پنل</span>
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
</svg>
                </button></a>
                  @endauth

                    <a type="button" href="{{route('customer.sales-process.cart')}}" class="relative  p-2 bg-main/20 rounded-xl block">
                        <svg class="w-5 h-5 " viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" class="fill-main"
                                d="M20.3503 27.9039C24.526 26.9217 27.7824 23.7217 28.735 19.649C29.5862 16.0101 29.3792 12.2127 28.1372 8.68161L27.9526 8.15703C26.586 4.27169 23.1721 1.40363 19.0196 0.65244L17.8826 0.446743C15.9772 0.102062 14.0228 0.102062 12.1175 0.446743L10.9804 0.652448C6.82795 1.40363 3.41399 4.27168 2.04738 8.157L1.86286 8.6816C0.62085 12.2127 0.413845 16.0101 1.265 19.649C2.21763 23.7218 5.47398 26.9217 9.64971 27.9039C13.1591 28.7294 16.8409 28.7295 20.3503 27.9039ZM11.2461 6.79981C11.4605 6.30356 11.2205 5.73231 10.71 5.52389C10.1996 5.31546 9.612 5.54879 9.39761 6.04504L9.06145 6.82315C8.43992 8.26183 8.28369 9.85038 8.61356 11.3775C9.13705 13.8009 11.1216 15.6727 13.6291 16.108L13.8145 16.1402C14.5986 16.2763 15.4014 16.2763 16.1856 16.1402L16.3709 16.108C18.8785 15.6727 20.863 13.8009 21.3865 11.3775C21.7163 9.85038 21.5601 8.26183 20.9386 6.82316L20.6024 6.04504C20.388 5.54879 19.8004 5.31546 19.29 5.52389C18.7795 5.73231 18.5395 6.30356 18.7539 6.79981L19.0901 7.57793C19.5539 8.65163 19.6705 9.8372 19.4244 10.9769C19.0689 12.6226 17.7213 13.8936 16.0185 14.1892L15.8331 14.2214C15.2821 14.3171 14.718 14.3171 14.1669 14.2214L13.9815 14.1892C12.2788 13.8936 10.9312 12.6226 10.5757 10.9769C10.3295 9.8372 10.4461 8.65163 10.91 7.57793L11.2461 6.79981Z" />
                        </svg>
                        <span class="absolute w-2 h-2 bg-yellow-400 rounded-lg right-1 top-1"></span>
                    </a>
                    @auth
                    <a type="button" href="@if (auth()->user()->is_admin == 1)
                    {{ route('admin.index') }}
                    @else
                    {{ route('customer.profile') }}
                  @endif" class="relative p-2 bg-main/20 rounded-xl lg:hidden block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-main">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                          </svg>

                    </a>
                    @endauth
                    @guest
                    <a type="button" href="{{ route('auth.customer.loginForm') }}" class="relative p-2 bg-main/20 rounded-xl lg:hidden block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-main">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                          </svg>

                    </a>
                    @endguest
                    <svg id="menuBtn" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 lg:hidden dark:text-white/80 rtl:rotate-180">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                    </svg>

                </div>
            </div>
        </header>
