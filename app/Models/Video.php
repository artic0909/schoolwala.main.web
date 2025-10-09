<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'chapter_id',
        'video_title',
        'slug',
        'video_type',
        'video_link',
        'note_link',
        'video_description',
        'video_thumbnail',
        'questions',
        'answers',
        'correct_answers',
        'duration',
        'rating',
        'feedback',
        'likes',
        'views',
    ];

    // Cast JSON fields to array automatically
    protected $casts = [
        'questions' => 'array',
        'answers' => 'array',
        'correct_answers' => 'array',
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
