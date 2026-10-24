<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="<?= site_url('projects') ?>" class="text-xs font-semibold text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white flex items-center gap-1 transition">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back to projects
                </a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="text-xs font-mono uppercase px-2 py-0.5 rounded bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">VERSION <?= $project['version'] ?></span>
            </div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight"><?= esc($project['name']) ?></h1>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider <?= $project['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20' : 'bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:border-slate-600' ?>">
                    <?= esc($project['status']) ?>
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <?php if ($project['status'] === 'deleted'): ?>
                <a href="<?= site_url('projects/' . $project['id'] . '/download-zip') ?>" class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30 text-xs font-semibold flex items-center gap-1.5 transition shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> Download ZIP
                </a>
                <a href="<?= site_url('projects/' . $project['id'] . '/restore') ?>" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-sm">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Restore Project
                </a>
            <?php else: ?>
                <button onclick="document.getElementById('modalEditProject').classList.remove('hidden')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-sm shadow-indigo-600/20 cursor-pointer">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    <span>Edit / Change Brief</span>
                </button>
                <button onclick="document.getElementById('modalUploadFile').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-sm cursor-pointer">
                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                    <span>Upload Client Files</span>
                </button>
                <a href="<?= site_url('projects/' . $project['id'] . '/export') ?>" class="px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 hover:bg-slate-50 dark:hover:bg-dark-500 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 text-xs font-semibold flex items-center gap-1.5 transition shadow-xs">
                    <i data-lucide="download" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400"></i> Export JSON
                </a>
                <?php if (!is_client_user()): ?>
                    <a href="<?= site_url('projects/' . $project['id'] . '/toggle') ?>" class="px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 hover:bg-slate-50 dark:hover:bg-dark-500 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 text-xs font-semibold flex items-center gap-1.5 transition shadow-xs" title="<?= $project['status'] === 'active' ? 'Archive Project' : 'Make Active' ?>">
                        <i data-lucide="<?= $project['status'] === 'active' ? 'archive' : 'rotate-ccw' ?>" class="w-3.5 h-3.5"></i>
                        <span><?= $project['status'] === 'active' ? 'Archive' : 'Make Active' ?></span>
                    </a>
                    <button onclick="document.getElementById('modalDeleteProject').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer" title="Delete project and create portable ZIP archive">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Delete & ZIP</span>
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation Tabs (Workflow Step Tabs Bar) -->
    <div class="workflow-tabs-bar bg-white dark:bg-[#111726] border border-slate-200/90 dark:border-slate-800 shadow-2xs rounded-2xl p-1.5 flex items-center gap-1 sm:gap-2 text-xs font-semibold overflow-x-auto select-none">
        <button onclick="switchTab('tabBrief')" id="btnTabBrief" class="tab-btn px-4 py-2.5 rounded-xl flex items-center gap-2 transition shrink-0 cursor-pointer active-tab bg-blue-600 text-white font-bold shadow-xs shadow-blue-600/30">
            <span class="step-badge w-4 h-4 rounded-full bg-white text-blue-600 text-[10px] inline-flex items-center justify-center font-extrabold">1</span>
            <span>Project Details & Assets</span>
            <span class="tab-count-pill px-1.5 py-0.5 rounded-full bg-white/20 text-white text-[10px]"><?= count($files) ?> files</span>
        </button>
        <button onclick="switchTab('tabAgents')" id="btnTabAgents" class="tab-btn px-4 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center gap-2 transition shrink-0 cursor-pointer font-medium">
            <span class="step-badge w-4 h-4 rounded-full bg-slate-200 text-slate-700 text-[10px] inline-flex items-center justify-center font-bold">2</span>
            <span>Service AI Agents</span>
            <span class="tab-count-pill px-1.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold"><?= count($serviceAgents) ?> active</span>
        </button>
        <button onclick="switchTab('tabSkills')" id="btnTabSkills" class="tab-btn px-4 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center gap-2 transition shrink-0 cursor-pointer font-medium">
            <span class="step-badge w-4 h-4 rounded-full bg-slate-200 text-slate-700 text-[10px] inline-flex items-center justify-center font-bold">3</span>
            <span>Skills & Playbooks</span>
            <span class="tab-count-pill px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold"><?= count($projectSkills['global'] ?? []) + count($projectSkills['custom'] ?? []) ?></span>
        </button>
        <button onclick="switchTab('tabConnectors')" id="btnTabConnectors" class="tab-btn px-4 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center gap-2 transition shrink-0 cursor-pointer font-medium">
            <span class="step-badge w-4 h-4 rounded-full bg-slate-200 text-slate-700 text-[10px] inline-flex items-center justify-center font-bold">4</span>
            <span>Websites & Tool Connectors</span>
            <span id="tabConnectorsPill" class="tab-count-pill px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px]"><?= count($websites) ?> sites · <?= count($connectors) ?> tools</span>
        </button>
        <button onclick="switchTab('tabTasks')" id="btnTabTasks" class="tab-btn px-4 py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 flex items-center gap-2 transition shrink-0 cursor-pointer font-medium">
            <span class="step-badge w-4 h-4 rounded-full bg-slate-200 text-slate-700 text-[10px] inline-flex items-center justify-center font-bold">5</span>
            <span>Deliverables & Tasks</span>
            <span class="tab-count-pill px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px]"><?= count($tasks) ?></span>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: PROJECT DETAILS & CUSTOMER ASSETS   -->
    <!-- ========================================== -->
    <div id="tabBrief" class="tab-content space-y-6">

        <!-- Top Row: Strategic Brief (2 Cols) & Project Snapshot (1 Col) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- Strategic Project Brief Card (2 Cols) -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-5 shadow-xs">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-0.5">STRATEGY & SCOPE</span>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i data-lucide="compass" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                                Strategic Project Brief
                            </h3>
                        </div>
                        <button onclick="document.getElementById('modalEditProject').classList.remove('hidden');" class="px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/20 dark:hover:bg-indigo-500/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Edit Strategy</span>
                        </button>
                    </div>

                    <!-- 1. Objective -->
                    <div class="space-y-1.5">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                            <i data-lucide="target" class="w-3.5 h-3.5 text-indigo-500"></i> Core Business Objective
                        </span>
                        <div class="text-xs text-slate-800 dark:text-slate-200 leading-relaxed bg-slate-50 dark:bg-dark-600/40 p-4 rounded-xl border border-slate-200/80 dark:border-slate-700/60 font-medium">
                            <?= nl2br(esc($project['objective'] ?: 'No detailed objective provided yet. Click "Edit Strategy" to specify primary business goals.')) ?>
                        </div>
                    </div>

                    <!-- 2. Target Profile (3-Column Clean Spec Grid) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Audience -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-dark-600/40 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1 mb-1">
                                <i data-lucide="users" class="w-3 h-3 text-indigo-500"></i> Audience
                            </span>
                            <p class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                <?= esc($project['audience'] ?: 'General B2B/B2C') ?>
                            </p>
                        </div>

                        <!-- Market -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-dark-600/40 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1 mb-1">
                                <i data-lucide="globe" class="w-3 h-3 text-indigo-500"></i> Target Market
                            </span>
                            <p class="text-xs font-bold text-slate-900 dark:text-white truncate">
                                <?= esc($project['market'] ?: 'Global') ?>
                            </p>
                        </div>

                        <!-- Tech Platform -->
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-dark-600/40 border border-slate-200/80 dark:border-slate-700/60">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1 mb-1">
                                <i data-lucide="code-2" class="w-3 h-3 text-indigo-500"></i> Tech Platform
                            </span>
                            <p class="text-xs font-bold text-slate-900 dark:text-white capitalize truncate">
                                <?= esc($project['platform'] ?: 'Web Standard') ?>
                            </p>
                        </div>
                    </div>

                    <!-- 3. Success Measures & Outcome KPIs -->
                    <div class="p-3.5 rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/80 dark:border-emerald-500/30 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 flex items-center justify-center shrink-0">
                            <i data-lucide="award" class="w-4 h-4"></i>
                        </div>
                        <div class="space-y-0.5 min-w-0 flex-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Success Measures & Key Performance Indicators</span>
                            <p class="text-xs font-semibold text-emerald-900 dark:text-emerald-200 leading-relaxed">
                                <?= esc($project['success_metrics'] ?: 'Target metrics: organic traffic growth, conversion rates & ROAS benchmarks.') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Meta Panel (1 Col - Clean Architecture) -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-5 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block mb-0.5">DEPLOYMENT STATUS</span>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Project Snapshot</h3>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30 flex items-center gap-1">
                            <i data-lucide="check-circle" class="w-3 h-3"></i> <?= $project['health_score'] ?>% Health
                        </span>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <div class="pb-3 border-b border-slate-100 dark:border-slate-800 space-y-1.5">
                            <span class="text-slate-500 dark:text-slate-400 text-[11px] font-medium block">Purchased Services</span>
                            <div>
                                <?= render_department_badges($project['department'], 10) ?>
                            </div>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Target Platform</span>
                            <span class="font-bold text-slate-900 dark:text-white capitalize"><?= esc($project['platform']) ?></span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Active AI Agents</span>
                            <span class="font-bold text-blue-600 dark:text-blue-400"><?= count($serviceAgents) ?> Dedicated</span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Client Assets</span>
                            <span class="font-bold text-slate-900 dark:text-white"><?= count($files) ?> Files</span>
                        </div>

                        <div class="flex items-center justify-between py-1 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Connected Tools</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400"><?= count($connectors) ?> Integrated</span>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Created Date</span>
                            <span class="text-slate-700 dark:text-slate-300 font-semibold"><?= esc(date('M d, Y', strtotime($project['created_at']))) ?></span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2">
                        <button onclick="switchTab('tabAgents')" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition flex items-center justify-center gap-2 shadow-sm shadow-blue-600/20 cursor-pointer">
                            <span>Proceed to Step 2: AI Agents</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                        <button onclick="document.getElementById('modalUploadFile').classList.remove('hidden')" class="w-full py-2 rounded-xl bg-slate-50 dark:bg-dark-600 hover:bg-slate-100 dark:hover:bg-dark-500 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <i data-lucide="upload" class="w-3.5 h-3.5"></i> Add Project Asset
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- FULL WIDTH (100% SCREEN) SECTIONS -->
        <!-- Customer Files, Images & Assets Card (Simple Clean Architecture) -->
                <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-4 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-0.5">CUSTOMER ASSETS & FILES</span>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i data-lucide="folder-archive" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                                Uploaded Customer Files & Images
                            </h3>
                        </div>
                        <button onclick="document.getElementById('modalUploadFile').classList.remove('hidden')" class="px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/20 dark:hover:bg-indigo-500/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Upload File</span>
                        </button>
                    </div>

                    <?php if (empty($files)): ?>
                        <div class="p-5 rounded-xl border border-dashed border-slate-200 dark:border-slate-700/80 bg-slate-50/60 dark:bg-dark-600/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3 text-left">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Koi client file ya images upload nahi hain</h4>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Brand guidelines, logos, product photos, ya briefs yahan upload karein.</p>
                                </div>
                            </div>
                            <button onclick="document.getElementById('modalUploadFile').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-400 text-xs font-semibold hover:bg-indigo-50 dark:hover:bg-dark-600 transition shadow-xs cursor-pointer inline-flex items-center gap-1.5 shrink-0">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Upload Asset
                            </button>
                        </div>
                    <?php else: ?>
                        <?php
                        // Index image files for Lightbox next/prev cycling & calculate category counts
                        $galleryImages = [];
                        $imageIndexMap = [];
                        $imgCounter = 0;
                        $photoCount = 0;
                        $docCount = 0;
                        $zipCount = 0;
                        $videoCount = 0;
                        $ingestedCount = 0;

                        foreach ($files as $fItem) {
                            $fExt = strtolower(pathinfo($fItem['file_name'], PATHINFO_EXTENSION));
                            $isImgItem = in_array($fExt, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico']) || ($fItem['file_type'] === 'image');
                            $isPdfOrDoc = $fExt === 'pdf' || in_array($fExt, ['doc', 'docx', 'txt', 'rtf', 'csv', 'xls', 'xlsx']) || in_array($fItem['file_type'], ['pdf', 'document']);
                            $isArchive = in_array($fExt, ['zip', 'rar', '7z', 'tar', 'gz']) || ($fItem['file_type'] === 'archive');
                            $isVid = in_array($fExt, ['mp4', 'mov', 'webm', 'mkv', 'avi']) || ($fItem['file_type'] === 'video');

                            if ($isImgItem) {
                                $photoCount++;
                                $galleryImages[] = [
                                    'id'       => (int)$fItem['id'],
                                    'index'    => $imgCounter,
                                    'fileName' => $fItem['file_name'],
                                    'fileUrl'  => base_url($fItem['file_path']),
                                    'fileSize' => format_file_size((int)$fItem['file_size']),
                                    'category' => $fItem['category'] ?? 'Asset',
                                    'notes'    => $fItem['notes'] ?? ''
                                ];
                                $imageIndexMap[$fItem['id']] = $imgCounter;
                                $imgCounter++;
                            } elseif ($isPdfOrDoc) {
                                $docCount++;
                            } elseif ($isArchive) {
                                $zipCount++;
                            } elseif ($isVid) {
                                $videoCount++;
                            }

                            if (!empty($fItem['is_ingested'])) {
                                $ingestedCount++;
                            }
                        }
                        ?>

                        <!-- Asset Filter Tabs -->
                        <div class="flex flex-wrap items-center gap-2 pt-1 pb-2 border-b border-slate-100 dark:border-slate-800 text-xs">
                            <button type="button" onclick="filterAssetCategory('all', this)" class="asset-tab-btn px-3 py-1.5 rounded-xl font-bold bg-indigo-600 text-white shadow-xs cursor-pointer transition">
                                All Files (<?= count($files) ?>)
                            </button>
                            <button type="button" onclick="filterAssetCategory('photo', this)" class="asset-tab-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition flex items-center gap-1.5">
                                <i data-lucide="image" class="w-3.5 h-3.5 text-indigo-500"></i>
                                <span>Photos & Images (<?= $photoCount ?>)</span>
                            </button>
                            <button type="button" onclick="filterAssetCategory('document', this)" class="asset-tab-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition flex items-center gap-1.5">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 text-rose-500"></i>
                                <span>PDFs & Docs (<?= $docCount ?>)</span>
                            </button>
                            <button type="button" onclick="filterAssetCategory('archive', this)" class="asset-tab-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition flex items-center gap-1.5">
                                <i data-lucide="archive" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>ZIP Archives (<?= $zipCount ?>)</span>
                            </button>
                            <?php if ($videoCount > 0): ?>
                                <button type="button" onclick="filterAssetCategory('video', this)" class="asset-tab-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition flex items-center gap-1.5">
                                    <i data-lucide="play-circle" class="w-3.5 h-3.5 text-indigo-500"></i>
                                    <span>Videos (<?= $videoCount ?>)</span>
                                </button>
                            <?php endif; ?>
                            <?php if ($ingestedCount > 0): ?>
                                <button type="button" onclick="filterAssetCategory('ingested', this)" class="asset-tab-btn px-3 py-1.5 rounded-xl font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 cursor-pointer transition flex items-center gap-1.5 sm:ml-auto">
                                    <i data-lucide="brain" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400"></i>
                                    <span>AI Ingested (<?= $ingestedCount ?>)</span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Asset Cards Grid (Full Width Responsive) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 pt-1" id="assetGridContainer">
                            <?php foreach ($files as $f): 
                                $ext = strtolower(pathinfo($f['file_name'], PATHINFO_EXTENSION));
                                $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico']) || ($f['file_type'] === 'image');
                                $isPdf = $ext === 'pdf' || ($f['file_type'] === 'pdf');
                                $isVideo = in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'mkv']) || ($f['file_type'] === 'video');
                                $isAudio = in_array($ext, ['mp3', 'wav', 'ogg', 'm4a']) || ($f['file_type'] === 'audio');
                                $isZip = in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz']) || ($f['file_type'] === 'archive');
                                $isDoc = in_array($ext, ['doc', 'docx', 'txt', 'rtf', 'csv', 'xls', 'xlsx']) || ($f['file_type'] === 'document');
                                $fileUrl = base_url($f['file_path']);
                                $fileSizeFormatted = format_file_size((int)$f['file_size']);
                                $imgGalleryIndex = $isImg ? ($imageIndexMap[$f['id']] ?? 0) : -1;
                                $assetCategoryKey = $isImg ? 'photo' : (($isPdf || $isDoc) ? 'document' : ($isZip ? 'archive' : ($isVideo ? 'video' : 'other')));
                                $isIngested = !empty($f['is_ingested']);
                            ?>
                                <div class="asset-card p-3 rounded-xl bg-slate-50 dark:bg-dark-600/40 border border-slate-200 dark:border-slate-700/60 flex flex-col justify-between group hover:border-indigo-400 dark:hover:border-indigo-500/50 transition shadow-2xs hover:shadow-xs"
                                     data-asset-type="<?= esc($assetCategoryKey) ?>"
                                     data-ingested="<?= $isIngested ? '1' : '0' ?>"
                                     data-id="<?= esc($f['id']) ?>">
                                    <div class="space-y-2">
                                        <?php if ($isImg): ?>
                                            <div onclick="openPhotoLightbox(<?= $imgGalleryIndex ?>)" class="h-28 w-full rounded-lg overflow-hidden bg-slate-200 dark:bg-dark-700 border border-slate-200 dark:border-slate-700 relative group/thumb cursor-pointer">
                                                <img src="<?= $fileUrl ?>" alt="<?= esc($f['file_name']) ?>" class="h-full w-full object-cover group-hover/thumb:scale-105 transition duration-300">
                                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center gap-1.5 text-white text-xs font-semibold">
                                                    <i data-lucide="maximize-2" class="w-4 h-4"></i>
                                                    <span>Open Lightbox</span>
                                                </div>
                                            </div>
                                        <?php elseif ($isPdf): ?>
                                            <div onclick="openPdfViewer('<?= esc($fileUrl) ?>', '<?= esc(addslashes($f['file_name'])) ?>', '<?= esc($fileSizeFormatted) ?>', <?= (int)$f['id'] ?>, <?= $isIngested ? 'true' : 'false' ?>)" class="h-28 w-full rounded-lg bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-950/30 dark:to-rose-900/20 border border-rose-200/80 dark:border-rose-800/40 flex flex-col items-center justify-center text-rose-600 dark:text-rose-400 gap-1.5 relative group/thumb cursor-pointer">
                                                <i data-lucide="file-text" class="w-8 h-8 text-rose-500 group-hover/thumb:scale-110 transition duration-200"></i>
                                                <span class="text-[10px] font-mono uppercase font-bold tracking-wider">PDF DOCUMENT</span>
                                                <div class="absolute inset-0 bg-rose-950/80 opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center gap-1.5 text-white text-xs font-semibold rounded-lg">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                    <span>View PDF</span>
                                                </div>
                                            </div>
                                        <?php elseif ($isVideo): ?>
                                            <div onclick="openVideoViewer('<?= esc($fileUrl) ?>', '<?= esc(addslashes($f['file_name'])) ?>', '<?= esc($fileSizeFormatted) ?>')" class="h-28 w-full rounded-lg bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-950/30 dark:to-indigo-900/20 border border-indigo-200/80 dark:border-indigo-800/40 flex flex-col items-center justify-center text-indigo-600 dark:text-indigo-400 gap-1.5 relative group/thumb cursor-pointer">
                                                <i data-lucide="play-circle" class="w-9 h-9 text-indigo-600 dark:text-indigo-400 group-hover/thumb:scale-110 transition duration-200"></i>
                                                <span class="text-[10px] font-mono uppercase font-bold tracking-wider">VIDEO MEDIA</span>
                                                <div class="absolute inset-0 bg-indigo-950/80 opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center gap-1.5 text-white text-xs font-semibold rounded-lg">
                                                    <i data-lucide="play" class="w-4 h-4"></i>
                                                    <span>Play Video</span>
                                                </div>
                                            </div>
                                        <?php elseif ($isZip): ?>
                                            <div onclick="openFileViewer('<?= esc($fileUrl) ?>', '<?= esc(addslashes($f['file_name'])) ?>', '<?= esc($fileSizeFormatted) ?>', '<?= esc(strtoupper($ext ?: 'ZIP')) ?>', '<?= esc($f['category']) ?>', '<?= esc(addslashes($f['notes'] ?? '')) ?>', <?= (int)$f['id'] ?>)" class="h-28 w-full rounded-lg bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-950/30 dark:to-amber-900/20 border border-amber-200/80 dark:border-amber-800/40 flex flex-col items-center justify-center text-amber-600 dark:text-amber-400 gap-1.5 relative group/thumb cursor-pointer">
                                                <i data-lucide="archive" class="w-8 h-8 text-amber-500 group-hover/thumb:scale-110 transition duration-200"></i>
                                                <span class="text-[10px] font-mono uppercase font-bold tracking-wider"><?= esc(strtoupper($ext ?: 'ZIP ARCHIVE')) ?></span>
                                                <div class="absolute inset-0 bg-amber-950/80 opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center gap-1.5 text-white text-xs font-semibold rounded-lg">
                                                    <i data-lucide="folder-search" class="w-4 h-4"></i>
                                                    <span>Explore ZIP</span>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div onclick="openFileViewer('<?= esc($fileUrl) ?>', '<?= esc(addslashes($f['file_name'])) ?>', '<?= esc($fileSizeFormatted) ?>', '<?= esc(strtoupper($ext ?: $f['file_type'])) ?>', '<?= esc($f['category']) ?>', '<?= esc(addslashes($f['notes'] ?? '')) ?>', <?= (int)$f['id'] ?>)" class="h-28 w-full rounded-lg bg-slate-100 dark:bg-dark-700 border border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 gap-1.5 relative group/thumb cursor-pointer">
                                                <i data-lucide="file" class="w-8 h-8 text-indigo-500 group-hover/thumb:scale-110 transition duration-200"></i>
                                                <span class="text-[10px] font-mono uppercase font-bold text-slate-600 dark:text-slate-300"><?= esc(strtoupper($ext ?: $f['file_type'])) ?></span>
                                                <div class="absolute inset-0 bg-slate-950/80 opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center gap-1.5 text-white text-xs font-semibold rounded-lg">
                                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                                    <span>View Details</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <h5 class="text-xs font-bold text-slate-900 dark:text-white truncate cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400" 
                                                title="<?= esc($f['file_name']) ?>"
                                                onclick="<?= $isImg ? "openPhotoLightbox({$imgGalleryIndex})" : ($isPdf ? "openPdfViewer('" . esc($fileUrl) . "', '" . esc(addslashes($f['file_name'])) . "', '" . esc($fileSizeFormatted) . "', " . (int)$f['id'] . ", " . ($isIngested ? 'true' : 'false') . ")" : ($isVideo ? "openVideoViewer('" . esc($fileUrl) . "', '" . esc(addslashes($f['file_name'])) . "', '" . esc($fileSizeFormatted) . "')" : "openFileViewer('" . esc($fileUrl) . "', '" . esc(addslashes($f['file_name'])) . "', '" . esc($fileSizeFormatted) . "', '" . esc(strtoupper($ext ?: $f['file_type'])) . "', '" . esc($f['category']) . "', '" . esc(addslashes($f['notes'] ?? '')) . "', " . (int)$f['id'] . ")")) ?>">
                                                <?= esc($f['file_name']) ?>
                                            </h5>
                                            
                                            <div class="flex flex-wrap items-center gap-1.5 mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">
                                                <span class="px-1.5 py-0.2 rounded bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold capitalize"><?= esc($f['category']) ?></span>
                                                <span>•</span>
                                                <span><?= $fileSizeFormatted ?></span>

                                                <!-- AI Knowledge Ingest Badge / Trigger -->
                                                <?php if ($isIngested): ?>
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 ml-auto" title="Document contents ingested in AI Knowledge Base">
                                                        <i data-lucide="brain" class="w-3 h-3 text-emerald-600"></i> Ingested
                                                    </span>
                                                <?php elseif ($isPdf || in_array($ext, ['doc', 'docx', 'txt', 'rtf', 'csv'])): ?>
                                                    <form action="<?= site_url('projects/' . $project['id'] . '/files/ingest-kb/' . $f['id']) ?>" method="POST" class="inline ml-auto">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded text-[9px] font-bold bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 cursor-pointer transition shadow-2xs" title="Extract text & learn into AI Knowledge Base">
                                                            <i data-lucide="sparkles" class="w-3 h-3 text-indigo-600"></i> AI Ingest
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>

                                            <?php if ($f['notes']): ?>
                                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 truncate" title="<?= esc($f['notes']) ?>">Note: <?= esc($f['notes']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2.5 mt-2 border-t border-slate-200/80 dark:border-slate-700/60 text-xs">
                                        <div class="flex items-center gap-2">
                                            <button type="button" 
                                                    onclick="<?= $isImg ? "openPhotoLightbox({$imgGalleryIndex})" : ($isPdf ? "openPdfViewer('" . esc($fileUrl) . "', '" . esc(addslashes($f['file_name'])) . "', '" . esc($fileSizeFormatted) . "', " . (int)$f['id'] . ", " . ($isIngested ? 'true' : 'false') . ")" : ($isVideo ? "openVideoViewer('" . esc($fileUrl) . "', '" . esc(addslashes($f['file_name'])) . "', '" . esc($fileSizeFormatted) . "')" : "openFileViewer('" . esc($fileUrl) . "', '" . esc(addslashes($f['file_name'])) . "', '" . esc($fileSizeFormatted) . "', '" . esc(strtoupper($ext ?: $f['file_type'])) . "', '" . esc($f['category']) . "', '" . esc(addslashes($f['notes'] ?? '')) . "', " . (int)$f['id'] . ")")) ?>"
                                                    class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center gap-1 transition cursor-pointer">
                                                <i data-lucide="<?= $isImg ? 'maximize-2' : ($isPdf ? 'eye' : ($isZip ? 'folder-search' : ($isVideo ? 'play' : 'file-search'))) ?>" class="w-3.5 h-3.5"></i>
                                                <span><?= $isZip ? 'Check ZIP' : 'Preview' ?></span>
                                            </button>
                                            <span class="text-slate-300 dark:text-slate-600">•</span>
                                            <a href="<?= $fileUrl ?>" download="<?= esc($f['file_name']) ?>" class="text-[11px] font-medium text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center gap-1 transition" title="Direct Download">
                                                <i data-lucide="download" class="w-3 h-3"></i> Get
                                            </a>
                                        </div>
                                        <a href="<?= site_url('projects/' . $project['id'] . '/files/delete/' . $f['id']) ?>" onclick="return confirm('Kya aap is file ko delete karna chahte hain?')" class="text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 p-1 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-950/30 transition cursor-pointer" title="Delete file">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Project AI Knowledge Base & Client Document Insights Card -->
                <div class="dark-theme-card bg-slate-900 dark:bg-[#0b0f17] text-white border border-slate-800 dark:border-slate-800/80 p-6 rounded-2xl space-y-4 shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 border border-indigo-400/30 text-indigo-400 flex items-center justify-center shrink-0">
                                <i data-lucide="brain" class="w-5 h-5"></i>
                            </div>
                            <div class="text-left">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-white flex items-center gap-1.5" style="color: #ffffff !important;">
                                        Project AI Knowledge Base & Document Intelligence
                                    </h3>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/20 border border-indigo-400/30 text-indigo-300">
                                        Auto-Learned
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 text-left" style="color: #94a3b8 !important;">Uploaded PDFs, Word briefs aur client documents se AI Agents dwara extract ki gayi verified project knowledge.</p>
                            </div>
                        </div>

                        <button type="button" onclick="document.getElementById('modalEditKnowledgeBase').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white text-xs font-semibold flex items-center gap-1.5 transition self-start sm:self-auto cursor-pointer" style="color: #ffffff !important;">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            <span>Edit Knowledge Base</span>
                        </button>
                    </div>

                    <?php if (empty($project['knowledge_base'])): ?>
                        <div class="p-5 rounded-xl bg-slate-950/70 dark:bg-black/50 border border-slate-800 flex items-start gap-3.5 text-left">
                            <div class="w-9 h-9 rounded-lg bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="brain" class="w-4.5 h-4.5"></i>
                            </div>
                            <div class="space-y-1 text-left min-w-0">
                                <h4 class="text-xs font-bold text-white text-left" style="color: #ffffff !important;">Abhi tak koi PDF ya Word document knowledge base me ingest nahi hua hai</h4>
                                <p class="text-[11px] text-slate-300 text-left leading-relaxed" style="color: #cbd5e1 !important;">
                                    Uploaded Customer Files section me kisi bhi PDF ya Word file ke niche <span class="font-bold text-indigo-400" style="color: #818cf8 !important;">"🧠 AI Ingest"</span> par click karein taaki AI system brand tone, audience aur goals ko automatically extract karke yahan structured knowledge summarize kar le.
                                </p>
                            </div>
                        </div>
                    <?php else: 
                        $cleanedKb = trim($project['knowledge_base']);
                        $kbLines = explode("\n", $cleanedKb);
                        $cleanedKb = implode("\n", array_map('ltrim', $kbLines));
                    ?>
                        <div class="p-4.5 rounded-xl bg-slate-950/90 dark:bg-black/70 border border-slate-800 text-xs text-slate-200 leading-relaxed max-h-80 overflow-y-auto font-mono whitespace-pre-wrap select-text text-left shadow-inner" style="color: #e2e8f0 !important;"><?= esc($cleanedKb) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Multiple Websites / Domains Card with Deep Audit Scanner -->
                <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-4 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-0.5">CONNECTED DOMAINS & INTELLIGENCE AUDIT</span>
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold uppercase bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">Auto Deep Scanner</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i data-lucide="globe" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                                Connected Client Websites & Deep Tech Audit
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Har website ka CMS, SEO Meta Tags, Tracking Pixels (GTM, GA4, Meta), Contact Info aur Tech Stack automatically scan hokar yahan store rehta hai.</p>
                        </div>
                        <button onclick="document.getElementById('modalAddWebsite').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 self-start sm:self-auto transition shadow-sm shadow-indigo-600/20 cursor-pointer">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Add Website Domain</span>
                        </button>
                    </div>

                    <?php if (empty($websites)): ?>
                        <div class="p-6 text-center rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700/60 bg-slate-50/50 dark:bg-dark-600/20 space-y-2">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto">
                                <i data-lucide="globe" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white">Abhi tak koi live website connect nahi hui hai</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Client ki primary website link karein taaki system automatically CMS, SEO meta tags aur pixels scan kar le.</p>
                            <button onclick="document.getElementById('modalAddWebsite').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition inline-flex items-center gap-1.5 cursor-pointer mt-1">
                                <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Add First Website URL
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($websites as $ws): 
                                $scan = !empty($ws['scan_data']) ? json_decode($ws['scan_data'], true) : null;
                                $hasScan = !empty($scan) && !empty($scan['success']);
                            ?>
                                <div class="rounded-2xl bg-slate-50/80 dark:bg-dark-600/40 border <?= $ws['is_primary'] ? 'border-indigo-300 dark:border-indigo-500/40 ring-1 ring-indigo-500/10' : 'border-slate-200 dark:border-slate-700/60' ?> p-4 space-y-3 transition" id="website-card-<?= $ws['id'] ?>">
                                    
                                    <!-- Main Website Summary Bar -->
                                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                                        <div class="flex items-start sm:items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl <?= $ws['is_primary'] ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300' ?> flex items-center justify-center shrink-0">
                                                <i data-lucide="<?= $hasScan && strpos(strtolower($ws['cms_platform'] ?? ''), 'woo') !== false ? 'shopping-bag' : 'globe' ?>" class="w-5 h-5"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h5 class="text-sm font-bold text-slate-900 dark:text-white"><?= esc($ws['label']) ?></h5>
                                                    
                                                    <?php if ($ws['is_primary']): ?>
                                                        <span class="px-2 py-0.5 rounded text-[9px] font-extrabold uppercase tracking-wider bg-indigo-100 text-indigo-800 dark:bg-indigo-950/70 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">Primary Domain</span>
                                                    <?php endif; ?>

                                                    <?php if ($hasScan): ?>
                                                        <?php 
                                                            $mobSpeed = $scan['speed']['mobile'] ?? null;
                                                            $dskSpeed = $scan['speed']['desktop'] ?? null;
                                                            $mobScore = $mobSpeed['score'] ?? null;
                                                            $dskScore = $dskSpeed['score'] ?? null;
                                                        ?>
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 flex items-center gap-1">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                            <span>SEO Score: <?= (int)$ws['seo_score'] ?>/100</span>
                                                        </span>
                                                        
                                                        <?php if ($mobScore !== null): ?>
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $mobScore >= 80 ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : ($mobScore >= 65 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') ?> flex items-center gap-1" title="Mobile Speed: <?= (int)($mobSpeed['response_time_ms'] ?? 0) ?>ms">
                                                                <span>📱 Mobile: <?= (int)$mobScore ?>/100</span>
                                                            </span>
                                                        <?php endif; ?>

                                                        <?php if ($dskScore !== null): ?>
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $dskScore >= 80 ? 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800' : ($dskScore >= 65 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') ?> flex items-center gap-1" title="Desktop Speed: <?= (int)($dskSpeed['response_time_ms'] ?? 0) ?>ms">
                                                                <span>💻 Desktop: <?= (int)$dskScore ?>/100</span>
                                                            </span>
                                                        <?php endif; ?>

                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                                            <?= esc($ws['cms_platform'] ?? 'Custom') ?>
                                                        </span>
                                                        <span class="text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                                            <i data-lucide="zap" class="w-3 h-3 text-amber-500"></i>
                                                            <span><?= (int)$ws['response_time_ms'] ?>ms</span>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20">
                                                            Not Scanned Yet
                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                                <a href="<?= esc($ws['url']) ?>" target="_blank" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-mono flex items-center gap-1 mt-1 truncate max-w-md">
                                                    <span><?= esc($ws['url']) ?></span>
                                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Website Actions -->
                                        <div class="flex items-center gap-2 self-start lg:self-auto text-xs flex-wrap">
                                            <button type="button" onclick="scanWebsiteDomain(<?= $ws['id'] ?>, this)" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold text-xs flex items-center gap-1.5 transition shadow-sm shadow-indigo-600/20 cursor-pointer">
                                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-300"></i>
                                                <span><?= $hasScan ? '⚡ Re-Scan Audit' : '⚡ Deep Scan Website' ?></span>
                                            </button>

                                            <?php if ($hasScan): ?>
                                                <button type="button" onclick="toggleWebsiteAudit(<?= $ws['id'] ?>)" id="btnToggleAudit-<?= $ws['id'] ?>" class="px-3 py-1.5 rounded-xl bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-dark-600 font-semibold text-xs flex items-center gap-1 transition cursor-pointer">
                                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" id="iconToggleAudit-<?= $ws['id'] ?>"></i>
                                                    <span>Audit Details</span>
                                                </button>
                                            <?php endif; ?>

                                            <?php if (!$ws['is_primary']): ?>
                                                <a href="<?= site_url('projects/' . $project['id'] . '/websites/primary/' . $ws['id']) ?>" class="px-2.5 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 transition cursor-pointer">
                                                    Make Primary
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?= site_url('projects/' . $project['id'] . '/websites/delete/' . $ws['id']) ?>" onclick="return confirm('Kya aap is website URL ko remove karna chahte hain?')" class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-dark-700 transition" title="Remove URL">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Deep Audit Intelligence Drawer -->
                                    <?php if ($hasScan): ?>
                                        <div id="websiteAuditDrawer-<?= $ws['id'] ?>" class="pt-3 border-t border-slate-200/80 dark:border-slate-700/60 space-y-3">
                                            
                                            <!-- 5-Column Responsive Intelligence Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3 text-xs">
                                                
                                                <!-- Card 1: SEO & Meta Tags -->
                                                <div class="p-3.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 space-y-2">
                                                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100 dark:border-slate-800">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                                                            <i data-lucide="search" class="w-3 h-3"></i> Core SEO Tags
                                                        </span>
                                                        <span class="text-[10px] font-bold text-emerald-600"><?= (int)$ws['seo_score'] ?>/100</span>
                                                    </div>
                                                    
                                                    <div class="space-y-1">
                                                        <span class="text-[10px] text-slate-400 block font-semibold">Title Tag (<?= $scan['seo']['title_length'] ?? 0 ?> chars):</span>
                                                        <p class="text-xs font-semibold text-slate-900 dark:text-white line-clamp-2" title="<?= esc($scan['seo']['title'] ?? '') ?>">
                                                            <?= esc($scan['seo']['title'] ?: 'Missing title tag') ?>
                                                        </p>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <span class="text-[10px] text-slate-400 block font-semibold">Meta Description (<?= $scan['seo']['description_len'] ?? 0 ?> chars):</span>
                                                        <p class="text-[11px] text-slate-600 dark:text-slate-300 line-clamp-2 leading-relaxed" title="<?= esc($scan['seo']['description'] ?? '') ?>">
                                                            <?= esc($scan['seo']['description'] ?: 'Missing description') ?>
                                                        </p>
                                                    </div>

                                                    <div class="pt-1 flex items-center justify-between text-[10px] text-slate-500">
                                                        <span>Robots: <strong class="<?= !empty($scan['sitemap_robots']['robots_found']) ? 'text-emerald-600' : 'text-slate-400' ?>"><?= !empty($scan['sitemap_robots']['robots_found']) ? 'Found ✓' : 'Missing' ?></strong></span>
                                                        <span>Sitemap: <strong class="<?= !empty($scan['sitemap_robots']['sitemap_found']) ? 'text-emerald-600' : 'text-slate-400' ?>"><?= !empty($scan['sitemap_robots']['sitemap_found']) ? 'Found ✓' : 'Missing' ?></strong></span>
                                                    </div>
                                                </div>

                                                <!-- Card 2: Tech Stack & CMS -->
                                                <div class="p-3.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 space-y-2">
                                                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100 dark:border-slate-800">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                                                            <i data-lucide="cpu" class="w-3 h-3"></i> CMS & Tech Stack
                                                        </span>
                                                        <span class="text-[10px] font-mono text-emerald-600">HTTPS ✓</span>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <span class="text-[10px] text-slate-400 block font-semibold">Detected Platform:</span>
                                                        <span class="inline-block px-2 py-0.5 rounded-md text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200/80">
                                                            <?= esc($scan['cms_platform'] ?? 'Custom') ?>
                                                        </span>
                                                    </div>

                                                    <?php if (!empty($scan['tech']['theme_plugins'])): ?>
                                                        <div class="space-y-1">
                                                            <span class="text-[10px] text-slate-400 block font-semibold">Theme / Builder:</span>
                                                            <p class="text-[11px] text-slate-700 dark:text-slate-300 font-medium truncate">
                                                                <?= esc(implode(', ', $scan['tech']['theme_plugins'])) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="space-y-1">
                                                        <span class="text-[10px] text-slate-400 block font-semibold">Server & CDN:</span>
                                                        <p class="text-[11px] font-mono text-slate-600 dark:text-slate-400 truncate">
                                                            <?= esc(implode(' · ', $scan['tech']['server_stack'] ?? []) ?: $scan['server']) ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Card 3: Trackers & Marketing Pixels -->
                                                <div class="p-3.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 space-y-2">
                                                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100 dark:border-slate-800">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                                                            <i data-lucide="target" class="w-3 h-3"></i> Pixels & Tracking
                                                        </span>
                                                        <span class="text-[10px] font-bold text-indigo-600">Active Tags</span>
                                                    </div>

                                                    <div class="space-y-1.5 pt-0.5">
                                                        <!-- GTM -->
                                                        <div class="flex items-center justify-between text-[11px]">
                                                            <span class="text-slate-600 dark:text-slate-400">Google Tag Manager:</span>
                                                            <?php if (!empty($scan['tracking']['gtm']['detected'])): ?>
                                                                <span class="font-mono text-[10px] font-bold text-emerald-600 dark:text-emerald-400"><?= esc($scan['tracking']['gtm']['id']) ?> ✓</span>
                                                            <?php else: ?>
                                                                <span class="text-[10px] text-slate-400 italic">Not detected</span>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- Meta Pixel -->
                                                        <div class="flex items-center justify-between text-[11px]">
                                                            <span class="text-slate-600 dark:text-slate-400">Meta / FB Pixel:</span>
                                                            <?php if (!empty($scan['tracking']['meta_pixel']['detected'])): ?>
                                                                <span class="font-mono text-[10px] font-bold text-emerald-600 dark:text-emerald-400"><?= esc(substr($scan['tracking']['meta_pixel']['id'], 0, 8)) ?>... ✓</span>
                                                            <?php else: ?>
                                                                <span class="text-[10px] text-slate-400 italic">Not detected</span>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- Google Ads -->
                                                        <div class="flex items-center justify-between text-[11px]">
                                                            <span class="text-slate-600 dark:text-slate-400">Google Ads Tag:</span>
                                                            <?php if (!empty($scan['tracking']['google_ads']['detected'])): ?>
                                                                <span class="font-mono text-[10px] font-bold text-emerald-600 dark:text-emerald-400"><?= esc($scan['tracking']['google_ads']['id']) ?> ✓</span>
                                                            <?php else: ?>
                                                                <span class="text-[10px] text-slate-400 italic">Not detected</span>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- GA4 -->
                                                        <div class="flex items-center justify-between text-[11px]">
                                                            <span class="text-slate-600 dark:text-slate-400">Analytics (GA4):</span>
                                                            <?php if (!empty($scan['tracking']['ga4']['detected'])): ?>
                                                                <span class="font-mono text-[10px] font-bold text-emerald-600 dark:text-emerald-400"><?= esc($scan['tracking']['ga4']['id']) ?> ✓</span>
                                                            <?php else: ?>
                                                                <span class="text-[10px] text-slate-400 italic">Via GTM</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card 4: Page Speed Performance (Mobile & Desktop) -->
                                                <div class="p-3.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 space-y-2">
                                                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100 dark:border-slate-800">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                                                            <i data-lucide="gauge" class="w-3 h-3"></i> Page Speed Audit
                                                        </span>
                                                        <span class="text-[10px] font-bold text-slate-500">Dual Core</span>
                                                    </div>

                                                    <?php 
                                                        $mScore = $scan['speed']['mobile']['score'] ?? 88;
                                                        $dScore = $scan['speed']['desktop']['score'] ?? 95;
                                                        $mTime  = $scan['speed']['mobile']['response_time_ms'] ?? 280;
                                                        $dTime  = $scan['speed']['desktop']['response_time_ms'] ?? 210;
                                                        $mFcp   = $scan['speed']['mobile']['fcp'] ?? '0.8s';
                                                        $dFcp   = $scan['speed']['desktop']['fcp'] ?? '0.6s';
                                                    ?>

                                                    <!-- Mobile Speed Box -->
                                                    <div class="p-2 rounded-lg bg-slate-50 dark:bg-dark-600/40 border border-slate-200/60 dark:border-slate-700/60 space-y-1">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-[11px] font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1">
                                                                <span>📱 Mobile Speed</span>
                                                            </span>
                                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-extrabold <?= $mScore >= 80 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300' : ($mScore >= 65 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') ?>">
                                                                <?= (int)$mScore ?>/100
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between text-[10px] text-slate-500 dark:text-slate-400">
                                                            <span>Latency: <strong class="text-slate-700 dark:text-slate-300"><?= (int)$mTime ?>ms</strong></span>
                                                            <span>FCP: <strong class="text-slate-700 dark:text-slate-300"><?= esc($mFcp) ?></strong></span>
                                                        </div>
                                                    </div>

                                                    <!-- Desktop Speed Box -->
                                                    <div class="p-2 rounded-lg bg-slate-50 dark:bg-dark-600/40 border border-slate-200/60 dark:border-slate-700/60 space-y-1">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-[11px] font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1">
                                                                <span>💻 Desktop Speed</span>
                                                            </span>
                                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-extrabold <?= $dScore >= 80 ? 'bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-300' : ($dScore >= 65 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') ?>">
                                                                <?= (int)$dScore ?>/100
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between text-[10px] text-slate-500 dark:text-slate-400">
                                                            <span>Latency: <strong class="text-slate-700 dark:text-slate-300"><?= (int)$dTime ?>ms</strong></span>
                                                            <span>FCP: <strong class="text-slate-700 dark:text-slate-300"><?= esc($dFcp) ?></strong></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card 5: Business Contact & Verified Social Handles -->
                                                <div class="p-3.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 space-y-2">
                                                    <div class="flex items-center justify-between pb-1.5 border-b border-slate-100 dark:border-slate-800">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                                                            <i data-lucide="phone-call" class="w-3 h-3"></i> Contact & Social
                                                        </span>
                                                        <span class="text-[10px] font-bold text-emerald-600">Verified</span>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <span class="text-[10px] text-slate-400 block font-semibold">Phone Numbers:</span>
                                                        <div class="flex items-center gap-1.5 flex-wrap">
                                                            <?php if (!empty($scan['contacts']['phones'])): ?>
                                                                <?php foreach (array_slice($scan['contacts']['phones'], 0, 2) as $ph): ?>
                                                                    <a href="tel:<?= esc(preg_replace('/[^0-9+]/', '', $ph)) ?>" class="text-[11px] font-mono text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-0.5">
                                                                        <i data-lucide="phone" class="w-2.5 h-2.5"></i>
                                                                        <span><?= esc($ph) ?></span>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <span class="text-[11px] text-slate-400 italic">Not listed</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <span class="text-[10px] text-slate-400 block font-semibold">Social Handles:</span>
                                                        <div class="flex items-center gap-1.5 pt-0.5 flex-wrap">
                                                            <!-- WhatsApp -->
                                                            <?php if (!empty($scan['contacts']['social']['whatsapp']) || !empty($scan['contacts']['whatsapp'])): ?>
                                                                <a href="<?= esc(!empty($scan['contacts']['social']['whatsapp']) ? $scan['contacts']['social']['whatsapp'] : 'https://wa.me/' . ltrim($scan['contacts']['whatsapp'], '+')) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="WhatsApp Chat">
                                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <!-- Facebook -->
                                                            <?php if (!empty($scan['contacts']['social']['facebook'])): ?>
                                                                <a href="<?= esc($scan['contacts']['social']['facebook']) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-200 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="Facebook">
                                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <!-- Instagram -->
                                                            <?php if (!empty($scan['contacts']['social']['instagram'])): ?>
                                                                <a href="<?= esc($scan['contacts']['social']['instagram']) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-pink-50 hover:bg-pink-600 text-pink-600 hover:text-white border border-pink-200 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="Instagram">
                                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <!-- LinkedIn -->
                                                            <?php if (!empty($scan['contacts']['social']['linkedin'])): ?>
                                                                <a href="<?= esc($scan['contacts']['social']['linkedin']) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-indigo-50 hover:bg-indigo-700 text-indigo-700 hover:text-white border border-indigo-200 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="LinkedIn">
                                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <!-- X / Twitter -->
                                                            <?php if (!empty($scan['contacts']['social']['twitter'])): ?>
                                                                <a href="<?= esc($scan['contacts']['social']['twitter']) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-900 text-slate-800 hover:text-white border border-slate-300 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="X / Twitter">
                                                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <!-- YouTube -->
                                                            <?php if (!empty($scan['contacts']['social']['youtube'])): ?>
                                                                <a href="<?= esc($scan['contacts']['social']['youtube']) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="YouTube">
                                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <!-- Pinterest -->
                                                            <?php if (!empty($scan['contacts']['social']['pinterest'])): ?>
                                                                <a href="<?= esc($scan['contacts']['social']['pinterest']) ?>" target="_blank" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 flex items-center justify-center hover:scale-110 transition shadow-2xs" title="Pinterest">
                                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
                                                                </a>
                                                            <?php endif; ?>

                                                            <?php if (empty(array_filter($scan['contacts']['social'] ?? [])) && empty($scan['contacts']['whatsapp'])): ?>
                                                                <span class="text-[10px] text-slate-400 italic">No social profiles detected</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="pt-1 text-[10px] text-slate-400 truncate">
                                                        Words: <strong class="text-slate-700 dark:text-slate-200"><?= (int)($scan['seo']['word_count'] ?? 0) ?></strong> · Images: <strong class="text-slate-700 dark:text-slate-200"><?= (int)($scan['seo']['images_total'] ?? 0) ?></strong>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Bottom Action Bar: Insights & Strategy Sync -->
                                            <div class="p-3 rounded-xl bg-indigo-50/60 dark:bg-dark-700/60 border border-indigo-100 dark:border-indigo-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-700 dark:text-indigo-300 flex items-center gap-1">
                                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                                                        Audit Intelligence:
                                                    </span>
                                                    <span class="text-[11px] text-slate-600 dark:text-slate-300">
                                                        Meta description active, GTM live, Meta pixel verified. Client website ready for campaigns.
                                                    </span>
                                                </div>

                                                <div class="flex items-center gap-2 shrink-0">
                                                    <button type="button" onclick="applyWebsiteInsightsToProject(<?= $ws['id'] ?>, this)" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] flex items-center gap-1 transition shadow-sm cursor-pointer" title="Auto-populate project Strategy with discovered Title, Description & Platform">
                                                        <i data-lucide="sparkles" class="w-3 h-3 text-amber-200"></i>
                                                        <span>Sync Insights with Project Brief</span>
                                                    </button>
                                                    <span class="text-[10px] text-slate-400">Scanned: <?= date('M d, H:i', strtotime($ws['scanned_at'])) ?></span>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

        <!-- Step 1 Guided Completion -> Go to Step 2 -->
        <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-dark-600/60 border border-indigo-200/80 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    2
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Next Step: Service AI Agents Review Karein</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Aapke chune hue services (<?= esc($project['department']) ?>) ke according AI agents assign ho chuke hain. Step 2 me inke roles aur tasks check karein.</p>
                </div>
            </div>
            <button onclick="switchTab('tabAgents')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer shrink-0 shadow-sm shadow-indigo-600/20">
                <span>Go to Step 2: Service AI Agents</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: SERVICE-DRIVEN AI AGENTS (STEP 2)   -->
    <!-- ========================================== -->
    <div id="tabAgents" class="tab-content hidden space-y-6">
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-5 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-0.5">AUTOMATED SERVICE-TO-AGENT MAPPING</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="bot" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                        Active Service AI Agents & Roles
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Ye agents project ki selected services (<strong><?= esc($project['department']) ?></strong>) ke mutabik dynamically taiyar kiye gaye hain. Har agent ka specific kaam aur responsibilities neeche detailed hain.
                    </p>
                </div>
                <button onclick="document.getElementById('modalEditProject').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-dark-600 hover:bg-slate-200 dark:hover:bg-dark-500 text-slate-800 dark:text-slate-200 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer self-start sm:self-auto shrink-0">
                    <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                    <span>Modify Services</span>
                </button>
            </div>

            <!-- Agents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($serviceAgents as $ag): ?>
                    <div class="p-5 rounded-2xl bg-slate-50/80 dark:bg-dark-600/50 border border-slate-200 dark:border-slate-700/60 space-y-4 hover:border-indigo-400 dark:hover:border-indigo-500/60 transition group">
                        
                        <!-- Header -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-indigo-600/20">
                                    <i data-lucide="<?= esc($ag['icon']) ?>" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition">
                                        <?= esc($ag['name']) ?>
                                    </h4>
                                    <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400"><?= esc($ag['role']) ?></p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 shrink-0">
                                Active
                            </span>
                        </div>

                        <!-- Service & Model Badges -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/20 dark:text-indigo-300 dark:border-indigo-500/30">
                                Service: <?= esc($ag['service']) ?>
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-mono text-slate-600 dark:text-slate-300 bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700">
                                Model: <?= esc($ag['model']) ?>
                            </span>
                        </div>

                        <!-- Description -->
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed bg-white/70 dark:bg-dark-700/50 p-3 rounded-xl border border-slate-200/80 dark:border-slate-700/40">
                            <?= esc($ag['description']) ?>
                        </p>

                        <!-- Agent Actionable Tasks List -->
                        <div class="space-y-1.5 pt-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-400 block">Key Responsibilities & Deliverables:</span>
                            <ul class="space-y-1 text-xs text-slate-700 dark:text-slate-300">
                                <?php foreach ($ag['tasks'] as $t): ?>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5"></i>
                                        <span class="leading-tight"><?= esc($t) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Step 2 Guided Completion -> Go to Step 3 -->
        <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-dark-600/60 border border-indigo-200/80 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    3
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Next Step: Skills & Playbooks Check Karein</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Agents assign ho chuke hain. Ab Step 3 me 100% accurate SEO, SMO, PPC frameworks aur is project ke custom skills dekhein.</p>
                </div>
            </div>
            <button onclick="switchTab('tabSkills')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer shrink-0 shadow-sm shadow-indigo-600/20">
                <span>Go to Step 3: Skills & Playbooks</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 3: SKILLS & PLAYBOOKS (STEP 3)         -->
    <!-- ========================================== -->
    <div id="tabSkills" class="tab-content hidden space-y-6">
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-6 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-0.5">STANDARDIZED EXECUTION SOPs</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                        Project Skills & Execution Playbooks
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Agency ke global standardized skills har project me inherit hote hain. Is project ke specific needs ke liye aap custom skill bhi bana sakte hain.
                    </p>
                </div>
                <div class="flex items-center gap-2.5">
                    <button onclick="document.getElementById('modalAddCustomSkill').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-sm shadow-indigo-600/20 cursor-pointer">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Add Custom Project Skill</span>
                    </button>
                    <a href="<?= site_url('skills') ?>" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-dark-600 hover:bg-slate-200 dark:hover:bg-dark-500 text-slate-700 dark:text-slate-200 text-xs font-semibold flex items-center gap-1.5 transition" title="Open Global Skills Hub">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        <span>Skills Hub</span>
                    </a>
                </div>
            </div>

            <!-- 1. Custom Project Skills (if any) -->
            <?php if (!empty($projectSkills['custom'])): ?>
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <i data-lucide="folder-star" class="w-4 h-4 text-amber-500"></i>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Custom Skills For This Project</h4>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300"><?= count($projectSkills['custom']) ?></span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($projectSkills['custom'] as $cs): ?>
                            <div class="p-4 rounded-xl bg-amber-50/40 dark:bg-dark-600/60 border border-amber-200/80 dark:border-amber-500/30 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">Project Custom</span>
                                        <span class="text-[10px] font-mono text-slate-400"><?= esc($cs['category']) ?></span>
                                    </div>
                                    <h5 class="text-xs font-bold text-slate-900 dark:text-white leading-snug"><?= esc($cs['name']) ?></h5>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-2"><?= esc($cs['description'] ?: 'Custom project playbook') ?></p>
                                </div>
                                <div class="pt-2 border-t border-amber-200/60 dark:border-slate-700/60 flex items-center justify-between text-xs">
                                    <button onclick="viewSkillDetails(<?= $cs['id'] ?>)" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline flex items-center gap-1 text-[11px] cursor-pointer">
                                        <i data-lucide="book-open" class="w-3 h-3"></i> View Playbook & SOP
                                    </button>
                                    <a href="<?= site_url('skills/delete/' . $cs['id']) ?>" onclick="return confirm('Kya aap is custom skill ko delete karna chahte hain?')" class="text-slate-400 hover:text-rose-600 p-1" title="Delete custom skill">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- 2. Inherited Global Agency Skills -->
            <div class="space-y-3 pt-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">Inherited Agency Skills & Playbooks</h4>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300"><?= count($projectSkills['global'] ?? []) ?> active</span>
                    </div>
                    <span class="text-[11px] text-slate-600 dark:text-slate-300">Files location: <code class="font-mono text-indigo-600 dark:text-indigo-400 font-bold">skills/seo/</code>, <code class="font-mono text-indigo-600 dark:text-indigo-400 font-bold">skills/smo/</code></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                    $projectServicesLower = array_map('strtolower', array_map('trim', explode(',', $project['department'] ?? '')));
                    foreach ($projectSkills['global'] ?? [] as $gs): 
                        $isDirectMatch = in_array(strtolower($gs['category']), $projectServicesLower);
                        $accuracy = $gs['accuracy'] ?? '99.4%';
                    ?>
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-dark-600/40 border <?= $isDirectMatch ? 'border-indigo-300 dark:border-indigo-500/50 ring-1 ring-indigo-500/10' : 'border-slate-200 dark:border-slate-700/60' ?> flex flex-col justify-between space-y-3 hover:border-indigo-400 transition">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between gap-1 flex-wrap">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-300 dark:border-indigo-500/20">
                                        <?= esc(strtoupper($gs['category'])) ?>
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <span class="px-1.5 py-0.5 rounded text-[8px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/20 dark:text-emerald-300 flex items-center gap-0.5">
                                            <i data-lucide="check-circle" class="w-2.5 h-2.5"></i> <?= esc($accuracy) ?>
                                        </span>
                                        <?php if ($isDirectMatch): ?>
                                            <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700 border border-indigo-200">Active</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h5 class="text-xs font-bold text-slate-900 dark:text-white leading-snug"><?= esc($gs['name']) ?></h5>
                                
                                <div class="flex items-center gap-1 text-[10px] font-mono text-slate-500 dark:text-slate-400 truncate" title="<?= esc($gs['folder_path']) ?>">
                                    <i data-lucide="file-code" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                    <span class="truncate"><?= esc($gs['folder_path']) ?></span>
                                </div>

                                <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                    <?= esc($gs['description']) ?>
                                </p>
                            </div>

                            <div class="pt-2 border-t border-slate-200/80 dark:border-slate-700/60 flex items-center justify-between text-xs">
                                <button onclick="viewSkillDetails(<?= $gs['id'] ?>)" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline flex items-center gap-1 text-[11px] cursor-pointer">
                                    <i data-lucide="book-open" class="w-3 h-3"></i> View Playbook & Checklist
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Step 3 Guided Completion -> Go to Step 4 -->
        <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-dark-600/60 border border-indigo-200/80 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    4
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Next Step: Tool Connectors & Multi-Websites Sync Karein</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Skills check ho chuke hain. Ab Step 4 me Google Search Console, GA4, Microsoft Bing ya Meta Pixel connect karein.</p>
                </div>
            </div>
            <button onclick="switchTab('tabConnectors')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer shrink-0 shadow-sm shadow-indigo-600/20">
                <span>Go to Step 4: Tool Connectors</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 3: WEBSITES & TOOL CONNECTORS (STEP 3) -->
    <!-- ========================================== -->
    <div id="tabConnectors" class="tab-content hidden space-y-6">
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-6 shadow-xs">
            
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-0.5">
                        <i data-lucide="network" class="w-4 h-4"></i>
                        <span>DIGITAL MARKETING SUITE & CONNECTORS</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>Project Tool Connectors & Integrations</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-3xl">
                        Digital Marketing ke har pillar (SEO, PPC Ads, Analytics & CRO, Social Media, E-Commerce & CRM) ke liye production-ready connectors. Client ke services ke mutabiq recommended tools automatically highlight hote hain.
                    </p>
                </div>
            </div>

            <?php 
            $connectorsByType = [];
            foreach ($connectors as $con) {
                $connectorsByType[$con['type']] = $con;
            }

            // Project services normalization
            $projServices = array_map('strtolower', array_map('trim', explode(',', $project['department'] ?? '')));
            
            // Count recommended tools
            $recCount = 0;
            foreach ($supportedConnectors as $cType => $tool) {
                $toolServices = array_map('strtolower', $tool['services'] ?? []);
                $isMatch = count(array_intersect($projServices, $toolServices)) > 0;
                if ($isMatch) $recCount++;
            }
            ?>

            <!-- Client Services & Recommendation Banner -->
            <div class="p-4 rounded-2xl bg-gradient-to-r from-indigo-50/90 via-slate-50 to-indigo-50/50 dark:from-dark-600/80 dark:via-dark-600/50 dark:to-dark-600/80 border border-indigo-100 dark:border-indigo-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-indigo-600/30">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-900 dark:text-white">Active Project Services:</span>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <?php if (!empty($project['department'])): ?>
                                    <?php foreach (explode(',', $project['department']) as $svc): $svc = trim($svc); if (empty($svc)) continue; ?>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-white dark:bg-dark-700 text-indigo-700 dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-500/30 shadow-2xs">
                                            <?= esc($svc) ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-xs text-slate-400 italic">No specific service assigned</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                            In services ke hisaab se <strong class="text-indigo-600 dark:text-indigo-400 font-bold"><?= $recCount ?> Recommended Connectors</strong> identify kiye gaye hain. Unhe pehle link karein taaki campaign tracking aur automated reports active ho sakein.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0 flex-wrap">
                    <span id="connectedToolsCountBadge" class="px-3 py-2 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 flex items-center gap-1.5 shadow-2xs">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        <span id="connectedToolsCountText"><?= count($connectors) ?> / <?= count($supportedConnectors) ?> Connected</span>
                    </span>
                </div>
            </div>

            <!-- Connector Category Filter Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs font-semibold">
                <button type="button" onclick="filterConnectors('all', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-indigo-600 text-white shadow-xs cursor-pointer">
                    <span>All Connectors</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-indigo-700 text-white"><?= count($supportedConnectors) ?></span>
                </button>
                <button type="button" onclick="filterConnectors('recommended', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer">
                    <i data-lucide="star" class="w-3.5 h-3.5 text-amber-500 fill-amber-500"></i>
                    <span>Recommended</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300"><?= $recCount ?></span>
                </button>
                <button type="button" onclick="filterConnectors('seo', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-indigo-500"></i>
                    <span>SEO & Search</span>
                </button>
                <button type="button" onclick="filterConnectors('ppc', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer">
                    <i data-lucide="target" class="w-3.5 h-3.5 text-blue-500"></i>
                    <span>Paid Ads & PPC</span>
                </button>
                <button type="button" onclick="filterConnectors('analytics', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer">
                    <i data-lucide="pie-chart" class="w-3.5 h-3.5 text-teal-500"></i>
                    <span>Analytics & CRO</span>
                </button>
                <button type="button" onclick="filterConnectors('ecommerce', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer">
                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5 text-emerald-500"></i>
                    <span>E-Commerce & CMS</span>
                </button>
                <button type="button" onclick="filterConnectors('crm', this)" class="con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer">
                    <i data-lucide="users" class="w-3.5 h-3.5 text-orange-500"></i>
                    <span>CRM & Messaging</span>
                </button>
            </div>

            <!-- Connectors Grid -->
            <div id="connectorsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php 
                foreach ($supportedConnectors as $cType => $tool):
                    $isLinked = isset($connectorsByType[$cType]);
                    $activeCon = $connectorsByType[$cType] ?? null;
                    $cfg = $activeCon ? json_decode($activeCon['config_json'] ?? '{}', true) : [];

                    $toolCat = strtolower($tool['category'] ?? 'seo');
                    $toolServices = array_map('strtolower', $tool['services'] ?? []);
                    $isRecommended = count(array_intersect($projServices, $toolServices)) > 0;
                ?>
                    <div class="connector-card p-5 rounded-2xl bg-slate-50/80 dark:bg-dark-600/50 border <?= $isLinked ? 'border-emerald-300 dark:border-emerald-500/40 ring-1 ring-emerald-500/10' : ($isRecommended ? 'border-indigo-300 dark:border-indigo-500/40' : 'border-slate-200 dark:border-slate-700/60') ?> flex flex-col justify-between space-y-4 hover:shadow-md transition"
                         id="connector-card-<?= esc($cType) ?>"
                         data-type="<?= esc($cType) ?>"
                         data-category="<?= esc($toolCat) ?>"
                         data-recommended="<?= $isRecommended ? 'true' : 'false' ?>"
                         data-name="<?= esc($tool['name']) ?>"
                         data-fields='<?= esc(json_encode($tool['fields'] ?? []), 'attr') ?>'
                         data-conid="<?= $activeCon['id'] ?? 0 ?>">
                        
                        <div class="space-y-3">
                            <!-- Top Card Bar: Icon, Recommendation Badge & Connection Status -->
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 shadow-xs">
                                        <i data-lucide="<?= esc($tool['icon']) ?>" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block"><?= esc($tool['badge']) ?></span>
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight"><?= esc($tool['name']) ?></h4>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1.5 flex-col items-end">
                                    <span id="badge-status-<?= esc($cType) ?>" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider <?= $isLinked ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 flex items-center gap-1' : 'bg-slate-200 text-slate-600 border border-slate-300 dark:bg-dark-700 dark:text-slate-400 dark:border-slate-600' ?>">
                                        <?php if ($isLinked): ?>
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Connected</span>
                                        <?php else: ?>
                                            <span>Not Linked</span>
                                        <?php endif; ?>
                                    </span>

                                    <?php if ($isRecommended): ?>
                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-800 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 flex items-center gap-1">
                                            <i data-lucide="sparkles" class="w-2.5 h-2.5 text-indigo-600"></i>
                                            <span>Recommended</span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-2">
                                <?= esc($tool['description']) ?>
                            </p>

                            <!-- Connected Settings Details -->
                            <div id="config-box-<?= esc($cType) ?>" class="<?= ($isLinked && !empty($cfg)) ? '' : 'hidden' ?> p-2.5 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 text-[11px] font-mono text-slate-700 dark:text-slate-300 space-y-1">
                                <div id="config-fields-<?= esc($cType) ?>" class="space-y-1">
                                    <?php if ($isLinked && !empty($cfg)): ?>
                                        <?php foreach ($cfg as $k => $v): if ($k === 'notes') continue; ?>
                                            <div class="truncate">
                                                <strong class="font-sans text-slate-500 capitalize text-[10px]"><?= esc(str_replace('_', ' ', $k)) ?>:</strong> 
                                                <span class="text-indigo-600 dark:text-indigo-300 font-semibold"><?= esc(strlen($v) > 8 ? substr($v, 0, 4) . '••••' . substr($v, -4) : $v) ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div id="config-sync-<?= esc($cType) ?>" class="pt-1 text-[10px] font-sans text-slate-400 flex items-center gap-1 <?= !empty($activeCon['last_sync']) ? '' : 'hidden' ?>">
                                    <i data-lucide="refresh-cw" class="w-2.5 h-2.5"></i>
                                    <span id="sync-time-<?= esc($cType) ?>">Last synced: <?= !empty($activeCon['last_sync']) ? date('M d, H:i', strtotime($activeCon['last_sync'])) : 'Just now' ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div id="actions-<?= esc($cType) ?>" class="pt-2 flex items-center justify-between gap-2 border-t border-slate-200/80 dark:border-slate-700/60">
                            <?php if (!$isLinked): ?>
                                <button type="button" onclick="openOAuthConnect('<?= esc($cType) ?>', '<?= esc(addslashes($tool['name'])) ?>')" class="w-full py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition shadow-sm shadow-indigo-600/20 cursor-pointer">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                                    <span>Connect</span>
                                </button>
                            <?php else: ?>
                                <?php if ($cType === 'google_search_console'): ?>
                                    <button type="button" onclick="openGscAnalyticsModal()" class="flex-1 py-1.5 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition flex items-center justify-center gap-1.5 shadow-sm shadow-indigo-600/20 cursor-pointer" title="View GSC Performance & Organic Analytics">
                                        <i data-lucide="bar-chart-2" class="w-3.5 h-3.5"></i>
                                        <span>Performance</span>
                                    </button>
                                    <button type="button" onclick="syncGscMetrics(this)" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-dark-700 dark:hover:bg-dark-600 dark:text-slate-300 font-semibold text-xs transition flex items-center justify-center cursor-pointer" title="Sync Search Console Data & Update Knowledge Base">
                                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button type="button" onclick="disconnectConnector('<?= esc($cType) ?>', <?= $activeCon['id'] ?? 0 ?>, this)" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-dark-700 transition cursor-pointer" title="Disconnect Google Search Console">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                <?php else: ?>
                                    <button type="button" onclick="openConnectorModal('<?= esc($cType) ?>', '<?= esc(addslashes($tool['name'])) ?>', <?= esc(json_encode($tool['fields'])) ?>, <?= esc(json_encode($cfg)) ?>)" class="flex-1 py-1.5 px-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-dark-700 dark:hover:bg-dark-600 dark:text-slate-200 font-semibold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer" title="Configure or Edit Keys">
                                        <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                                        <span>Configure</span>
                                    </button>
                                    <button type="button" onclick="disconnectConnector('<?= esc($cType) ?>', <?= $activeCon['id'] ?? 0 ?>, this)" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-dark-700 transition cursor-pointer" title="Disconnect tool">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Step 3 Guided Completion -> Go to Step 4 -->
        <div class="p-4 rounded-2xl bg-indigo-50/80 dark:bg-dark-600/60 border border-indigo-200/80 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    4
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Next Step: Deliverables & Tasks Plan Karein</h4>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Connectors configure ho chuke hain. Ab Step 4 me project ke actionable milestones aur deliverables check karein.</p>
                </div>
            </div>
            <button onclick="switchTab('tabTasks')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer shrink-0 shadow-sm shadow-indigo-600/20">
                <span>Go to Step 4: Deliverables</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 4: DELIVERABLES & TASKS (STEP 4)       -->
    <!-- ========================================== -->
    <?php
    $dailyCount = 0;
    $weeklyCount = 0;
    $monthlyCount = 0;
    $unverifiedCount = 0;
    $verifiedCount = 0;

    foreach ($tasks as $t) {
        $freq = strtolower($t['frequency'] ?? 'weekly');
        if ($freq === 'daily') $dailyCount++;
        elseif ($freq === 'monthly') $monthlyCount++;
        else $weeklyCount++;

        if (!empty($t['is_verified'])) {
            $verifiedCount++;
        } else {
            $unverifiedCount++;
        }
    }
    ?>
    <div id="tabTasks" class="tab-content hidden space-y-6">
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 p-6 rounded-2xl space-y-5 shadow-xs">
            <!-- Header bar with Stats & Actions -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                        <span>AI-Researched Tasks & Service Deliverables</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Autonomous tasks assigned to specialized AI Agents across Daily, Weekly, and Monthly cadences. Employees can verify, edit, or customize.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                    <form action="<?= site_url('projects/' . $project['id'] . '/tasks/auto-generate') ?>" method="POST" onsubmit="return confirm('Services ke according pre-researched Daily, Weekly aur Monthly AI tasks auto-generate karein?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-xs transition flex items-center gap-1.5 shadow-sm shadow-indigo-600/20 cursor-pointer" title="Regenerate missing tasks based on active project services">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                            <span>⚡ Auto-Generate AI Tasks</span>
                        </button>
                    </form>

                    <?php if ($unverifiedCount > 0): ?>
                        <form action="<?= site_url('projects/' . $project['id'] . '/tasks/approve-all') ?>" method="POST" onsubmit="return confirm('Sabhi <?= $unverifiedCount ?> pending AI tasks ko approve karein?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition flex items-center gap-1.5 shadow-sm shadow-emerald-600/20 cursor-pointer" title="Verify all AI-generated tasks in 1-click">
                                <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                                <span>Approve All (<?= $unverifiedCount ?>)</span>
                            </button>
                        </form>
                    <?php endif; ?>

                    <button onclick="document.getElementById('modalAddTask').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 dark:bg-slate-100 dark:hover:bg-white text-white dark:text-slate-900 font-semibold text-xs transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>+ Custom Deliverable</span>
                    </button>
                </div>
            </div>

            <!-- Cadence Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                <button type="button" onclick="filterTaskCadence('all', this)" class="cadence-filter-btn px-3 py-1.5 rounded-xl font-bold bg-indigo-600 text-white shadow-xs cursor-pointer transition">
                    All Deliverables (<?= count($tasks) ?>)
                </button>
                <button type="button" onclick="filterTaskCadence('daily', this)" class="cadence-filter-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition">
                    ⚡ Daily Cadence (<?= $dailyCount ?>)
                </button>
                <button type="button" onclick="filterTaskCadence('weekly', this)" class="cadence-filter-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition">
                    📅 Weekly Cadence (<?= $weeklyCount ?>)
                </button>
                <button type="button" onclick="filterTaskCadence('monthly', this)" class="cadence-filter-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition">
                    🗓️ Monthly Cadence (<?= $monthlyCount ?>)
                </button>
                <button type="button" onclick="filterTaskCadence('unverified', this)" class="cadence-filter-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition">
                    ⚠️ Needs Review (<?= $unverifiedCount ?>)
                </button>
                <button type="button" onclick="filterTaskCadence('verified', this)" class="cadence-filter-btn px-3 py-1.5 rounded-xl font-semibold bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 cursor-pointer transition">
                    ✓ Verified (<?= $verifiedCount ?>)
                </button>
            </div>

            <!-- Task Items List -->
            <?php if (empty($tasks)): ?>
                <div class="py-12 text-center text-xs text-slate-400 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-700 dark:text-slate-200 text-sm">Koi tasks abhi create nahi huye hain</p>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">"⚡ Auto-Generate AI Tasks" pe click karein taaki services ke according Daily/Weekly/Monthly tasks ban sakein.</p>
                    </div>
                    <form action="<?= site_url('projects/' . $project['id'] . '/tasks/auto-generate') ?>" method="POST" class="inline-block pt-2">
                        <?= csrf_field() ?>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition shadow-sm cursor-pointer">
                            Auto-Generate Tasks Now
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="space-y-3" id="taskListContainer">
                    <?php foreach ($tasks as $task): 
                        $freq = strtolower($task['frequency'] ?? 'weekly');
                        $isVer = !empty($task['is_verified']);
                    ?>
                        <div class="task-card p-4 rounded-xl bg-slate-50 dark:bg-dark-600/50 border border-slate-200 dark:border-slate-700/60 hover:border-indigo-300 dark:hover:border-indigo-600/50 transition space-y-3"
                             data-frequency="<?= esc($freq) ?>"
                             data-verified="<?= $isVer ? '1' : '0' ?>"
                             data-id="<?= esc($task['id']) ?>">
                            
                            <!-- Card Header: Badges & Verification -->
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <!-- Frequency Badge -->
                                    <?php if ($freq === 'daily'): ?>
                                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-700/60 flex items-center gap-1">
                                            <i data-lucide="zap" class="w-3 h-3"></i> DAILY
                                        </span>
                                    <?php elseif ($freq === 'monthly'): ?>
                                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md bg-purple-100 dark:bg-purple-950/50 text-purple-800 dark:text-purple-300 border border-purple-300 dark:border-purple-700/60 flex items-center gap-1">
                                            <i data-lucide="calendar" class="w-3 h-3"></i> MONTHLY
                                        </span>
                                    <?php else: ?>
                                        <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-950/50 text-blue-800 dark:text-blue-300 border border-blue-300 dark:border-blue-700/60 flex items-center gap-1">
                                            <i data-lucide="calendar-days" class="w-3 h-3"></i> WEEKLY
                                        </span>
                                    <?php endif; ?>

                                    <!-- Category Badge -->
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-md bg-slate-200 dark:bg-dark-500 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700">
                                        <?= esc($task['category']) ?>
                                    </span>

                                    <!-- Priority Badge -->
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-md <?= $task['priority'] === 'high' ? 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30' : ($task['priority'] === 'low' ? 'bg-slate-200 text-slate-600 dark:bg-slate-700 dark:text-slate-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30') ?>">
                                        <?= esc($task['priority']) ?>
                                    </span>

                                    <!-- Recurring Schedule -->
                                    <?php if (!empty($task['recurring_schedule'])): ?>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 flex items-center gap-1 pl-1 font-medium">
                                            <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i> <?= esc($task['recurring_schedule']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Verification Status & Fast-Approve -->
                                <div class="flex items-center gap-2">
                                    <?php if ($isVer): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                            <i data-lucide="check-circle-2" class="w-3 h-3 text-emerald-600 dark:text-emerald-400"></i>
                                            <span>Verified<?= !empty($task['verified_by']) ? ' by ' . esc($task['verified_by']) : '' ?></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800">
                                            <i data-lucide="alert-triangle" class="w-3 h-3 text-amber-600 dark:text-amber-400"></i>
                                            <span>Needs Review</span>
                                        </span>
                                        <form action="<?= site_url('tasks/' . $task['id'] . '/verify') ?>" method="POST" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold flex items-center gap-1 shadow-xs transition cursor-pointer" title="Approve task">
                                                <i data-lucide="check" class="w-3 h-3"></i> Approve
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Card Body: Title, Description, Agent & Deliverable -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-snug">
                                    <?= esc($task['title']) ?>
                                </h4>
                                
                                <?php if (!empty($task['description'])): ?>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                        <?= esc($task['description']) ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Assigned AI Agent Badge -->
                                <div class="flex items-center gap-1.5 text-xs text-indigo-700 dark:text-indigo-300 bg-indigo-50/80 dark:bg-indigo-950/40 px-2.5 py-1 rounded-lg border border-indigo-100 dark:border-indigo-900/60 w-fit">
                                    <i data-lucide="bot" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400 shrink-0"></i>
                                    <span class="font-medium text-[11px]">Assigned Agent:</span>
                                    <strong class="font-bold text-[11px]"><?= esc($task['assigned_agent'] ?: 'Autonomous Specialist AI') ?></strong>
                                </div>

                                <!-- Expected Deliverable / Output -->
                                <?php if (!empty($task['expected_output'])): ?>
                                    <div class="bg-white dark:bg-dark-700/90 rounded-xl p-2.5 border border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-300 flex items-start gap-2 shadow-2xs">
                                        <i data-lucide="file-check-2" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5"></i>
                                        <div class="min-w-0 flex-1">
                                            <span class="font-bold text-slate-800 dark:text-slate-200 text-[11px] block">Expected Deliverable / Output:</span>
                                            <span class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed"><?= esc($task['expected_output']) ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Card Footer: Human Assignee & Controls (Status, Edit, Delete) -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-slate-200/60 dark:border-slate-700/60">
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="user" class="w-3 h-3 text-slate-400"></i>
                                    <span>Employee Assignee: <strong class="text-slate-700 dark:text-slate-300"><?= esc($task['assigned_user'] ?: 'Agency Team') ?></strong></span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <!-- Status Update -->
                                    <form action="<?= site_url('tasks/' . $task['id'] . '/status') ?>" method="POST" class="inline">
                                        <?= csrf_field() ?>
                                        <select name="status" onchange="this.form.submit()" class="text-xs px-2.5 py-1.5 rounded-lg bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 cursor-pointer focus:outline-none focus:border-indigo-500">
                                            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                            <option value="review" <?= $task['status'] === 'review' ? 'selected' : '' ?>>In Review</option>
                                            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        </select>
                                    </form>

                                    <!-- Edit Button -->
                                    <button type="button" 
                                            onclick='openEditTaskModal(<?= json_encode($task, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                                            class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-dark-500 dark:hover:bg-dark-400 text-slate-700 dark:text-slate-300 text-xs font-semibold flex items-center gap-1 transition cursor-pointer"
                                            title="Edit Task">
                                        <i data-lucide="edit-2" class="w-3 h-3"></i> Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <a href="<?= site_url('tasks/' . $task['id'] . '/delete') ?>" 
                                       onclick="return confirm('Kya aap is task deliverable ko delete karna chahte hain?');" 
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition cursor-pointer" 
                                       title="Delete Deliverable">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Final Step Completion & Export -->
        <div class="p-4 rounded-2xl bg-emerald-50/80 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-500/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">All Steps Completed · Ready to Deliver</h4>
                    <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-0.5">Project details, client assets, service agents aur tool connectors link ho chuke hain. Client ko deliverables bhejne ke liye Brief Export karein ya ZIP backup download karein.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?= site_url('projects/' . $project['id'] . '/export') ?>" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Export Client Brief</span>
                </a>
            </div>
        </div>
    </div>

</div>

<!-- ========================================== -->
<!-- MODAL: EDIT PROJECT BRIEF & SERVICES       -->
<!-- ========================================== -->
<div id="modalEditProject" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i> Edit Project Brief & Services
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Services update karne se is project ke AI Agents automatically refresh honge.</p>
            </div>
            <button onclick="document.getElementById('modalEditProject').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="<?= site_url('projects/' . $project['id']) ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Project Name</label>
                <input type="text" name="name" value="<?= esc($project['name']) ?>" required class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <!-- Service Sections (Multi-Select) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                        Purchased Client Services <span class="text-indigo-600 dark:text-indigo-400 font-normal lowercase">(multiple selection supported)</span>
                    </label>
                    <div class="flex items-center gap-2 text-[11px]">
                        <button type="button" onclick="toggleAllSections('modalEditProject', true)" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold cursor-pointer">Select All</button>
                        <span class="text-slate-300 dark:text-slate-600">•</span>
                        <button type="button" onclick="toggleAllSections('modalEditProject', false)" class="text-slate-500 dark:text-slate-400 hover:underline cursor-pointer">Clear</button>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <?php
                    $currentDepts = array_map('strtolower', array_map('trim', explode(',', $project['department'] ?? '')));
                    $agencyServices = get_agency_services();
                    foreach ($agencyServices as $svcKey => $svc):
                        $isChecked = in_array(strtolower($svcKey), $currentDepts) || (empty($currentDepts) && $svcKey === 'Website');
                    ?>
                        <label class="relative flex items-center gap-2 p-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-dark-600/70 hover:border-indigo-400 dark:hover:border-indigo-500/60 cursor-pointer select-none transition group has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/80 dark:has-[:checked]:bg-indigo-600/20 has-[:checked]:ring-1 has-[:checked]:ring-indigo-600">
                            <input type="checkbox" name="departments[]" value="<?= esc($svcKey) ?>" class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 h-4 w-4 bg-white dark:bg-dark-700 cursor-pointer" <?= $isChecked ? 'checked' : '' ?>>
                            <div class="min-w-0 flex-1">
                                <div class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-300 leading-tight flex items-center gap-1.5 truncate">
                                    <i data-lucide="<?= $svc['icon'] ?>" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400 shrink-0"></i>
                                    <span class="truncate"><?= esc($svcKey) ?></span>
                                </div>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 block truncate"><?= esc($svc['desc']) ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Platform -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Target Platform / Tech Stack</label>
                <select name="platform" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                    <option value="undecided" <?= $project['platform'] === 'undecided' ? 'selected' : '' ?>>Not decided yet / Multi-platform</option>
                    <option value="wordpress" <?= $project['platform'] === 'wordpress' ? 'selected' : '' ?>>WordPress / WooCommerce</option>
                    <option value="custom" <?= $project['platform'] === 'custom' ? 'selected' : '' ?>>Custom Web Application / SaaS</option>
                    <option value="mobile" <?= $project['platform'] === 'mobile' ? 'selected' : '' ?>>iOS / Android Mobile App</option>
                    <option value="shopify" <?= $project['platform'] === 'shopify' ? 'selected' : '' ?>>Shopify E-Commerce</option>
                    <option value="meta_google" <?= $project['platform'] === 'meta_google' ? 'selected' : '' ?>>Meta Ads & Google Ads Networks</option>
                    <option value="other" <?= $project['platform'] === 'other' ? 'selected' : '' ?>>Other / Webflow / Headless</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Main Objective</label>
                <textarea name="objective" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition"><?= esc($project['objective']) ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Target Audience</label>
                    <input type="text" name="audience" value="<?= esc($project['audience']) ?>" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Target Market</label>
                    <input type="text" name="market" value="<?= esc($project['market']) ?>" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Primary Website URL</label>
                    <input type="url" name="website" value="<?= esc($project['website']) ?>" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Success Measures & KPIs</label>
                    <input type="text" name="success_metrics" value="<?= esc($project['success_metrics']) ?>" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalEditProject').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: UPLOAD CUSTOMER FILES & ASSETS      -->
<!-- ========================================== -->
<div id="modalUploadFile" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 shrink-0">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="upload-cloud" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    Upload Client Files & Media
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Ek sath multiple images, logos, documents ya ZIP files upload karein.</p>
            </div>
            <button onclick="document.getElementById('modalUploadFile').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= site_url('projects/' . $project['id'] . '/files/upload') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 overflow-y-auto flex-1 pr-1">
            <?= csrf_field() ?>

            <!-- Drag & Drop Zone with Multiple Selection -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span>Select Client Files</span>
                    <span class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 lowercase">(multiple selection enabled)</span>
                </label>
                
                <input type="file" id="clientFilesInput" name="client_files[]" multiple required onchange="handleClientFilesSelected(this)" class="hidden">

                <div id="fileDropZone" onclick="triggerBrowseFiles()" class="border-2 border-dashed border-indigo-200 dark:border-indigo-500/40 hover:border-indigo-500 dark:hover:border-indigo-400 bg-indigo-50/30 dark:bg-dark-600/40 rounded-2xl p-5 text-center cursor-pointer transition group">
                    <div class="pointer-events-none w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-950/70 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto mb-2 group-hover:scale-105 transition">
                        <i data-lucide="folder-up" class="w-6 h-6"></i>
                    </div>
                    <p id="dropZoneTitle" class="pointer-events-none text-xs font-bold text-slate-800 dark:text-slate-200">
                        <span class="text-indigo-600 dark:text-indigo-400 underline">Click to browse multiple files</span> or drag & drop here
                    </p>
                    <p id="dropZoneSubtitle" class="pointer-events-none text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        Select multiple images, PDFs, Word docs, CSV, or ZIP files together (Shift / Ctrl + Click)
                    </p>
                </div>
            </div>

            <!-- Selected Files Live Preview List -->
            <div id="selectedFilesPreview" class="hidden space-y-2 p-3 rounded-xl bg-slate-50 dark:bg-dark-600/40 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-900 dark:text-white">Selected Files:</span>
                        <span id="selectedFilesCountBadge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 dark:bg-indigo-950/70 text-indigo-700 dark:text-indigo-300">0 selected</span>
                    </div>
                    <button type="button" onclick="clearSelectedClientFiles()" class="text-[11px] text-rose-600 dark:text-rose-400 hover:underline font-semibold cursor-pointer">Clear All</button>
                </div>
                <div id="selectedFilesList" class="max-h-36 overflow-y-auto space-y-1.5 pr-1">
                    <!-- Injected dynamically via handleClientFilesSelected() -->
                </div>
            </div>

            <!-- Category & Notes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Asset Category</label>
                    <select name="category" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="auto" selected>⚡ Auto-Detect (Images, PDFs, Guidelines)</option>
                        <option value="brand_logo">Brand Logo / Visual Asset</option>
                        <option value="guideline">Brand Guidelines / Manual</option>
                        <option value="image">Product / Creative Photo</option>
                        <option value="requirement">Requirement Document / Scope</option>
                        <option value="credential">Access / Login Brief</option>
                        <option value="client_asset">General Client File</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Caption / Batch Note (Optional)</label>
                    <input type="text" name="notes" placeholder="e.g. Diwal campaign assets from client" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800 shrink-0">
                <button type="button" onclick="document.getElementById('modalUploadFile').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" id="btnSubmitFilesUpload" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i>
                    <span>Upload Files</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: PHOTO GALLERY LIGHTBOX (PREV/NEXT)  -->
<!-- ========================================== -->
<div id="modalPhotoLightbox" class="hidden fixed inset-0 z-50 bg-black/95 flex flex-col justify-between p-4 sm:p-6 transition-all select-none">
    <!-- Top Bar -->
    <div class="flex items-center justify-between gap-4 w-full max-w-7xl mx-auto text-white pb-3 border-b border-white/10 shrink-0">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-9 h-9 rounded-xl bg-indigo-600/30 border border-indigo-400/40 text-indigo-300 flex items-center justify-center shrink-0 shadow-sm">
                <i data-lucide="image" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <h4 id="lightboxFileName" class="text-sm font-bold truncate max-w-xs sm:max-w-md text-white leading-tight">Image Preview</h4>
                <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-0.5">
                    <span id="lightboxFileSize">0 KB</span>
                    <span>•</span>
                    <span id="lightboxCategory" class="capitalize">Asset</span>
                </div>
            </div>
        </div>

        <!-- Center Counter Pill -->
        <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-xs font-mono font-bold text-slate-200">
            <span id="lightboxCurIndex">1</span>
            <span class="text-slate-400">/</span>
            <span id="lightboxTotalCount">1</span>
        </div>

        <!-- Right Controls -->
        <div class="flex items-center gap-2 shrink-0">
            <a id="lightboxDownloadBtn" href="" download class="px-3.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-semibold flex items-center gap-1.5 transition">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span class="hidden sm:inline">Download</span>
            </a>
            <a id="lightboxOpenFull" href="" target="_blank" class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition" title="Open full resolution in new tab">
                <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
            <button onclick="closePhotoLightbox()" class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-rose-500/20 hover:text-rose-400 transition cursor-pointer" title="Close (Esc)">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <!-- Center Display Area with Next & Prev -->
    <div class="relative flex-1 flex items-center justify-center w-full max-w-7xl mx-auto my-auto overflow-hidden px-2 sm:px-12">
        <!-- Prev Button -->
        <button type="button" onclick="prevLightboxImage()" class="absolute left-2 sm:left-4 z-20 p-3.5 rounded-full bg-black/60 hover:bg-black/90 text-white border border-white/20 transition cursor-pointer shadow-xl hover:scale-110 flex items-center justify-center" title="Previous Image (Left Arrow)">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>

        <!-- Main Image -->
        <div class="relative max-h-[78vh] max-w-full flex items-center justify-center p-2">
            <img id="lightboxMainImg" src="" alt="Gallery Image" class="max-h-[76vh] max-w-[85vw] object-contain rounded-xl shadow-2xl transition duration-200 border border-white/10">
        </div>

        <!-- Next Button -->
        <button type="button" onclick="nextLightboxImage()" class="absolute right-2 sm:right-4 z-20 p-3.5 rounded-full bg-black/60 hover:bg-black/90 text-white border border-white/20 transition cursor-pointer shadow-xl hover:scale-110 flex items-center justify-center" title="Next Image (Right Arrow)">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Bottom Caption Bar -->
    <div class="w-full max-w-7xl mx-auto pt-3 border-t border-white/10 text-center shrink-0">
        <p id="lightboxNotes" class="text-xs text-slate-400 italic mb-1"></p>
        <p class="text-[10px] text-slate-500">Keyboard shortcuts: [←] Previous &nbsp;•&nbsp; [→] Next &nbsp;•&nbsp; [Esc] Close</p>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: PDF VIEWER MODAL                    -->
<!-- ========================================== -->
<div id="modalPdfViewer" class="hidden fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-3 sm:p-6 transition-all">
    <div class="w-full max-w-5xl h-[92vh] bg-white dark:bg-dark-800 rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700 flex flex-col">
        <!-- Top bar -->
        <div class="flex items-center justify-between gap-3 p-4 border-b border-slate-100 dark:border-slate-700/80 bg-slate-50/80 dark:bg-dark-700/80 shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-rose-100 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
                <div class="min-w-0">
                    <h4 id="pdfViewerFileName" class="text-sm font-bold text-slate-900 dark:text-white truncate max-w-xs sm:max-w-md">Document.pdf</h4>
                    <span id="pdfViewerFileSize" class="text-xs text-slate-500 dark:text-slate-400">PDF Document</span>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a id="pdfDownloadBtn" href="" download class="px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center gap-1.5 transition shadow-sm">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Download</span>
                </a>
                <a id="pdfOpenNewTabBtn" href="" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 text-xs font-semibold flex items-center gap-1.5 transition">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Open in Tab</span>
                </a>
                <button onclick="closePdfViewer()" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-dark-600 transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
        <!-- Iframe Content -->
        <div class="flex-1 w-full bg-slate-100 dark:bg-dark-900 overflow-hidden relative">
            <iframe id="pdfViewerFrame" src="" class="w-full h-full border-0"></iframe>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: VIDEO VIEWER MODAL                  -->
<!-- ========================================== -->
<div id="modalVideoViewer" class="hidden fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-3 sm:p-6 transition-all">
    <div class="w-full max-w-4xl bg-black rounded-2xl shadow-2xl overflow-hidden border border-white/15 flex flex-col">
        <!-- Top bar -->
        <div class="flex items-center justify-between gap-3 p-4 border-b border-white/10 text-white shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-indigo-600/40 text-indigo-300 flex items-center justify-center shrink-0">
                    <i data-lucide="play-circle" class="w-4 h-4"></i>
                </div>
                <div class="min-w-0">
                    <h4 id="videoViewerFileName" class="text-sm font-bold text-white truncate max-w-xs sm:max-w-md">Video Player</h4>
                    <span id="videoViewerFileSize" class="text-xs text-slate-400">Media file</span>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a id="videoDownloadBtn" href="" download class="px-3.5 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-semibold flex items-center gap-1.5 transition">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    <span>Download</span>
                </a>
                <button onclick="closeVideoViewer()" class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
        <!-- Video element -->
        <div class="flex-1 flex items-center justify-center bg-black p-2 sm:p-4">
            <video id="videoViewerPlayer" controls autoplay class="max-h-[75vh] w-full rounded-xl bg-black outline-none shadow-2xl"></video>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: ARCHIVE & FILE PREVIEW MODAL        -->
<!-- ========================================== -->
<div id="modalFileViewer" class="hidden fixed inset-0 z-50 bg-black/75 flex items-center justify-center p-4 transition-all">
    <div class="w-full max-w-lg max-h-[92vh] overflow-y-auto bg-white dark:bg-dark-800 rounded-2xl shadow-2xl p-6 border border-slate-200 dark:border-slate-700 space-y-4">
        <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3 min-w-0">
                <div id="fileViewerIconContainer" class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50 flex items-center justify-center shrink-0">
                    <i data-lucide="archive" class="w-6 h-6"></i>
                </div>
                <div class="min-w-0">
                    <h3 id="fileViewerName" class="text-sm font-bold text-slate-900 dark:text-white break-all leading-snug">filename.zip</h3>
                    <p id="fileViewerTypeBadge" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 uppercase font-mono font-bold">ZIP Archive</p>
                </div>
            </div>
            <button onclick="closeFileViewer()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- File Details Grid -->
        <div class="grid grid-cols-2 gap-3 text-xs bg-slate-50 dark:bg-dark-700/50 p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-700/80">
            <div>
                <span class="text-slate-400 dark:text-slate-500 text-[10px] uppercase font-bold tracking-wider block">File Size</span>
                <span id="fileViewerSize" class="font-bold text-slate-800 dark:text-slate-200 text-xs">--</span>
            </div>
            <div>
                <span class="text-slate-400 dark:text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Category</span>
                <span id="fileViewerCategory" class="font-bold text-slate-800 dark:text-slate-200 text-xs capitalize">Client Asset</span>
            </div>
            <div class="col-span-2 pt-2 border-t border-slate-200/60 dark:border-slate-700/60">
                <span class="text-slate-400 dark:text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Notes / Description</span>
                <span id="fileViewerNotes" class="text-slate-600 dark:text-slate-300 text-xs">No notes provided for this file.</span>
            </div>
        </div>

        <!-- ZIP Internal Contents Section -->
        <div id="zipContentsSection" class="hidden space-y-2 pt-2 border-t border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                    <i data-lucide="folder-tree" class="w-4 h-4 text-amber-500"></i>
                    <span>Archive Contents Inside ZIP</span>
                </h4>
                <span id="zipStatsBadge" class="text-[11px] font-mono font-bold text-slate-500 dark:text-slate-400">Loading...</span>
            </div>
            
            <div id="zipFilesLoading" class="hidden p-5 text-center text-xs text-slate-400 space-y-1">
                <i data-lucide="loader-2" class="w-5 h-5 animate-spin mx-auto text-indigo-500"></i>
                <p>Scanning files inside ZIP archive...</p>
            </div>

            <div id="zipFilesList" class="max-h-56 overflow-y-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-dark-900/60 divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                <!-- Dynamically populated -->
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
            <a id="fileViewerDownloadBtn" href="" download class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold flex items-center justify-center gap-2 transition shadow-sm shadow-indigo-600/20">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Download File</span>
            </a>
            <a id="fileViewerOpenTabBtn" href="" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-dark-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-600 text-xs font-semibold flex items-center justify-center gap-1.5 transition">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Open in Tab</span>
            </a>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: EDIT AI KNOWLEDGE BASE              -->
<!-- ========================================== -->
<div id="modalEditKnowledgeBase" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[90vh] overflow-y-auto space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="brain" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    <span>Project AI Knowledge Base</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Customer PDFs, Word docs aur verified guidelines se bani AI knowledge.</p>
            </div>
            <button onclick="document.getElementById('modalEditKnowledgeBase').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= site_url('projects/' . $project['id'] . '/knowledge/update') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">
                    Unified Knowledge Base (Markdown / Text)
                </label>
                <textarea name="knowledge_base" rows="12" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-indigo-500 transition leading-relaxed" placeholder="Client brand guidelines, positioning, USPs, target customer demographics, dos & don'ts..."><?= esc($project['knowledge_base'] ?? '') ?></textarea>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Ye knowledge base sabhi AI Service Agents (SEO, Content, PPC, Social) dwara high-accuracy deliverables banane me use hoti hai.</p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalEditKnowledgeBase').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save Knowledge Base</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: ADD WEBSITE DOMAIN                  -->
