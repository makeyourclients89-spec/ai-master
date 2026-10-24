<!DOCTYPE html>
<html lang="en" class="h-full light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account · Agency OS</title>
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
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                START IN SECONDS
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight">
                Launch your agency OS without <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-indigo-300 italic">delays.</span>
            </h1>
            <p class="text-slate-300 text-sm leading-relaxed">
                Create your account and jump straight into your dashboard. No email verification waiting period, no activation links—just immediate direct access.
            </p>

            <div class="pt-4 space-y-3">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10 text-slate-200 text-xs font-medium backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/30 text-emerald-300 flex items-center justify-center shrink-0"><i data-lucide="zap" class="w-4 h-4"></i></div>
                    <span>Instant workspace initialization and auto-login</span>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/10 text-slate-200 text-xs font-medium backdrop-blur-sm">
                    <div class="w-7 h-7 rounded-lg bg-indigo-500/30 text-indigo-300 flex items-center justify-center shrink-0"><i data-lucide="bot" class="w-4 h-4"></i></div>
                    <span>Ready for AI agents: OpenAI, Gemini & Anthropic</span>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs text-slate-400 flex items-center justify-between">
            <span>PROJECT OPERATING PLATFORM</span>
            <span class="font-mono text-indigo-300">01 / FOUNDATION</span>
        </div>
    </div>

    <!-- Right Register Card Panel -->
    <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 relative">
        
        <!-- Top Controls: Theme Switcher & Login Link -->
        <div class="w-full max-w-md flex items-center justify-between mb-6">
            <button id="themeToggleBtn" onclick="toggleTheme()" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-dark-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 shadow-sm hover:border-indigo-400 dark:hover:border-indigo-500 transition cursor-pointer">
                <i id="themeIcon" data-lucide="sun" class="w-4 h-4 text-amber-500"></i>
                <span id="themeLabel">Light Mode</span>
            </button>

            <a href="<?= site_url('login') ?>" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold flex items-center gap-1">
                Sign in <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="w-full max-w-md">
            
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center gap-2 mb-6">
                <span class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg">A↗</span>
                <span class="font-bold tracking-tight text-xl text-slate-900 dark:text-white">agency<span class="text-indigo-600 dark:text-indigo-400">OS</span></span>
            </div>

            <!-- Card -->
            <div class="bg-white dark:bg-dark-700/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-7 sm:p-8 shadow-xl dark:shadow-2xl">
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 block mb-1">DIRECT REGISTRATION</span>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight mb-2">Create your account</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Start with your account. Instant direct access to your workspace.</p>

                <!-- Alerts -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-5 p-3 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-700 dark:text-rose-400 text-xs flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('register') ?>" method="POST" class="space-y-4">
                    <?= csrf_field() ?>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Full name</label>
                        <div class="relative">
                            <input type="text" name="name" value="<?= old('name') ?>" required placeholder="Your full name" class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition">
                            <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email address</label>
                        <div class="relative">
                            <input type="email" name="email" value="<?= old('email') ?>" required placeholder="you@company.com" class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Password</label>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400">At least 6 characters</span>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" required minlength="6" placeholder="Choose a password" class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-dark-600 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 transition">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold text-sm transition shadow-lg shadow-emerald-600/25 flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <span>Create account & enter</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-500"></i> No verification email needed</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-mono text-[11px]">Instant Access</span>
                </div>
            </div>

        </div>
    </div>

    <script>
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

        const currentTheme = localStorage.getItem('theme') || 'light';
        applyTheme(currentTheme);
    </script>
</body>
</html>
