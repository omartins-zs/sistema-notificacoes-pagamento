<?php

use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\NotificacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cobrancas.index');
});

Route::get('/cobrancas', [CobrancaController::class, 'index'])->name('cobrancas.index');
Route::get('/cobrancas/create', [CobrancaController::class, 'create'])->name('cobrancas.create');
Route::post('/cobrancas', [CobrancaController::class, 'store'])->name('cobrancas.store');
Route::post('/cobrancas/{cobranca}/notificar', [NotificacaoController::class, 'store'])->name('notificacoes.store');
Route::get('/notificacoes', [NotificacaoController::class, 'index'])->name('notificacoes.index');
