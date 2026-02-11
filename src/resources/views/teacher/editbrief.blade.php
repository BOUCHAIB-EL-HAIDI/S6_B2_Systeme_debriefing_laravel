<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Brief - Debrief.me</title>
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
        <main class="flex-1 ml-64 p-8 flex justify-center">
            <div class="w-full max-w-3xl">
                <header class="mb-10 flex items-center gap-4">
                    <a href="{{ route('teacher.briefs') }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-white/10 transition-all">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-extrabold">Modifier le Brief</h1>
                        <p class="text-slate-400 mt-1">Mettez à jour les informations du projet pédagogique</p>
                    </div>
                </header>

                <div class="glass p-8 rounded-[2.5rem] shadow-2xl">
                    <form action="{{ route('teacher.briefs.update', $brief->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Titre du Brief</label>
                                <input type="text" name="title" value="{{ old('title', $brief->title) }}" required placeholder="ex : Système de débriefing" 
                                       class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600">
                                @error('title') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Contenu / Description</label>
                                <textarea name="content" required rows="4" placeholder="Objectifs, ressources, livrables attendus..."
                                          class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600">{{ old('content', $brief->content) }}</textarea>
                                @error('content') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Date de début</label>
                                    <input type="date" name="start_date" value="{{ old('start_date', $brief->start_date ? $brief->start_date->format('Y-m-d') : '') }}" required 
                                           class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-slate-300">
                                    @error('start_date') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Date de fin</label>
                                    <input type="date" name="end_date" value="{{ old('end_date', $brief->end_date ? $brief->end_date->format('Y-m-d') : '') }}" required 
                                           class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-slate-300">
                                    @error('end_date') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Type</label>
                                    <select name="type" required class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-slate-300">
                                        <option value="INDIVIDUAL" {{ old('type', $brief->type) == 'INDIVIDUAL' ? 'selected' : '' }}>Individuel</option>
                                        <option value="COLLECTIVE" {{ old('type', $brief->type) == 'COLLECTIVE' ? 'selected' : '' }}>Collectif</option>
                                    </select>
                                    @error('type') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Assigner à un Sprint</label>
                                    <select name="sprint_id" required class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-slate-300">
                                        <option value="">Sélectionner un sprint...</option>
                                        @foreach($sprints as $sprint)
                                            <option value="{{ $sprint->id }}" {{ old('sprint_id', $brief->sprint_id) == $sprint->id ? 'selected' : '' }}>{{ $sprint->name }} (Ordre: {{ $sprint->order }})</option>
                                        @endforeach
                                    </select>
                                    @error('sprint_id') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Compétences visées</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-slate-900/50 border border-white/10 rounded-2xl">
                                    @php
                                        $selectedCompetences = old('competences', $brief->competences->pluck('code')->toArray());
                                    @endphp
                                    @foreach($competences as $competence)
                                    <label class="flex items-center gap-3 p-2 hover:bg-white/5 rounded-xl cursor-pointer transition-all">
                                        <input type="checkbox" name="competences[]" value="{{ $competence->code }}" 
                                               {{ is_array($selectedCompetences) && in_array($competence->code, $selectedCompetences) ? 'checked' : '' }}
                                               class="w-4 h-4 rounded border-white/10 bg-slate-800 text-indigo-500 focus:ring-0">
                                        <span class="text-xs font-medium">{{ $competence->code }} - {{ $competence->label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('competences') <p class="text-rose-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
