<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefone',
    ];

    public function cobrancas(): HasMany
    {
        return $this->hasMany(Cobranca::class);
    }
}
