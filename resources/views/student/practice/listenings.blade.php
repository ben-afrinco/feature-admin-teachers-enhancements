<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تحسين مهارة الاستماع - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
  --bg-dark:#000c1d;
  --card-bg: rgba(255,255,255,0.08);
  --listening-color:#3d6dff;
  --text:#fff;
  --radius:25px;
  --transition: all .25s ease;
  --stroke: rgba(255,255,255,0.14);
  --muted: rgba(255,255,255,0.75);
  --ok: #10b981;
  --bad:#ef4444;
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
  background: radial-gradient(circle, rgba(61, 109, 255, 0.14), transparent 70%);
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
  box-shadow: 0 18px 35px rgba(61,109,255,0.14);
}
.skill-icon img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}
.skill-title h1{
  color: var(--listening-color);
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
  border-right:4px solid var(--listening-color);
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
  border-color: rgba(61,109,255,0.60);
  box-shadow: 0 18px 34px rgba(61,109,255,0.12);
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
  background: linear-gradient(135deg, var(--listening-color), #00c6ff);
  box-shadow: 0 10px 18px rgba(61,109,255,0.18);
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

/* Audio */
.audio-box{
  padding:14px;
  border-radius:18px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  margin-bottom:14px;
}
.audio-box p{
  margin:0 0 10px;
  color: rgba(255,255,255,0.82);
  font-weight:800;
  line-height:1.7;
}
.audio{
  width:100%;
  outline:none;
  filter: invert(1) hue-rotate(180deg);
}

/* Questions */
.qbox{
  padding:14px;
  border-radius:18px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.12);
  margin-bottom:12px;
}
.qtitle{
  margin:0 0 10px;
  font-weight:900;
  color:#eafcff;
}
.option{
  display:flex;
  gap:10px;
  align-items:center;
  padding:10px 10px;
  border-radius:14px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  cursor:pointer;
  margin-bottom:10px;
  transition: var(--transition);
}
.option:hover{
  border-color: rgba(61,109,255,0.60);
  background: rgba(61,109,255,0.10);
}
.option:last-child{ margin-bottom:0; }
.option input{ width:18px; height:18px; accent-color: var(--listening-color); }
.option span{ color: rgba(255,255,255,0.85); font-weight:700; }

.qresult{
  margin-top:10px;
  padding:10px 12px;
  border-radius:14px;
  border:1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color: rgba(255,255,255,0.86);
  font-weight:800;
  line-height:1.7;
  display:none;
}
.qresult.ok{
  border-color: rgba(16,185,129,0.35);
  background: rgba(16,185,129,0.12);
}
.qresult.bad{
  border-color: rgba(239,68,68,0.35);
  background: rgba(239,68,68,0.12);
}

.exercise-actions{
  margin-top:12px;
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  justify-content:flex-start;
}

.summary{
  margin-top:12px;
  padding:12px 12px;
  border-radius:16px;
  border:1px solid rgba(0,198,255,0.25);
  background: rgba(0,198,255,0.08);
  color: rgba(255,255,255,0.90);
  font-weight:900;
  line-height:1.7;
  display:none;
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
      <!-- ✅ بدل الإيموجي: listening.png -->
      <div class="skill-icon">
        <img src="{{ asset('images/listening.png') }}" alt="Listening">
      </div>
      <div class="skill-title">
        <h1>تحسين مهارة الاستماع</h1>
        <p class="sub">اختاري نوع تمرين وسيظهر لك مقطع صوت + 5 أسئلة في نفس الصفحة.</p>
      </div>
    </div>

    <a href="{{ route('test.strengthening') }}" class="back-button">
      <i class="fas fa-arrow-right"></i> العودة للتقوية
    </a>
  </div>

  <!-- YouTube -->
  <div class="box">
    <h3>🎥 روابط وقنوات مقترحة (YouTube)</h3>
    <p class="small">اختاري قناة/بحث سريع لممارسة الاستماع (مفيد للسهل–المتوسط–المتقدم).</p>

    <div class="grid">
      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> قناة</span>
        <h4>ZAmericanEnglish</h4>
        <p>شرح واضح وتمارين تساعد على فهم المحادثات.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener" href="https://www.youtube.com/@ZAmericanEnglish">
            <i class="fas fa-play"></i> افتح القناة
          </a>
          <a class="btn btn-ghost" target="_blank" rel="noopener" href="https://www.youtube.com/results?search_query=ZAmericanEnglish+listening+practice">
            <i class="fas fa-magnifying-glass"></i> بحث استماع
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> محادثات</span>
        <h4>English Listening Practice (Short Conversations)</h4>
        <p>محادثات قصيرة مع أسئلة فهم.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+listening+practice+short+conversations+with+questions">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> بودكاست</span>
        <h4>English Podcast (Beginner/Intermediate)</h4>
        <p>مقاطع أطول لتحسين التركيز والسرعة.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+podcast+beginner+intermediate+listening">
            <i class="fas fa-play"></i> استمع الآن
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> متقدم</span>
        <h4>TED-Ed / Talks Listening</h4>
        <p>فهم أفكار وسياق متقدم (مناسب للمتقدم).</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=TED+talks+listening+comprehension+questions">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Exercises -->
  <div class="box">
    <h3>🧩 التمارين داخل المنصة</h3>
    <p class="small">10 تمارين لكل مستوى (سهل – متوسط – متقدم). كل تمرين يحتوي مقطع صوت + 5 أسئلة + تصحيح فوري.</p>

    <div class="grid">
      <div class="card">
        <span class="tag">🎧 سهل</span>
        <h4>محادثات قصيرة</h4>
        <p>10 تمارين مختلفة — (Audio + 5 أسئلة).</p>
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
        <span class="tag">🎙️ متوسط</span>
        <h4>بودكاست تعليمي</h4>
        <p>10 تمارين مختلفة — (Audio + 5 أسئلة).</p>
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
        <span class="tag">🎬 متقدم</span>
        <h4>مقاطع متقدمة</h4>
        <p>10 تمارين مختلفة — (Audio + 5 أسئلة).</p>
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
          <i class="fas fa-headphones"></i>
          <span id="exTitle">تمرين استماع</span>
        </div>
        <div class="level" id="exLevel">—</div>
      </div>

      <div class="audio-box">
        <p id="audioHint">اضغطي تشغيل للاستماع ثم أجيبي على الأسئلة.</p>
        <audio class="audio" id="exAudio" controls preload="metadata">
          <source id="audioSrc" src="" type="audio/mpeg">
        </audio>
      </div>

      <div id="questionsWrap"></div>

      <div class="exercise-actions">
        <button class="btn btn-primary" type="button" onclick="checkAll()">
          <i class="fas fa-check"></i> تحقق
        </button>
        <button class="btn btn-ghost" type="button" onclick="nextExercise()">
          <i class="fas fa-shuffle"></i> تمرين جديد
        </button>
      </div>

      <div class="summary" id="summaryBox"></div>
    </div>
  </div>

</div>

<script>
/* ==================================================
   ✅ بنك تمارين الاستماع: 10 لكل مستوى
   كل تمرين: audio + 5 questions + correct + explain
   ملاحظة: غيّري روابط الصوت إلى ملفاتك داخل public
   ================================================== */

const bank = {
  easy: [
    makeEasy(1), makeEasy(2), makeEasy(3), makeEasy(4), makeEasy(5),
    makeEasy(6), makeEasy(7), makeEasy(8), makeEasy(9), makeEasy(10)
  ],
  mid: [
    makeMid(1), makeMid(2), makeMid(3), makeMid(4), makeMid(5),
    makeMid(6), makeMid(7), makeMid(8), makeMid(9), makeMid(10)
  ],
  adv: [
    makeAdv(1), makeAdv(2), makeAdv(3), makeAdv(4), makeAdv(5),
    makeAdv(6), makeAdv(7), makeAdv(8), makeAdv(9), makeAdv(10)
  ]
};

/* ===== مولدات جاهزة (عشان ما نكتب 30 تمرين يدوي هنا)
   ✅ كل تمرين مختلف بإسم وملف صوت مختلف
   ✅ الأسئلة ثابتة بالنمط لكن مختلفة بالمحتوى (يتغير رقم التمرين)
   - تقدر/ين لاحقًا تستبدليها بتمارينك الحقيقية نصًا وصوتًا
*/
function makeEasy(n){
  return {
    title:"محادثات قصيرة",
    level:"سهل",
    audio:`{{ asset('audio/listening/easy_${n}.mp3') }}`,
    questions:[
      { q:`What time is mentioned in the conversation (Easy ${n})?`, options:{a:"8:00", b:"9:00", c:"10:00", d:"11:00"}, correct:["a","b","c","d"][(n-1)%4], explain:"اختاري الوقت الذي سمعتيه في المقطع." },
      { q:`Where are the speakers (Easy ${n})?`, options:{a:"At a café", b:"At school", c:"At a shop", d:"At home"}, correct:["a","b","c","d"][n%4], explain:"انتبهي لكلمة المكان (café / school / shop / home)." },
      { q:`What does the woman want (Easy ${n})?`, options:{a:"Tea", b:"Coffee", c:"Water", d:"Juice"}, correct:["b","a","d","c"][n%4], explain:"ركزي على الطلب (drink)." },
      { q:`What will they do next (Easy ${n})?`, options:{a:"Meet later", b:"Call a friend", c:"Buy food", d:"Go home"}, correct:["a","b","c","d"][(n+1)%4], explain:"هذه أسئلة توقع/خطوة تالية من الحوار." },
      { q:`The conversation is mainly about (Easy ${n})…`, options:{a:"A plan", b:"A problem", c:"A trip", d:"A game"}, correct:["a","b","c","d"][(n+2)%4], explain:"الفكرة العامة تُفهم من الجمل الأساسية." },
    ]
  };
}

function makeMid(n){
  return {
    title:"بودكاست تعليمي",
    level:"متوسط",
    audio:`{{ asset('audio/listening/mid_${n}.mp3') }}`,
    questions:[
      { q:`What is the main topic (Mid ${n})?`, options:{a:"Health", b:"Study", c:"Travel", d:"Technology"}, correct:["b","a","d","c"][(n-1)%4], explain:"اسمعي الكلمات المتكررة لتحديد الموضوع." },
      { q:`One benefit mentioned is (Mid ${n})…`, options:{a:"Saving time", b:"Saving money", c:"Better sleep", d:"More exercise"}, correct:["a","b","c","d"][n%4], explain:"عادة يذكر المتحدث فائدة مباشرة." },
      { q:`What is a problem mentioned (Mid ${n})?`, options:{a:"Noise", b:"Stress", c:"Traffic", d:"Weather"}, correct:["b","c","a","d"][(n+1)%4], explain:"ركزي على كلمات مثل: problem / challenge / difficult." },
      { q:`What does the speaker recommend (Mid ${n})?`, options:{a:"Practice daily", b:"Stop trying", c:"Do nothing", d:"Only read"}, correct:["a","d","a","a"][n%4], explain:"عادة تأتي النصيحة بصيغة: should / recommend." },
      { q:`The speaker’s tone is (Mid ${n})…`, options:{a:"Encouraging", b:"Angry", c:"Sarcastic", d:"Confused"}, correct:"a", explain:"بودكاست تعليمي غالبًا نبرته مشجعة." },
    ]
  };
}

function makeAdv(n){
  return {
    title:"مقاطع متقدمة",
    level:"متقدم",
    audio:`{{ asset('audio/listening/adv_${n}.mp3') }}`,
    questions:[
      { q:`The speaker argues that (Adv ${n})…`, options:{a:"Evidence matters", b:"Opinions are enough", c:"Facts are useless", d:"No one should question"}, correct:"a", explain:"مقاطع متقدمة تركز على الحجة والدليل." },
      { q:`A key challenge mentioned is (Adv ${n})…`, options:{a:"Bias", b:"Hunger", c:"Sports", d:"Fashion"}, correct:"a", explain:"كلمات مثل bias / fairness تظهر كثيرًا." },
      { q:`What is the implied meaning (Adv ${n})?`, options:{a:"A cautious warning", b:"A joke", c:"A shopping offer", d:"A love story"}, correct:"a", explain:"الاستنتاج من السياق أهم من كلمة واحدة." },
      { q:`Which detail supports the main idea (Adv ${n})?`, options:{a:"An example", b:"A random name", c:"A color", d:"A song"}, correct:"a", explain:"الدعم يكون مثال/دليل." },
      { q:`Overall, the talk is about (Adv ${n})…`, options:{a:"Evaluating decisions", b:"Cooking recipes", c:"Football match", d:"Car engines"}, correct:"a", explain:"الفكرة العامة: اتخاذ قرار/تحليل." },
    ]
  };
}

/* ============================
   Rendering + Random
   ============================ */
let currentType = null;
let currentIndex = 0;

function loadExercise(type, forceNew=false){
  currentType = type;

  if(!forceNew && document.getElementById('exerciseArea').style.display === 'block' && currentType === type){
    // ابقي على نفس التمرين (لو ما ضغط "تمرين آخر")
  }else{
    currentIndex = Math.floor(Math.random() * bank[type].length);
  }

  renderExercise();

  const area = document.getElementById('exerciseArea');
  area.style.display = 'block';
  area.scrollIntoView({behavior:'smooth', block:'start'});
}

function renderExercise(){
  const ex = bank[currentType][currentIndex];

  document.getElementById('exTitle').textContent = ex.title;
  document.getElementById('exLevel').textContent = ex.level;

  // audio
  const audio = document.getElementById('exAudio');
  const src = document.getElementById('audioSrc');
  src.src = ex.audio;
  audio.load();

  const wrap = document.getElementById('questionsWrap');
  wrap.innerHTML = "";

  ex.questions.forEach((qq, idx) => {
    const n = idx + 1;

    const box = document.createElement('div');
    box.className = 'qbox';
    box.dataset.correct = qq.correct;
    box.dataset.explain = qq.explain;

    box.innerHTML = `
      <p class="qtitle">${n}) ${qq.q}</p>
      <label class="option"><input type="radio" name="q${idx}" value="a"><span>${qq.options.a}</span></label>
      <label class="option"><input type="radio" name="q${idx}" value="b"><span>${qq.options.b}</span></label>
      <label class="option"><input type="radio" name="q${idx}" value="c"><span>${qq.options.c}</span></label>
      <label class="option"><input type="radio" name="q${idx}" value="d"><span>${qq.options.d}</span></label>
      <div class="qresult" id="res${idx}"></div>
    `;

    wrap.appendChild(box);
  });

  const summary = document.getElementById('summaryBox');
  summary.style.display = 'none';
  summary.textContent = '';
}

function checkAll(){
  const qboxes = document.querySelectorAll('#questionsWrap .qbox');
  let correctCount = 0;

  qboxes.forEach((box, idx) => {
    const correct = box.dataset.correct;
    const explain = box.dataset.explain;

    const selected = box.querySelector(`input[name="q${idx}"]:checked`);
    const res = box.querySelector('.qresult');

    res.style.display = 'block';

    if(!selected){
      res.className = 'qresult bad';
      res.textContent = `❌ لم تختاري إجابة. الصحيح هو (${String(correct).toUpperCase()}). ${explain}`;
      return;
    }

    if(selected.value === correct){
      correctCount++;
      res.className = 'qresult ok';
      res.textContent = `✅ صحيح. ${explain}`;
    }else{
      res.className = 'qresult bad';
      res.textContent = `❌ خطأ. الصحيح هو (${String(correct).toUpperCase()}). ${explain}`;
    }
  });

  const summary = document.getElementById('summaryBox');
  summary.style.display = 'block';
  summary.textContent = `نتيجتك: ${correctCount} / 5 ✅`;
  summary.scrollIntoView({behavior:'smooth', block:'center'});
}

function nextExercise(){
  if(!currentType) return;

  let next = Math.floor(Math.random() * bank[currentType].length);
  if(bank[currentType].length > 1){
    while(next === currentIndex){
      next = Math.floor(Math.random() * bank[currentType].length);
    }
  }
  currentIndex = next;
  renderExercise();
  document.getElementById('exerciseArea').scrollIntoView({behavior:'smooth', block:'start'});
}
</script>

</body>
</html>