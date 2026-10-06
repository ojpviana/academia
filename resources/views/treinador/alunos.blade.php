<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Alunos - Treinador GymPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-300 font-sans flex flex-col md:flex-row h-screen overflow-hidden relative w-full">

    <div id="sidebar-overlay" onclick="toggleMenu()" class="fixed inset-0 bg-slate-900/80 z-30 hidden transition-opacity md:hidden"></div>

    @include('treinador.partials.sidebar')

    <main class="flex-1 flex flex-col h-screen overflow-y-auto w-full relative">
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-4 md:px-8 z-10 shrink-0">
            <div class="flex items-center">
                <button onclick="toggleMenu()" class="md:hidden text-slate-400 hover:text-white mr-4 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-bold text-white uppercase tracking-wider">Meus Alunos</h1>
            </div>

            <div class="flex items-center relative">
                <button onclick="toggleMenuPerfil()" class="flex items-center space-x-3 focus:outline-none hover:opacity-80 transition-opacity">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm text-white font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-orange-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="h-10 w-10 bg-slate-700 rounded-full flex items-center justify-center border border-slate-600 shadow-lg">
                        <span class="text-white font-bold text-sm uppercase">{{ substr(Auth::user()->name, 0, 2) }}</span>
                    </div>
                </button>

                <div id="menuPerfil" class="hidden absolute top-12 right-0 mt-2 w-48 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl z-50 overflow-hidden">
                    <div class="py-1">
                        <a href="/logout" class="block px-4 py-3 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Sair do Sistema
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-4 md:p-8 space-y-6">
            <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg overflow-hidden flex flex-col">
                <div class="px-4 md:px-6 py-4 border-b border-slate-700 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-700/30 gap-4 sm:gap-0">
                    <h2 class="text-lg font-bold text-white uppercase tracking-tight">Lista Completa ({{ $atletas->count() }})</h2>
                    <input type="text" id="filtroAlunos" placeholder="Pesquisar por nome..." class="w-full sm:w-1/3 bg-slate-900 border border-slate-600 rounded-lg p-2 text-sm text-white focus:outline-none focus:border-orange-500 transition-colors">
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-700">
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold">Nome do Aluno</th>
                                <th class="px-6 py-4 font-bold">Idade</th>
                                <th class="px-6 py-4 font-bold text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaAlunos" class="divide-y divide-slate-700">
                            @forelse($atletas as $atleta)
                                @php 
                                    $presente = in_array($atleta->idAtleta, $alunosPresentesIds);
                                @endphp
                                <tr class="hover:bg-slate-700/30 transition-colors item-aluno" data-nome="{{ strtolower($atleta->nome) }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($presente)
                                            <span class="bg-green-500/10 text-green-400 px-2 py-1 rounded text-xs font-bold border border-green-500/20 flex items-center inline-flex">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2 animate-pulse"></span> Presente
                                            </span>
                                        @else
                                            <span class="bg-slate-700 text-slate-400 px-2 py-1 rounded text-xs font-bold border border-slate-600 inline-flex">
                                                Ausente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                                <div class="font-bold text-white capitalize">{{ $atleta->nome }}</div>
                                        @php
                                            $obj = $atleta->objetivo;
                                            if (!$obj && is_array($atleta->anamnese) && isset($atleta->anamnese['objetivo'])) {
                                                $obj = $atleta->anamnese['objetivo'];
                                            }
                                            $obj = $obj ?: 'N�o definido';
                                        @endphp
                                        <div class="mt-2">
                                            <span class="bg-blue-900 text-blue-300 text-xs px-2 py-1 rounded-full border border-blue-700 font-medium">
                                                Alvo: {{ $obj }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">
                                        {{ $atleta->idade }} anos
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="/treinador?atleta={{ $atleta->idAtleta }}&nome={{ urlencode($atleta->nome) }}&objetivo={{ urlencode($obj) }}" class="inline-block bg-orange-600 hover:bg-orange-500 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-colors shadow shadow-orange-900/20">
                                            Abrir Ficha
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500 italic">Nenhum aluno vinculado a você.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleMenuPerfil() {
            document.getElementById('menuPerfil').classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const menu = document.getElementById('menuPerfil');
            if (menu) {
                const botao = menu.previousElementSibling;
                if (botao && !botao.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            }
        });

        // Filtro da tabela
        document.getElementById('filtroAlunos').addEventListener('input', function() {
            const val = this.value.toLowerCase();
            const linhas = document.querySelectorAll('.item-aluno');
            linhas.forEach(linha => {
                if (linha.getAttribute('data-nome').includes(val)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

