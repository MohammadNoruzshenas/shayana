@extends('customer.layouts.master')
@section('head-tag')
    <title>پشتیبانی</title>
@endsection
@section('content')
    <section class="container my-5 content lg:blur-0">
        <a href="{{ route('customer.profile') }}"
            class="flex items-center gap-2 text-lg font-bold lg:text-lg group text-main"> برگشت به پروفایل
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                class="duration-200 rtl:rotate-180 group-hover:-translate-x-1" viewBox="0 0 24 24" fill="none">
                <path d="M14.4302 5.92999L20.5002 12L14.4302 18.07" class="stroke-main" stroke="#4A6DFF" stroke-width="1.5"
                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M3.5 12H20.33" stroke="#4A6DFF" class="stroke-main" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <br>
        <div class="flex flex-col justify-between gap-5 lg:flex-row" data-aos="fade-down">

            <div class="flex flex-col  w-full gap-4 p-5 bg-white rounded-3xl dark:bg-dark ">

                <div
                    class="flex justify-between items-center pb-3.5 md:pb-4.5 mb-6 md:mb-7 border-b border-b-gray-200 dark:border-b-gray-700">
                    <span class=" md:text-3xl text-zinc-700 dark:text-white">{{ $ticket->subject }}</span>
                </div>


                <div class="space-y-6">
                    <div
                        class="w-11/12 p-4 bg-gray-100 rounded-tr-sm sm:w-2/3 dark:bg-secondary/70 text-zinc-700 dark:text-white rounded-2xl">
                        <h4 class="mb-1 text-xl text-right ">{{ $ticket->user->full_name }}</h4>
                        <span class="block text-xs text-right text-slate-500 dark:text-slate-400"
                            style="direction: ltr;">{{ jalaliDate($ticket->created_at,'Y/m/d H:s') }}</span>
                        <p class=" mt-4.5">{{ $ticket->description }}</p>
                    </div>
                    @if ($ticket->file()->count() > 0)
                        <section class="card-footer">
                            <a class="flex items-center gap-2 w-44 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main"
                                href="{{ asset($ticket->file->file_path) }}" download>
                                دانلود ضمیمه
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </a>
                        </section>
                    @endif

                    @foreach ($ticket->children as $child)
                        @if ($child->user_id == auth()->user()->id)
                            <div
                                class="w-11/12 p-4 bg-gray-100 rounded-tr-sm sm:w-2/3 dark:bg-secondary/70 text-zinc-700 dark:text-white rounded-2xl">
                                <h4 class="mb-1 text-xl text-right ">{{ $child->user->full_name }}</h4>
                                <span class="block text-xs text-right text-slate-500 dark:text-slate-400"
                                    style="direction: ltr;">{{ jalaliDate($child->created_at,'Y/m/d H:s') }}</span>
                                <p class=" mt-4.5">{{ $child->description }}</p>
                            </div>
                            @if ($child->file()->count() > 0)
                                <section class="card-footer">
                                    <a class="flex items-center gap-2 w-44 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main"
                                        href="{{ asset($child->file->file_path) }}" download>
                                        دانلود ضمیمه
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </a>
                                </section>
                            @endif
                        @else
                            <div
                                class="w-11/12 p-4 rounded-tr-sm ltr:ml-auto rtl:mr-auto sm:w-2/3 bg-main/40 dark:bg-secondary text-zinc-700 dark:text-white rounded-2xl">
                                <h4 class="mb-1 text-xl text-right ">ادمین </h4>
                                <span class="block text-xs text-right text-slate-500 mb-2 dark:text-slate-400"
                                style="direction: ltr;">{{ jalaliDate($child->created_at,'Y/m/d H:s') }}</span>
                                <p class=" mt-4.5"></p>
                                <p>{{ $child->description }}</p>
                            </div>
                            @if ($child->file()->count() > 0)
                                <section class="card-footer text-left rounded-tr-sm ltr:ml-auto rtl:mr-auto sm:w-2/3">
                                    <a class="flex items-center gap-2 w-44 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main"
                                        href="{{ asset($child->file->file_path) }}" download>
                                        دانلود ضمیمه
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </a>
                                </section>
                            @endif
                        @endif
                    @endforeach
                </div>
                @if ($ticket->status != 0)
                <form class="mt-10" method="post" action="{{ route('customer.profile.ticket.answer',$ticket) }}"  enctype="multipart/form-data">
                    @csrf
                    <textarea rows="6"
                        class="block w-full p-3 text-sm transition-colors bg-gray-100 border border-transparent md:p-5 md:text-base text-slate-500 dark:text-gray-500 focus:text-zinc-700 dark:focus:text-white dark:bg-secondary rounded-2xl "
                        name="description" required="" placeholder="پاسخ ..."></textarea>
                    <div class="flex gap-x-2 justify-end mt-2.5">
                            <input name="file" hidden type="file"id="fileTicketInp"
                            onchange="document.querySelector('#filTecketBtn').innerText =  this.files[0].name">
                         <button id="filTecketBtn" type="button" onclick="document.querySelector('#fileTicketInp').click();"
                        class="flex items-center gap-2 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main ">
                        انتخاب فایل ضمیمه
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                          </svg>


                         </button>
                        <button
                            class="flex items-center gap-2 px-8 py-3 text-sm font-medium text-white transition border rounded-lg bg-main border-main shrink-0 hover:bg-transparent hover:text-main focus:outline-none focus:ring active:text-main">
                            ارسال
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 rtl:rotate-180">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                              </svg>

                        </button>

                    </div>
                    @error('file')
                    <div>
                        <span class="font-bold text-red-500 ">{{ $message }}</span>
                    </div>
                    @enderror
                </form>
                @endif

            </div>
        </div>
    </section>
@endsection
