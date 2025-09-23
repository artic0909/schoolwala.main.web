<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryTag extends Model
{
    protected $table = 'story_tags';

    protected $fillable = [
        'tag_name',
        'slug'
    ];

    public function stories()
    {
        return $this->hasMany(Story::class, 'story_tag_id');
    }
}
