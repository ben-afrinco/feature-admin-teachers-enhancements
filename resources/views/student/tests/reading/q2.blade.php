<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reading - Question 2</title>

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
    radial-gradient(1200px 700px at 20% 10%, rgba(0,198,255,.18), transparent 60%),
    radial-gradient(900px 600px at 80% 70%, rgba(0,134,255,.14), transparent 55%),
    var(--bg);
  font-family:"Poppins","Tajawal",Arial,sans-serif;
  color:var(--text);
  padding: 96px 18px 22px;
  overflow:hidden; /* سكرول فقط داخل صندوق الأسئلة */
  position:relative;
}

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

/* Topbar */
.topbar{
  position: fixed;
  top: 14px;
  left: 18px;
  right: 18px;
  z-index: 999;
}
.topbar-inner{
  max-width: 1200px;
  margin: 0 auto;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
  padding: 12px 14px;
  border-radius: 18px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.07);
  backdrop-filter: blur(16px);
  box-shadow: 0 18px 55px rgba(0,180,255,0.10);
}
.title{
  margin:0;
  font-size: 14.5px;
  font-weight: 900;
  letter-spacing:.2px;
  color:#eafcff;
  display:flex;
  gap:10px;
  align-items:center;
  flex-wrap:wrap;
}
.badge{
  padding: 6px 10px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(0,0,0,0.18);
  color: rgba(255,255,255,0.78);
  font-size: 12px;
  font-weight: 800;
}
.actions{
  display:flex;
  align-items:center;
  gap:10px;
}
.timer{
  padding: 8px 12px;
  border-radius: 14px;
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(0,0,0,0.18);
  color: var(--muted);
  font-weight: 900;
  font-size: 13px;
}
.translate-btn{
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color:#fff;
  padding: 9px 14px;
  border-radius: 14px;
  font-weight: 900;
  cursor:pointer;
  backdrop-filter: blur(10px);
  transition:.2s;
}
.translate-btn:hover{ background: rgba(255,255,255,0.12); }

/* Shell */
.shell{
  max-width: 1200px;
  margin: 0 auto;
  height: calc(100vh - 96px - 22px);
}

/* Layout */
.main{
  height: 100%;
  display:grid;
  grid-template-columns: 1.15fr .85fr;
  gap: 16px;
  align-items:stretch;
}

/* Cards */
.card{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
  min-height: 0;
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

/* Passage */
.passage{
  font-size: 14.5px;
  line-height: 1.95;
  color: rgba(255,255,255,0.88);
}
.no-select{
  -webkit-user-select: none;
  user-select: none;
  -webkit-touch-callout: none;
}
.passage h3{
  margin: 0 0 10px;
  font-size: 14px;
  color: #cfefff;
}
.passage p{
  margin: 12px 0;
  color: rgba(255,255,255,0.82);
}

/* Questions scroll */
.qscroll{
  height: 100%;
  overflow:auto;
  padding: 18px;
}
.qscroll::-webkit-scrollbar{ width: 10px; }
.qscroll::-webkit-scrollbar-thumb{
  background: rgba(255,255,255,0.18);
  border-radius: 999px;
}
.qscroll::-webkit-scrollbar-track{
  background: rgba(0,0,0,0.10);
}

/* Questions */
.qwrap{ display:flex; flex-direction:column; gap: 14px; }
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

/* Footer sticky */
.footer{
  margin-top: 14px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap: 10px;
  position: sticky;
  bottom: 0;
  padding: 12px 0 6px;
  background: linear-gradient(to top, rgba(0,0,0,0.18), rgba(0,0,0,0));
}
.hint{
  font-size: 12.5px;
  color: rgba(255,255,255,0.65);
  font-weight: 700;
}
.btn{
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
.btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

/* Alert overlay */
#alertOverlay{
  display:none;
  position: fixed;
  top:0; left:0; right:0; bottom:0;
  background: rgba(0,0,0,0.78);
  z-index: 9999;
  justify-content:center;
  align-items:center;
  padding: 18px;
}
.alertCard{
  width: min(520px, 100%);
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.18);
  border-radius: 22px;
  backdrop-filter: blur(14px);
  box-shadow: 0 18px 55px rgba(0,0,0,0.35);
  padding: 18px;
  text-align:center;
}
.alertCard p{
  margin: 0 0 12px;
  font-weight: 900;
  color:#fff;
}
.alertBtn{
  border:none;
  border-radius: 999px;
  padding: 10px 18px;
  font-weight: 900;
  color:#fff;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  cursor:pointer;
}

