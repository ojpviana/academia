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

<!-- Aba Cadastro 2: Documentação e Endereço -->
                <div id="cad_aba_2" class="aba-cadastro space-y-4 hidden">
                    <h3 class="text-xs font-bold text-purple-500 uppercase tracking-widest mb-3 border-b border-slate-700 pb-1">Documentação e Endereço</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">CPF</label>
                            <input type="text" name="cpf" placeholder="000.000.000-00" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">CEP</label>
                            <input type="text" name="cep" id="cep" placeholder="00000-000" onblur="buscarCEP(this.value, '')" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Endereço (Rua, Av.)</label>
                            <input type="text" name="endereco" id="endereco" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Número</label>
                            <input type="text" name="numero" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-slate-400 mb-1">UF</label>
                            <input type="text" name="estado" id="estado" placeholder="SP" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-purple-500 uppercase">
                        </div>
                    </div>
                </div>

                <p class="text-xs text-orange-400 font-bold mt-2 text-center">* A senha padrão de acesso do aluno será: gympro123</p>

                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl mt-4 transition-all shadow-lg shadow-orange-900/20 uppercase tracking-widest">
                    Cadastrar Aluno
                </button>
            </form>
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
                            <label class="block text-sm font-medium text-slate-400 mb-1">Turno / Horário</label>
                            <input type="text" name="turno_horario" id="treinador_turno_horario" placeholder="Ex: Seg a Sex, 06h às 14h" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
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
                        <div class="md:col-span-3">
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
    
<script>
function mudarAbaCadastro(aba) {
            document.querySelectorAll('.aba-cadastro').forEach(el => el.classList.add('hidden'));
            document.getElementById('btn_cad_1').className = 'bg-slate-700 text-slate-300 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap';
            document.getElementById('btn_cad_2').className = 'bg-slate-700 text-slate-300 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap';
            document.getElementById('cad_aba_' + aba).classList.remove('hidden');
            const cores = { 1: 'bg-orange-600', 2: 'bg-purple-600' };
            document.getElementById('btn_cad_' + aba).className = (cores[aba] || 'bg-orange-600') + ' text-white px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap';
        }

        // --- ATLETAS ---
        function abrirModal() {
            mudarAbaCadastro(1);
            document.getElementById('modalCadastro').classList.remove('hidden');
            document.getElementById('modalCadastro').classList.add('flex');
        }
        function fecharModal() {
            document.getElementById('modalCadastro').classList.add('hidden');
            document.getElementById('modalCadastro').classList.remove('flex');
        }

                function mudarAbaEdicao(aba) {
            // Esconder todas
            document.querySelectorAll('.aba-edicao').forEach(el => el.classList.add('hidden'));
            
            // Resetar botões
            document.getElementById('btn_aba_1').className = "bg-slate-700 text-slate-300 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap";
            document.getElementById('btn_aba_2').className = "bg-slate-700 text-slate-300 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap";
            document.getElementById('btn_aba_3').className = "bg-slate-700 text-slate-300 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap";
            
            // Ativar selecionada
            document.getElementById('aba_' + aba).classList.remove('hidden');
            
            if (aba === 1) document.getElementById('btn_aba_1').className = "bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap";
            if (aba === 2) document.getElementById('btn_aba_2').className = "bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap";
            if (aba === 3) document.getElementById('btn_aba_3').className = "bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all whitespace-nowrap";
        }


        let atletaAtualParaModais = null;

        
function abrirModalTreinador() {
            // Prepara para Cadastrar
            document.getElementById('tituloModalTreinador').innerText = 'Cadastrar Treinador';
            document.getElementById('btnSalvarTreinador').innerText = 'Cadastrar';
            document.getElementById('formTreinador').action = '/admin/treinadores';
            document.getElementById('formTreinador').reset();
            document.getElementById('metodoTreinador').innerHTML = ''; // Remove o PUT
            document.getElementById('treinador_password').required = true;

            document.getElementById('modalTreinador').classList.remove('hidden');
            document.getElementById('modalTreinador').classList.add('flex');
        }

        function fecharModalTreinador() {
            document.getElementById('modalTreinador').classList.add('hidden');
            document.getElementById('modalTreinador').classList.remove('flex');
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
            document.getElementById('treinador_turno_horario').value = treinador.turno_horario || '';
            document.getElementById('treinador_telefone').value = treinador.telefone || '';
            document.getElementById('treinador_endereco_completo').value = treinador.endereco_completo || '';
            document.getElementById('treinador_dados_bancarios').value = treinador.dados_bancarios || '';

            // Deixa a senha vazia e não obrigatória
            document.getElementById('treinador_password').value = '';
            document.getElementById('treinador_password').required = false;

            document.getElementById('modalTreinador').classList.remove('hidden');
            document.getElementById('modalTreinador').classList.add('flex');
        }

        // --- SENHA E OUTROS ---
        
</script>