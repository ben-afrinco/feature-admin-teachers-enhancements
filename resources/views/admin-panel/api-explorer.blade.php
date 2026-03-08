@extends('admin-panel.layout')
@section('title', 'مستكشف API')

@section('content')
<style>
    /* ── API Explorer Layout ─────────────────────── */
    .api-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .api-header h1 { font-size: 22px; font-weight: 700; }
    .api-header p { font-size: 14px; color: var(--text-secondary); margin-top: 4px; }

    /* ── Request Builder ─────────────────────────── */
    .request-builder {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); margin-bottom: 24px; overflow: hidden;
    }
    .request-bar {
        display: flex; gap: 0; border-bottom: 1px solid var(--border);
    }
    .method-select {
        padding: 14px 16px; font-size: 14px; font-weight: 700;
        font-family: 'Courier New', monospace;
        background: var(--bg-primary); border: none; color: var(--success);
        cursor: pointer; min-width: 110px; border-left: 1px solid var(--border);
    }
    .method-select option { font-weight: 700; }
    .url-input {
        flex: 1; padding: 14px 16px; font-size: 14px;
        background: transparent; border: none; color: var(--text-primary);
        font-family: 'Courier New', monospace; outline: none;
    }
    .url-input::placeholder { color: var(--text-muted); }
    .send-btn {
        padding: 14px 24px; background: var(--accent); border: none;
        color: #fff; font-weight: 700; font-size: 14px; cursor: pointer;
        font-family: inherit; transition: background var(--transition);
        display: flex; align-items: center; gap: 8px;
    }
    .send-btn:hover { background: var(--accent-hover); }
    .send-btn:disabled { opacity: 0.6; cursor: not-allowed; }
    .send-btn .spinner {
        width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff; border-radius: 50%;
        animation: spin 0.6s linear infinite; display: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── Tabs ─────────────────────────────────────── */
    .req-tabs {
        display: flex; border-bottom: 1px solid var(--border);
    }
    .req-tab {
        padding: 10px 20px; font-size: 13px; font-weight: 500;
        color: var(--text-muted); cursor: pointer; border: none;
        background: transparent; transition: all var(--transition);
        border-bottom: 2px solid transparent; font-family: inherit;
    }
    .req-tab.active {
        color: var(--accent); border-bottom-color: var(--accent);
    }
    .req-tab:hover { color: var(--text-primary); }

    .req-panel {
        display: none; padding: 16px;
    }
    .req-panel.active { display: block; }

    /* ── Headers Editor ──────────────────────────── */
    .header-row {
        display: flex; gap: 8px; align-items: center; margin-bottom: 8px;
    }
    .header-row input {
        flex: 1; padding: 8px 12px; font-size: 13px;
        background: var(--bg-input); border: 1px solid var(--border);
        border-radius: var(--radius-sm); color: var(--text-primary);
        font-family: 'Courier New', monospace; outline: none;
    }
    .header-row input:focus { border-color: var(--accent); }
    .header-row button {
        width: 32px; height: 32px; border: none; border-radius: 6px;
        background: rgba(239,68,68,0.15); color: var(--danger);
        cursor: pointer; display: flex; align-items: center;
        justify-content: center; font-size: 12px;
        transition: all var(--transition);
    }
    .header-row button:hover { background: var(--danger); color: #fff; }

    /* ── Body Editor ─────────────────────────────── */
    .body-editor {
        width: 100%; min-height: 180px; padding: 14px;
        background: var(--bg-primary); border: 1px solid var(--border);
        border-radius: var(--radius-sm); color: var(--text-primary);
        font-family: 'Courier New', monospace; font-size: 13px;
        resize: vertical; outline: none; line-height: 1.6;
    }
    .body-editor:focus { border-color: var(--accent); }

    /* ── Response Panel ───────────────────────────── */
    .response-panel {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 24px;
    }
    .response-header {
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
    }
    .response-header h3 { font-size: 15px; font-weight: 600; }
    .response-meta {
        display: flex; gap: 16px; font-size: 13px;
    }
    .response-meta .status-badge {
        padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;
    }
    .status-2xx { background: rgba(16,185,129,0.15); color: var(--success); }
    .status-3xx { background: rgba(59,130,246,0.15); color: var(--info); }
    .status-4xx { background: rgba(245,158,11,0.15); color: var(--warning); }
    .status-5xx { background: rgba(239,68,68,0.15); color: var(--danger); }

    .response-body {
        padding: 16px; max-height: 500px; overflow: auto;
    }
    .response-body pre {
        background: var(--bg-primary); padding: 16px; border-radius: 8px;
        font-family: 'Courier New', monospace; font-size: 13px;
        color: var(--text-secondary); white-space: pre-wrap;
        word-break: break-word; line-height: 1.6;
    }
    .response-empty {
        text-align: center; padding: 40px 20px;
    }
    .response-empty i { font-size: 36px; color: var(--text-muted); margin-bottom: 12px; }
    .response-empty p { color: var(--text-muted); font-size: 14px; }

    /* ── Route List ───────────────────────────────── */
    .routes-section {
        margin-bottom: 24px;
    }
    .route-group {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); margin-bottom: 12px; overflow: hidden;
    }
    .route-group-header {
        padding: 14px 20px; display: flex; align-items: center;
        justify-content: space-between; cursor: pointer;
        transition: background var(--transition);
    }
    .route-group-header:hover { background: var(--bg-hover); }
    .route-group-header h3 {
        font-size: 14px; font-weight: 600; display: flex;
        align-items: center; gap: 10px;
    }
    .route-group-header .count {
        font-size: 12px; background: var(--accent-light);
        color: var(--accent); padding: 2px 10px; border-radius: 12px;
        font-weight: 600;
    }
    .route-group-header .chevron {
        transition: transform var(--transition); color: var(--text-muted);
    }
    .route-group.open .chevron { transform: rotate(180deg); }
    .route-group-body {
        display: none; border-top: 1px solid var(--border);
    }
    .route-group.open .route-group-body { display: block; }

    .route-row {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 20px; border-bottom: 1px solid rgba(51,65,85,0.3);
        cursor: pointer; transition: background var(--transition);
    }
    .route-row:last-child { border-bottom: none; }
    .route-row:hover { background: var(--bg-hover); }

    .method-badge {
        font-size: 11px; font-weight: 700; padding: 3px 8px;
        border-radius: 4px; font-family: 'Courier New', monospace;
        min-width: 60px; text-align: center; text-transform: uppercase;
    }
    .method-GET { background: rgba(16,185,129,0.15); color: var(--success); }
    .method-POST { background: rgba(59,130,246,0.15); color: var(--info); }
    .method-PUT, .method-PATCH { background: rgba(245,158,11,0.15); color: var(--warning); }
    .method-DELETE { background: rgba(239,68,68,0.15); color: var(--danger); }
    .method-HEAD, .method-OPTIONS { background: rgba(148,163,184,0.15); color: var(--text-secondary); }

    .route-uri {
        font-family: 'Courier New', monospace; font-size: 13px;
        color: var(--text-primary); flex: 1;
    }
    .route-name {
        font-size: 12px; color: var(--text-muted);
        max-width: 200px; overflow: hidden; text-overflow: ellipsis;
        white-space: nowrap;
    }
    .route-middleware {
        font-size: 11px; color: var(--text-muted); max-width: 150px;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }

    /* ── Search ───────────────────────────────────── */
    .api-search {
        display: flex; align-items: center; gap: 10px;
        background: var(--bg-input); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 16px;
        margin-bottom: 20px;
    }
    .api-search i { color: var(--text-muted); }
    .api-search input {
        flex: 1; border: none; background: none;
        color: var(--text-primary); font-family: inherit;
        font-size: 14px; outline: none;
    }
    .api-search input::placeholder { color: var(--text-muted); }
    .api-method-filter {
        display: flex; gap: 6px; flex-wrap: wrap;
    }
    .api-method-filter button {
        padding: 4px 10px; border: 1px solid var(--border);
        border-radius: 6px; background: transparent;
        color: var(--text-muted); font-size: 12px; font-weight: 600;
        cursor: pointer; font-family: 'Courier New', monospace;
        transition: all var(--transition);
    }
    .api-method-filter button.active {
        border-color: var(--accent); color: var(--accent);
        background: var(--accent-light);
    }

    /* ── Stats ────────────────────────────────────── */
    .api-stats {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px; margin-bottom: 24px;
    }
    .api-stat {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 14px 16px;
        text-align: center;
    }
    .api-stat h4 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
    .api-stat span { font-size: 12px; color: var(--text-muted); }

    @media (max-width: 768px) {
        .request-bar { flex-direction: column; }
        .method-select { border-left: none; border-bottom: 1px solid var(--border); }
        .route-row { flex-wrap: wrap; }
        .route-name, .route-middleware { display: none; }
    }
</style>

<div style="padding: 24px;">
    {{-- Header --}}
    <div class="api-header">
        <div>
            <h1>
                <i class="fas fa-plug" style="color: var(--accent);"></i>
                مستكشف API
            </h1>
            <p>اختبار نقاط النهاية مباشرة من لوحة الإدارة</p>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $allRoutes = $routes;
        $totalRoutes = $allRoutes->count();
        $getMethods = $allRoutes->filter(fn($r) => str_contains($r['method'], 'GET'))->count();
        $postMethods = $allRoutes->filter(fn($r) => str_contains($r['method'], 'POST'))->count();
        $putPatch = $allRoutes->filter(fn($r) => str_contains($r['method'], 'PUT') || str_contains($r['method'], 'PATCH'))->count();
        $deleteMethods = $allRoutes->filter(fn($r) => str_contains($r['method'], 'DELETE'))->count();
    @endphp
    <div class="api-stats">
        <div class="api-stat">
            <h4 style="color: var(--accent);">{{ $totalRoutes }}</h4>
            <span>إجمالي المسارات</span>
        </div>
        <div class="api-stat">
            <h4 style="color: var(--success);">{{ $getMethods }}</h4>
            <span>GET</span>
        </div>
        <div class="api-stat">
            <h4 style="color: var(--info);">{{ $postMethods }}</h4>
            <span>POST</span>
        </div>
        <div class="api-stat">
            <h4 style="color: var(--warning);">{{ $putPatch }}</h4>
            <span>PUT/PATCH</span>
        </div>
        <div class="api-stat">
            <h4 style="color: var(--danger);">{{ $deleteMethods }}</h4>
            <span>DELETE</span>
        </div>
    </div>

    {{-- Request Builder --}}
    <div class="request-builder">
        <div class="request-bar">
            <select class="method-select" id="reqMethod">
                <option value="GET" style="color:#10b981">GET</option>
                <option value="POST" style="color:#3b82f6">POST</option>
                <option value="PUT" style="color:#f59e0b">PUT</option>
                <option value="PATCH" style="color:#f59e0b">PATCH</option>
                <option value="DELETE" style="color:#ef4444">DELETE</option>
            </select>
            <input type="text" class="url-input" id="reqUrl" placeholder="/api/v1/endpoint">
            <button class="send-btn" id="sendBtn" onclick="sendRequest()">
                <span class="spinner" id="sendSpinner"></span>
                <i class="fas fa-paper-plane" id="sendIcon"></i>
                إرسال
            </button>
        </div>

        <div class="req-tabs">
            <button class="req-tab active" onclick="switchReqTab('headers')">
                <i class="fas fa-heading"></i> Headers
                <span id="headersCount" style="font-size:11px;color:var(--accent);margin-right:4px;">(1)</span>
            </button>
            <button class="req-tab" onclick="switchReqTab('body')">
                <i class="fas fa-code"></i> Body
            </button>
            <button class="req-tab" onclick="switchReqTab('auth')">
                <i class="fas fa-key"></i> Auth
            </button>
        </div>

        {{-- Headers Panel --}}
        <div class="req-panel active" id="panel-headers">
            <div id="headersContainer">
                <div class="header-row">
                    <input type="text" placeholder="Key" value="Content-Type" class="header-key">
                    <input type="text" placeholder="Value" value="application/json" class="header-value">
                    <button onclick="this.parentElement.remove(); updateHeadersCount()"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <button class="btn btn-outline" style="margin-top:8px;font-size:12px;" onclick="addHeaderRow()">
                <i class="fas fa-plus"></i> إضافة Header
            </button>
        </div>

        {{-- Body Panel --}}
        <div class="req-panel" id="panel-body">
            <textarea class="body-editor" id="reqBody" placeholder='{"key": "value"}'></textarea>
            <div style="margin-top:8px;display:flex;gap:8px;">
                <button class="btn btn-outline" style="font-size:12px;" onclick="formatBody()">
                    <i class="fas fa-magic"></i> تنسيق JSON
                </button>
                <button class="btn btn-outline" style="font-size:12px;" onclick="clearBody()">
                    <i class="fas fa-eraser"></i> مسح
                </button>
            </div>
        </div>

        {{-- Auth Panel --}}
        <div class="req-panel" id="panel-auth">
            <div style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
                <div style="flex:1;min-width:200px;">
                    <label style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">نوع المصادقة</label>
                    <select id="authType" onchange="toggleAuthFields()" style="width:100%;padding:8px 12px;background:var(--bg-input);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--text-primary);font-family:inherit;font-size:13px;">
                        <option value="none">بدون مصادقة</option>
                        <option value="bearer">Bearer Token</option>
                        <option value="basic">Basic Auth</option>
                    </select>
                </div>
                <div id="bearerField" style="flex:2;min-width:250px;display:none;">
                    <label style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">Token</label>
                    <input type="text" id="authToken" placeholder="Bearer token..." style="width:100%;padding:8px 12px;background:var(--bg-input);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--text-primary);font-family:'Courier New',monospace;font-size:13px;">
                </div>
                <div id="basicFields" style="display:none;flex:2;display:flex;gap:8px;min-width:250px;">
                    <div style="flex:1;">
                        <label style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">اسم المستخدم</label>
                        <input type="text" id="authUser" placeholder="username" style="width:100%;padding:8px 12px;background:var(--bg-input);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--text-primary);font-size:13px;">
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">كلمة المرور</label>
                        <input type="password" id="authPass" placeholder="password" style="width:100%;padding:8px 12px;background:var(--bg-input);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--text-primary);font-size:13px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Response --}}
    <div class="response-panel" id="responsePanel">
        <div class="response-header">
            <h3><i class="fas fa-reply" style="color:var(--accent);"></i> الاستجابة</h3>
            <div class="response-meta" id="responseMeta" style="display:none;">
                <span class="status-badge" id="responseStatus"></span>
                <span style="color:var(--text-muted);"><i class="fas fa-clock"></i> <span id="responseDuration"></span></span>
                <button class="btn btn-outline" style="font-size:11px;padding:3px 10px;" onclick="copyResponse()">
                    <i class="fas fa-copy"></i> نسخ
                </button>
            </div>
        </div>
        <div class="response-body" id="responseBody">
            <div class="response-empty">
                <i class="fas fa-satellite-dish"></i>
                <p>أرسل طلبًا لعرض الاستجابة هنا</p>
            </div>
        </div>
    </div>

    {{-- Route List --}}
    <div class="routes-section">
        <h2 style="font-size:18px;font-weight:700;margin-bottom:16px;">
            <i class="fas fa-sitemap" style="color:var(--accent);"></i>
            المسارات المسجلة
        </h2>

        {{-- Search & Filter --}}
        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:16px;">
            <div class="api-search" style="flex:1;margin-bottom:0;">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="بحث في المسارات..." id="routeSearch" oninput="filterRoutes()">
            </div>
            <div class="api-method-filter">
                <button class="active" onclick="filterByMethod(this, 'ALL')">الكل</button>
                <button onclick="filterByMethod(this, 'GET')">GET</button>
                <button onclick="filterByMethod(this, 'POST')">POST</button>
                <button onclick="filterByMethod(this, 'PUT')">PUT</button>
                <button onclick="filterByMethod(this, 'PATCH')">PATCH</button>
                <button onclick="filterByMethod(this, 'DELETE')">DELETE</button>
            </div>
        </div>

        @foreach($grouped as $prefix => $groupRoutes)
        <div class="route-group" data-group="{{ $prefix }}">
            <div class="route-group-header" onclick="this.parentElement.classList.toggle('open')">
                <h3>
                    <i class="fas fa-folder" style="color:var(--accent);font-size:13px;"></i>
                    /{{ $prefix }}
                    <span class="count">{{ $groupRoutes->count() }}</span>
                </h3>
                <i class="fas fa-chevron-down chevron"></i>
            </div>
            <div class="route-group-body">
                @foreach($groupRoutes as $route)
                @php
                    $methods = explode('|', $route['method']);
                    $primaryMethod = $methods[0] === 'HEAD' && count($methods) > 1 ? $methods[1] : $methods[0];
                @endphp
                <div class="route-row" data-methods="{{ $route['method'] }}" data-uri="{{ $route['uri'] }}"
                     onclick="selectRoute('{{ $primaryMethod }}', '/{{ $route['uri'] }}')">
                    @foreach($methods as $m)
                        @if(!in_array($m, ['HEAD']))
                        <span class="method-badge method-{{ $m }}">{{ $m }}</span>
                        @endif
                    @endforeach
                    <span class="route-uri">/{{ $route['uri'] }}</span>
                    @if($route['name'])
                    <span class="route-name" title="{{ $route['name'] }}">{{ $route['name'] }}</span>
                    @endif
                    @if($route['middleware'])
                    <span class="route-middleware" title="{{ $route['middleware'] }}">
                        <i class="fas fa-shield-alt" style="font-size:10px;"></i>
                        {{ $route['middleware'] }}
                    </span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- History Sidebar (optional, kept minimal) --}}