@media (max-width: 980px){
  body{ overflow:auto; padding-top: 116px; }
  .shell{ height: auto; }
  .main{ grid-template-columns: 1fr; height:auto; }
  .qscroll{ height: auto; overflow: visible; padding: 18px; }
}
</style>
</head>

<body class="no-select">
<div class="light"></div>

<div class="topbar">
  <div class="topbar-inner">
    <div class="title">
      <span id="topTitle">Reading • Advanced • 10 Questions</span>
      <span class="badge" id="badge">Q2</span>
    </div>

    <div class="actions">
      <button class="translate-btn" type="button" onclick="toggleLang()" id="translateBtn">Translate</button>
      <div class="timer">Time: <span id="timer">20:00</span></div>
    </div>
  </div>
</div>

<div class="shell">
  <div class="main">

    <!-- Left: Passage -->
    <div class="card">
      <div class="card-head">
        <h2 id="leftH">Read the text and answer the questions.</h2>
        <p id="leftP">Choose the best answer.</p>
      </div>

      <div class="card-pad passage no-select" id="passage">
        <h3 id="passTitle">The Hidden Cost of Convenience</h3>

        <p id="p1">
          In many cities, the promise of “instant delivery” has reshaped daily routines. Groceries, medicines,
          and household items arrive within minutes, reducing the need to plan ahead. Yet the same speed that
          delights customers also compresses schedules for couriers, who often navigate traffic, weather, and
          unpredictable demand while being judged by strict time targets.
        </p>

        <p id="p2">
          Supporters argue that these services create flexible work and encourage small businesses to reach
          new customers. Critics, however, warn that flexibility can be one-sided: workers may face unstable
          income, algorithmic oversight, and limited bargaining power. Meanwhile, the environmental footprint
          can grow as short trips multiply, packaging increases, and “failed deliveries” require repeated attempts.
        </p>

        <p id="p3">
          Policymakers are beginning to respond. Some propose minimum earnings standards and clearer
          transparency about how pay is calculated. Others focus on urban logistics—consolidation hubs, bike
          lanes, and restrictions on high-emission vehicles—to reduce congestion. Whether the convenience
          revolution becomes sustainable may depend on how societies balance consumer expectations with
          fair labor conditions and responsible city planning.
        </p>
      </div>
    </div>

    <!-- Right: Questions with scroll -->
    <div class="card">
      <div class="qscroll">
        <form class="qwrap" id="qForm" method="POST" action="{{ route('reading.submit', ['q' => 'q2']) }}">
          @csrf

          <!-- Q1 -->
          <div class="qbox">
            <p class="qtitle" id="q1t">1) What is the main idea of the text?</p>
            <label class="option"><input type="radio" name="q1" value="a" required><span id="q1a">Instant delivery offers convenience but raises concerns about labor and sustainability.</span></label>
            <label class="option"><input type="radio" name="q1" value="b"><span id="q1b">City residents should avoid online shopping to reduce traffic.</span></label>
            <label class="option"><input type="radio" name="q1" value="c"><span id="q1c">Couriers prefer strict deadlines because it improves motivation.</span></label>
            <label class="option"><input type="radio" name="q1" value="d"><span id="q1d">Packaging is the only reason instant delivery harms the environment.</span></label>
          </div>

          <!-- Q2 -->
          <div class="qbox">
            <p class="qtitle" id="q2t">2) In paragraph 1, “compresses schedules” most nearly means:</p>
            <label class="option"><input type="radio" name="q2" value="a" required><span id="q2a">reduces the time available for tasks</span></label>
            <label class="option"><input type="radio" name="q2" value="b"><span id="q2b">makes schedules more entertaining</span></label>
            <label class="option"><input type="radio" name="q2" value="c"><span id="q2c">eliminates all deadlines</span></label>
            <label class="option"><input type="radio" name="q2" value="d"><span id="q2d">moves work to the night</span></label>
          </div>

          <!-- Q3 -->
          <div class="qbox">
            <p class="qtitle" id="q3t">3) Which statement best reflects the critics’ viewpoint?</p>
            <label class="option"><input type="radio" name="q3" value="a" required><span id="q3a">Flexibility may benefit companies more than workers.</span></label>
            <label class="option"><input type="radio" name="q3" value="b"><span id="q3b">Couriers have full control over their income.</span></label>
            <label class="option"><input type="radio" name="q3" value="c"><span id="q3c">Instant delivery reduces packaging waste.</span></label>
            <label class="option"><input type="radio" name="q3" value="d"><span id="q3d">Algorithmic management increases bargaining power.</span></label>
          </div>

          <!-- Q4 -->
          <div class="qbox">
            <p class="qtitle" id="q4t">4) What does the text imply about “failed deliveries”?</p>
            <label class="option"><input type="radio" name="q4" value="a" required><span id="q4a">They can increase emissions by requiring repeated trips.</span></label>
            <label class="option"><input type="radio" name="q4" value="b"><span id="q4b">They have no impact on environmental costs.</span></label>
            <label class="option"><input type="radio" name="q4" value="c"><span id="q4c">They mainly occur because customers dislike convenience.</span></label>
            <label class="option"><input type="radio" name="q4" value="d"><span id="q4d">They happen only in rural areas.</span></label>
          </div>

          <!-- Q5 -->
          <div class="qbox">
            <p class="qtitle" id="q5t">5) Which of the following is NOT mentioned as a potential downside?</p>
            <label class="option"><input type="radio" name="q5" value="a" required><span id="q5a">Unstable income for workers</span></label>
            <label class="option"><input type="radio" name="q5" value="b"><span id="q5b">Increased packaging</span></label>
            <label class="option"><input type="radio" name="q5" value="c"><span id="q5c">Algorithmic oversight</span></label>
            <label class="option"><input type="radio" name="q5" value="d"><span id="q5d">Reduced access to small businesses</span></label>
          </div>

          <!-- Q6 -->
          <div class="qbox">
            <p class="qtitle" id="q6t">6) The author’s tone can best be described as:</p>
            <label class="option"><input type="radio" name="q6" value="a" required><span id="q6a">balanced and analytical</span></label>
            <label class="option"><input type="radio" name="q6" value="b"><span id="q6b">humorous and sarcastic</span></label>
            <label class="option"><input type="radio" name="q6" value="c"><span id="q6c">angry and accusatory</span></label>
            <label class="option"><input type="radio" name="q6" value="d"><span id="q6d">nostalgic and sentimental</span></label>
          </div>

          <!-- Q7 -->
          <div class="qbox">
            <p class="qtitle" id="q7t">7) Why are “minimum earnings standards” mentioned?</p>
            <label class="option"><input type="radio" name="q7" value="a" required><span id="q7a">As a possible policy response to protect workers.</span></label>
            <label class="option"><input type="radio" name="q7" value="b"><span id="q7b">To argue that couriers already earn high wages.</span></label>
            <label class="option"><input type="radio" name="q7" value="c"><span id="q7c">To suggest consumers should pay less for delivery.</span></label>
            <label class="option"><input type="radio" name="q7" value="d"><span id="q7d">To show that algorithms are no longer used.</span></label>
          </div>

          <!-- Q8 -->
          <div class="qbox">
            <p class="qtitle" id="q8t">8) In paragraph 3, the phrase “urban logistics” refers to:</p>
            <label class="option"><input type="radio" name="q8" value="a" required><span id="q8a">how cities organize the movement and delivery of goods</span></label>
            <label class="option"><input type="radio" name="q8" value="b"><span id="q8b">tourism marketing strategies</span></label>
            <label class="option"><input type="radio" name="q8" value="c"><span id="q8c">personal budgeting for consumers</span></label>
            <label class="option"><input type="radio" name="q8" value="d"><span id="q8d">online advertising for delivery apps</span></label>
          </div>

          <!-- Q9 -->
          <div class="qbox">
            <p class="qtitle" id="q9t">9) Which conclusion is most supported by the passage?</p>
            <label class="option"><input type="radio" name="q9" value="a" required><span id="q9a">The future of instant delivery depends on balancing speed with fairness and sustainability.</span></label>
            <label class="option"><input type="radio" name="q9" value="b"><span id="q9b">Instant delivery will disappear because it is unpopular.</span></label>
            <label class="option"><input type="radio" name="q9" value="c"><span id="q9c">All policymakers agree on a single solution.</span></label>
            <label class="option"><input type="radio" name="q9" value="d"><span id="q9d">Congestion is unrelated to delivery services.</span></label>
          </div>

          <!-- Q10 -->
          <div class="qbox">
            <p class="qtitle" id="q10t">10) What is the function of paragraph 2 in the overall structure?</p>
            <label class="option"><input type="radio" name="q10" value="a" required><span id="q10a">It presents contrasting perspectives and expands on potential consequences.</span></label>
            <label class="option"><input type="radio" name="q10" value="b"><span id="q10b">It provides historical background about postal services.</span></label>
            <label class="option"><input type="radio" name="q10" value="c"><span id="q10c">It gives step-by-step instructions for couriers.</span></label>
            <label class="option"><input type="radio" name="q10" value="d"><span id="q10d">It summarizes the policies already implemented worldwide.</span></label>
          </div>

          <div class="footer">
            <div class="hint" id="hint">Answer all questions to continue.</div>
            <button type="button" class="btn" id="nextBtn" onclick="submitAndGo()">Next</button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>

