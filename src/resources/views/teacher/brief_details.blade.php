<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $brief['title'] }} - Détails - Debrief.me</title>
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
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('teacher.briefs') }}" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="file-text"></i> <span>Briefs</span>
                </a>
                <a href="{{ route('teacher.debriefing') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="check-square"></i> <span>Débriefing</span>
                </a>
                <a href="{{ route('teacher.progression') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="trending-up"></i> <span>Progression</span>
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
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold">Détails du Brief</h1>
                    <p class="text-slate-400 mt-1">Gérez le contenu et voyez les rendus</p>
                </div>
                <div class="flex items-center gap-6">
                    <div class="glass px-4 py-2 rounded-2xl flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ Auth::user()->role ?? 'FORMATEUR' }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white uppercase">
                            {{ substr(Auth::user()->first_name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="space-y-8 max-w-7xl mx-auto">
                <div class="glass p-10 rounded-[2.5rem] bg-gradient-to-br from-indigo-500/5 to-transparent border-indigo-500/20">
                    <h1 class="text-5xl font-extrabold mb-4 tracking-tight">{{ $brief->title }}</h1>
                    <p class="text-indigo-400 font-bold uppercase tracking-widest text-sm mb-8 flex items-center gap-2">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                        {{ $brief->sprint->name ?? 'Aucun sprint' }} • Ordre: {{ $brief->sprint->order ?? 'N/A' }}
                    </p>

                    <div class="flex flex-wrap gap-8 text-sm text-slate-400 mb-10 border-b border-white/10 pb-10">
                        <span class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-xl">
                            <i data-lucide="calendar" class="w-5 h-5 text-indigo-400"></i> 
                            <span class="font-semibold">Période:</span> {{ $brief->start_date->format('d/m/Y') }} — {{ $brief->end_date->format('d/m/Y') }}
                        </span>
                        <span class="flex items-center gap-3 bg-white/5 px-4 py-2 rounded-xl">
                            <i data-lucide="users" class="w-5 h-5 text-indigo-400"></i> 
                            <span class="font-semibold">Type:</span> {{ $brief->type == 'INDIVIDUAL' ? 'Individuel' : 'Collectif' }}
                        </span>
                    </div>

                    <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed text-lg whitespace-pre-wrap break-words">
                        {!! nl2br(e($brief->content)) !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Student Deliverables -->
                    <div class="glass p-8 rounded-3xl">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i data-lucide="send" class="text-indigo-400"></i> Livrables des Étudiants
                        </h3>
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($deliverables as $del)
                            <div class="p-4 bg-slate-900/50 rounded-2xl border border-white/5 hover:border-indigo-500/30 transition-all group">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold text-xs uppercase">
                                            {{ substr($del->student->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-200">{{ $del->student->first_name }} {{ $del->student->last_name }}</p>
                                            <p class="text-[10px] text-slate-500 italic">{{ \Carbon\Carbon::parse($del->submitted_at)->format('d/m à H:i') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ $del->content }}" target="_blank" class="p-2 bg-white/5 rounded-lg text-slate-400 hover:text-white hover:bg-indigo-500/20 transition-all">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </div>
                                <div class="bg-indigo-500/5 p-3 rounded-xl border border-indigo-500/10 mt-2">
                                    <p class="text-xs text-slate-400 leading-relaxed italic whitespace-pre-wrap break-words">
                                        {{ trim($del->comment, '"') ?: "Aucun commentaire laissé par l'étudiant." }}
                                    </p>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    @if($del->is_evaluated)
                                        <a href="{{ route('teacher.debriefing', ['student' => $del->student_id, 'brief' => $del->brief_id]) }}" class="text-[10px] font-extrabold text-emerald-500 bg-emerald-500/10 px-3 py-1.5 rounded-lg border border-emerald-500/20 flex items-center gap-1 group/btn italic">
                                            <i data-lucide="check-circle" class="w-3 h-3"></i>
                                            Voir évaluation
                                        </a>
                                    @else
                                        <a href="{{ route('teacher.debriefing', ['student' => $del->student_id, 'brief' => $del->brief_id]) }}" class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1 group/btn">
                                            Évaluer cet étudiant <i data-lucide="chevron-right" class="w-3 h-3 group-hover/btn:translate-x-1 transition-transform"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="bg-slate-900/50 p-8 rounded-2xl border border-white/5 text-center">
                                <i data-lucide="inbox" class="w-8 h-8 text-slate-600 mx-auto mb-3"></i>
                                <p class="text-slate-500 text-sm italic">Aucun livrable n'a été soumis pour le moment.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Competences -->
                    <div class="glass p-8 rounded-3xl">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                            <i data-lucide="award" class="text-emerald-400"></i> Compétences visées
                        </h3>
                        <div class="space-y-3">
                            @foreach($brief->competences as $competence)
                            <div class="flex items-center gap-4 p-3 bg-slate-900/50 rounded-xl border border-white/5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold border border-emerald-500/20 text-xs">{{ $competence->code }}</div>
                                <span class="text-xs font-medium text-slate-300">{{ $competence->label }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
