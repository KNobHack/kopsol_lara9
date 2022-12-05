<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Simpanan extends Model
{
    // use HasFactory;
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'transaksi_id',
        'jenis',
        'nominal',
        'status',
    ];

    const JENIS = [
        'pokok' => 1,
        'wajib' => 2,
        'sukarela' => 3,
    ];

    const STATUS = [
        'dibayar' => 1,
        'menunggak' => 2,
    ];

    // Relations

    public function transaksi(): Relation
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function anggota(): Relation
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }

    public function tunggakan(): Relation
    {
        return $this->morphOne(Tunggakan::class, 'tertunggak');
    }
}
