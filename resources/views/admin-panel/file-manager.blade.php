@extends('admin-panel.layout')
@section('title', 'مدير الملفات')

@section('content')
<style>
    /* ── File Manager Layout ─────────────────────── */
    .fm-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; flex-wrap: wrap; margin-bottom: 20px;
    }
    .fm-breadcrumbs {
        display: flex; align-items: center; gap: 6px; font-size: 14px;
        flex-wrap: wrap;
    }
    .fm-breadcrumbs a {
        color: var(--accent); text-decoration: none; font-weight: 500;
        transition: color var(--transition);
    }
    .fm-breadcrumbs a:hover { color: var(--accent-hover); }
    .fm-breadcrumbs .sep { color: var(--text-muted); font-size: 12px; }
    .fm-breadcrumbs .current { color: var(--text-primary); font-weight: 600; }

    .fm-actions {
        display: flex; gap: 10px; flex-wrap: wrap;
    }

    /* ── Toolbar ──────────────────────────────────── */
    .fm-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .fm-search {
        display: flex; align-items: center; gap: 8px;
        background: var(--bg-input); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 8px 14px;
        flex: 1; max-width: 400px;
    }
    .fm-search i { color: var(--text-muted); font-size: 14px; }
    .fm-search input {
        border: none; background: none; color: var(--text-primary);
        font-family: inherit; font-size: 14px; width: 100%; outline: none;
    }
    .fm-search input::placeholder { color: var(--text-muted); }
    .fm-view-toggle {
        display: flex; gap: 4px; background: var(--bg-input);
        border-radius: var(--radius-sm); padding: 4px;
    }
    .fm-view-btn {
        padding: 6px 12px; border: none; border-radius: 6px;
        background: transparent; color: var(--text-muted);
        cursor: pointer; font-size: 14px; transition: all var(--transition);
    }
    .fm-view-btn.active {
        background: var(--accent); color: #fff;
    }

    /* ── Grid View ────────────────────────────────── */
    .fm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px;
    }
    .fm-item {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px;
        display: flex; flex-direction: column; align-items: center;
        gap: 10px; cursor: pointer; transition: all var(--transition);
        position: relative; text-align: center;
    }
    .fm-item:hover {
        border-color: var(--accent); transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,0.12);
    }
    .fm-item.selected {
        border-color: var(--accent);
        background: var(--bg-active);
    }
    .fm-item-icon {
        width: 56px; height: 56px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; transition: transform var(--transition);
    }
    .fm-item:hover .fm-item-icon { transform: scale(1.1); }
    .fm-item-icon.dir { background: rgba(99,102,241,0.15); color: var(--accent); }
    .fm-item-icon.image { background: rgba(16,185,129,0.15); color: var(--success); }
    .fm-item-icon.video { background: rgba(239,68,68,0.15); color: var(--danger); }
    .fm-item-icon.audio { background: rgba(245,158,11,0.15); color: var(--warning); }
    .fm-item-icon.pdf { background: rgba(239,68,68,0.15); color: var(--danger); }
    .fm-item-icon.document { background: rgba(59,130,246,0.15); color: var(--info); }
    .fm-item-icon.text { background: rgba(148,163,184,0.15); color: var(--text-secondary); }
    .fm-item-icon.other { background: rgba(100,116,139,0.15); color: var(--text-muted); }
    .fm-item-name {
        font-size: 13px; font-weight: 500; color: var(--text-primary);
        word-break: break-all; line-height: 1.4;
        max-height: 2.8em; overflow: hidden;
    }
    .fm-item-meta {
        font-size: 11px; color: var(--text-muted);
    }
    .fm-item-actions {
        position: absolute; top: 8px; left: 8px;
        display: flex; gap: 4px; opacity: 0;
        transition: opacity var(--transition);
    }
    .fm-item:hover .fm-item-actions { opacity: 1; }
    .fm-item-actions button {
        width: 28px; height: 28px; border: none; border-radius: 6px;
        background: var(--bg-primary); color: var(--text-secondary);
        cursor: pointer; font-size: 12px; display: flex;
        align-items: center; justify-content: center;
        transition: all var(--transition);
    }
    .fm-item-actions button:hover {
        background: var(--accent); color: #fff;
    }
    .fm-item-actions button.danger:hover {
        background: var(--danger);
    }

    /* ── List View ────────────────────────────────── */
    .fm-list { display: none; }
    .fm-list.active { display: block; }
    .fm-grid.active { display: grid; }
    .fm-list table {
        width: 100%; border-collapse: collapse;
    }
    .fm-list th {
        text-align: right; padding: 10px 14px; font-size: 12px;
        color: var(--text-muted); font-weight: 600;
        border-bottom: 1px solid var(--border); text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .fm-list td {
        padding: 10px 14px; font-size: 13px; color: var(--text-primary);
        border-bottom: 1px solid rgba(51,65,85,0.5);
    }
    .fm-list tr { transition: background var(--transition); cursor: pointer; }
    .fm-list tr:hover { background: var(--bg-hover); }
    .fm-list .list-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 14px; margin-left: 10px; vertical-align: middle;
    }
    .fm-list .list-name {
        font-weight: 500; vertical-align: middle;
    }
    .fm-list .list-actions {
        display: flex; gap: 4px; justify-content: flex-start;
    }

    /* ── Preview Modal ────────────────────────────── */
    .preview-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.75);
        z-index: 2000; display: none; align-items: center;
        justify-content: center; padding: 24px;
    }
    .preview-overlay.active { display: flex; }
    .preview-box {
        background: var(--bg-card); border-radius: var(--radius);
        max-width: 800px; width: 100%; max-height: 85vh;
        overflow: hidden; display: flex; flex-direction: column;
        box-shadow: 0 16px 48px rgba(0,0,0,0.4);
    }
    .preview-header {
        padding: 16px 20px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .preview-header h3 { font-size: 15px; font-weight: 600; }
    .preview-body {
        flex: 1; overflow: auto; padding: 20px;
        display: flex; align-items: center; justify-content: center;
    }
    .preview-body img {
        max-width: 100%; max-height: 60vh; border-radius: 8px;
        object-fit: contain;
    }
    .preview-body video, .preview-body audio { width: 100%; max-width: 100%; }
    .preview-body iframe { width: 100%; height: 60vh; border: none; border-radius: 8px; }
    .preview-body pre {
        width: 100%; padding: 16px; background: var(--bg-primary);
        border-radius: 8px; overflow: auto; font-size: 13px;
        color: var(--text-secondary); white-space: pre-wrap; max-height: 60vh;
    }
    .preview-footer {
        padding: 14px 20px; border-top: 1px solid var(--border);
        display: flex; gap: 10px; justify-content: flex-end;
    }

    /* ── Upload Drop Zone ─────────────────────────── */
    .upload-zone {
        border: 2px dashed var(--border); border-radius: var(--radius);
        padding: 40px 20px; text-align: center;
        transition: all var(--transition); display: none;
        margin-bottom: 20px;
    }
    .upload-zone.active { display: block; }
    .upload-zone.dragover {
        border-color: var(--accent);
        background: var(--accent-light);
    }
    .upload-zone i { font-size: 36px; color: var(--accent); margin-bottom: 12px; }
    .upload-zone p { color: var(--text-secondary); font-size: 14px; margin-bottom: 6px; }
    .upload-zone span { color: var(--text-muted); font-size: 12px; }
    .upload-progress {
        margin-top: 16px; display: none;
    }
    .upload-progress .progress-bar {
        width: 100%; height: 6px; background: var(--bg-input);
        border-radius: 3px; overflow: hidden;
    }
    .upload-progress .progress-fill {
        height: 100%; background: var(--accent);
        border-radius: 3px; transition: width 0.3s ease;
        width: 0%;
    }

    /* ── Empty State ──────────────────────────────── */
    .fm-empty {
        text-align: center; padding: 60px 20px;
    }
    .fm-empty i { font-size: 48px; color: var(--text-muted); margin-bottom: 16px; }
    .fm-empty h3 { font-size: 18px; color: var(--text-secondary); margin-bottom: 8px; }
    .fm-empty p { font-size: 14px; color: var(--text-muted); }

    /* ── Stat Cards ───────────────────────────────── */
    .fm-stats {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px; margin-bottom: 24px;
    }
    .fm-stat-card {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px;
        display: flex; align-items: center; gap: 14px;
    }
    .fm-stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
    }
    .fm-stat-icon.folders { background: rgba(99,102,241,0.15); color: var(--accent); }
    .fm-stat-icon.files { background: rgba(16,185,129,0.15); color: var(--success); }
    .fm-stat-icon.images { background: rgba(245,158,11,0.15); color: var(--warning); }
    .fm-stat-icon.size { background: rgba(59,130,246,0.15); color: var(--info); }
    .fm-stat-info h4 { font-size: 20px; font-weight: 700; }
    .fm-stat-info span { font-size: 12px; color: var(--text-muted); }

    @media (max-width: 768px) {
        .fm-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
        .fm-item { padding: 12px; }
        .fm-item-icon { width: 44px; height: 44px; font-size: 20px; border-radius: 10px; }
        .fm-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<div style="padding: 24px;">
    {{-- Header --}}
    <div class="fm-header">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; margin-bottom: 6px;">
                <i class="fas fa-folder-open" style="color: var(--accent);"></i>
                مدير الملفات
            </h1>
            <div class="fm-breadcrumbs">
                <a href="{{ route('admin-panel.files.index') }}"><i class="fas fa-home"></i> الرئيسية</a>
                @foreach($breadcrumbs as $crumb)
                    <span class="sep"><i class="fas fa-chevron-left"></i></span>
                    @if(!$loop->last)
                        <a href="{{ route('admin-panel.files.index', ['path' => $crumb['path']]) }}">{{ $crumb['name'] }}</a>
                    @else
                        <span class="current">{{ $crumb['name'] }}</span>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="fm-actions">
            <button class="btn btn-primary" onclick="toggleUploadZone()" id="uploadToggleBtn">
                <i class="fas fa-cloud-upload-alt"></i> رفع ملفات
            </button>
            <button class="btn btn-outline" onclick="showNewFolderModal()">
                <i class="fas fa-folder-plus"></i> مجلد جديد
            </button>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $dirs = collect($items)->where('type', 'directory');
        $filesOnly = collect($items)->where('type', 'file');
        $images = $filesOnly->where('mime', 'image');
        $totalSize = $filesOnly->sum('size');
    @endphp
    <div class="fm-stats">
        <div class="fm-stat-card">
            <div class="fm-stat-icon folders"><i class="fas fa-folder"></i></div>
            <div class="fm-stat-info"><h4>{{ $dirs->count() }}</h4><span>مجلدات</span></div>
        </div>
        <div class="fm-stat-card">
            <div class="fm-stat-icon files"><i class="fas fa-file"></i></div>
            <div class="fm-stat-info"><h4>{{ $filesOnly->count() }}</h4><span>ملفات</span></div>
        </div>
        <div class="fm-stat-card">
            <div class="fm-stat-icon images"><i class="fas fa-image"></i></div>
            <div class="fm-stat-info"><h4>{{ $images->count() }}</h4><span>صور</span></div>
        </div>
        <div class="fm-stat-card">
            <div class="fm-stat-icon size"><i class="fas fa-weight-hanging"></i></div>
            <div class="fm-stat-info"><h4>{{ formatFileSize($totalSize) }}</h4><span>الحجم الكلي</span></div>
        </div>
    </div>

    {{-- Upload Zone --}}
    <div class="upload-zone" id="uploadZone">
        <i class="fas fa-cloud-upload-alt"></i>
        <p>اسحب الملفات هنا أو انقر للاختيار</p>
        <span>الحد الأقصى لحجم الملف: 20MB</span>
        <input type="file" id="fileInput" multiple style="display:none;">
        <div class="upload-progress" id="uploadProgress">
            <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
            <p style="margin-top: 8px; font-size: 12px; color: var(--text-muted);" id="progressText">جاري الرفع...</p>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="fm-toolbar">
        <div class="fm-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="بحث في الملفات..." id="searchInput" oninput="filterItems()">
        </div>
        <div class="fm-view-toggle">
            <button class="fm-view-btn active" onclick="setView('grid')" id="gridViewBtn">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="fm-view-btn" onclick="setView('list')" id="listViewBtn">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>

    {{-- Grid View --}}
    @if(count($items) > 0)
    <div class="fm-grid active" id="gridView">
        @foreach($items as $item)
        <div class="fm-item" data-name="{{ $item['name'] }}" data-path="{{ $item['path'] }}" data-type="{{ $item['type'] }}"
             @if($item['type'] === 'directory')
                 ondblclick="window.location='{{ route('admin-panel.files.index', ['path' => $item['path']]) }}'"
             @elseif(isset($item['mime']) && in_array($item['mime'], ['image','video','audio','pdf','text']))
                 ondblclick="previewFile(@json($item))"
             @endif
        >
            <div class="fm-item-actions">
                <button onclick="event.stopPropagation(); renameItem('{{ $item['path'] }}', '{{ $item['name'] }}')" title="إعادة التسمية">
                    <i class="fas fa-pen"></i>
                </button>
                <button class="danger" onclick="event.stopPropagation(); deleteItem('{{ $item['path'] }}')" title="حذف">
                    <i class="fas fa-trash"></i>
                </button>
                @if($item['type'] === 'file' && isset($item['url']))
                <button onclick="event.stopPropagation(); window.open('{{ $item['url'] }}', '_blank')" title="فتح">
                    <i class="fas fa-external-link-alt"></i>
                </button>
                @endif
            </div>

            @if($item['type'] === 'directory')
                <div class="fm-item-icon dir"><i class="fas fa-folder"></i></div>
            @else
                <div class="fm-item-icon {{ $item['mime'] ?? 'other' }}">
                    @switch($item['mime'] ?? 'other')
                        @case('image') <i class="fas fa-image"></i> @break
                        @case('video') <i class="fas fa-video"></i> @break
                        @case('audio') <i class="fas fa-music"></i> @break
                        @case('pdf') <i class="fas fa-file-pdf"></i> @break
                        @case('document') <i class="fas fa-file-word"></i> @break
                        @case('text') <i class="fas fa-file-code"></i> @break
                        @default <i class="fas fa-file"></i>
                    @endswitch
                </div>
            @endif

            <div class="fm-item-name">{{ $item['name'] }}</div>
            <div class="fm-item-meta">
                @if($item['type'] === 'file')
                    {{ formatFileSize($item['size']) }}
                @else
                    مجلد
                @endif
                &bull;
                {{ \Carbon\Carbon::createFromTimestamp($item['modified'])->diffForHumans() }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- List View --}}
    <div class="fm-list" id="listView">
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">الاسم</th>
                    <th>الحجم</th>
                    <th>النوع</th>
                    <th>آخر تعديل</th>
                    <th style="width: 100px;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr data-name="{{ $item['name'] }}"
                    @if($item['type'] === 'directory')
                        ondblclick="window.location='{{ route('admin-panel.files.index', ['path' => $item['path']]) }}'"
                    @elseif(isset($item['mime']) && in_array($item['mime'], ['image','video','audio','pdf','text']))
                        ondblclick="previewFile(@json($item))"
                    @endif
                >
                    <td>
                        @if($item['type'] === 'directory')
                            <span class="list-icon dir" style="background:rgba(99,102,241,0.15);color:var(--accent);">
                                <i class="fas fa-folder"></i>
                            </span>
                        @else
                            <span class="list-icon {{ $item['mime'] ?? 'other' }}">
                                @switch($item['mime'] ?? 'other')
                                    @case('image') <i class="fas fa-image" style="color:var(--success);"></i> @break
                                    @case('video') <i class="fas fa-video" style="color:var(--danger);"></i> @break
                                    @case('audio') <i class="fas fa-music" style="color:var(--warning);"></i> @break
                                    @case('pdf') <i class="fas fa-file-pdf" style="color:var(--danger);"></i> @break
                                    @default <i class="fas fa-file" style="color:var(--text-muted);"></i>
                                @endswitch
                            </span>
                        @endif
                        <span class="list-name">{{ $item['name'] }}</span>
                    </td>
                    <td>{{ $item['type'] === 'file' ? formatFileSize($item['size']) : '—' }}</td>
                    <td>
                        @if($item['type'] === 'directory')
                            <span class="badge" style="background:rgba(99,102,241,0.15);color:var(--accent);">مجلد</span>
                        @else
                            <span class="badge">{{ strtoupper($item['extension'] ?? '') }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::createFromTimestamp($item['modified'])->diffForHumans() }}</td>
                    <td>
                        <div class="list-actions">
                            <button class="btn btn-icon btn-sm" onclick="renameItem('{{ $item['path'] }}', '{{ $item['name'] }}')" title="إعادة التسمية">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn btn-icon btn-sm danger" onclick="deleteItem('{{ $item['path'] }}')" title="حذف">
                                <i class="fas fa-trash"></i>
                            </button>
                            @if($item['type'] === 'file' && isset($item['url']))
                            <button class="btn btn-icon btn-sm" onclick="window.open('{{ $item['url'] }}', '_blank')" title="فتح">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="fm-empty">
        <i class="fas fa-folder-open"></i>
        <h3>هذا المجلد فارغ</h3>
        <p>ارفع ملفات أو أنشئ مجلدًا جديدًا للبدء</p>
    </div>
    @endif
