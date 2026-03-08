<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>{{ $skillLabelAr ?? 'تفاصيل المهارة' }} - LingoPulse</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
  --bg:#000c1d;
  --card: rgba(255,255,255,0.08);
  --stroke: rgba(255,255,255,0.14);
  --text:#fff;
  --muted: rgba(255,255,255,0.72);

  --brand:#00c6ff;
  --ok:#10b981;
  --bad:#ef4444;
  --warn:#f59e0b;

  --shadow: 0 20px 55px rgba(0,0,0,0.45);
  --radius: 26px;
}

*{ box-sizing:border-box; }

body{
  margin:0;
  font-family: 'Tajawal','Poppins',sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height:100vh;
  padding: 90px 18px 22px;
  direction: rtl;
  overflow-x:hidden;
}

/* Background blobs */
.blob{
  position: fixed;
  width: 520px;
  height: 520px;
  background: radial-gradient(circle, rgba(0,198,255,0.16), transparent 70%);
  filter: blur(85px);
  z-index:-1;
}
.blob.a{ top:-120px; left:-140px; }
.blob.b{ bottom:-140px; right:-140px; }

/* Top bar */
.topbar{
  position: fixed;
  top: 0;
  left: 0;
  width:100%;
  z-index: 20;
  background: rgba(10,20,40,0.85);
  border-bottom: 1px solid rgba(255,255,255,0.10);
  backdrop-filter: blur(16px);
  display:flex;
  align-items:center;
  justify-content: space-between;
  gap: 10px;
  padding: 12px 16px;
}
.back{
  color: rgba(255,255,255,0.90);
  text-decoration:none;
  font-weight: 900;
  display:flex;
  align-items:center;
  gap: 8px;
  padding: 10px 12px;
  border-radius: 14px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.10);
}
.back:hover{ background: rgba(255,255,255,0.10); }
.lang-btn{
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.14);
  color:#fff;
  padding: 10px 12px;
  border-radius: 14px;
  font-weight: 900;
  cursor:pointer;
}
.lang-btn:hover{ background: rgba(255,255,255,0.12); }

.wrap{
  max-width: 980px;
  margin: 0 auto;
}

.hero{
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  padding: 22px 22px;
  display:flex;
  align-items:center;
  justify-content: space-between;
  gap: 14px;
  flex-wrap: wrap;
}
.hero-left{
  display:flex;
  align-items:center;
  gap: 14px;
}
.hero-icon{
  width: 54px;
  height: 54px;
  border-radius: 18px;
  display:flex;
  align-items:center;
  justify-content:center;
  background: rgba(0,198,255,0.12);
  border: 1px solid rgba(0,198,255,0.28);
  color: var(--brand);
  font-size: 22px;
}
.hero h1{
  margin:0;
  font-size: 1.35rem;
  font-weight: 1000;
}
.hero p{
  margin: 5px 0 0;
  color: var(--muted);
  font-weight: 700;
}
.badge{
  display:inline-flex;
  align-items:center;
  gap: 10px;
  padding: 10px 14px;
  border-radius: 999px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  font-weight: 1000;
}
.badge strong{ color: var(--brand); }

.filters{
  margin: 16px 0 18px;
  display:flex;
  gap: 10px;
  flex-wrap: wrap;
}
.chip{
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color:#fff;
  padding: 10px 14px;
  border-radius: 999px;
  cursor:pointer;
  font-weight: 900;
  transition: .2s;
}
.chip:hover{ background: rgba(255,255,255,0.10); }
.chip.active{
  border-color: rgba(0,198,255,0.35);
  background: rgba(0,198,255,0.10);
  color: var(--brand);
}

.list{
  display:grid;
  gap: 14px;
}

