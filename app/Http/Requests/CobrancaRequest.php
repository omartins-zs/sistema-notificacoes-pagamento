<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CobrancaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Permite sempre para testes (em produção, usar Auth::check())
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'required|integer|exists:clientes,id',
            'descricao' => 'required|string|max:200',
            'valor' => 'required|numeric|min:0.01',
            'data_vencimento' => 'required|date|after_or_equal:today',
            'status' => 'sometimes|in:pendente,paga,atrasada',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'cliente_id' => 'cliente',
            'descricao' => 'descrição',
            'valor' => 'valor',
            'data_vencimento' => 'data de vencimento',
            'status' => 'status',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O campo :attribute é obrigatório.',
            'cliente_id.integer' => 'O campo :attribute deve ser um número inteiro.',
            'cliente_id.exists' => 'O :attribute selecionado não existe.',
            'descricao.required' => 'O campo :attribute é obrigatório.',
            'descricao.string' => 'O campo :attribute deve ser um texto.',
            'descricao.max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'valor.required' => 'O campo :attribute é obrigatório.',
            'valor.numeric' => 'O campo :attribute deve ser um número.',
            'valor.min' => 'O campo :attribute deve ser maior que zero.',
            'data_vencimento.required' => 'O campo :attribute é obrigatório.',
            'data_vencimento.date' => 'O campo :attribute deve ser uma data válida.',
            'data_vencimento.after_or_equal' => 'O campo :attribute deve ser hoje ou uma data futura.',
            'status.in' => 'O campo :attribute deve ser "pendente", "paga" ou "atrasada".',
        ];
    }
}

