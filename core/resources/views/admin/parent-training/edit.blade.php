@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش آموزش والدین</title>
    {{-- اضافه کردن Tailwind CSS --}}
    <script src="{{ asset('dashboard/js/tailwindcss.js') }}"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    <style>
        /* نمایش textarea اگر CKEditor لود نشود */
        #description {
            display: block !important;
            visibility: visible !important;
            width: 100% !important;
            min-height: 300px !important;
        }

        .cke {
            display: block !important;
            visibility: visible !important;
        }

        .cke_wrapper {
            display: block !important;
            visibility: visible !important;
        }
    </style>
@endsection

@section('content')
    <div class="p-4 w-full font-sans">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                        <i class="fa fa-edit text-blue-500"></i>
                        ویرایش ویدیو آموزشی: {{ $parentTraining->title }}
                    </h5>
                    <a href="{{ route('admin.parent-training.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fa fa-arrow-left"></i>
                        بازگشت
                    </a>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.parent-training.update', $parentTraining->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">عنوان آموزش</label>
                            <input type="text" name="title" value="{{ old('title', $parentTraining->title) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                placeholder="مثال: نحوه رفتار با کودکان" required>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">لینک ویدیو آموزشی</label>
                            <input type="text" name="video_link" value="{{ old('video_link', $parentTraining->video_link) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                placeholder="مثال: https://aparat.com/v/XXXXX">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">لینک ویس آموزشی</label>
                            <input type="text" name="audio_link" value="{{ old('audio_link', $parentTraining->audio_link) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                placeholder="لینک فایل صوتی را اینجا قرار دهید">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">توضیحات</label>
                            <div class="rounded-xl overflow-hidden border border-gray-300">
                                <textarea name="description" id="description" class="ckeditor">{{ old('description', $parentTraining->description) }}</textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 transform active:scale-95">
                            <i class="fa fa-save"></i>
                            به‌روزرسانی آموزش
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('dashboard/js/ckeditor/ckeditor.js') }}"></script>
    <script>


        window.addEventListener('load', function() {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('description', {
                    height: 300
                });
            }
        });
    </script>
@endsection
