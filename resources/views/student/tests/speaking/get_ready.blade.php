<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Speaking - Get Ready</title>

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
  display:flex;
  justify-content:center;
  align-items:center;
  padding: 92px 18px 22px;
  position:relative;
}

/* Glow */
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

/* Top bar */
.topbar{
  position: fixed;
  top: 18px;
  left: 18px;
  right: 18px;
  display:flex;
  justify-content:flex-end;
  z-index:20;
}

.pill{
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color:#fff;
  padding: 10px 16px;
  border-radius: 14px;
  font-size: 14px;
  cursor:pointer;
  transition: .2s;
  backdrop-filter: blur(10px);
}
.pill:hover{
  transform: translateY(-1px);
  background: rgba(255,255,255,0.12);
}

/* Card */
.card{
  width: min(720px, 100%);
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  padding: 26px;
  box-shadow: var(--shadow);
  animation: fadeIn .9s ease-in-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

.header{text-align:center;}
h1{margin:0 0 8px;font-size: clamp(24px, 2.6vw, 34px);}
.sub{margin:0;color:var(--muted);font-size:14.5px;}

.mid{
  margin-top:20px;
  border-radius:22px;
  border:1px solid rgba(255,255,255,0.12);
  background:rgba(0,0,0,0.10);
  padding:18px;
  text-align:center;
}
.mid img{width:64px;height:64px;margin-bottom:8px;}
.mid-title{font-weight:700;}
.mid-time{font-weight:800;color:#c7f5ff;}

.list{
  margin-top:18px;
  padding:18px;
  border-radius:22px;
  border:1px solid rgba(255,255,255,0.12);
  background:rgba(0,0,0,0.10);
}
.list ul{
  margin:0;
  padding-left:18px;
  color:var(--muted);
  line-height:1.9;
  font-size:14.5px;
}

.start{
  margin-top:18px;
  width:100%;
  border:none;
  border-radius:999px;
  padding:14px;
  font-weight:800;
  font-size:15px;
  color:#fff;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  text-decoration:none;
  display:flex;
  justify-content:center;
}
</style>
</head>

<body>

<div class="light"></div>

<div class="topbar">
  <button class="pill" onclick="toggleLang()" id="translateBtn">Translate</button>
</div>

<div class="card">

  <div class="header">
    <h1 id="title">Speaking</h1>
    <p class="sub" id="subtitle">You are about to start the speaking section.</p>
  </div>

  <div class="mid">
    <img src="{{ asset('images/speaking.png') }}" alt="Speaking Icon">
    <p class="mid-title" id="midName">Speaking</p>
    <p class="mid-time" id="midTime">15 mins</p>
  </div>

  <div class="list">
    <ul id="rules">
      <li>On the next screen, you will be asked to authorize your microphone. We need access to your microphone to record your answers.</li>
      <li>Make sure you are in a quiet place so your recordings are clear. Use the practice question to check your recording levels.</li>
      <li>Once you submit a recording, you cannot go back.</li>
    </ul>
  </div>

  <!-- ✅ الانتقال إلى allowSpeaking.blade.php -->
  <a href="{{ route('allowSpeaking') }}" class="start" id="startBtn">Start</a>

</div>

<script>
let lang="en";

function toggleLang(){
 if(lang==="en"){
  document.getElementById("title").innerText="المحادثة";
  document.getElementById("subtitle").innerText="أنت على وشك بدء قسم المحادثة.";
  document.getElementById("midName").innerText="المحادثة";
  document.getElementById("midTime").innerText="١٥ دقيقة";
  document.getElementById("rules").innerHTML=`
    <li>في الشاشة التالية سيُطلب منك السماح بالوصول إلى الميكروفون. نحتاج الميكروفون لتسجيل إجاباتك.</li>
    <li>تأكد أنك في مكان هادئ حتى تكون التسجيلات واضحة. استخدم سؤال التدريب للتأكد من مستوى الصوت.</li>
    <li>بعد إرسال التسجيل، لا يمكنك الرجوع.</li>
  `;
  document.getElementById("startBtn").innerText="ابدأ";
  document.getElementById("translateBtn").innerText="English";
  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily='"Tajawal","Poppins", Arial, sans-serif';
  lang="ar";
 }else{
  document.getElementById("title").innerText="Speaking";
  document.getElementById("subtitle").innerText="You are about to start the speaking section.";
  document.getElementById("midName").innerText="Speaking";
  document.getElementById("midTime").innerText="15 mins";
  document.getElementById("rules").innerHTML=`
    <li>On the next screen, you will be asked to authorize your microphone. We need access to your microphone to record your answers.</li>
    <li>Make sure you are in a quiet place so your recordings are clear. Use the practice question to check your recording levels.</li>
    <li>Once you submit a recording, you cannot go back.</li>
  `;
  document.getElementById("startBtn").innerText="Start";
  document.getElementById("translateBtn").innerText="Translate";
  document.body.setAttribute("dir","ltr");
  document.body.style.fontFamily='"Poppins","Tajawal", Arial, sans-serif';
  lang="en";
 }
}
</script>

</body>
</html>