</div>

{{-- Preview Modal --}}
<div class="preview-overlay" id="previewModal" onclick="if(event.target===this) closePreview()">
    <div class="preview-box">
        <div class="preview-header">
            <h3 id="previewTitle">معاينة</h3>
            <button class="btn btn-icon" onclick="closePreview()"><i class="fas fa-times"></i></button>
        </div>
        <div class="preview-body" id="previewBody"></div>
        <div class="preview-footer">
            <a id="previewDownload" href="#" download class="btn btn-outline"><i class="fas fa-download"></i> تحميل</a>
            <button class="btn" onclick="closePreview()">إغلاق</button>
        </div>
    </div>
</div>

{{-- New Folder Modal --}}
<div class="modal-overlay" id="newFolderModal" onclick="if(event.target===this) this.classList.remove('active')" style="position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:2000;display:none;align-items:center;justify-content:center;">
    <div style="background:var(--bg-card);border-radius:var(--radius);padding:24px;width:100%;max-width:400px;box-shadow:var(--shadow);">
        <h3 style="font-size:16px;margin-bottom:16px;"><i class="fas fa-folder-plus" style="color:var(--accent);"></i> إنشاء مجلد جديد</h3>
        <div class="form-group" style="margin-bottom:16px;">
            <input type="text" id="newFolderName" class="form-control" placeholder="اسم المجلد" style="width:100%;padding:10px 14px;background:var(--bg-input);border:1px solid var(--border);border-radius:var(--radius-sm);color:var(--text-primary);font-family:inherit;font-size:14px;">
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button class="btn" onclick="document.getElementById('newFolderModal').style.display='none'">إلغاء</button>
            <button class="btn btn-primary" onclick="createFolder()">إنشاء</button>
        </div>
    </div>
