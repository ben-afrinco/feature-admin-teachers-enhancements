<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تحسين مهارة الكتابة - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
  --bg-dark:#000c1d;
  --card-bg: rgba(255,255,255,0.08);
  --writing-color:#8a84ff;
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
  background: radial-gradient(circle, rgba(138, 132, 255, 0.14), transparent 70%);
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
  box-shadow: 0 18px 35px rgba(138,132,255,0.14);
}
.skill-icon img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}
.skill-title h1{
  color: var(--writing-color);
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
  border-right:4px solid var(--writing-color);
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
  border-color: rgba(138,132,255,0.65);
  box-shadow: 0 18px 34px rgba(138,132,255,0.12);
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
  background: linear-gradient(135deg, var(--writing-color), #9d50bb);
  box-shadow: 0 10px 18px rgba(138,132,255,0.18);
}
.btn-primary:hover{ transform: translateY(-1px); }
.btn-ghost{
  background: rgba(255,255,255,0.10);
  border:1px solid rgba(255,255,255,0.14);
}
.btn-ghost:hover{ background: rgba(255,255,255,0.16); }

/* Writing Exercise Area */
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

textarea{
  width:100%;
  min-height: 190px;
  resize: vertical;
  border-radius:18px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.16);
  padding:14px 14px 44px;
  color: rgba(255,255,255,0.90);
  font-size: 14.5px;
  line-height:1.8;
  outline:none;
  transition: var(--transition);
  font-family: inherit;
}
textarea:focus{
  border-color: rgba(138,132,255,0.55);
  box-shadow: 0 0 0 3px rgba(138,132,255,0.12);
  background: rgba(0,0,0,0.20);
}

.helper-row{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  margin-top:10px;
  flex-wrap:wrap;
}
.counter{
  font-weight:900;
  color: rgba(255,255,255,0.72);
  font-size: 13px;
}

