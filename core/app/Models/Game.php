<?php

namespace App\Models;

use App\Models\Market\Course;
use App\Models\Market\Season;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'title',
        'description',
        'image',
        'course_id',
        'main_season_id',
        'sub_season_id'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function mainSeason()
    {
        return $this->belongsTo(Season::class, 'main_season_id');
    }

    public function subSeason()
    {
        return $this->belongsTo(Season::class, 'sub_season_id');
    }
}
