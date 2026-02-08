<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Classe - Debrief.me</title>
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
                <a href="/admin/dashboard" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="/admin/users" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-500 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="users"></i> <span>Utilisateurs</span>
                </a>
                <a href="/admin/classes" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-500 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="book-open"></i> <span>Classes</span>
                </a>
                <a href="/admin/competences" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-500 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="target"></i> <span>Compétences</span>
                </a>
                <a href="/admin/sprints" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-500 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="layers"></i> <span>Sprints</span>
                </a>
            </nav>

            <div class="pt-6 border-t border-white/10">
                <a href="{{ url('/logout') }}" class="flex items-center gap-3 p-3 rounded-xl text-rose-400 hover:bg-rose-500/10 transition-all">
                    <i data-lucide="log-out"></i> <span>Déconnexion</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8 flex justify-center">
            <div class="w-full max-w-2xl">
                <header class="mb-10 flex items-center gap-4">
                    <a href="{{ route('admin.classes.index') }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-white/10 transition-all">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-extrabold">Nouvelle Classe</h1>
                        <p class="text-slate-400 mt-1">Configurez la nouvelle promotion</p>
                    </div>
                </header>

                <div class="glass p-8 rounded-[2.5rem] shadow-2xl">
                    @if ($errors->any())

                    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 font-bold">
                       <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)

                           <li>{{  $error  }} </li>
                        @endforeach
                       </ul>
                    </div>
                    @endif
                    <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Nom de la classe</label>
                            <input type="text" name="name" placeholder="ex: WEB-2024-C" required
                                   class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Année</label>
                            <input type="number" name="year" placeholder="2024" required min="2000" max="2100"
                                   class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600">
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                Créer la classe
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
