<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>How It Works - LingoPulse AI</title>

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
    radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.16), transparent 60%),
    radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.12), transparent 55%),
    var(--bg);
  font-family:"Poppins","Tajawal",Arial,sans-serif;
  color:var(--text);
  overflow-x:hidden;
  padding: 92px 18px 40px; /* مساحة للأزرار الثابتة */
  position:relative;
}

/* ✅ Glow (خفيف وهادئ) */
.light{
  position: fixed;
  width: 720px;
  height: 720px;
  background: radial-gradient(circle, rgba(0,200,255,0.20), rgba(0,0,0,0));
  filter: blur(95px);
  z-index:-1;
  opacity: .70;
  animation: moveLightSoft 10s infinite alternate ease-in-out;
}
@keyframes moveLightSoft{
  0%   { top:-210px; left:-200px; transform: scale(1); }
  50%  { top:40%; left:60%; transform: translate(-50%,-50%) scale(1.03); }
  100% { top:90%; left:-160px; transform: scale(1); }
}

/* ✅ Top actions */
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

/* ✅ Container */
.container{
  width: min(980px, 100%);
  margin: 0 auto;
}

/* ✅ Header */
.header{
  text-align:center;
  margin-bottom: 20px;
}
h1{
  margin: 0 0 10px;
  font-size: clamp(24px, 3vw, 36px);
  letter-spacing:.2px;
  font-weight: 800;
}
.top-desc{
  margin: 0 auto;
  max-width: 780px;
  color: var(--muted2);
  font-size: 15.5px;
  line-height: 1.75;
}

/* ✅ Cards */
.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  padding: 18px;
  margin-top: 16px;
  display:flex;
  gap:16px;
  align-items:center;
  transition: transform .18s ease, border-color .18s ease, background .18s ease, box-shadow .18s ease;
  position:relative;
  overflow:hidden;
}
.card::before{
  content:"";
  position:absolute;
  inset:-2px;
  background: radial-gradient(520px 200px at 20% 0%, rgba(255,255,255,0.10), transparent 70%);
  pointer-events:none;
}
.card:hover{
  transform: translateY(-2px);
  border-color: rgba(0,198,255,0.28);
  box-shadow: 0 22px 70px rgba(0,180,255,0.26);
}
.card img{
  width: 98px;
  height: 98px;
  object-fit: contain;
  flex: 0 0 auto;
  filter: drop-shadow(0 10px 18px rgba(0,0,0,.35));
}
.text{
  position:relative;
  z-index:1;
}
.text h2{
  margin: 0 0 8px;
  font-size: 18.5px;
  font-weight: 800;
}
.text p{
  margin:0;
  color: rgba(255,255,255,0.78);
  line-height: 1.7;
  font-size: 14.5px;
}

/* ✅ Back Button (Glass + White style) */
.back-wrap{
  margin-top: 22px;
  display:flex;
  justify-content:center;
}
.back-btn{
  padding: 12px 22px;
  border-radius: 999px;
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.16);
  color:#fff;
  text-decoration:none;
  font-weight: 800;
  transition: .2s;
  backdrop-filter: blur(10px);
}
.back-btn:hover{
  transform: translateY(-1px);
  background: rgba(255,255,255,0.13);
}

/* ✅ Responsive */
@media (max-width: 650px){
  body{ padding-top: 100px; }
  .card{
    flex-direction: column;
    text-align:center;
    padding: 18px 16px;
  }
  .card img{
    width: 120px;
    height: 120px;
  }
}

/* ✅ RTL */
body[dir="rtl"] .top-actions{ direction: rtl; }
body[dir="rtl"] .text{ text-align: right; }
body[dir="rtl"] .card{ flex-direction: row-reverse; }
body[dir="rtl"] .top-desc{ direction: rtl; }
</style>
</head>

<body>
<div class="light"></div>

<div class="top-actions">
  <a href="{{ route('index') }}" class="btn" id="homeBtn">
    <span id="homeArrow">←</span> <span id="homeText">Home</span>
  </a>

  <button class="btn btn-primary" onclick="toggleTranslation()" id="translateBtn">Translate</button>
</div>

