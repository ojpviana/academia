<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Treino - GymPro</title>
    @php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); @endphp
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-900 text-slate-300 font-sans pb-24">

    <!-- HEADER -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center sticky top-0 z-40 shadow-md">
        <div>
            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mb-1">Bem-vindo de volta,</p>
            <h1 class="text-xl font-bold text-white capitalize">{{ $atleta->nome }}</h1>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $atleta->streak_atual > 0 ? 'bg-orange-500/10 text-orange-500 border border-orange-500/20' : 'bg-slate-700/50 text-slate-500 border border-slate-600' }}">
                    <svg class="w-4 h-4 text-orange-500 mr-1 inline" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg> 
                    {{ $atleta->streak_atual }} Semanas Seguidas
                </span>
            </div>
        </div>

        <div class="relative">
            <button onclick="toggleMenuPerfil()" class="h-12 w-12 rounded-full border-2 border-orange-500 p-0.5 focus:outline-none hover:scale-105 transition-transform shadow-lg shadow-orange-500/20">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($atleta->nome) }}&background=f97316&color=fff&bold=true" class="rounded-full w-full h-full object-cover">
            </button>

            <div id="menuPerfil" class="hidden absolute top-14 right-0 w-48 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl z-50 overflow-hidden">
                <div class="py-1">
                    <button onclick="abrirModalSenha(); toggleMenuPerfil();" class="w-full text-left px-4 py-3 text-sm text-slate-300 hover:bg-slate-700 hover:text-white transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Trocar Senha
                    </button>
                    <div class="border-t border-slate-700/50"></div>
                    <a href="/logout" class="block px-4 py-3 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Sair do App
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTEÃƒÅ¡DO PRINCIPAL -->
    <main class="p-4 sm:p-6 max-w-md mx-auto">
        <div id="tab-inicio">
            <div class="grid grid-cols-2 gap-4 mb-6 mt-2">
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-4 shadow-lg flex flex-col items-center justify-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Último Peso</p>
                    <p class="text-2xl font-bold text-white">
                        {{ $ultimaAvaliacao ? number_format($ultimaAvaliacao->peso, 1, ',', '.') : ($atleta->peso ?? '--') }} <span class="text-sm font-normal text-slate-500">kg</span>
                    </p>
                </div>
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-4 shadow-lg flex flex-col items-center justify-center relative group cursor-pointer" onclick="abrirModalAvaliacao()">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Data Avaliação</p>
                    <p class="text-xl font-bold text-orange-400">
                        {{ $ultimaAvaliacao ? date('d/m/y', strtotime($ultimaAvaliacao->data_avaliacao)) : '--' }}

                    </p>
                    @if($ultimaAvaliacao)
                        <div class="absolute inset-0 bg-slate-700/80 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-xs font-bold text-white">Ver detalhes</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- INFO DA ACADEMIA -->
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-4 shadow-lg mb-6 flex justify-between items-center">
                <div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Horário de Funcionamento</p>
                    <p class="text-sm font-bold text-white">{{ $horarioFuncionamento ?? '06:00 às 22:00' }}</p>
                </div>
                <div class="h-10 w-10 bg-slate-700 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4 mt-2">
                <h2 class="text-xl font-bold text-white">Sua Ficha</h2>
                <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-3 py-1 rounded-full text-xs font-bold shadow-sm">Ativa</span>
            </div>

            @php
                $diaSemana = date('N');
                $abaPadrao = 0;
                if (isset($treinos) && $treinos->count() > 0) {
                    $abaPadrao = ($diaSemana - 1) % $treinos->count();
                }
            @endphp

            @if(!$checkinHoje)
                <!-- TELA DE CHECK-IN -->
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 text-center shadow-lg mt-8 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 bg-orange-500/20 rounded-full flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(249,115,22,0.3)]">
                        <svg class="w-12 h-12 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-white font-bold text-2xl mb-2">Pronto para treinar?</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">Faça seu check-in para registrar sua presença e liberar a ficha de treinos.</p>
                    <button onclick="fazerCheckin()" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-orange-900/20 text-lg transition-transform active:scale-95 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Iniciar Treino
                    </button>
                </div>
            @elseif(isset($treinos) && $treinos->count() > 0)
                <!-- ABAS DE NAVEGAÇÃO DOS TREINOS -->
                <div class="flex space-x-3 overflow-x-auto pb-2 mb-4 scrollbar-hide snap-x">
                    @foreach($treinos as $dia => $exercicios)
                        <button onclick="solicitarTroca({{ $loop->index }}, '{{ $dia }}')" id="btn-tab-{{ $loop->index }}"
                            class="tab-btn snap-start shrink-0 px-5 py-2.5 rounded-xl border text-sm font-bold transition-all shadow-sm
                            {{ $loop->index == $abaPadrao ? 'bg-orange-500/20 text-orange-400 border-orange-500/50' : 'bg-slate-800 text-slate-400 border-slate-700 hover:bg-slate-700' }}">
                            {{ $dia }}

                        </button>
                    @endforeach
                </div>

                <!-- CONTEÚDO DAS FICHAS -->
                <div id="treinos-container">
                    @foreach($treinos as $dia => $exercicios)
                        <div id="content-tab-{{ $loop->index }}" class="treino-content {{ $loop->index == $abaPadrao ? 'block' : 'hidden' }}">
                            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-orange-500 shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>

                                <div class="flex justify-between items-center mb-5 pl-2">
                                    <h3 class="font-bold text-orange-400 text-lg">{{ $dia }}</h3>
                                    <span class="bg-slate-900 text-slate-400 border border-slate-700 text-[10px] px-2 py-1 rounded-md font-bold uppercase">{{ $exercicios->count() }} exs</span>
                                </div>

                                <div class="space-y-3 pl-2">
                                    @foreach($exercicios as $treino)
                                        <div class="bg-slate-900/50 border border-slate-700/50 rounded-xl p-4 flex justify-between items-center hover:bg-slate-700/50 transition-colors cursor-pointer" onclick="abrirModalExercicio({{ json_encode($treino->exercicio) }}, {{ $treino->id }}, {{ $treino->meta_carga_kg ?? 'null' }})">
                                            <div>
                                                <p class="text-[10px] text-orange-500/80 font-bold uppercase tracking-widest mb-1">{{ $treino->exercicio->grupo_muscular ?? 'N/A' }}</p>
                                                <p class="font-bold text-white text-sm mb-1">{{ $treino->exercicio->nome ?? 'Exercício Excluído' }}</p>
                                                <p class="text-xs text-slate-400 flex items-center font-medium">
                                                    <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                                    {{ $treino->series }} séries | {{ $treino->repeticoes }} reps
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @if(isset($treino->exercicio->video_url) && $treino->exercicio->video_url)
                                                    <span class="text-orange-500 bg-orange-500/10 p-1.5 rounded-full border border-orange-500/30">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                    </span>
                                                @endif
                                                
                                                @php
                                                    $jaConcluido = in_array($treino->id, $exerciciosConcluidosHoje);
                                                @endphp
                                                @if(!$jaConcluido)
                                                    <input type="number" id="carga-{{ $treino->id }}" placeholder="kg" class="w-14 h-10 bg-slate-900 border border-slate-700 text-slate-300 text-xs text-center rounded-lg focus:outline-none focus:border-orange-500 placeholder-slate-600" onclick="event.stopPropagation();">
                                                @endif
                                                <button id="btn-check-{{ $treino->id }}" onclick="event.stopPropagation(); concluirExercicio({{ $treino->id }}, '{{ $treino->exercicio->nome ?? 'Exercicio' }}')" class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center transition-all focus:outline-none z-10 {{ $jaConcluido ? 'bg-green-500 text-white border border-green-400 shadow-[0_0_15px_rgba(34,197,94,0.4)]' : 'bg-slate-800 border border-slate-600 text-slate-500 hover:border-green-500/50 hover:text-green-500/50' }}">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado Vazio -->
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 text-center shadow-lg mt-8">
                    <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-slate-800 shadow-inner">
                        <svg class="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Sua ficha está vazia</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Seu treinador ainda não prescreveu seus exercícios. Procure a recepção!</p>
                </div>
            @endif
        </div>

        <!-- TAB TODOS OS TREINOS -->
        <div id="tab-treinos" class="hidden">
            <div class="mb-6 mt-2">
                <h2 class="text-xl font-bold text-white mb-1">Todos os Treinos</h2>
                <p class="text-sm text-slate-400">Visualize todas as suas fichas cadastradas.</p>
            </div>

            @if(isset($treinos) && $treinos->count() > 0)
                <div class="space-y-6">
                    @foreach($treinos as $dia => $exercicios)
                        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 shadow-lg relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-slate-600"></div>

                            <div class="flex justify-between items-center mb-5 pl-2">
                                <h3 class="font-bold text-white text-lg">{{ $dia }}</h3>
                                <span class="bg-slate-900 text-slate-400 border border-slate-700 text-[10px] px-2 py-1 rounded-md font-bold uppercase">{{ $exercicios->count() }} exs</span>
                            </div>

                            <div class="space-y-3 pl-2">
                                @foreach($exercicios as $treino)
                                    <div class="bg-slate-900/50 border border-slate-700/50 rounded-xl p-4 flex justify-between items-center hover:bg-slate-700/50 transition-colors cursor-pointer" onclick="abrirModalExercicio({{ json_encode($treino->exercicio) }}, {{ $treino->id }}, {{ $treino->meta_carga_kg ?? 'null' }})">
                                        <div>
                                            <p class="text-[10px] text-orange-500/80 font-bold uppercase tracking-widest mb-1">{{ $treino->exercicio->grupo_muscular ?? 'N/A' }}</p>
                                            <p class="font-bold text-white text-sm mb-1">{{ $treino->exercicio->nome ?? 'Exercício Excluído' }}</p>
                                            <p class="text-xs text-slate-400 flex items-center font-medium">
                                                <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                                {{ $treino->series }} séries | {{ $treino->repeticoes }} reps
                                            </p>
                                        </div>
                                        @if(isset($treino->exercicio->video_url) && $treino->exercicio->video_url)
                                        <div class="flex items-center gap-2">
                                            <span class="text-orange-500 bg-orange-500/10 p-1.5 rounded-full border border-orange-500/30">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 text-center shadow-lg">
                    <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-slate-800 shadow-inner">
                        <svg class="w-10 h-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Sem treinos</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Nenhuma ficha encontrada.</p>
                </div>
            @endif
        </div>

        <!-- TAB VITRINE -->
        <div id="tab-vitrine" class="hidden space-y-6 pb-24">
            <h2 class="text-xl font-bold text-white mb-4">Vitrine de Produtos</h2>
            <div class="grid grid-cols-2 gap-4">
                @if(isset($produtos) && $produtos->count() > 0)
                    @foreach($produtos as $produto)
                        <div class="bg-slate-800 rounded-2xl overflow-hidden shadow-lg border border-slate-700">
                            <img src="{{ asset('storage/' . $produto->imagem_path) }}" alt="{{ $produto->nome }}" class="w-full h-32 object-cover">
                            <div class="p-4">
                                <h3 class="text-white font-bold text-sm mb-1 truncate">{{ $produto->nome }}</h3>
                                <p class="text-orange-400 font-bold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 text-center text-slate-400 italic py-8">Nenhum produto disponível no momento.</div>
                @endif
            </div>
        </div>

    </main>

    <!-- BARRA INFERIOR -->
    <nav class="fixed bottom-0 w-full max-w-md left-1/2 transform -translate-x-1/2 bg-slate-800/90 backdrop-blur-md border-t border-slate-700 flex justify-around items-center h-20 px-6 z-40 pb-2 shadow-[0_-10px_40px_rgba(0,0,0,0.5)] rounded-t-3xl">
        <button id="nav-btn-inicio" onclick="alternarAbaPrincipal('inicio')" class="flex flex-col items-center text-orange-500 w-20 transition-transform active:scale-95">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span class="text-[10px] font-bold uppercase tracking-widest">Início</span>
        </button>

        <button id="nav-btn-treinos" onclick="alternarAbaPrincipal('treinos')" class="flex flex-col items-center text-slate-500 hover:text-orange-400 w-20 transition-all active:scale-95">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            <span class="text-[10px] font-bold uppercase tracking-widest">Treinos</span>
        </button>
        
        <button id="nav-btn-vitrine" onclick="alternarAbaPrincipal('vitrine')" class="flex flex-col items-center text-slate-500 hover:text-orange-400 w-20 transition-all active:scale-95">
            <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            <span class="text-[10px] font-bold uppercase tracking-widest">Vitrine</span>
        </button>
    </nav>

    <!-- MODAL MOTIVO DE TROCA DE TREINO -->
    <div id="modalTrocaTreino" class="fixed inset-0 bg-slate-900/95 backdrop-blur-md hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-3xl w-full max-w-sm shadow-2xl relative">
            <button onclick="fecharModalTroca()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-1.5 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-lg font-bold text-white mb-2">Alterar ficha do dia?</h2>
            <p class="text-sm text-slate-400 mb-5">Você está mudando para o <span id="nomeTreinoDesejado" class="font-bold text-orange-400">Treino</span>. Quer deixar uma anotação para o seu professor?</p>

            <textarea id="motivoTroca" rows="3" placeholder="Ex: Aparelhos muito cheios, dor muscular..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl p-3 focus:outline-none focus:border-orange-500 transition-colors mb-4 text-sm resize-none"></textarea>

            <div class="flex space-x-3">
                <button onclick="fecharModalTroca()" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-xl transition-all text-sm">Cancelar</button>
                <button onclick="confirmarTroca()" class="flex-1 bg-orange-500 hover:bg-orange-400 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-orange-500/20 text-sm">Confirmar Troca</button>
            </div>
        </div>
    </div>

    <!-- MODAL DE SENHA -->
    <div id="modalSenha" class="fixed inset-0 bg-slate-900/95 backdrop-blur-md hidden flex items-center justify-center z-[100] px-4">
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

    <!-- MODAL VÃƒÂDEO EXERCÃƒÂCIO -->
    <div id="modalVideoExercicio" class="fixed inset-0 bg-slate-900/95 backdrop-blur-md hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 rounded-3xl w-full max-w-sm shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-4 border-b border-slate-700 flex justify-between items-center bg-slate-800/80 sticky top-0">
                <div>
                    <p id="modalExercicioGrupo" class="text-[10px] text-orange-500 font-bold uppercase tracking-widest leading-tight">Grupo</p>
                    <h2 id="modalExercicioNome" class="text-lg font-bold text-white leading-tight">Nome do Exercí­cio</h2>
                </div>
                <button onclick="fecharModalExercicio()" class="text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full transition-colors shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto p-4 space-y-4">
                <div id="modalExercicioVideoContainer" class="w-full aspect-video bg-slate-900 rounded-xl border border-slate-700 overflow-hidden flex items-center justify-center relative">
                    <p class="text-slate-500 text-sm absolute">Sem vídeo disponível</p>
                </div>
                
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Instruções</h3>
                    <p id="modalExercicioDescricao" class="text-sm text-slate-300 bg-slate-900/50 p-3 rounded-xl border border-slate-700/50">Nenhuma instrução adicional.</p>
                </div>
                
                <div class="mt-2 pt-4 border-t border-slate-700/50">
                    <h3 class="text-xs font-bold text-orange-400 uppercase tracking-widest mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Alvo PR (Meta de Carga)
                    </h3>
                    <div class="flex items-center gap-2">
                        <input type="hidden" id="prTreinoAtletaId">
                        <input type="number" id="inputMetaCarga" step="1" min="1" placeholder="Ex: 100" class="w-24 bg-slate-900 border border-slate-600 text-white rounded-lg p-2 focus:outline-none focus:border-orange-500">
                        <span class="text-slate-400 font-bold">kg</span>
                        <button onclick="salvarMetaPR()" class="ml-auto bg-orange-600 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded-lg shadow-lg text-sm transition-colors">
                            Definir Meta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($ultimaAvaliacao)
    <!-- MODAL AVALIAÃƒâ€¡ÃƒÆ’O FÃƒÂSICA -->
    <div id="modalAvaliacao" class="fixed inset-0 bg-slate-900/95 backdrop-blur-md hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-3xl w-full max-w-sm shadow-2xl relative overflow-y-auto max-h-[90vh]">
            <button onclick="fecharModalAvaliacao()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-1.5 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            
            <h2 class="text-xl font-bold text-white mb-1">Avaliação Física</h2>
            <p class="text-sm text-orange-400 font-bold mb-6">Realizada em: {{ date('d/m/Y', strtotime($ultimaAvaliacao->data_avaliacao)) }}</p>

            <div class="space-y-4">
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/50 flex justify-between items-center">
                    <span class="text-sm text-slate-400 font-bold">Peso Atual</span>
                    <span class="text-lg text-white font-bold">{{ number_format($ultimaAvaliacao->peso, 1, ',', '.') }} kg</span>
                </div>
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/50 flex justify-between items-center">
                    <span class="text-sm text-slate-400 font-bold">Altura</span>
                    <span class="text-lg text-white font-bold">{{ number_format($ultimaAvaliacao->altura, 2, ',', '.') }} m</span>
                </div>
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/50 flex justify-between items-center">
                    <span class="text-sm text-slate-400 font-bold">Massa Magra</span>
                    <span class="text-lg text-white font-bold">{{ number_format($ultimaAvaliacao->massa_magra, 1, ',', '.') }} %</span>
                </div>
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/50 flex justify-between items-center">
                    <span class="text-sm text-slate-400 font-bold">Massa Gorda</span>
                    <span class="text-lg text-white font-bold">{{ number_format($ultimaAvaliacao->massa_gorda, 1, ',', '.') }} %</span>
                </div>
                
                @if($ultimaAvaliacao->observacoes)
                <div class="bg-slate-900/50 rounded-xl p-4 border border-slate-700/50 mt-4">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Observações do Treinador</span>
                    <p class="text-sm text-slate-300 italic">"{{ $ultimaAvaliacao->observacoes }}"</p>
                </div>
                @endif
            </div>
            
            <button onclick="fecharModalAvaliacao()" class="w-full bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-xl mt-6 transition-all shadow-lg shadow-slate-900/20 text-sm">Fechar</button>
        </div>
    </div>
    @endif

    <!-- MODAL MARCAR EXERCÃƒÂCIO CONCLUÃƒÂDO -->
    <div id="modalExercicioConcluido" class="fixed inset-0 bg-slate-900/95 backdrop-blur-md hidden flex items-center justify-center z-[110] px-4">
        <div class="bg-slate-800 border border-slate-700 p-6 rounded-3xl w-full max-w-sm shadow-2xl relative">
            <button onclick="fecharModalConcluir()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-1.5 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <div class="w-12 h-12 rounded-full bg-green-500/20 border border-green-500/50 text-green-500 flex items-center justify-center mb-4 mx-auto">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
            </div>
            <h2 class="text-lg font-bold text-white mb-1 text-center">Exercício Concluído!</h2>
            <p class="text-sm text-slate-400 mb-5 text-center">Deixe uma anotação sobre <span id="nomeExercicioConcluido" class="font-bold text-orange-400">...</span> para o seu treinador (Opcional).</p>

            <textarea id="comentarioExercicio" rows="3" placeholder="Ex: Fiz com 20kg, senti um pouco o ombro..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl p-3 focus:outline-none focus:border-green-500 transition-colors mb-4 text-sm resize-none"></textarea>

            <input type="hidden" id="treinoAtletaIdConcluido"><input type="hidden" id="cargaExercicioConcluido">

            <button onclick="salvarExercicioConcluido()" class="w-full bg-green-500 hover:bg-green-400 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-green-500/20 text-sm">Salvar Anotação</button>
        </div>
    </div>

    <!-- TOAST ERRO -->
    <div id="toastErro" class="fixed bottom-5 right-5 bg-slate-800 border border-red-600 text-red-500 px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transition-all duration-300 transform translate-y-20 opacity-0 z-[120]" style="pointer-events: none;">
        <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span id="toastErroMessage" class="font-bold text-sm"></span>
    </div>

    <script>
        function mostrarToastErro(message) {
            const toast = document.getElementById("toastErro");
            const toastMsg = document.getElementById("toastErroMessage");
            if(toast && toastMsg) {
                toastMsg.innerText = message;
                toast.classList.remove("translate-y-20", "opacity-0");
                setTimeout(() => {
                    toast.classList.add("translate-y-20", "opacity-0");
                }, 3500);
            }
        }
        function alternarAbaPrincipal(aba) {
            const viewInicio = document.getElementById("tab-inicio");
            const viewTreinos = document.getElementById("tab-treinos");
            const viewVitrine = document.getElementById("tab-vitrine");
            
            const btnInicio = document.getElementById("nav-btn-inicio");
            const btnTreinos = document.getElementById("nav-btn-treinos");
            const btnVitrine = document.getElementById("nav-btn-vitrine");

            // Esconde tudo
            if(viewInicio) viewInicio.classList.add("hidden");
            if(viewTreinos) viewTreinos.classList.add("hidden");
            if(viewVitrine) viewVitrine.classList.add("hidden");
            
            [btnInicio, btnTreinos, btnVitrine].forEach(btn => {
                if(btn) {
                    btn.classList.remove("text-orange-500");
                    btn.classList.add("text-slate-500", "hover:text-orange-400");
                    let svg = btn.querySelector("svg");
                    if(svg) svg.setAttribute("stroke-width", "2");
                }
            });

            // Ativa o container correspondente
            let btnActive, viewActive;
            if (aba === "inicio") { viewActive = viewInicio; btnActive = btnInicio; }
            else if (aba === "treinos") { viewActive = viewTreinos; btnActive = btnTreinos; }
            else if (aba === "vitrine") { viewActive = viewVitrine; btnActive = btnVitrine; }

            if(viewActive) viewActive.classList.remove("hidden");
            if(btnActive) {
                btnActive.classList.add("text-orange-500");
                btnActive.classList.remove("text-slate-500", "hover:text-orange-400");
                let svg = btnActive.querySelector("svg");
                if(svg) svg.setAttribute("stroke-width", "2.5");
            }
            window.scrollTo({top: 0, behavior: "smooth"});
        }

        // Restante das funcoes
        function fazerCheckin() {
            fetch('/app/checkin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(async response => {
                const data = await response.json();
                if (!response.ok) throw data;
                return data;
            })
            .then(data => {
                window.location.reload();
            }).catch(error => {
                let msg = error.message || 'Erro de conexão.';
                let msgEl = document.getElementById('msgBloqueio');
                let modalEl = document.getElementById('modalBloqueio');
                
                if (error.is_bloqueado && msgEl && modalEl) {
                    msgEl.innerText = msg;
                    modalEl.classList.remove('hidden');
                } else {
                    mostrarToastErro(msg);
                }
            });
        }

        function toggleMenuPerfil() { document.getElementById('menuPerfil').classList.toggle('hidden'); }
        function abrirModalSenha() { document.getElementById('modalSenha').classList.remove('hidden'); }
        function fecharModalSenha() { document.getElementById('modalSenha').classList.add('hidden'); }
        function fecharModalTroca() { document.getElementById('modalTrocaTreino').classList.add('hidden'); }
        function fecharModalAvaliacao() { document.getElementById('modalAvaliacao').classList.add('hidden'); }
        function fecharModalExercicio() { 
            document.getElementById('modalVideoExercicio').classList.add('hidden');
            document.getElementById('modalExercicioVideoContainer').innerHTML = '<p class="text-slate-500 text-sm absolute">Sem vídeo disponível</p>';
        }
        function fecharModalConcluir() { document.getElementById('modalExercicioConcluido').classList.add('hidden'); }
        
        
        )
                .catch(error => {
                    let msg = (error.response && error.response.data && error.response.data.message) ? error.response.data.message : 'Erro ao realizar check-in.';
                    mostrarToastErro(msg);
                });
        }

        function alternarAbaPrincipal(aba) {
            document.querySelectorAll('.aba-principal').forEach(el => el.classList.add('hidden'));
            let tab = document.getElementById('aba-' + aba);
            if(tab) tab.classList.remove('hidden');
            
            ['inicio', 'treinos', 'vitrine'].forEach(id => {
                let btn = document.getElementById('nav-btn-' + id);
                if(btn) {
                    if(id === aba) {
                        btn.classList.remove('text-slate-500');
                        btn.classList.add('text-orange-500');
                    } else {
                        btn.classList.remove('text-orange-500');
                        btn.classList.add('text-slate-500');
                    }
                }
            });
        }

        let treinoTrocaDesejado = null;
        function solicitarTroca(index, dia) {
            treinoTrocaDesejado = { index, dia };
            let nomeEl = document.getElementById('nomeTreinoDesejado');
            if(nomeEl) nomeEl.innerText = dia;
            document.getElementById('modalTrocaTreino').classList.remove('hidden');
        }

        function confirmarTroca() {
            let justificativa = document.getElementById('justificativaTroca') ? document.getElementById('justificativaTroca').value : '';
            if(treinoTrocaDesejado) {
                if (typeof alternarAbaTreino === 'function') {
                    alternarAbaTreino(treinoTrocaDesejado.index, treinoTrocaDesejado.dia);
                }
            }
            fecharModalTroca();
            if (typeof mostrarToastSucesso === 'function') mostrarToastSucesso('Ficha trocada com sucesso!');
        }

        let exercicioAtualId = null;
        function abrirModalExercicio(exercicio, treinoId, metaCarga) {
            exercicioAtualId = treinoId;
            let titulo = document.getElementById('modalExercicioTitulo');
            if(titulo) titulo.innerText = exercicio.nome;
            
            let inst = document.getElementById('modalExercicioInstrucoes');
            if(inst) inst.innerText = exercicio.instrucoes || 'Sem instruções específicas.';
            
            let videoContainer = document.getElementById('modalExercicioVideoContainer');
            if(videoContainer) {
                if (exercicio.video_url) {
                    let embedUrl = exercicio.video_url.replace('watch?v=', 'embed/');
                    videoContainer.innerHTML = '<iframe class="w-full h-full rounded-lg" src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';
                } else {
                    videoContainer.innerHTML = '<p class="text-slate-500 text-sm absolute">Sem vídeo disponível</p>';
                }
            }
            document.getElementById('modalVideoExercicio').classList.remove('hidden');
        }

        function salvarMetaPR() {
            fecharModalExercicio();
            if (typeof mostrarToastSucesso === 'function') mostrarToastSucesso('Meta salva!');
        }

        function concluirExercicio(treinoId, exercicioNome) {
            exercicioAtualId = treinoId;
            let nomeEl = document.getElementById('modalExercicioConcluidoNome');
            if(nomeEl) nomeEl.innerText = exercicioNome;
            document.getElementById('modalExercicioConcluido').classList.remove('hidden');
        }

        function salvarExercicioConcluido() {
            if(!exercicioAtualId) return;
            
            let btn = document.getElementById('btn-check-' + exercicioAtualId);
            if(btn) {
                btn.classList.remove('bg-slate-800', 'text-slate-500', 'border-slate-600');
                btn.classList.add('bg-green-500', 'text-white', 'border-green-400', 'shadow-[0_0_15px_rgba(34,197,94,0.4)]');
            }
            
            fecharModalConcluir();
            if (typeof mostrarToastSucesso === 'function') mostrarToastSucesso('Exercício concluído!');
        }

    </script>
</body>
</html>