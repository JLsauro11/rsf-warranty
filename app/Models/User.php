<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verification_expires_at' => 'datetime',
        ];
    }

    const ROLE_ADMIN = 'admin';
    const ROLE_CSR_RS8 = 'csr_rs8';
    const ROLE_CSR_SRF = 'csr_srf';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCsrRs8()
    {
        return $this->role === self::ROLE_CSR_RS8;
    }

    public function isCsrSrf()
    {
        return $this->role === self::ROLE_CSR_SRF;
    }
}
