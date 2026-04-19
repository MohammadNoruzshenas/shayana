@extends('admin.layouts.master')

@section('head-tag')
    <title>مدیریت رویدادها</title>
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

            {{-- بخش فرم ایجاد رویداد --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                            <i class="fa fa-plus-circle text-blue-500"></i>
                            ایجاد رویداد جدید
                        </h5>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('admin.event.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">عنوان رویداد</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                    placeholder="مثال: رویداد نوروزی" required>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">تاریخ انتشار</label>
                                <input type="datetime-local" name="publish_date" value="{{ old('publish_date') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white">
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">لینک رویداد (در صورت وجود)</label>
                                <input type="url" name="link" value="{{ old('link') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                    placeholder="https://example.com">
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">عکس کاور رویداد</label>
                                <div class="relative">
                                    <input type="file" name="image" id="eventImage" class="hidden" accept="image/*"
                                        onchange="previewCoverImage(this)">
                                    <button type="button" onclick="document.getElementById('eventImage').click()"
                                        class="w-full px-4 py-6 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-all duration-200 flex flex-row items-center justify-center gap-2 cursor-pointer">
                                        <i class="fa fa-image text-xl text-gray-400"></i>
                                        <span class="text-sm text-gray-600">انتخاب عکس کاور</span>
                                    </button>
                                </div>
                                <div id="coverImagePreviewContainer" class="mt-4 hidden">
                                    <img id="coverImagePreview" src="" alt="کاور"
                                        class="w-full h-32 object-cover rounded-xl border border-gray-300">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-white-700 mb-2">ویدیو رویداد</label>
                                <div class="relative">
                                    <input type="file" name="file_path" id="eventFile" class="hidden"
                                        onchange="previewImage(this)">
                                    <button type="button" onclick="document.getElementById('eventFile').click()"
                                        class="w-full px-4 py-8 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center gap-2 cursor-pointer">
                                        <i class="fa fa-video text-2xl text-gray-400"></i>
                                        <span class="text-sm text-gray-600">برای آپلود ویدیو کلیک کنید</span>
                                        <span class="text-xs text-gray-400">یا فایل را بکشید و رها کنید</span>
                                    </button>
                                </div>
                                <!-- پیش‌نمایش فایل -->
                                <div id="imagePreviewContainer" class="mt-4 hidden">
                                    <div class="relative inline-block w-full">
                                        <img id="imagePreview" src="" alt="پیش‌نمایش"
                                            class="w-full h-48 object-cover rounded-xl border border-gray-300 hidden">
                                        <p id="fileTextPreview" class="text-center font-bold text-gray-600 hidden bg-gray-100 p-4 border rounded-xl"></p>    
                                        <button type="button" onclick="removeImage()"
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
                                ثبت رویداد
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- بخش جدول لیست رویدادها --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                            <i class="fa fa-list text-blue-500"></i>
                            لیست رویدادها
                        </h5>
                    </div>

                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-right border-collapse">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                                <tr>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-16">#</th>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-20">کاور</th>
                                    <th class="px-6 py-4 border-b border-gray-100">عنوان</th>
                                    <th class="px-6 py-4 border-b border-gray-100">تاریخ انتشار</th>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-48">تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($events as $event)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150 group">
                                        <td class="px-6 py-4 text-center text-gray-500 font-medium">{{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($event->image)
                                                <img src="{{ asset($event->image) }}" class="w-12 h-12 object-cover rounded-lg mx-auto shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg mx-auto flex items-center justify-center text-gray-400">
                                                    <i class="fa fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-800 font-bold">{{ $event->title }}</td>
                                        <td class="px-6 py-4 font-bold">
                                            @if($event->publish_date)
                                                {{ \Morilog\Jalali\Jalalian::forge($event->publish_date)->format('%A, %d %B %y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div
                                                class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.event.edit', $event->id) }}"
                                                    class="text-white bg-blue-500 hover:bg-blue-600 p-2 rounded-lg shadow-sm transition-colors duration-200"
                                                    title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.event.destroy', $event->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('آیا از حذف این رویداد اطمینان دارید؟')">
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
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">هیچ رویدادی ثبت
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
        function previewCoverImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('coverImagePreview').src = e.target.result;
                    document.getElementById('coverImagePreviewContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                // max 5MB
                if (file.size > 5 * 1024 * 1024) {
                    alert('حجم فایل باید کمتر از 5 مگابایت باشد');
                    input.value = '';
                    return;
                }

                document.getElementById('fileName').textContent = 'نام فایل: ' + file.name + ' (' + (file.size /
                    1024).toFixed(2) + ' KB)';
                document.getElementById('imagePreviewContainer').classList.remove('hidden');

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').src = e.target.result;
                        document.getElementById('imagePreview').classList.remove('hidden');
                        document.getElementById('fileTextPreview').classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('imagePreview').classList.add('hidden');
                    document.getElementById('fileTextPreview').textContent = 'فایل غیر تصویری انتخاب شد';
                    document.getElementById('fileTextPreview').classList.remove('hidden');
                }
            }
        }

        function removeImage() {
            document.getElementById('eventFile').value = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('imagePreview').src = '';
            document.getElementById('fileTextPreview').textContent = '';
        }

        const uploadBtn = document.querySelector('button[onclick="document.getElementById(\'eventFile\').click()"]');
        if (uploadBtn) {
            const form = uploadBtn.closest('form');

            form.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadBtn.classList.add('border-blue-400', 'bg-blue-50');
            });

            form.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadBtn.classList.remove('border-blue-400', 'bg-blue-50');
            });

            form.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadBtn.classList.remove('border-blue-400', 'bg-blue-50');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    document.getElementById('eventFile').files = files;
                    previewImage(document.getElementById('eventFile'));
                }
            });
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
