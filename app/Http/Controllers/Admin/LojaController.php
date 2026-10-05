<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Storage;

class LojaController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();
        return view('admin.loja.index', compact('produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $dados = $request->only(['nome', 'descricao', 'preco']);

        if ($request->hasFile('imagem')) {
            $dados['imagem_path'] = $request->file('imagem')->store('produtos', 'public');
        }

        Produto::create($dados);

        return back()->with('success', 'Produto cadastrado na vitrine!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        
        if ($produto->imagem_path && Storage::disk('public')->exists($produto->imagem_path)) {
            Storage::disk('public')->delete($produto->imagem_path);
        }

        $produto->delete();

        return back()->with('success', 'Produto removido da vitrine.');
    }
}
