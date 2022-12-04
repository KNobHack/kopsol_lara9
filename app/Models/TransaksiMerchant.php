<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class TransaksiMerchant extends Model
{
    use HasFactory;

    protected $table = 'transaksi_merchant';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah_beli',
        'total_nominal',
        'keterangan'
    ];

    // Relations

    public function transaksi(): Relation
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }

    public function produk(): Relation
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function tunggakan(): Relation
    {
        return $this->morphOne(Tunggakan::class, 'tertunggak');
    }
}
