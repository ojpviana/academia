<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plano;
use App\Models\FormaPagamento;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $planos = Plano::orderBy('nome')->get();
        $formasPagamento = FormaPagamento::orderBy('nome')->get();
        $horarioFuncionamento = Configuracao::getValor('horario_funcionamento', '06:00 às 22:00');
        
        return view('admin.configuracoes', compact('planos', 'formasPagamento', 'horarioFuncionamento'));
    }

    public function salvarHorario(Request $request)
    {
        $request->validate(['horario_funcionamento' => 'required|string|max:255']);
        
        Configuracao::updateOrCreate(
            ['chave' => 'horario_funcionamento'],
            ['valor' => $request->horario_funcionamento]
        );
        
        return back()->with('success', 'Horário de funcionamento atualizado!');
    }

    // ----- PLANOS -----
    public function storePlano(Request $request)
    {
        $request->validate([
            'nome'         => 'required|string|max:100|unique:planos,nome',
            'valor_padrao' => 'nullable|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
        ]);

        Plano::create($request->only('nome', 'valor_padrao', 'duracao_meses'));

        return back()->with('success', 'Plano criado com sucesso!');
    }

    public function updatePlano(Request $request, $id)
    {
        $plano = Plano::findOrFail($id);
        $request->validate([
            'nome'         => 'required|string|max:100|unique:planos,nome,' . $id,
            'valor_padrao' => 'nullable|numeric|min:0',
            'duracao_meses' => 'required|integer|min:1',
        ]);

        $plano->update($request->only('nome', 'valor_padrao'));

        return back()->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroyPlano($id)
    {
        Plano::findOrFail($id)->delete();
        return back()->with('success', 'Plano removido.');
    }

    // ----- FORMAS DE PAGAMENTO -----
    public function storeFormaPagamento(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:forma_pagamentos,nome',
        ]);

        FormaPagamento::create($request->only('nome'));

        return back()->with('success', 'Forma de pagamento criada com sucesso!');
    }

    public function updateFormaPagamento(Request $request, $id)
    {
        $forma = FormaPagamento::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:100|unique:forma_pagamentos,nome,' . $id,
        ]);

        $forma->update($request->only('nome'));

        return back()->with('success', 'Forma de pagamento atualizada!');
    }

    public function destroyFormaPagamento($id)
    {
        FormaPagamento::findOrFail($id)->delete();
        return back()->with('success', 'Forma de pagamento removida.');
    }
}
