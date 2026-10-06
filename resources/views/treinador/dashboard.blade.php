<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Treinador - GymPro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-300 font-sans flex flex-col md:flex-row h-screen overflow-hidden relative w-full">

    <div id="sidebar-overlay" onclick="toggleMenu()" class="fixed inset-0 bg-slate-900/80 z-30 hidden transition-opacity md:hidden"></div>

    <aside id="sidebar" class="fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 h-full">
        <div class="h-16 flex items-center px-6 border-b border-slate-700">
            <div class="bg-orange-500 p-2 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
            <span class="text-white font-bold text-xl tracking-wider uppercase italic">Painel do Treinador</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">


            <a href="/treinador" class="flex items-center px-4 py-3 bg-slate-700 text-orange-400 rounded-lg border-l-4 border-orange-500 font-bold shadow-lg mb-2">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Prescrever Treinos
            </a>

            <a href="/treinador/alunos" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition-all border border-slate-700 mb-2">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Meus Alunos
            </a>

            <div class="mt-4">
                <div class="px-4 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center justify-between">
                    <span>Alunos Presentes</span>
                    <span class="bg-orange-500/20 text-orange-400 px-2 py-0.5 rounded-full">{{ $alunosPresentes->count() }}</span>
                </div>

                <div class="flex-col space-y-1 px-2 mt-2">
                    @forelse($alunosPresentes as $atleta)
                        @php
    $obj = $atleta->objetivo;
    if (!$obj && is_array($atleta->anamnese) && isset($atleta->anamnese['objetivo'])) {
        $obj = $atleta->anamnese['objetivo'];
    }
    $obj = $obj ?: 'N�o definido';
@endphp
<button onclick="carregarAlunoPelaLista('{{ $atleta->idAtleta }}', '{{ $atleta->nome }}', '{{ addslashes($obj) }}')" class="w-full flex items-center px-3 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-orange-400 rounded-lg transition-all border border-transparent hover:border-slate-700">
                            <div class="w-2 h-2 rounded-full bg-green-500 mr-3 animate-pulse"></div>
                            <span class="truncate capitalize">{{ $atleta->nome }}</span>
                        </button>
                    @empty
                        <span class="text-xs text-slate-500 italic px-3 py-2 block">Nenhum aluno presente no momento.</span>
                    @endforelse
                </div>
            </div>

            <a href="/treinador/exercicios" class="flex items-center px-4 py-3 hover:bg-slate-700 text-slate-400 hover:text-white rounded-lg transition-colors border border-transparent hover:border-slate-700 mt-2">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Catálogo de Exerc�cios
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-slate-900 w-full relative">
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center justify-between px-4 md:px-8 z-10 shrink-0">
            <div class="flex items-center">
                <button onclick="toggleMenu()" class="md:hidden text-slate-400 hover:text-white mr-4 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-bold text-white uppercase tracking-wider">Gestǜo de Fichas</h1>
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
                        <button onclick="abrirModalSenha(); toggleMenuPerfil();" class="w-full text-left px-4 py-3 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition-colors flex items-center">
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

        <div class="p-4 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">
            <div class="lg:col-span-5">
                <div class="bg-slate-800 p-6 md:p-8 rounded-2xl shadow-lg border border-slate-700">
                    <h2 class="font-bold text-white mb-6 text-base md:text-lg border-b border-slate-700 pb-2">1. Vincular Novo Exerc�cio</h2>

                    <form action="/treinador/salvar" method="POST" class="space-y-4 md:space-y-5" onsubmit="return validarFicha(event)">
                        @csrf

                        <div class="relative">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Buscar Atleta</label>
                            <input type="text" id="searchAtletaTreinador" placeholder="Digite 3 letras para buscar..." class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:outline-none focus:border-orange-500 transition-colors" autocomplete="off">
                            <input type="hidden" name="atleta_id" id="atletaIdTreinador" required>

                            <ul id="dropdownAtletasTreinador" class="absolute z-[101] w-full bg-slate-800 border border-slate-600 mt-1 rounded-lg shadow-2xl max-h-48 overflow-y-auto hidden">
                                @foreach($atletas as $atleta)
                                    @php
    $obj = $atleta->objetivo;
    if (!$obj && is_array($atleta->anamnese) && isset($atleta->anamnese['objetivo'])) {
        $obj = $atleta->anamnese['objetivo'];
    }
    $obj = $obj ?: 'N�o definido';