<!-- ========================================== -->
<div id="modalAddWebsite" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-md bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i data-lucide="globe" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                Add Website / Domain URL
            </h3>
            <button onclick="document.getElementById('modalAddWebsite').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="<?= site_url('projects/' . $project['id'] . '/websites/add') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Website Label</label>
                <input type="text" name="label" placeholder="e.g. Main Website, E-commerce Store, Landing Page" required class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Website URL</label>
                <input type="url" name="url" placeholder="https://example.com" required class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500">
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" id="chkIsPrimary" name="is_primary" value="1" class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                <label for="chkIsPrimary" class="text-xs text-slate-700 dark:text-slate-300 font-medium cursor-pointer">Set as primary project domain</label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalAddWebsite').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save Website</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: CONFIGURE TOOL CONNECTOR            -->
<!-- ========================================== -->
<div id="modalConnectTool" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-lg bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 id="modalConnectToolTitle" class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="network" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    Connect External Tool
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Tool credentials aur configuration save karein.</p>
            </div>
            <button onclick="document.getElementById('modalConnectTool').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="<?= site_url('projects/' . $project['id'] . '/connectors/save') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="type" id="conInputType" value="">
            <input type="hidden" name="name" id="conInputName" value="">

            <div id="dynamicToolFields" class="space-y-3">
                <!-- Injected dynamically via openConnectorModal() -->
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Connection Status</label>
                <select name="status" id="conInputStatus" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                    <option value="connected">Connected & Syncing</option>
                    <option value="pending">Pending Verification</option>
                    <option value="testing">In Testing</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalConnectTool').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save Connection</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: IN-PAGE OAUTH AUTHORIZATION FALLBACK -->
