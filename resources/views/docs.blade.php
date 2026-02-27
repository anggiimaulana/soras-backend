<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SORAS API Docs — v1.0</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Syne:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <script>
        (function() {
            var t = localStorage.getItem('soras-docs-theme');
            if (t === 'light') document.documentElement.setAttribute('data-theme', 'light');
            else document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>
    <style>
        /* ═══ RESET & BASE ═══════════════════════════════════════════ */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 14px;
        }

        /* ═══ THEME VARIABLES ════════════════════════════════════════ */
        :root,
        [data-theme="dark"] {
            --bg: #0a0a0f;
            --bg2: #111118;
            --bg3: #1a1a24;
            --bg4: #22222e;
            --border: rgba(255, 255, 255, 0.07);
            --border2: rgba(255, 255, 255, 0.12);
            --text: #e8e8f0;
            --text2: #9090a8;
            --text3: #5a5a72;
            --accent: #7c6fff;
            --accent2: #5b4fe8;
            --green: #22c55e;
            --red: #ef4444;
            --amber: #f59e0b;
            --blue: #3b82f6;
            --cyan: #06b6d4;
            --sidebar-w: 260px;
        }

        [data-theme="light"] {
            --bg: #f5f5f8;
            --bg2: #ffffff;
            --bg3: #f0f0f5;
            --bg4: #e8e8f0;
            --border: rgba(0, 0, 0, 0.08);
            --border2: rgba(0, 0, 0, 0.14);
            --text: #1a1a2e;
            --text2: #4a4a68;
            --text3: #9090a8;
            --accent: #5b4fe8;
            --accent2: #4338ca;
        }

        /* ═══ LAYOUT ═════════════════════════════════════════════════ */
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            display: flex;
            min-height: 100vh;
            transition: background 0.2s, color 0.2s;
        }

        /* ═══ SIDEBAR ════════════════════════════════════════════════ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--bg2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 100;
            transition: transform 0.3s;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 18px 16px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(92, 79, 232, 0.4);
        }

        .sidebar-logo-text .name {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 15px;
            color: var(--text);
            line-height: 1;
        }

        .sidebar-logo-text .version {
            font-size: 10px;
            color: var(--text3);
            margin-top: 2px;
            font-family: 'JetBrains Mono', monospace;
        }

        .sidebar-search {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-search input {
            width: 100%;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 10px;
            font-size: 12px;
            color: var(--text);
            outline: none;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.15s;
        }

        .sidebar-search input:focus {
            border-color: var(--accent);
        }

        .sidebar-search input::placeholder {
            color: var(--text3);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
            scrollbar-width: thin;
            scrollbar-color: var(--bg4) transparent;
        }

        .nav-section-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text3);
            padding: 12px 18px 6px;
            font-family: 'JetBrains Mono', monospace;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 18px;
            font-size: 12.5px;
            color: var(--text2);
            text-decoration: none;
            transition: color 0.12s, background 0.12s;
            border-left: 2px solid transparent;
            cursor: pointer;
        }

        .nav-link:hover {
            color: var(--text);
            background: var(--bg3);
        }

        .nav-link.active {
            color: var(--accent);
            border-left-color: var(--accent);
            background: rgba(124, 111, 255, 0.07);
            font-weight: 600;
        }

        .nav-badge {
            font-size: 9px;
            padding: 2px 5px;
            border-radius: 4px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            margin-left: auto;
            flex-shrink: 0;
        }

        .badge-get {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }

        .badge-post {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        .badge-put {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        .badge-delete {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .sidebar-footer {
            padding: 12px 14px;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .theme-toggle {
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 11px;
            color: var(--text2);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: border-color 0.15s, color 0.15s;
        }

        .theme-toggle:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ═══ MAIN CONTENT ═══════════════════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
            padding: 40px 48px;
            max-width: 900px;
        }

        @media (max-width: 900px) {
            .main {
                padding: 24px 20px;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }
        }

        /* ═══ SECTIONS ═══════════════════════════════════════════════ */
        .doc-section {
            margin-bottom: 64px;
            scroll-margin-top: 32px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .section-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
        }

        .section-desc {
            font-size: 13px;
            color: var(--text2);
            margin-top: 2px;
        }

        /* ═══ ENDPOINT CARD ══════════════════════════════════════════ */
        .endpoint-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 14px;
            margin-bottom: 16px;
            overflow: hidden;
            transition: border-color 0.15s;
        }

        .endpoint-card:hover {
            border-color: var(--border2);
        }

        .endpoint-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            cursor: pointer;
            user-select: none;
        }

        .endpoint-header:hover {
            background: var(--bg3);
        }

        .method-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            flex-shrink: 0;
            min-width: 52px;
            text-align: center;
        }

        .method-get {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .method-post {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .method-put {
            background: rgba(59, 130, 246, 0.12);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .method-delete {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .endpoint-path {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            color: var(--text);
            flex: 1;
            min-width: 0;
        }

        .endpoint-path .param {
            color: var(--accent);
        }

        .endpoint-summary {
            font-size: 12px;
            color: var(--text2);
            flex-shrink: 0;
        }

        .auth-required {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 5px;
            background: rgba(124, 111, 255, 0.1);
            color: var(--accent);
            border: 1px solid rgba(124, 111, 255, 0.2);
            flex-shrink: 0;
            font-family: 'JetBrains Mono', monospace;
        }

        .endpoint-chevron {
            color: var(--text3);
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .endpoint-card.open .endpoint-chevron {
            transform: rotate(90deg);
        }

        /* ═══ ENDPOINT BODY ══════════════════════════════════════════ */
        .endpoint-body {
            display: none;
            border-top: 1px solid var(--border);
        }

        .endpoint-card.open .endpoint-body {
            display: block;
        }

        .tabs {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
            padding: 0 18px;
            background: var(--bg3);
        }

        .tab-btn {
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text3);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: color 0.12s, border-color 0.12s;
            user-select: none;
            background: none;
            border-left: none;
            border-right: none;
            border-top: none;
            font-family: 'Inter', sans-serif;
        }

        .tab-btn:hover {
            color: var(--text2);
        }

        .tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .tab-panel {
            display: none;
            padding: 18px;
        }

        .tab-panel.active {
            display: block;
        }

        /* ═══ CODE BLOCK ══════════════════════════════════════════════ */
        .code-block {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 14px;
            background: var(--bg3);
            border-bottom: 1px solid var(--border);
        }

        .code-lang {
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
            color: var(--text3);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .copy-btn {
            font-size: 11px;
            color: var(--text3);
            cursor: pointer;
            background: none;
            border: none;
            padding: 2px 8px;
            border-radius: 4px;
            transition: background 0.12s, color 0.12s;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .copy-btn:hover {
            background: var(--bg4);
            color: var(--text);
        }

        .copy-btn.copied {
            color: var(--green);
        }

        pre {
            padding: 16px;
            overflow-x: auto;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--text2);
            scrollbar-width: thin;
            scrollbar-color: var(--bg4) transparent;
        }

        .json-key {
            color: #c084fc;
        }

        .json-str {
            color: #86efac;
        }

        .json-num {
            color: #93c5fd;
        }

        .json-bool {
            color: #fb923c;
        }

        .json-null {
            color: var(--text3);
        }

        .json-comment {
            color: var(--text3);
            font-style: italic;
        }

        /* ═══ PARAMS TABLE ════════════════════════════════════════════ */
        .params-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .params-table th {
            text-align: left;
            padding: 8px 12px;
            background: var(--bg3);
            color: var(--text3);
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            border-bottom: 1px solid var(--border);
        }

        .params-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .params-table tr:last-child td {
            border-bottom: none;
        }

        .param-name {
            font-family: 'JetBrains Mono', monospace;
            color: var(--accent);
            font-size: 12px;
        }

        .param-type {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--cyan);
        }

        .param-required {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            font-weight: 600;
        }

        .param-optional {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            background: var(--bg3);
            color: var(--text3);
        }

        .param-desc {
            color: var(--text2);
        }

        /* ═══ RESPONSE BADGES ════════════════════════════════════════ */
        .response-group {
            margin-bottom: 16px;
        }

        .response-status {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .status-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 6px;
        }

        .status-2xx {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }

        .status-4xx {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .status-5xx {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
        }

        .status-desc {
            font-size: 12px;
            color: var(--text2);
        }

        /* ═══ HERO SECTION ═══════════════════════════════════════════ */
        .hero {
            margin-bottom: 56px;
            padding-bottom: 40px;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -80px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(124, 111, 255, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-family: 'JetBrains Mono', monospace;
            color: var(--accent);
            background: rgba(124, 111, 255, 0.1);
            border: 1px solid rgba(124, 111, 255, 0.2);
            padding: 4px 10px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
            margin-bottom: 12px;
        }

        .hero h1 span {
            color: var(--accent);
        }

        .hero-desc {
            font-size: 14px;
            color: var(--text2);
            line-height: 1.6;
            max-width: 560px;
            margin-bottom: 24px;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .meta-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text2);
            background: var(--bg2);
            border: 1px solid var(--border);
            padding: 6px 12px;
            border-radius: 8px;
        }

        .meta-chip .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--green);
        }

        .meta-chip .dot.orange {
            background: var(--amber);
        }

        /* ═══ INFO CARDS ═════════════════════════════════════════════ */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .info-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
        }

        .info-card-title {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text3);
            margin-bottom: 8px;
            font-family: 'JetBrains Mono', monospace;
        }

        .info-card-value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            font-family: 'JetBrains Mono', monospace;
        }

        /* ═══ ALERT BLOCKS ═══════════════════════════════════════════ */
        .alert {
            display: flex;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 13px;
            line-height: 1.5;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #93c5fd;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #fcd34d;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #86efac;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .alert-icon {
            flex-shrink: 0;
            font-size: 16px;
        }

        /* ═══ INLINE CODE ════════════════════════════════════════════ */
        code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            background: var(--bg3);
            border: 1px solid var(--border);
            padding: 1px 6px;
            border-radius: 4px;
            color: var(--accent);
        }

        /* ═══ SCHEMA TABLE ═══════════════════════════════════════════ */
        .schema-section {
            margin-top: 32px;
        }

        .schema-title {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .schema-badge {
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
            padding: 2px 7px;
            border-radius: 4px;
            background: rgba(6, 182, 212, 0.1);
            color: var(--cyan);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        /* ═══ SCROLLBAR ══════════════════════════════════════════════ */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--bg4);
            border-radius: 99px;
        }

        /* ═══ MOBILE HAMBURGER ════════════════════════════════════════ */
        .hamburger {
            display: none;
            position: fixed;
            top: 14px;
            left: 14px;
            z-index: 200;
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px;
            cursor: pointer;
            color: var(--text);
        }

        @media (max-width: 900px) {
            .hamburger {
                display: flex;
            }
        }

        /* ═══ PROGRESS BAR ═══════════════════════════════════════════ */
        .toc-progress {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: 2px;
            background: var(--border);
            z-index: 50;
        }

        .toc-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--cyan));
            width: 0%;
            transition: width 0.1s;
        }
    </style>
