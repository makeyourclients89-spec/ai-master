<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$employeeCount = 0;
$clientCount = 0;
$distinctCompanies = [];

foreach ($members as $m) {
    if (($m['member_type'] ?? '') === 'client') {
        $clientCount++;
        if (!empty($m['company_name'])) {
            $distinctCompanies[$m['company_name']] = true;
        }
    } else {
        $employeeCount++;
    }
}
$companyCount = count($distinctCompanies);
if ($companyCount === 0 && !empty($projects)) {
    $companyCount = count($projects);
}
?>

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                <i data-lucide="users" class="w-6 h-6 text-indigo-600 dark:text-indigo-400"></i> People & Access
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-dark-600 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold"><?= count($members) ?></span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Manage agency team employees, roles, and client stakeholder portal access.</p>
        </div>

        <div class="flex items-center gap-2.5 self-start sm:self-auto">
            <!-- Add Employee Quick Button -->
            <button onclick="openAddMemberModal('employee')" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition shadow-sm shadow-indigo-600/25 flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Add Employee
            </button>

            <!-- Add Client Quick Button -->
            <button onclick="openAddMemberModal('client')" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-sm shadow-emerald-600/25 flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="building-2" class="w-3.5 h-3.5"></i> Add Client
            </button>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Members -->
        <div class="p-4 rounded-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total People</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= count($members) ?></h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Workspace team & clients</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-dark-600 flex items-center justify-center text-slate-700 dark:text-slate-300">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Employees & Staff -->
        <div class="p-4 rounded-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Employees & Staff</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= $employeeCount ?></h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Internal agency specialists</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Active Clients -->
        <div class="p-4 rounded-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Client Stakeholders</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-1"><?= $clientCount ?></h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Approvers & reviewers</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <i data-lucide="building" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Frictionless Access -->
        <div class="p-4 rounded-2xl bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-purple-600 dark:text-purple-400">Instant Access</p>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-1 flex items-center gap-1.5">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i> Zero Friction
                </h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Direct enrollment without email delays</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                <i data-lucide="zap" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Segmented Tabs & Live Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200 dark:border-slate-800 pb-3">
        <!-- Tabs -->
        <div class="flex items-center gap-2">
            <button onclick="filterTeamTable('all')" id="tabBtnAll" class="team-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition bg-indigo-600 text-white shadow-sm cursor-pointer">
                <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                <span>All Members</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 text-white"><?= count($members) ?></span>
            </button>

            <button onclick="filterTeamTable('employee')" id="tabBtnEmployee" class="team-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white cursor-pointer">
                <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                <span>Employees & Staff</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-200 dark:bg-dark-600 text-slate-700 dark:text-slate-300"><?= $employeeCount ?></span>
            </button>

            <button onclick="filterTeamTable('client')" id="tabBtnClient" class="team-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white cursor-pointer">
                <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                <span>Clients</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-200 dark:bg-dark-600 text-slate-700 dark:text-slate-300"><?= $clientCount ?></span>
            </button>
        </div>

        <!-- Quick Live Search -->
        <div class="relative w-full sm:w-64">
            <input type="text" id="teamSearchInput" onkeyup="searchTeamTable()" placeholder="Search name, email, role, company..." class="w-full pl-9 pr-3 py-1.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-indigo-600 transition shadow-sm">
            <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-2.5"></i>
        </div>
    </div>

    <!-- Members Table Panel -->
    <div class="bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="teamMembersTable">
                <thead class="bg-slate-50 dark:bg-dark-600/70 text-slate-500 dark:text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-200 dark:border-slate-800 font-bold">
                    <tr>
                        <th class="py-3 px-6">Member / Contact</th>
                        <th class="py-3 px-6">Classification & Title</th>
                        <th class="py-3 px-6">Workspace Role</th>
                        <th class="py-3 px-6">Assigned Project / Company</th>
                        <th class="py-3 px-6">Joined</th>
                        <th class="py-3 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php if (empty($members)): ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                No members found in this workspace.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($members as $m): ?>
                            <?php
                            $isClient = ($m['member_type'] === 'client');
                            $typeFilter = $isClient ? 'client' : 'employee';
                            ?>
                            <tr class="team-row hover:bg-slate-50/80 dark:hover:bg-dark-600/30 transition" data-type="<?= $typeFilter ?>" data-search="<?= esc(strtolower($m['name'] . ' ' . $m['email'] . ' ' . ($m['designation'] ?? '') . ' ' . ($m['company_name'] ?? '') . ' ' . ($m['project_name'] ?? '') . ' ' . $m['member_role'] . ' ' . ($isClient ? 'client' : 'employee staff'))) ?>">
                                
                                <!-- Member / Contact -->
                                <td class="py-4 px-6 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl <?= $isClient ? 'bg-gradient-to-tr from-emerald-600 to-teal-500 text-white' : 'bg-gradient-to-tr from-indigo-600 to-purple-600 text-white' ?> flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        <?= substr($m['name'], 0, 1) ?>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900 dark:text-white"><?= esc($m['name']) ?></span>
                                            <?php if ($m['member_role'] === 'owner'): ?>
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">Owner</span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-mono"><?= esc($m['email']) ?></span>
                                    </div>
                                </td>

                                <!-- Classification & Title -->
                                <td class="py-4 px-6">
                                    <div class="flex flex-col gap-1 items-start">
                                        <?php if ($isClient): ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20">
                                                <i data-lucide="building" class="w-3 h-3"></i> Client
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20">
                                                <i data-lucide="briefcase" class="w-3 h-3"></i> Employee / Staff
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($m['designation'])): ?>
                                            <span class="text-xs font-medium text-slate-700 dark:text-slate-300"><?= esc($m['designation']) ?></span>
                                        <?php else: ?>
                                            <span class="text-[11px] text-slate-400 italic"><?= $isClient ? 'Client Representative' : 'Team Member' ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Role & Access -->
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        <?= $m['member_role'] === 'owner' ? 'bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20' : '' ?>
                                        <?= $m['member_role'] === 'admin' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-500/10 dark:text-indigo-400 dark:border-indigo-500/20' : '' ?>
                                        <?= $m['member_role'] === 'manager' ? 'bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-500/10 dark:text-purple-400 dark:border-purple-500/20' : '' ?>
                                        <?= $m['member_role'] === 'specialist' ? 'bg-sky-50 text-sky-700 border border-sky-200 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/20' : '' ?>
                                        <?= $m['member_role'] === 'client_approver' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20' : '' ?>
                                        <?= $m['member_role'] === 'client_reviewer' || $m['member_role'] === 'client_viewer' ? 'bg-teal-50 text-teal-700 border border-teal-200 dark:bg-teal-500/10 dark:text-teal-400 dark:border-teal-500/20' : '' ?>
                                        <?= $m['member_role'] === 'member' ? 'bg-slate-100 text-slate-700 border border-slate-200 dark:bg-dark-600 dark:text-slate-300 dark:border-slate-700' : '' ?>">
                                        
                                        <?php if ($m['member_role'] === 'client_approver'): ?>
                                            <i data-lucide="check-circle" class="w-3 h-3"></i> Client Approver
                                        <?php elseif ($m['member_role'] === 'client_reviewer'): ?>
                                            <i data-lucide="message-square" class="w-3 h-3"></i> Client Reviewer
                                        <?php elseif ($m['member_role'] === 'client_viewer'): ?>
                                            <i data-lucide="eye" class="w-3 h-3"></i> Client Viewer
                                        <?php else: ?>
                                            <?= esc($m['member_role']) ?>
                                        <?php endif; ?>
                                    </span>
                                </td>

                                <!-- Assigned Project / Company -->
                                <td class="py-4 px-6">
                                    <?php if ($isClient): ?>
                                        <div class="flex flex-col gap-1 items-start">
                                            <span class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                                <i data-lucide="building-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                                                <?= esc($m['company_name'] ?: ($m['project_name'] ?: 'Client Partner')) ?>
                                            </span>
                                            <?php if (!empty($m['project_name'])): ?>
                                                <a href="<?= project_url(['id' => $m['project_id'], 'name' => $m['project_name']]) ?>" class="text-[11px] text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                                                    <i data-lucide="folder-kanban" class="w-3 h-3"></i> Project: <?= esc($m['project_name']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                                            <i data-lucide="globe" class="w-3.5 h-3.5 text-indigo-500"></i> Full Agency Workspace
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Joined Date -->
                                <td class="py-4 px-6 text-slate-500 dark:text-slate-400 font-mono text-[11px]">
                                    <?= esc(date('M d, Y', strtotime($m['created_at']))) ?>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right">
                                    <?php if ($m['member_role'] !== 'owner'): ?>
                                        <a href="<?= site_url('team/remove/' . $m['membership_id']) ?>" onclick="return confirm('Remove access for this user from this workspace?')" class="px-2.5 py-1 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 font-semibold transition cursor-pointer">
                                            Remove
                                        </a>
                                    <?php else: ?>
                                        <span class="text-slate-400 dark:text-slate-500 font-mono text-[11px]">Primary Owner</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Add Member / Client -->
