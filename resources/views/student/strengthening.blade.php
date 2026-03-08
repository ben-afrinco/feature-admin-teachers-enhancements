<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تحسين المستوى - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

/* Summary / Analysis */
.level-info{
  background:rgba(255,255,255,0.04);
  border-radius:20px;
  padding:18px;
  margin:20px 0 26px;
  border-right:4px solid var(--warning-orange);
  text-align:right;
}
.level-info h3{
  color:var(--warning-orange);
  margin:0 0 10px;
  font-size:1.25rem;
  display:flex;
  align-items:center;
  gap:10px;
  font-weight:900;
}
.level-info .row{
  display:flex;
  flex-direction:column;
  gap:8px;
}
.level-info .item{
  margin:0;
  color:#ddd;
  display:flex;
  align-items:flex-start;
  gap:10px;
  line-height:1.6;
  font-weight:700;
}
.level-info .item i{ margin-top:3px; }

/* Weekly goal */
.goal{
  margin-top:14px;
  padding:14px 14px;
  border-radius:18px;
  border:1px solid rgba(0,198,255,0.22);
  background:rgba(0,198,255,0.08);
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  flex-wrap:wrap;
}
.goal strong{
  color:#cfefff;
  font-weight:900;
}
.goal span{
  color:rgba(255,255,255,0.80);
  font-weight:700;
}

/* Skills grid */
.skills-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(210px, 1fr));
  gap:18px;
  margin-bottom:22px;
}

.skill-card{
  background:rgba(255,255,255,0.05);
  border-radius:20px;
  padding:22px 18px;
  text-align:center;
  transition:var(--transition);
  border:1px solid rgba(255,255,255,0.10);
  text-decoration:none;
  color:inherit;
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:12px;
  position:relative;
  overflow:hidden;
}
.skill-card:hover{
  transform:translateY(-8px);
  background:rgba(0,198,255,0.05);
  border-color:rgba(0,198,255,0.35);
  box-shadow:0 15px 30px rgba(0,198,255,0.18);
}

.skill-icon{
  font-size:2.35rem;
  color:var(--neon-blue);
}

/* status tags */
.skill-status{
  font-size:0.85rem;
  padding:6px 14px;
  border-radius:999px;
  background:rgba(255,255,255,0.10);
  font-weight:900;
  color:rgba(255,255,255,0.85);
}

/* completed / weak styles */
.skill-card.completed{
  border-color:rgba(16,185,129,0.22);
}
.skill-card.completed:hover{
  border-color:rgba(16,185,129,0.45);
  box-shadow:0 15px 30px rgba(16,185,129,0.18);
}
.skill-card.completed .skill-status{
  background:rgba(16,185,129,0.16);
  color:#b7ffdf;
}

.skill-card.weak{
  border-color:rgba(239,68,68,0.22);
}
.skill-card.weak:hover{
  border-color:rgba(239,68,68,0.45);
  box-shadow:0 15px 30px rgba(239,68,68,0.18);
}
.skill-card.weak .skill-status{
  background:rgba(239,68,68,0.16);
  color:#ffd0d0;
}
.skill-card.weak .skill-icon{
  color:var(--danger-red);
}

.skill-title{
  font-size:1.15rem;
  font-weight:900;
}