<!-- Alert overlay -->
<div id="alertOverlay">
  <div class="alertCard">
    <p id="alertText">Please answer all questions before continuing.</p>
    <button class="alertBtn" type="button" onclick="closeAlert()">OK</button>
  </div>
</div>

<script>
/* حماية نسخ/قص/لصق/يمين */
(function hardenCopyProtection(){
  const block = (e) => { e.preventDefault(); return false; };
  document.addEventListener('copy', block);
  document.addEventListener('cut', block);
  document.addEventListener('paste', block);
  document.addEventListener('contextmenu', block);
  document.addEventListener('selectstart', block);

  document.addEventListener('keydown', function(e){
    const k = (e.key || '').toLowerCase();
    const ctrl = e.ctrlKey || e.metaKey;
    if (ctrl && ['c','x','a','s','u','p','v'].includes(k)) return block(e);
    if (e.key === 'F12') return block(e);
    if (ctrl && e.shiftKey && ['i','j','c'].includes(k)) return block(e);
  });
})();

/* منع الرجوع */
(function preventBack(){
  history.pushState(null, "", location.href);
  window.addEventListener('popstate', function () {
    history.pushState(null, "", location.href);
  });
})();

/* مؤقت 20:00 */
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

/* تحقق + انتقال */
function allAnswered(){
  const form = document.getElementById('qForm') || document.getElementById('qForm');
  // نتحقق من q1..q10
  for(let i=1;i<=10;i++){
    const checked = document.querySelector(`input[name="q${i}"]:checked`);
    if(!checked) return false;
  }
  return true;
}

