<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      
        'national_id',  
        'badge_number', 
        'active'        
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function identity()
    {
        return $this->belongsTo(Citizen::class, 'national_id', 'national_id');
    }

   
    public function registeredCitizens()
    {
        return $this->hasMany(Citizen::class, 'agent_id', 'user_id');
    }


    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}