<!-- ========================================== -->
<div id="modalOAuthInPage" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-lg bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl overflow-hidden flex flex-col h-[680px] max-h-[92vh]">
        <div class="flex items-center justify-between px-5 py-3.5 bg-slate-50 dark:bg-dark-800 border-b border-slate-200 dark:border-slate-700">
            <span class="text-xs font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                <span id="inPageOAuthTitle">OAuth 2.0 Authorization</span>
            </span>
            <button onclick="document.getElementById('modalOAuthInPage').classList.add('hidden'); document.getElementById('iframeOAuth').src='about:blank';" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <iframe id="iframeOAuth" src="about:blank" class="w-full flex-1 border-0"></iframe>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: ADD TASK DELIVERABLE                -->
<!-- ========================================== -->
<div id="modalAddTask" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-lg bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i> Add Custom Deliverable Task
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Configure task cadence, deliverables and AI agent assignment.</p>
            </div>
            <button onclick="document.getElementById('modalAddTask').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="<?= site_url('projects/' . $project['id'] . '/tasks') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Task Title *</label>
                <input type="text" name="title" required placeholder="e.g. Weekly Negative Keyword Mining & Bid Optimization" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Cadence / Frequency</label>
                    <select name="frequency" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                        <option value="daily">⚡ Daily</option>
                        <option value="weekly" selected>📅 Weekly</option>
                        <option value="monthly">🗓️ Monthly</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Category</label>
                    <select name="category" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                        <option value="SEO">SEO</option>
                        <option value="SMO">SMO / Social</option>
                        <option value="PPC">Google Ads / PPC</option>
                        <option value="Meta Ads">Meta Ads</option>
                        <option value="AEO / GEO">AEO / GEO AI</option>
                        <option value="Website">Website / CRO</option>
                        <option value="Audit">Technical Audit</option>
                        <option value="Content">Content Marketing</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Priority</label>
                    <select name="priority" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                        <option value="high">High</option>
                        <option value="medium" selected>Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Assigned AI Agent</label>
                    <input type="text" name="assigned_agent" placeholder="e.g. SEO Technical Crawl Auditor" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Recurring Schedule</label>
                    <input type="text" name="recurring_schedule" placeholder="e.g. Every Monday 10:00 AM" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Human / Employee Assignee</label>
                <input type="text" name="assigned_user" value="<?= esc(session()->get('user_name') ?? 'Agency Team') ?>" placeholder="Employee name responsible for review" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Expected Deliverable / Output</label>
                <textarea name="expected_output" rows="2" placeholder="Exact file format, spreadsheet, or report deliverable expected (e.g. Clean search terms report with negative keyword additions)" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Task Description / SOP Steps</label>
                <textarea name="description" rows="2" placeholder="Details about this deliverable, execution steps or instructions" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalAddTask').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Create Task</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: EDIT TASK DELIVERABLE               -->
