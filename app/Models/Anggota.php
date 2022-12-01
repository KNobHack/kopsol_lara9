<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Anggota extends Model
{
    // use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'alamat',
        'no_telpon',
    ];

    // Relations

    public function user(): Relation
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function simpanan(): Relation
    {
        return $this->hasMany(Simpanan::class, 'anggota_id', 'id');
    }

    public function penarikan(): Relation
    {
        return $this->hasMany(Penarikan::class, 'anggota_id', 'id');
    }

    public function tunggakan(): Relation
    {
        return $this->hasMany(Tunggakan::class, 'anggota_id', 'id');
    }
}
