@extends('admin.layouts.master')

@section('head-tag')
<title>نمایش برنامه هفتگی</title>
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
    .lesson-cell.has-lesson {
        background: #2a4d3a !important;
        color: white;
    }
    .lesson-info {
        padding: 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        line-height: 1.4;
    }
    .time-slot {
        width: 80px;
        background: #2c2c2c;
        min-width: 80px;
    }
    .lesson-cell {
        max-width: 200px;
        min-width: 150px;
        width: auto;
        white-space: normal;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        overflow: visible;
        height: auto;
    }
    .lesson-cell.has-lesson {
        background: #2a4d3a !important;
        color: white;
    }
    .lesson-info div {
        margin-bottom: 5px;
        word-break: break-word;
        overflow-wrap: break-word;
        word-wrap: break-word;
        white-space: normal;
        max-width: 100%;
    }
    .lesson-info div:last-child {
        margin-bottom: 0;
    }
    .schedule-table {
        table-layout: fixed;
        width: 100%;
    }
    .schedule-table tr {
        height: auto;
    }
</style>
@endsection

@section('breadcrumb')
<li><a href="{{ route('admin.index') }}">خانه</a></li>
<li><a href="{{ route('admin.schedule.index') }}">برنامه هفتگی</a></li>
<li><a href="{{ route('admin.schedule.show', $schedule->id) }}">نمایش برنامه</a></li>
@endsection

@section('content')

<div class="tab__box" style="display: flex; gap: 10px;">
    <div class="tab__items">
        <p>نمایش برنامه هفتگی</p>
    </div>
    <div class="tab__items">
        <a class="btn btn-warning tab__item" href="{{ route('admin.schedule.edit', $schedule->id) }}">
            <i class="fa fa-edit"></i> ویرایش برنامه
        </a>
    </div>
</div>

<div class="row no-gutters bg-white">
    <div class="col-12">
        <div class="padding-30">
            <div class="row" style="gap:10px">
                <div class="col-24">
                    <p class="mb-5 font-size-14">کاربر :</p>
                    <div class="alert alert-info bg-info-light p-3">
                        {{ $schedule->user->full_name }}
                    </div>
                </div>

                <div class="col-24">
                    <p class="mb-5 font-size-14">تاریخ شروع هفته :</p>
                    <div class="alert alert-info bg-info-light p-3">
                        {{ \Morilog\Jalali\Jalalian::fromCarbon($schedule->week_start_date)->format('Y/m/d') }}
                    </div>
                </div>

                <div class="col-24">
                    <p class="mb-5 font-size-14">وضعیت :</p>
                    <div class="alert alert-info bg-info-light p-3">
                        <span class="badge badge-{{ $schedule->status ? 'success' : 'danger' }}">
                            {{ $schedule->status_value }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row" style="gap:10px">
                <div class="col-48">
                    <p class="mb-5 font-size-14">عنوان :</p>
                    <div class="alert alert-info bg-info-light p-3">
                        {{ $schedule->title ?? 'بدون عنوان' }}
                    </div>
                </div>
            </div>

            <div class="row" style="gap:10px">
                <div class="col-12">
                    <p class="mb-5 font-size-14">برنامه هفتگی :</p>
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
                                    $organizedSchedule = $schedule->organized_schedule;
                                @endphp
                                @foreach($daysOfWeek as $dayIndex => $dayName)
                                    <tr>
                                        <td class="day-header">{{ $dayName }}</td>
                                        @for($slot = 1; $slot <= 4; $slot++)
                                            @php
                                                $currentItem = $organizedSchedule[$dayIndex]['slots'][$slot] ?? null;
                                            @endphp
                                            <td class="lesson-cell {{ $currentItem ? 'has-lesson' : '' }}">
                                                @if($currentItem)
                                                    <div class="lesson-info">
                                                        @if($currentItem->lession)
                                                            @php
                                                                $selectedCourse = $currentItem?->lession?->season?->parent?->course;
                                                                $selectedMainSeason = $currentItem?->lession?->season->parent;
                                                                $selectedSeason = $currentItem?->lession?->season;
                                                                $selectedLesion = $currentItem?->lession;
                                                            @endphp
                                                            <div><strong>{{ $selectedLesion->title }}</strong></div>
                                                            @if($selectedCourse)
                                                                <div><small>{{ $selectedCourse->title .'-'.$selectedMainSeason->title.'-'.$selectedSeason->title }}</small></div>
                                                            @endif
                                                        @endif
                                                        @if($currentItem->notes)
                                                            <div><em>{{ $currentItem->notes }}</em></div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div style="color: #666; padding: 10px;">خالی</div>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 