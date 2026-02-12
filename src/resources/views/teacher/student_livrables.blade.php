<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Livrables - {{ $student->first_name }} {{ $student->last_name }}</title>
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
        <!-- Sidebar (Reused) -->
        <aside class="w-64 glass border-r border-white/10 p-6 flex flex-col fixed h-full">
            <div class="flex items-center gap-3 text-2xl font-extrabold mb-10">
                <i data-lucide="graduation-cap" class="text-indigo-500"></i>
                <span>Debrief.me</span>
            </div>
            
            <nav class="space-y-2 flex-1">
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl text-slate-400 hover:bg-white/5 transition-all">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('teacher.briefs') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
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
                    <div class="flex items-center gap-4 mb-2">
                        <a href="{{ route('teacher.dashboard') }}" class="text-indigo-400 hover:text-indigo-300 transition-all flex items-center gap-1 text-sm">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Retour au Dashboard
                        </a>
                    </div>
                    <h1 class="text-3xl font-extrabold">{{ $student->first_name }} {{ $student->last_name }}</h1>
                    <p class="text-slate-400 mt-1">Historique complet des livrables</p>
                </div>
                
                <div class="glass px-6 py-3 rounded-2xl flex items-center gap-4 border-indigo-500/20">
                    <div class="text-right">
                        <p class="text-sm font-bold text-indigo-400">{{ $student->classe->name ?? 'Sans classe' }}</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Promotion {{ date('Y') }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white text-xl shadow-lg shadow-indigo-500/20">
                        {{ substr($student->first_name, 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="space-y-6">
                <div class="glass p-8 rounded-[2.5rem]">
                    <h3 class="text-xl font-bold mb-8 italic text-indigo-400">Tous les Livrables</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs text-slate-500 uppercase tracking-widest border-b border-white/5">
                                    <th class="pb-4 font-extrabold">Brief</th>
                                    <th class="pb-4 font-extrabold">Commentaire</th>
                                    <th class="pb-4 font-extrabold">Date de rendu</th>
                                    <th class="pb-4 font-extrabold">Lien</th>
                                    <th class="pb-4 font-extrabold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($livrables as $liv)
                                <tr class="group hover:bg-white/[0.02] transition-colors">
                                    <td class="py-6">
                                        <p class="font-bold text-slate-200">{{ $liv->brief->title }}</p>
                                        <p class="text-xs text-slate-500">Sprint: {{ $liv->brief->sprint->name ?? 'Général' }}</p>
                                    </td>
                                    <td class="py-6">
                                        @if($liv->comment)
                                            <div class="max-w-xs group-hover:bg-white/5 p-2 rounded-lg transition-colors">
                                                <p class="text-xs text-slate-300 italic">"{{ $liv->comment }}"</p>
                                            </div>
                                        @else
                                            <span class="text-[10px] text-slate-600 italic">Aucun commentaire</span>
                                        @endif
                                    </td>
                                    <td class="py-6">
                                        <span class="text-sm text-emerald-400 font-medium">
                                            {{ \Carbon\Carbon::parse($liv->submitted_at)->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td class="py-6">
                                        <a href="{{ $liv->content }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500 hover:text-white transition-all text-xs font-bold">
                                            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                            Consulter
                                        </a>
                                    </td>
                                    <td class="py-6">
                                        @if($liv->is_evaluated)
                                            <a href="{{ route('teacher.debriefing', ['student' => $student->id, 'brief' => $liv->brief_id]) }}" class="text-xs font-extrabold text-emerald-500 bg-emerald-500/10 hover:bg-emerald-500/20 transition-all uppercase tracking-wider italic px-4 py-2 rounded-xl border border-emerald-500/20 flex items-center gap-2 w-fit">
                                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                Voir évaluation
                                            </a>
                                        @else
                                            <a href="{{ route('teacher.debriefing', ['student' => $student->id, 'brief' => $liv->brief_id]) }}" class="text-xs font-extrabold text-white bg-indigo-500 hover:bg-indigo-600 transition-all uppercase tracking-wider italic px-4 py-2 rounded-xl shadow-lg shadow-indigo-500/20">
                                                Évaluer
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-slate-500 italic">
                                        <div class="flex flex-col items-center gap-3">
                                            <i data-lucide="folder-open" class="w-10 h-10 text-slate-700"></i>
                                            Aucun livrable trouvé pour cet étudiant.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Stats summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass p-6 rounded-3xl border-emerald-500/20">
                        <p class="text-slate-500 text-xs font-bold uppercase mb-2">Total Livrables</p>
                        <p class="text-4xl font-extrabold text-emerald-400">{{ $livrables->count() }}</p>
                    </div>
                    <div class="glass p-6 rounded-3xl border-indigo-500/20">
                        <p class="text-slate-500 text-xs font-bold uppercase mb-2">Dernière activité</p>
                        <p class="text-xl font-extrabold">
                            {{ $livrables->first() ? \Carbon\Carbon::parse($livrables->first()->submitted_at)->diffForHumans() : 'Aucune' }}
                        </p>
                    </div>
                    <div class="glass p-6 rounded-3xl border-indigo-500/20 bg-gradient-to-br from-indigo-500/5 to-transparent">
                        <i data-lucide="award" class="text-indigo-400 mb-2 w-5 h-5"></i>
                        <p class="text-xs text-slate-400">Prêt pour une nouvelle évaluation ?</p>
                        <a href="{{ route('teacher.debriefing', ['student' => $student->id]) }}" class="text-xs font-bold text-indigo-400 mt-2 block hover:underline">Accéder au débriefing →</a>
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
