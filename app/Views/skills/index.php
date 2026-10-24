<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Top Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-1">
                <span>Global Agency Playbooks</span>
                <span>•</span>
                <span class="text-slate-500">Active Across All Projects</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2.5">
                <i data-lucide="sparkles" class="w-7 h-7 text-indigo-600 dark:text-indigo-400"></i>
                <span>Agency Skills & SOPs Library</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1 max-w-3xl">
                100% researched, production-ready execution frameworks stored as structured files in <code class="font-mono text-indigo-600 dark:text-indigo-400 font-bold">skills/{category}/</code>. Ye saare skills har project me automatically inherit hote hain.
            </p>
        </div>

        <!-- Create Skill Button -->
        <div class="flex items-center gap-2">
            <button onclick="document.getElementById('modalCreateSkill').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold flex items-center gap-2 transition shadow-md shadow-indigo-600/30 cursor-pointer">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Create Agency Skill</span>
            </button>
        </div>
    </div>

    <!-- Category Filter Tabs & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <!-- Categories -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold">
            <a href="<?= site_url('skills/?category=all' . ($search ? '&q=' . urlencode($search) : '')) ?>" class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 <?= $category === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50' ?>">
                <span>All Skills</span>
                <span class="px-1.5 py-0.5 rounded-full text-[10px] <?= $category === 'all' ? 'bg-indigo-700 text-white' : 'bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300' ?>"><?= $counts['all'] ?? 0 ?></span>
            </a>
            <a href="<?= site_url('skills/?category=seo' . ($search ? '&q=' . urlencode($search) : '')) ?>" class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 <?= $category === 'seo' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50' ?>">
                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                <span>SEO Skills</span>
                <span class="px-1.5 py-0.5 rounded-full text-[10px] <?= $category === 'seo' ? 'bg-indigo-700 text-white' : 'bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300' ?>"><?= $counts['seo'] ?? 0 ?></span>
            </a>
            <a href="<?= site_url('skills/?category=smo' . ($search ? '&q=' . urlencode($search) : '')) ?>" class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 <?= $category === 'smo' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50' ?>">
                <i data-lucide="share-2" class="w-3.5 h-3.5"></i>
                <span>SMO Skills</span>
                <span class="px-1.5 py-0.5 rounded-full text-[10px] <?= $category === 'smo' ? 'bg-indigo-700 text-white' : 'bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300' ?>"><?= $counts['smo'] ?? 0 ?></span>
            </a>
            <a href="<?= site_url('skills/?category=ppc' . ($search ? '&q=' . urlencode($search) : '')) ?>" class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5 <?= $category === 'ppc' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-50' ?>">
                <i data-lucide="target" class="w-3.5 h-3.5"></i>
                <span>PPC & Ads</span>
                <span class="px-1.5 py-0.5 rounded-full text-[10px] <?= $category === 'ppc' ? 'bg-indigo-700 text-white' : 'bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300' ?>"><?= $counts['ppc'] ?? 0 ?></span>
            </a>
        </div>

        <!-- Search Form -->
        <form action="<?= site_url('skills/') ?>" method="GET" class="relative sm:w-64">
            <input type="hidden" name="category" value="<?= esc($category) ?>">
            <i data-lucide="search" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="q" value="<?= esc($search) ?>" placeholder="Search skills, checklists..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 shadow-xs">
        </form>
    </div>

    <!-- Skills Grid (Clean, Crisp Layout) -->
    <?php if (empty($skills)): ?>
        <div class="p-12 text-center rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700/60 bg-white dark:bg-dark-700/40 space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto">
                <i data-lucide="sparkles" class="w-6 h-6"></i>
            </div>
            <div>
                <h4 class="text-base font-bold text-slate-900 dark:text-white">Koi Skill Nahi Mili</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Aapke filter ke mutabik koi skill nahi hai. "Create Agency Skill" par click karke nayi skill banayein.</p>
            </div>
            <button onclick="document.getElementById('modalCreateSkill').classList.remove('hidden')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition cursor-pointer">
                Create First Skill
            </button>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($skills as $s): 
                $cat = strtolower($s['category']);
                $badgeCls = 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-300 dark:border-indigo-500/20';
                if ($cat === 'seo') $badgeCls = 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-300 dark:border-blue-500/20';
                elseif ($cat === 'smo') $badgeCls = 'bg-pink-50 text-pink-700 border-pink-200 dark:bg-pink-500/10 dark:text-pink-300 dark:border-pink-500/20';
                elseif ($cat === 'ppc') $badgeCls = 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/20';
                
                $accuracy = $s['accuracy'] ?? '99.4%';
                $time = $s['estimated_time'] ?? '15-30 Mins';
            ?>
                <div class="p-5 rounded-2xl bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 flex flex-col justify-between space-y-4 shadow-xs hover:border-indigo-400 dark:hover:border-indigo-500/60 hover:shadow-md transition group">
                    <div class="space-y-3">
                        
                        <!-- Top Metadata: Category, Accuracy, Time & Scope -->
                        <div class="flex items-center justify-between gap-1.5 flex-wrap">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border <?= $badgeCls ?>">
                                <?= esc(strtoupper($s['category'])) ?>
                            </span>

                            <div class="flex items-center gap-1.5">
                                <!-- Accuracy Badge -->
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 flex items-center gap-1" title="Tested Accuracy / Success Rate">
                                    <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500"></i>
                                    <span><?= esc($accuracy) ?> Accuracy</span>
                                </span>

                                <!-- Scope Badge -->
                                <?php if ($s['is_global']): ?>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">
                                        Global
                                    </span>
                                <?php else: ?>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20">
                                        Custom
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Title & Folder Path -->
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition leading-snug">
                                <?= esc($s['name']) ?>
                            </h3>
                            <div class="flex items-center gap-1 text-[11px] font-mono text-slate-500 dark:text-slate-400 mt-1 truncate" title="<?= esc($s['folder_path']) ?>">
                                <i data-lucide="folder" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                <span class="truncate"><?= esc($s['folder_path']) ?></span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3">
                            <?= esc($s['description'] ?: 'Complete framework and execution checklist ready to deploy.') ?>
                        </p>

                        <!-- Highlights Bar: Execution Time & Level -->
                        <div class="pt-2 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 border-t border-slate-100 dark:border-slate-800/80">
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3 text-indigo-500"></i>
                                <span>Est. Time: <strong class="text-slate-700 dark:text-slate-200"><?= esc($time) ?></strong></span>
                            </span>
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-mono uppercase bg-slate-100 dark:bg-dark-600 text-slate-600 dark:text-slate-300 font-semibold border border-slate-200 dark:border-slate-700">
                                <?= esc($s['level']) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Actions Row (View SOP, Copy, Edit, Delete) -->
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                        <button onclick="viewSkillDetails(<?= $s['id'] ?>)" class="px-3.5 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-500/20 dark:hover:bg-indigo-500/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer">
                            <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                            <span>View SOP & Details</span>
                        </button>

                        <div class="flex items-center gap-1">
                            <!-- Quick Copy SOP Button -->
                            <button onclick="copySkillDirect(<?= $s['id'] ?>, this)" class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-dark-600 transition cursor-pointer" title="Copy Full SOP to Clipboard">
                                <i data-lucide="copy" class="w-4 h-4"></i>
                            </button>

                            <!-- Edit Button -->
                            <button onclick="openEditSkill(<?= $s['id'] ?>)" class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-dark-600 transition cursor-pointer" title="Edit Skill & SOP">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>

                            <!-- Delete Button -->
                            <a href="<?= site_url('skills/delete/' . $s['id']) ?>" onclick="return confirm('Kya aap \'<?= esc(addslashes($s['name'])) ?>\' skill aur uski physical .md file ko delete karna chahte hain?')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-dark-600 transition cursor-pointer" title="Delete Skill">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<!-- ======================================================== -->