@endphp
<li class="px-4 py-3 hover:bg-slate-700 cursor-pointer text-slate-300 font-medium border-b border-slate-700/50 last:border-0 transition-colors" data-id="{{ $atleta->idAtleta }}" data-nome="{{ strtolower($atleta->nome) }}" data-objetivo="{{ htmlspecialchars($obj, ENT_QUOTES) }}">
                                        {{ $atleta->nome }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Exerc�cio do Catálogo</label>
                            <select name="exercicio_id" class="w-full bg-slate-700 border border-slate-600 rounded-lg p-3 text-white focus:outline-none focus:border-orange-500 transition-colors" required>
                                @foreach($exercicios as $ex)
                                    <option value="{{ $ex->id }}">[{{ $ex->grupo_muscular }}] {{ $ex->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">SǸries</label>
                                <input type="text" name="series" placeholder="Ex: 4" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Repeti�es</label>
                                <input type="text" name="repeticoes" placeholder="Ex: 10 a 12" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Divisǜo (Dia do Treino)</label>
                            <select name="dia_semana" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors" required>
                                <option value="Treino A">Treino A (Peito/Tr�ceps/Ombro)</option>
                                <option value="Treino B">Treino B (Costas/B�ceps)</option>
                                <option value="Treino C">Treino C (Pernas Completas)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 md:py-4 rounded-xl transition-all shadow-lg shadow-orange-900/20 mt-2 md:mt-4 text-base md:text-lg">
                            + Adicionar � Ficha
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 flex flex-col min-h-[400px] md:min-h-[500px] h-full overflow-hidden">
                    <div class="bg-slate-700/30 px-4 md:px-8 py-4 md:py-5 border-b border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
                        <h2 class="font-bold text-white text-base md:text-lg">2. Ficha Atual do Aluno</h2>
                        <div class="flex items-center space-x-3">
                            <span id="objetivo-aluno-label" class="hidden bg-indigo-900 text-indigo-300 border border-indigo-700 px-3 py-1 rounded-full text-xs md:text-sm font-bold truncate max-w-full"><svg class="w-3 h-3 md:w-4 md:h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> <span class="obj-text"></span></span>
                            <span id="nome-aluno-label" class="bg-slate-700 text-slate-400 border border-slate-600 px-3 py-1 rounded-full text-xs md:text-sm font-bold truncate max-w-full">Nenhum selecionado</span>
                            <button id="btn-Avaliações" onclick="abrirModalAvaliacao()" class="hidden bg-orange-600 hover:bg-orange-500 text-white px-4 py-1.5 rounded-lg text-sm font-bold transition-colors shadow-lg shadow-orange-900/20">Avalia�es</button>
                        </div>
                    </div>

                    <div id="lista-treinos" class="p-4 md:p-8 flex-1">
                        <div class="h-full flex flex-col items-center justify-center text-slate-500 space-y-4 py-10">
                            <svg class="w-12 h-12 md:w-16 md:h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p class="text-center font-medium text-sm md:text-base">Selecione um aluno na lista<br>para visualizar os exerc�cios.</p>
                        </div>
                    </div>

                    <div id="area-feedbacks" class="p-4 md:p-8 border-t border-slate-700 bg-slate-800/80 hidden">
                        <h3 class="text-orange-400 font-bold mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                            �sltimas Observa�es do Aluno
                        </h3>
                        <div id="lista-feedbacks" class="space-y-3">
                            <!-- O JavaScript vai injetar os avisos aqui dentro -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalSenha" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-sm shadow-2xl relative">
            <button onclick="fecharModalSenha()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                Redefinir Senha
            </h2>

            @if(session('success_password'))
                <div class="bg-green-500/10 border border-green-500/50 text-green-400 p-3 rounded-lg mb-4 text-sm">{{ session('success_password') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-3 rounded-lg mb-4 text-sm">{{ $errors->first() }}</div>
            @endif

            <form action="/perfil/trocar-senha" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Senha Atual</label>
                    <input type="password" name="current_password" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nova Senha</label>
                    <input type="password" name="new_password" required minlength="6" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Confirme a Nova Senha</label>
                    <input type="password" name="new_password_confirmation" required minlength="6" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                </div>
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-lg mt-2 transition-all shadow-lg shadow-orange-900/20">Atualizar Senha</button>
            </form>
        </div>
    </div>

    <!-- Modal Avalia�ǜo F�sica -->
    <div id="modalAvaliacao" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4 py-6">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl w-full max-w-5xl shadow-2xl relative flex flex-col max-h-full">
            <div class="p-4 md:p-6 border-b border-slate-700 flex justify-between items-center shrink-0">
                <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Avalia�es F�sicas: <span id="modalAvaliacaoNomeAluno" class="ml-2 text-orange-400 capitalize"></span>
                </h2>
                <button onclick="fecharModalAvaliacao()" class="text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 md:p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Nova Avalia�ǜo Form -->
                <div>
                    <h3 class="font-bold text-white mb-4 text-base border-b border-slate-700 pb-2">Nova Avalia�ǜo</h3>
                    <form id="formNovaAvaliacao" class="space-y-4" onsubmit="salvarNovaAvaliacao(event)">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Data da Avalia�ǜo</label>
                            <input type="date" name="data_avaliacao" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Peso (kg)</label>
                                <input type="number" step="0.01" name="peso" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Altura (cm)</label>
                                <input type="number" step="0.01" name="altura" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">B.F. (%)</label>
                                <input type="number" step="0.01" name="bf_percentual" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">M. Magra (kg)</label>
                                <input type="number" step="0.01" name="massa_magra_kg" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-700">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">T�rax (cm)</label>
                                <input type="number" step="0.01" name="medida_torax" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Cintura (cm)</label>
                                <input type="number" step="0.01" name="medida_cintura" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Abd�men (cm)</label>
                                <input type="number" step="0.01" name="medida_abdomen" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Quadril (cm)</label>
                                <input type="number" step="0.01" name="medida_quadril" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Bra�o Dir. (cm)</label>
                                <input type="number" step="0.01" name="medida_braco_dir" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Bra�o Esq. (cm)</label>
                                <input type="number" step="0.01" name="medida_braco_esq" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Coxa Dir. (cm)</label>
                                <input type="number" step="0.01" name="medida_coxa_dir" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Coxa Esq. (cm)</label>
                                <input type="number" step="0.01" name="medida_coxa_esq" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Pant. Dir. (cm)</label>
                                <input type="number" step="0.01" name="medida_panturrilha_dir" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Pant. Esq. (cm)</label>
                                <input type="number" step="0.01" name="medida_panturrilha_esq" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Observa�es</label>
                            <textarea name="observacoes_gerais" rows="2" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-2.5 focus:outline-none focus:border-orange-500 transition-colors"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-lg transition-all shadow-lg shadow-orange-900/20">
                            Salvar Avalia�ǜo
                        </button>
                    </form>
                </div>

                <!-- Hist�rico de Avalia�es -->
                <div class="flex flex-col border-t lg:border-t-0 lg:border-l border-slate-700 lg:pl-8 pt-8 lg:pt-0">
                    <h3 class="font-bold text-white mb-4 text-base border-b border-slate-700 pb-2">Histórico (Mais Recentes)</h3>
                    <div id="lista-Avaliações-modal" class="flex-1 overflow-y-auto pr-2 space-y-4">
                        <!-- Conteǧdo injetado via JS -->
                    </div>
                </div>
            </div>
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
        // Scripts originais do painel
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Novos scripts do Modal e Dropdown de Perfil
        function toggleMenuPerfil() { document.getElementById('menuPerfil').classList.toggle('hidden'); }
        function abrirModalSenha() { document.getElementById('modalSenha').classList.remove('hidden'); }
        function fecharModalSenha() { document.getElementById('modalSenha').classList.add('hidden'); }


        window.addEventListener('click', function(e) {
            const menu = document.getElementById('menuPerfil');
            const botao = menu.previousElementSibling;
            if (botao && !botao.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Reabre caso haja erro de valida�ǜo do Laravel
        @if(session('success_password') || $errors->has('current_password') || $errors->has('new_password'))
            abrirModalSenha();
        @endif

        // ----------------------------------------------------
        // MOTOR DO AUTOCOMPLETE - TREINADOR
        // ----------------------------------------------------
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchAtletaTreinador');
            const hiddenInput = document.getElementById('atletaIdTreinador');
            const dropdown = document.getElementById('dropdownAtletasTreinador');

            if(searchInput && dropdown) {
                const items = dropdown.querySelectorAll('li');

                searchInput.addEventListener('input', function() {
                    const val = this.value.toLowerCase();
                    hiddenInput.value = '';

                    if (val.length >= 3) {
                        dropdown.classList.remove('hidden');
                        let hasResults = false;
                        items.forEach(item => {
                            if (item.getAttribute('data-nome').includes(val)) {
                                item.style.display = 'block';
                                hasResults = true;
                            } else {
                                item.style.display = 'none';
                            }
                        });
                        if (!hasResults) dropdown.classList.add('hidden');
                    } else {
                        dropdown.classList.add('hidden');
                    }
                });

                items.forEach(item => {
                    item.addEventListener('click', function() {
                        const nomeSelecionado = this.innerText.trim();
                        searchInput.value = nomeSelecionado;
                        hiddenInput.value = this.getAttribute('data-id');
                        dropdown.classList.add('hidden');

                        // Executa o AJAX automaticamente ao clicar no nome
                        const obj = this.getAttribute('data-objetivo') || 'N�o definido';
                        const objLabel = document.getElementById('objetivo-aluno-label'); if(objLabel) { objLabel.classList.remove('hidden'); objLabel.querySelector('.obj-text').innerText = 'Alvo: ' + obj; }
                        carregarTreinos(hiddenInput.value, nomeSelecionado);
                    });
                });

                document.addEventListener('click', function(e) {
                    if(!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Auto-carregar se vier com parǽmetros na URL
            const urlParams = new URLSearchParams(window.location.search);
            const urlAtletaId = urlParams.get('atleta');
            const urlAtletaNome = urlParams.get('nome');
            if (urlAtletaId && urlAtletaNome) {
                carregarAlunoPelaLista(urlAtletaId, urlAtletaNome, urlParams.get('objetivo') || 'N�o definido');
            }
        });

        // ----------------------------------------------------
        // FUN�ǟO: CARREGA ALUNO PELA LISTA DA SIDEBAR
        // ----------------------------------------------------
        function carregarAlunoPelaLista(atletaId, atletaNome, objetivo = 'N�o definido') {
            const objLabel = document.getElementById('objetivo-aluno-label'); if(objLabel) { objLabel.classList.remove('hidden'); objLabel.querySelector('.obj-text').innerText = 'Alvo: ' + objetivo; }
            // Atualiza os inputs do form
            const searchInput = document.getElementById('searchAtletaTreinador');
            const hiddenInput = document.getElementById('atletaIdTreinador');
            
            if(searchInput) searchInput.value = atletaNome;
            if(hiddenInput) hiddenInput.value = atletaId;

            // Esconde menu dropdown se estiver aberto (mobile)
            if(window.innerWidth < 768) {
                toggleMenu();
            }

            // Chama a fun�ǜo principal que carrega os dados
            carregarTreinos(atletaId, atletaNome);
        }

        // ----------------------------------------------------
        // FUN�ǟO CENTRAL: CARREGA TREINOS E FEEDBACKS
        // ----------------------------------------------------
        function carregarTreinos(atletaId, atletaNome = '') {
            if (!atletaId) return;

            const lista = document.getElementById('lista-treinos');
            const label = document.getElementById('nome-aluno-label');
            const searchInput = document.getElementById('searchAtletaTreinador');

            // Atualiza o label superior com o nome do aluno
            label.className = 'bg-orange-500/20 text-orange-400 border border-orange-500/30 px-3 py-1 rounded-full text-xs md:text-sm font-bold truncate max-w-full';
            label.innerText = atletaNome || searchInput.value;
            document.getElementById('btn-Avaliações').classList.remove('hidden');

            lista.innerHTML = '<div class="flex justify-center py-20"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div></div>';

            // ==========================================
            // 1. BUSCA OS TREINOS (FICHA)
            // ==========================================
            fetch(`/treinador/listar-treinos/${atletaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        lista.innerHTML = '<div class="bg-slate-700/50 text-slate-300 p-4 md:p-6 rounded-xl border border-slate-600 text-center font-medium text-sm md:text-base">Este aluno ainda nǜo possui exerc�cios cadastrados na ficha.</div>';
                    } else {
                        let html = '<div class="overflow-x-auto"><table class="w-full text-left border-collapse min-w-[500px]"><thead><tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-700"><th class="py-3 px-4 font-bold">Exerc�cio</th><th class="py-3 px-4 font-bold">SǸries/Reps</th><th class="py-3 px-4 font-bold">Treino</th><th class="py-3 px-4 text-right font-bold">A�es</th></tr></thead><tbody class="divide-y divide-slate-700/50">';

                        data.forEach(item => {
                            html += `
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <span class="font-bold text-white block">${item.exercicio.nome}</span>
                                        <span class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-700 px-2 py-1 rounded mt-1 inline-block border border-slate-600">${item.exercicio.grupo_muscular}</span>
                                    </td>
                                    <td class="py-4 px-4 text-slate-300 font-medium whitespace-nowrap">${item.series} <span class="text-slate-500 mx-1">x</span> ${item.repeticoes}</td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <span class="bg-blue-500/10 text-blue-400 px-2 py-1 rounded text-xs font-bold border border-blue-500/20">${item.dia_semana}</span>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <button onclick="removerTreino(${item.id})" class="text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-red-500/30">Excluir</button>
                                    </td>
                                </tr>
                            `;
                        });

                        html += '</tbody></table></div>';
                        lista.innerHTML = html;
                    }
                })
                .catch(error => {
                    console.error("Erro ao carregar treinos:", error);
                    lista.innerHTML = '<div class="text-red-400 text-center py-10">Erro de conexǜo ao buscar treinos.</div>';
                });

            // ==========================================
            // 2. BUSCA OS FEEDBACKS (HIST�"RICO)
            // ==========================================
            fetch(`/treinador/historico/${atletaId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Rota nǜo encontrada");
                    return response.json();
                })
                .then(historico => {
                    const areaFeedbacks = document.getElementById('area-feedbacks');
                    const listaFeedbacks = document.getElementById('lista-feedbacks');

                    if (historico && historico.length > 0) {
                        areaFeedbacks.classList.remove('hidden');
                        let histHtml = '';
                        historico.forEach(item => {
                            let dataObj = new Date(item.created_at);
                            let dataFormatada = dataObj.toLocaleDateString('pt-BR');

                            let tagHtml = '';
                            if(item.tipo === 'exercicio_concluido') {
                                tagHtml = `<span class="bg-green-500/10 text-green-400 border border-green-500/20 text-[10px] px-2 py-0.5 rounded-full font-bold">�o" ${item.treino_para}</span>`;
                            } else {
                                tagHtml = `<span class="bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[10px] px-2 py-0.5 rounded-full font-bold">${item.treino_de || 'Desconhecido'} �z" ${item.treino_para || item.nome_treino}</span>`;
                            }

                            let borderClass = item.tipo === 'exercicio_concluido' ? 'border-green-500' : 'border-orange-500';

                            histHtml += `
                                <div class="bg-slate-900/50 border-l-4 ${borderClass} rounded-r-lg p-4 text-sm shadow-md transition-all hover:bg-slate-800">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">${dataFormatada}</span>
                                        ${tagHtml}
                                    </div>
                                    <p class="text-white italic mt-1 font-medium">"${item.observacao}"</p>
                                </div>
                            `;
                        });
                        listaFeedbacks.innerHTML = histHtml;
                    } else {
                        areaFeedbacks.classList.add('hidden');
                        listaFeedbacks.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error("Erro ao carregar feedbacks:", error);
                });
        }

        // Fun�ǜo para remover treino
        function removerTreino(id) {
            if (confirm('Tem certeza que deseja remover este exerc�cio da ficha?')) {
                fetch(`/treinador/remover-treino/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const atletaId = document.getElementById('atletaIdTreinador').value;
                        carregarTreinos(atletaId);
                    } else {
                        alert('Erro ao remover o exerc�cio.');
                    }
                })
                .catch(error => console.error('Erro:', error));
            }
        }
        // ----------------------------------------------------
        // TRAVA DE SEGURAN�A: IMPEDE SALVAR SEM SELECIONAR ALUNO
        // ----------------------------------------------------
        function validarFicha(event) {
            const idEscondido = document.getElementById('atletaIdTreinador').value;

            if (!idEscondido || idEscondido === "") {
                event.preventDefault(); // Trava o envio para o servidor
                alert("�s�? CHEFE: VocǦ precisa CLICAR no nome do aluno na lista (ou no menu lateral) antes de adicionar um exerc�cio!");
                return false;
            }
            return true;
        }

        // ----------------------------------------------------
        // AVALIA�ǟO F�?SICA
        // ----------------------------------------------------
        function abrirModalAvaliacao() {
            const atletaId = document.getElementById('atletaIdTreinador').value;
            const nomeAtleta = document.getElementById('nome-aluno-label').innerText;
            if (!atletaId) return;

            document.getElementById('modalAvaliacaoNomeAluno').innerText = nomeAtleta;
            document.getElementById('modalAvaliacao').classList.remove('hidden');
            carregarAvaliações(atletaId);
        }

        function fecharModalAvaliacao() {
            document.getElementById('modalAvaliacao').classList.add('hidden');
        }

        function carregarAvaliações(atletaId) {
            const lista = document.getElementById('lista-Avaliações-modal');
            lista.innerHTML = '<div class="text-center text-slate-400 py-4">Carregando avaliações...</div>';

            fetch(`/treinador/Avaliações/${atletaId}`)
                .then(res => res.json())
                .then(data => {
                    if(data.length === 0) {
                        lista.innerHTML = '<div class="bg-slate-700/30 text-slate-400 p-4 rounded-xl text-center text-sm border border-slate-600">Nenhuma avalia�ǜo encontrada.</div>';
                        return;
                    }

                    let html = '';
                    data.forEach(av => {
                        const dataStr = new Date(av.data_avaliacao).toLocaleDateString('pt-BR');
                        html += `
                            <div class="bg-slate-700/50 rounded-xl p-4 border border-slate-600 hover:bg-slate-700 transition-colors">
                                <div class="flex justify-between border-b border-slate-600 pb-2 mb-2">
                                    <strong class="text-orange-400 text-sm">${dataStr}</strong>
                                    <span class="text-xs bg-slate-900 text-slate-400 px-2 py-1 rounded">Peso: ${av.peso || '--'} kg | BF: ${av.bf_percentual || '--'}%</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs text-slate-300">
                                    <div>Tórax: ${av.medida_torax || '--'} cm</div>
                                    <div>Cintura: ${av.medida_cintura || '--'} cm</div>
                                    <div>Abdômen: ${av.medida_abdomen || '--'} cm</div>
                                    <div>Quadril: ${av.medida_quadril || '--'} cm</div>
                                </div>
                                ${av.observacoes_gerais ? `<div class="mt-2 text-xs italic text-slate-400 border-t border-slate-600/50 pt-1">Obs: ${av.observacoes_gerais}</div>` : ''}
                            </div>
                        `;
                    });
                    lista.innerHTML = html;
                });
        }

        function salvarNovaAvaliacao(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const atletaId = document.getElementById('atletaIdTreinador').value;

            fetch(`/treinador/Avaliações/${atletaId}`, {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if(res.ok) {
                    showToast('Avaliação salva com sucesso!');
                    form.reset();
                    carregarAvaliações(atletaId); // recarrega a lista
                } else {
                    alert('Erro ao salvar avaliação.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Erro de conexão ao salvar.');
            });
        }
    </script>

<!-- TOAST NOTIFICATION -->
<div id="toastNotification" class="fixed bottom-5 right-5 bg-slate-800 border border-emerald-500 text-emerald-400 px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transition-all duration-300 transform translate-y-20 opacity-0 z-[120]" style="pointer-events: none;">
    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    <span id="toastMessage" class="font-bold text-sm"></span>
</div>

<script>
function showToast(message) {
    const toast = document.getElementById("toastNotification");
    const toastMsg = document.getElementById("toastMessage");
    if(toast && toastMsg) {
        toastMsg.innerText = message;
        toast.classList.remove("translate-y-20", "opacity-0");
        
        setTimeout(() => {
            toast.classList.add("translate-y-20", "opacity-0");
        }, 3000);
    }
}
</script>
</body>
</html>