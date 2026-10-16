<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecutivePartner extends Model
{
    use HasFactory;

    protected $table = 'executive_partners';

    protected $fillable = [
        'name',
        'code',
        'mobile',
        'status',
    ];

    /**
     * Relationship: An Executive Partner has many Ground Partners.
     */
    public function groundPartners()
    {
        return $this->hasMany(GroundPartner::class, 'ep_id');
    }

    /**
     * Alias for groundPartners
     */
    public function gps()
    {
        return $this->groundPartners();
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