</head>

<body>

    <!-- Progress bar -->
    <div class="toc-progress">
        <div class="toc-progress-bar" id="progressBar"></div>
    </div>

    <!-- Mobile hamburger -->
    <button class="hamburger" onclick="document.querySelector('.sidebar').classList.toggle('open')">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- ═══ SIDEBAR ═══════════════════════════════════════════════ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="sidebar-logo-text">
                <div class="name">SORAS API</div>
                <div class="version">v1.0 · REST</div>
            </div>
        </div>
        <div class="sidebar-search">
            <input type="text" placeholder="Cari endpoint..." id="searchInput" oninput="filterNav(this.value)">
        </div>
        <nav class="sidebar-nav" id="sidebarNav">
            <div class="nav-section-title">Overview</div>
            <a class="nav-link active" onclick="scrollTo('intro')">Pengantar</a>
            <a class="nav-link" onclick="scrollTo('auth-guide')">Autentikasi</a>
            <a class="nav-link" onclick="scrollTo('errors')">Error Codes</a>
            <a class="nav-link" onclick="scrollTo('ratelimit')">Rate Limiting</a>

            <div class="nav-section-title">Endpoints</div>
            <a class="nav-link" onclick="scrollTo('auth')">
                Auth <span class="nav-badge badge-post">4</span>
            </a>
            <a class="nav-link" onclick="scrollTo('master')">
                Master Data <span class="nav-badge badge-get">2</span>
            </a>
            <a class="nav-link" onclick="scrollTo('profile')">
                Profile <span class="nav-badge badge-put">3</span>
            </a>
            <a class="nav-link" onclick="scrollTo('recommendation')">
                Recommendation <span class="nav-badge badge-post">2</span>
            </a>
            <a class="nav-link" onclick="scrollTo('history')">
                History <span class="nav-badge badge-get">1</span>
            </a>

            <div class="nav-section-title">Referensi</div>
            <a class="nav-link" onclick="scrollTo('database')">Skema Database</a>
            <a class="nav-link" onclick="scrollTo('scoring')">Rumus Scoring</a>
            <a class="nav-link" onclick="scrollTo('hardfilter')">Hard Filter Rules</a>
            <a class="nav-link" onclick="scrollTo('changelog')">Changelog</a>
        </nav>
        <div class="sidebar-footer">
            <span style="font-size:11px;color:var(--text3);font-family:'JetBrains Mono',monospace;">SORAS © 2025</span>
            <button class="theme-toggle" onclick="toggleTheme()" id="themeBtn">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2" id="themeIcon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span id="themeLabel">Light</span>
            </button>
        </div>
    </aside>

    <!-- ═══ MAIN CONTENT ══════════════════════════════════════════ -->
    <main class="main">

        <!-- ── HERO ─────────────────────────────────────────────────── -->
        <section class="hero" id="intro">
            <div class="hero-eyebrow">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                REST API Documentation
            </div>
            <h1>SORAS <span>API</span></h1>
            <p class="hero-desc">
                Dokumentasi lengkap REST API untuk Sistem Olahraga Rekomendasi Adaptif dan Sehat (SORAS).
                Dibangun dengan Laravel 12, menggunakan Laravel Sanctum untuk autentikasi berbasis token.
            </p>
            <div class="hero-meta">
                <div class="meta-chip"><span class="dot"></span> Laravel 12</div>
                <div class="meta-chip"><span class="dot"></span> Sanctum Auth</div>
                <div class="meta-chip"><span class="dot orange"></span> Base URL: <code
                        style="background:none;border:none;padding:0;color:var(--amber);">https://yourdomain.com</code>
                </div>
                <div class="meta-chip">Content-Type: <code
                        style="background:none;border:none;padding:0;color:var(--accent);">application/json</code>
                </div>
            </div>
        </section>

        <!-- ── BASE INFO ──────────────────────────────────────────────── -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-card-title">Base URL</div>
                <div class="info-card-value">/api</div>
            </div>
            <div class="info-card">
                <div class="info-card-title">Format</div>
                <div class="info-card-value">JSON</div>
            </div>
            <div class="info-card">
                <div class="info-card-title">Auth Method</div>
                <div class="info-card-value">Bearer Token</div>
            </div>
            <div class="info-card">
                <div class="info-card-title">Versi</div>
                <div class="info-card-value">v1.0.0</div>
            </div>
        </div>

        <!-- ── RESPONSE FORMAT ────────────────────────────────────────── -->
        <div class="alert alert-info">
            <span class="alert-icon">ℹ️</span>
            <div>Semua response menggunakan format JSON standar dengan struktur <code>{ success, message, data }</code>.
                Sertakan header <code>Accept: application/json</code> di setiap request untuk memastikan error response
                juga dikembalikan dalam JSON.</div>
        </div>

        <div class="code-block" style="margin-bottom:48px;">
            <div class="code-header">
                <span class="code-lang">JSON — Response Standar</span>
                <button class="copy-btn" onclick="copyCode(this)">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Copy
                </button>
            </div>
            <pre><span class="json-comment">// ✅ Success</span>
{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Data berhasil diambil"</span>,
  <span class="json-key">"data"</span>: { ... }
}

