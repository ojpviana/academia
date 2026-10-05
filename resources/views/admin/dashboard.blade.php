@extends('layouts.admin')

@section('title', 'Admin Dashboard - GymPro')
@section('header_title', 'Vis√£o Geral')

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
                                ‚Üê Voltar
                            </a>
                        @else
                            <a href="/admin/dashboard?status=inativos" class="text-sm bg-slate-800 hover:bg-slate-700 border border-slate-600 text-slate-300 px-3 py-2 rounded-lg transition-colors font-bold flex-1 sm:flex-none text-center">
                                Inativos
                            </a>
                            <button onclick="abrirModal()" class="text-sm bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg transition-colors font-bold flex-1 sm:flex-none text-center">
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
                                <th class="px-6 py-4 font-bold text-center">A√ß√µes</th>
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
                                    <span class="md:hidden text-xs text-slate-500 font-bold uppercase w-20">F√≠sico:</span>
                                    {{ $atleta->idade }} anos | {{ $atleta->peso }} kg
                                </td>

                                <td class="px-4 md:px-6 py-1 md:py-4 text-slate-400 text-sm md:text-xs md:table-cell flex items-center md:items-start">
                                    <span class="md:hidden text-xs text-slate-500 font-bold uppercase w-20">Entrou:</span>
                                    <span class="hidden md:inline">Membro desde:<br></span>
                                    <span class="text-white font-semibold text-sm">
                                        @if($atleta->criado_data)
                                            {{ \Carbon\Carbon::parse($atleta->criado_data)->format('d/m/Y') }}
                                        @else
                                            <span class="text-slate-500 italic text-xs">N√£o registrada</span>
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
                                            <button onclick="abrirModalPagamento({{ $atleta->idAtleta }}, '{{ $atleta->nome }}')" class="flex-1 bg-green-500/10 hover:bg-green-500/20 text-green-400 px-3 py-2.5 md:py-1.5 rounded-lg text-xs font-bold transition-all border border-green-500/30">
                                                $ PAGAMENTO
                                            </button>
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
                                <th class="px-6 py-4 font-bold">V√≠nculo</th>
                                <th class="px-6 py-4 text-center font-bold">A√ß√µes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @if(isset($treinadores))
                                @forelse($treinadores as $t)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 text-white font-medium capitalize">{{ $t->user->name ?? 'Sem Nome' }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $t->cref != '0000000000' ? $t->cref : 'N√£o Informado' }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $t->tipo_vinculo }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex gap-2 justify-center">
                                            <button onclick="editarTreinador({{ json_encode($t) }})" class="bg-slate-700 hover:bg-slate-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-slate-600">
                                                EDITAR
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

    <div id="modalCadastro" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4 overflow-y-auto pt-10 pb-10">
    <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-4xl shadow-2xl relative my-auto">
        <button onclick="fecharModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        
        <h2 class="text-2xl font-bold text-white mb-2" id="titleModalAtleta">Cadastrar Novo Atleta</h2>
        <p class="text-slate-400 text-sm mb-6">Preencha os dados completos do aluno, histÛrico de sa˙de e pacote de pagamento.</p>

        <!-- Menu de Abas -->
        <div class="flex border-b border-slate-700 mb-6 overflow-x-auto whitespace-nowrap">
            <button type="button" id="tabBtn1" onclick="switchTab(1)" class="px-6 py-3 font-bold text-sm text-orange-500 border-b-2 border-orange-500 hover:text-orange-400 transition-colors focus:outline-none">
                1. Dados Pessoais
            </button>
            <button type="button" id="tabBtn2" onclick="switchTab(2)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                2. DocumentaÁ„o
            </button>
            <button type="button" id="tabBtn3" onclick="switchTab(3)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                3. Sa˙de (PAR-Q)
            </button>
            <button type="button" id="tabBtn4" onclick="switchTab(4)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                4. Plano e Pgto
            </button>
        </div>

        <!-- FORMUL¡RIO ⁄NICO -->
        <form action="/admin/alunos" method="POST" id="formAtleta" class="space-y-6">
            @csrf
            <!-- Input oculto para PUT na ediÁ„o -->
            <input type="hidden" name="_method" value="POST" id="methodAtleta">

            <!-- ABA 1: DADOS PESSOAIS -->
            <div id="tabContent1" class="block">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Nome Completo *</label>
                        <input type="text" name="nome" id="inputAtletaNome" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">E-mail (Login) *</label>
                        <input type="email" name="email" id="inputAtletaEmail" required placeholder="aluno@email.com" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">WhatsApp</label>
                        <input type="text" name="telefone" id="inputAtletaTelefone" placeholder="(00) 00000-0000" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div class="grid grid-cols-2 gap-4 col-span-1 md:col-span-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Idade *</label>
                            <input type="number" name="idade" id="inputAtletaIdade" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Peso (kg) *</label>
                            <input type="number" step="0.01" name="peso" id="inputAtletaPeso" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" onclick="switchTab(2)" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-8 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        AvanÁar
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l7-7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- ABA 2: DOCUMENTA«√O -->
            <div id="tabContent2" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-1">CPF</label>
                        <input type="text" name="cpf" id="inputAtletaCpf" placeholder="000.000.000-00" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-1">CEP</label>
                        <input type="text" name="cep" id="inputAtletaCep" placeholder="00000-000" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-slate-400 mb-1">EndereÁo (Rua, Av.)</label>
                        <input type="text" name="endereco" id="inputAtletaEndereco" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-slate-400 mb-1">N˙mero</label>
                        <input type="text" name="numero" id="inputAtletaNumero" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Bairro</label>
                        <input type="text" name="bairro" id="inputAtletaBairro" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Cidade</label>
                        <input type="text" name="cidade" id="inputAtletaCidade" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-slate-400 mb-1">UF</label>
                        <input type="text" name="estado" id="inputAtletaEstado" placeholder="SP" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 uppercase transition-colors">
                    </div>
                </div>

                <div class="mt-8 flex justify-between gap-4">
                    <button type="button" onclick="switchTab(1)" class="bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar
                    </button>
                    <button type="button" onclick="switchTab(3)" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-8 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        AvanÁar
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l7-7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- ABA 3: SA⁄DE (PAR-Q) -->
            <div id="tabContent3" class="hidden space-y-6">
                <!-- PAR-Q -->
                <div class="bg-slate-900 p-5 rounded-xl border border-slate-700">
                    <h3 class="text-sm font-bold text-orange-500 uppercase tracking-widest mb-4">Question·rio PAR-Q</h3>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-slate-700/50 gap-2">
                            <span>Sente dor no peito ao praticar atividades fÌsicas?</span>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="par_q[dor_peito]" value="1" class="text-orange-500 bg-slate-700 border-slate-600"> Sim</label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="par_q[dor_peito]" value="0" checked class="text-orange-500 bg-slate-700 border-slate-600"> N„o</label>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 border-b border-slate-700/50 gap-2">
                            <span>Tem histÛrico de problemas cardÌacos?</span>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="par_q[cardiaco]" value="1" class="text-orange-500 bg-slate-700 border-slate-600"> Sim</label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="par_q[cardiaco]" value="0" checked class="text-orange-500 bg-slate-700 border-slate-600"> N„o</label>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-3 gap-2">
                            <span>Costuma ter tonturas ou desmaios freq¸entes?</span>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="par_q[tontura]" value="1" class="text-orange-500 bg-slate-700 border-slate-600"> Sim</label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="par_q[tontura]" value="0" checked class="text-orange-500 bg-slate-700 border-slate-600"> N„o</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Anamnese -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Cirurgias Anteriores</label>
                        <textarea name="anamnese[cirurgias]" rows="2" placeholder="Descreva se houver..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">MedicaÁ„o ContÌnua</label>
                        <textarea name="anamnese[medicacoes]" rows="2" placeholder="Descreva se houver..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Objetivo Principal do Treino</label>
                        <input type="text" name="anamnese[objetivo]" placeholder="Ex: Hipertrofia, Emagrecimento, ReabilitaÁ„o..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                </div>

                <div class="mt-8 flex justify-between gap-4">
                    <button type="button" onclick="switchTab(2)" class="bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar
                    </button>
                    <button type="button" onclick="switchTab(4)" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-8 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        AvanÁar
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l7-7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            <!-- ABA 4: PLANO E PGTO -->
            <div id="tabContent4" class="hidden">
                <div class="bg-slate-900 p-6 rounded-xl border border-slate-700">
                    <h3 class="text-sm font-bold text-green-500 uppercase tracking-widest mb-4">VÌnculo Financeiro</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Select do Plano -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Plano Vinculado</label>
                            <div class="relative">
                                <select name="plano_id" id="selectAtletaPlano" class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors appearance-none">
                                    <option value="">Nenhum / Escolher depois</option>
                                    @foreach(\App\Models\Plano::orderBy('nome')->get() as $plano)
                                        <option value="{{ $plano->id }}">{{ $plano->nome }} (R$ {{ number_format($plano->valor_padrao, 2, ',', '.') }})</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Select da Forma de Pgto -->
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Forma de Pagamento</label>
                            <div class="relative">
                                <select name="forma_pagamento_id" id="selectAtletaForma" class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors appearance-none">
                                    <option value="">Selecione...</option>
                                    @foreach(\App\Models\FormaPagamento::orderBy('nome')->get() as $forma)
                                        <option value="{{ $forma->id }}">{{ $forma->nome }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Data de Vencimento Base -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">PrÛximo Vencimento</label>
                            <input type="date" name="data_vencimento" id="inputAtletaVencimento" class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors">
                        </div>
                    </div>
                </div>

                <p class="text-xs text-orange-400 font-bold mt-4 text-center">* A senha padr„o de acesso ao app do aluno ser·: gympro123</p>

                <div class="mt-8 flex justify-between gap-4">
                    <button type="button" onclick="switchTab(3)" class="bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar
                    </button>

                    <!-- ⁄NICO BOT√O SUBMIT DO MODAL -->
                    <button type="submit" id="btnSubmitAtleta" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-orange-900/20 uppercase tracking-widest flex items-center justify-center focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Salvar Cadastro
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
      <div id="modalEdicao" class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4 overflow-y-auto pt-10 pb-10">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-4xl shadow-2xl relative my-auto">
            <button onclick="fecharModalEdicao()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <h2 class="text-2xl font-bold text-white mb-1">Editar e Enriquecer Ficha</h2>
            <p class="text-slate-400 text-xs mb-6 uppercase tracking-widest font-bold text-orange-500">Defini√ß√£o de Plano e Treinador</p>

            <form id="formEdicao" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">Nome Completo</label>
                        <input type="text" name="nome" id="edit_nome" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 outline-none focus:border-orange-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">Idade</label>
                        <input type="number" name="idade" id="edit_idade" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1 uppercase">Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" id="edit_peso" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 outline-none">
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">Plano e Financeiro</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Plano</label>
                            <select name="plano_tipo" id="edit_plano_tipo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                                <option value="Mensal">Mensal</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Anual">Anual</option>
                                <option value="Gympass">Gympass</option>
                                <option value="TotalPass">TotalPass</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Modalidade</label>
                            <select name="modalidades" id="edit_modalidades" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                                <option value="Muscula√ß√£o">Muscula√ß√£o</option>
                                <option value="Nata√ß√£o">Nata√ß√£o</option>
                                <option value="Lutas">Lutas</option>
                                <option value="Pilates">Pilates</option>
                                <option value="Completo">Completo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Pagamento</label>
                            <select name="forma_pagamento" id="edit_forma_pagamento" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                                <option value="Cart√£o Recorrente">Cart√£o Recorrente</option>
                                <option value="Pix">Pix</option>
                                <option value="Boleto">Boleto</option>
                                <option value="Dinheiro">Dinheiro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Vencimento</label>
                            <input type="date" name="data_vencimento" id="edit_data_vencimento" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-emerald-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">Treino e Sa√∫de</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Freq. Semanal</label>
                                <select name="frequencia_semanal" id="edit_frequencia_semanal" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                                    <option value="2">2x</option>
                                    <option value="3">3x</option>
                                    <option value="4">4x</option>
                                    <option value="5">5x</option>
                                    <option value="6">6x</option>
                                    <option value="7">Todos os dias</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Objetivo</label>
                                <select name="objetivo" id="edit_objetivo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                                    <option value="Emagrecimento">Emagrecimento</option>
                                    <option value="Hipertrofia">Hipertrofia</option>
                                    <option value="Condicionamento">Condicionamento</option>
                                    <option value="Reabilita√ß√£o">Reabilita√ß√£o</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Treinador Respons√°vel</label>
                            <select name="treinador_id" id="edit_treinador_id" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                                <option value="">Sem treinador espec√≠fico</option>
                                @if(isset($treinadores))
                                    @foreach($treinadores as $treinador)
                                        <option value="{{ $treinador->id }}">
                                            {{ $treinador->user->name ?? 'Sem Nome' }} {{ $treinador->cref != '0000000000' ? '('.$treinador->cref.')' : '' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Anamnese / PAR-Q</label>
                            <textarea name="anamnese" id="edit_anamnese" rows="2" placeholder="Les√µes, problemas de sa√∫de..." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500 resize-none"></textarea>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Atestado M√©dico (Atualizar PDF/Imagem)</label>
                            <input type="file" name="atestado_medico" accept=".pdf,image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30 bg-slate-700 border border-slate-600 rounded-lg p-1 transition-all cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-4 border-t border-slate-700">
                    <button type="button" onclick="document.getElementById('formExcluir').submit();" class="text-red-500 hover:text-red-400 text-xs font-bold uppercase tracking-widest px-4 py-2 border border-red-500/30 rounded-lg hover:bg-red-500/10 transition-all">
                        Excluir Atleta
                    </button>

                    <button type="submit" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition-all uppercase tracking-widest shadow-lg shadow-orange-900/20">
                        Salvar Altera√ß√µes
                    </button>
                </div>
            </form>

            <form id="formExcluir" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    <div id="modalTreinador" class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4 overflow-y-auto py-10">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-4xl shadow-2xl relative my-auto">
            <button onclick="fecharModalTreinador()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 id="tituloModalTreinador" class="text-2xl font-bold text-white mb-2">Cadastrar Treinador</h2>
            <p class="text-slate-400 text-sm mb-6">Preencha os dados contratuais e de acesso do treinador.</p>

            @if($errors->any() && old('cref'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl mb-6 text-sm font-bold">
                    ‚ö†Ô∏è Aten√ß√£o:
                    <ul class="list-disc pl-5 mt-1 font-normal">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formTreinador" action="/admin/treinadores" method="POST" class="space-y-6">
                @csrf
                <div id="metodoTreinador"></div> <div>
                    <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">1. Identifica√ß√£o e Login</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Nome Completo</label>
                            <input type="text" name="name" id="treinador_name" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">E-mail de Acesso</label>
                            <input type="email" name="email" id="treinador_email" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">CPF</label>
                            <input type="text" name="cpf" id="treinador_cpf" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">RG</label>
                            <input type="text" name="rg" id="treinador_rg" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Nascimento</label>
                            <input type="date" name="data_nascimento" id="treinador_data_nascimento" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-orange-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">2. Contrato e CREF</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">N√∫mero CREF *</label>
                            <input type="text" name="cref" id="treinador_cref" required placeholder="000000-G/UF" class="w-full bg-slate-700 border border-orange-500/50 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">V√≠nculo</label>
                            <select name="tipo_vinculo" id="treinador_tipo_vinculo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                                <option value="PJ">PJ (Prestador)</option>
                                <option value="CLT">CLT (Registro)</option>
                                <option value="Aut√¥nomo">Aut√¥nomo (Personal)</option>
                                <option value="Estagi√°rio">Estagi√°rio</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Turno / Hor√°rio</label>
                            <input type="text" name="turno_horario" id="treinador_turno_horario" placeholder="Ex: Seg a Sex, 06h √†s 14h" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-emerald-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">3. Financeiro e Contato</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Telefone/WhatsApp</label>
                            <input type="text" name="telefone" id="treinador_telefone" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Endere√ßo Completo</label>
                            <input type="text" name="endereco_completo" id="treinador_endereco_completo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Modelo de Remunera√ß√£o</label>
                            <input type="text" name="modelo_remuneracao" id="treinador_modelo_remuneracao" placeholder="Ex: R$ 25/hora + Fixo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Dados Banc√°rios (Chave PIX / Banco)</label>
                            <input type="text" name="dados_bancarios" id="treinador_dados_bancarios" placeholder="Banco XPTO, Ag 000, C/c 000 - PIX: cpf..." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Senha Provis√≥ria <span class="text-[10px] italic text-slate-500">(Deixe em branco para n√£o alterar na edi√ß√£o)</span></label>
                        <input type="text" name="password" id="treinador_password" value="professor123" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <button type="submit" id="btnSalvarTreinador" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl mt-6 transition-all shadow-lg shadow-blue-900/20 uppercase tracking-widest">
                    Cadastrar
                </button>
            </form>
        </div>
    </div>
    <div id="modalPagamento" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-md shadow-2xl relative">
            <button onclick="fecharModalPagamento()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-2xl font-bold text-white mb-1">Pagamento</h2>
            <p id="nomeAlunoPagamento" class="text-orange-400 font-medium mb-6 text-sm"></p>
            <form action="/admin/pagamentos" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="atleta_id" id="atleta_id_input">
                <input type="hidden" name="status" value="Pago">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Valor do Recebimento (R$)</label>
                    <input type="number" step="0.01" name="valor" placeholder="0,00" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:border-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Data</label>
                    <input type="date" name="data_pagamento" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 outline-none">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg mt-4 transition-all">Confirmar Pagamento</button>
            </form>
        </div>
    </div>

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
            @if($errors->any() && !old('cref'))
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

    @if(session('success'))
        <div id="toast-sucesso" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center transition-all duration-500 transform translate-y-0 opacity-100">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
        @endsection

@section('scripts')
<script>
            setTimeout(() => {
                const toast = document.getElementById('toast-sucesso');
                if(toast){
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <script>
        function toggleMobileMenu() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.relative')) {
                const dropdown = document.getElementById('perfilDropdown');
                if(dropdown) dropdown.classList.add('hidden');
            }
        }
        // --- ATLETAS ---
        function abrirModal() { document.getElementById('modalCadastro').classList.remove('hidden'); switchTab(1); }
        function fecharModal() { document.getElementById('modalCadastro').classList.add('hidden'); }

                function switchTab(tabIndex) {
            for (let i = 1; i <= 4; i++) {
                const btn = document.getElementById('tabBtn' + i);
                const content = document.getElementById('tabContent' + i);
                
                if (btn && content) {
                    if (i === tabIndex) {
                        content.classList.remove('hidden');
                        content.classList.add('block');
                        btn.className = "px-6 py-3 font-bold text-sm text-orange-500 border-b-2 border-orange-500 hover:text-orange-400 transition-colors focus:outline-none";
                    } else {
                        content.classList.add('hidden');
                        content.classList.remove('block');
                        btn.className = "px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none";
                    }
                }
            }
        }
        function abrirModalEdicao(atleta) {
            document.getElementById('edit_nome').value = atleta.nome || '';
            document.getElementById('edit_idade').value = atleta.idade || '';
            document.getElementById('edit_peso').value = atleta.peso || '';
            document.getElementById('edit_plano_tipo').value = atleta.plano_tipo || 'Mensal';
            document.getElementById('edit_modalidades').value = atleta.modalidades || 'Muscula√ß√£o';
            document.getElementById('edit_forma_pagamento').value = atleta.forma_pagamento || 'Pix';
            if(atleta.data_vencimento) document.getElementById('edit_data_vencimento').value = atleta.data_vencimento.substring(0, 10);
            document.getElementById('edit_frequencia_semanal').value = atleta.frequencia_semanal || '3';
            document.getElementById('edit_objetivo').value = atleta.objetivo || 'Emagrecimento';
            document.getElementById('edit_treinador_id').value = atleta.treinador_id || '';
            document.getElementById('edit_anamnese').value = atleta.anamnese || '';

            document.getElementById('formEdicao').action = '/admin/alunos/' + atleta.idAtleta;
            document.getElementById('formExcluir').action = '/admin/alunos/' + atleta.idAtleta;

            document.getElementById('modalEdicao').classList.remove('hidden');
        }
        function fecharModalEdicao() { document.getElementById('modalEdicao').classList.add('hidden'); }

        function abrirModalPagamento(id, nome) {
            document.getElementById('atleta_id_input').value = id;
            document.getElementById('nomeAlunoPagamento').innerText = "Registrando para: " + nome;
            document.getElementById('modalPagamento').classList.remove('hidden');
        }
        function fecharModalPagamento() { document.getElementById('modalPagamento').classList.add('hidden'); }


        // --- TREINADORES (A MAGIA DE CADASTRO/EDI√á√ÉO) ---
        function abrirModalTreinador() {
            // Prepara para Cadastrar
            document.getElementById('tituloModalTreinador').innerText = 'Cadastrar Treinador';
            document.getElementById('btnSalvarTreinador').innerText = 'Cadastrar';
            document.getElementById('formTreinador').action = '/admin/treinadores';
            document.getElementById('formTreinador').reset();
            document.getElementById('metodoTreinador').innerHTML = ''; // Remove o PUT
            document.getElementById('treinador_password').required = true;

            document.getElementById('modalTreinador').classList.remove('hidden');
        }

        function fecharModalTreinador() { document.getElementById('modalTreinador').classList.add('hidden'); }

        function editarTreinador(treinador) {
            // Prepara para Editar
            document.getElementById('tituloModalTreinador').innerText = 'Editar Treinador';
            document.getElementById('btnSalvarTreinador').innerText = 'Salvar Altera√ß√µes';
            document.getElementById('formTreinador').action = '/admin/treinadores/' + treinador.id;

            // Adiciona o m√©todo PUT
            document.getElementById('metodoTreinador').innerHTML = '<input type="hidden" name="_method" value="PUT">';

            // Preenche os dados
            document.getElementById('treinador_name').value = treinador.user ? treinador.user.name : '';
            document.getElementById('treinador_email').value = treinador.user ? treinador.user.email : '';
            document.getElementById('treinador_cpf').value = treinador.cpf || '';
            document.getElementById('treinador_rg').value = treinador.rg || '';
            if(treinador.data_nascimento) document.getElementById('treinador_data_nascimento').value = treinador.data_nascimento.substring(0, 10);
            document.getElementById('treinador_cref').value = treinador.cref || '';
            document.getElementById('treinador_tipo_vinculo').value = treinador.tipo_vinculo || 'PJ';
            document.getElementById('treinador_turno_horario').value = treinador.turno_horario || '';
            document.getElementById('treinador_telefone').value = treinador.telefone || '';
            document.getElementById('treinador_endereco_completo').value = treinador.endereco_completo || '';
            document.getElementById('treinador_modelo_remuneracao').value = treinador.modelo_remuneracao || '';
            document.getElementById('treinador_dados_bancarios').value = treinador.dados_bancarios || '';

            // Deixa a senha vazia e n√£o obrigat√≥ria
            document.getElementById('treinador_password').value = '';
            document.getElementById('treinador_password').required = false;

            document.getElementById('modalTreinador').classList.remove('hidden');
        }

        // --- SENHA E OUTROS ---
        function abrirModalSenha() { document.getElementById('modalSenha').classList.remove('hidden'); }
        function fecharModalSenha() { document.getElementById('modalSenha').classList.add('hidden'); }

        @if(session('success_password') || $errors->has('current_password') || $errors->has('new_password'))
            abrirModalSenha();
        @endif

        function buscarCEP(cep) {
            let cepLimpo = cep.replace(/\D/g, '');
            if (cepLimpo.length === 8) {
                fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('endereco').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        }
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        }

        @if($errors->any())
            @if(old('cref'))
                document.getElementById('modalTreinador').classList.remove('hidden');
            @elseif(old('_method') == 'PUT')
                // Erro na edi√ß√£o: precisa reabrir manualmente por causa do objeto do atleta
            @else
                abrirModal();
            @endif
        @endif
    
    if (window.location.search.includes('open_senha=1')) { abrirModalSenha(); }
</script>
@endsection