.q-card{
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 20px;
  padding: 16px 16px;
}
.q-head{
  display:flex;
  align-items:flex-start;
  justify-content: space-between;
  gap: 10px;
  margin-bottom: 10px;
}
.q-title{
  font-weight: 1000;
  line-height: 1.6;
}
.q-meta{
  display:flex;
  align-items:center;
  gap: 8px;
  flex-wrap: wrap;
}
.pill{
  font-weight: 1000;
  font-size: 0.85rem;
  padding: 7px 10px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.05);
  color: rgba(255,255,255,0.85);
}
.pill.ok{ border-color: rgba(16,185,129,0.45); background: rgba(16,185,129,0.12); color: var(--ok); }
.pill.bad{ border-color: rgba(239,68,68,0.45); background: rgba(239,68,68,0.12); color: var(--bad); }

.options{
  margin-top: 10px;
  display:grid;
  gap: 10px;
}
.opt{
  border-radius: 16px;
  padding: 12px 12px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.14);
  display:flex;
  align-items:flex-start;
  justify-content: space-between;
  gap: 10px;
}
.opt .text{
  line-height: 1.6;
  font-weight: 800;
  color: rgba(255,255,255,0.88);
}
.marks{
  display:flex;
  align-items:center;
  gap: 8px;
  flex: 0 0 auto;
}
.tag{
  font-size: 0.78rem;
  font-weight: 1000;
  padding: 6px 9px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.05);
  white-space: nowrap;
}
.tag.you{ border-color: rgba(245,158,11,0.45); background: rgba(245,158,11,0.14); color: var(--warn); }
.tag.right{ border-color: rgba(16,185,129,0.45); background: rgba(16,185,129,0.14); color: var(--ok); }

.opt.correct{
  border-color: rgba(16,185,129,0.35);
  background: rgba(16,185,129,0.10);
}
.opt.wrong-selected{
  border-color: rgba(239,68,68,0.35);
  background: rgba(239,68,68,0.10);
}

.explain{
  margin-top: 12px;
  padding: 12px 12px;
  border-radius: 16px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.10);
  color: rgba(255,255,255,0.78);
  line-height: 1.7;
  display:none;
}
.explain.show{ display:block; }

.small-actions{
  margin-top: 10px;
  display:flex;
  gap: 10px;
  flex-wrap: wrap;
}
.btn-mini{
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
  color:#fff;
  padding: 10px 12px;
  border-radius: 14px;
  cursor:pointer;
  font-weight: 900;
}
.btn-mini:hover{ background: rgba(255,255,255,0.10); }

.empty{
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 20px;
  padding: 18px;
  text-align:center;
  color: rgba(255,255,255,0.78);
  line-height: 1.7;
}

@media (max-width: 600px){
  .hero{ padding: 18px; }
}
</style>
</head>

