<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'story_tag_id',
        'image',
        'name',
        'feedback',
    ];

    // A Story belongs to one Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // A Story belongs to one StoryTag
    public function storyTag()
    {
        return $this->belongsTo(StoryTag::class, 'story_tag_id');
    }
}
