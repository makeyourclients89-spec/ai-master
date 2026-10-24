<!DOCTYPE html>
<html lang="en" class="h-full light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Agency OS') ?> · AI Master Agency</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Pre-render check for sidebar collapse: default to collapsed / icon rail ("default me left side hide ho")
        try {
            const saved = localStorage.getItem('sidebar_collapsed');
            if (saved !== 'false' && window.innerWidth >= 768) {
                document.documentElement.classList.add('sidebar-is-collapsed');
            }
        } catch (e) {}
    </script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            900: '#070a0f',
                            800: '#0b0f17',
                            700: '#111726',
                            600: '#172033',
                            500: '#1f2b45',
                        },
                        brand: {
                            50: '#eef2ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"DM Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.2s ease, color 0.2s ease; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        html.dark ::-webkit-scrollbar-track { background: #0b0f17; }
        html.dark ::-webkit-scrollbar-thumb { background: #1f2b45; }
        
        .glass-panel {
            background: #111726;
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
        .glow-effect {
            box-shadow: 0 0 25px -5px rgba(99, 102, 241, 0.25);
        }

        /* ==========================================================================
           LIGHT THEME COMPLETE DESIGN SYSTEM (World-Class SaaS Finish)
           ========================================================================== */
        html.light {
            color-scheme: light;
        }

        html.light body {
            background-color: #f8fafc !important;
            color: #1e293b !important;
        }

        /* ==========================================================================
           LEFT SIDEBAR STYLING (ADAPTIVE LIGHT & DARK THEMES)
           ========================================================================== */
        /* ==========================================================================
           LEFT SIDEBAR STYLING (USER REQUIREMENT)
           - In Light Mode: Left sidebar is DARK COLOR (#0b0f17) matching Top Nav!
           - In Dark Mode: Left sidebar is LIGHT COLOR (#ffffff) for contrast!
           ========================================================================== */
        /* 1. LIGHT MODE: LEFT SIDEBAR IS DARK COLOR (#0b0f17) */
        html.light aside#sidebar,
        html.light .md\:hidden {
            background-color: #0b0f17 !important;
            border-color: #1e293b !important;
            border-right: 1px solid #1e293b !important;
            color: #f8fafc !important;
            box-shadow: 1px 0 10px 0 rgba(0, 0, 0, 0.35) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        html.light aside#sidebar * {
            border-color: #1e293b !important;
        }
        html.light aside#sidebar a.sidebar-nav-item:not(.active-nav) {
            color: #cbd5e1 !important;
            background-color: transparent !important;
        }
        html.light aside#sidebar a.sidebar-nav-item:not(.active-nav):hover {
            background-color: #162032 !important;
            color: #ffffff !important;
        }
        html.light aside#sidebar a.sidebar-nav-item:not(.active-nav) i {
            color: #94a3b8 !important;
        }
        html.light aside#sidebar a.sidebar-nav-item:not(.active-nav):hover i {
            color: #ffffff !important;
        }
        html.light aside#sidebar [class*="bg-slate-50"],
        html.light aside#sidebar [class*="dark:bg-slate-50"],
        html.light aside#sidebar [class*="dark:bg-dark-600"] {
            background-color: #131b2e !important;
            border-color: #1e293b !important;
        }
        html.light aside#sidebar select {
            color: #f8fafc !important;
            background-color: transparent !important;
        }
        html.light aside#sidebar select option {
            background-color: #0b0f17 !important;
            color: #f8fafc !important;
        }
        html.light aside#sidebar .text-slate-900,
        html.light aside#sidebar .text-slate-800,
        html.light aside#sidebar span.text-slate-900,
        html.light aside#sidebar span.font-bold {
            color: #f8fafc !important;
        }
        html.light aside#sidebar .text-slate-400,
        html.light aside#sidebar .text-slate-500 {
            color: #94a3b8 !important;
        }
        html.light aside#sidebar button {
            color: #94a3b8 !important;
        }
        html.light aside#sidebar button:hover {
            color: #ffffff !important;
            background-color: #162032 !important;
        }
        html.light aside#sidebar > div:last-child {
            background-color: #0e1422 !important;
            border-top: 1px solid #1e293b !important;
        }

        /* 2. DARK MODE: LEFT SIDEBAR IS LIGHT COLOR (#ffffff) */
        html.dark aside#sidebar {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            border-right: 1px solid #e2e8f0 !important;
            color: #0f172a !important;
            box-shadow: 1px 0 6px 0 rgba(0, 0, 0, 0.06) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        html.dark aside#sidebar * {
            border-color: #e2e8f0 !important;
        }
        html.dark aside#sidebar a.sidebar-nav-item:not(.active-nav) {
            color: #475569 !important;
            background-color: transparent !important;
        }
        html.dark aside#sidebar a.sidebar-nav-item:not(.active-nav):hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        html.dark aside#sidebar a.sidebar-nav-item:not(.active-nav) i {
            color: #64748b !important;
        }
        html.dark aside#sidebar a.sidebar-nav-item:not(.active-nav):hover i {
            color: #0f172a !important;
        }
        html.dark aside#sidebar [class*="bg-slate-50"],
        html.dark aside#sidebar [class*="dark:bg-slate-50"],
        html.dark aside#sidebar [class*="dark:bg-dark-600"] {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }
        html.dark aside#sidebar select {
            color: #0f172a !important;
            background-color: transparent !important;
        }
        html.dark aside#sidebar select option {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
        html.dark aside#sidebar .text-slate-900,
        html.dark aside#sidebar .text-slate-800,
        html.dark aside#sidebar .dark\:text-white,
        html.dark aside#sidebar span.font-bold {
            color: #0f172a !important;
        }
        html.dark aside#sidebar button {
            color: #64748b !important;
        }
        html.dark aside#sidebar button:hover {
            color: #0f172a !important;
            background-color: #f1f5f9 !important;
        }
        html.dark aside#sidebar > div:last-child {
            background-color: #f8fafc !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        /* Topbar Header & Footer in Light Mode */
        html.light header h1 {
            color: #0f172a !important;
        }
        html.light footer {
            border-color: #e2e8f0 !important;
            background-color: #ffffff !important;
            color: #64748b !important;
        }

        /* ==========================================================================
           TOP MENU STYLING (USER REQUIREMENT):
           1. Jab Light Mode (लाइव मोड) ho -> Top Navigation Menu DARK COLOR me aaye!
           2. Jab Dark Mode ON ho -> Top Menu Light Mode Background (White) me aaye!
           ========================================================================== */
        
        /* 1. LIGHT MODE: TOP NAVIGATION IS DARK COLOR (#0b0f17) */
        html.light #mainTopNav {
            background-color: #0b0f17 !important;
            border-bottom: 1px solid #1e293b !important;
            color: #f8fafc !important;
            box-shadow: 0 4px 14px 0 rgba(0, 0, 0, 0.25) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        html.light #mainTopNav * {
            border-color: #1e293b !important;
        }
        html.light #mainTopNav a.top-nav-link:not(.active-nav) {
            color: #cbd5e1 !important;
            background-color: transparent !important;
        }
        html.light #mainTopNav a.top-nav-link:not(.active-nav):hover {
            background-color: #162032 !important;
            color: #ffffff !important;
        }
        html.light #mainTopNav a.top-nav-link:not(.active-nav) i {
            color: #94a3b8 !important;
        }
        html.light #mainTopNav a.top-nav-link:not(.active-nav):hover i {
            color: #ffffff !important;
        }
        html.light #mainTopNav #sidebarToggleBtn,
        html.light #mainTopNav #themeToggleBtn {
            background-color: #131b2e !important;
            border: 1px solid #1e293b !important;
            color: #cbd5e1 !important;
        }
        html.light #mainTopNav #sidebarToggleBtn:hover,
        html.light #mainTopNav #themeToggleBtn:hover {
            background-color: #1e2a42 !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }
        html.light #mainTopNav select {
            background-color: transparent !important;
            color: #f8fafc !important;
        }
        html.light #mainTopNav select option {
            background-color: #0b0f17 !important;
            color: #f8fafc !important;
        }
        html.light #mainTopNav .text-slate-900,
        html.light #mainTopNav .text-slate-800,
        html.light #mainTopNav span.text-slate-900,
        html.light #mainTopNav span.font-bold {
            color: #f8fafc !important;
        }
        html.light #mainTopNav .text-slate-500,
        html.light #mainTopNav .text-slate-600 {
            color: #94a3b8 !important;
        }

        /* 2. DARK MODE: TOP NAVIGATION IS LIGHT MODE BACKGROUND (#ffffff) */
        html.dark #mainTopNav {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            color: #0f172a !important;
            box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        html.dark #mainTopNav * {
            border-color: #e2e8f0 !important;
        }
        html.dark #mainTopNav a.top-nav-link:not(.active-nav) {
            color: #475569 !important;
            background-color: transparent !important;
        }
        html.dark #mainTopNav a.top-nav-link:not(.active-nav):hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        html.dark #mainTopNav a.top-nav-link:not(.active-nav) i {
            color: #64748b !important;
        }
        html.dark #mainTopNav a.top-nav-link:not(.active-nav):hover i {
            color: #0f172a !important;
        }
        html.dark #mainTopNav #sidebarToggleBtn,
        html.dark #mainTopNav #themeToggleBtn {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            color: #334155 !important;
        }
        html.dark #mainTopNav #sidebarToggleBtn:hover,
        html.dark #mainTopNav #themeToggleBtn:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }
        html.dark #mainTopNav select {
            background-color: transparent !important;
            color: #0f172a !important;
        }
        html.dark #mainTopNav select option {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
        html.dark #mainTopNav .text-slate-900,
        html.dark #mainTopNav .text-slate-800,
        html.dark #mainTopNav .dark\:text-white,
        html.dark #mainTopNav span.font-bold {
            color: #0f172a !important;
        }
        html.dark #mainTopNav .text-slate-500,
        html.dark #mainTopNav .text-slate-600 {
            color: #64748b !important;
        }

        /* Distinct Sapphire Highlight for Active Top Nav & Active Sidebar Items */
        html.light #mainTopNav a.top-nav-link.active-nav,
        html.dark #mainTopNav a.top-nav-link.active-nav,
        #mainTopNav a.top-nav-link.active-nav,
        #mainTopNav a.top-nav-link.bg-blue-600,
        html.light #sidebar .sidebar-nav-item.active-nav,
        html.dark #sidebar .sidebar-nav-item.active-nav,
        #sidebar .sidebar-nav-item.active-nav,
        #sidebar .sidebar-nav-item.bg-blue-600 {
            background-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px -1px rgba(37, 99, 235, 0.4) !important;
        }
        html.light #mainTopNav a.top-nav-link.active-nav *,
        html.dark #mainTopNav a.top-nav-link.active-nav *,
        #mainTopNav a.top-nav-link.active-nav *,
        #mainTopNav a.top-nav-link.bg-blue-600 *,
        html.light #sidebar .sidebar-nav-item.active-nav *,
        html.dark #sidebar .sidebar-nav-item.active-nav *,
        #sidebar .sidebar-nav-item.active-nav *,
        #sidebar .sidebar-nav-item.bg-blue-600 * {
            color: #ffffff !important;
            stroke: #ffffff !important;
        }
        #mainTopNav button.btn-new-project {
            background-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px -1px rgba(37, 99, 235, 0.3) !important;
        }
        #mainTopNav button.btn-new-project:hover {
            background-color: #1d4ed8 !important;
        }
        #mainTopNav button.btn-new-project * {
            color: #ffffff !important;
        }

        /* Distinct Highlight for Project Step Workflow Tabs */
        html.light .workflow-tabs-bar {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
        }
        html.dark .workflow-tabs-bar {
            background-color: #111726 !important;
            border: 1px solid #1e293b !important;
        }
        .tab-btn.active-tab,
        html.light .tab-btn.active-tab,
        html.dark .tab-btn.active-tab {
            background-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 8px -1px rgba(37, 99, 235, 0.45) !important;
            border-color: transparent !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        .tab-btn.active-tab span,
        html.light .tab-btn.active-tab span,
        html.dark .tab-btn.active-tab span {
            color: #ffffff !important;
        }
        .tab-btn.active-tab .step-badge,
        html.light .tab-btn.active-tab .step-badge,
        html.dark .tab-btn.active-tab .step-badge {
            background-color: #ffffff !important;
            color: #2563eb !important;
            font-weight: 800 !important;
        }
        .tab-btn.active-tab .tab-count-pill,
        html.light .tab-btn.active-tab .tab-count-pill,
        html.dark .tab-btn.active-tab .tab-count-pill {
            background-color: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* Inactive tabs */
        html.light .tab-btn:not(.active-tab) {
            color: #475569 !important;
            background-color: transparent !important;
            font-weight: 600 !important;
            border-color: transparent !important;
        }
        html.light .tab-btn:not(.active-tab):hover {
            color: #0f172a !important;
            background-color: #f1f5f9 !important;
        }
        html.light .tab-btn:not(.active-tab) .step-badge {
            background-color: #e2e8f0 !important;
            color: #475569 !important;
        }

        html.dark .tab-btn:not(.active-tab) {
            color: #94a3b8 !important;
            background-color: transparent !important;
            font-weight: 600 !important;
            border-color: transparent !important;
        }
        html.dark .tab-btn:not(.active-tab):hover {
            color: #ffffff !important;
            background-color: #162032 !important;
        }
        html.dark .tab-btn:not(.active-tab) .step-badge {
            background-color: #1e293b !important;
            color: #94a3b8 !important;
        }

        /* ==========================================================================
           COLLAPSIBLE SIDEBAR: ICON-ONLY RAIL (DEFAULT HIDE / EXPAND ON CLICK)
           ========================================================================== */
        #sidebar {
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1),
                        min-width 0.25s cubic-bezier(0.4, 0, 0.2, 1),
                        max-width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 768px) {
            /* In collapsed mode, sidebar is a slim icon rail (68px) */
            #sidebar.sidebar-collapsed,
            html.sidebar-is-collapsed #sidebar {
                width: 4.25rem !important; /* 68px */
                min-width: 4.25rem !important;
                max-width: 4.25rem !important;
            }

            /* Hide labels and expanded text when collapsed */
            #sidebar.sidebar-collapsed .sidebar-text,
            #sidebar.sidebar-collapsed .sidebar-expanded-only,
            html.sidebar-is-collapsed #sidebar .sidebar-text,
            html.sidebar-is-collapsed #sidebar .sidebar-expanded-only {
                display: none !important;
            }

            /* Center icons in collapsed mode */
            #sidebar.sidebar-collapsed .sidebar-nav-item,
            html.sidebar-is-collapsed #sidebar .sidebar-nav-item {
                justify-content: center !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                width: 2.75rem !important;
                height: 2.75rem !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            #sidebar.sidebar-collapsed .sidebar-collapsed-only,
            html.sidebar-is-collapsed #sidebar .sidebar-collapsed-only {
                display: flex !important;
            }

            #sidebar:not(.sidebar-collapsed) .sidebar-collapsed-only {
                display: none !important;
            }
        }

        @media (max-width: 767px) {
            #sidebar {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                height: 100vh !important;
                z-index: 50 !important;
                transform: translateX(-100%);
            }
            #sidebar.mobile-open {
                transform: translateX(0) !important;
            }
        }

        /* Floating Tooltips in Collapsed Mode */
        .sidebar-tooltip {
            display: none;
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 0.75rem;
            padding: 0.35rem 0.65rem;
            background-color: #0f172a;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
            border-radius: 0.5rem;
            border: 1px solid #334155;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
            z-index: 60;
            pointer-events: none;
        }

        #sidebar.sidebar-collapsed .sidebar-nav-item:hover .sidebar-tooltip,
        html.sidebar-is-collapsed #sidebar .sidebar-nav-item:hover .sidebar-tooltip,
        #sidebar.sidebar-collapsed .group:hover .sidebar-tooltip,
        html.sidebar-is-collapsed #sidebar .group:hover .sidebar-tooltip {
            display: flex !important;
        }

        /* Glass Panels and Cards */
        html.light .glass-panel,
        html.light [class*="bg-dark-700"],
        html.light [class*="bg-dark-800"],
        html.light [class*="bg-dark-900"] {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05) !important;
        }

        /* Inner list cards (AI Agent cards, task items, rows) */
        html.light [class*="bg-dark-600"] {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }
        html.light [class*="bg-dark-600"]:hover {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
        }
        html.light [class*="bg-dark-500"] {
            background-color: #eef2ff !important;
            color: #4338ca !important;
            border-color: #c7d2fe !important;
        }

        /* All dark borders converted to crisp light borders */
        html.light [class*="border-slate-800"],
        html.light [class*="border-slate-700"] {
            border-color: #e2e8f0 !important;
        }

        /* Top Hero Banner in Dashboard */
        html.light .bg-gradient-to-r.from-dark-700 {
            background: linear-gradient(135deg, #eef2ff 0%, #ffffff 50%, #faf5ff 100%) !important;
            border-color: #e0e7ff !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04) !important;
        }
        html.light .bg-gradient-to-r.from-dark-700 h1 {
            color: #0f172a !important;
        }
        html.light .bg-gradient-to-r.from-dark-700 p {
            color: #475569 !important;
        }
        html.light .bg-gradient-to-r.from-dark-700 strong {
            color: #4f46e5 !important;
        }
        html.light .bg-gradient-to-r.from-dark-700 a.bg-dark-600 {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            color: #334155 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        html.light .bg-gradient-to-r.from-dark-700 a.bg-dark-600:hover {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        /* Headings & Text Color Fixes */
        html.light h1:not(.dark-theme-card *):not(.force-dark *),
        html.light h2:not(.dark-theme-card *):not(.force-dark *),
        html.light h3:not(.dark-theme-card *):not(.force-dark *),
        html.light h4:not(.dark-theme-card *):not(.force-dark *),
        html.light h5:not(.dark-theme-card *):not(.force-dark *),
        html.light strong:not(.bg-indigo-600 *):not(.dark-theme-card *):not(.force-dark *) {
            color: #0f172a !important;
        }
        html.light [class*="text-slate-100"]:not(.dark-theme-card *):not(.force-dark *),
        html.light [class*="text-slate-200"]:not(.dark-theme-card *):not(.force-dark *) {
            color: #1e293b !important;
        }
        html.light [class*="text-slate-300"]:not(.dark-theme-card *):not(.force-dark *) {
            color: #334155 !important;
        }
        html.light [class*="text-slate-400"]:not(.dark-theme-card *):not(.force-dark *) {
            color: #64748b !important;
        }
        html.light [class*="text-slate-500"]:not(.dark-theme-card *):not(.force-dark *) {
            color: #94a3b8 !important;
        }

        /* Prevent invisible white-on-white text in Light Mode: map text-white on content cards to dark slate */
        html.light .glass-panel:not(.dark-theme-card) .text-white,
        html.light [class*="bg-dark-"]:not(.dark-theme-card):not(.dark-theme-card *) .text-white,
        html.light .p-4:not(.dark-theme-card):not(.dark-theme-card *) .text-white,
        html.light .p-6:not(.dark-theme-card):not(.dark-theme-card *) .text-white {
            color: #0f172a !important;
        }

        /* INTENTIONALLY DARK CARDS (e.g. AI Knowledge Base, Terminal, Code Editors) */
        .dark-theme-card,
        .dark-theme-card h1,
        .dark-theme-card h2,
        .dark-theme-card h3,
        .dark-theme-card h4,
        .dark-theme-card h5,
        .dark-theme-card [class*="text-white"],
        .dark-theme-card .text-white {
            color: #ffffff !important;
        }
        .dark-theme-card [class*="text-slate-100"],
        .dark-theme-card [class*="text-slate-200"] {
            color: #e2e8f0 !important;
        }
        .dark-theme-card [class*="text-slate-300"] {
            color: #cbd5e1 !important;
        }
        .dark-theme-card [class*="text-slate-400"] {
            color: #94a3b8 !important;
        }
        .dark-theme-card [class*="text-indigo-200"] {
            color: #c7d2fe !important;
        }
        .dark-theme-card [class*="text-indigo-300"] {
            color: #a5b4fc !important;
        }
        .dark-theme-card [class*="text-indigo-400"] {
            color: #818cf8 !important;
        }

        /* ABSOLUTE GUARANTEE: Primary Indigo & Emerald buttons ALWAYS have pure white text */
        html.light .bg-indigo-600,
        html.light .bg-indigo-600 *,
        html.light a.bg-indigo-600,
        html.light a.bg-indigo-600 *,
        html.light button.bg-indigo-600,
        html.light button.bg-indigo-600 *,
        html.light .bg-emerald-600,
        html.light .bg-emerald-600 *,
        html.light .rounded-full.bg-gradient-to-tr,
        html.light .rounded-full.bg-gradient-to-tr *,
        html.light span.w-9.h-9.bg-gradient-to-tr,
        html.light span.w-9.h-9.bg-gradient-to-tr *,
        html.light span.w-10.h-10.bg-gradient-to-tr,
        html.light span.w-10.h-10.bg-gradient-to-tr * {
            color: #ffffff !important;
            fill: #ffffff !important;
        }
        html.light .bg-indigo-600 {
            background-color: #4f46e5 !important;
        }
        html.light .bg-indigo-600:hover {
            background-color: #4338ca !important;
        }

        /* Form Inputs & Selects */
        html.light input,
        html.light select,
        html.light textarea {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }
        html.light input::placeholder,
        html.light textarea::placeholder {
            color: #94a3b8 !important;
        }
        html.light select option {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }

        /* Badges & Status Pills */
        html.light [class*="bg-emerald-500"] {
            background-color: #ecfdf5 !important;
            border-color: #a7f3d0 !important;
            color: #047857 !important;
        }
        html.light [class*="bg-indigo-500"] {
            background-color: #eef2ff !important;
            border-color: #c7d2fe !important;
            color: #4338ca !important;
        }
        html.light [class*="bg-purple-500"] {
            background-color: #faf5ff !important;
            border-color: #e9d5ff !important;
            color: #7e22ce !important;
        }
        html.light [class*="bg-amber-500"] {
            background-color: #fffbeb !important;
            border-color: #fde68a !important;
            color: #b45309 !important;
        }
        html.light [class*="bg-rose-500"] {
            background-color: #fff1f2 !important;
            border-color: #fecdd3 !important;
            color: #be123c !important;
        }

        /* Theme Toggle Button */
        html.light #themeToggleBtn {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #334155 !important;
        }
        html.light #themeToggleBtn:hover {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }

        /* Modals in Light Mode */
        html.light #modalCreateProject [class*="bg-dark-700"],
        html.light #modalCreateWorkspace [class*="bg-dark-700"] {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
</head>
<body class="h-screen flex flex-col antialiased bg-[#0b0f17] text-slate-100 selection:bg-indigo-500 selection:text-white overflow-hidden">

    <!-- 1. FULL-WIDTH TOP MENU (BILKUL STARTING ME SPANNING ACROSS SCREEN) -->
    <header id="mainTopNav" class="w-full h-14 sticky top-0 z-40 shrink-0 px-3 sm:px-6 flex items-center justify-between gap-2 sm:gap-4 select-none">
        <!-- Left: Sidebar Toggle + Brand Logo + Compact Workspace Switcher -->
        <div class="flex items-center gap-2 sm:gap-3.5 shrink-0">
            <!-- Sidebar Hide/Show Toggle Button -->
            <button id="sidebarToggleBtn" onclick="toggleSidebar()" type="button" 
                    class="p-2 rounded-xl text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-dark-600 border border-slate-200/80 dark:border-slate-700/80 transition cursor-pointer shadow-2xs flex items-center justify-center group"
                    title="Toggle Sidebar (Hide / Show) · Shortcut: Ctrl+B">
                <i id="sidebarToggleIcon" data-lucide="panel-left" class="w-4 h-4 group-hover:scale-110 transition"></i>
            </button>

            <!-- Brand Logo -->
            <a href="<?= site_url('dashboard') ?>" class="flex items-center gap-2 group">
                <span class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center font-black text-white shadow-md shadow-indigo-600/30 group-hover:scale-105 transition">A↗</span>
                <span class="font-bold tracking-tight text-base sm:text-lg text-slate-900 dark:text-white flex items-center gap-1.5">
                    agency<span class="text-indigo-600 dark:text-indigo-400">OS</span>
                    <span class="hidden sm:inline-block text-[9px] uppercase font-bold px-1.5 py-0.5 rounded bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30">CI4</span>
                </span>
            </a>

            <!-- Compact Workspace Dropdown (Top Menu Quick Switcher) -->
            <div class="hidden xl:flex items-center gap-1.5 pl-3 border-l border-slate-200 dark:border-slate-700/80 text-xs">
                <div class="w-5 h-5 rounded-md bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-bold text-[10px] uppercase shrink-0">
                    <?= substr($activeWorkspace['name'] ?? 'W', 0, 1) ?>
                </div>
                <select onchange="window.location.href='<?= site_url('workspace/switch/') ?>' + this.value" class="bg-transparent text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none cursor-pointer max-w-[140px] truncate py-1">
                    <?php foreach ($workspaces ?? [] as $ws): ?>
                        <option value="<?= $ws['id'] ?>" class="bg-white dark:bg-dark-700 text-slate-900 dark:text-white" <?= ($ws['id'] == ($activeWorkspace['id'] ?? 0)) ? 'selected' : '' ?>>
                            <?= esc($ws['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button onclick="document.getElementById('modalCreateWorkspace').classList.remove('hidden')" class="p-1 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded transition cursor-pointer" title="Create Workspace">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>

        <!-- Center: CLEAR TOP MENU NAVIGATION (BILKUL STARTING ME SE SAB KUCH VISIBLE) -->
        <?php $isClientNav = is_client_user(); ?>
        <nav class="hidden md:flex items-center gap-1 overflow-x-auto py-1 scrollbar-none">
            <!-- 1. Overview -->
            <a href="<?= site_url('dashboard') ?>" 
               class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'dashboard' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                <i data-lucide="<?= $isClientNav ? 'building' : 'layout-dashboard' ?>" class="w-3.5 h-3.5"></i>
                <span><?= $isClientNav ? 'Client Portal' : 'Overview' ?></span>
            </a>

            <!-- 2. Projects -->
            <a href="<?= site_url('projects') ?>" 
               class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'projects' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                <i data-lucide="folder-kanban" class="w-3.5 h-3.5"></i>
                <span><?= $isClientNav ? 'My Projects' : 'Projects' ?></span>
                <?php if (isset($projects) && count($projects) > 0): ?>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full <?= ($currentPage ?? '') === 'projects' ? 'bg-white/25 text-white' : 'bg-slate-100 dark:bg-dark-500 text-slate-600 dark:text-slate-400' ?>"><?= count($projects) ?></span>
                <?php endif; ?>
            </a>

            <?php if (!$isClientNav): ?>
                <!-- 3. Skills & SOPs -->
                <a href="<?= site_url('skills/') ?>" 
                   class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'skills' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500 dark:text-amber-400"></i>
                    <span>Skills & SOPs</span>
                </a>

                <!-- 4. AI & Agents -->
                <a href="<?= site_url('agents') ?>" 
                   class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'agents' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                    <i data-lucide="bot" class="w-3.5 h-3.5"></i>
                    <span>AI & Agents</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                </a>

                <!-- 5. People & Team -->
                <a href="<?= site_url('team') ?>" 
                   class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'team' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                    <i data-lucide="users" class="w-3.5 h-3.5"></i>
                    <span>Team</span>
                </a>
            <?php endif; ?>

            <!-- 6. Activity -->
            <a href="<?= site_url('activity') ?>" 
               class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'activity' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                <span>Activity</span>
            </a>

            <?php if (!$isClientNav && is_admin_user()): ?>
                <!-- 7. Billing & Plans -->
                <a href="<?= site_url('billing') ?>" 
                   class="top-nav-link flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition <?= ($currentPage ?? '') === 'billing' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-dark-600 hover:text-slate-900 dark:hover:text-white' ?>">
                    <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                    <span>Billing</span>
                </a>
            <?php endif; ?>
        </nav>

        <!-- Right: Actions + Theme Toggle + New Project + User Avatar & Logout -->
        <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
            <!-- Theme Toggle Button -->
            <button id="themeToggleBtn" onclick="toggleTheme()" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-dark-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-700 dark:text-slate-300 text-xs font-semibold transition cursor-pointer shadow-2xs">
                <i id="themeIcon" data-lucide="sun" class="w-3.5 h-3.5 text-amber-500"></i>
                <span id="themeLabel" class="hidden sm:inline">Light</span>
            </button>

            <?php if (!$isClientNav): ?>
                <!-- New Project Button (Agency staff only) -->
                <button onclick="document.getElementById('modalCreateProject').classList.remove('hidden')" class="btn-new-project flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition shadow-xs shadow-blue-600/30 cursor-pointer">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">New Project</span>
                </button>
            <?php else: ?>
                <!-- Client Portal Badge -->
                <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Client Portal
                </span>
            <?php endif; ?>

            <!-- User Avatar & Logout -->
            <div class="flex items-center gap-1.5 sm:gap-2 pl-1 sm:pl-2 border-l border-slate-200 dark:border-slate-700/80">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-xs text-white uppercase shadow-sm" title="<?= esc(session()->get('user_name') ?? 'User') ?>">
                    <?= substr(session()->get('user_name') ?? 'U', 0, 1) ?>
                </div>
                <a href="<?= site_url('logout') ?>" title="Sign Out" class="p-1.5 text-slate-400 hover:text-rose-500 dark:hover:text-rose-400 rounded-lg hover:bg-slate-100 dark:hover:bg-dark-600 transition">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- 2. MAIN WORKSPACE WRAPPER (SIDEBAR + MAIN CONTENT AREA) -->
    <div class="flex-1 flex min-h-0 overflow-hidden relative">

        <!-- Mobile Drawer Backdrop -->
        <div id="sidebarBackdrop" onclick="toggleSidebar(false)" class="hidden fixed inset-0 bg-black/60 z-40 md:hidden transition-opacity"></div>

        <!-- COLLAPSIBLE LEFT SIDEBAR (ALWAYS LIGHT BACKGROUND WITH SAPPHIRE HIGHLIGHT) -->
        <aside id="sidebar" class="flex flex-col w-64 bg-white dark:bg-white border-r border-slate-200 dark:border-slate-200 shrink-0 h-full z-30 select-none">
            <!-- Sidebar Header with Hide Button -->
            <div class="h-12 px-3 border-b border-slate-100 dark:border-slate-200 flex items-center justify-between shrink-0">
                <div class="sidebar-expanded-only flex items-center justify-between w-full">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">WORKSPACE NAVIGATION</span>
                    <button onclick="toggleSidebar()" type="button" class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer" title="Collapse to Icons (Ctrl+B)">
                        <i data-lucide="panel-left-close" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="sidebar-collapsed-only flex items-center justify-center w-full">
                    <button onclick="toggleSidebar()" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-slate-100 transition cursor-pointer" title="Expand Sidebar (Ctrl+B)">
                        <i data-lucide="panel-left-open" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Workspace Selector Card -->
            <div class="p-2 sm:p-3 border-b border-slate-100 dark:border-slate-200 shrink-0">
                <?php if ($isClientNav): ?>
                    <!-- Client Brand Card -->
                    <div class="sidebar-expanded-only bg-slate-50 dark:bg-slate-50 rounded-xl p-2.5 border border-slate-200/80 dark:border-slate-200">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] tracking-wider uppercase font-bold text-emerald-600">CLIENT ACCOUNT</span>
                            <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-100 text-emerald-700">Client</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-600 border border-emerald-500/30 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-xs font-bold text-slate-900 truncate block"><?= esc(session()->get('company_name') ?: session()->get('workspace_name')) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-collapsed-only flex items-center justify-center w-full py-1">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/15 text-emerald-600 border border-emerald-500/30 flex items-center justify-center font-bold text-sm uppercase shadow-2xs cursor-pointer group relative" onclick="toggleSidebar()" title="Client: <?= esc(session()->get('company_name') ?: 'Client') ?>">
                            <i data-lucide="building-2" class="w-4 h-4"></i>
                            <div class="sidebar-tooltip">Client: <?= esc(session()->get('company_name') ?: 'Client') ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Agency Expanded View -->
                    <div class="sidebar-expanded-only bg-slate-50 dark:bg-slate-50 rounded-xl p-2.5 border border-slate-200/80 dark:border-slate-200 hover:border-slate-300 transition">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] tracking-wider uppercase font-bold text-slate-400">WORKSPACE</span>
                            <button onclick="document.getElementById('modalCreateWorkspace').classList.remove('hidden')" class="text-[11px] text-indigo-600 hover:text-indigo-700 flex items-center gap-0.5 font-semibold cursor-pointer">
                                <i data-lucide="plus" class="w-3-h-3"></i> New
                            </button>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-600 border border-indigo-500/30 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                <?= substr($activeWorkspace['name'] ?? 'W', 0, 1) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <select onchange="window.location.href='<?= site_url('workspace/switch/') ?>' + this.value" class="w-full bg-transparent text-sm font-semibold text-slate-900 focus:outline-none cursor-pointer truncate">
                                    <?php foreach ($workspaces ?? [] as $ws): ?>
                                        <option value="<?= $ws['id'] ?>" class="bg-white text-slate-900" <?= ($ws['id'] == ($activeWorkspace['id'] ?? 0)) ? 'selected' : '' ?>>
                                            <?= esc($ws['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Collapsed View (Centered Badge with Tooltip) -->
                    <div class="sidebar-collapsed-only flex items-center justify-center w-full py-1">
                        <div class="w-9 h-9 rounded-xl bg-indigo-500/15 text-indigo-600 border border-indigo-500/30 flex items-center justify-center font-bold text-sm uppercase shadow-2xs cursor-pointer group relative" onclick="toggleSidebar()" title="Workspace: <?= esc($activeWorkspace['name'] ?? 'Workspace') ?>">
                            <?= substr($activeWorkspace['name'] ?? 'W', 0, 1) ?>
                            <div class="sidebar-tooltip">Workspace: <?= esc($activeWorkspace['name'] ?? 'Workspace') ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Navigation Menu -->
            <nav class="flex-1 px-2 sm:px-3 py-3 space-y-1.5 overflow-y-auto">
                <div class="sidebar-expanded-only px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Menu</div>
                
                <!-- Overview -->
                <a href="<?= site_url('dashboard') ?>" class="sidebar-nav-item flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'dashboard' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="<?= $isClientNav ? 'Client Portal' : 'Overview' ?>">
                    <i data-lucide="<?= $isClientNav ? 'building' : 'layout-dashboard' ?>" class="w-4 h-4 shrink-0"></i>
                    <span class="sidebar-text truncate"><?= $isClientNav ? 'Client Portal' : 'Overview' ?></span>
                    <span class="sidebar-tooltip"><?= $isClientNav ? 'Client Portal' : 'Overview' ?></span>
                </a>

                <!-- Projects -->
                <a href="<?= site_url('projects') ?>" class="sidebar-nav-item flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'projects' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="<?= $isClientNav ? 'My Projects' : 'Projects' ?>">
                    <div class="flex items-center gap-3 min-w-0">
                        <i data-lucide="folder-kanban" class="w-4 h-4 shrink-0"></i>
                        <span class="sidebar-text truncate"><?= $isClientNav ? 'My Projects' : 'Projects' ?></span>
                    </div>
                    <?php if (isset($projects)): ?>
                        <span class="sidebar-text text-[10px] px-1.5 py-0.2 rounded-full <?= ($currentPage ?? '') === 'projects' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' ?>"><?= count($projects) ?></span>
                    <?php endif; ?>
                    <span class="sidebar-tooltip"><?= $isClientNav ? 'My Projects' : 'Projects' ?> <?= isset($projects) ? '(' . count($projects) . ')' : '' ?></span>
                </a>

                <?php if (!$isClientNav): ?>
                    <!-- Skills & SOPs -->
                    <a href="<?= site_url('skills/') ?>" class="sidebar-nav-item flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'skills' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="Skills & SOPs">
                        <div class="flex items-center gap-3 min-w-0">
                            <i data-lucide="sparkles" class="w-4 h-4 text-amber-500 shrink-0"></i>
                            <span class="sidebar-text truncate">Skills & SOPs</span>
                        </div>
                        <span class="sidebar-text text-[9px] uppercase font-bold px-1.5 py-0.2 rounded bg-indigo-50 text-indigo-600 border border-indigo-200">Hub</span>
                        <span class="sidebar-tooltip">Skills & SOPs Hub</span>
                    </a>

                    <!-- AI & API Keys -->
                    <a href="<?= site_url('agents') ?>" class="sidebar-nav-item flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'agents' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="AI Agents">
                        <i data-lucide="bot" class="w-4 h-4 shrink-0"></i>
                        <span class="sidebar-text flex-1 truncate">AI & API Keys</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
                        <span class="sidebar-tooltip">Autonomous AI Agents</span>
                    </a>

                    <!-- People & Team -->
                    <a href="<?= site_url('team') ?>" class="sidebar-nav-item flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'team' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="Team">
                        <i data-lucide="users" class="w-4 h-4 shrink-0"></i>
                        <span class="sidebar-text truncate">People & Access</span>
                        <span class="sidebar-tooltip">People & Access</span>
                    </a>
                <?php endif; ?>

                <!-- Activity -->
                <a href="<?= site_url('activity') ?>" class="sidebar-nav-item flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'activity' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="Activity">
                    <i data-lucide="activity" class="w-4 h-4 shrink-0"></i>
                    <span class="sidebar-text truncate">Activity</span>
                    <span class="sidebar-tooltip">Activity Logs</span>
                </a>

                <?php if (!$isClientNav && is_admin_user()): ?>
                    <!-- Billing & Plans -->
                    <a href="<?= site_url('billing') ?>" class="sidebar-nav-item flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition group relative <?= ($currentPage ?? '') === 'billing' ? 'active-nav bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ?>" title="Billing">
                        <i data-lucide="credit-card" class="w-4 h-4 shrink-0"></i>
                        <span class="sidebar-text truncate">Plan & Usage</span>
                        <span class="sidebar-tooltip">Plan & Usage</span>
                    </a>
                <?php endif; ?>
            </nav>

            <!-- User Profile & Logout at Sidebar bottom -->
            <div class="p-2 sm:p-3 border-t border-slate-100 dark:border-slate-200 shrink-0 bg-slate-50 dark:bg-slate-50">
                <!-- Expanded View -->
                <div class="sidebar-expanded-only flex items-center justify-between">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-xs text-white uppercase shadow shrink-0">
                            <?= substr(session()->get('user_name') ?? 'U', 0, 1) ?>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-900 truncate"><?= esc(session()->get('user_name') ?? 'User') ?></p>
                            <p class="text-[10px] text-slate-500 truncate"><?= esc(session()->get('user_email') ?? '') ?></p>
                        </div>
                    </div>
                    <a href="<?= site_url('logout') ?>" title="Sign Out" class="p-1.5 text-slate-400 hover:text-rose-500 rounded-lg hover:bg-slate-200/60 transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Collapsed View (Avatar + Logout icon stacked centered) -->
                <div class="sidebar-collapsed-only flex flex-col items-center gap-2 w-full py-1">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-bold text-xs text-white uppercase shadow shrink-0 group relative cursor-pointer" onclick="toggleSidebar()" title="<?= esc(session()->get('user_name') ?? 'User') ?>">
                        <?= substr(session()->get('user_name') ?? 'U', 0, 1) ?>
                        <div class="sidebar-tooltip"><?= esc(session()->get('user_name') ?? 'User') ?></div>
                    </div>
                    <a href="<?= site_url('logout') ?>" class="p-1.5 text-slate-400 hover:text-rose-500 dark:hover:text-rose-400 rounded-lg hover:bg-slate-200/60 dark:hover:bg-dark-600 transition group relative" title="Sign Out">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <div class="sidebar-tooltip">Sign Out</div>
                    </a>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT SHELL (EXPANDS SMOOTHLY WHEN SIDEBAR IS COLLAPSED) -->
        <div id="mainContentShell" class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            
            <!-- Context Sub-bar / Breadcrumb Bar -->
            <div class="px-4 sm:px-6 py-2.5 border-b border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-dark-800 flex items-center justify-between text-xs shrink-0">
                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 min-w-0">
                    <span class="font-medium truncate"><?= esc($activeWorkspace['name'] ?? 'Workspace') ?></span>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="font-bold text-slate-900 dark:text-white truncate"><?= esc($title ?? 'Overview') ?></span>
                </div>
                
                <div class="flex items-center gap-3 text-[11px] text-slate-500 dark:text-slate-400 shrink-0">
                    <span class="hidden sm:inline">Press <kbd class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-dark-600 border border-slate-300 dark:border-slate-700 text-[10px] font-mono text-slate-700 dark:text-slate-300">Ctrl+B</kbd> to toggle sidebar</span>
                </div>
            </div>

            <!-- Flash Messages -->
            <div class="px-4 sm:px-6 pt-4">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flex items-center gap-3 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
                        <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('success')) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flex items-center gap-3 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-sm">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Body Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Footer -->
            <footer class="p-4 sm:p-5 border-t border-slate-200/80 dark:border-slate-800/80 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2 shrink-0">
                <div>
                    <strong>Agency OS</strong> · AI Project Operating Platform
                </div>
                <div class="flex items-center gap-2 text-slate-400">
                    <span>© <?= date('Y') ?> AI Master Agency</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal: Create Workspace -->
    <div id="modalCreateWorkspace" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80">
        <div class="w-full max-w-md bg-dark-700 border border-slate-700 rounded-2xl shadow-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-400"></i> Create New Workspace
                </h3>
                <button onclick="document.getElementById('modalCreateWorkspace').classList.add('hidden')" class="p-1 rounded-lg text-slate-400 hover:text-white">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="<?= site_url('workspace/create') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Workspace Name</label>
                    <input type="text" name="name" required placeholder="e.g. Northstar Media Studio" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('modalCreateWorkspace').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-dark-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition">Create Workspace</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Create Project -->
    <div id="modalCreateProject" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80">
        <div class="w-full max-w-2xl bg-dark-700 border border-slate-700 rounded-2xl shadow-2xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
                <div>
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i data-lucide="folder-plus" class="w-5 h-5 text-indigo-400"></i> Create Project
                    </h3>
                    <p class="text-xs text-slate-400">Define the core objective, department, and audience for your client project.</p>
                </div>
                <button onclick="document.getElementById('modalCreateProject').classList.add('hidden')" class="p-1 rounded-lg text-slate-400 hover:text-white">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <form action="<?= site_url('projects') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <!-- Step 1 Heading -->
                <div class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider flex items-center gap-1.5 pb-1 border-b border-slate-200 dark:border-slate-700">
                    <span class="w-4 h-4 rounded-full bg-indigo-600 text-white text-[10px] inline-flex items-center justify-center font-bold">1</span>
                    <span>Step 1: Project Name & Services</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Project Name</label>
                    <input type="text" name="name" required placeholder="e.g. Apex Search SEO Acceleration" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition">
                </div>

                <!-- Service Sections (Multi-Select) -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Services & Sections <span class="text-indigo-600 dark:text-indigo-400 font-normal lowercase">(multiple selection supported)</span>
                        </label>
                        <div class="flex items-center gap-2 text-[11px]">
                            <button type="button" onclick="toggleAllSections('modalCreateProject', true)" class="text-indigo-600 dark:text-indigo-400 hover:underline font-semibold cursor-pointer">Select All</button>
                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <button type="button" onclick="toggleAllSections('modalCreateProject', false)" class="text-slate-500 dark:text-slate-400 hover:underline cursor-pointer">Clear</button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <?php
                        $agencyServices = get_agency_services();
                        foreach ($agencyServices as $svcKey => $svc):
                        ?>
                            <label class="relative flex items-center gap-2 p-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-dark-600/70 hover:border-indigo-400 dark:hover:border-indigo-500/60 cursor-pointer select-none transition group has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/80 dark:has-[:checked]:bg-indigo-600/20 has-[:checked]:ring-1 has-[:checked]:ring-indigo-600">
                                <input type="checkbox" name="departments[]" value="<?= esc($svcKey) ?>" class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 h-4 w-4 bg-white dark:bg-dark-700 cursor-pointer" <?= $svcKey === 'Website' ? 'checked' : '' ?>>
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

                <!-- Step 2 Heading -->
                <div class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider flex items-center gap-1.5 pb-1 pt-2 border-b border-slate-200 dark:border-slate-700">
                    <span class="w-4 h-4 rounded-full bg-indigo-600 text-white text-[10px] inline-flex items-center justify-center font-bold">2</span>
                    <span>Step 2: Strategy Goals & Target Audience</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Main Objective</label>
                    <textarea name="objective" rows="2" placeholder="What core outcome does this project aim to achieve?" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Target Audience</label>
                        <input type="text" name="audience" placeholder="e.g. B2B Decision Makers" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Target Market</label>
                        <input type="text" name="market" placeholder="e.g. India, UAE, Global" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition">
                    </div>
                </div>

                <!-- Step 3 Heading -->
                <div class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider flex items-center gap-1.5 pb-1 pt-2 border-b border-slate-200 dark:border-slate-700">
                    <span class="w-4 h-4 rounded-full bg-indigo-600 text-white text-[10px] inline-flex items-center justify-center font-bold">3</span>
                    <span>Step 3: Platform & Delivery Metrics</span>
                </div>

                <!-- Platform -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Target Platform / Tech Stack</label>
                    <select name="platform" class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-dark-600 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-indigo-500 transition">
                        <option value="undecided">Not decided yet / Multi-platform</option>
                        <option value="wordpress">WordPress / WooCommerce</option>
                        <option value="custom">Custom Web Application / SaaS</option>
                        <option value="mobile">iOS / Android Mobile App</option>
                        <option value="shopify">Shopify E-Commerce</option>
                        <option value="meta_google">Meta Ads & Google Ads Networks</option>
                        <option value="other">Other / Webflow / Headless</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Website (Optional)</label>
                        <input type="url" name="website" placeholder="https://example.com" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Success Measures</label>
                        <input type="text" name="success_metrics" placeholder="e.g. 100k views, 50 qualified leads" class="w-full px-3.5 py-2.5 rounded-xl bg-dark-600 border border-slate-700 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-indigo-500 transition">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-800">
                    <button type="button" onclick="document.getElementById('modalCreateProject').classList.add('hidden')" class="px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:bg-dark-600">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition">Create Project</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleSidebar(forceState = null) {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const toggleIcon = document.getElementById('sidebarToggleIcon');
            if (!sidebar) return;

            const isMobile = window.innerWidth < 768;

            if (isMobile) {
                const isOpen = sidebar.classList.contains('mobile-open');
                const shouldOpen = forceState !== null ? forceState : !isOpen;

                if (shouldOpen) {
                    sidebar.classList.add('mobile-open');
                    backdrop?.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } else {
                    sidebar.classList.remove('mobile-open');
                    backdrop?.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            } else {
                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                const shouldCollapse = forceState !== null ? forceState : !isCollapsed;

                if (shouldCollapse) {
                    sidebar.classList.add('sidebar-collapsed');
                    document.documentElement.classList.add('sidebar-is-collapsed');
                    localStorage.setItem('sidebar_collapsed', 'true');
                    if (toggleBtn) {
                        toggleBtn.setAttribute('title', 'Expand Sidebar (Ctrl+B)');
                        toggleBtn.classList.add('text-indigo-400', 'border-indigo-500/50');
                    }
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                    document.documentElement.classList.remove('sidebar-is-collapsed');
                    localStorage.setItem('sidebar_collapsed', 'false');
                    if (toggleBtn) {
                        toggleBtn.setAttribute('title', 'Collapse to Icons (Ctrl+B)');
                        toggleBtn.classList.remove('text-indigo-400', 'border-indigo-500/50');
                    }
                }
            }
            if (window.lucide) lucide.createIcons();
        }

        // Global Shortcut: Ctrl+B or Cmd+B to toggle sidebar
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
        });

        // Initialize sidebar state on load: default to collapsed / icon rail ("default me left side hide ho")
        (function initSidebar() {
            try {
                const isCollapsed = localStorage.getItem('sidebar_collapsed') !== 'false';
                if (isCollapsed && window.innerWidth >= 768) {
                    const sidebar = document.getElementById('sidebar');
                    const toggleBtn = document.getElementById('sidebarToggleBtn');
                    if (sidebar) sidebar.classList.add('sidebar-collapsed');
                    if (toggleBtn) {
                        toggleBtn.setAttribute('title', 'Expand Sidebar (Ctrl+B)');
                        toggleBtn.classList.add('text-indigo-400', 'border-indigo-500/50');
                    }
                }
            } catch (e) {}
        })();

        function toggleAllSections(modalId, checked) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.querySelectorAll('input[name="departments[]"]').forEach(cb => {
                cb.checked = checked;
            });
        }

        function applyTheme(theme) {
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');
            const label = document.getElementById('themeLabel');

            if (theme === 'dark') {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (icon) {
                    icon.setAttribute('data-lucide', 'sun');
                    icon.className = 'w-3.5 h-3.5 text-amber-400';
                }
                if (label) label.textContent = 'Dark';
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('theme', 'light');
                if (icon) {
                    icon.setAttribute('data-lucide', 'moon');
                    icon.className = 'w-3.5 h-3.5 text-indigo-500';
                }
                if (label) label.textContent = 'Light';
            }
            if (window.lucide) lucide.createIcons();
        }

        function toggleTheme() {
            const current = localStorage.getItem('theme') || 'light';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        }

        // Initialize: default to light theme
        const currentTheme = localStorage.getItem('theme') || 'light';
        applyTheme(currentTheme);
    </script>
</body>
</html>
