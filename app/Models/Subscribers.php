<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'fees_id',
        'reciptimage',
        'subscription_date',
        'expiry_date',
        'status',
    ];

    // Relationship: Subscriber belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship: Subscriber belongs to a class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Relationship: Subscriber belongs to a fees record
    public function fees()
    {
        return $this->belongsTo(Fees::class);
    }
}
