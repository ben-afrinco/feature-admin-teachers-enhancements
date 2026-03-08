<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Allow Microphone - Speaking</title>

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

  --ok: rgba(0, 255, 170, .18);
  --okBorder: rgba(0, 255, 170, .40);
  --bad: rgba(255, 64, 64, .16);
  --badBorder: rgba(255, 64, 64, .40);
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
  width: 640px;
  height: 640px;
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

.header{
  text-align:center;
  margin-bottom: 14px;
}
h1{
  margin:0 0 8px;
  font-size: clamp(22px, 2.4vw, 30px);
  font-weight: 900;
  letter-spacing: .2px;
}
.sub{
  margin:0;
  color:var(--muted);
  font-size:14.5px;
  font-weight: 600;
}

.panel{
  margin-top:16px;
  border-radius: 22px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
  padding: 18px;
}

.icon{
  width: 62px;
  height: 62px;
  border-radius: 18px;
  margin: 0 auto 12px;
  display:flex;
  align-items:center;
  justify-content:center;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.06);
}
.icon svg{ width: 30px; height: 30px; opacity: .95; }

.actions{
  display:flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 12px;
}

.btn{
  width:100%;
  border:none;
  border-radius:999px;
  padding: 14px 16px;
  font-weight:900;
  font-size:15px;
  color:#fff;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  cursor:pointer;
  transition: .15s;
}
.btn:hover{ transform: translateY(-1px); }