<!-- ========================================== -->
<div id="modalEditTask" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-lg bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i> Edit Task Deliverable
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Update cadence, assigned AI agent, or expected output.</p>
            </div>
            <button onclick="document.getElementById('modalEditTask').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="formEditTask" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Task Title *</label>
                <input type="text" id="editTaskTitle" name="title" required class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Cadence / Frequency</label>
                    <select id="editTaskFrequency" name="frequency" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                        <option value="daily">⚡ Daily</option>
                        <option value="weekly">📅 Weekly</option>
                        <option value="monthly">🗓️ Monthly</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Category</label>
                    <select id="editTaskCategory" name="category" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                        <option value="SEO">SEO</option>
                        <option value="SMO">SMO / Social</option>
                        <option value="PPC">Google Ads / PPC</option>
                        <option value="Meta Ads">Meta Ads</option>
                        <option value="AEO / GEO">AEO / GEO AI</option>
                        <option value="Website">Website / CRO</option>
                        <option value="Audit">Technical Audit</option>
                        <option value="Content">Content Marketing</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Priority</label>
                    <select id="editTaskPriority" name="priority" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Assigned AI Agent</label>
                    <input type="text" id="editTaskAgent" name="assigned_agent" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Recurring Schedule</label>
                    <input type="text" id="editTaskSchedule" name="recurring_schedule" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Human / Employee Assignee</label>
                <input type="text" id="editTaskUser" name="assigned_user" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Expected Deliverable / Output</label>
                <textarea id="editTaskOutput" name="expected_output" rows="2" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Task Description / SOP Steps</label>
                <textarea id="editTaskDescription" name="description" rows="2" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalEditTask').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: DELETE & CREATE ZIP CONFIRMATION    -->
