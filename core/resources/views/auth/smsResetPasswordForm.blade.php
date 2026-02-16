@extends('customer.layouts.master')
@section('head-tag')
<title>تعیین رمز عبور جدید - {{cache('templateSetting')['title']}}</title>

@if (cache('settings')['recaptcha'] == 1)
<meta name="csrf-token" content="{{ csrf_token() }}" />
{!! htmlScriptTagJsApi() !!}
@endif

@endsection
@section('content')
<div id="particles-js" style="position: fixed;
        z-index: -10;
        top:0;
        bottom: 0;
        left:0;
        right:0"></div>
<section class="content lg:blur-0 py-10">

    <section class="container flex justify-between items-center lg:flex-row flex-col relative min-h-96 ">
        <form action="{{ route('auth.customer.smsResetPassword', $token) }}" method="post" class="lg:w-5/12 w-full">
            @csrf

            <main class="flex items-center justify-center  w-full">

                <div class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                    <h2 class="text-4xl font-bold text-main">تعیین رمز عبور جدید</h2>
                    <p class="text-gray-600">رمز عبور جدید خود را وارد کنید</p>
                    
                    @error('wrongPassOrEmail')
                    <div>
                        <span class="font-bold text-red-500 ">{{ $message }}</span>
                    </div>
                    @enderror
                    
                    <div class="flex flex-col w-full gap-4">
                        <div class="flex flex-col w-full gap-4">
                            <div class="flex flex-col gap-3">
                                <label class="relative block">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" class="@error('password')
                        fill-red-500 @else
                        fill-main
                        @enderror">
                                            <path
                                                d="M18 10V8C18 5.79086 16.2091 4 14 4H10C7.79086 4 6 5.79086 6 8V10C4.89543 10 4 10.8954 4 12V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V12C20 10.8954 19.1046 10 18 10ZM8 8C8 6.89543 8.89543 6 10 6H14C15.1046 6 16 6.89543 16 8V10H8V8Z" />
                                        </svg>
                                    </span>

                                    <input name="password" class="w-full py-4 pr-4 border placeholder:text-main  focus:border-main  pl-14 rounded-xl focus:ring-0  dark:bg-secondary dark:text-white/80 @error('password')
                      focus:border-red-500   border-red-500 placeholder:text-red-500 placeholder:font-bold
                      @enderror" placeholder="رمز عبور جدید" type="password" />

                                </label>
                                @error('password')
                                <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="flex flex-col gap-3">
                                <label class="relative block">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" class="@error('password_confirmation')
                        fill-red-500 @else
                        fill-main
                        @enderror">
                                            <path
                                                d="M18 10V8C18 5.79086 16.2091 4 14 4H10C7.79086 4 6 5.79086 6 8V10C4.89543 10 4 10.8954 4 12V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V12C20 10.8954 19.1046 10 18 10ZM8 8C8 6.89543 8.89543 6 10 6H14C15.1046 6 16 6.89543 16 8V10H8V8Z" />
                                        </svg>
                                    </span>

                                    <input name="password_confirmation" class="w-full py-4 pr-4 border placeholder:text-main  focus:border-main  pl-14 rounded-xl focus:ring-0  dark:bg-secondary dark:text-white/80 @error('password_confirmation')
                      focus:border-red-500   border-red-500 placeholder:text-red-500 placeholder:font-bold
                      @enderror" placeholder="تکرار رمز عبور جدید" type="password" />

                                </label>
                                @error('password_confirmation')
                                <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @error('g-recaptcha-response')
                            <span class="font-bold text-red-500">{{$message}}</span>
                            @enderror
                            
                            <div class="flex flex-col gap-2">
                                <span class="font-bold text-gray-400">ورود با
                                    <a href="{{ route('auth.customer.loginForm') }}" class="text-main"> ایمیل و رمز عبور </a>
                                </span>
                                <span class="font-bold text-gray-400">بازیابی رمز عبور با
                                    <a href="{{ route('auth.customer.forgetPasswordForm') }}" class="text-main"> ایمیل </a>
                                </span>
                            </div>
                            
                            <button type="submit"
                                class="w-full text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">
                                تغییر رمز عبور
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