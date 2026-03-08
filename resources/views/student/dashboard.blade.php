<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Evaluation Results - LingoPulse</title>

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root {
  --bg-dark: #000c1d;
  --card-bg: rgba(255, 255, 255, 0.08);
  --neon-blue: #00c6ff;
  --success-green: #10b981;
  --warning-orange: #f59e0b;
  --danger-red: #ef4444;
  --ai-purple: #a855f7;
}

body {
  margin: 0;
  font-family: 'Tajawal', 'Poppins', sans-serif;
  background: var(--bg-dark);
  color: #fff;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  overflow-x: hidden;
  direction: rtl;
}

/* Background Light Effects */
.light-blob {
  position: fixed;
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, rgba(0, 198, 255, 0.15), transparent 70%);
  z-index: -1;
  filter: blur(80px);
}
.blob-1 { top: -100px; left: -100px; }
.blob-2 { bottom: -100px; right: -100px; }

.container {
  width: 100%;
  max-width: 900px;
  background: var(--card-bg);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 30px;
  padding: 40px;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
  animation: fadeIn 0.8s ease-out;
  position: relative;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

header {
  text-align: center;
  margin-bottom: 18px;
}

header h1 {
  font-size: 2.4rem;
  margin: 0;
  background: linear-gradient(90deg, var(--neon-blue), #0072ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

header p {
  color: #ccc;
  font-size: 1.05rem;
  margin-top: 8px;
}

/* Language Toggle Button */
.lang-toggle{
  position: absolute;
  top: 18px;
  left: 18px;
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.18);
  color:#fff;
  padding: 10px 14px;
  border-radius: 14px;
  font-weight: 800;
  cursor:pointer;
  transition:.2s;
  backdrop-filter: blur(10px);
}
.lang-toggle:hover{ background: rgba(255,255,255,0.14); }

/* Overall level banner */
.level-banner{
  margin: 18px auto 26px;
  padding: 16px 18px;
  border-radius: 18px;
  background: rgba(0,0,0,0.18);
  border: 1px solid rgba(255,255,255,0.14);
  display:flex;
  align-items:center;
  justify-content: space-between;
  gap: 14px;
  flex-wrap: wrap;
}
.level-left{
  display:flex;
  align-items:center;
  gap:12px;
  flex-wrap: wrap;
}
.level-badge{
  display:inline-flex;
  align-items:center;
  gap:10px;
  padding: 10px 14px;
  border-radius: 999px;
  background: rgba(0,198,255,0.12);
  border: 1px solid rgba(0,198,255,0.35);
  font-weight: 900;
  color: var(--neon-blue);
}
.level-text{
  display:flex;
  flex-direction: column;
  gap: 4px;
}
.level-text strong{ font-size: 1rem; }
.level-text span{
  color: rgba(255,255,255,0.72);
  font-weight: 700;
  font-size: 0.92rem;
}

/* Results Grid */
.results-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-bottom: 32px;
}

.skill-card {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 20px;
  padding: 22px;
  text-align: center;
  transition: 0.3s;
  border: 1px solid transparent;
  text-decoration: none;
  color: inherit;
  cursor: pointer;
  position: relative;
}
.skill-card:hover {
  transform: translateY(-5px);
  border-color: var(--neon-blue);
  background: rgba(0, 198, 255, 0.05);
}

.skill-icon {
  font-size: 2rem;
  color: var(--neon-blue);
  margin-bottom: 12px;
}

.skill-name {
  font-weight: 800;
  display: block;
  margin-bottom: 12px;
}

.skill-sub{
  color: rgba(255,255,255,0.72);
  font-weight: 700;
  font-size: 0.92rem;
  margin-top: -6px;
  margin-bottom: 10px;
}

/* Progress ring */
.score-circle {
  --p: 0;
  --ring: var(--neon-blue);
  width: 86px;
  height: 86px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  margin: 0 auto;
  font-size: 1.15rem;
  font-weight: 900;
  background: conic-gradient(var(--ring) calc(var(--p) * 1%), rgba(255,255,255,0.10) 0);
  position: relative;
}
.score-circle::before{
  content:"";
  position:absolute;
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: rgba(10,20,40,0.70);
  border: 1px solid rgba(255,255,255,0.10);
}
.score-circle span{
  position: relative;
  z-index: 1;
}

/* Analysis */
.analysis-section {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.analysis-box {
  background: rgba(255, 255, 255, 0.03);
  border-radius: 20px;
  padding: 22px;
  border-right: 4px solid var(--neon-blue);
}

.analysis-box h3 {
  margin-top: 0;
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--neon-blue);
  font-weight: 900;
}

.list-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 12px;
  font-size: 0.95rem;
  color: #d1d1d1;
  line-height: 1.6;
}

