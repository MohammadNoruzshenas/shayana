@extends('admin.layouts.master')

@section('head-tag')
    <title>مدیریت بازی‌ها</title>
    {{-- اضافه کردن Tailwind CSS --}}
    <script src="{{ asset('dashboard/js/tailwindcss.js') }}"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false, // غیرفعال کردن ریست‌های پیش‌فرض برای جلوگیری از تداخل با بوت‌استرپ
            }
        }
    </script>
    {{-- Alpine.js for custom dropdowns --}}
    <script defer src="{{ asset('dashboard/js/alpine.js') }}"></script>
    <style>
        /* نمایش textarea اگر CKEditor لود نشود */
        #description {
            display: block !important;
            visibility: visible !important;
            width: 100% !important;
            min-height: 300px !important;
        }

        /* نمایش container CKEditor */
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

            {{-- بخش فرم ایجاد بازی --}}
            <div class="lg:col-span-4" x-data="gameForm">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                            <i class="fa fa-plus-circle text-blue-500"></i>
                            ایجاد بازی جدید
                        </h5>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('admin.game.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">عنوان بازی</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 text-sm bg-gray-50 focus:bg-white"
                                    placeholder="مثال: بازی حدس کلمه">
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">انتخاب دوره</label>
                                <!-- Custom Dropdown for Course -->
                                <div class="relative" x-data="{ open: false }">
                                    <input type="hidden" name="course_id" x-model="selectedCourseId">
                                    <button @click="open = !open" type="button"
                                        class="w-full text-right px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <span x-text="selectedCourseText" class="text-sm text-gray-500 truncate"></span>
                                        <i class="fa fa-chevron-down text-xs text-gray-500 transition-transform duration-200"
                                            :class="{ 'rotate-180': open }"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute z-20 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 max-h-56 overflow-y-auto">
                                        <ul class="py-1">
                                            <template x-for="course in courses" :key="course.id">
                                                <li @click="selectCourse(course); open = false"
                                                    class="px-4 py-2 text-sm text-white-700 hover:bg-blue-50 cursor-pointer"
                                                    x-text="course.title"></li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">انتخاب فصل اصلی</label>
                                <!-- Custom Dropdown for Main Season -->
                                <div class="relative" x-data="{ open: false }">
                                    <input type="hidden" name="main_season_id" x-model="selectedMainSeasonId">
                                    <button @click="open = !open" type="button" :disabled="!selectedCourseId"
                                        class="w-full text-right px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-400 disabled:bg-gray-200 disabled:cursor-not-allowed">
                                        <span x-text="selectedMainSeasonText" class="text-sm text-gray-500 truncate"></span>
                                        <i class="fa fa-chevron-down text-xs text-gray-500 transition-transform duration-200"
                                            :class="{ 'rotate-180': open }"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute z-10 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 max-h-56 overflow-y-auto">
                                        <ul class="py-1">
                                            <template x-if="mainSeasons.length === 0 && selectedCourseId">
                                                <li class="px-4 py-2 text-sm text-gray-400">فصلی برای این دوره یافت نشد</li>
                                            </template>
                                            <template x-for="season in mainSeasons" :key="season.id">
                                                <li @click="selectMainSeason(season); open = false"
                                                    class="px-4 py-2 text-sm text-white-700 hover:bg-blue-50 cursor-pointer"
                                                    x-text="season.title"></li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold text-white-700 mb-2">انتخاب زیرفصل</label>
                                <!-- Custom Dropdown for Sub Season -->
                                <div class="relative" x-data="{ open: false }">
                                    <input type="hidden" name="sub_season_id" x-model="selectedSubSeasonId">
                                    <button @click="open = !open" type="button" :disabled="!selectedMainSeasonId"
                                        class="w-full text-right px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-400 disabled:bg-gray-200 disabled:cursor-not-allowed">
                                        <span x-text="selectedSubSeasonText" class="text-sm text-gray-500 truncate"></span>
                                        <i class="fa fa-chevron-down text-xs text-gray-500 transition-transform duration-200"
                                            :class="{ 'rotate-180': open }"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition
                                        class="absolute z-10 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 max-h-56 overflow-y-auto">
                                        <ul class="py-1">
                                            <template x-if="subSeasons.length === 0 && selectedMainSeasonId">
                                                <li class="px-4 py-2 text-sm text-gray-400">زیرفصلی برای این فصل یافت نشد
                                                </li>
                                            </template>
                                            <template x-for="subSeason in subSeasons" :key="subSeason.id">
                                                <li @click="selectSubSeason(subSeason); open = false"
                                                    class="px-4 py-2 text-sm text-c-700 hover:bg-blue-50 cursor-pointer"
                                                    x-text="subSeason.title"></li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-white-700 mb-2">تصویر بازی</label>
                                <div class="relative">
                                    <input type="file" name="image" id="gameImage" accept="image/*" class="hidden"
                                        onchange="previewImage(this)">
                                    <button type="button" onclick="document.getElementById('gameImage').click()"
                                        class="w-full px-4 py-8 rounded-xl border-2 border-dashed border-gray-300 hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-all duration-200 flex flex-col items-center gap-2 cursor-pointer">
                                        <i class="fa fa-cloud-upload text-2xl text-gray-400"></i>
                                        <span class="text-sm text-gray-600">برای آپلود تصویر کلیک کنید</span>
                                        <span class="text-xs text-gray-400">یا تصویر را بکشید و رها کنید</span>
                                    </button>
                                </div>
                                <!-- پیش‌نمایش تصویر -->
                                <div id="imagePreviewContainer" class="mt-4 hidden">
                                    <div class="relative inline-block w-full">
                                        <img id="imagePreview" src="" alt="پیش‌نمایش"
                                            class="w-full h-48 object-cover rounded-xl border border-gray-300">
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
                                ثبت بازی
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- بخش جدول لیست بازی‌ها --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                            <i class="fa fa-list text-blue-500"></i>
                            لیست بازی‌ها
                        </h5>
                    </div>

                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-right border-collapse">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                                <tr>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-16">#</th>
                                    <th class="px-6 py-4 border-b border-gray-100">عنوان</th>
                                    <th class="px-6 py-4 border-b border-gray-100">دسته‌بندی</th>
                                    <th class="px-6 py-4 border-b border-gray-100 text-center w-48">تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($games as $game)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150 group">
                                        <td class="px-6 py-4 text-center text-gray-500 font-medium">{{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-800 font-bold">{{ $game->title }}</td>
                                        <td class="px-6 py-4">
                                            @if ($game->course && $game->mainSeason && $game->subSeason)
                                                <span
                                                    class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs font-bold">
                                                    {{ $game->course->title }} - {{ $game->mainSeason->title }} -
                                                    {{ $game->subSeason->title }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div
                                                class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.game.edit', $game->id) }}"
                                                    class="text-white bg-blue-500 hover:bg-blue-600 p-2 rounded-lg shadow-sm transition-colors duration-200"
                                                    title="ویرایش">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.game.destroy', $game->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('آیا از حذف این بازی اطمینان دارید؟')">
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
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">هیچ بازی‌ای ثبت
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
        // تابع برای نمایش پیش‌نمایش تصویر
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                // بررسی نوع فایل
                if (!file.type.startsWith('image/')) {
                    alert('لطفاً یک فایل تصویری انتخاب کنید');
                    input.value = '';
                    return;
                }

                // بررسی حجم فایل (حداکثر 5 مگابایت)
                if (file.size > 5 * 1024 * 1024) {
                    alert('حجم فایل باید کمتر از 5 مگابایت باشد');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('fileName').textContent = 'نام فایل: ' + file.name + ' (' + (file.size /
                        1024).toFixed(2) + ' KB)';
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // تابع برای حذف تصویر
        function removeImage() {
            document.getElementById('gameImage').value = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('imagePreview').src = '';
        }

        // Drag and drop برای آپلود تصویر
        const uploadBtn = document.querySelector('button[onclick="document.getElementById(\'gameImage\').click()"]');
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
                    document.getElementById('gameImage').files = files;
                    previewImage(document.getElementById('gameImage'));
                }
            });
        }

        // تاخیر برای اطمینان از لود شدن CKEDITOR
        window.addEventListener('load', function() {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('description', {
                    height: 300
                });
                console.log('CKEditor loaded successfully');
            } else {
                console.error('CKEditor failed to load');
            }
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('gameForm', () => ({
                courses: [],
                mainSeasons: [],
                subSeasons: [],

                selectedCourseId: '',
                selectedCourseText: 'انتخاب دوره...',
                selectedMainSeasonId: '',
                selectedMainSeasonText: 'انتخاب فصل اصلی...',
                selectedSubSeasonId: '',
                selectedSubSeasonText: 'انتخاب زیرفصل...',

                init() {
                    this.fetchCourses();
                },

                async fetchCourses() {
                    const response = await fetch('{{ route('admin.game.get-courses') }}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const data = await response.json();
                    this.courses = data;
                },

                async selectCourse(course) {
                    this.selectedCourseId = course.id;
                    this.selectedCourseText = course.title;

                    this.selectedMainSeasonId = '';
                    this.selectedMainSeasonText = 'انتخاب فصل اصلی...';
                    this.selectedSubSeasonId = '';
                    this.selectedSubSeasonText = 'انتخاب زیرفصل...';
                    this.mainSeasons = [];
                    this.subSeasons = [];

                    const response = await fetch(
                        `{{ route('admin.game.get-seasons-by-course') }}?course_id=${this.selectedCourseId}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    const data = await response.json();
                    this.mainSeasons = data;
                },

                async selectMainSeason(season) {
                    this.selectedMainSeasonId = season.id;
                    this.selectedMainSeasonText = season.title;

                    this.selectedSubSeasonId = '';
                    this.selectedSubSeasonText = 'انتخاب زیرفصل...';
                    this.subSeasons = [];

                    const response = await fetch(
                        `{{ route('admin.game.get-sub-seasons-by-main-season') }}?main_season_id=${this.selectedMainSeasonId}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    const data = await response.json();
                    this.subSeasons = data;
                },

                selectSubSeason(subSeason) {
                    this.selectedSubSeasonId = subSeason.id;
                    this.selectedSubSeasonText = subSeason.title;
                }
            }))
        })
    </script>
@endsection
