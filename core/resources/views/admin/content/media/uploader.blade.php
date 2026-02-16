@extends('admin.layouts.master')
@section('head-tag')
    <title>اپلود فایل</title>
    <link rel="stylesheet" href="{{ asset('dashboard/js/jalalidatepicker/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/resumable/style.css') }}">
@endsection
@section('breadcrumb')
    <li><a href="{{ route('admin.content.media.index') }}">مدیا</a></li>
    <li><a href="{{ route('admin.content.media.index') }}">{{ $media->title }}</a></li>

    <li><a href="{{ route('admin.content.media.create') }}">افزودن مدیا جدید</a></li>
@endsection
@section('content')
    <a href="{{ route('admin.content.media.details', $media) }}" style="margin-bottom: 5px"
        class="btn all-confirm-btn">برگشت</a>

    <p class="box__title">اپلودر</p>
    <div class="row no-gutters bg-white">
        <div class="col-12">
            <form action="{{ route('admin.content.media.store') }}" method="post" enctype="multipart/form-data"
                class="padding-30">
                @csrf

                {{-- start test --}}
                <div id="frame">

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
                    <script src="{{ asset('dashboard/resumable/resumable.js') }}"></script>

                    <div class="resumable-error">
                        Your browser, unfortunately, is not supported by Resumable.js. The library requires support for <a
                            href="http://www.w3.org/TR/FileAPI/">the HTML5 File API</a> along with <a
                            href="http://www.w3.org/TR/FileAPI/#normalization-of-params">file slicing</a>.
                    </div>

                    <div class="resumable-drop">
                        پرونده رابکشید و رها کنید <a class="resumable-browse"><u>یا انتخاب کنید</u></a>
                    </div>

                    <div class="resumable-progress">
                        <table>
                            <tr>
                                <td width="100%">
                                    <div class="progress-container">
                                        <div class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="progress-text" nowrap="nowrap"></td>
                                <td class="progress-pause" nowrap="nowrap">
                                    <a href="#" onclick="r.upload(); return(false);" class="progress-resume-link"><img
                                            src="{{ asset('dashboard/resumable/resume.png') }}" title="Resume upload" /></a>
                                    <a href="#" onclick="r.pause(); return(false);" class="progress-pause-link"><img
                                            src="{{ asset('dashboard/resumable/pause.png') }}" title="Pause upload" /></a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <ul class="resumable-list"></ul>
                    <br>


                    <br>
                    <div style="margin:5px"></div>
            </form>
        </div>
    </div>
@endsection


@section('script')
    <script>
        var r = new Resumable({
            target: '{{ route('admin.content.media.chunkUpload', $media) }}',
            query: {
                _token: '{{ csrf_token() }}'
            },
            chunkSize: 10 * 1024 * 1024,
            simultaneousUploads: 4,
            testChunks: false,
            throttleProgressCallbacks: 1,
            method: "post"
        });
        // Resumable.js isn't supported, fall back on a different method
        if (!r.support) {
            $('.resumable-error').show();
        } else {


            // Show a place for dropping/selecting files
            $('.resumable-drop').show();
            r.assignDrop($('.resumable-drop')[0]);
            r.assignBrowse($('.resumable-browse')[0]);

            // Handle file add event
            r.on('fileAdded', function(file) {
                // Show progress pabr
                $('.resumable-progress, .resumable-list').show();
                // Show pause, hide resume
                $('.resumable-progress .progress-resume-link').hide();
                $('.resumable-progress .progress-pause-link').show();
                $(".resumable-file-progress").html("")
                // Add the file to the list
                $('.resumable-list').append('<li class="resumable-file-' + file.uniqueIdentifier +
                    '"><span class="uploder"> در حال آپلود </span> <span class="resumable-file-name"></span> <span class="resumable-file-progress"></span>'
                    );
                $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-name').html(file.fileName);
                // Actually start the upload
                r.upload();
            });
            r.on('pause', function() {
                // Show resume, hide pause
                $('.resumable-progress .progress-resume-link').show();
                $('.resumable-progress .progress-pause-link').hide();
            });
            r.on('complete', function() {
                // Hide pause/resume when the upload has completed
                $('.resumable-progress .progress-resume-link, .resumable-progress .progress-pause-link').hide();

            });

            r.on('fileError', function(file, message) {
                // Reflect that the file upload has resulted in error
                $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(
                    '(مشکل در آپلود فایل: ' + message + ')');
            });
         r.on('fileProgress', function(file) {
    $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(Math.floor(file.progress() * 100) + '%');
    $('.progress-bar').css({
        width: Math.floor(r.progress() * 100) + '%'
    });
});

r.on('fileSuccess', function(file, message) {
    $('.uploder').html("")
    $('.resumable-file-name').html("")
    if (JSON.parse(message).status == false) {
        $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(
            '<span style="color:red">( خطا )</span> ' + 'فرمت فایل مجاز نیست فرمت های مجاز : ' +
            JSON.parse(message).message);
    } else {
        $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(
            '<span style="color:green">(تکمیل شد)</span>');
    }
    // Reflect that the file upload has completed
});

        }
    </script>
@endsection