function openAlert(msg){
  document.getElementById('alertText').innerText = msg;
  document.getElementById('alertOverlay').style.display = 'flex';
}
function closeAlert(){
  document.getElementById('alertOverlay').style.display = 'none';
}

function submitAndGo(){
  if(!allAnswered()){
    openAlert(lang === "en" ? "Please answer all questions before continuing." : "فضلاً أجب عن جميع الأسئلة قبل المتابعة.");
    return;
  }

  // Submit the form to controller to grade and redirect to done
  document.getElementById("qForm").submit();
}

/* ترجمة EN/AR */
let lang = "en";

function setArabic(){
  document.getElementById('topTitle').innerText = "القراءة • متقدم • 10 أسئلة";
  document.getElementById('badge').innerText = "س٢";
  document.getElementById('leftH').innerText = "اقرأ النص ثم أجب عن الأسئلة.";
  document.getElementById('leftP').innerText = "اختر أفضل إجابة.";
  document.getElementById('passTitle').innerText = "التكلفة الخفية للسهولة";

  document.getElementById('p1').innerText =
    "في كثير من المدن، غيّر وعد «التوصيل الفوري» روتين الحياة اليومية. تصل البقالة والأدوية واحتياجات المنزل خلال دقائق، مما يقلل الحاجة إلى التخطيط. لكن السرعة نفسها التي تُسعد العملاء تضغط جداول المندوبين الذين يواجهون المرور والطقس وتقلّب الطلب، بينما يُقاس أداؤهم وفق أهداف زمنية صارمة.";
  document.getElementById('p2').innerText =
    "يرى المؤيدون أن هذه الخدمات تخلق عملاً مرنًا وتساعد المتاجر الصغيرة على الوصول إلى عملاء جدد. غير أن النقاد يحذّرون من أن المرونة قد تكون لصالح طرف واحد: فقد يواجه العاملون دخلاً غير مستقر، ورقابة خوارزمية، وقدرة محدودة على التفاوض. كما قد يرتفع الأثر البيئي مع زيادة الرحلات القصيرة وكثرة التغليف، ومحاولات التسليم المتكررة عند فشل التسليم.";
  document.getElementById('p3').innerText =
    "بدأ صانعو السياسات بالاستجابة. يقترح بعضهم حدًا أدنى للأجور ومعايير أوضح لشفافية احتساب الدخل، بينما يركز آخرون على لوجستيات المدن مثل مراكز التجميع ومسارات الدراجات والحد من المركبات عالية الانبعاث. وقد يتوقف مستقبل هذه الثورة على كيفية موازنة توقعات المستهلكين مع عدالة ظروف العمل وتخطيط حضري مسؤول.";

  document.getElementById('q1t').innerText = "1) ما الفكرة الرئيسة للنص؟";
  document.getElementById('q1a').innerText = "التوصيل الفوري يوفر سهولة لكنه يثير قضايا تتعلق بالعمل والاستدامة.";
  document.getElementById('q1b').innerText = "على سكان المدن تجنب التسوق عبر الإنترنت لتقليل الازدحام.";
  document.getElementById('q1c').innerText = "المندوبون يفضلون المواعيد الصارمة لأنها تزيد الحافز.";
  document.getElementById('q1d').innerText = "التغليف هو السبب الوحيد لضرر التوصيل الفوري على البيئة.";

  document.getElementById('q2t').innerText = "2) في الفقرة الأولى، معنى «يضغط الجداول» أقرب إلى:";
  document.getElementById('q2a').innerText = "يقلل الوقت المتاح للمهام";
  document.getElementById('q2b').innerText = "يجعل الجداول أكثر متعة";
  document.getElementById('q2c').innerText = "يلغي كل المواعيد النهائية";
  document.getElementById('q2d').innerText = "ينقل العمل إلى الليل";

  document.getElementById('q3t').innerText = "3) أي عبارة تعكس رأي النقاد بشكل أفضل؟";
  document.getElementById('q3a').innerText = "قد تكون المرونة لصالح الشركات أكثر من العاملين.";
  document.getElementById('q3b').innerText = "المندوبون يتحكمون بالكامل في دخلهم.";
  document.getElementById('q3c').innerText = "التوصيل الفوري يقلل نفايات التغليف.";
  document.getElementById('q3d').innerText = "الإدارة الخوارزمية تزيد القدرة على التفاوض.";

  document.getElementById('q4t').innerText = "4) ماذا يوحي النص عن «فشل التسليم»؟";
  document.getElementById('q4a').innerText = "قد يزيد الانبعاثات بسبب تكرار الرحلات.";
  document.getElementById('q4b').innerText = "لا يؤثر على التكلفة البيئية.";
  document.getElementById('q4c').innerText = "يحدث لأن العملاء لا يحبون السهولة.";
  document.getElementById('q4d').innerText = "يحدث فقط في المناطق الريفية.";

  document.getElementById('q5t').innerText = "5) أي مما يلي لم يُذكر كأثر سلبي محتمل؟";
  document.getElementById('q5a').innerText = "دخل غير مستقر للعاملين";
  document.getElementById('q5b').innerText = "زيادة التغليف";
  document.getElementById('q5c').innerText = "رقابة خوارزمية";
  document.getElementById('q5d').innerText = "انخفاض وصول المتاجر الصغيرة للعملاء";

  document.getElementById('q6t').innerText = "6) يمكن وصف نبرة الكاتب بأنها:";
  document.getElementById('q6a').innerText = "متوازنة وتحليلية";
  document.getElementById('q6b').innerText = "ساخرة ومضحكة";
  document.getElementById('q6c').innerText = "غاضبة واتهامية";
  document.getElementById('q6d').innerText = "حنينية وعاطفية";

  document.getElementById('q7t').innerText = "7) لماذا ذُكرت «معايير الحد الأدنى للدخل»؟";
  document.getElementById('q7a').innerText = "كمثال لاستجابة سياسية لحماية العاملين.";
  document.getElementById('q7b').innerText = "لإثبات أن المندوبين يتقاضون أجورًا عالية.";
  document.getElementById('q7c').innerText = "للدلالة على ضرورة خفض رسوم التوصيل للمستهلكين.";
  document.getElementById('q7d').innerText = "لإظهار أن الخوارزميات لم تعد تُستخدم.";

  document.getElementById('q8t').innerText = "8) عبارة «لوجستيات المدن» تشير إلى:";
  document.getElementById('q8a').innerText = "كيفية تنظيم المدن لحركة البضائع وعمليات التوصيل";
  document.getElementById('q8b').innerText = "استراتيجيات التسويق السياحي";
  document.getElementById('q8c').innerText = "الميزانيات الشخصية للمستهلكين";
  document.getElementById('q8d').innerText = "الإعلانات الرقمية لتطبيقات التوصيل";

  document.getElementById('q9t').innerText = "9) أي نتيجة يدعمها النص أكثر؟";
  document.getElementById('q9a').innerText = "يعتمد مستقبل التوصيل الفوري على موازنة السرعة مع العدالة والاستدامة.";
  document.getElementById('q9b').innerText = "سوف يختفي التوصيل الفوري لأنه غير محبوب.";
  document.getElementById('q9c').innerText = "يتفق جميع صناع السياسات على حل واحد.";
  document.getElementById('q9d').innerText = "الازدحام لا علاقة له بخدمات التوصيل.";

  document.getElementById('q10t').innerText = "10) ما وظيفة الفقرة الثانية ضمن بناء النص؟";
  document.getElementById('q10a').innerText = "تطرح وجهات نظر متقابلة وتوسع الحديث عن النتائج المحتملة.";
  document.getElementById('q10b').innerText = "تقدم خلفية تاريخية عن خدمات البريد.";
  document.getElementById('q10c').innerText = "تعطي تعليمات خطوة بخطوة للمندوبين.";
  document.getElementById('q10d').innerText = "تلخص السياسات المطبقة عالميًا بالفعل.";

  document.getElementById('hint').innerText = "أجب عن جميع الأسئلة للمتابعة.";
  document.getElementById('nextBtn').innerText = "التالي";
  document.getElementById('translateBtn').innerText = "English";

  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
  lang = "ar";
}

