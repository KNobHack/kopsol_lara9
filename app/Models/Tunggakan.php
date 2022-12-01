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

    public function tertunggak()
    {
        return $this->morphTo('tertunggak');
    }

    public function anggota(): Relation
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }
}
