<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    public $fillable = ['name', 'description', 'slug'];

    public function faqs()
    {
        return $this->hasMany(ClassFAQ::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id', 'id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'fac_id');
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'class_id');
    }

    public function waverRequests()
    {
        return $this->hasMany(WaverRequest::class, 'class_id');
    }
}
