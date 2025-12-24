<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificacaoRequest;
use App\Services\NotificacaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class NotificacaoController extends Controller
{
    protected NotificacaoService $notificacaoService;

    public function __construct(NotificacaoService $notificacaoService)
    {
        $this->notificacaoService = $notificacaoService;
    }

    /**
     * Cria uma nova notificação via API
     */
    public function store(NotificacaoRequest $request): JsonResponse
    {
        try {
            $notificacao = $this->notificacaoService->criarNotificacao(
                $request->cobranca_id,
                $request->canal,
                $request->email,
                $request->telefone
            );

            return $this->successResponse(
                [
                    'id' => $notificacao->id,
                    'cobranca_id' => $notificacao->cobranca_id,
                    'canal' => $notificacao->canal,
                    'email' => $notificacao->email,
                    'telefone' => $notificacao->telefone,
                    'status' => $notificacao->status,
                    'created_at' => $notificacao->created_at,
                ],
                'Notificação criada com sucesso! O envio será processado em breve.',
                201
            );
        } catch (ValidationException $e) {
            return $this->validationErrorResponse(
                $e->errors(),
                'Erro de validação ao criar notificação.'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Cobrança não encontrada.');
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                400
            );
        } catch (\Exception $e) {
            Log::error('Erro ao criar notificação via API', [
                'cobranca_id' => $request->cobranca_id,
                'canal' => $request->canal,
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->serverErrorResponse(
                'Erro ao processar a solicitação. Tente novamente mais tarde.'
            );
        }
    }

    /**
     * Retorna uma resposta de sucesso padronizada
     */
    protected function successResponse(
        mixed $data = null,
        string $message = 'Operação realizada com sucesso.',
        int $statusCode = 200
    ): JsonResponse {
        $response = [
            'status' => 'success',
            'status_code' => $statusCode,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Retorna uma resposta de erro padronizada
     */
    protected function errorResponse(
        string $message,
        array $errors = [],
        int $statusCode = 400
    ): JsonResponse {
        $response = [
            'status' => 'error',
            'status_code' => $statusCode,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Retorna uma resposta de erro de validação padronizada
     */
    protected function validationErrorResponse(
        array $errors,
        string $message = 'Erro de validação.'
    ): JsonResponse {
        return $this->errorResponse($message, $errors, 422);
    }

    /**
     * Retorna uma resposta de erro não autorizado
     */
    protected function unauthorizedResponse(string $message = 'Não autorizado.'): JsonResponse
    {
        return $this->errorResponse($message, [], 401);
    }

    /**
     * Retorna uma resposta de erro não encontrado
     */
    protected function notFoundResponse(string $message = 'Recurso não encontrado.'): JsonResponse
    {
        return $this->errorResponse($message, [], 404);
    }

    /**
     * Retorna uma resposta de erro interno do servidor
     */
    protected function serverErrorResponse(string $message = 'Erro interno do servidor.'): JsonResponse
    {
        return $this->errorResponse($message, [], 500);
    }
}