<body>
  <div class="blob a"></div>
  <div class="blob b"></div>

  <div class="topbar">
    <a class="back" href="{{ route('test.results') }}">
      <i class="fas fa-arrow-right"></i>
      <span id="backText">رجوع للتقرير</span>
    </a>

    <button class="lang-btn" id="langBtn" onclick="toggleLang()">English</button>
  </div>

  <div class="wrap">

    @php
      $items = $items ?? [];
      $score = (int)($score ?? 0);
      $total = is_array($items) ? count($items) : 0;

      $correctCount = 0;
      foreach($items as $it){
        $sel = $it['selected'] ?? null;
        $cor = $it['correct'] ?? null;
        if($sel !== null && $sel !== '' && $sel == $cor) $correctCount++;
      }

      $skillAr = $skillLabelAr ?? 'تفاصيل المهارة';
      $skillEn = $skillLabelEn ?? 'Skill Details';
      $subtitleAr = 'شاهد أسئلتك، إجابتك، والإجابة الصحيحة';
      $subtitleEn = 'Review questions, your answer, and the correct answer';
    @endphp

    <div class="hero">
      <div class="hero-left">
        <div class="hero-icon"><i class="fas {{ $icon ?? 'fa-layer-group' }}"></i></div>
        <div>
          <h1 id="titleText">تفاصيل {{ $skillAr }}</h1>
          <p id="subtitleText">{{ $subtitleAr }}</p>
        </div>
      </div>

      <div class="badge">
        <span id="scoreText">النتيجة:</span>
        <strong>{{ $score }}%</strong>
        <span>•</span>
        <span id="countText">{{ $correctCount }} / {{ $total }}</span>
      </div>
    </div>

    <div class="filters">
      <button class="chip active" onclick="setFilter('all', this)" id="fAll">الكل</button>
      <button class="chip" onclick="setFilter('wrong', this)" id="fWrong">الأخطاء فقط</button>
      <button class="chip" onclick="setFilter('correct', this)" id="fCorrect">الصحيح فقط</button>
      <button class="chip" onclick="setFilter('unanswered', this)" id="fUnanswered">غير مُجاب</button>
    </div>

    <div class="list" id="qList">
      @forelse ($items as $index => $q)
        @php
          $selected = $q['selected'] ?? null;
          $correct  = $q['correct'] ?? null;
          $isAnswered = $selected !== null && $selected !== '';
          $isCorrect = $isAnswered && ($selected == $correct);

          $filterClass = 'all ';
          $filterClass .= $isCorrect ? 'correct ' : '';
          $filterClass .= ($isAnswered && !$isCorrect) ? 'wrong ' : '';
          $filterClass .= !$isAnswered ? 'unanswered ' : '';
        @endphp

        <div class="q-card {{ $filterClass }}" data-state="{{ $isCorrect ? 'correct' : ($isAnswered ? 'wrong' : 'unanswered') }}">
          <div class="q-head">
            <div class="q-title">
              <span style="color: rgba(255,255,255,0.65); font-weight:900;">#{{ $index + 1 }}</span>
              <span>—</span>
              <span>{{ $q['question'] ?? '' }}</span>
            </div>

            <div class="q-meta">
              @if(!empty($q['tag']))
                <span class="pill">{{ $q['tag'] }}</span>
              @endif

              @if($isCorrect)
                <span class="pill ok">صحيح</span>
              @elseif($isAnswered && !$isCorrect)
                <span class="pill bad">خطأ</span>
              @else
                <span class="pill">غير مُجاب</span>
              @endif
            </div>
          </div>

          <div class="options">
            @foreach(($q['choices'] ?? []) as $choice)
              @php
                $ck = $choice['key'] ?? '';
                $ct = $choice['text'] ?? '';

                $isSelected = $isAnswered && ($selected == $ck);
                $isRight = ($correct == $ck);

                $optClass = 'opt';
                if($isRight) $optClass .= ' correct';
                if($isSelected && !$isRight) $optClass .= ' wrong-selected';
              @endphp

              <div class="{{ $optClass }}">
                <div class="text">
                  <strong style="color: rgba(255,255,255,0.75);">{{ $ck }}.</strong>
                  {{ $ct }}
                </div>

                <div class="marks">
                  @if($isSelected)
                    <span class="tag you">إجابتك</span>
                  @endif
                  @if($isRight)
                    <span class="tag right">الصحيحة</span>
                  @endif
                </div>
              </div>
            @endforeach
          </div>

          @if(!empty($q['explanation']))
            <div class="small-actions">
              <button class="btn-mini" type="button" onclick="toggleExplain({{ $index }})" id="expBtn{{ $index }}">
                <i class="fas fa-lightbulb"></i> <span>عرض الشرح</span>
              </button>
            </div>

            <div class="explain" id="exp{{ $index }}">
              {{ $q['explanation'] }}
            </div>
          @endif
        </div>

      @empty
        <div class="empty" id="emptyText">
          لا توجد تفاصيل لعرضها حاليًا لهذه المهارة.<br>
          إذا رغبتِ، أقدر أربطها بقاعدة البيانات بحيث تظهر أسئلة الطالب وإجاباته تلقائيًا.
        </div>
      @endforelse
    </div>

  </div>

<script>
let lang = "ar";

function setFilter(mode, el){
  document.querySelectorAll(".chip").forEach(c => c.classList.remove("active"));
  el.classList.add("active");

  const cards = document.querySelectorAll(".q-card");
  cards.forEach(card => {
    if(mode === "all"){ card.style.display = "block"; return; }
    card.style.display = card.classList.contains(mode) ? "block" : "none";
  });
}

