<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Listening - Question 2</title>

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
    radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.16), transparent 60%),
    radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.12), transparent 55%),
    var(--bg);
  font-family:"Poppins","Tajawal",Arial,sans-serif;
  color:var(--text);
  overflow-x:hidden;
  position:relative;
  padding: 92px 18px 22px;
}

/* Soft Glow */
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

/* Top fixed bar */
.topbar{
  position: fixed;
  top: 14px;
  left: 18px;
  right: 18px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  z-index: 20;
}

.pill{
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color:#fff;
  padding: 10px 14px;
  border-radius: 14px;
  font-size: 14px;
  text-decoration:none;
  cursor:pointer;
  transition: transform .18s ease, background .18s ease;
  backdrop-filter: blur(10px);
  display:inline-flex;
  align-items:center;
  gap:8px;
  user-select:none;
}
.pill:hover{
  transform: translateY(-1px);
  background: rgba(255,255,255,0.11);
}
.pill.primary{
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  font-weight: 800;
}
.timerBox{
  font-weight: 800;
  color: rgba(255,255,255,0.88);
}

/* Layout */
.shell{
  max-width: 1200px;
  margin: 0 auto;
}

.grid{
  display:grid;
  grid-template-columns: 1.05fr .95fr;
  gap: 16px;
  align-items:start;
}

/* Card */
.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
  animation: fadeIn .9s ease-in-out;
}
@keyframes fadeIn{
  from { opacity:0; transform: translateY(12px); }
  to { opacity:1; transform: translateY(0); }
}
.cardPad{ padding: 18px; }
.cardHead{
  padding: 16px 18px;
  border-bottom: 1px solid rgba(255,255,255,0.10);
  background: rgba(0,0,0,0.10);
}
.cardHead h2{
  margin:0 0 6px;
  font-size: 14.5px;
  font-weight: 900;
  color: #eafcff;
}
.cardHead p{
  margin:0;
  font-size: 13px;
  color: var(--muted2);
  line-height: 1.6;
}

/* Audio panel */
.audioWrap{
  display:flex;
  gap: 14px;
  align-items:center;
  margin-top: 10px;
}

.playBtn{
  width: 72px;
  height: 72px;
  border-radius: 999px;
  border: 1px solid rgba(0,198,255,0.35);
  background: rgba(0,198,255,0.14);
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
  user-select:none;
}
.playBtn:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(0,200,255,0.18);
  background: rgba(0,198,255,0.18);
}
.playBtn:disabled{
  opacity: .55;
  cursor:not-allowed;
  transform:none;
  box-shadow:none;
}
.playIcon{
  font-size: 22px;
  transform: translateX(2px);
}
.audioMeta{
  display:flex;
  flex-direction:column;
  gap: 6px;
}
.metaRow{
  font-size: 13px;
  color: var(--muted);
  font-weight: 700;
}
.progress{
  width: min(380px, 100%);
  height: 10px;
  border-radius: 999px;
  background: rgba(255,255,255,0.10);
  overflow:hidden;
  border: 1px solid rgba(255,255,255,0.10);
}
.bar{
  height: 100%;
  width: 0%;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
}

/* Questions scroll */
.qscroll{
  max-height: calc(100vh - 180px);
  overflow:auto;
  padding-right: 6px;
}
.qscroll::-webkit-scrollbar{ width: 10px; }
.qscroll::-webkit-scrollbar-thumb{
  background: rgba(255,255,255,0.12);
  border-radius: 999px;
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
}

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
  color: rgba(255,255,255,0.84);
}

.footer{
  margin-top: 14px;
  display:flex;
  justify-content:flex-end;
}
.nextBtn{
  border:none;
  border-radius: 999px;
  padding: 12px 22px;
  font-weight: 900;
  font-size: 14px;
  color:#fff;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  cursor:pointer;
  transition: transform .18s ease, box-shadow .18s ease;
}
.nextBtn:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

@media (max-width: 980px){
  .grid{ grid-template-columns: 1fr; }
  .qscroll{ max-height: none; }
}
</style>
</head>

