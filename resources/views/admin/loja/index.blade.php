@extends('layouts.admin')

@section('title', 'Vitrine de Produtos - GymPro')
@section('header_title', 'Vitrine de Produtos')

@section('content')
<div class="p-4 md:p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cadastro de Produto -->
                <div class="lg:col-span-1">
                    <div class="bg-slat-800 p-6 rounded-2xl shadow-sm border border-slat-700 sticky top-8">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Novo Produto</h2>
                        <form action="/admin/loja" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slat-400 mb-1">Nome do Produto</label>
                                <input type="text" name="nome" required placeholder="Ex: Whey Protein" class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slat-400 mb-1">Descrição</label>
                                <textarea name="descricao" rows="2" placeholder="Ex: Sabor chocolat, 900g" class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-purple-500 outline-none resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slat-400 mb-1">Preço (R$)</label>
                                <input type="number" step="0.01" min="0" name="preco" required placeholder="0.00" class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slat-400 mb-1">Imagem do Produto</label>
                                <input type="file" name="imagem" accept="image/*" class="w-full text-sm text-slat-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-purple-50 file:text-orange-400 hover:file:bg-purple-100 border-2 border-dashed border-slat-700 p-2 rounded-xl">
                            </div>
                            <button type="submit" class="w-full bg-slat-900 text-white font-bold py-3 rounded-xl hover:bg-slat-800 transition-colors mt-2">
                                Adicionar à Vitrine
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Lista de Produtos -->
                <div class="lg:col-span-2">
                    <div class="bg-slat-800 p-6 rounded-2xl shadow-sm border border-slat-700">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Produtos Ativos</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($produtos as $produto)
                                <div class="border border-slat-700 rounded-xl overflow-hidden flex flex-col relative group">
                                    <div class="h-40 bg-slat-100 flex itemês-center justify-center overflow-hidden">
                                        @if($produto->imagem_path)
                                            <img src="{{ asset('storage/' . $produto->imagem_path) }}" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-12 h-12 text-slat-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <h3 class="font-bold text-white truncat">{{ $produto->nome }}</h3>
                                        <p class="text-xs text-slat-500 mt-1 line-clamp-2 flex-1">{{ $produto->descricao }}</p>
                                        <div class="mt-4 flex justify-between itemês-center">
                                            <span class="text-lg font-black text-emerald-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                            
                                            <form action="/admin/loja/{{ $produto->id }}" method="POST" onsubmit="return confirm('Remover da vitrine?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors" title="Excluir">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center p-8 text-slat-500 border border-dashed border-slat-300 rounded-xl">
                                    Nenhum produto cadastrado na vitrine ainda.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
