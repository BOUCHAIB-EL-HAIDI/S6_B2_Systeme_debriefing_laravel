<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Sprint - Debrief.me</title>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.showusers') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="users"></i> <span>Utilisateurs</span>
                </a>
                <a href="{{ route('admin.classes.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="book-open"></i> <span>Classes</span>
                </a>
                <a href="{{ route('admin.competences.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="target"></i> <span>Compétences</span>
                </a>
                <a href="{{ route('admin.sprints.showandcreate') }}" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="layers"></i> <span>Sprints</span>
                </a>
                <a href="{{ route('admin.competences.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="target"></i> <span>Compétences</span>
                </a>
            </nav>

            <div class="pt-6 border-t border-white/10">
                <a href="{{ route('auth.logout') }}" class="flex items-center gap-3 p-3 rounded-xl text-rose-400 hover:bg-rose-500/10 transition-all">
                    <i data-lucide="log-out"></i> <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <header class="mb-10 flex items-center gap-4">
                <a href="{{ route('admin.sprints.showandcreate') }}" class="p-3 bg-white/5 text-slate-400 rounded-2xl hover:text-white transition-all">
                    <i data-lucide="arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold">Modifier le Sprint</h1>
                    <p class="text-slate-400 mt-1">Mise à jour des informations du sprint {{ $sprint->name }}</p>
                </div>
            </header>

            <div class="max-w-2xl">
                <form action="{{ route('admin.sprints.update', $sprint->id) }}" method="POST" class="glass p-8 rounded-3xl space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Nom du Sprint</label>
                        <input type="text" name="name" value="{{ old('name', $sprint->name) }}" placeholder="Ex: Sprint 1 - PHP" 
                               class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-indigo-500 transition-all @error('name') border-rose-500/50 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Durée (jours)</label>
                            <input type="number" name="duration" value="{{ old('duration', $sprint->duration) }}" placeholder="7" 
                                   class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-indigo-500 transition-all @error('duration') border-rose-500/50 @enderror">
                            @error('duration')
                                <p class="mt-2 text-sm text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Ordre</label>
                            <input type="number" name="order" value="{{ old('order', $sprint->order) }}" placeholder="1" 
                                   class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-indigo-500 transition-all @error('order') border-rose-500/50 @enderror">
                            @error('order')
                                <p class="mt-2 text-sm text-rose-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                            <i data-lucide="refresh-cw"></i> Mettre à jour le Sprint
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script> lucide.createIcons(); </script>
</body>
</html>
