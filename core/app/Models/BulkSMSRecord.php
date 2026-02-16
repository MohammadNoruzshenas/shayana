<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BulkSMSRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'creator_id',
        'data',
        'sms_id',
        'status',
        'total_count',
        'success_count',
        'failed_count',
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';
    const STATUS_SUCCEEDED = 'succeeded';

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function sms()
    {
        return $this->belongsTo(\App\Models\Notify\SMS::class, 'sms_id');
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'در انتظار',
            self::STATUS_SENT => 'ارسال شده',
            self::STATUS_FAILED => 'شکست خورده',
            self::STATUS_SUCCEEDED => 'موفق',
            default => 'نامشخص'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_SENT => 'info',
            self::STATUS_FAILED => 'danger',
            self::STATUS_SUCCEEDED => 'success',
            default => 'secondary'
        };
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCreator($query, $creatorId)
    {
        return $query->where('creator_id', $creatorId);
    }
}
