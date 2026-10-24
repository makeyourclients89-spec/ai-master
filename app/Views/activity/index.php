<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-2.5">
            <i data-lucide="activity" class="w-6 h-6 text-emerald-400"></i> Workspace Activity Log
        </h1>
        <p class="text-xs text-slate-400 mt-1">Immutable audit stream recording project creation, task completions, and security changes.</p>
    </div>

    <!-- Activity Timeline -->
    <div class="glass-panel p-6 rounded-2xl space-y-4">
        <?php if (empty($activities)): ?>
            <p class="text-xs text-slate-500 text-center py-6">No workspace activities recorded yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($activities as $act): ?>
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-dark-600/40 border border-slate-700/40 hover:border-slate-600 transition text-xs">
                        <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-slate-200 font-semibold leading-relaxed">
                                <strong class="text-white"><?= esc($act['user_name']) ?></strong> <?= esc($act['action']) ?>
                            </p>
                            <?php if ($act['target']): ?>
                                <span class="text-[11px] font-mono text-indigo-300"><?= esc($act['target']) ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="text-[11px] text-slate-500 font-mono shrink-0">
                            <?= esc(date('M d, Y · H:i', strtotime($act['created_at']))) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>
