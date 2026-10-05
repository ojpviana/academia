<div id="modalCadastro" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden items-center justify-center z-50 px-4 overflow-y-auto pt-10 pb-10">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-4xl shadow-2xl relative my-auto">
            <button onclick="fecharModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 class="text-2xl font-bold text-white mb-2">Cadastrar Novo Atleta</h2>
            <p class="text-slate-400 text-sm mb-6">Preencha os dados abaixo. Use as abas para navegar entre as seções.</p>

            <!-- Abas do Modal de Cadastro -->
            <div class="flex space-x-2 border-b border-slate-700 pb-4 mb-6 overflow-x-auto" id="cadastro_tabs">
                <button type="button" onclick="mudarAbaCadastro(1)" id="btn_cad_1" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">
                    1. Dados Pessoais
                </button>
                <button type="button" onclick="mudarAbaCadastro(2)" id="btn_cad_2" class="bg-slate-700 text-slate-300 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap">
                    2. Documentação
                </button>
            </div>

            @if($errors->any() && !old('cref'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl mb-6 text-sm font-bold">
                    ⚠️ Atenção:
                    <ul class="list-disc pl-5 mt-1 font-normal">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/alunos" method="POST" class="space-y-6">
                @csrf

                <!-- Aba Cadastro 1: Dados Pessoais -->
                <div id="cad_aba_1" class="aba-cadastro space-y-4">
                    <h3 class="text-xs font-bold text-orange-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">Dados Pessoais e Contato</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Nome Completo</label>
                            <input type="text" name="nome" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">E-mail (Login)</label>
                            <input type="email" name="email" required placeholder="aluno@email.com" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">WhatsApp</label>
                            <input type="text" name="telefone" placeholder="(00) 00000-0000" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4 col-span-1 md:col-span-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Idade</label>
                                <input type="number" name="idade" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Peso (kg)</label>
                                <input type="number" step="0.01" name="peso" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                            </div>
                        </div>
                    </div>

<div id="modalTreinador" class="fixed inset-0 bg-slate-900/95 backdrop-blur-sm hidden items-center justify-center z-50 px-4 overflow-y-auto py-10">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl w-full max-w-4xl shadow-2xl relative my-auto">
            <button onclick="fecharModalTreinador()" class="absolute top-4 right-4 text-slate-400 hover:text-white bg-slate-700/50 p-2 rounded-full">
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