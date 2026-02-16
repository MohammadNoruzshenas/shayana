@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد برنامه هفتگی جدید</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/css/jalalidatepicker.min.css')}}" />
    <link href="{{asset('dashboard/js/select2/css/select2.min.css')}}" rel="stylesheet" />

    <style>
        .schedule-table {
            border: 2px solid #333;
            background: #1a1a1a;
            color: white;
        }
        .schedule-table th,
        .schedule-table td {
            border: 1px solid #444;
            text-align: center;
            vertical-align: middle;
            padding: 15px 8px;
        }
        .schedule-table th {
            background: #2c2c2c;
            font-weight: bold;
        }
        .day-header {
            background: #333 !important;
            color: white;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            width: 80px;
        }
        .time-slot {
            width: 120px;
            background: #2c2c2c;
        }
            .lesson-cell {
        position: relative;
        background: #1a1a1a;
        min-height: 80px;
    }
    .lesson-cell.has-lesson {
        background: #2a4d3a !important;
    }
        .lesson-select, .course-select, .main-season-select, .sub-season-select {
            width: 100%;
            background: #2c2c2c !important;
            border: 1px solid #555 !important;
            color: white !important;
            min-height: 35px;
            padding: 5px;
        }
        .lesson-select option, .course-select option, .main-season-select option, .sub-season-select option {
            background: #2c2c2c !important;
            color: white !important;
            padding: 8px;
        }
        
        /* Force dropdown options to be visible */
        select.form-control option {
            background-color: #2c2c2c !important;
            color: white !important;
        }
        
        /* Ensure select elements are visible */
        .main-season-select:not([disabled]) {
            background-color: #2c2c2c !important;
            color: white !important;
        }
        
        .sub-season-select:not([disabled]) {
            background-color: #2c2c2c !important;
            color: white !important;
        }
        
        /* Select2 Dark Theme Styling */
        .select2-container--default .select2-selection--single {
            background-color: #2c2c2c !important;
            border: 1px solid #555 !important;
            color: white !important;
            height: 40px !important;
            line-height: 40px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white !important;
            padding-left: 12px !important;
            padding-right: 20px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }
        
        .select2-dropdown {
            background-color: #2c2c2c !important;
            border: 1px solid #555 !important;
        }
        
        .select2-container--default .select2-results__option {
            background-color: #2c2c2c !important;
            color: white !important;
            padding: 8px 12px !important;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4a5568 !important;
            color: white !important;
        }
        
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #3182ce !important;
            color: white !important;
        }
        
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #1a1a1a !important;
            border: 1px solid #555 !important;
            color: white !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #a0a0a0 !important;
        }
        
        /* Hide original select when Select2 is active */
        .select2-search-user {
            display: none !important;
        }
        
        /* Ensure Select2 container takes full width */
        .select2-container {
            width: 100% !important;
        }
        
        /* Highlighting for lessons that exist in previous schedules */
        .lesson-select option.previous-lesson {
            background-color: #4a5568 !important;
            color: #ffd700 !important;
            font-weight: bold;
        }
        
        /* For browsers that support it, add a background pattern */
        .lesson-select option.previous-lesson {
            background-image: linear-gradient(45deg, #4a5568 25%, #2d3748 25%, #2d3748 50%, #4a5568 50%, #4a5568 75%, #2d3748 75%, #2d3748) !important;
            background-size: 8px 8px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">خانه</a></li>
    <li><a href="{{ route('admin.schedule.index') }}">برنامه هفتگی</a></li>
    <li><a href="{{ route('admin.schedule.create') }}">ایجاد برنامه جدید</a></li>
@endsection

@section('content')

    <p class="box__title">ایجاد برنامه هفتگی جدید</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.schedule.store') }}" method="post" class="padding-30">
                @csrf

                <div class="row" style="gap:10px">
                    <div class="col-32">
                        <p class="mb-5 font-size-14">انتخاب کاربر :</p>
                        <select name="user_id" id="user_id" class="form-control select2-search-user">
                            <option value="">کاربر را انتخاب کنید</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-32">
                        <p class="mb-5 font-size-14">تاریخ شروع هفته :</p>
                        <input type="text" name="week_start_date" id="week_start_date" data-jdp
                               class="text" 
                               value="{{ old('week_start_date') }}">
                        @error('week_start_date')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row" style="gap:10px">
                    <div class="col-48">
                        <p class="mb-5 font-size-14">عنوان (اختیاری) :</p>
                        <input type="text" name="title" id="title" 
                               class="text" 
                               value="{{ old('title') }}"
                               placeholder="مثال: برنامه هفته اول آبان">
                        @error('title')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                            <div class="row" style="gap:10px">
                <div class="col-12">
                    <p class="mb-5 font-size-14">برنامه هفتگی :</p>
                    <div class="alert alert-info mb-3">
                        <i class="fa fa-info-circle"></i>
                        توجه: می‌توانید برای هر زمان‌بندی یا یک درس انتخاب کنید یا صرفاً یادداشت وارد کنید یا هر دو را انجام دهید.<br>
                        <i class="fa fa-star" style="color: #ffd700;"></i> دروسی که با ستاره (⭐) نشان داده شده‌اند، قبلاً در برنامه‌های هفتگی این کاربر وجود داشته‌اند.
                    </div>
                        <div class="table-responsive">
                            <table class="table schedule-table">
                                <thead>
                                    <tr>
                                        <th class="time-slot">روز هفته</th>
                                        <th>تایم 1</th>
                                        <th>تایم 2</th>
                                        <th>تایم 3</th>
                                        <th>تایم 4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $daysOfWeek = ['روز اول', 'روز دوم', 'روز سوم', 'روز چهارم', 'روز پنجم', 'روز ششم', 'روز هفتم'];
                                    @endphp
                                    @foreach($daysOfWeek as $dayIndex => $dayName)
                                        <tr>
                                            <td class="day-header">{{ $dayName }}</td>
                                            @for($slot = 1; $slot <= 4; $slot++)
                                                <td class="lesson-cell">
                                                    <!-- Course Selection -->
                                                    <select name="schedule[{{ $dayIndex }}][{{ $slot }}][course_id]" 
                                                            class="form-control form-control-sm course-select mb-1"
                                                            data-day="{{ $dayIndex }}" 
                                                            data-slot="{{ $slot }}">
                                                        <option value="">انتخاب دوره</option>
                                                        @if($seasons && $seasons->count() > 0)
                                                            @foreach($seasons->groupBy('course_id') as $courseId => $courseSeasons)
                                                                @php $course = $courseSeasons->first()->course; @endphp
                                                                @if($course)
                                                                    <option value="{{ $course->id }}">
                                                                        {{ $course->title }}
                                                                    
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <option value="">هیچ دوره‌ای یافت نشد</option>
                                                        @endif
                                                    </select>
                                                    
                                                    <!-- Main Season Selection -->
                                                    <select name="schedule[{{ $dayIndex }}][{{ $slot }}][main_season_id]" 
                                                            class="form-control form-control-sm main-season-select mb-1"
                                                            id="main_season_{{ $dayIndex }}_{{ $slot }}"
                                                            data-day="{{ $dayIndex }}" 
                                                            data-slot="{{ $slot }}"
                                                            disabled>
                                                        <option value="">ابتدا دوره را انتخاب کنید</option>
                                                    </select>
                                                    
                                                    <!-- Sub Season Selection -->
                                                    <select name="schedule[{{ $dayIndex }}][{{ $slot }}][sub_season_id]" 
                                                            class="form-control form-control-sm sub-season-select mb-1"
                                                            id="sub_season_{{ $dayIndex }}_{{ $slot }}"
                                                            data-day="{{ $dayIndex }}" 
                                                            data-slot="{{ $slot }}"
                                                            disabled>
                                                        <option value="">ابتدا فصل اصلی را انتخاب کنید</option>
                                                    </select>
                                                    
                                                    <!-- Lesson Selection -->
                                                    <select name="schedule[{{ $dayIndex }}][{{ $slot }}][lession_id]" 
                                                            class="form-control form-control-sm lesson-select mb-1"
                                                            id="lesson_{{ $dayIndex }}_{{ $slot }}"
                                                            disabled>
                                                        <option value="">ابتدا زیر فصل را انتخاب کنید</option>
                                                    </select>
                                                    
                                                    <textarea name="schedule[{{ $dayIndex }}][{{ $slot }}][notes]" 
                                                              class="form-control form-control-sm" 
                                                              rows="1" 
                                                              placeholder="یادداشت - می‌توانید بدون انتخاب درس صرفاً یادداشت وارد کنید"></textarea>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-brand" id="submit-btn">
                    <span id="submit-text">ثبت برنامه</span>
                    <span id="loading-text" style="display: none;">
                        <i class="fa fa-spinner fa-spin"></i> در حال ثبت...
                    </span>
                </button>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('dashboard/js/jalalidatepicker.min.js')}}"></script>
    <script src="{{asset('dashboard/js/select2/js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            jalaliDatepicker.startWatch();
            
            // Remove any existing custom dropdown for user select
            $('#user_id').next('.dropdown-select').remove();
            
            // Initialize Select2 for user search
            $('#user_id').select2({
                placeholder: 'نام کاربر را جستجو کنید...',
                allowClear: true,
                dir: 'rtl',
                language: {
                    noResults: function() {
                        return "کاربری یافت نشد";
                    },
                    searching: function() {
                        return "در حال جستجو...";
                    },
                    inputTooShort: function() {
                        return "حداقل یک کاراکتر وارد کنید";
                    }
                }
            });
            
            // Handle user selection change - refresh lesson options if any are loaded
            $('#user_id').on('change', function() {
                var newUserId = $(this).val();
                
                // Find all enabled lesson selects that have options loaded
                $('.lesson-select:not([disabled])').each(function() {
                    var $lessonSelect = $(this);
                    var options = $lessonSelect.find('option');
                    
                    // If this select has lessons loaded (more than just the default option)
                    if (options.length > 1) {
                        var day = $lessonSelect.closest('td').find('.sub-season-select').data('day');
                        var slot = $lessonSelect.closest('td').find('.sub-season-select').data('slot');
                        var subSeasonId = $('#sub_season_' + day + '_' + slot).val();
                        
                        if (subSeasonId) {
                            // Reload lessons with new user context
                            $lessonSelect.html('<option value="">در حال بارگذاری...</option>');
                            
                            $.ajax({
                                url: '{{ route("admin.schedule.get-lessons-by-sub-season") }}',
                                type: 'GET',
                                data: { 
                                    sub_season_id: subSeasonId,
                                    user_id: newUserId
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(lessons) {
                                    $lessonSelect.html('<option value="">انتخاب درس</option>');
                                    
                                    if (lessons && lessons.length > 0) {
                                        $.each(lessons, function(index, lesson) {
                                            var previousIndicator = (lesson.in_previous_schedule || lesson.is_read) ? ' ⭐' : '';
                                            var optionClass = (lesson.in_previous_schedule || lesson.is_read) ? 'previous-lesson' : '';
                                            $lessonSelect.append('<option value="' + lesson.id + '" class="' + optionClass + '">' +
                                                lesson.title + ' (شماره: ' + lesson.number + ')' + previousIndicator + '</option>');
                                        });
                                    } else {
                                        $lessonSelect.append('<option value="">هیچ درسی یافت نشد</option>');
                                    }
                                    
                                    refreshCustomDropdown($lessonSelect);
                                },
                                error: function() {
                                    $lessonSelect.html('<option value="">خطا در بارگذاری دروس</option>');
                                }
                            });
                        }
                    }
                });
            });
            //
            // Global function to refresh custom dropdown after AJAX updates
            function refreshCustomDropdown(selectElement) {
                try {
                    var dropdown = selectElement.next('.dropdown-select');

                    if (dropdown.length > 0) {

                        // Clear existing options
                        dropdown.find('ul').empty();
                        
                        // Rebuild options from select element
                        var options = selectElement.find('option');
                        var selected = selectElement.find('option:selected');
                        
                        // Update current text to first option if no selection
                        var currentText = selected.length > 0 ? (selected.data('display-text') || selected.text()) : options.first().text();
                        dropdown.find('.current').html(currentText);

                        // Rebuild option list
                        options.each(function(j, o) {
                            var display = $(o).data('display-text') || '';
                            var isSelected = $(o).is(':selected') ? 'selected' : '';
                            var optionHtml = '<li class="option ' + isSelected + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>';
                            dropdown.find('ul').append(optionHtml);
                        });
                        
                        return true;
                    } else {
                        return false;
                    }
                } catch (error) {
                    return false;
                }
            }

            // Handle course selection change
            $('.course-select').on('change', function() {
                var courseId = $(this).val();
                var day = $(this).data('day');
                var slot = $(this).data('slot');
                var mainSeasonSelect = $('#main_season_' + day + '_' + slot);
                var subSeasonSelect = $('#sub_season_' + day + '_' + slot);
                var lessonSelect = $('#lesson_' + day + '_' + slot);
                

                if (courseId) {
                    // Enable main season select and load main seasons
                    mainSeasonSelect.prop('disabled', false);
                    mainSeasonSelect.html('<option value="">در حال بارگذاری...</option>');
                    
                    // Reset and disable sub season and lesson selects
                    subSeasonSelect.prop('disabled', true);
                    subSeasonSelect.html('<option value="">ابتدا فصل اصلی را انتخاب کنید</option>');
                    lessonSelect.prop('disabled', true);
                    lessonSelect.html('<option value="">ابتدا زیر فصل را انتخاب کنید</option>');
                    
                    // Fetch main seasons for this course
                    $.ajax({
                        url: '{{ route("admin.schedule.get-seasons-by-course") }}',
                        type: 'GET',
                        data: { course_id: courseId },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(seasons) {

                            mainSeasonSelect.html('<option value="">انتخاب فصل اصلی</option>');

                            if (seasons && seasons.length > 0) {
                                $.each(seasons, function(index, season) {

                                    var optionHtml = '<option value="' + season.id + '">' + 
                                        season.title + ' (شماره: ' + season.number + ')</option>';

                                    mainSeasonSelect.append(optionHtml);
                                });
                            } else {
                                mainSeasonSelect.append('<option value="">هیچ فصل اصلی یافت نشد</option>');
                            }
                            // Force refresh the select element
                            mainSeasonSelect.trigger('focus').trigger('blur');
                            
                            // Apply proper dark theme styling
                            mainSeasonSelect.css({
                                'background': '#2c2c2c',
                                'color': 'white',
                                'border': '1px solid #555'
                            });

                            // Refresh the main season dropdown
                            refreshCustomDropdown(mainSeasonSelect);
                            
                            // Check if options are actually selectable
                            setTimeout(function() {

                                // Final check of custom dropdown
                                var dropdownDiv = mainSeasonSelect.next('.dropdown-select');

                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            mainSeasonSelect.html('<option value="">خطا در بارگذاری فصل‌های اصلی</option>');
                        }
                    });
                } else {
                    // Disable all child selects
                    mainSeasonSelect.prop('disabled', true);
                    mainSeasonSelect.html('<option value="">ابتدا دوره را انتخاب کنید</option>');
                    subSeasonSelect.prop('disabled', true);
                    subSeasonSelect.html('<option value="">ابتدا فصل اصلی را انتخاب کنید</option>');
                    lessonSelect.prop('disabled', true);
                    lessonSelect.html('<option value="">ابتدا زیر فصل را انتخاب کنید</option>');
                }
                
                updateCellVisual($(this).closest('.lesson-cell'));
            });

            // Handle main season selection change
            $('.main-season-select').on('change', function() {
                var mainSeasonId = $(this).val();
                var day = $(this).data('day');
                var slot = $(this).data('slot');
                var subSeasonSelect = $('#sub_season_' + day + '_' + slot);
                var lessonSelect = $('#lesson_' + day + '_' + slot);
                
                if (mainSeasonId) {
                    // Enable sub season select and load sub seasons
                    subSeasonSelect.prop('disabled', false);
                    subSeasonSelect.html('<option value="">در حال بارگذاری...</option>');
                    
                    // Reset and disable lesson select
                    lessonSelect.prop('disabled', true);
                    lessonSelect.html('<option value="">ابتدا زیر فصل را انتخاب کنید</option>');
                    
                    // Fetch sub seasons for this main season
                    $.ajax({
                        url: '{{ route("admin.schedule.get-sub-seasons-by-main-season") }}',
                        type: 'GET',
                        data: { main_season_id: mainSeasonId },
                        success: function(subSeasons) {
                            subSeasonSelect.html('<option value="">انتخاب زیر فصل</option>');
                            $.each(subSeasons, function(index, subSeason) {
                                subSeasonSelect.append('<option value="' + subSeason.id + '">' + 
                                    subSeason.title + ' (شماره: ' + subSeason.number + ')</option>');
                            });
                            
                            // Refresh the custom dropdown for sub-seasons
                            refreshCustomDropdown(subSeasonSelect);
                        },
                        error: function() {
                            subSeasonSelect.html('<option value="">خطا در بارگذاری زیر فصل‌ها</option>');
                        }
                    });
                } else {
                    // Disable sub season and lesson selects
                    subSeasonSelect.prop('disabled', true);
                    subSeasonSelect.html('<option value="">ابتدا فصل اصلی را انتخاب کنید</option>');
                    lessonSelect.prop('disabled', true);
                    lessonSelect.html('<option value="">ابتدا زیر فصل را انتخاب کنید</option>');
                }
                
                updateCellVisual($(this).closest('.lesson-cell'));
            });

            // Handle sub season selection change
            $('.sub-season-select').on('change', function() {
                var subSeasonId = $(this).val();
                var day = $(this).data('day');
                var slot = $(this).data('slot');
                var lessonSelect = $('#lesson_' + day + '_' + slot);

                
                if (subSeasonId) {
                    // Enable lesson select and load lessons
                    lessonSelect.prop('disabled', false);
                    lessonSelect.html('<option value="">در حال بارگذاری...</option>');
                    
                    // Fetch lessons for this sub season
                    var selectedUserId = $('#user_id').val();
                    $.ajax({
                        url: '{{ route("admin.schedule.get-lessons-by-sub-season") }}',
                        type: 'GET',
                        data: { 
                            sub_season_id: subSeasonId,
                            user_id: selectedUserId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(lessons) {

                            lessonSelect.html('<option value="">انتخاب درس</option>');
                            
                            if (lessons && lessons.length > 0) {
                                $.each(lessons, function(index, lesson) {
                                    var previousIndicator = (lesson.in_previous_schedule || lesson.is_read ) ? ' ⭐' : '';
                                    var optionClass = (lesson.in_previous_schedule || lesson.is_read ) ? 'previous-lesson' : '';
                                    lessonSelect.append('<option value="' + lesson.id + '" class="' + optionClass + '">' +
                                        lesson.title + ' (شماره: ' + lesson.number + ')' + previousIndicator + '</option>');
                                });
                            } else {
                                lessonSelect.append('<option value="">هیچ درسی یافت نشد</option>');
                            }
                            
                            // Refresh the custom dropdown for lessons
                            refreshCustomDropdown(lessonSelect);
                        },
                        error: function(xhr, status, error) {
                            lessonSelect.html('<option value="">خطا در بارگذاری دروس</option>');
                            refreshCustomDropdown(lessonSelect);
                        }
                    });
                } else {
                    // Disable lesson select
                    lessonSelect.prop('disabled', true);
                    lessonSelect.html('<option value="">ابتدا زیر فصل را انتخاب کنید</option>');
                }
                
                updateCellVisual($(this).closest('.lesson-cell'));
            });

            // Handle lesson selection change
            $('.lesson-select').on('change', function() {
                updateCellVisual($(this).closest('.lesson-cell'));
            });

            // Handle notes input change
            $('textarea[name*="[notes]"]').on('input', function() {
                updateCellVisual($(this).closest('.lesson-cell'));
            });

            // Visual feedback function
            function updateCellVisual($cell) {
                var hasLesson = $cell.find('.lesson-select').val();
                var hasNotes = $cell.find('textarea[name*="[notes]"]').val().trim();
                
                if (hasLesson || hasNotes) {
                    $cell.addClass('has-lesson');
                    $cell.css('background-color', '#2a4d3a');
                } else {
                    $cell.removeClass('has-lesson');
                    $cell.css('background-color', '#1a1a1a');
                }
            }

            // Prevent double submission
            $('form').on('submit', function(e) {
                var submitBtn = $('#submit-btn');
                var submitText = $('#submit-text');
                var loadingText = $('#loading-text');
                
                // Check if already submitting
                if (submitBtn.prop('disabled')) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable button and show loading state
                submitBtn.prop('disabled', true);
                submitText.hide();
                loadingText.show();
                
                // Optional: Re-enable button after some time if submission fails
                setTimeout(function() {
                    if (submitBtn.prop('disabled')) {
                        submitBtn.prop('disabled', false);
                        submitText.show();
                        loadingText.hide();
                    }
                }, 30000); // 30 seconds timeout
            });
        });
    </script>
@endsection 