.alert{
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
.alert.warn{
  border-color: rgba(245,158,11,0.40);
  background: rgba(245,158,11,0.12);
}
.alert.bad{
  border-color: rgba(239,68,68,0.40);
  background: rgba(239,68,68,0.12);
}
.alert.ok{
  border-color: rgba(16,185,129,0.40);
  background: rgba(16,185,129,0.12);
}

.feedback{
  margin-top:12px;
  display:none;
  padding:14px;
  border-radius:18px;
  border:1px solid rgba(138,132,255,0.35);
  background: rgba(138,132,255,0.10);
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
.fb-title{
  font-weight:900;
  color: rgba(255,255,255,0.92);
  margin-bottom:6px;
}
.fb-text{
  color: rgba(255,255,255,0.82);
  line-height:1.7;
  font-weight:700;
}

.score{
  margin-top:10px;
  display:none;
  padding:12px;
  border-radius:16px;
  border:1px solid rgba(0,198,255,0.25);
  background: rgba(0,198,255,0.08);
  font-weight:900;
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
      <!-- ✅ بدل الإيموجي: writing.png -->
      <div class="skill-icon">
        <img src="{{ asset('images/writing.png') }}" alt="Writing">
      </div>
      <div class="skill-title">
        <h1>تحسين مهارة الكتابة</h1>
        <p class="sub">اختاري نوع تمرين، اكتبي الإجابة، وبعدها يظهر تصحيح فوري + شرح الأخطاء.</p>
      </div>
    </div>

    <a href="{{ route('test.strengthening') }}" class="back-button">
      <i class="fas fa-arrow-right"></i> العودة للتقوية
    </a>
  </div>

  <!-- YouTube -->
  <div class="box">
    <h3>🎥 روابط وقنوات مقترحة (YouTube)</h3>
    <p class="small">روابط تساعدك على تحسين الكتابة (قواعد + أمثلة + كتابة أكاديمية).</p>

    <div class="grid">
      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> قناة</span>
        <h4>ZAmericanEnglish</h4>
        <p>شرح واضح للقواعد والأخطاء الشائعة (مفيد جدًا للكتابة).</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener" href="https://www.youtube.com/@ZAmericanEnglish">
            <i class="fas fa-play"></i> افتح القناة
          </a>
          <a class="btn btn-ghost" target="_blank" rel="noopener" href="https://www.youtube.com/results?search_query=ZAmericanEnglish+english+grammar+writing">
            <i class="fas fa-magnifying-glass"></i> بحث كتابة
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> قواعد</span>
        <h4>English Grammar for Writing</h4>
        <p>شرح قواعد تساعدك في تكوين جمل صحيحة.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+grammar+for+writing+practice">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> أكاديمي</span>
        <h4>Academic Writing (Basics)</h4>
        <p>أساسيات الكتابة الأكاديمية وتنظيم الأفكار.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=academic+writing+basics+for+beginners">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Writing Exercises -->
  <div class="box">
    <h3>🧩 التمارين داخل المنصة</h3>
    <p class="small">10 تمارين لكل مستوى (سهل – متوسط – متقدم). كل تمرين: سؤال كتابة + تصحيح فوري + نتيجة.</p>

    <div class="grid">
      <div class="card">
        <span class="tag">📝 سهل</span>
        <h4>كتابة فقرات قصيرة</h4>
        <p>10 مواضيع بسيطة (60–90 كلمة).</p>
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
        <span class="tag">📧 متوسط</span>
        <h4>كتابة إيميلات</h4>
        <p>10 تمارين (90–140 كلمة).</p>
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
        <span class="tag">🖋️ متقدم</span>
        <h4>كتابة متقدمة</h4>
        <p>10 تمارين (140–200 كلمة).</p>
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
          <i class="fas fa-pen-nib"></i>
          <span id="exTitle">تمرين كتابة</span>
        </div>
        <div class="level" id="exLevel">—</div>
      </div>

      <div class="prompt" id="exPrompt">—</div>

      <textarea id="writingBox" placeholder="اكتبي إجابتك هنا باللغة الإنجليزية فقط..."></textarea>

      <div class="helper-row">
        <div class="counter" id="wordCounter">Words: 0</div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
          <button class="btn btn-primary" type="button" onclick="checkWriting()">
            <i class="fas fa-check"></i> تحقق
          </button>
          <button class="btn btn-ghost" type="button" onclick="nextExercise()">
            <i class="fas fa-shuffle"></i> تمرين جديد
          </button>
        </div>
      </div>

      <div class="alert warn" id="warnBox"></div>

      <!-- ✅ تصحيح + شرح -->
      <div class="feedback" id="feedbackBox">
        <h4>🛠️ تصحيح وشرح الأخطاء</h4>
        <div class="fb-item" id="fbCorrected" style="border-color: rgba(16,185,129,0.25); background: rgba(16,185,129,0.08);">
          <div class="fb-title">✅ نسخة مقترحة (أفضل)</div>
          <div class="fb-text" id="correctedText">—</div>
        </div>

        <div class="fb-item">
          <div class="fb-title">❗ أخطاء شائعة ظهرت في إجابتك</div>
          <div class="fb-text" id="errorsList">—</div>
        </div>

        <div class="fb-item">
          <div class="fb-title">📌 شرح سريع</div>
          <div class="fb-text" id="explainList">—</div>
        </div>
      </div>

      <div class="score" id="scoreBox"></div>
    </div>
  </div>

</div>

<script>
/* ==================================================
   ✅ Writing bank: 10 لكل مستوى
   كل تمرين: prompt + min/max words
   + تصحيح بسيط (rule-based) + درجة تقديرية
   ================================================== */

const writingBank = {
  easy: Array.from({length:10}, (_,i)=>({
    title:"كتابة فقرات قصيرة",
    level:"سهل",
    min:60, max:90,
    prompt: [
      "Write about your daily routine.",
      "Write about your favorite food and why you like it.",
      "Describe your best friend.",
      "Write about a place you like in your city.",
      "Write about your last weekend.",
      "Write about your favorite hobby.",
      "Write about a teacher you like.",
      "Describe your room.",
      "Write about your family.",
      "Write about your plans for next year."
    ][i]
  })),
  mid: Array.from({length:10}, (_,i)=>({
    title:"كتابة إيميلات",
    level:"متوسط",
    min:90, max:140,
    prompt: [
      "Write an email to your teacher asking for extra help.",
      "Write an email to a hotel to ask about prices and rooms.",
      "Write an email to a friend inviting them to an event.",
      "Write an email to your manager requesting a day off.",
      "Write an email to customer support about a problem you have.",
      "Write an email to a classmate about a group project.",
      "Write an email to a company asking about a job position.",
      "Write an email to your landlord about a repair.",
      "Write an email to a restaurant to reserve a table.",
      "Write an email thanking someone for their help."
    ][i]
  })),
  adv: Array.from({length:10}, (_,i)=>({
    title:"كتابة متقدمة",
    level:"متقدم",
    min:140, max:200,
    prompt: [
      "Write an opinion paragraph about online learning (pros/cons).",
      "Write about how technology changes communication.",
      "Write about the importance of time management.",
      "Write a short argumentative paragraph: Should students wear uniforms?",
      "Write about climate change and what people can do.",
      "Write about benefits and risks of social media.",
      "Write about the value of teamwork in workplaces.",
      "Write about how to stay healthy while studying/working.",
      "Write about traveling: how it can change your mindset.",
      "Write about the role of reading in personal growth."
    ][i]
  }))
};

let currentType = null;
let currentIndex = 0;

const writingBox = document.getElementById('writingBox');
const wordCounter = document.getElementById('wordCounter');
const warnBox = document.getElementById('warnBox');
const feedbackBox = document.getElementById('feedbackBox');
const scoreBox = document.getElementById('scoreBox');

writingBox.addEventListener('input', () => {
  wordCounter.textContent = "Words: " + countWords(writingBox.value);
});

function countWords(text){
  const t = text.trim();
  if(!t) return 0;
  return t.split(/\s+/).length;
}

function loadExercise(type, forceNew=false){
  currentType = type;

  if(!forceNew && document.getElementById('exerciseArea').style.display === 'block' && currentType === type){
    // keep
  }else{
    currentIndex = Math.floor(Math.random() * writingBank[type].length);
  }

  renderExercise();

  const area = document.getElementById('exerciseArea');
  area.style.display = 'block';
  area.scrollIntoView({behavior:'smooth', block:'start'});
}

function renderExercise(){
  const ex = writingBank[currentType][currentIndex];

  document.getElementById('exTitle').textContent = ex.title;
  document.getElementById('exLevel').textContent = ex.level;
  document.getElementById('exPrompt').textContent = ex.prompt;

  writingBox.value = "";
  wordCounter.textContent = "Words: 0";

  warnBox.style.display = "none";
  warnBox.textContent = "";

  feedbackBox.style.display = "none";
  scoreBox.style.display = "none";
  scoreBox.textContent = "";
}

function nextExercise(){
  if(!currentType) return;

  let next = Math.floor(Math.random() * writingBank[currentType].length);
  if(writingBank[currentType].length > 1){
    while(next === currentIndex){
      next = Math.floor(Math.random() * writingBank[currentType].length);
    }
  }
  currentIndex = next;
  renderExercise();
  document.getElementById('exerciseArea').scrollIntoView({behavior:'smooth', block:'start'});
}

/* ==================================================
   ✅ Simple "correction" (Rule-based)
   - هذا Front-end demo: لاحقًا تربطينه بـ AI / Backend
   ================================================== */
function checkWriting(){
  const ex = writingBank[currentType][currentIndex];
  const text = writingBox.value.trim();

  feedbackBox.style.display = "none";
  scoreBox.style.display = "none";

  if(!text){
    showWarn("اكتبي إجابة أولاً.");
    return;
  }

  // منع العربي (اختياري)
  const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
  if(arabicRegex.test(text)){
    showWarn("رجاءً اكتبي بالإنجليزية فقط (لا يوجد عربي).");
    return;
  }

  const words = countWords(text);
  if(words < ex.min){
    showWarn(`عدد الكلمات قليل. المطلوب تقريبًا بين ${ex.min} و ${ex.max} كلمة. (حاليًا: ${words})`);
    return;
  }
  if(words > ex.max){
    showWarn(`عدد الكلمات كبير. المطلوب تقريبًا بين ${ex.min} و ${ex.max} كلمة. (حاليًا: ${words})`);
    // نكمل لكن ننبه
  }else{
    warnBox.style.display = "none";
  }

  const analysis = analyzeText(text);

  // corrected version (simple)
  const corrected = applyFixes(text, analysis.fixes);

  // score (demo)
  let score = 5;
  score -= Math.min(3, analysis.errors.length);      // كل خطأ ينقص
  if(words > ex.max) score -= 1;
  if(score < 1) score = 1;

  document.getElementById('correctedText').textContent = corrected;

  document.getElementById('errorsList').innerHTML = analysis.errors.length
    ? ("<ul style='margin:0; padding-right:18px;'>" + analysis.errors.map(e=>`<li>${escapeHtml(e)}</li>`).join("") + "</ul>")
    : "✅ لا توجد أخطاء واضحة في القواعد البسيطة.";

  document.getElementById('explainList').innerHTML = analysis.explanations.length
    ? ("<ul style='margin:0; padding-right:18px;'>" + analysis.explanations.map(e=>`<li>${escapeHtml(e)}</li>`).join("") + "</ul>")
    : "👍 ممتاز! استمري على نفس الأسلوب.";

  feedbackBox.style.display = "block";

  scoreBox.style.display = "block";
  scoreBox.textContent = `نتيجتك التقديرية: ${score} / 5 ⭐ (تصحيح تجريبي — اربطيه بالـ AI لاحقًا)`;

  scoreBox.scrollIntoView({behavior:'smooth', block:'center'});
}

function showWarn(msg){
  warnBox.textContent = msg;
  warnBox.className = "alert warn";
  warnBox.style.display = "block";
  warnBox.scrollIntoView({behavior:'smooth', block:'center'});
}

function escapeHtml(s){
  return s.replace(/[&<>"']/g, (m) => ({
    "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  }[m]));
}

function analyzeText(text){
  const errors = [];
  const explanations = [];
  const fixes = [];

  // 1) common "i" => "I"
  if (/(^|\s)i(\s|')/g.test(text)) {
    errors.push("استخدمت حرف i صغير. الصحيح: I (حرف كبير).");
    explanations.push("ضمير المتكلم في الإنجليزية دائمًا يُكتب بحرف كبير: I.");
    fixes.push({type:"regex", from: /(^|\s)i(\s|')/g, to: "$1I$2"});
  }

  // 2) double spaces
  if (/\s{2,}/.test(text)) {
    errors.push("هناك مسافات زائدة بين الكلمات.");
    explanations.push("حاولي جعل المسافة واحدة بين الكلمات.");
    fixes.push({type:"regex", from: /\s{2,}/g, to: " "});
  }

  // 3) very common verb agreement demo: "He go" / "She go"
  if (/\b(he|she)\s+go\b/i.test(text)) {
    errors.push("خطأ في توافق الفعل: (He/She go) الصحيح: (He/She goes).");
    explanations.push("في المضارع البسيط، مع He/She/It نضيف s للفعل غالبًا.");
    fixes.push({type:"regex", from: /\b(he|she)\s+go\b/gi, to: (m)=> m.replace(/go/i,"goes")});
  }

  // 4) "a apple" => "an apple"
  if (/\ba\s+apple\b/i.test(text)) {
    errors.push("استخدمت a قبل كلمة تبدأ بحرف صوتي. الصحيح: an apple.");
    explanations.push("نستخدم an قبل الكلمات التي تبدأ بصوت حرف علّة (a,e,i,o,u).");
    fixes.push({type:"regex", from: /\ba\s+apple\b/gi, to: "an apple"});
  }

  // 5) sentence ending punctuation (simple)
  const endsOk = /[.!?]\s*$/.test(text);
  if (!endsOk){
    errors.push("حاولي إنهاء الفقرة بعلامة ترقيم مثل (.)");
    explanations.push("الترقيم يساعد على وضوح الكتابة.");
    fixes.push({type:"append", value:"."});
  }

  return {errors, explanations, fixes};
}

function applyFixes(original, fixes){
  let t = original;

  fixes.forEach(f => {
    if(f.type === "regex"){
      t = t.replace(f.from, f.to);
    }else if(f.type === "append"){
      if(!/[.!?]\s*$/.test(t)) t = t + f.value;
    }
  });

  // simple cleanup
  t = t.replace(/\s+\./g, ".").replace(/\s+,/g, ",");
  return t;
}
</script>

</body>
</html>