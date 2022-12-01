<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Transaksi extends Model
{
    // use HasFactory;

    protected $table = 'Transaksi';

    protected $fillable = [
        'anggota_id',
        'nominal',
        'status',
        'keterangan'
    ];

    // Relations

    public function anggota(): Relation
    {
        return $this->hasMany(Anggota::class, 'transaksi_id', 'id');
    }

    public function simpanan(): Relation
    {
        return $this->hasMany(Simpanan::class, 'transaksi_id', 'id');
    }

    public function penarikan(): Relation
    {
        return $this->hasMany(Penarikan::class, 'transaksi_id', 'id');
    }
}
