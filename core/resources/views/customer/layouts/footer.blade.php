<svg xmlns="http://www.w3.org/2000/svg" style="margin-bottom: -1px"  viewBox="0 0 1458 160" fill="none">
    <path
        d="M0 128.058L48.6 112.086C97.2 96.1151 194.4 64.1726 291.6 37.5206C388.8 11.2679 486 -10.6926 583.2 5.57812C680.4 21.2499 777.6 75.1528 874.8 90.8246C972 107.095 1069.2 85.1348 1166.4 90.8246C1263.6 96.1151 1360.8 128.058 1409.4 144.029L1458 160H1409.4C1360.8 160 1263.6 160 1166.4 160C1069.2 160 972 160 874.8 160C777.6 160 680.4 160 583.2 160C486 160 388.8 160 291.6 160C194.4 160 97.2 160 48.6 160H0V128.058Z"
        class="fill-gray dark:fill-dark" />
</svg>
<footer class="py-6 md:py-8  px-4  dark:bg-dark bg-gray">

    <div class="grid gap-8 md:gap-14 grid-cols-5 grid-row-2 container md:max-w-screen-xl mx-auto py-10">
        <div class="col-span-5 md:col-span-2 flex flex-col justify-start">
            <div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('customer.home') }}" class="flex items-center gap-x-1">
                        <image class="w-10 h-10" src="{{ asset(cache('templateSetting')['logo']) }}">

                            <p class="font-bold text-main">
                                {{ cache('templateSetting')['title'] }}
                            </p>
                    </a>
                </div>
                <p class=" mx-auto mt-6 leading-relaxed text-center  text-secondary  lg:text-start dark:text-white/80">
                    {{ cache('templateSetting')['about_footer'] }}
                </p>
            </div>
            <div class="mt-4">
                <ul class="items-center w-full justify-center gap-3 text-sm flex lg:w-min">
                    @if (cache('templateSetting')['link_instagram'])
                    <a class="dark:text-white/80" href="https://instagram.com/{{ cache('templateSetting')['link_instagram'] }}">
                      <svg  fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
<path d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"></path>
</svg>
                    </a>
                    @endif
                    @if (cache('templateSetting')['link_telegram'])
                    <a class="dark:text-white/80"  href="https://t.me/{{ cache('templateSetting')['link_telegram'] }}">

                        <svg  fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"  width="30" height="30" viewBox="0 0 50 50">
<path   d="M 25 2 C 12.309288 2 2 12.309297 2 25 C 2 37.690703 12.309288 48 25 48 C 37.690712 48 48 37.690703 48 25 C 48 12.309297 37.690712 2 25 2 z M 25 4 C 36.609833 4 46 13.390175 46 25 C 46 36.609825 36.609833 46 25 46 C 13.390167 46 4 36.609825 4 25 C 4 13.390175 13.390167 4 25 4 z M 34.087891 14.035156 C 33.403891 14.035156 32.635328 14.193578 31.736328 14.517578 C 30.340328 15.020578 13.920734 21.992156 12.052734 22.785156 C 10.984734 23.239156 8.9960938 24.083656 8.9960938 26.097656 C 8.9960938 27.432656 9.7783594 28.3875 11.318359 28.9375 C 12.146359 29.2325 14.112906 29.828578 15.253906 30.142578 C 15.737906 30.275578 16.25225 30.34375 16.78125 30.34375 C 17.81625 30.34375 18.857828 30.085859 19.673828 29.630859 C 19.666828 29.798859 19.671406 29.968672 19.691406 30.138672 C 19.814406 31.188672 20.461875 32.17625 21.421875 32.78125 C 22.049875 33.17725 27.179312 36.614156 27.945312 37.160156 C 29.021313 37.929156 30.210813 38.335938 31.382812 38.335938 C 33.622813 38.335938 34.374328 36.023109 34.736328 34.912109 C 35.261328 33.299109 37.227219 20.182141 37.449219 17.869141 C 37.600219 16.284141 36.939641 14.978953 35.681641 14.376953 C 35.210641 14.149953 34.672891 14.035156 34.087891 14.035156 z M 34.087891 16.035156 C 34.362891 16.035156 34.608406 16.080641 34.816406 16.181641 C 35.289406 16.408641 35.530031 16.914688 35.457031 17.679688 C 35.215031 20.202687 33.253938 33.008969 32.835938 34.292969 C 32.477938 35.390969 32.100813 36.335938 31.382812 36.335938 C 30.664813 36.335938 29.880422 36.08425 29.107422 35.53125 C 28.334422 34.97925 23.201281 31.536891 22.488281 31.087891 C 21.863281 30.693891 21.201813 29.711719 22.132812 28.761719 C 22.899812 27.979719 28.717844 22.332938 29.214844 21.835938 C 29.584844 21.464938 29.411828 21.017578 29.048828 21.017578 C 28.923828 21.017578 28.774141 21.070266 28.619141 21.197266 C 28.011141 21.694266 19.534781 27.366266 18.800781 27.822266 C 18.314781 28.124266 17.56225 28.341797 16.78125 28.341797 C 16.44825 28.341797 16.111109 28.301891 15.787109 28.212891 C 14.659109 27.901891 12.750187 27.322734 11.992188 27.052734 C 11.263188 26.792734 10.998047 26.543656 10.998047 26.097656 C 10.998047 25.463656 11.892938 25.026 12.835938 24.625 C 13.831938 24.202 31.066062 16.883437 32.414062 16.398438 C 33.038062 16.172438 33.608891 16.035156 34.087891 16.035156 z"></path>
</svg>
                    </a>
                    @endif

                </ul>
            </div>
        </div>
        <div class="col-span-5 md:col-span-1">
            <h3 class="text-xl mb-4 text-main ">{{ cache('templateSetting')['footer_title_link'] }}</h3>
            <nav>
                <ul class="text-sm marker:text-main">
                    @foreach (cache('footerLinks') as $link)
                    <li class="list-disc py-2 list-inside"><a
                            class="py-2 transition-all duration-300  text-secondary dark:text-white/80   hover:text-main  "
                            href="{{$link->link()}}">{{$link->title}}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <div class="col-span-5 md:col-span-1">
            <h3 class="text-xl mb-4 text-main">{{ cache('templateSetting')['footer_title_link2'] }}</h3>
            <nav>
                <ul class="text-sm marker:text-main">
                    @foreach (cache('footerLinks2') as $link)
                    <li class="list-disc py-2 list-inside"><a
                            class="py-2 transition-all duration-300  text-secondary dark:text-white/80   hover:text-main  "
                            href="{{$link->link()}}">{{$link->title}}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="col-span-5 md:col-span-1"    >
        <h3 class="text-xl mb-4 text-main ">نماد های سایت</h3>
        <div class="relative h-24 w-24">
            <div class="absolute z-50 object-cover w-full h-full flex gap-5">
          <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=624581&Code=XbN5Q8OZQu02Y2b40tn3lqaGyp3xKgmj'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=624581&Code=XbN5Q8OZQu02Y2b40tn3lqaGyp3xKgmj' alt='' style='cursor:pointer' code='XbN5Q8OZQu02Y2b40tn3lqaGyp3xKgmj'></a>
            </div>
        </div>
        </div>
        <div class="col-span-5 flex justify-between items-center">
            <p class="text-center tex-xs text-secondary dark:text-white/80"> {{ cache('templateSetting')['copyright'] }}
            </p>
            <button onClick="window.scrollTo(0, 0);" class="w-10 h-10 bg-main/90 hover:bg-main rounded-lg text-white flex justify-center items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
</svg>
            </button>
        </div>

    </div>
</footer>
