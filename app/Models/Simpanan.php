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

    // Relations

    public function transaksi(): Relation
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function anggota(): Relation
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }
}
