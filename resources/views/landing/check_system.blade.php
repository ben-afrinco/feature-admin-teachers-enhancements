<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sound Check - LingoPulse</title>

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
  width: min(520px, 100%);
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  padding: 28px;
  box-shadow: var(--shadow);
  animation: fadeIn .9s ease-in-out;
  text-align:center;
  position:relative;
  overflow:hidden;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Header */
h1{
  margin: 8px 0 8px;
  font-size: clamp(22px, 2.6vw, 34px);
  letter-spacing: .2px;
}
.sub{
  margin: 0 auto 16px;
  color: var(--muted);
  font-size: 14.5px;
  line-height: 1.7;
  max-width: 420px;
}

/* Speaker ring */
.ring{
  width: 140px;
  height: 140px;
  margin: 10px auto 18px;
  border-radius: 999px;
  display:grid;
  place-items:center;
  background:
    radial-gradient(circle at 30% 30%, rgba(0,198,255,0.24), transparent 55%),
    radial-gradient(circle at 70% 70%, rgba(0,134,255,0.18), transparent 55%),
    rgba(0,0,0,0.10);
  border: 1px solid rgba(255,255,255,0.14);
  position: relative;
}

.ring::after{
  content:"";
  position:absolute;
  inset:-10px;
  border-radius:999px;
  border: 1px solid rgba(0,198,255,0.22);
  filter: blur(.2px);
  opacity:.9;
}

.speaker{
  width: 92px;
  height: 92px;
  border-radius: 999px;
  display:grid;
  place-items:center;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.16);
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
  user-select:none;
}
.speaker:hover{
  transform: translateY(-2px) scale(1.02);
  background: rgba(255,255,255,0.08);
}
.speaker.playing{
  transform: scale(1.08);
  box-shadow: 0 0 30px rgba(0,198,255,0.35);
}

.speaker span{
  font-size: 40px;
  filter: drop-shadow(0 10px 18px rgba(0,0,0,.35));
}

/* Status pill */
.status{
  display:inline-flex;
  align-items:center;
  gap:10px;
  padding: 10px 12px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
  color: var(--muted2);
  font-size: 13px;
  margin: 0 auto 16px;
}
.dot{
  width:10px;height:10px;border-radius:999px;
  background: rgba(255,255,255,0.35);
}
.dot.on{
  background: #00c6ff;
  box-shadow: 0 0 14px rgba(0,198,255,0.65);
}

/* Buttons inside card */
.actions{
  display:flex;
  flex-direction:column;
  gap: 12px;
  margin-top: 6px;
}

.btn-outline{
  border: 1px solid rgba(0,198,255,0.55);
  background: rgba(255,255,255,0.06);
  color: #bff3ff;
  padding: 13px 16px;
  border-radius: 999px;
  font-weight: 800;
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
}
.btn-outline:hover{
  transform: translateY(-1px);
  background: rgba(0,198,255,0.10);
  box-shadow: 0 10px 24px rgba(0,200,255,0.18);
}

.btn-start{
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  color:#fff;
  padding: 14px 18px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 15px;
  text-decoration:none;
  display:inline-flex;
  justify-content:center;
  align-items:center;
  gap:10px;
  transition: transform .18s ease, box-shadow .18s ease;
}
.btn-start:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

.hint{
  margin-top: 12px;
  font-size: 12px;
  color: rgba(255,255,255,0.45);
}