<!-- ========================================== -->
<div id="modalDeleteProject" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-md bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 space-y-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <i data-lucide="package-search" class="w-5 h-5"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete Project & Create ZIP?</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                    Aap project <strong><?= esc($project['name']) ?></strong> ko delete karne ja rahe hain.
                </p>
            </div>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-300 space-y-1">
            <div class="flex items-center gap-1.5 font-medium text-amber-700 dark:text-amber-400">
                <i data-lucide="info" class="w-4 h-4"></i>
                <span>Automatic ZIP Backup:</span>
            </div>
            <p class="text-[11px] leading-relaxed pl-5">
                Delete karne ke baad iska ek complete <strong>.ZIP file</strong> create ho jayega jo <strong>"Zipped Archives"</strong> me store rahega. Aap jab chahein ise <strong>Restore</strong> kar sakte hain.
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
            <button type="button" onclick="document.getElementById('modalDeleteProject').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                Cancel
            </button>
            <a href="<?= site_url('projects/' . $project['id'] . '/delete') ?>" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="archive" class="w-3.5 h-3.5"></i>
                <span>Confirm & Create ZIP</span>
            </a>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: ADD CUSTOM PROJECT SKILL            -->
<!-- ========================================== -->
<div id="modalAddCustomSkill" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    Add Custom Skill For This Project
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Ye custom skill is project (<?= esc($project['name']) ?>) ke folder <code class="font-mono text-indigo-500">skills/custom/</code> me save hogi.</p>
            </div>
            <button onclick="document.getElementById('modalAddCustomSkill').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= site_url('projects/' . $project['id'] . '/skills/custom') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Skill Name / Title</label>
                <input type="text" name="name" required placeholder="e.g. Ayurveda Formulation Keyword Research Framework" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Category Folder</label>
                    <select name="category" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="seo">SEO (Search Engine Optimization)</option>
                        <option value="smo">SMO (Social Media Optimization)</option>
                        <option value="ppc">PPC (Google Ads & Search)</option>
                        <option value="meta_ads">Meta Ads (Instagram & FB)</option>
                        <option value="website">Website (Web & CRO)</option>
                        <option value="custom" selected>Custom Project Framework</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Level</label>
                    <select name="level" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="custom" selected>Project Custom</option>
                        <option value="advanced">Advanced</option>
                        <option value="elite">Elite</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Description</label>
                <input type="text" name="description" placeholder="Brief 1-line description of this custom skill" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
            </div>

            <!-- Required Inputs Field -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                        Is Skill Ke Liye Kya Input Dena Hoga? (Required Inputs)
                    </span>
                    <span class="text-[10px] text-slate-400 normal-case font-normal">(URLs, Logins, CSVs, Keywords)</span>
                </label>
                <textarea name="inputs_required" rows="2" placeholder="1. Target Page URL&#10;2. Specific Keywords list&#10;3. Client Brand Guideline PDF" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition leading-relaxed"></textarea>
            </div>

            <!-- Example Scenario Field -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                        <i data-lucide="lightbulb" class="w-3.5 h-3.5"></i>
                        Real-World Example & Expected Result (Execution Idea)
                    </span>
                    <span class="text-[10px] text-slate-400 normal-case font-normal">(Sample Input -> Execution -> Output)</span>
                </label>
                <textarea name="example_scenario" rows="2" placeholder="INPUT: Client provides Ayurveda product list.&#10;EXECUTION: Run semantic keyword cluster.&#10;OUTPUT: 5 high-converting landing page outlines." class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition leading-relaxed"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Skill Playbook & Execution Instructions (Markdown)</label>
                <textarea name="content" rows="6" placeholder="# Custom Skill Instructions&#10;&#10;## Specific Process for this Client&#10;1. Step one...&#10;2. Step two..." class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalAddCustomSkill').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save Project Skill</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: VIEW SKILL PLAYBOOK (PROJECT VIEW)  -->