<body>
<div class="light"></div>

<!-- Top bar (fixed) -->
<div class="topbar">
  <div class="pill timerBox" id="timerBox">Time: <span id="timer">20:00</span></div>
</div>

<div class="shell">
  <div class="grid">

    <!-- LEFT: Audio / Instructions -->
    <div class="card">
      <div class="cardHead">
        <h2 id="leftTitle">Listening</h2>
        <p id="leftDesc">
          You will hear a man and a woman talking about taking breaks at work. Choose the best answer for each question.
          There are 4 questions. You can play the recording <strong>TWO</strong> times.
        </p>
      </div>

      <div class="cardPad">
        <div class="audioWrap">
          <button class="playBtn" id="playBtn" type="button" onclick="togglePlay()">
            <span class="playIcon" id="playIcon">▶</span>
          </button>

          <div class="audioMeta">
            <div class="metaRow">
              <span id="playsLabel">Plays left:</span> <span id="playsLeft">2</span>
            </div>
            <div class="metaRow">
              <span id="timeNow">00:00</span> / <span id="timeTotal">00:00</span>
            </div>
            <div class="progress" aria-label="audio progress">
              <div class="bar" id="bar"></div>
            </div>
          </div>
        </div>

        <!-- Audio (file name: audioQ2.mp3) -->
        <audio id="audio" preload="metadata">
          <source src="{{ asset('audio/audioQ2.mp3') }}" type="audio/mpeg">
        </audio>
      </div>
    </div>

    <!-- ✅ RIGHT: Questions (Finish -> listeningdone) -->
    <form class="card" method="POST" action="{{ route('listening.submit', ['q' => 'q2']) }}">
      @csrf

      <div class="qscroll">
        <div class="cardPad">
          <div class="qwrap">

            <!-- Q1 -->
            <div class="qbox">
              <p class="qtitle" id="q1">1. Why does the man mention Facebook?</p>

              <label class="option">
                <input type="radio" name="q1" value="a" required>
                <span id="q1a">To provide evidence that people secretly browse Facebook at work</span>
              </label>
              <label class="option">
                <input type="radio" name="q1" value="b">
                <span id="q1b">To confess that he browses social media websites throughout the day</span>
              </label>
              <label class="option">
                <input type="radio" name="q1" value="c">
                <span id="q1c">To show that people get distracted toward the end of the day</span>
              </label>
              <label class="option">
                <input type="radio" name="q1" value="d">
                <span id="q1d">To prove that people post updates on Facebook during coffee breaks</span>
              </label>
            </div>

            <!-- Q2 -->
            <div class="qbox">
              <p class="qtitle" id="q2">2. Which statement would the woman most likely agree with?</p>

              <label class="option">
                <input type="radio" name="q2" value="a" required>
                <span id="q2a">How working people feel about breaks varies by country.</span>
              </label>
              <label class="option">
                <input type="radio" name="q2" value="b">
                <span id="q2b">It is critical to finish all assigned tasks before the end of the work day.</span>
              </label>
              <label class="option">
                <input type="radio" name="q2" value="c">
                <span id="q2c">The man’s boss will be annoyed because he takes so many breaks.</span>
              </label>
              <label class="option">
                <input type="radio" name="q2" value="d">
                <span id="q2d">Taking a break with a colleague makes work more enjoyable.</span>
              </label>
            </div>

            <!-- Q3 -->
            <div class="qbox">
              <p class="qtitle" id="q3">3. According to the man, what is a likely behavior of an American worker?</p>

              <label class="option">
                <input type="radio" name="q3" value="a" required>
                <span id="q3a">Inviting a colleague to take a break</span>
              </label>
              <label class="option">
                <input type="radio" name="q3" value="b">
                <span id="q3b">Working through lunch</span>
              </label>
              <label class="option">
                <input type="radio" name="q3" value="c">
                <span id="q3c">Leaving work right at 5 p.m.</span>
              </label>
              <label class="option">
                <input type="radio" name="q3" value="d">
                <span id="q3d">Drinking coffee while working</span>
              </label>
            </div>

            <!-- Q4 -->
            <div class="qbox">
              <p class="qtitle" id="q4">4. Why did the woman suggest the man should find a job in Sweden?</p>

              <label class="option">
                <input type="radio" name="q4" value="a" required>
                <span id="q4a">Because he has Swedish friends</span>
              </label>
              <label class="option">
                <input type="radio" name="q4" value="b">
                <span id="q4b">Because he admires Swedish culture</span>
              </label>
              <label class="option">
                <input type="radio" name="q4" value="c">
                <span id="q4c">Because he does not like working at an American company</span>
              </label>
              <label class="option">
                <input type="radio" name="q4" value="d">
                <span id="q4d">Because he wants to increase his productivity</span>
              </label>
            </div>

            <div class="footer">
              <button class="nextBtn" type="submit" id="submitBtn">Finish</button>
            </div>

          </div>
        </div>
      </div>
    </form>

  </div>
