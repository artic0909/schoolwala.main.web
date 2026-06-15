<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'short_description',
        'content',
        'status',
        'meta_title',
        'meta_description'
    ];
}
