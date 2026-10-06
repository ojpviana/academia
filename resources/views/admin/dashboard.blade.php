@extends('layouts.admin')

@section('title', 'Admin Dashboard - GymPro')
@section('header_title', 'Visão Geral')

@section('content')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 flex justify-between items-center shadow-lg">
                    <div>
                        <p class="text-sm text-slate-400 mb-1 font-medium uppercase">
                            {{ $filtro == 'inativos' ? 'Membros Inativos' : 'Membros Ativos' }}
                        </p>
                        <p class="text-3xl font-bold text-white">{{ $atletas->count() }}</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-500/20 rounded-lg flex items-center justify-center text-blue-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 flex justify-between items-center shadow-lg">
                    <div>
                        <p class="text-sm text-slate-400 mb-1 font-medium uppercase">Receita Mensal</p>
                        <p class="text-3xl font-bold text-green-400">R$ {{ number_format($receitaMensal, 2, ',', '.') }}</p>
                    </div>
                    <div class="h-12 w-12 bg-green-500/20 rounded-lg flex items-center justify-center text-green-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg overflow-hidden mt-6">
                <div class="px-4 md:px-6 py-4 border-b border-slate-700 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-700/30 gap-4 sm:gap-0">
                    <h2 class="text-lg font-bold text-white uppercase tracking-tight">
                        {{ $filtro == 'inativos' ? 'Alunos Inativos' : 'Gerenciamento de Alunos' }}
                    </h2>

                    <div class="flex space-x-2 w-full sm:w-auto">
                        @if($filtro == 'inativos')
                            <a href="/admin/dashboard" class="text-sm bg-slate-600 hover:bg-slate-500 text-white px-4 py-2 rounded-lg transition-colors font-bold w-full sm:w-auto text-center">
                                ← Voltar
                            </a>
                        @else
                            <a href="/admin/dashboard?status=inativos" class="text-sm bg-slate-800 hover:bg-slate-700 border border-slate-600 text-slate-300 px-3 py-2 rounded-lg transition-colors font-bold flex-1 sm:flex-none text-center">
                                Inativos
                            </a>
                            <button x-data @click="$dispatch('abrir-modal-aluno')" class="text-sm bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg transition-colors font-bold flex-1 sm:flex-none text-center">
                                + Novo Aluno
                            </button>
                        @endif
                    </div>
                </div>

                <div class="w-full">
                    <table class="w-full text-left border-collapse">
                        <thead class="hidden md:table-header-group">
                            <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest">
                                <th class="px-6 py-4 font-bold">Nome do Atleta</th>
                                <th class="px-6 py-4 font-bold">Idade / Peso</th>
                                <th class="px-6 py-4 font-bold">Cadastro</th>
                                <th class="px-6 py-4 font-bold text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700 flex flex-col md:table-row-group">
                            @forelse($atletas as $atleta)
                            <tr class="hover:bg-slate-700/30 transition-colors flex flex-col md:table-row py-4 md:py-0">

                                <td class="px-4 md:px-6 py-1 md:py-4 text-white md:table-cell flex flex-col md:flex-row">
                                    <span class="md:hidden text-xs text-orange-400 font-bold uppercase mb-1">Nome</span>
                                    <span class="font-medium text-lg md:text-base">{{ $atleta->nome }}</span>
                                </td>

                                <td class="px-4 md:px-6 py-1 md:py-4 text-slate-400 md:table-cell flex items-center md:items-start">
                                    <span class="md:hidden text-xs text-slate-500 font-bold uppercase w-20">Físico:</span>
                                    {{ $atleta->idade }} anos | {{ $atleta->peso }} kg
                                </td>

                                <td class="px-4 md:px-6 py-1 md:py-4 text-slate-400 text-sm md:text-xs md:table-cell flex items-center md:items-start">
                                    <span class="md:hidden text-xs text-slate-500 font-bold uppercase w-20">Entrou:</span>
                                    <span class="hidden md:inline">Membro desde:<br></span>
                                    <span class="text-white font-semibold text-sm">
                                        @if($atleta->criado_data)
                                            {{ \Carbon\Carbon::parse($atleta->criado_data)->format('d/m/Y') }}
                                        @else
                                            <span class="text-slate-500 italic text-xs">Não registrada</span>
                                        @endif
                                    </span>
                                </td>

                                <td class="px-4 md:px-6 pt-4 pb-2 md:py-4 text-center md:table-cell">
                                    <div class="flex gap-2 justify-start md:justify-center w-full">
                                        @if($filtro == 'inativos')
                                            <form action="/admin/alunos/{{ $atleta->idAtleta }}/restaurar" method="POST" class="w-full">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="w-full bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 px-3 py-2.5 md:py-1.5 rounded-lg text-xs font-bold transition-all border border-blue-500/30">
                                                    RESTAURAR CADASTRO
                                                </button>
                                            </form>
                                        @else
                                            <button onclick="abrirModalEdicao({{ json_encode($atleta) }})" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white px-3 py-2.5 md:py-1.5 rounded-lg text-xs font-bold transition-all border border-slate-600">
                                                EDITAR
                                            </button>
                                            @php
                                                $valorPlano = $atleta->plano ? ($atleta->plano->valor_padrao ?? $atleta->plano->valor ?? 0) : 0;
                                                $ultimoPgto = $atleta->pagamentos->sortByDesc('data_pagamento')->first();
                                                $dataUltimo = $ultimoPgto ? \Carbon\Carbon::parse($ultimoPgto->data_pagamento)->format('d/m/Y') : 'Nenhum';
                                                $dataVenc = $atleta->data_vencimento ? \Carbon\Carbon::parse($atleta->data_vencimento)->format('d/m/Y') : 'N�o definido';
                                            @endphp
                                            <button onclick="abrirModalPagamento({{ $atleta->idAtleta }}, '{{ addslashes($atleta->nome) }}', {{ $valorPlano }}, '{{ $dataUltimo }}', '{{ $dataVenc }}')" class="flex-1 bg-green-500/10 hover:bg-green-500/20 text-green-400 px-3 py-2.5 md:py-1.5 rounded-lg text-xs font-bold transition-all border border-green-500/30">
                                                $ PAGAMENTO
                                            </button>
                                            @if($filtro == 'inativos')
                                                <form action="/admin/alunos/{{ $atleta->idAtleta }}/restaurar" method="POST" class="inline flex-1 flex" onsubmit="return confirm('Deseja restaurar este aluno para os ativos?');">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="w-full bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 px-3 py-2.5 md:py-1.5 rounded-lg text-xs font-bold transition-all border border-blue-500/30">
                                                        RESTAURAR
                                                    </button>
                                                </form>
                                            @else
                                                <button onclick="abrirModalExclusao({{ $atleta->idAtleta }}, '{{ addslashes($atleta->nome) }}')" class="flex-1 bg-red-500/10 hover:bg-red-500/20 text-red-400 px-3 py-2.5 md:py-1.5 rounded-lg text-xs font-bold transition-all border border-red-500/30">
                                                    EXCLUIR
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500 italic">Nenhum atleta cadastrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg overflow-hidden mt-10">
                <div class="px-6 py-4 border-b border-slate-700 bg-slate-700/30 flex justify-between">
                    <h2 class="text-lg font-bold text-white uppercase tracking-tight">Equipe de Treinadores</h2>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-700/50 text-slate-400 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nome</th>
                                <th class="px-6 py-4 font-bold">CREF</th>
                                <th class="px-6 py-4 font-bold">Vínculo</th>
                                <th class="px-6 py-4 text-center font-bold">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @if(isset($treinadores))
                                @forelse($treinadores as $t)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 text-white font-medium capitalize">{{ $t->user->name ?? 'Sem Nome' }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $t->cref != '0000000000' ? $t->cref : 'Não Informado' }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $t->tipo_vinculo }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <button onclick="editarTreinador({{ json_encode($t) }})" class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-slate-600">
                                                EDITAR
                                            </button>
                                            <button onclick="abrirModalPagamentoTreinador({{ $t->id }}, '{{ addslashes($t->user->name ?? '') }}', {{ $t->salario ?? 0 }})" class="bg-green-500/10 hover:bg-green-500/20 text-green-400 px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-green-500/30">
                                                $ PAGAR
                                            </button>
                                            <form action="/admin/treinadores/{{ $t->id }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este treinador e o seu acesso?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-red-500/30">
                                                    EXCLUIR
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 italic">Nenhum treinador cadastrado.</td>
                                </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

    
@endsection




    