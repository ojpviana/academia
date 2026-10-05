@extends('layouts.admin')

@section('title', 'Financeiro - GymPro')
@section('header_title', 'Gestão Financeira')

@section('content')
            
                        <!-- Abas do Financeiro -->
            <div class="flex border-b border-slate-700 mb-6">
                <button type="button" id="tabFinBtn1" onclick="switchFinTab(1)" class="px-6 py-3 font-bold text-sm text-orange-500 border-b-2 border-orange-500 hover:text-orange-400 transition-colors focus:outline-none">
                    Fluxo de Caixa
                </button>
                <button type="button" id="tabFinBtn2" onclick="switchFinTab(2)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                    Planos e Pagamentos
                </button>
            </div>

            <div id="tabFinContent1" class="space-y-6 block"><div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 p-4 md:p-6 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
                <div>
                    <h2 class="text-lg font-bold text-white tracking-wider">Período de Análise</h2>
                    <p class="text-xs text-slate-400">Filtre os resultados para visualizar o lucro real</p>
                </div>

                <form action="/admin/financeiro" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto">
                    <div class="flex items-center space-x-2 bg-slate-900 border border-slate-600 rounded-lg p-1">
                        <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" class="bg-transparent text-slate-300 text-sm focus:outline-none p-1.5 [&::-webkit-calendar-picker-indicator]:filter-[invert(1)]">
                        <span class="text-slate-500 text-sm font-bold">até</span>
                        <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="bg-transparent text-slate-300 text-sm focus:outline-none p-1.5 [&::-webkit-calendar-picker-indicator]:filter-[invert(1)]">
                    </div>
                    
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-1 sm:flex-none bg-slate-700 hover:bg-slate-600 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm shadow-md">
                            Filtrar
                        </button>

                        @if(request('data_inicio') || request('data_fim'))
                            <a href="/admin/financeiro" class="bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 py-2 px-3 rounded-lg transition-colors flex items-center justify-center" title="Limpar Filtro">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif

                        <a href="/admin/financeiro/exportar-caixa?data_inicio={{ request('data_inicio') }}&data_fim={{ request('data_fim') }}" target="_blank" class="flex-1 sm:flex-none bg-orange-600 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded-lg transition-all text-sm flex items-center justify-center shadow-lg shadow-orange-900/20 whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Gerar PDF
                        </a>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Entradas (Receitas)</p>
                    <h3 class="text-3xl font-bold text-green-400">R$ {{ number_format($somaVisivel ?? 0, 2, ',', '.') }}</h3>
                </div>

                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Saídas (Despesas)</p>
                    <h3 class="text-3xl font-bold text-red-400">R$ {{ number_format($totalDespesas ?? 0, 2, ',', '.') }}</h3>
                </div>

                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Lucro Real</p>
                    <h3 class="text-3xl font-bold {{ ($lucro ?? 0) >= 0 ? 'text-white' : 'text-red-500' }}">
                        R$ {{ number_format($lucro ?? 0, 2, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden flex flex-col h-full">
                    <div class="p-5 border-b border-slate-700 flex justify-between items-center bg-slate-800">
                        <h2 class="font-bold text-white text-lg flex items-center">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Recebimentos
                        </h2>
                        <button onclick="abrirModalRecebimento()" class="bg-green-500/10 hover:bg-green-500/20 text-green-400 border border-green-500/30 font-bold py-1.5 px-3 rounded-lg text-xs transition-colors flex items-center">
                            + Nova Entrada
                        </button>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-700">
                                    <th class="py-3 px-4 font-bold">Data</th>
                                    <th class="py-3 px-4 font-bold">Atleta</th>
                                    <th class="py-3 px-4 text-right font-bold">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @forelse($pagamentos as $pagamento)
                                    <tr class="hover:bg-slate-700/30 transition-colors">
                                        <td class="py-3 px-4 text-sm whitespace-nowrap text-slate-300">
                                            {{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-sm font-bold text-white whitespace-nowrap">
                                            {{ $pagamento->atleta->nome ?? 'Atleta Removido' }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-right font-bold text-green-400 whitespace-nowrap">
                                            R$ {{ number_format($pagamento->valor, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-slate-500 text-sm">Nenhum recebimento neste período.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden flex flex-col h-full">
                    <div class="p-5 border-b border-slate-700 flex justify-between items-center bg-slate-800">
                        <h2 class="font-bold text-white text-lg flex items-center">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Despesas
                        </h2>
                        <button onclick="abrirModalDespesa()" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 font-bold py-1.5 px-3 rounded-lg text-xs transition-colors flex items-center">
                            + Nova Despesa
                        </button>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-700">
                                    <th class="py-3 px-4 font-bold">Data</th>
                                    <th class="py-3 px-4 font-bold">Descrição</th>
                                    <th class="py-3 px-4 text-right font-bold">Valor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @forelse($despesas as $despesa)
                                    <tr class="hover:bg-slate-700/30 transition-colors">
                                        <td class="py-3 px-4 text-sm whitespace-nowrap text-slate-300">
                                            {{ \Carbon\Carbon::parse($despesa->data_pagamento)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-sm whitespace-nowrap">
                                            <span class="font-bold text-white block">{{ $despesa->descricao }}</span>
                                            <span class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $despesa->categoria }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-sm text-right font-bold text-red-400 whitespace-nowrap">
                                            R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-slate-500 text-sm">Nenhuma despesa registrada neste período.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

                </div> <!-- Fim Aba 1 -->

            <!-- Aba 2: Cadastros Base -->
            <div id="tabFinContent2" class="space-y-6 hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Cadastro de Planos -->
                    <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
                        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
                            <h2 class="text-xl font-bold text-white tracking-wider flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Planos
                            </h2>
                        </div>
                        <form id="formPlano" action="/admin/financeiro/planos" method="POST" class="p-6 space-y-4">
                            <input type="hidden" name="_method" value="POST" id="methodPlano">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Nome do Plano</label>
                                <input type="text" id="inputPlanoNome" name="nome" required placeholder="Ex: Trimestral" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-400 mb-1">Valor (R$)</label>
                                    <input type="number" step="0.01" id="inputPlanoValor" name="valor_padrao" required placeholder="150.00" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-400 mb-1">Duração (Meses)</label>
                                    <input type="number" id="inputPlanoDuracao" name="duracao_meses" required value="1" min="1" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors">
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button type="submit" id="btnSubmitPlano" class="flex-1 bg-green-600 hover:bg-green-500 text-white font-bold py-3 rounded-lg transition-all shadow-lg shadow-green-900/20">Salvar Plano</button>
                                <button type="button" id="btnCancelPlano" onclick="cancelarEdicaoPlano()" class="hidden bg-slate-600 hover:bg-slate-500 text-white font-bold py-3 px-4 rounded-lg transition-all">Cancelar</button>
                             </div>
                        </form>
                        
                        <!-- Lista de Planos -->
                        <div class="px-6 pb-6">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-700 pb-2">Planos Cadastrados</h3>
                            <ul class="space-y-2">
                                @forelse($planos ?? [] as $plano)
                                                                        <li class="flex justify-between items-center bg-slate-900 p-3 rounded-lg border border-slate-700 cursor-pointer hover:border-green-500 transition-colors" onclick="editarPlano({{ $plano->id }}, '{{ addslashes($plano->nome) }}', {{ $plano->valor_padrao }}, {{ $plano->duracao_meses }})">
                                        <div>
                                            <span class="text-white font-bold block">{{ $plano->nome }}</span>
                                            <span class="text-xs text-slate-500">{{ $plano->duracao_meses }} meses</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="text-green-400 font-bold">R$ {{ number_format($plano->valor_padrao, 2, ',', '.') }}</span>
                                            <form action="/admin/financeiro/planos/{{ $plano->id }}" method="POST" class="inline" onsubmit="return confirm('Excluir este plano?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-500 hover:text-red-500 p-1" onclick="event.stopPropagation();">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-slate-500 text-sm">Nenhum plano cadastrado.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Cadastro de Formas de Pagamento -->
                    <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
                        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
                            <h2 class="text-xl font-bold text-white tracking-wider flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                Formas de Pagamento
                            </h2>
                        </div>
                        <form id="formForma" action="/admin/financeiro/formas-pagamento" method="POST" class="p-6 space-y-4">
                            <input type="hidden" name="_method" value="POST" id="methodForma">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Nome da Forma</label>
                                <input type="text" id="inputFormaNome" name="nome" required placeholder="Ex: Pix, Cartão de Crédito" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors">
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button type="submit" id="btnSubmitForma" class="flex-1 bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-lg transition-all shadow-lg shadow-blue-900/20">Salvar Forma</button>
                                <button type="button" id="btnCancelForma" onclick="cancelarEdicaoForma()" class="hidden bg-slate-600 hover:bg-slate-500 text-white font-bold py-3 px-4 rounded-lg transition-all">Cancelar</button>
                             </div>
                        </form>
                        
                        <!-- Lista de Formas de Pagto -->
                        <div class="px-6 pb-6">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-700 pb-2">Cadastradas</h3>
                            <ul class="space-y-2">
                                @forelse($formasPagamento ?? [] as $forma)
                                                                        <li class="flex justify-between items-center bg-slate-900 p-3 rounded-lg border border-slate-700 text-white font-medium cursor-pointer hover:border-blue-500 transition-colors" onclick="editarForma({{ $forma->id }}, '{{ addslashes($forma->nome) }}')">
                                        {{ $forma->nome }}
                                        <form action="/admin/financeiro/formas-pagamento/{{ $forma->id }}" method="POST" class="inline" onsubmit="return confirm('Excluir forma de pagamento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-500 hover:text-red-500 p-1" onclick="event.stopPropagation();">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="text-slate-500 text-sm">Nenhuma forma cadastrada.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!-- Fim Aba 2 -->
<div id="modalRecebimento" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-md shadow-2xl relative">
            <button onclick="fecharModalRecebimento()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-2xl font-bold text-white mb-6">Registrar Entrada</h2>
            
            <form action="/admin/recebimentos" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Buscar Aluno</label>
                    <input type="text" id="searchAtletaRecebimento" placeholder="Digite 3 letras para buscar..." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors" autocomplete="off">
                    <input type="hidden" name="atleta_id" id="atletaIdRecebimento" required>
                    
                    <ul id="dropdownAtletasRecebimento" class="absolute z-[101] w-full bg-slate-800 border border-slate-600 mt-1 rounded-lg shadow-2xl max-h-48 overflow-y-auto hidden">
                        @if(isset($atletas) && count($atletas) > 0)
                            @foreach($atletas as $atleta)
                                <li class="px-4 py-3 hover:bg-slate-700 cursor-pointer text-slate-300 font-medium border-b border-slate-700/50 last:border-0 transition-colors" data-id="{{ $atleta->idAtleta }}" data-nome="{{ strtolower($atleta->nome) }}">
                                    {{ $atleta->nome }}
                                </li>
                            @endforeach
                        @else
                            <li class="px-4 py-3 text-slate-500 text-sm">Nenhum aluno encontrado</li>
                        @endif
                    </ul>
                </div>
                
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-400 mb-1">Plano (Opcional)</label>
                    <select name="plano_id" id="planoIdRecebimento" onchange="atualizarValorPlano()" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors">
                        <option value="" data-valor="">Avulso / Selecione um Plano</option>
                        @foreach($planos ?? [] as $plano)
                            <option value="{{ $plano->id }}" data-valor="{{ $plano->valor_padrao }}">{{ $plano->nome }} - {{ $plano->duracao_meses }} meses</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Valor (R$)</label>
                        <input type="number" step="0.01" name="valor" id="valorRecebimento" placeholder="100.00" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Data do Pagto</label>
                        <input type="date" name="data_pagamento" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-700 border border-slate-600 text-slate-300 rounded-lg p-3 focus:outline-none focus:border-green-500 [&::-webkit-calendar-picker-indicator]:filter-[invert(1)]">
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-3 rounded-lg mt-6 transition-all shadow-lg shadow-green-900/20">Salvar Recebimento</button>
            </form>
        </div>
    </div>

    <div id="modalDespesa" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-md shadow-2xl relative">
            <button onclick="fecharModalDespesa()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-2xl font-bold text-white mb-6">Registrar Despesa</h2>
            
            <form action="/admin/despesas" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Descrição</label>
                    <input type="text" name="descricao" placeholder="Ex: Conta de Energia" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-red-500 transition-colors">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Valor (R$)</label>
                        <input type="number" step="0.01" name="valor" placeholder="150.00" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Data do Pagto</label>
                        <input type="date" name="data_pagamento" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-700 border border-slate-600 text-slate-300 rounded-lg p-3 focus:outline-none focus:border-red-500 [&::-webkit-calendar-picker-indicator]:filter-[invert(1)]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Categoria</label>
                    <select name="categoria" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-red-500">
                        <option value="Operacional">Custos Operacionais (Água, Luz, Internet)</option>
                        <option value="Folha de Pagamento">Folha de Pagamento / Salários</option>
                        <option value="Manutenção">Manutenção de Equipamentos</option>
                        <option value="Aluguel">Aluguel / Imóvel</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-bold py-3 rounded-lg mt-6 transition-all shadow-lg shadow-red-900/20">Salvar Despesa</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div id="toast-sucesso" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transition-all duration-500 transform translate-y-0 opacity-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
        
    @endif

    @endsection

@section('scripts')
<script>

    setTimeout(() => {
        const toast = document.getElementById('toast-sucesso');
        if(toast) {
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);

        function abrirModalDespesa() { document.getElementById('modalDespesa').classList.remove('hidden'); }
        function fecharModalDespesa() { document.getElementById('modalDespesa').classList.add('hidden'); }
        
        // Novas funções para o modal de Recebimento
        function abrirModalRecebimento() { document.getElementById('modalRecebimento').classList.remove('hidden'); }
        function fecharModalRecebimento() { document.getElementById('modalRecebimento').classList.add('hidden'); }
        
        // Motor do Autocomplete - Financeiro
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchAtletaRecebimento');
            const hiddenInput = document.getElementById('atletaIdRecebimento');
            const dropdown = document.getElementById('dropdownAtletasRecebimento');
            
            if(searchInput && dropdown) {
                const items = dropdown.querySelectorAll('li[data-id]');

                searchInput.addEventListener('input', function() {
                    const val = this.value.toLowerCase();
                    hiddenInput.value = ''; // Trava o form se o usuário não clicar na lista
                    
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
                        searchInput.value = this.innerText.trim();
                        hiddenInput.value = this.getAttribute('data-id');
                        dropdown.classList.add('hidden');
                    });
                });

                document.addEventListener('click', function(e) {
                    if(!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });

    function switchFinTab(tabIndex) {
        const t1Btn = document.getElementById('tabFinBtn1');
        const t2Btn = document.getElementById('tabFinBtn2');
        const t1 = document.getElementById('tabFinContent1');
        const t2 = document.getElementById('tabFinContent2');
        
        const activeCls = "px-6 py-3 font-bold text-sm text-orange-500 border-b-2 border-orange-500 hover:text-orange-400 transition-colors focus:outline-none";
        const inactiveCls = "px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none";

        if (tabIndex === 1) {
            t1.classList.remove('hidden');
            t2.classList.add('hidden');
            t1Btn.className = activeCls;
            t2Btn.className = inactiveCls;
        } else {
            t1.classList.add('hidden');
            t2.classList.remove('hidden');
            t2Btn.className = activeCls;
            t1Btn.className = inactiveCls;
        }
    }

        function editarPlano(id, nome, valor, duracao) {
        document.getElementById('formPlano').action = '/admin/financeiro/planos/' + id;
        document.getElementById('methodPlano').value = 'PUT';
        document.getElementById('inputPlanoNome').value = nome;
        document.getElementById('inputPlanoValor').value = valor;
        document.getElementById('inputPlanoDuracao').value = duracao;
        document.getElementById('btnSubmitPlano').innerText = 'Atualizar Plano';
        document.getElementById('btnCancelPlano').classList.remove('hidden');
        window.scrollTo({ top: document.getElementById('formPlano').offsetTop, behavior: 'smooth' });
    }

    function cancelarEdicaoPlano() {
        document.getElementById('formPlano').action = '/admin/financeiro/planos';
        document.getElementById('methodPlano').value = 'POST';
        document.getElementById('inputPlanoNome').value = '';
        document.getElementById('inputPlanoValor').value = '';
        document.getElementById('inputPlanoDuracao').value = '1';
        document.getElementById('btnSubmitPlano').innerText = 'Salvar Plano';
        document.getElementById('btnCancelPlano').classList.add('hidden');
    }

    function editarForma(id, nome) {
        document.getElementById('formForma').action = '/admin/financeiro/formas-pagamento/' + id;
        document.getElementById('methodForma').value = 'PUT';
        document.getElementById('inputFormaNome').value = nome;
        document.getElementById('btnSubmitForma').innerText = 'Atualizar Forma';
        document.getElementById('btnCancelForma').classList.remove('hidden');
        window.scrollTo({ top: document.getElementById('formForma').offsetTop, behavior: 'smooth' });
    }

    function cancelarEdicaoForma() {
        document.getElementById('formForma').action = '/admin/financeiro/formas-pagamento';
        document.getElementById('methodForma').value = 'POST';
        document.getElementById('inputFormaNome').value = '';
        document.getElementById('btnSubmitForma').innerText = 'Salvar Forma';
        document.getElementById('btnCancelForma').classList.add('hidden');
    }

    @if(session('tab') == 2)
    document.addEventListener('DOMContentLoaded', function() {
        switchFinTab(2);
    });
    @endif

    function atualizarValorPlano() {
        const select = document.getElementById('planoIdRecebimento');
        const valorInput = document.getElementById('valorRecebimento');
        if(select && valorInput) {
            const opcaoSelecionada = select.options[select.selectedIndex];
            const valorStr = opcaoSelecionada.getAttribute('data-valor');
            if (valorStr) {
                // Formatting to 2 decimals
                valorInput.value = parseFloat(valorStr).toFixed(2);
            }
        }
    }
</script>
@endsection

