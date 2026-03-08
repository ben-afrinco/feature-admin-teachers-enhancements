@php
// Use LingoPulse styling from admin dashboard
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>LingoPulse - المطور (المعلمين)</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <style>
        body { font-family: "Tajawal", sans-serif; background: #f8fafc; color: #0f172a; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #0b2a82, #0b1220 70%); color: white; padding: 20px;}
        .sidebar a { color: white; text-decoration: none; padding: 10px; display: block; margin-bottom: 5px; border-radius: 8px;}
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); font-weight: bold; }
        .content { padding: 30px; }
        .card { border-radius: 12px; border: none; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        .btn-brand { background: linear-gradient(135deg, #2563eb, #7c3aed); color: white; border: none; }
        .btn-brand:hover { background: linear-gradient(135deg, #1d4ed8, #6d28d9); color: white; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4 class="text-center mb-4">المطور</h4>
                <a href="{{ route('developer') }}"><i class="fa-solid fa-gauge-high ms-2"></i> الرئيسية</a>
                <a href="{{ route('admin.students') }}"><i class="fa-solid fa-user-graduate ms-2"></i> الطلاب</a>
                <a href="{{ route('admin.teachers') }}" class="active"><i class="fa-solid fa-chalkboard-user ms-2"></i> المعلمين</a>
            </div>

            <!-- Content -->
            <div class="col-md-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>إدارة المعلمين</h2>
                    <div>
                        <button class="btn btn-brand" onclick="showAddModal()">
                            <i class="fa-solid fa-plus ms-1"></i> إضافة معلم جديد
                        </button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->user_id }}</td>
                                    <td>{{ $teacher->full_name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="showEditModal({{ json_encode($teacher) }})">
                                            <i class="fa-solid fa-edit"></i> تعديل
                                        </button>
                                        <form action="{{ route('admin.deleteUser', $teacher->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $teachers->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.addUser') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="teacher">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة معلم</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>الاسم الكامل</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>كلمة المرور</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-brand">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل معلم</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>الاسم الكامل</label>
                            <input type="text" name="full_name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>كلمة المرور (تُترك فارغة إذا لم ترد التغيير)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-brand">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const addModal = new bootstrap.Modal(document.getElementById('addModal'));
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));

        function showAddModal() {
            addModal.show();
        }

        function showEditModal(user) {
            document.getElementById('edit_name').value = user.full_name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('editForm').action = "/admin/user/update/" + user.user_id;
            editModal.show();
        }
    </script>
</body>
</html>