function toggleExplain(i){
  const box = document.getElementById("exp"+i);
  if(!box) return;
  box.classList.toggle("show");
  const btn = document.getElementById("expBtn"+i);
  if(btn){
    const span = btn.querySelector("span");
    if(span){
      span.innerText = box.classList.contains("show")
        ? (lang === "ar" ? "إخفاء الشرح" : "Hide explanation")
        : (lang === "ar" ? "عرض الشرح" : "Show explanation");
    }
  }
}

function toggleLang(){
  if(lang === "ar"){
    document.documentElement.lang = "en";
    document.body.style.direction = "ltr";

    document.getElementById("langBtn").innerText = "العربية";
    document.getElementById("backText").innerText = "Back to report";

    document.getElementById("titleText").innerText = "Details: {{ $skillEn }}";
    document.getElementById("subtitleText").innerText = "Review questions, your answer, and the correct answer";

    document.getElementById("scoreText").innerText = "Score:";
    document.getElementById("fAll").innerText = "All";
    document.getElementById("fWrong").innerText = "Wrong only";
    document.getElementById("fCorrect").innerText = "Correct only";
    document.getElementById("fUnanswered").innerText = "Unanswered";

    document.querySelectorAll(".tag.you").forEach(t => t.innerText = "Your answer");
    document.querySelectorAll(".tag.right").forEach(t => t.innerText = "Correct");
    document.querySelectorAll(".pill.ok").forEach(p => p.innerText = "Correct");
    document.querySelectorAll(".pill.bad").forEach(p => p.innerText = "Wrong");
    document.querySelectorAll(".q-card").forEach(card => {
      const st = card.getAttribute("data-state");
      if(st === "unanswered"){
        const pill = card.querySelector(".pill:not(.ok):not(.bad)");
        if(pill) pill.innerText = "Unanswered";
      }
    });

    document.querySelectorAll("[id^='expBtn']").forEach(btn => {
      const span = btn.querySelector("span");
      if(span) span.innerText = "Show explanation";
    });

    const empty = document.getElementById("emptyText");
    if(empty){
      empty.innerHTML = "No details available for this skill yet.<br>We can connect it to the database to show the student's answers automatically.";
    }

    lang = "en";
  } else {
    document.documentElement.lang = "ar";
    document.body.style.direction = "rtl";

    document.getElementById("langBtn").innerText = "English";
    document.getElementById("backText").innerText = "رجوع للتقرير";

    document.getElementById("titleText").innerText = "تفاصيل {{ $skillAr }}";
    document.getElementById("subtitleText").innerText = "شاهد أسئلتك، إجابتك، والإجابة الصحيحة";

    document.getElementById("scoreText").innerText = "النتيجة:";
    document.getElementById("fAll").innerText = "الكل";
    document.getElementById("fWrong").innerText = "الأخطاء فقط";
    document.getElementById("fCorrect").innerText = "الصحيح فقط";
    document.getElementById("fUnanswered").innerText = "غير مُجاب";

    document.querySelectorAll(".tag.you").forEach(t => t.innerText = "إجابتك");
    document.querySelectorAll(".tag.right").forEach(t => t.innerText = "الصحيحة");
    document.querySelectorAll(".pill.ok").forEach(p => p.innerText = "صحيح");
    document.querySelectorAll(".pill.bad").forEach(p => p.innerText = "خطأ");
    document.querySelectorAll(".q-card").forEach(card => {
      const st = card.getAttribute("data-state");
      if(st === "unanswered"){
        const pill = card.querySelector(".pill:not(.ok):not(.bad)");
        if(pill) pill.innerText = "غير مُجاب";
      }
    });

    document.querySelectorAll("[id^='expBtn']").forEach(btn => {
      const span = btn.querySelector("span");
      if(span) span.innerText = "عرض الشرح";
    });

    const empty = document.getElementById("emptyText");
    if(empty){
      empty.innerHTML = "لا توجد تفاصيل لعرضها حاليًا لهذه المهارة.<br>إذا رغبتِ، أقدر أربطها بقاعدة البيانات بحيث تظهر أسئلة الطالب وإجاباته تلقائيًا.";
    }

    lang = "ar";
  }
}
</script>

@include('student.partials.chatbot')
</body>
</html>