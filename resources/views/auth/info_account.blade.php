<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Select Your Role - LingoPulse</title>

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
  --soft: rgba(0,0,0,0.10);
}

*{ box-sizing:border-box; margin:0; padding:0; }

body{
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
  padding: 92px 18px 22px; /* مساحة للأزرار فوق */
  overflow-x:hidden;
  position:relative;
}

/* ✅ Glow (خفيف وناعم) */
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

/* ✅ Top actions (Back + Translate) */
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

/* ✅ Card (Glass) */
.card{
  width: min(430px, 100%);
  background: var(--card);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  backdrop-filter: blur(16px);
  padding: 28px 22px;
  box-shadow: var(--shadow);
  text-align:center;
  animation: fadeIn .9s ease-in-out;
  position:relative;
  overflow:hidden;
}
.card::before{
  content:"";
  position:absolute;
  inset:-2px;
  background: radial-gradient(520px 220px at 20% 0%, rgba(255,255,255,0.10), transparent 70%);
  pointer-events:none;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}

h1{
  margin: 4px 0 10px;
  font-size: 24px;
  font-weight: 800;
  letter-spacing:.2px;
}
.desc{
  margin: 0 auto 18px;
  color: var(--muted2);
  font-size: 14.5px;
  line-height: 1.7;
  max-width: 330px;
}

/* ✅ Role options */
.role-options{
  display:flex;
  flex-direction:column;
  gap: 12px;
  margin: 16px 0 18px;
}

.role-btn{
  width:100%;
  padding: 14px 14px;
  border-radius: 18px;
  font-size: 14.5px;
  font-weight: 800;
  cursor:pointer;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(0,0,0,0.10);
  color:#fff;
  transition: transform .15s ease, background .15s ease, border-color .15s ease;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
}
.role-btn:hover{
  transform: translateY(-1px);
  background: rgba(255,255,255,0.07);
  border-color: rgba(0,198,255,0.32);
}
.role-btn.selected{
  background: rgba(0,198,255,0.14);
  border-color: rgba(0,198,255,0.55);
}
.badge{
  font-size: 12px;
  font-weight: 900;
  color: rgba(255,255,255,0.85);
  padding: 6px 10px;
  border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.14);
  background: rgba(255,255,255,0.06);
}

/* ✅ Next button */
.next-btn{
  width:100%;
  padding: 14px 0;
  border-radius: 999px;
  font-size: 15px;
  font-weight: 900;
  cursor:pointer;
  border:none;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  color:#fff;
  box-shadow: 0 4px 18px rgba(0,114,255,0.25);
  transition: transform .18s ease, box-shadow .18s ease;
}
.next-btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 26px rgba(0,200,255,0.28);
}

/* ✅ Alert Overlay */
#alertOverlay{
  display:none;
  position: fixed;
  inset:0;
  background: rgba(0,0,0,0.78);
  z-index: 9999;
  justify-content: center;
  align-items: center;
  padding: 18px;
}
.alert-card{
  width: min(420px, 100%);
  background: rgba(255,255,255,0.09);
  border: 1px solid rgba(255,255,255,0.16);
  border-radius: 22px;
  backdrop-filter: blur(16px);
  padding: 18px;
  text-align:center;
  box-shadow: 0 18px 55px rgba(0,180,255,0.18);
}
.alert-card p{
  margin: 0 0 14px;
  color: rgba(255,255,255,0.85);
  font-weight: 700;
  line-height: 1.7;
}
.alert-card button{
  border:none;
  padding: 10px 22px;
  border-radius: 999px;
  cursor:pointer;
  font-weight: 900;
  color:#fff;
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
}
.alert-card button:hover{
  box-shadow: 0 10px 24px rgba(0,200,255,0.25);
}

/* ✅ Login Modal */
#loginModal{
  display:none;
  position: fixed;
  inset:0;
  background: rgba(0,0,0,0.85);
  z-index: 10000;
  justify-content: center;
  align-items: center;
  padding: 18px;
}
.login-card{
  width: min(420px, 100%);
  background: rgba(15,23,42,0.95);
  border: 1px solid rgba(255,255,255,0.16);
  border-radius: 22px;
  backdrop-filter: blur(20px);
  padding: 30px 22px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}
.login-card h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #fff;
  font-size: 20px;
}
.form-control {
  width: 100%;
  padding: 12px 16px;
  margin-bottom: 16px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.2);
  background: rgba(0,0,0,0.2);
  color: #fff;
  font-family: inherit;
  font-size: 15px;
}
.form-control:focus {
  outline: 2px solid var(--brand1);
  background: rgba(0,0,0,0.4);
}
.login-btn, .close-login-btn {
  width: 100%;
  padding: 12px;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  border: none;
  transition: .2s;
}
.login-btn {
  background: linear-gradient(135deg, var(--brand1), var(--brand2));
  color: #fff;
  margin-bottom: 10px;
}
.login-btn:hover {
  box-shadow: 0 8px 20px rgba(0,180,255,0.3);
}
.close-login-btn {
  background: rgba(255,255,255,0.1);
  color: #fff;
}
.close-login-btn:hover {
  background: rgba(255,255,255,0.2);
}

