<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reading - Get Ready</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#000c1d;
  --card: rgba(255,255,255,0.085);
  --stroke: rgba(255,255,255,0.16);
  --text:#ffffff;
  --muted: rgba(255,255,255,0.72);
  --muted2: rgba(255,255,255,0.6);
  --brand1:#00c6ff;
  --brand2:#0086ff;
  --shadow: 0 18px 55px rgba(0,180,255,0.22);
  --radius: 26px;
  --soft: rgba(0,0,0,0.10);
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
.btn-primary{
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
}
.btn-primary:hover{
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

/* Card */
.card{
  width: min(720px, 100%);
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  padding: 26px;
  box-shadow: var(--shadow);
  animation: fadeIn .9s ease-in-out;
  overflow:hidden;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

.header{
  text-align:center;
  padding: 10px 6px 8px;
}
h1{
  margin: 0 0 8px;
  font-size: clamp(24px, 2.6vw, 34px);
  letter-spacing: .2px;
}
.sub{
  margin: 0;
  color: var(--muted);
  font-size: 14.5px;
  line-height: 1.7;
}

/* Mid info block like your screenshot */
.mid{
  margin-top: 18px;
  border-radius: 22px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
  padding: 18px 14px;
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:10px;
}
.mid img{
  width: 64px;
  height: 64px;
  object-fit: contain;
  filter: drop-shadow(0 10px 20px rgba(0,0,0,.35));
}
.mid .mid-title{
  font-weight: 700;
  margin: 0;
}
.mid .mid-time{
  margin: 0;
  font-weight: 800;
  color: #c7f5ff;
}

/* Bullet list */
.list{
  margin: 18px 0 0;
  padding: 16px 18px;
  border-radius: 22px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
}
.list ul{
  margin: 0;
  padding-left: 18px;
  color: var(--muted);
  line-height: 1.9;
  font-size: 14.5px;
}
.list li{ margin: 10px 0; }

/* Start button */
.start{
  margin-top: 18px;
  width: 100%;
  border-radius: 999px;
  padding: 14px 16px;
  font-weight: 800;
  font-size: 15.5px;
  display:inline-flex;
  justify-content:center;
  align-items:center;
}

/* RTL tweaks */
body[dir="rtl"] .top-actions{ direction: rtl; }
body[dir="rtl"] .list ul{
  padding-left: 0;
  padding-right: 18px;
}
body[dir="rtl"] .list ul{ direction: rtl; }

@media (max-width: 420px){
  .card{ padding: 20px; }
}
</style>
</head>

<body>
<div class="light"></div>

<div class="top-actions">
  <a href="{{ url()->previous() }}" class="btn" id="backBtn">
    <span id="backArrow">←</span> <span id="backText">Back</span>
  </a>

  <button class="btn btn-primary" onclick="toggleLang()" id="translateBtn">Translate</button>
</div>

<div class="card">

  <div class="header">
    <h1 id="title">Reading</h1>
    <p class="sub" id="subtitle">You are about to start the reading section.</p>
  </div>

  <div class="mid">
    <img src="{{ asset('images/reading.png') }}" alt="Reading Icon">
    <p class="mid-title" id="midName">Reading</p>
    <p class="mid-time" id="midTime">20 mins</p>
  </div>

  <div class="list" id="rulesBox">
    <ul id="rules">
      <li>The questions in this test may get harder or easier to adapt to your level. Use the progress bar so that you have time to answer all the questions.</li>
      <li>You will not lose points for incorrect answers.</li>
      <li>Once you submit a task, you cannot go back.</li>
    </ul>
  </div>

  <!-- ✅ التعديل هنا لربط مع الذكاء الاصطناعي -->
  <a href="{{ route('test.startAI') }}" class="btn btn-primary start" id="startBtn">Start</a>

</div>

<script>
let lang = 'en';

function setArabic(){
  document.getElementById('title').innerText = "القراءة";
  document.getElementById('subtitle').innerText = "أنت على وشك بدء قسم القراءة.";
  document.getElementById('midName').innerText = "القراءة";
  document.getElementById('midTime').innerText = "20 دقيقة";
  document.getElementById('startBtn').innerText = "ابدأ";

  document.getElementById('translateBtn').innerText = "English";

  // Back RTL
  document.getElementById('backArrow').innerText = "→";
  document.getElementById('backText').innerText = "رجوع";

  document.getElementById('rules').innerHTML = `
    <li>قد تصبح الأسئلة أسهل أو أصعب حسب مستواك. استخدم شريط التقدم حتى يكون لديك وقت كافٍ للإجابة على جميع الأسئلة.</li>
    <li>لن تفقد نقاطًا عند الإجابات الخاطئة.</li>
    <li>بعد تسليم المهمة، لا يمكنك الرجوع.</li>
  `;

  document.documentElement.lang = "ar";
  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
  lang = 'ar';
}

function setEnglish(){
  document.getElementById('title').innerText = "Reading";
  document.getElementById('subtitle').innerText = "You are about to start the reading section.";
  document.getElementById('midName').innerText = "Reading";
  document.getElementById('midTime').innerText = "20 mins";
  document.getElementById('startBtn').innerText = "Start";

  document.getElementById('translateBtn').innerText = "Translate";

  document.getElementById('backArrow').innerText = "←";
  document.getElementById('backText').innerText = "Back";

  document.getElementById('rules').innerHTML = `
    <li>The questions in this test may get harder or easier to adapt to your level. Use the progress bar so that you have time to answer all the questions.</li>
    <li>You will not lose points for incorrect answers.</li>
    <li>Once you submit a task, you cannot go back.</li>
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