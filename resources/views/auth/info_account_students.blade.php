<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Configure your account</title>

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
  --muted2: rgba(255,255,255,0.6);
  --brand1:#00c6ff;
  --brand2:#0086ff;
  --shadow: 0 18px 55px rgba(0,180,255,0.22);
  --radius: 26px;
  --inputBg: rgba(0,0,0,0.18);
  --inputStroke: rgba(255,255,255,0.18);
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
  padding: 84px 18px 22px;
  overflow-x:hidden;
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

/* Top actions */
.top-actions{
  position: fixed;
  top: 18px;
  left: 18px;
  right: 18px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:12px;
  z-index: 20;
}
.btn{
  border: 1px solid rgba(255,255,255,0.16);
  background: rgba(255,255,255,0.08);
  color:#fff;
  padding: 10px 14px;
  border-radius: 14px;
  font-size: 14px;
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
.btn:focus{
  outline: 2px solid rgba(0,198,255,0.55);
  outline-offset: 2px;
}
.btn-primary{
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
}
.btn-primary:hover{
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

/* Card */
.card{
  width: min(640px, 100%);
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
  padding: 8px 6px 2px;
}
h1{
  margin: 2px 0 8px;
  font-size: clamp(22px, 2.4vw, 30px);
  letter-spacing: .2px;
}
.section-title{
  margin: 18px 0 6px;
  font-weight: 700;
  font-size: 16px;
  text-align:center;
}
.section-sub{
  margin: 0 0 12px;
  color: var(--muted2);
  font-size: 13.5px;
  text-align:center;
  line-height: 1.6;
}

.form{
  margin-top: 10px;
  display:flex;
  flex-direction:column;
  gap: 12px;
}
.field{
  display:flex;
  flex-direction:column;
  gap: 8px;
}
.label{
  font-size: 13px;
  color: var(--muted);
  font-weight: 600;
}

/* Inputs */
.input, .select{
  width:100%;
  border-radius: 14px;
  border: 1px solid var(--inputStroke);
  background: var(--inputBg);
  color: var(--text);
  padding: 14px 14px;
  font-size: 14.5px;
  outline:none;
  transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
}
.input::placeholder{ color: rgba(255,255,255,0.55); }
.input:focus, .select:focus{
  border-color: rgba(0,198,255,0.55);
  box-shadow: 0 0 0 4px rgba(0,198,255,0.14);
  background: rgba(0,0,0,0.22);
}

/* Phone row: country select + phone */
.phone-row{
  display:grid;
  grid-template-columns: 92px 1fr;
  gap: 10px;
}
.select{
  appearance:none;
  background-image:
    linear-gradient(45deg, transparent 50%, rgba(255,255,255,0.8) 50%),
    linear-gradient(135deg, rgba(255,255,255,0.8) 50%, transparent 50%);
  background-position:
    calc(100% - 20px) calc(50% - 3px),
    calc(100% - 14px) calc(50% - 3px);
  background-size: 6px 6px, 6px 6px;
  background-repeat:no-repeat;
  padding-right: 42px;
}

/* Checkbox */
.check{
  display:flex;
  gap:10px;
  align-items:flex-start;
  margin-top: 4px;
  padding: 10px 12px;
  border: 1px solid rgba(255,255,255,0.12);
  background: rgba(0,0,0,0.10);
  border-radius: 16px;
}
.check input{
  margin-top: 3px;
  width: 18px;
  height: 18px;
  accent-color: #00c6ff;
}
.check p{
  margin:0;
  color: var(--muted);
  font-size: 13.5px;
  line-height: 1.7;
}
.check a{
  color: #8fe6ff;
  text-decoration: underline;
}

/* Submit */
.submit{
  margin-top: 10px;
  width:100%;
  border-radius: 999px;
  padding: 14px 16px;
  font-weight: 800;
  font-size: 15.5px;
  display:inline-flex;
  justify-content:center;
  align-items:center;
}
.submit:disabled{
  opacity: .7;
  cursor: not-allowed;
}

/* Divider spacing between blocks */
.hr{
  height:1px;
  background: rgba(255,255,255,0.12);
  margin: 10px 0 2px;
}

/* RTL */
body[dir="rtl"] .top-actions{ direction: rtl; }
body[dir="rtl"] .label{ text-align:right; }
body[dir="rtl"] .section-title,
body[dir="rtl"] .section-sub{ text-align:center; }
body[dir="rtl"] .select{
  background-position:
    20px calc(50% - 3px),
    26px calc(50% - 3px);
  padding-right: 14px;
  padding-left: 42px;
}

@media (max-width: 420px){
  .card{ padding: 20px; }
  .phone-row{ grid-template-columns: 1fr; }
}
</style>
</head>

<body>
<div class="light"></div>

<div class="top-actions">
  <a href="{{ url()->previous() }}" class="btn" id="backBtn">
    <span id="backArrow">←</span> <span id="backText">Back</span>
  </a>

  <button class="btn btn-primary" onclick="toggleLang()" id="translateBtn">Translate</button>
</div>

<div class="card">
  <div class="header">
    <h1 id="title">Configure your account</h1>
  </div>

  <form class="form" method="POST" action="{{ route('account.store') }}" id="accountForm">
    @csrf

    <div class="section-title" id="sec1Title">Your full name</div>
    <div class="section-sub" id="sec1Sub">This name will appear on your EF SET certificate.</div>

    <div class="field">
      <label class="label" for="first_name" id="firstLabel">* First name(s)</label>
      <input class="input" id="first_name" name="first_name" placeholder="First name(s)" required>
    </div>

    <div class="field">
      <label class="label" for="last_name" id="lastLabel">* Last name(s)</label>
      <input class="input" id="last_name" name="last_name" placeholder="Last name(s)" required>
    </div>

    <div class="hr"></div>

    <div class="section-title" id="sec2Title">Where should we send your results?</div>
    <div class="section-sub" id="sec2Sub">Check carefully - this cannot be changed later</div>

    <div class="field">
      <label class="label" for="email" id="emailLabel">* Email address</label>
      <input class="input" id="email" name="email" type="email" placeholder="Email address" required>
    </div>

    <div class="field">
      <label class="label" for="email_confirm" id="email2Label">* Confirm email address</label>
      <input class="input" id="email_confirm" name="email_confirm" type="email" placeholder="Confirm email address" required>
    </div>

    <div class="field">
      <label class="label" id="phoneLabel">Phone (optional)</label>
      <div class="phone-row">
        <select class="select" name="country_code" aria-label="Country code">
          <option value="+966">🇸🇦 +966</option>
          <option value="+971">🇦🇪 +971</option>
          <option value="+965">🇰🇼 +965</option>
          <option value="+20">🇪🇬 +20</option>
          <option value="+1">🇺🇸 +1</option>
        </select>
        <input class="input" name="phone" placeholder="Phone (optional)">
      </div>
    </div>

    <div class="check">
      <input type="checkbox" id="agree" required>
      <p id="agreeText">
        *Yes, I (or my legal guardian) have read and understood how EF processes my personal data as set out in the
        <a href="#" target="_blank" rel="noopener" id="privacyLink">Privacy Policy</a>.
      </p>
    </div>

    <!-- ✅ نفس الزر، فقط أضفنا span للنص وتعطيل بعد الضغط -->
    <button class="btn btn-primary submit" type="submit" id="saveBtn">
      <span id="saveBtnText">Continue</span>
    </button>
  </form>
</div>

<script>
let lang = 'en';

const form = document.getElementById('accountForm');
const saveBtn = document.getElementById('saveBtn');
const saveBtnText = document.getElementById('saveBtnText');

form.addEventListener('submit', function () {
  // ✅ تعطيل الزر بعد الضغط (بدون تغيير أي شيء في التصميم)
  saveBtn.disabled = true;
  saveBtn.style.opacity = "0.75";
  saveBtn.style.cursor = "not-allowed";
  saveBtnText.innerText = (lang === 'ar') ? "جاري المتابعة..." : "Please wait...";
});

function setArabic(){
  document.getElementById('title').innerText = "تهيئة حسابك";

  document.getElementById('sec1Title').innerText = "اسمك الكامل";
  document.getElementById('sec1Sub').innerText = "سيظهر هذا الاسم على شهادة الاختبار.";

  document.getElementById('firstLabel').innerText = "* الاسم الأول";
  document.getElementById('lastLabel').innerText = "* اسم العائلة";
  document.getElementById('first_name').placeholder = "الاسم الأول";
  document.getElementById('last_name').placeholder = "اسم العائلة";

  document.getElementById('sec2Title').innerText = "أين نرسل نتيجتك؟";
  document.getElementById('sec2Sub').innerText = "تأكد جيدًا — لا يمكن تغيير هذا لاحقًا";

  document.getElementById('emailLabel').innerText = "* البريد الإلكتروني";
  document.getElementById('email2Label').innerText = "* تأكيد البريد الإلكتروني";
  document.getElementById('email').placeholder = "البريد الإلكتروني";
  document.getElementById('email_confirm').placeholder = "تأكيد البريد الإلكتروني";

  document.getElementById('phoneLabel').innerText = "الهاتف (اختياري)";
  document.querySelector('input[name="phone"]').placeholder = "الهاتف (اختياري)";

  document.getElementById('agreeText').innerHTML =
    `*نعم، لقد قرأت (أو قرأ ولي أمري) وفهمت كيفية معالجة بياناتي الشخصية كما هو موضح في
    <a href="#" target="_blank" rel="noopener" id="privacyLink">سياسة الخصوصية</a>.`;

  document.getElementById('translateBtn').innerText = "English";

  // Back RTL
  document.getElementById('backArrow').innerText = "→";
  document.getElementById('backText').innerText = "رجوع";

  // زر الإرسال بالعربي (قبل الضغط)
  if(!saveBtn.disabled) document.getElementById('saveBtnText').innerText = "متابعة";

  document.documentElement.lang = "ar";
  document.body.setAttribute("dir","rtl");
  document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
  lang = 'ar';
}

function setEnglish(){
  document.getElementById('title').innerText = "Configure your account";

  document.getElementById('sec1Title').innerText = "Your full name";
  document.getElementById('sec1Sub').innerText = "This name will appear on your EF SET certificate.";

  document.getElementById('firstLabel').innerText = "* First name(s)";
  document.getElementById('lastLabel').innerText = "* Last name(s)";
  document.getElementById('first_name').placeholder = "First name(s)";
  document.getElementById('last_name').placeholder = "Last name(s)";

  document.getElementById('sec2Title').innerText = "Where should we send your results?";
  document.getElementById('sec2Sub').innerText = "Check carefully - this cannot be changed later";

  document.getElementById('emailLabel').innerText = "* Email address";
  document.getElementById('email2Label').innerText = "* Confirm email address";
  document.getElementById('email').placeholder = "Email address";
  document.getElementById('email_confirm').placeholder = "Confirm email address";

  document.getElementById('phoneLabel').innerText = "Phone (optional)";
  document.querySelector('input[name="phone"]').placeholder = "Phone (optional)";

  document.getElementById('agreeText').innerHTML =
    `*Yes, I (or my legal guardian) have read and understood how EF processes my personal data as set out in the
    <a href="#" target="_blank" rel="noopener" id="privacyLink">Privacy Policy</a>.`;

  document.getElementById('translateBtn').innerText = "Translate";

  document.getElementById('backArrow').innerText = "←";
  document.getElementById('backText').innerText = "Back";

  // زر الإرسال بالإنجليزي (قبل الضغط)
  if(!saveBtn.disabled) document.getElementById('saveBtnText').innerText = "Continue";

  document.documentElement.lang = "en";
  document.body.setAttribute("dir","ltr");
  document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
  lang = 'en';
}

function toggleLang(){
  if(lang === 'en') setArabic();
  else setEnglish();
}
</script>

</body>
</html>