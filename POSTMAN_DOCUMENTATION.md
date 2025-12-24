# Documentação da API - Sistema de Notificações de Pagamento

## Importar no Postman

1. Abra o Postman
2. Clique em **Import** (canto superior esquerdo)
3. Selecione o arquivo `postman_collection.json`
4. A coleção será importada com todas as requisições configuradas

## Configuração

### Variável de Ambiente

A coleção usa a variável `base_url` que está configurada como `http://127.0.0.1:8000` por padrão.

Para alterar:
1. Clique na coleção
2. Vá em **Variables**
3. Altere o valor de `base_url` conforme necessário

## Endpoints

### GET /api/cobrancas

Lista todas as cobranças do vendedor autenticado.

**URL:** `{{base_url}}/api/cobrancas`

**Método:** `GET`

**Headers:**
```
Accept: application/json
```

**Resposta de Sucesso (200):**
```json
{
    "status": "success",
    "status_code": 200,
    "message": "Cobranças listadas com sucesso.",
    "data": [
        {
            "id": 1,
            "descricao": "Pagamento de serviços",
            "valor": "1500.00",
            "data_vencimento": "2024-12-25",
            "status": "pendente",
            "cliente": {
                "id": 1,
                "nome": "João Silva",
                "email": "joao@example.com",
                "telefone": "(11) 99999-9999"
            },
            "created_at": "2024-12-24T12:00:00.000000Z",
            "updated_at": "2024-12-24T12:00:00.000000Z"
        }
    ]
}
```

**Resposta de Erro (500):**
```json
{
    "status": "error",
    "status_code": 500,
    "message": "Erro ao listar cobranças. Tente novamente mais tarde."
}
```

### POST /api/cobrancas

Cria uma nova cobrança.

**URL:** `{{base_url}}/api/cobrancas`

**Método:** `POST`

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Body (JSON):**
```json
{
    "cliente_id": 1,
    "descricao": "Pagamento de serviços",
    "valor": 1500.00,
    "data_vencimento": "2024-12-31",
    "status": "pendente"
}
```

**Parâmetros:**
- `cliente_id` (integer, obrigatório): ID do cliente (o cliente **DEVE ter um email cadastrado** para poder receber notificações por email)
- `descricao` (string, obrigatório): Descrição da cobrança (máximo 200 caracteres)
- `valor` (numeric, obrigatório): Valor da cobrança (deve ser maior que zero)
- `data_vencimento` (date, obrigatório): Data de vencimento (formato: YYYY-MM-DD, deve ser hoje ou futura)
- `status` (string, opcional): Status da cobrança - `"pendente"` (padrão), `"paga"` ou `"atrasada"`

**Observação importante:**
- O cliente selecionado **deve ter um email válido cadastrado** no sistema para que seja possível enviar notificações por email posteriormente.

**Resposta de Sucesso (201):**
```json
{
    "status": "success",
    "status_code": 201,
    "message": "Cobrança criada com sucesso.",
    "data": {
        "id": 1,
        "descricao": "Pagamento de serviços",
        "valor": "1500.00",
        "data_vencimento": "2024-12-31",
        "status": "pendente",
        "cliente": {
            "id": 1,
            "nome": "João Silva",
            "email": "joao@example.com",
            "telefone": "(11) 99999-9999"
        },
        "created_at": "2024-12-24T12:00:00.000000Z",
        "updated_at": "2024-12-24T12:00:00.000000Z"
    }
}
```

**Resposta de Erro de Validação (422):**
```json
{
    "status": "error",
    "status_code": 422,
    "message": "Erro de validação ao criar cobrança.",
    "errors": {
        "cliente_id": ["O cliente selecionado não existe."],
        "valor": ["O campo valor deve ser maior que zero."],
        "data_vencimento": ["O campo data de vencimento deve ser hoje ou uma data futura."]
    }
}
```

### POST /api/cobrancas

Cria uma nova cobrança.

**URL:** `{{base_url}}/api/cobrancas`

**Método:** `POST`

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Body (JSON):**
```json
{
    "cliente_id": 1,
    "descricao": "Pagamento de serviços",
    "valor": 1500.00,
    "data_vencimento": "2024-12-31",
    "status": "pendente"
}
```

**Parâmetros:**
- `cliente_id` (integer, obrigatório): ID do cliente (o cliente **DEVE ter um email cadastrado** para poder receber notificações por email)
- `descricao` (string, obrigatório): Descrição da cobrança (máximo 200 caracteres)
- `valor` (numeric, obrigatório): Valor da cobrança (deve ser maior que zero)
- `data_vencimento` (date, obrigatório): Data de vencimento (formato: YYYY-MM-DD, deve ser hoje ou futura)
- `status` (string, opcional): Status da cobrança - `"pendente"` (padrão), `"paga"` ou `"atrasada"`

**Observação importante:**
- O cliente selecionado **deve ter um email válido cadastrado** no sistema para que seja possível enviar notificações por email posteriormente.

**Resposta de Sucesso (201):**
```json
{
    "status": "success",
    "status_code": 201,
    "message": "Cobrança criada com sucesso.",
    "data": {
        "id": 1,
        "descricao": "Pagamento de serviços",
        "valor": "1500.00",
        "data_vencimento": "2024-12-31",
        "status": "pendente",
        "cliente": {
            "id": 1,
            "nome": "João Silva",
            "email": "joao@example.com",
            "telefone": "(11) 99999-9999"
        },
        "created_at": "2024-12-24T12:00:00.000000Z",
        "updated_at": "2024-12-24T12:00:00.000000Z"
    }
}
```

