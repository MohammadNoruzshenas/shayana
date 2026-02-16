<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLessionRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lession_id',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function lession()
    {
        return $this->belongsTo(Lession::class);
    }



    // Check if a user has read a specific lesson
    public static function hasUserReadLesson($userId, $lessionId)
    {
        return self::where('user_id', $userId)
                   ->where('lession_id', $lessionId)
                   ->exists();
    }

    // Mark a lesson as read for a user
    public static function markAsRead($userId, $lessionId)
    {
        return self::firstOrCreate(
            [
                'user_id' => $userId,
                'lession_id' => $lessionId
            ],
            [
                'read_at' => now()
            ]
        );
    }

    // Unmark a lesson as read for a user
    public static function markAsUnread($userId, $lessionId)
    {
        return self::where('user_id', $userId)
                   ->where('lession_id', $lessionId)
                   ->delete();
    }
} 