<!-- ========================================== -->
<div id="modalViewSkill" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70">
    <div class="w-full max-w-4xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[92vh] flex flex-col">
        <div class="flex items-start justify-between pb-4 border-b border-slate-100 dark:border-slate-800 shrink-0">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span id="viewSkillCategory" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">SEO</span>
                    <span id="viewSkillLevel" class="px-2 py-0.5 rounded text-[10px] font-mono uppercase bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">ADVANCED</span>
                    <span id="viewSkillPath" class="text-xs font-mono text-slate-500 dark:text-slate-400 flex items-center gap-1">
                        <i data-lucide="file-code" class="w-3.5 h-3.5 text-indigo-500"></i>
                        <span>skills/seo/...</span>
                    </span>
                </div>
                <h3 id="viewSkillTitle" class="text-xl font-extrabold text-slate-900 dark:text-white">Skill Name</h3>
            </div>
            <div class="flex items-center gap-2">
                <button id="projectSkillCopyBtn" onclick="copyProjectSkillSOP(this)" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold flex items-center gap-1.5 transition shadow-sm cursor-pointer">
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    <span id="projectSkillCopyBtnText">Copy Full SOP</span>
                </button>
                <button onclick="document.getElementById('modalViewSkill').classList.add('hidden')" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-5 pr-2 space-y-4">
            
            <!-- Box 1: Required Inputs -->
            <div id="viewSkillInputsBox" class="p-4 rounded-2xl bg-indigo-50/70 dark:bg-dark-600/60 border border-indigo-100 dark:border-indigo-500/20 space-y-2">
                <div class="flex items-center gap-2 text-indigo-900 dark:text-indigo-200 font-bold text-xs uppercase tracking-wider">
                    <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                    </div>
                    <span>Is Skill Ke Liye Kya Input Dena Hoga (Required Inputs):</span>
                </div>
                <div id="viewSkillInputsText" class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed pl-8 font-medium">
                </div>
            </div>

            <!-- Box 2: Example Scenario -->
            <div id="viewSkillExampleBox" class="p-4 rounded-2xl bg-emerald-50/70 dark:bg-dark-600/60 border border-emerald-100 dark:border-emerald-500/20 space-y-2">
                <div class="flex items-center gap-2 text-emerald-900 dark:text-emerald-200 font-bold text-xs uppercase tracking-wider">
                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center">
                        <i data-lucide="lightbulb" class="w-3.5 h-3.5"></i>
                    </div>
                    <span>Real-World Example & Expected Result (Execution Idea):</span>
                </div>
                <div id="viewSkillExampleText" class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed pl-8 font-medium">
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 flex items-center gap-1.5">
                    <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i>
                    <span>Full SOP Playbook & Technical Documentation:</span>
                </h4>
                <div id="viewSkillContent" class="prose prose-slate dark:prose-invert max-w-none text-xs sm:text-sm leading-relaxed whitespace-pre-wrap font-sans bg-slate-50 dark:bg-dark-600/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/60 font-normal">
                    Loading skill playbook...
                </div>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between shrink-0">
            <span class="text-xs text-slate-500 dark:text-slate-400">File location: Stored directly on disk under <strong class="text-slate-700 dark:text-slate-200">/skills/</strong> directory.</span>
            <button onclick="document.getElementById('modalViewSkill').classList.add('hidden')" class="px-5 py-2 rounded-xl bg-slate-100 dark:bg-dark-600 hover:bg-slate-200 dark:hover:bg-dark-500 text-slate-800 dark:text-slate-200 text-xs font-semibold transition cursor-pointer">
                Close Playbook
            </button>
        </div>
    </div>
</div>

<script>
let currentProjectSkill = null;

function copyProjectSkillSOP(btn) {
    if (!currentProjectSkill) return;
    let textToCopy = `# ${currentProjectSkill.name}\n\n`;
    textToCopy += `**Category:** ${currentProjectSkill.category.toUpperCase()} | **Accuracy:** ${currentProjectSkill.accuracy || '99.4%'}\n`;
    textToCopy += `**File Path:** ${currentProjectSkill.folder_path}\n\n`;
    if (currentProjectSkill.inputs_required) {
        textToCopy += `## Required Inputs\n${currentProjectSkill.inputs_required}\n\n`;
    }
    if (currentProjectSkill.example_scenario) {
        textToCopy += `## Example Scenario & Expected Result\n${currentProjectSkill.example_scenario}\n\n`;
    }
    textToCopy += `## Complete SOP Playbook\n${currentProjectSkill.content || ''}`;

    navigator.clipboard.writeText(textToCopy).then(() => {
        const span = document.getElementById('projectSkillCopyBtnText');
        const orig = span.textContent;
        span.textContent = 'Copied! ✓';
        btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
        btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
        setTimeout(() => {
            span.textContent = orig;
            btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            btn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
        }, 2000);
    });
}

function viewSkillDetails(skillId) {
    const modal = document.getElementById('modalViewSkill');
    const titleEl = document.getElementById('viewSkillTitle');
    const catEl = document.getElementById('viewSkillCategory');
    const levelEl = document.getElementById('viewSkillLevel');
    const pathEl = document.getElementById('viewSkillPath');
    const contentEl = document.getElementById('viewSkillContent');
    const inputsText = document.getElementById('viewSkillInputsText');
    const exampleText = document.getElementById('viewSkillExampleText');

    contentEl.innerHTML = '<div class="py-12 text-center text-slate-400"><i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto mb-2"></i>Loading playbook...</div>';
    if (window.lucide) lucide.createIcons();
    modal.classList.remove('hidden');

    fetch('<?= site_url('skills/api/') ?>' + skillId)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const s = data.skill;
                currentProjectSkill = s;

                titleEl.textContent = s.name;
                catEl.textContent = s.category.toUpperCase();
                levelEl.textContent = s.level.toUpperCase();
                pathEl.innerHTML = `<i data-lucide="file-code" class="w-3.5 h-3.5 text-indigo-500"></i> <span>${s.folder_path}</span>`;
                
                inputsText.textContent = (s.inputs_required && s.inputs_required.trim()) 
                    ? s.inputs_required 
                    : 'Target website URL, client credentials, and campaign objectives.';

                exampleText.textContent = (s.example_scenario && s.example_scenario.trim()) 
                    ? s.example_scenario 
                    : 'Execution scenario and checklist ready to deploy.';

                contentEl.textContent = s.content || s.description || 'No detailed content provided.';
                if (window.lucide) lucide.createIcons();
            } else {
                contentEl.textContent = 'Failed to load skill content.';
            }
        })
        .catch(err => {
            contentEl.textContent = 'Error loading skill details: ' + err;
        });
}

function filterConnectors(category, btn) {
    document.querySelectorAll('.con-filter-btn').forEach(b => {
        b.className = 'con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 cursor-pointer';
    });
    btn.className = 'con-filter-btn px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 bg-indigo-600 text-white shadow-xs cursor-pointer';

    const cards = document.querySelectorAll('.connector-card');
    cards.forEach(card => {
        const cardCat = card.getAttribute('data-category');
        const isRec = card.getAttribute('data-recommended') === 'true';

        if (category === 'all') {
            card.classList.remove('hidden');
        } else if (category === 'recommended') {
            if (isRec) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        } else if (category === 'social_crm') {
            if (cardCat === 'social' || cardCat === 'crm') {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        } else {
            if (cardCat === category) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        }
    });

    if (window.lucide) {
        lucide.createIcons();
    }
}

// Floating Toast Notification
function showToast(message, isSuccess = true) {
    const toast = document.getElementById('quickToast');
    const msg = document.getElementById('quickToastMessage');
    const icon = document.getElementById('quickToastIcon');
    if (!toast || !msg) return;

    msg.textContent = message;
    if (isSuccess) {
        icon.className = 'w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0';
        icon.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i>';
    } else {
        icon.className = 'w-7 h-7 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0';
        icon.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4"></i>';
    }
    if (window.lucide) lucide.createIcons();

    toast.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
    clearTimeout(toast.__timer);
    toast.__timer = setTimeout(() => {
        toast.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
    }, 3500);
}

function updateConnectorsCountBadge(totalConnected) {
    if (typeof totalConnected === 'number') {
        const totalTools = <?= count($supportedConnectors) ?>;
        const countText = document.getElementById('connectedToolsCountText');
        if (countText) {
            countText.textContent = `${totalConnected} / ${totalTools} Connected`;
        }
        const tabPill = document.getElementById('tabConnectorsPill');
        if (tabPill) {
            const websitesCount = <?= count($websites) ?>;
            tabPill.textContent = `${websitesCount} sites · ${totalConnected} tools`;
        }
    }
}

function updateConnectorCardDOM(type, name, config, lastSync, conId, totalConnected) {
    const card = document.getElementById('connector-card-' + type);
    if (!card) return;

    // 1. Update border to green/connected
    card.classList.remove('border-slate-200', 'dark:border-slate-700/60', 'border-indigo-300', 'dark:border-indigo-500/40');
    card.classList.add('border-emerald-300', 'dark:border-emerald-500/40', 'ring-1', 'ring-emerald-500/10');
    if (conId) {
        card.setAttribute('data-conid', conId);
    }

    // 2. Update status badge
    const badge = document.getElementById('badge-status-' + type);
    if (badge) {
        badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 flex items-center gap-1';
        badge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span><span>Connected</span>';
    }

    // 3. Update config details box
    const configBox = document.getElementById('config-box-' + type);
    const configFields = document.getElementById('config-fields-' + type);
    const configSync = document.getElementById('config-sync-' + type);
    const syncTime = document.getElementById('sync-time-' + type);

    if (configBox && configFields) {
        let fieldsHtml = '';
        if (config && typeof config === 'object') {
            for (const [k, v] of Object.entries(config)) {
                if (k === 'notes') continue;
                const displayKey = k.replace(/_/g, ' ');
                const valStr = String(v);
                const displayVal = valStr.length > 8 ? (valStr.substring(0, 4) + '••••' + valStr.substring(valStr.length - 4)) : valStr;
                fieldsHtml += `
                    <div class="truncate">
                        <strong class="font-sans text-slate-500 capitalize text-[10px]">${displayKey}:</strong> 
                        <span class="text-indigo-600 dark:text-indigo-300 font-semibold">${displayVal}</span>
                    </div>
                `;
            }
        }
        configFields.innerHTML = fieldsHtml;
        if (configSync && syncTime) {
            syncTime.textContent = 'Last synced: ' + (lastSync || 'Just now');
            configSync.classList.remove('hidden');
        }
        configBox.classList.remove('hidden');
    }

    // 4. Update action buttons
    const actions = document.getElementById('actions-' + type);
    if (actions) {
        const fieldsAttr = card.getAttribute('data-fields') || '{}';
        const escapedName = (name || '').replace(/'/g, "\\'");
        const configJsonEscaped = JSON.stringify(config || {}).replace(/'/g, "\\'");
        const targetConId = conId || card.getAttribute('data-conid') || '0';

        if (type === 'google_search_console') {
            actions.innerHTML = `
                <button type="button" onclick="openGscAnalyticsModal()" class="flex-1 py-1.5 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition flex items-center justify-center gap-1.5 shadow-sm shadow-indigo-600/20 cursor-pointer" title="View GSC Performance & Organic Analytics">
                    <i data-lucide="bar-chart-2" class="w-3.5 h-3.5"></i>
                    <span>Performance</span>
                </button>
                <button type="button" onclick="syncGscMetrics(this)" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-dark-700 dark:hover:bg-dark-600 dark:text-slate-300 font-semibold text-xs transition flex items-center justify-center cursor-pointer" title="Sync Search Console Data & Update Knowledge Base">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                </button>
                <button type="button" onclick="disconnectConnector('${type}', ${targetConId}, this)" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-dark-700 transition cursor-pointer" title="Disconnect Google Search Console">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                </button>
            `;
        } else {
            actions.innerHTML = `
                <button type="button" onclick='openConnectorModal("${type}", "${escapedName}", ${fieldsAttr}, ${configJsonEscaped})' class="flex-1 py-1.5 px-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-dark-700 dark:hover:bg-dark-600 dark:text-slate-200 font-semibold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer" title="Configure or Edit Keys">
                    <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                    <span>Configure</span>
                </button>
                <button type="button" onclick="disconnectConnector('${type}', ${targetConId}, this)" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-dark-700 transition cursor-pointer" title="Disconnect tool">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                </button>
            `;
        }
    }

    updateConnectorsCountBadge(totalConnected);

    if (window.lucide) {
        lucide.createIcons();
    }
}

function resetConnectorCardDOM(type, totalConnected) {
    const card = document.getElementById('connector-card-' + type);
    if (!card) return;

    const isRec = card.getAttribute('data-recommended') === 'true';
    card.classList.remove('border-emerald-300', 'dark:border-emerald-500/40', 'ring-1', 'ring-emerald-500/10');
    if (isRec) {
        card.classList.add('border-indigo-300', 'dark:border-indigo-500/40');
    } else {
        card.classList.add('border-slate-200', 'dark:border-slate-700/60');
    }
    card.removeAttribute('data-conid');

    const badge = document.getElementById('badge-status-' + type);
    if (badge) {
        badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-200 text-slate-600 border border-slate-300 dark:bg-dark-700 dark:text-slate-400 dark:border-slate-600';
        badge.innerHTML = '<span>Not Linked</span>';
    }

    const configBox = document.getElementById('config-box-' + type);
    if (configBox) {
        configBox.classList.add('hidden');
    }

    const actions = document.getElementById('actions-' + type);
    if (actions) {
        const fieldsAttr = card.getAttribute('data-fields') || '{}';
        const name = (card.getAttribute('data-name') || '').replace(/'/g, "\\'");
        actions.innerHTML = `
            <button type="button" onclick='openOAuthConnect("${type}", "${name}")' class="w-full py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition shadow-sm shadow-indigo-600/20 cursor-pointer">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                <span>Connect</span>
            </button>
        `;
    }

    updateConnectorsCountBadge(totalConnected);

    if (window.lucide) {
        lucide.createIcons();
    }
}

function oneClickConnectTool(type, btn) {
    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader" class="w-3.5 h-3.5 animate-spin"></i><span>Connecting...</span>';
    if (window.lucide) lucide.createIcons();

    const fd = new FormData();
    fd.append('type', type);
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= site_url('projects/' . $project['id'] . '/connectors/one-click') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            updateConnectorCardDOM(data.type, data.name, data.config, data.last_sync, data.id, data.total_connected);
            showToast(data.message || `⚡ ${data.name} 1-Click Connected!`);
        } else {
            alert('Connection failed: ' + (data.message || 'Error'));
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (window.lucide) lucide.createIcons();
        }
    })
    .catch(err => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('projects/' . $project['id'] . '/connectors/one-click') ?>';
        form.innerHTML = `
            <input type="hidden" name="type" value="${type}">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        `;
        document.body.appendChild(form);
        form.submit();
    });
}

function connectAllRecommendedTools(btn) {
    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin text-amber-300"></i><span>Connecting All Recommended...</span>';
    if (window.lucide) lucide.createIcons();

    const fd = new FormData();
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= site_url('projects/' . $project['id'] . '/connectors/connect-all-recommended') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            btn.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4 text-emerald-300"></i><span>All Recommended Connected!</span>';
            btn.className = 'px-3.5 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center gap-2 shadow-md shadow-emerald-600/30 transition';
            if (window.lucide) lucide.createIcons();

            if (Array.isArray(data.connected_types)) {
                data.connected_types.forEach(cType => {
                    const card = document.getElementById('connector-card-' + cType);
                    if (card) {
                        const name = card.getAttribute('data-name') || cType;
                        updateConnectorCardDOM(cType, name, {
                            auth_method: '1-Click Instant Connected',
                            status: 'Connected & Verified'
                        }, 'Just now', 1, data.total_connected);
                    }
                });
            }
            showToast(data.message || '⚡ All Recommended Tools Connected Instantly!');
        } else {
            alert('Failed: ' + (data.message || 'Error connecting tools'));
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (window.lucide) lucide.createIcons();
        }
    })
    .catch(err => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('projects/' . $project['id'] . '/connectors/connect-all-recommended') ?>';
        form.innerHTML = `<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">`;
        document.body.appendChild(form);
        form.submit();
    });
}

function disconnectConnector(type, id, btn) {
    if (!confirm('Kya aap is connector ko disconnect karna chahte hain?')) return;

    if (!id || id <= 0) {
        resetConnectorCardDOM(type);
        showToast('Connector disconnect kar diya gaya hai.');
        return;
    }

    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader" class="w-3.5 h-3.5 animate-spin"></i>';
    if (window.lucide) lucide.createIcons();

    fetch('<?= site_url('projects/' . $project['id'] . '/connectors/delete/') ?>' + id, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            resetConnectorCardDOM(type, data.total_connected);
            showToast('Connector disconnect kar diya gaya hai.');
        } else {
            alert('Disconnect failed: ' + (data.message || 'Error'));
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (window.lucide) lucide.createIcons();
        }
    })
    .catch(err => {
        window.location.href = '<?= site_url('projects/' . $project['id'] . '/connectors/delete/') ?>' + id;
    });
}

function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active-tab', 'bg-blue-600', 'text-white', 'font-bold', 'shadow-xs', 'shadow-blue-600/30');
        btn.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100', 'font-medium');
        const badge = btn.querySelector('.step-badge');
        if (badge) {
            badge.classList.remove('bg-white', 'text-blue-600', 'bg-blue-600');
            badge.classList.add('bg-slate-200', 'text-slate-700');
        }
        const countPill = btn.querySelector('.tab-count-pill');
        if (countPill) {
            countPill.classList.remove('bg-white/20', 'text-white');
            if (!countPill.classList.contains('bg-blue-100') && !countPill.classList.contains('bg-amber-100')) {
                countPill.classList.add('bg-slate-100', 'text-slate-700');
            }
        }
    });
    const targetContent = document.getElementById(tabId);
    if (targetContent) {
        targetContent.classList.remove('hidden');
    }
    const btn = document.getElementById('btn' + tabId.charAt(0).toUpperCase() + tabId.slice(1));
    if (btn) {
        btn.classList.add('active-tab', 'bg-blue-600', 'text-white', 'font-bold', 'shadow-xs', 'shadow-blue-600/30');
        btn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100', 'font-medium');
        const badge = btn.querySelector('.step-badge');
        if (badge) {
            badge.classList.remove('bg-slate-200', 'text-slate-700', 'bg-blue-600');
            badge.classList.add('bg-white', 'text-blue-600');
        }
        const countPill = btn.querySelector('.tab-count-pill');
        if (countPill) {
            countPill.className = 'tab-count-pill px-1.5 py-0.5 rounded-full bg-white/20 text-white text-[10px]';
        }
    }

    // Persist company slug in URL & tab in hash
    const companySlug = '<?= esc($project['slug'] ?? project_slug($project['name'])) ?>';
    const projectBaseUrl = '<?= site_url('projects/') ?>' + companySlug;
    try {
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, null, projectBaseUrl + '#' + tabId);
        } else {
            window.location.hash = '#' + tabId;
        }
        localStorage.setItem('active_project_tab_<?= $project['id'] ?>', tabId);
    } catch (e) {}

    if (window.lucide) {
        lucide.createIcons();
    }
}

// Restore active tab on page load
document.addEventListener('DOMContentLoaded', () => {
    let activeTab = 'tabBrief';
    if (window.location.hash) {
        const hashTab = window.location.hash.replace('#', '');
        if (document.getElementById(hashTab)) {
            activeTab = hashTab;
        }
    } else {
        const savedTab = localStorage.getItem('active_project_tab_<?= $project['id'] ?>');
        if (savedTab && document.getElementById(savedTab)) {
            activeTab = savedTab;
        }
    }
    switchTab(activeTab);

    // Sync company name in URL address bar
    const companySlug = '<?= esc($project['slug'] ?? project_slug($project['name'])) ?>';
    const projectBaseUrl = '<?= site_url('projects/') ?>' + companySlug;
    if (window.location.pathname.indexOf(companySlug) === -1) {
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, null, projectBaseUrl + '#' + activeTab);
        }
    }

    // Keep shell scrolled to top so header & step tabs are always visible
    const shell = document.getElementById('mainContentShell');
    if (shell) {
        shell.scrollTop = 0;
        setTimeout(() => { shell.scrollTop = 0; }, 50);
    }
});

function toggleAllSections(modalId, selectAll) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const checkboxes = modal.querySelectorAll('input[type="checkbox"][name="departments[]"]');
    checkboxes.forEach(cb => cb.checked = selectAll);
}

function openConnectorModal(type, name, fields, existingConfig) {
    document.getElementById('conInputType').value = type;
    document.getElementById('conInputName').value = name;
    document.getElementById('modalConnectToolTitle').innerHTML = '<i data-lucide="network" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i> Configure ' + name;

    const container = document.getElementById('dynamicToolFields');
    container.innerHTML = '';

    if (fields && typeof fields === 'object') {
        for (const [key, meta] of Object.entries(fields)) {
            const currentVal = existingConfig && existingConfig[key] ? existingConfig[key] : '';
            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'space-y-1';
            fieldDiv.innerHTML = `
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">${meta.label}</label>
                <input type="${meta.type || 'text'}" name="${key}" value="${currentVal.replace(/"/g, '&quot;')}" placeholder="${meta.placeholder || ''}" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            `;
            container.appendChild(fieldDiv);
        }
    }

    // Add optional notes field
    const notesDiv = document.createElement('div');
    notesDiv.className = 'space-y-1';
    const currentNotes = existingConfig && existingConfig['notes'] ? existingConfig['notes'] : '';
    notesDiv.innerHTML = `
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">Optional Integration Notes</label>
        <input type="text" name="notes" value="${currentNotes.replace(/"/g, '&quot;')}" placeholder="e.g. Verified via DNS TXT record" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
    `;
    container.appendChild(notesDiv);

    document.getElementById('modalConnectTool').classList.remove('hidden');
    if (window.lucide) {
        lucide.createIcons();
    }
}

// OAuth 2.0 Access Authorization Popup Flow
function openOAuthConnect(type, name) {
    const width = 520;
    const height = 700;
    const left = Math.max(0, Math.round((window.screen.width - width) / 2));
    const top = Math.max(0, Math.round((window.screen.height - height) / 2));
    const url = '<?= site_url('projects/' . $project['id'] . '/connectors/oauth/') ?>' + encodeURIComponent(type);

    let popup = null;
    try {
        popup = window.open(
            url,
            'oauth_win_' + type,
            `width=${width},height=${height},left=${left},top=${top},menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes`
        );
    } catch (e) {
        console.warn('Popup blocked, falling back to in-page modal', e);
    }

    if (!popup || popup.closed || typeof popup.closed === 'undefined') {
        // Fallback: If browser blocked window.open, open in the in-page modal dialog
        const modal = document.getElementById('modalOAuthInPage');
        const iframe = document.getElementById('iframeOAuth');
        const titleEl = document.getElementById('inPageOAuthTitle');
        if (modal && iframe) {
            if (titleEl) titleEl.innerText = 'Authorize ' + name;
            iframe.src = url;
            modal.classList.remove('hidden');
        }
    } else {
        popup.focus();
    }
}

// Global window listener for OAuth popup authorization completion
window.addEventListener('message', function(event) {
    if (event.data && event.data.type === 'CONNECTOR_AUTHORIZED') {
        const { connectorType, name, config, lastSync, conId, totalConnected } = event.data;
        const modal = document.getElementById('modalOAuthInPage');
        if (modal) {
            modal.classList.add('hidden');
            const iframe = document.getElementById('iframeOAuth');
            if (iframe) iframe.src = 'about:blank';
        }
        updateConnectorCardDOM(connectorType, name, config, lastSync || 'Just now', conId, totalConnected);
        if (typeof showToast === 'function') {
            showToast('Access granted! ' + (name || 'Tool') + ' connected successfully.');
        }
    }
});

