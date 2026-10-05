<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlunoPagamento;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceiroController extends Controller
{
    // 1. Carrega o ecrÃ£ limpo do financeiro
    public function index(\Illuminate\Http\Request $request)
    {
        // Se nÃƒÂ£o tiver filtro, define por padrÃƒÂ£o o mÃƒÂªs atual
        if (!$request->has('data_inicio') && !$request->has('data_fim')) {
            $request->merge([
                'data_inicio' => \Carbon\Carbon::now()->subDays(15)->toDateString(),
                'data_fim' => \Carbon\Carbon::now()->endOfMonth()->toDateString(),
            ]);
        }

        // 1. Busca as RECEITAS (com o filtro de datas)
        $queryReceitas = \App\Models\AlunoPagamento::with('atleta')->orderBy('data_pagamento', 'desc');
        if ($request->filled('data_inicio')) $queryReceitas->whereDate('data_pagamento', '>=', $request->data_inicio);
        if ($request->filled('data_fim')) $queryReceitas->whereDate('data_pagamento', '<=', $request->data_fim);

        $pagamentos = $queryReceitas->get();
        $somaVisivel = $pagamentos->sum('valor');

        // 2. Busca as DESPESAS (com o MESMO filtro de datas)
        $queryDespesas = \App\Models\Despesa::orderBy('data_pagamento', 'desc');
        if ($request->filled('data_inicio')) $queryDespesas->whereDate('data_pagamento', '>=', $request->data_inicio);
        if ($request->filled('data_fim')) $queryDespesas->whereDate('data_pagamento', '<=', $request->data_fim);

        $despesas = $queryDespesas->get();
        $totalDespesas = $despesas->sum('valor');

        // 3. Calcula o LUCRO REAL
        $lucro = $somaVisivel - $totalDespesas;

        // 4. Busca Atletas para o Modal
        $atletas = \App\Models\Atleta::with('plano')->orderBy('nome')->get();

        
        $planos = \App\Models\Plano::orderBy('nome')->get();
        $formasPagamento = \App\Models\FormaPagamento::orderBy('nome')->get();
        
        return view('admin.financeiro', compact('pagamentos', 'somaVisivel', 'despesas', 'totalDespesas', 'lucro', 'atletas', 'planos', 'formasPagamento'));

    }

    // 2. FunÃ§Ã£o para salvar uma NOVA ENTRADA (Recebimento)
    public function storeRecebimento(\Illuminate\Http\Request $request)
    {
        // ValidaÃ§Ã£o blindada (verifica se o ID existe na tabela atletas)
        $request->validate([
            'atleta_id' => 'required|exists:atletas,idAtleta',
            'valor' => 'required|numeric',
            'data_pagamento' => 'required|date',
        ]);

        \App\Models\AlunoPagamento::create([
            'atleta_id' => $request->atleta_id,
            'valor' => $request->valor,
            'data_pagamento' => $request->data_pagamento,
            'status' => 'PAGO'
        ]);

        // AUTOMATIZAÃ‡ÃƒO DA REGRA DE NEGÃ“CIO: Destrava o acesso do aluno
        $atleta = \App\Models\Atleta::find($request->atleta_id);
        if ($atleta) {
            $atleta->update([
                'status' => 'Ativo',
                'data_vencimento' => \Carbon\Carbon::parse($request->data_pagamento)->addMonth()->toDateString()
            ]);
        }

        return back()->with('success', 'Entrada registrada com sucesso! Acesso do aluno foi renovado.');
    }

    // 3. FunÃ§Ã£o para salvar uma nova DESPESA no banco
    public function storeDespesa(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'required|numeric',
            'data_pagamento' => 'required|date',
        ]);

        \App\Models\Despesa::create($request->all());

        return back()->with('success', 'Despesa registrada com sucesso!');
    }

   // 4. FunÃ§Ã£o para gerar o PDF Financeiro Completo (Entradas, SaÃ­das e Saldo)
    public function exportarPdfCaixa(\Illuminate\Http\Request $request)
    {
        // Se nÃƒÂ£o tiver filtro, define por padrÃƒÂ£o o mÃƒÂªs atual
        if (!$request->has('data_inicio') && !$request->has('data_fim')) {
            $request->merge([
                'data_inicio' => \Carbon\Carbon::now()->subDays(15)->toDateString(),
                'data_fim' => \Carbon\Carbon::now()->endOfMonth()->toDateString(),
            ]);
        }

        // 1. Busca as RECEITAS (Aplicando filtros de data)
        $queryReceitas = \App\Models\AlunoPagamento::with('atleta')->orderBy('data_pagamento', 'desc');
        if ($request->filled('data_inicio')) {
            $queryReceitas->whereDate('data_pagamento', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $queryReceitas->whereDate('data_pagamento', '<=', $request->data_fim);
        }
        $pagamentos = $queryReceitas->get();
        $totalEntradas = $pagamentos->sum('valor');

        // 2. Busca as DESPESAS (Aplicando os mesmos filtros de data)
        $queryDespesas = \App\Models\Despesa::orderBy('data_pagamento', 'desc');
        if ($request->filled('data_inicio')) {
            $queryDespesas->whereDate('data_pagamento', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $queryDespesas->whereDate('data_pagamento', '<=', $request->data_fim);
        }
        $despesas = $queryDespesas->get();
        $totalDespesas = $despesas->sum('valor');

        // 3. Calcula o LUCRO REAL (O que faz a mÃ¡quina girar)
        $saldoLiquido = $totalEntradas - $totalDespesas;

        // 4. Formata o perÃ­odo para o cabeÃ§alho do PDF
        $periodo = 'Todo o perÃ­odo';
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $periodo = \Carbon\Carbon::parse($request->data_inicio)->format('d/m/Y') . ' atÃ© ' . \Carbon\Carbon::parse($request->data_fim)->format('d/m/Y');
        }

        // 5. Carrega a view do PDF injetando toda a matemÃ¡tica de negÃ³cio
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.relatorios.caixa_pdf', compact(
            'pagamentos',
            'totalEntradas',
            'despesas',
            'totalDespesas',
            'saldoLiquido',
            'periodo'
        ));

        // 6. Faz o download do relatÃ³rio completo
        return $pdf->download('relatorio_financeiro_gympro.pdf');
    }

    // --- Cadastros Base ---
    public function storePlano(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nome'         => 'required|string|max:100|unique:planos,nome',
            'valor_padrao' => 'nullable|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
        ]);

        \App\Models\Plano::create($request->only('nome', 'valor_padrao', 'duracao_meses'));

        return back()->with('success', 'Plano criado com sucesso!')->with('tab', 2);
    }

    public function storeFormaPagamento(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:forma_pagamentos,nome',
        ]);

        \App\Models\FormaPagamento::create($request->only('nome'));

        return back()->with('success', 'Forma de pagamento criada com sucesso!')->with('tab', 2);
    }

    public function updatePlano(\Illuminate\Http\Request $request, $id)
    {
        $plano = \App\Models\Plano::findOrFail($id);
        $request->validate([
            'nome'         => 'required|string|max:100|unique:planos,nome,' . $id,
            'valor_padrao' => 'nullable|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
        ]);

        $plano->update($request->only('nome', 'valor_padrao', 'duracao_meses'));

        return back()->with('success', 'Plano atualizado com sucesso!')->with('tab', 2);
    }

    public function destroyPlano($id)
    {
        \App\Models\Plano::destroy($id);
        return back()->with('success', 'Plano removido!')->with('tab', 2);
    }

    public function updateFormaPagamento(\Illuminate\Http\Request $request, $id)
    {
        $forma = \App\Models\FormaPagamento::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:100|unique:forma_pagamentos,nome,' . $id,
        ]);

        $forma->update($request->only('nome'));

        return back()->with('success', 'Forma de pagamento atualizada!')->with('tab', 2);
    }

    public function destroyFormaPagamento($id)
    {
        \App\Models\FormaPagamento::destroy($id);
        return back()->with('success', 'Forma de pagamento removida!')->with('tab', 2);
    }
}
