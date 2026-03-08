<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Speaking Test - LingoPulse</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body{
      margin:0;
      background:#000c1d;
      font-family:"Poppins", sans-serif;
      color:#fff;
      overflow-x:hidden;
      min-height:100vh;
    }

    .light{
      position:fixed;
      width:650px;
      height:650px;
      background: radial-gradient(circle, rgba(0,200,255,0.3), transparent);
      animation: moveLight 8s infinite alternate ease-in-out;
      filter: blur(80px);
      z-index:0;
    }
    @keyframes moveLight{
      0% { top:-120px; left:-160px; transform: scale(1); }
      50% { top:35%; left:55%; transform: translate(-50%, -50%) scale(1.03); }
      100% { top:85%; left:-120px; transform: scale(1); }
    }

    .top-bar{
      position:fixed;
      top:0;
      left:0;
      z-index:1000;
      width:100%;
      box-sizing: border-box;
      padding:12px 24px;
      background: rgba(10, 20, 40, 0.85);
      border-bottom: 1px solid rgba(255,255,255,0.1);
      display:flex;
      justify-content: space-between;
      align-items:center;
      gap: 14px;
      backdrop-filter: blur(20px);
      overflow: visible;
    }

    .logo-text{
      font-size:20px;
      color:#00c6ff;
      font-weight:700;
      display:flex;
      align-items:center;
      gap:10px;
      white-space: nowrap;
      flex: 1 1 auto;
      justify-content:center;
      text-align:center;
    }

    .timer{
      font-size:18px;
      font-weight:bold;
      color:#00c6ff;
      white-space: nowrap;
      flex: 0 0 auto;
      min-width: 86px;
      text-align:right;
      font-variant-numeric: tabular-nums;
    }

    .back-link{
      display:flex;
      align-items:center;
      gap:8px;
      color:#94a3b8;
      text-decoration:none;
      font-size:0.95rem;
      white-space: nowrap;
      transition: .2s;
      flex: 0 0 auto;
    }
    .back-link.disabled{
      opacity:.45;
      pointer-events:none;
      cursor:not-allowed;
    }

    .main-container{
      position:relative;
      z-index:1;
      padding:100px 20px 40px;
      display:flex;
      justify-content:center;
      align-items:center;
      min-height:100vh;
    }

    .card{
      background: rgba(255, 255, 255, 0.06);
      border-radius:30px;
      padding:40px;
      border:1px solid rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(20px);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
      width:100%;
      max-width:600px;
      text-align:center;
    }

    h1{
      font-size:2rem;
      margin-bottom:10px;
      background: linear-gradient(to right, #fff, #00c6ff);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
    }

    .desc{
      color:#b0c4de;
      margin-bottom:16px;
      line-height:1.6;
    }

    .prompt-box{
      margin: 0 auto 18px;
      padding: 14px 16px;
      border-radius: 18px;
      text-align: left;
      background: rgba(0,0,0,0.16);
      border: 1px solid rgba(255,255,255,0.10);
      color: rgba(255,255,255,0.88);
      line-height: 1.7;
    }
    .prompt-box .label{
      display:inline-flex;
      align-items:center;
      gap:8px;
      font-weight:800;
      color:#00c6ff;
      margin-bottom:6px;
    }
    .prompt-box .q{
      margin:0;
      font-weight:700;
      color: rgba(255,255,255,0.92);
    }

    .status-badge{
      display:inline-block;
      padding:8px 20px;
      border-radius:20px;
      background: rgba(255, 255, 255, 0.05);
      font-size:0.9rem;
      margin-bottom:12px;
      color:#00c6ff;
      border:1px solid rgba(0, 198, 255, 0.2);
      font-weight:700;
    }

    .countdown-text{
      margin: 0 auto 10px;
      color: rgba(255,255,255,.75);
      font-weight: 700;
      font-size: 0.95rem;
      min-height: 22px;
    }

    .record-btn{
      width:120px;
      height:120px;
      border-radius:50%;
      background: linear-gradient(135deg, #00c6ff, #007BFF);
      display:flex;
      justify-content:center;
      align-items:center;
      font-size:40px;
      margin:0 auto 18px;
      cursor:pointer;
      box-shadow: 0 0 30px rgba(0, 198, 255, 0.4);
      transition:0.3s;
      border:4px solid rgba(255, 255, 255, 0.2);
      color:white;
      user-select:none;
      font-weight: 900;
    }

    .record-btn.recording{
      background: linear-gradient(135deg, #ff416c, #ff4b2b);
      animation:pulse 1.5s infinite;
      box-shadow: 0 0 50px rgba(255, 65, 108, 0.5);
    }

    .record-btn.countdown{
      background: rgba(255,255,255,0.08);
      border-color: rgba(255,255,255,0.18);
      box-shadow: 0 0 30px rgba(0, 198, 255, 0.25);
      cursor: default;
    }

    @keyframes pulse{
      0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 65, 108, 0.7); }
      70% { transform: scale(1.1); box-shadow: 0 0 0 20px rgba(255, 65, 108, 0); }
      100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 65, 108, 0); }
    }

    audio{
      width:100%;
      margin-top:18px;
      display:none;
      filter: invert(1) hue-rotate(180deg);
    }

    .result-box{
      margin-top:16px;
      background: rgba(255, 255, 255, 0.08);
      padding:16px;
      border-radius:15px;
      text-align:left;
      font-size:0.95rem;
      line-height:1.6;
      display:none;
      border:1px solid rgba(255, 255, 255, 0.05);
    }

    .btn-row{
      display:none;
      margin-top:24px;
      gap:12px;
    }
    .btn{
      flex:1;
      padding:16px 18px;
      border-radius:50px;
      text-decoration:none;
      font-weight:800;
      font-size:1.05rem;
      border:none;
      cursor:pointer;
      transition:0.3s;
      display:flex;
      justify-content:center;
      align-items:center;
      gap:10px;
      width:100%;
    }

    .btn-finish{
      background: linear-gradient(135deg, #10b981, #0da271);
      color:#fff;
      box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }
    .btn-finish:hover{
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(16, 185, 129, 0.5);
    }

    .btn-again{
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.18);
      color:#fff;
    }
    .btn-again:hover{
      transform: translateY(-2px);
      background: rgba(255,255,255,.12);
    }
    .btn-again:disabled{
      opacity:.45;
      cursor:not-allowed;
      transform:none;
    }

    @media (max-width: 520px){
      .top-bar{ padding: 10px 12px; }
      .logo-text{ font-size: 16px; gap: 8px; }
      .timer{ font-size: 16px; min-width: 78px; }
      .back-link{ font-size: 0.9rem; }

      .card{ padding: 22px; border-radius: 22px; }
      h1{ font-size: 1.6rem; }
      .desc{ font-size: .95rem; margin-bottom: 14px; }

      .record-btn{ width: 96px; height: 96px; font-size: 34px; margin-bottom: 14px; }

      .btn-row{ flex-direction: column; }
    }
  </style>
