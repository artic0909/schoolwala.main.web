<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'student_id',
        'video_id',
        'rating',
        'feedback',
    ];

    /**
     * Relationships
     */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
