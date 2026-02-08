<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compétences - Debrief.me</title>
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
                <a href="{{ route('admin.competences.index') }}" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="target"></i> <span>Compétences</span>
                </a>
                <a href="{{ route('admin.sprints.showandcreate') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="layers"></i> <span>Sprints</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold">Gestion des Compétences</h1>
                    <p class="text-slate-400 mt-1">Liste et administration des compétences du système</p>
                </div>
                <a href="{{ route('admin.competences.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 transition-all shadow-lg shadow-indigo-500/20">
                    <i data-lucide="plus-circle"></i> Ajouter une Compétence
                </a>
            </header>

            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-2xl mb-8 flex items-center gap-3">
                    <i data-lucide="check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="glass rounded-3xl overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10 text-slate-400 text-xs uppercase tracking-widest">
                            <th class="px-8 py-4">Code</th>
                            <th class="px-8 py-4">Libellé</th>
                            <th class="px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($competences as $competence)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-4 font-bold text-indigo-400">{{ $competence->code }}</td>
                                <td class="px-8 py-4 text-slate-300 font-medium">{{ $competence->label }}</td>
                                <td class="px-8 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.competences.edit', $competence->code) }}" class="p-2 bg-indigo-500/10 text-indigo-400 rounded-lg hover:bg-indigo-500 hover:text-white transition-all">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.competences.destroy', $competence->code) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-500/10 text-rose-400 rounded-lg hover:bg-rose-500 hover:text-white transition-all">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center text-slate-500 italic">
                                    <i data-lucide="info" class="w-8 h-8 mx-auto mb-3 opacity-20"></i>
                                    Aucune compétence enregistrée pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script> lucide.createIcons(); </script>
</body>
</html>
