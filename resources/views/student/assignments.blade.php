<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>التكاليف - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
:root{
  --bg-dark:#000c1d;
  --card-bg:rgba(255,255,255,0.08);
  --neon-blue:#00c6ff;
  --neon-purple:#9d50bb;
  --success-green:#10b981;
  --warning-orange:#f59e0b;
  --danger-red:#ef4444;
  --text:#fff;
  --radius:25px;
  --transition:all .3s ease;
}

body{
  margin:0;
  font-family:'Tajawal','Poppins',sans-serif;
  background:var(--bg-dark);
  color:var(--text);
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  padding:20px;
  direction:rtl;
  overflow-x:hidden;
}

/* Background blobs */
.light-blob{
  position:fixed;
  width:520px;
  height:520px;
  background:radial-gradient(circle, rgba(0,198,255,0.12), transparent 70%);
  z-index:-1;
  filter:blur(85px);
}
.blob-1{ top:-120px; left:-120px; }
.blob-2{ bottom:-120px; right:-120px; }

.container{
  width:100%;
  max-width:920px;
  background:var(--card-bg);
  backdrop-filter:blur(20px);
  border:1px solid rgba(255,255,255,0.15);
  border-radius:var(--radius);
  padding:40px;
  box-shadow:0 25px 50px rgba(0,0,0,0.5);
  animation:fadeIn .8s ease-out;
  position:relative;
}

@keyframes fadeIn{
  from{ opacity:0; transform:translateY(20px); }
  to{ opacity:1; transform:translateY(0); }
}