<div id="modalAddMember" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">
    <div class="w-full max-w-lg bg-white dark:bg-dark-700 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl p-6 text-slate-900 dark:text-white">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i> 
                    <span id="modalTitle">Add Member or Client</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Directly grant workspace permissions to employees or client partners.</p>
            </div>
            <button type="button" onclick="closeAddMemberModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Form -->
        <form action="<?= site_url('team/add') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <!-- Member Type Selector Buttons -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">Who are you adding?</label>
                <div class="grid grid-cols-2 gap-2 p-1 rounded-xl bg-slate-100 dark:bg-dark-600 border border-slate-200 dark:border-slate-700">
                    <button type="button" onclick="selectMemberType('employee')" id="btnSelectEmployee" class="py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition bg-white dark:bg-dark-700 text-indigo-600 dark:text-indigo-400 shadow-sm cursor-pointer">
                        <i data-lucide="briefcase" class="w-4 h-4"></i> Agency Employee
                    </button>
                    <button type="button" onclick="selectMemberType('client')" id="btnSelectClient" class="py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer">
                        <i data-lucide="building-2" class="w-4 h-4"></i> Client Partner
                    </button>
                </div>
                <input type="hidden" name="member_type" id="inputMemberType" value="employee">
            </div>

            <!-- Full Name & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Full Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Vikramaditya Rathore" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Email Address *</label>
                    <input type="email" name="email" required placeholder="name@company.com" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                </div>
            </div>

            <!-- EMPLOYEE SPECIFIC FIELDS -->
            <div id="fieldsEmployee" class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Employee Role & Permissions</label>
                    <select name="role" id="roleEmployee" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                        <option value="specialist" selected>Specialist / Employee — Execute AI workflows, SEO & playbooks</option>
                        <option value="manager">Manager / Project Lead — Manage campaigns, deliverables & client review</option>
                        <option value="admin">Admin — Full operational access across all projects & settings</option>
                        <option value="member">Member — Standard workspace member access</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Job Title / Designation</label>
                    <input type="text" name="designation" placeholder="e.g. Senior AI SEO Strategist / Content Lead" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Assign to Project (Optional)</label>
                    <select name="project_id" id="roleEmployeeProject" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                        <option value="">-- All Projects (Global Agency Access) --</option>
                        <?php foreach ($projects as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= esc($p['name']) ?> (ID: <?= $p['id'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- CLIENT SPECIFIC FIELDS -->
            <div id="fieldsClient" class="space-y-3 hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Client Company / Brand *</label>
                        <input type="text" name="company_name" id="inputClientCompany" placeholder="e.g. Ivate Ayurveda" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Client Designation</label>
                        <input type="text" name="designation" placeholder="e.g. Head of Marketing / CEO" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Client Role & Access</label>
                    <select name="role" id="roleClient" disabled class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                        <option value="client_approver" selected>Client Approver — Review & Approve deliverables & briefs</option>
                        <option value="client_reviewer">Client Reviewer — Leave feedback, notes & comments</option>
                        <option value="client_viewer">Client Viewer — Read-only visibility to project progress</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1">Assign to Project</label>
                    <select name="project_id" id="clientProjectSelect" onchange="syncClientCompanyWithProject(this)" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-xs focus:outline-none focus:border-indigo-600">
                        <option value="">-- Select Project (Optional) --</option>
                        <?php foreach ($projects as $p): ?>
                            <option value="<?= $p['id'] ?>" data-name="<?= esc($p['name']) ?>"><?= esc($p['name']) ?> (ID: <?= $p['id'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Zero Friction Banner -->
            <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-[11px] text-emerald-800 dark:text-emerald-300 flex items-start gap-2">
                <i data-lucide="zap" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-bold">Zero Email Friction Direct Enrollment</p>
                    <p class="text-[10px] text-emerald-700 dark:text-emerald-400 mt-0.5">User will be created immediately without email verification delays. Initial login password: <span class="font-mono font-bold bg-white dark:bg-dark-800 px-1 py-0.5 rounded border border-emerald-300 dark:border-emerald-600">welcome123</span></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200 dark:border-slate-800">
                <button type="button" onclick="closeAddMemberModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 cursor-pointer">Cancel</button>
                <button type="submit" id="btnSubmitAdd" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer">
                    Add Employee
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentMemberType = 'employee';

function openAddMemberModal(type = 'employee') {
    selectMemberType(type);
    document.getElementById('modalAddMember').classList.remove('hidden');
}

function closeAddMemberModal() {
    document.getElementById('modalAddMember').classList.add('hidden');
}

function selectMemberType(type) {
    currentMemberType = type;
    document.getElementById('inputMemberType').value = type;

    const btnEmp = document.getElementById('btnSelectEmployee');
    const btnCli = document.getElementById('btnSelectClient');
    const fieldsEmp = document.getElementById('fieldsEmployee');
    const fieldsCli = document.getElementById('fieldsClient');
    const roleEmp = document.getElementById('roleEmployee');
    const roleCli = document.getElementById('roleClient');
    const projEmp = document.getElementById('roleEmployeeProject');
    const projCli = document.getElementById('clientProjectSelect');
    const btnSubmit = document.getElementById('btnSubmitAdd');
    const modalTitle = document.getElementById('modalTitle');

    if (type === 'client') {
        // Active Client tab
        btnCli.className = "py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition bg-white dark:bg-dark-700 text-emerald-600 dark:text-emerald-400 shadow-sm cursor-pointer";
        btnEmp.className = "py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer";

        fieldsEmp.classList.add('hidden');
        roleEmp.disabled = true;
        if (projEmp) projEmp.disabled = true;

        fieldsCli.classList.remove('hidden');
        roleCli.disabled = false;
        if (projCli) projCli.disabled = false;

        btnSubmit.className = "px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer";
        btnSubmit.textContent = "Add Client Partner";
        modalTitle.textContent = "Add Client Stakeholder";
    } else {
        // Active Employee tab
        btnEmp.className = "py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition bg-white dark:bg-dark-700 text-indigo-600 dark:text-indigo-400 shadow-sm cursor-pointer";
        btnCli.className = "py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white cursor-pointer";

        fieldsCli.classList.add('hidden');
        roleCli.disabled = true;
        if (projCli) projCli.disabled = true;

        fieldsEmp.classList.remove('hidden');
        roleEmp.disabled = false;
        if (projEmp) projEmp.disabled = false;

        btnSubmit.className = "px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition shadow-sm cursor-pointer";
        btnSubmit.textContent = "Add Agency Employee";
        modalTitle.textContent = "Add Agency Employee";
    }

    if (window.lucide) {
        window.lucide.createIcons();
    }
}

function syncClientCompanyWithProject(selectEl) {
    const selected = selectEl.options[selectEl.selectedIndex];
    const projectName = selected.getAttribute('data-name');
    const compInput = document.getElementById('inputClientCompany');
    if (projectName && (!compInput.value || compInput.value.trim() === '')) {
        compInput.value = projectName;
    }
}

// Table Filter (All / Employee / Client)
function filterTeamTable(type) {
    const rows = document.querySelectorAll('.team-row');
    const btnAll = document.getElementById('tabBtnAll');
    const btnEmp = document.getElementById('tabBtnEmployee');
    const btnCli = document.getElementById('tabBtnClient');

    const activeClasses = "team-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition bg-indigo-600 text-white shadow-sm cursor-pointer";
    const inactiveClasses = "team-tab-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white cursor-pointer";

    btnAll.className = (type === 'all') ? activeClasses : inactiveClasses;
    btnEmp.className = (type === 'employee') ? activeClasses : inactiveClasses;
    btnCli.className = (type === 'client') ? activeClasses : inactiveClasses;

    rows.forEach(row => {
        const rowType = row.getAttribute('data-type');
        if (type === 'all' || rowType === type) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    // Re-check search query if any
    searchTeamTable();
}

// Live Search Filter
function searchTeamTable() {
    const query = (document.getElementById('teamSearchInput').value || '').toLowerCase().trim();
    const rows = document.querySelectorAll('.team-row');

    // Check which tab is active
    let activeTab = 'all';
    if (document.getElementById('tabBtnEmployee').classList.contains('bg-indigo-600')) activeTab = 'employee';
    if (document.getElementById('tabBtnClient').classList.contains('bg-indigo-600')) activeTab = 'client';

    rows.forEach(row => {
        const rowType = row.getAttribute('data-type');
        const searchData = (row.getAttribute('data-search') || '').toLowerCase();
        const matchesTab = (activeTab === 'all' || rowType === activeTab);
        const matchesQuery = !query || searchData.includes(query);

        if (matchesTab && matchesQuery) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Initialize Lucide icons
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide) {
        window.lucide.createIcons();
    }
});
</script>

<?= $this->endSection() ?>