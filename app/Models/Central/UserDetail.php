<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class UserDetail extends Model
{
    // use HasFactory;

    protected $table = 'users_detail';

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
        'nomor_telpon',
    ];

    // Relations

    public function user(): Relation
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function anggota(): Relation
    {
        return $this->hasOne(Anggota::class, 'user_id', 'id');
    }

    // public function melayaniTransaksi(): Relation
    // {
    //     return $this->hasMany(Transaksi::class, 'pelayan_id', 'id');
    // }

    public function transaksi(): Relation
    {
        return $this->hasMany(Transaksi::class, 'pelaku_id');
    }

    // public function simpanan(): Relation
    // {
    //     return $this->hasMany(Simpanan::class, 'anggota_id', 'id');
    // }

    // public function penarikan(): Relation
    // {
    //     return $this->hasMany(Penarikan::class, 'anggota_id', 'id');
    // }

    public function tunggakan(): Relation
    {
        return $this->hasMany(Tunggakan::class, 'penunggak_id');
    }
}
