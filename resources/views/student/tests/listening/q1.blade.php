<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Listening - Question 1</title>

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
  padding: 26px 18px 22px;
  overflow-x:hidden;
  position:relative;
}

/* Glow */
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

/* Fixed top bar */
.topbar{
  position: sticky;
  top: 0;
  z-index: 50;
  padding: 10px 0 14px;
  backdrop-filter: blur(10px);
}
.topbar-inner{
  max-width: 1200px;
  margin: 0 auto;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap: 12px;
}
.left-info{
  display:flex;
  align-items:center;
  gap: 10px;
  min-width: 220px;
}
.badge{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding: 10px 14px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color: var(--muted);
  font-weight: 800;
  font-size: 13px;
}

.progress{
  flex: 1;
  height: 10px;
  border-radius: 999px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.12);
  overflow:hidden;
}
.progress > span{
  display:block;
  height: 100%;
  width: 10%; /* Q1 of 10 */
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  border-radius: 999px;
}

.right-actions{
  display:flex;
  align-items:center;
  gap: 10px;
  min-width: 220px;
  justify-content:flex-end;
}
.timer{
  padding: 10px 14px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color: var(--muted);
  font-weight: 900;
  font-size: 13px;
}

/* Main shell */
.shell{
  max-width: 1200px;
  margin: 0 auto;
}

/* Layout like screenshot */
.main{
  display:grid;
  grid-template-columns: 1.05fr .95fr;
  gap: 16px;
  align-items:start;
  margin-top: 10px;
}

/* Cards */
.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
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
  font-weight: 900;
  color: #eafcff;
}
.card-head p{
  margin: 6px 0 0;
  font-size: 13px;
  color: var(--muted2);
  line-height: 1.6;
}

/* Player panel */
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
.meta-line small{
  color: var(--muted2);
  font-weight: 700;
}
.time-line{
  font-weight: 900;
  letter-spacing: .2px;
}

