<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Templates - GymPro</title>
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
                <h1 class="text-xl font-bold text-white uppercase tracking-wider">Meus Templates</h1>
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
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-lg font-bold text-white uppercase tracking-tight">Gerenciamento de Templates</h2>
                <button onclick="abrirModalNovoTemplate()" class="bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-lg shadow-orange-900/20 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Novo Template
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($templates as $template)
                    <div class="bg-slate-800 border border-slate-700 rounded-xl p-5 shadow-lg flex flex-col h-full hover:border-slate-500 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-bold text-white">{{ $template->nome_template }}</h3>
                            <span class="bg-slate-700 text-slate-300 text-xs px-2 py-1 rounded-full border border-slate-600">{{ $template->exercicios->count() }} Exercícios</span>
                        </div>
                        <p class="text-sm text-slate-400 mb-4 flex-1">{{ $template->descricao ?: 'Sem descrição' }}</p>
                        
                        <div class="border-t border-slate-700 pt-4 mt-auto flex justify-between items-center">
                            <form action="/treinador/templates/{{ $template->id }}" method="POST" onsubmit="return confirm('Deseja excluir este template?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">Excluir</button>
                            </form>
                            <a href="/treinador/templates/{{ $template->id }}/editar" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-1.5 rounded-lg text-sm font-bold border border-slate-600 hover:border-slate-500 transition-colors shadow-sm">
                                Editar Exercícios
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-slate-800/50 border border-slate-700 rounded-xl p-10 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-700 text-slate-400 mb-4">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">Nenhum template criado</h3>
                        <p class="text-slate-400 text-sm max-w-md mx-auto">Os templates permitem salvar conjuntos de exercícios para importar rapidamente para a ficha dos seus alunos.</p>
                        <button onclick="abrirModalNovoTemplate()" class="mt-6 bg-orange-600 hover:bg-orange-500 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-colors shadow-lg shadow-orange-900/20 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Criar Primeiro Template
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Modal Novo Template -->
    <div id="modalNovoTemplate" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-6 md:p-8 rounded-2xl w-full max-w-md shadow-2xl relative">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white">Criar Novo Template</h2>
                <button type="button" onclick="fecharModalNovoTemplate()" class="text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="/treinador/templates" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nome do Template</label>
                    <input type="text" name="nome_template" required placeholder="Ex: Adaptação Iniciante" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Descrição (Opcional)</label>
                    <textarea name="descricao" rows="3" placeholder="Ex: Treino fullbody para as duas primeiras semanas." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors"></textarea>
                </div>
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-lg mt-2 transition-all shadow-lg shadow-orange-900/20">Criar Template</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div id="toast-sucesso" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transition-all duration-500 transform translate-y-0 opacity-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-sucesso');
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        </script>
    @endif

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

        function abrirModalNovoTemplate() {
            document.getElementById('modalNovoTemplate').classList.remove('hidden');
        }

        function fecharModalNovoTemplate() {
            document.getElementById('modalNovoTemplate').classList.add('hidden');
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
    </script>
</body>
</html>

