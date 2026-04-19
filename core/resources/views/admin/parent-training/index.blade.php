@extends('admin.layouts.master')

@section('head-tag')
    <title>آموزش والدین</title>
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
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- بخش فرم ایجاد آموزش --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                            <i class="fa fa-plus-circle text-blue-500"></i>
                            ایجاد آموزش جدید برای والدین
                        </h5>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('admin.parent-training.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">عنوان آموزش</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                    placeholder="مثال: نحوه رفتار با کودکان" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-white-700 mb-2">ویدیو آموزشی</label>
                                <div class="relative">
                                    <input type="file" name="video_path" id="parentTrainingVideo" class="hidden" accept="video/*"
                                        onchange="previewVideo(this)">
                                    <button type="button" onclick="document.getElementById('parentTrainingVideo').click()"
                                        class="w-full px-4 py-8 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center gap-2 cursor-pointer">
                                        <i class="fa fa-video text-2xl text-gray-400"></i>
                                        <span class="text-sm text-gray-600">برای آپلود ویدیو کلیک کنید</span>
                                        <span class="text-xs text-gray-400">حداکثر حجم: 50 مگابایت</span>
                                    </button>
                                </div>
                                <!-- پیش‌نمایش فایل -->
                                <div id="videoPreviewContainer" class="mt-4 hidden">
                                    <div class="relative inline-block w-full">
                                        <video id="videoPreview" controls class="w-full rounded-xl border border-gray-300 hidden">
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
                                <label class="block text-sm font-bold text-white-700 mb-2">توضیحات</label>
                                <div class="rounded-xl overflow-hidden border border-gray-300">
                                    <textarea name="description" id="description" class="ckeditor">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 transform active:scale-95">
                                <i class="fa fa-save"></i>
                                ثبت آموزش
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- بخش جدول لیست آموزش‌ها --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                            <i class="fa fa-list text-blue-500"></i>
                            لیست ویدیوهای آموزشی والدین
                        </h5>
                    </div>

                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-right border-collapse">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                                <tr>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-16">#</th>
                                    <th class="px-6 py-4 border-b border-gray-100">عنوان</th>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center">ویدیو</th>
                                    <th class="px-6 py-4 border-b border-gray-100">تاریخ ثبت</th>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-48">تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($parentTrainings as $parentTraining)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150 group">
                                        <td class="px-6 py-4 text-center text-gray-500 font-medium">{{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-800 font-bold">{{ $parentTraining->title }}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($parentTraining->video_path)
                                                <i class="fa fa-video text-blue-500 text-xl" title="دارای ویدیو"></i>
                                            @else
                                                <i class="fa fa-video-slash text-gray-300 text-xl"></i>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-bold">
                                            {{ \Morilog\Jalali\Jalalian::forge($parentTraining->created_at)->format('%d %B %y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div
                                                class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.parent-training.edit', $parentTraining->id) }}"
                                                    class="text-white bg-blue-500 hover:bg-blue-600 p-2 rounded-lg shadow-sm transition-colors duration-200"
                                                    title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.parent-training.destroy', $parentTraining->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('آیا از حذف این ویدیو آموزشی اطمینان دارید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-lg shadow-sm transition-colors duration-200"
                                                        title="حذف">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">هیچ آموزشی ثبت
                                            نشده است</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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

                document.getElementById('fileName').textContent = 'نام فایل: ' + file.name + ' (' + (file.size /
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
            document.getElementById('videoPreviewContainer').classList.add('hidden');
            const video = document.getElementById('videoPreview');
            video.src = '';
            video.classList.add('hidden');
            document.getElementById('fileTextPreview').textContent = '';
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
