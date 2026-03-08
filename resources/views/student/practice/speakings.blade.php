<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>تحسين مهارة المحادثة - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
  --bg-dark:#000c1d;
  --card-bg: rgba(255,255,255,0.08);
  --speaking-color:#5a7dff;
  --text:#fff;
  --radius:25px;
  --transition: all .25s ease;
  --stroke: rgba(255,255,255,0.14);
  --muted: rgba(255,255,255,0.75);
  --ok: #10b981;
  --bad:#ef4444;
  --warn:#f59e0b;
}

*{ box-sizing:border-box; }

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

/* background blobs */
.light-blob{
  position:fixed;
  width:520px;
  height:520px;
  background: radial-gradient(circle, rgba(90, 125, 255, 0.16), transparent 70%);
  z-index:-1;
  filter: blur(90px);
}
.blob-1{ top:-120px; left:-120px; }
.blob-2{ bottom:-120px; right:-120px; opacity:.7; }

.container{
  width:100%;
  max-width:1050px;
  background:var(--card-bg);
  backdrop-filter: blur(20px);
  border:1px solid rgba(255,255,255,0.15);
  border-radius:var(--radius);
  padding:40px;
  box-shadow:0 25px 50px rgba(0,0,0,0.5);
  animation: fadeIn .8s ease-out;
}

@keyframes fadeIn{
  from{ opacity:0; transform: translateY(18px); }
  to{ opacity:1; transform: translateY(0); }
}

