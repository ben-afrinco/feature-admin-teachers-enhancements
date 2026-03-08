<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Test Instructions - LingoPulse AI</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#000c1d;
  --card: rgba(255,255,255,0.085);
  --stroke: rgba(255,255,255,0.16);
  --text: #ffffff;
  --muted: rgba(255,255,255,0.72);
  --muted2: rgba(255,255,255,0.6);
  --brand1:#00c6ff;
  --brand2:#0086ff;
  --shadow: 0 18px 55px rgba(0,180,255,0.22);
  --radius: 26px;
}

*{ box-sizing:border-box; }
body{
  margin:0;
  min-height:100vh;
  background: radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.18), transparent 60%),
              radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.14), transparent 55%),
              var(--bg);
  font-family: "Poppins", "Tajawal", Arial, sans-serif;
  color:var(--text);
  display:flex;
  justify-content:center;
  align-items:center;
  padding: 84px 18px 22px;
  overflow-x:hidden;
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

/* Top actions */
.top-actions{
  position: fixed;
  top: 18px;
  left: 18px;
  right: 18px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
  z-index: 20;
}

.btn{
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color:#fff;
  padding: 10px 14px;
  border-radius: 14px;
  font-size: 14px;
  text-decoration:none;
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
  backdrop-filter: blur(10px);
  display:inline-flex;
  align-items:center;
  gap:8px;
  user-select:none;
}
.btn:hover{
  transform: translateY(-1px);
  background: rgba(255,255,255,0.11);
}
.btn:focus{
  outline: 2px solid rgba(0,198,255,0.55);
  outline-offset: 2px;
}