</div>

<script>
    const currentPath = @json($path);

    // ── View Toggle ──────────────────────────────
    function setView(view) {
        const grid = document.getElementById('gridView');
        const list = document.getElementById('listView');
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');

        if (view === 'grid') {
            grid?.classList.add('active');
            list?.classList.remove('active');
            gridBtn?.classList.add('active');
            listBtn?.classList.remove('active');
        } else {
            grid?.classList.remove('active');
            list?.classList.add('active');
            gridBtn?.classList.remove('active');
            listBtn?.classList.add('active');
        }
        localStorage.setItem('fm_view', view);
    }

    // Restore saved view
    const savedView = localStorage.getItem('fm_view');
    if (savedView) setView(savedView);

    // ── Search Filter ────────────────────────────
    function filterItems() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.fm-item, .fm-list tr[data-name]').forEach(el => {
            const name = el.dataset.name?.toLowerCase() || '';
            el.style.display = name.includes(q) ? '' : 'none';
        });
    }

    // ── Upload ───────────────────────────────────
    function toggleUploadZone() {
        const zone = document.getElementById('uploadZone');
        zone.classList.toggle('active');
    }

    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');

    uploadZone?.addEventListener('click', (e) => {
        if (e.target === uploadZone || e.target.tagName === 'P' || e.target.tagName === 'I' || e.target.tagName === 'SPAN') {
            fileInput.click();
        }
    });

    uploadZone?.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });
    uploadZone?.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
    });
    uploadZone?.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files);
    });
    fileInput?.addEventListener('change', () => {
        if (fileInput.files.length) uploadFiles(fileInput.files);
    });

    async function uploadFiles(files) {
        const formData = new FormData();
        Array.from(files).forEach(f => formData.append('files[]', f));
        formData.append('path', currentPath);

        const progress = document.getElementById('uploadProgress');
        const fill = document.getElementById('progressFill');
        const text = document.getElementById('progressText');
        progress.style.display = 'block';
        fill.style.width = '0%';
        text.textContent = 'جاري الرفع...';

        try {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("admin-panel.files.upload") }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name=csrf-token]').content);

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    const pct = Math.round((e.loaded / e.total) * 100);
                    fill.style.width = pct + '%';
                    text.textContent = `جاري الرفع... ${pct}%`;
                }
            };

            xhr.onload = () => {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    showToast(res.message, 'success');
                    setTimeout(() => location.reload(), 600);
                } else {
                    showToast('حدث خطأ أثناء الرفع', 'error');
                }
            };
            xhr.onerror = () => showToast('فشل الاتصال', 'error');
            xhr.send(formData);
        } catch (err) {
            showToast('حدث خطأ: ' + err.message, 'error');
        }
    }

    // ── New Folder ───────────────────────────────
    function showNewFolderModal() {
        document.getElementById('newFolderModal').style.display = 'flex';
        document.getElementById('newFolderName').value = '';
        document.getElementById('newFolderName').focus();
    }

    async function createFolder() {
        const name = document.getElementById('newFolderName').value.trim();
        if (!name) return showToast('يرجى إدخال اسم المجلد', 'error');

        const res = await apiFetch('{{ route("admin-panel.files.mkdir") }}', {
            method: 'POST',
            body: JSON.stringify({ name, path: currentPath }),
        });

        if (res.success) {
            showToast(res.message, 'success');
            setTimeout(() => location.reload(), 500);
        } else {
            showToast('حدث خطأ', 'error');
        }
        document.getElementById('newFolderModal').style.display = 'none';
    }

    // ── Delete ───────────────────────────────────
    async function deleteItem(path) {
        if (!confirm('هل أنت متأكد من حذف هذا العنصر؟')) return;

        const res = await apiFetch('{{ route("admin-panel.files.delete") }}', {
            method: 'DELETE',
            body: JSON.stringify({ path }),
        });

        if (res.success) {
            showToast(res.message, 'success');
            setTimeout(() => location.reload(), 500);
        } else {
            showToast('حدث خطأ في الحذف', 'error');
        }
    }

    // ── Rename ───────────────────────────────────
    async function renameItem(oldPath, currentName) {
        const newName = prompt('أدخل الاسم الجديد:', currentName);
        if (!newName || newName === currentName) return;

        const res = await apiFetch('{{ route("admin-panel.files.rename") }}', {
            method: 'PATCH',
            body: JSON.stringify({ old_path: oldPath, new_name: newName }),
        });

        if (res.success) {
            showToast(res.message, 'success');
            setTimeout(() => location.reload(), 500);
        } else {
            showToast('حدث خطأ في إعادة التسمية', 'error');
        }
    }

    // ── Preview ──────────────────────────────────
    function previewFile(item) {
        const modal = document.getElementById('previewModal');
        const body = document.getElementById('previewBody');
        const title = document.getElementById('previewTitle');
        const download = document.getElementById('previewDownload');

        title.textContent = item.name;
        download.href = item.url;
        body.innerHTML = '';

        switch (item.mime) {
            case 'image':
                body.innerHTML = `<img src="${item.url}" alt="${item.name}">`;
                break;
            case 'video':
                body.innerHTML = `<video controls><source src="${item.url}"></video>`;
                break;
            case 'audio':
                body.innerHTML = `<audio controls style="width:100%"><source src="${item.url}"></audio>`;
                break;
            case 'pdf':
                body.innerHTML = `<iframe src="${item.url}"></iframe>`;
                break;
            case 'text':
                fetch(item.url)
                    .then(r => r.text())
                    .then(text => { body.innerHTML = `<pre>${escapeHtml(text)}</pre>`; });
                break;
            default:
                body.innerHTML = `<div class="fm-empty"><i class="fas fa-eye-slash"></i><h3>لا يمكن معاينة هذا الملف</h3><p>يمكنك تحميله بدلاً من ذلك</p></div>`;
        }
        modal.classList.add('active');
    }

    function closePreview() {
        document.getElementById('previewModal').classList.remove('active');
        document.getElementById('previewBody').innerHTML = '';
    }

    function escapeHtml(text) {
        const d = document.createElement('div');
        d.textContent = text;
        return d.innerHTML;
    }
</script>
@endsection

@php
function formatFileSize($bytes) {
    if (!$bytes) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), 1) . ' ' . $units[$i];
}
@endphp
