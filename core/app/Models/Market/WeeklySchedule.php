<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_start_date',
        'title',
        'status'
    ];

    protected $casts = [
        'week_start_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scheduleItems()
    {
        return $this->hasMany(ScheduleItem::class);
    }

    public function getStatusValueAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'غیر فعال';
            case 1:
                return 'فعال';
            default:
                return 'نامشخص';
        }
    }

    // Get schedule items organized by day and time slot
    public function getOrganizedScheduleAttribute()
    {
        $organized = [];
        $daysOfWeek = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
        
        foreach ($daysOfWeek as $dayIndex => $dayName) {
            $organized[$dayIndex] = [
                'name' => $dayName,
                'slots' => []
            ];
            
            for ($slot = 1; $slot <= 4; $slot++) {
                // Use the already loaded scheduleItems collection instead of making a new query
                $item = $this->scheduleItems
                    ->where('day_of_week', $dayIndex)
                    ->where('time_slot', $slot)
                    ->first();
                    
                $organized[$dayIndex]['slots'][$slot] = $item;
            }
        }
        
        return $organized;
    }
} 