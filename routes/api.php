<?php

use App\Http\Controllers\Api\CobrancaController;
use App\Http\Controllers\Api\NotificacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/cobrancas', [CobrancaController::class, 'index']);
Route::post('/cobrancas', [CobrancaController::class, 'store']);
Route::post('/notificacoes', [NotificacaoController::class, 'store']);
