# Padrão de Análise de Commits

## 1ª Parte — Análise de Commits

Este documento define o **padrão oficial para análise de commits** do projeto.

O objetivo é:
- Analisar **todos os arquivos modificados**
- Identificar corretamente o **tipo de alteração**
- Gerar **mensagens de commit padronizadas**
- Organizar tudo em um único arquivo para revisão antes da aplicação dos commits

---

## Fluxo de Trabalho

1. Analisar todos os arquivos alterados
2. Descrever claramente o que mudou em cada arquivo
3. Classificar a mudança (simples ou complexa)
4. Sugerir o commit adequado seguindo o padrão abaixo
5. Consolidar tudo neste arquivo para validação

---

## Padrão de Commits (iuricode)

Referência oficial:
- https://github.com/iuricode/padroes-de-commits

## Padrões de emojis/Tipos de Commit 💈

<table>
  <thead>
    <tr>
      <th>Tipo do commit</th>
      <th>Emoji</th>
      <th>Palavra-chave</th>
    </tr>
  </thead>
 <tbody>
    <tr>
      <td>Acessibilidade</td>
      <td>♿ <code>:wheelchair:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Adicionando um teste</td>
      <td>✅ <code>:white_check_mark:</code></td>
      <td><code>test</code></td>
    </tr>
    <tr>
      <td>Atualizando a versão de um submódulo</td>
      <td>⬆️ <code>:arrow_up:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Retrocedendo a versão de um submódulo</td>
      <td>⬇️ <code>:arrow_down:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Adicionando uma dependência</td>
      <td>➕ <code>:heavy_plus_sign:</code></td>
      <td><code>build</code></td>
    </tr>
    <tr>
      <td>Alterações de revisão de código</td>
      <td>👌 <code>:ok_hand:</code></td>
      <td><code>style</code></td>
    </tr>
    <tr>
      <td>Animações e transições</td>
      <td>💫 <code>:dizzy:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Bugfix</td>
      <td>🐛 <code>:bug:</code></td>
      <td><code>fix</code></td>
    </tr>
    <tr>
      <td>Comentários</td>
      <td>💡 <code>:bulb:</code></td>
      <td><code>docs</code></td>
    </tr>
    <tr>
      <td>Commit inicial</td>
      <td>🎉 <code>:tada:</code></td>
      <td><code>init</code></td>
    </tr>
    <tr>
      <td>Configuração</td>
      <td>🔧 <code>:wrench:</code></td>
      <td><code>chore</code></td>
    </tr>
    <tr>
      <td>Deploy</td>
      <td>🚀 <code>:rocket:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Documentação</td>
      <td>📚 <code>:books:</code></td>
      <td><code>docs</code></td>
    </tr>
    <tr>
      <td>Em progresso</td>
      <td>🚧 <code>:construction:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Estilização de interface</td>
      <td>💄 <code>:lipstick:</code></td>
      <td><code>feat</code></td>
    </tr>
    <tr>
      <td>Infraestrutura</td>
      <td>🧱 <code>:bricks:</code></td>
      <td><code>ci</code></td>
    </tr>
    <tr>
      <td>Lista de ideias (tasks)</td>
      <td>🔜 <code> :soon: </code></td>
      <td></td>
    </tr>
    <tr>
      <td>Mover/Renomear</td>
      <td>🚚 <code>:truck:</code></td>
      <td><code>chore</code></td>
    </tr>
    <tr>
      <td>Novo recurso</td>
      <td>✨ <code>:sparkles:</code></td>
      <td><code>feat</code></td>
    </tr>
    <tr>
      <td>Package.json em JS</td>
      <td>📦 <code>:package:</code></td>
      <td><code>build</code></td>
    </tr>
    <tr>
      <td>Performance</td>
      <td>⚡ <code>:zap:</code></td>
      <td><code>perf</code></td>
    </tr>
    <tr>
        <td>Refatoração</td>
        <td>♻️ <code>:recycle:</code></td>
        <td><code>refactor</code></td>
    </tr>
    <tr>
      <td>Limpeza de Código</td>
      <td>🧹 <code>:broom:</code></td>
      <td><code>cleanup</code></td>
    </tr>
    <tr>
      <td>Removendo um arquivo</td>
      <td>🗑️ <code>:wastebasket:</code></td>
      <td><code>remove</code></td>
    </tr>
    <tr>
      <td>Removendo uma dependência</td>
      <td>➖ <code>:heavy_minus_sign:</code></td>
      <td><code>build</code></td>
    </tr>
    <tr>
      <td>Responsividade</td>
      <td>📱 <code>:iphone:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Revertendo mudanças</td>
      <td>💥 <code>:boom:</code></td>
      <td><code>fix</code></td>
    </tr>
    <tr>
      <td>Segurança</td>
      <td>🔒️ <code>:lock:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>SEO</td>
      <td>🔍️ <code>:mag:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Tag de versão</td>
      <td>🔖 <code>:bookmark:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Teste de aprovação</td>
      <td>✔️ <code>:heavy_check_mark:</code></td>
      <td><code>test</code></td>
    </tr>
    <tr>
      <td>Testes</td>
      <td>🧪 <code>:test_tube:</code></td>
      <td><code>test</code></td>
    </tr>
    <tr>
      <td>Texto</td>
      <td>📝 <code>:pencil:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Tipagem</td>
      <td>🏷️ <code>:label:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Tratamento de erros</td>
      <td>🥅 <code>:goal_net:</code></td>
      <td></td>
    </tr>
    <tr>
      <td>Dados</td>
      <td>🗃️ <code>:card_file_box:</code></td>
      <td><code>raw</code></td>
    </tr>
  </tbody>
