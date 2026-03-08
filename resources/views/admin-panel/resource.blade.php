@extends('admin-panel.layout')
@section('title', $config['label_ar'])

@section('extra-styles')
/* ── Filters Panel ─── */
.filters-panel { display:none; padding:16px 20px; border-bottom:1px solid var(--border); }
.filters-panel.open { display:block; }
.filters-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:12px; }
.cols-panel { display:none; position:absolute; top:calc(100% + 8px); right:0; background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius-sm); padding:12px; z-index:100; box-shadow:0 4px 12px rgba(0,0,0,0.1); min-width:200px; max-height:300px; overflow-y:auto; }
.cols-panel.open { display:flex; flex-direction:column; gap:10px; }
.cols-panel label { display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer; color:var(--text-primary); }
.bulk-bar { display:none; padding:10px 20px; background:var(--accent-light); border-bottom:1px solid var(--accent); gap:12px; align-items:center; font-size:13px; font-weight:600; }
.trashed-row { opacity:0.6; text-decoration:line-through; }
.trashed-row td:first-child::after { content:' (محذوف)'; color:var(--danger); font-size:11px; }
.cell-actions { display:flex; gap:4px; }
.cell-actions button { background:none; border:none; color:var(--text-muted); cursor:pointer; padding:4px 6px; border-radius:4px; font-size:13px; transition:all var(--transition); }
.cell-actions button:hover { color:var(--text-primary); background:var(--bg-input); }
.cell-actions .btn-edit:hover { color:var(--info); }
.cell-actions .btn-del:hover { color:var(--danger); }
.cell-actions .btn-restore:hover { color:var(--success); }
.cell-actions .btn-copy:hover { color:var(--warning); }
.per-page-select { background:var(--bg-input); border:1px solid var(--border); color:var(--text-primary); padding:6px 10px; border-radius:var(--radius-sm); font-family:inherit; font-size:13px; }
.import-area { border:2px dashed var(--border); border-radius:var(--radius); padding:30px; text-align:center; cursor:pointer; transition:border-color var(--transition); }
.import-area:hover { border-color:var(--accent); }
.import-area.dragover { border-color:var(--accent); background:var(--accent-light); }
.checkbox-cell { width:40px; }
.checkbox-cell input[type="checkbox"] { width:16px; height:16px; accent-color:var(--accent); cursor:pointer; }
.trashed-toggle { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-secondary); cursor:pointer; }
.trashed-toggle input { accent-color:var(--accent); }
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid {{ $config['icon'] }}"></i> {{ $config['label_ar'] }}</h1>
        <div class="breadcrumb mt-8">
            <a href="{{ route('admin-panel.dashboard') }}">لوحة الإدارة</a> / {{ $config['label_ar'] }}
        </div>
    </div>
    <div class="flex gap-8">
        @if(empty($config['readonly']))
        <button class="btn btn-primary" onclick="openCreateModal()"><i class="fa-solid fa-plus"></i> إضافة جديد</button>
        <a href="{{ route('admin-panel.resource.export', $resource) }}" class="btn btn-ghost"><i class="fa-solid fa-download"></i> تصدير</a>
        <button class="btn btn-ghost" onclick="openImportModal()"><i class="fa-solid fa-upload"></i> استيراد</button>
        @endif
    </div>
</div>

