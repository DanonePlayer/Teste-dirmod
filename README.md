# International Expense Manager - API

Este projeto é uma API para gerenciamento de despesas internacionais, com conversão automática de moedas e validações de domínio (CPF/CEP).

## 🚀 Como Executar o Projeto

1. Clone o repositório
2. Instale as dependências: `composer install`
3. Configure o `.env` e rode as migrations: `php artisan migrate`
4. Inicie o servidor: `php artisan serve`

---

## 🛠 Guia de Uso da API (Endpoints)

### 1. Criar Novo Usuário
**POST** `[/api/users](http://127.0.0.1:8000/api/users)`

**Exemplo de Body:**
```json
{
    "name": "João Silva",
    "email": "joao@exemplo.com",
    "cpf": "N.CPF",
    "zip_code": "69901154",
    "password": "senha_segura"
}
```


### 2. Registrar Despesa (Com Conversão)

**POST** `[api/expenses](http://localhost:8000/api/expenses)`

```json
{
    "user_id": 1, 
    "description": "Hospedagem em Buenos Aires",
    "original_amount": 150.00,
    "currency": "USD"
}
```


### 3. Listagem de Despesas (Privacidade)

**GET** `[api/expenses](http://localhost:8000/api/expenses)`

Header = X-User-Id

Valor = 1

Descrição = ID do usuário que está requisitando (Simulação de Auth)


