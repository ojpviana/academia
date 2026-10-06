<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExercicioCatalogo;
use App\Models\Atleta;
use App\Models\Treinador;
use Illuminate\Support\Facades\Auth;

class TreinadorController extends Controller
{
    public function index()
    {
        // 1. Identifica o usuário logado
        $userId = Auth::id();

        // 2. Busca a ficha de RH do Treinador vinculada a este Login
        $treinador = Treinador::where('user_id', $userId)->first();

        // 3. Filtro de Visão (A Mágica da Segurança)
        if ($treinador) {
            // Busca TODOS os alunos ativos desse treinador (para o campo de busca/autocomplete)
            $atletas = Atleta::where('status', 'Ativo')
                             ->where('treinador_id', $treinador->id)
                             ->get();

            // Busca os IDs dos atletas que fizeram check-in nas últimas 3 horas
            $alunosPresentesIds = \App\Models\AlunoFrequencia::where('data_hora_entrada', '>=', now()->subHours(3))
                                ->pluck('atleta_id');

            // Filtra os alunos presentes (para a sidebar)
            $alunosPresentes = $atletas->whereIn('idAtleta', $alunosPresentesIds);
        } else {
            // Se a conta não tiver ficha de RH (segurança extra), devolve uma lista vazia
            $atletas = collect();
            $alunosPresentes = collect();
        }

        // 4. Busca o catálogo de exercícios ordenado
        $exercicios = ExercicioCatalogo::orderBy('grupo_muscular')->get();

        // 5. Templates do treinador (para o modal "Importar Template")
        $templates = $treinador
            ? \App\Models\TreinoTemplate::withCount('exercicios')->where('treinador_id', $treinador->id)->orderBy('nome_template')->get()
            : collect();

        // 6. Retorna a tela limpa e segura
        return view('treinador.dashboard', compact('atletas', 'alunosPresentes', 'exercicios', 'templates'));
    }

    public function listarTodosAlunos()
    {
        $userId = Auth::id();
        $treinador = Treinador::where('user_id', $userId)->first();

        if ($treinador) {
            $atletas = Atleta::where('status', 'Ativo')
                             ->where('treinador_id', $treinador->id)
                             ->orderBy('nome')
                             ->get();

            $alunosPresentesIds = \App\Models\AlunoFrequencia::where('data_hora_entrada', '>=', now()->subHours(3))
                                ->pluck('atleta_id')->toArray();
        } else {
            $atletas = collect();
            $alunosPresentesIds = [];
        }

        return view('treinador.alunos', compact('atletas', 'alunosPresentesIds'));
    }

    public function salvarTreino(Request $request)
    {
        \App\Models\TreinoAtleta::create($request->all());
        return redirect()->back()->with('success', 'Adicionado!');
    }

    public function listarTreinosPorAtleta($id)
    {
        $treinos = \App\Models\TreinoAtleta::with('exercicio')
                ->where('atleta_id', $id)->get();
                
        $treinos->map(function($treino) {
            $ultimoConcluido = \App\Models\ExercicioConcluido::where('atleta_id', $treino->atleta_id)
                ->where('treino_atleta_id', $treino->id)
                ->whereNotNull('carga_kg')
                ->orderBy('data_conclusao', 'desc')
                ->first();
            $treino->ultima_carga = $ultimoConcluido ? $ultimoConcluido->carga_kg : null;
            return $treino;
        });

        return response()->json($treinos);
    }

