<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CobrancaRequest;
use App\Models\Cobranca;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CobrancaController extends Controller
{
    /**
     * Lista todas as cobranças do vendedor autenticado
     */
    public function index(): JsonResponse
    {
        try {
            // Para testes: usa o primeiro usuário se não houver autenticação
            $vendedorId = Auth::id() ?? \App\Models\User::first()?->id ?? 1;

            $cobrancas = Cobranca::with(['cliente'])
                ->where('vendedor_id', $vendedorId)
                ->orderBy('data_vencimento', 'asc')
                ->get()
                ->map(function ($cobranca) {
                    return [
                        'id' => $cobranca->id,
                        'descricao' => $cobranca->descricao,
                        'valor' => $cobranca->valor,
                        'data_vencimento' => $cobranca->data_vencimento,
                        'status' => $cobranca->status,
                        'cliente' => [
                            'id' => $cobranca->cliente->id,
                            'nome' => $cobranca->cliente->nome,
                            'email' => $cobranca->cliente->email,
                            'telefone' => $cobranca->cliente->telefone,
                        ],
                        'created_at' => $cobranca->created_at,
                        'updated_at' => $cobranca->updated_at,
                    ];
                });

            return $this->successResponse(
                $cobrancas,
                'Cobranças listadas com sucesso.',
                200
            );
        } catch (\Exception $e) {
            return $this->serverErrorResponse(
                'Erro ao listar cobranças. Tente novamente mais tarde.'
            );
        }
    }

    /**
     * Cria uma nova cobrança
     */
    public function store(CobrancaRequest $request): JsonResponse
    {
        try {
            // Para testes: usa o primeiro usuário se não houver autenticação
            $vendedorId = Auth::id() ?? \App\Models\User::first()?->id ?? 1;

            $cobranca = Cobranca::create([
                'vendedor_id' => $vendedorId,
                'cliente_id' => $request->cliente_id,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data_vencimento' => $request->data_vencimento,
                'status' => $request->status ?? 'pendente',
            ]);

            $cobranca->load('cliente');

            return $this->successResponse(
                [
                    'id' => $cobranca->id,
                    'descricao' => $cobranca->descricao,
                    'valor' => $cobranca->valor,
                    'data_vencimento' => $cobranca->data_vencimento,
                    'status' => $cobranca->status,
                    'cliente' => [
                        'id' => $cobranca->cliente->id,
                        'nome' => $cobranca->cliente->nome,
                        'email' => $cobranca->cliente->email,
                        'telefone' => $cobranca->cliente->telefone,
                    ],
                    'created_at' => $cobranca->created_at,
                    'updated_at' => $cobranca->updated_at,
                ],
                'Cobrança criada com sucesso.',
                201
            );
        } catch (ValidationException $e) {
            return $this->validationErrorResponse(
                $e->errors(),
                'Erro de validação ao criar cobrança.'
            );
        } catch (\Exception $e) {
            Log::error('Erro ao criar cobrança via API', [
                'cliente_id' => $request->cliente_id,
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->serverErrorResponse(
                'Erro ao criar cobrança. Tente novamente mais tarde.'
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
     * Retorna uma resposta de erro interno do servidor
     */
    protected function serverErrorResponse(string $message = 'Erro interno do servidor.'): JsonResponse
    {
        return $this->errorResponse($message, [], 500);
    }
}