<!-- MODAL: VIEW FULL SKILL FRAMEWORK, INPUTS, EXAMPLE & COPY -->
<!-- ======================================================== -->
<div id="modalViewSkill" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
    <div class="w-full max-w-4xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[92vh] flex flex-col">
        
        <!-- Header -->
        <div class="flex items-start justify-between pb-4 border-b border-slate-100 dark:border-slate-800 shrink-0 gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                    <span id="viewSkillCategory" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">SEO</span>
                    <span id="viewSkillAccuracy" class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500"></i>
                        <span id="viewSkillAccuracyText">99.4% Accuracy</span>
                    </span>
                    <span id="viewSkillTime" class="px-2 py-0.5 rounded text-[10px] font-mono text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3 text-indigo-500"></i>
                        <span id="viewSkillTimeText">15-30 Mins</span>
                    </span>
                    <span id="viewSkillPath" class="text-xs font-mono text-slate-500 dark:text-slate-400 flex items-center gap-1">
                        <i data-lucide="file-code" class="w-3.5 h-3.5 text-indigo-500"></i>
                        <span>skills/seo/example.md</span>
                    </span>
                </div>
                <h3 id="viewSkillTitle" class="text-xl font-extrabold text-slate-900 dark:text-white">Skill Name</h3>
            </div>
            
            <div class="flex items-center gap-2 shrink-0">
                <!-- Copy Button in Modal -->
                <button id="viewSkillCopyBtn" onclick="copyCurrentViewingSkill(this)" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold flex items-center gap-1.5 transition shadow-sm cursor-pointer">
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    <span id="viewSkillCopyBtnText">Copy Full SOP</span>
                </button>

                <!-- Edit Button -->
                <button id="viewSkillEditBtn" onclick="" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-dark-500 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    <span>Edit</span>
                </button>

                <!-- Close Button -->
                <button onclick="document.getElementById('modalViewSkill').classList.add('hidden')" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Scrollable Content Body (Inputs, Example, & Full SOP) -->
        <div class="flex-1 overflow-y-auto py-5 pr-2 space-y-4">
            
            <!-- Box 1: Required Inputs (Input Kya Dena Hoga) -->
            <div id="viewSkillInputsBox" class="p-4 rounded-2xl bg-indigo-50/70 dark:bg-dark-600/60 border border-indigo-100 dark:border-indigo-500/20 space-y-2">
                <div class="flex items-center gap-2 text-indigo-900 dark:text-indigo-200 font-bold text-xs uppercase tracking-wider">
                    <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                    </div>
                    <span>Is Skill Ke Liye Kya Input Dena Hoga (Required Inputs):</span>
                </div>
                <div id="viewSkillInputsText" class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed pl-8 font-medium">
                    <!-- Populated by JS -->
                </div>
            </div>

            <!-- Box 2: Execution Example & Expected Result -->
            <div id="viewSkillExampleBox" class="p-4 rounded-2xl bg-emerald-50/70 dark:bg-dark-600/60 border border-emerald-100 dark:border-emerald-500/20 space-y-2">
                <div class="flex items-center gap-2 text-emerald-900 dark:text-emerald-200 font-bold text-xs uppercase tracking-wider">
                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center">
                        <i data-lucide="lightbulb" class="w-3.5 h-3.5"></i>
                    </div>
                    <span>Real-World Example & Expected Result (Execution Idea):</span>
                </div>
                <div id="viewSkillExampleText" class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed pl-8 font-medium">
                    <!-- Populated by JS -->
                </div>
            </div>

            <!-- Box 3: Full SOP Markdown Section -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                        <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i>
                        <span>Full SOP Playbook & Technical Documentation:</span>
                    </h4>
                    <button onclick="copySkillTextOnly()" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1 font-semibold cursor-pointer">
                        <i data-lucide="copy" class="w-3 h-3"></i> Copy Playbook Text
                    </button>
                </div>
                <div id="viewSkillContent" class="prose prose-slate dark:prose-invert max-w-none text-xs sm:text-sm leading-relaxed whitespace-pre-wrap font-sans bg-slate-50 dark:bg-dark-600/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/60 font-normal">
                    Loading skill framework...
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between shrink-0">
            <span class="text-xs text-slate-500 dark:text-slate-400">File location: Stored directly on disk under <strong class="text-slate-700 dark:text-slate-200">/skills/</strong> directory.</span>
            <div class="flex items-center gap-2">
                <button onclick="document.getElementById('modalViewSkill').classList.add('hidden')" class="px-5 py-2 rounded-xl bg-slate-100 dark:bg-dark-600 hover:bg-slate-200 dark:hover:bg-dark-500 text-slate-800 dark:text-slate-200 text-xs font-semibold transition cursor-pointer">
                    Close Playbook
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: CREATE GLOBAL AGENCY SKILL          -->
<!-- ========================================== -->
<div id="modalCreateSkill" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-3xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    Create New Agency Skill
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Ye skill save hote hi automatically <code class="font-mono text-indigo-500">skills/{category}/</code> folder me .md file banegi aur har project me inherit hogi.</p>
            </div>
            <button onclick="document.getElementById('modalCreateSkill').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= site_url('skills/create') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Skill Name / Title</label>
                <input type="text" name="name" required placeholder="e.g. Core Web Vitals LCP Optimization Framework" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Category Folder</label>
                    <select name="category" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="seo">skills/seo/ (Search Engine Optimization)</option>
                        <option value="smo">skills/smo/ (Social Media Optimization)</option>
                        <option value="ppc">skills/ppc/ (Google Ads & PPC)</option>
                        <option value="meta_ads">skills/meta_ads/ (Meta & Social Ads)</option>
                        <option value="website">skills/website/ (Web Development & CRO)</option>
                        <option value="aeo_geo">skills/aeo_geo/ (AI Search & Citations)</option>
                        <option value="custom">skills/custom/ (Custom Framework)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Accuracy Rate</label>
                    <input type="text" name="accuracy" value="99.4%" placeholder="e.g. 99.4%" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Est. Time</label>
                    <input type="text" name="estimated_time" value="20-30 Mins" placeholder="e.g. 20-30 Mins" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Difficulty Level</label>
                    <select name="level" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="advanced" selected>Advanced</option>
                        <option value="elite">Elite / Enterprise</option>
                        <option value="intermediate">Intermediate</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Short Summary / Objective</label>
                    <input type="text" name="description" placeholder="Brief 1-line description of what this skill achieves" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <!-- Required Inputs Field -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                        Is Skill Ko Execute Karne Ke Liye Kya Input Dena Hoga? (Required Inputs)
                    </span>
                    <span class="text-[10px] text-slate-400 normal-case font-normal">(URLs, Logins, CSVs, Keywords, etc.)</span>
                </label>
                <textarea name="inputs_required" rows="3" placeholder="1. Target Website URL (e.g. https://domain.com)&#10;2. Target Keywords List / CSV&#10;3. Google Search Console or Hosting Access&#10;4. Competitor URLs (2-3)" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition leading-relaxed"></textarea>
            </div>

            <!-- Example Scenario Field -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                        <i data-lucide="lightbulb" class="w-3.5 h-3.5"></i>
                        Real-World Example & Expected Result (Idea Kya Hoga)
                    </span>
                    <span class="text-[10px] text-slate-400 normal-case font-normal">(Sample Input -> Execution -> Result)</span>
                </label>
                <textarea name="example_scenario" rows="3" placeholder="INPUT: Client store has 4.8s LCP, slow TTFB, 340 redirect chains.&#10;&#10;EXECUTION & OUTPUT: Preload hero WebP, clean .htaccess redirects, build XML sitemap.&#10;RESULT: LCP drops to 1.7s (Passes Core Web Vitals)." class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition leading-relaxed"></textarea>
            </div>

            <!-- Full SOP Markdown -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Skill Playbook & Execution Instructions (Markdown)</label>
                <textarea name="content" rows="6" placeholder="# Skill Title&#10;&#10;## 1. Step-by-Step Execution&#10;Write detailed instructions, checklists, and code snippets..." class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalCreateSkill').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Save & Create File</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: EDIT AGENCY SKILL                   -->
