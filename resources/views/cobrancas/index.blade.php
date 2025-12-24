@extends('layouts.app')

@section('title', 'Cobranças Pendentes')

@section('content')
<div class="px-4 py-5 sm:p-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Cobranças Pendentes</h1>
            <p class="mt-1 text-sm text-gray-500">Lista de cobranças pendentes que podem ser notificadas</p>
        </div>
        <a href="{{ route('cobrancas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nova Cobrança
        </a>
    </div>

    @if($cobrancas->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500">Nenhuma cobrança pendente encontrada.</p>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($cobrancas as $cobranca)
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <p class="text-sm font-medium text-indigo-600 truncate">
                                        {{ $cobranca->descricao }}
                                    </p>
                                    @if($cobranca->status === 'atrasada')
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Atrasada
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            Cliente: {{ $cobranca->cliente->nome }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                            Valor: R$ {{ number_format($cobranca->valor, 2, ',', '.') }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                            Vencimento: {{ $cobranca->data_vencimento->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    data-modal-target="notificationModal"
                                    data-modal-toggle="notificationModal"
                                    data-cobranca-id="{{ $cobranca->id }}"
                                >
                                    Notificar
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- Modal Flowbite -->
<div id="notificationModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Escolha o Canal de Notificação
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="notificationModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fechar</span>
                </button>
            </div>
            <form id="notificationForm" method="POST" onsubmit="return false;">
                @csrf
                <div class="p-4 md:p-5">
                    <div class="mb-4">
                        <label for="canal" class="block mb-2 text-sm font-medium text-gray-900">Canal</label>
                        <select name="canal" id="canal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                            <option value="">Selecione um canal</option>
                            <option value="email">E-mail</option>
                            <option value="sms">SMS</option>
                        </select>
                        <div id="errorMessage" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button type="submit" id="submitBtn" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <span id="submitText">Enviar Notificação</span>
                        <span id="submitLoading" class="hidden">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            Enviando...
                        </span>
                    </button>
                    <button type="button" data-modal-hide="notificationModal" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Aguarda o jQuery e Toastr estarem disponíveis
(function() {
    function initNotificationForm() {
        if (typeof jQuery === 'undefined') {
            console.log('jQuery não está disponível ainda, tentando novamente...');
            setTimeout(initNotificationForm, 100);
            return;
        }

        if (typeof toastr === 'undefined') {
            console.log('Toastr não está disponível ainda, tentando novamente...');
            setTimeout(initNotificationForm, 100);
            return;
        }

        let currentCobrancaId = null;
        const modal = $('#notificationModal');
        const form = $('#notificationForm');

        console.log('Inicializando formulário de notificação');

        // Quando o modal é aberto, captura o ID da cobrança
        $(document).on('click', '[data-modal-target="notificationModal"]', function() {
            currentCobrancaId = $(this).data('cobranca-id');
            console.log('Modal aberto para cobrança ID:', currentCobrancaId);

            if (!currentCobrancaId) {
                console.error('ID da cobrança não encontrado!');
                return;
            }

            // Limpa formulário
            form[0].reset();
            $('#errorMessage').addClass('hidden').text('');
            $('#canal').removeClass('border-red-500');
        });

        // Flag para evitar múltiplos envios
        let isSubmitting = false;

        // Submissão do formulário via AJAX - usando delegação de eventos
        $(document).on('submit', '#notificationForm', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            // Previne múltiplos envios
            if (isSubmitting) {
                console.log('Formulário já está sendo enviado, ignorando...');
                return false;
            }

            console.log('Formulário submetido via AJAX');

            const canal = $('#canal').val();
            const errorMessage = $('#errorMessage');
            const submitBtn = $('#submitBtn');
            const submitText = $('#submitText');
            const submitLoading = $('#submitLoading');

            // Validação
            if (!canal) {
                errorMessage.removeClass('hidden').text('Por favor, selecione um canal de notificação.');
                $('#canal').addClass('border-red-500');
                return false;
            }

            if (!currentCobrancaId) {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Erro: ID da cobrança não encontrado.');
                } else {
                    alert('Erro: ID da cobrança não encontrado.');
                }
                return false;
            }

            // Marca como enviando
            isSubmitting = true;

            // Desabilita botão e mostra loading
            submitBtn.prop('disabled', true);
            submitText.addClass('hidden');
            submitLoading.removeClass('hidden');
            errorMessage.addClass('hidden');
            $('#canal').removeClass('border-red-500');

            // Cria FormData
            const formData = new FormData();
            formData.append('canal', canal);
            formData.append('_token', $('input[name="_token"]').val());

            // Garante que a URL está correta
            const url = `/cobrancas/${currentCobrancaId}/notificar`;
            console.log('Enviando para:', url);

            // Envia requisição AJAX usando jQuery
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    console.log('Resposta recebida:', data);

                    // Verifica o formato padronizado da resposta
                    if (data.status === 'success') {
                        const message = data.message || 'Notificação criada com sucesso! O envio será processado em breve.';

                        // Verifica se toastr está disponível
                        if (typeof toastr !== 'undefined') {
                            toastr.success(message);
                        } else {
                            alert(message);
                        }

                        // Fecha o modal Flowbite
                        modal.addClass('hidden');

                        // Recarrega a lista após 1 segundo
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        // Se vier com status error mesmo no success (200-299)
                        throw new Error(data.message || 'Erro ao criar notificação');
                    }
                },
                error: function(xhr) {
                    console.error('Erro na requisição:', xhr);
                    let errorMsg = 'Erro ao criar notificação. Tente novamente.';
                    let errors = [];

                    // Tenta parsear a resposta padronizada
                    if (xhr.responseJSON) {
                        const response = xhr.responseJSON;

                        if (response.status === 'error') {
                            errorMsg = response.message || errorMsg;

                            // Se houver erros de validação, mostra todos
                            if (response.errors && Object.keys(response.errors).length > 0) {
                                errors = Object.values(response.errors).flat();
                                errorMsg = errors.join(' ');
                            }
                        } else if (response.message) {
                            errorMsg = response.message;
                        }
                    } else if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'error') {
                                errorMsg = response.message || errorMsg;
                                if (response.errors) {
                                    errors = Object.values(response.errors).flat();
                                    errorMsg = errors.join(' ');
                                }
                            }
                        } catch(e) {
                            console.error('Erro ao parsear resposta:', e);
                        }
                    }

                    // Verifica se toastr está disponível
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                    errorMessage.removeClass('hidden').text(errorMsg);
                    $('#canal').addClass('border-red-500');
                },
                complete: function() {
                    // Reabilita botão e permite novo envio
                    isSubmitting = false;
                    submitBtn.prop('disabled', false);
                    submitText.removeClass('hidden');
                    submitLoading.addClass('hidden');
                }
            });

            return false;
        });

    }

    // Tenta inicializar quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNotificationForm);
    } else {
        initNotificationForm();
    }
})();
</script>
@endsection

