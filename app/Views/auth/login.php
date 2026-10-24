<!DOCTYPE html>
<html lang="en" class="h-full light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In · Agency OS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: { 900: '#070a0f', 800: '#0b0f17', 700: '#111726', 600: '#172033', 500: '#1f2b45' }
                    },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .theme-transition { transition: background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease; }
    </style>
</head>
<body class="h-full antialiased flex flex-col lg:flex-row bg-slate-50 dark:bg-[#0b0f17] text-slate-800 dark:text-slate-100 theme-transition">

    <!-- Left Brand Story Panel -->
    <div class="hidden lg:flex flex-col justify-between w-1/2 p-12 bg-gradient-to-br from-indigo-900 via-slate-900 to-indigo-950 text-white relative overflow-hidden border-r border-slate-200/10 dark:border-slate-800/80">
        <div class="absolute -right-24 -top-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-24 -bottom-24 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 flex items-center justify-center font-black text-white text-lg shadow-lg shadow-indigo-500/30">A↗</span>
                <div>
                    <div class="font-bold tracking-tight text-xl text-white">agency<span class="text-indigo-400">OS</span></div>
                    <span class="text-xs text-indigo-200/80 font-medium">CodeIgniter 4 Enterprise Engine</span>
                </div>
            </div>
        </div>

        <div class="relative z-10 max-w-lg space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                ONE PLACE TO BEGIN
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight">
                Good work starts with a clear <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-indigo-200 to-purple-300 italic">workspace.</span>
            </h1>
            <p class="text-slate-300 text-sm leading-relaxed">
                Bring your projects, goals, client briefs and AI specialist agents together. Build a dependable, high-converting agency operating system.
            </p>

            <div class="pt-4 space-y-3">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10 text-slate-200 text-xs font-medium backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-indigo-500/30 text-indigo-300 flex items-center justify-center shrink-0"><i data-lucide="folder-kanban" class="w-4 h-4"></i></div>
                    <span>Your projects organized with clear briefs and deliverables</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10 text-slate-200 text-xs font-medium backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/30 text-emerald-300 flex items-center justify-center shrink-0"><i data-lucide="target" class="w-4 h-4"></i></div>
                    <span>Direct access with instant zero-friction login</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10 text-slate-200 text-xs font-medium backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-amber-500/30 text-amber-300 flex items-center justify-center shrink-0"><i data-lucide="shield-check" class="w-4 h-4"></i></div>
                    <span>Tenant isolated data with strict role permissions</span>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs text-slate-400 flex items-center justify-between">
            <span>PROJECT OPERATING PLATFORM</span>
            <span class="font-mono text-indigo-300">01 / FOUNDATION</span>
        </div>
    </div>

    <!-- Right Login Card Panel -->
    <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 relative">
        
        <!-- Top Controls: Theme Switcher & Register Link -->
        <div class="w-full max-w-md flex items-center justify-between mb-6">
            <!-- Theme Toggle Button -->
            <button id="themeToggleBtn" onclick="toggleTheme()" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 shadow-sm hover:border-indigo-400 dark:hover:border-indigo-500 transition cursor-pointer">
                <i id="themeIcon" data-lucide="sun" class="w-4 h-4 text-amber-500"></i>
                <span id="themeLabel">Light Mode</span>
            </button>

            <!-- Register link -->
            <a href="<?= site_url('register') ?>" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold flex items-center gap-1">
                Create account <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="w-full max-w-md">
            
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center gap-2 mb-6">
                <span class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg">A↗</span>
                <span class="font-bold tracking-tight text-xl text-slate-900 dark:text-white">agency<span class="text-indigo-600 dark:text-indigo-400">OS</span></span>
            </div>

            <!-- Login Card -->
            <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-7 sm:p-8 shadow-xl dark:shadow-2xl">
                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 block mb-1">WELCOME BACK</span>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight mb-2">Sign in to your agency</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Enter your email and password for direct, instant access.</p>

                <!-- Alerts -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-5 p-3 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-700 dark:text-rose-400 text-xs flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-5 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('success')) ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('login') ?>" method="POST" class="space-y-4">
                    <?= csrf_field() ?>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email address</label>
                        <div class="relative">
                            <input type="email" id="inputEmail" name="email" value="<?= old('email') ?>" required placeholder="you@company.com" class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="inputPassword" name="password" required placeholder="••••••••" class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm transition shadow-lg shadow-indigo-600/25 flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <span>Sign in directly</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><i data-lucide="lock-keyhole" class="w-3.5 h-3.5 text-indigo-500"></i> Direct Auth Secure</span>
                    <span class="text-indigo-600 dark:text-indigo-400 font-mono text-[11px] font-medium">Phase 8 Ready</span>
                </div>
            </div>

            <!-- Demo Login Credentials Card (Client vs Employee vs Admin) -->
            <div class="mt-5 p-4 rounded-2xl bg-indigo-50/70 dark:bg-dark-700/60 border border-indigo-100 dark:border-slate-800 text-xs">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="font-bold text-slate-800 dark:text-slate-200">1-Click Demo Login</span>
                    </div>
                    <span class="text-[10px] text-slate-500 font-mono">Password: password123 / admin123</span>
                </div>

                <div class="space-y-2 mt-2">
                    <!-- 1. Agency Owner / Admin -->
                    <button type="button" onclick="fillCredentials('admin@agency.com', 'admin123', true)" class="w-full p-2 rounded-xl bg-white dark:bg-dark-600 border border-indigo-100 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 flex items-center justify-between transition cursor-pointer text-left">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-[11px]">👑</div>
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block text-[11px]">Agency Owner / Admin</span>
                                <span class="text-[10px] text-slate-500 font-mono">admin@agency.com (All Projects & Settings)</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-0.5">Sign In <i data-lucide="arrow-right" class="w-3 h-3"></i></span>
                    </button>

                    <!-- 2. Agency Employee / Specialist -->
                    <button type="button" onclick="fillCredentials('priya@agency.com', 'password123', true)" class="w-full p-2 rounded-xl bg-white dark:bg-dark-600 border border-indigo-100 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 flex items-center justify-between transition cursor-pointer text-left">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-sky-50 dark:bg-sky-500/20 text-sky-600 dark:text-sky-400 flex items-center justify-center font-bold text-[11px]">🧑‍💼</div>
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block text-[11px]">Employee · Priya Patel</span>
                                <span class="text-[10px] text-slate-500 font-mono">priya@agency.com (Assigned Project Specialist)</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-sky-600 dark:text-sky-400 flex items-center gap-0.5">Sign In <i data-lucide="arrow-right" class="w-3 h-3"></i></span>
                    </button>

                    <!-- 3. Client Stakeholder -->
                    <button type="button" onclick="fillCredentials('aarav@agency.com', 'password123', true)" class="w-full p-2 rounded-xl bg-white dark:bg-dark-600 border border-emerald-100 dark:border-slate-700 hover:border-emerald-400 dark:hover:border-emerald-500 flex items-center justify-between transition cursor-pointer text-left">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-[11px]">🏢</div>
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block text-[11px]">Client Partner · Aarav Mehta</span>
                                <span class="text-[10px] text-slate-500 font-mono">aarav@agency.com (Ivate Ayurveda Only)</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5">Sign In <i data-lucide="arrow-right" class="w-3 h-3"></i></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        function fillCredentials(email, pass, autoSubmit = false) {
            const emailInput = document.getElementById('inputEmail');
            const passInput = document.getElementById('inputPassword');
            emailInput.value = email;
            passInput.value = pass;
            
            // Visual feedback highlight
            emailInput.classList.add('ring-2', 'ring-emerald-500');
            passInput.classList.add('ring-2', 'ring-emerald-500');
            setTimeout(() => {
                emailInput.classList.remove('ring-2', 'ring-emerald-500');
                passInput.classList.remove('ring-2', 'ring-emerald-500');
            }, 600);

            if (autoSubmit) {
                setTimeout(() => {
                    const form = document.querySelector('form');
                    if (form) form.submit();
                }, 180);
            }
        }

        function applyTheme(theme) {
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');
            const label = document.getElementById('themeLabel');

            if (theme === 'dark') {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (icon) icon.setAttribute('data-lucide', 'sun');
                if (icon) icon.className = 'w-4 h-4 text-amber-400';
                if (label) label.textContent = 'Dark Mode';
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('theme', 'light');
                if (icon) icon.setAttribute('data-lucide', 'moon');
                if (icon) icon.className = 'w-4 h-4 text-indigo-500';
                if (label) label.textContent = 'Light Mode';
            }
            if (window.lucide) {
                lucide.createIcons();
            }
        }

        function toggleTheme() {
            const current = localStorage.getItem('theme') || 'light';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        }

        // Initialize: Default to Light Theme
        const currentTheme = localStorage.getItem('theme') || 'light';
        applyTheme(currentTheme);
    </script>
</body>
</html>
