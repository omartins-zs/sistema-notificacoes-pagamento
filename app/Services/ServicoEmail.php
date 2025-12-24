<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Cobranca;
use Illuminate\Support\Facades\Log;

class ServicoEmail
{
    /**
     * Envia notificação de pagamento por e-mail
     */
    public function enviar(Cliente $cliente, Cobranca $cobranca, ?string $emailDestino = null): bool
    {
        // Usa o email fornecido ou o email do cliente
        $email = $emailDestino ?? $cliente->email;

        // Simulação de envio de e-mail
        // Em produção, aqui seria usado Mail::send() ou similar

        $mensagem = sprintf(
            "Olá %s,\n\nVocê possui uma cobrança pendente:\n\n" .
            "Descrição: %s\n" .
            "Valor: R$ %s\n" .
            "Vencimento: %s\n\n" .
            "Por favor, realize o pagamento até a data de vencimento.\n\n" .
            "Atenciosamente,\nEquipe de Cobrança",
            $cliente->nome,
            $cobranca->descricao,
            number_format($cobranca->valor, 2, ',', '.'),
            $cobranca->data_vencimento->format('d/m/Y')
        );

        // Log para demonstração (em produção seria enviado realmente)
        Log::info("E-mail enviado para {$email}", [
            'cliente' => $cliente->nome,
            'cobranca_id' => $cobranca->id,
            'email_destino' => $email,
            'mensagem' => $mensagem,
        ]);

        // Simula sucesso (90% de chance)
        return rand(1, 10) <= 9;
    }
}

