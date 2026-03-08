@extends('admin-panel.layout')
@section('title', 'لوحة المعلومات')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-chart-pie"></i> لوحة المعلومات</h1>
        <div class="breadcrumb mt-8">لوحة الإدارة / الرئيسية</div>
    </div>
    <div class="flex gap-8">
        <span class="text-muted" style="font-size:13px">{{ session('name') }}</span>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    @foreach($stats as $slug => $stat)
    <a href="{{ route('admin-panel.resource.index', $slug) }}" class="stat-card">
        <div class="stat-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($stat['total']) }}</div>
            <div class="stat-label">{{ $stat['label_ar'] }}</div>
            <div class="stat-sub">
                <span>+{{ $stat['recent'] }}</span> خلال 7 أيام
                @if($stat['trashed'] > 0)
                    · <span class="text-danger">{{ $stat['trashed'] }} محذوف</span>
                @endif
            </div>
        </div>
    </a>
    @endforeach
</div>

<!-- Charts Row -->
<div class="grid-2 mb-16">
    <!-- Registrations Chart -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-chart-line"></i> التسجيلات (30 يوم)</h3>
        </div>
        <div class="card-body">
            <canvas id="registrationsChart" height="200"></canvas>
        </div>
    </div>

    <!-- Distribution Chart -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-chart-doughnut"></i> توزيع الأدوار</h3>
        </div>
        <div class="card-body">
            <canvas id="rolesChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h3><i class="fa-solid fa-clock-rotate-left"></i> آخر النشاطات</h3>
        <a href="{{ route('admin-panel.resource.index', 'activity-log') }}" class="btn btn-ghost btn-sm">عرض الكل</a>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الإجراء</th>
                    <th>النوع</th>
                    <th>الوصف</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentActivity as $log)
                <tr>
                    <td>{{ $log->user ? $log->user->full_name : 'نظام' }}</td>
                    <td><span class="badge badge-{{ $log->action }}">{{ $log->action }}</span></td>
                    <td>{{ $log->model_type }}</td>
                    <td>{{ Str::limit($log->model_label, 40) }}</td>
                    <td class="text-muted" title="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted)">لا توجد نشاطات مسجلة بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Registrations Chart
    const regCtx = document.getElementById('registrationsChart').getContext('2d');
    const regData = @json($chartData);

    new Chart(regCtx, {
        type: 'line',
        data: {
            labels: regData.map(d => d.date),
            datasets: [{
                label: 'تسجيلات جديدة',
                data: regData.map(d => d.count),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#6366f1',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                x: { grid: { color: 'rgba(51,65,85,0.3)' }, ticks: { color: '#64748b', font: { family: 'Tajawal' } } },
                y: { grid: { color: 'rgba(51,65,85,0.3)' }, ticks: { color: '#64748b', font: { family: 'Tajawal' }, stepSize: 1 }, beginAtZero: true },
            },
        },
    });

    // Roles Distribution Chart
    const rolesCtx = document.getElementById('rolesChart').getContext('2d');
    const statsData = @json($stats);
    const roleLabels = [];
    const roleValues = [];
    const roleColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6', '#f97316'];

    Object.entries(statsData).forEach(([slug, stat], i) => {
        roleLabels.push(stat.label_ar);
        roleValues.push(stat.total);
    });

    new Chart(rolesCtx, {
        type: 'doughnut',
        data: {
            labels: roleLabels,
            datasets: [{
                data: roleValues,
                backgroundColor: roleColors.slice(0, roleLabels.length),
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true,
                    labels: { color: '#94a3b8', font: { family: 'Tajawal', size: 12 }, padding: 12, usePointStyle: true, pointStyleWidth: 10 },
                },
            },
            cutout: '65%',
        },
    });
</script>
@endsection
