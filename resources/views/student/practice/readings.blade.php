<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>📖 تحسين مهارة القراءة - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
  --bg-dark:#000c1d;
  --card-bg: rgba(255,255,255,0.08);
  --reading-color:#6da1ff;
  --text:#fff;
  --radius:25px;
  --transition: all .25s ease;
  --stroke: rgba(255,255,255,0.14);
  --muted: rgba(255,255,255,0.75);
  --ok: #10b981;
  --bad:#ef4444;
}

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
  background: radial-gradient(circle, rgba(0, 198, 255, 0.12), transparent 70%);
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
  margin-bottom:20px;
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
  background: linear-gradient(135deg, var(--reading-color), #0072ff);
  border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:1.9rem;color:white;
}
.skill-title h1{
  color: var(--reading-color);
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
  border-right:4px solid var(--reading-color);
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
  border-color: rgba(109,161,255,0.55);
  box-shadow: 0 18px 34px rgba(109,161,255,0.12);
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
  background: linear-gradient(135deg, var(--reading-color), #0072ff);
  box-shadow: 0 10px 18px rgba(109,161,255,0.18);
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

.passage{
  padding:14px 14px;
  border-radius:18px;
  border:1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  line-height:1.9;
  color: rgba(255,255,255,0.86);
  margin-bottom:14px;
}

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
  border-color: rgba(109,161,255,0.55);
  background: rgba(109,161,255,0.08);
}
.option:last-child{ margin-bottom:0; }
.option input{ width:18px; height:18px; accent-color: #6da1ff; }
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
      <div class="skill-icon">📖</div>
      <div class="skill-title">
        <h1>تحسين مهارة القراءة</h1>
        <p class="sub">اختاري نوع تمرين وسيظهر لك نص + 5 أسئلة في نفس الصفحة.</p>
      </div>
    </div>

    <a href="{{ route('test.strengthening') }}" class="back-button">
      <i class="fas fa-arrow-right"></i> العودة للتقوية
    </a>
  </div>

  <!-- YouTube -->
  <div class="box">
    <h3>🎥 فيديوهات مقترحة (YouTube)</h3>
    <p class="small">قنوات وروابط سريعة تساعدك على تحسين القراءة والفهم.</p>

    <div class="grid">
      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> قناة</span>
        <h4>ZAmericanEnglish</h4>
        <p>ممتاز للمفردات + فهم النصوص + الجمل.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener" href="https://www.youtube.com/@ZAmericanEnglish">
            <i class="fas fa-play"></i> افتح القناة
          </a>
          <a class="btn btn-ghost" target="_blank" rel="noopener" href="https://www.youtube.com/results?search_query=ZAmericanEnglish+reading+english">
            <i class="fas fa-magnifying-glass"></i> بحث قراءة
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> قراءة</span>
        <h4>English Reading Practice (A1–B1)</h4>
        <p>فقرات قصيرة مع أسئلة فهم.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+reading+practice+A1+A2+B1+with+questions">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>

      <div class="card">
        <span class="tag"><i class="fa-brands fa-youtube"></i> أخبار</span>
        <h4>News Reading (Beginner)</h4>
        <p>تحسين الفهم من خلال أخبار مبسطة.</p>
        <div class="actions">
          <a class="btn btn-primary" target="_blank" rel="noopener"
             href="https://www.youtube.com/results?search_query=english+news+reading+comprehension+beginner">
            <i class="fas fa-play"></i> شاهد الآن
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Exercises -->
  <div class="box">
    <h3>🧩 التمارين داخل المنصة</h3>
    <p class="small">اضغطي على نوع التمرين وسيظهر لك نص + 5 أسئلة مباشرة داخل نفس الصفحة.</p>

    <div class="grid">
      <div class="card">
        <span class="tag">📄 سهل</span>
        <h4>فقرات قصيرة</h4>
        <p>نص بسيط + 5 أسئلة فهم.</p>
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
        <span class="tag">📰 متوسط</span>
        <h4>مقالات مبسطة</h4>
        <p>مقال قصير + 5 أسئلة.</p>
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
        <span class="tag">📚 متقدم</span>
        <h4>نصوص أكاديمية</h4>
        <p>نص أكاديمي قصير + 5 أسئلة.</p>
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
          <i class="fas fa-book-open"></i>
          <span id="exTitle">تمرين قراءة</span>
        </div>
        <div class="level" id="exLevel">—</div>
      </div>

      <div class="passage" id="exPassage">—</div>

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
/* ✅ بنك تمارين: كل تمرين يحتوي passage + 5 questions */
const bank = {
  easy: [
    {
      title:"فقرات قصيرة",
      level:"سهل",
      passage:"Sara goes to school every day. She likes English because it is fun. After school, she reads a short story. She sleeps early at night.",
      questions:[
        { q:"Where does Sara go every day?", options:{a:"To the park", b:"To school", c:"To the mall", d:"To the beach"}, correct:"b", explain:"في النص: Sara goes to school every day."},
        { q:"Why does she like English?", options:{a:"Because it is hard", b:"Because it is fun", c:"Because it is boring", d:"Because it is long"}, correct:"b", explain:"في النص: because it is fun."},
        { q:"What does she do after school?", options:{a:"Reads a short story", b:"Plays tennis", c:"Watches TV only", d:"Cooks food"}, correct:"a", explain:"في النص: After school, she reads a short story."},
        { q:"When does she sleep?", options:{a:"Very late", b:"Early at night", c:"In the morning", d:"At school"}, correct:"b", explain:"في النص: She sleeps early at night."},
        { q:"This text is mainly about…", options:{a:"Sara’s daily routine", b:"A scary movie", c:"A trip to London", d:"Cooking dinner"}, correct:"a", explain:"النص يتكلم عن يوم سارة."},
      ]
    },
    {
      title:"فقرات قصيرة",
      level:"سهل",
      passage:"Ali has a small cat. The cat is white and likes milk. Every morning, Ali feeds the cat before work. The cat sleeps on the sofa.",
      questions:[
        { q:"Who has a cat?", options:{a:"Sara", b:"Ali", c:"Omar", d:"Hana"}, correct:"b", explain:"في النص: Ali has a small cat."},
        { q:"What color is the cat?", options:{a:"Black", b:"Brown", c:"White", d:"Gray"}, correct:"c", explain:"في النص: The cat is white."},
        { q:"What does the cat like?", options:{a:"Milk", b:"Juice", c:"Pizza", d:"Rice"}, correct:"a", explain:"في النص: likes milk."},
        { q:"When does Ali feed the cat?", options:{a:"At night", b:"Every morning", c:"Every Friday", d:"Never"}, correct:"b", explain:"في النص: Every morning."},
        { q:"Where does the cat sleep?", options:{a:"On the sofa", b:"In a car", c:"At school", d:"In the garden"}, correct:"a", explain:"في النص: sleeps on the sofa."},
      ]
    }
  ],

  mid: [
    {
      title:"مقالات مبسطة",
      level:"متوسط",
      passage:"Many people enjoy drinking coffee. Some drink it to feel more awake, while others like the taste. However, too much coffee can cause trouble sleeping and may make some people feel nervous.",
      questions:[
        { q:"Why do some people drink coffee?", options:{a:"To feel more awake", b:"To sleep more", c:"To grow taller", d:"To stop studying"}, correct:"a", explain:"في النص: to feel more awake."},
        { q:"What else do people like about coffee?", options:{a:"Its color only", b:"Its taste", c:"Its sound", d:"Its price"}, correct:"b", explain:"في النص: others like the taste."},
        { q:"Too much coffee can cause…", options:{a:"Better sleep", b:"Trouble sleeping", c:"More dreams", d:"No energy"}, correct:"b", explain:"في النص: trouble sleeping."},
        { q:"How may coffee affect some people?", options:{a:"Make them feel nervous", b:"Make them sleepy", c:"Make them hungry", d:"Make them quiet"}, correct:"a", explain:"في النص: feel nervous."},
        { q:"Main idea of the text:", options:{a:"Coffee is always bad", b:"Coffee and its effects", c:"How to cook coffee", d:"Buying tea"}, correct:"b", explain:"النص يشرح لماذا الناس تشرب القهوة وتأثيرها."},
      ]
    },
    {
      title:"مقالات مبسطة",
      level:"متوسط",
      passage:"Recycling helps reduce waste. When we recycle paper, plastic, and glass, we use fewer new materials. This can protect the environment and save energy. Many cities provide recycling bins for homes.",
      questions:[
        { q:"Recycling helps reduce…", options:{a:"Water", b:"Waste", c:"Books", d:"Cars"}, correct:"b", explain:"في النص: reduce waste."},
        { q:"Recycling means using…", options:{a:"More new materials", b:"Fewer new materials", c:"Only metal", d:"Only food"}, correct:"b", explain:"في النص: use fewer new materials."},
        { q:"One benefit is to protect…", options:{a:"The environment", b:"The phone", c:"The TV", d:"The chair"}, correct:"a", explain:"في النص: protect the environment."},
        { q:"Another benefit is saving…", options:{a:"Money always", b:"Energy", c:"Time only", d:"Rain"}, correct:"b", explain:"في النص: save energy."},
        { q:"Many cities provide…", options:{a:"Recycling bins", b:"Free cars", c:"New houses", d:"More trash"}, correct:"a", explain:"في النص: provide recycling bins."},
      ]
    }
  ],

  adv: [
    {
      title:"نصوص أكاديمية",
      level:"متقدم",
      passage:"Critical thinking is the ability to analyze information objectively. It requires evaluating evidence, identifying assumptions, and forming reasoned conclusions rather than accepting claims without question. In education and work, it helps people solve problems effectively.",
      questions:[
        { q:"Critical thinking is mainly the ability to…", options:{a:"Analyze information objectively", b:"Memorize facts", c:"Ignore evidence", d:"Accept claims quickly"}, correct:"a", explain:"في النص: analyze information objectively."},
        { q:"It requires evaluating…", options:{a:"Only opinions", b:"Evidence", c:"Colors", d:"Prices"}, correct:"b", explain:"في النص: evaluating evidence."},
        { q:"It also requires identifying…", options:{a:"Assumptions", b:"Shoes", c:"Emails", d:"Songs"}, correct:"a", explain:"في النص: identifying assumptions."},
        { q:"It forms…", options:{a:"Random guesses", b:"Reasoned conclusions", c:"No conclusions", d:"Funny stories"}, correct:"b", explain:"في النص: forming reasoned conclusions."},
        { q:"Critical thinking helps people…", options:{a:"Solve problems effectively", b:"Sleep longer", c:"Avoid learning", d:"Forget tasks"}, correct:"a", explain:"في النص: solve problems effectively."},
      ]
    },
    {
      title:"نصوص أكاديمية",
      level:"متقدم",
      passage:"Globalization has increased connections between countries. While it can create economic opportunities, it may also widen inequality if benefits are not distributed fairly. Policies can influence whether globalization becomes more inclusive.",
      questions:[
        { q:"Globalization has increased…", options:{a:"Isolation", b:"Connections between countries", c:"No trade", d:"Less travel"}, correct:"b", explain:"في النص: increased connections."},
        { q:"One positive effect is…", options:{a:"Economic opportunities", b:"No jobs", c:"No products", d:"More borders"}, correct:"a", explain:"في النص: economic opportunities."},
        { q:"A possible negative effect is…", options:{a:"More fairness always", b:"Widening inequality", c:"Less inequality", d:"No change"}, correct:"b", explain:"في النص: widen inequality."},
        { q:"Inequality may widen if benefits are not…", options:{a:"Distributed fairly", b:"Painted blue", c:"Hidden", d:"Written"}, correct:"a", explain:"في النص: not distributed fairly."},
        { q:"What can influence inclusiveness?", options:{a:"Policies", b:"Music", c:"Weather", d:"Sports"}, correct:"a", explain:"في النص: Policies can influence..." },
      ]
    }
  ]
};

let currentType = null;
let currentIndex = 0;

function loadExercise(type, forceNew=false){
  currentType = type;

  if(!forceNew && document.getElementById('exerciseArea').style.display === 'block' && currentType === type){
    // لا شيء
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
  document.getElementById('exPassage').textContent = ex.passage;

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

  document.getElementById('summaryBox').style.display = 'none';
  document.getElementById('summaryBox').textContent = '';
}

function checkAll(){
  const ex = bank[currentType][currentIndex];
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
      res.textContent = `❌ لم تختاري إجابة. الصحيح هو (${correct.toUpperCase()}). ${explain}`;
      return;
    }

    if(selected.value === correct){
      correctCount++;
      res.className = 'qresult ok';
      res.textContent = `✅ صحيح. ${explain}`;
    }else{
      res.className = 'qresult bad';
      res.textContent = `❌ خطأ. الصحيح هو (${correct.toUpperCase()}). ${explain}`;
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