<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Classes - Debrief.me</title>
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
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="users"></i> <span>Utilisateurs</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="book-open"></i> <span>Classes</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="target"></i> <span>Compétences</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="layers"></i> <span>Sprints</span>
                </a>
            </nav>

            <div class="pt-6 border-t border-white/10">
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-rose-400 hover:bg-rose-500/10 transition-all">
                    <i data-lucide="log-out"></i> <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold">Gestion des Classes</h1>
                    <p class="text-slate-400 mt-1">Gérez les promotions et affectez les formateurs</p>
                </div>
                <a href="{{ route('admin.classes.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 transition-all shadow-lg shadow-indigo-500/20">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Créer une Classe
                </a>
            </header>


            @if(session('success'))
            <div id="success-message"
                class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold">
             {{ session('success') }}
            </div>
             @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($classes as $classe)
                <!-- Class Card -->
                <div class="glass p-6 rounded-[2rem] hover:border-indigo-500/50 transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 bg-indigo-500 shadow-lg shadow-indigo-500/20 rounded-2xl flex items-center justify-center">
                            <i data-lucide="users" class="text-white"></i>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] text-slate-500 uppercase font-bold">Année</span>
                            <span class="text-sm font-bold text-slate-300">{{ $classe->year }}</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-extrabold mb-1">{{ $classe->name }}</h3>
                    <p class="text-xs text-slate-500 mb-6">Promotion active</p>

                    <div class="space-y-3 mb-8">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Apprenants</span>
                            <span class="font-bold text-emerald-400">
                                0/26
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Formateur principal</span>
                            <span class="text-indigo-400 font-medium">Non assigné</span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.classes.edit', $classe->id) }}" class="flex-1 py-2 rounded-xl bg-white/5 text-xs font-bold hover:bg-indigo-500 transition-all text-center flex items-center justify-center gap-2">
                            <i data-lucide="edit-3" class="w-3 h-3"></i> Modifier
                        </a>
                        <form action="{{ route('admin.classes.destroy', $classe->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 rounded-xl bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>
</html>