/* ✅ RTL */
body[dir="rtl"] .top-actions{ direction: rtl; }
body[dir="rtl"] .desc{ direction: rtl; }
body[dir="rtl"] .role-btn{ flex-direction: row-reverse; }

@media (max-width: 420px){
  .card{ padding: 22px 18px; }
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
  <h1 id="title">Select Your Role</h1>
  <p class="desc" id="desc">Choose the role you will enter the system as:</p>

  <div class="role-options">
    <button class="role-btn" data-role="student" id="studentBtn">
      <span id="studentText">Student</span>
      <span class="badge" id="studentBadge">Exam</span>
    </button>

    <button class="role-btn" data-role="teacher" id="teacherBtn">
      <span id="teacherText">Teacher</span>
      <span class="badge" id="teacherBadge">Manage</span>
    </button>

    <button class="role-btn" data-role="admin" id="adminBtn">
      <span id="adminText">Admin</span>
      <span class="badge" id="adminBadge">Control</span>
    </button>
  </div>

  <button class="next-btn" onclick="proceedNext()" id="nextBtn">Next</button>
</div>

</div>

<!-- Alert Overlay (required by JS) -->
<div id="alertOverlay">
  <div class="alert-card">
    <p id="alertText">Please select a role first!</p>
    <button onclick="closeAlert()" id="okBtn">OK</button>
  </div>
</div>

<!-- Login Modal -->
<div id="loginModal">
  <div class="login-card">
    <h2 id="loginModalTitle">تسجيل الدخول</h2>
    @if(session('login_error'))
      <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 10px; border-radius: 10px; text-align: center; margin-bottom: 15px;">
        {{ session('login_error') }}
      </div>
    @endif
    <form action="{{ route('auth.login') }}" method="POST">
      @csrf
      <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني / Email" required>
      <input type="password" name="password" class="form-control" placeholder="كلمة المرور / Password" required>
      <button type="submit" class="login-btn" id="loginSubmitBtn">دخول / Login</button>
      <button type="button" class="close-login-btn" onclick="closeLoginModal()" id="loginCancelBtn">إلغاء / Cancel</button>
    </form>
  </div>
</div>

<script>
let selectedRole = null;
let lang = 'en';

document.querySelectorAll('.role-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    selectedRole = btn.getAttribute('data-role');
  });
});

function proceedNext(){
  if(!selectedRole){
    document.getElementById('alertText').innerText =
      lang === 'en' ? "Please select a role first!" : "الرجاء اختيار دور أولاً!";
    document.getElementById('alertOverlay').style.display = 'flex';
    return;
  }

  // ✅ توجيه حسب الدور المختار
  if(selectedRole === 'admin' || selectedRole === 'teacher'){
    document.getElementById('loginModalTitle').innerText = lang === 'en' ? 'Login' : 'تسجيل الدخول';
    document.getElementById('loginModal').style.display = 'flex';
  } else {
    window.location.href = "{{ route('info.students') }}"; // student registration form
  }
}

function closeLoginModal() {
  document.getElementById('loginModal').style.display = 'none';
}

function closeAlert(){
  document.getElementById('alertOverlay').style.display = 'none';
}

function toggleLang(){
  if(lang === 'en'){
    document.getElementById('title').innerText = "اختر دورك";
    document.getElementById('desc').innerText = "اختر الدور الذي ستدخل به النظام:";

    document.getElementById('studentText').innerText = "طالب";
    document.getElementById('teacherText').innerText = "معلم";
    document.getElementById('adminText').innerText = "مشرف";

    document.getElementById('studentBadge').innerText = "اختبار";
    document.getElementById('teacherBadge').innerText = "إدارة";
    document.getElementById('adminBadge').innerText = "تحكم";

    document.getElementById('nextBtn').innerText = "التالي";
    document.getElementById('translateBtn').innerText = "English";
    document.getElementById('backArrow').innerText = "→";
    document.getElementById('backText').innerText = "رجوع";
    document.getElementById('okBtn').innerText = "حسنًا";

    document.documentElement.lang = "ar";
    document.body.setAttribute("dir","rtl");
    document.body.style.fontFamily = '"Tajawal","Poppins", Arial, sans-serif';
    lang = 'ar';
  } else {
    document.getElementById('title').innerText = "Select Your Role";
    document.getElementById('desc').innerText = "Choose the role you will enter the system as:";

    document.getElementById('studentText').innerText = "Student";
    document.getElementById('teacherText').innerText = "Teacher";
    document.getElementById('adminText').innerText = "Admin";

    document.getElementById('studentBadge').innerText = "Exam";
    document.getElementById('teacherBadge').innerText = "Manage";
    document.getElementById('adminBadge').innerText = "Control";

    document.getElementById('nextBtn').innerText = "Next";
    document.getElementById('translateBtn').innerText = "Translate";
    document.getElementById('backArrow').innerText = "←";
    document.getElementById('backText').innerText = "Back";
    document.getElementById('okBtn').innerText = "OK";

    document.documentElement.lang = "en";
    document.body.setAttribute("dir","ltr");
    document.body.style.fontFamily = '"Poppins","Tajawal", Arial, sans-serif';
    lang = 'en';
  }
}

// Auto-show login modal if there's an error
@if(session('login_error'))
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginModal').style.display = 'flex';
  });
@endif

</script>

</body>
</html>