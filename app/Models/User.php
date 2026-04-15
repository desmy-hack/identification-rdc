<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'must_change_password', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean', 
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isAgent(): bool { return $this->role === 'agent'; }
    public function isCitizen(): bool { return $this->role === 'citizen'; }

    public function citizenProfile()
    {
        return $this->hasOne(Citizen::class, 'user_id');
    }
}