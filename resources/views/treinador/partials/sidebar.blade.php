<aside id="sidebar" class="fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out w-64 bg-slate-800 border-r border-slate-700 flex flex-col z-40 h-full">
    <div class="h-16 flex items-center px-6 border-b border-slate-700">
        <div class="bg-orange-500 p-2 rounded-lg mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
            </svg>
        </div>
        <span class="text-white font-bold text-xl tracking-wider uppercase italic">Painel</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="/treinador" class="flex items-center px-4 py-3 {{ Request::is('treinador') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500 font-bold shadow-lg' : 'text-slate-400 hover:bg-slate-700 hover:text-white border border-transparent hover:border-slate-700' }} rounded-lg transition-all mb-2">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Prescrever Treinos
        </a>

        <a href="/treinador/alunos" class="flex items-center px-4 py-3 {{ Request::is('treinador/alunos') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500 font-bold shadow-lg' : 'text-slate-400 hover:bg-slate-700 hover:text-white border border-transparent hover:border-slate-700' }} rounded-lg transition-all mb-2">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Meus Alunos
        </a>

        <div class="mt-4 mb-4">
            <div class="px-4 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center justify-between">
                <span>Alunos Presentes</span>
                <span class="bg-orange-500/20 text-orange-400 px-2 py-0.5 rounded-full">{{ isset($alunosPresentes) ? $alunosPresentes->count() : 0 }}</span>
            </div>

            <div class="flex-col space-y-1 px-2 mt-2">
                @forelse($alunosPresentes ?? [] as $atleta)
                    <a href="/treinador?atleta={{ $atleta->idAtleta }}&nome={{ urlencode($atleta->nome) }}" class="w-full flex items-center px-3 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-orange-400 rounded-lg transition-all border border-transparent hover:border-slate-700">
                        <div class="w-2 h-2 rounded-full bg-green-500 mr-3 animate-pulse"></div>
                        <span class="truncate capitalize">{{ $atleta->nome }}</span>
                    </a>
                @empty
                    <span class="text-xs text-slate-500 italic px-3 py-2 block">Nenhum aluno presente.</span>
                @endforelse
            </div>
        </div>

        <a href="/treinador/exercicios" class="flex items-center px-4 py-3 {{ Request::is('treinador/exercicios') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500 font-bold shadow-lg' : 'text-slate-400 hover:bg-slate-700 hover:text-white border border-transparent hover:border-slate-700' }} rounded-lg transition-colors mt-2">
            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            Catálogo de Exercícios
        </a>
        
        <a href="/treinador/templates" class="flex items-center px-4 py-3 {{ Request::is('treinador/templates*') ? 'bg-slate-700 text-orange-400 border-l-4 border-orange-500 font-bold shadow-lg' : 'text-slate-400 hover:bg-slate-700 hover:text-white border border-transparent hover:border-slate-700' }} rounded-lg transition-all mt-2">
            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
            Meus Templates
        </a>
    </nav>
</aside>
