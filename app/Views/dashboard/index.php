<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">

    <!-- Top Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50/90 via-white to-purple-50/60 dark:from-dark-700 dark:via-dark-700 dark:to-indigo-950/50 border border-indigo-100/80 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <?php if (is_client_user()): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> CLIENT PORTAL · <?= esc(session()->get('company_name') ?: 'PARTNER') ?>
                        </span>
                    <?php elseif (count($activeProjects) > 0): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span> SYSTEM HEALTH: <?= $avgHealth ?>%
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> NEW WORKSPACE · READY
                        </span>
                    <?php endif; ?>
                    <span class="text-xs text-slate-400 dark:text-slate-500">•</span>
                    <span class="text-xs text-slate-600 dark:text-slate-400 font-medium"><?= is_client_user() ? 'Brand Organization:' : 'Workspace:' ?> <strong class="text-slate-900 dark:text-white"><?= esc(is_client_user() ? (session()->get('company_name') ?: $activeWorkspace['name']) : $activeWorkspace['name']) ?></strong></span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    <?= is_client_user() ? 'Welcome to your Client Portal, ' . esc(session()->get('user_name')) : 'Welcome back, ' . esc(explode(' ', session()->get('user_name') ?? 'Admin')[0]) ?>.
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm max-w-2xl leading-relaxed">
                    <?php if (is_client_user()): ?>
                        Here is your dedicated client stakeholder overview for <strong class="text-slate-800 dark:text-slate-200"><?= esc(session()->get('company_name') ?: 'your campaign') ?></strong>. Review milestones, strategy briefs, live performance indicators, and sign off deliverables.
                    <?php elseif (!is_admin_user()): ?>
                        Here are your assigned specialist campaigns. You can execute AI workflows, optimize web properties, and deliver high-impact results for each project.
                    <?php else: ?>
                        Here is your live agency command center. Review active campaigns, monitor AI execution runs, and assign client deliverables with accountability.
                    <?php endif; ?>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <?php if (is_client_user()): ?>
                    <?php if (!empty($projects)): ?>
                        <a href="<?= project_url($projects[0]) ?>" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-md shadow-emerald-600/25 flex items-center gap-2 cursor-pointer">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            <span>View Project Deliverables</span>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <button onclick="document.getElementById('modalCreateProject').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-xs transition shadow-md shadow-indigo-600/25 flex items-center gap-2 cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>New Project</span>
                    </button>
                    <a href="<?= site_url('agents') ?>" class="px-4 py-2.5 rounded-xl bg-white dark:bg-dark-600 hover:bg-slate-50 dark:hover:bg-dark-500 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-semibold text-xs transition flex items-center gap-2 shadow-sm">
                        <i data-lucide="bot" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                        <span>Configure AI</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Step-by-Step Setup & Workflow Guide (Internal Agency Only) -->
    <?php if (!is_client_user()): ?>
    <?php
        $step1Done = count($agents) > 0;
        $step2Done = count($projects) > 0;
        $step3Done = ($tasksTotal ?? 0) > 0;
        $step4Done = ($tasksCompleted ?? 0) > 0 || count($activities) > 3;

        $completedCount = ($step1Done ? 1 : 0) + ($step2Done ? 1 : 0) + ($step3Done ? 1 : 0) + ($step4Done ? 1 : 0);
        $progressPct = round(($completedCount / 4) * 100);
    ?>
    <div class="bg-white dark:bg-dark-700/80 border border-indigo-100/90 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
        <!-- Header Row -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold shrink-0">
                    <i data-lucide="compass" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Agency Setup & Workflow Guide</h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/20">
                            <?= $completedCount ?>/4 Completed
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pehle kya set karna hai aur agle steps me kya hoga — Step-by-step roadmap guide.</p>
                </div>
            </div>

            <!-- Progress Bar & Toggle -->
            <div class="flex items-center gap-3 self-end sm:self-center">
                <div class="w-32 bg-slate-100 dark:bg-dark-600 rounded-full h-2 overflow-hidden border border-slate-200 dark:border-slate-700">
                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width: <?= $progressPct ?>%"></div>
                </div>
                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400"><?= $progressPct ?>%</span>
                <button type="button" onclick="document.getElementById('setupStepsGrid').classList.toggle('hidden'); this.querySelector('i').classList.toggle('rotate-180');" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white transition cursor-pointer" title="Toggle guide">
                    <i data-lucide="chevron-up" class="w-4 h-4 transition-transform duration-200"></i>
                </button>
            </div>
        </div>

        <!-- 4 Steps Interactive Grid -->
        <div id="setupStepsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3.5 pt-1">
            <!-- STEP 1 -->
            <div class="p-4 rounded-xl border <?= $step1Done ? 'border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/40 dark:bg-emerald-950/10' : 'border-indigo-200 dark:border-indigo-500/30 bg-indigo-50/20 dark:bg-dark-600/50 ring-1 ring-indigo-500/20' ?> flex flex-col justify-between space-y-3 relative group transition">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider <?= $step1Done ? 'text-emerald-700 dark:text-emerald-400' : 'text-indigo-600 dark:text-indigo-400' ?>">
                            STEP 1 · PEHLE YEH KAREIN
                        </span>
                        <?php if ($step1Done): ?>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Connected
                            </span>
                        <?php else: ?>
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse" title="Needs setup first"></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="key" class="w-3.5 h-3.5 text-indigo-500"></i> AI & API Keys Connect Karein
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                        OpenAI, Gemini ya Claude ki API Key add karein taaki AI agents autonomous strategy, copy aur audits generate kar sakein.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="<?= site_url('agents') ?>" class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold <?= $step1Done ? 'bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-dark-500 dark:text-slate-300' : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-600/20' ?> transition">
                        <span><?= $step1Done ? 'Manage Keys' : 'Connect API Key' ?></span>
                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="p-4 rounded-xl border <?= $step2Done ? 'border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/40 dark:bg-emerald-950/10' : 'border-slate-200 dark:border-slate-700 bg-slate-50/40 dark:bg-dark-600/30' ?> flex flex-col justify-between space-y-3 relative group transition">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider <?= $step2Done ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' ?>">
                            STEP 2 · PROJECT SETUP
                        </span>
                        <?php if ($step2Done): ?>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> <?= count($projects) ?> Created
                            </span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="folder-plus" class="w-3.5 h-3.5 text-indigo-500"></i> Client Project Create Karein
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                        Naya client campaign add karein aur required services select karein (Website, SEO, PPC, Meta Ads, Custom Software).
                    </p>
                </div>
                <div class="pt-2">
                    <button onclick="document.getElementById('modalCreateProject').classList.remove('hidden')" class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold <?= $step2Done ? 'bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-dark-500 dark:text-slate-300' : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-600/20' ?> transition cursor-pointer">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        <span><?= $step2Done ? 'Add Another Project' : '+ New Project' ?></span>
                    </button>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="p-4 rounded-xl border <?= $step3Done ? 'border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/40 dark:bg-emerald-950/10' : 'border-slate-200 dark:border-slate-700 bg-slate-50/40 dark:bg-dark-600/30' ?> flex flex-col justify-between space-y-3 relative group transition">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider <?= $step3Done ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' ?>">
                            STEP 3 · DELIVERABLES
                        </span>
                        <?php if ($step3Done): ?>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> <?= $tasksTotal ?> Tasks
                            </span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="check-square" class="w-3.5 h-3.5 text-indigo-500"></i> Strategy & Tasks Generate Karein
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                        Project open karke Strategy Brief review karein aur AI se deliverables aur actionable milestones generate karein.
                    </p>
                </div>
                <div class="pt-2">
                    <?php if (!empty($activeProjects)): ?>
                        <a href="<?= project_url($activeProjects[0]) ?>" class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-dark-500 dark:text-slate-300 transition">
                            <span>Open Project Brief</span>
                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    <?php else: ?>
                        <button disabled class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-400 bg-slate-100 dark:bg-dark-600 cursor-not-allowed">
                            <span>Requires Step 2 First</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="p-4 rounded-xl border <?= $step4Done ? 'border-emerald-200 dark:border-emerald-500/30 bg-emerald-50/40 dark:bg-emerald-950/10' : 'border-slate-200 dark:border-slate-700 bg-slate-50/40 dark:bg-dark-600/30' ?> flex flex-col justify-between space-y-3 relative group transition">
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider <?= $step4Done ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' ?>">
                            STEP 4 · LIVE EXECUTION
                        </span>
                        <?php if ($step4Done): ?>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Active
                            </span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                        <i data-lucide="play-circle" class="w-3.5 h-3.5 text-indigo-500"></i> Sync & AI Workflows Run Karein
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                        Connectors (GSC, Meta, Analytics) link karein, AI execution flow chalayein aur client report download karein.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="<?= site_url('activity') ?>" class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-dark-500 dark:text-slate-300 transition">
                        <span>Live Execution Log</span>
                        <i data-lucide="activity" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Executive Metrics Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Metric 1: Active Projects -->
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group hover:border-indigo-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider">ACTIVE PROJECTS</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20 flex items-center justify-center">
                    <i data-lucide="folder-kanban" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight"><?= count($activeProjects) ?></span>
                <span class="text-xs text-slate-500 dark:text-slate-400">/ <?= count($projects) ?> total</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">
                <?php if (count($activeProjects) > 0): ?>
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400"></i>
                    <span class="text-emerald-600 dark:text-emerald-400">Ready for execution</span>
                <?php else: ?>
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span>No active campaigns</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Metric 2: Deliverable Tasks -->
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group hover:border-purple-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider">TASKS & DELIVERABLES</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-100 dark:border-purple-500/20 flex items-center justify-center">
                    <i data-lucide="check-square" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight"><?= $tasksCompleted ?></span>
                <span class="text-xs text-slate-500 dark:text-slate-400">/ <?= $tasksTotal ?> completed</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">
                <?php if ($tasksTotal > 0): ?>
                    <?php $pct = round(($tasksCompleted / $tasksTotal) * 100); ?>
                    <i data-lucide="activity" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400"></i>
                    <span class="text-indigo-600 dark:text-indigo-400"><?= $pct ?>% completion rate</span>
                <?php else: ?>
                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span>0% completion rate</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Metric 3: Health Score -->
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group hover:border-emerald-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider">AVERAGE HEALTH SCORE</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight"><?= $avgHealth ?></span>
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">/ 100</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">
                <?php if (count($activeProjects) > 0): ?>
                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400"></i>
                    <span class="text-emerald-600 dark:text-emerald-400"><?= $avgHealth >= 80 ? 'Core Web Vitals optimal' : 'Optimization needed' ?></span>
                <?php else: ?>
                    <i data-lucide="info" class="w-3.5 h-3.5 text-slate-400"></i>
                    <span>No projects added yet</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Metric 4: AI Agents Fleet -->
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 p-5 rounded-2xl shadow-sm relative overflow-hidden group hover:border-amber-300 dark:hover:border-slate-700 transition">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider">AI AGENTS ACTIVE</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20 flex items-center justify-center">
                    <i data-lucide="bot" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight"><?= count($agents) ?></span>
                <span class="text-xs text-slate-500 dark:text-slate-400">models deployed</span>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 font-medium">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                <span>OpenAI · Gemini · Claude</span>
            </div>
        </div>
    </div>

    <!-- Active Projects Section -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="folder-kanban" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i> Active Projects
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700"><?= count($activeProjects) ?></span>
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Independent client goals with live status, metrics and deliverables.</p>
            </div>
            <a href="<?= site_url('projects') ?>" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center gap-1">
                View all in library <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <?php if (empty($activeProjects)): ?>
            <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 shadow-sm p-10 rounded-2xl text-center space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto">
                    <i data-lucide="folder-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">No active projects yet</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-md mx-auto mt-1">Get started by creating your first agency project. Add your brief, goals, audience, and AI workflow.</p>
                </div>
                <button onclick="document.getElementById('modalCreateProject').classList.remove('hidden')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold cursor-pointer">
                    Create First Project
                </button>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($activeProjects as $project): ?>
                    <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 shadow-sm p-5 rounded-2xl flex flex-col justify-between hover:border-indigo-300 dark:hover:border-indigo-500/40 hover:shadow-md transition group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <?= render_department_badges($project['department'] ?? 'Website') ?>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                                    <span>v<?= $project['version'] ?></span>
                                </div>
                            </div>

                            <a href="<?= project_url($project) ?>" class="block">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition"><?= esc($project['name']) ?></h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed"><?= esc($project['objective'] ?: 'No objective specified.') ?></p>
                            </a>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1 capitalize">
                                <i data-lucide="globe" class="w-3.5 h-3.5 text-slate-400"></i>
                                <?= esc($project['platform']) ?>
                            </span>
                            <a href="<?= project_url($project) ?>" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold flex items-center gap-1">
                                Open Brief <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Two-Column Operational Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column 1: Live AI Agents (2 Cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 shadow-sm p-6 rounded-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="bot" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i> Configured AI Agents & Prompts
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Specialist agents active for SEO audits, copywriting, and market research.</p>
                </div>
                <a href="<?= site_url('agents') ?>" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center gap-1">
                    Manage Keys <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="space-y-3">
                <?php foreach ($agents as $agent): ?>
                    <div class="p-4 rounded-xl bg-slate-50/80 dark:bg-dark-600/50 border border-slate-200/80 dark:border-slate-700/50 hover:bg-white dark:hover:bg-dark-600 hover:border-indigo-200 dark:hover:border-slate-600 hover:shadow-sm transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="sparkles" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white"><?= esc($agent['name']) ?></h4>
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-indigo-50 dark:bg-dark-500 text-indigo-700 dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-500/20"><?= esc($agent['model']) ?></span>
                                </div>
                                <p class="text-[11px] text-slate-600 dark:text-slate-400 mt-0.5 line-clamp-1"><?= esc($agent['system_prompt']) ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0 text-xs">
                            <span class="text-slate-500 dark:text-slate-400 font-mono"><?= $agent['total_runs'] ?> runs</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Active</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Column 2: Live Activity Stream (1 Col) -->
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 shadow-sm p-6 rounded-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-emerald-600 dark:text-emerald-400"></i> Live Activity
                </h3>
                <a href="<?= site_url('activity') ?>" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold">View All</a>
            </div>

            <div class="space-y-4">
                <?php if (empty($activities)): ?>
                    <p class="text-xs text-slate-500 text-center py-4">No recent activities recorded.</p>
                <?php else: ?>
                    <?php foreach ($activities as $act): ?>
                        <div class="flex items-start gap-3 text-xs">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 mt-1.5 shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-700 dark:text-slate-200 font-medium leading-snug">
                                    <strong class="text-slate-900 dark:text-white font-semibold"><?= esc($act['user_name']) ?></strong> <?= esc($act['action']) ?>
                                </p>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500"><?= esc(date('M d, H:i', strtotime($act['created_at']))) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
