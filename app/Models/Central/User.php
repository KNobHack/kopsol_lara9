<?php

namespace App\Models\Central;

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

    const DefaultRoleId = 2; // user

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
     * Apakah user sudah mengisi minimum profile
     * @return bool
     */
    public function profileMinimum(): bool
    {
        $detail = $this->udetail;

        if ($detail === null) {
            return false;
        }

        return $detail->nama && $detail->jenis_kelamin;
    }

    /**
     * Apakah user sudah mengisi data dirinya?
     */
    public function profileComplete(): bool
    {
        $detail = $this->udetail;

        if ($detail === null) {
            return false;
        }

        return $detail->nik &&
            $detail->nama &&
            $detail->tempat_lahir &&
            $detail->tanggal_lahir &&
            $detail->jenis_kelamin &&
            $detail->agama &&
            $detail->pekerjaan &&
            $detail->alamat &&
            $detail->nomor_telpon;
    }

    // Relations

    public function role(): Relation
    {
        return $this->belongsTo(User::class, 'role_id', 'id');
    }

    public function detail(): Relation
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }
}
