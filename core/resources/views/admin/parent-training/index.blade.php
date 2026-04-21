@extends('admin.layouts.master')

@section('head-tag')
    <title>آموزش والدین</title>
    <script src="{{ asset('dashboard/js/tailwindcss.js') }}"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            }
        }
    </script>
@endsection

@section('content')
    <div class="p-4 w-full font-sans">
        <!-- Header Section -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa fa-book text-blue-500"></i>
                آموزش والدین
            </h3>
            <p class="text-gray-500 mt-2">مدیریت فصل‌ها و قسمت‌های آموزشی</p>
        </div>

        <!-- Add Chapter Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                    <i class="fa fa-plus-circle text-blue-500"></i>
                    فصل جدید
                </h5>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.parent-training.chapter.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-white-700 mb-2">عنوان فصل</label>
                            <input type="text" name="title"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                                placeholder="مثال: فصل اول - مبانی تربیت" required>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-colors mt-6">
                                <i class="fa fa-plus ml-2"></i>افزودن فصل
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-white-700 mb-2">توضیحات (اختیاری)</label>
                        <textarea name="description" rows="2"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                            placeholder="توضیحات کلی فصل..."></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- Chapters List -->
        <div class="space-y-4">
            @forelse($chapters as $chapter)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-r-4 border-blue-500">
                    <!-- Chapter Header - Clickable -->
                    <div class="chapter-header bg-gradient-to-l from-blue-50 to-blue-100 px-6 py-4 flex items-center justify-between cursor-pointer hover:from-blue-100 hover:to-blue-150 transition-colors"
                        onclick="toggleChapter({{ $chapter->id }})">
                        <div class="flex-1 flex items-center gap-4">
                            <div
                                class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-bold text-lg">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">فصل {{ $loop->iteration }}:
                                    {{ $chapter->title }}</h3>
                                @if ($chapter->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($chapter->description, 100) }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mr-4">
                                <span class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $chapter->trainings()->count() }} قسمت
                                </span>
                                <i class="fa fa-chevron-down text-gray-600 text-xl transition-transform duration-300 chapter-icon"
                                    id="icon-{{ $chapter->id }}"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mr-8">
                            <a href="{{ route('admin.parent-training.chapter.edit', $chapter->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm transition-colors"
                                onclick="event.stopPropagation();">
                                <i class="fa fa-edit"></i> ویرایش
                            </a>
                            <form action="{{ route('admin.parent-training.chapter.destroy', $chapter->id) }}"
                                method="POST" class="inline-block"
                                onsubmit="return confirm('آیا مطمئن هستید؟ تمام قسمت‌های این فصل نیز حذف خواهند شد.');"
                                onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition-colors">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Chapter Content - Collapsible -->
                    <div class="chapter-content bg-white" id="content-{{ $chapter->id }}" style="display: none;">
                        <div class="p-6">
                            <!-- Sections List -->
                            @if ($chapter->trainings()->count() > 0)
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <h4 class="font-bold text-white-700 mb-4 flex items-center gap-2 text-base">
                                        <i class="fa fa-list text-green-500"></i>
                                        قسمت‌های این فصل ({{ $chapter->trainings()->count() }})
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($chapter->trainings as $section)
                                            <div
                                                class="bg-gradient-to-l from-green-50 to-green-100 rounded-lg p-4 flex items-center justify-between hover:shadow-md transition-shadow border-r-4 border-green-500">
                                                <div class="flex-1 flex items-start gap-3">
                                                    <div
                                                        class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full font-bold text-sm mt-1">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-semibold text-gray-800">{{ $section->title }}</p>
                                                        @if ($section->description)
                                                            <p class="text-sm text-gray-600 mt-1">
                                                                {{ Str::limit($section->description, 100) }}</p>
                                                        @endif
                                                        <div class="flex items-center gap-4 mt-2 text-xs">
                                                            @if ($section->video_link)
                                                                <span
                                                                    class="flex items-center gap-1 bg-blue-200 text-blue-700 px-2 py-1 rounded">
                                                                    <i class="fa fa-video"></i> ویدیو
                                                                </span>
                                                            @endif
                                                            @if ($section->audio_link)
                                                                <span
                                                                    class="flex items-center gap-1 bg-green-200 text-green-700 px-2 py-1 rounded">
                                                                    <i class="fa fa-microphone"></i> صوت
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 mr-4">
                                                    <a href="{{ route('admin.parent-training.section.edit', $section->id) }}"
                                                        class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.parent-training.section.destroy', $section->id) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('آیا مطمئن هستید؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <div class="bg-yellow-100 text-yellow-700 rounded-lg p-4 text-center font-semibold">
                                        <i class="fa fa-info-circle"></i> این فصل هنوز قسمتی ندارد - قسمت جدیدی اضافه کنید
                                    </div>
                                </div>
                            @endif

                            <!-- Add Section Form -->
                            <div>
                                <h4 class="font-bold text-white-700 mb-4 flex items-center gap-2 text-base">
                                    <i class="fa fa-plus-circle text-purple-500"></i>
                                    افزودن قسمت جدید به این فصل
                                </h4>
                                <form action="{{ route('admin.parent-training.section.store') }}" method="POST"
                                    class="space-y-3 bg-purple-50 p-4 rounded-lg">
                                    @csrf
                                    <input type="hidden" name="season_id" value="{{ $chapter->id }}">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">عنوان قسمت</label>
                                            <input type="text" name="title"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm"
                                                placeholder="عنوان قسمت" required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">لینک ویدیو</label>
                                            <input type="text" name="video_link"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm"
                                                placeholder="https://example.com/video">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">لینک صوت</label>
                                            <input type="text" name="audio_link"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm"
                                                placeholder="https://example.com/audio">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">&nbsp;</label>
                                            <button type="submit"
                                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-3 rounded-lg transition-colors text-sm">
                                                <i class="fa fa-plus ml-1"></i>افزودن قسمت
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">توضیحات</label>
                                        <textarea name="description" rows="2"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 text-sm"
                                            placeholder="توضیحات قسمت..."></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <i class="fa fa-book text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">هنوز فصلی ایجاد نشده است</p>
            <p class="text-gray-400">برای شروع از بخش بالا یک فصل جدید اضافه کنید</p>
        </div>
        @endforelse
    </div>
    </div>

    <style>
        body {
            direction: rtl;
        }

        .chapter-header {
            user-select: none;
        }

        .chapter-content {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
            }

            to {
                opacity: 1;
                max-height: 2000px;
            }
        }

        .chapter-icon {
            transition: transform 0.3s ease-out;
        }

        .chapter-icon.rotated {
            transform: rotate(-180deg);
        }
    </style>

    <script>
        function toggleChapter(chapterId) {
            const content = document.getElementById('content-' + chapterId);
            const icon = document.getElementById('icon-' + chapterId);

            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
                icon.classList.add('rotated');
            } else {
                content.style.display = 'none';
                icon.classList.remove('rotated');
            }
        }
    </script>
@endsection