<script>
    let currentMethodFilter = 'ALL';

    // ── Tab Switching ────────────────────────────
    function switchReqTab(tab) {
        document.querySelectorAll('.req-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.req-panel').forEach(p => p.classList.remove('active'));
        event.target.closest('.req-tab').classList.add('active');
        document.getElementById('panel-' + tab).classList.add('active');
    }

    // ── Headers Management ──────────────────────
    function addHeaderRow() {
        const container = document.getElementById('headersContainer');
        const row = document.createElement('div');
        row.className = 'header-row';
        row.innerHTML = `
            <input type="text" placeholder="Key" class="header-key">
            <input type="text" placeholder="Value" class="header-value">
            <button onclick="this.parentElement.remove(); updateHeadersCount()"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(row);
        updateHeadersCount();
    }

    function updateHeadersCount() {
        const count = document.querySelectorAll('#headersContainer .header-row').length;
        document.getElementById('headersCount').textContent = `(${count})`;
    }

    function getHeaders() {
        const headers = {};
        document.querySelectorAll('#headersContainer .header-row').forEach(row => {
            const key = row.querySelector('.header-key').value.trim();
            const val = row.querySelector('.header-value').value.trim();
            if (key) headers[key] = val;
        });

        // Add auth headers
        const authType = document.getElementById('authType').value;
        if (authType === 'bearer') {
            const token = document.getElementById('authToken').value.trim();
            if (token) headers['Authorization'] = 'Bearer ' + token;
        } else if (authType === 'basic') {
            const user = document.getElementById('authUser').value;
            const pass = document.getElementById('authPass').value;
            if (user) headers['Authorization'] = 'Basic ' + btoa(user + ':' + pass);
        }

        return headers;
    }

    // ── Auth Toggle ─────────────────────────────
    function toggleAuthFields() {
        const type = document.getElementById('authType').value;
        document.getElementById('bearerField').style.display = type === 'bearer' ? 'block' : 'none';
        document.getElementById('basicFields').style.display = type === 'basic' ? 'flex' : 'none';
    }

    // ── Body Helpers ────────────────────────────
    function formatBody() {
        const el = document.getElementById('reqBody');
        try {
            const obj = JSON.parse(el.value);
            el.value = JSON.stringify(obj, null, 2);
        } catch (e) {
            showToast('JSON غير صالح', 'error');
        }
    }

    function clearBody() {
        document.getElementById('reqBody').value = '';
    }

    // ── Send Request ────────────────────────────
    async function sendRequest() {
        const method = document.getElementById('reqMethod').value;
        const url = document.getElementById('reqUrl').value.trim();
        const body = document.getElementById('reqBody').value.trim();
        const headers = getHeaders();

        if (!url) return showToast('يرجى إدخال عنوان URL', 'error');

        const btn = document.getElementById('sendBtn');
        const spinner = document.getElementById('sendSpinner');
        const icon = document.getElementById('sendIcon');

        btn.disabled = true;
        spinner.style.display = 'block';
        icon.style.display = 'none';

        try {
            const res = await apiFetch('{{ route("admin-panel.api.execute") }}', {
                method: 'POST',
                body: JSON.stringify({ method, url, headers, body }),
            });

            displayResponse(res);
        } catch (err) {
            displayResponse({ status: 0, body: JSON.stringify({ error: err.message }), duration: '0ms' });
        } finally {
            btn.disabled = false;
            spinner.style.display = 'none';
            icon.style.display = '';
        }
    }

    function displayResponse(res) {
        const meta = document.getElementById('responseMeta');
        const statusEl = document.getElementById('responseStatus');
        const durationEl = document.getElementById('responseDuration');
        const bodyEl = document.getElementById('responseBody');

        meta.style.display = 'flex';

        // Status badge
        const status = res.status || 0;
        let statusClass = 'status-5xx';
        if (status >= 200 && status < 300) statusClass = 'status-2xx';
        else if (status >= 300 && status < 400) statusClass = 'status-3xx';
        else if (status >= 400 && status < 500) statusClass = 'status-4xx';

        statusEl.className = 'status-badge ' + statusClass;
        statusEl.textContent = status;
        durationEl.textContent = res.duration || '0ms';

        // Format body
        let bodyContent = res.body || '';
        try {
            const parsed = JSON.parse(bodyContent);
            bodyContent = JSON.stringify(parsed, null, 2);
        } catch (e) {}

        bodyEl.innerHTML = `<pre id="responseContent">${escapeHtml(bodyContent)}</pre>`;
    }

    function copyResponse() {
        const content = document.getElementById('responseContent');
        if (content) {
            navigator.clipboard.writeText(content.textContent);
            showToast('تم نسخ الاستجابة', 'success');
        }
    }

    // ── Route Selection ─────────────────────────
    function selectRoute(method, uri) {
        document.getElementById('reqMethod').value = method;
        document.getElementById('reqUrl').value = uri;

        // Update method color
        const select = document.getElementById('reqMethod');
        const colors = { GET: '#10b981', POST: '#3b82f6', PUT: '#f59e0b', PATCH: '#f59e0b', DELETE: '#ef4444' };
        select.style.color = colors[method] || '#94a3b8';

        // Scroll to builder
        document.querySelector('.request-builder').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Method color on change
    document.getElementById('reqMethod').addEventListener('change', function() {
        const colors = { GET: '#10b981', POST: '#3b82f6', PUT: '#f59e0b', PATCH: '#f59e0b', DELETE: '#ef4444' };
        this.style.color = colors[this.value] || '#94a3b8';
    });

    // ── Route Filtering ─────────────────────────
    function filterRoutes() {
        const q = document.getElementById('routeSearch').value.toLowerCase();
        document.querySelectorAll('.route-row').forEach(row => {
            const uri = row.dataset.uri.toLowerCase();
            const methods = row.dataset.methods.toUpperCase();
            const matchesSearch = uri.includes(q);
            const matchesMethod = currentMethodFilter === 'ALL' || methods.includes(currentMethodFilter);
            row.style.display = (matchesSearch && matchesMethod) ? '' : 'none';
        });

        // Hide empty groups
        document.querySelectorAll('.route-group').forEach(group => {
            const visibleRows = group.querySelectorAll('.route-row:not([style*="display: none"])');
            group.style.display = visibleRows.length ? '' : 'none';
        });
    }

    function filterByMethod(btn, method) {
        currentMethodFilter = method;
        document.querySelectorAll('.api-method-filter button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        filterRoutes();
    }

    // ── Utils ────────────────────────────────────
    function escapeHtml(text) {
        const d = document.createElement('div');
        d.textContent = text;
        return d.innerHTML;
    }
</script>
@endsection
