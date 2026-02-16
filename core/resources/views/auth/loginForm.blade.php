@extends('customer.layouts.master')
@section('head-tag')
<title>ورود - {{cache('templateSetting')['title']}}</title>

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

    <section class="container flex justify-between items-center lg:flex-row flex-col relative min-h-96">
        <form action="{{ route('auth.customer.login') }}" method="post" class="lg:w-5/12 w-full" data-aos="fade-up">
            @csrf



            <main class="flex items-center justify-center  w-full">

                <div class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                    <h2 class="text-4xl font-bold text-main">ورود</h2>
                    @error('wrongPassOrEmail')
                    <div>
                        <span class="font-bold text-red-500 ">{{ $message }}</span>
                    </div>
                    @enderror
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
                  @enderror" placeholder=" ایمیل" type="text" />

                            </label>
                            @error('email')
                            <span class="font-bold text-red-500">{{ $message }}</span>

                            @enderror

                        </div>
                        <div class="flex flex-col gap-3">
                            <label class="relative block">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class=" showPassIcon w-6 h-6 cursor-pointer @error('password')
                      stroke-red-500 @else
                      stroke-main
                      @enderror">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="hidePassIcon w-6 h-6 cursor-pointer @error('password')
                      stroke-red-500 @else
                      stroke-main
                      @enderror hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>


                                </span>
                                <input name="password" class="passwordInp w-full py-4 pr-4 border pl-14 rounded-xl focus:border-main focus:ring-0 focus:outline-none placeholder:text-main placeholder:font-bold passInput dark:bg-secondary dark:text-white/80 @error('password')
                  focus:border-red-500   border-red-500 placeholder:text-red-500

                  @enderror" placeholder="رمز عبور " type="password" />
                                @error('password')
                                <span class="font-bold text-red-500">{{ $message }}</span>
                                @enderror

                            </label>

                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                    @if (cache('settings')['method_login_register'] == 0 || cache('settings')['method_login_register']
                    == 2)

                    <span class="font-bold text-gray-400">
                        حساب کاربری ندارید؟

                         <a class="text-main" href="{{ route('auth.customer.registerForm') }}"> ثبت نام </a>
                        </span>
                        

                    @endif
                    <span class="font-bold text-gray-400">رمز عبور خود را فراموش کرده اید ؟ <a
                            href="{{ route('auth.customer.smsForgetPasswordForm') }}" class="text-main">برای بازیابی کلیک
                            کنید</a></span>
                    
                    <!-- SMS Login Button -->
                    <div class="flex items-center  mt-4">
                
                        <a href="{{ route('auth.customer.smsLoginForm') }}" 
                           class="text-main">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" class="fill-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            ورود با پیامک
                        </a>
                    </div>
                    </div>
                    <button type="submit"
                        class="w-32 text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">ورود
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

<script>
  // Password visibility toggle functionality
  document.addEventListener('DOMContentLoaded', function() {
    const showPassIcon = document.querySelector('.showPassIcon');
    const hidePassIcon = document.querySelector('.hidePassIcon');
    const passwordInput = document.querySelector('.passInput');

    // Show password when show icon is clicked
    showPassIcon.addEventListener('click', function() {
      passwordInput.type = 'text';
      showPassIcon.classList.add('hidden');
      hidePassIcon.classList.remove('hidden');
    });

    // Hide password when hide icon is clicked
    hidePassIcon.addEventListener('click', function() {
      passwordInput.type = 'password';
      hidePassIcon.classList.add('hidden');
      showPassIcon.classList.remove('hidden');
    });
  });
</script>
@endsection
