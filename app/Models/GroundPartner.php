<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundPartner extends Model
{
    use HasFactory;

    protected $table = 'ground_partners';

    protected $fillable = [
        'ep_id',
        'name',
        'code',
        'mobile',
        'status',
    ];

    /**
     * Relationship: A Ground Partner belongs to an Executive Partner.
     */
    public function executivePartner()
    {
        return $this->belongsTo(ExecutivePartner::class, 'ep_id');
    }

    /**
     * Alias for executivePartner
     */
    public function ep()
    {
        return $this->executivePartner();
    }

    /**
     * Accessor for 'phone' alias to 'mobile'
     */
    public function getPhoneAttribute()
    {
        return $this->mobile;
    }

    /**
     * Mutator for 'phone' alias to 'mobile'
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['mobile'] = $value;
    }
}
