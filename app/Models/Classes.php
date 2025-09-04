<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    public $fillable = ['name', 'description', 'slug'];

    public function faqs()
    {
        return $this->hasMany(ClassFAQ::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
