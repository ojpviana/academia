<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlunoPagamento;

class PagamentoController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados financeiros
        $request->validate([
            'atleta_id' => 'required',
            'valor' => 'required|numeric',
            'data_pagamento' => 'required|date',
            'status' => 'required'
        ]);

        // Salva o pagamento e volta para o Dashboard
        AlunoPagamento::create($request->all());

        return redirect('/admin/dashboard');
    }
}
