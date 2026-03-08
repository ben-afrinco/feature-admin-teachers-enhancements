<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reading Completed - LingoPulse</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

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
  display:flex;
  justify-content:center;
  align-items:center;
  padding: 84px 18px 22px;
  overflow-x:hidden;
  position:relative;
}

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

.translate-btn{
  position: fixed;
  top: 18px;
  right: 18px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.16);
  color:#fff;
  padding: 9px 15px;
  border-radius: 14px;
  font-weight: 700;
  cursor:pointer;
  backdrop-filter: blur(10px);
  transition:.2s;
  z-index:10;
}
.translate-btn:hover{
  background: rgba(255,255,255,0.12);
}

.card{
  width: min(860px, 100%);
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  box-shadow: var(--shadow);
  overflow:hidden;
  animation: fadeIn .9s ease-in-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

.header{
  padding: 34px 22px 26px;
  text-align:center;
  background: rgba(255,255,255,0.02);
}
.header h1{
  margin: 0 0 10px;
  font-size: clamp(26px, 3vw, 34px);
  font-weight: 900;
}
.header p{
  margin: 0;
  color: var(--muted);
}

.strip{
  background: rgba(0,0,0,0.10);
  border-top: 1px solid rgba(255,255,255,0.10);
  border-bottom: 1px solid rgba(255,255,255,0.10);
  padding: 18px 14px;
}
.skills{
  display:grid;
  grid-template-columns: repeat(4, minmax(0,1fr));
  gap: 12px;
}
.skill{
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.05);
  border-radius: 18px;
  padding: 14px 10px;
  text-align:center;
}
.icon-wrap{
  width: 56px;
  height: 56px;
  margin: 0 auto 10px;
  display:flex;
  align-items:center;
  justify-content:center;
}
.skill img{
  width: 52px;
  height: 52px;
}
.skill strong{
  display:block;
  font-size: 14px;
  font-weight: 900;
}
.skill span{
  display:block;
  font-size: 13px;
  color: var(--muted2);
  font-weight: 700;
}

.checkCircle{
  width: 52px;
  height: 52px;
  border-radius: 999px;
  background: rgba(0,198,255,0.16);
  border: 1px solid rgba(0,198,255,0.45);
  display:flex;
  align-items:center;
  justify-content:center;
}

.footer{
  padding: 22px;
  display:flex;
  justify-content:center;
}
.cta{
  width: min(420px, 100%);
  border:none;
  border-radius: 999px;
  padding: 14px 18px;
  font-weight: 900;
  font-size: 15px;
  color:#fff;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  text-decoration:none;
  text-align:center;
}

@media (max-width: 820px){
  .skills{ grid-template-columns: repeat(2, minmax(0,1fr)); }
}
</style>
</head>

<body>

<div class="light"></div>

<button class="translate-btn" onclick="toggleLang()" id="translateBtn">Translate</button>

<div class="card">

  <div class="header">
    <h1 id="title">Well done!</h1>
    <p id="desc">You are about to start the listening section.</p>
  </div>

  <div class="strip">
    <div class="skills">

      <div class="skill">
        <div class="icon-wrap">
          <div class="checkCircle">✔</div>
        </div>
        <strong id="readingText">Reading</strong>
        <span>20 mins</span>
      </div>

      <div class="skill">
        <div class="icon-wrap">
          <img src="{{ asset('images/listening.png') }}">
        </div>
        <strong id="listeningText">Listening</strong>
        <span>20 mins</span>
      </div>

      <div class="skill">
        <div class="icon-wrap">
          <img src="{{ asset('images/writing.png') }}">
        </div>
        <strong id="writingText">Writing</strong>
        <span>35 mins</span>
      </div>

      <div class="skill">
        <div class="icon-wrap">
          <img src="{{ asset('images/speaking.png') }}">
        </div>
        <strong id="speakingText">Speaking</strong>
        <span>15 mins</span>
      </div>

    </div>
  </div>

  <div class="footer">
    <!-- ✅ تم التعديل هنا -->
    <a class="cta" href="{{ route('listening.getready') }}" id="nextBtn">
      Continue to the next section
    </a>
  </div>

</div>

<script>
let lang = "en";

function toggleLang(){
    if(lang === "en"){
        document.getElementById("title").innerText = "أحسنت!";
        document.getElementById("desc").innerText = "أنت على وشك بدء قسم الاستماع.";
        document.getElementById("readingText").innerText = "القراءة";
        document.getElementById("listeningText").innerText = "الاستماع";
        document.getElementById("writingText").innerText = "الكتابة";
        document.getElementById("speakingText").innerText = "المحادثة";
        document.getElementById("nextBtn").innerText = "المتابعة إلى القسم التالي";
        document.getElementById("translateBtn").innerText = "English";
        document.body.setAttribute("dir","rtl");
        lang = "ar";
    } else {
        document.getElementById("title").innerText = "Well done!";
        document.getElementById("desc").innerText = "You are about to start the listening section.";
        document.getElementById("readingText").innerText = "Reading";
        document.getElementById("listeningText").innerText = "Listening";
        document.getElementById("writingText").innerText = "Writing";
        document.getElementById("speakingText").innerText = "Speaking";
        document.getElementById("nextBtn").innerText = "Continue to the next section";
        document.getElementById("translateBtn").innerText = "Translate";
        document.body.setAttribute("dir","ltr");
        lang = "en";
    }
}
</script>

</body>
</html>