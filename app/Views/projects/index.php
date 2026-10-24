<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header & Action Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <i data-lucide="folder-kanban" class="w-6 h-6 text-indigo-600 dark:text-indigo-400"></i> Projects
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold"><?= count($projects) ?></span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Manage active workspace campaigns and portable ZIP archives.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search & Filter Form -->
            <form action="<?= site_url('projects') ?>" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="status" value="<?= esc($status ?? 'active') ?>">
                <div class="relative">
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Search projects..." class="pl-9 pr-3 py-1.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-600 w-44 sm:w-56 transition shadow-sm">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-2.5"></i>
                </div>
            </form>

            <button onclick="document.getElementById('modalCreateProject').classList.remove('hidden')" class="px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-xs transition shadow-md shadow-indigo-600/25 flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i> New Project
            </button>
        </div>
    </div>

    <!-- Navigation Tabs (Active, Zipped / Trash, Archived) -->
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2 overflow-x-auto text-xs font-semibold">
        <a href="<?= site_url('projects?status=active') ?>" class="px-3.5 py-2 rounded-xl flex items-center gap-2 transition <?= ($status === 'active' || empty($status)) ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900' ?>">
            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
            <span>Active Projects</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] <?= ($status === 'active' || empty($status)) ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-dark-500 text-slate-700 dark:text-slate-300' ?>">
                <?= $counts['active'] ?? 0 ?>
            </span>
        </a>

        <!-- Zipped Archives Tab (Delete hone ke baad yahan zip me show hoga) -->
        <a href="<?= site_url('projects?status=deleted') ?>" class="px-3.5 py-2 rounded-xl flex items-center gap-2 transition <?= ($status === 'deleted') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900' ?>">
            <i data-lucide="package" class="w-3.5 h-3.5"></i>
            <span>Zipped Archives / Trash</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] <?= ($status === 'deleted') ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300' ?>">
                <?= $counts['deleted'] ?? 0 ?>
            </span>
        </a>

        <a href="<?= site_url('projects?status=archived') ?>" class="px-3.5 py-2 rounded-xl flex items-center gap-2 transition <?= ($status === 'archived') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900' ?>">
            <i data-lucide="archive" class="w-3.5 h-3.5"></i>
            <span>Archived</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] <?= ($status === 'archived') ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-dark-500 text-slate-700 dark:text-slate-300' ?>">
                <?= $counts['archived'] ?? 0 ?>
            </span>
        </a>
    </div>

    <!-- Zipped Archives Notice Banner (When viewing deleted/zipped status) -->
    <?php if ($status === 'deleted'): ?>
        <div class="p-4 rounded-2xl bg-amber-50/80 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/40 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-700 dark:text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                    <i data-lucide="package-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white">Zipped Project Backups & Archives</h4>
                    <p class="text-slate-600 dark:text-slate-300 mt-0.5 leading-relaxed">
                        Delete kiye gaye projects automatically secure portable <strong>.ZIP</strong> backup me convert ho jate hain. Aap kisi bhi project ko <strong>Download ZIP</strong> kar sakte hain ya <strong>Restore</strong> dabakar wapas live kar sakte hain.
                    </p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-lg bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 font-mono text-[11px] font-semibold whitespace-nowrap">
                ZIP Engine Active
            </span>
        </div>
    <?php endif; ?>

    <!-- Projects Grid -->
    <?php if (empty($projects)): ?>
        <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 p-12 rounded-2xl text-center space-y-4 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto">
                <i data-lucide="<?= $status === 'deleted' ? 'package-open' : 'folder-search' ?>" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">
                    <?= $status === 'deleted' ? 'No Zipped Archives Found' : 'No matching projects found' ?>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1">
                    <?= $status === 'deleted' 
                        ? 'Trash me koi project nahi hai. Jab aap koi project delete karenge, wo automatic yahan ZIP format me aakar store ho jayega.' 
                        : 'Try resetting your search query or create a new project to get started.' ?>
                </p>
            </div>
            <?php if ($status === 'deleted'): ?>
                <a href="<?= site_url('projects') ?>" class="inline-block px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold shadow-sm hover:bg-indigo-700 transition">
                    View Active Projects
                </a>
            <?php else: ?>
                <a href="<?= site_url('projects') ?>" class="inline-block px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                    Reset Filter
                </a>
            <?php endif; ?>
        </div>

    <?php elseif ($status === 'deleted'): ?>
        <!-- ZIPPED ARCHIVES / TRASH CARDS VIEW -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($projects as $project): ?>
                <div class="bg-white dark:bg-dark-700/80 border border-amber-200 dark:border-amber-900/40 p-5 rounded-2xl flex flex-col justify-between shadow-sm hover:border-amber-400 transition group relative overflow-hidden">
                    <div class="space-y-3.5">
                        <!-- Top Metadata -->
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
                                <i data-lucide="package" class="w-3 h-3"></i> ZIPPED BACKUP
                            </span>

                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20">
                                Deleted
                            </span>
                        </div>

                        <!-- Title & Brief -->
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white"><?= esc($project['name']) ?></h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                                <?= esc($project['objective'] ?: 'No objective specified.') ?>
                            </p>
                        </div>

                        <!-- ZIP File Meta Card -->
                        <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-dark-600/70 border border-slate-200/80 dark:border-slate-700 text-xs flex items-center justify-between">
                            <span class="text-slate-500 text-[11px] flex items-center gap-1.5 truncate">
                                <i data-lucide="file-archive" class="w-3.5 h-3.5 text-amber-500 shrink-0"></i>
                                <span class="font-mono text-indigo-600 dark:text-indigo-400 truncate max-w-[150px]"><?= esc($project['zip_file'] ?? 'project_backup.zip') ?></span>
                            </span>
                            <span class="text-slate-400 text-[11px] shrink-0 font-medium">
                                <?= !empty($project['deleted_at']) ? esc(date('M d, Y', strtotime($project['deleted_at']))) : 'Recently' ?>
                            </span>
                        </div>
                    </div>

                    <!-- Actions Bar (Download ZIP, Restore, Permanent Delete) -->
                    <div class="pt-3.5 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                        <!-- Download ZIP Button -->
                        <a href="<?= site_url('projects/' . $project['id'] . '/download-zip') ?>" class="px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:hover:bg-amber-500/30 dark:text-amber-300 font-semibold text-xs transition flex items-center gap-1.5 border border-amber-200/80 dark:border-amber-500/30 shadow-sm" title="Download portable ZIP archive">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            <span>Download ZIP</span>
                        </a>

                        <div class="flex items-center gap-1.5">
                            <!-- Restore Button (jab chahein restore kar payein) -->
                            <a href="<?= site_url('projects/' . $project['id'] . '/restore') ?>" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition flex items-center gap-1 shadow-sm" title="Restore project back to active list">
                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                <span>Restore</span>
                            </a>

                            <!-- Permanent Delete Button -->
                            <button onclick="confirmPermanentDelete(<?= $project['id'] ?>, '<?= esc(addslashes($project['name'])) ?>')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 border border-slate-200 dark:border-slate-700 transition cursor-pointer" title="Delete permanently">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <!-- NORMAL PROJECTS GRID (Active, Archived, All) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($projects as $project): ?>
                <div class="bg-white dark:bg-dark-700/80 border border-slate-200/90 dark:border-slate-800 p-5 rounded-2xl flex flex-col justify-between hover:border-indigo-300 dark:hover:border-indigo-500/40 hover:shadow-md transition duration-200 group">
                    <div class="space-y-3.5">
                        <div class="flex items-center justify-between gap-2">
                            <?= render_department_badges($project['department'] ?? 'Website') ?>

                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase <?= $project['status'] === 'active' ? 'bg-emerald-50 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400' ?>">
                                    <?= esc($project['status']) ?>
                                </span>
                            </div>
                        </div>

                        <div>
                            <a href="<?= project_url($project) ?>" class="block">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-snug"><?= esc($project['name']) ?></h3>
                            </a>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed"><?= esc($project['objective'] ?: 'No objective specified.') ?></p>
                        </div>
                    </div>

                    <div class="pt-3.5 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400 dark:text-slate-500 flex items-center gap-1 font-medium">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            <?= !empty($project['updated_at']) ? esc(date('M d, Y', strtotime($project['updated_at']))) : 'Recently' ?>
                        </span>

                        <div class="flex items-center gap-2">
                            <!-- Open Project Button -->
                            <a href="<?= project_url($project) ?>" class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition flex items-center gap-1.5 shadow-sm shadow-indigo-600/20">
                                <span>Open Project</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>

                            <!-- Delete Project & Convert to ZIP Button -->
                            <button onclick="confirmDelete(<?= $project['id'] ?>, '<?= esc(addslashes($project['name'])) ?>')" title="Delete project & create portable ZIP archive" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 border border-slate-200 dark:border-slate-700 transition cursor-pointer">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<!-- Modal 1: Delete & Create ZIP Confirmation Modal -->
