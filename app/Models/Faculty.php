<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    protected $fillable = [
        'image',
        'fac_id',
        'name',
        'email',
        'mobile',
        'about_fac',
        'assigned_classes',
    ];

    protected $casts = [
        'assigned_classes' => 'array',
    ];


}