</table>

---

## Regras para Mensagens de Commit

- Máximo de **50 caracteres** na mensagem principal
- Usar verbo no infinitivo (Criar, Adicionar, Atualizar, Remover)
- Evitar mensagens genéricas
- Um commit por responsabilidade

Quando houver **muitas alterações relacionadas**, usar:

- **Mensagem curta**
- **Descrição detalhada no corpo do commit**

---

## Exemplos Práticos

### Exemplo 1 — Criação de arquivo

**Arquivo:** `database/seeders/PartidaSeeder.php`

**Análise:**
Criação de seeder responsável por popular a tabela de partidas para ambiente de desenvolvimento e testes.

**Commit sugerido:**

```
🔧 :wrench: Criando seeder de partidas
```

---

### Exemplo 2 — Alteração simples (coluna)

**Arquivo:** `database/migrations/xxxx_add_quadro_numero_partidas.php`

**Análise:**
Adição da coluna `quadro_numero` para controle interno das partidas.

**Commit sugerido:**

```
🗃️ :card_file_box: Add coluna quadro_numero em partidas
```

---

### Exemplo 3 — Criação de Model

**Arquivo:** `app/Models/Atleta.php`

**Análise:**
Criação do model Atleta para representação dos dados de atletas no sistema.

**Commit sugerido:**

```
🗃️ :card_file_box: Criando model de Atleta
```

---

## 2ª Parte — Análise Profunda de Commits

Após a validação deste arquivo:

- Os commits serão **executados manualmente**
- Ajustes finos poderão ser feitos nas mensagens
- Commits simples podem usar apenas `:chore:` ou tipo equivalente
- Commits complexos terão análise técnica mais detalhada

---

## Observações Finais

- Alterações pequenas devem gerar commits pequenos
- Evitar misturar migration, model e regra de negócio no mesmo commit
- Clareza > quantidade
- Commits contam história do projeto

---

## 📋 ANÁLISE DE COMMITS - Sistema de Notificações de Pagamento

### 🗃️ Migrations

#### `database/migrations/2025_12_24_171848_create_clientes_table.php`
**Análise:** Criação da migration para tabela de clientes com campos: id, nome, email, telefone e timestamps.

**Commit sugerido:**
```
🗃️ Criar migration de clientes
```

#### `database/migrations/2025_12_24_171849_create_cobrancas_table.php`
**Análise:** Criação da migration para tabela de cobranças com relacionamentos para vendedores e clientes, campos de descrição, valor, data_vencimento e status.

**Commit sugerido:**
```
🗃️ Criar migration de cobranças
```

#### `database/migrations/2025_12_24_171851_create_notificacoes_pagamento_table.php`
**Análise:** Criação da migration para tabela de notificações de pagamento com campos de canal (email/sms), email, telefone, status e relacionamentos.

**Commit sugerido:**
```
🗃️ Criar migration de notificações pagamento
```

---

### 🗃️ Models

#### `app/Models/Cliente.php`
**Análise:** Criação do model Cliente com fillable e relacionamento hasMany para cobranças.

**Commit sugerido:**
```
🗃️ Criar model Cliente
```

#### `app/Models/Cobranca.php`
**Análise:** Criação do model Cobranca com fillable, casts e relacionamentos belongsTo para cliente e vendedor, e hasMany para notificações.

**Commit sugerido:**
```
🗃️ Criar model Cobranca
```

#### `app/Models/NotificacaoPagamento.php`
**Análise:** Criação do model NotificacaoPagamento com table name explícito, fillable incluindo email e telefone, casts e relacionamentos.

**Commit sugerido:**
```
🗃️ Criar model NotificacaoPagamento
```

#### `app/Models/User.php`
**Análise:** Adição de relacionamentos hasMany para cobrancas e notificacoes no model User.

**Commit sugerido:**
```
🗃️ Add relacionamentos em User model
```

---

### 🔧 Seeders