/* header */
.header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:18px;
  flex-wrap:wrap;
  gap:18px;
}
.skill-header{
  display:flex;
  align-items:center;
  gap:15px;
}
.skill-icon{
  width:60px;height:60px;
  border-radius:50%;
  overflow:hidden;
  border:1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.06);
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow: 0 18px 35px rgba(90,125,255,0.14);
}
.skill-icon img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}
.skill-title h1{
  color: var(--speaking-color);
  font-size:2rem;
  margin:0;
  font-weight:900;
}
.sub{ color:#ccc; margin:6px 0 0; line-height:1.6; }

.back-button{
  background: rgba(255,255,255,0.10);
  color:#fff;
  border:1px solid rgba(255,255,255,0.14);
  border-radius:14px;
  padding:10px 18px;
  cursor:pointer;
  transition: var(--transition);
  text-decoration:none;
  display:flex;
  align-items:center;
  gap:8px;
  font-weight:900;
}
.back-button:hover{
  background: rgba(255,255,255,0.16);
  transform: translateY(-1px);
}

/* sections */
.box{
  background: rgba(255,255,255,0.04);
  border-radius:20px;
  padding:20px;
  margin-bottom:18px;
  border-right:4px solid var(--speaking-color);
  text-align:right;
}
.box h3{
  margin:0 0 10px;
  font-weight:900;
  display:flex;
  align-items:center;
  gap:10px;
}
.small{
  color: var(--muted);
  margin:0;
  line-height:1.7;
  font-weight:700;
}

/* grids */
.grid{
  display:grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap:16px;
  margin-top:12px;
}

.card{
  background: rgba(255,255,255,0.03);
  border-radius:20px;
  padding:18px;
  text-align:right;
  border:1px solid rgba(255,255,255,0.10);
  transition: var(--transition);
  position:relative;
  overflow:hidden;
}
.card:hover{
  transform: translateY(-5px);
  border-color: rgba(90,125,255,0.65);
  box-shadow: 0 18px 34px rgba(90,125,255,0.12);
}

.tag{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:6px 10px;
  border-radius:999px;
  font-size:0.85rem;
  font-weight:900;
  color: rgba(255,255,255,0.86);
  background: rgba(255,255,255,0.08);
  border:1px solid rgba(255,255,255,0.12);
}

.card h4{
  margin:12px 0 8px;
  font-size:1.05rem;
  font-weight:900;
  color:#eafcff;
}
.card p{
  margin:0;
  color: rgba(255,255,255,0.78);
  line-height:1.7;
  font-weight:700;
}

.actions{
  margin-top:14px;
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.btn{
  border:none;
  border-radius:12px;
  padding:10px 14px;
  cursor:pointer;
  transition: var(--transition);
  text-decoration:none;
  font-weight:900;
  display:inline-flex;
  align-items:center;
  gap:8px;
  color:#fff;
}
.btn-primary{
  background: linear-gradient(135deg, var(--speaking-color), #00c6ff);
  box-shadow: 0 10px 18px rgba(90,125,255,0.18);
}
.btn-primary:hover{ transform: translateY(-1px); }
.btn-ghost{
  background: rgba(255,255,255,0.10);
  border:1px solid rgba(255,255,255,0.14);
}
.btn-ghost:hover{ background: rgba(255,255,255,0.16); }

/* Exercise Area */
.exercise-area{
  margin-top:14px;
  padding:18px;
  border-radius:20px;
  border:1px solid var(--stroke);
  background: rgba(0,0,0,0.14);
  display:none;
}
.exercise-head{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
  flex-wrap:wrap;
  margin-bottom:12px;
}
.exercise-head .title{
  display:flex;
  align-items:center;
  gap:10px;
  font-weight:900;
  color:#eafcff;
}
.exercise-head .level{
  padding:6px 12px;
  border-radius:999px;
  border:1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.08);
  color: rgba(255,255,255,0.85);
  font-weight:900;
  font-size:0.85rem;
}

.prompt{
  padding:14px;
  border-radius:18px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  line-height:1.9;
  color: rgba(255,255,255,0.88);
  margin-bottom:12px;
  font-weight:800;
}

.controls{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  align-items:center;
  justify-content:flex-start;
  margin-top:12px;
}

.pill{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:8px 12px;
  border-radius:999px;
  border:1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.08);
  color: rgba(255,255,255,0.86);
  font-weight:900;
  font-size:.9rem;
}

.record-btn{
  border:none;
  width:60px;
  height:60px;
  border-radius:999px;
  cursor:pointer;
  font-size:22px;
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  transition: var(--transition);
  background: linear-gradient(135deg, var(--speaking-color), #00c6ff);
  box-shadow: 0 14px 26px rgba(90,125,255,0.18);
}
.record-btn:hover{ transform: translateY(-1px); }
.record-btn.recording{
  background: linear-gradient(135deg, #ff416c, #ff4b2b);
  box-shadow: 0 14px 26px rgba(255,65,108,0.20);
}

.alert{
  margin-top:12px;
  padding:10px 12px;
  border-radius:14px;
  border:1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color: rgba(255,255,255,0.86);
  font-weight:800;
  line-height:1.7;
  display:none;
}
.alert.ok{
  border-color: rgba(16,185,129,0.40);
  background: rgba(16,185,129,0.12);
}
.alert.bad{
  border-color: rgba(239,68,68,0.40);
  background: rgba(239,68,68,0.12);
}
.alert.warn{
  border-color: rgba(245,158,11,0.40);
  background: rgba(245,158,11,0.12);
}

.transcript{
  margin-top:12px;
  padding:14px;
  border-radius:18px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.12);
  display:none;
}
.transcript h4{
  margin:0 0 10px;
  font-weight:900;
  color:#eafcff;
}
.transcript p{
  margin:0;
  line-height:1.8;
  color: rgba(255,255,255,0.84);
  font-weight:700;
}

.feedback{
  margin-top:12px;
  display:none;
  padding:14px;
  border-radius:18px;
  border:1px solid rgba(90,125,255,0.35);
  background: rgba(90,125,255,0.10);
}
.feedback h4{
  margin:0 0 10px;
  font-weight:900;
  color:#eafcff;
}
.fb-item{
  padding:10px 12px;
  border-radius:14px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.12);
  margin-bottom:10px;
}
.fb-item:last-child{ margin-bottom:0; }
.fb-title{ font-weight:900; color: rgba(255,255,255,0.92); margin-bottom:6px; }
.fb-text{ color: rgba(255,255,255,0.82); line-height:1.7; font-weight:700; }

.score{
  margin-top:10px;
  display:none;
  padding:12px;
  border-radius:16px;
  border:1px solid rgba(0,198,255,0.25);
  background: rgba(0,198,255,0.08);
  font-weight:900;
}

audio{
  width:100%;
  margin-top:12px;
  display:none;
  filter: invert(1) hue-rotate(180deg);
}

@media (max-width: 600px){
  .container{ padding:24px; }
  .skill-title h1{ font-size:1.7rem; }
}
</style>
</head>

<body>
<div class="light-blob blob-1"></div>
<div class="light-blob blob-2"></div>

<div class="container">

  <div class="header">
    <div class="skill-header">
      <!-- ✅ بدل الإيموجي: speaking.png -->
      <div class="skill-icon">
        <img src="{{ asset('images/speaking.png') }}" alt="Speaking">
      </div>
      <div class="skill-title">
        <h1>تحسين مهارة المحادثة</h1>
        <p class="sub">روابط تساعدك + تمارين داخل نفس الصفحة (سؤال + تسجيل 40 ثانية + تقييم تجريبي).</p>
      </div>
    </div>

    <a href="{{ route('test.strengthening') }}" class="back-button">
      <i class="fas fa-arrow-right"></i> العودة للتقوية
    </a>
  </div>

  <!-- YouTube -->
  <div class="box">
    <h3>🎥 روابط وقنوات مقترحة (YouTube)</h3>
    <p class="small">قنوات/بحث سريع لتحسين المحادثة والنطق.</p>

    <div class="grid">
      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> قناة</span>
        <h4>ZAmericanEnglish</h4>
        <p>نطق + محادثة + تصحيح أخطاء شائعة.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener" href="https://www.youtube.com/@ZAmericanEnglish">
            <i class="fas fa-play"></i> افتح القناة
          </a>
          <a class="btn btn-ghost" target="_blank" rel="noopener" href="https://www.youtube.com/results?search_query=ZAmericanEnglish+pronunciation+speaking">
            <i class="fas fa-magnifying-glass"></i> بحث محادثة
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> نطق</span>
        <h4>English Pronunciation Practice</h4>
        <p>فيديوهات للنطق وتصحيح مخارج الحروف.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+pronunciation+practice+american+accent">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> محادثة</span>
        <h4>Speaking Practice (Topics)</h4>
        <p>تمارين محادثة بمواضيع متعددة.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+speaking+practice+topics+beginner+intermediate">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Exercises -->
  <div class="box">
    <h3>🧩 التمارين داخل المنصة</h3>
    <p class="small">10 تمارين لكل مستوى (سهل – متوسط – متقدم). كل تمرين: سؤال + تسجيل (40 ثانية) + تقييم فوري (تجريبي).</p>

    <div class="grid">
      <div class="card">
        <span class="tag">🎙️ سهل</span>
        <h4>مواضيع يومية</h4>
        <p>10 أسئلة بسيطة للتدريب على الكلام.</p>
        <div class="actions">
          <button type="button" class="btn btn-primary" onclick="loadExercise('easy')">
            <i class="fas fa-play"></i> ابدأ
          </button>
          <button type="button" class="btn btn-ghost" onclick="loadExercise('easy', true)">
            <i class="fas fa-shuffle"></i> تمرين آخر
          </button>
        </div>
      </div>

      <div class="card">
        <span class="tag">💬 متوسط</span>
        <h4>مواقف محادثة</h4>
        <p>10 مواقف (في المطعم/العمل/السفر).</p>
        <div class="actions">
          <button type="button" class="btn btn-primary" onclick="loadExercise('mid')">
            <i class="fas fa-play"></i> ابدأ
          </button>
          <button type="button" class="btn btn-ghost" onclick="loadExercise('mid', true)">
            <i class="fas fa-shuffle"></i> تمرين آخر
          </button>
        </div>
      </div>

      <div class="card">
        <span class="tag">🎭 متقدم</span>
        <h4>رأي + تبرير</h4>
        <p>10 أسئلة تحتاج رأي وأسباب.</p>
        <div class="actions">
          <button type="button" class="btn btn-primary" onclick="loadExercise('adv')">
            <i class="fas fa-play"></i> ابدأ
          </button>
          <button type="button" class="btn btn-ghost" onclick="loadExercise('adv', true)">
            <i class="fas fa-shuffle"></i> تمرين آخر
          </button>
        </div>
      </div>
    </div>

    <!-- Exercise area -->
    <div class="exercise-area" id="exerciseArea">
      <div class="exercise-head">
        <div class="title">
          <i class="fas fa-microphone-alt"></i>
          <span id="exTitle">تمرين محادثة</span>
        </div>
        <div class="level" id="exLevel">—</div>
      </div>

      <div class="prompt" id="exPrompt">—</div>

      <div class="controls">
        <button class="record-btn" id="recBtn" type="button" title="تسجيل / إيقاف">
          <i class="fas fa-microphone"></i>
        </button>

        <span class="pill"><i class="fas fa-hourglass-half"></i> <span id="recTime">0:40</span></span>
        <span class="pill"><i class="fas fa-rotate-left"></i> إعادة: <span id="retries">2</span></span>
        <span class="pill"><i class="fas fa-signal"></i> تقييم: <span id="scoreMini">—</span></span>

        <button class="btn btn-ghost" type="button" onclick="nextExercise()">
          <i class="fas fa-shuffle"></i> تمرين جديد
        </button>
      </div>

      <div class="alert" id="alertBox"></div>

      <audio id="audioPlayback" controls></audio>

      <div class="transcript" id="transcriptBox">
        <h4>📝 النص المكتوب (Speech-to-Text)</h4>
        <p id="transcriptText">—</p>
      </div>

      <div class="feedback" id="feedbackBox">
        <h4>🛠️ ملاحظات سريعة (تجريبية)</h4>
        <div class="fb-item">
          <div class="fb-title">✅ اقتراح تحسين</div>
          <div class="fb-text" id="tipText">—</div>
        </div>
        <div class="fb-item">
          <div class="fb-title">❗ كلمات/أخطاء شائعة</div>
          <div class="fb-text" id="mistText">—</div>
        </div>
      </div>

      <div class="score" id="scoreBox"></div>
    </div>

  </div>

</div>

<script>
/* ==================================================
   ✅ بنك محادثة: 10 لكل مستوى
   تمرين: prompt + (تسجيل 40 ثانية)
   + Transcript إن توفر SpeechRecognition
   + تقييم تجريبي يعتمد على طول الكلام/كلمات ربط
   ================================================== */

const speakingBank = {
  easy: Array.from({length:10}, (_,i)=>({
    title:"مواضيع يومية",
    level:"سهل",
    prompt:[
      "Talk about your daily routine.",
      "Describe your family.",
      "Talk about your favorite food.",
      "Describe your room.",
      "Talk about your school or work.",
      "Talk about your best friend.",
      "Describe your favorite place in your city.",
      "Talk about your hobby.",
      "What did you do last weekend?",
      "Talk about your plans for next week."
    ][i]
  })),
  mid: Array.from({length:10}, (_,i)=>({
    title:"مواقف محادثة",
    level:"متوسط",
    prompt:[
      "Role-play: Order food at a restaurant.",
      "Role-play: Ask for directions to a museum.",
      "Role-play: Book a hotel room on the phone.",
      "Role-play: Talk to a doctor about a cold.",
      "Role-play: Return an item to a store.",
      "Role-play: Ask your manager for help with a task.",
      "Role-play: Talk to a friend about a movie.",
      "Role-play: Plan a trip with a friend.",
      "Role-play: Introduce yourself in an interview.",
      "Role-play: Make a complaint politely."
    ][i]
  })),
  adv: Array.from({length:10}, (_,i)=>({
    title:"رأي + تبرير",
    level:"متقدم",
    prompt:[
      "Do you think online learning is better than classroom learning? Why?",
      "Should social media be limited for teenagers? Explain.",
      "Is it better to live in a city or the countryside? Why?",
      "Should schools give homework every day? Explain your view.",
      "How does technology affect communication positively/negatively?",
      "What is the best way to stay healthy? Give reasons.",
      "Should people travel more? Why does it matter?",
      "Is teamwork better than working alone? Explain with examples.",
      "What makes a good leader? Explain.",
      "Do you think reading books is still important today? Why?"
    ][i]
  }))
};

let currentType = null;
let currentIndex = 0;

/* recording */
const MAX_RECORD_SECONDS = 40;
let secondsLeft = MAX_RECORD_SECONDS;
let countdownInterval = null;

let retriesLeft = 2;
let recording = false;

let mediaRecorder = null;
let chunks = [];
let streamRef = null;

const recBtn = document.getElementById('recBtn');
const recTimeEl = document.getElementById('recTime');
const retriesEl = document.getElementById('retries');
const audioPlayback = document.getElementById('audioPlayback');
const alertBox = document.getElementById('alertBox');

const transcriptBox = document.getElementById('transcriptBox');
const transcriptText = document.getElementById('transcriptText');

const feedbackBox = document.getElementById('feedbackBox');
const tipText = document.getElementById('tipText');
const mistText = document.getElementById('mistText');
const scoreBox = document.getElementById('scoreBox');
const scoreMini = document.getElementById('scoreMini');

let recognition = null;
let liveTranscript = "";

(function initSpeech(){
  const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
  if(!SR) return;
  recognition = new SR();
  recognition.lang = "en-US";
  recognition.continuous = true;
  recognition.interimResults = true;

  recognition.onresult = (e) => {
    for(let i=e.resultIndex; i<e.results.length; i++){
      const t = e.results[i][0].transcript;
      if(e.results[i].isFinal){
        liveTranscript += t + " ";
      }
    }
  };
})();

function loadExercise(type, forceNew=false){
  currentType = type;

  if(!forceNew && document.getElementById('exerciseArea').style.display === 'block' && currentType === type){
    // keep
  }else{
    currentIndex = Math.floor(Math.random() * speakingBank[type].length);
  }

  renderExercise();

  const area = document.getElementById('exerciseArea');
  area.style.display = 'block';
  area.scrollIntoView({behavior:'smooth', block:'start'});
}

function renderExercise(){
  const ex = speakingBank[currentType][currentIndex];

  document.getElementById('exTitle').textContent = ex.title;
  document.getElementById('exLevel').textContent = ex.level;
  document.getElementById('exPrompt').textContent = ex.prompt;

  resetRecordingUI();
  hideAlert();

  transcriptBox.style.display = "none";
  transcriptText.textContent = "—";

  feedbackBox.style.display = "none";
  scoreBox.style.display = "none";
  scoreBox.textContent = "";
  scoreMini.textContent = "—";
}

function nextExercise(){
  if(!currentType) return;

  let next = Math.floor(Math.random() * speakingBank[currentType].length);
  if(speakingBank[currentType].length > 1){
    while(next === currentIndex){
      next = Math.floor(Math.random() * speakingBank[currentType].length);
    }
  }
  currentIndex = next;
  renderExercise();
  document.getElementById('exerciseArea').scrollIntoView({behavior:'smooth', block:'start'});
}

/* ============ Recording helpers ============ */
function fmtMMSS(s){
  const m = Math.floor(s/60);
  const ss = s%60;
  return `${m}:${ss < 10 ? "0" : ""}${ss}`;
}

function showAlert(msg, type="warn"){
  alertBox.className = "alert " + (type || "warn");
  alertBox.textContent = msg;
  alertBox.style.display = "block";
}
function hideAlert(){
  alertBox.style.display = "none";
  alertBox.textContent = "";
}

function stopTracks(){
  if(streamRef){
    streamRef.getTracks().forEach(t => t.stop());
    streamRef = null;
  }
}

function clearCountdown(){
  if(countdownInterval) clearInterval(countdownInterval);
  countdownInterval = null;
}

function resetRecordingUI(){
  clearCountdown();
  stopTracks();

  recording = false;
  secondsLeft = MAX_RECORD_SECONDS;
  recTimeEl.textContent = fmtMMSS(secondsLeft);

  recBtn.classList.remove("recording");
  recBtn.innerHTML = '<i class="fas fa-microphone"></i>';

  audioPlayback.pause();
  audioPlayback.removeAttribute("src");
  audioPlayback.load();
  audioPlayback.style.display = "none";

  chunks = [];

  retriesEl.textContent = String(retriesLeft);
}

async function startRecording(){
  if(recording) return;

  if(retriesLeft <= 0){
    showAlert("لا يوجد محاولات إعادة متبقية.", "bad");
    return;
  }

  hideAlert();

  try{
    streamRef = await navigator.mediaDevices.getUserMedia({audio:true});
  }catch(err){
    showAlert("تم رفض صلاحية المايكروفون.", "bad");
    return;
  }

  // start recorder
  mediaRecorder = new MediaRecorder(streamRef);
  chunks = [];
  mediaRecorder.ondataavailable = e => chunks.push(e.data);

  mediaRecorder.onstop = () => {
    const blob = new Blob(chunks, {type:"audio/webm"});
    audioPlayback.src = URL.createObjectURL(blob);
    audioPlayback.style.display = "block";
  };

  mediaRecorder.start();
  recording = true;
  liveTranscript = "";

  if(recognition){
    try{ recognition.start(); }catch(e){}
  }

  recBtn.classList.add("recording");
  recBtn.innerHTML = '<i class="fas fa-stop"></i>';

  // countdown
  secondsLeft = MAX_RECORD_SECONDS;
  recTimeEl.textContent = fmtMMSS(secondsLeft);

  clearCountdown();
  countdownInterval = setInterval(() => {
    secondsLeft--;
    if(secondsLeft <= 0){
      recTimeEl.textContent = "0:00";
      stopRecording(true);
      return;
    }
    recTimeEl.textContent = fmtMMSS(secondsLeft);
  }, 1000);
}

function stopRecording(isAuto=false){
  if(!recording) return;

  clearCountdown();

  try{
    if(mediaRecorder && mediaRecorder.state !== "inactive") mediaRecorder.stop();
  }catch(e){}

  if(recognition){
    try{ recognition.stop(); }catch(e){}
  }

  stopTracks();

  recording = false;
  retriesLeft = Math.max(0, retriesLeft - 1);
  retriesEl.textContent = String(retriesLeft);

  recBtn.classList.remove("recording");
  recBtn.innerHTML = '<i class="fas fa-microphone"></i>';

  // Show transcript if any
  const tr = (liveTranscript || "").trim();
  if(tr){
    transcriptText.textContent = tr;
    transcriptBox.style.display = "block";
  }else{
    transcriptBox.style.display = "none";
  }

  // Evaluate (demo)
  const evalRes = evaluateSpeaking(tr);
  scoreMini.textContent = `${evalRes.score}/5`;

  feedbackBox.style.display = "block";
  tipText.textContent = evalRes.tip;
  mistText.textContent = evalRes.mist;

  scoreBox.style.display = "block";
  scoreBox.textContent = `تقييمك التجريبي: ${evalRes.score} / 5 ⭐ (اعتمادًا على النص المكتوب — اربطيه بالـ AI لاحقًا)`;

  if(isAuto){
    showAlert("انتهى الوقت (40 ثانية) وتم حفظ التسجيل.", "ok");
  }else{
    showAlert("تم حفظ التسجيل. يمكنك اختيار تمرين جديد أو إعادة المحاولة (إن تبقى).", "ok");
  }
}

function evaluateSpeaking(transcript){
  // demo scoring:
  // + طول الكلام (عدد كلمات)
  // + وجود linking words
  const t = (transcript || "").trim();
  const words = t ? t.split(/\s+/).length : 0;

  const linking = ["because","so","however","also","first","then","finally","for example"];
  let linkHits = 0;
  const low = t.toLowerCase();
  linking.forEach(w => { if(low.includes(w)) linkHits++; });

  let score = 1;
  if(words >= 15) score = 2;
  if(words >= 35) score = 3;
  if(words >= 60) score = 4;
  if(words >= 80 && linkHits >= 2) score = 5;
  if(words === 0) score = 1;

  let tip = "حاولي تتكلمي بجمل كاملة: Subject + Verb + Object.";
  if(words >= 35) tip = "ممتاز! زيدي استخدام كلمات الربط مثل: because, so, however.";
  if(words >= 60) tip = "رائع! حاولي إضافة مثال واحد (for example) وتحديد بداية/نهاية واضحة.";

  let mist = "نصيحة: تجنبي التوقف الطويل، ولو نسيتي كلمة استخدمي كلمة أسهل.";
  if(!t) mist = "لم يظهر نص مكتوب (قد لا يدعم المتصفح Speech-to-Text). ركزي على وضوح النطق.";

  return {score, tip, mist};
}

recBtn.addEventListener('click', async () => {
  if(!currentType){
    showAlert("اختاري مستوى أولاً ثم اضغطي ابدأ.", "warn");
    return;
  }
  if(!recording) await startRecording();
  else stopRecording(false);
});
</script>

</body>
</html>