<span class="json-comment">// ❌ Error</span>
{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Validation failed"</span>,
  <span class="json-key">"errors"</span>: {
    <span class="json-key">"email"</span>: [<span class="json-str">"Email sudah digunakan"</span>]
  }
}</pre>
        </div>

        <!-- ── AUTENTIKASI GUIDE ───────────────────────────────────── -->
        <section class="doc-section" id="auth-guide">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(124,111,255,0.1);">🔐</div>
                <div>
                    <div class="section-title">Autentikasi</div>
                    <div class="section-desc">Laravel Sanctum — Bearer Token</div>
                </div>
            </div>

            <p style="font-size:13px;color:var(--text2);line-height:1.7;margin-bottom:16px;">
                SORAS menggunakan <strong style="color:var(--text);">Laravel Sanctum</strong> untuk autentikasi
                berbasis token.
                Setelah login/register, simpan token yang dikembalikan dan kirimkan di header setiap request yang
                membutuhkan autentikasi.
            </p>

            <div class="alert alert-warning">
                <span class="alert-icon">⚠️</span>
                <div>Endpoint yang bertanda <span
                        style="background:rgba(124,111,255,0.1);color:var(--accent);padding:1px 6px;border-radius:4px;font-size:11px;font-family:'JetBrains Mono',monospace;">🔒
                        Auth</span> membutuhkan token. Request tanpa token akan mendapat response <code>401
                        Unauthorized</code>.</div>
            </div>

            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">HTTP Header</span>
                    <button class="copy-btn" onclick="copyCode(this)">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copy
                    </button>
                </div>
                <pre>Authorization: Bearer <span class="json-str">your_token_here</span>
