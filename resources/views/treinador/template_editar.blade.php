<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Template - GymPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-300 font-sans flex flex-col md:flex-row h-screen overflow-hidden relative w-full">

    <div id="sidebar-overlay" onclick="toggleMenu()" class="fixed inset-0 bg-slate-900/80 z-30 hidden transition-opacity md:hidden"></div>

    @include('treinador.partials.sidebar')

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-slate-900 w-full relative">
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-4 md:px-8 z-10 shrink-0">
            <div class="flex items-center">
                <button onclick="toggleMenu()" class="md:hidden text-slate-400 hover:text-white mr-4 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center space-x-3">
                    <a href="/treinador/templates" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <h1 class="text-xl font-bold text-white uppercase tracking-wider">Editor: {{ $template->nome_template }}</h1>
                </div>
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

        <div class="p-4 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">
            <div class="lg:col-span-5">
                <div class="bg-slate-800 p-6 md:p-8 rounded-2xl shadow-lg border border-slate-700">
                    <h2 class="font-bold text-white mb-6 text-base md:text-lg border-b border-slate-700 pb-2">1. Vincular Novo Exercício ao Template</h2>

                    <form action="/treinador/templates/{{ $template->id }}/exercicios" method="POST" class="space-y-4 md:space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Exercício do Catálogo</label>
                            <select name="exercicio_id" class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:outline-none focus:border-orange-500 transition-colors" required>
                                @foreach($exercicios as $ex)
                                    <option value="{{ $ex->id }}">[{{ $ex->grupo_muscular }}] {{ $ex->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Séries</label>
                                <input type="text" name="series" placeholder="Ex: 4" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Repetições</label>
                                <input type="text" name="repeticoes" placeholder="Ex: 10 a 12" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Divisão (Dia do Treino)</label>
                            <select name="dia_semana" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors" required>
                                <option value="Treino A">Treino A</option>
                                <option value="Treino B">Treino B</option>
                                <option value="Treino C">Treino C</option>
                                <option value="Treino D">Treino D</option>
                                <option value="Treino E">Treino E</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 md:py-4 rounded-xl transition-all shadow-lg shadow-orange-900/20 mt-2 md:mt-4 text-base md:text-lg">
                            + Adicionar ao Template
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 flex flex-col min-h-[400px] md:min-h-[500px] h-full overflow-hidden">
                    <div class="bg-slate-700/30 px-4 md:px-8 py-4 md:py-5 border-b border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
                        <h2 class="font-bold text-white text-base md:text-lg">2. Exercícios do Template</h2>
                        <span class="bg-slate-700 text-slate-400 border border-slate-600 px-3 py-1 rounded-full text-xs font-bold truncate max-w-full">
                            {{ $template->exercicios->count() }} Exercício(s)
                        </span>
                    </div>

                    <div class="p-4 md:p-8 flex-1">
                        @if($template->exercicios->isEmpty())
                            <div class="h-full flex flex-col items-center justify-center text-slate-500 space-y-4 py-10">
                                <svg class="w-12 h-12 md:w-16 md:h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <p class="text-center font-medium text-sm md:text-base">Este template está vazio.<br>Adicione exerc�cios usando o formulário.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse min-w-[500px]">
                                    <thead>
                                        <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-700">
                                            <th class="py-3 px-4 font-bold">Exercício</th>
                                            <th class="py-3 px-4 font-bold">Séries/Reps</th>
                                            <th class="py-3 px-4 font-bold">Treino</th>
                                            <th class="py-3 px-4 text-right font-bold">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-700/50">
                                        @foreach($template->exercicios as $item)
                                            <tr class="hover:bg-slate-700/30 transition-colors">
                                                <td class="py-4 px-4 whitespace-nowrap">
                                                    <span class="font-bold text-white block">{{ $item->exercicio->nome }}</span>
                                                    <span class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-700 px-2 py-1 rounded mt-1 inline-block border border-slate-600">{{ $item->exercicio->grupo_muscular }}</span>
                                                </td>
                                                <td class="py-4 px-4 text-slate-300 font-medium whitespace-nowrap">{{ $item->series }} <span class="text-slate-500 mx-1">x</span> {{ $item->repeticoes }}</td>
                                                <td class="py-4 px-4 whitespace-nowrap">
                                                    <span class="bg-blue-500/10 text-blue-400 px-2 py-1 rounded text-xs font-bold border border-blue-500/20">{{ $item->dia_semana }}</span>
                                                </td>
                                                <td class="py-4 px-4 text-right">
                                                    <form action="/treinador/templates/{{ $template->id }}/exercicios/{{ $item->id }}" method="POST" class="inline-block" onsubmit="return confirm('Remover exercício do template?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-red-500/30">Excluir</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

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
    
    @if($errors->any())
        <div id="toast-erro" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transition-all duration-500 transform translate-y-0 opacity-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $errors->first() }}
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-erro');
                if(toast) {
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000);
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