/* Progress bar inside card */
.progress-wrap{
  width:100%;
  margin-top:2px;
}
.progress-bar{
  width:100%;
  height:10px;
  border-radius:999px;
  background:rgba(255,255,255,0.08);
  border:1px solid rgba(255,255,255,0.10);
  overflow:hidden;
}
.progress-bar > span{
  display:block;
  height:100%;
  width:0%;
  background:linear-gradient(90deg, var(--neon-blue), #0072ff);
  border-radius:999px;
}
.skill-card.completed .progress-bar > span{
  background:linear-gradient(90deg, var(--success-green), #0da271);
}
.skill-card.weak .progress-bar > span{
  background:linear-gradient(90deg, var(--danger-red), #ff4b2b);
}
.progress-meta{
  margin-top:8px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:0.85rem;
  color:rgba(255,255,255,0.75);
  font-weight:800;
}

/* Footer */
.footer-actions{
  margin-top:12px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:14px;
  flex-wrap:wrap;
}
.hint{
  color:#9aa6b2;
  font-size:0.95rem;
  font-weight:700;
  margin:0;
}

.btn{
  padding:12px 22px;
  border-radius:999px;
  font-weight:900;
  text-decoration:none;
  transition:var(--transition);
  display:inline-flex;
  align-items:center;
  gap:10px;
  font-family:inherit;
  border:none;
  cursor:pointer;
  white-space:nowrap;
}
.btn-secondary{
  background:rgba(255,255,255,0.10);
  color:#fff;
  border:1px solid rgba(255,255,255,0.14);
}
.btn-secondary:hover{
  background:rgba(255,255,255,0.16);
}
.btn-primary{
  background:linear-gradient(90deg, #f59e0b, #d97706);
  color:#fff;
  box-shadow:0 10px 20px rgba(245,158,11,0.28);
}
.btn-primary:hover{
  transform:translateY(-1px);
  box-shadow:0 14px 26px rgba(245,158,11,0.35);
}

/* ✅ Sticky footer button on mobile */
.sticky-mobile{
  display:none;
}

@media (max-width: 600px){
  .container{ padding:24px; border-radius:22px; }
  .header h1{ font-size:2rem; }
  .footer-actions{ justify-content:center; }
  .hint{ text-align:center; width:100%; }

  .sticky-mobile{
    display:flex;
    position:fixed;
    bottom:14px;
    left:14px;
    right:14px;
    z-index:999;
    gap:10px;
    justify-content:center;
  }
  .sticky-mobile .btn{
    flex:1;
    justify-content:center;
    padding:12px 16px;
  }
}
</style>
</head>

<body>
<div class="light-blob blob-1"></div>
<div class="light-blob blob-2"></div>

@php
  // ✅ قراءة الدرجات (تشتغل لو جت من controller: $scores)
  $reading   = (int) (($scores['reading'] ?? 0));
  $listening = (int) (($scores['listening'] ?? 0));
  $writing   = (int) (($scores['writing'] ?? 0));
  $speaking  = (int) (($scores['speaking'] ?? 0));

  // ✅ لو ما عندك $scores في الكنترولر، تقدرين مؤقتاً تشيلين السطرين الجايين أو تخليهم
  // مثال fallback من session (اختياري):
  // $reading   = $reading   ?: (int) session('scores.reading', 0);
  // $listening = $listening ?: (int) session('scores.listening', 0);
  // $writing   = $writing   ?: (int) session('scores.writing', 0);
  // $speaking  = $speaking  ?: (int) session('scores.speaking', 0);

  // ✅ Threshold لتصنيف المهارة
  $THRESHOLD = 70;

  function levelText($p){
    if ($p >= 90) return 'ممتاز';
    if ($p >= 80) return 'جيد جدًا';
    if ($p >= 70) return 'جيد';
    if ($p >= 55) return 'متوسط';
    return 'يحتاج تقوية';
  }

  $skills = [
    [
      'key' => 'reading',
      'title' => 'القراءة',
      'icon' => 'fa-book-open',
      'route' => route('practice.readings'),
      'score' => $reading,
    ],
    [
      'key' => 'listening',
      'title' => 'الاستماع',
      'icon' => 'fa-headphones',
      'route' => route('practice.listenings'),
      'score' => $listening,
    ],
    [
      'key' => 'writing',
      'title' => 'الكتابة',
      'icon' => 'fa-pen-nib',
      'route' => route('practice.writings'),
      'score' => $writing,
    ],
    [
      'key' => 'speaking',
      'title' => 'المحادثة',
      'icon' => 'fa-microphone-alt',
      'route' => route('practice.speakings'),
      'score' => $speaking,
    ],
  ];

  $completed = [];
  $needWork = [];

  foreach($skills as $s){
    if ($s['score'] >= $THRESHOLD) $completed[] = $s['title'];
    else $needWork[] = $s['title'];
  }

  // ✅ الهدف الأسبوعي: أضعف مهارة
  $weakest = $skills[0];
  foreach($skills as $s){
    if ($s['score'] < $weakest['score']) $weakest = $s;
  }
  $nextTarget = min(100, max($THRESHOLD, $weakest['score'] + 10));
@endphp

<div class="container">
  <div class="header">
    <h1><i class="fas fa-shield-alt"></i> خطة تحسين المستوى</h1>
    <p>بناءً على نتائجك الأخيرة، صممنا لك مسارات تدريبية ذكية لرفع كفاءتك في مهارات اللغة الإنجليزية.</p>
  </div>

  <div class="level-info">
    <h3><i class="fas fa-chart-bar"></i> تحليلك الأكاديمي الحالي</h3>

    <div class="row">
      <p class="item">
        <i class="fas fa-check-circle" style="color: var(--success-green);"></i>
        <span>المهارات المكتملة: <b>{{ count($completed) ? implode('، ', $completed) : '—' }}</b></span>
      </p>

      <p class="item">
        <i class="fas fa-exclamation-circle" style="color: var(--danger-red);"></i>
        <span>مهارات تحتاج لتقوية: <b>{{ count($needWork) ? implode('، ', $needWork) : '—' }}</b></span>
      </p>
    </div>

    <div class="goal">
      <div>
        <strong><i class="fas fa-bullseye"></i> هدف هذا الأسبوع:</strong>
        <span>رفع <b>{{ $weakest['title'] }}</b> إلى <b>{{ $nextTarget }}%</b> على الأقل</span>
      </div>

      <a class="btn btn-primary" href="{{ $weakest['route'] }}">
        <i class="fas fa-play"></i> ابدأ الآن
      </a>
    </div>
  </div>

  <div class="skills-grid">
    @foreach($skills as $s)
      @php
        $statusClass = ($s['score'] >= $THRESHOLD) ? 'completed' : 'weak';
        $label = levelText($s['score']);
        $w = max(0, min(100, (int)$s['score']));
      @endphp

      <a href="{{ $s['route'] }}" class="skill-card {{ $statusClass }}">
        <i class="fas {{ $s['icon'] }} skill-icon"></i>

        <span class="skill-title">{{ $s['title'] }}</span>

        <span class="skill-status">{{ $label }} ({{ $w }}%)</span>

        <div class="progress-wrap">
          <div class="progress-bar" aria-label="progress">
            <span style="width: {{ $w }}%;"></span>
          </div>
          <div class="progress-meta">
            <span>تقدّمك</span>
            <span>{{ $w }}%</span>
          </div>
        </div>
      </a>
    @endforeach
  </div>

  <div class="footer-actions">
    <a href="{{ route('test.results') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-right"></i> العودة للنتائج
    </a>

    <p class="hint">اختر مهارة للبدء في التدريب المخصص حسب نتيجتك.</p>
  </div>
</div>

<!-- ✅ Sticky on mobile -->
<div class="sticky-mobile">
  <a href="{{ route('test.results') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-right"></i> النتائج
  </a>
  <a href="{{ $weakest['route'] }}" class="btn btn-primary">
    <i class="fas fa-play"></i> ابدأ الآن
  </a>
</div>

@include('student.partials.chatbot')
</body>
</html>