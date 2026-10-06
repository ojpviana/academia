<div id="modal-cadastro-aluno" x-data="{ open: false }" x-show="open" @abrir-modal-aluno.window="open = true" @abrir-modal-aluno-novo.window="open = true; document.getElementById('titleModalAtleta').innerText = 'Cadastrar Novo Atleta'; document.getElementById('formAtleta').action = '/admin/alunos'; document.getElementById('methodAtleta').value = 'POST'; document.getElementById('btnSubmitAtleta').innerHTML = '<svg class=\'w-5 h-5 mr-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Salvar Cadastro'; document.getElementById('formAtleta').reset(); if(typeof switchTab === 'function') switchTab(1);" style="display: none;" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm flex items-center justify-center z-50 px-4 overflow-y-auto pt-10 pb-10">
    <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden w-full max-w-4xl shadow-2xl relative my-auto">
        <div class="modal-body-scroll p-8 relative">
        <button @click="open = false" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        
        <h2 class="text-2xl font-bold text-white mb-2" id="titleModalAtleta">Cadastrar Novo Atleta</h2>
        <p class="text-slate-400 text-sm mb-6">Preencha os dados completos do aluno, histórico de saúde e pacote de pagamento.</p>

        <!-- Menu de Abas -->
        <div class="flex border-b border-slate-700 mb-6 overflow-x-auto whitespace-nowrap">
            <button type="button" id="tabBtn1" onclick="switchTab(1)" class="px-6 py-3 font-bold text-sm text-orange-500 border-b-2 border-orange-500 hover:text-orange-400 transition-colors focus:outline-none">
                1. Dados Pessoais
            </button>
            <button type="button" id="tabBtn2" onclick="switchTab(2)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                2. Documentação
            </button>
            <button type="button" id="tabBtn3" onclick="switchTab(3)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                3. Saúde (PAR-Q)
            </button>
            <button type="button" id="tabBtn4" onclick="switchTab(4)" class="px-6 py-3 font-bold text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-300 transition-colors focus:outline-none">
                4. Plano e Pagamento
            </button>
        </div>

        <!-- FORMULÁRIO ÚNICO -->
        <form action="/admin/alunos" method="POST" id="formAtleta" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <!-- Input oculto para PUT na edi��o -->
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
                        Avan�ar
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 12h14"></path></svg>
                    </button>
                </div>
            </div>

            <!-- ABA 2: DOCUMENTA��O -->
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
                        <label class="block text-sm font-medium text-slate-400 mb-1">Endereço (Rua, Av.)</label>
                        <input type="text" name="endereco" id="inputAtletaEndereco" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500 transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Número</label>
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
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M19 12H5"></path></svg>
                        Voltar
                    </button>
                    <button type="button" onclick="switchTab(3)" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-8 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        Avan�ar
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 12h14"></path></svg>
                    </button>
                </div>
            </div>

            <!-- ABA 3: SADE (PAR-Q) e ANAMNESE -->
            <div id="tabContent3" class="hidden space-y-6">
                
                                    <div class="mb-6">
                        <label class="block text-sm font-bold text-white mb-2 flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Objetivo Principal do Treino
                        </label>
                        <input type="text" name="objetivo" placeholder="Ex: Hipertrofia, Emagrecimento, Reabilitação..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl p-4 focus:outline-none focus:border-orange-500 transition-colors shadow-inner">
                    </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bot�o Modal PAR-Q -->
                    <button type="button" onclick="abrirModalParQ()" class="flex flex-col items-center justify-center p-8 bg-slate-900 border border-slate-700 hover:border-orange-500 rounded-xl transition-all group focus:outline-none">
                        <div class="w-16 h-16 bg-orange-500/20 text-orange-500 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Questionário PAR-Q</h3>
                        <p class="text-sm text-slate-400 text-center">7 perguntas padrão obrigatórias para prontidão física.</p>
                    </button>

                    <!-- Bot�o Modal Anamnese -->
                    <button type="button" onclick="abrirModalAnamnese()" class="flex flex-col items-center justify-center p-8 bg-slate-900 border border-slate-700 hover:border-blue-500 rounded-xl transition-all group focus:outline-none">
                        <div class="w-16 h-16 bg-blue-500/20 text-blue-500 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Anamnese Completa</h3>
                        <p class="text-sm text-slate-400 text-center">Histórico médico, lesões, medicações e estilo de vida.</p>
                    </button>
                </div>

                <!-- Atestado M�dico -->
                <div class="bg-slate-900 p-6 rounded-xl border border-slate-700 mt-6">
                    <label class="block text-sm font-bold text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Anexar Atestado Médico
                    </label>
                    <input type="file" name="atestado_medico" accept=".pdf, image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30 border border-slate-700 border-dashed p-4 rounded-xl cursor-pointer">
                    <p class="text-xs text-slate-500 mt-2">Formatos aceitos: PDF, JPG, PNG (Max 5MB).</p>
                </div>

                <div class="mt-8 flex justify-between gap-4">
                    <button type="button" onclick="switchTab(2)" class="bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M19 12H5"></path></svg>
                        Voltar
                    </button>
                    <button type="button" onclick="switchTab(4)" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-8 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        Avan�ar
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 12h14"></path></svg>
                    </button>
                </div>
            </div>

            <!-- ABA 4: PLANO E PGTO -->
            <div id="tabContent4" class="hidden">
                <div class="bg-slate-900 p-6 rounded-xl border border-slate-700">
                    <h3 class="text-sm font-bold text-green-500 uppercase tracking-widest mb-4">Vínculo Financeiro</h3>
                                        <div class="mb-6">
                        <label class="block text-sm font-bold text-white mb-2 flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Objetivo Principal do Treino
                        </label>
                        <input type="text" name="objetivo" placeholder="Ex: Hipertrofia, Emagrecimento, Reabilitação..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl p-4 focus:outline-none focus:border-orange-500 transition-colors shadow-inner">
                    </div>
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
                            <label class="block text-sm font-medium text-slate-400 mb-1">Próximo Vencimento</label>
                            <input type="date" name="data_vencimento" id="inputAtletaVencimento" class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-green-500 transition-colors">
                        </div>
                    </div>
                </div>

                <p class="text-xs text-orange-400 font-bold mt-4 text-center">* A senha padrão de acesso ao app do aluno será: gympro123</p>

                <div class="mt-8 flex justify-between gap-4">
                    <button type="button" onclick="switchTab(3)" class="bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all border border-slate-600 shadow-sm flex items-center focus:outline-none">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M19 12H5"></path></svg>
                        Voltar
                    </button>
                    <button type="submit" id="btnSubmitAtleta" class="flex-1 bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all flex items-center justify-center focus:outline-none">
                        Salvar Cadastro
                    </button>
                </div>
            </div>
        
