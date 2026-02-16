@extends('admin.layouts.master')

@section('head-tag')
    <title>مدیریت مطالعه دروس کاربران</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('dashboard/js/select2/css/select2.min.css')}}" rel="stylesheet" />
    
    <style>
        .lessons-panel {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            display: none;
        }
        
        .lessons-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }
        
        .lesson-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #f8f9fa;
            transition: all 0.2s;
            min-width: 200px;
            flex: 0 0 auto;
        }
        
        .lesson-item:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        
        .lesson-item.checked {
            background-color: #d4edda;
            border-color: #28a745;
        }
        
        .lesson-checkbox {
            margin-left: 10px;
            transform: scale(1.2);
        }
        
        .lesson-title {
            font-weight: 500;
            color: #333;
        }
        
        .lesson-number {
            color: #666;
            font-size: 0.9em;
            margin-right: 10px;
        }
        
        .stats-panel {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }
        
        .stat-item {
            display: inline-block;
            margin-left: 20px;
            color: #1565c0;
            font-weight: 500;
        }
        
        .select-all-btn {
            margin-bottom: 15px;
        }
        
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
            color: #666;
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
        .select2-search-user,
        .select2-course,
        .select2-main-season,
        .select2-sub-season {
            display: none !important;
        }
        
        /* Ensure Select2 container takes full width */
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li><a href="{{ route('admin.index') }}">خانه</a></li>
    <li><a href="{{ route('admin.user-lesson-read.index') }}">مدیریت مطالعه دروس</a></li>
@endsection

