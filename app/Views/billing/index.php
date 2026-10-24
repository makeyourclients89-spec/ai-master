<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-2.5">
            <i data-lucide="credit-card" class="w-6 h-6 text-indigo-400"></i> Plan & Usage
        </h1>
        <p class="text-xs text-slate-400 mt-1">Tenant quotas, AI token reservations, and plan subscription parameters.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Panel 1: Subscription -->
        <div class="glass-panel p-6 rounded-2xl space-y-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">SUBSCRIPTION TIER</span>
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Agency Pro (Phase 8)</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Enterprise CodeIgniter 4 Workspace Edition</p>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    Active Plan
                </span>
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-3 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Max Active Projects:</span>
                    <span class="font-bold text-white">Unlimited</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Team Seats:</span>
                    <span class="font-bold text-white">25 Included</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Database Driver:</span>
                    <span class="font-mono text-emerald-400">SQLite3 (Zero Latency)</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Direct Auth:</span>
                    <span class="font-bold text-emerald-400">Instant (No Email Lag)</span>
                </div>
            </div>
        </div>

        <!-- Panel 2: AI Quota -->
        <div class="glass-panel p-6 rounded-2xl space-y-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-400 block mb-1">AI USAGE & LIMITS</span>
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white">Token Allotment</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Automated prompt and agent invocations</p>
                </div>
                <span class="font-mono text-xs text-indigo-300 font-bold">10M / Month</span>
            </div>

            <div class="w-full bg-dark-600 rounded-full h-2.5 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-full rounded-full" style="width: 28%"></div>
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-3 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Reserved Tokens:</span>
                    <span class="font-mono font-bold text-white">284,500</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">Settled Usage:</span>
                    <span class="font-mono font-bold text-slate-300">142,100</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400">AI Safety Limits:</span>
                    <span class="text-emerald-400 font-semibold">Strict Tenant Isolation</span>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
