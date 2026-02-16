@extends('customer.layouts.master')
@section('head-tag')
<title> بازیابی رمز عبور - {{cache('templateSetting')['title']}}</title>
@endsection
@section('content')
<div id="particles-js" style="position: fixed;
        z-index: -10;
        top:0;
        bottom: 0;
        left:0;
        right:0"></div>
<section class="content lg:blur-0 py-10">

    <section class="container flex justify-between items-center lg:flex-row flex-col relative min-h-96">
        <form action="{{ route('auth.customer.EmailResetPassword',$token->token) }}" method="post"
            class="lg:w-5/12 w-full">
            @csrf



            <main class="flex items-center justify-center  w-full">

                <div class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                    <h2 class="text-4xl font-bold text-main"> بازیابی رمز عبور</h2>
                    @error('WrongMobile')
                    <div>
                        <span class="font-bold text-red-500 ">{{ $message }}</span>
                    </div>
                    @enderror
                    <div class="flex flex-col w-full gap-4">

                        <div class="flex flex-col w-full gap-4">

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
                                <label class="relative block">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="showConfirmPassIcon w-6 h-6 cursor-pointer @error('password')
                      stroke-red-500 @else
                      stroke-main
                      @enderror">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="hideConfirmPassIcon w-6 h-6 cursor-pointer @error('password')
                      stroke-red-500 @else
                      stroke-main
                      @enderror hidden">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>

                                    </span>
                                    <input name="password_confirmation" class="confirmPasswordInp w-full py-4 pr-4 border pl-14 rounded-xl focus:border-main focus:ring-0 focus:outline-none placeholder:text-main placeholder:font-bold passInput dark:bg-secondary dark:text-white/80 @error('password_confirmation')
                  focus:border-red-500   border-red-500 placeholder:text-red-500

                  @enderror" placeholder="تکرار رمز عبور " type="password" />

                                    @error('password_confirmation')
                                    <span class="font-bold text-red-500">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-32 text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">
                            تغیر رمز</button>
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
