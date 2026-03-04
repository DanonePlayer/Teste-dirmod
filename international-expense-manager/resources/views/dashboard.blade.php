<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Despesas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto space-y-8">

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-blue-600">1. Cadastro de Usuário</h2>
            <form id="userForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="name" placeholder="Nome Completo" class="border p-2 rounded" required>
                <input type="email" name="email" placeholder="E-mail" class="border p-2 rounded" required>
                <input type="text" id="cpf" name="cpf" placeholder="CPF (000.000.000-00)" class="border p-2 rounded" required>
                <input type="text" id="zip_code" name="zip_code" placeholder="CEP" class="border p-2 rounded" required>
                <input type="password" name="password" placeholder="Senha" class="border p-2 rounded" required>
                <button type="submit" class="bg-blue-500 text-white font-bold p-2 rounded hover:bg-blue-600">Cadastrar</button>
            </form>
            <div id="userMsg" class="mt-2 font-bold text-sm"></div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-green-600">2. Nova Despesa</h2>
            <form id="expenseForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="number" name="user_id" id="logged_user_id" placeholder="ID Usuário (Ex: 1)" class="border p-2 rounded" required>
                <input type="text" name="description" placeholder="Descrição (Ex: Jantar)" class="border p-2 rounded" required>
                <input type="number" step="0.01" name="original_amount" placeholder="Valor (Ex: 50.00)" class="border p-2 rounded" required>
                <select name="currency" class="border p-2 rounded">
                    <option value="USD">Dólar (USD)</option>
                    <option value="EUR">Euro (EUR)</option>
                    <option value="GBP">Libra (GBP)</option>
                </select>
                <button type="submit" class="bg-green-500 text-white font-bold p-2 rounded hover:bg-green-600">Salvar Despesa</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-700">Minhas Despesas</h2>
                <button onclick="loadExpenses()" class="text-blue-500 underline">Atualizar Lista</button>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 border">Descrição</th>
                        <th class="p-3 border">Valor Original</th>
                        <th class="p-3 border">Moeda</th>
                        <th class="p-3 border">Cotação</th>
                        <th class="p-3 border bg-green-100">Valor BRL</th>
                    </tr>
                </thead>
                <tbody id="expenseTableBody">
                    </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('zip_code').addEventListener('blur', async (e) => {
            const cep = e.target.value.replace(/\D/g, '');
            if(cep.length === 8) {
                const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await res.json();
                if(!data.erro) {
                    document.getElementById('userMsg').innerText = `Endereço: ${data.logradouro}, ${data.bairro} - ${data.localidade}/${data.uf}`;
                    document.getElementById('userMsg').className = "mt-2 font-bold text-sm text-gray-600";
                }
            }
        });

        document.getElementById('userForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const res = await fetch('/api/users', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            const data = await res.json();
            const msg = document.getElementById('userMsg');
            if(res.ok) {
                msg.innerText = "Usuário cadastrado! Use o ID: " + data.user.id;
                msg.className = "mt-2 font-bold text-sm text-green-500";
                document.getElementById('logged_user_id').value = data.user.id;
            } else {
                msg.innerText = "Erro: " + data.error;
                msg.className = "mt-2 font-bold text-sm text-red-500";
            }
        });

        document.getElementById('expenseForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const res = await fetch('/api/expenses', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            if(res.ok) {
                alert("Despesa salva!");
                loadExpenses();
            } else {
                const data = await res.json();
                alert("Erro: " + data.error);
            }
        });

        async function loadExpenses() {
            const userId = document.getElementById('logged_user_id').value;
            if(!userId) return alert("Insira o ID do usuário para listar!");

            const res = await fetch('/api/expenses', {
                headers: { 'X-User-Id': userId }
            });
            const expenses = await res.json();
            const tbody = document.getElementById('expenseTableBody');
            tbody.innerHTML = '';

            expenses.forEach(ex => {
                tbody.innerHTML += `
                    <tr>
                        <td class="p-3 border">${ex.description}</td>
                        <td class="p-3 border">${ex.original_amount}</td>
                        <td class="p-3 border font-bold">${ex.currency}</td>
                        <td class="p-3 border text-gray-500">${ex.exchange_rate}</td>
                        <td class="p-3 border bg-green-50 font-bold text-green-700">R$ ${ex.converted_amount_brl}</td>
                    </tr>
                `;
            });
        }
    </script>
</body>
</html>
