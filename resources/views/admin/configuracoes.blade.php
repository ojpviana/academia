@extends('layouts.admin')

@section('title', 'Configurações - GymPro')
@section('header_title', 'Configurações')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/50 text-green-400 p-4 rounded-xl flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
            <h2 class="text-xl font-bold text-white tracking-wider flex items-center">
                <svg class="w-6 h-6 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Horário de Funcionamento
            </h2>
            <p class="text-sm text-slate-400 mt-1">Configure o horário da academia. Isso afetará as validações de check-in na catraca dos alunos.</p>
        </div>

        @php
            $horario = $horarioFuncionamento ?? '06:00 às 22:00';
            // Fallback for encoding issues where 'às' becomes something else
            if (!str_contains($horario, ' às ')) {
                $horario = preg_replace('/ [^\s]+ /', ' às ', $horario);
            }
            $partes = explode(' às ', $horario);
            $aberturaPadrao = $partes[0] ?? '06:00';
            $fechamentoPadrao = $partes[1] ?? '22:00';
            
            $opcoes = [];
            for($h = 4; $h <= 23; $h++) {
                $opcoes[] = sprintf('%02d:00', $h);
                $opcoes[] = sprintf('%02d:30', $h);
            }
            $opcoes[] = '23:59'; // Option for midnight
        @endphp

        <form action="/admin/configuracoes/horario" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="abertura" class="block text-sm font-medium text-slate-400 mb-2">Horário de Abertura</label>
                    <div class="relative">
                        <select name="abertura" id="abertura" class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl p-3 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors appearance-none">
                            @foreach($opcoes as $op)
                                <option value="{{ $op }}" {{ $aberturaPadrao == $op ? 'selected' : '' }}>{{ $op }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="fechamento" class="block text-sm font-medium text-slate-400 mb-2">Horário de Fechamento</label>
                    <div class="relative">
                        <select name="fechamento" id="fechamento" class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl p-3 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors appearance-none">
                            @foreach($opcoes as $op)
                                <option value="{{ $op }}" {{ $fechamentoPadrao == $op ? 'selected' : '' }}>{{ $op }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-orange-900/20 flex items-center focus:outline-none">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Salvar Horários
                </button>
            </div>
        </form>
    </div>

    <div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
            <h2 class="text-xl font-bold text-white tracking-wider flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Gestão de Turnos de Trabalho
            </h2>
            <p class="text-sm text-slate-400 mt-1">Gerencie os turnos e horários para vincul-los aos treinadores.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2">
            <form action="/admin/configuracoes/turnos" method="POST" class="p-6 border-b md:border-b-0 md:border-r border-slate-700 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1">Nome do Turno</label>
                    <input type="text" name="nome_turno" required placeholder="Ex: Manhã (06h - 12h)" class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Início</label>
                        <input type="time" name="hora_inicio" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-1">Fim</label>
                        <input type="time" name="hora_fim" required class="w-full bg-slate-900 border border-slate-700 text-white rounded-lg p-3 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-lg mt-2 transition-all shadow-lg shadow-blue-900/20">Cadastrar Turno</button>
            </form>

            <div class="p-6">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-700 pb-2">Turnos Cadastrados</h3>
                <ul class="space-y-2">
                    @forelse($turnos ?? [] as $turno)
                        <li class="flex justify-between items-center bg-slate-900 p-3 rounded-lg border border-slate-700 text-white font-medium">
                            <div>
                                <span class="block text-white font-bold">{{ $turno->nome_turno }}</span>
                                <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }} às {{ \Carbon\Carbon::parse($turno->hora_fim)->format('H:i') }}</span>
                            </div>
                            <form action="/admin/configuracoes/turnos/{{ $turno->id }}" method="POST" class="inline" onsubmit="return confirm('Excluir este turno?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-red-500 p-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="text-slate-500 text-sm">Nenhum turno cadastrado.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
