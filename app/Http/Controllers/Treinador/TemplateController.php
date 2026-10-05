<?php

namespace App\Http\Controllers\Treinador;

use App\Http\Controllers\Controller;
use App\Models\Atleta;
use App\Models\ExercicioCatalogo;
use App\Models\Treinador;
use App\Models\TreinoAtleta;
use App\Models\TreinoTemplate;
use App\Models\TreinoTemplateExercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    // Ficha de RH do treinador logado (404 se a conta não tiver ficha)
    private function treinadorLogado(): Treinador
    {
        return Treinador::where('user_id', Auth::id())->firstOrFail();
    }

    // Garante que o template pertence ao treinador logado
    private function templateDoTreinador($id): TreinoTemplate
    {
        return TreinoTemplate::where('id', $id)
            ->where('treinador_id', $this->treinadorLogado()->id)
            ->firstOrFail();
    }

    // Tela "Meus Templates" (lista + criação)
    public function index()
    {
        $templates = TreinoTemplate::withCount('exercicios')
            ->where('treinador_id', $this->treinadorLogado()->id)
            ->orderBy('nome_template')
            ->get();

        return view('treinador.templates', compact('templates'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_template' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
        ]);
        $dados['treinador_id'] = $this->treinadorLogado()->id;

        $template = TreinoTemplate::create($dados);

        return redirect("/treinador/templates/{$template->id}")
            ->with('success', 'Template criado! Agora adicione os exercícios.');
    }

    public function update(Request $request, $id)
    {
        $template = $this->templateDoTreinador($id);
        $template->update($request->validate([
            'nome_template' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
        ]));

        return back()->with('success', 'Template atualizado!');
    }

    public function destroy($id)
    {
        $this->templateDoTreinador($id)->delete(); // exercícios caem por cascade

        return redirect('/treinador/templates')->with('success', 'Template excluído.');
    }

    // Editor de exercícios do template (mesma interface da prescrição)
    public function show($id)
    {
        $template = $this->templateDoTreinador($id);
        $template->load(['exercicios' => fn ($q) => $q->with('exercicio')->orderBy('dia_semana')->orderBy('id')]);
        $exercicios = ExercicioCatalogo::orderBy('grupo_muscular')->get();

        return view('treinador.template_editar', compact('template', 'exercicios'));
    }

    public function adicionarExercicio(Request $request, $id)
    {
        $template = $this->templateDoTreinador($id);
        $dados = $request->validate([
            'exercicio_id' => 'required|exists:exercicios_catalogo,id',
            'series' => 'required|string|max:20',
            'repeticoes' => 'required|string|max:20',
            'dia_semana' => 'required|string|max:50',
        ]);

        $template->exercicios()->create($dados);

        return back()->with('success', 'Exercício adicionado ao template!');
    }

    public function removerExercicio($id, $exercicioId)
    {
        $template = $this->templateDoTreinador($id);
        TreinoTemplateExercicio::where('template_id', $template->id)
            ->where('id', $exercicioId)
            ->delete();

        return back()->with('success', 'Exercício removido do template.');
    }

    // Clona os exercícios do template para a ficha do aluno e recarrega a prescrição
    public function importar(Request $request)
    {
        $treinador = $this->treinadorLogado();
        $request->validate([
            'atleta_id' => 'required|integer',
            'template_id' => 'required|integer',
            'modo' => 'required|in:substituir,adicionar',
        ]);

        $template = $this->templateDoTreinador($request->template_id);
        $atleta = Atleta::where('idAtleta', $request->atleta_id)
            ->where('treinador_id', $treinador->id)
            ->firstOrFail();

        DB::transaction(function () use ($request, $template, $atleta) {
            if ($request->modo === 'substituir') {
                TreinoAtleta::where('atleta_id', $atleta->idAtleta)->delete();
            }
            foreach ($template->exercicios as $ex) {
                TreinoAtleta::create([
                    'atleta_id' => $atleta->idAtleta,
                    'exercicio_id' => $ex->exercicio_id,
                    'series' => $ex->series,
                    'repeticoes' => $ex->repeticoes,
                    'dia_semana' => $ex->dia_semana,
                ]);
            }
        });

        $qtd = $template->exercicios->count();

        return redirect('/treinador?' . http_build_query(['atleta' => $atleta->idAtleta, 'nome' => $atleta->nome]))
            ->with('success', "Template \"{$template->nome_template}\" importado: {$qtd} exercício(s) na ficha.");
    }
}