#### `database/seeders/ClienteSeeder.php`
**Análise:** Criação de seeder para popular tabela de clientes com 5 clientes de exemplo.

**Commit sugerido:**
```
🔧 Criar seeder de clientes
```

#### `database/seeders/CobrancaSeeder.php`
**Análise:** Criação de seeder para popular tabela de cobranças com 5 cobranças de exemplo vinculadas ao primeiro vendedor.

**Commit sugerido:**
```
🔧 Criar seeder de cobranças
```

#### `database/seeders/DatabaseSeeder.php`
**Análise:** Atualização do DatabaseSeeder para chamar ClienteSeeder e CobrancaSeeder após criar usuário.

**Commit sugerido:**
```
🔧 Atualizar DatabaseSeeder
```

---

### ✨ Controllers

#### `app/Http/Controllers/CobrancaController.php`
**Análise:** Criação do controller web para gerenciar cobranças com métodos index (listar), create (formulário) e store (criar).

**Commit sugerido:**
```
✨ Criar controller web de cobranças
```

#### `app/Http/Controllers/NotificacaoController.php`
**Análise:** Criação do controller web para gerenciar notificações com métodos index (histórico) e store (criar notificação).

**Commit sugerido:**
```
✨ Criar controller web de notificações
```

#### `app/Http/Controllers/Api/CobrancaController.php`
**Análise:** Criação do controller API para cobranças com métodos index (listar) e store (criar), retornando JSON padronizado.

**Commit sugerido:**
```
✨ Criar controller API de cobranças
```

#### `app/Http/Controllers/Api/NotificacaoController.php`
**Análise:** Criação do controller API para notificações com método store, tratamento de erros e respostas JSON padronizadas.

**Commit sugerido:**
```
✨ Criar controller API de notificações
```

---

### 🛡️ Form Requests

#### `app/Http/Requests/CobrancaRequest.php`
**Análise:** Criação de FormRequest para validação de criação de cobranças com regras, atributos e mensagens personalizadas em português.

**Commit sugerido:**
```
🛡️ Criar CobrancaRequest para validação
```

#### `app/Http/Requests/NotificacaoRequest.php`
**Análise:** Criação de FormRequest para validação de notificações com validação condicional de email (quando canal é email) e telefone (quando canal é sms).

**Commit sugerido:**
```
🛡️ Criar NotificacaoRequest para validação
```

---

### 🔧 Services

#### `app/Services/NotificacaoService.php`
**Análise:** Criação do service para gerenciar criação de notificações, validação de cobrança, obtenção de email/telefone do cliente quando não fornecido e enfileiramento de job.

**Commit sugerido:**
```
🔧 Criar NotificacaoService
```

#### `app/Services/ServicoEmail.php`
**Análise:** Criação do service para simulação de envio de email com log e retorno de sucesso simulado.

**Commit sugerido:**
```
🔧 Criar ServicoEmail
```

#### `app/Services/ServicoSMS.php`
**Análise:** Criação do service para simulação de envio de SMS com log e retorno de sucesso simulado.

**Commit sugerido:**
```
🔧 Criar ServicoSMS
```

---

### ⚙️ Jobs

#### `app/Jobs/EnviarNotificacaoJob.php`
**Análise:** Criação do job para processar envio de notificações em background com propriedades tries, timeout e backoff, tratamento de erros e atualização de status.

**Commit sugerido:**
```
⚙️ Criar EnviarNotificacaoJob
```

---

### 🛣️ Routes

#### `routes/web.php`
**Análise:** Adição de rotas web para cobranças (index, create, store) e notificações (store, index).

**Commit sugerido:**
```
🛣️ Adicionar rotas web do sistema
```

#### `routes/api.php`
**Análise:** Criação de arquivo de rotas API com endpoints para listar e criar cobranças, e criar notificações.

**Commit sugerido:**
```
🛣️ Criar rotas API do sistema
```

#### `bootstrap/app.php`
**Análise:** Atualização do bootstrap para incluir carregamento das rotas API.

**Commit sugerido:**
```
🛣️ Configurar bootstrap para rotas API
```

---

### 💄 Views

#### `resources/views/layouts/app.blade.php`
**Análise:** Criação do layout base com integração de Tailwind CSS, Flowbite, jQuery e Toastr.

**Commit sugerido:**
```
💄 Criar layout base da aplicação
```

#### `resources/views/cobrancas/index.blade.php`
**Análise:** Criação da view para listagem de cobranças pendentes com modal Flowbite para notificação e integração AJAX com Toastr.

**Commit sugerido:**
```
💄 Criar view de listagem de cobranças
```

#### `resources/views/cobrancas/create.blade.php`
**Análise:** Criação da view para formulário de criação de cobranças com validação e submissão via AJAX.

**Commit sugerido:**
```
💄 Criar view de criação de cobranças
```