.btn-primary{
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
}
.btn-primary:hover{
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

/* Card */
.card{
  width: min(820px, 100%);
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  padding: 28px;
  box-shadow: var(--shadow);
  animation: fadeIn .9s ease-in-out;
  text-align:center;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

h1{
  font-size: clamp(22px, 2.4vw, 30px);
  margin: 6px 0 18px;
  letter-spacing: .2px;
}
.sub{
  color: var(--muted2);
  font-size: 14px;
  margin: 0 auto 18px;
  max-width: 560px;
  line-height: 1.7;
}

/* skills grid */
.skills{
  display:grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 14px;
  margin: 18px 0 22px;
}
.skill{
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.14);
  border-radius: 18px;
  padding: 14px 12px;
  display:flex;
  flex-direction:column;
  align-items:center;
  gap: 8px;
  transition: transform .18s ease, background .18s ease, border-color .18s ease;
}
.skill:hover{
  transform: translateY(-2px);
  background: rgba(255,255,255,0.12);
  border-color: rgba(0,198,255,0.25);
}
.skill img{
  width: 56px;
  height: 56px;
  object-fit: contain;
  filter: drop-shadow(0 6px 12px rgba(0,0,0,.35));
}
.skill strong{ font-size: 14px; }
.skill span{
  font-size: 13px;
  color: var(--muted);
}

/* Instructions */
.instructions{
  text-align: left;
  font-size: 14.5px;
  line-height: 1.8;
  color: var(--muted);
  margin-top: 8px;
  padding: 14px 14px;
  border-radius: 18px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
}
.instructions p{ margin: 8px 0; }

/* Start button */
.start-btn{
  width: 100%;
  margin-top: 18px;
  padding: 14px;
  border-radius: 999px;
  font-size: 16px;
  font-weight: 700;
  justify-content:center;
}

/* Responsive */
@media (max-width: 820px){
  .card{ padding: 22px; }
  .skills{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 420px){
  body{ padding-top: 92px; }
  .skills{ grid-template-columns: 1fr; }
  .btn{ font-size: 13px; padding: 9px 12px; }
}

/* RTL */
body[dir="rtl"] .instructions{ text-align: right; }
body[dir="rtl"] .top-actions{ direction: rtl; }
</style>
</head>

<body>
<div class="light"></div>

<div class="top-actions">
  <a href="{{ url()->previous() }}" class="btn" id="backBtn">
    <span id="backArrow">←</span> <span id="backText">Back</span>
  </a>

  <button class="btn btn-primary" onclick="toggleLang()" id="translateBtn">
    Translate
  </button>
</div>

<div class="card">
  <h1 id="title">You are about to start the test</h1>
  <p class="sub" id="subtitle">Please read the instructions carefully before you begin.</p>

  <div class="skills">
    <div class="skill">
      <img src="{{ asset('images/reading.png') }}" alt="Reading">
      <strong id="reading">Reading</strong>
      <span id="readingTime">20 mins</span>
    </div>
    <div class="skill">
      <img src="{{ asset('images/listening.png') }}" alt="Listening">
      <strong id="listening">Listening</strong>
      <span id="listeningTime">20 mins</span>
    </div>
    <div class="skill">
      <img src="{{ asset('images/writing.png') }}" alt="Writing">
      <strong id="writing">Writing</strong>
      <span id="writingTime">35 mins</span>
    </div>
    <div class="skill">
      <img src="{{ asset('images/speaking.png') }}" alt="Speaking">
      <strong id="speaking">Speaking</strong>
      <span id="speakingTime">15 mins</span>
    </div>
  </div>

  <div class="instructions" id="instructions">
    <p>• Check you will have enough time to complete the whole test before you begin.</p>
    <p>• You can only take the test once.</p>
    <p>• An unstable internet connection may interrupt the test.</p>
    <p>• You will not lose points for wrong answers.</p>
    <p>• Once you submit an exercise, you cannot go back.</p>
  </div>

  <!-- ✅ التعديل هنا فقط: ينقلك إلى صفحة check.blade.php -->
  <a href="{{ route('system.check') }}" class="btn btn-primary start-btn" id="startBtn">
    Start Test
  </a>
</div>

<script>
let lang = 'en';

function setArabic(){
  document.getElementById('title').innerText = "أنت على وشك بدء الاختبار";
  document.getElementById('subtitle').innerText = "اقرأ التعليمات جيدًا قبل البدء.";
  document.getElementById('reading').innerText = "القراءة";
  document.getElementById('listening').innerText = "الاستماع";
  document.getElementById('writing').innerText = "الكتابة";
  document.getElementById('speaking').innerText = "المحادثة";

  document.getElementById('startBtn').innerText = "ابدأ الاختبار";
  document.getElementById('translateBtn').innerText = "English";

  document.getElementById('backArrow').innerText = "→";
  document.getElementById('backText').innerText = "رجوع";

  document.getElementById('instructions').innerHTML = `
    <p>• تأكد أن لديك وقتًا كافيًا لإكمال الاختبار بالكامل قبل البدء.</p>
    <p>• يمكنك إجراء الاختبار مرة واحدة فقط.</p>
    <p>• قد يؤدي ضعف الاتصال بالإنترنت إلى انقطاع الاختبار.</p>
    <p>• لن تفقد نقاطًا عند الإجابات الخاطئة.</p>
    <p>• بعد تسليم أي جزء، لا يمكنك الرجوع إليه.</p>
  `;

  document.documentElement.lang = "ar";
  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
  lang = 'ar';
}

function setEnglish(){
  document.getElementById('title').innerText = "You are about to start the test";
  document.getElementById('subtitle').innerText = "Please read the instructions carefully before you begin.";
  document.getElementById('reading').innerText = "Reading";
  document.getElementById('listening').innerText = "Listening";
  document.getElementById('writing').innerText = "Writing";
  document.getElementById('speaking').innerText = "Speaking";

  document.getElementById('startBtn').innerText = "Start Test";
  document.getElementById('translateBtn').innerText = "Translate";

  document.getElementById('backArrow').innerText = "←";
  document.getElementById('backText').innerText = "Back";

  document.getElementById('instructions').innerHTML = `
    <p>• Check you will have enough time to complete the whole test before you begin.</p>
    <p>• You can only take the test once.</p>
    <p>• An unstable internet connection may interrupt the test.</p>
    <p>• You will not lose points for wrong answers.</p>
    <p>• Once you submit an exercise, you cannot go back.</p>
  `;

  document.documentElement.lang = "en";
  document.body.setAttribute("dir","ltr");
  document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
  lang = 'en';
}

function toggleLang(){
  if(lang === 'en') setArabic();
  else setEnglish();
}
</script>

</body>
</html>