.list-item i {
  margin-top: 4px;
  font-size: 0.85rem;
}

.weakness i { color: var(--danger-red); }
.strength i { color: var(--success-green); }

/* AI Advice Section */
.ai-advice-section {
  margin-top: 24px;
  background: linear-gradient(135deg, rgba(168, 85, 247, 0.08), rgba(0, 198, 255, 0.06));
  border-radius: 22px;
  padding: 28px;
  border: 1px solid rgba(168, 85, 247, 0.25);
  position: relative;
  overflow: hidden;
}

.ai-advice-section::before {
  content: "";
  position: absolute;
  top: -50px;
  right: -50px;
  width: 160px;
  height: 160px;
  background: radial-gradient(circle, rgba(168, 85, 247, 0.12), transparent 70%);
  filter: blur(40px);
  z-index: 0;
}

.ai-advice-section h3 {
  margin-top: 0;
  display: flex;
  align-items: center;
  gap: 12px;
  color: var(--ai-purple);
  font-weight: 900;
  font-size: 1.15rem;
  position: relative;
  z-index: 1;
}

.ai-advice-section h3 .ai-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(168, 85, 247, 0.15);
  border: 1px solid rgba(168, 85, 247, 0.3);
  border-radius: 999px;
  padding: 4px 12px;
  font-size: 0.72rem;
  font-weight: 800;
  color: var(--ai-purple);
  letter-spacing: 0.5px;
}

.ai-advice-content {
  position: relative;
  z-index: 1;
  color: #d1d1d1;
  font-size: 0.98rem;
  line-height: 1.85;
  padding: 14px 0 0;
}

.ai-powered-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 0.7rem;
  color: rgba(168, 85, 247, 0.6);
  margin-top: 16px;
  font-weight: 700;
}

