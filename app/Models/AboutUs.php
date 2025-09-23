<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = [
        'happy_kids',
        'fun_lessons',
        'satisfaction',
        'cm_email',
        'cm_mobile',
        'cm_address',
        'our_story',
        'our_vision',
        'bold_message',
    ];
}
