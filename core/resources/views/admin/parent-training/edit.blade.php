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

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ویدیو آموزشی (در صورت تمایل به تغییر انتخاب کنید)</label>
                            <div class="relative">
                                <input type="file" name="video_path" id="parentTrainingVideo" class="hidden" accept="video/*"
                                    onchange="previewVideo(this)">
                                <button type="button" onclick="document.getElementById('parentTrainingVideo').click()"
                                    class="w-full px-4 py-8 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center gap-2 cursor-pointer">
                                    <i class="fa fa-video text-2xl text-gray-400"></i>
                                    <span class="text-sm text-gray-600">برای تغییر ویدیو کلیک کنید</span>
                                    <span class="text-xs text-gray-400">حداکثر حجم: 50 مگابایت</span>
                                </button>
                            </div>
                            <!-- پیش‌نمایش فایل جدید یا فعلی -->
                            <div id="videoPreviewContainer" class="mt-4 {{ $parentTraining->video_path ? '' : 'hidden' }}">
                                <div class="relative inline-block w-full">
                                    <video id="videoPreview" controls class="w-full rounded-xl border border-gray-300 {{ $parentTraining->video_path ? '' : 'hidden' }}" src="{{ $parentTraining->video_path ? asset($parentTraining->video_path) : '' }}">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p id="fileTextPreview" class="text-center font-bold text-gray-600 hidden bg-gray-100 p-4 border rounded-xl"></p>    
                                    <button type="button" onclick="removeVideo()"
                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-colors duration-200">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <p id="fileName" class="text-xs text-gray-500 mt-2"></p>
                            </div>
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
        function previewVideo(input) {
            const file = input.files[0];
            if (file) {
                // max 50MB
                if (file.size > 50 * 1024 * 1024) {
                    alert('حجم فایل باید کمتر از 50 مگابایت باشد');
                    input.value = '';
                    return;
                }

                document.getElementById('fileName').textContent = 'نام فایل جدید: ' + file.name + ' (' + (file.size /
                    (1024 * 1024)).toFixed(2) + ' MB)';
                document.getElementById('videoPreviewContainer').classList.remove('hidden');

                if (file.type.startsWith('video/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const video = document.getElementById('videoPreview');
                        video.src = e.target.result;
                        video.classList.remove('hidden');
                        document.getElementById('fileTextPreview').classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('videoPreview').classList.add('hidden');
                    document.getElementById('fileTextPreview').textContent = 'فایل غیر ویدیویی انتخاب شد';
                    document.getElementById('fileTextPreview').classList.remove('hidden');
                }
            }
        }

        function removeVideo() {
            document.getElementById('parentTrainingVideo').value = '';
            // If we have an existing video, we don't really "remove" it from server here, 
            // but for UI we might want to show it's gone or just keep original.
            // Simplified: just hide preview if it was a new file.
            const video = document.getElementById('videoPreview');
            // If it was the original video, maybe we want to keep it unless changed.
            // For now, let's just clear the input and the preview.
            @if($parentTraining->video_path)
                video.src = "{{ asset($parentTraining->video_path) }}";
                document.getElementById('fileName').textContent = 'ویدیو فعلی';
            @else
                document.getElementById('videoPreviewContainer').classList.add('hidden');
                video.src = '';
                video.classList.add('hidden');
            @endif
        }

        window.addEventListener('load', function() {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('description', {
                    height: 300
                });
            }
        });
    </script>
@endsection
