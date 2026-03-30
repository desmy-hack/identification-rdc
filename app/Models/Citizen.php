<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'national_id', 'last_name', 'middle_name', 'first_name',
        'birth_date', 'birth_place', 'gender', 'address',
        'province', 'territory', 'sector', 'phone',
        'father_name', 'mother_name', 'photo', 'qr_code', 'agent_id'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class);
    }
}
