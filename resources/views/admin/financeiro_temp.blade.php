@extends('layouts.admin')

@section('title', 'Financeiro - GymPro')
@section('header_title', 'Gest�o Financeira')

@section('content')
            
            <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 p-4 md:p-6 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
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
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Valor (R$)</label>
                        <input type="number" step="0.01" name="valor" placeholder="100.00" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-green-500">
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

        function toggleMenuPerfil() { document.getElementById('menuPerfil').classList.toggle('hidden'); }
        function abrirModalDespesa() { document.getElementById('modalDespesa').classList.remove('hidden'); }
        function fecharModalDespesa() { document.getElementById('modalDespesa').classList.add('hidden'); }
        
        // Novas funções para o modal de Recebimento
        function abrirModalRecebimento() { document.getElementById('modalRecebimento').classList.remove('hidden'); }
        function fecharModalRecebimento() { document.getElementById('modalRecebimento').classList.add('hidden'); }
        
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('menuPerfil');
            const botao = menu.previousElementSibling;
            if (botao && !botao.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

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

    </script>
@endsection