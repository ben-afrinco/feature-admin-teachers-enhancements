<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reading - Question 1</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

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
  padding: 96px 18px 22px; /* لأن التوب بار ثابت */
  overflow:hidden; /* ✅ مهم: نخلي سكرول فقط داخل صندوق الأسئلة */
  position:relative;
}

/* Glow */
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

/* ✅ Fixed topbar */
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
}
.title{
  margin:0;
  font-size: 14.5px;
  font-weight: 900;
  letter-spacing:.2px;
  color:#eafcff;
}
.timer{
  padding: 8px 12px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(0,0,0,0.18);
  color: var(--muted);
  font-weight: 800;
  font-size: 13px;
}

/* Shell */
.shell{
  max-width: 1200px;
  margin: 0 auto;
  height: calc(100vh - 96px - 22px); /* ✅ ارتفاع الصفحة بدون التوب بار والبوتوم */
}

/* Main layout */
.main{
  height: 100%;
  display:grid;
  grid-template-columns: 1.15fr .85fr;
  gap: 16px;
  align-items:stretch;
}

/* Cards */
.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
  min-height: 0; /* ✅ عشان السكروول يشتغل داخل الأب */
}

.card-pad{ padding: 18px; }

.card-head{
  padding: 16px 18px;
  border-bottom: 1px solid rgba(255,255,255,0.10);
  background: rgba(0,0,0,0.10);
}
.card-head h2{
  margin:0;
  font-size: 14.5px;
  font-weight: 800;
  color: #eafcff;
}
.card-head p{
  margin: 6px 0 0;
  font-size: 13px;
  color: var(--muted2);
  line-height: 1.6;
}

/* Passage */
.passage{
  font-size: 14.5px;
  line-height: 1.9;
  color: rgba(255,255,255,0.88);
}
.no-select{
  -webkit-user-select: none;
  user-select: none;
  -webkit-touch-callout: none;
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

/* ✅ Questions scroll area */
.qscroll{
  height: 100%;
  overflow:auto;              /* ✅ هنا السكروول */
  padding: 18px;
}

/* Make scrollbar nicer */
.qscroll::-webkit-scrollbar{ width: 10px; }
.qscroll::-webkit-scrollbar-thumb{
  background: rgba(255,255,255,0.18);
  border-radius: 999px;
}
.qscroll::-webkit-scrollbar-track{
  background: rgba(0,0,0,0.10);
}

/* Questions */
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
}

/* Options */
.option{
  display:flex;
  align-items:center;
  gap:10px;
  padding: 12px 12px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  cursor:pointer;
  transition: transform .15s ease, background .15s ease, border-color .15s ease;
  margin-bottom: 10px;
}
.option:last-child{ margin-bottom:0; }
.option:hover{
  transform: translateY(-1px);
  background: rgba(255,255,255,0.07);
  border-color: rgba(0,198,255,0.32);
}
.option input{
  width: 18px;
  height: 18px;
  accent-color: #00c6ff;
}
.option span{
  font-size: 13.5px;
  color: rgba(255,255,255,0.82);
}

/* Footer controls */
.footer{
  margin-top: 14px;
  display:flex;
  justify-content:flex-end;
  position: sticky;     /* ✅ يظل زر Next ظاهر عند النزول */
  bottom: 0;
  padding: 12px 0 6px;
  background: linear-gradient(to top, rgba(0,0,0,0.18), rgba(0,0,0,0));
}
.btn{
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  color:#fff;
  padding: 12px 22px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 14px;
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease;
}
.btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

@media (max-width: 980px){
  body{ overflow:auto; padding-top: 110px; }
  .shell{ height: auto; }
  .main{ grid-template-columns: 1fr; height:auto; }
  .qscroll{ height: auto; overflow: visible; padding: 18px; }
}
</style>
</head>

<body class="no-select">
<div class="light"></div>

<div class="topbar">
  <div class="topbar-inner">
    <h1 class="title">Reading • Beginner • 10 Questions</h1>
    <div class="timer">Time: <span id="timer">20:00</span></div>
  </div>
</div>

<div class="shell">
  <div class="main">

    <!-- Left: Passage فقط (بدون سكرول مستقل) -->
    <div class="card">
      <div class="card-head">
        <h2>Read the text and answer the questions.</h2>
        <p>Choose the best answer.</p>
      </div>

      <div class="card-pad passage no-select" id="passage">
        <h3>My Day at the Park</h3>

        <div class="story-text">
          {!! nl2br(e($test->content)) !!}
        </div>
      </div>
    </div>

    <!-- Right: Questions with scroll -->
    <div class="card">
      <div class="qscroll">
        <form class="qwrap" method="POST" action="{{ route('reading.submit', ['q' => 'dynamic']) }}">
          @csrf

          @foreach($test->questions as $index => $question)
          <div class="qbox">
            <p class="qtitle">{{ $index + 1 }}) {{ $question->question_text }}</p>
            @foreach($question->options as $option)
            <label class="option">
              <input type="radio" name="q{{ $question->question_id }}" value="{{ $option->option_id }}" required>
              <span>{{ $option->optione_text }}</span>
            </label>
            @endforeach
          </div>
          @endforeach

          <div class="footer">
            <button type="submit" class="btn" id="nextBtn">Submit & Next</button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>

<script>
/* ✅ منع النسخ/القص/اللصق/كليك يمين/اختصارات */
(function hardenCopyProtection(){
  const block = (e) => { e.preventDefault(); return false; };
  document.addEventListener('copy', block);
  document.addEventListener('cut', block);
  document.addEventListener('paste', block);
  document.addEventListener('contextmenu', block);
  document.addEventListener('selectstart', block);

  document.addEventListener('keydown', function(e){
    const k = (e.key || '').toLowerCase();
    const ctrl = e.ctrlKey || e.metaKey;

    if (ctrl && ['c','x','a','s','u','p','v'].includes(k)) return block(e);
    if (e.key === 'F12') return block(e);
    if (ctrl && e.shiftKey && ['i','j','c'].includes(k)) return block(e);
  });
})();

/* ✅ منع الرجوع (قدر الإمكان) */
(function preventBack(){
  history.pushState(null, "", location.href);
  window.addEventListener('popstate', function () {
    history.pushState(null, "", location.href);
  });
})();

/* ✅ مؤقت 20:00 */
(function timer(){
  let total = 20 * 60;
  const el = document.getElementById('timer');

  setInterval(() => {
    if (total <= 0) return;
    total--;
    const m = String(Math.floor(total/60)).padStart(2,'0');
    const s = String(total%60).padStart(2,'0');
    el.textContent = `${m}:${s}`;
  }, 1000);
})();
</script>

</body>
</html>