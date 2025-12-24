<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notificacoes_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cobranca_id')->constrained('cobrancas')->onDelete('cascade');
            $table->foreignId('vendedor_id')->constrained('users')->onDelete('cascade');
            $table->enum('canal', ['email', 'sms']);
            $table->string('email', 100)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->enum('status', ['pendente', 'enviado', 'falha'])->default('pendente');
            $table->dateTime('data_envio')->nullable();
            $table->text('erro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacoes_pagamento');
    }
};