<div class="container">

  <div class="header">
    <h1 id="pageTitle">How LingoPulse Works</h1>
    <p class="top-desc" id="pageDesc">
      Certify all your English skills at once: speaking, writing, listening, and reading.
      Instantly get a personalized LingoPulse Certificate that proves your level.
    </p>
  </div>

  <div class="card">
    <img src="{{ asset('images/certificate.png') }}" alt="Certificate">
    <div class="text">
      <h2 id="card1Title">Get a Free Certificate</h2>
      <p id="card1Text">
        When you finish the test, you'll instantly get an official LingoPulse certificate
        showcasing all your English skills: reading, listening, writing and speaking.
      </p>
    </div>
  </div>

  <div class="card">
    <img src="{{ asset('images/level.png') }}" alt="Level">
    <div class="text">
      <h2 id="card2Title">Know Your English Level</h2>
      <p id="card2Text">
        Our adaptive test design and the power of AI lets you accurately measure your level
        from A1 to C2 on the CEFR scale.
      </p>
    </div>
  </div>

  <div class="card">
    <img src="{{ asset('images/exam.png') }}" alt="Exam">
    <div class="text">
      <h2 id="card3Title">Exam Preparation</h2>
      <p id="card3Text">
        Preparing for TOEFL, IELTS or another exam?
        LingoPulse results align with CEFR so you can use them to estimate your score on other English tests.
      </p>
    </div>
  </div>

  <div class="back-wrap">
    <a href="{{ route('index') }}" class="back-btn" id="backBtn">Back to Home</a>
  </div>

</div>

<script>
let isArabic = false;

function toggleTranslation() {
  if (!isArabic) {
    document.getElementById('pageTitle').innerText = "كيف يعمل LingoPulse";
    document.getElementById('pageDesc').innerText =
      "اعتمد جميع مهاراتك في اللغة الإنجليزية دفعة واحدة: المحادثة، الكتابة، الاستماع، والقراءة. احصل فورًا على شهادة LingoPulse مخصصة تثبت مستواك.";

    document.getElementById('card1Title').innerText = "احصل على شهادة مجانية";
    document.getElementById('card1Text').innerText =
      "عند إنهاء الاختبار، ستحصل فورًا على شهادة رسمية من LingoPulse تعرض جميع مهاراتك: القراءة، الاستماع، الكتابة والمحادثة.";

    document.getElementById('card2Title').innerText = "اعرف مستواك في الإنجليزية";
    document.getElementById('card2Text').innerText =
      "تصميم الاختبار التكيفي وقوة الذكاء الاصطناعي يتيحان قياس مستواك بدقة من A1 إلى C2 وفق مقياس CEFR.";

    document.getElementById('card3Title').innerText = "التحضير للامتحانات";
    document.getElementById('card3Text').innerText =
      "هل تستعد لامتحان TOEFL أو IELTS أو غيرها؟ نتائج LingoPulse متوافقة مع CEFR لتقدير أدائك في اختبارات أخرى.";

    document.getElementById('backBtn').innerText = "العودة إلى الرئيسية";
    document.getElementById('translateBtn').innerText = "English";

    document.getElementById('homeArrow').innerText = "→";
    document.getElementById('homeText').innerText = "الرئيسية";

    document.documentElement.lang = "ar";
    document.body.setAttribute("dir","rtl");
    document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
    isArabic = true;
  } else {
    document.getElementById('pageTitle').innerText = "How LingoPulse Works";
    document.getElementById('pageDesc').innerText =
      "Certify all your English skills at once: speaking, writing, listening, and reading. Instantly get a personalized LingoPulse Certificate that proves your level.";

    document.getElementById('card1Title').innerText = "Get a Free Certificate";
    document.getElementById('card1Text').innerText =
      "When you finish the test, you'll instantly get an official LingoPulse certificate showcasing all your English skills: reading, listening, writing and speaking.";

    document.getElementById('card2Title').innerText = "Know Your English Level";
    document.getElementById('card2Text').innerText =
      "Our adaptive test design and the power of AI lets you accurately measure your level from A1 to C2 on the CEFR scale.";

    document.getElementById('card3Title').innerText = "Exam Preparation";
    document.getElementById('card3Text').innerText =
      "Preparing for TOEFL, IELTS or another exam? LingoPulse results align with CEFR so you can use them to estimate your score on other English tests.";

    document.getElementById('backBtn').innerText = "Back to Home";
    document.getElementById('translateBtn').innerText = "Translate";

    document.getElementById('homeArrow').innerText = "←";
    document.getElementById('homeText').innerText = "Home";

    document.documentElement.lang = "en";
    document.body.setAttribute("dir","ltr");
    document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
    isArabic = false;
  }
}
</script>

</body>
</html>