<div id="modalDeleteProject" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 space-y-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <i data-lucide="package-search" class="w-5 h-5"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete Project & Create ZIP?</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                    Aap project <strong id="deleteTargetName" class="text-slate-900 dark:text-white font-semibold"></strong> ko delete karne ja rahe hain.
                </p>
            </div>
        </div>

        <div class="p-3 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-300 space-y-1">
            <div class="flex items-center gap-1.5 font-medium text-amber-700 dark:text-amber-400">
                <i data-lucide="info" class="w-4 h-4"></i>
                <span>Automatic ZIP Backup Feature:</span>
            </div>
            <p class="text-[11px] leading-relaxed pl-5">
                Delete karne ke baad is project ka complete brief, tasks aur connectors ka <strong>.ZIP file</strong> create ho jayega jo <strong>"Zipped Archives"</strong> me save rahega. Aap ise jab chahein <strong>Restore</strong> kar sakte hain.
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
            <button type="button" onclick="document.getElementById('modalDeleteProject').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                Cancel
            </button>
            <a id="btnConfirmDelete" href="#" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="archive" class="w-3.5 h-3.5"></i>
                <span>Confirm & Create ZIP</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal 2: Permanent Delete Confirmation Modal -->
<div id="modalPermanentDelete" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 space-y-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Delete Permanently?</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                    Aap project <strong id="permanentTargetName" class="text-slate-900 dark:text-white font-semibold"></strong> aur uske ZIP backup ko hamesha ke liye delete karne ja rahe hain. Yeh action undo nahi kiya ja sakta.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
            <button type="button" onclick="document.getElementById('modalPermanentDelete').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                Cancel
            </button>
            <a id="btnConfirmPermanent" href="#" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                <span>Permanently Delete</span>
            </a>
        </div>
    </div>
</div>

<script>
    function confirmDelete(projectId, projectName) {
        document.getElementById('deleteTargetName').textContent = projectName;
        document.getElementById('btnConfirmDelete').href = '<?= site_url('projects/') ?>' + projectId + '/delete';
        document.getElementById('modalDeleteProject').classList.remove('hidden');
    }

    function confirmPermanentDelete(projectId, projectName) {
        document.getElementById('permanentTargetName').textContent = projectName;
        document.getElementById('btnConfirmPermanent').href = '<?= site_url('projects/') ?>' + projectId + '/destroy';
        document.getElementById('modalPermanentDelete').classList.remove('hidden');
    }
</script>

<?= $this->endSection() ?>