<!-- ========================================== -->
<div id="modalEditSkill" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-3xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    <span>Edit Skill & SOP Playbook</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Changes save hone par disk par physical .md file aur database dono update ho jayenge.</p>
            </div>
            <button onclick="document.getElementById('modalEditSkill').classList.add('hidden')" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formEditSkill" action="" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Skill Name / Title</label>
                <input type="text" id="editSkillName" name="name" required class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Category Folder</label>
                    <select id="editSkillCategory" name="category" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="seo">skills/seo/ (Search Engine Optimization)</option>
                        <option value="smo">skills/smo/ (Social Media Optimization)</option>
                        <option value="ppc">skills/ppc/ (Google Ads & PPC)</option>
                        <option value="meta_ads">skills/meta_ads/ (Meta & Social Ads)</option>
                        <option value="website">skills/website/ (Web Development & CRO)</option>
                        <option value="aeo_geo">skills/aeo_geo/ (AI Search & Citations)</option>
                        <option value="custom">skills/custom/ (Custom Framework)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Accuracy Rate</label>
                    <input type="text" id="editSkillAccuracy" name="accuracy" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Est. Time</label>
                    <input type="text" id="editSkillTime" name="estimated_time" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Difficulty Level</label>
                    <select id="editSkillLevel" name="level" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs">
                        <option value="advanced">Advanced</option>
                        <option value="elite">Elite / Enterprise</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="custom">Project Custom</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Brief Summary / Objective</label>
                    <input type="text" id="editSkillDescription" name="description" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <!-- Required Inputs Field -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400">
                        <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                        Is Skill Ke Liye Kya Input Dena Hoga? (Required Inputs)
                    </span>
                    <span class="text-[10px] text-slate-400 normal-case font-normal">(URLs, Logins, CSVs, Keywords, etc.)</span>
                </label>
                <textarea id="editSkillInputs" name="inputs_required" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition leading-relaxed"></textarea>
            </div>

            <!-- Example Scenario Field -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                        <i data-lucide="lightbulb" class="w-3.5 h-3.5"></i>
                        Real-World Example & Expected Result (Execution Idea)
                    </span>
                    <span class="text-[10px] text-slate-400 normal-case font-normal">(Sample Input -> Execution -> Result)</span>
                </label>
                <textarea id="editSkillExample" name="example_scenario" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-500 transition leading-relaxed"></textarea>
            </div>

            <!-- Markdown Content -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Skill Playbook & Execution Instructions (Markdown)</label>
                <textarea id="editSkillContent" name="content" rows="7" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalEditSkill').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">Update Skill & File</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast notification for copy -->