#### `resources/views/notificacoes/index.blade.php`
**Análise:** Criação da view para histórico de notificações enviadas.

**Commit sugerido:**
```
💄 Criar view de histórico de notificações
```

---

### 🔧 Configurações

#### `config/app.php`
**Análise:** Atualização de timezone para America/Sao_Paulo com suporte a variável de ambiente.

**Commit sugerido:**
```
🔧 Configurar timezone para America/Sao_Paulo
```

#### `tailwind.config.js`
**Análise:** Criação/atualização da configuração do Tailwind CSS com plugin Flowbite e paths corretos.

**Commit sugerido:**
```
🔧 Configurar Tailwind com Flowbite
```

#### `package.json` e `package-lock.json`
**Análise:** Adição de dependências Flowbite e Toastr para frontend.

**Commit sugerido:**
```
📦 Adicionar dependências Flowbite e Toastr
```

#### `resources/js/app.js`
**Análise:** Atualização do app.js para importar Flowbite e Toastr.

**Commit sugerido:**
```
🔧 Configurar imports Flowbite e Toastr
```

#### `resources/css/app.css`
**Análise:** Atualização do CSS com diretivas do Tailwind.

**Commit sugerido:**
```
💄 Atualizar CSS com Tailwind
```

---

### 📚 Documentação

#### `README.md`
**Análise:** Atualização completa do README com documentação do sistema de notificações, instruções de setup, comandos e uso da API.

**Commit sugerido:**
```
📚 Atualizar README com documentação
```

#### `POSTMAN_DOCUMENTATION.md`
**Análise:** Criação de documentação completa da API para importação no Postman com exemplos de requisições e respostas.

**Commit sugerido:**
```
📚 Criar documentação da API Postman
```

#### `POSTMAN_IMPORT.md`
**Análise:** Criação de guia rápido para importação da collection no Postman.

**Commit sugerido:**
```
📚 Criar guia de importação Postman
```

#### `postman_collection.json`
**Análise:** Criação da collection completa do Postman com todos os endpoints, exemplos de requisição e resposta padronizados.

**Commit sugerido:**
```
📚 Criar collection Postman da API
```

---

## 📌 RESUMO DOS COMMITS SUGERIDOS

1. 🗃️ Criar migration de clientes
2. 🗃️ Criar migration de cobranças
3. 🗃️ Criar migration de notificações pagamento
4. 🗃️ Criar model Cliente
5. 🗃️ Criar model Cobranca
6. 🗃️ Criar model NotificacaoPagamento
7. 🗃️ Add relacionamentos em User model
8. 🔧 Criar seeder de clientes
9. 🔧 Criar seeder de cobranças
10. 🔧 Atualizar DatabaseSeeder
11. ✨ Criar controller web de cobranças
12. ✨ Criar controller web de notificações
13. ✨ Criar controller API de cobranças
14. ✨ Criar controller API de notificações
15. 🛡️ Criar CobrancaRequest para validação
16. 🛡️ Criar NotificacaoRequest para validação
17. 🔧 Criar NotificacaoService
18. 🔧 Criar ServicoEmail
19. 🔧 Criar ServicoSMS
20. ⚙️ Criar EnviarNotificacaoJob
21. 🛣️ Adicionar rotas web do sistema
22. 🛣️ Criar rotas API do sistema
23. 🛣️ Configurar bootstrap para rotas API
24. 💄 Criar layout base da aplicação
25. 💄 Criar view de listagem de cobranças
26. 💄 Criar view de criação de cobranças
27. 💄 Criar view de histórico de notificações
28. 🔧 Configurar timezone para America/Sao_Paulo
29. 🔧 Configurar Tailwind com Flowbite
30. 📦 Adicionar dependências Flowbite e Toastr
31. 🔧 Configurar imports Flowbite e Toastr
32. 💄 Atualizar CSS com Tailwind
33. 📚 Atualizar README com documentação
34. 📚 Criar documentação da API Postman
35. 📚 Criar guia de importação Postman
36. 📚 Criar collection Postman da API

---

## ✅ COMMITS EXECUTADOS

Todos os 36 commits foram criados com sucesso seguindo o padrão estabelecido.

**Total de commits:** 36

**Distribuição por tipo:**
- 🗃️ Migrations e Models: 7 commits
- 🔧 Services, Seeders e Configurações: 9 commits
- ✨ Controllers: 4 commits
- 🛡️ Form Requests: 2 commits
- ⚙️ Jobs: 1 commit
- 🛣️ Rotas: 3 commits
- 💄 Views: 4 commits
- 📦 Dependências: 1 commit
- 📚 Documentação: 5 commits

**Status:** ✅ Todos os arquivos foram commitados seguindo o padrão de 1 emoji por commit.

---

📌 **Este arquivo serve como base oficial para análise e organização dos commits do projeto.**
