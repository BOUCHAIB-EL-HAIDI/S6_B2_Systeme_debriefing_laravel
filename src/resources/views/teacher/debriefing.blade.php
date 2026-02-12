<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Débriefing Pédagogique - Debrief.me</title>
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
                <a href="{{ route('teacher.briefs') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-all text-slate-400">
                    <i data-lucide="file-text"></i> <span>Briefs</span>
                </a>
                <a href="{{ route('teacher.debriefing') }}" class="flex items-center gap-3 p-3 rounded-xl text-white bg-indigo-500 shadow-lg shadow-indigo-500/20">
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
                    <h1 class="text-3xl font-extrabold">Débriefing Pédagogique</h1>
                    <p class="text-slate-400 mt-1">Évaluez les compétences par apprenant</p>
                </div>
                <div class="glass px-4 py-2 rounded-2xl flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ Auth::user()->role ?? 'FORMATEUR' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white uppercase">
                        {{ substr(Auth::user()->first_name, 0, 1) }}
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div id="readOnlyBanner" class="hidden mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 font-bold flex items-center gap-3">
                <i data-lucide="lock" class="w-5 h-5"></i>
                <span>Mode Lecture : Cette évaluation a déjà été validée et ne peut plus être modifiée.</span>
            </div>

            <div id="noSubmissionBanner" class="hidden mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 font-bold flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span>Action Requise : L'étudiant n'a pas encore soumis de travail. L'évaluation est bloquée.</span>
            </div>

            <form action="{{ route('teacher.debriefing.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Selection Column -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="glass p-6 rounded-3xl">
                            <h3 class="text-lg font-bold mb-4">Sélection</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs text-slate-400 mb-2 block uppercase tracking-widest">Le Brief</label>
                                    <select name="brief_id" required id="briefSelect" class="w-full bg-slate-900/50 border border-white/10 rounded-xl p-3 outline-none focus:border-indigo-500 transition-all text-slate-300">
                                        <option value="">Sélectionner un brief...</option>
                                        @foreach($briefs as $brief)
                                            <option value="{{ $brief->id }}" {{ (isset($selectedBriefId) && $selectedBriefId == $brief->id) ? 'selected' : '' }}>{{ $brief->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs text-slate-400 mb-2 block uppercase tracking-widest">L'Apprenant</label>
                                    <select name="student_id" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl p-3 outline-none focus:border-indigo-500 transition-all text-slate-300">
                                        <option value="">Sélectionner un étudiant...</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ (isset($selectedStudentId) && $selectedStudentId == $student->id) ? 'selected' : '' }}>{{ $student->first_name }} {{ $student->last_name }} ({{ $student->classe->name ?? 'Sans Classe' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between">
                                <span class="text-sm text-slate-400">Statut Livrable</span>
                                <span id="livrableStatus" class="px-3 py-1 rounded-full bg-slate-800 text-slate-500 text-xs font-bold uppercase">—</span>
                            </div>
                        </div>
                    </div>

                    <!-- Evaluation Column -->
                    <div class="lg:col-span-2 glass p-8 rounded-3xl">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xl font-bold">Évaluation des compétences</h3>
                            <span class="text-sm text-slate-400">Statut: <span id="currentBriefTitle" class="text-white font-bold">—</span></span>
                        </div>

                        <div id="evaluationContainer" class="space-y-10">
                            <!-- Dynamically loaded competences will appear here -->
                            <div class="flex flex-col items-center justify-center py-20 text-slate-500 italic">
                                <i data-lucide="info" class="w-8 h-8 mb-3 opacity-20"></i>
                                <p>Veuillez sélectionner un brief pour commencer l'évaluation.</p>
                            </div>
                        </div>

                        <div class="mt-10 pt-10 border-t border-white/10 space-y-6">
                            <div class="space-y-4">
                                <label class="text-xs text-slate-400 uppercase tracking-widest block font-bold">Feedback Constructif Global</label>
                                <textarea name="comment" class="w-full bg-slate-900/50 border border-white/10 rounded-2xl p-4 outline-none focus:border-indigo-500 transition-all h-32 placeholder:text-slate-600" placeholder="Ex: Excellent travail sur la planification, attention aux délais sur la phase de tests..."></textarea>
                            </div>

                            <div class="flex justify-end gap-4">
                                <button type="reset" class="px-6 py-3 rounded-xl border border-white/10 text-slate-400 hover:bg-white/5 transition-all font-bold">Réinitialiser</button>
                                <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-500 hover:bg-indigo-600 shadow-lg shadow-indigo-500/20 transition-all font-bold text-white">Enregistrer le débrief</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        lucide.createIcons();

        const briefSelect = document.getElementById('briefSelect');
        const studentSelect = document.querySelector('select[name="student_id"]');
        const livrableStatusEl = document.getElementById('livrableStatus');
        const evalContainer = document.getElementById('evaluationContainer');
        const currentBriefTitle = document.getElementById('currentBriefTitle');

        function refreshFormState() {
            const briefId = briefSelect.value;
            const studentId = studentSelect.value;
            
            if (!briefId || !studentId) {
                livrableStatusEl.innerText = '—';
                livrableStatusEl.className = 'px-3 py-1 rounded-full bg-slate-800 text-slate-500 text-xs font-bold uppercase';
                if (document.getElementById('livrableDetailsContainer')) {
                    document.getElementById('livrableDetailsContainer').innerHTML = '';
                }
                resetEvaluationForm();
                disableEvaluationForm(true); // Disable until selection
                return;
            }

            livrableStatusEl.innerText = 'Vérification...';
            resetEvaluationForm();
            disableEvaluationForm(true); // Disable while loading

            // Sequence: Check Submissions -> Check Evaluations
            fetch(`/teacher/briefs/${briefId}/students/${studentId}/livrable`)
                .then(response => response.json())
                .then(submissionData => {
                    updateSubmissionUI(submissionData);
                    
                    if (submissionData.submitted) {
                        // Only check evaluations if submitted
                        return fetch(`/teacher/debriefing/data?brief_id=${briefId}&student_id=${studentId}`);
                    } else {
                        // Not submitted -> form stays disabled
                        document.getElementById('noSubmissionBanner').classList.remove('hidden');
                        return null;
                    }
                })
                .then(response => response ? response.json() : null)
                .then(evalData => {
                    if (evalData && evalData.found) {
                        populateEvaluationForm(evalData);
                        disableEvaluationForm(true);
                        document.getElementById('readOnlyBanner').classList.remove('hidden');
                    } else if (evalData) {
                        // Submitted but not evaluated -> ENABLE form
                        disableEvaluationForm(false);
                    }
                });
        }

        function updateSubmissionUI(data) {
            const container = document.getElementById('livrableDetailsContainer');
            if (!container) {
                const newContainer = document.createElement('div');
                newContainer.id = 'livrableDetailsContainer';
                newContainer.className = 'mt-4 space-y-4';
                livrableStatusEl.parentElement.after(newContainer);
            }
            const detailsContainer = document.getElementById('livrableDetailsContainer');

            if (data.submitted) {
                livrableStatusEl.innerText = `${data.count} Rendu(s)`;
                livrableStatusEl.className = 'px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold uppercase';
                document.getElementById('noSubmissionBanner').classList.add('hidden');
                
                detailsContainer.innerHTML = data.deliveries.map((liv, index) => `
                    <div class="p-4 bg-slate-900/50 border border-white/5 rounded-2xl">
                        <p class="text-[10px] text-slate-500 uppercase font-bold mb-2">Rendu #${data.count - index}</p>
                        <a href="${liv.content}" target="_blank" class="text-sm text-indigo-400 hover:underline flex items-center gap-2 break-all mb-2">
                            <i data-lucide="external-link" class="w-3 h-3 flex-shrink-0"></i> Voir le travail
                        </a>
                        ${liv.comment ? `<p class="text-xs text-slate-400 italic mt-2 border-t border-white/5 pt-2">"${liv.comment}"</p>` : ''}
                    </div>
                `).join('');
                lucide.createIcons();
            } else {
                livrableStatusEl.innerText = 'Non Rendu';
                livrableStatusEl.className = 'px-3 py-1 rounded-full bg-rose-500/20 text-rose-400 text-xs font-bold uppercase';
                detailsContainer.innerHTML = '';
            }
        }

        function populateEvaluationForm(data) {
            const commentArea = document.querySelector('textarea[name="comment"]');
            commentArea.value = data.comment || '';
            
            Object.keys(data.evaluations).forEach(code => {
                const eval = data.evaluations[code];
                const item = document.querySelector(`.competence-item[data-code="${code}"]`);
                if (item) {
                    const statusSelect = item.querySelector(`select[name="evaluations[${code}][status]"]`);
                    if (statusSelect) statusSelect.value = eval.status;

                    const levelCard = item.querySelector(`.level-card[data-level="${eval.niveau}"]`);
                    if (levelCard) levelCard.click();
                }
            });
        }

        studentSelect.addEventListener('change', refreshFormState);

        briefSelect.addEventListener('change', function() {
            const briefId = this.value;
            const briefName = this.options[this.selectedIndex].text;
            
            refreshFormState();

            if (!briefId) {
                evalContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-20 text-slate-500 italic">
                        <i data-lucide="info" class="w-8 h-8 mb-3 opacity-20"></i>
                        <p>Veuillez sélectionner un brief pour commencer l'évaluation.</p>
                    </div>
                `;
                currentBriefTitle.innerText = '—';
                lucide.createIcons();
                return;
            }

            // Show loading state for competences
            evalContainer.innerHTML = '<div class="flex justify-center py-20"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div></div>';
            currentBriefTitle.innerText = briefName;

            fetch(`/teacher/briefs/${briefId}/competences`)
                .then(response => response.json())
                .then(competences => {
                    renderCompetences(competences);
                    // After rendering items, refresh state again to ensure banners/locking apply to new items
                    refreshFormState();
                })
                .catch(error => {
                    console.error('Error fetching competences:', error);
                    evalContainer.innerHTML = '<p class="text-rose-500 text-center py-10">Erreur lors du chargement des compétences.</p>';
                });
        });

        // Trigger initial load if values are pre-selected
        if (briefSelect.value) {
            briefSelect.dispatchEvent(new Event('change'));
        }

        function renderCompetences(competences) {
            if (competences.length === 0) {
                evalContainer.innerHTML = '<p class="text-center text-slate-500 italic py-10">Aucune compétence associée à ce brief.</p>';
                return;
            }

            evalContainer.innerHTML = competences.map(comp => `
                <div class="pb-8 border-b border-white/10 competence-item" data-code="${comp.code}">
                    <div class="flex justify-between items-start mb-6">
                        <div class="max-w-[70%]">
                            <h4 class="text-indigo-400 font-bold text-lg">${comp.code}: ${comp.label}</h4>
                            <p class="text-xs text-slate-500 mt-1">Évaluation du niveau d'acquisition pour cette compétence.</p>
                        </div>
                        <select name="evaluations[${comp.code}][status]" class="bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-lg px-3 py-2 text-xs font-bold uppercase outline-none focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="VALIDEE">Validée</option>
                            <option value="INVALIDE">Invalide</option>
                        </select>
                    </div>
                    
                    <input type="hidden" name="evaluations[${comp.code}][niveau]" value="NIVEAU_1">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="level-card cursor-pointer bg-indigo-500/20 border-2 border-indigo-500 p-4 rounded-2xl flex flex-col items-center transition-all" data-level="NIVEAU_1">
                            <span class="text-[10px] uppercase font-bold text-indigo-300">Niveau 1</span>
                            <span class="text-xs font-bold">Imiter</span>
                        </div>
                        <div class="level-card cursor-pointer bg-slate-900 border-2 border-white/5 p-4 rounded-2xl flex flex-col items-center grayscale opacity-50 hover:opacity-100 transition-all" data-level="NIVEAU_2">
                            <span class="text-[10px] uppercase font-bold text-slate-500">Niveau 2</span>
                            <span class="text-xs font-bold">S'adapter</span>
                        </div>
                        <div class="level-card cursor-pointer bg-slate-900 border-2 border-white/5 p-4 rounded-2xl flex flex-col items-center grayscale opacity-50 hover:opacity-100 transition-all" data-level="NIVEAU_3">
                            <span class="text-[10px] uppercase font-bold text-slate-500">Niveau 3</span>
                            <span class="text-xs font-bold">Transposer</span>
                        </div>
                    </div>
                </div>
            `).join('');

            // Add click events to level cards
            evalContainer.querySelectorAll('.level-card').forEach(card => {
                card.addEventListener('click', function() {
                    const parent = this.closest('.competence-item');
                    const hiddenInput = parent.querySelector('input[type="hidden"]');
                    
                    // Reset all cards in this item
                    parent.querySelectorAll('.level-card').forEach(c => {
                        c.classList.remove('bg-indigo-500/20', 'border-indigo-500');
                        c.classList.add('bg-slate-900', 'border-white/5', 'grayscale', 'opacity-50');
                        const span = c.querySelector('span:first-child');
                        span.classList.remove('text-indigo-300');
                        span.classList.add('text-slate-500');
                    });

                    // Set this card as active
                    this.classList.add('bg-indigo-500/20', 'border-indigo-500');
                    this.classList.remove('bg-slate-900', 'border-white/5', 'grayscale', 'opacity-50');
                    const span = this.querySelector('span:first-child');
                    span.classList.remove('text-slate-500');
                    span.classList.add('text-indigo-300');
                    
                    hiddenInput.value = this.dataset.level;
                });
            });

            lucide.createIcons();
        }
    </script>
</body>
</html>
