<?php

namespace App\Models;

use App\Casts\Money;
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
        'sisa_nominal',
        'tertunggak_id',
        'tertunggak_type'
    ];

    protected $casts = [
        'nominal' => Money::class,
        'sisa_nominal' => Money::class,
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