Accept: application/json
Content-Type: application/json</pre>
            </div>
        </section>

        <!-- ── ERROR CODES ─────────────────────────────────────────── -->
        <section class="doc-section" id="errors">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(239,68,68,0.1);">⚠️</div>
                <div>
                    <div class="section-title">HTTP Status Codes</div>
                    <div class="section-desc">Daftar kode error yang dapat dikembalikan API</div>
                </div>
            </div>
            <table class="params-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Arti</th>
                        <th>Kapan terjadi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="status-code status-2xx">200</span></td>
                        <td style="color:var(--text2);">OK</td>
                        <td style="color:var(--text2);">Request berhasil, data dikembalikan</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-2xx">201</span></td>
                        <td style="color:var(--text2);">Created</td>
                        <td style="color:var(--text2);">Resource baru berhasil dibuat (register, create profile,
                            generate rekomendasi)</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-4xx">401</span></td>
                        <td style="color:var(--text2);">Unauthorized</td>
                        <td style="color:var(--text2);">Token tidak ada, tidak valid, atau sudah kedaluwarsa</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-4xx">403</span></td>
                        <td style="color:var(--text2);">Forbidden</td>
                        <td style="color:var(--text2);">Mengakses resource milik user lain</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-4xx">404</span></td>
                        <td style="color:var(--text2);">Not Found</td>
                        <td style="color:var(--text2);">Resource tidak ditemukan atau route tidak ada</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-4xx">409</span></td>
                        <td style="color:var(--text2);">Conflict</td>
                        <td style="color:var(--text2);">Resource sudah ada (misal: profil sudah pernah dibuat)</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-4xx">422</span></td>
                        <td style="color:var(--text2);">Unprocessable Entity</td>
                        <td style="color:var(--text2);">Validasi gagal, cek field <code>errors</code> di response</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-4xx">429</span></td>
                        <td style="color:var(--text2);">Too Many Requests</td>
                        <td style="color:var(--text2);">Rate limit terlampaui (maks 10 rekomendasi/menit)</td>
                    </tr>
                    <tr>
                        <td><span class="status-code status-5xx">500</span></td>
                        <td style="color:var(--text2);">Server Error</td>
                        <td style="color:var(--text2);">Kesalahan internal server</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- ── RATE LIMITING ─────────────────────────────────────────── -->
        <section class="doc-section" id="ratelimit">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(245,158,11,0.1);">⏱️</div>
                <div>
                    <div class="section-title">Rate Limiting</div>
                    <div class="section-desc">Batas request per waktu</div>
                </div>
            </div>
            <div class="alert alert-warning">
                <span class="alert-icon">⚠️</span>
                <div>Endpoint <code>POST /api/recommendations</code> dibatasi <strong style="color:var(--text);">10
                        request per menit</strong> per user. Melebihi batas akan menghasilkan response <code>429 Too
                        Many Requests</code>.</div>
            </div>
            <div class="code-block">
                <div class="code-header"><span class="code-lang">JSON — Response 429</span><button class="copy-btn"
                        onclick="copyCode(this)">Copy</button></div>
                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Terlalu banyak request. Coba lagi dalam 1 menit."</span>
}</pre>
            </div>
        </section>

        <!-- ═══ AUTH ENDPOINTS ════════════════════════════════════════ -->
        <section class="doc-section" id="auth">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(245,158,11,0.1);">🔑</div>
                <div>
                    <div class="section-title">Authentication</div>
                    <div class="section-desc">Register, Login, Logout, Me</div>
                </div>
            </div>

            <!-- Register -->
            <?php /* ENDPOINT: Register */ ?>
            <div class="endpoint-card" id="ep-register">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-post">POST</span>
                    <span class="endpoint-path">/api/auth/register</span>
                    <span class="endpoint-summary">Daftarkan pengguna baru</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'params')">Parameters</button>
                        <button class="tab-btn" onclick="switchTab(this,'request')">Request</button>
                        <button class="tab-btn" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="params">
                        <table class="params-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">name</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">Nama lengkap pengguna. Maks 255 karakter.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">email</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">Alamat email valid dan unik.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">password</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">Password minimal 8 karakter.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">password_confirmation</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">Harus sama dengan <code>password</code>.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-panel" data-tab="request">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON Body</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"name"</span>: <span class="json-str">"Budi Santoso"</span>,
  <span class="json-key">"email"</span>: <span class="json-str">"budi@example.com"</span>,
  <span class="json-key">"password"</span>: <span class="json-str">"password123"</span>,
  <span class="json-key">"password_confirmation"</span>: <span class="json-str">"password123"</span>
}</pre>
                        </div>
                    </div>
                    <div class="tab-panel" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-2xx">201</span><span
                                    class="status-desc">Berhasil mendaftar</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Registrasi berhasil"</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"token"</span>: <span class="json-str">"1|abc123xyz..."</span>,
    <span class="json-key">"user"</span>: {
      <span class="json-key">"id"</span>: <span class="json-num">1</span>,
      <span class="json-key">"name"</span>: <span class="json-str">"Budi Santoso"</span>,
      <span class="json-key">"email"</span>: <span class="json-str">"budi@example.com"</span>,
      <span class="json-key">"created_at"</span>: <span class="json-str">"2025-01-15T08:00:00.000000Z"</span>
    }
  }
}</pre>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-4xx">422</span><span
                                    class="status-desc">Validasi gagal</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Validation failed"</span>,
  <span class="json-key">"errors"</span>: {
    <span class="json-key">"email"</span>: [<span class="json-str">"Email sudah digunakan"</span>],
    <span class="json-key">"password"</span>: [<span class="json-str">"Password minimal 8 karakter"</span>]
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-post">POST</span>
                    <span class="endpoint-path">/api/auth/login</span>
                    <span class="endpoint-summary">Login & dapatkan token</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'params')">Parameters</button>
                        <button class="tab-btn" onclick="switchTab(this,'request')">Request</button>
                        <button class="tab-btn" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="params">
                        <table class="params-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">email</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">Email terdaftar.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">password</span></td>
                                    <td><span class="param-type">string</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">Password akun.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-panel" data-tab="request">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON Body</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"email"</span>: <span class="json-str">"budi@example.com"</span>,
  <span class="json-key">"password"</span>: <span class="json-str">"password123"</span>
}</pre>
                        </div>
                    </div>
                    <div class="tab-panel" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-2xx">200</span><span
                                    class="status-desc">Login berhasil</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Login berhasil"</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"token"</span>: <span class="json-str">"2|def456uvw..."</span>,
    <span class="json-key">"user"</span>: {
      <span class="json-key">"id"</span>: <span class="json-num">1</span>,
      <span class="json-key">"name"</span>: <span class="json-str">"Budi Santoso"</span>,
      <span class="json-key">"email"</span>: <span class="json-str">"budi@example.com"</span>
    }
  }
}</pre>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-4xx">401</span><span
                                    class="status-desc">Kredensial salah</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Email atau password salah"</span>
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Me -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-get">GET</span>
                    <span class="endpoint-path">/api/auth/me</span>
                    <span class="endpoint-summary">Data user yang sedang login</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-2xx">200</span><span
                                    class="status-desc">Berhasil</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"id"</span>: <span class="json-num">1</span>,
    <span class="json-key">"name"</span>: <span class="json-str">"Budi Santoso"</span>,
    <span class="json-key">"email"</span>: <span class="json-str">"budi@example.com"</span>,
    <span class="json-key">"is_admin"</span>: <span class="json-bool">false</span>,
    <span class="json-key">"created_at"</span>: <span class="json-str">"2025-01-15T08:00:00.000000Z"</span>
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-post">POST</span>
                    <span class="endpoint-path">/api/auth/logout</span>
                    <span class="endpoint-summary">Revoke token aktif</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="response">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Logout berhasil"</span>
}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ MASTER DATA ═══════════════════════════════════════════ -->
        <section class="doc-section" id="master">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(6,182,212,0.1);">📦</div>
                <div>
                    <div class="section-title">Master Data</div>
                    <div class="section-desc">Daftar keluhan dan tujuan latihan — digunakan sebagai ID input
                        rekomendasi</div>
                </div>
            </div>

            <div class="alert alert-success">
                <span class="alert-icon">💡</span>
                <div>Endpoint ini <strong>tidak membutuhkan autentikasi</strong>. Ambil data ini terlebih dahulu untuk
                    mengisi dropdown keluhan dan tujuan di UI Anda.</div>
            </div>

            <!-- GET Complaints -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-get">GET</span>
                    <span class="endpoint-path">/api/complaints</span>
                    <span class="endpoint-summary">Semua keluhan tersedia</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-2xx">200</span><span
                                    class="status-desc">Daftar keluhan</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"data"</span>: [
    { <span class="json-key">"id"</span>: <span class="json-num">1</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Nyeri Lutut"</span>,          <span class="json-key">"slug"</span>: <span class="json-str">"nyeri_lutut"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">2</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Nyeri Sendi"</span>,          <span class="json-key">"slug"</span>: <span class="json-str">"nyeri_sendi"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">3</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Nyeri Punggung"</span>,       <span class="json-key">"slug"</span>: <span class="json-str">"nyeri_punggung"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">4</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Obesitas"</span>,             <span class="json-key">"slug"</span>: <span class="json-str">"obesitas"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">5</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Hipertensi"</span>,           <span class="json-key">"slug"</span>: <span class="json-str">"hipertensi"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">6</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Tekanan Darah Tinggi"</span>, <span class="json-key">"slug"</span>: <span class="json-str">"tekanan_darah_tinggi"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">7</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Stres / Kecemasan"</span>,   <span class="json-key">"slug"</span>: <span class="json-str">"stres"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">8</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Kurang Fleksibilitas"</span>, <span class="json-key">"slug"</span>: <span class="json-str">"kurang_fleksibilitas"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">9</span>,  <span class="json-key">"name"</span>: <span class="json-str">"Lemah Otot"</span>,           <span class="json-key">"slug"</span>: <span class="json-str">"lemah_otot"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">10</span>, <span class="json-key">"name"</span>: <span class="json-str">"Postur Buruk"</span>,         <span class="json-key">"slug"</span>: <span class="json-str">"postur_buruk"</span> }
  ]
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GET Goals -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-get">GET</span>
                    <span class="endpoint-path">/api/goals</span>
                    <span class="endpoint-summary">Semua tujuan latihan tersedia</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="response">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"data"</span>: [
    { <span class="json-key">"id"</span>: <span class="json-num">1</span>, <span class="json-key">"name"</span>: <span class="json-str">"Menurunkan Berat Badan"</span>,    <span class="json-key">"slug"</span>: <span class="json-str">"weight_loss"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">2</span>, <span class="json-key">"name"</span>: <span class="json-str">"Meningkatkan Daya Tahan"</span>,  <span class="json-key">"slug"</span>: <span class="json-str">"endurance"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">3</span>, <span class="json-key">"name"</span>: <span class="json-str">"Meningkatkan Kekuatan Otot"</span>,<span class="json-key">"slug"</span>: <span class="json-str">"muscle_strength"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">4</span>, <span class="json-key">"name"</span>: <span class="json-str">"Mengurangi Nyeri / Rehab"</span>, <span class="json-key">"slug"</span>: <span class="json-str">"rehabilitation"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">5</span>, <span class="json-key">"name"</span>: <span class="json-str">"Mengurangi Stres"</span>,         <span class="json-key">"slug"</span>: <span class="json-str">"stress_relief"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">6</span>, <span class="json-key">"name"</span>: <span class="json-str">"Meningkatkan Fleksibilitas"</span>,<span class="json-key">"slug"</span>: <span class="json-str">"flexibility"</span> },
    { <span class="json-key">"id"</span>: <span class="json-num">7</span>, <span class="json-key">"name"</span>: <span class="json-str">"Meningkatkan Kesehatan Jantung"</span>,<span class="json-key">"slug"</span>: <span class="json-str">"heart_health"</span> }
  ]
}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ PROFILE ════════════════════════════════════════════════ -->
        <section class="doc-section" id="profile">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(34,197,94,0.1);">👤</div>
                <div>
                    <div class="section-title">Profile</div>
                    <div class="section-desc">Kelola data fisik pengguna — BMI dihitung otomatis</div>
                </div>
            </div>

            <!-- POST Profile -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-post">POST</span>
                    <span class="endpoint-path">/api/profile</span>
                    <span class="endpoint-summary">Buat profil pertama kali</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'params')">Parameters</button>
                        <button class="tab-btn" onclick="switchTab(this,'request')">Request</button>
                        <button class="tab-btn" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="params">
                        <table class="params-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Validasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">age</span></td>
                                    <td><span class="param-type">integer</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">5 – 100 tahun</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">gender</span></td>
                                    <td><span class="param-type">enum</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc"><code>L</code> (Laki-laki) atau <code>P</code> (Perempuan)
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">height_cm</span></td>
                                    <td><span class="param-type">float</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">50 – 250 cm</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">weight_kg</span></td>
                                    <td><span class="param-type">float</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">10 – 300 kg</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-panel" data-tab="request">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON Body</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"age"</span>: <span class="json-num">30</span>,
  <span class="json-key">"gender"</span>: <span class="json-str">"L"</span>,
  <span class="json-key">"height_cm"</span>: <span class="json-num">170</span>,
  <span class="json-key">"weight_kg"</span>: <span class="json-num">90</span>
}</pre>
                        </div>
                    </div>
                    <div class="tab-panel" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-2xx">201</span><span
                                    class="status-desc">Profil berhasil dibuat</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Profil berhasil dibuat"</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"id"</span>: <span class="json-num">1</span>,
    <span class="json-key">"user_id"</span>: <span class="json-num">1</span>,
    <span class="json-key">"age"</span>: <span class="json-num">30</span>,
    <span class="json-key">"gender"</span>: <span class="json-str">"L"</span>,
    <span class="json-key">"height_cm"</span>: <span class="json-num">170</span>,
    <span class="json-key">"weight_kg"</span>: <span class="json-num">90</span>,
    <span class="json-key">"bmi"</span>: <span class="json-num">31.1</span>,          <span class="json-comment">// dihitung otomatis</span>
    <span class="json-key">"bmi_category"</span>: <span class="json-str">"Obesitas"</span>,  <span class="json-comment">// dihitung otomatis</span>
    <span class="json-key">"age_category"</span>: <span class="json-str">"Dewasa"</span>    <span class="json-comment">// dihitung otomatis</span>
  }
}</pre>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-4xx">409</span><span
                                    class="status-desc">Profil sudah ada</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Profil sudah ada. Gunakan PUT untuk update."</span>
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GET Profile -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-get">GET</span>
                    <span class="endpoint-path">/api/profile</span>
                    <span class="endpoint-summary">Ambil profil user yang login</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs"><button class="tab-btn active"
                            onclick="switchTab(this,'response')">Response</button></div>
                    <div class="tab-panel active" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-4xx">404</span><span
                                    class="status-desc">Profil belum dibuat</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                        onclick="copyCode(this)">Copy</button></div>
                                <pre>{ <span class="json-key">"success"</span>: <span class="json-bool">false</span>, <span class="json-key">"message"</span>: <span class="json-str">"Profil belum ada"</span> }</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PUT Profile -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-put">PUT</span>
                    <span class="endpoint-path">/api/profile</span>
                    <span class="endpoint-summary">Update profil — BMI dihitung ulang</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'request')">Request</button>
                        <button class="tab-btn" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="request">
                        <div class="alert alert-info" style="margin:0 0 12px;">
                            <span class="alert-icon">ℹ️</span>
                            <div>Semua field bersifat opsional — kirim hanya field yang ingin diperbarui. BMI akan
                                dihitung ulang otomatis.</div>
                        </div>
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON Body</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"weight_kg"</span>: <span class="json-num">85</span>
}</pre>
                        </div>
                    </div>
                    <div class="tab-panel" data-tab="response">
                        <div class="response-status"><span class="status-code status-2xx">200</span><span
                                class="status-desc">Update berhasil</span></div>
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON</span><button class="copy-btn"
                                    onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Profil berhasil diperbarui"</span>,
  <span class="json-key">"data"</span>: { <span class="json-comment">/* profil terbaru dengan BMI baru */</span> }
}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ RECOMMENDATION ════════════════════════════════════════ -->
        <section class="doc-section" id="recommendation">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(124,111,255,0.1);">⚡</div>
                <div>
                    <div class="section-title">Recommendation</div>
                    <div class="section-desc">Engine rekomendasi — kalkulasi skor MCDM real-time</div>
                </div>
            </div>

            <div class="alert alert-info">
                <span class="alert-icon">💡</span>
                <div>Profil fisik <strong style="color:var(--text);">harus sudah ada</strong> sebelum memanggil
                    endpoint ini. Sistem akan menjalankan Hard Filter → Scoring → Ranking dan mengembalikan Top-3
                    olahraga terbaik.</div>
            </div>

            <!-- POST Recommendation -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-post">POST</span>
                    <span class="endpoint-path">/api/recommendations</span>
                    <span class="endpoint-summary">Generate rekomendasi olahraga</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'params')">Parameters</button>
                        <button class="tab-btn" onclick="switchTab(this,'request')">Request</button>
                        <button class="tab-btn" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="params">
                        <table class="params-table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">primary_complaint_id</span></td>
                                    <td><span class="param-type">integer</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">ID keluhan utama dari <code>GET /api/complaints</code></td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">secondary_complaint_ids</span></td>
                                    <td><span class="param-type">array</span></td>
                                    <td><span class="param-optional">Optional</span></td>
                                    <td class="param-desc">Array ID keluhan tambahan. Maks 3. Tidak boleh sama dengan
                                        primary. Tidak boleh duplikat.</td>
                                </tr>
                                <tr>
                                    <td><span class="param-name">goal_id</span></td>
                                    <td><span class="param-type">integer</span></td>
                                    <td><span class="param-required">Required</span></td>
                                    <td class="param-desc">ID tujuan latihan dari <code>GET /api/goals</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-panel" data-tab="request">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON Body — Contoh lengkap</span><button
                                    class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"primary_complaint_id"</span>: <span class="json-num">1</span>,          <span class="json-comment">// Nyeri Lutut</span>
  <span class="json-key">"secondary_complaint_ids"</span>: [<span class="json-num">4</span>, <span class="json-num">7</span>], <span class="json-comment">// Obesitas, Stres</span>
  <span class="json-key">"goal_id"</span>: <span class="json-num">4</span>                       <span class="json-comment">// Rehabilitasi</span>
}</pre>
                        </div>
                    </div>
                    <div class="tab-panel" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-2xx">201</span><span
                                    class="status-desc">Rekomendasi berhasil digenerate</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON — Full response</span><button
                                        class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Rekomendasi berhasil dibuat"</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"recommendation_id"</span>: <span class="json-num">42</span>,
    <span class="json-key">"confidence"</span>: <span class="json-num">34.5</span>,       <span class="json-comment">// % keyakinan sistem</span>
    <span class="json-key">"final_score"</span>: <span class="json-num">0.842</span>,
    <span class="json-key">"recommendations"</span>: [
      {
        <span class="json-key">"rank"</span>: <span class="json-num">1</span>,
        <span class="json-key">"exercise"</span>: {
          <span class="json-key">"id"</span>: <span class="json-num">4</span>,
          <span class="json-key">"name"</span>: <span class="json-str">"Berenang"</span>,
          <span class="json-key">"category"</span>: <span class="json-str">"Kardio"</span>,
          <span class="json-key">"impact_level"</span>: <span class="json-num">1</span>,
          <span class="json-key">"duration_min"</span>: <span class="json-num">30</span>,
          <span class="json-key">"frequency_per_week"</span>: <span class="json-num">4</span>,
          <span class="json-key">"description"</span>: <span class="json-str">"Latihan seluruh tubuh dengan tekanan minimal pada sendi."</span>
        },
        <span class="json-key">"score"</span>: <span class="json-num">0.842</span>,
        <span class="json-key">"score_breakdown"</span>: {
          <span class="json-key">"score_primary"</span>:   <span class="json-num">1.00</span>, <span class="json-comment">// × 0.30</span>
          <span class="json-key">"score_secondary"</span>: <span class="json-num">0.90</span>, <span class="json-comment">// × 0.20</span>
          <span class="json-key">"score_goal"</span>:      <span class="json-num">1.00</span>, <span class="json-comment">// × 0.25</span>
          <span class="json-key">"score_bmi"</span>:       <span class="json-num">1.00</span>, <span class="json-comment">// × 0.15</span>
          <span class="json-key">"score_age"</span>:       <span class="json-num">1.00</span>  <span class="json-comment">// × 0.10</span>
        }
      },
      <span class="json-comment">// ... rank 2 & 3</span>
    ]
  }
}</pre>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-4xx">422</span><span
                                    class="status-desc">Validasi gagal</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button
                                        class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                                <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Validation failed"</span>,
  <span class="json-key">"errors"</span>: {
    <span class="json-key">"secondary_complaint_ids"</span>: [
      <span class="json-str">"Secondary complaint tidak boleh sama dengan primary"</span>
    ]
  }
}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GET Recommendation Detail -->
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-get">GET</span>
                    <span class="endpoint-path">/api/recommendations/<span class="param">{id}</span></span>
                    <span class="endpoint-summary">Detail rekomendasi berdasarkan ID</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'params')">Parameters</button>
                        <button class="tab-btn" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="params">
                        <table class="params-table">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Type</th>
                                    <th>Lokasi</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="param-name">id</span></td>
                                    <td><span class="param-type">integer</span></td>
                                    <td><span class="param-type">Path</span></td>
                                    <td class="param-desc">ID rekomendasi. Hanya bisa diakses oleh user pemiliknya.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-panel" data-tab="response">
                        <div class="response-group">
                            <div class="response-status"><span class="status-code status-4xx">403</span><span
                                    class="status-desc">Bukan milik user ini</span></div>
                            <div class="code-block">
                                <div class="code-header"><span class="code-lang">JSON</span><button
                                        class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                                <pre>{ <span class="json-key">"success"</span>: <span class="json-bool">false</span>, <span class="json-key">"message"</span>: <span class="json-str">"Akses ditolak"</span> }</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ HISTORY ════════════════════════════════════════════════ -->
        <section class="doc-section" id="history">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(59,130,246,0.1);">📜</div>
                <div>
                    <div class="section-title">History</div>
                    <div class="section-desc">Riwayat semua rekomendasi user</div>
                </div>
            </div>

            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggleEndpoint(this)">
                    <span class="method-badge method-get">GET</span>
                    <span class="endpoint-path">/api/history</span>
                    <span class="endpoint-summary">Semua riwayat rekomendasi user</span>
                    <span class="auth-required">🔒 Auth</span>
                    <svg class="endpoint-chevron" width="16" height="16" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="endpoint-body">
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(this,'response')">Response</button>
                    </div>
                    <div class="tab-panel active" data-tab="response">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JSON — Paginated</span><button
                                    class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                            <pre>{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"current_page"</span>: <span class="json-num">1</span>,
    <span class="json-key">"per_page"</span>: <span class="json-num">10</span>,
    <span class="json-key">"total"</span>: <span class="json-num">42</span>,
    <span class="json-key">"data"</span>: [
      {
        <span class="json-key">"id"</span>: <span class="json-num">42</span>,
        <span class="json-key">"primary_complaint"</span>: { <span class="json-key">"id"</span>: <span class="json-num">1</span>, <span class="json-key">"name"</span>: <span class="json-str">"Nyeri Lutut"</span> },
        <span class="json-key">"goal"</span>: { <span class="json-key">"id"</span>: <span class="json-num">4</span>, <span class="json-key">"name"</span>: <span class="json-str">"Rehabilitasi"</span> },
        <span class="json-key">"final_score"</span>: <span class="json-num">0.842</span>,
        <span class="json-key">"confidence"</span>: <span class="json-num">34.5</span>,
        <span class="json-key">"top_exercise"</span>: <span class="json-str">"Berenang"</span>,
        <span class="json-key">"created_at"</span>: <span class="json-str">"2025-01-20T10:30:00.000000Z"</span>
      }
    ]
  }
}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ DATABASE SCHEMA ════════════════════════════════════════ -->
        <section class="doc-section" id="database">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(6,182,212,0.1);">🗄️</div>
                <div>
                    <div class="section-title">Skema Database</div>
                    <div class="section-desc">MySQL — 9 tabel utama</div>
                </div>
            </div>

            <div class="code-block" style="margin-bottom:16px;">
                <div class="code-header"><span class="code-lang">ERD — Relasi tabel</span></div>
                <pre style="line-height:1.8;color:var(--text2);">users
  ├── user_profiles          (1:1)
  │     ├── user_complaints  (1:N) → complaints
  │     ├── user_goals       (1:N) → goals
  │     └── recommendations  (1:N)
  │           ├── recommendation_details (1:N) → exercises
  │           └── recommendation_score_breakdowns (1:N) → exercises
  └── recommendations        (via user_profile)</pre>
            </div>

            <div class="schema-section">
                <div class="schema-title">
                    <span class="schema-badge">TABLE</span> users
                </div>
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>Kolom</th>
                            <th>Type</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="param-name">id</span></td>
                            <td><span class="param-type">bigint PK</span></td>
                            <td class="param-desc">Auto increment primary key</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">name</span></td>
                            <td><span class="param-type">string</span></td>
                            <td class="param-desc">Nama lengkap</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">email</span></td>
                            <td><span class="param-type">string unique</span></td>
                            <td class="param-desc">Email unik</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">password</span></td>
                            <td><span class="param-type">string</span></td>
                            <td class="param-desc">Bcrypt hashed</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">is_admin</span></td>
                            <td><span class="param-type">boolean</span></td>
                            <td class="param-desc">Default false</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="schema-section">
                <div class="schema-title"><span class="schema-badge">TABLE</span> user_profiles</div>
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>Kolom</th>
                            <th>Type</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="param-name">user_id</span></td>
                            <td><span class="param-type">FK → users</span></td>
                            <td class="param-desc">Cascade delete</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">age</span></td>
                            <td><span class="param-type">integer</span></td>
                            <td class="param-desc">Usia dalam tahun</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">gender</span></td>
                            <td><span class="param-type">enum(L,P)</span></td>
                            <td class="param-desc">Jenis kelamin</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">height_cm</span></td>
                            <td><span class="param-type">float</span></td>
                            <td class="param-desc">Tinggi badan (cm)</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">weight_kg</span></td>
                            <td><span class="param-type">float</span></td>
                            <td class="param-desc">Berat badan (kg)</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">bmi</span></td>
                            <td><span class="param-type">float nullable</span></td>
                            <td class="param-desc">Dihitung otomatis: kg/(m²)</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">bmi_category</span></td>
                            <td><span class="param-type">string nullable</span></td>
                            <td class="param-desc">Underweight / Normal / Overweight / Obesitas</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">age_category</span></td>
                            <td><span class="param-type">string nullable</span></td>
                            <td class="param-desc">Anak-anak / Remaja / Dewasa / Lansia</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="schema-section">
                <div class="schema-title"><span class="schema-badge">TABLE</span> exercises</div>
                <table class="params-table">
                    <thead>
                        <tr>
                            <th>Kolom</th>
                            <th>Type</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="param-name">name</span></td>
                            <td><span class="param-type">string</span></td>
                            <td class="param-desc">Jalan Kaki, Lari, Bersepeda, Berenang, Yoga, Latihan Kekuatan,
                                HIIT, Peregangan</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">category</span></td>
                            <td><span class="param-type">string</span></td>
                            <td class="param-desc">Kardio / Kekuatan / Fleksibilitas / Kardio Intensitas Tinggi</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">impact_level</span></td>
                            <td><span class="param-type">tinyint</span></td>
                            <td class="param-desc"><code>1</code>=Low · <code>2</code>=Medium · <code>3</code>=High
                            </td>
                        </tr>
                        <tr>
                            <td><span class="param-name">intensity_level</span></td>
                            <td><span class="param-type">tinyint</span></td>
                            <td class="param-desc"><code>1</code>=Low · <code>2</code>=Medium · <code>3</code>=High
                            </td>
                        </tr>
                        <tr>
                            <td><span class="param-name">duration_min</span></td>
                            <td><span class="param-type">integer</span></td>
                            <td class="param-desc">Durasi latihan per sesi (menit)</td>
                        </tr>
                        <tr>
                            <td><span class="param-name">frequency_per_week</span></td>
                            <td><span class="param-type">integer</span></td>
                            <td class="param-desc">Frekuensi per minggu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ═══ SCORING FORMULA ════════════════════════════════════════ -->
        <section class="doc-section" id="scoring">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(124,111,255,0.1);">🧮</div>
                <div>
                    <div class="section-title">Rumus Scoring MCDM</div>
                    <div class="section-desc">Weighted Multi-Criteria Decision Making</div>
                </div>
            </div>

            <div class="code-block" style="margin-bottom:16px;">
                <div class="code-header"><span class="code-lang">Formula Utama</span></div>
                <pre style="font-size:14px;line-height:2;text-align:center;color:var(--text);">FinalScore = (<span style="color:#ef4444;">0.30</span> × P) + (<span style="color:#f97316;">0.20</span> × S) + (<span style="color:#3b82f6;">0.25</span> × G) + (<span style="color:#8b5cf6;">0.15</span> × BMI) + (<span style="color:#22c55e;">0.10</span> × Age)</pre>
            </div>

            <table class="params-table" style="margin-bottom:16px;">
                <thead>
                    <tr>
                        <th>Variabel</th>
                        <th>Bobot</th>
                        <th>Sumber</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span style="color:#ef4444;font-family:'JetBrains Mono',monospace;">P</span></td>
                        <td><strong>30%</strong></td>
                        <td>complaint_exercise matrix</td>
                        <td class="param-desc">Skor relevansi keluhan utama vs olahraga (–0.5 s/d 1.0)</td>
                    </tr>
                    <tr>
                        <td><span style="color:#f97316;font-family:'JetBrains Mono',monospace;">S</span></td>
                        <td><strong>20%</strong></td>
                        <td>complaint_exercise matrix</td>
                        <td class="param-desc">Rata-rata skor keluhan sekunder (0–3 keluhan)</td>
                    </tr>
                    <tr>
                        <td><span style="color:#3b82f6;font-family:'JetBrains Mono',monospace;">G</span></td>
                        <td><strong>25%</strong></td>
                        <td>goal_exercise matrix</td>
                        <td class="param-desc">Skor relevansi tujuan latihan vs olahraga</td>
                    </tr>
                    <tr>
                        <td><span style="color:#8b5cf6;font-family:'JetBrains Mono',monospace;">BMI</span></td>
                        <td><strong>15%</strong></td>
                        <td>BMI matrix (4 kategori)</td>
                        <td class="param-desc">Skor kesesuaian kategori BMI user</td>
                    </tr>
                    <tr>
                        <td><span style="color:#22c55e;font-family:'JetBrains Mono',monospace;">Age</span></td>
                        <td><strong>10%</strong></td>
                        <td>AgeImpact table</td>
                        <td class="param-desc">Toleransi usia terhadap impact level olahraga</td>
                    </tr>
                </tbody>
            </table>

            <div class="alert alert-warning">
                <span class="alert-icon">⚠️</span>
                <div>RawScore dapat negatif (nilai matriks –0.5). Hasil akhir di-clamp: <code>FinalScore = max(0,
                        RawScore)</code></div>
            </div>

            <div style="font-size:13px;color:var(--text2);margin-top:12px;">
                <strong style="color:var(--text);">Confidence</strong> =
                <code>(TopScore / SumAllScores) × 100%</code>
                — Persentase dominasi rekomendasi teratas dibanding total skor semua olahraga yang lolos filter.
            </div>
        </section>

        <!-- ═══ HARD FILTER ════════════════════════════════════════════ -->
        <section class="doc-section" id="hardfilter">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(239,68,68,0.1);">🛡️</div>
                <div>
                    <div class="section-title">Hard Filter Rules</div>
                    <div class="section-desc">Safety guard — dijalankan SEBELUM scoring</div>
                </div>
            </div>

            <div class="alert alert-danger">
                <span class="alert-icon">🚫</span>
                <div>Olahraga yang tereliminasi oleh hard filter <strong>tidak akan muncul</strong> dalam hasil
                    rekomendasi, berapapun skornya.</div>
            </div>

            <table class="params-table">
                <thead>
                    <tr>
                        <th>Rule</th>
                        <th>Kondisi</th>
                        <th>Olahraga yang dieliminasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color:var(--text);font-weight:600;">Hipertensi Rule</td>
                        <td class="param-desc">Keluhan = Hipertensi / Tekanan Darah Tinggi</td>
                        <td class="param-desc">Impact High (HIIT, Lari)</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text);font-weight:600;">Joint Injury Rule</td>
                        <td class="param-desc">Primary = Nyeri Lutut / Nyeri Sendi</td>
                        <td class="param-desc">Impact High</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text);font-weight:600;">Obesity Rule</td>
                        <td class="param-desc">BMI ≥ 30 (Obesitas)</td>
                        <td class="param-desc">Impact High (Score = 0)</td>
                    </tr>
                    <tr>
                        <td style="color:var(--text);font-weight:600;">Geriatric Rule</td>
                        <td class="param-desc">Usia ≥ 50 (Lansia)</td>
                        <td class="param-desc">Impact High</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- ═══ CHANGELOG ═════════════════════════════════════════════ -->
        <section class="doc-section" id="changelog">
            <div class="section-header">
                <div class="section-icon" style="background:rgba(34,197,94,0.1);">📝</div>
                <div>
                    <div class="section-title">Changelog</div>
                </div>
            </div>
            <div style="space-y:12px;">
                <div style="display:flex;gap:16px;padding:14px 0;border-bottom:1px solid var(--border);">
                    <span
                        style="font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--accent);flex-shrink:0;min-width:64px;">v1.0.0</span>
                    <div>
                        <p style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:4px;">Initial Release
                        </p>
                        <p style="font-size:12px;color:var(--text2);">Auth, Profile, Complaints, Goals, Recommendation
                            Engine (MCDM), History, Score Breakdown, Hard Filter Safety Rules.</p>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- end .main -->

    <script>
        // ── Theme toggle ──────────────────────────────────────────────
        function toggleTheme() {
            var current = document.documentElement.getAttribute('data-theme');
            var next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('soras-docs-theme', next);
            var label = document.getElementById('themeLabel');
            var icon = document.getElementById('themeIcon');
            if (next === 'light') {
                label.textContent = 'Dark';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
            } else {
                label.textContent = 'Light';
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
            }
        }
        // Init label
        (function() {
            var t = document.documentElement.getAttribute('data-theme');
            if (t === 'light') {
                document.getElementById('themeLabel').textContent = 'Dark';
                document.getElementById('themeIcon').innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
            }
        })();

        // ── Endpoint accordion ────────────────────────────────────────
        function toggleEndpoint(header) {
            var card = header.parentElement;
            card.classList.toggle('open');
        }

        // ── Tab switching ─────────────────────────────────────────────
        function switchTab(btn, tabName) {
            var body = btn.closest('.endpoint-body');
            body.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            body.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            body.querySelector('[data-tab="' + tabName + '"]').classList.add('active');
        }

        // ── Scroll to section ─────────────────────────────────────────
        function scrollTo(id) {
            var el = document.getElementById(id);
            if (el) el.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            // Update active nav
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            event.currentTarget.classList.add('active');
            // Close mobile sidebar
            if (window.innerWidth < 900) {
                document.querySelector('.sidebar').classList.remove('open');
            }
        }

        // ── Copy button ───────────────────────────────────────────────
        function copyCode(btn) {
            var pre = btn.closest('.code-block').querySelector('pre');
            var text = pre.innerText;
            navigator.clipboard.writeText(text).then(function() {
                btn.classList.add('copied');
                btn.innerHTML =
                    '<svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Copied!';
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML =
                        '<svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg> Copy';
                }, 2000);
            });
        }

        // ── Nav search filter ─────────────────────────────────────────
        function filterNav(query) {
            var links = document.querySelectorAll('#sidebarNav .nav-link');
            links.forEach(function(link) {
                if (!query) {
                    link.style.display = '';
                    return;
                }
                link.style.display = link.textContent.toLowerCase().includes(query.toLowerCase()) ? '' : 'none';
            });
        }

        // ── Reading progress bar ─────────────────────────────────────
        window.addEventListener('scroll', function() {
            var main = document.querySelector('.main');
            var scrollTop = window.scrollY;
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            var progress = (scrollTop / docHeight) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        });

        // ── Active nav on scroll ──────────────────────────────────────
        var sections = ['intro', 'auth-guide', 'errors', 'ratelimit', 'auth', 'master', 'profile', 'recommendation',
            'history', 'database', 'scoring', 'hardfilter', 'changelog'
        ];
        window.addEventListener('scroll', function() {
            var scrollY = window.scrollY + 80;
            var current = 'intro';
            sections.forEach(function(id) {
                var el = document.getElementById(id);
                if (el && el.offsetTop <= scrollY) current = id;
            });
            // Update nav — match by onclick content
            document.querySelectorAll('.nav-link').forEach(function(link) {
                var fn = link.getAttribute('onclick') || '';
                link.classList.toggle('active', fn.includes("'" + current + "'") || fn.includes('"' +
                    current + '"'));
            });
        });
    </script>
</body>

</html>