**Resposta de Erro de Validação (422):**
```json
{
    "status": "error",
    "status_code": 422,
    "message": "Erro de validação ao criar cobrança.",
    "errors": {
        "cliente_id": ["O cliente selecionado não existe."],
        "valor": ["O campo valor deve ser maior que zero."],
        "data_vencimento": ["O campo data de vencimento deve ser hoje ou uma data futura."]
    }
}
```

### POST /api/notificacoes

Envia uma notificação de pagamento por EMAIL ou SMS.

**URL:** `{{base_url}}/api/notificacoes`

**Método:** `POST`

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Body (JSON) - Para Email:**
```json
{
    "cobranca_id": 1,
    "canal": "email",
    "email": "destino@example.com"
}
```

**Body (JSON) - Para SMS:**
```json
{
    "cobranca_id": 1,
    "canal": "sms",
    "telefone": "(11) 99999-9999"
}
```

**Parâmetros:**
- `cobranca_id` (integer, obrigatório): ID da cobrança a ser notificada
- `canal` (string, obrigatório): Canal de notificação - deve ser `"email"` para enviar por email ou `"sms"` para enviar por SMS
- `email` (string, opcional): Email de destino. Quando o canal for `"email"`, se não fornecido, será usado o email do cliente associado à cobrança
- `telefone` (string, opcional): Telefone de destino. Quando o canal for `"sms"`, se não fornecido, será usado o telefone do cliente associado à cobrança

**Validações:**
- A cobrança deve existir no banco de dados
- A cobrança deve pertencer ao vendedor autenticado
- O canal deve ser exatamente `"email"` ou `"sms"`
- Quando o canal for `"email"`: o parâmetro `email` é obrigatório OU o cliente associado à cobrança deve ter um email cadastrado
- Quando o canal for `"sms"`: o parâmetro `telefone` é obrigatório OU o cliente associado à cobrança deve ter um telefone cadastrado
- O email fornecido deve ser um email válido (formato válido)
- O telefone fornecido deve ser uma string válida (máximo 20 caracteres)

## Padrão de Respostas

Todas as respostas seguem o formato padronizado:

| Campo        | Tipo    | Descrição                                                                 |
|--------------|---------|---------------------------------------------------------------------------|
| status       | string  | `"success"` ou `"error"`                                                  |
| status_code  | integer | Código HTTP da resposta (ex: 200, 201, 400, 401, 404, 422, 500)            |
| message      | string  | Texto descritivo                                                         |
| data         | mixed   | Objeto ou array de dados (opcional, em caso de sucesso)                   |
| errors       | array   | Lista de erros (opcional, em caso de falha)                               |

**Resposta de Sucesso (201):**
```json
{
    "status": "success",
    "status_code": 201,
    "message": "Notificação criada com sucesso! O envio será processado em breve.",
    "data": {
        "id": 1,
        "cobranca_id": 1,
        "canal": "email",
        "status": "pendente",
        "created_at": "2024-12-24T12:00:00.000000Z"
    }
}
```

**Resposta de Erro (400):**
```json
{
    "status": "error",
    "status_code": 400,
    "message": "[mensagem de erro]"
}
```

**Resposta de Erro de Validação (422):**
```json
{
    "status": "error",
    "status_code": 422,
    "message": "Erro de validação ao criar notificação.",
    "errors": {
        "cobranca_id": ["A cobrança selecionada não existe."],
        "canal": ["O campo canal de notificação deve ser \"email\" ou \"sms\"."]
    }
}
```

**Resposta de Erro - Não Encontrado (404):**
```json
{
    "status": "error",
    "status_code": 404,
    "message": "Cobrança não encontrada."
}
```

**Resposta de Erro - Servidor (500):**
```json
{
    "status": "error",
    "status_code": 500,
    "message": "Erro ao processar a solicitação. Tente novamente mais tarde."
}
```

## Exemplos de Uso

### Exemplo 1: Criar uma cobrança
```bash
curl -X POST http://127.0.0.1:8000/api/cobrancas \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "cliente_id": 1,
    "descricao": "Pagamento de serviços",
    "valor": 1500.00,
    "data_vencimento": "2024-12-31",
    "status": "pendente"
  }'
```

### Exemplo 2: Listar cobranças
```bash
curl -X GET http://127.0.0.1:8000/api/cobrancas \
  -H "Accept: application/json"
```

### Exemplo 3: Enviar notificação por E-mail
```bash
curl -X POST http://127.0.0.1:8000/api/notificacoes \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "cobranca_id": 1,
    "canal": "email"
  }'
```

### Exemplo 4: Enviar notificação por SMS
```bash
curl -X POST http://127.0.0.1:8000/api/notificacoes \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "cobranca_id": 2,
    "canal": "sms"
  }'
```

## Fluxo de Processamento

1. **Criação da Notificação:**
   - A requisição cria um registro na tabela `notificacoes_pagamento` com status `"pendente"`
   - Um job é enfileirado na fila `notificacoes`

2. **Processamento em Background:**
   - O job `EnviarNotificacaoJob` é processado pela fila
   - O serviço apropriado (`ServicoEmail` ou `ServicoSMS`) é chamado
   - O status da notificação é atualizado para `"enviado"` ou `"falha"`

3. **Configuração do Job:**
   - Máximo de 5 tentativas
   - Timeout de 5 minutos por tentativa
   - Backoff: 10s, 20s, 30s entre tentativas

## Status da Notificação

- **pendente**: Notificação criada, aguardando processamento
- **enviado**: Notificação enviada com sucesso
- **falha**: Notificação falhou após todas as tentativas

## Observações

- As notificações são processadas de forma assíncrona através de filas
- É necessário ter o worker rodando: `php artisan queue:listen --queue=notificacoes`
- Os serviços de e-mail e SMS são simulados (fazem log no arquivo de log)
- Em produção, substitua `ServicoEmail` e `ServicoSMS` por implementações reais

