<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dashboard - Debrief.me</title>
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
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="layout-dashboard"></i> <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="file-text"></i> <span>Mes Briefs</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400 hover:text-white">
                    <i data-lucide="award"></i> <span>Mon Parcours</span>
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
                    <h1 class="text-3xl font-extrabold">Bonjour, Student ! 👋</h1>
                    <p class="text-slate-400 mt-1">Bon retour sur votre espace de débriefing</p>
                </div>
                <!-- Notifications/Profile -->
                <div class="flex gap-4 items-center">
                    <button class="w-12 h-12 glass rounded-2xl flex items-center justify-center relative hover:bg-white/5 transition-all">
                        <i data-lucide="bell" class="w-5 h-5 text-slate-400"></i>
                        <span class="absolute top-3 right-3 w-2 h-2 bg-rose-500 rounded-full"></span>
                    </button>
                    <div class="glass px-4 py-2 rounded-2xl flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-bold">John Doe</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider">student</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-emerald-500 text-slate-900 flex items-center justify-center font-bold">
                            J
                        </div>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Current Brief & Tasks -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Featured Card -->
                    <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 p-8 rounded-[2.5rem] relative overflow-hidden shadow-2xl shadow-indigo-500/20">
                        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end">
                            <div>
                                <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-4 inline-block">Dernier Brief Assigné</span>
                                <h2 class="text-4xl font-black mb-2">Brief PHP MVC</h2>
                                <p class="text-indigo-100/70 text-sm max-w-sm mb-6">Création d'un système de gestion de débriefing en utilisant l'architecture MVC...</p>
                                <a href="#" class="bg-white text-indigo-600 px-6 py-3 rounded-2xl font-bold inline-flex items-center gap-2 hover:scale-105 transition-transform shadow-lg">
                                    <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                                    Accéder au Brief
                                </a>
                            </div>
                            <div class="mt-8 md:mt-0 text-right">
                                <p class="text-xs uppercase font-bold text-indigo-200">Date limite</p>
                                <p class="text-2xl font-black leading-none mt-1">10 Feb</p>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Briefs / History Section -->
                    <div class="glass p-8 rounded-[2.5rem]">
                        <h3 class="text-xl font-bold mb-6">Autres Briefs Assignés</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-slate-900/50 border border-white/5 rounded-2xl flex flex-col justify-between group hover:border-indigo-500/30 transition-all">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-[10px] uppercase font-bold text-slate-500">Sprint 1</span>
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    </div>
                                    <h4 class="font-bold text-white mb-1">Brief UML</h4>
                                    <p class="text-xs text-slate-400 line-clamp-2">Conception des diagrammes UML pour le projet...</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-white/5 flex justify-between items-center">
                                    <span class="text-[10px] text-slate-500">Fin le 05/01</span>
                                    <a href="#" class="text-xs text-indigo-400 font-bold group-hover:underline">Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Feed/Messages -->
                <div class="space-y-8">
                    <div class="glass p-8 rounded-[2.5rem]">
                        <h3 class="text-xl font-bold mb-6">Flux d'Activité</h3>
                        <div class="space-y-6">
                            <div class="relative pl-6 border-l-2 border-indigo-500/30">
                                <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-indigo-500"></div>
                                <span class="text-[10px] text-slate-500 uppercase font-bold">Aujourd'hui, 09:00</span>
                                <h4 class="text-sm font-bold mt-1">Nouveau brief assigné</h4>
                                <p class="text-xs text-slate-400 mt-2">Brief PHP MVC</p>
                            </div>
                            <div class="relative pl-6 border-l-2 border-indigo-500/30">
                                <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-indigo-500"></div>
                                <span class="text-[10px] text-slate-500 uppercase font-bold">Hier, 14:00</span>
                                <h4 class="text-sm font-bold mt-1">Brief UML corrigé</h4>
                                <p class="text-xs text-slate-400 mt-2">Votre formateur a validé vos compétences.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glass p-8 rounded-[2.5rem] bg-indigo-500 shadow-xl shadow-indigo-500/20 text-white group">
                        <i data-lucide="award" class="w-8 h-8 mb-4 group-hover:rotate-12 transition-transform"></i>
                        <h4 class="text-lg font-black mb-2">Badges Disponibles</h4>
                        <p class="text-xs text-indigo-100 leading-relaxed mb-6">Validez encore 2 compétences en back-end pour débloquer le badge "Maître Serveur".</p>
                        <button class="w-full py-3 bg-white text-indigo-600 rounded-xl font-bold text-xs">VOIR MES BADGES</button>
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