<div class="card">
    {{-- Toolbar --}}
    <div class="toolbar">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="بحث سريع..." value="{{ request('search') }}">
        </div>
        <button class="btn btn-ghost btn-sm" onclick="toggleFilters()"><i class="fa-solid fa-filter"></i> فلاتر</button>
        <div style="position:relative; display:inline-block;">
            <button class="btn btn-ghost btn-sm" onclick="toggleColsPanel()"><i class="fa-solid fa-eye"></i> أعمدة</button>
            <div class="cols-panel" id="colsPanel">
                @foreach($config['columns'] as $colKey => $colConfig)
                <label><input type="checkbox" class="col-toggle" value="{{ $colKey }}" checked onchange="toggleColumn('{{ $colKey }}', this.checked)"> {{ $colConfig['label_ar'] }}</label>
                @endforeach
            </div>
        </div>
        <label class="trashed-toggle">
            <input type="checkbox" id="trashedToggle" {{ request('trashed') ? 'checked' : '' }}> المحذوفة
        </label>
        <select class="per-page-select" id="perPageSelect" onchange="changePerPage(this.value)">
            @foreach([10,25,50,100] as $pp)
            <option value="{{ $pp }}" {{ request('per_page', 25) == $pp ? 'selected' : '' }}>{{ $pp }}</option>
            @endforeach
        </select>
    </div>

    {{-- Filters --}}
    <div class="filters-panel {{ request('filters') ? 'open' : '' }}" id="filtersPanel">
        <form id="filtersForm" class="filters-grid">
            @foreach($config['filters'] as $fKey => $fConfig)
            <div class="form-group" style="margin-bottom:0">
                <label>{{ $fConfig['label_ar'] }}</label>
                @if($fConfig['type'] === 'select')
                    <select name="filters[{{ $fKey }}]" class="form-control">
                        <option value="">الكل</option>
                        @foreach($fConfig['options'] as $opt)
                        <option value="{{ $opt }}" {{ request("filters.{$fKey}") == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                @elseif($fConfig['type'] === 'relation_select')
                    <select name="filters[{{ $fKey }}]" class="form-control">
                        <option value="">الكل</option>
                        @if(isset($filterOptions[$fKey]))
                            @foreach($filterOptions[$fKey] as $opt)
                            <option value="{{ $opt['id'] }}" {{ request("filters.{$fKey}") == $opt['id'] ? 'selected' : '' }}>{{ $opt['label'] }}</option>
                            @endforeach
                        @endif
                    </select>
                @elseif($fConfig['type'] === 'date_range')
                    <div class="flex gap-8">
                        <input type="date" name="filters[{{ $fKey }}][from]" class="form-control" value="{{ request("filters.{$fKey}.from") }}" placeholder="من">
                        <input type="date" name="filters[{{ $fKey }}][to]" class="form-control" value="{{ request("filters.{$fKey}.to") }}" placeholder="إلى">
                    </div>
                @elseif($fConfig['type'] === 'boolean')
                    <select name="filters[{{ $fKey }}]" class="form-control">
                        <option value="">الكل</option>
                        <option value="1" {{ request("filters.{$fKey}") === '1' ? 'selected' : '' }}>نعم</option>
                        <option value="0" {{ request("filters.{$fKey}") === '0' ? 'selected' : '' }}>لا</option>
                    </select>
                @else
                    <input type="text" name="filters[{{ $fKey }}]" class="form-control" value="{{ request("filters.{$fKey}") }}" placeholder="{{ $fConfig['label_ar'] }}">
                @endif
            </div>
            @endforeach
        </form>
        <div class="flex gap-8 mt-8" style="justify-content:flex-end">
            <button class="btn btn-primary btn-sm" onclick="applyFilters()"><i class="fa-solid fa-check"></i> تطبيق</button>
            <a href="{{ route('admin-panel.resource.index', $resource) }}" class="btn btn-ghost btn-sm"><i class="fa-solid fa-xmark"></i> مسح</a>
        </div>
    </div>

    {{-- Bulk Actions Bar --}}
    <div class="bulk-bar" id="bulkBar">
        <span id="bulkCount">0</span> محدد
        @if(empty($config['readonly']))
        <button class="btn btn-danger btn-sm" onclick="bulkAction('delete')"><i class="fa-solid fa-trash"></i> حذف</button>
        <button class="btn btn-success btn-sm" onclick="bulkAction('restore')"><i class="fa-solid fa-rotate-left"></i> استعادة</button>
        <button class="btn btn-danger btn-sm" onclick="bulkAction('force_delete')"><i class="fa-solid fa-skull"></i> حذف نهائي</button>
        @endif
    </div>

    {{-- Table --}}
    <div class="table-container">
        <table class="data-table" id="resourceTable">
            <thead>
                <tr>
                    <th class="checkbox-cell"><input type="checkbox" id="checkAll" onchange="toggleAll(this)"></th>
                    @foreach($config['columns'] as $colKey => $colConfig)
                    @php
                        $isSorted = request('sort') === $colKey;
                        $currentDir = request('dir', 'desc');
                        $nextDir = ($isSorted && $currentDir === 'asc') ? 'desc' : 'asc';
                    @endphp
                    <th class="{{ $isSorted ? 'sorted' : '' }}" data-col="{{ $colKey }}"
                        @if(!empty($colConfig['sortable'])) 
                        onclick="sortBy('{{ $colKey }}', '{{ $nextDir }}')" 
                        @endif>
                        {{ $colConfig['label_ar'] }}
                        @if(!empty($colConfig['sortable']))
                        <span class="sort-icon">
                            @if($isSorted)
                                <i class="fa-solid {{ $currentDir === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            @else
                                <i class="fa-solid fa-sort"></i>
                            @endif
                        </span>
                        @endif
                        <span class="resize-handle" onmousedown="startResize(event, this)"></span>
                    </th>
                    @endforeach
                    <th style="width:120px">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                @php $isTrashed = method_exists($record, 'trashed') && $record->trashed(); @endphp
                <tr class="{{ $isTrashed ? 'trashed-row' : '' }}" data-id="{{ $record->{$config['primaryKey']} }}">
                    <td class="checkbox-cell"><input type="checkbox" class="row-check" value="{{ $record->{$config['primaryKey']} }}" onchange="updateBulk()"></td>
                    @foreach($config['columns'] as $colKey => $colConfig)
                    <td data-col="{{ $colKey }}">
                        @if(!empty($colConfig['relation']))
                            @php
                                $relParts = explode('.', $colConfig['relation']);
                                $relValue = $record;
                                foreach ($relParts as $p) $relValue = $relValue?->$p;
                                $display = $relValue?->{$colConfig['display']} ?? '—';
                            @endphp
                            {{ Str::limit($display, 40) }}
                        @elseif(($colConfig['type'] ?? '') === 'datetime')
                            <span title="{{ $record->$colKey }}">{{ $record->$colKey ? \Carbon\Carbon::parse($record->$colKey)->format('Y/m/d H:i') : '—' }}</span>
                        @elseif(($colConfig['type'] ?? '') === 'boolean')
                            @if(!empty($colConfig['editable']) && !$isTrashed)
                                <span class="cell-editable" ondblclick="inlineEdit(this, '{{ $record->{$config['primaryKey']} }}', '{{ $colKey }}', 'boolean')">
                                    {!! $record->$colKey ? '<i class="fa-solid fa-check text-success"></i>' : '<i class="fa-solid fa-xmark text-danger"></i>' !!}
                                </span>
                            @else
                                {!! $record->$colKey ? '<i class="fa-solid fa-check text-success"></i>' : '<i class="fa-solid fa-xmark text-danger"></i>' !!}
                            @endif
                        @elseif(($colConfig['type'] ?? '') === 'badge')
                            <span class="badge badge-{{ $record->$colKey }}">{{ $record->$colKey }}</span>
                        @elseif(($colConfig['type'] ?? '') === 'number')
                            @if(!empty($colConfig['editable']) && !$isTrashed)
                                <span class="cell-editable" ondblclick="inlineEdit(this, '{{ $record->{$config['primaryKey']} }}', '{{ $colKey }}', 'number')">{{ $record->$colKey ?? '—' }}</span>
                            @else
                                {{ $record->$colKey ?? '—' }}
                            @endif
                        @elseif(($colConfig['type'] ?? '') === 'select')
                            @if(!empty($colConfig['editable']) && !$isTrashed)
                                <span class="cell-editable" ondblclick="inlineEdit(this, '{{ $record->{$config['primaryKey']} }}', '{{ $colKey }}', 'select', {{ json_encode($colConfig['options']) }})">{{ $record->$colKey ?? '—' }}</span>
                            @else
                                {{ $record->$colKey ?? '—' }}
                            @endif
                        @else
                            @if(!empty($colConfig['editable']) && !$isTrashed)
                                <span class="cell-editable" ondblclick="inlineEdit(this, '{{ $record->{$config['primaryKey']} }}', '{{ $colKey }}', 'text')">{{ Str::limit($record->$colKey, 50) ?? '—' }}</span>
                            @else
                                {{ Str::limit($record->$colKey, 50) ?? '—' }}
                            @endif
                        @endif
                    </td>
                    @endforeach
                    <td>
                        <div class="cell-actions">
                            @if($isTrashed)
                                <button class="btn-restore" title="استعادة" onclick="restoreRecord('{{ $record->{$config['primaryKey']} }}')"><i class="fa-solid fa-rotate-left"></i></button>
                                <button class="btn-del" title="حذف نهائي" onclick="forceDeleteRecord('{{ $record->{$config['primaryKey']} }}')"><i class="fa-solid fa-skull"></i></button>
                            @else
                                @if(empty($config['readonly']))
                                <button class="btn-edit" title="تعديل" onclick="openEditModal('{{ $record->{$config['primaryKey']} }}')"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn-del" title="حذف" onclick="deleteRecord('{{ $record->{$config['primaryKey']} }}')"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn-copy" title="نسخ" onclick="duplicateRecord('{{ $record->{$config['primaryKey']} }}')"><i class="fa-solid fa-copy"></i></button>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($config['columns']) + 2 }}" style="text-align:center;padding:60px;color:var(--text-muted)">
                    <i class="fa-solid fa-inbox" style="font-size:36px;display:block;margin-bottom:12px"></i> لا توجد سجلات
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination">
        {{ $records->links() }}
    </div>
