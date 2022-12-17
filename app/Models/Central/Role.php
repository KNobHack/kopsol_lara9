<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Role extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'role'
    ];

    const ROLE = [
        'admin' => 1,
    ];

    // Relations

    public function users(): Relation
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
