<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Notificações')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('cobrancas.index') }}" class="text-xl font-semibold text-gray-900">
                        Sistema de Notificações
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cobrancas.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Cobranças
                    </a>
                    <a href="{{ route('notificacoes.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Notificações
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Mensagens de sessão com Toastr -->
    @if(session('success'))
        <script>
            if (typeof toastr !== 'undefined') {
                toastr.success("{{ session('success') }}");
            }
        </script>
    @endif

    @if(session('error'))
        <script>
            if (typeof toastr !== 'undefined') {
                toastr.error("{{ session('error') }}");
            }
        </script>
    @endif
</body>
</html>

