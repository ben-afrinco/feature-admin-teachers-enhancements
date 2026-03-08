<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة المعلم - نظام التقييم الذكي</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* تنسيقات عامة */
        :root {
            --dark-bg: #0f172a;
            --dark-surface: #1e293b;
            --dark-surface-light: #334155;
            --dark-border: #475569;
            --dark-text: #f1f5f9;
            --dark-text-secondary: #94a3b8;
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--dark-text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* صفحة المعلم الرئيسية */
        .teacher-main-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            text-align: center;
        }

        /* صورة أيقونة المعلم بدل الإيموجي */
        .teacher-icon{
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,.35));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .teacher-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: var(--dark-text);
        }

        .teacher-subtitle {
            font-size: 1.2rem;
            color: var(--dark-text-secondary);
            margin-bottom: 30px;
            max-width: 600px;
            line-height: 1.6;
        }

        .main-buttons {
            display: flex;
            flex-direction: column;
            gap: 25px;
            width: 100%;
            max-width: 400px;
        }

        .main-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 22px 30px;
            background-color: var(--dark-surface);
            border: 2px solid var(--dark-border);
            border-radius: var(--border-radius);
            color: var(--dark-text);
            font-size: 1.3rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .main-btn:hover {
            background-color: var(--dark-surface-light);
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .main-btn i {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        /* الصفحات الداخلية */
        .page {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-bg);
            padding: 20px;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.4s ease;
            z-index: 100;
        }

        .page.active {
            transform: translateX(0);
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--dark-border);
        }

        .page-title {
            font-size: 1.8rem;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
            color: var(--primary-color);
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: var(--dark-surface);
            color: var(--dark-text);
            border: 1px solid var(--dark-border);
            border-radius: var(--border-radius);
            padding: 12px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .back-btn:hover {
            background-color: var(--dark-surface-light);
            border-color: var(--primary-color);
        }

        .back-btn i {
            transform: rotate(180deg);
        }

        /* صفحة الفصول */
        .classes-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .class-card {
            background-color: var(--dark-surface);
            border-radius: var(--border-radius);
            padding: 25px;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid var(--dark-border);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .class-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .class-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .class-name {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .class-code {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .class-info {
            display: flex;
            gap: 20px;
            color: var(--dark-text-secondary);
            font-size: 0.95rem;
        }

        .class-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .class-info-item i {
            color: var(--primary-color);
        }

        .class-description {
            color: var(--dark-text-secondary);
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* صفحة طلاب الفصل */
        .students-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .student-card {
            background-color: var(--dark-surface);
            border-radius: var(--border-radius);
            padding: 25px;
            border: 1px solid var(--dark-border);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
        }

        .student-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            font-weight: 600;
        }

        .student-info {
            flex: 1;
        }

        .student-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .student-email {
            color: var(--dark-text-secondary);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .student-level {
            display: inline-block;
            padding: 5px 15px;
            background-color: var(--dark-bg);
            color: var(--primary-color);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* صفحة التكاليف */
        .assignment-form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: right;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark-text);
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 16px;
            background-color: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: var(--border-radius);
            color: var(--dark-text);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* صفحة إدخال الدرجات */
        .grades-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 15px;
            background-color: var(--dark-surface);
            border-radius: var(--border-radius);
            border: 1px solid var(--dark-border);
        }

        .grades-summary {
            display: flex;
            gap: 30px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .summary-label {
            font-size: 0.9rem;
            color: var(--dark-text-secondary);
            margin-top: 5px;
        }

        .grades-actions {
            display: flex;
            gap: 15px;
        }

        .grades-table {
            width: 100%;
            background-color: var(--dark-surface);
            border-radius: var(--border-radius);
            border-collapse: collapse;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .grades-table th {
            background-color: var(--dark-surface-light);
            padding: 18px 15px;
            text-align: right;
            color: var(--dark-text);
            font-weight: 600;
            border-bottom: 1px solid var(--dark-border);
        }

        .grades-table td {
            padding: 18px 15px;
            text-align: right;
            border-bottom: 1px solid var(--dark-border);
        }

        .grades-table tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .grades-table .student-info-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .grades-table .student-info-cell .student-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .grade-input {
            width: 100%;
            padding: 10px 12px;
            background-color: var(--dark-bg);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            color: var(--dark-text);
            font-size: 1rem;
            text-align: center;
            transition: var(--transition);
        }

        .grade-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .grade-input.error {
            border-color: var(--danger-color);
        }

        .grade-input.success {
            border-color: var(--success-color);
        }

        .total-grade {
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            background-color: rgba(59, 130, 246, 0.1);
            padding: 8px;
            border-radius: 8px;
        }

        .note-btn {
            background-color: var(--warning-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .note-btn:hover {
            background-color: #e58e0a;
            transform: translateY(-2px);
        }

        .note-btn.has-note {
            background-color: var(--success-color);
        }

        .note-btn.has-note:hover {
            background-color: #0da271;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: var(--dark-text-secondary);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        /* نافذة الملاحظات المنبثقة */
        .modal-overlay {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: var(--dark-surface);
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 25px;
            border-bottom: 1px solid var(--dark-border);
        }

        .modal-title {
            font-size: 1.5rem;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .modal-title i {
            color: var(--warning-color);
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--dark-text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close:hover {
            color: var(--danger-color);
        }

        .modal-body {
            padding: 25px;
        }

        .student-modal-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding: 20px;
            background-color: rgba(59, 130, 246, 0.1);
            border-radius: var(--border-radius);
        }

        .student-modal-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            font-weight: 600;
        }

        .student-modal-details h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .student-modal-details p {
            color: var(--dark-text-secondary);
        }

        .grades-summary-modal {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .grade-box {
            background-color: var(--dark-bg);
            border-radius: var(--border-radius);
            padding: 15px;
            text-align: center;
        }

        .grade-label {
            font-size: 0.9rem;
            color: var(--dark-text-secondary);
            margin-bottom: 8px;
        }

        .grade-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .grade-midterm .grade-value { color: #3b82f6; }
        .grade-final .grade-value { color: #10b981; }
        .grade-oral .grade-value { color: #f59e0b; }
        .grade-total .grade-value { color: #8b5cf6; }

        .note-textarea {
            width: 100%;
            min-height: 200px;
            padding: 20px;
            background-color: var(--dark-bg);
            border: 1px solid var(--dark-border);
            border-radius: var(--border-radius);
            color: var(--dark-text);
            font-size: 1rem;
            line-height: 1.6;
            resize: vertical;
            transition: var(--transition);
        }

        .note-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .note-textarea::placeholder {
            color: var(--dark-text-secondary);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding: 25px;
            border-top: 1px solid var(--dark-border);
        }

        /* تعديل خاص للقائمة المنسدلة */
        .form-control.select-placeholder { color: var(--dark-text-secondary); }
        .form-control.select-placeholder option:first-child { color: var(--dark-text-secondary); display: none; }
        .form-control.select-placeholder option { color: var(--dark-text); }

        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }

        .form-row { display: flex; gap: 20px; }
        .form-row .form-group { flex: 1; }

        .file-upload { margin-top: 10px; }
        .file-input { display: none; }

        .file-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background-color: var(--dark-surface);
            border: 2px dashed var(--dark-border);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .file-label:hover {
            border-color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.05);
        }

        .file-label i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-label span { color: var(--dark-text-secondary); font-size: 1rem; }

        .file-info {
            margin-top: 15px;
            padding: 15px;
            background-color: var(--dark-surface);
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            color: var(--dark-text-secondary);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .remove-file {
            background: none;
            border: none;
            color: var(--danger-color);
            cursor: pointer;
            font-size: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            padding: 16px 35px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            flex: 2;
        }

        .btn-primary:hover { background-color: var(--primary-dark); }

        .btn-secondary {
            background-color: var(--dark-surface);
            color: var(--dark-text);
            border: 1px solid var(--dark-border);
            flex: 1;
        }

        .btn-secondary:hover { background-color: var(--dark-surface-light); }

        .btn-success { background-color: var(--success-color); color: white; }
        .btn-success:hover { background-color: #0da271; }

        .btn-warning { background-color: var(--warning-color); color: white; }
        .btn-warning:hover { background-color: #e58e0a; }

        /* أزرار الراديو لتحديد نوع التكليف */
        .radio-buttons-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .radio-button {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px;
            background-color: var(--dark-surface);
            border: 2px solid var(--dark-border);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .radio-button:hover { border-color: var(--primary-color); }

        .radio-button.selected {
            border-color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.1);
        }

        .radio-input { display: none; }

        .radio-custom {
            width: 22px;
            height: 22px;
            border: 2px solid var(--dark-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .radio-custom::after {
            content: '';
            width: 12px;
            height: 12px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: none;
        }

        .radio-input:checked + .radio-custom { border-color: var(--primary-color); }
        .radio-input:checked + .radio-custom::after { display: block; }

        .radio-label { display: flex; align-items: center; gap: 12px; }

        .radio-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--dark-surface-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .radio-text { font-weight: 600; font-size: 1rem; color: var(--dark-text); }
        .radio-button.selected .radio-text { color: var(--primary-color); }

        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .teacher-title { font-size: 2rem; }
            .teacher-subtitle { font-size: 1rem; margin-bottom: 25px; }
            .main-btn { padding: 18px 25px; font-size: 1.1rem; }
            .classes-container, .students-container { grid-template-columns: 1fr; }
            .grades-header { flex-direction: column; gap: 20px; }
            .grades-summary { width: 100%; justify-content: space-around; }
            .grades-actions { width: 100%; }
            .form-row { flex-direction: column; gap: 0; }
            .form-actions { flex-direction: column; }
            .btn { width: 100%; }
            .radio-buttons-container { grid-template-columns: repeat(2, 1fr); }
            .grades-table { display: block; overflow-x: auto; }
            .grades-summary-modal { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .page { padding: 15px; }
            .teacher-title { font-size: 1.8rem; }
            .page-title { font-size: 1.5rem; }
            .radio-buttons-container { grid-template-columns: 1fr; }
            .class-card, .student-card { padding: 20px; }
            .grades-table th, .grades-table td { padding: 12px 8px; font-size: 0.9rem; }
            .grade-input { width: 70px; padding: 8px 6px; }
            .grades-summary-modal { grid-template-columns: 1fr; }
            .modal-header, .modal-body, .modal-footer { padding: 15px; }
        }
    </style>
</head>
<body>

    <!-- صفحة تسجيل الدخول (مخفية — المصادقة تتم عبر Laravel middleware) -->
    <div id="login-page" class="teacher-main-page" style="display:none;"></div>

    <!-- الصفحة الرئيسية للمعلم -->
    <div id="main-page" class="teacher-main-page">
        <img class="teacher-icon"
             src="https://www.pngkey.com/png/detail/18-182885_vector-transparent-library-svg-definition-teacher-teacher-icon.png"
             alt="Teacher Icon">

        <h1 class="teacher-title">المعلم</h1>
        <p id="teacher-welcome" class="teacher-subtitle" style="margin-bottom: 10px;"></p>
        <p class="teacher-subtitle">مرحباً بك في نظام التقييم الذكي. يمكنك إدارة فصولك وإرسال التكاليف وإدخال درجات الطلاب من خلال هذه الواجهة.</p>

        <div class="main-buttons">
            <button class="main-btn" id="classes-btn">
                <i class="fas fa-chalkboard"></i>
                <span>الفصول التي أديرها</span>
            </button>

            <button class="main-btn" id="assignments-btn">
                <i class="fas fa-tasks"></i>
                <span>إرسال التكاليف</span>
            </button>

            <button class="main-btn" id="grades-btn">
                <i class="fas fa-star-half-alt"></i>
                <span>تقييم الطلاب وإدخال الدرجات</span>
            </button>

            <!-- زر الاختبارات -->
            <button class="main-btn" id="quizzes-btn">
                <i class="fas fa-question-circle"></i>
                <span>الاختبارات</span>
            </button>

            <!-- زر الجلسات المباشرة -->
            <button class="main-btn" id="sessions-btn">
                <i class="fas fa-video"></i>
                <span>الجلسات المباشرة (Jitsi Meet)</span>
            </button>

            <!-- زر تسجيل خروج (اختياري) -->
            <button class="main-btn" id="logout-btn" style="border-color: var(--danger-color);">
                <i class="fas fa-sign-out-alt" style="color: var(--danger-color);"></i>
                <span>تسجيل خروج</span>
            </button>
        </div>
    </div>

    <!-- صفحة الفصول -->
    <div id="classes-page" class="page">
        <div class="page-header">
            <button class="back-btn" id="back-from-classes">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-chalkboard"></i>
                الفصول التي أديرها
            </h1>
        </div>

        <div class="classes-container" id="classes-list"></div>
    </div>

    <!-- صفحة طلاب الفصل -->
    <div id="class-students-page" class="page">
        <div class="page-header">
            <button class="back-btn" id="back-from-students">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع للفصول</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                <span id="class-title">طلاب الفصل</span>
            </h1>
        </div>

        <div class="students-container" id="students-list"></div>
    </div>

    <!-- صفحة التكاليف -->
    <div id="assignments-page" class="page">
        <div class="page-header">
            <button class="back-btn" id="back-from-assignments">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-tasks"></i>
                إرسال تكليف جديد
            </h1>
        </div>

        <div class="assignment-form-container">
            <form id="assignment-form">
                <div class="form-group">
                    <label for="assignment-title">عنوان التكليف *</label>
                    <input type="text" id="assignment-title" class="form-control" placeholder="أدخل عنوان التكليف" required>
                </div>

                <div class="form-group">
                    <label>نوع التكليف *</label>
                    <div class="radio-buttons-container" id="assignment-type-container">
                        <label class="radio-button" id="homework-radio">
                            <input type="radio" name="assignment-type" value="homework" class="radio-input" required>
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <div class="radio-icon"><i class="fas fa-book"></i></div>
                                <div class="radio-text">واجب منزلي</div>
                            </div>
                        </label>

                        <label class="radio-button" id="project-radio">
                            <input type="radio" name="assignment-type" value="project" class="radio-input">
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <div class="radio-icon"><i class="fas fa-project-diagram"></i></div>
                                <div class="radio-text">مشروع</div>
                            </div>
                        </label>

                        <label class="radio-button" id="activity-radio">
                            <input type="radio" name="assignment-type" value="activity" class="radio-input">
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <div class="radio-icon"><i class="fas fa-running"></i></div>
                                <div class="radio-text">نشاط</div>
                            </div>
                        </label>

                        <label class="radio-button" id="quiz-radio">
                            <input type="radio" name="assignment-type" value="quiz" class="radio-input">
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <div class="radio-icon"><i class="fas fa-question-circle"></i></div>
                                <div class="radio-text">اختبار قصير</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="assignment-class">الفصل المستهدف *</label>
                    <select id="assignment-class" class="form-control select-placeholder" required></select>
                </div>

                <div class="form-group">
                    <label for="assignment-description">وصف التكليف *</label>
                    <textarea id="assignment-description" class="form-control" placeholder="أدخل وصف التكليف والتعليمات..." required></textarea>
                    <small style="color: var(--dark-text-secondary); margin-top: 5px; display: block;">
                        ملاحظة: التكليف سيصل إلكترونياً إلى جميع الطلاب في الفصل، وسيتم حله وتقديمه إلكترونياً.
                    </small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="assignment-deadline">الموعد النهائي *</label>
                        <input type="date" id="assignment-deadline" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="assignment-points">الدرجة (اختياري)</label>
                        <input type="number" id="assignment-points" class="form-control" placeholder="أدخل الدرجة الكلية للتكليف" min="0" max="100">
                    </div>
                </div>

                <div class="form-group">
                    <label>مرفقات (اختياري)</label>
                    <div class="file-upload">
                        <input type="file" id="assignment-file" class="file-input">
                        <label for="assignment-file" class="file-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>اسحب وأفلت الملف أو انقر للاختيار</span>
                            <small style="color: var(--dark-text-secondary); margin-top: 10px; display: block;">
                                يمكن رفع PDF, Word, PowerPoint أو صور
                            </small>
                        </label>
                        <div class="file-info" id="file-info"></div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        إرسال التكليف
                    </button>
                    <button type="button" class="btn btn-secondary" id="cancel-assignment">إلغاء</button>
                </div>
            </form>
        </div>

        <div class="assignments-list-container" style="margin-top: 40px;">
            <h2 style="margin-bottom: 20px; color: var(--dark-text);"><i class="fas fa-list"></i> التكاليف المرسلة</h2>
            <div class="grades-table" style="display: block; overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>عنوان التكليف</th>
                            <th>الفصل</th>
                            <th>تاريخ الإنشاء</th>
                            <th>تاريخ التسليم المتوقع</th>
                            <th>إدارة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments ?? [] as $assignment)
                        <tr>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ optional($assignment->classRoom)->classes_name ?? 'غير محدد' }}</td>
                            <td dir="ltr">{{ \Carbon\Carbon::parse($assignment->created_at)->format('Y-m-d') }}</td>
                            <td dir="ltr">
                                @if(\Carbon\Carbon::parse($assignment->due_date)->isPast())
                                    <span style="color:var(--danger-color); font-weight:bold;">منتهي: {{ \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d') }}</span>
                                @else
                                    <span style="color:var(--success-color);">{{ \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d') }}</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                   <button class="btn btn-primary" onclick="openSubmissionsPage({{ $assignment->id }}, '{{ addslashes($assignment->title) }}')" style="padding: 8px 12px; font-size: 0.85rem;">
                                       التسليمات ({{ $assignment->submissions->count() }})
                                   </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 30px; text-align: center; color: var(--dark-text-secondary); background: var(--dark-surface);">لا توجد التكاليف مقدّمة حالياً.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px; text-align: center; direction: ltr;">
                {{ $assignments->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    <!-- صفحة التسليمات -->
    <div id="submissions-page" class="page">
        <div class="page-header">
            <button class="back-btn" onclick="document.getElementById('submissions-page').classList.remove('active')">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-tasks"></i>
                تسليمات التكليف: <span id="submissions-assignment-title"></span>
            </h1>
        </div>
        <div class="card">
            <div id="submissions-loading" style="text-align: center; padding: 20px; display: none;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i>
            </div>
            <div class="table-responsive">
                <table class="grades-table" id="submissions-table">
                    <thead>
                        <tr>
                            <th>الطالب</th>
                            <th>حالة التسليم</th>
                            <th>تاريخ التسليم</th>
                            <th>الملف/النص</th>
                            <th>الدرجة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="submissions-tbody">
                        <!-- Dynamic rows here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- نافذة تقييم التسليم المنبثقة -->
    <div class="modal-overlay" id="gradeSubmissionModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-star"></i>
                    تقييم تسليم الطالب
                </h2>
                <button class="modal-close" onclick="hideModal('gradeSubmissionModal')">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="grade-sub-id" value="">
                <div class="form-group">
                    <label>الدرجة الممنوحة</label>
                    <input type="number" id="grade-sub-score" class="form-control" min="0" step="0.5">
                </div>
                <div class="form-group">
                    <label>ملاحظات المعلم (اختياري)</label>
                    <textarea id="grade-sub-note" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="hideModal('gradeSubmissionModal')">إلغاء</button>
                <button class="btn btn-primary" onclick="submitGrade()">حفظ التقييم</button>
            </div>
        </div>
    </div>

    <!-- صفحة إدخال الدرجات -->
    <div id="grades-page" class="page">
        <div class="page-header">
            <button class="back-btn" id="back-from-grades">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-star-half-alt"></i>
                <span id="grades-title">تقييم الطلاب وإدخال الدرجات</span>
            </h1>
        </div>

        <div class="grades-container">
            <div id="class-selection-section">
                <h2 style="margin-bottom: 20px; color: var(--dark-text);">اختر الفصل لإدخال الدرجات:</h2>
                <div class="classes-container" id="grades-classes-list"></div>
            </div>

            <div id="grades-entry-section" style="display: none;">
                <div class="grades-header">
                    <div class="grades-summary">
                        <div class="summary-item">
                            <div class="summary-value" id="students-count">0</div>
                            <div class="summary-label">عدد الطلاب</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value" id="grades-saved">0</div>
                            <div class="summary-label">درجات محفوظة</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value" id="average-grade">0</div>
                            <div class="summary-label">المتوسط العام</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value" id="notes-count">0</div>
                            <div class="summary-label">ملاحظات مكتوبة</div>
                        </div>
                    </div>
                    <div class="grades-actions">
                        <button class="btn btn-secondary" id="change-class-btn">
                            <i class="fas fa-exchange-alt"></i>
                            تغيير الفصل
                        </button>
                        <button class="btn btn-success" id="save-grades-btn">
                            <i class="fas fa-save"></i>
                            حفظ الدرجات
                        </button>
                    </div>
                </div>

                <div id="grades-table-container"></div>
            </div>
        </div>
    </div>

    <!-- صفحة الجلسات المباشرة -->
    <!-- صفحة الاختبارات -->
    <div id="quizzes-page" class="page">
        <div class="page-header">
            <button class="back-btn" id="back-from-quizzes">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-question-circle"></i>
                إدارة الاختبارات
            </h1>
        </div>

        <div class="sessions-container" style="max-width: 900px; margin: 0 auto;">
            <!-- زر إنشاء اختبار -->
            <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                <button class="btn btn-primary" id="open-create-quiz-btn" style="flex: 1;">
                    <i class="fas fa-plus"></i> إنشاء اختبار يدوي
                </button>
                <button class="btn" id="ai-generate-quiz-btn" style="flex: 1; background: linear-gradient(135deg, #8b5cf6, #6366f1); color: #fff; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; display:flex; align-items:center; justify-content:center; gap:8px; cursor: pointer;">
                    <i class="fas fa-wand-magic-sparkles"></i> توليد اختبار بالذكاء الاصطناعي
                </button>
            </div>

            <!-- نموذج إنشاء اختبار يدوي -->
            <div id="create-quiz-form" style="display: none; background: var(--dark-surface); padding: 20px; border-radius: var(--border-radius); border: 1px solid var(--dark-border); margin-bottom: 30px;">
                <h2 style="margin-bottom: 20px; color: var(--dark-text);"><i class="fas fa-edit"></i> إنشاء اختبار جديد</h2>
                <form id="manual-quiz-form">
                    @csrf
                    <div class="form-group" style="text-align: right;">
                        <label>عنوان الاختبار *</label>
                        <input type="text" name="title" class="form-control" required placeholder="مثال: اختبار الوحدة الأولى">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label>وصف الاختبار</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="وصف مختصر..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group" style="flex:1; text-align: right;">
                            <label>اختر الفصل *</label>
                            <select name="class_id" class="form-control select-placeholder" required>
                                <option value="" disabled selected>-- اختر الفصل --</option>
                                @foreach($classes as $c)
                                    <option style="color: black;" value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex:1; text-align: right;">
                            <label>المدة (بالدقائق)</label>
                            <input type="number" name="duration" class="form-control" min="5" max="240" value="30">
                        </div>
                    </div>

                    <div id="quiz-questions-container">
                        <h3 style="margin: 15px 0 10px; color: var(--dark-text);">الأسئلة</h3>
                        <div class="quiz-question-block" data-qindex="0" style="background: var(--dark-bg); padding: 15px; border-radius: 8px; margin-bottom: 10px; border: 1px solid var(--dark-border);">
                            <label style="color:var(--dark-text-secondary); font-weight:600;">السؤال 1</label>
                            <input type="text" name="questions[0][text]" class="form-control" required placeholder="نص السؤال" style="margin-bottom:8px;">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                                <input type="text" name="questions[0][options][0]" class="form-control" required placeholder="الخيار أ">
                                <input type="text" name="questions[0][options][1]" class="form-control" required placeholder="الخيار ب">
                                <input type="text" name="questions[0][options][2]" class="form-control" required placeholder="الخيار ج">
                                <input type="text" name="questions[0][options][3]" class="form-control" required placeholder="الخيار د">
                            </div>
                            <div style="margin-top:8px;">
                                <label style="color:var(--dark-text-secondary);">الإجابة الصحيحة</label>
                                <select name="questions[0][correct]" class="form-control" style="max-width:200px;">
                                    <option value="0">الخيار أ</option>
                                    <option value="1">الخيار ب</option>
                                    <option value="2">الخيار ج</option>
                                    <option value="3">الخيار د</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-quiz-question-btn" class="btn btn-secondary" style="margin: 10px 0;">
                        <i class="fas fa-plus"></i> إضافة سؤال آخر
                    </button>

                    <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-success" style="flex: 2;"><i class="fas fa-check"></i> حفظ الاختبار</button>
                        <button type="button" class="btn btn-secondary" id="cancel-create-quiz" style="flex: 1;">إلغاء</button>
                    </div>
                </form>
            </div>

            <!-- نموذج التوليد بالذكاء الاصطناعي -->
            <div id="ai-quiz-form" style="display: none; background: var(--dark-surface); padding: 20px; border-radius: var(--border-radius); border: 1px solid var(--dark-border); margin-bottom: 30px;">
                <h2 style="margin-bottom: 20px; color: var(--dark-text);"><i class="fas fa-wand-magic-sparkles"></i> توليد اختبار بالذكاء الاصطناعي</h2>
                <form id="ai-quiz-generate-form">
                    @csrf
                    <div class="form-group" style="text-align: right;">
                        <label>الموضوع *</label>
                        <input type="text" name="topic" class="form-control" required placeholder="مثال: Present Simple Tense">
                    </div>
                    <div class="form-row">
                        <div class="form-group" style="flex:1; text-align: right;">
                            <label>اختر الفصل *</label>
                            <select name="class_id" class="form-control select-placeholder" required>
                                <option value="" disabled selected>-- اختر الفصل --</option>
                                @foreach($classes as $c)
                                    <option style="color: black;" value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex:1; text-align: right;">
                            <label>عدد الأسئلة</label>
                            <input type="number" name="count" class="form-control" min="3" max="30" value="10">
                        </div>
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label>المستوى</label>
                        <select name="level" class="form-control">
                            <option value="A1">A1 - مبتدئ</option>
                            <option value="A2">A2 - قبل المتوسط</option>
                            <option value="B1" selected>B1 - متوسط</option>
                            <option value="B2">B2 - فوق المتوسط</option>
                            <option value="C1">C1 - متقدم</option>
                            <option value="C2">C2 - إتقان</option>
                        </select>
                    </div>
                    <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-success" id="ai-quiz-submit-btn" style="flex: 2;"><i class="fas fa-robot"></i> توليد</button>
                        <button type="button" class="btn btn-secondary" id="cancel-ai-quiz" style="flex: 1;">إلغاء</button>
                    </div>
                </form>
            </div>

            <!-- قائمة الاختبارات الموجودة -->
            <h3 style="margin-bottom: 15px; color: var(--dark-text); text-align: right;">الاختبارات الخاصة بي</h3>
            <div class="grades-table" style="display: block; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">العنوان</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">عدد الأسئلة</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">تاريخ الإنشاء</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">إدارة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes ?? [] as $quiz)
                        <tr style="background: var(--dark-surface);">
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">{{ $quiz->test_name }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">{{ $quiz->questions->count() }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;" dir="ltr">{{ $quiz->created_at->format('Y-m-d') }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">
                                <form method="POST" action="{{ route('teacher.quiz.destroy', $quiz->test_id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الاختبار؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 8px 12px; font-size: 0.85rem;"><i class="fas fa-trash"></i> حذف</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: var(--dark-text-secondary);">
                                <i class="fas fa-clipboard" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                لا توجد اختبارات بعد. قم بإنشاء اختبار جديد أو توليد واحد بالذكاء الاصطناعي.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="sessions-page" class="page">
        <div class="page-header">
            <button class="back-btn" id="back-from-sessions">
                <i class="fas fa-arrow-left"></i>
                <span>رجوع</span>
            </button>
            <h1 class="page-title">
                <i class="fas fa-video"></i>
                الجلسات المباشرة (Jitsi Meet)
            </h1>
        </div>

        <div class="sessions-container" style="max-width: 900px; margin: 0 auto;">
            
            <button class="btn btn-primary" id="open-create-session-btn" style="margin-bottom: 20px; width:100%;">
                <i class="fas fa-plus"></i> إنشاء جلسة جديدة
            </button>

            <div id="create-session-form" style="display: none; background: var(--dark-surface); padding: 20px; border-radius: var(--border-radius); border: 1px solid var(--dark-border); margin-bottom: 30px;">
                <h2 style="margin-bottom: 20px; color: var(--dark-text);"><i class="fas fa-calendar-alt"></i> جدولة جلسة جديدة</h2>
                <form action="{{ route('teacher.session.create') }}" method="POST">
                    @csrf
                    <div class="form-group" style="text-align: right;">
                        <label>موضوع الجلسة *</label>
                        <input type="text" name="topic" class="form-control" required placeholder="مثال: مراجعة الوحدة الأولى">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label>اختر الفصل *</label>
                        <select name="class_id" class="form-control select-placeholder" required>
                            <option value="" disabled selected>-- اختر الفصل --</option>
                            @foreach($classes as $c)
                                <option style="color: black;" value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group" style="flex:1; text-align: right;">
                            <label>وقت وتاريخ البدء *</label>
                            <input type="datetime-local" name="start_time" class="form-control" required>
                        </div>
                        <div class="form-group" style="flex:1; text-align: right;">
                            <label>مدة الجلسة (بالدقائق) *</label>
                            <input type="number" name="duration" class="form-control" min="15" max="300" value="60" required>
                        </div>
                    </div>
                    <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-success" style="flex: 2;"><i class="fas fa-check"></i> حفظ وجدولة الجلسة</button>
                        <button type="button" class="btn btn-secondary" id="cancel-create-session" style="flex: 1;">إلغاء</button>
                    </div>
                </form>
            </div>

            <h3 style="margin-bottom: 15px; color: var(--dark-text); text-align: right;">الجلسات المجدولة والنشطة</h3>
            <div class="grades-table" style="display: block; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">الموضوع</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">الفصل</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">التاريخ</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">المدة</th>
                            <th style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right; color: var(--dark-text-secondary);">إدارة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions ?? [] as $session)
                        <tr style="background: var(--dark-surface);">
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">{{ $session->topic }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">{{ $session->classRoom->classes_name ?? 'بدون' }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;" dir="ltr">{{ \Carbon\Carbon::parse($session->start_time)->format('Y-m-d h:i A') }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">{{ $session->duration }} دقيقة</td>
                            <td style="padding: 15px; border-bottom: 1px solid var(--dark-border); text-align: right;">
                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                    <a href="{{ $session->join_url }}" target="_blank" class="btn btn-primary" style="padding: 8px 12px; font-size: 0.85rem;">
                                        <i class="fas fa-play"></i> بدء
                                    </a>
                                    <form action="{{ route('teacher.session.delete', $session->session_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning" style="padding: 8px 12px; font-size: 0.85rem;" onclick="return confirm('هل أنت متأكد من حذف هذه الجلسة؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 30px; text-align: center; color: var(--dark-text-secondary); background: var(--dark-surface);">لا توجد جلسات مجدولة حالياً.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px; text-align: center; direction: ltr;">
                {{ $sessions->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

    <!-- نافذة كتابة الملاحظات -->
    <div id="note-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-edit"></i>
                    <span id="modal-student-name">ملاحظة للطالب</span>
                </h2>
                <button class="modal-close" id="close-modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="student-modal-info" id="modal-student-info"></div>
                <div class="grades-summary-modal" id="modal-grades-summary"></div>

                <div class="form-group">
                    <label for="note-text">ملاحظة المعلم *</label>
                    <textarea id="note-text" class="note-textarea"
                              placeholder="اكتب ملاحظتك هنا... يمكنك ذكر نقاط القوة والضعف للطالب والتوصيات للتحسين"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-note">إلغاء</button>
                <button class="btn btn-warning" id="save-note">
                    <i class="fas fa-save"></i>
                    حفظ الملاحظة
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => showToast("{{ session('success') }}", 'success'), 500);
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => showToast("{{ session('error') }}", 'error'), 500);
        });
    </script>
    @endif

    <script>
        // =========================
        // المصادقة تتم عبر Laravel middleware — لا حاجة لتسجيل دخول ثاني
        // =========================

        // بيانات حقيقية للفصول
        const classesData = @json($classes);

        // بيانات حقيقية للطلاب (مجمعة حسب الفصل)
        const studentsData = @json($studentsByClass);

        // تخزين الدرجات لكل طالب من Backend
        let gradesData = @json($gradesData ?? []);

        // تخزين الملاحظات لكل طالب من Backend
        let notesData = @json($notesData ?? []);

        function initializeGradesData() {
            // Data is already loaded from backend via json, no need to load from localStorage
        }

        function saveGradesData() {
            // Function no longer saves to localStorage directly.
        }
        function saveNotesData() {
            // Function no longer saves to localStorage directly.
        }

        // عناصر DOM
        const loginPage = document.getElementById('login-page');
        const loginForm = document.getElementById('login-form');
        const loginError = document.getElementById('login-error');

        const mainPage = document.getElementById('main-page');
        const teacherWelcome = document.getElementById('teacher-welcome');

        const classesPage = document.getElementById('classes-page');
        const classStudentsPage = document.getElementById('class-students-page');
        const assignmentsPage = document.getElementById('assignments-page');
        const gradesPage = document.getElementById('grades-page');
        const sessionsPage = document.getElementById('sessions-page');
        const quizzesPage = document.getElementById('quizzes-page');

        const classesBtn = document.getElementById('classes-btn');
        const assignmentsBtn = document.getElementById('assignments-btn');
        const gradesBtn = document.getElementById('grades-btn');
        const sessionsBtn = document.getElementById('sessions-btn');
        const quizzesBtn = document.getElementById('quizzes-btn');
        const logoutBtn = document.getElementById('logout-btn');

        const backFromClassesBtn = document.getElementById('back-from-classes');
        const backFromStudentsBtn = document.getElementById('back-from-students');
        const backFromAssignmentsBtn = document.getElementById('back-from-assignments');
        const backFromGradesBtn = document.getElementById('back-from-grades');
        const backFromSessionsBtn = document.getElementById('back-from-sessions');
        const backFromQuizzesBtn = document.getElementById('back-from-quizzes');

        const classesList = document.getElementById('classes-list');
        const studentsList = document.getElementById('students-list');
        const classTitle = document.getElementById('class-title');

        const assignmentForm = document.getElementById('assignment-form');
        const cancelAssignmentBtn = document.getElementById('cancel-assignment');
        const assignmentClassSelect = document.getElementById('assignment-class');
        const assignmentFile = document.getElementById('assignment-file');
        const fileInfo = document.getElementById('file-info');

        // عناصر صفحة الدرجات
        const classSelectionSection = document.getElementById('class-selection-section');
        const gradesEntrySection = document.getElementById('grades-entry-section');
        const gradesClassesList = document.getElementById('grades-classes-list');
        const gradesTitle = document.getElementById('grades-title');
        const changeClassBtn = document.getElementById('change-class-btn');
        const saveGradesBtn = document.getElementById('save-grades-btn');
        const gradesTableContainer = document.getElementById('grades-table-container');
        const studentsCountEl = document.getElementById('students-count');
        const gradesSavedEl = document.getElementById('grades-saved');
        const averageGradeEl = document.getElementById('average-grade');
        const notesCountEl = document.getElementById('notes-count');

        // عناصر نافذة الملاحظات
        const noteModal = document.getElementById('note-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const cancelNoteBtn = document.getElementById('cancel-note');
        const saveNoteBtn = document.getElementById('save-note');
        const modalStudentName = document.getElementById('modal-student-name');
        const modalStudentInfo = document.getElementById('modal-student-info');
        const modalGradesSummary = document.getElementById('modal-grades-summary');
        const noteText = document.getElementById('note-text');

        // عناصر الجلسات
        const openCreateSessionBtn = document.getElementById('open-create-session-btn');
        const cancelCreateSessionBtn = document.getElementById('cancel-create-session');
        const createSessionForm = document.getElementById('create-session-form');

        // متغيرات إضافية
        let selectedClassId = null;
        let selectedStudentId = null;
        let selectedStudent = null;

        // عناصر أزرار الراديو
        const assignmentTypeButtons = document.querySelectorAll('.radio-button');

        document.addEventListener('DOMContentLoaded', function() {
            initializeGradesData();
            renderClasses();
            renderGradesClasses();
            populateClassSelect();
            setupEventListeners();
            activateRadioButtons();

            // تاريخ افتراضي للموعد النهائي (بعد أسبوع)
            const nextWeek = new Date();
            nextWeek.setDate(nextWeek.getDate() + 7);
            document.getElementById('assignment-deadline').valueAsDate = nextWeek;

            // عرض اسم المعلم من session — المصادقة تمت عبر Laravel middleware
            const currentTab = new URLSearchParams(window.location.search).get('tab') || 'home';
            if (currentTab !== 'home') {
                mainPage.style.display = 'none';
                showPage(currentTab + '-page');
            } else {
                mainPage.style.display = 'flex';
            }
            teacherWelcome.textContent = `مرحباً {{ session('name') ?? 'أستاذ' }} 👋`;

        // تسجيل خروج
        logoutBtn.addEventListener('click', () => {
            localStorage.removeItem('teacherLoggedIn');
            localStorage.removeItem('teacherName');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}';
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        });

        function renderClasses() {
            classesList.innerHTML = '';
            classesData.forEach(classItem => {
                const classCard = document.createElement('div');
                classCard.className = 'class-card';
                classCard.dataset.id = classItem.id;

                classCard.innerHTML = `
                    <div class="class-header">
                        <div class="class-name">${classItem.name}</div>
                        <div class="class-code">${classItem.code}</div>
                    </div>
                    <div class="class-info">
                        <div class="class-info-item">
                            <i class="fas fa-users"></i>
                            <span>${classItem.students} طالب</span>
                        </div>
                        <div class="class-info-item">
                            <i class="fas fa-signal"></i>
                            <span>المستوى: ${classItem.level}</span>
                        </div>
                    </div>
                    <div class="class-description">${classItem.description}</div>
                `;

                classCard.addEventListener('click', function() {
                    const classId = this.dataset.id;
                    const selectedClass = classesData.find(c => c.id == classId);
                    showClassStudents(classId, selectedClass.name);
                });

                classesList.appendChild(classCard);
            });
        }

        function renderGradesClasses() {
            gradesClassesList.innerHTML = '';
            classesData.forEach(classItem => {
                const classCard = document.createElement('div');
                classCard.className = 'class-card';
                classCard.dataset.id = classItem.id;

                classCard.innerHTML = `
                    <div class="class-header">
                        <div class="class-name">${classItem.name}</div>
                        <div class="class-code">${classItem.code}</div>
                    </div>
                    <div class="class-info">
                        <div class="class-info-item">
                            <i class="fas fa-users"></i>
                            <span>${classItem.students} طالب</span>
                        </div>
                        <div class="class-info-item">
                            <i class="fas fa-signal"></i>
                            <span>المستوى: ${classItem.level}</span>
                        </div>
                    </div>
                    <div class="class-description">${classItem.description}</div>
                `;

                classCard.addEventListener('click', function() {
                    selectedClassId = this.dataset.id;
                    const selectedClass = classesData.find(c => c.id == selectedClassId);
                    showGradesEntry(selectedClass);
                });

                gradesClassesList.appendChild(classCard);
            });
        }

        function populateClassSelect() {
            assignmentClassSelect.innerHTML = '';
         // Submissions API integration
        function openSubmissionsPage(assignment_id, title) {
            document.getElementById('submissions-assignment-title').textContent = title;
            document.getElementById('submissions-page').classList.add('active');
            const tbody = document.getElementById('submissions-tbody');
            const loading = document.getElementById('submissions-loading');
            
            tbody.innerHTML = '';
            loading.style.display = 'block';

            fetch(`/teacher/assignments/${assignment_id}/submissions`)
                .then(res => res.json())
                .then(data => {
                    loading.style.display = 'none';
                    if (!data.success) {
                        showToast('حدث خطأ في جلب التسليمات', 'error');
                        return;
                    }

                    if (data.data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; padding: 20px;">لا توجد تسليمات حتى الآن</td></tr>`;
                        return;
                    }

                    data.data.forEach(sub => {
                        const studentName = sub.student?.user?.full_name || 'طالب غير معروف';
                        const lastVersion = sub.versions?.length ? sub.versions[sub.versions.length - 1] : null;
                        const date = lastVersion ? new Date(lastVersion.created_at).toLocaleString('ar-EG') : '-';
                        
                        let contentHtml = '-';
                        if (lastVersion) {
                            contentHtml = '';
                            if (lastVersion.file_path) {
                                contentHtml += `<a href="/downloads/submissions/${lastVersion.id}" target="_blank" class="btn btn-secondary" style="padding: 4px 8px; font-size: 0.8rem; display: inline-block; margin-bottom: 5px;"><i class="fas fa-file"></i> تحميل المرفق</a>`;
                            }
                            if (lastVersion.content) {
                                contentHtml += `<div style="font-size:0.85rem; max-height:80px; overflow:hidden; text-overflow:ellipsis; background:var(--dark-bg); padding:5px; border-radius:4px;" title="${lastVersion.content}">${lastVersion.content}</div>`;
                            }
                        }

                        let statusHtml = '';
                        if (sub.status === 'submitted') statusHtml = '<span style="color:var(--primary-color);">مسلم</span>';
                        else if (sub.status === 'late') statusHtml = '<span style="color:var(--warning-color);">متأخر</span>';
                        else if (sub.status === 'graded') statusHtml = '<span style="color:var(--success-color);">تم التقييم</span>';

                        const gradeVal = sub.grade !== null ? sub.grade : '-';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${studentName}</td>
                            <td>${statusHtml}</td>
                            <td dir="ltr">${date}</td>
                            <td>${contentHtml}</td>
                            <td id="grade-display-${sub.id}" style="font-weight:bold; color:var(--success-color);">${gradeVal}</td>
                            <td>
                                <button class="btn btn-warning" onclick="openGradeModal(${sub.id}, ${sub.grade || 0}, '${(sub.teacher_comment || '').replace(/'/g, "\\'")}')" style="padding: 5px 10px; font-size: 0.85rem;">
                                    <i class="fas fa-star"></i> تقييم
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(err => {
                    loading.style.display = 'none';
                    showToast('فشل الاتصال بالخادم', 'error');
                });
        }

        function openGradeModal(submission_id, current_grade, comment) {
            document.getElementById('grade-sub-id').value = submission_id;
            document.getElementById('grade-sub-score').value = current_grade || '';
            document.getElementById('grade-sub-note').value = comment || '';
            showModal('gradeSubmissionModal');
        }

        function submitGrade() {
            const id = document.getElementById('grade-sub-id').value;
            const grade = document.getElementById('grade-sub-score').value;
            const note = document.getElementById('grade-sub-note').value;

            if (!grade) {
                showToast('الرجاء إدخال الدرجة', 'error');
                return;
            }

            fetch(`/teacher/submissions/${id}/grade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ grade: grade, teacher_comment: note })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    hideModal('gradeSubmissionModal');
                    // Update table UI
                    const display = document.getElementById(`grade-display-${id}`);
                    if (display) display.textContent = grade;
                } else {
                    showToast(data.message || 'خطأ في الحفظ', 'error');
                }
            })
            .catch(err => showToast('حدث خطأ في الخادم', 'error'));
        }

        // Initialize empty rows placeholders mostly everywhere...
            const placeholderOption = document.createElement('option');
            placeholderOption.value = "";
            placeholderOption.textContent = "اختر الفصل";
            placeholderOption.disabled = true;
            placeholderOption.selected = true;
            placeholderOption.hidden = true;
            assignmentClassSelect.appendChild(placeholderOption);

            @foreach($classes as $c)
                const opt_{{ $loop->index }} = document.createElement('option');
                opt_{{ $loop->index }}.value = "{{ $c['id'] }}";
                opt_{{ $loop->index }}.textContent = "{{ $c['name'] }}";
                assignmentClassSelect.appendChild(opt_{{ $loop->index }});
            @endforeach
        }
        assignmentClassSelect.setAttribute('placeholder', 'اختر الفصل');

        function showClassStudents(classId, className) {
            classTitle.textContent = `طلاب ${className}`;
            const students = studentsData[classId] || [];
            studentsList.innerHTML = '';

            if (students.length === 0) {
                studentsList.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: var(--dark-text-secondary); grid-column: 1 / -1;">
                        <i class="fas fa-users-slash" style="font-size: 3rem; margin-bottom: 20px;"></i>
                        <p style="font-size: 1.2rem;">لا يوجد طلاب في هذا الفصل</p>
                    </div>
                `;
            } else {
                students.forEach(student => {
                    const studentCard = document.createElement('div');
                    studentCard.className = 'student-card';
                    studentCard.innerHTML = `
                        <div class="student-avatar">${student.avatar}</div>
                        <div class="student-info">
                            <div class="student-name">${student.name}</div>
                            <div class="student-email">${student.email}</div>
                            <div class="student-level">المستوى: ${student.level}</div>
                        </div>
                    `;
                    studentsList.appendChild(studentCard);
                });
            }

            showPage('class-students-page');
        }

        function showGradesEntry(classData) {
            gradesTitle.textContent = `تقييم الطلاب - ${classData.name}`;
            classSelectionSection.style.display = 'none';
            gradesEntrySection.style.display = 'block';
            renderGradesTable(classData.id);
            updateGradesStats(classData.id);
        }

        function renderGradesTable(classId) {
            const students = studentsData[classId] || [];
            const classGrades = gradesData[classId] || {};
            const classNotes = notesData[classId] || {};

            if (students.length === 0) {
                gradesTableContainer.innerHTML = `
                    <div class="no-data">
                        <i class="fas fa-users-slash"></i>
                        <p style="font-size: 1.2rem;">لا يوجد طلاب في هذا الفصل</p>
                    </div>
                `;
                return;
            }

            let tableHTML = `
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">الطالب</th>
                            <th style="width: 12%;">الدرجة النصفية (من 40)</th>
                            <th style="width: 12%;">الدرجة النهائية (من 50)</th>
                            <th style="width: 12%;">الدرجة الشفوية (من 25)</th>
                            <th style="width: 12%;">المجموع (من 115)</th>
                            <th style="width: 12%;">النسبة المئوية</th>
                            <th style="width: 15%;">ملاحظة المعلم</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            students.forEach(student => {
                const studentGrades = classGrades[student.id] || { midterm: 0, final: 0, oral: 0 };
                const studentNote = classNotes[student.id];

                const total = studentGrades.midterm + studentGrades.final + studentGrades.oral;
                const percentage = ((total / 115) * 100).toFixed(1);

                const noteBtnClass = studentNote ? "note-btn has-note" : "note-btn";

                tableHTML += `
                    <tr data-student-id="${student.id}">
                        <td>
                            <div class="student-info-cell">
                                <div class="student-avatar">${student.avatar}</div>
                                <div>
                                    <div style="font-weight: 600;">${student.name}</div>
                                    <div style="font-size: 0.9rem; color: var(--dark-text-secondary);">${student.email}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="grade-input midterm-grade" min="0" max="40" step="0.5"
                                   value="${studentGrades.midterm}" data-grade-type="midterm">
                        </td>
                        <td>
                            <input type="number" class="grade-input final-grade" min="0" max="50" step="0.5"
                                   value="${studentGrades.final}" data-grade-type="final">
                        </td>
                        <td>
                            <input type="number" class="grade-input oral-grade" min="0" max="25" step="0.5"
                                   value="${studentGrades.oral}" data-grade-type="oral">
                        </td>
                        <td class="total-grade" data-total="${total}">${total}</td>
                        <td style="text-align: center; font-weight: 600; color: ${getPercentageColor(percentage)};">${percentage}%</td>
                        <td>
                            <button class="${noteBtnClass}" data-student-id="${student.id}">
                                <i class="fas fa-edit"></i>
                                ملاحظة
                            </button>
                        </td>
                    </tr>
                `;
            });

            tableHTML += `</tbody></table>`;
            gradesTableContainer.innerHTML = tableHTML;

            document.querySelectorAll('.grade-input').forEach(input => {
                input.addEventListener('input', function() {
                    updateStudentTotal(this);
                    updateGradesStats(selectedClassId);
                });

                input.addEventListener('change', function() {
                    validateGradeInput(this);
                });
            });

            document.querySelectorAll('.note-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.studentId;
                    openNoteModal(studentId);
                });
            });
        }

        function updateStudentTotal(inputElement) {
            const row = inputElement.closest('tr');
            const studentId = row.dataset.studentId;

            const midtermInput = row.querySelector('.midterm-grade');
            const finalInput = row.querySelector('.final-grade');
            const oralInput = row.querySelector('.oral-grade');

            const midterm = parseFloat(midtermInput.value) || 0;
            const final = parseFloat(finalInput.value) || 0;
            const oral = parseFloat(oralInput.value) || 0;

            const total = midterm + final + oral;

            const totalCell = row.querySelector('.total-grade');
            totalCell.textContent = total;
            totalCell.dataset.total = total;

            const percentage = ((total / 115) * 100).toFixed(1);
            const percentageCell = row.querySelector('td:nth-child(6)');
            percentageCell.textContent = `${percentage}%`;
            percentageCell.style.color = getPercentageColor(percentage);

            if (!gradesData[selectedClassId]) gradesData[selectedClassId] = {};
            gradesData[selectedClassId][studentId] = { midterm, final, oral };
        }

        function validateGradeInput(inputElement) {
            const max = parseInt(inputElement.max);
            const value = parseFloat(inputElement.value) || 0;

            if (value < 0) {
                inputElement.value = 0;
                inputElement.classList.add('error');
                setTimeout(() => inputElement.classList.remove('error'), 1000);
            } else if (value > max) {
                inputElement.value = max;
                inputElement.classList.add('error');
                setTimeout(() => inputElement.classList.remove('error'), 1000);
            } else {
                inputElement.classList.add('success');
                setTimeout(() => inputElement.classList.remove('success'), 1000);
            }

            updateStudentTotal(inputElement);
        }

        function getPercentageColor(percentage) {
            const perc = parseFloat(percentage);
            if (perc >= 90) return '#10b981';
            if (perc >= 80) return '#3b82f6';
            if (perc >= 70) return '#f59e0b';
            if (perc >= 60) return '#f97316';
            return '#ef4444';
        }

        function updateGradesStats(classId) {
            const students = studentsData[classId] || [];
            const classGrades = gradesData[classId] || {};
            const classNotes = notesData[classId] || {};

            studentsCountEl.textContent = students.length;

            let savedCount = 0;
            let totalSum = 0;
            let studentCount = 0;

            students.forEach(student => {
                const studentGrades = classGrades[student.id];
                if (studentGrades) {
                    const total = studentGrades.midterm + studentGrades.final + studentGrades.oral;
                    if (total > 0) {
                        savedCount++;
                        totalSum += total;
                        studentCount++;
                    }
                }
            });

            gradesSavedEl.textContent = savedCount;
            notesCountEl.textContent = Object.keys(classNotes || {}).length;

            const averagePercentage = studentCount > 0 ? ((totalSum / studentCount) / 115 * 100).toFixed(1) : 0;
            averageGradeEl.textContent = averagePercentage > 0 ? `${averagePercentage}%` : '0';
            averageGradeEl.style.color = getPercentageColor(averagePercentage);
        }

        function saveGrades() {
            if (!selectedClassId) {
                alert('الرجاء اختيار فصل أولاً');
                return;
            }

            const gradesToSave = gradesData[selectedClassId] || {};
            const gradesPayload = [];
            for (const [studentId, grade] of Object.entries(gradesToSave)) {
                gradesPayload.push({
                    student_id: studentId,
                    midterm: grade.midterm,
                    final: grade.final,
                    oral: grade.oral
                });
            }

            const submitBtn = document.getElementById('save-grades-btn');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';

            fetch('{{ route("teacher.grades.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    class_id: selectedClassId,
                    grades: gradesPayload
                })
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                if(data.success) {
                    showToast(data.message || 'تم حفظ الدرجات بنجاح!', 'success');
                    updateGradesStats(selectedClassId);
                } else {
                    showToast(data.message || 'حدث خطأ أثناء حفظ الدرجات', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                showToast('حدث خطأ في الاتصال بالخادم', 'error');
            });
        }

        function openNoteModal(studentId) {
            if (!selectedClassId) return;

            selectedStudentId = studentId;
            const students = studentsData[selectedClassId] || [];
            selectedStudent = students.find(s => s.id == studentId);
            if (!selectedStudent) return;

            modalStudentName.textContent = `ملاحظة للطالب: ${selectedStudent.name}`;

            modalStudentInfo.innerHTML = `
                <div class="student-modal-avatar">${selectedStudent.avatar}</div>
                <div class="student-modal-details">
                    <h3>${selectedStudent.name}</h3>
                    <p>${selectedStudent.email}</p>
                    <p>المستوى: ${selectedStudent.level}</p>
                </div>
            `;

            const studentGrades = gradesData[selectedClassId]?.[studentId] || { midterm: 0, final: 0, oral: 0 };
            const total = studentGrades.midterm + studentGrades.final + studentGrades.oral;
            const percentage = ((total / 115) * 100).toFixed(1);

            modalGradesSummary.innerHTML = `
                <div class="grade-box grade-midterm">
                    <div class="grade-label">الدرجة النصفية</div>
                    <div class="grade-value">${studentGrades.midterm}/40</div>
                </div>
                <div class="grade-box grade-final">
                    <div class="grade-label">الدرجة النهائية</div>
                    <div class="grade-value">${studentGrades.final}/50</div>
                </div>
                <div class="grade-box grade-oral">
                    <div class="grade-label">الدرجة الشفوية</div>
                    <div class="grade-value">${studentGrades.oral}/25</div>
                </div>
                <div class="grade-box grade-total">
                    <div class="grade-label">المجموع والنسبة</div>
                    <div class="grade-value">${total}/115 (${percentage}%)</div>
                </div>
            `;

            const currentNote = notesData[selectedClassId]?.[studentId];
            noteText.value = currentNote ? currentNote.text : '';

            noteModal.classList.add('active');
        }

        function closeNoteModal() {
            noteModal.classList.remove('active');
            selectedStudentId = null;
            selectedStudent = null;
            noteText.value = '';
        }

        function saveNote() {
            if (!selectedClassId || !selectedStudentId) return;

            const noteTextValue = noteText.value.trim();
            if (!noteTextValue) {
                alert('الرجاء كتابة الملاحظة قبل الحفظ');
                return;
            }

            const saveBtn = document.getElementById('save-note');
            const originalHtml = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';

            fetch('{{ route("teacher.note.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    class_id: selectedClassId,
                    student_id: selectedStudentId,
                    notes: noteTextValue
                })
            })
            .then(response => response.json())
            .then(data => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalHtml;
                
                if (data.success) {
                    const note = { text: noteTextValue, date: new Date().toISOString().split('T')[0] };
                    if (!notesData[selectedClassId]) notesData[selectedClassId] = {};
                    notesData[selectedClassId][selectedStudentId] = note;

                    closeNoteModal();
                    showToast(data.message || 'تم حفظ الملاحظة بنجاح!', 'success');

                    renderGradesTable(selectedClassId);
                    updateGradesStats(selectedClassId);
                } else {
                    showToast(data.message || 'حدث خطأ أثناء إرسال الملاحظة', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalHtml;
                showToast('حدث خطأ في الاتصال بالخادم', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background-color: ${type === 'success' ? 'var(--success-color)' : 'var(--warning-color)'};
                color: white;
                padding: 15px 30px;
                border-radius: var(--border-radius);
                font-weight: 600;
                z-index: 1000;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            `;
            toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        function activateRadioButtons() {
            assignmentTypeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    assignmentTypeButtons.forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                    const radioInput = this.querySelector('.radio-input');
                    radioInput.checked = true;
                });
            });

            if (assignmentTypeButtons.length > 0) {
                assignmentTypeButtons[0].classList.add('selected');
                assignmentTypeButtons[0].querySelector('.radio-input').checked = true;
            }
        }

        function updateURL(tab) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }

        function showPage(pageId) {
            mainPage.style.display = 'none';
            classesPage.classList.remove('active');
            classStudentsPage.classList.remove('active');
            assignmentsPage.classList.remove('active');
            gradesPage.classList.remove('active');
            sessionsPage.classList.remove('active');
            quizzesPage.classList.remove('active');

            if (pageId === 'main-page') {
                mainPage.style.display = 'flex';
                updateURL('home');
            } else {
                document.getElementById(pageId).classList.add('active');
                updateURL(pageId.replace('-page', ''));
            }

            if (pageId === 'grades-page') {
                classSelectionSection.style.display = 'block';
                gradesEntrySection.style.display = 'none';
                selectedClassId = null;
            }
        }

        function setupEventListeners() {
            classesBtn.addEventListener('click', () => showPage('classes-page'));
            assignmentsBtn.addEventListener('click', () => showPage('assignments-page'));
            gradesBtn.addEventListener('click', () => showPage('grades-page'));
            sessionsBtn.addEventListener('click', () => showPage('sessions-page'));
            quizzesBtn.addEventListener('click', () => showPage('quizzes-page'));

            backFromClassesBtn.addEventListener('click', () => showPage('main-page'));
            backFromStudentsBtn.addEventListener('click', () => showPage('classes-page'));
            backFromAssignmentsBtn.addEventListener('click', () => showPage('main-page'));
            backFromGradesBtn.addEventListener('click', () => showPage('main-page'));
            backFromSessionsBtn.addEventListener('click', () => showPage('main-page'));
            backFromQuizzesBtn.addEventListener('click', () => showPage('main-page'));

            if (openCreateSessionBtn) {
                openCreateSessionBtn.addEventListener('click', () => {
                    createSessionForm.style.display = 'block';
                    openCreateSessionBtn.style.display = 'none';
                });
            }
            if (cancelCreateSessionBtn) {
                cancelCreateSessionBtn.addEventListener('click', () => {
                    createSessionForm.style.display = 'none';
                    openCreateSessionBtn.style.display = 'block';
                });
            }

           // Submit Assignment via API
            assignmentForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = assignmentForm.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> إرسال...';

                const assignmentTitle = document.getElementById('assignment-title').value;
                const classId = document.getElementById('assignment-class').value;
                const description = document.getElementById('assignment-description').value;
                const deadline = document.getElementById('assignment-deadline').value;
                const points = document.getElementById('assignment-points').value || 100;

                if (!assignmentTitle || !classId || !deadline) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> إرسال التكليف';
                    showToast('الرجاء تعبئة جميع الحقول المطلوبة', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('class_id', classId);
                formData.append('title', assignmentTitle);
                formData.append('description', description);
                formData.append('due_date', deadline + ' 23:59:59');
                formData.append('max_grade', points);

                const fileInput = document.getElementById('assignment-file');
                if(fileInput.files.length > 0) {
                    formData.append('files[]', fileInput.files[0]);
                }

                fetch('{{ route("teacher.assignment.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> إرسال التكليف';
                    
                    if(data.success) {
                        showToast('تم إرسال التكليف بنجاح لجميع طلاب الفصل');
                        setTimeout(() => {
                            window.location.reload(); // Reload to show the new assignment in the list
                        }, 1500);
                    } else {
                        let errorMsg = 'حدث خطأ أثناء إرسال التكليف';
                        if (data.errors) {
                            const firstError = Object.values(data.errors)[0];
                            if (firstError && firstError.length) errorMsg = firstError[0];
                        }
                        showToast(errorMsg, 'error');
                        console.error('Validation errors:', data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> إرسال التكليف';
                    showToast('حدث خطأ في الاتصال بالخادم', 'error');
                });
            });


            cancelAssignmentBtn.addEventListener('click', function() {
                if (confirm('هل تريد إلغاء إرسال التكليف؟ سيتم فقدان جميع البيانات المدخلة.')) {
                    assignmentForm.reset();
                    assignmentTypeButtons.forEach(btn => btn.classList.remove('selected'));
                    if (assignmentTypeButtons.length > 0) {
                        assignmentTypeButtons[0].classList.add('selected');
                        assignmentTypeButtons[0].querySelector('.radio-input').checked = true;
                    }
                    fileInfo.textContent = '';
                    showPage('main-page');
                }
            });

            assignmentFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    fileInfo.innerHTML = `
                        <div>
                            <i class="fas fa-file"></i>
                            <span style="margin-right: 10px;">${file.name}</span>
                            <span style="color: var(--dark-text-secondary);">(${fileSize} MB)</span>
                        </div>
                        <button type="button" class="remove-file">
                            <i class="fas fa-times"></i> حذف
                        </button>
                    `;

                    const removeBtn = fileInfo.querySelector('.remove-file');
                    removeBtn.addEventListener('click', function() {
                        assignmentFile.value = '';
                        fileInfo.textContent = '';
                    });
                }
            });

            assignmentClassSelect.addEventListener('focus', function() {
                this.classList.remove('select-placeholder');
            });

            assignmentClassSelect.addEventListener('blur', function() {
                if (this.value === "") this.classList.add('select-placeholder');
            });

            assignmentClassSelect.addEventListener('change', function() {
                this.style.color = (this.value !== "") ? 'var(--dark-text)' : 'var(--dark-text-secondary)';
            });

            changeClassBtn.addEventListener('click', function() {
                classSelectionSection.style.display = 'block';
                gradesEntrySection.style.display = 'none';
                selectedClassId = null;
            });

            saveGradesBtn.addEventListener('click', saveGrades);

            closeModalBtn.addEventListener('click', closeNoteModal);
            cancelNoteBtn.addEventListener('click', closeNoteModal);
            saveNoteBtn.addEventListener('click', saveNote);

            noteModal.addEventListener('click', function(e) {
                if (e.target === this) closeNoteModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && noteModal.classList.contains('active')) closeNoteModal();
            });

            // ===== Quiz Management Events =====
            const openCreateQuizBtn = document.getElementById('open-create-quiz-btn');
            const aiGenerateQuizBtn = document.getElementById('ai-generate-quiz-btn');
            const createQuizForm = document.getElementById('create-quiz-form');
            const aiQuizForm = document.getElementById('ai-quiz-form');
            const cancelCreateQuiz = document.getElementById('cancel-create-quiz');
            const cancelAiQuiz = document.getElementById('cancel-ai-quiz');
            const addQuizQuestionBtn = document.getElementById('add-quiz-question-btn');

            if (openCreateQuizBtn) {
                openCreateQuizBtn.addEventListener('click', () => {
                    createQuizForm.style.display = 'block';
                    aiQuizForm.style.display = 'none';
                });
            }
            if (aiGenerateQuizBtn) {
                aiGenerateQuizBtn.addEventListener('click', () => {
                    aiQuizForm.style.display = 'block';
                    createQuizForm.style.display = 'none';
                });
            }
            if (cancelCreateQuiz) {
                cancelCreateQuiz.addEventListener('click', () => {
                    createQuizForm.style.display = 'none';
                });
            }
            if (cancelAiQuiz) {
                cancelAiQuiz.addEventListener('click', () => {
                    aiQuizForm.style.display = 'none';
                });
            }

            // Dynamic question addition
            let quizQuestionIndex = 1;
            if (addQuizQuestionBtn) {
                addQuizQuestionBtn.addEventListener('click', () => {
                    const container = document.getElementById('quiz-questions-container');
                    const idx = quizQuestionIndex++;
                    const block = document.createElement('div');
                    block.className = 'quiz-question-block';
                    block.setAttribute('data-qindex', idx);
                    block.style.cssText = 'background: var(--dark-bg); padding: 15px; border-radius: 8px; margin-bottom: 10px; border: 1px solid var(--dark-border);';
                    block.innerHTML = `
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <label style="color:var(--dark-text-secondary); font-weight:600;">السؤال ${idx + 1}</label>
                            <button type="button" onclick="this.closest('.quiz-question-block').remove()" style="background:var(--danger-color); color:#fff; border:none; border-radius:50%; width:28px; height:28px; cursor:pointer;"><i class="fas fa-times"></i></button>
                        </div>
                        <input type="text" name="questions[${idx}][text]" class="form-control" required placeholder="نص السؤال" style="margin-bottom:8px; margin-top:8px;">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                            <input type="text" name="questions[${idx}][options][0]" class="form-control" required placeholder="الخيار أ">
                            <input type="text" name="questions[${idx}][options][1]" class="form-control" required placeholder="الخيار ب">
                            <input type="text" name="questions[${idx}][options][2]" class="form-control" required placeholder="الخيار ج">
                            <input type="text" name="questions[${idx}][options][3]" class="form-control" required placeholder="الخيار د">
                        </div>
                        <div style="margin-top:8px;">
                            <label style="color:var(--dark-text-secondary);">الإجابة الصحيحة</label>
                            <select name="questions[${idx}][correct]" class="form-control" style="max-width:200px;">
                                <option value="0">الخيار أ</option>
                                <option value="1">الخيار ب</option>
                                <option value="2">الخيار ج</option>
                                <option value="3">الخيار د</option>
                            </select>
                        </div>
                    `;
                    container.appendChild(block);
                });
            }

            // Manual quiz form submission
            const manualQuizForm = document.getElementById('manual-quiz-form');
            if (manualQuizForm) {
                manualQuizForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = {
                        title: formData.get('title'),
                        description: formData.get('description'),
                        class_id: formData.get('class_id'),
                        duration: formData.get('duration'),
                        questions: []
                    };
                    const blocks = document.querySelectorAll('.quiz-question-block');
                    blocks.forEach(block => {
                        const idx = block.getAttribute('data-qindex');
                        const text = formData.get(`questions[${idx}][text]`);
                        const options = [
                            formData.get(`questions[${idx}][options][0]`),
                            formData.get(`questions[${idx}][options][1]`),
                            formData.get(`questions[${idx}][options][2]`),
                            formData.get(`questions[${idx}][options][3]`)
                        ];
                        const correct = parseInt(formData.get(`questions[${idx}][correct]`));
                        data.questions.push({ text, options, correct });
                    });

                    fetch("{{ route('teacher.quiz.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            alert('تم إنشاء الاختبار بنجاح!');
                            location.reload();
                        } else {
                            alert('خطأ: ' + (res.message || 'فشل في إنشاء الاختبار.'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('حدث خطأ غير متوقع.');
                    });
                });
            }

            // AI quiz generation form
            const aiQuizGenerateForm = document.getElementById('ai-quiz-generate-form');
            if (aiQuizGenerateForm) {
                aiQuizGenerateForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('ai-quiz-submit-btn');
                    const origText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التوليد...';

                    const formData = new FormData(this);
                    fetch("{{ route('teacher.quiz.generateAI') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            topic: formData.get('topic'),
                            class_id: formData.get('class_id'),
                            count: formData.get('count'),
                            level: formData.get('level')
                        })
                    })
                    .then(r => r.json())
                    .then(res => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = origText;
                        if (res.success) {
                            alert('تم توليد الاختبار بنجاح بواسطة الذكاء الاصطناعي!');
                            location.reload();
                        } else {
                            alert('خطأ: ' + (res.message || 'فشل في توليد الاختبار.'));
                        }
                    })
                    .catch(err => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = origText;
                        console.error(err);
                        alert('حدث خطأ غير متوقع.');
                    });
                });
            }
        }
        });
    </script>
</body>
</html>