</div>

<script>
(function preventBack(){
  history.pushState(null, "", location.href);
  window.addEventListener('popstate', function () {
    history.pushState(null, "", location.href);
  });
})();

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

const audio = document.getElementById('audio');
const playBtn = document.getElementById('playBtn');
const playIcon = document.getElementById('playIcon');
const playsLeftEl = document.getElementById('playsLeft');
const timeNowEl = document.getElementById('timeNow');
const timeTotalEl = document.getElementById('timeTotal');
const bar = document.getElementById('bar');

let playsLeft = 2;
let startedThisPlay = false;

function fmt(sec){
  if (!isFinite(sec)) return "00:00";
  sec = Math.max(0, Math.floor(sec));
  const m = String(Math.floor(sec/60)).padStart(2,'0');
  const s = String(sec%60).padStart(2,'0');
  return `${m}:${s}`;
}

audio.addEventListener('loadedmetadata', () => {
  timeTotalEl.textContent = fmt(audio.duration);
});

audio.addEventListener('timeupdate', () => {
  timeNowEl.textContent = fmt(audio.currentTime);
  const pct = audio.duration ? (audio.currentTime / audio.duration) * 100 : 0;
  bar.style.width = `${pct}%`;
});

audio.addEventListener('ended', () => {
  playIcon.textContent = "▶";
  startedThisPlay = false;
  if (playsLeft <= 0) {
    playBtn.disabled = true;
  }
});

function togglePlay(){
  if (playsLeft <= 0) return;

  if (audio.paused){
    if (!startedThisPlay) {
      playsLeft--;
      playsLeftEl.textContent = playsLeft;
      startedThisPlay = true;
    }
    audio.play();
    playIcon.textContent = "⏸";
  } else {
    audio.pause();
    playIcon.textContent = "▶";
  }
}

let lang = "en";

