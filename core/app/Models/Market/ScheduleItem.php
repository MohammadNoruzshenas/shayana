<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_schedule_id',
        'day_of_week',
        'time_slot',
        'game_id',
        'lession_id',
        'notes'
    ];

    public function weeklySchedule()
    {
        return $this->belongsTo(WeeklySchedule::class);
    }

    public function game()
    {
        return $this->belongsTo(\App\Models\Game::class);
    }

    public function lession()
    {
        return $this->belongsTo(Lession::class);
    }

    // Get day name in Persian
    public function getDayNameAttribute()
    {
        $days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
        return $days[$this->day_of_week] ?? 'نامشخص';
    }

    // Get time slot name
    public function getTimeSlotNameAttribute()
    {
        $slots = [
            1 => 'تایم 1',
            2 => 'تایم 2', 
            3 => 'تایم 3',
            4 => 'تایم 4'
        ];
        return $slots[$this->time_slot] ?? 'نامشخص';
    }
} 