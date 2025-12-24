# Como Importar no Postman

## Método 1: Importar Arquivo JSON

1. Abra o **Postman**
2. Clique no botão **Import** (canto superior esquerdo)
3. Selecione a opção **File**
4. Escolha o arquivo `postman_collection.json` deste projeto
5. Clique em **Import**

## Método 2: Importar via Link (se hospedado)

1. Abra o **Postman**
2. Clique em **Import**
3. Selecione a opção **Link**
4. Cole a URL do arquivo JSON
5. Clique em **Import**

## Após Importar

1. A coleção **"Sistema de Notificações de Pagamento"** aparecerá no lado esquerdo
2. Configure a variável `base_url`:
   - Clique na coleção
   - Vá na aba **Variables**
   - O valor padrão é `http://127.0.0.1:8000`
   - Altere se necessário

## Testando

1. Abra a requisição **"Criar Notificação"**
2. Verifique se o body está correto:
   ```json
   {
       "cobranca_id": 1,
       "canal": "email"
   }
   ```
3. Clique em **Send**
4. Verifique a resposta

## Requisitos

- Servidor Laravel rodando (`php artisan serve`)
- Banco de dados configurado e populado (`php artisan migrate:fresh --seed`)
- Worker de fila rodando (`php artisan queue:listen --queue=notificacoes`)

