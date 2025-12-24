<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificacaoRequest;
use App\Services\NotificacaoService;
use App\Models\NotificacaoPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    protected NotificacaoService $notificacaoService;

    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    /**
     * Lista o histórico de notificações do vendedor autenticado
     */
    public function index()
    {
        // Para testes: usa o primeiro usuário se não houver autenticação
        $vendedorId = Auth::id() ?? \App\Models\User::first()?->id ?? 1;

        $notificacoes = NotificacaoPagamento::with(['cobranca.cliente'])
            ->where('vendedor_id', $vendedorId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notificacoes.index', compact('notificacoes'));
    }

    /**
     * Cria uma nova notificação a partir de uma cobrança
     */
    public function store(Request $request, $cobranca)
    {
        $request->validate([
            'canal' => 'required|in:email,sms',
            'email' => 'sometimes|required_if:canal,email|email|max:100',
            'telefone' => 'sometimes|required_if:canal,sms|string|max:20',
        ]);

        try {
            // Se $cobranca for um ID, converte para inteiro, senão assume que já é o ID
            $cobrancaId = is_numeric($cobranca) ? (int)$cobranca : $cobranca->id;
            $notificacao = $this->notificacaoService->criarNotificacao($cobrancaId, $request->canal, $request->email, $request->telefone);

            // Se for requisição AJAX, retorna JSON padronizado
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'status_code' => 201,
                    'message' => 'Notificação criada com sucesso! O envio será processado em breve.',
                    'data' => [
                        'id' => $notificacao->id,
                        'cobranca_id' => $notificacao->cobranca_id,
                        'canal' => $notificacao->canal,
                        'status' => $notificacao->status,
                    ]
                ], 201);
            }

            return redirect()
                ->route('cobrancas.index')
                ->with('success', 'Notificação criada com sucesso! O envio será processado em breve.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 422,
                    'message' => 'Erro de validação ao criar notificação.',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 404,
                    'message' => 'Cobrança não encontrada.',
                ], 404);
            }

            return redirect()
                ->back()
                ->with('error', 'Cobrança não encontrada.');
        } catch (\InvalidArgumentException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 400,
                    'message' => $e->getMessage(),
                ], 400);
            }

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Erro ao criar notificação', [
                'cobranca_id' => $cobranca,
                'canal' => $request->canal,
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 500,
                    'message' => 'Erro ao processar a solicitação. Tente novamente mais tarde.',
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Erro ao criar notificação. Tente novamente mais tarde.');
        }
    }
}
