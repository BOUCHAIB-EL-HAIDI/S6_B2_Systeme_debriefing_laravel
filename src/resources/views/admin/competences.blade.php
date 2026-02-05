<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Référentiel Compétences - Debrief.me</title>
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
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="book-open"></i> <span>Classes</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
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
                    <h1 class="text-3xl font-extrabold">Référentiel de Compétences</h1>
                    <p class="text-slate-400 mt-1">Définissez les compétences et les critères d'évaluation</p>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add Competence Form -->
                <div class="lg:col-span-1">
                    <div class="glass p-8 rounded-[2.5rem] sticky top-8">
                        <h3 class="text-xl font-bold mb-6">Nouvelle Compétence</h3>
                        
                        <form action="#" method="POST" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Code (Format: C1, C2...)</label>
                                <input type="text" name="code" required placeholder="C1" 
                                       class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Libellé</label>
                                <textarea name="label" required placeholder="Description de la compétence..." rows="3"
                                          class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder:text-slate-600"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                                Enregistrer
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Competences List -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="glass p-8 rounded-[2.5rem]">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold">Liste des Compétences</h3>
                            <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">0 Total</span>
                        </div>

                        <div class="space-y-3">
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/5 flex items-center justify-between group hover:border-indigo-500/30 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center font-bold text-sm">C1</div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white">Maquetter une application</h4>
                                        <p class="text-[10px] text-slate-500">Ajoutée le 01/01/2024</p>
                                    </div>
                                </div>
                            </div>
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
