<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام إدارة المتطوعين') — EMC</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Cairo:wght@400;600;700;800;900&family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ═══════════════════════════════════════════════════
           EMC DESIGN SYSTEM — TOKENS
        ═══════════════════════════════════════════════════ */
        :root {
            --deep:    #22334A;
            --blue:    #2691C2;
            --orange:  #EC943C;
            --bg:      #F8FAFC;
            --card:    #FFFFFF;
            --border:  #E2E8F0;
            --text:    #0F172A;
            --muted:   #64748B;
            --success: #16A34A;
            --warning: #F59E0B;
            --danger:  #DC2626;
            --sidebar-w: 280px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: 'Tajawal', 'Cairo', 'Noto Kufi Arabic', 'Noto Sans Arabic', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            direction: rtl;
            overflow-x: hidden;
            max-width: 100%;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        body.sidebar-open { overflow: hidden; }

        /* Numbers and Latin text use Inter for tabular clarity */
        .num, kbd, code, .tabular {
            font-family: 'Inter', 'Tajawal', ui-sans-serif, system-ui, sans-serif;
            font-variant-numeric: tabular-nums;
        }

        input, select, textarea, button {
            font-family: 'Tajawal', 'Cairo', sans-serif;
        }

        /* ═══════════════════════════════════════════════════
           CORE LAYOUT — THE WIDTH BUG FIX
           Root cause: .emc-main had no explicit width so in
           RTL flex it shrank to content width, leaving the
           left half of the viewport empty.
        ═══════════════════════════════════════════════════ */

        /* Sidebar: fixed, right edge, full height */
        .admin-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--deep);
            z-index: 50;
            display: flex;
            flex-direction: column;
            box-shadow: -2px 0 20px rgba(34,51,74,0.18);
            overflow: hidden;
        }

        /* Main: offset from right by sidebar width */
        .admin-main {
            margin-right: var(--sidebar-w);
            width: calc(100% - var(--sidebar-w));
            max-width: 100%;
            min-height: 100vh;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* Content area */
        .admin-content {
            flex: 1;
            padding: 28px 32px 48px;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════════════════
           SIDEBAR INTERNALS
        ═══════════════════════════════════════════════════ */
        .sb-logo {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.09);
            flex-shrink: 0;
        }

        .sb-user {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sb-nav {
            flex: 1;
            padding: 10px 12px;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .sb-nav::-webkit-scrollbar { display: none; }

        .sb-section-label {
            font-size: 0.62rem;
            font-weight: 800;
            color: rgba(255,255,255,0.28);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 10px 8px 6px;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 9px;
            font-size: 0.855rem;
            font-weight: 600;
            color: rgba(255,255,255,0.58);
            text-decoration: none;
            transition: background 0.18s, color 0.18s, transform 0.15s;
            margin-bottom: 1px;
            position: relative;
            overflow: hidden;
        }
        .sb-link:hover {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.9);
        }
        .sb-link.active {
            background: var(--orange);
            color: #fff;
            box-shadow: 0 4px 14px rgba(236,148,60,0.38);
            font-weight: 700;
        }
        .sb-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: rgba(255,255,255,0.5);
            border-radius: 0 3px 3px 0;
        }
        .sb-link svg { opacity: 0.7; flex-shrink: 0; }
        .sb-link.active svg, .sb-link:hover svg { opacity: 1; }

        .sb-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sb-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 13px;
            border-radius: 8px;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.42);
            font-size: 0.855rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
            text-align: right;
        }
        .sb-logout:hover {
            background: rgba(220,38,38,0.14);
            color: #fca5a5;
        }

        /* Sidebar close (mobile) */
        .sb-close {
            display: none;
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.18s, color 0.18s;
        }
        .sb-close:hover { background: rgba(255,255,255,0.14); color: #fff; }

        /* Mobile toggle — in topbar on mobile, hidden fixed version */
        .sb-mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: var(--deep);
            border: none;
            border-radius: 9px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.18s;
        }
        .sb-mobile-toggle:hover { background: #1a2d42; }

        /* Mobile overlay */
        .sb-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.5);
            z-index: 45;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.22s ease, visibility 0.22s;
        }
        .sb-overlay.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* ═══════════════════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════════════════ */
        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 30;
            flex-shrink: 0;
            box-shadow: 0 1px 0 var(--border);
        }

        .topbar-title {
            font-size: 1.05rem;
            font-weight: 900;
            color: var(--deep);
            line-height: 1;
        }

        .topbar-sub {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 3px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .topbar-head {
            flex: 1;
            min-width: 0;
        }

        .topbar-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        /* ═══════════════════════════════════════════════════
           CARDS
        ═══════════════════════════════════════════════════ */
        .emc-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.03);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .emc-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .emc-stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: box-shadow 0.22s, transform 0.22s;
        }
        .emc-stat-card:hover {
            box-shadow: 0 8px 28px rgba(0,0,0,0.09);
            transform: translateY(-2px);
        }

        /* ═══════════════════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════════════════ */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s, box-shadow 0.18s, transform 0.15s;
        }
        .btn-primary:hover {
            background: #d4832a;
            box-shadow: 0 4px 14px rgba(236,148,60,0.4);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: translateY(0); box-shadow: none; }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: #fff;
            color: var(--deep);
            border: 1px solid var(--border);
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s, border-color 0.18s, box-shadow 0.18s, transform 0.15s;
        }
        .btn-secondary:hover {
            background: var(--bg);
            border-color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transform: translateY(-1px);
        }
        .btn-secondary:active { transform: translateY(0); }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            background: #fff;
            color: var(--danger);
            border: 1px solid #fecaca;
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s, border-color 0.18s;
        }
        .btn-danger:hover { background: #fef2f2; border-color: #fca5a5; }

        /* ═══════════════════════════════════════════════════
           TABLE
        ═══════════════════════════════════════════════════ */
        .emc-table { width: 100%; border-collapse: collapse; text-align: right; }

        .emc-table thead th {
            background: var(--bg);
            color: var(--muted);
            font-size: 0.69rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 11px 20px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .emc-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.12s;
        }
        .emc-table tbody tr:last-child { border-bottom: none; }
        .emc-table tbody tr:hover { background: #f8fafc; }

        .emc-table tbody td {
            padding: 13px 20px;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        /* ═══════════════════════════════════════════════════
           BADGES
        ═══════════════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 0.71rem;
            font-weight: 700;
        }
        .badge-active    { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-pending   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-inactive  { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .badge-suspended { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        /* ═══════════════════════════════════════════════════
           FORM INPUTS
        ═══════════════════════════════════════════════════ */
        .emc-input {
            width: 100%;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 0.875rem;
            color: var(--text);
            transition: border-color 0.18s, box-shadow 0.18s;
            outline: none;
            font-family: inherit;
        }
        .emc-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(38,145,194,0.14);
        }
        .emc-input::placeholder { color: #94a3b8; }

        /* ═══════════════════════════════════════════════════
           SECTION HEADERS (forms)
        ═══════════════════════════════════════════════════ */
        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }
        .section-number {
            width: 28px; height: 28px;
            background: var(--orange);
            color: #fff;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem; font-weight: 900;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════════════
           FLASH MESSAGES
        ═══════════════════════════════════════════════════ */
        .flash-success {
            display: flex; align-items: center; gap: 10px;
            padding: 13px 18px;
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
            border-radius: 10px; font-size: 0.875rem; font-weight: 600;
            animation: slideDown 0.28s ease;
        }
        .flash-error {
            display: flex; align-items: center; gap: 10px;
            padding: 13px 18px;
            background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;
            border-radius: 10px; font-size: 0.875rem; font-weight: 600;
            animation: slideDown 0.28s ease;
        }

        /* ═══════════════════════════════════════════════════
           PROGRESS
        ═══════════════════════════════════════════════════ */
        .emc-progress-track {
            width: 100%; height: 6px;
            background: #e2e8f0;
            border-radius: 99px; overflow: hidden;
        }
        .emc-progress-fill {
            height: 100%; border-radius: 99px;
            background: var(--blue);
            transition: width 0.5s cubic-bezier(0.4,0,0.2,1);
        }
        .emc-progress-fill.green  { background: var(--success); }
        .emc-progress-fill.orange { background: var(--orange); }
        .emc-progress-fill.amber  { background: var(--warning); }
        .emc-progress-fill.red    { background: var(--danger); }

        /* ═══════════════════════════════════════════════════
           ICON BOXES
        ═══════════════════════════════════════════════════ */
        .icon-box {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .icon-box-blue   { background: #e0f2fe; color: var(--blue); }
        .icon-box-orange { background: #fff7ed; color: var(--orange); }
        .icon-box-green  { background: #dcfce7; color: var(--success); }
        .icon-box-amber  { background: #fef3c7; color: var(--warning); }
        .icon-box-red    { background: #fee2e2; color: var(--danger); }
        .icon-box-purple { background: #f3e8ff; color: #7c3aed; }
        .icon-box-deep   { background: rgba(34,51,74,0.08); color: var(--deep); }

        /* ═══════════════════════════════════════════════════
           ICON ACTION BUTTONS
        ═══════════════════════════════════════════════════ */
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s, transform 0.12s;
            flex-shrink: 0;
        }
        .icon-btn:hover { transform: translateY(-1px); }
        .icon-btn:focus-visible {
            outline: 2px solid var(--blue);
            outline-offset: 2px;
        }
        .icon-btn-view  { background: #EFF6FF; color: #2691C2; border-color: #BFDBFE; }
        .icon-btn-edit  { background: #FFF7ED; color: #EC943C; border-color: #FED7AA; }
        .icon-btn-delete { background: #FEF2F2; color: #DC2626; border-color: #FECACA; }
        .icon-btn-neutral { background: #F8FAFC; color: #64748B; border-color: #E2E8F0; }
        .icon-btn-view:hover  { background: #DBEAFE; border-color: #2691C2; }
        .icon-btn-edit:hover  { background: #FFEDD5; border-color: #EC943C; }
        .icon-btn-delete:hover { background: #FEE2E2; border-color: #DC2626; }
        .icon-btn-neutral:hover { background: #F1F5F9; border-color: #CBD5E1; }

        .icon-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: center;
        }

        /* Clickable table rows & cards */
        .clickable-row {
            cursor: pointer;
            transition: background 0.12s;
        }
        .clickable-row:hover { background: #F8FAFC; }
        .clickable-card {
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .clickable-card:hover {
            box-shadow: 0 6px 20px rgba(34,51,74,0.08);
            transform: translateY(-1px);
        }

        /* Legacy text buttons (deprecated) */
        .tbl-btn-view, .tbl-btn-edit, .tbl-btn-delete {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 8px;
            transition: background 0.15s, transform 0.12s;
            text-decoration: none; border: 1px solid transparent;
            cursor: pointer; font-family: inherit;
        }
        .tbl-btn-view  { background: #EFF6FF; color: #2691C2; border-color: #BFDBFE; }
        .tbl-btn-edit  { background: #FFF7ED; color: #EC943C; border-color: #FED7AA; }
        .tbl-btn-delete { background: #FEF2F2; color: #DC2626; border-color: #FECACA; }
        .tbl-btn-view:hover  { background: #DBEAFE; transform: translateY(-1px); }
        .tbl-btn-edit:hover  { background: #FFEDD5; transform: translateY(-1px); }
        .tbl-btn-delete:hover { background: #FEE2E2; transform: translateY(-1px); }

        /* ═══════════════════════════════════════════════════
           DETAIL PAGES — PREMIUM LAYOUT SYSTEM
        ═══════════════════════════════════════════════════ */
        .detail-page {
            width: 100%;
            animation: fadeUp 0.25s ease;
        }

        .detail-page-narrow {
            max-width: 1120px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── Volunteer card grid (index) ── */
        .volunteer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
        @media (min-width: 768px) {
            .volunteer-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .volunteer-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (min-width: 1400px) {
            .volunteer-grid { grid-template-columns: repeat(4, 1fr); }
        }

        .vol-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            transition: box-shadow 0.2s, border-color 0.2s, transform 0.18s;
            overflow: hidden;
            min-width: 0;
        }
        .vol-card:hover {
            box-shadow: 0 6px 20px rgba(34,51,74,0.08);
            border-color: #CBD5E1;
            transform: translateY(-1px);
        }
        .vol-card-top {
            padding: 16px 16px 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .vol-card-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .vol-card-head { flex: 1; min-width: 0; }
        .vol-card-name {
            font-size: 0.88rem;
            font-weight: 800;
            color: var(--deep);
            line-height: 1.35;
            margin: 0 0 2px;
        }
        .vol-card-email {
            font-size: 0.72rem;
            color: #94a3b8;
            word-break: break-all;
        }
        .vol-card-body {
            padding: 0 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 7px;
            flex: 1;
        }
        .vol-card-field {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 0.76rem;
            line-height: 1.4;
        }
        .vol-card-field svg {
            flex-shrink: 0;
            margin-top: 1px;
            color: #94a3b8;
        }
        .vol-card-field-label {
            color: #94a3b8;
            flex-shrink: 0;
            min-width: 72px;
        }
        .vol-card-field-value {
            color: #475569;
            font-weight: 600;
            word-break: break-word;
        }
        .vol-card-foot {
            padding: 10px 14px;
            border-top: 1px solid #F1F5F9;
            background: #FAFBFC;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .vol-card-dates {
            font-size: 0.68rem;
            color: #94a3b8;
            line-height: 1.5;
        }
        .vol-card-dates strong {
            color: #64748B;
            font-weight: 700;
        }

        /* ── Department unified member cards ── */
        .member-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
        @media (min-width: 768px) {
            .member-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1200px) {
            .member-grid { grid-template-columns: repeat(2, 1fr); }
        }

        .member-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: box-shadow 0.2s, border-color 0.2s;
            min-width: 0;
        }
        .member-card:hover {
            box-shadow: 0 4px 16px rgba(34,51,74,0.07);
            border-color: #CBD5E1;
        }
        .member-card-header {
            padding: 16px 18px 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border-bottom: 1px solid #F1F5F9;
        }
        .member-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(34,51,74,0.06);
            border: 1px solid var(--border);
            color: var(--deep);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .member-card-title {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--deep);
            margin: 0 0 3px;
        }
        .member-card-sub {
            font-size: 0.73rem;
            color: #94a3b8;
        }
        .member-card-job {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 6px;
            padding: 3px 9px;
            background: #FFF7ED;
            border: 1px solid #FED7AA;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #C2410C;
        }
        .member-card-grid {
            padding: 14px 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 16px;
        }
        @media (max-width: 767px) {
            .member-card-grid { grid-template-columns: 1fr; }
        }
        .member-field-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
        }
        .member-field-value {
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            line-height: 1.45;
            word-break: break-word;
        }
        .member-field-span { grid-column: 1 / -1; }
        .member-card-foot {
            padding: 10px 16px;
            border-top: 1px solid #F1F5F9;
            background: #FAFBFC;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        .member-card-meta {
            font-size: 0.68rem;
            color: #94a3b8;
        }

        .section-block {
            margin-bottom: 20px;
        }
        .section-block-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .section-block-head h3 {
            font-size: 0.88rem;
            font-weight: 900;
            color: var(--deep);
            margin: 0;
        }
        .section-block-count {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--muted);
            background: var(--bg);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        /* Narrow volunteer profile layout */
        .profile-hero {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }
        .profile-hero-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .profile-hero-body { flex: 1; min-width: 0; }
        .profile-hero-name {
            font-size: 1.2rem;
            font-weight: 900;
            color: var(--deep);
            margin: 0 0 4px;
        }
        .profile-hero-email {
            font-size: 0.8rem;
            color: var(--muted);
            margin: 0 0 10px;
        }
        .profile-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .profile-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 7px;
            background: var(--bg);
            border: 1px solid var(--border);
            font-size: 0.73rem;
            font-weight: 600;
            color: #475569;
        }
        .profile-chip svg { color: var(--muted); }

        .profile-layout {
            display: grid;
            grid-template-columns: 1fr minmax(260px, 300px);
            gap: 16px;
            align-items: start;
        }
        @media (max-width: 960px) {
            .profile-layout { grid-template-columns: 1fr; }
        }
        .profile-main { display: flex; flex-direction: column; gap: 14px; min-width: 0; }
        .profile-aside { display: flex; flex-direction: column; gap: 14px; min-width: 0; }

        .profile-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 20px;
        }
        .profile-section-title {
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0 0 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #F1F5F9;
        }
        .profile-section h2 {
            font-size: 0.95rem;
            font-weight: 900;
            color: var(--deep);
            margin: 0 0 8px;
        }
        .profile-text {
            font-size: 0.82rem;
            color: #475569;
            line-height: 1.65;
            margin: 0;
        }
        .profile-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.73rem;
            font-weight: 700;
            color: var(--blue);
            text-decoration: none;
            margin-top: 8px;
        }
        .profile-link:hover { text-decoration: underline; }

        .profile-meta-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid #F1F5F9;
        }
        .profile-meta-row:last-child { border-bottom: none; padding-bottom: 0; }
        .profile-meta-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--muted);
        }
        .profile-meta-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 1px;
        }
        .profile-meta-value {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--deep);
            line-height: 1.4;
            word-break: break-word;
        }
        .profile-meta-value a {
            color: var(--blue);
            text-decoration: none;
        }
        .profile-meta-value a:hover { text-decoration: underline; }

        .profile-danger {
            background: #FFFBFB;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 4px;
        }
        .profile-danger h4 {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--danger);
            margin: 0 0 2px;
        }
        .profile-danger p {
            font-size: 0.72rem;
            color: var(--muted);
            margin: 0;
        }

        .detail-hero {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px 28px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(34,51,74,0.04);
            display: flex;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
        }
        .detail-hero-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            color: var(--blue);
        }
        .detail-hero-body { flex: 1; min-width: 220px; }
        .detail-hero-title {
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--deep);
            margin: 0 0 4px;
            line-height: 1.25;
        }
        .detail-hero-sub {
            font-size: 0.82rem;
            color: var(--muted);
            margin: 0 0 12px;
        }
        .detail-hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 0.75rem;
            color: var(--muted);
        }
        .detail-hero-meta strong { color: var(--deep); font-weight: 700; }

        .detail-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }
        .detail-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            background: var(--bg);
            border: 1px solid var(--border);
            font-size: 0.76rem;
            font-weight: 600;
            color: #475569;
        }

        /* KPI grid: 1 → 2 → 3 → 6 columns */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }
        .kpi-grid .emc-stat-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 18px 20px;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .kpi-grid .emc-stat-card:hover {
            box-shadow: 0 4px 16px rgba(34,51,74,0.07);
            transform: translateY(-1px);
        }
        .kpi-label {
            font-size: 0.71rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .kpi-value {
            font-size: 1.65rem;
            font-weight: 900;
            color: var(--deep);
            line-height: 1;
            margin-top: auto;
        }
        .kpi-value-text {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--deep);
            line-height: 1.35;
            margin-top: auto;
        }
        .kpi-sub {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-top: 4px;
        }
        .kpi-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 10px;
            flex-shrink: 0;
        }
        .kpi-icon-blue   { background: #EFF6FF; color: var(--blue); }
        .kpi-icon-orange { background: #FFF7ED; color: var(--orange); }
        .kpi-icon-deep   { background: rgba(34,51,74,0.06); color: var(--deep); }
        .kpi-icon-green  { background: #F0FDF4; color: var(--success); }

        @media (max-width: 1024px) {
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 767px) {
            .kpi-grid { grid-template-columns: 1fr; }
        }
        .kpi-grid-4 { grid-template-columns: repeat(4, 1fr) !important; }
        @media (max-width: 1024px) {
            .kpi-grid-4 { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 767px) {
            .kpi-grid-4 { grid-template-columns: 1fr !important; }
        }

        /* ── Responsive grids ── */
        .emc-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }
        .emc-grid-2-3 {
            display: grid;
            grid-template-columns: 2fr 3fr;
            gap: 18px;
        }
        .emc-grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }
        .emc-grid-auto {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
        }
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        /* ── Form & filter helpers ── */
        .filter-card { padding: 16px 20px; margin-bottom: 16px; }
        .form-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .form-section-card { padding: 28px; margin-bottom: 20px; }
        .page-actions-bar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

        .form-page { max-width: 720px; width: 100%; }
        .form-page-narrow { max-width: 600px; width: 100%; }

        .stats-bar {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px 20px;
            margin-bottom: 20px;
            padding: 12px 18px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
        }
        .stats-bar-divider {
            width: 1px;
            height: 14px;
            background: var(--border);
            flex-shrink: 0;
        }

        .detail-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        .detail-grid-span { grid-column: 1 / -1; }

        .emc-grid-2.mb,
        .emc-grid-2-3.mb,
        .detail-grid-2.mb { margin-bottom: 24px; }

        /* ── Responsive tables: desktop table + mobile cards ── */
        .table-desktop { display: block; width: 100%; }
        .mobile-cards { display: none; }

        .mobile-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            transition: box-shadow 0.18s, border-color 0.18s;
        }
        .mobile-card.clickable { cursor: pointer; }
        .mobile-card.clickable:active { background: #F8FAFC; }
        .mobile-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }
        .mobile-card-title {
            font-size: 0.88rem;
            font-weight: 800;
            color: var(--deep);
            line-height: 1.3;
        }
        .mobile-card-sub {
            font-size: 0.72rem;
            color: #94a3b8;
            margin-top: 2px;
        }
        .mobile-card-rows { display: flex; flex-direction: column; gap: 6px; }
        .mobile-card-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 0.76rem;
        }
        .mobile-card-row span:first-child { color: #94a3b8; flex-shrink: 0; }
        .mobile-card-row span:last-child { color: #475569; font-weight: 600; text-align: left; word-break: break-word; }
        .mobile-card-foot {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #F1F5F9;
            display: flex;
            justify-content: flex-end;
        }

        /* Scrollable table fallback (detail pages) */
        .table-scroll {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-scroll .emc-table { min-width: 640px; }

        /* ── Pagination ── */
        .emc-pagination {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* ── Flash wrapper ── */
        .flash-wrap { padding: 16px 32px 0; }

        /* Two-column detail: main (wide, RTL-right) + sidebar (narrow, RTL-left) */
        .detail-layout {
            display: grid;
            grid-template-columns: 1fr minmax(280px, 320px);
            gap: 20px;
            width: 100%;
            align-items: start;
        }
        .detail-main { display: flex; flex-direction: column; gap: 16px; min-width: 0; }
        .detail-aside { display: flex; flex-direction: column; gap: 16px; min-width: 0; }

        @media (max-width: 960px) {
            .detail-layout { grid-template-columns: 1fr; }
        }

        .detail-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px 24px;
            box-shadow: 0 1px 3px rgba(34,51,74,0.04);
        }
        .detail-section-head {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0 0 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }
        .detail-section-title {
            font-size: 0.9rem;
            font-weight: 900;
            color: var(--deep);
            margin: 0 0 14px;
        }

        .detail-panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 1px 3px rgba(34,51,74,0.04);
        }
        .detail-panel-head {
            font-size: 0.72rem;
            font-weight: 800;
            color: #94a3b8;
            letter-spacing: 0.06em;
            margin: 0 0 14px;
        }

        .detail-meta-list { display: flex; flex-direction: column; gap: 0; }
        .detail-meta-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid #F1F5F9;
        }
        .detail-meta-item:last-child { border-bottom: none; padding-bottom: 0; }
        .detail-meta-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            color: var(--muted);
        }
        .detail-meta-label {
            font-size: 0.68rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        .detail-meta-value {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--deep);
            line-height: 1.4;
        }
        .detail-meta-value a {
            color: var(--blue);
            text-decoration: none;
        }
        .detail-meta-value a:hover { text-decoration: underline; }

        .detail-task {
            font-size: 0.85rem;
            color: #475569;
            line-height: 1.65;
            margin: 0;
            padding: 10px 14px 10px 0;
            border-right: 3px solid var(--border);
        }
        .detail-task + .detail-task { margin-top: 8px; }

        .detail-table-wrap {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(34,51,74,0.04);
            margin-bottom: 20px;
        }
        .detail-table-head {
            padding: 14px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .detail-table-head h3 {
            font-size: 0.88rem;
            font-weight: 900;
            color: var(--deep);
            margin: 0;
        }
        .detail-table-count {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--muted);
            background: var(--bg);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .detail-empty {
            padding: 36px 24px;
            text-align: center;
            color: var(--muted);
        }
        .detail-empty svg { opacity: 0.35; margin: 0 auto 10px; display: block; }
        .detail-empty p { font-size: 0.84rem; margin: 0; }

        .detail-danger {
            background: #FFFBFB;
            border: 1px solid #FECACA;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .detail-danger-text h4 {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--danger);
            margin: 0 0 2px;
        }
        .detail-danger-text p {
            font-size: 0.75rem;
            color: var(--muted);
            margin: 0;
        }
        .btn-danger-sm {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            background: #fff;
            color: var(--danger);
            border: 1px solid #FECACA;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.18s, border-color 0.18s;
        }
        .btn-danger-sm:hover { background: #FEF2F2; border-color: #FCA5A5; }

        .detail-kpi-inline {
            text-align: center;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 22px;
            flex-shrink: 0;
            min-width: 110px;
        }
        .detail-kpi-inline .num {
            font-size: 2rem;
            font-weight: 900;
            color: var(--deep);
            line-height: 1;
        }
        .detail-kpi-inline span {
            font-size: 0.7rem;
            color: var(--muted);
            font-weight: 600;
            margin-top: 4px;
            display: block;
        }

        /* ═══════════════════════════════════════════════════
           EMPTY STATE
        ═══════════════════════════════════════════════════ */
        .empty-state {
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 40px 24px;
            color: #94a3b8; gap: 10px;
        }
        .empty-state svg   { width: 52px; height: 52px; opacity: 0.35; }
        .empty-state h3    { font-size: 1rem; font-weight: 700; color: #64748B; margin: 0; }
        .empty-state p     { font-size: 0.82rem; color: #94a3b8; margin: 0; text-align: center; }

        /* ═══════════════════════════════════════════════════
           ANIMATIONS
        ═══════════════════════════════════════════════════ */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        .page-enter { animation: fadeUp 0.3s cubic-bezier(0.4,0,0.2,1); }

        /* ═══════════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS
           Mobile:  < 768px  |  Tablet: 768–1024px  |  Desktop: > 1024px
        ═══════════════════════════════════════════════════ */

        /* Tablet */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(100%);
                transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
                z-index: 55;
            }
            .admin-sidebar.open { transform: translateX(0); }

            .admin-main {
                margin-right: 0;
                width: 100%;
                max-width: 100%;
            }

            .sb-overlay { display: block; }
            .sb-mobile-toggle { display: inline-flex; }
            .sb-close { display: inline-flex; }

            .admin-topbar {
                padding: 12px 16px;
                height: auto;
                min-height: 58px;
                flex-wrap: wrap;
            }

            .admin-content { padding: 18px 16px 36px; }
            .flash-wrap { padding: 12px 16px 0; }

            .emc-grid-2-3 { grid-template-columns: 1fr; }
            .emc-grid-cards { grid-template-columns: repeat(2, 1fr); }
            .detail-table-wrap .table-desktop { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .detail-table-wrap .table-desktop .emc-table { min-width: 640px; }
            .detail-hero { padding: 20px; }
            .detail-section { padding: 18px; }
            .detail-panel { padding: 18px; }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .admin-topbar {
                padding: 10px 12px;
                gap: 10px;
            }

            .topbar-title { font-size: 0.92rem; }
            .topbar-sub { font-size: 0.7rem; }
            .topbar-actions {
                width: 100%;
                justify-content: stretch;
            }
            .topbar-actions > * { flex: 1 1 calc(50% - 5px); min-width: 0; }
            .topbar-actions .btn-primary,
            .topbar-actions .btn-secondary {
                justify-content: center;
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .admin-content { padding: 14px 12px 28px; }
            .flash-wrap { padding: 10px 12px 0; }

            .emc-grid-2,
            .emc-grid-2-3,
            .detail-grid-2,
            .form-grid-2,
            .form-grid-3,
            .emc-grid-auto {
                grid-template-columns: 1fr;
            }

            .stats-bar-divider { display: none; }

            .emc-grid-cards { grid-template-columns: 1fr; }

            .filter-card { padding: 14px; }
            .form-section-card { padding: 18px 16px; }
            .form-actions { flex-direction: column; }
            .form-actions .btn-primary,
            .form-actions .btn-secondary,
            .form-actions .btn-danger { width: 100%; justify-content: center; }

            /* Form submit rows outside .form-actions */
            form > .form-actions { flex-direction: column; }
            form > div.form-actions .btn-primary,
            form > div.form-actions .btn-secondary { width: 100%; justify-content: center; }

            .detail-hero {
                flex-direction: column;
                padding: 16px;
                gap: 14px;
            }
            .detail-hero-title { font-size: 1.15rem; }
            .detail-kpi-inline { width: 100%; min-width: 0; }
            .detail-layout { grid-template-columns: 1fr; }
            .detail-danger { flex-direction: column; align-items: stretch; }
            .detail-danger .btn-danger-sm { width: 100%; justify-content: center; }

            .detail-table-head { padding: 12px 14px; flex-wrap: wrap; }

            /* Hide desktop tables, show mobile cards */
            .table-desktop { display: none !important; }
            .mobile-cards {
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 12px;
            }

            .emc-pagination {
                flex-direction: column;
                align-items: stretch;
                padding: 12px 14px;
            }
            .emc-pagination > div { justify-content: center; }

            .btn-primary, .btn-secondary, .btn-danger {
                max-width: 100%;
            }

            .vol-card:hover { transform: none; box-shadow: 0 2px 8px rgba(34,51,74,0.06); }
            .member-card:hover { box-shadow: none; }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>

{{-- Mobile overlay --}}
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()" aria-hidden="true"></div>

{{-- ═══════ SIDEBAR ═══════ --}}
<aside class="admin-sidebar" id="adminSidebar" aria-label="القائمة الجانبية">

    {{-- Logo --}}
    <div class="sb-logo">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
            <div style="display:flex;align-items:center;gap:12px;min-width:0;">
            <div style="width:40px;height:40px;background:var(--orange);border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(236,148,60,0.4);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div style="font-size:0.9rem;font-weight:900;color:#fff;line-height:1.1;letter-spacing:-0.3px;">نظام المتطوعين</div>
                <div style="font-size:0.67rem;color:rgba(255,255,255,0.38);margin-top:3px;letter-spacing:0.02em;">EMC Volunteer System</div>
            </div>
            </div>
            <button type="button" class="sb-close" onclick="closeSidebar()" aria-label="إغلاق القائمة">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- User info --}}
    <div class="sb-user">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;background:linear-gradient(135deg,var(--blue),#1a7a9e);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:0.82rem;flex-shrink:0;">
                {{ mb_substr(auth()->user()->name, 0, 1) }}
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.8rem;font-weight:700;color:rgba(255,255,255,0.88);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <div style="font-size:0.65rem;color:rgba(255,255,255,0.38);margin-top:2px;">
                    {{ auth()->user()->role === 'super_admin' ? 'مدير عام' : 'مدير النظام' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sb-nav">
        <div class="sb-section-label">القائمة الرئيسية</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            لوحة التحكم
        </a>

        <a href="{{ route('admin.volunteers.index') }}"
           class="sb-link {{ request()->routeIs('admin.volunteers.*') ? 'active' : '' }}">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            المتطوعون
        </a>

        <a href="{{ route('admin.departments.index') }}"
           class="sb-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            الأقسام
        </a>

        <a href="{{ route('admin.job-descriptions.index') }}"
           class="sb-link {{ request()->routeIs('admin.job-descriptions.*') ? 'active' : '' }}">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            بطاقات الوصف الوظيفي
        </a>

        {{-- Public form link --}}
        <div class="sb-section-label" style="margin-top:8px;">روابط عامة</div>
        <a href="{{ route('volunteer.apply') }}" target="_blank"
           class="sb-link" style="border:1px dashed rgba(236,148,60,0.35);color:rgba(255,255,255,0.7);">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
            </svg>
            استمارة بيانات المتطوعين
        </a>
    </nav>

    {{-- Logout --}}
    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                تسجيل الخروج
            </button>
        </form>
    </div>
</aside>

{{-- ═══════ MAIN AREA ═══════ --}}
<div class="admin-main" id="adminMain">

    {{-- Topbar --}}
    <header class="admin-topbar">
        <div class="topbar-title-wrap">
            <button type="button" class="sb-mobile-toggle" onclick="toggleSidebar()" aria-label="فتح القائمة" aria-expanded="false" id="sbToggle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div class="topbar-head">
                <div class="topbar-title">@yield('page-title', 'لوحة التحكم')</div>
                @hasSection('page-subtitle')
                <div class="topbar-sub">@yield('page-subtitle')</div>
                @endif
            </div>
        </div>
        <div class="topbar-actions">
            @yield('page-actions')
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success') || session('error'))
    <div class="flash-wrap" id="flashMessages">
        @if(session('success'))
        <div class="flash-success" id="flashSuccess">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flash-error" id="flashError">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif
    </div>
    @endif

    {{-- Page content --}}
    <div class="admin-content page-enter">
        @yield('content')
    </div>

</div>

<script>
    function toggleSidebar() {
        const sb = document.getElementById('adminSidebar');
        const ov = document.getElementById('sbOverlay');
        const tg = document.getElementById('sbToggle');
        const open = !sb.classList.contains('open');
        sb.classList.toggle('open', open);
        ov.classList.toggle('show', open);
        document.body.classList.toggle('sidebar-open', open);
        if (tg) tg.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    function closeSidebar() {
        const sb = document.getElementById('adminSidebar');
        const ov = document.getElementById('sbOverlay');
        const tg = document.getElementById('sbToggle');
        sb.classList.remove('open');
        ov.classList.remove('show');
        document.body.classList.remove('sidebar-open');
        if (tg) tg.setAttribute('aria-expanded', 'false');
    }

    // Close drawer on nav link click (mobile)
    document.querySelectorAll('.sb-nav .sb-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });

    // Close on resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 1024) closeSidebar();
    });

    // Auto-dismiss flash messages
    setTimeout(() => {
        const f = document.getElementById('flashMessages');
        if (f) {
            f.style.transition = 'opacity 0.4s, transform 0.4s';
            f.style.opacity = '0';
            f.style.transform = 'translateY(-6px)';
            setTimeout(() => f.remove(), 400);
        }
    }, 4500);
</script>

</body>
</html>
