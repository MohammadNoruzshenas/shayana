<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentTraining extends Model
{
    use HasFactory;

    protected $fillable = ['season_id', 'title', 'description', 'video_path', 'video_link', 'audio_link', 'order'];

    /**
     * دریافت فصل این قسمت
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(ParentTrainingChapter::class, 'season_id');
    }
}