/* Questions column */
.qscroll{
  max-height: calc(100vh - 160px);
  overflow:auto;
  padding: 18px;
  scrollbar-width: thin;
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

.footer{
  margin-top: 14px;
  display:flex;
  justify-content:flex-end;
}
.next{
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
.next:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}
.next:disabled{
  opacity: .55;
  cursor:not-allowed;
  transform:none;
  box-shadow:none;
}

@media (max-width: 980px){
  .main{ grid-template-columns: 1fr; }
  .qscroll{ max-height: none; }
}
</style>
</head>

<body>
<div class="light"></div>

<div class="topbar">
  <div class="topbar-inner shell">
    <div class="left-info">
      <div class="badge" id="sectionBadge">🎧 Listening</div>
    </div>

    <div class="progress" aria-label="Progress">
      <span></span>
    </div>

    <div class="right-actions">
      <div class="timer" id="timerBox">Time: <span id="timer">20:00</span></div>
    </div>
  </div>
</div>

<div class="shell">
  <div class="main">

    <div class="card">
      <div class="card-head">
        <h2 id="insTitle">You will hear ten speakers. Choose the best option for what comes next.</h2>
        <p id="insDesc">You can play the recording <b>TWO</b> times.</p>
      </div>

      <div class="player">
        <button class="play-btn" id="playBtn" type="button" aria-label="Play audio">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M8 5v14l11-7-11-7z" fill="white"/>
          </svg>
        </button>

        <div class="player-meta">
          <div class="meta-line"><span id="playsLabel">Plays left:</span> <span id="playsLeft">2</span></div>
          <div class="time-line"><span id="curTime">00:00</span> / <span id="durTime">00:00</span></div>
          <small style="color: var(--muted2);" id="hintLine">Select answers on the right, then press Next.</small>
        </div>
      </div>

      <audio id="audio" preload="metadata">
        <source src="{{ asset('audio/audioQ1.mp3') }}" type="audio/mpeg">
      </audio>

      <div class="card-pad" style="padding-top:0;">
        <div style="height: 1px; background: rgba(255,255,255,0.10); margin: 0 0 14px;"></div>
        <p style="margin:0; color: var(--muted); font-size: 13.5px; line-height:1.7;" id="noteLine">
          Tip: Use both plays if you need to confirm details. You cannot go back after submitting.
        </p>
      </div>
    </div>

    <!-- ✅ RIGHT: Questions -->
    <form class="card" method="POST" action="{{ route('listening.submit', ['q' => 'q1']) }}">
      @csrf
      <div class="qscroll">
        <div class="qwrap">

          <!-- Speaker 1 -->
          <div class="qbox">
            <p class="qtitle" id="q1Title">What is the best response to Speaker 1?</p>
            <label class="option"><input type="radio" name="s1" value="a" required><span id="s1a">I went to the gym.</span></label>
            <label class="option"><input type="radio" name="s1" value="b"><span id="s1b">It’s on Monday morning.</span></label>
            <label class="option"><input type="radio" name="s1" value="c"><span id="s1c">Yes, I can.</span></label>
            <label class="option"><input type="radio" name="s1" value="d"><span id="s1d">That’s a good idea.</span></label>
          </div>

          <!-- Speaker 2 -->
          <div class="qbox">
            <p class="qtitle" id="q2Title">What is the best response to Speaker 2?</p>
            <label class="option"><input type="radio" name="s2" value="a" required><span id="s2a">I’m from Austria too.</span></label>
            <label class="option"><input type="radio" name="s2" value="b"><span id="s2b">I don’t like cold weather.</span></label>
            <label class="option"><input type="radio" name="s2" value="c"><span id="s2c">At five o’clock.</span></label>
            <label class="option"><input type="radio" name="s2" value="d"><span id="s2d">That’s expensive.</span></label>
          </div>

          <!-- Speaker 3 -->
          <div class="qbox">
            <p class="qtitle" id="q3Title">What is the best response to Speaker 3?</p>
            <label class="option"><input type="radio" name="s3" value="a" required><span id="s3a">Yes, please. I’ll have tea with milk.</span></label>
            <label class="option"><input type="radio" name="s3" value="b"><span id="s3b">I’m going to a café later.</span></label>
            <label class="option"><input type="radio" name="s3" value="c"><span id="s3c">I don’t eat breakfast.</span></label>
            <label class="option"><input type="radio" name="s3" value="d"><span id="s3d">It was on the table.</span></label>
          </div>

          <!-- Speaker 4 -->
          <div class="qbox">
            <p class="qtitle" id="q4Title">What is the best response to Speaker 4?</p>
            <label class="option"><input type="radio" name="s4" value="a" required><span id="s4a">Here you are—£15.</span></label>
            <label class="option"><input type="radio" name="s4" value="b"><span id="s4b">It’s really lovely.</span></label>
            <label class="option"><input type="radio" name="s4" value="c"><span id="s4c">I can’t swim.</span></label>
            <label class="option"><input type="radio" name="s4" value="d"><span id="s4d">That’s my favorite song.</span></label>
          </div>

          <!-- Speaker 5 -->
          <div class="qbox">
            <p class="qtitle" id="q5Title">What is the best response to Speaker 5?</p>
            <label class="option"><input type="radio" name="s5" value="a" required><span id="s5a">It’s half past nine.</span></label>
            <label class="option"><input type="radio" name="s5" value="b"><span id="s5b">It’s ten degrees.</span></label>
            <label class="option"><input type="radio" name="s5" value="c"><span id="s5c">It’s the number eleven.</span></label>
            <label class="option"><input type="radio" name="s5" value="d"><span id="s5d">It’s next to the bank.</span></label>
          </div>

          <!-- Speaker 6 -->
          <div class="qbox">
            <p class="qtitle" id="q6Title">What is the best response to Speaker 6?</p>
            <label class="option"><input type="radio" name="s6" value="a" required><span id="s6a">Yes, please. Could you repeat that?</span></label>
            <label class="option"><input type="radio" name="s6" value="b"><span id="s6b">I played football yesterday.</span></label>
            <label class="option"><input type="radio" name="s6" value="c"><span id="s6c">It’s made of wood.</span></label>
            <label class="option"><input type="radio" name="s6" value="d"><span id="s6d">I can drive.</span></label>
          </div>

          <!-- Speaker 7 -->
          <div class="qbox">
            <p class="qtitle" id="q7Title">What is the best response to Speaker 7?</p>
            <label class="option"><input type="radio" name="s7" value="a" required><span id="s7a">Sorry, I can’t today. How about tomorrow?</span></label>
            <label class="option"><input type="radio" name="s7" value="b"><span id="s7b">I live near the park.</span></label>
            <label class="option"><input type="radio" name="s7" value="c"><span id="s7c">It’s a blue jacket.</span></label>
            <label class="option"><input type="radio" name="s7" value="d"><span id="s7d">Because I was hungry.</span></label>
          </div>

          <!-- Speaker 8 -->
          <div class="qbox">
            <p class="qtitle" id="q8Title">What is the best response to Speaker 8?</p>
            <label class="option"><input type="radio" name="s8" value="a" required><span id="s8a">Really? What does it look like?</span></label>
            <label class="option"><input type="radio" name="s8" value="b"><span id="s8b">These are too big for her.</span></label>
            <label class="option"><input type="radio" name="s8" value="c"><span id="s8c">She won’t like the color.</span></label>
            <label class="option"><input type="radio" name="s8" value="d"><span id="s8d">I don’t wear hats.</span></label>
          </div>

          <!-- Speaker 9 -->
          <div class="qbox">
            <p class="qtitle" id="q9Title">What is the best response to Speaker 9?</p>
            <label class="option"><input type="radio" name="s9" value="a" required><span id="s9a">Yes, it finally arrived.</span></label>
            <label class="option"><input type="radio" name="s9" value="b"><span id="s9b">Yes, it was a fast trip.</span></label>
            <label class="option"><input type="radio" name="s9" value="c"><span id="s9c">Yes, it was a long journey.</span></label>
            <label class="option"><input type="radio" name="s9" value="d"><span id="s9d">Yes, it’s my new phone.</span></label>
          </div>

          <!-- Speaker 10 -->
          <div class="qbox">
            <p class="qtitle" id="q10Title">What is the best response to Speaker 10?</p>
            <label class="option"><input type="radio" name="s10" value="a" required><span id="s10a">Yes, they look like their father.</span></label>
            <label class="option"><input type="radio" name="s10" value="b"><span id="s10b">I saw them yesterday.</span></label>
            <label class="option"><input type="radio" name="s10" value="c"><span id="s10c">My mother does.</span></label>
            <label class="option"><input type="radio" name="s10" value="d"><span id="s10d">It starts at noon.</span></label>
          </div>

          <div class="footer">
            <button class="next" type="submit" id="nextBtn">Next</button>
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

</body>
</html>