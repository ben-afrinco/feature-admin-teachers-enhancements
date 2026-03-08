<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Writing Details</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
  --bg:#000c1d;
  --card: rgba(255,255,255,0.085);
  --stroke: rgba(255,255,255,0.16);
  --text:#ffffff;
  --muted: rgba(255,255,255,0.72);
  --muted2: rgba(255,255,255,0.60);
  --brand1:#00c6ff;
  --brand2:#0086ff;

  --ok:#10b981;
  --bad:#ef4444;
  --warn:#f59e0b;

  --shadow: 0 18px 55px rgba(0,180,255,0.22);
  --radius: 26px;
}

*{ box-sizing:border-box; }

body{
  margin:0;
  min-height:100vh;
  background:
    radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.16), transparent 60%),
    radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.12), transparent 55%),
    var(--bg);
  font-family:"Poppins","Tajawal",Arial,sans-serif;
  color:var(--text);
  padding: 96px 18px 22px;
  overflow:hidden; /* ✅ سكرول فقط داخل المحتوى */
  position:relative;
}

.light{
  position: fixed;
  width: 720px;
  height: 720px;
  background: radial-gradient(circle, rgba(0,200,255,0.18), rgba(0,0,0,0));
  filter: blur(95px);
  z-index:-1;
  opacity: .70;
  animation: moveLightSoft 10s infinite alternate ease-in-out;
}
@keyframes moveLightSoft{
  0%   { top:-210px; left:-200px; transform: scale(1); }
  50%  { top:42%; left:62%; transform: translate(-50%,-50%) scale(1.03); }
  100% { top:92%; left:-160px; transform: scale(1); }
}

/* ✅ Topbar ثابت */
.topbar{
  position: fixed;
  top: 14px;
  left: 18px;
  right: 18px;
  z-index: 999;
}
.topbar-inner{
  max-width: 1000px;
  margin: 0 auto;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
  padding: 12px 14px;
  border-radius: 18px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.07);
  backdrop-filter: blur(16px);
  box-shadow: 0 18px 55px rgba(0,180,255,0.10);
  flex-wrap: wrap;
}
.title{
  margin:0;
  font-size: 14.5px;
  font-weight: 900;
  letter-spacing:.2px;
  color:#eafcff;
  display:flex;
  align-items:center;
  gap:10px;
}
.pills{
  display:flex;
  gap: 10px;
  flex-wrap: wrap;
}
.pill{
  padding: 8px 12px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(0,0,0,0.18);
  color: var(--muted);
  font-weight: 800;
  font-size: 12.5px;
  display:flex;
  align-items:center;
  gap:8px;
}

/* ✅ Shell */
.shell{
  max-width: 1000px;
  margin: 0 auto;
  height: calc(100vh - 96px - 22px);
}

/* ✅ Scroll area */
.scroll{
  height: 100%;
  overflow:auto;
  padding: 0;
}
.scroll::-webkit-scrollbar{ width: 10px; }
.scroll::-webkit-scrollbar-thumb{
  background: rgba(255,255,255,0.18);
  border-radius: 999px;
}
.scroll::-webkit-scrollbar-track{
  background: rgba(0,0,0,0.10);
}

.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
  margin-bottom: 16px;
}

.card-head{
  padding: 16px 18px;
  border-bottom: 1px solid rgba(255,255,255,0.10);
  background: rgba(0,0,0,0.10);
}
.card-head h2{
  margin:0;
  font-size: 14.5px;
  font-weight: 900;
  color: #eafcff;
}
.card-head p{
  margin: 6px 0 0;
  font-size: 13px;
  color: var(--muted2);
  line-height: 1.6;
}

.card-pad{ padding: 18px; }

textarea{
  width: 100%;
  min-height: 220px;
  background: rgba(0,0,0,0.16);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 22px;
  padding: 16px 16px;
  color: rgba(255,255,255,0.90);
  font-size: 14.5px;
  line-height: 1.8;
  font-family: inherit;
  resize: none;
  outline: none;
}

/* Errors list */
.err-list{
  display:flex;
  flex-direction:column;
  gap: 12px;
}

.err{
  padding: 14px;
  border-radius: 20px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
}

.err-top{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}

.err-badge{
  font-size: 11.5px;
  font-weight: 900;
  padding: 6px 10px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color: rgba(255,255,255,0.85);
}

