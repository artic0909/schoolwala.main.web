<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    public $fillable = ['class_id', 'name', 'bg_color_txt', 'icon_txt', 'slug', 'background_image'];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
    
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
