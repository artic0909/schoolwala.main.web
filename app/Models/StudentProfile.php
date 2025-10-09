<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $table = 'student_profiles';

    protected $fillable = [
        'student_id',
        'profile_image',
        'profile_icon',
        'no_practise_test',
        'total_practise_test_score',
        'interest_in',
    ];

    protected $casts = [
        'interest_in' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