</div>

{{-- Create/Edit Modal --}}
<div class="modal-overlay" id="formModal">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modalTitle">إضافة جديد</h3>
            <button class="modal-close" onclick="closeModal('formModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="resourceForm">
                <input type="hidden" id="editRecordId" value="">
                @foreach($config['formFields'] as $ffKey => $ffConfig)
                <div class="form-group">
                    <label>{{ $ffConfig['label_ar'] }} @if(!empty($ffConfig['required']))<span class="text-danger">*</span>@endif</label>
                    @if($ffConfig['type'] === 'textarea')
                        <textarea name="{{ $ffKey }}" class="form-control" {{ !empty($ffConfig['required']) && $ffConfig['required'] !== 'create' ? 'required' : '' }}></textarea>
                    @elseif($ffConfig['type'] === 'select')
                        <select name="{{ $ffKey }}" class="form-control" {{ !empty($ffConfig['required']) ? 'required' : '' }}>
                            <option value="">اختر...</option>
                            @foreach($ffConfig['options'] as $optVal => $optLabel)
                            <option value="{{ is_string($optVal) ? $optVal : $optLabel }}">{{ $optLabel }}</option>
                            @endforeach
                        </select>
                    @elseif($ffConfig['type'] === 'relation_select')
                        <select name="{{ $ffKey }}" class="form-control relation-select" data-field="{{ $ffKey }}" {{ !empty($ffConfig['required']) ? 'required' : '' }}>
                            <option value="">جاري التحميل...</option>
                        </select>
                    @elseif($ffConfig['type'] === 'boolean')
                        <select name="{{ $ffKey }}" class="form-control">
                            <option value="0">لا</option>
                            <option value="1">نعم</option>
                        </select>
                    @else
                        <input type="{{ $ffConfig['type'] === 'datetime' ? 'datetime-local' : $ffConfig['type'] }}" name="{{ $ffKey }}" class="form-control" 
                            {{ !empty($ffConfig['required']) && $ffConfig['required'] !== 'create' ? 'required' : '' }}>
                    @endif
                </div>
                @endforeach
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('formModal')">إلغاء</button>
            <button class="btn btn-primary" id="saveBtn" onclick="saveRecord()"><i class="fa-solid fa-check"></i> حفظ</button>
        </div>
    </div>