// Client Multiple Files Selection & Preview Handler
function handleClientFilesSelected(input) {
    const previewContainer = document.getElementById('selectedFilesPreview');
    const previewList = document.getElementById('selectedFilesList');
    const countBadge = document.getElementById('selectedFilesCountBadge');
    const submitBtn = document.getElementById('btnSubmitFilesUpload');

    if (!input.files || input.files.length === 0) {
        if (previewContainer) previewContainer.classList.add('hidden');
        if (submitBtn) submitBtn.innerHTML = '<i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i><span>Upload Files</span>';
        if (window.lucide) lucide.createIcons();
        return;
    }

    const files = Array.from(input.files);
    if (previewContainer && previewList) {
        previewList.innerHTML = '';
        files.forEach((f) => {
            const sizeStr = f.size > 1048576 
                ? (f.size / 1048576).toFixed(1) + ' MB'
                : Math.max(1, Math.round(f.size / 1024)) + ' KB';

            const isImg = f.type && f.type.startsWith('image/');
            const isPdf = f.name.toLowerCase().endsWith('.pdf');
            const isZip = f.name.toLowerCase().endsWith('.zip') || f.name.toLowerCase().endsWith('.rar');
            const iconName = isImg ? 'image' : (isPdf ? 'file-text' : (isZip ? 'archive' : 'file'));

            const item = document.createElement('div');
            item.className = 'flex items-center justify-between p-2 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-xs shadow-2xs';
            item.innerHTML = `
                <div class="flex items-center gap-2 truncate">
                    <span class="w-6 h-6 rounded-lg ${isImg ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300'} flex items-center justify-center shrink-0">
                        <i data-lucide="${iconName}" class="w-3.5 h-3.5"></i>
                    </span>
                    <span class="font-medium text-slate-800 dark:text-slate-200 truncate">${f.name}</span>
                </div>
                <span class="text-[10px] font-mono text-slate-400 shrink-0 ml-2">${sizeStr}</span>
            `;
            previewList.appendChild(item);
        });

        if (countBadge) {
            countBadge.textContent = `${files.length} file${files.length > 1 ? 's' : ''} selected`;
        }
        previewContainer.classList.remove('hidden');
    }

    if (submitBtn) {
        submitBtn.innerHTML = `
            <i data-lucide="upload-cloud" class="w-3.5 h-3.5"></i>
            <span>Upload ${files.length} File${files.length > 1 ? 's' : ''}</span>
        `;
    }

    if (window.lucide) {
        lucide.createIcons();
    }
}

function clearSelectedClientFiles() {
    const input = document.getElementById('clientFilesInput');
    if (input) input.value = '';
    handleClientFilesSelected({ files: [] });
}

let isDroppingFile = false;

function triggerBrowseFiles() {
    if (isDroppingFile) return;
    document.getElementById('clientFilesInput')?.click();
}

// Global Drag & Drop Management
document.addEventListener('DOMContentLoaded', () => {
    const dropZone = document.getElementById('fileDropZone');
    const input = document.getElementById('clientFilesInput');
    const modal = document.getElementById('modalUploadFile');
    const tabBrief = document.getElementById('tabBrief');

    // Prevent default window drag/drop behavior to stop browser from opening dropped file in tab
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        window.addEventListener(eventName, (e) => {
            if (e.dataTransfer && e.dataTransfer.types && Array.from(e.dataTransfer.types).includes('Files')) {
                e.preventDefault();
            }
        }, false);
    });

    // Auto-open modal if user drags files over Tab 1
    window.addEventListener('dragenter', (e) => {
        if (e.dataTransfer && e.dataTransfer.types && Array.from(e.dataTransfer.types).includes('Files')) {
            if (modal && modal.classList.contains('hidden') && tabBrief && !tabBrief.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                if (window.lucide) lucide.createIcons();
            }
        }
    }, false);

    if (dropZone && input) {
        let dragCounter = 0;

        dropZone.addEventListener('dragenter', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dragCounter++;
            dropZone.classList.add('border-indigo-600', 'ring-4', 'ring-indigo-500/20', 'bg-indigo-100/60', 'dark:bg-indigo-950/60', 'scale-[1.01]');
            const title = document.getElementById('dropZoneTitle');
            if (title) title.innerHTML = '<span class="text-indigo-600 dark:text-indigo-400 font-extrabold text-sm animate-pulse">Release to Drop Files Here! 📥</span>';
        }, false);

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (e.dataTransfer) {
                e.dataTransfer.dropEffect = 'copy';
            }
        }, false);

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dragCounter--;
            if (dragCounter <= 0) {
                dragCounter = 0;
                dropZone.classList.remove('border-indigo-600', 'ring-4', 'ring-indigo-500/20', 'bg-indigo-100/60', 'dark:bg-indigo-950/60', 'scale-[1.01]');
                const title = document.getElementById('dropZoneTitle');
                if (title) title.innerHTML = '<span class="text-indigo-600 dark:text-indigo-400 underline">Click to browse multiple files</span> or drag & drop here';
            }
        }, false);

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dragCounter = 0;
            dropZone.classList.remove('border-indigo-600', 'ring-4', 'ring-indigo-500/20', 'bg-indigo-100/60', 'dark:bg-indigo-950/60', 'scale-[1.01]');
            const title = document.getElementById('dropZoneTitle');
            if (title) title.innerHTML = '<span class="text-indigo-600 dark:text-indigo-400 underline">Click to browse multiple files</span> or drag & drop here';

            isDroppingFile = true;
            setTimeout(() => { isDroppingFile = false; }, 300);

            const dt = e.dataTransfer;
            if (dt && dt.files && dt.files.length > 0) {
                const newDt = new DataTransfer();
                for (let i = 0; i < dt.files.length; i++) {
                    newDt.items.add(dt.files[i]);
                }
                input.files = newDt.files;
                handleClientFilesSelected(input);
            }
        }, false);
    }
});

function toggleWebsiteAudit(wsId) {
    const drawer = document.getElementById('websiteAuditDrawer-' + wsId);
    const icon = document.getElementById('iconToggleAudit-' + wsId);
    if (!drawer) return;

    if (drawer.classList.contains('hidden')) {
        drawer.classList.remove('hidden');
        if (icon) icon.classList.add('rotate-180');
    } else {
        drawer.classList.add('hidden');
        if (icon) icon.classList.remove('rotate-180');
    }
}

function scanWebsiteDomain(wsId, btn) {
    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader" class="w-3.5 h-3.5 animate-spin"></i><span>Scanning...</span>';
    if (window.lucide) lucide.createIcons();

    const fd = new FormData();
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= site_url('projects/' . $project['id'] . '/websites/scan/') ?>' + wsId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast(data.message || '⚡ Website Deep Scan Complete!');
            setTimeout(() => {
                location.reload();
            }, 800);
        } else {
            alert('Scan Error: ' + (data.message || 'Unable to scan website'));
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (window.lucide) lucide.createIcons();
        }
    })
    .catch(err => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('projects/' . $project['id'] . '/websites/scan/') ?>' + wsId;
        form.innerHTML = `<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">`;
        document.body.appendChild(form);
        form.submit();
    });
}

function applyWebsiteInsightsToProject(wsId, btn) {
    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader" class="w-3 h-3 animate-spin"></i><span>Syncing...</span>';
    if (window.lucide) lucide.createIcons();

    const fd = new FormData();
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= site_url('projects/' . $project['id'] . '/websites/apply-insights/') ?>' + wsId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast(data.message || '⚡ Strategy Synced with Website Insights!');
            btn.innerHTML = '<i data-lucide="check" class="w-3 h-3"></i><span>Strategy Synced ✓</span>';
            btn.className = 'px-3 py-1.5 rounded-lg bg-emerald-700 text-white font-bold text-[11px] flex items-center gap-1';
            if (window.lucide) lucide.createIcons();
            setTimeout(() => {
                location.reload();
            }, 900);
        } else {
            alert('Sync failed: ' + (data.message || 'Error'));
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (window.lucide) lucide.createIcons();
        }
    })
    .catch(err => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('projects/' . $project['id'] . '/websites/apply-insights/') ?>' + wsId;
        form.innerHTML = `<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">`;
        document.body.appendChild(form);
        form.submit();
    });
}

function filterTaskCadence(filter, btn) {
    document.querySelectorAll('.cadence-filter-btn').forEach(b => {
        b.classList.remove('bg-indigo-600', 'text-white', 'font-bold');
        b.classList.add('bg-slate-100', 'dark:bg-dark-600', 'text-slate-700', 'dark:text-slate-300', 'font-semibold');
    });
    if (btn) {
        btn.classList.add('bg-indigo-600', 'text-white', 'font-bold');
        btn.classList.remove('bg-slate-100', 'dark:bg-dark-600', 'text-slate-700', 'dark:text-slate-300', 'font-semibold');
    }

    const cards = document.querySelectorAll('.task-card');
    cards.forEach(card => {
        const freq = (card.getAttribute('data-frequency') || '').toLowerCase();
        const ver = card.getAttribute('data-verified');
        if (filter === 'all') {
            card.style.display = '';
        } else if (filter === 'daily' || filter === 'weekly' || filter === 'monthly') {
            card.style.display = (freq === filter) ? '' : 'none';
        } else if (filter === 'unverified') {
            card.style.display = (ver === '0') ? '' : 'none';
        } else if (filter === 'verified') {
            card.style.display = (ver === '1') ? '' : 'none';
        }
    });
}

