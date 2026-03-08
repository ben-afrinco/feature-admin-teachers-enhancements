<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Writing Test</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

    /* Topbar */
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
      padding: 12px 14px;
      border-radius: 18px;
      border: 1px solid rgba(255,255,255,0.16);
      background: rgba(255,255,255,0.07);
      backdrop-filter: blur(16px);
      box-shadow: 0 18px 55px rgba(0,180,255,0.10);
    }

    .left-actions{
      display:flex;
      align-items:center;
      gap: 10px;
      min-width: 220px;
    }

    .btn{
      border: 1px solid rgba(255,255,255,0.16);
      background: rgba(255,255,255,0.08);
      color:#fff;
      padding: 10px 14px;
      border-radius: 14px;
      font-size: 13.5px;
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
      white-space: nowrap;
    }

    .timer{
      padding: 10px 14px;
      border-radius: 14px;
      border: 1px solid rgba(255,255,255,0.16);
      background: rgba(0,0,0,0.18);
      color: var(--muted);
      font-weight: 900;
      font-size: 13px;
      min-width: 110px;
      text-align:center;
    }

    .shell{
      max-width: 1200px;
      margin: 0 auto;
    }

    .main{
      display:flex;
      justify-content:center;
      align-items:flex-start;
      margin-top: 14px;
      padding-bottom: 30px;
    }

    .card{
      width: 100%;
      max-width: 900px;
      background: var(--card);
      border: 1px solid var(--stroke);
      border-radius: var(--radius);
      backdrop-filter: blur(16px);
      box-shadow: var(--shadow);
      overflow:hidden;
    }

    .card-head{
      padding: 18px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.10);
      background: rgba(0,0,0,0.10);
    }

    .card-head h1{
      margin:0;
      font-size: 18px;
      font-weight: 900;
      color: #eafcff;
      letter-spacing:.2px;
    }
    .card-head p{
      margin: 8px 0 0;
      font-size: 13.5px;
      color: var(--muted2);
      line-height: 1.7;
    }

    .card-body{
      padding: 18px 20px 22px;
    }

    .writing-wrapper{
      position: relative;
      margin-top: 14px;
    }

    textarea{
      width: 100%;
      height: 260px;
      background: rgba(0,0,0,0.16);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 22px;
      padding: 16px 16px 42px;
      color: rgba(255,255,255,0.90);
      font-size: 14.5px;
      line-height: 1.8;
      font-family: inherit;
      resize: none;
      outline: none;
      transition: 0.25s ease;
    }

    textarea:focus{
      border-color: rgba(0,198,255,0.45);
      box-shadow: 0 0 0 3px rgba(0,198,255,0.12);
      background: rgba(0,0,0,0.20);
    }

    .word-count{
      position:absolute;
      right: 16px;
      bottom: 14px;
      color: rgba(255,255,255,0.55);
      font-weight: 800;
      font-size: 12.5px;
    }

    .validation-msg{
      margin-top: 10px;
      padding: 12px 14px;
      border-radius: 16px;
      border: 1px solid rgba(255,75,43,0.30);
      background: rgba(255,75,43,0.10);
      color: rgba(255,255,255,0.88);
      font-size: 13px;
      display:none;
    }

    .actions{
      display:flex;
      gap: 12px;
      margin-top: 14px;
      justify-content:flex-end;
      flex-wrap: wrap;
    }

    .btn-primary{
      border:none;
      background: linear-gradient(135deg, var(--brand1), var(--brand2));
      font-weight: 900;
      padding: 12px 18px;
      border-radius: 999px;
      box-shadow: 0 10px 24px rgba(0,200,255,0.15);
    }
    .btn-primary:hover{
      box-shadow: 0 10px 24px rgba(0,200,255,0.25);
    }

    .btn-success{
      border:none;
      background: linear-gradient(135deg, #10b981, #0da271);
      font-weight: 900;
      padding: 12px 18px;
      border-radius: 999px;
      display:none;
      color:#fff;
      text-decoration:none;
      align-items:center;
      gap:8px;
    }

    @media (max-width: 520px){
      .left-actions{ min-width:auto; }
      .timer{ min-width: 95px; }
      .actions{ justify-content:stretch; }
      .actions .btn{ width:100%; justify-content:center; }
      .btn-success{ width:100%; justify-content:center; }
    }
  </style>
</head>

<body>
  <div class="light"></div>

  <!-- Topbar -->
  <div class="topbar">
    <div class="topbar-inner shell">
      <div class="left-actions">
        <a href="{{ url()->previous() }}" class="btn">
          <i class="fas fa-arrow-left"></i> Back
        </a>
      </div>

      <div class="badge">
        <i class="fas fa-pen-nib"></i> Writing Section
      </div>

      <!-- ✅ timer now 20:00 -->
      <div class="timer" id="timer">20:00</div>
    </div>
  </div>

  <!-- Main -->
  <div class="shell">
    <div class="main">
      <div class="card">
        <div class="card-head">
          <h1>Writing Task</h1>
          <p>{!! nl2br(e($test->content)) !!}</p>
        </div>

        <div class="card-body">
          <form method="POST" action="{{ route('writing.submit') }}" id="wForm">
            @csrf
          <div class="writing-wrapper">
            <textarea
              name="essay"
              id="writingText"
              placeholder="Start typing your response here..."
              oninput="validateInput()"
            ></textarea>
            <div class="word-count" id="wordCountCounter">Words: 0</div>
          </div>

          <div id="englishOnlyMsg" class="validation-msg">
            <i class="fas fa-exclamation-circle"></i>
            Only English characters are allowed. Please remove non-English text.
          </div>

          <div id="pasteMsg" class="validation-msg" style="display:none; border-color: rgba(255,160,0,0.35); background: rgba(255,160,0,0.10);">
            <i class="fas fa-ban"></i>
            Pasting is disabled. Please type your answer.
          </div>

          <div class="actions">
            <button id="saveBtn" class="btn btn-primary" type="button" onclick="submitWriting()">
              Save Response <i class="fas fa-save" style="margin-left: 8px;"></i>
            </button>

            <!-- ✅ route fixed to writing.done -->
            <a id="nextBtn" href="{{ route('writing.done') }}" class="btn btn-success">
              Finish <i class="fas fa-chevron-right" style="margin-left: 8px;"></i>
            </a>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    /* =========================
       ✅ Countdown Timer (20:00)
       ========================= */
    let time = 20 * 60;
    const timerEl = document.getElementById('timer');

    function renderTimer(){
      const mins = String(Math.floor(time / 60)).padStart(2,'0');
      const secs = String(time % 60).padStart(2,'0');
      timerEl.textContent = `${mins}:${secs}`;
    }

    renderTimer();
    setInterval(() => {
      if (time > 0) {
        time--;
        renderTimer();
      }
    }, 1000);

    /* =========================
       ✅ Disable paste in textarea
       ========================= */
    const textarea = document.getElementById("writingText");
    const pasteMsg = document.getElementById("pasteMsg");

    // prevent Ctrl+V / Cmd+V
    textarea.addEventListener("keydown", (e) => {
      const isPaste = (e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === "v");
      if (isPaste) {
        e.preventDefault();
        showPasteWarning();
      }
    });

    // prevent right-click paste / menu paste
    textarea.addEventListener("paste", (e) => {
      e.preventDefault();
      showPasteWarning();
    });

    // prevent dropping text into textarea
    textarea.addEventListener("drop", (e) => {
      e.preventDefault();
      showPasteWarning();
    });

    // optional: block cut/copy too (leave it allowed unless you want)
    // textarea.addEventListener("copy", (e)=> e.preventDefault());
    // textarea.addEventListener("cut", (e)=> e.preventDefault());

    function showPasteWarning(){
      pasteMsg.style.display = "block";
      clearTimeout(window.__pasteTimer);
      window.__pasteTimer = setTimeout(() => {
        pasteMsg.style.display = "none";
      }, 2200);
    }

    /* =========================
       ✅ English Only Validation + Word Count
       ========================= */
    function validateInput() {
      const msg = document.getElementById("englishOnlyMsg");
      const saveBtn = document.getElementById("saveBtn");
      const val = textarea.value;

      const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;

      if (arabicRegex.test(val)) {
        msg.style.display = "block";
        saveBtn.disabled = true;
        saveBtn.style.opacity = "0.55";
      } else {
        msg.style.display = "none";
        saveBtn.disabled = false;
        saveBtn.style.opacity = "1";
      }

      const words = val.trim() ? val.trim().split(/\s+/).length : 0;
      document.getElementById("wordCountCounter").textContent = "Words: " + words;
    }

    /* =========================
       ✅ Save / Reveal Finish
       ========================= */
    function submitWriting() {
      const text = textarea.value.trim();

      if (text.length === 0) {
        alert("Please write your response before saving.");
        return;
      }

      const saveBtn = document.getElementById("saveBtn");
      const nextBtn = document.getElementById("nextBtn");

      saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
      saveBtn.disabled = true;

      setTimeout(() => {
        document.getElementById("wForm").submit();
      }, 1200);
    }
  </script>
</body>
</html>