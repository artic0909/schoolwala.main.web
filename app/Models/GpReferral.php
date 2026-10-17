<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpReferral extends Model
{
    use HasFactory;

    protected $table = 'gp_referrals';

    protected $fillable = [
        'gp_id',
        'student_id',
        'payment_id',
        'amount',
        'payment_status',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function groundPartner()
    {
        return $this->belongsTo(GroundPartner::class, 'gp_id');
    }

    public function gp()
    {
        return $this->groundPartner();
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
