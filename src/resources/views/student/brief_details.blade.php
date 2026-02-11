<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $brief['title'] }} - Debrief.me</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-100 min-h-screen">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 glass border-r border-white/10 p-6 flex flex-col fixed h-full">
            <div class="flex items-center gap-3 text-2xl font-extrabold mb-10">
                <i data-lucide="graduation-cap" class="text-indigo-500"></i>
                <span>Debrief.me</span>
            </div>
            
            <nav class="space-y-2 flex-1">
                <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl {{ Route::is('student.dashboard') ? 'text-white bg-indigo-500 shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('student.briefs') }}" class="flex items-center gap-3 p-3 rounded-xl {{ Route::is('student.briefs*') ? 'text-white bg-indigo-500 shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="file-text"></i> <span>Mes Briefs</span>
                </a>
                <a href="{{ route('student.progression') }}" class="flex items-center gap-3 p-3 rounded-xl {{ Route::is('student.progression') ? 'text-white bg-indigo-500 shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="award"></i> <span>Mon Parcours</span>
                </a>
            </nav>
            
            <div class="pt-6 border-t border-white/10">
                <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 rounded-xl text-rose-400 hover:bg-rose-500/10 transition-all">
                    <i data-lucide="log-out"></i> <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-4xl mx-auto">
                <a href="{{ route('student.briefs') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors mb-6">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Retour aux briefs
                </a>

                <div class="glass rounded-[2.5rem] p-10 mb-8 border-t border-white/10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8">
                        @if($livrables->isNotEmpty())
                        <span class="px-4 py-2 bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase rounded-full border border-emerald-500/20">Soumis ({{ $livrables->count() }})</span>
                        @else
                        <span class="px-4 py-2 bg-amber-500/20 text-amber-400 text-xs font-bold uppercase rounded-full border border-amber-500/20">Non Rendu</span>
                        @endif
                    </div>

                    <h1 class="text-4xl font-extrabold mb-4">{{ $brief->title }}</h1>
                    <div class="flex flex-wrap gap-6 text-sm text-slate-400 mb-8">
                        <span class="flex items-center gap-2"><i data-lucide="calendar" class="w-4 h-4 text-indigo-400"></i> Du {{ optional($brief->start_date)->format('d/m') }} au {{ optional($brief->end_date)->format('d/m/Y') }}</span>
                        <span class="flex items-center gap-2"><i data-lucide="target" class="w-4 h-4 text-indigo-400"></i> Sprint: {{ $brief->sprint->name ?? 'N/A' }}</span>
                        <span class="flex items-center gap-2 font-bold text-indigo-300 capitalize"><i data-lucide="layers" class="w-4 h-4"></i> {{ $brief->type }}</span>
                    </div>

                    <div class="prose prose-invert max-w-none text-slate-300 bg-white/5 p-6 rounded-2xl border border-white/10 whitespace-pre-line">
                        {{ $brief->content }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Competences -->
                    <div class="glass p-8 rounded-3xl">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i data-lucide="award" class="text-indigo-400"></i> Compétences visées
                        </h3>
                        <div class="space-y-4">
                            @forelse($brief->competences as $comp)
                            <div class="flex items-center gap-4 p-4 bg-slate-900/50 rounded-2xl border border-white/5">
                                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold border border-indigo-500/20">{{ $comp->code }}</div>
                                <span class="text-sm font-medium">{{ $comp->label }}</span>
                            </div>
                            @empty
                            <p class="text-slate-500 italic text-sm">Aucune compétence associée.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Submission Status -->
                    <div class="glass p-8 rounded-3xl">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i data-lucide="send" class="text-emerald-400"></i> Rendu du travail
                        </h3>
                        
                        @if($livrables->isNotEmpty())
                        <div class="space-y-4 mb-8">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Vos rendus</h4>
                            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($livrables as $liv)
                                <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] text-slate-500">{{ \Carbon\Carbon::parse($liv->submitted_at)->format('d/m/Y à H:i') }}</span>
                                    </div>
                                    <a href="{{ $liv->content }}" target="_blank" class="text-sm text-indigo-400 hover:underline flex items-center gap-2 break-all">
                                        <i data-lucide="external-link" class="w-3 h-3 flex-shrink-0"></i> Voir le rendu
                                    </a>
                                    @if($liv->comment)
                                    <p class="mt-2 text-xs text-slate-400 italic">"{{ $liv->comment }}"</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="border-t border-white/10 pt-6 mt-6">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Nouveau rendu</h4>
                        </div>
                        @endif

                        <form action="{{ route('student.briefs.deliver', $brief->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-2">Lien du rendu</label>
                                <input type="url" name="content" required placeholder="https://github.com/..." 
                                    class="w-full bg-slate-900/50 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all text-sm">
                                @error('content') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-2">Commentaire (opt.)</label>
                                <textarea name="comment" rows="2" placeholder="Un petit mot..." 
                                    class="w-full bg-slate-900/50 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all resize-none text-sm"></textarea>
                                @error('comment') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 text-white font-bold transition-all flex items-center justify-center gap-2 group text-sm">
                                <i data-lucide="plus-circle" class="w-4 h-4 group-hover:rotate-90 transition-transform"></i>
                                {{ $livrables->isNotEmpty() ? 'Ajouter un rendu' : 'Soumettre mon travail' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
