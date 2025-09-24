<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'f_a_q_s';

    protected $fillable = [
        'question',
        'answer',
        'slug',
    ];

    // Automatically set slug if not provided
    public static function boot()
    {
        parent::boot();

        static::creating(function ($faq) {
            if (empty($faq->slug)) {
                $faq->slug = Str::slug(substr($faq->question, 0, 50)) . '-' . uniqid();
            }
        });

        static::updating(function ($faq) {
            if (empty($faq->slug)) {
                $faq->slug = Str::slug(substr($faq->question, 0, 50)) . '-' . uniqid();
            }
        });
    }
}
