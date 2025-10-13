<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaverRequest extends Model
{
    protected $table = 'waver_requests';

    protected $fillable = [
        'class_id',
        'p_name',
        'c_name',
        'c_age',
        'email',
        'mobile',
        'address',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'email', 'email');
    }
}