function setEnglish(){
  document.getElementById('topTitle').innerText = "Reading • Advanced • 10 Questions";
  document.getElementById('badge').innerText = "Q2";
  document.getElementById('leftH').innerText = "Read the text and answer the questions.";
  document.getElementById('leftP').innerText = "Choose the best answer.";
  document.getElementById('passTitle').innerText = "The Hidden Cost of Convenience";

  document.getElementById('p1').innerText =
    "In many cities, the promise of “instant delivery” has reshaped daily routines. Groceries, medicines, and household items arrive within minutes, reducing the need to plan ahead. Yet the same speed that delights customers also compresses schedules for couriers, who often navigate traffic, weather, and unpredictable demand while being judged by strict time targets.";
  document.getElementById('p2').innerText =
    "Supporters argue that these services create flexible work and encourage small businesses to reach new customers. Critics, however, warn that flexibility can be one-sided: workers may face unstable income, algorithmic oversight, and limited bargaining power. Meanwhile, the environmental footprint can grow as short trips multiply, packaging increases, and “failed deliveries” require repeated attempts.";
  document.getElementById('p3').innerText =
    "Policymakers are beginning to respond. Some propose minimum earnings standards and clearer transparency about how pay is calculated. Others focus on urban logistics—consolidation hubs, bike lanes, and restrictions on high-emission vehicles—to reduce congestion. Whether the convenience revolution becomes sustainable may depend on how societies balance consumer expectations with fair labor conditions and responsible city planning.";

  document.getElementById('q1t').innerText = "1) What is the main idea of the text?";
  document.getElementById('q1a').innerText = "Instant delivery offers convenience but raises concerns about labor and sustainability.";
  document.getElementById('q1b').innerText = "City residents should avoid online shopping to reduce traffic.";
  document.getElementById('q1c').innerText = "Couriers prefer strict deadlines because it improves motivation.";
  document.getElementById('q1d').innerText = "Packaging is the only reason instant delivery harms the environment.";

  document.getElementById('q2t').innerText = "2) In paragraph 1, “compresses schedules” most nearly means:";
  document.getElementById('q2a').innerText = "reduces the time available for tasks";
  document.getElementById('q2b').innerText = "makes schedules more entertaining";
  document.getElementById('q2c').innerText = "eliminates all deadlines";
  document.getElementById('q2d').innerText = "moves work to the night";

  document.getElementById('q3t').innerText = "3) Which statement best reflects the critics’ viewpoint?";
  document.getElementById('q3a').innerText = "Flexibility may benefit companies more than workers.";
  document.getElementById('q3b').innerText = "Couriers have full control over their income.";
  document.getElementById('q3c').innerText = "Instant delivery reduces packaging waste.";
  document.getElementById('q3d').innerText = "Algorithmic management increases bargaining power.";

  document.getElementById('q4t').innerText = "4) What does the text imply about “failed deliveries”?";
  document.getElementById('q4a').innerText = "They can increase emissions by requiring repeated trips.";
  document.getElementById('q4b').innerText = "They have no impact on environmental costs.";
  document.getElementById('q4c').innerText = "They mainly occur because customers dislike convenience.";
  document.getElementById('q4d').innerText = "They happen only in rural areas.";

  document.getElementById('q5t').innerText = "5) Which of the following is NOT mentioned as a potential downside?";
  document.getElementById('q5a').innerText = "Unstable income for workers";
  document.getElementById('q5b').innerText = "Increased packaging";
  document.getElementById('q5c').innerText = "Algorithmic oversight";
  document.getElementById('q5d').innerText = "Reduced access to small businesses";

  document.getElementById('q6t').innerText = "6) The author’s tone can best be described as:";
  document.getElementById('q6a').innerText = "balanced and analytical";
  document.getElementById('q6b').innerText = "humorous and sarcastic";
  document.getElementById('q6c').innerText = "angry and accusatory";
  document.getElementById('q6d').innerText = "nostalgic and sentimental";

  document.getElementById('q7t').innerText = "7) Why are “minimum earnings standards” mentioned?";
  document.getElementById('q7a').innerText = "As a possible policy response to protect workers.";
  document.getElementById('q7b').innerText = "To argue that couriers already earn high wages.";
  document.getElementById('q7c').innerText = "To suggest consumers should pay less for delivery.";
  document.getElementById('q7d').innerText = "To show that algorithms are no longer used.";

  document.getElementById('q8t').innerText = "8) In paragraph 3, the phrase “urban logistics” refers to:";
  document.getElementById('q8a').innerText = "how cities organize the movement and delivery of goods";
  document.getElementById('q8b').innerText = "tourism marketing strategies";
  document.getElementById('q8c').innerText = "personal budgeting for consumers";
  document.getElementById('q8d').innerText = "online advertising for delivery apps";

  document.getElementById('q9t').innerText = "9) Which conclusion is most supported by the passage?";
  document.getElementById('q9a').innerText = "The future of instant delivery depends on balancing speed with fairness and sustainability.";
  document.getElementById('q9b').innerText = "Instant delivery will disappear because it is unpopular.";
  document.getElementById('q9c').innerText = "All policymakers agree on a single solution.";
  document.getElementById('q9d').innerText = "Congestion is unrelated to delivery services.";

  document.getElementById('q10t').innerText = "10) What is the function of paragraph 2 in the overall structure?";
  document.getElementById('q10a').innerText = "It presents contrasting perspectives and expands on potential consequences.";
  document.getElementById('q10b').innerText = "It provides historical background about postal services.";
  document.getElementById('q10c').innerText = "It gives step-by-step instructions for couriers.";
  document.getElementById('q10d').innerText = "It summarizes the policies already implemented worldwide.";

  document.getElementById('hint').innerText = "Answer all questions to continue.";
  document.getElementById('nextBtn').innerText = "Next";
  document.getElementById('translateBtn').innerText = "Translate";

  document.body.setAttribute("dir","ltr");
  document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
  lang = "en";
}

function toggleLang(){
  if(lang === "en") setArabic();
  else setEnglish();
}
</script>

</body>
</html>