    public function removerTreino($id)
    {
        $treino = \App\Models\TreinoAtleta::find($id);

        if ($treino) {
            $treino->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Treino não encontrado.'], 404);
    }

    public function listarHistorico($atletaId)
    {
        // Trocas de Ficha
        $historicoFichas = \App\Models\HistoricoTreino::where('atleta_id', $atletaId)
                        ->whereNotNull('observacao')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get()
                        ->map(function($h) {
                            $h->tipo = 'troca_ficha';
                            return $h;
                        });

        // Exercícios Concluídos
        $historicoExercicios = \App\Models\ExercicioConcluido::with('treinoAtleta.exercicio')
                        ->where('atleta_id', $atletaId)
                        ->whereNotNull('observacao')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get()
                        ->map(function($e) {
                            $e->tipo = 'exercicio_concluido';
                            $e->treino_de = 'Exercício';
                            $e->treino_para = $e->treinoAtleta->exercicio->nome ?? 'Exercício';
                            return $e;
                        });

        $historico = $historicoFichas->concat($historicoExercicios)->sortByDesc('created_at')->values()->take(10);

        return response()->json($historico);
    }

    // Busca o treinador para a edição
    public function edit($id)
    {
        $treinador = \App\Models\Treinador::with('user')->findOrFail($id);
        return response()->json($treinador);
    }

    // Atualiza os dados de RH
    public function update(Request $request, $id)
    {
        $request->validate([
            'cref' => ['required', 'regex:/^\d{6}-[GP]\/[A-Z]{2}$/']
        ], [
            'cref.regex' => 'Insira um CREF válido'
        ]);

        $treinador = \App\Models\Treinador::findOrFail($id);

        $treinador->update($request->except('modelo_remuneracao'));
        $treinador->user->update(['name' => $request->name]); // Atualiza nome no login tbm

        return back()->with('success', 'Treinador atualizado com sucesso!');
    }

    // Remuneração
    public function getRemuneracao($id)
    {
        $historico = \App\Models\HistoricoRemuneracaoTreinador::where('treinador_id', $id)
                        ->orderBy('data_inicio', 'desc')
                        ->get();
        return response()->json($historico);
    }

    public function storeRemuneracao(Request $request, $id)
    {
        $request->validate([
            'valor_remuneracao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio'
        ]);

        // Encerra o contrato anterior se estiver ativo (sem data_fim) e a nova data_inicio for maior
        $ultimoAtivo = \App\Models\HistoricoRemuneracaoTreinador::where('treinador_id', $id)
            ->whereNull('data_fim')
            ->orderBy('data_inicio', 'desc')
            ->first();
            
        if ($ultimoAtivo) {
            $ultimoAtivo->update(['data_fim' => \Carbon\Carbon::parse($request->data_inicio)->subDay()->toDateString()]);
        }

        \App\Models\HistoricoRemuneracaoTreinador::create([
            'treinador_id' => $id,
            'valor_remuneracao' => $request->valor_remuneracao,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim
        ]);

        return back()->with('success', 'Contrato de remuneração registrado com sucesso!');
    }

    // Exclui o treinador
    public function destroy($id)
    {
        $treinador = \App\Models\Treinador::findOrFail($id);
        $treinador->delete(); // Remove o RH (soft delete ativado)

        return back()->with('success', 'Treinador removido da equipe.');
    }

    // --- Avaliação Física ---
    public function listarAvaliacoes($atletaId)
    {
        $avaliacoes = \App\Models\AvaliacaoFisica::where('atleta_id', $atletaId)
                        ->orderBy('data_avaliacao', 'desc')
                        ->get();
        return response()->json($avaliacoes);
    }

    public function salvarAvaliacao(Request $request, $atletaId)
    {
        $userId = Auth::id();
        $treinador = Treinador::where('user_id', $userId)->first();

        $dados = $request->all();
        $dados['atleta_id'] = $atletaId;
        $dados['treinador_id'] = $treinador ? $treinador->id : null;

        \App\Models\AvaliacaoFisica::create($dados);

        return back()->with('success', 'Avaliação Física salva com sucesso!');
    }

    // Templates de treino: ver App\Http\Controllers\Treinador\TemplateController
    public function pagar(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'valor' => 'required|numeric|min:0.01',
            'data_pagamento' => 'required|date',
        ]);

        $treinador = \App\Models\Treinador::with('user')->findOrFail($id);

        \App\Models\Despesa::create([
            'descricao' => 'Pagamento Treinador: ' . ($treinador->user->name ?? 'Desconhecido'),
            'valor' => $request->valor,
            'data_pagamento' => $request->data_pagamento,
            'categoria' => 'Folha de Pagamento',
        ]);

        $treinador->data_ultimo_pagamento = $request->data_pagamento;
        $treinador->save();

        return back()->with('success', 'Pagamento do treinador registrado com sucesso!');
    }
}
