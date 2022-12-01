<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    // use HasApiTokens, HasFactory;
    use Notifiable;

    const DefaultRoleId = '1'; // admin @todo should be changed

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Functions

    /**
     * Apakah user sudah mengisi data dirinya?
     */
    public function profileComplete(): bool
    {
        return $this->anggota !== null;
    }

    // Relations

    public function role(): Relation
    {
        return $this->belongsTo(User::class, 'role_id', 'id');
    }

    public function anggota(): Relation
    {
        return $this->hasOne(Anggota::class, 'user_id', 'id');
    }
}
