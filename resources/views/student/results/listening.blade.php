<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Listening Details</title>

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
    radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.16), transparent 60%),
    radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.12), transparent 55%),
    var(--bg);
  font-family:"Poppins","Tajawal",Arial,sans-serif;
  color:var(--text);
  padding: 96px 18px 22px; /* مساحة للتوب بار */
  overflow:hidden;          /* ✅ يمنع سكرول الصفحة */
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
  min-height: 0;
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

/* ✅ Player panel */
.player{
  display:flex;
  gap: 16px;
  align-items:center;
  padding: 18px;
}
.play-btn{
  width: 70px;
  height: 70px;
  border-radius: 999px;
  border: 1px solid rgba(0,198,255,0.35);
  background: rgba(0,198,255,0.14);
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
  user-select:none;
}
.play-btn:hover{
  transform: translateY(-1px);
  background: rgba(0,198,255,0.18);
  box-shadow: 0 16px 32px rgba(0,198,255,0.16);
}
.play-btn svg{
  width: 26px;
  height: 26px;
}
.player-meta{
  display:flex;
  flex-direction:column;
  gap: 6px;
}
.meta-line{
  color: rgba(255,255,255,0.86);
  font-weight: 800;
  font-size: 13px;
}
.time-line{
  font-weight: 900;
  letter-spacing: .2px;
}

/* ✅ Questions scroll area فقط */
.qscroll{
  height: 100%;
  overflow:auto;
  padding: 18px;
  scrollbar-width: thin;
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
  justify-content:space-between;
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

/* Options */
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
  margin-left:auto;
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

/* ✅ زر الرجوع ثابت أسفل السكروول */
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
    overflow:auto;
    padding-top: 110px;
  }
  .shell{ height: auto; }
  .grid{ grid-template-columns: 1fr; height:auto; }
  .qscroll{ height: auto; overflow: visible; padding: 18px; }
  .footer-actions{ position: static; background: none; padding: 0; }
}
</style>
</head>

<body>
<div class="light"></div>

