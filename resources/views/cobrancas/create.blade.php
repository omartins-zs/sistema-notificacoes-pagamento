@extends('layouts.app')

@section('title', 'Criar Nova Cobrança')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Criar Nova Cobrança</h1>
        <p class="mt-1 text-sm text-gray-500">Preencha os dados para criar uma nova cobrança</p>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <form id="cobrancaForm" method="POST" action="{{ route('cobrancas.store') }}" onsubmit="return false;">
            @csrf
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <!-- Cliente -->
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente <span class="text-red-500">*</span></label>
                    <select name="cliente_id" id="cliente_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }} - {{ $cliente->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição <span class="text-red-500">*</span></label>
                    <input type="text" name="descricao" id="descricao" value="{{ old('descricao') }}" required maxlength="200" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('descricao')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valor -->
                <div>
                    <label for="valor" class="block text-sm font-medium text-gray-700">Valor (R$) <span class="text-red-500">*</span></label>
                    <input type="number" name="valor" id="valor" value="{{ old('valor') }}" required step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('valor')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data de Vencimento -->
                <div>
                    <label for="data_vencimento" class="block text-sm font-medium text-gray-700">Data de Vencimento <span class="text-red-500">*</span></label>
                    <input type="date" name="data_vencimento" id="data_vencimento" value="{{ old('data_vencimento') }}" required min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('data_vencimento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="pendente" {{ old('status', 'pendente') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="paga" {{ old('status') == 'paga' ? 'selected' : '' }}>Paga</option>
                        <option value="atrasada" {{ old('status') == 'atrasada' ? 'selected' : '' }}>Atrasada</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mensagens de erro -->
                <div id="errorMessages" class="hidden">
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Erro ao criar cobrança</h3>
                                <div class="mt-2 text-sm text-red-700" id="errorList"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('cobrancas.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancelar
                </a>
                <button type="submit" id="submitBtn" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span id="submitText">Criar Cobrança</span>
                    <span id="submitLoading" class="hidden">
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        Criando...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    function initCobrancaForm() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initCobrancaForm, 100);
            return;
        }

        if (typeof toastr === 'undefined') {
            setTimeout(initCobrancaForm, 100);
            return;
        }

        const form = $('#cobrancaForm');
        let isSubmitting = false;

        form.on('submit', function(e) {
            e.preventDefault();

            if (isSubmitting) {
                return false;
            }

            const submitBtn = $('#submitBtn');
            const submitText = $('#submitText');
            const submitLoading = $('#submitLoading');
            const errorMessages = $('#errorMessages');
            const errorList = $('#errorList');

            // Validação básica
            const clienteId = $('#cliente_id').val();
            const descricao = $('#descricao').val();
            const valor = $('#valor').val();
            const dataVencimento = $('#data_vencimento').val();

            if (!clienteId || !descricao || !valor || !dataVencimento) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Por favor, preencha todos os campos obrigatórios.');
                } else {
                    alert('Por favor, preencha todos os campos obrigatórios.');
                }
                return false;
            }

            isSubmitting = true;
            submitBtn.prop('disabled', true);
            submitText.addClass('hidden');
            submitLoading.removeClass('hidden');
            errorMessages.addClass('hidden');

            const formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        const message = data.message || 'Cobrança criada com sucesso!';

                        if (typeof toastr !== 'undefined') {
                            toastr.success(message);
                        } else {
                            alert(message);
                        }

                        setTimeout(function() {
                            window.location.href = '{{ route("cobrancas.index") }}';
                        }, 1000);
                    } else {
                        throw new Error(data.message || 'Erro ao criar cobrança');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Erro ao criar cobrança. Tente novamente.';
                    let errors = [];

                    if (xhr.responseJSON) {
                        const response = xhr.responseJSON;

                        if (response.status === 'error') {
                            errorMsg = response.message || errorMsg;

                            if (response.errors && Object.keys(response.errors).length > 0) {
                                errors = Object.values(response.errors).flat();
                                errorMsg = errors.join(' ');

                                // Mostra erros na div
                                errorList.html('<ul class="list-disc list-inside">' +
                                    errors.map(e => '<li>' + e + '</li>').join('') +
                                    '</ul>');
                                errorMessages.removeClass('hidden');
                            }
                        } else if (response.message) {
                            errorMsg = response.message;
                        } else if (response.errors) {
                            errors = Object.values(response.errors).flat();
                            errorMsg = errors.join(' ');
                            errorList.html('<ul class="list-disc list-inside">' +
                                errors.map(e => '<li>' + e + '</li>').join('') +
                                '</ul>');
                            errorMessages.removeClass('hidden');
                        }
                    }

                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                },
                complete: function() {
                    isSubmitting = false;
                    submitBtn.prop('disabled', false);
                    submitText.removeClass('hidden');
                    submitLoading.addClass('hidden');
                }
            });

            return false;
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCobrancaForm);
    } else {
        initCobrancaForm();
    }
})();
</script>
@endsection

