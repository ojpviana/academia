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
        // 1. O FILTRO DE SEGURANÃ‡A (Valida��o£o rÃ­gida)
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
            // Validaçãoão atestado: Aceita PDF ou Imagens ate© 2 Megabytes
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
            'password' => \Illuminate\Support\Facades\Hash::make('gympro123'), // Senha padrÃ£o
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
            'modalidades' => $dados['modalidades'] ?? 'Musculação',
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

        // Retorna avisando que o fluxo foi 100% concluÃ­do
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

            // Dados de Edi��o£o / Enriquecimento
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
        // Valida��o£o rigorosa para evitar dados financeiros inconsistentes no banco
        $request->validate([
            'atleta_id' => 'required|integer',
            'valor' => 'required|numeric',
            'data_pagamento' => 'required|date',
        ]);

        // Cria o registro financeiro
        AlunoPagamento::create([
            'atleta_id' => $request->atleta_id,
            'valor' => $request->valor,
            'data_pagamento' => $request->data_pagamento,
            'status' => $request->status ?? 'Pago',
        ]);

        // AUTOMATIZAÃ‡ÃƒO DA REGRA DE NEGÃ“CIO: Destrava o acesso do aluno
        $atleta = Atleta::find($request->atleta_id);
        if ($atleta) {
            $atleta->update([
                'status' => 'Ativo',
                'data_vencimento' => \Carbon\Carbon::parse($request->data_pagamento)->addMonth()->toDateString()
            ]);
        }

        // Retorna para a tela principal
        return redirect('/admin/dashboard')->with('success', 'Pagamento registrado e acesso do aluno renovado!');
    }

    public function restaurar($id)
    {
        $atleta = Atleta::where('idAtleta', $id)->firstOrFail();

        $atleta->excluido = 0; // Volta a ser atevo
        $atleta->excluido_date = null; // Limpa a date de exclusÃ£o
        $atleta->save();

        return redirect('/admin/dashboard');
    }

    // MÃ©todo para salvar o Treinador
    public function salvarTreinador(\Illuminate\Http\Request $request)
    {
        $dados = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'cpf' => 'nullable|string',
            'rg' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'telefone' => 'nullable|string',
            'endereco_completo' => 'nullable|string',
            'cref' => ['required', 'string', 'regex:/^\d{6}-[GP]\/[A-Z]{2}$/'],
            'funcao' => 'nullable|string',
            'tipo_vinculo' => 'nullable|string',
            'turno_horario' => 'nullable|string',
            'dados_bancarios' => 'nullable|string'
        ], [
            'cref.regex' => 'Insira um CREF vÃ¡lido'
        ]);

        // 1. Cria o Login do Professor
        $user = \App\Models\User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($dados['password']),
            'role' => 'treinador'
        ]);

        // 2. Cria a Ficha do Professor
        $treinador = \App\Models\Treinador::create([
            'user_id' => $user->id,
            'cpf' => $dados['cpf'] ?? null,
            'rg' => $dados['rg'] ?? null,
            'data_nascimento' => $dados['data_nascimento'] ?? null,
            'telefone' => $dados['telefone'] ?? null,
            'endereco_completo' => $dados['endereco_completo'] ?? null,
            'cref' => $dados['cref'],
            'funcao' => $dados['funcao'] ?? 'Professor',
            'tipo_vinculo' => $dados['tipo_vinculo'] ?? 'PJ',
            'turno_horario' => $dados['turno_horario'] ?? null,
            'dados_bancarios' => $dados['dados_bancarios'] ?? null
        ]);


        return back()->with('success', 'Treinador cadastrado com sucesso!');
    }
    // Fun��o£o para salvar a justificateva silenciosamente via AJAX
    public function registrarHistorico(\Illuminate\Http\Request $request)
    {
        try {
            \App\Models\HistoricoTreino::create([
                'atleta_id' => $request->atleta_id,
                'treino_de' => $request->treino_de,     // Nova coluna
                'treino_para' => $request->treino_para, // Nova coluna (antigo nome_treino)
                'observacao' => $request->observacao
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Em caso de erro no banco, ele devolve o motivo exata
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