<!-- MODAL PAR-Q (Nested in Form) -->
            <div id="modalParQ" class="hidden fixed inset-0 z-[60] bg-slate-900/95 flex items-center justify-center p-4">
                <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden w-full max-w-2xl shadow-2xl relative">
        <div class="modal-body-scroll relative">
                    <div class="sticky top-0 bg-slate-800 border-b border-slate-700 p-6 flex justify-between items-center z-10">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3"><svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg></span>
                            PAR-Q
                        </h2>
                        <button type="button" onclick="fecharModalParQ()" class="text-slate-400 hover:text-white p-2 focus:outline-none"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>
                    <div class="p-6 space-y-5 text-sm text-slate-300">
                        @php
                            $perguntasParq = [
                                'dor_peito' => 'Sente dor no peito ao praticar atividades físicas?',
                                'tontura' => 'Costuma ter tonturas ou desmaios frequentes?',
                                'pressao' => 'Seu médico já disse que você possui pressão arterial alta?',
                                'articular' => 'Possui algum problema ósseo ou articular que poderia piorar com exercícios?',
                                'medicacao' => 'Toma alguma medicação contínua para pressão ou coração?',
                                'coracao' => 'Tem histórico de problemas cardíacos (ex: arritmia, infarto)?',
                                'impeditivo' => 'Existe algum outro motivo físico que o impeça de fazer atividade física?'
                            ];
                        @endphp
                        @foreach($perguntasParq as $chave => $pergunta)
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center pb-4 border-b border-slate-700/50 gap-3">
                                <span>{{ $pergunta }}</span>
                                <div class="flex gap-4 shrink-0">
                                    <label class="flex items-center gap-2 cursor-pointer hover:text-orange-400 transition-colors">
                                        <input type="radio" name="par_q[{{ $chave }}]" value="1" class="text-orange-500 focus:ring-orange-500 bg-slate-900 border-slate-600"> Sim
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer hover:text-orange-400 transition-colors">
                                        <input type="radio" name="par_q[{{ $chave }}]" value="0" checked class="text-orange-500 focus:ring-orange-500 bg-slate-900 border-slate-600"> Não
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-6 border-t border-slate-700 bg-slate-800/50 flex justify-end">
                        <button type="button" onclick="fecharModalParQ()" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-orange-900/20 uppercase tracking-widest focus:outline-none">
                            Salvar Respostas
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL ANAMNESE (Nested in Form) -->
            <div id="modalAnamnese" class="hidden fixed inset-0 z-[60] bg-slate-900/95 flex items-center justify-center p-4">
                <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden w-full max-w-2xl shadow-2xl relative">
        <div class="modal-body-scroll relative">
                    <div class="sticky top-0 bg-slate-800 border-b border-slate-700 p-6 flex justify-between items-center z-10">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3"><svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></span>
                            Anamnese
                        </h2>
                        <button type="button" onclick="fecharModalAnamnese()" class="text-slate-400 hover:text-white p-2 focus:outline-none"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </div>
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Cirurgias Anteriores</label>
                            <textarea name="anamnese[cirurgias]" rows="2" placeholder="Ex: LCA joelho direito em 2021..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Medicações de Uso Contínua</label>
                            <textarea name="anamnese[medicacoes]" rows="2" placeholder="Ex: Losartana 50mg..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Lesões Atuais ou Dores Crônicas</label>
                            <textarea name="anamnese[lesoes]" rows="2" placeholder="Ex: Tendinite no ombro, dor lombar constante..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Histórico Familiar (Doen�as)</label>
                            <textarea name="anamnese[historico_familiar]" rows="2" placeholder="Ex: Pai com hipertens�o, m�e com diabetes..." class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Qualidade do Sono</label>
                                <select name="anamnese[sono]" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors">
                                    <option value="Bom">Bom (7h-8h)</option>
                                    <option value="Regular">Regular (5h-6h)</option>
                                    <option value="Ruim">Ruim / Ins�nia</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="p-6 border-t border-slate-700 bg-slate-800/50 flex justify-end">
                        <button type="button" onclick="fecharModalAnamnese()" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-900/20 uppercase tracking-widest focus:outline-none">
                            Salvar Respostas
                        </button>
                    </div>
                </div>
            </div>