<div id="copyToast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 flex items-center gap-2.5 px-4 py-3 rounded-2xl bg-slate-900 text-white text-xs font-semibold shadow-xl border border-slate-700">
    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
    <span id="copyToastMsg">SOP copied to clipboard!</span>
</div>

<script>
let currentViewingSkill = null;

function viewSkillDetails(skillId) {
    const modal = document.getElementById('modalViewSkill');
    const titleEl = document.getElementById('viewSkillTitle');
    const catEl = document.getElementById('viewSkillCategory');
    const pathEl = document.getElementById('viewSkillPath');
    const contentEl = document.getElementById('viewSkillContent');
    const inputsText = document.getElementById('viewSkillInputsText');
    const exampleText = document.getElementById('viewSkillExampleText');
    const accuracyText = document.getElementById('viewSkillAccuracyText');
    const timeText = document.getElementById('viewSkillTimeText');
    const editBtn = document.getElementById('viewSkillEditBtn');

    contentEl.innerHTML = '<div class="py-12 text-center text-slate-400"><i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto mb-2"></i>Loading skill playbook...</div>';
    if (window.lucide) lucide.createIcons();
    modal.classList.remove('hidden');

    fetch('<?= site_url('skills/api/') ?>' + skillId)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const s = data.skill;
                currentViewingSkill = s;

                titleEl.textContent = s.name;
                catEl.textContent = s.category.toUpperCase();
                pathEl.innerHTML = `<i data-lucide="file-code" class="w-3.5 h-3.5 text-indigo-500"></i> <span>${s.folder_path}</span>`;
                accuracyText.textContent = (s.accuracy || '99.4%') + ' Accuracy';
                timeText.textContent = (s.estimated_time || '15-30 Mins');
                
                // Inputs Required
                if (s.inputs_required && s.inputs_required.trim()) {
                    inputsText.textContent = s.inputs_required;
                } else {
                    inputsText.textContent = '1. Target Website URL\n2. Campaign Goals & Primary Keywords\n3. Client Branding Guidelines & Access';
                }

                // Example Scenario
                if (s.example_scenario && s.example_scenario.trim()) {
                    exampleText.textContent = s.example_scenario;
                } else {
                    exampleText.textContent = 'INPUT: Target website and goals provided.\nEXECUTION: Run step-by-step checklist.\nRESULT: Verified high-performing production output.';
                }

                contentEl.textContent = s.content || s.description || 'No detailed content provided.';

                // Attach edit action to edit button in modal
                editBtn.onclick = function() {
                    modal.classList.add('hidden');
                    openEditSkill(skillId);
                };

                if (window.lucide) lucide.createIcons();
            } else {
                contentEl.textContent = 'Failed to load skill content.';
            }
        })
        .catch(err => {
            contentEl.textContent = 'Error loading skill details: ' + err;
        });
}

