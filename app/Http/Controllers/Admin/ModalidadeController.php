<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModalidadeExtra;
use App\Models\Turma;
use App\Models\Treinador;
use App\Models\Atleta;

class ModalidadeController extends Controller
{
    public function index()
    {
        $modalidades = ModalidadeExtra::withCount('turmas')->orderBy('nome')->get();
        $turmas = Turma::with(['modalidade', 'treinador.user', 'atletas'])->get();
        $treinadores = Treinador::with('user')->get();
        $atletas = Atleta::where('status', 'Ativo')->orderBy('nome')->get();

        return view('admin.modalidades.index', compact('modalidades', 'turmas', 'treinadores', 'atletas'));
    }

    public function storeModalidade(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:100|unique:modalidades_extras,nome']);
        ModalidadeExtra::create($request->only('nome'));
        return back()->with('success', 'Modalidade cadastrada!');
    }

    public function destroyModalidade($id)
    {
        ModalidadeExtra::findOrFail($id)->delete();
        return back()->with('success', 'Modalidade excluída!');
    }

    public function storeTurma(Request $request)
    {
        $request->validate([
            'modalidade_id' => 'required|exists:modalidades_extras,id',
            'treinador_id'  => 'nullable|exists:treinadores,id',
            'dia_semana'    => 'required|string',
            'hora_inicio'   => 'required|date_format:H:i',
            'hora_fim'      => 'required|date_format:H:i|after:hora_inicio',
            'limite_alunos' => 'required|integer|min:1'
        ]);

        Turma::create($request->all());
        return back()->with('success', 'Turma criada!');
    }

    public function destroyTurma($id)
    {
        Turma::findOrFail($id)->delete();
        return back()->with('success', 'Turma excluída!');
    }

    public function matricularAluno(Request $request, $idTurma)
    {
        $request->validate([
            'atleta_id' => 'required|exists:atletas,idAtleta'
        ]);

        $turma = Turma::findOrFail($idTurma);

        if ($turma->atletas()->where('atleta_id', $request->atleta_id)->exists()) {
            return back()->withErrors(['atleta_id' => 'Aluno já está matriculado nesta turma.']);
        }

        if ($turma->atletas()->count() >= $turma->limite_alunos) {
            return back()->withErrors(['limite' => 'Turma já está lotada.']);
        }

        $turma->atletas()->attach($request->atleta_id);
        return back()->with('success', 'Aluno matriculado com sucesso!');
    }

    public function removerMatricula($idTurma, $idAtleta)
    {
        $turma = Turma::findOrFail($idTurma);
        $turma->atletas()->detach($idAtleta);
        return back()->with('success', 'Matrícula removida!');
    }
}