/* RTL */
body[dir="rtl"] .top-actions{ direction: rtl; }
body[dir="rtl"] .btn{ letter-spacing: 0; }
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

  <h1 id="title">Speaker Test</h1>
  <p class="sub" id="desc">Tap the speaker icon to test your sound. Make sure you can hear clearly before continuing.</p>

  <div class="ring">
    <div class="speaker" id="speakerBtn" onclick="playTestSound()" aria-label="Play test sound">
      <span id="speakerEmoji">🔊</span>
    </div>
  </div>

  <div class="status" id="statusBox">
    <span class="dot" id="statusDot"></span>
    <span id="statusText">Ready to play</span>
  </div>

  <div class="actions">
    <button class="btn-outline" onclick="playTestSound()" type="button" id="playBtn">Play Test Sound</button>

    <!-- ✅ ينقلك إلى الاختبار (reading.getready) -->
    <a href="{{ route('reading.getready') }}" class="btn-start" id="startBtn">
      <span id="startText">I can hear clearly, Continue</span>
      <span>››</span>
    </a>
  </div>

  <div class="hint" id="hint">Tip: Increase your device volume if you can’t hear the test sound.</div>
</div>

<audio id="testAudio" preload="auto">
  <source src="{{ asset('audio/check.mp3') }}" type="audio/mpeg">
  <source src="{{ asset('audio/check.m4a') }}" type="audio/mp4">
</audio>

<script>
let lang = 'en';

const audio = document.getElementById('testAudio');
const speakerBtn = document.getElementById('speakerBtn');
const statusDot = document.getElementById('statusDot');
const statusText = document.getElementById('statusText');

function setStatus(mode){
  if(mode === 'playing'){
    statusDot.classList.add('on');
    statusText.textContent = (lang === 'ar') ? "يتم التشغيل الآن..." : "Playing...";
    speakerBtn.classList.add('playing');
  }else if(mode === 'done'){
    statusDot.classList.remove('on');
    statusText.textContent = (lang === 'ar') ? "تم تشغيل الصوت" : "Sound played";
    speakerBtn.classList.remove('playing');
  }else{
    statusDot.classList.remove('on');
    statusText.textContent = (lang === 'ar') ? "جاهز للتشغيل" : "Ready to play";
    speakerBtn.classList.remove('playing');
  }
}

function playTestSound(){
  try{
    if(!audio.paused) audio.currentTime = 0;
    audio.play();
    setStatus('playing');
  }catch(e){
    setStatus('ready');
  }
}

audio.addEventListener('ended', ()=> setStatus('done'));
audio.addEventListener('pause', ()=>{
  // لو توقّف بدون انتهاء
  if(audio.currentTime > 0 && audio.currentTime < audio.duration) setStatus('done');
});

function setArabic(){
  document.getElementById('title').innerText = "اختبار الصوت";
  document.getElementById('desc').innerText = "اضغط على أيقونة السماعة لاختبار الصوت. تأكد أنك تسمع بوضوح قبل المتابعة.";
  document.getElementById('playBtn').innerText = "تشغيل صوت تجريبي";
  document.getElementById('startText').innerText = "أسمع بوضوح، متابعة";
  document.getElementById('hint').innerText = "نصيحة: ارفع صوت الجهاز إذا لم تسمع الصوت التجريبي.";

  document.getElementById('translateBtn').innerText = "English";
  document.getElementById('backArrow').innerText = "→";
  document.getElementById('backText').innerText = "رجوع";

  document.documentElement.lang = "ar";
  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
  lang = 'ar';
  setStatus('ready');
}

function setEnglish(){
  document.getElementById('title').innerText = "Speaker Test";
  document.getElementById('desc').innerText = "Tap the speaker icon to test your sound. Make sure you can hear clearly before continuing.";
  document.getElementById('playBtn').innerText = "Play Test Sound";
  document.getElementById('startText').innerText = "I can hear clearly, Continue";
  document.getElementById('hint').innerText = "Tip: Increase your device volume if you can’t hear the test sound.";

  document.getElementById('translateBtn').innerText = "Translate";
  document.getElementById('backArrow').innerText = "←";
  document.getElementById('backText').innerText = "Back";

  document.documentElement.lang = "en";
  document.body.setAttribute("dir","ltr");
  document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
  lang = 'en';
  setStatus('ready');
}

function toggleLang(){
  if(lang === 'en') setArabic();
  else setEnglish();
}

setStatus('ready');
</script>

</body>
</html>