function openEditSkill(skillId) {
    const modal = document.getElementById('modalEditSkill');
    const form = document.getElementById('formEditSkill');
    
    form.action = '<?= site_url('skills/update/') ?>' + skillId;

    fetch('<?= site_url('skills/api/') ?>' + skillId)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const s = data.skill;
                document.getElementById('editSkillName').value = s.name || '';
                document.getElementById('editSkillCategory').value = s.category.toLowerCase();
                document.getElementById('editSkillLevel').value = s.level.toLowerCase();
                document.getElementById('editSkillAccuracy').value = s.accuracy || '99.4%';
                document.getElementById('editSkillTime').value = s.estimated_time || '15-30 Mins';
                document.getElementById('editSkillDescription').value = s.description || '';
                document.getElementById('editSkillInputs').value = s.inputs_required || '';
                document.getElementById('editSkillExample').value = s.example_scenario || '';
                document.getElementById('editSkillContent').value = s.content || '';

                modal.classList.remove('hidden');
                if (window.lucide) lucide.createIcons();
            } else {
                alert('Skill load karne me error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('Skill load karne me error: ' + err);
        });
}

function showToast(message) {
    const toast = document.getElementById('copyToast');
    const msgEl = document.getElementById('copyToastMsg');
    msgEl.textContent = message;
    toast.classList.remove('translate-y-20', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    if (window.lucide) lucide.createIcons();
    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-20', 'opacity-0');
    }, 2500);
}

