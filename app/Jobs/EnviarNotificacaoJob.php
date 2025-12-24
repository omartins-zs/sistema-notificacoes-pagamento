<?php

namespace App\Jobs;

use App\Models\NotificacaoPagamento;
use App\Services\ServicoEmail;
use App\Services\ServicoSMS;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviarNotificacaoJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /** Número máximo de tentativas */
    public int $tries = 5;

    /** Timeout geral em segundos (5 minutos) */
    public int $timeout = 300;

    /** Intervalos de backoff (em segundos) entre tentativas */
    public array $backoff = [10, 20, 30];

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $notificacaoId
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificacao = NotificacaoPagamento::with(['cobranca.cliente'])->findOrFail($this->notificacaoId);

        $cobranca = $notificacao->cobranca;
        $cliente = $cobranca->cliente;

        try {
            $enviado = false;

            if ($notificacao->canal === 'email') {
                $servicoEmail = new ServicoEmail();
                // Usa o email da notificação se disponível, senão usa o email do cliente
                $emailDestino = $notificacao->email ?? $cliente->email;
                $enviado = $servicoEmail->enviar($cliente, $cobranca, $emailDestino);
            } elseif ($notificacao->canal === 'sms') {
                $servicoSMS = new ServicoSMS();
                // Usa o telefone da notificação se disponível, senão usa o telefone do cliente
                $telefoneDestino = $notificacao->telefone ?? $cliente->telefone;
                $enviado = $servicoSMS->enviar($cliente, $cobranca, $telefoneDestino);
            }

            if ($enviado) {
                $notificacao->update([
                    'status' => 'enviado',
                    'data_envio' => now(),
                    'erro' => null,
                ]);
            } else {
                $notificacao->update([
                    'status' => 'falha',
                    'data_envio' => now(),
                    'erro' => 'Falha ao enviar notificação',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao processar notificação', [
                'notificacao_id' => $this->notificacaoId,
                'erro' => $e->getMessage(),
            ]);

            $notificacao->update([
                'status' => 'falha',
                'data_envio' => now(),
                'erro' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
