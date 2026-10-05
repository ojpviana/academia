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
</div>
@endsection
