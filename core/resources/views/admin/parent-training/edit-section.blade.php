@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش قسمت آموزش والدین</title>
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
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h5 class="font-bold text-gray-800 flex items-center gap-2 m-0 text-lg">
                        <i class="fa fa-edit text-blue-500"></i>
                        ویرایش قسمت: {{ $parentTraining->title }}
                    </h5>
                    <a href="{{ route('admin.parent-training.index') }}"
                        class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fa fa-arrow-left"></i> بازگشت
                    </a>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.parent-training.section.update', $parentTraining->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">فصل</label>
                            <select name="season_id"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                                required>
                                <option value="">انتخاب فصل...</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" @selected($chapter->id == $parentTraining->season_id)>
                                        {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">عنوان قسمت</label>
                            <input type="text" name="title" value="{{ old('title', $parentTraining->title) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                                placeholder="عنوان قسمت" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">توضیحات</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                                placeholder="توضیحات قسمت...">{{ old('description', $parentTraining->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">لینک ویدیو</label>
                                <input type="text" name="video_link"
                                    value="{{ old('video_link', $parentTraining->video_link) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                                    placeholder="https://example.com/video">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">لینک فایل صوتی</label>
                                <input type="text" name="audio_link"
                                    value="{{ old('audio_link', $parentTraining->audio_link) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all"
                                    placeholder="https://example.com/audio">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-colors">
                                <i class="fa fa-save ml-2"></i>ذخیره تغییرات
                            </button>
                            <a href="{{ route('admin.parent-training.index') }}"
                                class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-xl transition-colors text-center">
                                <i class="fa fa-times ml-2"></i>لغو
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            direction: rtl;
        }
    </style>
@endsection
