@extends('layouts.admin')

@section('title', 'Radar de Retenção - GymPro')
@section('header_title', 'Radar de Retenção')

@section('content')
<div class="bg-slate-800 rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
    <div class="p-6 border-b border-slate-700 bg-slate-800/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-wider flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Monitoramento de Frequência
            </h2>
            <p class="text-sm text-slate-400 mt-1">Identifique alunos com risco de evasão e aja antecipadamente.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1.5 bg-green-500/10 border border-green-500/30 text-green-400 text-xs font-bold rounded-lg flex items-center shadow-sm">
                <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div> Frequente
            </span>
            <span class="px-3 py-1.5 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 text-xs font-bold rounded-lg flex items-center shadow-sm">
                <div class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></div> Alerta
            </span>
            <span class="px-3 py-1.5 bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold rounded-lg flex items-center shadow-sm">
                <div class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></div> Ausente / Risco
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-900/50 text-slate-400 text-xs uppercase tracking-widest">
                    <th class="p-4 font-semibold border-b border-slate-700">Atleta</th>
                    <th class="p-4 font-semibold border-b border-slate-700 text-center">Frequência (7 dias)</th>
                    <th class="p-4 font-semibold border-b border-slate-700 text-center">Último Check-in</th>
                    <th class="p-4 font-semibold border-b border-slate-700 text-center">Status</th>
                    <th class="p-4 font-semibold border-b border-slate-700 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50 text-sm">
                @forelse($alunosAtivos->sortBy('frequencias_count') as $aluno)
                    @php
                        // Obter o último checkin sem N+1 massivo (já que é um radar pequeno)
                        $ultimoCheckin = \App\Models\AlunoFrequencia::where('atleta_id', $aluno->idAtleta)->orderBy('data_hora_entrada', 'desc')->first();
                        $dataUltimo = $ultimoCheckin ? \Carbon\Carbon::parse($ultimoCheckin->data_hora_entrada) : null;
                        
                        $meta = $aluno->frequencia_semanal ?: 3;
                        $count = $aluno->frequencias_count;
                        $diasAusente = $dataUltimo ? $dataUltimo->diffInDays(now()) : 999;
                        
                        // Lógica de Retenção
                        if ($count >= $meta && $diasAusente <= 5) {
                            $bgClass = 'bg-green-500/10';
                            $textClass = 'text-green-400';
                            $borderClass = 'border-green-500/20';
                            $dotClass = 'bg-green-500';
                            $hoverBorderClass = 'group-hover:border-green-500';
                            $statusLabel = 'Frequente';
                        } elseif ($diasAusente >= 14 || ($count == 0 && $diasAusente > 7)) {
                            $bgClass = 'bg-red-500/10';
                            $textClass = 'text-red-400';
                            $borderClass = 'border-red-500/20';
                            $dotClass = 'bg-red-500 animate-pulse';
                            $hoverBorderClass = 'group-hover:border-red-500';
                            $statusLabel = $diasAusente > 30 ? 'Evasão Iminente' : 'Risco Crítico';
                        } else {
                            $bgClass = 'bg-yellow-500/10';
                            $textClass = 'text-yellow-400';
                            $borderClass = 'border-yellow-500/20';
                            $dotClass = 'bg-yellow-500';
                            $hoverBorderClass = 'group-hover:border-yellow-500';
                            $statusLabel = 'Alerta';
                        }
                    @endphp
                    <tr class="hover:bg-slate-700/30 transition-colors group">
                        <td class="p-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-slate-700 border border-slate-600 flex items-center justify-center text-white font-bold shadow-sm {{ $hoverBorderClass }} transition-colors">
                                    {{ substr($aluno->nome, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <p class="text-white font-bold tracking-wide">{{ $aluno->nome }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $aluno->telefone ?: 'Sem número' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-lg font-black {{ $count < $meta ? 'text-red-400' : 'text-white' }}">{{ $count }}</span>
                                <span class="text-[10px] text-slate-500 uppercase tracking-widest mt-1">de {{ $meta }} presenças</span>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($dataUltimo)
                                <span class="block text-slate-300 font-medium">{{ $dataUltimo->format('d/m/Y') }}</span>
                                <span class="text-xs mt-1 {{ $diasAusente >= 7 ? 'text-red-400 font-bold' : 'text-slate-500' }}">
                                    (há {{ $diasAusente }} {{ $diasAusente == 1 ? 'dia' : 'dias' }})
                                </span>
                            @else
                                <span class="px-2 py-1 bg-slate-900 text-slate-500 text-xs rounded-md italic">Sem registros</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $bgClass }} {{ $textClass }} border {{ $borderClass }} shadow-sm">
                                <div class="w-1.5 h-1.5 rounded-full {{ $dotClass }} mr-1.5"></div>
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @if($aluno->telefone)
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $aluno->telefone) }}" target="_blank" class="inline-flex items-center justify-center p-2.5 bg-slate-700 hover:bg-green-600 text-slate-400 hover:text-white rounded-xl transition-all shadow-sm border border-slate-600 hover:border-green-500 group-hover:scale-110 focus:outline-none" title="Chamar no WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.125-.397-.179-.974-.39-1.928-1.244-1.177-1.054-1.93-2.39-2.158-2.697-.229-.307-.545-.941-.531-1.517.014-.576.299-.861.405-.974.106-.113.25-.157.356-.157.106 0 .211.009.303.013.111.005.253-.042.396.299.144.341.492 1.205.536 1.297.044.092.073.199.02.305-.053.106-.08.171-.161.266-.08.095-.166.208-.235.293-.082.102-.17.208-.052.413.118.204.524.868 1.124 1.402.776.689 1.423.904 1.628 1.004.205.101.325.085.445-.053.12-.138.525-.611.666-.821.141-.21.282-.175.47-.104.188.071 1.19.562 1.395.664.205.102.341.152.392.237.051.085.051.495-.093.901z"/></svg>
                            </a>
                            @else
                            <button disabled class="inline-flex items-center justify-center p-2.5 bg-slate-800 text-slate-600 rounded-xl border border-slate-700 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 border-dashed border-slate-700">
                            Nenhum aluno ativo para monitorar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
