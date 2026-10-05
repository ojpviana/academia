<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Academia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-6">Painel do Atleta - Gerenciamento de Treinos</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold border-b pb-2 mb-4">Treinos da Semana</h2>
                <p class="text-gray-600">Nenhum treino agendado ainda.</p>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h2 class="font-bold border-b pb-2 mb-4">Minhas Metas</h2>
                <p class="text-gray-600">Defina suas metas com o treinador.</p>
            </div>
        </div>
    </div>
</body>
</html>
