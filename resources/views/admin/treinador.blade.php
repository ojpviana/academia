<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Treinador - GymPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-300 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-slate-700">
            <span class="text-orange-500 font-bold text-xl uppercase italic tracking-tighter">GymPro</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition-all">Painel Administrativo</a>
            <a href="/admin/treinador" class="flex items-center px-4 py-3 bg-slate-700 text-orange-400 rounded-lg border-l-4 border-orange-500 font-bold">Prescrever Treinos</a>
            <a href="/admin/financeiro" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition-all">Financeiro</a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="h-16 bg-slate-800 border-b border-slate-700 flex items-center px-8 justify-between">
            <h1 class="text-xl font-bold text-white uppercase italic">Gestão de Treinos</h1>
        </header>

        <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-4">
                <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-2xl">
                    <h2 class="text-white font-bold mb-6 flex items-center">
                        <span class="bg-orange-500 w-2 h-6 mr-3 rounded"></span>
                        ADICIONAR EXERCÍCIO
                    </h2>

                    <form action="/admin/treinador/salvar" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Aluno</label>
                            <select id="select-aluno" name="atleta_id" onchange="carregarTreinos(this.value)" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-orange-500 outline-none mt-1">
                                <option value="">Selecione um atleta...</option>
                                @foreach($atletas as $atleta)
                                    <option value="{{ $atleta->idAtleta }}">{{ $atleta->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Exercício</label>
                            <select name="exercicio_id" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-orange-500 outline-none mt-1">
                                @foreach($exercicios as $ex)
                                    <option value="{{ $ex->id }}">[{{ $ex->grupo_muscular }}] {{ $ex->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="series" placeholder="Séries (ex: 3)" class="bg-slate-900 border border-slate-700 rounded-lg p-3 text-white">
                            <input type="text" name="repeticoes" placeholder="Reps (ex: 12)" class="bg-slate-900 border border-slate-700 rounded-lg p-3 text-white">
                        </div>

                        <select name="dia_semana" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white">
                            <option value="Treino A">Treino A (Empurrar)</option>
                            <option value="Treino B">Treino B (Puxar)</option>
                            <option value="Treino C">Treino C (Pernas)</option>
                        </select>

                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-black py-4 rounded-lg transition-all shadow-lg shadow-orange-900/40 uppercase">
                            Salvar na Ficha
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-2xl min-h-[500px]">
                    <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                        <h2 class="text-white font-bold uppercase italic">Ficha do Aluno</h2>
                        <span id="nome-aluno-label" class="text-orange-500 font-bold">---</span>
                    </div>

                    <div id="lista-treinos" class="p-6">
                        <div class="text-center py-20 text-slate-600">
                            <p>Selecione um aluno para visualizar ou editar a ficha de treinos.</p>
                        </div>
                    </div>
                    <!-- FEEDBACKS DO ALUNO -->
                    <div id="area-feedbacks" class="p-4 md:p-8 border-t border-slate-700 hidden">
                        <h3 class="text-orange-400 font-bold mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                            Últimas Observações do Aluno
                        </h3>
                        <div id="lista-feedbacks" class="space-y-3">
                            <!-- Injetado via JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function carregarTreinos(atletaId) {
            if (!atletaId) return;

            const lista = document.getElementById('lista-treinos');
            const label = document.getElementById('nome-aluno-label');
            const select = document.getElementById('select-aluno');

            label.innerText = select.options[select.selectedIndex].text;
            lista.innerHTML = '<div class="text-center py-20 text-orange-500 font-bold">A carregar ficha...</div>';

            // ==========================================
            // 1. BUSCA OS TREINOS (Ficha)
            // ==========================================
            fetch(`/admin/treinador/listar-treinos/${atletaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        lista.innerHTML = '<div class="text-center py-20 text-slate-500 italic border-2 border-dashed border-slate-700 rounded-xl">Este aluno ainda não possui exercícios vinculados.</div>';
                    } else {
                        let html = '<table class="w-full text-left border-collapse"><thead><tr class="text-slate-500 text-xs uppercase border-b border-slate-700"><th class="pb-3">Exercício</th><th class="pb-3">Séries/Reps</th><th class="pb-3">Treino</th><th class="pb-3 text-right">Ações</th></tr></thead><tbody class="divide-y divide-slate-700">';

                        data.forEach(item => {
                            html += `
                                <tr class="hover:bg-slate-700/20">
                                    <td class="py-4 font-bold text-white">${item.exercicio.nome} <br><span class="text-[10px] text-slate-500 uppercase font-normal">${item.exercicio.grupo_muscular}</span></td>
                                    <td class="py-4">${item.series} x ${item.repeticoes}</td>
                                    <td class="py-4 font-medium text-orange-400">${item.dia_semana}</td>
                                    <td class="py-4 text-right">
                                        <button class="text-red-400 hover:text-red-300 text-xs font-bold uppercase">Remover</button>
                                    </td>
                                </tr>
                            `;
                        });

                        html += '</tbody></table>';
                        lista.innerHTML = html;
                    }
                })
                .catch(error => console.error("Erro ao carregar treinos:", error));

            // ==========================================
            // 2. BUSCA OS FEEDBACKS (Histórico) - Totalmente Independente!
            // ==========================================

            // Dica da Diretora: Se a sua rota no web.php estiver dentro do grupo /admin,
            // mude esta URL abaixo para `/admin/treinador/historico/${atletaId}`
            fetch(`/treinador/historico/${atletaId}`)
                .then(response => response.json())
                .then(historico => {
                    const areaFeedbacks = document.getElementById('area-feedbacks');
                    const listaFeedbacks = document.getElementById('lista-feedbacks');

                    if (historico && historico.length > 0) {
                        areaFeedbacks.classList.remove('hidden');
                        let histHtml = '';
                        historico.forEach(item => {
                            // Formata a data para o padrão Brasileiro
                            let dataObj = new Date(item.created_at);
                            let dataFormatada = dataObj.toLocaleDateString('pt-BR');

                            histHtml += `
                                <div class="bg-slate-900/50 border-l-4 border-orange-500 rounded-r-lg p-3 text-sm">
                                    <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">${dataFormatada} - Mudou para ${item.nome_treino}</span>
                                    <p class="text-slate-300 italic mt-1">"${item.observacao}"</p>
                                </div>
                            `;
                        });
                        listaFeedbacks.innerHTML = histHtml;
                    } else {
                        // Se não tiver feedback, esconde a caixa
                        areaFeedbacks.classList.add('hidden');
                        listaFeedbacks.innerHTML = '';
                    }
                })
                .catch(error => console.error("Erro ao carregar feedbacks:", error));
        }
    </script>
</body>
</html>
