<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTest extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'student_id',
        'video_id',
        'student_answers',
        'score',
    ];

    // Cast JSON fields to array automatically
    protected $casts = [
        'student_answers' => 'array',
    ];

    /**
     * Relationships
     */

    // Each test belongs to one student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Each test belongs to one video (the "test")
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
}