</head>

<body>
  <div class="light"></div>

  <div class="top-bar">
    <a href="{{ url()->previous() }}" class="back-link" id="backLink">
      <i class="fas fa-arrow-left"></i> Back
    </a>

    <div class="logo-text">
      <i class="fas fa-microphone-alt"></i> Speaking Section
    </div>

    <div class="timer" id="timer">15:00</div>
  </div>

  <div class="main-container">
    <div class="card">
      <h1>Speaking Task</h1>
      <p class="desc">
        Please talk in <b>English</b> for about <b>40 seconds</b>.
        Click the microphone to start.
      </p>

      <!-- ✅ إعداد نص محدد للقراءة -->
      <div class="prompt-box">
        <div class="label"><i class="fas fa-book-open"></i> Please read this passage aloud:</div>
        <p class="q" id="targetText">{{ $test->content }}</p>
      </div>

      <div id="status" class="status-badge">Ready to Record</div>
      <div class="countdown-text" id="countdownText"></div>

      <div class="record-btn" id="recBtn">
        <i class="fas fa-microphone"></i>
      </div>

      <audio id="audioPlayback" controls></audio>
      <div class="result-box" id="resultBox"></div>

      <div class="btn-row" id="btnRow">
        <button class="btn btn-again" id="recordAgainBtn" type="button">
          <i class="fas fa-rotate-left"></i> Record Again (2 left)
        </button>

        <!-- ✅ حفظ النسبة والترانسكربشن للباكاند -->
        <button type="button" class="btn btn-finish" id="seeResultsBtn" onclick="submitSpeakingTest()">
          Finish <i class="fas fa-chevron-right"></i>
        </button>
      </div>
      <form id="speakForm" method="POST" action="{{ route('speaking.submit') }}" style="display:none;">
        @csrf
        <input type="hidden" name="transcription" id="transcriptionInput" value="">
        <input type="hidden" name="accuracy" id="accuracyInput" value="0">
      </form>
    </div>
  </div>

  <script>
    /* =================================
       Redirect target (speakingdone)
       ================================= */
    const DONE_URL = "{{ route('speaking.done') }}";

    /* =========================
       Section timer (15 minutes)
       ========================= */
    let sectionTime = 15 * 60;
    const timerEl = document.getElementById('timer');
    timerEl.textContent = "15:00";

    const sectionInterval = setInterval(() => {
      if (sectionTime > 0) {
        sectionTime--;
        const mins = Math.floor(sectionTime / 60);
        const secs = sectionTime % 60;
        timerEl.textContent = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
      } else {
        // ✅ اختياري: لو انتهت مدة السكشن، انقل إلى speakingdone
        clearInterval(sectionInterval);
        // Save transcription before submit
        document.getElementById('transcriptionInput').value = resultBox.textContent.trim() || 'No speech detected.';
        document.getElementById('speakForm').submit();
      }
    }, 1000);

    /* =========================
       Recording rules
       ========================= */
    const MAX_RECORD_SECONDS = 40;
    let reRecordLeft = 2;

    let recording = false;
    let isCountingDown = false;

    let mediaRecorder;
    let audioChunks = [];
    let recognition;
    let activeStream = null;

    let autoStopTimeout = null;
    let recordCountdownInterval = null;
    let recordSecondsLeft = MAX_RECORD_SECONDS;

    const recBtn = document.getElementById("recBtn");
    const statusBadge = document.getElementById("status");
    const audioPlayback = document.getElementById("audioPlayback");
    const resultBox = document.getElementById("resultBox");
    const btnRow = document.getElementById("btnRow");
    const recordAgainBtn = document.getElementById("recordAgainBtn");
    const countdownText = document.getElementById("countdownText");
    const backLink = document.getElementById("backLink");

    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
      recognition = new SpeechRecognition();
      recognition.lang = 'en-US';
      recognition.continuous = true;
      recognition.interimResults = true;
    }

    function formatMMSS(totalSeconds){
      const mm = Math.floor(totalSeconds / 60);
      const ss = totalSeconds % 60;
      return `${mm}:${ss < 10 ? '0' : ''}${ss}`;
    }

    function disableBack(disabled){
      if(disabled) backLink.classList.add("disabled");
      else backLink.classList.remove("disabled");
    }

    function protectNavigation(enable){
      if(enable){
        history.pushState({locked:true}, "", location.href);
        window.onpopstate = function(){
          history.pushState({locked:true}, "", location.href);
        };
      }else{
        window.onpopstate = null;
      }
    }

    function stopAllTracks(){
      if (activeStream) {
        activeStream.getTracks().forEach(t => t.stop());
        activeStream = null;
      }
    }

    function clearTimers(){
      if (autoStopTimeout) clearTimeout(autoStopTimeout);
      autoStopTimeout = null;

      if (recordCountdownInterval) clearInterval(recordCountdownInterval);
      recordCountdownInterval = null;
    }

    function updateReRecordButton(){
      recordAgainBtn.innerHTML = `<i class="fas fa-rotate-left"></i> Record Again (${reRecordLeft} left)`;
      recordAgainBtn.disabled = (reRecordLeft <= 0);
    }

    function resetUI(){
      clearTimers();
      stopAllTracks();

      audioPlayback.pause();
      audioPlayback.removeAttribute("src");
      audioPlayback.load();
      audioPlayback.style.display = "none";

      resultBox.textContent = "";
      resultBox.style.display = "none";

      btnRow.style.display = "none";

      recording = false;
      isCountingDown = false;
      recBtn.classList.remove("recording", "countdown");
      recBtn.innerHTML = '<i class="fas fa-microphone"></i>';

      statusBadge.textContent = "Ready to Record";
      statusBadge.style.color = "#00c6ff";
      recordSecondsLeft = MAX_RECORD_SECONDS;

      countdownText.textContent = "";

      disableBack(false);
      protectNavigation(false);

      updateReRecordButton();
    }

    function startRecordCountdownTimer(){
      recordSecondsLeft = MAX_RECORD_SECONDS;
      statusBadge.textContent = `Recording Time: ${formatMMSS(recordSecondsLeft)}`;
      statusBadge.style.color = "#ff4b2b";

      recordCountdownInterval = setInterval(() => {
        recordSecondsLeft--;
        if (recordSecondsLeft <= 0){
          statusBadge.textContent = `Recording Time: 0:00`;
          clearInterval(recordCountdownInterval);
          recordCountdownInterval = null;
          return;
        }
        statusBadge.textContent = `Recording Time: ${formatMMSS(recordSecondsLeft)}`;
      }, 1000);
    }

    async function startRecordingNow(){
      countdownText.textContent = "";

      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      activeStream = stream;

      mediaRecorder = new MediaRecorder(stream);
      audioChunks = [];

      mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
      mediaRecorder.onstop = () => {
        const audioBlob = new Blob(audioChunks, { type: "audio/webm" });
        audioPlayback.src = URL.createObjectURL(audioBlob);
        audioPlayback.style.display = "block";
      };

      mediaRecorder.start();

      if (recognition) {
        resultBox.textContent = "";
        recognition.start();
        recognition.onresult = (event) => {
          for (let i = event.resultIndex; i < event.results.length; ++i) {
            if (event.results[i].isFinal) {
              resultBox.textContent += event.results[i][0].transcript + " ";
            }
          }
        };
      }

      recording = true;
      recBtn.classList.remove("countdown");
      recBtn.classList.add("recording");
      recBtn.innerHTML = '<i class="fas fa-stop"></i>';

      audioPlayback.style.display = "none";
      resultBox.style.display = "none";
      btnRow.style.display = "none";

      disableBack(true);
      protectNavigation(true);

      startRecordCountdownTimer();

      // ✅ بعد 40 ثانية يوقف تلقائيًا وينقل إلى speakingdone
      autoStopTimeout = setTimeout(() => {
        if (recording) stopRecording(true);
      }, MAX_RECORD_SECONDS * 1000);
    }

    function stopRecording(isAutoStop = false){
      if (!recording) return;

      clearTimers();

      try{
        if (mediaRecorder && mediaRecorder.state !== "inactive") {
          mediaRecorder.stop();
        }
      }catch(e){}

      if (recognition) {
        try{ recognition.stop(); }catch(e){}
      }

      stopAllTracks();

      recording = false;
      recBtn.classList.remove("recording");
      recBtn.innerHTML = '<i class="fas fa-microphone"></i>';

      statusBadge.textContent = "Recording Saved";
      statusBadge.style.color = "#10b981";

      // ✅ معالجة النتائج والمقارنة بعد التوقف
      const spokenTranscript = resultBox.textContent.trim() || "";
      const { html, accuracy } = compareAndHighlightSpoken(
        document.getElementById('targetText').textContent, 
        spokenTranscript
      );
      
      resultBox.innerHTML = html; // Show the highlighted comparison instead of plain text
      resultBox.style.display = "block";
      document.getElementById('accuracyInput').value = accuracy; // Save accuracy for submit
      document.getElementById('transcriptionInput').value = spokenTranscript;

      disableBack(false);
      protectNavigation(false);
      countdownText.textContent = `Accuracy: ${accuracy}%`; // Show accuracy preview

      if(isAutoStop){
        countdownText.textContent += " - Redirecting...";
        setTimeout(() => {
          submitSpeakingTest();
        }, 1500);
        return;
      }

      btnRow.style.display = "flex";
    }

    async function start3_2_1_thenRecord(){
      if (isCountingDown || recording) return;

      isCountingDown = true;
      recBtn.classList.add("countdown");
      btnRow.style.display = "none";
      audioPlayback.style.display = "none";
      resultBox.style.display = "none";

      disableBack(true);
      protectNavigation(true);

      countdownText.textContent = "Recording starts in...";
      statusBadge.textContent = "Get ready...";
      statusBadge.style.color = "#00c6ff";

      let n = 3;
      recBtn.textContent = n;

      const interval = setInterval(async () => {
        n--;
        if (n > 0){
          recBtn.textContent = n;
          return;
        }

        clearInterval(interval);
        recBtn.textContent = "GO!";

        setTimeout(async () => {
          try{
            await startRecordingNow();
          }catch(err){
            isCountingDown = false;
            recBtn.classList.remove("countdown");
            recBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            countdownText.textContent = "";
            statusBadge.textContent = "Microphone access denied";
            statusBadge.style.color = "#ff4b2b";
            disableBack(false);
            protectNavigation(false);
            console.error(err);
          } finally{
            isCountingDown = false;
          }
        }, 350);

      }, 800);
    }

    recBtn.addEventListener("click", async () => {
      if (isCountingDown) return;

      if (!recording) {
        await start3_2_1_thenRecord();
      } else {
        stopRecording(false);
      }
    });

    recordAgainBtn.addEventListener("click", () => {
      if(reRecordLeft <= 0) return;
      reRecordLeft--;
      resetUI();
    });

    function submitSpeakingTest() {
      if (!document.getElementById('transcriptionInput').value) {
        document.getElementById('transcriptionInput').value = 'No speech detected.';
      }
      document.getElementById('speakForm').submit();
    }

    // ✅ خوارزمية مطابقة الصوت بالنص وتلوين الكلمات
    function compareAndHighlightSpoken(targetText, spokenText) {
      if (!spokenText) return { html: "<span style='color:#ef4444'>No speech detected.</span>", accuracy: 0 };
      
      const targetWordsOriginal = targetText.split(/\s+/);
      const targetWordsNormal = targetText.toLowerCase().replace(/[.,!?]/g, '').split(/\s+/);
      const spokenWordsNormal = spokenText.toLowerCase().replace(/[.,!?]/g, '').split(/\s+/);

      let html = "";
      let correctCount = 0;
      let spokenIndex = 0;

      for (let i = 0; i < targetWordsNormal.length; i++) {
        let tWord = targetWordsNormal[i];
        let originalWord = targetWordsOriginal[i];
        let found = false;

        // ابحث عن الكلمة في حدود الكلمات الخمس التالية من الصوت (للتغلب على التأتأة أو الأخطاء)
        for (let j = spokenIndex; j < Math.min(spokenIndex + 5, spokenWordsNormal.length); j++) {
            if (spokenWordsNormal[j] === tWord) {
                found = true;
                spokenIndex = j + 1; // تقدم في مؤشر الصوت لتجنب مطابقة كلمتين بنفس الكلمة المنطوقة
                break;
            }
        }

        if (found) {
            html += `<span style="color: #10b981; font-weight: bold;">${originalWord}</span> `; // أخضر
            correctCount++;
        } else {
            html += `<span style="color: #ef4444; border-bottom: 2px solid #ef4444;">${originalWord}</span> `; // أحمر مسطر
        }
      }
      
      let accuracy = Math.round((correctCount / targetWordsNormal.length) * 100);
      return { html, accuracy };
    }

    updateReRecordButton();
    resetUI();
  </script>
</body>
</html>