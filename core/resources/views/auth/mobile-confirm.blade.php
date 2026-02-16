    @extends('customer.layouts.master')
    @section('head-tag')
        <title>ورود - {{ cache('templateSetting')['title'] }}</title>
        <style>
            .d-none {
                display: none;
            }
        </style>
        @if (cache('settings')['recaptcha'] == 1)
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            {!! htmlScriptTagJsApi() !!}
        @endif
    @endsection
    @section('content')
        <div id="particles-js"
            style="position: fixed;
        z-index: -10;
        top:0;
        bottom: 0;
        left:0;
        right:0">
        </div>
        <section class="content lg:blur-0 py-10">

            <section class="container flex justify-between items-center lg:flex-row flex-col relative min-h-96 ">
                <form action="{{ route('auth.customer.mobile-confirm', $token) }}" method="post" class="lg:w-5/12 w-full">
                    @csrf



                    <main class="flex items-center justify-center  w-full">

                        <div
                            class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                            <h2 class="text-4xl font-bold text-main">تایید شماره</h2>
                            <span class="font-bold text-gray-400 text-main">کد تایید به شماره {{ $otp->login_id }} ارسال
                                شد</span>

                            @error('error')
                                <div>
                                    <span class="font-bold text-red-500 ">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- <div class="flex flex-col w-full gap-4">

                                <div class="flex flex-col w-full gap-4">
                                    <div class="flex flex-col gap-3">
                                        <label class="relative block">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">


                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="h-6 w-6 @error('code')
                                                stroke-red-500 @else
                                                stroke-main
                                                @enderror">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                                </svg>


                                            </span>

                                            <input name="code" value="{{ old('code') }}" class="w-full py-4 pr-4 border placeholder:text-main  focus:border-main  pl-14 rounded-xl focus:ring-0  dark:bg-secondary dark:text-white/80 @error('code')
                                          focus:border-red-500   border-red-500 placeholder:text-red-500 placeholder:font-bold
                                          @enderror" placeholder="کد تایید" type="text" />

                                        </label>
                                        @error('code')
        <span class="font-bold text-red-500">{{ $message }}</span>
    @enderror

                                    </div>




                                    <section id="timer" class="text-teal-500"></section>
                                    <button type="submit"
                                        class="w-32 text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">ثبت
                                        نام</button>
                          </div> -->
                          <section id="timer" class="text-teal-500"></section>
                            <section id="resend-otp" class="d-none">
                                <a href="{{ route('auth.customer.login-resend-otp', $token) }}" class="text-main">دریافت
                                    مجدد کد تایید</a>
                            </section>


                            <div class="formConfirm w-full">
                                <div class="flex justify-center w-full gap-3  mb-3" style="direction:ltr;">
                                    <input name="code[]" type="tel" maxlength="1" pattern="[0-9]"
                                        class="form-control inputConfirm">
                                    <input name="code[]" type="tel" maxlength="1" pattern="[0-9]"
                                        class="form-control inputConfirm">
                                    <input name="code[]" type="tel" maxlength="1" pattern="[0-9]"
                                        class="form-control inputConfirm">
                                    <input name="code[]" type="tel" maxlength="1" pattern="[0-9]"
                                        class="form-control inputConfirm">
                                    <input name="code[]" type="tel" maxlength="1" pattern="[0-9]"
                                        class="form-control inputConfirm">
                                    <input name="code[]" type="tel" maxlength="1" pattern="[0-9]"
                                        class="form-control inputConfirm">
                                </div>

                            </div>
                            <button class="w-32 text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">ورود
                            </button>
                    </main>
                </form>

                <aside class="relative  lg:w-1/2 w-full lg:flex hidden">

                    <img src="{{ asset(cache('templateSetting')['image_auth']) }}" alt="">
                </aside>


            </section>
        </section>
    @endsection

    @section('script')
    <script src="{{asset('customer/js/jquery-3.6.1.min.js')}}"></script>

        @php
            $timer =
                ((new \Carbon\Carbon($otp->created_at))->addMinutes(5)->timestamp - \Carbon\Carbon::now()->timestamp) *
                1000;
        @endphp

        <script>
            var timerValue = {{$timer}};
            var countDownDate = new Date().getTime() + timerValue;
            var timer = $('#timer');
            var resendOtp = $('#resend-otp');

            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                if (minutes == 0) {
                    timer.html('ارسال مجدد کد تایید تا ' + seconds + 'ثانیه دیگر')
                } else {
                    timer.html('ارسال مجدد کد تایید تا ' + minutes + 'دقیقه و ' + seconds + 'ثانیه دیگر');
                }
                if (distance < 0) {
                    clearInterval(x);
                    timer.addClass('d-none');
                    resendOtp.removeClass('d-none');
                }
            }, 1000);
        </script>

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
            const form = document.querySelector('.formConfirm')
            const inputs = form.querySelectorAll('.form-control')
            const KEYBOARDS = {
                backspace: 8,
                arrowLeft: 37,
                arrowRight: 39,
            }

            function handleInput(e) {
                const input = e.target
                const nextInput = input.nextElementSibling
                if (nextInput && input.value) {
                    nextInput.focus()
                    if (nextInput.value) {
                        nextInput.select()
                    }
                }
            }

            function handlePaste(e) {
                e.preventDefault()
                const paste = e.clipboardData.getData('text')
                inputs.forEach((input, i) => {
                    input.value = paste[i] || ''
                })
            }

            function handleBackspace(e) {
                const input = e.target
                if (input.value) {
                    input.value = ''
                    return
                }

                input.previousElementSibling.focus()
            }

            function handleArrowLeft(e) {
                const previousInput = e.target.previousElementSibling
                if (!previousInput) return
                previousInput.focus()
            }

            function handleArrowRight(e) {
                const nextInput = e.target.nextElementSibling
                if (!nextInput) return
                nextInput.focus()
            }

            form.addEventListener('input', handleInput)
            inputs[0].addEventListener('paste', handlePaste)

            inputs.forEach(input => {
                input.addEventListener('focus', e => {
                    setTimeout(() => {
                        e.target.select()
                    }, 0)
                })

                input.addEventListener('keydown', e => {
                    switch (e.keyCode) {
                        case KEYBOARDS.backspace:
                            handleBackspace(e)
                            break
                        case KEYBOARDS.arrowLeft:
                            handleArrowLeft(e)
                            break
                        case KEYBOARDS.arrowRight:
                            handleArrowRight(e)
                            break
                        default:
                    }
                })
            })
        </script>
    @endsection