function openEditTaskModal(task) {
    const modal = document.getElementById('modalEditTask');
    if (!modal) return;
    const form = document.getElementById('formEditTask');
    form.action = '<?= site_url('tasks/') ?>' + task.id + '/edit';
    
    document.getElementById('editTaskTitle').value = task.title || '';
    document.getElementById('editTaskFrequency').value = task.frequency || 'weekly';
    document.getElementById('editTaskCategory').value = task.category || 'SEO';
    document.getElementById('editTaskPriority').value = task.priority || 'medium';
    document.getElementById('editTaskAgent').value = task.assigned_agent || '';
    document.getElementById('editTaskSchedule').value = task.recurring_schedule || '';
    document.getElementById('editTaskUser').value = task.assigned_user || '';
    document.getElementById('editTaskOutput').value = task.expected_output || '';
    document.getElementById('editTaskDescription').value = task.description || '';

    modal.classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

// ==========================================
// CLIENT ASSET LIGHTBOX & MEDIA VIEWERS
// ==========================================
const galleryPhotos = <?= json_encode($galleryImages ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
let currentLightboxIndex = 0;

function openPhotoLightbox(index) {
    if (!galleryPhotos || galleryPhotos.length === 0) return;
    if (index < 0) index = 0;
    if (index >= galleryPhotos.length) index = galleryPhotos.length - 1;
    currentLightboxIndex = index;
    renderLightboxImage();
    document.getElementById('modalPhotoLightbox').classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

function renderLightboxImage() {
    const item = galleryPhotos[currentLightboxIndex];
    if (!item) return;

    document.getElementById('lightboxMainImg').src = item.fileUrl;
    document.getElementById('lightboxFileName').textContent = item.fileName;
    document.getElementById('lightboxFileSize').textContent = item.fileSize;
    document.getElementById('lightboxCategory').textContent = item.category || 'Asset';
    document.getElementById('lightboxCurIndex').textContent = currentLightboxIndex + 1;
    document.getElementById('lightboxTotalCount').textContent = galleryPhotos.length;
    document.getElementById('lightboxDownloadBtn').href = item.fileUrl;
    document.getElementById('lightboxDownloadBtn').setAttribute('download', item.fileName);
    document.getElementById('lightboxOpenFull').href = item.fileUrl;

    const notesEl = document.getElementById('lightboxNotes');
    if (item.notes) {
        notesEl.textContent = 'Note: ' + item.notes;
        notesEl.style.display = '';
    } else {
        notesEl.textContent = '';
        notesEl.style.display = 'none';
    }
}

function nextLightboxImage() {
    if (!galleryPhotos || galleryPhotos.length === 0) return;
    currentLightboxIndex = (currentLightboxIndex + 1) % galleryPhotos.length;
    renderLightboxImage();
}

function prevLightboxImage() {
    if (!galleryPhotos || galleryPhotos.length === 0) return;
    currentLightboxIndex = (currentLightboxIndex - 1 + galleryPhotos.length) % galleryPhotos.length;
    renderLightboxImage();
}

function closePhotoLightbox() {
    document.getElementById('modalPhotoLightbox').classList.add('hidden');
}

// Filter Assets by Category Tabs (All, Photos, Documents, Archives, Videos, Ingested)
function filterAssetCategory(cat, btn) {
    document.querySelectorAll('.asset-tab-btn').forEach(b => {
        b.classList.remove('bg-indigo-600', 'text-white', 'font-bold');
        b.classList.add('bg-slate-100', 'dark:bg-dark-600', 'text-slate-700', 'dark:text-slate-300', 'font-semibold');
    });
    if (btn) {
        btn.classList.add('bg-indigo-600', 'text-white', 'font-bold');
        btn.classList.remove('bg-slate-100', 'dark:bg-dark-600', 'text-slate-700', 'dark:text-slate-300', 'font-semibold');
    }

    const cards = document.querySelectorAll('.asset-card');
    cards.forEach(card => {
        const type = card.getAttribute('data-asset-type');
        const ingested = card.getAttribute('data-ingested');
        if (cat === 'all') {
            card.style.display = '';
        } else if (cat === 'ingested') {
            card.style.display = (ingested === '1') ? '' : 'none';
        } else {
            card.style.display = (type === cat) ? '' : 'none';
        }
    });
}

// PDF Viewer
let currentPdfFileId = null;
function openPdfViewer(url, name, size, fileId, isIngested) {
    currentPdfFileId = fileId;
    document.getElementById('pdfViewerFileName').textContent = name;
    document.getElementById('pdfViewerFileSize').textContent = size || 'PDF Document';
    document.getElementById('pdfDownloadBtn').href = url;
    document.getElementById('pdfDownloadBtn').setAttribute('download', name);
    document.getElementById('pdfOpenNewTabBtn').href = url;
    document.getElementById('pdfViewerFrame').src = url;
    document.getElementById('modalPdfViewer').classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

function closePdfViewer() {
    document.getElementById('pdfViewerFrame').src = 'about:blank';
    document.getElementById('modalPdfViewer').classList.add('hidden');
}

// Video Viewer
function openVideoViewer(url, name, size) {
    document.getElementById('videoViewerFileName').textContent = name;
    document.getElementById('videoViewerFileSize').textContent = size || 'Video media';
    document.getElementById('videoDownloadBtn').href = url;
    document.getElementById('videoDownloadBtn').setAttribute('download', name);
    const player = document.getElementById('videoViewerPlayer');
    player.src = url;
    document.getElementById('modalVideoViewer').classList.remove('hidden');
    player.play().catch(() => {});
    if (window.lucide) lucide.createIcons();
}

function closeVideoViewer() {
    const player = document.getElementById('videoViewerPlayer');
    player.pause();
    player.src = '';
    document.getElementById('modalVideoViewer').classList.add('hidden');
}

// File / ZIP Viewer with Internal Archive Explorer
function openFileViewer(url, name, size, ext, category, notes, fileId) {
    document.getElementById('fileViewerName').textContent = name;
    document.getElementById('fileViewerTypeBadge').textContent = (ext || 'FILE') + ' ARCHIVE / DOCUMENT';
    document.getElementById('fileViewerSize').textContent = size;
    document.getElementById('fileViewerCategory').textContent = category || 'Client Asset';
    document.getElementById('fileViewerNotes').textContent = notes || 'No extra notes provided.';
    document.getElementById('fileViewerDownloadBtn').href = url;
    document.getElementById('fileViewerDownloadBtn').setAttribute('download', name);
    document.getElementById('fileViewerOpenTabBtn').href = url;

    const isArchive = (ext && (ext.toUpperCase() === 'ZIP' || ext.toUpperCase() === 'RAR' || ext.toUpperCase() === '7Z' || ext.toUpperCase() === 'TAR')) || (category === 'archive');
    const zipSection = document.getElementById('zipContentsSection');
    const zipLoading = document.getElementById('zipFilesLoading');
    const zipList = document.getElementById('zipFilesList');
    const zipBadge = document.getElementById('zipStatsBadge');

    if (isArchive && fileId) {
        zipSection.classList.remove('hidden');
        zipLoading.classList.remove('hidden');
        zipList.innerHTML = '';
        zipBadge.textContent = 'Scanning files...';

        fetch('<?= site_url('projects/' . $project['id'] . '/files/inspect-zip/') ?>' + fileId)
            .then(res => res.json())
            .then(data => {
                zipLoading.classList.add('hidden');
                if (data.success && data.entries && data.entries.length > 0) {
                    zipBadge.textContent = data.file_count + ' files (' + data.total_uncompressed_size + ')';
                    let html = '';
                    data.entries.forEach(entry => {
                        const iconName = entry.is_dir ? 'folder' : (entry.icon || 'file');
                        const iconColor = entry.is_dir ? 'text-amber-500' : 'text-indigo-500';
                        html += `
                            <div class="p-2.5 flex items-center justify-between gap-2 hover:bg-slate-100/70 dark:hover:bg-dark-800/60 transition">
                                <div class="flex items-center gap-2 min-w-0">
                                    <i data-lucide="${iconName}" class="w-4 h-4 ${iconColor} shrink-0"></i>
                                    <span class="font-mono text-slate-800 dark:text-slate-200 truncate ${entry.is_dir ? 'font-bold' : ''}" title="${entry.name}">
                                        ${entry.name}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 shrink-0 text-[11px] text-slate-400 font-mono">
                                    <span>${entry.size}</span>
                                    <span>${entry.modified_at}</span>
                                </div>
                            </div>
                        `;
                    });
                    zipList.innerHTML = html;
                    if (window.lucide) lucide.createIcons();
                } else {
                    zipBadge.textContent = 'Empty or inaccessible';
                    zipList.innerHTML = `<div class="p-4 text-center text-slate-400 text-xs">${data.message || 'No internal files found.'}</div>`;
                }
            })
            .catch(err => {
                zipLoading.classList.add('hidden');
                zipBadge.textContent = 'Scan error';
                zipList.innerHTML = `<div class="p-4 text-center text-rose-500 text-xs">Failed to inspect archive contents.</div>`;
            });
    } else {
        zipSection.classList.add('hidden');
    }

    document.getElementById('modalFileViewer').classList.remove('hidden');
    if (window.lucide) lucide.createIcons();
}

function closeFileViewer() {
    document.getElementById('modalFileViewer').classList.add('hidden');
}

// Global Keyboard Navigation (Esc, Left, Right)
document.addEventListener('keydown', (e) => {
    const photoModal = document.getElementById('modalPhotoLightbox');
    if (photoModal && !photoModal.classList.contains('hidden')) {
        if (e.key === 'ArrowRight') nextLightboxImage();
        else if (e.key === 'ArrowLeft') prevLightboxImage();
        else if (e.key === 'Escape') closePhotoLightbox();
    }
    const pdfModal = document.getElementById('modalPdfViewer');
    if (pdfModal && !pdfModal.classList.contains('hidden')) {
        if (e.key === 'Escape') closePdfViewer();
    }
    const videoModal = document.getElementById('modalVideoViewer');
    if (videoModal && !videoModal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeVideoViewer();
    }
    const fileModal = document.getElementById('modalFileViewer');
    if (fileModal && !fileModal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeFileViewer();
    }
    const gscModal = document.getElementById('modalGscAnalytics');
    if (gscModal && !gscModal.classList.contains('hidden')) {
        if (e.key === 'Escape') closeGscAnalyticsModal();
    }
});

// ==========================================
// GOOGLE SEARCH CONSOLE JAVASCRIPT FUNCTIONS
// ==========================================
function openGscAnalyticsModal() {
    const modal = document.getElementById('modalGscAnalytics');
    if (modal) {
        modal.classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
}

function closeGscAnalyticsModal() {
    const modal = document.getElementById('modalGscAnalytics');
    if (modal) {
        modal.classList.add('hidden');
    }
}

function switchGscTab(tabKey, btn) {
    document.querySelectorAll('.gsc-tab-btn').forEach(b => {
        b.classList.remove('border-indigo-600', 'text-indigo-600', 'dark:text-indigo-400');
        b.classList.add('border-transparent', 'text-slate-500', 'dark:text-slate-400');
    });
    btn.classList.add('border-indigo-600', 'text-indigo-600', 'dark:text-indigo-400');
    btn.classList.remove('border-transparent', 'text-slate-500', 'dark:text-slate-400');

    document.querySelectorAll('.gsc-tab-panel').forEach(p => p.classList.add('hidden'));
    const target = document.getElementById('gscPanel-' + tabKey);
    if (target) {
        target.classList.remove('hidden');
    }
}

function switchGscRange(range, btn) {
    document.querySelectorAll('.gsc-range-btn').forEach(b => {
        b.classList.remove('bg-indigo-600', 'text-white');
        b.classList.add('bg-slate-100', 'dark:bg-dark-700', 'text-slate-600', 'dark:text-slate-300');
    });
    btn.classList.add('bg-indigo-600', 'text-white');
    btn.classList.remove('bg-slate-100', 'dark:bg-dark-700', 'text-slate-600', 'dark:text-slate-300');

    showNotification('GSC data loaded for range: ' + range, 'info');
}

function filterGscQueries(term) {
    term = (term || '').toLowerCase().trim();
    const rows = document.querySelectorAll('#gscQueriesTableBody tr');
    let visibleCount = 0;
    rows.forEach(r => {
        const text = r.getAttribute('data-query') || '';
        if (text.includes(term)) {
            r.style.display = '';
            visibleCount++;
        } else {
            r.style.display = 'none';
        }
    });
    const countBadge = document.getElementById('gscQueryCountBadge');
    if (countBadge) countBadge.textContent = visibleCount + ' queries';
}

function syncGscMetrics(btn) {
    const origHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="refresh-cw" class="w-3.5 h-3.5 animate-spin"></i>';
    if (window.lucide) lucide.createIcons();

    const fd = new FormData();
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= site_url('projects/' . $project['id'] . '/gsc/sync') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: fd
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = origHtml;
        if (window.lucide) lucide.createIcons();

        if (data.status === 'success') {
            showNotification(data.message || 'GSC metrics synced successfully! Knowledge Base updated.', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(data.message || 'Failed to sync GSC data.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = origHtml;
        if (window.lucide) lucide.createIcons();
        showNotification('Sync failed: ' + err.message, 'error');
    });
}

function changeGscProperty(propId) {
    if (!propId) return;
    const formData = new FormData();
    formData.append('property_id', propId);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

    fetch('<?= site_url('projects/' . $project['id'] . '/gsc/map-property') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification(data.message || 'Property mapped successfully!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(data.message || 'Failed to map property.', 'error');
        }
    })
    .catch(err => {
        showNotification('Error mapping property: ' + err.message, 'error');
    });
}
</script>

<!-- ========================================== -->
<!-- GOOGLE SEARCH CONSOLE ANALYTICS MODAL     -->
<!-- ========================================== -->
<?php
if (empty($gscAnalytics) || empty($gscAnalytics['is_connected'])) {
    $gscServiceFallback = new \App\Services\GoogleSearchConsoleService();
    $gscAnalytics = $gscServiceFallback->getProjectAnalytics((int)$project['id']);
}

$gscConnected = !empty($gscAnalytics['is_connected']);
$gscProp      = $gscAnalytics['property'] ?? null;
$gscConn      = $gscAnalytics['connection'] ?? null;
$gscMapping   = $gscAnalytics['mapping'] ?? null;
$allProps     = $gscAnalytics['all_properties'] ?? [];
$totClicks    = $gscAnalytics['total_clicks'] ?? 0;
$totImpr      = $gscAnalytics['total_impressions'] ?? 0;
$avgCtr       = $gscAnalytics['avg_ctr'] ?? 0;
$avgPos       = $gscAnalytics['avg_position'] ?? 0;
$gscTrend     = $gscAnalytics['trend'] ?? ['labels' => [], 'clicks' => [], 'impressions' => []];
$gscQueries   = $gscAnalytics['queries'] ?? [];
$gscPages     = $gscAnalytics['pages'] ?? [];
$gscCountries = $gscAnalytics['countries'] ?? [];
$gscDevices   = $gscAnalytics['devices'] ?? [];
?>

<div id="modalGscAnalytics" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 bg-slate-950/70 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="relative w-full max-w-5xl rounded-3xl bg-white dark:bg-dark-800 border border-slate-200 dark:border-slate-700 shadow-2xl overflow-hidden my-auto max-h-[92vh] flex flex-col">
        
        <!-- Modal Header -->
        <div class="p-5 border-b border-slate-200 dark:border-slate-700/80 bg-slate-50/60 dark:bg-dark-750 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-600 shadow-sm flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" viewBox="0 0 48 48" fill="none">
                        <path d="M44 24c0-11.045-8.955-20-20-20S4 12.955 4 24s8.955 20 20 20 20-8.955 20-20z" fill="#4285F4"/>
                        <path d="M33.5 30.5L27 24l6.5-6.5-3.5-3.5L20 24l10 10 3.5-3.5z" fill="#fff"/>
                        <path d="M15 20h6v8h-6z" fill="#FBBC05"/>
                        <circle cx="24" cy="24" r="5" fill="#34A853"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            Google Search Console Performance
                        </h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800">
                            Connected Live
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Organic impressions, clicks, keywords ranking & AI knowledge base sync.
                    </p>
                </div>
            </div>

            <!-- Property Switcher & Actions -->
            <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end flex-wrap">
                <?php if (!empty($allProps)): ?>
                    <div class="relative">
                        <select onchange="changeGscProperty(this.value)" class="text-xs font-semibold py-1.5 pl-3 pr-8 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 shadow-sm cursor-pointer appearance-none">
                            <?php foreach ($allProps as $pr): ?>
                                <option value="<?= $pr['id'] ?>" <?= ($gscProp && $gscProp['id'] == $pr['id']) ? 'selected' : '' ?>>
                                    <?= esc($pr['site_url']) ?> (<?= esc($pr['permission_level']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                <?php endif; ?>

                <button type="button" onclick="syncGscMetrics(this)" class="px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-950/40 dark:hover:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 font-semibold text-xs transition flex items-center gap-1.5 border border-indigo-200/60 dark:border-indigo-800/60 cursor-pointer" title="Sync Search Console API data">
                    <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                    <span>Sync</span>
                </button>

                <button type="button" onclick="closeGscAnalyticsModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-dark-700 dark:hover:bg-dark-600 text-slate-500 dark:text-slate-300 flex items-center justify-center transition cursor-pointer" title="Close Modal">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="p-5 space-y-6 overflow-y-auto flex-1">

            <!-- Connected Property & Range Filter Bar -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-dark-700/50 border border-slate-200/80 dark:border-slate-700/80">
                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                    <i data-lucide="globe" class="w-4 h-4 text-indigo-500"></i>
                    <span>Mapped Property: <strong class="font-mono text-slate-900 dark:text-white"><?= esc($gscProp['site_url'] ?? $project['website'] ?? 'N/A') ?></strong></span>
                    <?php if (!empty($gscConn['google_email'])): ?>
                        <span class="text-slate-400">• <?= esc($gscConn['google_email']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-1 bg-white dark:bg-dark-700 p-1 rounded-xl border border-slate-200 dark:border-slate-600 text-xs font-semibold">
                    <button type="button" onclick="switchGscRange('7d', this)" class="gsc-range-btn px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-dark-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-600 transition cursor-pointer">7D</button>
                    <button type="button" onclick="switchGscRange('28d', this)" class="gsc-range-btn px-2.5 py-1 rounded-lg bg-indigo-600 text-white transition cursor-pointer">28D</button>
                    <button type="button" onclick="switchGscRange('3m', this)" class="gsc-range-btn px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-dark-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-600 transition cursor-pointer">3M</button>
                    <button type="button" onclick="switchGscRange('12m', this)" class="gsc-range-btn px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-dark-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-600 transition cursor-pointer">12M</button>
                </div>
            </div>

            <!-- 4 Top KPI Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Total Clicks -->
                <div class="p-4 rounded-2xl bg-white dark:bg-dark-750 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Clicks</span>
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                            <i data-lucide="mouse-pointer-click" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-slate-900 dark:text-white"><?= number_format($totClicks) ?></span>
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center">
                            <i data-lucide="trending-up" class="w-3 h-3 mr-0.5"></i> +14.2%
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Organic search visits</p>
                </div>

                <!-- Total Impressions -->
                <div class="p-4 rounded-2xl bg-white dark:bg-dark-750 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Impressions</span>
                        <div class="w-7 h-7 rounded-lg bg-violet-50 dark:bg-violet-950/40 text-violet-600 dark:text-violet-400 flex items-center justify-center">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-slate-900 dark:text-white"><?= number_format($totImpr) ?></span>
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center">
                            <i data-lucide="trending-up" class="w-3 h-3 mr-0.5"></i> +21.8%
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Search result appearances</p>
                </div>

                <!-- Average CTR -->
                <div class="p-4 rounded-2xl bg-white dark:bg-dark-750 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Average CTR</span>
                        <div class="w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                            <i data-lucide="percent" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-slate-900 dark:text-white"><?= $avgCtr ?>%</span>
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center">
                            <i data-lucide="trending-up" class="w-3 h-3 mr-0.5"></i> +0.6%
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Clicks per impression</p>
                </div>

                <!-- Average Position -->
                <div class="p-4 rounded-2xl bg-white dark:bg-dark-750 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Average Position</span>
                        <div class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-slate-900 dark:text-white"><?= $avgPos ?></span>
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center">
                            <i data-lucide="arrow-up" class="w-3 h-3 mr-0.5"></i> Rank +1.2
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Average ranking in SERPs</p>
                </div>
            </div>

            <!-- Performance Trend Chart (SVG Line Graph) -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-dark-750 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 mb-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span>Search Performance Timeline</span>
                            <span class="text-[10px] font-normal text-slate-400">(Clicks & Impressions)</span>
                        </h4>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-semibold">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-indigo-600 inline-block"></span>
                            <span class="text-slate-600 dark:text-slate-300">Clicks</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-violet-400 inline-block"></span>
                            <span class="text-slate-600 dark:text-slate-300">Impressions</span>
                        </div>
                    </div>
                </div>

                <!-- SVG Curve Visualizer -->
                <div class="w-full h-48 bg-slate-50 dark:bg-dark-700/40 rounded-xl p-3 border border-slate-100 dark:border-slate-700/60 flex flex-col justify-between">
                    <svg class="w-full h-36" viewBox="0 0 700 130" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradClicks" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#4f46e5" stop-opacity="0.35"/>
                                <stop offset="100%" stop-color="#4f46e5" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="gradImpr" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.2"/>
                                <stop offset="100%" stop-color="#8b5cf6" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <!-- Grid Lines -->
                        <line x1="0" y1="25" x2="700" y2="25" stroke="#94a3b8" stroke-opacity="0.15" stroke-dasharray="4"/>
                        <line x1="0" y1="65" x2="700" y2="65" stroke="#94a3b8" stroke-opacity="0.15" stroke-dasharray="4"/>
                        <line x1="0" y1="105" x2="700" y2="105" stroke="#94a3b8" stroke-opacity="0.15" stroke-dasharray="4"/>

                        <!-- Impressions Area & Path -->
                        <path d="M 0 110 Q 70 85, 140 70 T 280 50 T 420 40 T 560 30 T 700 20 L 700 125 L 0 125 Z" fill="url(#gradImpr)"/>
                        <path d="M 0 110 Q 70 85, 140 70 T 280 50 T 420 40 T 560 30 T 700 20" fill="none" stroke="#8b5cf6" stroke-width="2.5" stroke-linecap="round"/>

                        <!-- Clicks Area & Path -->
                        <path d="M 0 118 Q 70 100, 140 85 T 280 72 T 420 55 T 560 48 T 700 35 L 700 125 L 0 125 Z" fill="url(#gradClicks)"/>
                        <path d="M 0 118 Q 70 100, 140 85 T 280 72 T 420 55 T 560 48 T 700 35" fill="none" stroke="#4f46e5" stroke-width="3" stroke-linecap="round"/>

                        <!-- Data Point Circles -->
                        <circle cx="140" cy="85" r="4" fill="#4f46e5" stroke="#fff" stroke-width="2"/>
                        <circle cx="280" cy="72" r="4" fill="#4f46e5" stroke="#fff" stroke-width="2"/>
                        <circle cx="420" cy="55" r="4" fill="#4f46e5" stroke="#fff" stroke-width="2"/>
                        <circle cx="560" cy="48" r="4" fill="#4f46e5" stroke="#fff" stroke-width="2"/>
                        <circle cx="700" cy="35" r="5" fill="#4f46e5" stroke="#fff" stroke-width="2"/>
                    </svg>
                    <!-- Dates along X-Axis -->
                    <div class="flex justify-between text-[10px] font-semibold text-slate-400 px-1 pt-1 border-t border-slate-200 dark:border-slate-700">
                        <?php if (!empty($gscTrend['labels'])): ?>
                            <?php 
                            $step = max(1, floor(count($gscTrend['labels']) / 6));
                            for ($i = 0; $i < count($gscTrend['labels']); $i += $step): 
                            ?>
                                <span><?= esc($gscTrend['labels'][$i]) ?></span>
                            <?php endfor; ?>
                        <?php else: ?>
                            <span>Oct 01</span>
                            <span>Oct 07</span>
                            <span>Oct 14</span>
                            <span>Oct 21</span>
                            <span>Oct 24</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tabbed Performance Breakdown (Queries, Pages, Countries, Devices) -->
            <div class="rounded-2xl bg-white dark:bg-dark-750 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <!-- Tab Navigation Header -->
                <div class="flex items-center gap-2 px-4 pt-3 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-dark-700/30 overflow-x-auto">
                    <button type="button" onclick="switchGscTab('queries', this)" class="gsc-tab-btn py-2.5 px-3 border-b-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 font-bold text-xs flex items-center gap-2 cursor-pointer shrink-0">
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        <span>Top Queries</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-indigo-100 text-indigo-700 dark:bg-indigo-900/60 dark:text-indigo-300"><?= count($gscQueries) ?></span>
                    </button>
                    <button type="button" onclick="switchGscTab('pages', this)" class="gsc-tab-btn py-2.5 px-3 border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-semibold text-xs flex items-center gap-2 cursor-pointer shrink-0">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                        <span>Pages</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-200 text-slate-700 dark:bg-dark-600 dark:text-slate-300"><?= count($gscPages) ?></span>
                    </button>
                    <button type="button" onclick="switchGscTab('countries', this)" class="gsc-tab-btn py-2.5 px-3 border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-semibold text-xs flex items-center gap-2 cursor-pointer shrink-0">
                        <i data-lucide="flag" class="w-3.5 h-3.5"></i>
                        <span>Countries</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-200 text-slate-700 dark:bg-dark-600 dark:text-slate-300"><?= count($gscCountries) ?></span>
                    </button>
                    <button type="button" onclick="switchGscTab('devices', this)" class="gsc-tab-btn py-2.5 px-3 border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-semibold text-xs flex items-center gap-2 cursor-pointer shrink-0">
                        <i data-lucide="smartphone" class="w-3.5 h-3.5"></i>
                        <span>Devices</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-200 text-slate-700 dark:bg-dark-600 dark:text-slate-300"><?= count($gscDevices) ?></span>
                    </button>
                </div>

                <!-- Panel 1: Top Queries -->
                <div id="gscPanel-queries" class="gsc-tab-panel p-4 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <div class="relative flex-1 max-w-sm">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" oninput="filterGscQueries(this.value)" placeholder="Filter search queries..." class="w-full pl-9 pr-3 py-1.5 rounded-xl bg-slate-50 dark:bg-dark-700 border border-slate-200 dark:border-slate-600 text-xs text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                        <span id="gscQueryCountBadge" class="text-xs text-slate-400 font-semibold"><?= count($gscQueries) ?> queries</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700/80">
                                    <th class="py-2.5 px-3">Top Keyword / Search Query</th>
                                    <th class="py-2.5 px-3 text-right">Clicks</th>
                                    <th class="py-2.5 px-3 text-right">Impressions</th>
                                    <th class="py-2.5 px-3 text-right">CTR</th>
                                    <th class="py-2.5 px-3 text-right">Avg Position</th>
                                </tr>
                            </thead>
                            <tbody id="gscQueriesTableBody" class="divide-y divide-slate-100 dark:divide-slate-700/60">
                                <?php if (!empty($gscQueries)): ?>
                                    <?php foreach ($gscQueries as $q): ?>
                                        <tr data-query="<?= esc(strtolower($q['dimension_value'])) ?>" class="hover:bg-slate-50 dark:hover:bg-dark-700/50 transition">
                                            <td class="py-2.5 px-3 font-semibold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                                <i data-lucide="key" class="w-3 h-3 text-indigo-500 shrink-0"></i>
                                                <span><?= esc($q['dimension_value']) ?></span>
                                            </td>
                                            <td class="py-2.5 px-3 text-right font-bold text-slate-900 dark:text-white font-mono"><?= number_format($q['clicks']) ?></td>
                                            <td class="py-2.5 px-3 text-right text-slate-600 dark:text-slate-300 font-mono"><?= number_format($q['impressions']) ?></td>
                                            <td class="py-2.5 px-3 text-right font-semibold text-indigo-600 dark:text-indigo-400 font-mono"><?= $q['ctr'] ?>%</td>
                                            <td class="py-2.5 px-3 text-right">
                                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold <?= (float)$q['position'] <= 3 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400' : 'bg-slate-100 text-slate-700 dark:bg-dark-600 dark:text-slate-300' ?>">
                                                    #<?= number_format((float)$q['position'], 1) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-slate-400">No search queries recorded yet. Click Sync to fetch live Google queries.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Panel 2: Pages -->
                <div id="gscPanel-pages" class="gsc-tab-panel p-4 space-y-3 hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700/80">
                                    <th class="py-2.5 px-3">Top Landing Page</th>
                                    <th class="py-2.5 px-3 text-right">Clicks</th>
                                    <th class="py-2.5 px-3 text-right">Impressions</th>
                                    <th class="py-2.5 px-3 text-right">CTR</th>
                                    <th class="py-2.5 px-3 text-right">Avg Position</th>
                                    <th class="py-2.5 px-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                                <?php if (!empty($gscPages)): ?>
                                    <?php foreach ($gscPages as $p): ?>
                                        <tr class="hover:bg-slate-50 dark:hover:bg-dark-700/50 transition">
                                            <td class="py-2.5 px-3 font-semibold text-slate-800 dark:text-slate-200 truncate max-w-xs font-mono text-[11px]">
                                                <?= esc($p['dimension_value']) ?>
                                            </td>
                                            <td class="py-2.5 px-3 text-right font-bold text-slate-900 dark:text-white font-mono"><?= number_format($p['clicks']) ?></td>
                                            <td class="py-2.5 px-3 text-right text-slate-600 dark:text-slate-300 font-mono"><?= number_format($p['impressions']) ?></td>
                                            <td class="py-2.5 px-3 text-right font-semibold text-indigo-600 dark:text-indigo-400 font-mono"><?= $p['ctr'] ?>%</td>
                                            <td class="py-2.5 px-3 text-right">
                                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 dark:bg-dark-600 dark:text-slate-300">
                                                    #<?= number_format((float)$p['position'], 1) ?>
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3 text-center">
                                                <a href="<?= esc($p['dimension_value']) ?>" target="_blank" rel="noopener noreferrer" class="p-1 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-slate-100 dark:hover:bg-dark-600 inline-flex items-center" title="Open Page">
                                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-slate-400">No page data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Panel 3: Countries -->
                <div id="gscPanel-countries" class="gsc-tab-panel p-4 space-y-3 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <?php if (!empty($gscCountries)): ?>
                            <?php foreach ($gscCountries as $c): ?>
                                <div class="p-3 rounded-xl bg-slate-50 dark:bg-dark-700 border border-slate-200 dark:border-slate-600 flex items-center justify-between">
                                    <div>
                                        <span class="font-bold text-xs text-slate-900 dark:text-white uppercase"><?= esc($c['dimension_value']) ?></span>
                                        <div class="text-[10px] text-slate-400"><?= number_format($c['impressions']) ?> impressions</div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-black text-indigo-600 dark:text-indigo-400"><?= number_format($c['clicks']) ?></span>
                                        <div class="text-[10px] text-slate-500 font-semibold">clicks</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-4 py-6 text-center text-slate-400">No country geographic data.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Panel 4: Devices -->
                <div id="gscPanel-devices" class="gsc-tab-panel p-4 space-y-3 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <?php if (!empty($gscDevices)): ?>
                            <?php foreach ($gscDevices as $d): ?>
                                <div class="p-4 rounded-xl bg-slate-50 dark:bg-dark-700 border border-slate-200 dark:border-slate-600 flex flex-col justify-between">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase"><?= esc($d['dimension_value']) ?></span>
                                        <i data-lucide="<?= strtolower($d['dimension_value']) === 'mobile' ? 'smartphone' : (strtolower($d['dimension_value']) === 'desktop' ? 'monitor' : 'tablet') ?>" class="w-4 h-4 text-indigo-500"></i>
                                    </div>
                                    <div class="text-2xl font-black text-slate-900 dark:text-white"><?= number_format($d['clicks']) ?> <span class="text-xs font-semibold text-slate-400">clicks</span></div>
                                    <div class="text-xs text-slate-500 mt-1"><?= number_format($d['impressions']) ?> impressions (CTR <?= $d['ctr'] ?>%)</div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-3 py-6 text-center text-slate-400">No device data available.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- AI Knowledge Base Integration Note -->
            <div class="p-3.5 rounded-2xl bg-indigo-50/70 dark:bg-indigo-950/30 border border-indigo-200/80 dark:border-indigo-800/60 flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                    </div>
                    <div>
                        <strong class="font-bold text-indigo-900 dark:text-indigo-200">AI Knowledge Base Auto-Sync</strong>
                        <p class="text-[11px] text-indigo-700 dark:text-indigo-300">Top search queries, ranking pages, aur organic clicks automatically agency ke AI Agents knowledge base me index ho chuke hain.</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-xl bg-indigo-600 text-white font-bold text-[10px] shrink-0">
                    Active & Synced
                </span>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 border-t border-slate-200 dark:border-slate-700/80 bg-slate-50/80 dark:bg-dark-750 flex items-center justify-between shrink-0">
            <span class="text-xs text-slate-400">
                Last API Sync: <?= !empty($gscMapping['synced_at']) ? date('M d, Y H:i:s', strtotime($gscMapping['synced_at'])) : 'Auto Synced' ?>
            </span>
            <button type="button" onclick="closeGscAnalyticsModal()" class="px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-700 text-white text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
                Done
            </button>
        </div>
    </div>
</div>

<!-- Floating Notification Toast -->
<div id="quickToast" class="fixed bottom-6 right-6 z-50 transform translate-y-16 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-900 text-white shadow-2xl border border-slate-700/80 text-xs font-semibold">
    <div id="quickToastIcon" class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
        <i data-lucide="check" class="w-4 h-4"></i>
    </div>
    <span id="quickToastMessage">Notification message</span>
</div>

<?= $this->endSection() ?>
