<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة الإدارة') - LingoPulse Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #1e293b;
            --bg-input: #334155;
            --bg-hover: #334155;
            --bg-active: rgba(99, 102, 241, 0.15);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --accent-light: rgba(99, 102, 241, 0.12);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --border: #334155;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 4px 24px rgba(0,0,0,0.25);
            --sidebar-width: 280px;
            --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Sidebar ───────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-secondary);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform var(--transition);
        }

        .sidebar-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header .logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--accent), #a855f7);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 18px; color: #fff;
        }

        .sidebar-header h2 {
            font-size: 16px; font-weight: 700;
            color: var(--text-primary);
        }

        .sidebar-header span {
            font-size: 11px; color: var(--text-muted);
        }

        .sidebar-nav {
            flex: 1; overflow-y: auto; padding: 16px 12px;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .nav-group-label {
            font-size: 11px; font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 12px 8px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px; font-weight: 500;
            transition: all var(--transition);
            margin-bottom: 2px;
        }

        .nav-item:hover { background: var(--bg-hover); color: var(--text-primary); }
        .nav-item.active { background: var(--bg-active); color: var(--accent); font-weight: 700; }
        .nav-item i { width: 20px; text-align: center; font-size: 15px; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }

        .sidebar-footer a {
            display: flex; align-items: center; gap: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            transition: all var(--transition);
        }

        .sidebar-footer a:hover { background: var(--bg-hover); color: var(--danger); }

        /* ── Main Content ──────────────────────────────── */
        .main-content {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            padding: 24px 32px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-hover));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header .breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 13px; color: var(--text-muted);
        }

        .page-header .breadcrumb a { color: var(--accent); text-decoration: none; }

        /* ── Cards ──────────────────────────────────────── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }

        .card-header h3 { font-size: 15px; font-weight: 700; }
        .card-body { padding: 20px; }

        /* ── Buttons ───────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            border: none;
            font-family: inherit;
            font-size: 13px; font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
        }

        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { opacity: 0.9; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { opacity: 0.9; }
        .btn-warning { background: var(--warning); color: #000; }
        .btn-ghost { background: transparent; color: var(--text-secondary); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--bg-hover); color: var(--text-primary); }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-icon { padding: 8px; min-width: 36px; justify-content: center; }

        /* ── Form Elements ─────────────────────────────── */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px; }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
            transition: border-color var(--transition);
        }

        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }

        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: left 12px center; padding-left: 32px; }

        textarea.form-control { resize: vertical; min-height: 80px; }

        /* ── Table ──────────────────────────────────────── */
        .table-container { overflow-x: auto; }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 12px 16px;
            text-align: right;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .data-table th:hover { color: var(--accent); }

        .data-table th .sort-icon {
            margin-right: 4px;
            font-size: 10px;
            opacity: 0.5;
        }

        .data-table th.sorted .sort-icon { opacity: 1; color: var(--accent); }

        .data-table td {
            padding: 12px 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
            white-space: nowrap;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .data-table tbody tr { transition: background var(--transition); }
        .data-table tbody tr:hover { background: var(--bg-hover); }
        .data-table tbody tr.selected { background: var(--accent-light); }

        .data-table .cell-editable {
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all var(--transition);
        }

        .data-table .cell-editable:hover { background: var(--bg-input); }

        .data-table .cell-editable input,
        .data-table .cell-editable select {
            background: var(--bg-input);
            border: 2px solid var(--accent);
            color: var(--text-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: inherit;
            font-size: 13px;
            width: 100%;
            outline: none;
        }

        /* Column resize handle */
        .data-table th .resize-handle {
            position: absolute;
            left: 0; top: 0;
            width: 4px; height: 100%;
            cursor: col-resize;
            background: transparent;
        }

        .data-table th .resize-handle:hover { background: var(--accent); }

        /* ── Badges ────────────────────────────────────── */
        .badge {
            display: inline-flex;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-create { background: rgba(16,185,129,0.15); color: var(--success); }
        .badge-update { background: rgba(59,130,246,0.15); color: var(--info); }
        .badge-delete { background: rgba(239,68,68,0.15); color: var(--danger); }
        .badge-restore { background: rgba(245,158,11,0.15); color: var(--warning); }
        .badge-export { background: rgba(139,92,246,0.15); color: #8b5cf6; }
        .badge-import { background: rgba(6,182,212,0.15); color: #06b6d4; }
        .badge-force_delete { background: rgba(239,68,68,0.25); color: var(--danger); }
        .badge-trashed { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px dashed var(--danger); }

        /* ── Modal ──────────────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 200;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: var(--shadow);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 { font-size: 16px; font-weight: 700; }

        .modal-close {
            background: none; border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
        }

        .modal-close:hover { color: var(--danger); }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid var(--border); display: flex; gap: 12px; justify-content: flex-end; }

        /* ── Pagination ────────────────────────────────── */
        .pagination {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 20px;
            justify-content: center;
        }

        .pagination a, .pagination span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 36px; height: 36px;
            padding: 0 10px;
            border-radius: var(--radius-sm);
            font-size: 13px; font-weight: 600;
            color: var(--text-secondary);
            background: var(--bg-input);
            border: 1px solid var(--border);
            text-decoration: none;
            transition: all var(--transition);
        }

        .pagination a:hover { background: var(--accent); color: #fff; border-color: var(--accent); }
        .pagination .active span { background: var(--accent); color: #fff; border-color: var(--accent); }
        .pagination .disabled span { opacity: 0.4; cursor: not-allowed; }

        /* ── Toast Notification ─────────────────────────── */
        .toast-container {
            position: fixed;
            top: 24px;
            left: 24px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600;
            display: flex; align-items: center; gap: 10px;
            box-shadow: var(--shadow);
            animation: slideIn 0.3s ease;
            min-width: 280px;
        }

        .toast-success { background: var(--success); color: #fff; }
        .toast-error { background: var(--danger); color: #fff; }
        .toast-info { background: var(--info); color: #fff; }

        @keyframes slideIn { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }

        /* ── Toolbar ────────────────────────────────────── */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
        }

        .search-box input:focus { border-color: var(--accent); outline: none; }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* ── Grid ───────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all var(--transition);
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.08);
        }

        .stat-card .stat-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            background: var(--accent-light);
            color: var(--accent);
            flex-shrink: 0;
        }

        .stat-card .stat-info { flex: 1; }
        .stat-card .stat-info .stat-value { font-size: 24px; font-weight: 800; line-height: 1.2; }
        .stat-card .stat-info .stat-label { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }
        .stat-card .stat-info .stat-sub { font-size: 11px; color: var(--text-muted); margin-top: 4px; }
        .stat-card .stat-info .stat-sub span { color: var(--success); font-weight: 700; }



        /* ── Responsive ────────────────────────────────── */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 150;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            color: var(--text-primary);
            width: 44px; height: 44px;
            border-radius: var(--radius-sm);
            font-size: 20px;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-right: 0; padding: 16px; }
            .mobile-toggle { display: flex; align-items: center; justify-content: center; }
        }

        /* ── Utility ───────────────────────────────────── */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .gap-8 { gap: 8px; }
        .gap-12 { gap: 12px; }
        .gap-16 { gap: 16px; }
        .mt-8 { margin-top: 8px; }
        .mt-16 { margin-top: 16px; }
        .mb-16 { margin-bottom: 16px; }
        .text-muted { color: var(--text-muted); }
        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        @yield('extra-styles')
    </style>
</head>
<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">LP</div>
            <div>
                <h2>LingoPulse</h2>
                <span>لوحة الإدارة المتقدمة</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <!-- Dashboard -->
            <a href="{{ route('admin-panel.dashboard') }}" class="nav-item {{ request()->routeIs('admin-panel.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                لوحة المعلومات
            </a>

            @foreach($nav as $groupKey => $group)
                <div class="nav-group-label">{{ $group['label_ar'] }}</div>
                @foreach($group['items'] as $item)
                    @php
                        $isActive = false;
                        if (in_array($item['slug'], ['file-manager', 'api-explorer', 'activity-log'])) {
                            $isActive = request()->is("admin-panel/{$item['slug']}*");
                        } else {
                            $isActive = request()->is("admin-panel/resource/{$item['slug']}*");
                        }
                        $href = match($item['slug']) {
                            'file-manager'  => route('admin-panel.files.index'),
                            'api-explorer'  => route('admin-panel.api.index'),
                            'activity-log'  => route('admin-panel.activity-log.index'),
                            default         => route('admin-panel.resource.index', $item['slug']),
                        };
                    @endphp
                    <a href="{{ $href }}" class="nav-item {{ $isActive ? 'active' : '' }}">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                        {{ $item['label_ar'] }}
                    </a>
                @endforeach
            @endforeach
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('developer') }}"><i class="fa-solid fa-arrow-right"></i> العودة للوحة القديمة</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Global JS Utilities -->
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // Toast notification
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i> ${message}`;
            container.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3500);
        }

        // Fetch wrapper with CSRF
        async function apiFetch(url, options = {}) {
            const defaults = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
            };
            const merged = { ...defaults, ...options, headers: { ...defaults.headers, ...options.headers } };
            try {
                const res = await fetch(url, merged);
                const data = await res.json();
                if (data.success) {
                    showToast(data.message);
                } else {
                    showToast(data.message || 'حدث خطأ', 'error');
                }
                return data;
            } catch (e) {
                showToast('خطأ في الاتصال', 'error');
                throw e;
            }
        }

        // Format time ago
        function timeAgo(dateStr) {
            const diff = (Date.now() - new Date(dateStr)) / 1000;
            if (diff < 60) return 'الآن';
            if (diff < 3600) return Math.floor(diff/60) + ' دقيقة';
            if (diff < 86400) return Math.floor(diff/3600) + ' ساعة';
            return Math.floor(diff/86400) + ' يوم';
        }

        // Format file size
        function formatSize(bytes) {
            if (!bytes) return '—';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
        }
    </script>

    @yield('scripts')
</body>
</html>
