<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>LingoPulse AI</title>

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
  display:flex;
  justify-content:center;
  align-items:center;
  padding: 70px 18px 22px;
  overflow:hidden;
  position:relative;
}

/* ✅ Glow (أهدأ + بدون وميض قوي) */
.light{
  position: fixed;
  width: 620px;
  height: 620px;
  background: radial-gradient(circle, rgba(0,200,255,0.22), rgba(0,0,0,0));
  filter: blur(85px);
  z-index:-1;
  opacity: .75;
  animation: moveLightSoft 10s infinite alternate ease-in-out;
}
@keyframes moveLightSoft {
  0% { top: -180px; left: -160px; transform: scale(1); }
  50% { top: 35%; left: 55%; transform: translate(-50%, -50%) scale(1.03); }
  100% { top: 85%; left: -120px; transform: scale(1); }
}

/* ✅ Translate button */
.translate-btn{
  position: fixed;
  top: 18px;
  right: 18px;
  background: rgba(255,255,255,0.08);
  color:#fff;
  border: 1px solid rgba(255,255,255,0.16);
  padding: 9px 15px;
  border-radius: 18px;
  cursor:pointer;
  font-weight: 700;
  font-size: 13px;
  backdrop-filter: blur(10px);
  transition: .25s;
  z-index: 30;
}
.translate-btn:hover{
  background: rgba(255,255,255,0.12);
  transform: translateY(-1px);
}

/* ✅ Card (Glass) */
.card{
  width: min(520px, 100%);
  padding: 44px 34px;
  background: var(--card);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  border: 1px solid var(--stroke);
  text-align:center;
  box-shadow: 0 0 40px rgba(0,180,255,0.26);
  animation: fadeIn .9s ease-in-out;
  position:relative;
  overflow:hidden;
}
@keyframes fadeIn{
  from{ opacity:0; transform: translateY(16px); }
  to{ opacity:1; transform: translateY(0); }
}

/* ✅ subtle shine */
.card::before{
  content:"";
  position:absolute;
  inset:-2px;
  background: radial-gradient(500px 200px at 25% 10%, rgba(255,255,255,0.10), transparent 70%);
  pointer-events:none;
}

/* ✅ Logo أكبر */
.logo{
  width: 210px;
  height: 210px;
  object-fit: contain;
  margin: 0 auto 18px;
  display:block;
  filter: drop-shadow(0 14px 28px rgba(0,0,0,.40));
}

h1{
  margin: 6px 0 8px;
  font-size: 30px;
  letter-spacing: .2px;
  font-weight: 800;
}
h1 .brand{
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  -webkit-background-clip:text;
  color: transparent;
}

.desc{
  margin: 0 auto 22px;
  max-width: 420px;
  color: var(--muted2);
  font-size: 14.5px;
  line-height: 1.75;
}

/* Buttons */
.btns{
  display:flex;
  gap: 14px;
  justify-content:center;
  flex-wrap: wrap;
  margin-top: 8px;
}
.btn{
  padding: 12px 22px;
  border-radius: 999px;
  font-size: 15px;
  font-weight: 800;
  cursor:pointer;
  border:none;
  transition: .25s;
  min-width: 160px;
}

.primary{
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  color:#fff;
  box-shadow: 0 0 12px rgba(0,150,255,0.55);
}
.primary:hover{
  transform: translateY(-2px);
  box-shadow: 0 0 22px rgba(0,200,255,0.75);
}

.secondary{
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.16);
  color:#fff;
}
.secondary:hover{
  background: rgba(255,255,255,0.14);
  transform: translateY(-2px);
}

/* Loader Overlay */
#loaderOverlay{
  position: fixed;
  inset:0;
  background: rgba(0,0,0,0.75);
  display:none;
  justify-content:center;
  align-items:center;
  z-index: 9999;
}
.loader{
  border: 6px solid rgba(255,255,255,0.18);
  border-top: 6px solid var(--brand1);
  border-radius: 50%;
  width: 70px;
  height: 70px;
  animation: spin 1s linear infinite;
}
@keyframes spin{
  0%{ transform: rotate(0deg); }
  100%{ transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 420px){
  .card{ padding: 34px 22px; }
  .logo{ width: 170px; height: 170px; }
  .btn{ width: 100%; min-width: 0; }
}

/* RTL */
body[dir="rtl"]{
  font-family:"Tajawal","Poppins",Arial,sans-serif;
}
</style>
</head>

<body>
<div class="light"></div>

<button class="translate-btn" onclick="toggleTranslation()" id="translateBtn">Translate</button>

<div class="card">
  <img class="logo" src="{{ asset('images/logo.png') }}" alt="Logo">

  <h1 id="mainTitle">Welcome to <span class="brand">LingoPulse AI</span></h1>
  <p class="desc" id="mainDesc">Your English Level, Measured Smarter.</p>

  <div class="btns">
    <button class="btn primary" onclick="startExam()" id="nextBtn">Next</button>
    <button class="btn secondary" onclick="window.location.href='{{ route('how') }}'" id="howBtn">How It Works</button>
  </div>
</div>

<div id="loaderOverlay">
  <div class="loader"></div>
</div>

<script>
let isArabic = false;

function startExam() {
  document.getElementById('loaderOverlay').style.display = 'flex';
  setTimeout(() => {
    window.location.href = "{{ route('info_account') }}";
  }, 900);
}

function toggleTranslation() {
  if (!isArabic) {
    document.getElementById('mainTitle').innerHTML = "مرحبًا بك في <span class='brand'>LingoPulse AI</span>";
    document.getElementById('mainDesc').innerText = "مستوى لغتك الإنجليزية، يقاس بطريقة أذكى.";
    document.getElementById('nextBtn').innerText = "التالي";
    document.getElementById('howBtn').innerText = "كيفية عمله";
    document.getElementById('translateBtn').innerText = "English";
    document.body.setAttribute("dir","rtl");
    isArabic = true;
  } else {
    document.getElementById('mainTitle').innerHTML = "Welcome to <span class='brand'>LingoPulse AI</span>";
    document.getElementById('mainDesc').innerText = "Your English Level, Measured Smarter.";
    document.getElementById('nextBtn').innerText = "Next";
    document.getElementById('howBtn').innerText = "How It Works";
    document.getElementById('translateBtn').innerText = "Translate";
    document.body.setAttribute("dir","ltr");
    isArabic = false;
  }
}
</script>

</body>
</html>