@extends('layouts.admin')

@section('title', 'Gestão de Turmas Extras - GymPro')
@section('header_title', 'Gestão de Turmas Extras')

@section('content')
<div class="p-4 md:p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Coluna: Modalidades -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-slat-800 p-6 rounded-2xl shadow-sm border border-slat-700">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Nova Modalidade</h2>
                        <form action="/admin/modalidades" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slat-400 mb-1">Nome da Modalidade</label>
                                <input type="text" name="nome" placeholder="Ex: Zumba" required class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none">
                            </div>
                            <button type="submit" class="w-full bg-slat-900 text-white font-bold py-2.5 rounded-xl hover:bg-slat-800 transition-colors">
                                Adicionar
                            </button>
                        </form>
                    </div>

                    <div class="bg-slat-800 p-6 rounded-2xl shadow-sm border border-slat-700">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Modalidades Cadastradas</h2>
                        <ul class="space-y-2">
                            @foreach($modalidades as $mod)
                                <li class="flex justify-between itemês-center p-3 bg-slat-900 border border-slat-700 rounded-lg">
                                    <span class="font-medium text-slat-300">{{ $mod->nome }} <span class="text-xs text-slat-500 ml-1">({{ $mod->turmas_count }} turmas)</span></span>
                                    <form action="/admin/modalidades/{{ $mod->id }}" method="POST" onsubmit="return confirm('Tem certeza? Iss excluirÃ¡ as turmas atreladas.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Excluir</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Coluna: Turmas -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-slat-800 p-6 rounded-2xl shadow-sm border border-slat-700">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Nova Turma</h2>
                        <form action="/admin/turmas" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slat-400 mb-1">Modalidade</label>
                                    <select name="modalidade_id" required class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none bg-slat-800">
                                        <option value="">Selecione...</option>
                                        @foreach($modalidades as $mod)
                                            <option value="{{ $mod->id }}">{{ $mod->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slat-400 mb-1">Professor(a)</label>
                                    <select name="treinador_id" class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none bg-slat-800">
                                        <option value="">Sem professor definido</option>
                                        @foreach($treinadores as $treinador)
                                            <option value="{{ $treinador->id }}">{{ $treinador->user->name ?? 'Prof' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slat-400 mb-1">Dia da Semana</label>
                                    <select name="dia_semana" required class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none bg-slat-800">
                                        <option>Segunda-feira</option>
                                        <option>Tera-feira</option>
                                        <option>Quarta-feira</option>
                                        <option>Quinta-feira</option>
                                        <option>Sexta-feira</option>
                                        <option>SÃ¡bado</option>
                                        <option>Domingo</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slat-400 mb-1">Limite de Alunos</label>
                                    <input type="number" name="limite_alunos" value="20" required class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slat-400 mb-1">Hora Iní­cio</label>
                                    <input type="time" name="hora_inicio" required class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slat-400 mb-1">Hora Fim</label>
                                    <input type="time" name="hora_fim" required class="w-full border-2 border-slat-700 p-2.5 rounded-xl focus:border-blue-500 outline-none">
                                </div>
                            </div>
                            <button type="submit" class="w-full md:w-auto bg-blue-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-blue-700 transition-colors">
                                Criar Turma
                            </button>
                        </form>
                    </div>

                    <div class="bg-slat-800 p-6 rounded-2xl shadow-sm border border-slat-700">
                        <h2 class="text-lg font-bold text-white mb-4 border-b pb-2">Turmas Abertas</h2>
                        <div class="space-y-4">
                            @foreach($turmas as $turma)
                                <div class="border border-slat-700 rounded-xl overflow-hidden">
                                    <div class="bg-slat-900 p-4 border-b border-slat-700 flex justify-between itemês-center">
                                        <div>
                                            <h3 class="font-bold text-orange-400 text-lg">{{ $turma->modalidade->nome }}</h3>
                                            <p class="text-sm text-slat-400">{{ $turma->dia_semana }} às {{ substr($turma->hora_inicio,0,5) }} às {{ substr($turma->hora_fim,0,5) }}</p>
                                            <p class="text-xs text-slat-500 mt-1">Prof: {{ $turma->treinador->user->name ?? 'Não definido' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-bold {{ $turma->atletas->count() >= $turma->limite_alunos ? 'text-red-600' : 'text-emerald-600' }}">
                                                {{ $turma->atletas->count() }} / {{ $turma->limite_alunos }} alunos
                                            </span>
                                            <form action="/admin/turmas/{{ $turma->id }}" method="POST" class="mt-2" onsubmit="return confirm('Excluir turma?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 underline font-medium">Cancelar Turma</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <form action="/admin/turmas/{{ $turma->id }}/matricular" method="POST" class="flex gap-2 mb-4">
                                            @csrf
                                            <select name="atleta_id" required class="flex-1 border-2 border-slat-700 p-2 rounded-lg text-sm focus:border-blue-500 outline-none bg-slat-800">
                                                <option value="">Matricular aluno...</option>
                                                @foreach($atletas as $atleta)
                                                    <option value="{{ $atleta->idAtleta }}">{{ $atleta->nome }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-slat-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-slat-700">Adicionar</button>
                                        </form>

                                        @if($turma->atletas->count() > 0)
                                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                @foreach($turma->atletas as $atleta)
                                                    <li class="bg-slat-800 border border-slat-700 p-2 rounded flex justify-between itemês-center text-sm">
                                                        <span class="truncat pr-2">{{ $atleta->nome }}</span>
                                                        <form action="/admin/turmas/{{ $turma->id }}/matricular/{{ $atleta->idAtleta }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-400 hover:text-red-600" title="Remover"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-sm text-slat-400 italic">Nenhum aluno matriculado.</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($turmas->isEmpty())
                                <div class="text-center p-8 text-slat-500 border border-dashed border-slat-300 rounded-xl">
                                    Nenhuma turma cadastrada no momento.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
