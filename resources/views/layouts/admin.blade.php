<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - GymPro')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-900 text-slate-300 font-sans flex h-screen overflow-hidden relative w-full">

    <div id="sidebar-overlay" onclick="toggleMobileMenu()" class="fixed inset-0 bg-slate-900/80 z-30 hidden transition-opacity md:hidden"></div>

    <aside id="sidebar" class="fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 h-full">
        <div class="h-16 flex items-center px-6 border-b border-slate-700 shrink-0">
            <div class="bg-orange-500 p-2 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
            <span class="text-white font-bold text-xl tracking-wider">GymPro</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="/admin/dashboard" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admin/dashboard') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500' : 'hover:bg-slate-700 text-slate-400 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                Dashboard
            </a>

                                    <button x-data @click="$dispatch('abrir-modal-aluno-novo')" class="w-full flex items-center px-4 py-3 hover:bg-slate-700 text-slate-400 hover:text-white rounded-lg transition-colors text-left">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                Cadastrar Aluno
            </button>
            <button x-data @click="$dispatch('abrir-modal-treinador-novo')" class="w-full flex items-center px-4 py-3 hover:bg-slate-700 text-slate-400 hover:text-white rounded-lg transition-colors text-left">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Cadastrar Treinador
            </button>

            <a href="/admin/financeiro" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admin/financeiro') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500' : 'hover:bg-slate-700 text-slate-400 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Financeiro
            </a>

            <a href="/admin/modalidades" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admin/modalidades*') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500' : 'hover:bg-slate-700 text-slate-400 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                Turmas e Modalidades
            </a>

            <a href="/admin/loja" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admin/loja*') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500' : 'hover:bg-slate-700 text-slate-400 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                Vitrine / Produtos
            </a>

            <a href="/admin/configuracoes" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admin/configuracoes') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500' : 'hover:bg-slate-700 text-slate-400 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Configurações
            </a>

            <a href="/admin/radar" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->is('admin/radar') ? 'bg-slate-700 text-red-400 border-l-4 border-red-500 font-bold' : 'hover:bg-slate-700 text-slate-400 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Radar de Retenção
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full relative bg-slate-900">
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-4 md:px-8 z-10 shrink-0">
            <div class="flex items-center">
                <button onclick="toggleMobileMenu()" class="md:hidden text-slate-400 hover:text-white mr-4 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-bold text-white uppercase tracking-wider">@yield('header_title', 'Dashboard')</h1>
            </div>

            <div class="relative">
                <button onclick="toggleMenuPerfil()" class="flex items-center space-x-3 focus:outline-none hover:opacity-80 transition-opacity">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm text-white font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-orange-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="h-10 w-10 bg-slate-700 rounded-full flex items-center justify-center border border-slate-600 shadow-lg">
                        <span class="text-white font-bold text-sm">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                    </div>
                </button>

                <div id="menuPerfil" class="hidden absolute right-0 mt-3 w-48 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl z-50 overflow-hidden">
                    <div class="py-1">
                        <button onclick="abrirModalSenhaGlob()" class="w-full text-left px-4 py-3 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Trocar Senha
                        </button>
                        <div class="border-t border-slate-700/50"></div>

                        <a href="/logout" class="block px-4 py-3 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Sair do Sistema
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-4 md:p-8 space-y-6">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleMobileMenu() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }

        
        function abrirModalSenhaGlob() {
            if(window.abrirModalSenha) {
                window.abrirModalSenha();
                toggleMenuPerfil();
            } else {
                window.location.href = "/admin/dashboard?open_senha=1";
            }
        }
        function toggleMenuPerfil() {
            document.getElementById('menuPerfil').classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const menu = document.getElementById('menuPerfil');
            if (menu && !menu.classList.contains('hidden')) {
                const btn = menu.previousElementSibling;
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            }
        });
    </script>
    @yield('scripts')
    

    @include('admin.partials.modais_globais')
</body>
</html>



