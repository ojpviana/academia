<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atleta;
use App\Models\AlunoPagamento;
use App\Models\User; // Importado para gerenciar logins
use Illuminate\Support\Facades\Hash; // Importado para criptografar senhas

class AlunoController extends Controller
{
    public function store(\Illuminate\Http\Request $request)
    {
        // 1. O FILTRO DE SEGURANÃƒâ€¡A (Validaï¿½ï¿½oÂ£o rÃƒÂ­gida)
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Impede e-mails duplicados
            'telefone' => 'nullable|string|max:20',
            'idade' => 'required|integer',
            'peso' => 'required|numeric',
            'plano_id' => 'nullable|exists:planos,id',
            'modalidades' => 'nullable|string',
            'forma_pagamento_id' => 'nullable|exists:forma_pagamentos,id',
            'data_vencimento' => 'nullable|date',
            'frequencia_semanal' => 'integer',
            'objetivo' => 'nullable|string',
            'anamnese' => 'nullable|array',
            // ValidaÃ§Ã£oÃ£o atestado: Aceita PDF ou Imagens ateÂ© 2 Megabytes
            'atestado_medico' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'cpf' => 'nullable|string|max:14',
            'cep' => 'nullable|string|max:9',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
        ]);

        // 2. O COFRE DE ARQUIVOS
        $caminhoAtestado = null;
        if ($request->hasFile('atestado_medico')) {
            // Guarda na pasta storage/app/public/atestados e pega o caminho gerado
            $caminhoAtestado = $request->file('atestado_medico')->store('atestados', 'public');
        }

        // 3. CRIAR O ACESSO DO ALUNO (O Login no App)
        $user = \App\Models\User::create([
            'name' => $dados['nome'],
            'email' => $dados['email'],
            'password' => \Illuminate\Support\Facades\Hash::make('gympro123'), // Senha padrÃƒÂ£o
            'role' => 'atleta'
        ]);

        // 4. CRIAR O PERFIL DO ATLETA (A Ficha do GymPro)
        \App\Models\Atleta::create([
            'user_id' => $user->id,
            'nome' => $dados['nome'],
            'idade' => $dados['idade'],
            'peso' => $dados['peso'],
            'telefone' => $dados['telefone'] ?? null,
            'plano_id' => $dados['plano_id'] ?? null,
            'modalidades' => $dados['modalidades'] ?? 'MusculaÃ§Ã£o',
            'forma_pagamento_id' => $dados['forma_pagamento_id'] ?? null,
            'data_vencimento' => $dados['data_vencimento'] ?? null,
            'frequencia_semanal' => $dados['frequencia_semanal'] ?? 3,
            'objetivo' => $dados['objetivo'] ?? null,
            'anamnese' => $dados['anamnese'] ?? null,
            'atestado_medico' => $caminhoAtestado,
            'status' => 'Ativo',
            'cpf' => $dados['cpf'] ?? null,
            'cep' => $dados['cep'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'numero' => $dados['numero'] ?? null,
            'bairro' => $dados['bairro'] ?? null,
            'cidade' => $dados['cidade'] ?? null,
            'estado' => $dados['estado'] ?? null
        ]);

        // Retorna avisando que o fluxo foi 100% concluÃƒÂ­do
        return back()->with('success', 'Atleta matriculado com sucesso! Conta e ficha criadas.');
    }

        public function update(\Illuminate\Http\Request $request, $id)
    {
        $atleta = \App\Models\Atleta::findOrFail($id);

        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($atleta->user_id ?? 'NULL'),
            'telefone' => 'nullable|string|max:20',
            'idade' => 'required|integer',
            'peso' => 'required|numeric',
            'cpf' => 'nullable|string|max:14',
            'cep' => 'nullable|string|max:9',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',

            // Dados de Ediï¿½ï¿½oÂ£o / Enriquecimento
            'plano_id' => 'nullable|exists:planos,id',
            'modalidades' => 'nullable|string',
            'forma_pagamento_id' => 'nullable|exists:forma_pagamentos,id',
            'data_vencimento' => 'nullable|date',
            'frequencia_semanal' => 'nullable|integer',
            'objetivo' => 'nullable|string',
            'anamnese' => 'nullable|array',
            'par_q' => 'nullable|array',
            'treinador_id' => 'nullable|exists:treinadores,id',
            'atestado_medico' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('atestado_medico')) {
            $dados['atestado_medico'] = $request->file('atestado_medico')->store('atestados', 'public');
        }

        // Update User
        if ($atleta->user) {
            $atleta->user->update([
                'name' => $dados['nome'],
                'email' => $dados['email'],
            ]);
        }

        // We filter out 'email' since it belongs to User, not Atleta
        unset($dados['email']);

        $atleta->update($dados);

        return back()->with('success', 'Ficha do atleta atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $atleta = Atleta::where('idAtleta', $id)->firstOrFail();

        // Soft delete the user so they lose access
        if ($atleta->user) {
            $atleta->user->delete();
        }

        // Soft delete the athlete
        $atleta->delete();

        return redirect('/admin/dashboard')->with('success', 'Atleta removido com sucesso.');
    }

        public function registrarPagamento(Request $request)
    {
        // Validação rigorosa
        $request->validate([
            'atleta_id' => 'required|integer',
            'valor' => 'required|numeric',
            'data_pagamento' => 'required|date',
        ]);

        $dataPagamento = \Carbon\Carbon::parse($request->data_pagamento);

        // TRAVA DE SEGURANÇA: Impedir duplicidade no mês/ano
        $pagamentoExistente = \App\Models\AlunoPagamento::where('atleta_id', $request->atleta_id)
            ->whereMonth('data_pagamento', $dataPagamento->month)
            ->whereYear('data_pagamento', $dataPagamento->year)
            ->first();

        if ($pagamentoExistente) {
            return back()->withErrors(['erro' => 'Este aluno já possui um pagamento para o mês informado. Se estiver ANTECIPANDO uma mensalidade, altere o campo "Data" no modal para o próximo mês.']);
        }

        // Cria o registro financeiro
        \App\Models\AlunoPagamento::create([
            'atleta_id' => $request->atleta_id,
            'valor' => $request->valor,
            'data_pagamento' => $request->data_pagamento,
            'status' => $request->status ?? 'Pago',
        ]);

        // Destrava o acesso do aluno e joga o vencimento +1 mês
        $atleta = \App\Models\Atleta::find($request->atleta_id);
        if ($atleta) {
            $baseVencimento = $atleta->data_vencimento ? \Carbon\Carbon::parse($atleta->data_vencimento) : $dataPagamento->copy();
            
            $atleta->update([
                'status' => 'Ativo',
                'data_vencimento' => $baseVencimento->addMonth()->toDateString()
            ]);
        }

        return back()->with('success', 'Pagamento registrado com sucesso!');
    }

    public function restaurar($id)
    {
        $atleta = \App\Models\Atleta::onlyTrashed()->where('idAtleta', $id)->firstOrFail();
        
        $atleta->restore();
        if ($atleta->user) {
            $atleta->user->restore();
        }
        
        return back()->with('success', 'Atleta restaurado com sucesso e movido de volta para a lista de ativos!');
    }

}
