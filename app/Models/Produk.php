<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'harga',
        'keterangan',
    ];

    // Casts

    protected $casts = [
        'harga' => Money::class,
    ];

    // Realtions

    public function transaksiMerchant(): Relation
    {
        return $this->hasMany(TransaksiMerchant::class, 'produk_id', 'id');
    }
}
