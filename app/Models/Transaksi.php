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
        'pelayan_id',
        'pelaku_id',
        'pelaku_type',
        'nominal',
        'status',
        'keterangan'
    ];

    const STATUS = [
        'lunas' => '1',
        'utang' => '2',
        // 'menunggu_pembayaran' => '3'
    ];

    // Relations

    public function pelayan(): Relation
    {
        return $this->belongsTo(Anggota::class, 'pelayan_id', 'id');
    }

    public function pelaku(): Relation
    {
        return $this->morphTo('pelaku');
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
