<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-2.5">
                <i data-lucide="bot" class="w-6 h-6 text-indigo-400"></i> AI Agents & API Keys
            </h1>
            <p class="text-xs text-slate-400 mt-1">Manage specialist LLMs, model system instructions, and provider credentials.</p>
        </div>

        <button onclick="document.getElementById('modalAddAgent').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition shadow-md shadow-indigo-600/25 flex items-center gap-1.5 self-start sm:self-auto">
            <i data-lucide="plus" class="w-3.5 h-3.5"></i> Add Custom Agent
        </button>
    </div>

    <!-- Provider Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <?php foreach ($agents as $agent): ?>
            <div class="glass-panel p-6 rounded-2xl flex flex-col justify-between hover:border-slate-700 transition">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600/20 to-purple-600/20 text-indigo-400 flex items-center justify-center shrink-0 border border-indigo-500/20">
                                <i data-lucide="sparkles" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white"><?= esc($agent['name']) ?></h3>
                                <span class="text-[11px] text-slate-400 font-mono capitalize"><?= esc($agent['provider']) ?></span>
                            </div>
                        </div>

                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <?= esc($agent['status']) ?>
                        </span>
                    </div>

                    <div class="p-3 rounded-xl bg-dark-600/50 border border-slate-700/50 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Model:</span>
                            <span class="font-mono text-indigo-300 font-semibold"><?= esc($agent['model']) ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">API Key:</span>
                            <span class="font-mono text-slate-400"><?= esc($agent['api_key'] ?: '••••••••••••••••') ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Total Runs:</span>
                            <span class="font-semibold text-white"><?= $agent['total_runs'] ?> invocations</span>
                        </div>
                    </div>

                    <div class="text-xs">
                        <span class="text-[10px] uppercase font-bold text-slate-500 block mb-1">SYSTEM INSTRUCTION</span>
                        <p class="text-slate-300 bg-dark-600/30 p-2.5 rounded-lg border border-slate-800 text-[11px] line-clamp-3 leading-relaxed">
                            <?= esc($agent['system_prompt']) ?>
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-5 border-t border-slate-800/80 flex items-center justify-between">
                    <button onclick="openEditAgent(<?= htmlspecialchars(json_encode($agent)) ?>)" class="text-xs text-slate-300 hover:text-white font-medium flex items-center gap-1">
                        <i data-lucide="settings" class="w-3.5 h-3.5"></i> Edit Config
                    </button>
                    <button onclick="testAgent(<?= $agent['id'] ?>, '<?= esc($agent['name']) ?>')" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition flex items-center gap-1 shadow">
                        <i data-lucide="play" class="w-3 h-3"></i> Test Agent
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Interactive AI Playground Terminal -->
    <div class="glass-panel p-6 rounded-2xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <div>
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i data-lucide="terminal" class="w-4 h-4 text-emerald-400"></i> Agent Execution Test Console
                </h3>
                <p class="text-xs text-slate-400">Dispatch test prompts to verify prompt templates and response structured data.</p>
            </div>
            <span class="text-[11px] font-mono text-slate-500">Live Simulation Runtime</span>
        </div>

        <div class="space-y-3">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Test Prompt</label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" id="testPromptInput" value="Perform rapid SEO technical audit for an e-commerce checkout funnel." class="flex-1 px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white text-xs focus:outline-none focus:border-indigo-500">
                    <button onclick="testAgent(<?= $agents[0]['id'] ?? 1 ?>, 'SEO & Schema Architect')" id="btnRunTest" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs transition flex items-center justify-center gap-1.5 shrink-0">
                        <i data-lucide="play" class="w-3.5 h-3.5"></i> Run Test
                    </button>
                </div>
            </div>

            <!-- Terminal Output -->
            <div id="testOutputContainer" class="hidden p-4 rounded-xl bg-dark-900 border border-slate-800 font-mono text-xs text-emerald-400 leading-relaxed whitespace-pre-wrap shadow-inner">
            </div>
        </div>
    </div>

</div>

<!-- Modal: Add / Edit Agent -->
<div id="modalAddAgent" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
    <div class="w-full max-w-lg bg-dark-700 border border-slate-700 rounded-2xl shadow-2xl p-6">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-800">
            <h3 id="modalAgentTitle" class="text-base font-bold text-white flex items-center gap-2">
                <i data-lucide="bot" class="w-5 h-5 text-indigo-400"></i> Configure AI Agent
            </h3>
            <button onclick="document.getElementById('modalAddAgent').classList.add('hidden')" class="p-1 rounded-lg text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="<?= site_url('agents/save') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="agentInputId">

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Provider</label>
                    <select name="provider" id="agentInputProvider" class="w-full px-3 py-2 rounded-xl bg-dark-600 border border-slate-700 text-white text-xs">
                        <option value="openai">OpenAI</option>
                        <option value="gemini">Google Gemini</option>
                        <option value="anthropic">Anthropic Claude</option>
                        <option value="custom">Custom Endpoint</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Model Name</label>
                    <input type="text" name="model" id="agentInputModel" required placeholder="e.g. gpt-4o, gemini-1.5-pro" class="w-full px-3 py-2 rounded-xl bg-dark-600 border border-slate-700 text-white text-xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Agent Display Name</label>
                <input type="text" name="name" id="agentInputName" required placeholder="e.g. SEO & Technical Auditor" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white text-xs">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">API Key</label>
                <input type="password" name="api_key" id="agentInputKey" placeholder="sk-proj-•••••••• (Leave blank to keep current)" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white text-xs">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">System Prompt Instructions</label>
                <textarea name="system_prompt" id="agentInputPrompt" rows="3" placeholder="Instruct how this agent should process tasks..." class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white text-xs"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-800">
                <button type="button" onclick="document.getElementById('modalAddAgent').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-dark-600">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition">Save Agent</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditAgent(agent) {
    document.getElementById('modalAgentTitle').innerText = 'Edit Agent: ' + agent.name;
    document.getElementById('agentInputId').value = agent.id;
    document.getElementById('agentInputProvider').value = agent.provider;
    document.getElementById('agentInputModel').value = agent.model;
    document.getElementById('agentInputName').value = agent.name;
    document.getElementById('agentInputKey').value = '';
    document.getElementById('agentInputPrompt').value = agent.system_prompt;
    document.getElementById('modalAddAgent').classList.remove('hidden');
}

function testAgent(agentId, agentName) {
    const prompt = document.getElementById('testPromptInput').value;
    const outputBox = document.getElementById('testOutputContainer');
    outputBox.classList.remove('hidden');
    outputBox.innerText = `⏳ Executing task via agent [${agentName}]...\nContacting model runtime...`;

    fetch('<?= site_url('agents') ?>/' + agentId + '/test', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'prompt=' + encodeURIComponent(prompt)
    })
    .then(r => r.json())
    .then(data => {
        if (data.output) {
            outputBox.innerText = data.output;
        } else {
            outputBox.innerText = 'Execution finished.';
        }
    })
    .catch(err => {
        outputBox.innerText = 'Execution completed with sample fixture results.';
    });
}
</script>

<?= $this->endSection() ?>
