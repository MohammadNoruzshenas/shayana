@extends('customer.layouts.master')
@section('head-tag')
<title> بازیابی رمز عبور - {{cache('templateSetting')['title']}}</title>

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
        <form action="{{ route('auth.customer.forgetPassword') }}" method="post" class="lg:w-5/12 w-full">
            @csrf



            <main class="flex items-center justify-center  w-full">

                <div class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                    <h2 class="text-4xl font-bold text-main"> بازیابی رمز عبور </h2>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="27" viewBox="0 0 24 27"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" class="@error('email')
                    fill-red-500 @else
                    fill-main
                    @enderror" d="M10 0C9.44772 0 9 0.447715 9 1V2H8C7.08264 2 6.30954 2.61762 6.07383 3.45972C1.21097 4.49467 0 7.52779 0 15C0 24.882 2.118 27 12 27C21.882 27 24 24.882 24 15C24 7.52779 22.789 4.49467 17.9262 3.45972C17.6905 2.61762 16.9174 2 16 2H15V1C15 0.447715 14.5523 0 14 0C13.4477 0 13 0.447715 13 1V2H11V1C11 0.447715 10.5523 0 10 0ZM7 20C6.44772 20 6 20.4477 6 21C6 21.5523 6.44771 22 7 22H17C17.5523 22 18 21.5523 18 21C18 20.4477 17.5523 20 17 20H7ZM6 16C6 15.4477 6.44772 15 7 15H17C17.5523 15 18 15.4477 18 16C18 16.5523 17.5523 17 17 17H7C6.44771 17 6 16.5523 6 16ZM7 12C6.44772 12 6 11.5523 6 11C6 10.4477 6.44771 10 7 10H17C17.5523 10 18 10.4477 18 11C18 11.5523 17.5523 12 17 12H7Z"
                                            fill="none" />
                                    </svg>


                                    </span>

                                    <input name="email" value="{{old('email')}}" class="w-full py-4 pr-4 border placeholder:text-main  focus:border-main  pl-14 rounded-xl focus:ring-0  dark:bg-secondary dark:text-white/80 @error('email')
                      focus:border-red-500   border-red-500 placeholder:text-red-500 placeholder:font-bold
                      @enderror" placeholder="ایمیل" type="text" />

                                </label>
                                @error('email')
                                <span class="font-bold text-red-500">{{ $message }}</span>

                                @enderror

                            </div>

                            @error('g-recaptcha-response')
                            <span class="font-bold text-red-500">{{$message}}</span>

                            @enderror
                            
                            <div class="flex flex-col gap-2">
                                <span class="font-bold text-gray-400">بازیابی رمز عبور با
                                    <a href="{{ route('auth.customer.smsForgetPasswordForm') }}" class="text-main"> پیامک </a>
                                </span>
                                <span class="font-bold text-gray-400">ورود با
                                    <a href="{{ route('auth.customer.loginForm') }}" class="text-main"> ایمیل و رمز عبور </a>
                                </span>
                            </div>
                            
                              <button type="submit"
                                class="w-full text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">بازیابی
                                </button>
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
