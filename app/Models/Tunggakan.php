<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Tunggakan extends Model
{
    // use HasFactory;

    protected $table = 'tunggakan';

    protected $fillable = [
        'anggota_id',
        'nama_tunggakan',
        'nominal',
        'keterangan',
        'status',
        'tertunggak_id',
        'tertunggak_type'
    ];

    const STATUS = [
        'lunas' => '1',
        'belum_lunas' => '2',
        // 'menunggu_pembayaran' => '3'
    ];

    public function tertunggak()
    {
        return $this->morphTo('tertunggak');
    }

    public function penunggak()
    {
        return $this->morphTo('penunggak');
    }
}