.err-badge.grammar{ border-color: rgba(245,158,11,0.40); background: rgba(245,158,11,0.10); color: #ffe2b1; }
.err-badge.spelling{ border-color: rgba(239,68,68,0.40); background: rgba(239,68,68,0.10); color: #ffd0d0; }
.err-badge.style{ border-color: rgba(0,198,255,0.40); background: rgba(0,198,255,0.10); color: #cfefff; }

.row{
  display:flex;
  flex-direction:column;
  gap: 8px;
}

.label{
  font-weight: 900;
  font-size: 12.5px;
  color: rgba(255,255,255,0.85);
  display:flex;
  align-items:center;
  gap: 8px;
}

.box{
  border-radius: 16px;
  padding: 12px 12px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  color: rgba(255,255,255,0.86);
  line-height: 1.7;
  font-size: 13.5px;
}

.box.bad{
  border-color: rgba(239,68,68,0.35);
  background: rgba(239,68,68,0.10);
}
.box.ok{
  border-color: rgba(16,185,129,0.35);
  background: rgba(16,185,129,0.10);
}

.explain{
  margin-top: 10px;
  font-size: 13px;
  color: rgba(255,255,255,0.74);
  line-height: 1.7;
}

.footer-actions{
  position: sticky;
  bottom: 0;
  padding: 12px 0 10px;
  margin-top: 12px;
  background: linear-gradient(to top, rgba(0,0,0,0.28), rgba(0,0,0,0));
  display:flex;
  gap:10px;
  justify-content:center;
  flex-wrap: wrap;
}

.btn2{
  border:none;
  color:#fff;
  padding: 12px 18px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 13.5px;
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
  text-decoration:none;
  display:inline-flex;
  align-items:center;
  gap:10px;
  justify-content:center;
}
.btn2:hover{ transform: translateY(-1px); }

.btn-primary{
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  box-shadow: 0 10px 24px rgba(0,200,255,0.20);
}
.btn-secondary{
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.14);
}

@media (max-width: 980px){
  body{
    overflow:auto;
    padding-top: 110px;
  }
  .shell{ height: auto; }
  .scroll{ height: auto; overflow: visible; }
  .footer-actions{ position: static; background: none; padding: 0; }
}
</style>
</head>

<body>
<div class="light"></div>

@php
  // ✅ بيانات حقيقية من قاعدة البيانات
  $text = $studentText ?? '';
  $feedback = $aiFeedback ?? '';
  $score = $aiScore ?? 0;
  $finalScore = $dbScore ?? 0;

  // Try parsing structured feedback (JSON with criteria)
  $criteriaData = null;
  $feedbackText = $feedback;
  $parsedFeedback = json_decode($feedback, true);
  if (json_last_error() === JSON_ERROR_NONE && isset($parsedFeedback['criteria'])) {
    $criteriaData = $parsedFeedback['criteria'];
    $feedbackText = $parsedFeedback['feedback'] ?? '';
  }

  // Build corrections from feedback
  $corrections = [];
  if (!empty($feedbackText) && $feedbackText !== 'AI evaluation is temporarily unavailable due to rate limits. Your response has been saved and a teacher can review it later.') {
    $corrections = [
      [
        'type' => 'style',
        'title' => 'AI Feedback',
        'wrong' => 'See AI analysis below',
        'right' => $feedbackText,
        'explain' => 'Score: ' . $score . '%',
      ],
    ];
  } elseif (!empty($feedbackText)) {
    $corrections = [
      [
        'type' => 'style',
        'title' => 'AI Status',
        'wrong' => 'Evaluation pending',
        'right' => $feedbackText,
        'explain' => 'A teacher can review and provide manual feedback.',
      ],
    ];
  }

  $wordCount = str_word_count($text ?: 'No text submitted.');
  $mistakes = count($corrections);

  // Criteria labels
  $criteriaLabels = [
    'task_achievement' => ['en' => 'Task Achievement', 'icon' => 'fa-bullseye', 'color' => '#00c6ff'],
    'coherence' => ['en' => 'Coherence & Cohesion', 'icon' => 'fa-link', 'color' => '#10b981'],
    'vocabulary' => ['en' => 'Lexical Resource', 'icon' => 'fa-book', 'color' => '#f59e0b'],
    'grammar' => ['en' => 'Grammar & Accuracy', 'icon' => 'fa-spell-check', 'color' => '#a855f7'],
  ];
@endphp

<div class="topbar">
  <div class="topbar-inner">
    <h1 class="title"><i class="fa-solid fa-pen-nib"></i> تفاصيل الكتابة • Writing Details</h1>

    <div class="pills">
      <div class="pill"><i class="fa-solid fa-font"></i> Words: {{ $wordCount }}</div>
      <div class="pill"><i class="fa-solid fa-gauge-high"></i> Score: {{ $finalScore }}%</div>
      <div class="pill"><i class="fa-solid fa-circle-info"></i> Red = Wrong • Green = Correct</div>
    </div>
  </div>
</div>

<div class="shell">
  <div class="scroll">

    <!-- ✅ Student Answer -->
    <div class="card">
      <div class="card-head">
        <h2>Your Answer</h2>
        <p>Read-only view of what you wrote.</p>
      </div>
      <div class="card-pad">
        <textarea readonly>{{ $text ?: 'No text submitted yet.' }}</textarea>
      </div>
    </div>

    <!-- ✅ Writing Criteria (4 International) -->
    @if($criteriaData)
    <div class="card">
      <div class="card-head">
        <h2><i class="fa-solid fa-chart-bar"></i> Writing Criteria Assessment</h2>
        <p>Evaluated on 4 international writing standards (each 0-25 points).</p>
      </div>
      <div class="card-pad">
        <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:14px;">
          @foreach($criteriaLabels as $key => $meta)
            @php $val = $criteriaData[$key] ?? 0; $pct = ($val / 25) * 100; @endphp
            <div style="padding:16px; border-radius:20px; border:1px solid rgba(255,255,255,0.12); background:rgba(0,0,0,0.10);">
              <div style="display:flex; align-items:center; gap:8px; font-weight:900; font-size:12.5px; color:{{ $meta['color'] }};">
                <i class="fa-solid {{ $meta['icon'] }}"></i> {{ $meta['en'] }}
              </div>
              <div style="margin-top:10px; font-size:22px; font-weight:900; color:#eafcff;">{{ $val }}<span style="font-size:13px; color:rgba(255,255,255,0.55);">/25</span></div>
              <div style="margin-top:8px; height:8px; border-radius:999px; background:rgba(255,255,255,0.10); overflow:hidden;">
                <div style="width:{{ $pct }}%; height:100%; border-radius:999px; background:{{ $meta['color'] }}; transition:width .6s ease;"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    <!-- ✅ Corrections -->
    <div class="card">
      <div class="card-head">
        <h2>Corrections & Explanations</h2>
        <p>We highlight mistakes and explain how to fix them.</p>
      </div>

      <div class="card-pad">
        <div class="err-list">

          @forelse($corrections as $c)
            <div class="err">
              <div class="err-top">
                <div class="err-badge {{ $c['type'] }}">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                  {{ $c['title'] }}
                </div>
              </div>

              <div class="row">
                <div class="label"><i class="fa-solid fa-xmark" style="color: rgba(239,68,68,0.95);"></i> Wrong</div>
                <div class="box bad">{{ $c['wrong'] }}</div>
              </div>

              <div class="row" style="margin-top:10px;">
                <div class="label"><i class="fa-solid fa-check" style="color: rgba(16,185,129,0.95);"></i> Correct</div>
                <div class="box ok">{{ $c['right'] }}</div>
              </div>

              <div class="explain">
                <i class="fa-solid fa-circle-info"></i>
                {{ $c['explain'] }}
              </div>
            </div>
          @empty
            <div class="err">
              <div class="explain" style="margin:0;">
                <i class="fa-solid fa-check" style="color: rgba(16,185,129,0.95);"></i>
                No issues found. Great job!
              </div>
            </div>
          @endforelse

          <!-- ✅ زر الرجوع للنتائج ثابت تحت -->
          <div class="footer-actions">
            <a class="btn2 btn-secondary" href="{{ route('test.results') }}">
              <i class="fa-solid fa-arrow-right"></i> الرجوع للنتائج
            </a>
            <a class="btn2 btn-primary" href="{{ route('test.strengthening') }}">
              <i class="fa-solid fa-shield-halved"></i> ابدأ خطة التقوية
            </a>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

@include('student.partials.chatbot')
</body>
</html>