function setArabic(){
  document.getElementById('leftTitle').innerText = "الاستماع";
  document.getElementById('leftDesc').innerHTML =
    "سوف تستمع إلى رجل وامرأة يتحدثان عن أخذ فترات راحة في العمل. اختر أفضل إجابة لكل سؤال. " +
    "يوجد 4 أسئلة. يمكنك تشغيل التسجيل <strong>مرتين</strong>.";

  document.getElementById('playsLabel').innerText = "عدد مرات التشغيل المتبقية:";
  document.getElementById('q1').innerText = "1. لماذا ذكر الرجل فيسبوك؟";
  document.getElementById('q1a').innerText = "لتقديم دليل أن الناس يتصفحون فيسبوك سرًا أثناء العمل";
  document.getElementById('q1b').innerText = "ليعترف أنه يتصفح مواقع التواصل طوال اليوم";
  document.getElementById('q1c').innerText = "ليُظهر أن الناس يتشتتون قرب نهاية اليوم";
  document.getElementById('q1d').innerText = "ليثبت أن الناس ينشرون تحديثات أثناء استراحة القهوة";

  document.getElementById('q2').innerText = "2. أي عبارة من المرجح أن توافق عليها المرأة؟";
  document.getElementById('q2a').innerText = "تختلف نظرة الناس للاستراحات من بلد لآخر.";
  document.getElementById('q2b').innerText = "من الضروري إنهاء كل المهام قبل نهاية يوم العمل.";
  document.getElementById('q2c').innerText = "رئيس الرجل سيَنزعج لأنه يأخذ الكثير من الاستراحات.";
  document.getElementById('q2d').innerText = "أخذ استراحة مع زميل يجعل العمل أكثر متعة.";

  document.getElementById('q3').innerText = "3. بحسب الرجل، ما سلوك شائع للعامل الأمريكي؟";
  document.getElementById('q3a').innerText = "دعوة زميل لأخذ استراحة";
  document.getElementById('q3b').innerText = "العمل أثناء الغداء";
  document.getElementById('q3c').innerText = "مغادرة العمل تمامًا عند الخامسة";
  document.getElementById('q3d').innerText = "شرب القهوة أثناء العمل";

  document.getElementById('q4').innerText = "4. لماذا اقترحت المرأة أن يبحث الرجل عن وظيفة في السويد؟";
  document.getElementById('q4a').innerText = "لأنه لديه أصدقاء سويديون";
  document.getElementById('q4b').innerText = "لأنه يُعجب بالثقافة السويدية";
  document.getElementById('q4c').innerText = "لأنه لا يحب العمل في شركة أمريكية";
  document.getElementById('q4d').innerText = "لأنه يريد زيادة إنتاجيته";

  document.getElementById('submitBtn').innerText = "إنهاء";
  document.getElementById('translateBtn').innerText = "English";

  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
  lang = "ar";
}

function setEnglish(){
  document.getElementById('leftTitle').innerText = "Listening";
  document.getElementById('leftDesc').innerHTML =
    "You will hear a man and a woman talking about taking breaks at work. Choose the best answer for each question. " +
    "There are 4 questions. You can play the recording <strong>TWO</strong> times.";

  document.getElementById('playsLabel').innerText = "Plays left:";
  document.getElementById('q1').innerText = "1. Why does the man mention Facebook?";
  document.getElementById('q1a').innerText = "To provide evidence that people secretly browse Facebook at work";
  document.getElementById('q1b').innerText = "To confess that he browses social media websites throughout the day";
  document.getElementById('q1c').innerText = "To show that people get distracted toward the end of the day";
  document.getElementById('q1d').innerText = "To prove that people post updates on Facebook during coffee breaks";

  document.getElementById('q2').innerText = "2. Which statement would the woman most likely agree with?";
  document.getElementById('q2a').innerText = "How working people feel about breaks varies by country.";
  document.getElementById('q2b').innerText = "It is critical to finish all assigned tasks before the end of the work day.";
  document.getElementById('q2c').innerText = "The man’s boss will be annoyed because he takes so many breaks.";
  document.getElementById('q2d').innerText = "Taking a break with a colleague makes work more enjoyable.";

  document.getElementById('q3').innerText = "3. According to the man, what is a likely behavior of an American worker?";
  document.getElementById('q3a').innerText = "Inviting a colleague to take a break";
  document.getElementById('q3b').innerText = "Working through lunch";
  document.getElementById('q3c').innerText = "Leaving work right at 5 p.m.";
  document.getElementById('q3d').innerText = "Drinking coffee while working";

  document.getElementById('q4').innerText = "4. Why did the woman suggest the man should find a job in Sweden?";
  document.getElementById('q4a').innerText = "Because he has Swedish friends";
  document.getElementById('q4b').innerText = "Because he admires Swedish culture";
  document.getElementById('q4c').innerText = "Because he does not like working at an American company";
  document.getElementById('q4d').innerText = "Because he wants to increase his productivity";

  document.getElementById('submitBtn').innerText = "Finish";
  document.getElementById('translateBtn').innerText = "Translate";

  document.body.setAttribute("dir","ltr");
  document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
  lang = "en";
}

function toggleLang(){
  if (lang === "en") setArabic();
  else setEnglish();
}
</script>

</body>
</html>