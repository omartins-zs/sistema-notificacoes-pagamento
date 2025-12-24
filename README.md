<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sistema de Notificações de Pagamento

Sistema desenvolvido em Laravel que permite a um vendedor emitir lembretes de pagamento para seus clientes, selecionando o canal de notificação desejado (e-mail ou SMS) para cada cobrança.

### Funcionalidades

- ✅ Seleção de canal de notificação (E-mail ou SMS)
- ✅ Listagem de cobranças pendentes
- ✅ Histórico de notificações enviadas
- ✅ Processamento de notificações em fila (background jobs)
- ✅ API REST para integração
- ✅ Interface web moderna com Tailwind CSS

### Estrutura do Banco de Dados

- **users** (Vendedores)
- **clientes** (Clientes)
- **cobrancas** (Cobranças/Faturas)
- **notificacoes_pagamento** (Histórico de notificações)

### Instalação e Configuração

1. **Clone o repositório e instale as dependências:**
```bash
composer install
npm install
```

2. **Configure o arquivo .env:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure o banco de dados no .env:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

4. **Execute as migrations e seeders:**
```bash
php artisan migrate:fresh --seed
```

5. **Compile os assets:**
```bash
npm run dev
# ou para produção:
npm run build
```

### Comandos Principais

**Iniciar o servidor Laravel:**
```bash
php artisan serve
```

**Processar a fila de jobs:**

Para desenvolvimento (recomendado - não precisa parar e rodar de novo):
```bash
php artisan queue:listen --queue=notificacoes --tries=3
```

Para produção:
```bash
php artisan queue:work --queue=notificacoes --tries=3
```

**Ou usar o comando dev que inicia tudo:**
```bash
composer dev
```

**Nota:** O comando `queue:listen` é melhor para desenvolvimento pois monitora mudanças no código e reinicia automaticamente. O `queue:work` é mais eficiente para produção.

### Uso da API

**Endpoint:** `POST /api/notificacoes`

**Exemplo de requisição (curl):**
```bash
curl -X POST http://localhost:8000/api/notificacoes \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "cobranca_id": 1,
    "canal": "sms"
  }'
```

**Resposta de sucesso:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "cobranca_id": 1,
    "canal": "sms",
    "status": "pendente",
    "created_at": "2024-12-24T12:00:00.000000Z"
  }
}
```

### Rotas Web

- `/cobrancas` - Lista de cobranças pendentes
- `/cobrancas/{id}/notificar` - Criar notificação (POST)
- `/notificacoes` - Histórico de notificações

### Observações

- As notificações são processadas em segundo plano através de filas
- Os serviços de e-mail e SMS são simulados (fazem log no arquivo de log)
- Em produção, substitua `ServicoEmail` e `ServicoSMS` por implementações reais
- O driver de fila padrão é `database` (configurado em `config/queue.php`)

### Tecnologias Utilizadas

- PHP 8.2+
- Laravel 12
- MySQL
- Tailwind CSS
- Vite

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