/* Action Buttons */
.footer-actions {
  margin-top: 34px;
  display: flex;
  gap: 14px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn {
  padding: 14px 26px;
  border-radius: 50px;
  font-weight: 900;
  text-decoration: none;
  transition: 0.3s;
  cursor: pointer;
  border: none;
  font-family: inherit;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  justify-content: center;
}

.btn-primary {
  background: linear-gradient(90deg, #f59e0b, #d97706);
  color: #fff;
  box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
}

.btn-secondary {
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  border: 1px solid rgba(255,255,255,0.12);
}

.btn:hover { transform: scale(1.03); }

@media (max-width: 768px) {
  .analysis-section { grid-template-columns: 1fr; }
  header h1 { font-size: 2.1rem; }
  .container { padding: 26px; }
  .lang-toggle{ top: 14px; left: 14px; }
}
</style>
</head>

<body>
  <div class="light-blob blob-1"></div>
  <div class="light-blob blob-2"></div>

  <div class="container">
    <button class="lang-toggle" id="langBtn" onclick="toggleLang()">English</button>

    <header>
      <h1 id="pageTitle"><i class="fas fa-chart-line"></i> تقرير التقييم النهائي</h1>
      <p id="pageSubtitle">تحليل شامل لأدائك في مهارات اللغة الإنجليزية</p>
    </header>

    @php
      $reading   = (int) ($scores['reading'] ?? 0);
      $listening = (int) ($scores['listening'] ?? 0);
      $writing   = (int) ($scores['writing'] ?? 0);
      $speaking  = (int) ($scores['speaking'] ?? 0);

      $overall = (int) round(($reading + $listening + $writing + $speaking) / 4);

      // CEFR mapping (initial PHP fallback)
      $cefr = 'A1'; $cefrAr = 'مبتدئ';
      if ($overall >= 40) { $cefr = 'A2'; $cefrAr = 'مبتدئ مرتفع'; }
      if ($overall >= 55) { $cefr = 'B1'; $cefrAr = 'متوسط'; }
      if ($overall >= 70) { $cefr = 'B2'; $cefrAr = 'متوسط مرتفع'; }
      if ($overall >= 85) { $cefr = 'C1'; $cefrAr = 'متقدم'; }

      // Override with Gemini CEFR if available
      $geminiCefrLevel = $aiAnalysis['cefr_level'] ?? '';
      $geminiCefrDescAr = $aiAnalysis['cefr_description_ar'] ?? '';
      $geminiCefrDescEn = $aiAnalysis['cefr_description_en'] ?? '';

      $cefrLabels = [
          'A1' => 'مبتدئ', 'A2' => 'مبتدئ مرتفع',
          'B1' => 'متوسط', 'B2' => 'متوسط مرتفع',
          'C1' => 'متقدم', 'C2' => 'متقدم مرتفع',
      ];

      if (!empty($geminiCefrLevel) && isset($cefrLabels[$geminiCefrLevel])) {
          $cefr = $geminiCefrLevel;
          $cefrAr = $cefrLabels[$geminiCefrLevel];
      }

      $hintAr = !empty($geminiCefrDescAr) ? $geminiCefrDescAr : 'هذا تقدير مبدئي بناءً على نتائج الاختبار.';
      $hintEn = !empty($geminiCefrDescEn) ? $geminiCefrDescEn : 'This is an initial estimate based on your test scores.';

      // AI Analysis data (from controller)
      $strengthsAr = $aiAnalysis['strengths_ar'] ?? [];
      $strengthsEn = $aiAnalysis['strengths_en'] ?? [];
      $weaknessesAr = $aiAnalysis['weaknesses_ar'] ?? [];
      $weaknessesEn = $aiAnalysis['weaknesses_en'] ?? [];
      $adviceAr = $aiAnalysis['advice_ar'] ?? '';
      $adviceEn = $aiAnalysis['advice_en'] ?? '';

      // Fallback: if AI returned empty, use static analysis
      if (empty($strengthsAr)) {
        $skills = [
          'reading' => ['scoreVal' => $reading, 'arName' => 'القراءة', 'enName' => 'Reading'],
          'listening' => ['scoreVal' => $listening, 'arName' => 'الاستماع', 'enName' => 'Listening'],
          'writing' => ['scoreVal' => $writing, 'arName' => 'الكتابة', 'enName' => 'Writing'],
          'speaking' => ['scoreVal' => $speaking, 'arName' => 'المحادثة', 'enName' => 'Speaking'],
        ];
        $sorted = $skills;
        uasort($sorted, fn($a, $b) => $b['scoreVal'] <=> $a['scoreVal']);
        $strengthKeys = array_slice(array_keys($sorted), 0, 2);
        $weakKeys = array_slice(array_keys($sorted), -2);

        foreach ($strengthKeys as $key) {
          $s = $skills[$key];
          $strengthsAr[] = "أداء متميز في مهارة {$s['arName']} بنسبة {$s['scoreVal']}%.";
          $strengthsEn[] = "Strong performance in {$s['enName']} at {$s['scoreVal']}%.";
        }
        foreach ($weakKeys as $key) {
          $s = $skills[$key];
          $weaknessesAr[] = "مهارة {$s['arName']} تحتاج تطوير — النتيجة الحالية {$s['scoreVal']}%.";
          $weaknessesEn[] = "{$s['enName']} needs improvement — current score {$s['scoreVal']}%.";
        }
      }
    @endphp

    <!-- Overall Level -->
    <div class="level-banner">
      <div class="level-left">
        <div class="level-badge">
          <i class="fas fa-graduation-cap"></i>
          <span id="levelLabel">المستوى العام</span>
          <span>:</span>
          <span>{{ $cefr }}</span>
          <span>({{ $cefrAr }})</span>
        </div>

        <div class="level-text">
          <strong id="overallScoreText">المعدل العام: {{ $overall }}%</strong>
          <span id="levelHint">{{ $hintAr }}</span>
        </div>
      </div>

      <div class="level-badge" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.14); color:#fff;">
        <i class="fas fa-bullseye"></i>
        <span id="nextGoalText">هدفك القادم: رفع المحادثة</span>
      </div>
    </div>

    <!-- Skills (Clickable) -->
    <div class="results-grid">

      <!-- UPDATED LINK -->
      <a class="skill-card" href="{{ route('detailsReading') }}">
        <i class="fas fa-book-open skill-icon"></i>
        <span class="skill-name" id="readingName">القراءة</span>
        <div class="skill-sub" id="tapHint1">اضغط لعرض الأسئلة والإجابات</div>
        <div class="score-circle" style="--p: {{ $reading }}; --ring: var(--neon-blue);">
          <span>{{ $reading }}%</span>
        </div>
      </a>

      <!-- UPDATED LINK -->
      <a class="skill-card" href="{{ route('detailsListening') }}">
        <i class="fas fa-headphones skill-icon"></i>
        <span class="skill-name" id="listeningName">الاستماع</span>
        <div class="skill-sub" id="tapHint2">اضغط لعرض الأسئلة والإجابات</div>
        <div class="score-circle" style="--p: {{ $listening }}; --ring: var(--success-green);">
          <span>{{ $listening }}%</span>
        </div>
      </a>

      <!-- UPDATED LINK -->
      <a class="skill-card" href="{{ route('detailsWriting') }}">
        <i class="fas fa-pen-nib skill-icon"></i>
        <span class="skill-name" id="writingName">الكتابة</span>
        <div class="skill-sub" id="tapHint3">اضغط لعرض التفاصيل</div>
        <div class="score-circle" style="--p: {{ $writing }}; --ring: var(--warning-orange);">
          <span>{{ $writing }}%</span>
        </div>
      </a>

      <!-- UPDATED LINK -->
      <a class="skill-card" href="{{ route('detailsSpeaking') }}">
        <i class="fas fa-microphone-alt skill-icon"></i>
        <span class="skill-name" id="speakingName">المحادثة</span>
        <div class="skill-sub" id="tapHint4">اضغط لعرض التسجيل والتحليل</div>
        <div class="score-circle" style="--p: {{ $speaking }}; --ring: var(--danger-red);">
          <span>{{ $speaking }}%</span>
        </div>
      </a>

    </div>

    <!-- AI-Powered Analysis: Strengths & Weaknesses -->
    <div class="analysis-section">
      <div class="analysis-box strength">
        <h3 id="strengthTitle"><i class="fas fa-award"></i> نقاط القوة</h3>
        <div id="strengthsList">
          @forelse($strengthsAr as $s)
            <div class="list-item">
              <i class="fas fa-check-circle"></i>
              <span>{{ $s }}</span>
            </div>
          @empty
            <div class="list-item">
              <i class="fas fa-check-circle"></i>
              <span>لا توجد بيانات كافية.</span>
            </div>
          @endforelse
        </div>
      </div>

      <div class="analysis-box weakness" style="border-right-color: var(--danger-red);">
        <h3 id="weakTitle"><i class="fas fa-exclamation-triangle"></i> نقاط تحتاج لتطوير</h3>
        <div id="weaknessesList">
          @forelse($weaknessesAr as $w)
            <div class="list-item">
              <i class="fas fa-times-circle"></i>
              <span>{{ $w }}</span>
            </div>
          @empty
            <div class="list-item">
              <i class="fas fa-times-circle"></i>
              <span>لا توجد بيانات كافية.</span>
            </div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- AI Advice Section (NEW) -->
    <div class="ai-advice-section">
      <h3 id="adviceTitle">
        <i class="fas fa-robot"></i>
        تحليل ونصائح الذكاء الاصطناعي
        <span class="ai-badge"><i class="fas fa-sparkles"></i> Gemini AI</span>
      </h3>
      <div class="ai-advice-content" id="adviceContent">
        @if(!empty($adviceAr))
          {{ $adviceAr }}
        @else
          <span style="color: rgba(255,255,255,0.5);">لم يتم إنشاء تحليل بعد. أكمل جميع الاختبارات للحصول على تحليل مفصل من الذكاء الاصطناعي.</span>
        @endif
      </div>
      <div class="ai-powered-label">
        <i class="fas fa-bolt"></i>
        <span id="poweredByText">مدعوم بتقنية الذكاء الاصطناعي من Google Gemini</span>
      </div>
    </div>

    <!-- Actions -->
    <div class="footer-actions">
      <a href="{{ route('index') }}" class="btn btn-secondary" id="homeBtn">
        <i class="fas fa-home"></i> العودة للرئيسية
      </a>

      <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-secondary" id="logoutBtn" style="border-color: var(--danger-red); color: var(--danger-red);">
            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
          </button>
      </form>

      <a href="{{ route('test.strengthening') }}" class="btn btn-primary" id="planBtn">
        <i class="fas fa-shield-alt"></i> ابدأ خطة التقوية
      </a>

      <a href="{{ route('student.assignments.index') }}" class="btn btn-secondary" id="assignmentsBtn" style="border-color: var(--neon-blue); color: var(--neon-blue);">
        <i class="fas fa-tasks"></i> التكاليف الدراسية
      </a>

      <a href="#" class="btn btn-secondary" id="pdfBtn">
        <i class="fas fa-file-download"></i> تحميل التقرير (PDF)
      </a>
    </div>
  </div>
  
  @include('student.partials.chatbot')

<script>
let lang = "ar";

// Store AI data for language switching
const aiData = {
  strengthsAr: @json($strengthsAr),
  strengthsEn: @json($strengthsEn),
  weaknessesAr: @json($weaknessesAr),
  weaknessesEn: @json($weaknessesEn),
  adviceAr: @json($adviceAr),
  adviceEn: @json($adviceEn),
};

function buildListItems(items, iconClass) {
  if (!items || items.length === 0) {
    return `<div class="list-item"><i class="${iconClass}"></i><span>${lang === 'ar' ? 'لا توجد بيانات كافية.' : 'No data available.'}</span></div>`;
  }
  return items.map(item =>
    `<div class="list-item"><i class="${iconClass}"></i><span>${item}</span></div>`
  ).join('');
}

function toggleLang(){
  if(lang === "ar"){
    document.documentElement.lang = "en";
    document.body.style.direction = "ltr";

    document.getElementById("langBtn").innerText = "العربية";
    document.getElementById("pageTitle").innerHTML = '<i class="fas fa-chart-line"></i> Final Evaluation Report';
    document.getElementById("pageSubtitle").innerText = "A complete analysis of your English skills performance";

    document.getElementById("levelLabel").innerText = "Overall Level";
    document.getElementById("overallScoreText").innerText = "Overall average: {{ $overall }}%";
    document.getElementById("levelHint").innerText = "{{ $hintEn }}";
    document.getElementById("nextGoalText").innerText = "Next goal: Improve Speaking";

    document.getElementById("readingName").innerText = "Reading";
    document.getElementById("listeningName").innerText = "Listening";
    document.getElementById("writingName").innerText = "Writing";
    document.getElementById("speakingName").innerText = "Speaking";

    document.getElementById("tapHint1").innerText = "Tap to view Q&A";
    document.getElementById("tapHint2").innerText = "Tap to view Q&A";
    document.getElementById("tapHint3").innerText = "Tap to view details";
    document.getElementById("tapHint4").innerText = "Tap to view recording & analysis";

    document.getElementById("strengthTitle").innerHTML = '<i class="fas fa-award"></i> Strengths';
    document.getElementById("strengthsList").innerHTML = buildListItems(aiData.strengthsEn, 'fas fa-check-circle');

    document.getElementById("weakTitle").innerHTML = '<i class="fas fa-exclamation-triangle"></i> Needs Improvement';
    document.getElementById("weaknessesList").innerHTML = buildListItems(aiData.weaknessesEn, 'fas fa-times-circle');

    document.getElementById("adviceTitle").innerHTML = '<i class="fas fa-robot"></i> AI Analysis & Recommendations <span class="ai-badge"><i class="fas fa-sparkles"></i> Gemini AI</span>';
    document.getElementById("adviceContent").innerText = aiData.adviceEn || "No analysis available yet. Complete all tests to get a detailed AI analysis.";
    document.getElementById("poweredByText").innerText = "Powered by Google Gemini AI";

    document.getElementById("homeBtn").innerHTML = '<i class="fas fa-home"></i> Home';
    document.getElementById("logoutBtn").innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
    document.getElementById("planBtn").innerHTML = '<i class="fas fa-shield-alt"></i> Start Strengthening Plan';
    document.getElementById("assignmentsBtn").innerHTML = '<i class="fas fa-tasks"></i> Academic Assignments';
    document.getElementById("pdfBtn").innerHTML = '<i class="fas fa-file-download"></i> Download Report (PDF)';

    // move toggle button for LTR
    document.querySelector(".lang-toggle").style.left = "auto";
    document.querySelector(".lang-toggle").style.right = "18px";

    lang = "en";
  } else {
    document.documentElement.lang = "ar";
    document.body.style.direction = "rtl";

    document.getElementById("langBtn").innerText = "English";
    document.getElementById("pageTitle").innerHTML = '<i class="fas fa-chart-line"></i> تقرير التقييم النهائي';
    document.getElementById("pageSubtitle").innerText = "تحليل شامل لأدائك في مهارات اللغة الإنجليزية";

    document.getElementById("levelLabel").innerText = "المستوى العام";
    document.getElementById("overallScoreText").innerText = "المعدل العام: {{ $overall }}%";
    document.getElementById("levelHint").innerText = "{{ $hintAr }}";
    document.getElementById("nextGoalText").innerText = "هدفك القادم: رفع المحادثة";

    document.getElementById("readingName").innerText = "القراءة";
    document.getElementById("listeningName").innerText = "الاستماع";
    document.getElementById("writingName").innerText = "الكتابة";
    document.getElementById("speakingName").innerText = "المحادثة";

    document.getElementById("tapHint1").innerText = "اضغط لعرض الأسئلة والإجابات";
    document.getElementById("tapHint2").innerText = "اضغط لعرض الأسئلة والإجابات";
    document.getElementById("tapHint3").innerText = "اضغط لعرض التفاصيل";
    document.getElementById("tapHint4").innerText = "اضغط لعرض التسجيل والتحليل";

    document.getElementById("strengthTitle").innerHTML = '<i class="fas fa-award"></i> نقاط القوة';
    document.getElementById("strengthsList").innerHTML = buildListItems(aiData.strengthsAr, 'fas fa-check-circle');

    document.getElementById("weakTitle").innerHTML = '<i class="fas fa-exclamation-triangle"></i> نقاط تحتاج لتطوير';
    document.getElementById("weaknessesList").innerHTML = buildListItems(aiData.weaknessesAr, 'fas fa-times-circle');

    document.getElementById("adviceTitle").innerHTML = '<i class="fas fa-robot"></i> تحليل ونصائح الذكاء الاصطناعي <span class="ai-badge"><i class="fas fa-sparkles"></i> Gemini AI</span>';
    document.getElementById("adviceContent").innerText = aiData.adviceAr || "لم يتم إنشاء تحليل بعد. أكمل جميع الاختبارات للحصول على تحليل مفصل من الذكاء الاصطناعي.";
    document.getElementById("poweredByText").innerText = "مدعوم بتقنية الذكاء الاصطناعي من Google Gemini";

    document.getElementById("homeBtn").innerHTML = '<i class="fas fa-home"></i> العودة للرئيسية';
    document.getElementById("logoutBtn").innerHTML = '<i class="fas fa-sign-out-alt"></i> تسجيل الخروج';
    document.getElementById("planBtn").innerHTML = '<i class="fas fa-shield-alt"></i> ابدأ خطة التقوية';
    document.getElementById("assignmentsBtn").innerHTML = '<i class="fas fa-tasks"></i> التكاليف الدراسية';
    document.getElementById("pdfBtn").innerHTML = '<i class="fas fa-file-download"></i> تحميل التقرير (PDF)';

    // move toggle button for RTL
    document.querySelector(".lang-toggle").style.right = "auto";
    document.querySelector(".lang-toggle").style.left = "18px";

    lang = "ar";
  }
}
</script>
</body>
</html>