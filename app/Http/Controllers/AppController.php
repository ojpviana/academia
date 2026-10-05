<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atleta;
use App\Models\TreinoAtleta;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $atleta = Atleta::where('user_id', $user->id)->first();

        if (!$atleta) {
            return "Erro: O seu login não possui um perfil de aluno vinculado. Procure a recepção.";
        }

        $treinos = TreinoAtleta::with('exercicio')
                    ->where('atleta_id', $atleta->idAtleta)
                    ->get()
                    ->groupBy('dia_semana');

        $ultimaAvaliacao = \App\Models\AvaliacaoFisica::where('atleta_id', $atleta->idAtleta)
                            ->orderBy('data_avaliacao', 'desc')
                            ->first();

        $exerciciosConcluidosHoje = \App\Models\ExercicioConcluido::where('atleta_id', $atleta->idAtleta)
            ->whereDate('data_conclusao', now()->toDateString())
            ->pluck('treino_atleta_id')
            ->toArray();

        $semanaPassadaInclusa = \App\Models\AlunoFrequencia::where('atleta_id', $atleta->idAtleta)
            ->whereBetween('data_hora_entrada', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();
        if ($semanaPassadaInclusa < $atleta->frequencia_semanal && $atleta->streak_atual > 0) {
            $atleta->update(['streak_atual' => 0]);
        }

        $checkinHoje = \App\Models\AlunoFrequencia::where('atleta_id', $atleta->idAtleta)
            ->whereDate('data_hora_entrada', now()->toDateString())
            ->exists();

        $horario = \App\Models\Configuracao::getValor('horario_funcionamento', '06:00 as 22:00'); 
        $produtos = \App\Models\Produto::orderBy('nome')->get(); 

        return view('app.dashboard', compact('atleta', 'treinos', 'ultimaAvaliacao', 'exerciciosConcluidosHoje', 'checkinHoje', 'horario', 'produtos'));
    }

    public function checkin(Request $request)
    {
        $user = Auth::user();
        $atleta = Atleta::where('user_id', $user->id)->first();

        if (!$atleta) {
            return response()->json(['message' => 'Atleta não encontrado.'], 404);
        }

        $horario = \App\Models\Configuracao::getValor('horario_funcionamento', '06:00 as 22:00');
        if (preg_match_all('/\d{2}:\d{2}/', $horario, $matches) && count($matches[0]) >= 2) {
            $horaInicio = $matches[0][0];
            $horaFim = $matches[0][1];
            $agora = now()->format('H:i');

            if ($agora < $horaInicio || $agora > $horaFim) {
                return response()->json(['message' => 'Check-in indisponível: Fora do horário de funcionamento.'], 403);
            }
        }

        // Catraca Lógica: Validação Financeira
        if ($atleta->data_vencimento && \Carbon\Carbon::parse($atleta->data_vencimento)->endOfDay()->isPast() || in_array($atleta->status, ['Pendente', 'Inativo'])) {
            return response()->json([
                'is_bloqueado' => true,
                'message' => 'Identificamos uma pendência no seu plano. Por favor, procure a recepção para liberar seu treino.'
            ], 403);
        }

        $checkinHoje = \App\Models\AlunoFrequencia::where('atleta_id', $atleta->idAtleta)
            ->whereDate('data_hora_entrada', now()->toDateString())
            ->exists();

        if ($checkinHoje) {
             return response()->json(['message' => 'Check-in já realizado hoje.'], 422);
        }

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $frequenciaSemanal = $atleta->frequencia_semanal;

        $countSemana = \App\Models\AlunoFrequencia::where('atleta_id', $atleta->idAtleta)
            ->whereBetween('data_hora_entrada', [$startOfWeek, $endOfWeek])
            ->count();

        if ($countSemana >= $frequenciaSemanal) {
            return response()->json([
                'message' => 'Você já atingiu seu limite de treinos desta semana. Procure a recepção.'
            ], 403);
        }

        \App\Models\AlunoFrequencia::create([
            'atleta_id' => $atleta->idAtleta,
            'data_hora_entrada' => now()
        ]);

        if ($countSemana + 1 == $frequenciaSemanal) {
            $atleta->increment('streak_atual');
        }

        return response()->json(['success' => true]);
    }

    public function registrarExercicioConcluido(Request $request)
    {
        $request->validate([
            'treino_atleta_id' => 'required|integer',
            'observacao' => 'nullable|string',
            'carga_kg' => 'nullable|numeric|min:0'
        ]);

        $user = Auth::user();
        $atleta = Atleta::where('user_id', $user->id)->first();

        $existe = \App\Models\ExercicioConcluido::where('atleta_id', $atleta->idAtleta)
            ->where('treino_atleta_id', $request->treino_atleta_id)
            ->whereDate('data_conclusao', now()->toDateString())
            ->first();

        $is_pr = false;
        $porcentagem_evolucao = 0;
        $bateu_meta = false;
        $meta_atingida = 0;

        $treino = \App\Models\TreinoAtleta::find($request->treino_atleta_id);

        if (!$existe) {
            if ($request->carga_kg && $treino) {
                $previousMax = \App\Models\ExercicioConcluido::where('atleta_id', $atleta->idAtleta)
                    ->whereHas('treinoAtleta', function($q) use ($treino) {
                        $q->where('exercicio_id', $treino->exercicio_id);
                    })->max('carga_kg');
                
                if ($previousMax && $request->carga_kg > $previousMax) {
                    $is_pr = true;
                    $porcentagem_evolucao = round((($request->carga_kg - $previousMax) / $previousMax) * 100, 1);
                } elseif (!$previousMax && $request->carga_kg > 0) {
                    $is_pr = true;
                }

                if ($treino->meta_carga_kg && $request->carga_kg >= $treino->meta_carga_kg) {
                    $bateu_meta = true;
                    $meta_atingida = $treino->meta_carga_kg;
                    $treino->update(['meta_carga_kg' => null]);
                }
            }

            \App\Models\ExercicioConcluido::create([
                'atleta_id' => $atleta->idAtleta,
                'treino_atleta_id' => $request->treino_atleta_id,
                'observacao' => $request->observacao,
                'carga_kg' => $request->carga_kg,
                'is_pr' => $is_pr,
                'data_conclusao' => now()->toDateString()
            ]);
        }

        return response()->json([
            'success' => true,
            'is_pr' => $is_pr,
            'porcentagem_evolucao' => $porcentagem_evolucao,
            'bateu_meta' => $bateu_meta,
            'meta_atingida' => $meta_atingida
        ]);
    }

    public function salvarMetaCarga(Request $request)
    {
        $request->validate([
            'treino_atleta_id' => 'required|integer',
            'meta_carga_kg' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $atleta = Atleta::where('user_id', $user->id)->first();

        $treino = \App\Models\TreinoAtleta::where('atleta_id', $atleta->idAtleta)
            ->where('id', $request->treino_atleta_id)
            ->first();

        if ($treino) {
            $treino->update(['meta_carga_kg' => $request->meta_carga_kg]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }
}