function copyCurrentViewingSkill(btn) {
    if (!currentViewingSkill) return;
    
    let textToCopy = `# ${currentViewingSkill.name}\n\n`;
    textToCopy += `**Category:** ${currentViewingSkill.category.toUpperCase()} | **Accuracy:** ${currentViewingSkill.accuracy || '99.4%'} | **Est. Time:** ${currentViewingSkill.estimated_time || '20-30 Mins'}\n`;
    textToCopy += `**File Path:** ${currentViewingSkill.folder_path}\n\n`;
    
    if (currentViewingSkill.inputs_required) {
        textToCopy += `## Required Inputs\n${currentViewingSkill.inputs_required}\n\n`;
    }
    if (currentViewingSkill.example_scenario) {
        textToCopy += `## Example Scenario & Expected Result\n${currentViewingSkill.example_scenario}\n\n`;
    }
    textToCopy += `## Complete SOP Playbook\n${currentViewingSkill.content || ''}`;

    navigator.clipboard.writeText(textToCopy).then(() => {
        const textSpan = document.getElementById('viewSkillCopyBtnText');
        const origText = textSpan.textContent;
        textSpan.textContent = 'Copied! ✓';
        btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
        btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
        showToast('Complete SOP & Execution Guide copied to clipboard!');
        setTimeout(() => {
            textSpan.textContent = origText;
            btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            btn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
        }, 2200);
    });
}

function copySkillTextOnly() {
    if (!currentViewingSkill) return;
    const content = currentViewingSkill.content || currentViewingSkill.description || '';
    navigator.clipboard.writeText(content).then(() => {
        showToast('Playbook text copied to clipboard!');
    });
}

function copySkillDirect(skillId, btn) {
    fetch('<?= site_url('skills/api/') ?>' + skillId)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const s = data.skill;
                let textToCopy = `# ${s.name}\n\n`;
                textToCopy += `**Category:** ${s.category.toUpperCase()} | **Accuracy:** ${s.accuracy || '99.4%'}\n\n`;
                if (s.inputs_required) textToCopy += `## Required Inputs\n${s.inputs_required}\n\n`;
                if (s.example_scenario) textToCopy += `## Example Scenario\n${s.example_scenario}\n\n`;
                textToCopy += `## SOP Playbook\n${s.content || ''}`;

                navigator.clipboard.writeText(textToCopy).then(() => {
                    const origHtml = btn.innerHTML;
                    btn.innerHTML = '<i data-lucide="check" class="w-4 h-4 text-emerald-500"></i>';
                    if (window.lucide) lucide.createIcons();
                    showToast(`"${s.name}" SOP copied!`);
                    setTimeout(() => {
                        btn.innerHTML = origHtml;
                        if (window.lucide) lucide.createIcons();
                    }, 2000);
                });
            }
        });
}
</script>

<?= $this->endSection() ?>