@section('content')
    <p class="box__title">مدیریت مطالعه دروس کاربران</p>
    
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form id="lessons-form" class="padding-30">
                @csrf
                
                <div class="row" style="gap:10px">
                    <div class="col-32">
                        <p class="mb-5 font-size-14">انتخاب کاربر :</p>
                        <select name="user_id" id="user_id" class="form-control select2-search-user">
                            <option value="">کاربر را انتخاب کنید</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-32">
                        <p class="mb-5 font-size-14">انتخاب دوره :</p>
                        <select name="course_id" id="course_id" class="form-control select2-course" disabled>
                            <option value="">ابتدا کاربر را انتخاب کنید</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row" style="gap:10px">
                    <div class="col-32">
                        <p class="mb-5 font-size-14">انتخاب فصل اصلی :</p>
                        <select name="main_season_id" id="main_season_id" class="form-control select2-main-season" disabled>
                            <option value="">ابتدا دوره را انتخاب کنید</option>
                        </select>
                        @error('main_season_id')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-32">
                        <p class="mb-5 font-size-14">انتخاب زیر فصل :</p>
                        <select name="sub_season_id" id="sub_season_id" class="form-control select2-sub-season" disabled>
                            <option value="">ابتدا فصل اصلی را انتخاب کنید</option>
                        </select>
                        @error('sub_season_id')
                            <span class="text-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- User Stats Panel -->
                <div id="stats-panel" class="stats-panel">
                    <h6>آمار مطالعه کاربر:</h6>
                    <div id="user-stats">
                        <!-- Stats will be loaded here -->
                    </div>
                </div>

                <!-- Lessons Panel -->
                <div id="lessons-panel" class="lessons-panel">
                    <h5 class="mb-3">لیست دروس</h5>
                    <div class="alert alert-info mb-3">
                        <i class="fa fa-info-circle"></i>
                        دروس مطالعه شده توسط این کاربر با تیک مشخص شده‌اند. می‌توانید وضعیت مطالعه هر درس را تغییر دهید.
                    </div>
                    
                    <div class="select-all-btn">
                        <button type="button" id="select-all" class="btn btn-sm btn-secondary">انتخاب همه</button>
                        <button type="button" id="deselect-all" class="btn btn-sm btn-secondary">لغو انتخاب همه</button>
                    </div>
                    
                    <div class="loading-spinner" id="loading-spinner">
                        <i class="fa fa-spinner fa-spin"></i> در حال بارگذاری دروس...
                    </div>
                    
                    <div id="lessons-list" class="lessons-grid">
                        <!-- Lessons will be loaded here -->
                    </div>
                    
                    <div class="mt-3">
                        @permission('edit-user-lession-read')
                        <button type="submit" class="btn btn-brand" id="save-btn">
                            <span id="save-text">ذخیره تغییرات</span>
                            <span id="save-loading" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i> در حال ذخیره...
                            </span>
                        </button>
                        @endpermission
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('dashboard/js/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('dashboard/js/sweetalert/sweetalert2.all.min.js')}}"></script>
    
    <script>
        $(document).ready(function() {
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
            
            // Initialize Select2 for course select
            $('#course_id').select2({
                placeholder: 'انتخاب دوره',
                allowClear: true,
                dir: 'rtl'
            });
            
            // Initialize Select2 for main season select
            $('#main_season_id').select2({
                placeholder: 'انتخاب فصل اصلی',
                allowClear: true,
                dir: 'rtl'
            });
            
            // Initialize Select2 for sub season select
            $('#sub_season_id').select2({
                placeholder: 'انتخاب زیر فصل',
                allowClear: true,
                dir: 'rtl'
            });
            
            // Handle user selection
            $('#user_id').on('change', function() {
                var userId = $(this).val();
                
                // Reset dependent selects
                resetSelect('#main_season_id', 'ابتدا دوره را انتخاب کنید');
                resetSelect('#sub_season_id', 'ابتدا فصل اصلی را انتخاب کنید');
                hideLessonsPanel();
                hideStatsPanel();
                
                if (userId) {
                    // Enable course selection
                    $('#course_id').prop('disabled', false);
                    loadUserStats(userId);
                } else {
                    $('#course_id').prop('disabled', true);
                    $('#course_id').val('').trigger('change');
                }
            });
            
            // Handle course selection
            $('#course_id').on('change', function() {
                var courseId = $(this).val();
                
                resetSelect('#main_season_id', 'انتخاب فصل اصلی');
                resetSelect('#sub_season_id', 'ابتدا فصل اصلی را انتخاب کنید');
                hideLessonsPanel();
                
                if (courseId) {
                    loadMainSeasons(courseId);
                } else {
                    $('#main_season_id').prop('disabled', true);
                }
            });
            
            // Handle main season selection
            $('#main_season_id').on('change', function() {
                var mainSeasonId = $(this).val();
                
                resetSelect('#sub_season_id', 'انتخاب زیر فصل');
                hideLessonsPanel();
                
                if (mainSeasonId) {
                    loadSubSeasons(mainSeasonId);
                } else {
                    $('#sub_season_id').prop('disabled', true);
                }
            });
            
            // Handle sub season selection
            $('#sub_season_id').on('change', function() {
                var subSeasonId = $(this).val();
                
                if (subSeasonId && $('#user_id').val()) {
                    loadLessons(subSeasonId);
                } else {
                    hideLessonsPanel();
                    if (!$('#user_id').val()) {
                        Swal.fire({
                            title: 'توجه!',
                            text: 'لطفاً ابتدا کاربر را انتخاب کنید',
                            icon: 'warning',
                            confirmButtonText: 'باشه'
                        });
                    }
                }
            });
            
            // Handle select all button
            $('#select-all').on('click', function() {
                $('.lesson-checkbox').prop('checked', true);
                $('.lesson-item').addClass('checked');
            });
            
            // Handle deselect all button
            $('#deselect-all').on('click', function() {
                $('.lesson-checkbox').prop('checked', false);
                $('.lesson-item').removeClass('checked');
            });
            
            // Handle form submission
            $('#lessons-form').on('submit', function(e) {
                e.preventDefault();
                saveLessonReads();
            });
            
            // Helper functions
            function resetSelect(selector, placeholder) {
                // Destroy existing Select2 instance
                $(selector).select2('destroy');
                
                // Reset the select element
                $(selector).empty().append('<option value="">' + placeholder + '</option>').prop('disabled', true);
                
                // Reinitialize Select2
                $(selector).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    dir: 'rtl'
                });
            }
            
            function hideLessonsPanel() {
                $('#lessons-panel').hide();
            }
            
            function showLessonsPanel() {
                $('#lessons-panel').show();
            }
            
            function hideStatsPanel() {
                $('#stats-panel').hide();
            }
            
            function showStatsPanel() {
                $('#stats-panel').show();
            }
            
            function loadMainSeasons(courseId) {
                // Destroy Select2, update options, then reinitialize
                $('#main_season_id').select2('destroy');
                $('#main_season_id').prop('disabled', false);
                $('#main_season_id').empty().append('<option value="">در حال بارگذاری...</option>');
                $('#main_season_id').select2({
                    placeholder: 'در حال بارگذاری...',
                    allowClear: true,
                    dir: 'rtl'
                });
                
                $.ajax({
                    url: '{{ route("admin.user-lesson-read.get-seasons-by-course") }}',
                    type: 'GET',
                    data: { course_id: courseId },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(seasons) {
                        // Destroy Select2 again to update options
                        $('#main_season_id').select2('destroy');
                        $('#main_season_id').empty().append('<option value="">انتخاب فصل اصلی</option>');
                        
                        if (seasons && seasons.length > 0) {
                            $.each(seasons, function(index, season) {
                                $('#main_season_id').append('<option value="' + season.id + '">' + 
                                    season.title  + '</option>');
                            });
                        } else {
                            $('#main_season_id').append('<option value="">هیچ فصل اصلی یافت نشد</option>');
                        }
                        
                        // Reinitialize Select2 with new options
                        $('#main_season_id').select2({
                            placeholder: 'انتخاب فصل اصلی',
                            allowClear: true,
                            dir: 'rtl'
                        });
                    },
                    error: function() {
                        $('#main_season_id').select2('destroy');
                        $('#main_season_id').empty().append('<option value="">خطا در بارگذاری فصل‌ها</option>');
                        $('#main_season_id').select2({
                            placeholder: 'خطا در بارگذاری فصل‌ها',
                            allowClear: true,
                            dir: 'rtl'
                        });
                    }
                });
            }
            
            function loadSubSeasons(mainSeasonId) {
                // Destroy Select2, update options, then reinitialize
                $('#sub_season_id').select2('destroy');
                $('#sub_season_id').prop('disabled', false);
                $('#sub_season_id').empty().append('<option value="">در حال بارگذاری...</option>');
                $('#sub_season_id').select2({
                    placeholder: 'در حال بارگذاری...',
                    allowClear: true,
                    dir: 'rtl'
                });
                
                $.ajax({
                    url: '{{ route("admin.user-lesson-read.get-sub-seasons-by-main-season") }}',
                    type: 'GET',
                    data: { main_season_id: mainSeasonId },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(subSeasons) {
                        // Destroy Select2 again to update options
                        $('#sub_season_id').select2('destroy');
                        $('#sub_season_id').empty().append('<option value="">انتخاب زیر فصل</option>');
                        
                        if (subSeasons && subSeasons.length > 0) {
                            $.each(subSeasons, function(index, subSeason) {
                                $('#sub_season_id').append('<option value="' + subSeason.id + '">' + 
                                    subSeason.title + '</option>');
                            });
                        } else {
                            $('#sub_season_id').append('<option value="">هیچ زیر فصلی یافت نشد</option>');
                        }
                        
                        // Reinitialize Select2 with new options
                        $('#sub_season_id').select2({
                            placeholder: 'انتخاب زیر فصل',
                            allowClear: true,
                            dir: 'rtl'
                        });
                    },
                    error: function() {
                        $('#sub_season_id').select2('destroy');
                        $('#sub_season_id').empty().append('<option value="">خطا در بارگذاری زیر فصل‌ها</option>');
                        $('#sub_season_id').select2({
                            placeholder: 'خطا در بارگذاری زیر فصل‌ها',
                            allowClear: true,
                            dir: 'rtl'
                        });
                    }
                });
            }
            
            function loadLessons(subSeasonId) {
                var userId = $('#user_id').val();
                
                $('#loading-spinner').show();
                $('#lessons-list').empty();
                showLessonsPanel();
                
                $.ajax({
                    url: '{{ route("admin.user-lesson-read.get-lessons-by-sub-season") }}',
                    type: 'GET',
                    data: { 
                        sub_season_id: subSeasonId,
                        user_id: userId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(lessons) {
                        $('#loading-spinner').hide();
                        
                        if (lessons && lessons.length > 0) {
                            $.each(lessons, function(index, lesson) {
                                var checked = lesson.is_read ? 'checked' : '';
                                var checkedClass = lesson.is_read ? 'checked' : '';
                                var lessonHtml = '<div class="lesson-item ' + checkedClass + '">' +
                                    '<input type="checkbox" name="lesson_ids[]" value="' + lesson.id + '" ' +
                                    'class="lesson-checkbox" ' + checked + '>' +
                                    '<div class="lesson-content">' +
                                        '<span class="lesson-title">' + lesson.title + '</span>' +
                                    '</div>' +
                                '</div>';
                                $('#lessons-list').append(lessonHtml);
                            });
                            
                            // Add event listener for checkbox changes
                            $('.lesson-checkbox').on('change', function() {
                                var $item = $(this).closest('.lesson-item');
                                if ($(this).is(':checked')) {
                                    $item.addClass('checked');
                                } else {
                                    $item.removeClass('checked');
                                }
                            });
                        } else {
                            $('#lessons-list').removeClass('lessons-grid').append('<p class="text-center text-muted">هیچ درسی یافت نشد</p>');
                        }
                    },
                    error: function() {
                        $('#loading-spinner').hide();
                        $('#lessons-list').append('<p class="text-center text-danger">خطا در بارگذاری دروس</p>');
                    }
                });
            }
            
            function loadUserStats(userId) {
                $.ajax({
                    url: '{{ route("admin.user-lesson-read.get-user-stats") }}',
                    type: 'GET',
                    data: { user_id: userId },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(stats) {
                        if (stats && Object.keys(stats).length > 0) {
                            var statsHtml = '<span class="stat-item">تعداد دروس مطالعه شده: ' + stats.total_read_lessons + '</span>' +
                                          '<span class="stat-item">دوره‌های در حال مطالعه: ' + stats.courses_with_read_lessons + '</span>';
                            
                            $('#user-stats').html(statsHtml);
                            showStatsPanel();
                        }
                    },
                    error: function() {
                        hideStatsPanel();
                    }
                });
            }
            
            function saveLessonReads() {
                if (!$('#user_id').val()) {
                    Swal.fire({
                        title: 'خطا!',
                        text: 'لطفاً کاربر را انتخاب کنید',
                        icon: 'error',
                        confirmButtonText: 'باشه'
                    });
                    return;
                }
                
                if (!$('#sub_season_id').val()) {
                    Swal.fire({
                        title: 'خطا!',
                        text: 'لطفاً زیر فصل را انتخاب کنید',
                        icon: 'error',
                        confirmButtonText: 'باشه'
                    });
                    return;
                }
                
                var formData = {
                    user_id: $('#user_id').val(),
                    sub_season_id: $('#sub_season_id').val(),
                    lesson_ids: []
                };
                
                // Get selected lesson IDs
                $('.lesson-checkbox:checked').each(function() {
                    formData.lesson_ids.push($(this).val());
                });
                
                // Show loading state
                $('#save-btn').prop('disabled', true);
                $('#save-text').hide();
                $('#save-loading').show();
                
                $.ajax({
                    url: '{{ route("admin.user-lesson-read.store") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'موفق!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'باشه'
                            });
                            
                            // Reload user stats
                            loadUserStats($('#user_id').val());
                        } else {
                            Swal.fire({
                                title: 'خطا!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'باشه'
                            });
                        }
                    },
                    error: function(xhr) {
                        var message = 'خطا در ذخیره اطلاعات';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            title: 'خطا!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'باشه'
                        });
                    },
                    complete: function() {
                        // Hide loading state
                        $('#save-btn').prop('disabled', false);
                        $('#save-text').show();
                        $('#save-loading').hide();
                    }
                });
            }
        });
    </script>
@endsection 