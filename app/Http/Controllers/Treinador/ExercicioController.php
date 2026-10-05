<?php

namespace App\Http\Controllers\Treinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Atleta;
use App\Models\Treinador;
use App\Models\ExercicioCatalogo;

class ExercicioController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $treinador = Treinador::where('user_id', $userId)->first();
        $atletas = $treinador ? Atleta::where('status', 'Ativo')->where('treinador_id', $treinador->id)->get() : collect();
        $exercicios = ExercicioCatalogo::orderBy('grupo_muscular')->orderBy('nome')->get();
        return view('treinador.exercicios', compact('exercicios', 'atletas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'grupo_muscular' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
        ]);

        ExercicioCatalogo::create($request->all());

        return back()->with('success', 'Exercício adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $exercicio = ExercicioCatalogo::findOrFail($id);
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'grupo_muscular' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'video_url' => 'nullable|url|max:255',
        ]);

        $exercicio->update($request->all());

        return back()->with('success', 'Exercício atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $exercicio = ExercicioCatalogo::findOrFail($id);
        
        // Verifica se o exercício está sendo usado em alguma ficha (treino_atleta)
        if (\App\Models\TreinoAtleta::where('exercicio_id', $id)->exists()) {
            return back()->withErrors(['error' => 'Não é possível excluir o exercício pois ele já está vinculado à ficha de algum aluno.']);
        }

        $exercicio->delete();

        return back()->with('success', 'Exercício removido com sucesso!');
    }
}
