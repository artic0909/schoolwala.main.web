<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'amount',
        'razorpay_payment_id',
        'razorpay_order_id',
        'razorpay_signature',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