.header{
  text-align:center;
  margin-bottom:26px;
}
.header h1{
  font-size:2.4rem;
  margin:0 0 10px;
  background:linear-gradient(90deg, var(--neon-blue), #0072ff);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}
.header p{
  color:#ccc;
  font-size:1.05rem;
  line-height:1.65;
  margin:0;
}

.assignment-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    transition: var(--transition);
}

.assignment-card:hover { border-color: var(--neon-blue); box-shadow: 0 10px 20px rgba(0, 198, 255, 0.1); }
.assignment-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; margin-bottom: 15px; }
.assignment-title { font-size: 1.25rem; font-weight: 700; color: var(--neon-blue); }
.assignment-meta { font-size: 0.9rem; color: #aaa; display: flex; gap: 15px; }
.assignment-desc { font-size: 1rem; color: #ddd; line-height: 1.6; margin-bottom: 15px; }
.status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; }
.status-pending { background: rgba(245, 158, 11, 0.2); color: var(--warning-orange); border: 1px solid var(--warning-orange); }
.status-submitted { background: rgba(16, 185, 129, 0.2); color: var(--success-green); border: 1px solid var(--success-green); }
.status-late { background: rgba(239, 68, 68, 0.2); color: var(--danger-red); border: 1px solid var(--danger-red); }
.status-graded { background: rgba(157, 80, 187, 0.2); color: var(--neon-purple); border: 1px solid var(--neon-purple); }

.attachments { margin-top: 15px; background: rgba(0,0,0,0.2); padding: 10px; border-radius: 10px; border: 1px dashed rgba(255,255,255,0.2); }
.attachment-link { color: var(--neon-blue); text-decoration: none; display: flex; align-items: center; gap: 8px; font-size: 0.9rem; }
.attachment-link:hover { text-decoration: underline; }

/* Upload area */
.submit-area { margin-top: 15px; background: rgba(0,0,0,0.15); padding: 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 8px; color: #ccc; }
.form-control { width: 100%; padding: 10px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; color: #fff; font-family: inherit; resize: vertical; }
.form-control:focus { outline: none; border-color: var(--neon-blue); }
.file-upload { position: relative; width: 100%; height: 100px; background: rgba(0,0,0,0.3); border: 2px dashed rgba(255,255,255,0.2); border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s; }
.file-upload:hover { border-color: var(--neon-blue); background: rgba(0, 198, 255, 0.05); }
.file-upload input[type="file"] { position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; }

.btn { padding: 10px 20px; border-radius: 8px; border: none; font-family: inherit; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s; color: #fff; }
.btn-primary { background: var(--neon-blue); color: #000; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 198, 255, 0.3); }
.btn-secondary { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); }
.btn-secondary:hover { background: rgba(255,255,255,0.15); }

/* Footer */
.footer-actions { margin-top: 30px; display: flex; justify-content: center; gap: 15px; }
</style>
</head>

<body>
<div class="light-blob blob-1"></div>
<div class="light-blob blob-2"></div>

<div class="container">
  <div class="header">
    <h1><i class="fas fa-tasks"></i> سجل التكاليف</h1>
    <p>تابع التكاليف والواجبات المطلوبة وارفع إجاباتك هنا.</p>
  </div>

  @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid var(--success-green); border-radius: 12px; padding: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-check-circle" style="color: var(--success-green); font-size: 1.3rem;"></i>
        <span style="color: var(--success-green); font-weight: bold;">{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid var(--danger-red); border-radius: 12px; padding: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="color: var(--danger-red); font-size: 1.3rem;"></i>
        <span style="color: var(--danger-red); font-weight: bold;">{{ session('error') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid var(--danger-red); border-radius: 12px; padding: 15px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle" style="color: var(--danger-red); font-size: 1.1rem;"></i>
        <ul style="margin: 5px 0 0 0; padding-right: 20px; color: #ffa8a8;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  @if($assignments->isEmpty())
    <div style="text-align: center; padding: 40px; background: rgba(255,255,255,0.05); border-radius: 15px;">
        <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--success-green); margin-bottom: 15px;"></i>
        <h3 style="margin: 0;">لا توجد تكاليف مطلوبة حالياً</h3>
        <p style="color: #aaa; margin-top: 10px;">أنت على إطلاع بكافة المهام الدراسية الخاصة بك.</p>
    </div>
  @else
    @foreach($assignments as $assignment)
        @php
            $submission = $assignment->submissions->first();
            $statusStr = $submission ? $submission->status : 'pending';
            
            $statusData = [
                'pending' => ['class' => 'status-pending', 'label' => 'قيد الانتظار', 'icon' => 'fa-clock'],
                'submitted' => ['class' => 'status-submitted', 'label' => 'مقدّم', 'icon' => 'fa-check'],
                'late' => ['class' => 'status-late', 'label' => 'تأخير', 'icon' => 'fa-exclamation-triangle'],
                'graded' => ['class' => 'status-graded', 'label' => 'تم التقييم', 'icon' => 'fa-star']
            ];
            
            $currentStatus = $statusData[$statusStr];
            $isPastDue = \Carbon\Carbon::parse($assignment->due_date)->isPast() && !$submission;
            if ($isPastDue) {
                $currentStatus = ['class' => 'status-late', 'label' => 'متأخر جداً', 'icon' => 'fa-times-circle'];
            }
        @endphp
        
        <div class="assignment-card">
            <div class="assignment-header">
                <div class="assignment-title">
                    <i class="fas fa-book"></i> {{ $assignment->title }}
                </div>
                <div class="status-badge {{ $currentStatus['class'] }}">
                    <i class="fas {{ $currentStatus['icon'] }}"></i> {{ $currentStatus['label'] }}
                </div>
            </div>
            
            <div class="assignment-meta">
                <span><i class="fas fa-calendar-alt"></i> آخر موعد: <span dir="ltr">{{ \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d H:i') }}</span></span>
                <span><i class="fas fa-star"></i> الدرجة: {{ $assignment->max_grade }}</span>
                <span><i class="fas fa-chalkboard"></i> الفصل: {{ optional($assignment->classRoom)->classes_name ?? '' }}</span>
            </div>
            
            <div class="assignment-desc" style="margin-top: 15px;">
                {{ $assignment->description }}
            </div>

            @if($assignment->attachments->isNotEmpty())
                <div class="attachments">
                    <div style="font-size: 0.85rem; color: #aaa; margin-bottom: 5px;">مرفقات المعلم:</div>
                    @foreach($assignment->attachments as $attachment)
                        <a href="{{ route('shared.download.attachment', $attachment->id) }}" class="attachment-link">
                            <i class="fas fa-file-download"></i> {{ $attachment->file_name }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if($statusStr === 'graded')
                <div class="attachments" style="border-color: var(--neon-purple); background: rgba(157, 80, 187, 0.1);">
                    <div style="color: var(--neon-purple); font-weight: bold; margin-bottom: 5px;">
                        <i class="fas fa-award"></i> الدرجة المكتسبة: {{ $submission->grade }} / {{ $assignment->max_grade }}
                    </div>
                    @if($submission->teacher_comment)
                        <div style="color: #ccc; font-size: 0.95rem;">
                            <strong>ملاحظة المعلم:</strong> {{ $submission->teacher_comment }}
                        </div>
                    @endif
                </div>
            @else
                <!-- Form to submit or update -->
                <div class="submit-area">
                    <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--neon-blue);">
                        {{ $submission ? 'تحديث التسليم' : 'تسليم التكليف' }}
                    </h4>
                    
                    <form action="{{ route('student.assignment.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>النص (ملاحظاتك أو إجابتك النصية):</label>
                            <textarea name="content" class="form-control" rows="3" placeholder="أدخل إجابتك هنا...">{{ $submission ? optional($submission->versions->last())->content : '' }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>مرفق ملف (اختياري):</label>
                            @if($submission && optional($submission->versions->last())->file_path)
                                <div style="margin-bottom: 10px; font-size: 0.85rem;">
                                    <a href="{{ route('shared.download.submission', $submission->versions->last()->id) }}" style="color: var(--success-green); text-decoration: none;">
                                        <i class="fas fa-paperclip"></i> لقد قمت برفع ملف مسبقاً (انقر للتحميل). رفع ملف جديد سيقوم باستبداله للمقّيم.
                                    </a>
                                </div>
                            @endif
                            <div class="file-upload">
                                <input type="file" name="file" id="file_{{ $assignment->id }}">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 1.5rem; color: #aaa; margin-bottom: 8px;"></i>
                                <span id="filename_{{ $assignment->id }}" style="color: #ccc; font-size: 0.9rem;">اضغط هنا لرفع ملفك المستكمل</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> {{ $submission ? 'حفظ التعديلات' : 'إرسال التكليف' }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @endforeach
  @endif

  <div class="footer-actions">
    <a href="{{ route('test.results') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-right"></i> العودة للنتائج
    </a>
  </div>
</div>

<script>
// Logic to display selected file name
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'اضغط هنا لرفع ملفك المستكمل';
        document.getElementById('filename_' + this.id.split('_')[1]).innerText = fileName;
    });
});
</script>

@include('student.partials.chatbot')
</body>
</html>
