@extends('customer.layouts.master')
@section('head-tag')
    <title>تایید کد بازیابی رمز عبور - {{ cache('templateSetting')['title'] }}</title>
    <style>
        .d-none {
            display: none;
        }
        .form-control {
            width: 3rem;
            height: 3rem;
            font-size: 1.5rem;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
        }
        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .inputConfirm {
            transition: all 0.2s ease;
        }
        .inputConfirm:hover {
            border-color: #9ca3af;
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
            <form action="{{ route('auth.customer.smsForgetPasswordConfirm', $token) }}" method="post" class="lg:w-5/12 w-full">
                @csrf

                <main class="flex items-center justify-center  w-full">

                    <div
                        class="flex flex-col w-full h-auto gap-10   lg:rounded-3xl bg-white  shadow-lg rounded-2xl dark:bg-dark dark:shadow-none p-5">

                        <h2 class="text-4xl font-bold text-main">تایید کد بازیابی رمز عبور</h2>
                        <span class="font-bold text-gray-400 text-main">کد تایید به شماره {{ $otp->login_id }} ارسال
                            شد</span>

                        @error('error')
                            <div>
                                <span class="font-bold text-red-500 ">{{ $message }}</span>
                            </div>
                        @enderror
                        
                      <section id="timer" class="text-teal-500"></section>
                        <section id="resend-otp" class="d-none">
                            <a href="{{ route('auth.customer.smsForgetPasswordResendOtp', $token) }}" class="text-main">دریافت
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
                        
                        <div class="flex flex-col gap-2">
                            <span class="font-bold text-gray-400">بازگشت به 
                                <a href="{{ route('auth.customer.smsForgetPasswordForm') }}" class="text-main"> بازیابی با پیامک </a>
                            </span>
{{--                            <span class="font-bold text-gray-400">بازیابی رمز عبور با--}}
{{--                                <a href="{{ route('auth.customer.forgetPasswordForm') }}" class="text-main"> ایمیل </a>--}}
{{--                            </span>--}}
                            <span class="font-bold text-gray-400">ورود با
                                <a href="{{ route('auth.customer.loginForm') }}" class="text-main"> ایمیل و رمز عبور </a>
                            </span>
                        </div>
                        
                        <button class="w-full text-white focus:border-main bg-main rounded-xl h-14 hover:bg-main/90">تایید کد
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
            ((new \Carbon\Carbon($otp->created_at))->addMinutes(2)->timestamp - \Carbon\Carbon::now()->timestamp) *
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