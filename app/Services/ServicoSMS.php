<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Cobranca;
use Illuminate\Support\Facades\Log;

class ServicoSMS
{
    /**
     * Envia notificação de pagamento por SMS
     */
    public function enviar(Cliente $cliente, Cobranca $cobranca, ?string $telefoneDestino = null): bool
    {
        // Usa o telefone fornecido ou o telefone do cliente
        $telefone = $telefoneDestino ?? $cliente->telefone;

        // Simulação de envio de SMS
        // Em produção, aqui seria usado um serviço como Twilio, AWS SNS, etc.

        $mensagem = sprintf(
            "Olá %s! Você possui uma cobrança de R$ %s vencendo em %s. Descrição: %s",
            $cliente->nome,
            number_format($cobranca->valor, 2, ',', '.'),
            $cobranca->data_vencimento->format('d/m/Y'),
            $cobranca->descricao
        );

        // Log para demonstração (em produção seria enviado realmente)
        Log::info("SMS enviado para {$telefone}", [
            'cliente' => $cliente->nome,
            'cobranca_id' => $cobranca->id,
            'telefone_destino' => $telefone,
            'mensagem' => $mensagem,
        ]);

        // Simula sucesso (85% de chance)
        return rand(1, 20) <= 17;
    }
}

