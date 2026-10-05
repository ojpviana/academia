<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GymPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen font-sans relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-orange-500/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-500/10 rounded-full blur-[100px]"></div>

    <div class="bg-slate-800 border border-slate-700 p-10 rounded-2xl w-full max-w-md shadow-2xl relative z-10">

        <div class="flex flex-col items-center justify-center mb-8">
            <div class="bg-orange-500 p-3 rounded-xl mb-4 shadow-lg shadow-orange-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
            <h1 class="text-3xl font-black text-white tracking-widest uppercase">GymPro</h1>

        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-3 rounded-lg mb-6 text-sm text-center font-medium">
                Credenciais inválidas. Tente novamente.
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">E-mail ou Matrícula</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="email" name="email" required autofocus autocomplete="off"
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" required autocomplete="new-password"
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-slate-400 cursor-pointer hover:text-white transition-colors">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-slate-700 bg-slate-900 text-orange-500 focus:ring-orange-500">
                    Lembrar de mim
                </label>
                <a href="#" class="text-sm text-orange-400 hover:text-orange-300 font-medium">Esqueceu a senha?</a>
            </div>

            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3.5 rounded-lg transition-all uppercase tracking-widest shadow-lg shadow-orange-900/50 mt-2">
                Entrar no Sistema
            </button>
        </form>
    </div>

</body>
</html>
