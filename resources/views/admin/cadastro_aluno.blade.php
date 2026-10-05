<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Matrícula de Atleta - GymPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-4 md:p-10 font-sans">
    <div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-3xl overflow-hidden border border-slate-200">

        <div class="bg-slate-900 p-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black text-white uppercase tracking-tighter">Matrícula Profissional</h1>
                <p class="text-slate-400 text-sm">Preencha todos os pilares para ativar o acesso do aluno.</p>
            </div>
            <div class="bg-orange-500 p-3 rounded-2xl shadow-lg shadow-orange-500/20">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
            </div>
        </div>

        <form action="/admin/alunos" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf

            <div>
                <h2 class="text-xs font-bold text-orange-600 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-px bg-orange-200 mr-2"></span> Dados Pessoais
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nome Completo</label>
                        <input type="text" name="nome" required class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">WhatsApp</label>
                        <input type="text" name="telefone" placeholder="(00) 00000-0000" class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-orange-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4 md:col-span-1">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Idade</label>
                            <input type="number" name="idade" required class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-orange-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Peso (kg)</label>
                            <input type="number" step="0.01" name="peso" required class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-orange-500 outline-none">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-1">Objetivo Principal</label>
                        <select name="objetivo" class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-orange-500 outline-none appearance-none bg-white">
                            <option value="Emagrecimento">Emagrecimento</option>
                            <option value="Hipertrofia">Hipertrofia (Ganho de Massa)</option>
                            <option value="Condicionamento">Condicionamento Físico</option>
                            <option value="Reabilitação">Reabilitação / Saúde</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-px bg-blue-200 mr-2"></span> Plano e Contrato
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Tipo de Plano</label>
                        <select name="plano_tipo" class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-blue-500 outline-none bg-white">
                            <option>Mensal</option>
                            <option>Trimestral</option>
                            <option>Anual</option>
                            <option>Gympass</option>
                            <option>TotalPass</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Modalidade</label>
                        <select name="modalidades" class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-blue-500 outline-none bg-white">
                            <option>Musculação</option>
                            <option>Natação</option>
                            <option>Lutas</option>
                            <option>Pilates</option>
                            <option>Completo (Todas)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Pagamento</label>
                        <select name="forma_pagamento" class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-blue-500 outline-none bg-white">
                            <option>Cartão Recorrente</option>
                            <option>Pix</option>
                            <option>Boleto</option>
                            <option>Dinheiro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Vencimento</label>
                        <input type="date" name="data_vencimento" value="{{ date('Y-m-d', strtotime('+30 days')) }}" class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-8 h-px bg-emerald-200 mr-2"></span> Anamnese e PAR-Q
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Atestado Médico (PDF/Foto)</label>
                        <div class="relative">
                            <input type="file" name="attestado_medico" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border-2 border-dashed border-slate-200 p-2 rounded-xl">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Observações PAR-Q (Saúde)</label>
                        <textarea name="anamnese" rows="2" placeholder="Ex: Hipertenso, lesão no ombro esquerdo..." class="w-full border-2 border-slate-200 p-3 rounded-xl focus:border-emerald-500 outline-none resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 uppercase tracking-widest text-sm">
                    Finalizar Matrícula e Ativar Aluno
                </button>
            </div>
        </form>
    </div>
</body>
</html>
