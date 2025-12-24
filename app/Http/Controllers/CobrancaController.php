<?php

namespace App\Http\Controllers;

use App\Http\Requests\CobrancaRequest;
use App\Models\Cliente;
use App\Models\Cobranca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CobrancaController extends Controller
{
    /**
     * Lista todas as cobranças pendentes do vendedor autenticado
     */
    public function index()
    {
        // Para testes: usa o primeiro usuário se não houver autenticação
        $vendedorId = Auth::id() ?? \App\Models\User::first()?->id ?? 1;

        $cobrancas = Cobranca::with(['cliente'])
            ->where('vendedor_id', $vendedorId)
            ->where('status', 'pendente')
            ->orderBy('data_vencimento', 'asc')
            ->get();

        return view('cobrancas.index', compact('cobrancas'));
    }

    /**
     * Mostra o formulário para criar uma nova cobrança
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('cobrancas.create', compact('clientes'));
    }

    /**
     * Armazena uma nova cobrança
     */
    public function store(CobrancaRequest $request)
    {
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

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Cobrança criada com sucesso.',
                'data' => $cobranca->load('cliente'),
            ], 201);
        }

        return redirect()->route('cobrancas.index')
            ->with('success', 'Cobrança criada com sucesso!');
    }
}