.link{
  display:block;
  text-align:center;
  margin-top: 6px;
  color: rgba(255,255,255,0.70);
  font-weight: 700;
  font-size: 14px;
  text-decoration: none;
  cursor:pointer;
}
.link:hover{ color: #fff; }

.note{
  margin-top: 12px;
  text-align:center;
  font-size: 13px;
  color: rgba(255,255,255,0.62);
  font-weight: 650;
  line-height: 1.7;
}

.alert{
  margin-top: 12px;
  border-radius: 18px;
  padding: 12px 12px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(255,255,255,0.06);
  font-weight: 700;
  font-size: 13.5px;
  line-height: 1.65;
  display:none;
}
.alert.ok{
  display:block;
  background: var(--ok);
  border-color: var(--okBorder);
}
.alert.bad{
  display:block;
  background: var(--bad);
  border-color: var(--badBorder);
}

/* Continue as link styled like button */
.btnlink{
  text-decoration:none;
  display:flex;
  justify-content:center;
  align-items:center;
}
.btnlink.disabled{
  opacity:.55;
  pointer-events:none;
  transform:none;
}

/* ✅ Custom Modal */
.modalOverlay{
  display:none;
  position:fixed;
  inset:0;
  background: rgba(0,0,0,.55);
  backdrop-filter: blur(4px);
  justify-content:center;
  align-items:center;
  z-index:999;
  padding: 18px;
}
.modal{
  width:min(430px, 100%);
  background: rgba(20,30,45,.95);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 22px;
  padding: 22px;
  box-shadow: 0 25px 60px rgba(0,0,0,.45);
  text-align:center;
  animation: pop .16s ease-out;
}
@keyframes pop{
  from{ transform: translateY(8px); opacity:.7; }
  to{ transform: translateY(0); opacity:1; }
}
.modal h3{
  margin:0 0 10px;
  font-size: 18px;
  font-weight: 900;
}
.modal p{
  margin:0 0 18px;
  font-size: 14px;
  color: rgba(255,255,255,.75);
  line-height: 1.65;
  font-weight: 650;
  white-space: pre-line;
}
.modalActions{
  display:flex;
  gap: 10px;
}
.modalBtn{
  flex:1;
  padding: 12px;
  border-radius: 999px;
  font-weight: 800;
  cursor:pointer;
}
.modalBtn.cancel{
  border: 1px solid rgba(255,255,255,.2);
  background: rgba(255,255,255,.08);
  color:#fff;
}
.modalBtn.danger{
  border:none;
  background: linear-gradient(135deg,#ff5f6d,#ff2d55);
  color:#fff;
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
    <h1 id="title">Please allow access to your microphone</h1>
    <p class="sub" id="subtitle">For the speaking test, we need access to your microphone.</p>
  </div>

  <div class="panel">
    <div class="icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" fill="none">
        <path d="M12 14c1.66 0 3-1.34 3-3V6a3 3 0 0 0-6 0v5c0 1.66 1.34 3 3 3Z" stroke="white" stroke-width="1.7"/>
        <path d="M19 11a7 7 0 0 1-14 0" stroke="white" stroke-width="1.7" stroke-linecap="round"/>
        <path d="M12 18v3" stroke="white" stroke-width="1.7" stroke-linecap="round"/>
        <path d="M8 21h8" stroke="white" stroke-width="1.7" stroke-linecap="round"/>
      </svg>
    </div>

    <div class="actions">
      <button class="btn" id="allowBtn" onclick="requestMic()">Allow microphone</button>

      <a class="btn btnlink disabled" id="continueBtn" href="{{ route('speaking.q1') }}" aria-disabled="true">
        Continue
      </a>

      <!-- ✅ Skip opens custom modal -->
      <span class="link" id="skipLink" onclick="openSkipModal()">Skip the speaking test</span>
    </div>

    <div class="alert" id="alertBox"></div>

    <div class="note" id="note">To continue you need to allow microphone access.</div>
  </div>

</div>

<!-- ✅ Custom Alert Modal -->
<div class="modalOverlay" id="skipModal" role="dialog" aria-modal="true">
  <div class="modal">
    <h3 id="modalTitle">Confirm Skip</h3>
    <p id="modalMsg">Are you sure you want to skip the speaking test?</p>

    <div class="modalActions">
      <button class="modalBtn cancel" onclick="closeSkipModal()" id="modalCancel">Cancel</button>
      <button class="modalBtn danger" onclick="confirmSkipRedirect()" id="modalYes">Yes, Skip</button>
    </div>
  </div>
</div>

<script>
let lang = "en";
let micAllowed = false;

function setAlert(type, text){
  const box = document.getElementById("alertBox");
  box.className = "alert " + type;
  box.textContent = text;
}

function setContinueEnabled(enabled){
  const btn = document.getElementById("continueBtn");
  if(enabled){
    btn.classList.remove("disabled");
    btn.setAttribute("aria-disabled","false");
  }else{
    btn.classList.add("disabled");
    btn.setAttribute("aria-disabled","true");
  }
}
setContinueEnabled(false);

async function requestMic(){
  if(!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia){
    setAlert("bad", (lang==="en")
      ? "Your browser does not support microphone access. Please try a different browser (Chrome/Edge) or use another device."
      : "متصفحك لا يدعم الوصول للميكروفون. جرّبي متصفح آخر (Chrome/Edge) أو جهاز آخر."
    );
    return;
  }

  try{
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    stream.getTracks().forEach(t => t.stop());

    micAllowed = true;
    setContinueEnabled(true);

    setAlert("ok", (lang==="en")
      ? "Microphone access granted. You can continue."
      : "تم السماح بالوصول للميكروفون. يمكنك المتابعة."
    );

    document.getElementById("note").textContent = (lang==="en")
      ? "Great! Click Continue to start the speaking test."
      : "ممتاز! اضغطي متابعة لبدء اختبار المحادثة.";
  }catch(err){
    micAllowed = false;
    setContinueEnabled(false);

    setAlert("bad", (lang==="en")
      ? "Microphone access was blocked. Please allow it from your browser settings and try again."
      : "تم حظر الميكروفون. اسمحي به من إعدادات المتصفح ثم أعيدي المحاولة."
    );

    document.getElementById("note").textContent = (lang==="en")
      ? "To continue you need to allow microphone access."
      : "للمتابعة يجب السماح بالوصول للميكروفون.";
  }
}

/* ✅ Open/Close Modal */
function openSkipModal(){
  const modal = document.getElementById("skipModal");
  const msg = document.getElementById("modalMsg");

  msg.textContent = (lang === "en")
    ? "Are you sure you want to skip the speaking test?\nYou will be taken to the results page."
    : "هل أنتِ متأكدة أنك تريدين تخطي اختبار المحادثة؟\nسيتم نقلك إلى صفحة النتائج.";

  modal.style.display = "flex";
}
function closeSkipModal(){
  document.getElementById("skipModal").style.display = "none";
}

/* ✅ Redirect to speaking.skip */
function confirmSkipRedirect(){
  window.location.href = "{{ route('speaking.skip') }}";
}

/* Close modal if click outside */
document.getElementById("skipModal").addEventListener("click", function(e){
  if(e.target.id === "skipModal") closeSkipModal();
});

function toggleLang(){
  if(lang === "en"){
    document.getElementById("title").innerText = "يرجى السماح بالوصول إلى الميكروفون";
    document.getElementById("subtitle").innerText = "لاختبار المحادثة، نحتاج إلى الوصول إلى الميكروفون.";
    document.getElementById("allowBtn").innerText = "السماح بالميكروفون";
    document.getElementById("continueBtn").innerText = "متابعة";
    document.getElementById("skipLink").innerText = "تخطي اختبار المحادثة";
    document.getElementById("note").innerText = micAllowed
      ? "ممتاز! اضغطي متابعة لبدء اختبار المحادثة."
      : "للمتابعة يجب السماح بالوصول للميكروفون.";
    document.getElementById("modalTitle").innerText = "تأكيد التخطي";
    document.getElementById("modalCancel").innerText = "إلغاء";
    document.getElementById("modalYes").innerText = "نعم، تخطي";
    document.getElementById("translateBtn").innerText = "English";
    document.body.setAttribute("dir","rtl");
    document.body.style.fontFamily='"Tajawal","Poppins", Arial, sans-serif';
    lang = "ar";
  } else {
    document.getElementById("title").innerText = "Please allow access to your microphone";
    document.getElementById("subtitle").innerText = "For the speaking test, we need access to your microphone.";
    document.getElementById("allowBtn").innerText = "Allow microphone";
    document.getElementById("continueBtn").innerText = "Continue";
    document.getElementById("skipLink").innerText = "Skip the speaking test";
    document.getElementById("note").innerText = micAllowed
      ? "Great! Click Continue to start the speaking test."
      : "To continue you need to allow microphone access.";
    document.getElementById("modalTitle").innerText = "Confirm Skip";
    document.getElementById("modalCancel").innerText = "Cancel";
    document.getElementById("modalYes").innerText = "Yes, Skip";
    document.getElementById("translateBtn").innerText = "Translate";
    document.body.setAttribute("dir","ltr");
    document.body.style.fontFamily='"Poppins","Tajawal", Arial, sans-serif';
    lang = "en";
  }
}
</script>

</body>
</html>