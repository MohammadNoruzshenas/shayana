@extends('customer.layouts.master')
@section('head-tag')
<title>ورود با پیامک - {{cache('templateSetting')['title']}}</title>

@if (cache('settings')['recaptcha'] == 1)
<meta name="csrf-token" content="{{ csrf_token() }}" />
{!! htmlScriptTagJsApi() !!}
@endif

@endsection


@section('content')
@csrf
<div id="particles-js" style="position: fixed;
        z-index: -10;
        top:0;
        bottom: 0;
        left:0;
        right:0"></div>
<section class="content lg:blur-0 py-10">

    <section class="container flex justify-between items-center lg:flex-row flex-col relative min-h-96 ">
        <form action="{{ route('auth.customer.smsLogin') }}" method="post" class="lg:w-5/12 w-full">
            @csrf

            <main class="flex items-center justify-center  w-full">

                <div class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                    <h2 class="text-4xl font-bold text-main">ورود با پیامک</h2>
                    <p class="text-gray-600">شماره موبایل خود را وارد کنید تا کد تایید برای شما ارسال شود</p>
                    
                    @error('error')
                    <div>
                        <span class="font-bold text-red-500 ">{{ $message }}</span>
                    </div>
                    @enderror
                    
                    <div class="flex flex-col w-full gap-4">
                        <div class="flex flex-col w-full gap-4">
                            <div class="flex flex-col gap-3">
                                <label class="relative block">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24" class="@error('mobile')
                        fill-red-500 @else
                        fill-main
                        @enderror">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                    </span>

                                    <input name="mobile" value="{{old('mobile')}}" required class="w-full py-4 pr-4 border placeholder:text-main  focus:border-main  pl-14 rounded-xl focus:ring-0  dark:bg-secondary dark:text-white/80 @error('mobile')
                      focus:border-red-500   border-red-500 placeholder:text-red-500 placeholder:font-bold
                      @enderror" placeholder=" شماره موبایل" type="text" />

                                </label>
                                @error('mobile')
                                <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @error('g-recaptcha-response')
                            <span class="font-bold text-red-500">{{$message}}</span>
                            @enderror
                            
                            <div class="flex flex-col gap-2">
                                <span class="font-bold text-gray-400">
                                    حساب کاربری ندارید؟
                                    <a href="{{ route('auth.customer.registerForm') }}" class="text-main"> ثبت نام </a>
                                </span>
                                <span class="font-bold text-gray-400">ورود با
                                    <a href="{{ route('auth.customer.loginForm') }}" class="text-main"> ایمیل و رمز عبور </a>
                                </span>
                                <span class="font-bold text-gray-400">بازیابی رمز عبور با
                                    <a href="{{ route('auth.customer.smsForgetPasswordForm') }}" class="text-main"> پیامک </a>
                                </span>
                            </div>
                            
                            <button type="submit"
                                class="w-full text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">
                                    ارسال کد تایید
                                </button>
                        </div>
                    </div>
                </div>
            </main>
        </form>
        
        <aside class="relative  lg:w-1/2 w-full lg:flex hidden">
            <img src="{{asset(cache('templateSetting')['image_auth'])}}" alt="">
        </aside>

    </section>
</section>


<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
  // Initialize Particle.js with custom configuration
  particlesJS('particles-js', {
    "particles": {
      "number": {
        "value": 38,
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#ffffff"
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        },
        "polygon": {
          "nb_sides": 5
        },
        "image": {
          "src": "img/github.svg",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.1,
          "sync": false
        }
      },
      "size": {
        "value": 3,
        "random": true,
        "anim": {
          "enable": false,
          "speed": 40,
          "size_min": 0.1,
          "sync": false
        }
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#ffffff",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 6,
        "direction": "none",
        "random": false,
        "straight": false,
        "out_mode": "out",
        "bounce": false,
        "attract": {
          "enable": false,
          "rotateX": 600,
          "rotateY": 1200
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": true,
          "mode": "repulse"
        },
        "onclick": {
          "enable": true,
          "mode": "push"
        },
        "resize": true
      },
      "modes": {
        "grab": {
          "distance": 400,
          "line_linked": {
            "opacity": 1
          }
        },
        "bubble": {
          "distance": 400,
          "size": 40,
          "duration": 2,
          "opacity": 8,
          "speed": 3
        },
        "repulse": {
          "distance": 200,
          "duration": 0.4
        },
        "push": {
          "particles_nb": 4
        },
        "remove": {
          "particles_nb": 2
        }
      }
    },
    "retina_detect": true
  });
</script>
@endsection 