@extends('layouts.admin')

@section('title', 'Vitrine de Produtos - GymPro')
@section('header_title', 'Vitrine de Produtos')

@section('content')
<div class="p-4 md:p-8">
                        @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/50 text-green-400 p-4 rounded-xl mb-6 text-sm font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-xl mb-6 text-sm font-bold">
                    ?? Atenção:
                    <ul class="list-disc pl-5 mt-1 font-normal">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cadastro de Produto -->
                <div class="lg:col-span-1">
                    <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 p-6 sticky top-8">
                        <h2 id="tituloFormProduto" class="text-lg font-bold text-white mb-4 border-b pb-2 border-slate-700">Novo Produto</h2>
                        <form id="formProduto" action="/admin/loja" method="POST" enctype="multipart/form-data" class="space-y-4">
                            <div id="methodProduto"></div>
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Nome do Produto</label>
                                <input type="text" id="produto_nome" name="nome" required placeholder="Ex: Whey Protein" class="w-full border-2 border-slate-700 p-2.5 rounded-xl focus:border-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">DescriÃ§Ã£o</label>
                                <textarea id="produto_descricao" name="descricao" rows="2" placeholder="Ex: Sabor chocolate, 900g" class="w-full border-2 border-slate-700 p-2.5 rounded-xl focus:border-purple-500 outline-none resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">PreÃ§o (R$)</label>
                                <input type="number" step="0.01" min="0" id="produto_preco" name="preco" required placeholder="0.00" class="w-full border-2 border-slate-700 p-2.5 rounded-xl focus:border-purple-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Imagem do Produto</label>
                                <input type="file" name="imagem" accept="image/*" class="w-full text-sm text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-purple-50 file:text-orange-400 hover:file:bg-purple-100 border-2 border-dashed border-slate-700 p-2 rounded-xl">
                            </div>
                                                        <div class="flex gap-2 mt-2">
                                <button type="submit" class="flex-1 bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-slate-800 transition-colors">
                                    <span id="btnSalvarProduto">Adicionar à Vitrine</span>
                                </button>
                                <button type="button" id="btnCancelarEdicao" onclick="cancelarEdicaoProduto()" class="hidden bg-slate-700 text-white font-bold px-4 py-3 rounded-xl hover:bg-slate-600 transition-colors">
                                    X
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de Produtos -->
                <div class="lg:col-span-2">
                    <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 p-6">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Produtos Ativos</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($produtos as $produto)
                                <div class="border border-slate-700 rounded-xl overflow-hidden flex flex-col relative group">
                                    <div class="h-40 bg-slate-900 flex itemÃªs-center justify-center overflow-hidden">
                                        @if($produto->imagem_path)
                                            <img src="{{ asset('storage/' . $produto->imagem_path) }}" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <h3 class="font-bold text-white truncate">{{ $produto->nome }}</h3>
                                        <p class="text-xs text-gray-200 mt-1 line-clamp-2 flex-1">{{ $produto->descricao }}</p>
                                        <div class="mt-4 flex justify-between itemÃªs-center">
                                            <span class="text-lg font-black text-emerald-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                            
                                            <div class="flex gap-2">
        <button type="button" data-produto="{{ $produto }}" onclick="editarProduto(JSON.parse(this.dataset.produto))" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-500/10 transition-colors" title="Editar">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
        </button>
        <button type="button" onclick="abrirModalExclusaoProduto({{ $produto->id }}, '{{ addslashes($produto->nome) }}')" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-500/10 transition-colors" title="Excluir">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        </button>
    </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center p-8 text-gray-200 border border-dashed border-slate-300 rounded-xl">
                                    Nenhum produto cadastrado na vitrine ainda.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal de Confirmação de Exclusão de Produto -->
    <div id="modalExclusaoProduto" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm hidden flex items-center justify-center z-[100] px-4">
        <div class="bg-slate-800 border border-slate-700 p-8 rounded-2xl overflow-hidden w-full max-w-sm shadow-2xl relative text-center">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-500/20 shadow-inner shadow-red-500/20">
                <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-white mb-2">Excluir Produto?</h2>
            <p class="text-slate-400 text-sm mb-6">
                Tem certeza que deseja remover o produto <br>
                <strong id="nomeProdutoExclusao" class="text-white text-base"></strong> da vitrine?<br>
                <span class="text-xs mt-2 block opacity-75">Esta ação é irreversível e a imagem associada será apagada do servidor.</span>
            </p>

            <form id="formExclusaoProduto" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="fecharModalExclusaoProduto()" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-xl transition-all">Cancelar</button>
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-red-900/20">Sim, Excluir</button>
            </form>
        </div>
    </div>

    <script>
        function abrirModalExclusaoProduto(id, nome) {
            document.getElementById('nomeProdutoExclusao').innerText = nome;
            document.getElementById('formExclusaoProduto').action = '/admin/loja/' + id;
            document.getElementById('modalExclusaoProduto').classList.remove('hidden');
        }
                function editarProduto(produto) {
            document.getElementById('tituloFormProduto').innerText = 'Editar Produto';
            document.getElementById('formProduto').action = '/admin/loja/' + produto.id;
            document.getElementById('methodProduto').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('produto_nome').value = produto.nome;
            document.getElementById('produto_descricao').value = produto.descricao || '';
            document.getElementById('produto_preco').value = produto.preco;
            document.getElementById('btnSalvarProduto').innerText = 'Salvar Alterações';
            document.getElementById('btnCancelarEdicao').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

                function cancelarEdicaoProduto() {
            document.getElementById('tituloFormProduto').innerText = 'Novo Produto';
            document.getElementById('formProduto').action = '/admin/loja';
            document.getElementById('methodProduto').innerHTML = '';
            document.getElementById('formProduto').reset();
            document.getElementById('btnSalvarProduto').innerText = 'Adicionar à Vitrine';
            document.getElementById('btnCancelarEdicao').classList.add('hidden');
        }

        function fecharModalExclusaoProduto() {
            document.getElementById('modalExclusaoProduto').classList.add('hidden');
        }
    </script>
@endsection
