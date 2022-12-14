<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class NonAnggota extends Model
{
    use HasFactory;

    protected $table = 'non_anggota';

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'nomor_telpon'
    ];

    // Relations

    public function role(): Relation
    {
        return $this->belongsTo(User::class, 'role_id', 'id');
    }

    public function transaksi(): Relation
    {
        return $this->morphMany(Transaksi::class, 'pelaku');
    }

    public function tunggakan(): Relation
    {
        return $this->morphMany(Tunggakan::class, 'penunggak');
    }
}
