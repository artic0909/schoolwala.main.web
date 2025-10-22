<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\Subscribers\Subscriber;

class Fees extends Model
{
    protected $table = 'fees';

    protected $fillable = [
        'class_id',
        'amount',
        'qrimage',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
