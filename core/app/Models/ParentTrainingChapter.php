<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentTrainingChapter extends Model
{
    use HasFactory;

    protected $table = 'parent_training_seasons';
    protected $fillable = ['title', 'description', 'order'];

    /**
     * دریافت تمام قسمت‌های این فصل
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(ParentTraining::class, 'season_id')->orderBy('order');
    }
}
