<?php

namespace App\Services;

use App\Models\Cobranca;
use App\Models\NotificacaoPagamento;
use App\Jobs\EnviarNotificacaoJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificacaoService
{
    /**
     * Cria uma notificação de pagamento e enfileira o job de envio
     */
    public function criarNotificacao(int $cobrancaId, string $canal, ?string $email = null, ?string $telefone = null): NotificacaoPagamento
    {
        // Para testes: usa o primeiro usuário se não houver autenticação
        $vendedorId = Auth::id() ?? \App\Models\User::first()?->id ?? 1;

        // Valida se a cobrança existe e pertence ao vendedor
        $cobranca = Cobranca::where('id', $cobrancaId)
            ->where('vendedor_id', $vendedorId)
            ->firstOrFail();

        // Valida o canal
        if (!in_array($canal, ['email', 'sms'])) {
            throw new \InvalidArgumentException('Canal inválido. Use "email" ou "sms".');
        }

        // Se o canal for email e não foi fornecido um email, usa o email do cliente
        if ($canal === 'email' && !$email) {
            $cobranca->load('cliente');
            $email = $cobranca->cliente->email;
        }

        // Se o canal for sms e não foi fornecido um telefone, usa o telefone do cliente
        if ($canal === 'sms' && !$telefone) {
            $cobranca->load('cliente');
            $telefone = $cobranca->cliente->telefone;
        }

        // Valida se o email foi fornecido quando o canal é email
        if ($canal === 'email' && empty($email)) {
            throw new \InvalidArgumentException('Email é obrigatório quando o canal é "email". O cliente deve ter um email cadastrado ou você deve fornecer um email na requisição.');
        }

        // Valida se o telefone foi fornecido quando o canal é sms
        if ($canal === 'sms' && empty($telefone)) {
            throw new \InvalidArgumentException('Telefone é obrigatório quando o canal é "sms". O cliente deve ter um telefone cadastrado ou você deve fornecer um telefone na requisição.');
        }

        // Cria a notificação com status pendente
        $notificacao = NotificacaoPagamento::create([
            'cobranca_id' => $cobrancaId,
            'vendedor_id' => $vendedorId,
            'canal' => $canal,
            'status' => 'pendente',
            'email' => $email,
            'telefone' => $telefone,
        ]);

        // Enfileira o job para envio em segundo plano
        EnviarNotificacaoJob::dispatch($notificacao->id)
            ->onQueue('notificacoes');

        Log::info('Notificação criada e job enfileirado', [
            'notificacao_id' => $notificacao->id,
            'cobranca_id' => $cobrancaId,
            'canal' => $canal,
        ]);

        return $notificacao;
    }
}

