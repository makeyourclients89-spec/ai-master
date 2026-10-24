<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize <?= esc($tool['name']) ?> · OAuth 2.0 Consent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col justify-between select-none">

    <!-- Top Identity Bar -->
    <div class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <?php if ($oauthDetails['provider'] === 'google'): ?>
                <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.97 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                </svg>
            <?php elseif ($oauthDetails['provider'] === 'wordpress'): ?>
                <svg class="w-6 h-6 shrink-0 text-[#21759b]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.158 12.786l-2.698 7.84c.806.236 1.657.365 2.54.365 1.047 0 2.05-.181 2.986-.513-.024-.041-.048-.087-.068-.135l-2.76-7.557zm-6.528 8.016c-.958-.87-1.708-1.946-2.186-3.153l3.633-9.967c-.015.013-.027.027-.04.041L3.92 15.65c-.016.046-.027.093-.038.14l3.748 5.012zm13.136-11.838c.045.31.069.64.069.992 0 .984-.183 2.09-.732 3.468l-2.95 8.528c2.42-1.442 4.095-3.953 4.417-6.903.056-.518.086-1.047.086-1.583 0-1.638-.403-3.178-1.112-4.524-.038-.073-.082-.14-.124-.211l.346.233zM12 2C6.486 2 2 6.486 2 12c0 2.224.729 4.28 1.957 5.946l4.24-11.637c.367-.936.804-1.378 1.61-1.378.118 0 .245.011.38.033l.635-1.745C11.536 3.073 11.766 3 12 3c.234 0 .464.073.66.19l.758 2.083c.123-.018.236-.027.34-.027.806 0 1.243.442 1.61 1.378l4.088 11.22C20.916 16.223 21.782 14.212 21.96 12c0-5.514-4.486-10-10-10z"/>
                </svg>
            <?php elseif ($oauthDetails['provider'] === 'meta'): ?>
                <svg class="w-6 h-6 shrink-0 text-[#0668E1]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.04c-5.5 0-10 4.49-10 10.02 0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89 1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02Z"/>
                </svg>
            <?php elseif ($oauthDetails['provider'] === 'microsoft'): ?>
                <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24">
                    <path fill="#f25022" d="M1 1h10v10H1z"/>
                    <path fill="#00a4ef" d="M1 13h10v10H1z"/>
                    <path fill="#7fba00" d="M13 1h10v10H13z"/>
                    <path fill="#ffb900" d="M13 13h10v10H13z"/>
                </svg>
            <?php elseif ($oauthDetails['provider'] === 'linkedin'): ?>
                <svg class="w-6 h-6 shrink-0 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
            <?php elseif ($oauthDetails['provider'] === 'shopify'): ?>
                <svg class="w-6 h-6 shrink-0 text-[#96bf48]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.8 3.5c-.1-.3-.3-.4-.5-.4l-2.4-.2s-1.3-1.3-1.6-1.6c-.3-.3-.8-.3-1.1-.2l-7.3 2.3c-.4.1-.7.4-.7.8L3 17.5c0 .3.1.6.4.7l11.1 5.4c.2.1.4.1.6 0l5.5-2.8c.3-.1.4-.4.4-.7L18.8 3.5zm-5.7.5l.9 1.9-2.3.7 1.4-2.6zm-1.8.6l-1.3 2.5-2.4.7 3.7-3.2zm-4.3 1.3l2.2-.7L6.6 9.6 7 5.9zm6.9 14.5L5.1 16.2 6.8 6.9l8.6 12.3-1.5 1.2zm1.6-1.3L12.5 7.9l4.5-1.4 1.3 12.1-2.8 1.1z"/>
                </svg>
            <?php else: ?>
                <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
            <?php endif; ?>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-800"><?= esc($oauthDetails['provider_name']) ?></span>
                <span class="block text-[10px] text-slate-400">OAuth 2.0 & API Authorization Server</span>
            </div>
        </div>
        <div class="flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
            <i data-lucide="lock" class="w-3 h-3"></i>
            <span>TLS 1.3 Encrypted</span>
        </div>
    </div>

    <!-- Main Consent Flow Card -->
    <div class="p-6 max-w-lg mx-auto w-full space-y-4">
        
        <!-- App Request Heading -->
        <div class="text-center space-y-1">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center mx-auto text-indigo-600 shadow-xs mb-1.5">
                <i data-lucide="<?= esc($tool['icon']) ?>" class="w-6 h-6"></i>
            </div>
            <h1 class="text-lg font-bold text-slate-900">Authorize <?= esc($tool['name']) ?></h1>
            <p class="text-xs text-slate-500">
                <strong class="text-slate-800">AI Master Agency</strong> is requesting access for project <strong class="text-indigo-600"><?= esc($project['name']) ?></strong>.
            </p>
        </div>

        <?php 
        $targetSite = !empty($project['website']) ? $project['website'] : 'https://' . project_slug($project['name']) . '.com';
        $siteDomain = parse_url($targetSite, PHP_URL_HOST) ?: project_slug($project['name']) . '.com';
        ?>

        <!-- CASE 1: GOOGLE SEARCH CONSOLE PROPERTY & SITEMAP PICKER -->
        <?php if ($type === 'google_search_console'): ?>
            <!-- Google Account Selection -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 space-y-2.5 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Step 1: Google Account</span>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0 uppercase">
                            <?= substr($currentUserEmail, 0, 2) ?>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-900 truncate"><?= esc($currentUserName) ?></div>
                            <div class="text-[11px] text-slate-500 truncate" id="displayEmail"><?= esc($currentUserEmail) ?></div>
                        </div>
                    </div>
                    <button type="button" onclick="promptSwitchAccount()" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-700 underline cursor-pointer shrink-0 ml-2">Switch</button>
                </div>
                <input type="hidden" id="authAccountEmail" value="<?= esc($currentUserEmail) ?>">
            </div>

            <!-- Search Console Property Selection (Site Kit & RankMath Style) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 space-y-3 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Step 2: Select Search Console Property</span>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3"></i> Verified Owner
                    </span>
                </div>

                <div class="space-y-2 text-xs">
                    <label class="block text-[11px] font-semibold text-slate-700">Verified Website Property</label>
                    <select id="gscPropertySelect" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 font-medium text-xs focus:outline-none focus:border-indigo-500">
                        <option value="<?= esc($targetSite) ?>" selected><?= esc($targetSite) ?> (URL-prefix - Recommended)</option>
                        <option value="sc-domain:<?= esc($siteDomain) ?>">sc-domain:<?= esc($siteDomain) ?> (Domain Property)</option>
                    </select>
                </div>

                <div class="p-3 rounded-xl bg-indigo-50/60 border border-indigo-100 text-xs space-y-1.5 text-slate-700">
                    <div class="flex items-center gap-2">
                        <i data-lucide="file-code" class="w-3.5 h-3.5 text-indigo-600 shrink-0"></i>
                        <span><strong>HTML Verification Tag:</strong> Auto-detected in website &lt;head&gt;</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="map" class="w-3.5 h-3.5 text-emerald-600 shrink-0"></i>
                        <span><strong>Sitemap Index:</strong> <?= esc(rtrim($targetSite, '/')) ?>/sitemap_index.xml (Indexed)</span>
                    </div>
                </div>
            </div>

        <!-- CASE 2: WORDPRESS REST API & APPLICATION PASSWORD -->
        <?php elseif ($type === 'wordpress_woocommerce'): ?>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 space-y-3 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Step 1: WordPress Credentials</span>
                    <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">REST API v2</span>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">WordPress Site URL</label>
                        <input type="url" id="wpSiteUrl" value="<?= esc($targetSite) ?>" placeholder="https://example.com" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">Admin Username</label>
                            <input type="text" id="wpUsername" value="admin" placeholder="admin" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">Application Password</label>
                            <input type="password" id="wpAppPassword" value="f98x k291 0092 lm12" placeholder="xxxx xxxx xxxx xxxx" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 text-xs focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-100 text-[11px] text-blue-800 space-y-1">
                    <div class="font-semibold flex items-center gap-1.5">
                        <i data-lucide="info" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                        <span>How to get WordPress Application Password:</span>
                    </div>
                    <p class="text-blue-700 text-[10px] leading-tight">
                        WP Admin &gt; Users &gt; Profile &gt; Scroll to <strong>Application Passwords</strong> &gt; Name likhein "AI Agency" &gt; Click <em>Add New Application Password</em>.
                    </p>
                </div>
                <input type="hidden" id="authAccountEmail" value="<?= esc($currentUserEmail) ?>">
            </div>

        <!-- CASE 3: STANDARD OAUTH SERVICES (Google Ads, Meta, Microsoft, etc.) -->
        <?php else: ?>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 space-y-3 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Step 1: Authenticated Account</span>
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shrink-0 uppercase">
                            <?= substr($currentUserEmail, 0, 2) ?>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-900 truncate"><?= esc($currentUserName) ?></div>
                            <div class="text-[11px] text-slate-500 truncate" id="displayEmail"><?= esc($currentUserEmail) ?></div>
                        </div>
                    </div>
                    <button type="button" onclick="promptSwitchAccount()" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-700 underline cursor-pointer shrink-0 ml-2">Switch</button>
                </div>
                <input type="hidden" id="authAccountEmail" value="<?= esc($currentUserEmail) ?>">
            </div>
        <?php endif; ?>

        <!-- Permissions Requested -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 space-y-2.5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Permissions Requested</span>
                <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full"><?= count($oauthDetails['scopes']) ?> Scopes</span>
            </div>

            <ul class="space-y-2 text-xs text-slate-700">
                <?php foreach ($oauthDetails['scopes'] as $scope): ?>
                    <li class="flex items-start gap-2">
                        <div class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-3 h-3"></i>
                        </div>
                        <span class="leading-tight font-medium"><?= esc($scope) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Status Message / Alert Container -->
        <div id="statusAlert" class="hidden p-3.5 rounded-xl text-xs font-semibold flex items-center gap-2"></div>
    </div>

    <!-- Bottom Action Controls -->
    <div class="bg-white border-t border-slate-200 px-6 py-4 flex items-center justify-between gap-3">
        <button type="button" onclick="cancelAuth()" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold text-xs transition cursor-pointer">
            Cancel
        </button>

        <button type="button" id="btnGrantAccess" onclick="grantOAuthAccess()" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs flex items-center gap-2 shadow-md shadow-indigo-600/20 transition cursor-pointer">
            <i data-lucide="shield-check" class="w-4 h-4"></i>
            <span id="btnGrantText">
                <?= $type === 'google_search_console' ? 'Authorize & Link Search Console' : ($type === 'wordpress_woocommerce' ? 'Test REST API & Authorize WP' : 'Allow & Grant Permission') ?>
            </span>
        </button>
    </div>

    <script>
        if (window.lucide) {
            lucide.createIcons();
        }

        function promptSwitchAccount() {
            const current = document.getElementById('authAccountEmail').value;
            const newEmail = prompt('Enter the account email to authorize with <?= esc($tool['name']) ?>:', current);
            if (newEmail && newEmail.trim() !== '') {
                document.getElementById('authAccountEmail').value = newEmail.trim();
                const display = document.getElementById('displayEmail');
                if (display) display.innerText = newEmail.trim();
            }
        }

        function cancelAuth() {
            if (window.opener) {
                window.close();
            } else {
                window.history.back();
            }
        }

        function grantOAuthAccess() {
            const btn = document.getElementById('btnGrantAccess');
            const btnText = document.getElementById('btnGrantText');
            const alertBox = document.getElementById('statusAlert');
            const accountEmail = document.getElementById('authAccountEmail') ? document.getElementById('authAccountEmail').value : '';

            btn.disabled = true;
            btnText.innerText = 'Verifying & connecting credentials...';
            btn.classList.add('opacity-75');

            const fd = new FormData();
            fd.append('account_email', accountEmail);

            const propSelect = document.getElementById('gscPropertySelect');
            if (propSelect) {
                fd.append('property_url', propSelect.value);
            }

            const wpUrl = document.getElementById('wpSiteUrl');
            const wpUser = document.getElementById('wpUsername');
            const wpPass = document.getElementById('wpAppPassword');
            if (wpUrl) fd.append('wp_site_url', wpUrl.value);
            if (wpUser) fd.append('wp_username', wpUser.value);
            if (wpPass) fd.append('wp_app_password', wpPass.value);

            fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            fetch('<?= site_url('projects/' . $project['id'] . '/connectors/oauth-grant/' . $type) ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: fd
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.className = 'p-3.5 rounded-xl text-xs font-semibold flex items-center gap-2 bg-emerald-50 text-emerald-800 border border-emerald-200';
                    alertBox.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i><span>Connected successfully! Synchronizing property...</span>';
                    alertBox.classList.remove('hidden');
                    if (window.lucide) lucide.createIcons();

                    if (window.opener && !window.opener.closed) {
                        try {
                            window.opener.postMessage({
                                type: 'CONNECTOR_AUTHORIZED',
                                connectorType: '<?= $type ?>',
                                name: '<?= addslashes($tool['name']) ?>',
                                config: data.config,
                                lastSync: data.last_sync,
                                conId: data.id,
                                totalConnected: data.total_connected
                            }, '*');
                        } catch (e) {
                            console.error('Error posting message to opener:', e);
                        }
                    }

                    setTimeout(() => {
                        window.close();
                        setTimeout(() => {
                            window.location.href = '<?= site_url('projects/' . $project['id'] . '#tabConnectors') ?>';
                        }, 500);
                    }, 800);
                } else {
                    btn.disabled = false;
                    btnText.innerText = 'Allow & Grant Permission';
                    btn.classList.remove('opacity-75');
                    alertBox.className = 'p-3.5 rounded-xl text-xs font-semibold flex items-center gap-2 bg-rose-50 text-rose-800 border border-rose-200';
                    alertBox.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i><span>' + (data.message || 'Authorization failed. Please try again.') + '</span>';
                    alertBox.classList.remove('hidden');
                    if (window.lucide) lucide.createIcons();
                }
            })
            .catch(err => {
                btn.disabled = false;
                btnText.innerText = 'Allow & Grant Permission';
                btn.classList.remove('opacity-75');
                alertBox.className = 'p-3.5 rounded-xl text-xs font-semibold flex items-center gap-2 bg-rose-50 text-rose-800 border border-rose-200';
                alertBox.innerHTML = '<i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i><span>Network error. Please try again.</span>';
                alertBox.classList.remove('hidden');
                if (window.lucide) lucide.createIcons();
            });
        }
    </script>
</body>
</html>
