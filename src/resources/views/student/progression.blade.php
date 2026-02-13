<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Parcours - Debrief.me</title>
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
    <aside class="w-64 glass border-r border-white/10 p-6 flex flex-col fixed h-full z-20">
        <div class="flex items-center gap-3 text-2xl font-extrabold mb-10 text-white">
            <i data-lucide="graduation-cap" class="text-indigo-500"></i>
            <span>Debrief.me</span>
        </div>
        
        <nav class="space-y-2 flex-1">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl text-slate-400 hover:bg-white/5 transition-all">
                <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('student.briefs') }}" class="flex items-center gap-3 p-3 rounded-xl text-slate-400 hover:bg-white/5 transition-all">
                <i data-lucide="file-text"></i> <span>Mes Briefs</span>
            </a>
            <a href="{{ route('student.progression') }}" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-500 text-white shadow-lg shadow-indigo-500/20">
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
    <main class="flex-1 ml-64 p-8 relative">
        <div class="max-w-5xl mx-auto">
            <header class="mb-10">
                <h1 class="text-3xl font-extrabold text-white mb-2">Mon Parcours <span class="text-indigo-400">.</span></h1>
                <p class="text-slate-400">Retrouvez ici l'historique de vos briefs, évaluations et corrections.</p>
            </header>

            <div class="relative border-l border-white/10 ml-6 space-y-12">
                @forelse($debriefings as $debrief)
                <div class="relative pl-10 group">
                    <!-- Timeline Dot -->
                    <div class="absolute -left-[5px] top-0 w-3 h-3 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                    
                    <div class="glass p-6 rounded-3xl border border-white/5 hover:border-indigo-500/30 transition-all">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1 block">
                                    {{ $debrief->brief->type ?? 'Brief' }}
                                </span>
                                <h3 class="text-xl font-bold text-white">{{ $debrief->brief->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1">Évalué le {{ \Carbon\Carbon::parse($debrief->created_at)->format('d/m/Y') }} par {{ $debrief->teacher->first_name ?? 'Enseignant' }}</p>
                            </div>
                            <div class="px-4 py-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold flex items-center gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Évalué
                            </div>
                        </div>

                        <!-- Correction Comment -->
                        @if($debrief->comment)
                        <div class="mb-6 bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-2 flex items-center gap-2">
                                <i data-lucide="message-square" class="w-3 h-3"></i> Commentaire
                            </p>
                            <p class="text-sm text-slate-300 italic leading-relaxed whitespace-pre-wrap break-words">{{ trim($debrief->comment, '"') }}</p>
                        </div>
                        @endif

                        <!-- Competences -->
                        <div class="mt-6">
                            <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-3">Compétences évaluées</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($debrief->competences as $comp)
                                <div class="bg-white/5 p-3 rounded-xl border border-white/5 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-bold text-white mb-1">{{ $comp->code }}</p>
                                        <p class="text-[10px] text-slate-400 line-clamp-1">{{ $comp->nom }}</p>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg
                                        @if(in_array($comp->pivot->status, ['Acquis', 'VALIDEE'])) bg-emerald-500/20 text-emerald-400
                                        @elseif(in_array($comp->pivot->status, ['En cours', 'A_REVOIR'])) bg-amber-500/20 text-amber-400
                                        @else bg-rose-500/20 text-rose-400 @endif">
                                        {{ $comp->pivot->status }}
                                        <span class="ml-1 opacity-50">(Niv. {{ $comp->pivot->niveau }})</span>
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="ml-10 glass p-8 rounded-3xl text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="inbox" class="w-8 h-8 text-slate-400"></i>
                    </div>
                    <p class="text-slate-400 font-medium">Vous n'avez pas encore d'évaluations.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>

<script>
    lucide.createIcons();
    // Re-run icons immediately to prevent flash
    window.onload = function() {
        lucide.createIcons();
    }
</script>
</body>
</html>
