<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Atleta;
use App\Models\Treinador; // 1. IMPORTANTE: Adicione esta linha no topo
use App\Models\Plano;
use App\Models\FormaPagamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Certifique-se de que o Controller pai está aqui

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('status', 'ativos');

        if ($filtro == 'inativos') {
            $atletas = Atleta::with('user')->where('excluido', 1)->get();
        } else {
            $atletas = Atleta::with('user')->where('excluido', 0)->get();
        }

        $receitaMensal = \App\Models\AlunoPagamento::whereMonth('data_pagamento', Carbon::now()->month)
                                                ->whereYear('data_pagamento', Carbon::now()->year)
                                                ->sum('valor');


        $treinadores   = Treinador::with('user')->get();
        $planos        = Plano::orderBy('nome')->get();
        $formasPagamento = FormaPagamento::orderBy('nome')->get();

        return view('admin.dashboard', compact('atletas', 'receitaMensal', 'filtro', 'treinadores', 'planos', 'formasPagamento'));
    }

    public function radar()
    {
        $seteDiasAtras = Carbon::now()->subDays(7);
        $alunosAtivos = Atleta::where('excluido', 0)
            ->where('status', 'Ativo')
            ->withCount(['frequencias' => function ($query) use ($seteDiasAtras) {
                $query->where('data_hora_entrada', '>=', $seteDiasAtras);
            }])
            ->get();

        $alunosEmRisco = $alunosAtivos->filter(function ($aluno) {
            return $aluno->frequencias_count < $aluno->frequencia_semanal;
        });

        return view('admin.radar', compact('alunosAtivos', 'alunosEmRisco'));
    }
}
