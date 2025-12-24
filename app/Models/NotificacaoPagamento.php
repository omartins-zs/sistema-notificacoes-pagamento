<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacaoPagamento extends Model
{
    protected $table = 'notificacoes_pagamento';

    protected $fillable = [
        'cobranca_id',
        'vendedor_id',
        'canal',
        'email',
        'telefone',
        'status',
        'data_envio',
        'erro',
    ];

    protected function casts(): array
    {
        return [
            'data_envio' => 'datetime',
        ];
    }

    public function cobranca(): BelongsTo
    {
        return $this->belongsTo(Cobranca::class);
    }

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }
}
