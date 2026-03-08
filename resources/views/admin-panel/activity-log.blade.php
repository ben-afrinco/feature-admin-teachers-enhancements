@extends('admin-panel.layout')

@section('content')
<div class="card">
    <div class="card-header" style="justify-content: space-between;">
        <h2>سجل النشاطات (Activity Log)</h2>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin-panel.activity-log.index') }}" method="GET" class="filter-form" style="display: flex; gap: var(--spacing-sm); margin-bottom: var(--spacing-md); align-items: flex-end; flex-wrap: wrap;">
            
            <div class="form-group" style="margin-bottom: 0;">
                <label>نوع الإجراء</label>
                <select name="action" class="form-control" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label>نوع الجدول (Model)</label>
                <select name="model_type" class="form-control" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    @foreach($modelTypes as $modelType)
                        <option value="{{ $modelType }}" {{ request('model_type') == $modelType ? 'selected' : '' }}>
                            {{ class_basename($modelType) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 0; flex-grow: 1;">
                <label>بحث عام</label>
                <div style="position: relative;">
                    <i class="fa-solid fa-search" style="position: absolute; right: 12px; top: 12px; color: var(--text-muted);"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="ابحث باسم المستخدم، النوع، الوصف..." style="padding-right: 35px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <button type="submit" class="btn btn-primary" style="height: 42px;">بحث</button>
                <a href="{{ route('admin-panel.activity-log.index') }}" class="btn btn-secondary" style="height: 42px; display: inline-flex; align-items: center;">إعادة ضبط</a>
            </div>
        </form>

        <div class="table-container">
            <table class="table" style="min-width: 900px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المستخدم</th>
                        <th>الإجراء</th>
                        <th>الجدول</th>
                        <th>السجل المعني</th>
                        <th>التاريخ</th>
                        <th>التفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>
                                @if($log->user)
                                    <div style="font-weight: bold;">{{ $log->user->full_name }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">{{ $log->user->role }}</div>
                                @else
                                    <span style="color: var(--text-muted);">نظام / غير معروف</span>
                                @endif
                                <div style="font-size: 11px; color: var(--text-muted);">IP: {{ $log->ip_address }}</div>
                            </td>
                            <td>
                                @php
                                    $actionClass = match($log->action) {
                                        'create' => 'success',
                                        'update', 'inlineUpdate' => 'warning',
                                        'delete', 'forceDelete' => 'danger',
                                        'restore' => 'info',
                                        default => 'secondary'
                                    };
                                    $actionLabel = match($log->action) {
                                        'create' => 'إنشاء',
                                        'update' => 'تعديل',
                                        'inlineUpdate' => 'تعديل سريع',
                                        'delete' => 'حذف (ناعم)',
                                        'forceDelete' => 'حذف نهائي',
                                        'restore' => 'استعادة',
                                        'bulkDelete' => 'حذف جماعي',
                                        'bulkRestore' => 'استعادة جماعية',
                                        'bulkForceDelete' => 'حذف جماعي نهائي',
                                        default => $log->action
                                    };
                                @endphp
                                <span class="badge badge-{{ $actionClass }}">{{ $actionLabel }}</span>
                            </td>
                            <td>
                                <code>{{ class_basename($log->model_type) }}</code>
                            </td>
                            <td>
                                <div>{{ $log->model_label ?: 'ID: ' . $log->model_id }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">ID: {{ $log->model_id }}</div>
                            </td>
                            <td>
                                <div dir="ltr" style="text-align: right; display: inline-block;">{{ $log->created_at->format('Y-m-d H:i:s') }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $log->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm view-log-btn" data-id="{{ $log->id }}">
                                    <i class="fa-solid fa-eye"></i> التغييرات
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: var(--spacing-lg) 0;">
                                <i class="fa-solid fa-clock-rotate-left fa-3x" style="color: var(--border-color); margin-bottom: 10px;"></i>
                                <p>لا يوجد سجل أنشطة مطابق لبحثك.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: var(--spacing-md); display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 13px; color: var(--text-muted);">
                عرض {{ $logs->firstItem() ?? 0 }} إلى {{ $logs->lastItem() ?? 0 }} من {{ $logs->total() }} سجل
            </div>
            <div class="pagination-wrapper">
                {{ $logs->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="logModal">
    <div class="modal" style="max-width: 800px; width: 90%;">
        <div class="modal-header">
            <h3>تفاصيل التغييرات</h3>
            <button class="close-modal" onclick="closeModal()"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body" id="logModalBody">
            <div style="text-align: center; padding: 2rem;">
                <i class="fa-solid fa-circle-notch fa-spin fa-2x"></i>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add basic diff styling */
    .diff-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: var(--spacing-md);
        font-family: monospace;
        font-size: 13px;
    }
    .diff-table th, .diff-table td {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        text-align: left;
    }
    html[dir="rtl"] .diff-table th, 
    html[dir="rtl"] .diff-table td {
        text-align: right;
    }
    .diff-table th {
        background: var(--bg-hover);
        width: 20%;
    }
    .diff-table td {
        width: 40%;
        word-break: break-all;
    }
    .diff-old { background-color: rgba(239, 68, 68, 0.1); }
    .diff-old-text { color: var(--danger-color); text-decoration: line-through; }
    .diff-new { background-color: rgba(34, 197, 94, 0.1); }
    .diff-new-text { color: var(--success-color); font-weight: bold; }
    
    .log-meta {
        background: var(--bg-hover);
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        margin-bottom: var(--spacing-md);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--spacing-md);
    }
    .log-meta-item {
        display: flex;
        flex-direction: column;
    }
    .log-meta-label {
        font-size: 11px;
        color: var(--text-muted);
        margin-bottom: 4px;
        text-transform: uppercase;
    }
    .log-meta-val {
        font-weight: 500;
        font-size: 13px;
    }

    /* Force pagination to use generic styling somewhat compatible with theme */
    .pagination-wrapper nav {
        display: flex;
    }
    .pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 4px;
    }
    .pagination-wrapper .page-item a,
    .pagination-wrapper .page-item span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-color);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
    }
    .pagination-wrapper .page-item.active span,
    .pagination-wrapper .page-item.active a {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    .pagination-wrapper .page-item.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .pagination-wrapper .page-item a:hover {
        background: var(--bg-hover);
        border-color: var(--border-color);
    }
    .pagination-wrapper .page-item.active a:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('logModal');
        const modalBody = document.getElementById('logModalBody');
        
        window.closeModal = () => {
            modal.classList.remove('active');
        };

        const viewButtons = document.querySelectorAll('.view-log-btn');
        viewButtons.forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.getAttribute('data-id');
                modal.classList.add('active');
                modalBody.innerHTML = '<div style="text-align: center; padding: 2rem;"><i class="fa-solid fa-circle-notch fa-spin fa-2x"></i></div>';
                
                try {
                    const res = await fetch(`{{ url('/admin-panel/activity-log') }}/${id}`);
                    if (!res.ok) throw new Error('Fetch failed');
                    
                    const data = await res.json();
                    renderLogDetails(data.log, data.diff);
                } catch (e) {
                    modalBody.innerHTML = `<div class="alert alert-danger">حدث خطأ أثناء تحميل التفاصيل: ${e.message}</div>`;
                }
            });
        });

        function renderLogDetails(log, diff) {
            let userDisplay = log.user ? log.user.full_name : 'نظام النظام';
            let dateDisplay = new Date(log.created_at).toLocaleString('ar-EG');
            
            let html = `
                <div class="log-meta">
                    <div class="log-meta-item">
                        <span class="log-meta-label">المستخدم</span>
                        <span class="log-meta-val">${userDisplay}</span>
                    </div>
                    <div class="log-meta-item">
                        <span class="log-meta-label">نوع الإجراء</span>
                        <span class="log-meta-val badge badge-secondary">${log.action}</span>
                    </div>
                    <div class="log-meta-item">
                        <span class="log-meta-label">الجدول / السجل</span>
                        <span class="log-meta-val"><code>${log.model_type.split('\\\\').pop()}</code> #${log.model_id}</span>
                    </div>
                    <div class="log-meta-item">
                        <span class="log-meta-label">التاريخ والوقت</span>
                        <span class="log-meta-val" dir="ltr">${dateDisplay}</span>
                    </div>
                    <div class="log-meta-item">
                        <span class="log-meta-label">عنوان الـ IP</span>
                        <span class="log-meta-val" dir="ltr">${log.ip_address || '-'}</span>
                    </div>
                    <div class="log-meta-item">
                        <span class="log-meta-label">المتصفح User Agent</span>
                        <span class="log-meta-val" style="font-size: 11px; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${log.user_agent}">${log.user_agent || '-'}</span>
                    </div>
                </div>
            `;

            if (Object.keys(diff).length > 0) {
                html += `
                    <h4>التغييرات (Diff)</h4>
                    <div style="overflow-x: auto;">
                        <table class="diff-table">
                            <thead>
                                <tr>
                                    <th>الحقل</th>
                                    <th>القيمة القديمة</th>
                                    <th>القيمة الجديدة</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                for (const [key, change] of Object.entries(diff)) {
                    html += `
                        <tr>
                            <td><strong>${key}</strong></td>
                            <td class="diff-old"><span class="diff-old-text">${formatVal(change.old)}</span></td>
                            <td class="diff-new"><span class="diff-new-text">${formatVal(change.new)}</span></td>
                        </tr>
                    `;
                }
                
                html += `</tbody></table></div>`;
            } else if (log.new_values && Object.keys(log.new_values).length > 0 && !log.old_values) {
                // Just created, show new values
                html += `
                    <h4>القيم (New Values)</h4>
                    <div style="overflow-x: auto;">
                        <table class="diff-table">
                            <thead><tr><th>الحقل</th><th>القيمة</th></tr></thead>
                            <tbody>
                `;
                for (const [key, val] of Object.entries(log.new_values)) {
                    html += `<tr><td><strong>${key}</strong></td><td>${formatVal(val)}</td></tr>`;
                }
                html += `</tbody></table></div>`;
            } else {
                html += `<div class="alert alert-info">لا توجد تفاصيل دقيقة أو تغييرات لعرضها لهذا النشاط.</div>`;
            }

            modalBody.innerHTML = html;
        }

        function formatVal(val) {
            if (val === null) return '<em>[null]</em>';
            if (val === '') return '<em>[فارغ]</em>';
            if (typeof val === 'boolean') return val ? 'نعم (true)' : 'لا (false)';
            if (typeof val === 'object') return `<pre style="margin:0; font-size:11px;">${JSON.stringify(val, null, 2)}</pre>`;
            return escapeHtml(String(val));
        }

        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
        }
    });

    // Close modal on click outside
    document.getElementById('logModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('logModal')) closeModal();
    });
</script>
@endsection