</form>
    </div>
</div>
      <div id="modal-cadastro-treinador" x-data="{ open: false }" x-show="open" @abrir-modal-treinador.window="open = true" @abrir-modal-treinador-novo.window="open = true; document.getElementById('tituloModalTreinador').innerText = 'Cadastrar Treinador'; document.getElementById('formTreinador').action = '/admin/treinadores'; document.getElementById('metodoTreinador').innerHTML = ''; document.getElementById('formTreinador').reset(); document.getElementById('treinador_password').required = true;" style="display: none;" class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm flex items-center justify-center z-50 px-4 overflow-y-auto py-10">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden w-full max-w-4xl shadow-2xl relative my-auto">
        <div class="modal-body-scroll p-8 relative">
            <button @click="open = false" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 id="tituloModalTreinador" class="text-2xl font-bold text-white mb-2">Cadastrar Treinador</h2>
            <p class="text-slate-400 text-sm mb-6">Preencha os dados contratuais e de acesso do treinador.</p>

            @if($errors->any() && old('cref'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl mb-6 text-sm font-bold">
                    ⚠️ Atenção:
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
                    <h3 class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">1. Identificação e Login</h3>
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
                            <label class="block text-sm font-medium text-slate-400 mb-1">Número CREF *</label>
                            <input type="text" name="cref" id="treinador_cref" required placeholder="000000-G/UF" class="w-full bg-slate-700 border border-orange-500/50 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Vínculo</label>
                            <select name="tipo_vinculo" id="treinador_tipo_vinculo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                                <option value="PJ">PJ (Prestador)</option>
                                <option value="CLT">CLT (Registro)</option>
                                <option value="Autônomo">Autônomo (Personal)</option>
                                <option value="Estagiário">Estagiário</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Turno</label>
                            <select name="turno_id" id="treinador_turno_id" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
        <option value="">Selecione o Turno</option>
        @foreach($turnos ?? [] as $t)
            <option value="{{ $t->id }}">{{ $t->nome_turno }} ({{ \Carbon\Carbon::parse($t->hora_inicio)->format("H:i") }} �s {{ \Carbon\Carbon::parse($t->hora_fim)->format("H:i") }})</option>
        @endforeach
    </select>
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
                            <label class="block text-sm font-medium text-slate-400 mb-1">Endereço Completo</label>
                            <input type="text" name="endereco_completo" id="treinador_endereco_completo" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Sal�rio Fixo (R$)</label>
                            <input type="number" step="0.01" name="salario" id="treinador_salario" placeholder="1500.00" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Dados Bancários (Chave PIX / Banco)</label>
                            <input type="text" name="dados_bancarios" id="treinador_dados_bancarios" placeholder="Banco XPTO, Ag 000, C/c 000 - PIX: cpf..." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-slate-400 mb-1">Senha Provisória <span class="text-[10px] italic text-slate-500">(Deixe em branco para não alterar na edição)</span></label>
                        <input type="text" name="password" id="treinador_password" value="professor123" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <button type="submit" id="btnSalvarTreinador" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl mt-6 transition-all shadow-lg shadow-blue-900/20 uppercase tracking-widest">
                    Cadastrar
                </button>
            </form>
            </div>
</div>
    </div>
        <div id="modalPagamento" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl overflow-hidden w-full max-w-md shadow-2xl relative">
            <button onclick="fecharModalPagamento()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-2xl font-bold text-white mb-1">Pagamento</h2>
            <p id="nomeAlunoPagamento" class="text-orange-400 font-medium mb-4 text-sm"></p>
            
            <!-- Hist�rico Visual -->
            <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-700 mb-6 space-y-2">
                <p class="text-xs text-slate-400 font-medium">�ltimo pagamento: <span id="infoUltimoPagamento" class="text-slate-200"></span></p>
                <p class="text-xs text-slate-400 font-medium">Vencimento atual/Pr�ximo: <span id="infoVencimentoAtual" class="text-slate-200"></span></p>
            </div>

            <form action="/admin/pagamentos" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="atleta_id" id="atleta_id_input">
                <input type="hidden" name="status" value="Pago">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Valor do Recebimento (R$)</label>
                    <input type="number" step="0.01" name="valor" id="valorPagamentoInput" placeholder="0,00" required readonly class="w-full bg-slate-900 border border-slate-700 text-slate-400 cursor-not-allowed rounded-lg p-3 outline-none focus:ring-0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Data</label>
                    <input type="date" name="data_pagamento" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 outline-none focus:border-green-500">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg mt-4 transition-all uppercase tracking-widest shadow-lg shadow-green-900/20">Confirmar Pagamento</button>
            </form>
        </div>
    </div>
    </div>

        <!-- Modal Lan�ar Pagamento Treinador -->
    <div id="modalPagamentoTreinador" class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm hidden flex items-center justify-center z-50 px-4 overflow-y-auto py-10">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl overflow-hidden w-full max-w-md shadow-2xl relative my-auto">
            <button onclick="fecharModalPagamentoTreinador()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-2xl font-bold text-white mb-2">Lan�ar Pagamento</h2>
            <p id="nomeTreinadorPagamento" class="text-slate-400 text-sm mb-6"></p>
            <form id="formPagamentoTreinador" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Valor Pago (R$)</label>
                    <input type="number" step="0.01" name="valor" id="valorPagamentoTreinador" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Data do Pagamento</label>
                    <input type="date" name="data_pagamento" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-green-500">
                </div>
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-green-900/20 uppercase tracking-widest">
                    Confirmar Pagamento
                </button>
            </form>
        </div>
    </div>

    <div id="modalSenha" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl overflow-hidden w-full max-w-sm shadow-2xl relative">
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
        
<!-- Modal Exclusao -->
<div id="modalExclusao" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl overflow-hidden w-full max-w-sm shadow-2xl relative text-center">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-500/20 shadow-inner shadow-red-500/20">
                <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-white mb-2">Desativar Aluno?</h2>
            <p class="text-slate-400 text-sm mb-6">
                Tem certeza que deseja desativar o acesso de <br>
                <strong id="nomeAlunoExclusao" class="text-white text-base"></strong>?<br>
                <span class="text-xs mt-2 block opacity-75">O aluno ser� enviado para a lista de Inativos. Nenhuma cobran�a ou ficha de treino ser� deletada do banco.</span>
            </p>

            <form id="formExclusaoAtleta" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="fecharModalExclusao()" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-xl transition-all">Cancelar</button>
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-red-900/20">Sim, Desativar</button>
            </form>
        </div>
    </div>

<script>

function abrirModalExclusao(id, nome) {
            document.getElementById('nomeAlunoExclusao').innerText = nome;
            document.getElementById('formExclusaoAtleta').action = '/admin/alunos/' + id;
            document.getElementById('modalExclusao').classList.remove('hidden');
        }
        function fecharModalExclusao() {
            document.getElementById('modalExclusao').classList.add('hidden');
        }
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
                function abrirModalParQ() { document.getElementById('modalParQ').classList.remove('hidden'); }
        function fecharModalParQ() { document.getElementById('modalParQ').classList.add('hidden'); }
        function abrirModalAnamnese() { document.getElementById('modalAnamnese').classList.remove('hidden'); }
        function fecharModalAnamnese() { document.getElementById('modalAnamnese').classList.add('hidden'); }

        function abrirModal() { document.getElementById('titleModalAtleta').innerText = 'Cadastrar Novo Atleta'; document.getElementById('formAtleta').action = '/admin/alunos'; document.getElementById('methodAtleta').value = 'POST'; document.getElementById('btnSubmitAtleta').innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Salvar Cadastro'; document.getElementById('formAtleta').reset(); window.dispatchEvent(new CustomEvent('abrir-modal-aluno')); switchTab(1); }
        

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
            document.getElementById('titleModalAtleta').innerText = 'Editar Atleta';
            document.getElementById('formAtleta').action = '/admin/alunos/' + atleta.idAtleta;
            document.getElementById('methodAtleta').value = 'PUT';
            document.getElementById('btnSubmitAtleta').innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Salvar Altera��es';

            // Aba 1
            if(document.getElementById('inputAtletaNome')) document.getElementById('inputAtletaNome').value = atleta.nome || '';
            if(document.getElementById('inputAtletaEmail')) document.getElementById('inputAtletaEmail').value = atleta.user ? atleta.user.email : '';
            if(document.getElementById('inputAtletaTelefone')) document.getElementById('inputAtletaTelefone').value = atleta.telefone || '';
            if(document.getElementById('inputAtletaIdade')) document.getElementById('inputAtletaIdade').value = atleta.idade || '';
            if(document.getElementById('inputAtletaPeso')) document.getElementById('inputAtletaPeso').value = atleta.peso || '';

            // Aba 2
            if(document.getElementById('inputAtletaCpf')) document.getElementById('inputAtletaCpf').value = atleta.cpf || '';
            if(document.getElementById('inputAtletaCep')) document.getElementById('inputAtletaCep').value = atleta.cep || '';
            if(document.getElementById('inputAtletaEndereco')) document.getElementById('inputAtletaEndereco').value = atleta.endereco || '';
            if(document.getElementById('inputAtletaNumero')) document.getElementById('inputAtletaNumero').value = atleta.numero || '';
            if(document.getElementById('inputAtletaBairro')) document.getElementById('inputAtletaBairro').value = atleta.bairro || '';
            if(document.getElementById('inputAtletaCidade')) document.getElementById('inputAtletaCidade').value = atleta.cidade || '';
            if(document.getElementById('inputAtletaEstado')) document.getElementById('inputAtletaEstado').value = atleta.estado || '';

            // Aba 3 (Modals)
            try {
                let p = typeof atleta.par_q === 'string' ? JSON.parse(atleta.par_q) : (atleta.par_q || {});
                ['dor_peito', 'tontura', 'pressao', 'articular', 'medicacao', 'coracao', 'impeditivo'].forEach(k => {
                    let el = document.querySelector(`input[name="par_q[${k}]"][value="${p[k] || '0'}"]`);
                    if(el) el.checked = true;
                });
            } catch(e) {}

            try {
                let a = typeof atleta.anamnese === 'string' ? JSON.parse(atleta.anamnese) : (atleta.anamnese || {});
                if(document.querySelector('[name="anamnese[cirurgias]"]')) document.querySelector('[name="anamnese[cirurgias]"]').value = a.cirurgias || '';
                if(document.querySelector('[name="anamnese[medicacoes]"]')) document.querySelector('[name="anamnese[medicacoes]"]').value = a.medicacoes || '';
                if(document.querySelector('[name="anamnese[lesoes]"]')) document.querySelector('[name="anamnese[lesoes]"]').value = a.lesoes || '';
                if(document.querySelector('[name="anamnese[historico_familiar]"]')) document.querySelector('[name="anamnese[historico_familiar]"]').value = a.historico_familiar || '';
                if(document.querySelector('[name="anamnese[sono]"]')) document.querySelector('[name="anamnese[sono]"]').value = a.sono || 'Bom';
                if(document.querySelector('[name="objetivo"]')) document.querySelector('[name="objetivo"]').value = atleta.objetivo || a.objetivo || '';
            } catch(e) {}

            // Aba 4
            if(document.getElementById('selectAtletaPlano')) document.getElementById('selectAtletaPlano').value = atleta.plano_id || '';
            if(document.getElementById('selectAtletaForma')) document.getElementById('selectAtletaForma').value = atleta.forma_pagamento_id || '';
            if(atleta.data_vencimento && document.getElementById('inputAtletaVencimento')) document.getElementById('inputAtletaVencimento').value = atleta.data_vencimento.substring(0, 10);

            window.dispatchEvent(new CustomEvent('abrir-modal-aluno'));
            switchTab(1);
        }
        function fecharModalEdicao() { document.getElementById('modalEdicao').classList.add('hidden'); }

                function abrirModalPagamento(id, nome, valorPlano, dataUltimo, dataVencimento) {
            document.getElementById('atleta_id_input').value = id;
            document.getElementById('nomeAlunoPagamento').innerText = "Registrando para: " + nome;
            
            // Valor do plano (travado)
            document.getElementById('valorPagamentoInput').value = valorPlano || 0;

            // Hist�rico Visual
            if (document.getElementById('infoUltimoPagamento')) {
                document.getElementById('infoUltimoPagamento').innerText = dataUltimo || "Nenhum";
            }
            if (document.getElementById('infoVencimentoAtual')) {
                document.getElementById('infoVencimentoAtual').innerText = dataVencimento || "N�o definido";
            }

            document.getElementById('modalPagamento').classList.remove('hidden');
        }
        function fecharModalPagamento() { document.getElementById('modalPagamento').classList.add('hidden'); }


        // --- TREINADORES (A MAGIA DE CADASTRO/EDIÇÃO) ---
        function x_old_abrirModalTreinador() {
            // Prepara para Cadastrar
            document.getElementById('tituloModalTreinador').innerText = 'Cadastrar Treinador';
            document.getElementById('btnSalvarTreinador').innerText = 'Cadastrar';
            document.getElementById('formTreinador').action = '/admin/treinadores';
            document.getElementById('formTreinador').reset();
            document.getElementById('metodoTreinador').innerHTML = ''; // Remove o PUT
            document.getElementById('treinador_password').required = true;

            window.dispatchEvent(new CustomEvent('abrir-modal-treinador'));
        }

        

        function editarTreinador(treinador) {
            // Prepara para Editar
            document.getElementById('tituloModalTreinador').innerText = 'Editar Treinador';
            document.getElementById('btnSalvarTreinador').innerText = 'Salvar Alterações';
            document.getElementById('formTreinador').action = '/admin/treinadores/' + treinador.id;

            // Adiciona o método PUT
            document.getElementById('metodoTreinador').innerHTML = '<input type="hidden" name="_method" value="PUT">';

            // Preenche os dados
            document.getElementById('treinador_name').value = treinador.user ? treinador.user.name : '';
            document.getElementById('treinador_email').value = treinador.user ? treinador.user.email : '';
            document.getElementById('treinador_cpf').value = treinador.cpf || '';
            document.getElementById('treinador_rg').value = treinador.rg || '';
            if(treinador.data_nascimento) document.getElementById('treinador_data_nascimento').value = treinador.data_nascimento.substring(0, 10);
            document.getElementById('treinador_cref').value = treinador.cref || '';
            document.getElementById('treinador_tipo_vinculo').value = treinador.tipo_vinculo || 'PJ';
            document.getElementById('treinador_turno_id').value = treinador.turno_id || '';
            document.getElementById('treinador_telefone').value = treinador.telefone || '';
            document.getElementById('treinador_endereco_completo').value = treinador.endereco_completo || '';
            document.getElementById('treinador_salario').value = treinador.salario || '';
            document.getElementById('treinador_dados_bancarios').value = treinador.dados_bancarios || '';

            // Deixa a senha vazia e não obrigatória
            document.getElementById('treinador_password').value = '';
            document.getElementById('treinador_password').required = false;

            window.dispatchEvent(new CustomEvent('abrir-modal-treinador'));
        }

        // --- SENHA E OUTROS ---
                function abrirModalPagamentoTreinador(id, nome, salario) {
            document.getElementById('nomeTreinadorPagamento').innerText = "Destinat�rio: " + nome;
            document.getElementById('valorPagamentoTreinador').value = salario;
            document.getElementById('formPagamentoTreinador').action = '/admin/treinadores/' + id + '/pagar';
            document.getElementById('modalPagamentoTreinador').classList.remove('hidden');
        }
        function fecharModalPagamentoTreinador() { document.getElementById('modalPagamentoTreinador').classList.add('hidden'); }

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

                @if($errors->has('erro'))
            alert("{{ $errors->first('erro') }}");
        @elseif($errors->any())
            @if(old('cref'))
                window.dispatchEvent(new CustomEvent('abrir-modal-treinador'));
            @elseif(old('_method') == 'PUT')
                // Erro na edi��o
            @elseif(old('form_type') == 'atleta')
                window.dispatchEvent(new CustomEvent('abrir-modal-aluno'));
            @else
                alert("{{ str_replace('"', '\"', $errors->first()) }}");
            @endif
        @endif
    
    if (window.location.search.includes('open_senha=1')) { abrirModalSenha(); }

</script>
