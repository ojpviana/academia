<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Exercícios - Treinador GymPro</title>
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
                <h1 class="text-xl font-bold text-white uppercase tracking-wider">Gestão do Catálogo</h1>
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
            <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg overflow-hidden">
                <div class="px-4 md:px-6 py-4 border-b border-slate-700 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-700/30 gap-4 sm:gap-0">
                    <h2 class="text-lg font-bold text-white uppercase tracking-tight">Catálogo Cadastrado</h2>
                    <button onclick="abrirModalExercicio()" class="text-sm bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded-lg transition-colors font-bold w-full sm:w-auto text-center shadow-lg shadow-orange-900/20">
                        + Novo Exercício
                    </button>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-700">
                                <th class="px-6 py-4 font-bold">Grupo Muscular</th>
                                <th class="px-6 py-4 font-bold">Nome do Exercício</th>
                                <th class="px-6 py-4 font-bold">Mídia</th>
                                <th class="px-6 py-4 font-bold text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($exercicios as $ex)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-slate-700 text-slate-300 px-2 py-1 rounded text-xs font-bold border border-slate-600 uppercase tracking-widest">{{ $ex->grupo_muscular }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-white">{{ $ex->nome }}</span>
                                    @if($ex->descricao)
                                        <p class="text-xs text-slate-400 mt-1 truncate max-w-xs" title="{{ $ex->descricao }}">{{ $ex->descricao }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ex->video_url)
                                        <a href="{{ $ex->video_url }}" target="_blank" class="text-blue-400 hover:text-blue-300 text-xs font-bold underline flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Vídeo/GIF
                                        </a>
                                    @else
                                        <span class="text-slate-500 text-xs italic">Sem mídia</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex gap-2 justify-center">
                                        <button onclick="editarExercicio({{ json_encode($ex) }})" class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-slate-600">Editar</button>
                                        <form action="/treinador/exercicios/{{ $ex->id }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este exercício?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-red-500/30">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500 italic">Nenhum exercício cadastrado no catálogo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Novo/Editar Exercício -->
    <div id="modalExercicio" class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-2xl shadow-2xl relative">
            <button onclick="fecharModalExercicio()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 id="modalExercicioTitulo" class="text-2xl font-bold text-white mb-6">Cadastrar Exercício</h2>

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl mb-6 text-sm font-bold">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formExercicio" action="/treinador/exercicios" method="POST" class="space-y-4">
                @csrf
                <div id="methodExercicio"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nome do Exercício</label>
                        <input type="text" name="nome" id="exercicio_nome" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Grupo Muscular</label>
                        <select name="grupo_muscular" id="exercicio_grupo" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                            <option value="">Selecione...</option>
                            <option value="Peito">Peito</option>
                            <option value="Costas">Costas</option>
                            <option value="Ombros">Ombros</option>
                            <option value="Bíceps">Bíceps</option>
                            <option value="Tríceps">Tríceps</option>
                            <option value="Pernas">Pernas</option>
                            <option value="Abdômen">Abdômen</option>
                            <option value="Panturrilhas">Panturrilhas</option>
                            <option value="Cardio">Cardio</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">URL do Vídeo / GIF (Link Externo)</label>
                    <input type="url" name="video_url" id="exercicio_video_url" placeholder="https://youtube.com/... ou link do Giphy" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                    <p class="text-[10px] text-slate-500 mt-1">* Cole aqui o link de um vídeo no YouTube ou GIF externo mostrando a execução.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Descrição / Instruções (Opcional)</label>
                    <textarea name="descricao" id="exercicio_descricao" rows="3" placeholder="Instruções de execução, dicas de postura, etc." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 resize-none"></textarea>
                </div>

                <button type="submit" id="btnSalvarExercicio" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-4 rounded-xl mt-6 transition-all shadow-lg shadow-orange-900/20 uppercase tracking-widest">
                    Salvar Exercício
                </button>
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
                if(toast) {
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }
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

        window.addEventListener('click', function(e) {
            const menu = document.getElementById('menuPerfil');
            if (menu) {
                const botao = menu.previousElementSibling;
                if (botao && !botao.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            }
        });



        const modalEx = document.getElementById('modalExercicio');
        const formEx = document.getElementById('formExercicio');
        const methodEx = document.getElementById('methodExercicio');

        function abrirModalExercicio() {
            document.getElementById('modalExercicioTitulo').innerText = 'Cadastrar Exercício';
            formEx.action = '/treinador/exercicios';
            methodEx.innerHTML = '';
            
            document.getElementById('exercicio_nome').value = '';
            document.getElementById('exercicio_grupo').value = '';
            document.getElementById('exercicio_video_url').value = '';
            document.getElementById('exercicio_descricao').value = '';

            modalEx.classList.remove('hidden');
        }

        function editarExercicio(ex) {
            document.getElementById('modalExercicioTitulo').innerText = 'Editar Exercício';
            formEx.action = '/treinador/exercicios/' + ex.id;
            methodEx.innerHTML = '@method("PUT")';

            document.getElementById('exercicio_nome').value = ex.nome;
            document.getElementById('exercicio_grupo').value = ex.grupo_muscular;
            document.getElementById('exercicio_video_url').value = ex.video_url || '';
            document.getElementById('exercicio_descricao').value = ex.descricao || '';

            modalEx.classList.remove('hidden');
        }

        function fecharModalExercicio() {
            modalEx.classList.add('hidden');
        }
    </script>
</body>
</html>