</div>

{{-- Import Modal --}}
<div class="modal-overlay" id="importModal">
    <div class="modal">
        <div class="modal-header">
            <h3>استيراد من CSV</h3>
            <button class="modal-close" onclick="closeModal('importModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="import-area" id="importArea" onclick="document.getElementById('importFile').click()"
                 ondragover="event.preventDefault(); this.classList.add('dragover')"
                 ondragleave="this.classList.remove('dragover')"
                 ondrop="event.preventDefault(); this.classList.remove('dragover'); handleImportDrop(event)">
                <i class="fa-solid fa-cloud-arrow-up" style="font-size:36px;color:var(--accent);margin-bottom:12px;display:block"></i>
                <p>اسحب ملف CSV هنا أو انقر للاختيار</p>
                <p class="text-muted" style="font-size:12px;margin-top:8px">الحد الأقصى: 5 ميجابايت</p>
            </div>
            <input type="file" id="importFile" accept=".csv,.txt" style="display:none" onchange="handleImportFile(this)">
            <div id="importStatus" style="margin-top:12px;display:none"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const RESOURCE = '{{ $resource }}';
    const BASE_URL = '/admin-panel/resource/' + RESOURCE;
    const PK = '{{ $config['primaryKey'] }}';
    const STORAGE_KEY = 'adminPanel_' + RESOURCE + '_layout';

    document.addEventListener('DOMContentLoaded', () => {
        restoreLayout();
    });

    // ─── Search ──────────────────────────────────────
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const url = new URL(window.location);
            if (this.value) url.searchParams.set('search', this.value);
            else url.searchParams.delete('search');
            url.searchParams.delete('page');
            window.location = url;
        }, 500);
    });

    // ─── Filters ─────────────────────────────────────
    function toggleFilters() { document.getElementById('filtersPanel').classList.toggle('open'); }

    function applyFilters() {
        const form = document.getElementById('filtersForm');
        const url = new URL(window.location);
        // Clear old filters
        for (const key of [...url.searchParams.keys()]) { if (key.startsWith('filters')) url.searchParams.delete(key); }
        url.searchParams.delete('page');
        // Add new filters
        const formData = new FormData(form);
        for (const [key, val] of formData) { if (val) url.searchParams.set(key, val); }
        window.location = url;
    }

    // ─── Sorting ─────────────────────────────────────
    function sortBy(col, dir) {
        const url = new URL(window.location);
        url.searchParams.set('sort', col);
        url.searchParams.set('dir', dir);
        url.searchParams.delete('page');
        window.location = url;
    }

    // ─── Per Page ────────────────────────────────────
    function changePerPage(val) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', val);
        url.searchParams.delete('page');
        window.location = url;
    }

    // ─── Trashed Toggle ──────────────────────────────
    document.getElementById('trashedToggle').addEventListener('change', function() {
        const url = new URL(window.location);
        if (this.checked) url.searchParams.set('trashed', 'all');
        else url.searchParams.delete('trashed');
        url.searchParams.delete('page');
        window.location = url;
    });

    // ─── Layout: Cols & Resizing ─────────────────────
    function toggleColsPanel() { document.getElementById('colsPanel').classList.toggle('open'); }

    function toggleColumn(colKey, isVisible, save = true) {
        const th = document.querySelector(`#resourceTable th[data-col="${colKey}"]`);
        const tds = document.querySelectorAll(`#resourceTable td[data-col="${colKey}"]`);
        
        if (th) th.style.display = isVisible ? '' : 'none';
        tds.forEach(td => td.style.display = isVisible ? '' : 'none');
        
        if (save) saveLayout();
    }

    function saveLayout() {
        const hiddenCols = [...document.querySelectorAll('.col-toggle:not(:checked)')].map(c => c.value);
        const colWidths = {};
        document.querySelectorAll('#resourceTable th[data-col]').forEach(th => {
            if (th.style.width) colWidths[th.dataset.col] = th.style.width;
        });
        localStorage.setItem(STORAGE_KEY, JSON.stringify({ hiddenCols, colWidths }));
    }

    function restoreLayout() {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (!saved) return;
        try {
            const { hiddenCols = [], colWidths = {} } = JSON.parse(saved);
            
            hiddenCols.forEach(col => {
                const cb = document.querySelector(`.col-toggle[value="${col}"]`);
                if (cb) {
                    cb.checked = false;
                    toggleColumn(col, false, false);
                }
            });

            Object.entries(colWidths).forEach(([col, width]) => {
                const th = document.querySelector(`#resourceTable th[data-col="${col}"]`);
                if (th) th.style.width = width;
            });
        } catch(e) {}
    }

    // Close cols panel when clicking outside
    document.addEventListener('click', e => {
        const panel = document.getElementById('colsPanel');
        const btn = document.querySelector('button[onclick="toggleColsPanel()"]');
        if (panel && panel.classList.contains('open') && !panel.contains(e.target) && !btn.contains(e.target)) {
            panel.classList.remove('open');
        }
    });

    // ─── Bulk Selection ──────────────────────────────
    function toggleAll(cb) {
        document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
        updateBulk();
    }
    function updateBulk() {
        const checked = document.querySelectorAll('.row-check:checked');
        const bar = document.getElementById('bulkBar');
        document.getElementById('bulkCount').textContent = checked.length;
        bar.classList.toggle('visible', checked.length > 0);
    }
    async function bulkAction(action) {
        const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
        if (!ids.length) return;
        if (!confirm(`هل تريد تنفيذ "${action}" على ${ids.length} سجل؟`)) return;
        await apiFetch(BASE_URL + '/bulk', { method: 'POST', body: JSON.stringify({ action, ids }) });
        location.reload();
    }

    // ─── CRUD ────────────────────────────────────────
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }

    function openCreateModal() {
        document.getElementById('editRecordId').value = '';
        document.getElementById('modalTitle').textContent = 'إضافة جديد';
        document.getElementById('resourceForm').reset();
        loadRelationOptions();
        openModal('formModal');
    }

    async function openEditModal(id) {
        const res = await fetch(BASE_URL + '/' + id, { headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        const record = data.record;

        document.getElementById('editRecordId').value = id;
        document.getElementById('modalTitle').textContent = 'تعديل #' + id;

        await loadRelationOptions();

        // Populate form fields
        const form = document.getElementById('resourceForm');
        for (const [key, val] of Object.entries(record)) {
            const el = form.querySelector(`[name="${key}"]`);
            if (el) {
                if (el.type === 'datetime-local' && val) {
                    el.value = val.replace(' ', 'T').substring(0, 16);
                } else if (key !== 'password') {
                    el.value = val ?? '';
                }
            }
        }
        openModal('formModal');
    }

    async function saveRecord() {
        const form = document.getElementById('resourceForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        const editId = document.getElementById('editRecordId').value;

        // Remove empty password on update
        if (editId && !data.password) delete data.password;

        const url = editId ? BASE_URL + '/' + editId : BASE_URL;
        const method = editId ? 'PUT' : 'POST';

        const result = await apiFetch(url, { method, body: JSON.stringify(data) });
        if (result.success) { closeModal('formModal'); location.reload(); }
    }

    async function deleteRecord(id) {
        if (!confirm('هل تريد حذف هذا السجل؟')) return;
        await apiFetch(BASE_URL + '/' + id, { method: 'DELETE' });
        location.reload();
    }

    async function restoreRecord(id) {
        await apiFetch(BASE_URL + '/' + id + '/restore', { method: 'POST' });
        location.reload();
    }

    async function forceDeleteRecord(id) {
        if (!confirm('هل تريد الحذف النهائي؟ لا يمكن التراجع!')) return;
        await apiFetch(BASE_URL + '/' + id + '/force', { method: 'DELETE' });
        location.reload();
    }

    async function duplicateRecord(id) {
        const withRelations = confirm('هل تريد نسخ العلاقات أيضاً؟');
        await apiFetch(BASE_URL + '/' + id + '/duplicate', {
            method: 'POST', body: JSON.stringify({ with_relations: withRelations })
        });
        location.reload();
    }

    // ─── Inline Editing ──────────────────────────────
    function inlineEdit(cell, id, field, type, options = null) {
        if (cell.querySelector('input, select')) return; // already editing
        const currentVal = cell.textContent.trim();
        let input;

        if (type === 'select' || type === 'boolean') {
            input = document.createElement('select');
            if (type === 'boolean') {
                input.innerHTML = '<option value="0">لا</option><option value="1">نعم</option>';
                input.value = cell.querySelector('.fa-check') ? '1' : '0';
            } else {
                options.forEach(opt => {
                    const o = document.createElement('option');
                    o.value = opt; o.textContent = opt;
                    input.appendChild(o);
                });
                input.value = currentVal === '—' ? '' : currentVal;
            }
        } else {
            input = document.createElement('input');
            input.type = type === 'number' ? 'number' : 'text';
            input.value = currentVal === '—' ? '' : currentVal;
        }

        cell.innerHTML = '';
        cell.appendChild(input);
        input.focus();

        const save = async () => {
            const newVal = input.value;
            cell.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            const result = await apiFetch(BASE_URL + '/' + id + '/inline', {
                method: 'PATCH', body: JSON.stringify({ field, value: newVal })
            });
            if (result.success) {
                if (type === 'boolean') {
                    cell.innerHTML = newVal === '1' ? '<i class="fa-solid fa-check text-success"></i>' : '<i class="fa-solid fa-xmark text-danger"></i>';
                } else {
                    cell.textContent = result.value || newVal;
                }
            } else {
                cell.textContent = currentVal;
            }
        };

        input.addEventListener('blur', save);
        input.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); input.blur(); } if (e.key === 'Escape') { cell.textContent = currentVal; } });
    }

    // ─── Relation Options ────────────────────────────
    async function loadRelationOptions() {
        const selects = document.querySelectorAll('.relation-select');
        for (const sel of selects) {
            const field = sel.dataset.field;
            const currentVal = sel.value;
            try {
                const res = await fetch(BASE_URL + '/relation-options/' + field, { headers: { 'Accept': 'application/json' } });
                const options = await res.json();
                sel.innerHTML = '<option value="">اختر...</option>';
                options.forEach(opt => {
                    const o = document.createElement('option');
                    o.value = opt.id; o.textContent = opt.label;
                    if (String(opt.id) === String(currentVal)) o.selected = true;
                    sel.appendChild(o);
                });
            } catch (e) { sel.innerHTML = '<option value="">خطأ في التحميل</option>'; }
        }
    }

    // ─── Import ──────────────────────────────────────
    function openImportModal() { openModal('importModal'); }

    function handleImportDrop(e) {
        const file = e.dataTransfer.files[0];
        if (file) uploadImport(file);
    }

    function handleImportFile(input) {
        if (input.files[0]) uploadImport(input.files[0]);
    }

    async function uploadImport(file) {
        const status = document.getElementById('importStatus');
        status.style.display = 'block';
        status.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> جاري الاستيراد...';

        const formData = new FormData();
        formData.append('file', file);

        try {
            const res = await fetch(BASE_URL + '/import', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: formData,
            });
            const data = await res.json();
            if (data.success) {
                status.innerHTML = `<span class="text-success">${data.message}</span>`;
                if (data.errors?.length) {
                    status.innerHTML += '<br><small class="text-danger">' + data.errors.join('<br>') + '</small>';
                }
                setTimeout(() => location.reload(), 2000);
            } else {
                status.innerHTML = `<span class="text-danger">${data.message}</span>`;
            }
        } catch (e) {
            status.innerHTML = '<span class="text-danger">خطأ في الاتصال</span>';
        }
    }

    // ─── Column Resize ───────────────────────────────
    let resizing = null;
    function startResize(e, handle) {
        e.preventDefault();
        const th = handle.parentElement;
        resizing = { th, startX: e.pageX, startWidth: th.offsetWidth };
        document.addEventListener('mousemove', doResize);
        document.addEventListener('mouseup', stopResize);
    }
    function doResize(e) {
        if (!resizing) return;
        const diff = resizing.startX - e.pageX; // RTL: reversed
        resizing.th.style.width = (resizing.startWidth + diff) + 'px';
    }
    function stopResize() { 
        if (resizing) saveLayout(); 
        resizing = null; 
        document.removeEventListener('mousemove', doResize); 
        document.removeEventListener('mouseup', stopResize); 
    }
</script>
@endsection
