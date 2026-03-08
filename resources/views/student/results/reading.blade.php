<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reading Details</title>

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
  --you:#f59e0b;

  --shadow: 0 18px 55px rgba(0,180,255,0.22);
  --radius: 26px;
}

*{ box-sizing:border-box; }

body{
  margin:0;
  min-height:100vh;
  background:
    radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.18), transparent 60%),
    radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.14), transparent 55%),
    var(--bg);
  font-family:"Poppins","Tajawal",Arial,sans-serif;
  color:var(--text);
  padding: 96px 18px 22px; /* مساحة للتوب بار */
  overflow:hidden; /* ✅ مهم: يمنع سكرول الصفحة */
  position:relative;
}

.light{
  position: fixed;
  width: 620px;
  height: 620px;
  background: radial-gradient(circle, rgba(0,200,255,0.28), rgba(0,0,0,0));
  animation: moveLight 7s infinite alternate ease-in-out;
  filter: blur(70px);
  z-index:-1;
}
@keyframes moveLight {
  0% { top: -180px; left: -160px; }
  50% { top: 35%; left: 55%; transform: translate(-50%, -50%); }
  100% { top: 85%; left: -120px; }
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
  max-width: 1200px;
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

/* ✅ Shell ارتفاع ثابت */
.shell{
  max-width: 1200px;
  margin: 0 auto;
  height: calc(100vh - 96px - 22px);
}

/* ✅ Grid نفس ارتفاع الشل */
.grid{
  height: 100%;
  display:grid;
  grid-template-columns: 1.05fr 0.95fr;
  gap: 16px;
  align-items: stretch;
}

/* Cards */
.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
  min-height: 0; /* ✅ مهم مع السكروول */
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

/* ✅ Passage ثابت (بدون سكرول) */
.passage{
  font-size: 14.5px;
  line-height: 1.9;
  color: rgba(255,255,255,0.88);
}
.passage h3{
  margin: 0 0 10px;
  font-size: 14px;
  color: #cfefff;
}
.passage p{
  margin: 10px 0;
  color: rgba(255,255,255,0.80);
}

/* ✅ Questions scroll area فقط */
.qscroll{
  height: 100%;
  overflow:auto;
  padding: 18px;
}
.qscroll::-webkit-scrollbar{ width: 10px; }
.qscroll::-webkit-scrollbar-thumb{
  background: rgba(255,255,255,0.18);
  border-radius: 999px;
}
.qscroll::-webkit-scrollbar-track{
  background: rgba(0,0,0,0.10);
}

.qwrap{
  display:flex;
  flex-direction:column;
  gap: 14px;
}
.qbox{
  padding: 16px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
  border-radius: 22px;
}
.qtitle{
  margin:0 0 12px;
  font-weight: 900;
  font-size: 13.5px;
  color:#eafcff;
  display:flex;
  justify-content: space-between;
  align-items:flex-start;
  gap:10px;
}

.badge{
  font-size: 11.5px;
  font-weight: 900;
  padding: 6px 10px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color: rgba(255,255,255,0.85);
  white-space: nowrap;
}
.badge.ok{ border-color: rgba(16,185,129,0.35); background: rgba(16,185,129,0.10); color: #b7ffdf; }
.badge.bad{ border-color: rgba(239,68,68,0.35); background: rgba(239,68,68,0.10); color: #ffd0d0; }

.option{
  display:flex;
  align-items:center;
  gap:10px;
  padding: 12px 12px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  margin-bottom: 10px;
  position: relative;
}
.option:last-child{ margin-bottom:0; }
.option .dot{
  width: 18px;
  height: 18px;
  border-radius: 50%;
  border: 2px solid rgba(255,255,255,0.35);
  flex: 0 0 auto;
}
.option span{
  font-size: 13.5px;
  color: rgba(255,255,255,0.82);
}

/* ✅ التلوين */
.option.you{
  border-color: rgba(245,158,11,0.45);
  background: rgba(245,158,11,0.10);
}
.option.you .dot{ border-color: rgba(245,158,11,0.95); }

.option.correct{
  border-color: rgba(16,185,129,0.45);
  background: rgba(16,185,129,0.10);
}
.option.correct .dot{ border-color: rgba(16,185,129,0.95); }

.option.wrong{
  border-color: rgba(239,68,68,0.45);
  background: rgba(239,68,68,0.10);
}
.option.wrong .dot{ border-color: rgba(239,68,68,0.95); }

.tag{
  margin-left: auto;
  font-size: 11px;
  font-weight: 900;
  padding: 5px 9px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(0,0,0,0.18);
  color: rgba(255,255,255,0.86);
}

.tag.you{ border-color: rgba(245,158,11,0.45); color: #ffe2b1; background: rgba(245,158,11,0.08); }
.tag.correct{ border-color: rgba(16,185,129,0.45); color: #c7ffe6; background: rgba(16,185,129,0.08); }

.note{
  margin-top: 10px;
  font-size: 12.5px;
  color: rgba(255,255,255,0.70);
  line-height: 1.6;
}

/* AI Explain */
.explain-btn{
  margin-top: 10px;
  display: inline-flex;
  align-items:center;
  gap:8px;
  padding: 8px 14px;
  border-radius: 14px;
  border: 1px solid rgba(168,85,247,0.35);
  background: rgba(168,85,247,0.10);
  color: #d8b4fe;
  font-weight: 800;
  font-size: 12px;
  cursor:pointer;
  transition: .2s;
}
.explain-btn:hover{ background: rgba(168,85,247,0.18); }
.explain-btn:disabled{ opacity: .5; cursor: not-allowed; }
.explain-box{
  margin-top: 10px;
  padding: 14px;
  border-radius: 16px;
  border: 1px solid rgba(168,85,247,0.25);
  background: rgba(168,85,247,0.06);
  color: rgba(255,255,255,0.88);
  font-size: 13px;
  line-height: 1.75;
  display: none;
  white-space: pre-wrap;
}

/* ✅ أزرار ثابتة داخل صندوق الأسئلة */
.footer-actions{
  position: sticky;
  bottom: 0;
  padding: 12px 0 6px;
  margin-top: 10px;
  background: linear-gradient(to top, rgba(0,0,0,0.22), rgba(0,0,0,0));
  display:flex;
  gap:10px;
  justify-content:center;
  flex-wrap: wrap;
}

.btn{
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
.btn:hover{ transform: translateY(-1px); }

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
    overflow:auto; /* على الجوال نخلي الصفحة تسكرول */
    padding-top: 110px;
  }
  .shell{ height: auto; }
  .grid{ grid-template-columns: 1fr; height:auto; }
  .qscroll{ height: auto; overflow: visible; padding: 18px; }
}
</style>
</head>

<body>
<div class="light"></div>

@php
  // ✅ بيانات حقيقية من الجلسة
  $answers = $studentAnswers ?? [];

  $correct = [
    'q1' => 'a',
    'q2' => 'a',
    'q3' => 'a',
    'q4' => 'a',
    'q5' => 'a',
    'q6' => 'a',
    'q7' => 'a',
    'q8' => 'a',
    'q9' => 'a',
    'q10'=> 'a',
  ];

  $questions = [
    ['key'=>'q1','q'=>'1) When did the writer go to the park?','options'=>['a'=>'On Saturday morning','b'=>'On Friday night','c'=>'On Sunday afternoon','d'=>'On Monday morning']],
    ['key'=>'q2','q'=>'2) Who went with the writer?','options'=>['a'=>'The writer’s sister','b'=>'The writer’s teacher','c'=>'The writer’s father','d'=>'The writer’s friend']],
    ['key'=>'q3','q'=>'3) What was the weather like?','options'=>['a'=>'Sunny and warm','b'=>'Cold and rainy','c'=>'Windy and snowy','d'=>'Dark and stormy']],
    ['key'=>'q4','q'=>'4) What did they eat?','options'=>['a'=>'Sandwiches','b'=>'Pizza','c'=>'Soup','d'=>'Rice']],
    ['key'=>'q5','q'=>'5) Where did they sit?','options'=>['a'=>'On a bench','b'=>'On the grass','c'=>'On a bus','d'=>'In a car']],
    ['key'=>'q6','q'=>'6) What did they see at the lake?','options'=>['a'=>'Ducks swimming','b'=>'Fish jumping','c'=>'Boats racing','d'=>'Dogs running']],
    ['key'=>'q7','q'=>'7) What did the sister do?','options'=>['a'=>'She took photos','b'=>'She bought flowers','c'=>'She played football','d'=>'She cooked dinner']],
    ['key'=>'q8','q'=>'8) What did the writer feed the ducks?','options'=>['a'=>'Small pieces of bread','b'=>'Rice','c'=>'Ice cream','d'=>'Chocolate']],
    ['key'=>'q9','q'=>'9) What did they buy in the afternoon?','options'=>['a'=>'Ice cream','b'=>'Milk','c'=>'Books','d'=>'Water']],
    ['key'=>'q10','q'=>'10) What time did they go home?','options'=>['a'=>"At 5 o’clock",'b'=>"At 7 o’clock",'c'=>"At 9 o’clock",'d'=>"At 12 o’clock"]],
  ];

  $total = count($questions);
  $score = 0;
  foreach($questions as $qq){
    $k = $qq['key'];
    if(($answers[$k] ?? null) === ($correct[$k] ?? null)) $score++;
  }
  $percent = isset($dbScore) && $dbScore > 0 ? $dbScore : (int) round(($score / max($total,1)) * 100);
@endphp

<div class="topbar">
  <div class="topbar-inner">
    <h1 class="title"><i class="fa-solid fa-book-open"></i> تفاصيل القراءة • Reading Details</h1>

    <div class="pills">
      <div class="pill"><i class="fa-solid fa-list-check"></i> Questions: {{ $total }}</div>
      <div class="pill"><i class="fa-solid fa-bullseye"></i> Score: {{ $score }}/{{ $total }} ({{ $percent }}%)</div>
      <div class="pill"><i class="fa-solid fa-circle-info"></i> <span style="color:#ffe2b1;font-weight:900;">Your choice</span> • <span style="color:#c7ffe6;font-weight:900;">Correct</span></div>
    </div>
  </div>
</div>

<div class="shell">
  <div class="grid">

    <!-- ✅ Left: Passage ثابت -->
    <div class="card">
      <div class="card-head">
        <h2>Passage</h2>
        
      </div>
      <div class="card-pad passage">
        <h3>My Day at the Park</h3>

        <p>
          On Saturday morning, I went to the park with my sister. The weather was sunny and warm.
          We walked on a small path and saw many trees and flowers.
        </p>

        <p>
          At the park, we sat on a bench and ate sandwiches. After that, we watched children play.
          Some children were riding bikes, and some were playing football.
        </p>

        <p>
          Then we went to the lake. We saw ducks swimming in the water.
          My sister took photos, and I fed the ducks small pieces of bread.
        </p>

        <p>
          In the afternoon, we bought ice cream. We were happy, but we were tired.
          Finally, we went home at 5 o’clock.
        </p>
      </div>
    </div>

    <!-- ✅ Right: Questions scroll -->
    <div class="card">
      <div class="card-head">
        <h2>Answers Review</h2>
        
      </div>

      <div class="qscroll">
        <div class="qwrap">

          @foreach($questions as $qq)
            @php
              $k = $qq['key'];
              $user = $answers[$k] ?? null;
              $right = $correct[$k] ?? null;
              $isCorrect = ($user !== null && $user === $right);
            @endphp

            <div class="qbox">
              <div class="qtitle">
                <span>{{ $qq['q'] }}</span>
                @if($user === null)
                  <span class="badge bad">No Answer</span>
                @elseif($isCorrect)
                  <span class="badge ok">Correct</span>
                @else
                  <span class="badge bad">Wrong</span>
                @endif
              </div>

              @foreach($qq['options'] as $optKey => $optText)
                @php
                  $classes = 'option';

                  if($user === $optKey){
                    $classes .= ' you';
                    if(!$isCorrect) $classes .= ' wrong';
                  }

                  if($right === $optKey){
                    $classes .= ' correct';
                  }

                  $tag = null;
                  $tagClass = null;

                  if($user === $optKey && $right === $optKey){
                    $tag = 'Your choice • Correct';
                    $tagClass = 'correct';
                  } elseif($user === $optKey && $right !== $optKey){
                    $tag = 'Your choice';
                    $tagClass = 'you';
                  } elseif($right === $optKey){
                    $tag = 'Correct answer';
                    $tagClass = 'correct';
                  }
                @endphp

                <div class="{{ $classes }}">
                  <div class="dot"></div>
                  <span>{{ strtoupper($optKey) }}) {{ $optText }}</span>
                  @if($tag)
                    <span class="tag {{ $tagClass }}">{{ $tag }}</span>
                  @endif
                </div>
              @endforeach

              @if($user !== null && !$isCorrect)
                <div class="note">
                  <i class="fa-solid fa-circle-exclamation" style="color: rgba(239,68,68,0.95);"></i>
                  Your answer was <b style="color:#ffd1d1;">{{ strtoupper($user) }}</b>.
                  The correct answer is <b style="color:#c7ffe6;">{{ strtoupper($right) }}</b>.
                </div>
                <button class="explain-btn" onclick="streamExplain(this, '{{ addslashes($qq['q']) }}', '{{ addslashes($qq['options'][$right] ?? '') }}', '{{ addslashes($qq['options'][$user] ?? '') }}')">
                  <i class="fa-solid fa-robot"></i> <span>🤖 AI Explain</span>
                </button>
                <div class="explain-box"></div>
              @endif

            </div>
          @endforeach

          <!-- ✅ أزرار ثابتة داخل السكروول -->
          <div class="footer-actions">
            <a class="btn btn-secondary" href="{{ route('test.results') }}">
              <i class="fa-solid fa-arrow-right"></i> Back to Results
            </a>
            <a class="btn btn-primary" href="{{ route('test.strengthening') }}">
              <i class="fa-solid fa-shield-halved"></i> Start Plan
            </a>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>

</div>

<script>
async function streamExplain(btn, question, correctAnswer, studentAnswer) {
  btn.disabled = true;
  btn.querySelector('span').textContent = '⏳ Loading...';
  const box = btn.nextElementSibling;
  box.style.display = 'block';
  box.textContent = '';

  try {
    const response = await fetch('{{ route("ollama.explain") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'text/event-stream'
      },
      body: JSON.stringify({ question, correct_answer: correctAnswer, student_answer: studentAnswer })
    });

    const reader = response.body.getReader();
    const decoder = new TextDecoder();
    let buffer = '';

    while (true) {
      const { done, value } = await reader.read();
      if (done) break;
      buffer += decoder.decode(value, { stream: true });

      const lines = buffer.split('\n');
      buffer = lines.pop();

      for (const line of lines) {
        if (line.startsWith('data: ')) {
          const payload = line.substring(6).trim();
          if (payload === '[DONE]') break;
          try {
            const json = JSON.parse(payload);
            if (json.token) box.textContent += json.token;
          } catch(e) {}
        }
      }
    }
  } catch(error) {
    box.textContent = 'AI explanation is temporarily unavailable.';
    console.error('Stream error:', error);
  }
  btn.querySelector('span').textContent = '✅ Done';
}
</script>

@include('student.partials.chatbot')
</body>
</html>