@php
  // ✅ بيانات حقيقية من الجلسة
  $answers = $studentAnswers ?? [];

  $correct = [
    's1' => 'd', // الصحيح D
    's2' => 'a',
    's3' => 'a',
    's4' => 'a',
    's5' => 'a',
    's6' => 'a',
    's7' => 'a',
    's8' => 'a',
    's9' => 'a',
    's10'=> 'a',
  ];

  $questions = [
    ['key'=>'s1','q'=>'What is the best response to Speaker 1?','options'=>['a'=>'I went to the gym.','b'=>'It’s on Monday morning.','c'=>'Yes, I can.','d'=>'That’s a good idea.']],
    ['key'=>'s2','q'=>'What is the best response to Speaker 2?','options'=>['a'=>'I’m from Austria too.','b'=>'I don’t like cold weather.','c'=>'At five o’clock.','d'=>'That’s expensive.']],
    ['key'=>'s3','q'=>'What is the best response to Speaker 3?','options'=>['a'=>'Yes, please. I’ll have tea with milk.','b'=>'I’m going to a café later.','c'=>'I don’t eat breakfast.','d'=>'It was on the table.']],
    ['key'=>'s4','q'=>'What is the best response to Speaker 4?','options'=>['a'=>'Here you are—£15.','b'=>'It’s really lovely.','c'=>'I can’t swim.','d'=>'That’s my favorite song.']],
    ['key'=>'s5','q'=>'What is the best response to Speaker 5?','options'=>['a'=>'It’s half past nine.','b'=>'It’s ten degrees.','c'=>'It’s the number eleven.','d'=>'It’s next to the bank.']],
    ['key'=>'s6','q'=>'What is the best response to Speaker 6?','options'=>['a'=>'Yes, please. Could you repeat that?','b'=>'I played football yesterday.','c'=>'It’s made of wood.','d'=>'I can drive.']],
    ['key'=>'s7','q'=>'What is the best response to Speaker 7?','options'=>['a'=>'Sorry, I can’t today. How about tomorrow?','b'=>'I live near the park.','c'=>'It’s a blue jacket.','d'=>'Because I was hungry.']],
    ['key'=>'s8','q'=>'What is the best response to Speaker 8?','options'=>['a'=>'Really? What does it look like?','b'=>'These are too big for her.','c'=>'She won’t like the color.','d'=>'I don’t wear hats.']],
    ['key'=>'s9','q'=>'What is the best response to Speaker 9?','options'=>['a'=>'Yes, it finally arrived.','b'=>'Yes, it was a fast trip.','c'=>'Yes, it was a long journey.','d'=>'Yes, it’s my new phone.']],
    ['key'=>'s10','q'=>'What is the best response to Speaker 10?','options'=>['a'=>'Yes, they look like their father.','b'=>'I saw them yesterday.','c'=>'My mother does.','d'=>'It starts at noon.']],
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
    <h1 class="title"><i class="fa-solid fa-headphones"></i> تفاصيل الاستماع • Listening Details</h1>

    <div class="pills">
      <div class="pill"><i class="fa-solid fa-list-check"></i> Questions: {{ $total }}</div>
      <div class="pill"><i class="fa-solid fa-bullseye"></i> Score: {{ $score }}/{{ $total }} ({{ $percent }}%)</div>
      <div class="pill"><i class="fa-solid fa-circle-info"></i> <span style="color:#ffe2b1;font-weight:900;">Your choice</span> • <span style="color:#c7ffe6;font-weight:900;">Correct</span></div>
    </div>
  </div>
</div>

<div class="shell">
  <div class="grid">

    <!-- ✅ Left: Audio ثابت -->
    <div class="card">
      <div class="card-head">
        <h2>Listening Audio</h2>
        <p>Review the recording (demo: 2 plays).</p>
      </div>

      <div class="player">
        <button class="play-btn" id="playBtn" type="button" aria-label="Play audio">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M8 5v14l11-7-11-7z" fill="white"/>
          </svg>
        </button>

        <div class="player-meta">
          <div class="meta-line">Plays left: <span id="playsLeft" style="font-weight:900;">2</span></div>
          <div class="time-line"><span id="curTime">00:00</span> / <span id="durTime">00:00</span></div>
          <small style="color: var(--muted2);">Scroll the questions on the right.</small>
        </div>
      </div>

      <audio id="audio" preload="metadata">
        <source src="{{ asset('audio/audioQ1.mp3') }}" type="audio/mpeg">
      </audio>

      <div class="card-pad" style="padding-top:0;">
        <div style="height: 1px; background: rgba(255,255,255,0.10); margin: 0 0 14px;"></div>
        <p style="margin:0; color: var(--muted); font-size: 13.5px; line-height:1.7;">
          Tip: This is a review page. Later we will connect answers from session.
        </p>
      </div>
    </div>

    <!-- ✅ Right: Questions scroll + زر رجوع ثابت -->
    <div class="card">
      <div class="card-head">
        <h2>Answers Review</h2>
        <p>Only this side scrolls.</p>
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

          <!-- ✅ زر الرجوع للنتائج ثابت وتحت -->
          <div class="footer-actions">
            <a class="btn btn-secondary" href="{{ route('test.results') }}">
              <i class="fa-solid fa-arrow-right"></i> الرجوع للنتائج
            </a>
            <a class="btn btn-primary" href="{{ route('test.strengthening') }}">
              <i class="fa-solid fa-shield-halved"></i> ابدأ خطة التقوية
            </a>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

<script>
(function audioController(){
  const audio = document.getElementById('audio');
  const playBtn = document.getElementById('playBtn');
  const playsLeftEl = document.getElementById('playsLeft');
  const curTimeEl = document.getElementById('curTime');
  const durTimeEl = document.getElementById('durTime');

  let playsLeft = 2;

  function fmt(t){
    if (!isFinite(t)) return "00:00";
    const m = String(Math.floor(t/60)).padStart(2,'0');
    const s = String(Math.floor(t%60)).padStart(2,'0');
    return `${m}:${s}`;
  }

  audio.addEventListener('loadedmetadata', () => {
    durTimeEl.textContent = fmt(audio.duration);
  });

  audio.addEventListener('timeupdate', () => {
    curTimeEl.textContent = fmt(audio.currentTime);
  });

  playBtn.addEventListener('click', () => {
    if (playsLeft <= 0) return;

    if (audio.paused) {
      if (audio.currentTime === 0 || audio.ended) {
        playsLeft--;
        playsLeftEl.textContent = String(playsLeft);
      }
      audio.play().catch(()=>{});
    } else {
      audio.pause();
    }
  });
})();
</script>

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