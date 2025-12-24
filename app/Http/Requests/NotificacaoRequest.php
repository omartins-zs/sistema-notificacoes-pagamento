<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificacaoRequest extends FormRequest
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
            'cobranca_id' => 'required|integer|exists:cobrancas,id',
            'canal' => 'required|in:email,sms',
            'email' => 'sometimes|required_if:canal,email|email|max:100',
            'telefone' => 'sometimes|required_if:canal,sms|string|max:20',
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
            'cobranca_id' => 'cobrança',
            'canal' => 'canal de notificação',
            'email' => 'email',
            'telefone' => 'telefone',
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
            'cobranca_id.required' => 'O campo :attribute é obrigatório.',
            'cobranca_id.integer' => 'O campo :attribute deve ser um número inteiro.',
            'cobranca_id.exists' => 'A :attribute selecionada não existe.',
            'canal.required' => 'O campo :attribute é obrigatório.',
            'canal.in' => 'O campo :attribute deve ser "email" ou "sms".',
            'email.required_if' => 'O campo :attribute é obrigatório quando o canal é "email".',
            'email.email' => 'O campo :attribute deve ser um email válido.',
            'email.max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'telefone.required_if' => 'O campo :attribute é obrigatório quando o canal é "sms".',
            'telefone.string' => 'O campo :attribute deve ser um texto.',
            'telefone.max' => 'O campo :attribute não pode ter mais de :max caracteres.',
        ];
    }
}
