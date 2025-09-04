<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFAQ extends Model
{
    protected $table = 'class_f_a_q_s';

    protected $fillable = [
        'class_id',
        'question',
        'answer',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
