<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>LingoPulse - لوحة تحكم المشرف</title>

  <!-- ✅ Fonts + Icons (ضروري عشان FontAwesome يشتغل) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root{
      /* LingoPulse Identity */
      --brand-1:#1e3a8a;     /* Deep Blue */
      --brand-2:#2563eb;     /* Blue */
      --brand-3:#7c3aed;     /* Violet */
      --brand-4:#22c55e;     /* Success */
      --danger:#ef4444;

      /* UI */
      --bg:#f7fafc;
      --bg2:#eef2ff;
      --card:#ffffff;
      --text:#0f172a;
      --muted:#64748b;
      --border:rgba(15,23,42,.08);

      --radius:18px;
      --radius2:14px;
      --shadow:0 18px 45px rgba(2,6,23,.10);
      --shadow2:0 10px 25px rgba(2,6,23,.10);
      --t: all .25s ease;
    }

    body.dark-theme{
      --bg:#0b1220;
      --bg2:#0f172a;
      --card:#0f1c33;
      --text:#f1f5f9;
      --muted:#9aa9c2;
      --border:rgba(255,255,255,.08);
      --shadow:0 20px 55px rgba(0,0,0,.35);
      --shadow2:0 12px 30px rgba(0,0,0,.30);
    }

    *{box-sizing:border-box;margin:0;padding:0}
    html,body{height:100%}
    body{
      font-family:"Tajawal",sans-serif;
      color:var(--text);
      direction:rtl;
      overflow-x:hidden;
      overflow-y:auto;
      background:
        radial-gradient(900px 500px at 20% 10%, rgba(37,99,235,.12), transparent 60%),
        radial-gradient(700px 450px at 80% 85%, rgba(124,58,237,.10), transparent 55%),
        linear-gradient(135deg,var(--bg) 0%, var(--bg2) 100%);
      transition:var(--t);
    }

    /* English mode */
    body.english{direction:ltr}
    body.english .sidebar{direction:ltr}
    body.english .main-content{direction:ltr}
    body.english .nav-item{border-right:none;border-left:4px solid transparent}
    body.english .nav-item.active{border-left-color:rgba(255,255,255,.9)}
    body.english .nav-icon{margin-left:0;margin-right:12px}
    body.english .data-table th,
    body.english .data-table td{text-align:left}
    body.english .search-box input{padding:12px 20px 12px 44px}

    /* ---------- Login ---------- */
    .login-page{
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:22px;
      background:
        radial-gradient(900px 500px at 30% 20%, rgba(255,255,255,.15), transparent 55%),
        linear-gradient(135deg, var(--brand-1), var(--brand-2) 55%, var(--brand-3));
    }

    .login-box{
      width:100%;
      max-width:520px;
      background:rgba(255,255,255,.92);
      border:1px solid rgba(255,255,255,.25);
      border-radius:22px;
      padding:34px 28px;
      box-shadow:0 28px 65px rgba(0,0,0,.22);
      backdrop-filter: blur(10px);
      position:relative;
      overflow:hidden;
      text-align:center;
    }
    body.dark-theme .login-box{
      background:rgba(15,28,51,.92);
      border-color:rgba(255,255,255,.08);
    }

    .login-box:before{
      content:"";
      position:absolute; inset:auto 0 0 0;
      height:6px;
      background:linear-gradient(90deg,var(--brand-2), var(--brand-3), var(--brand-4));
    }

    .brand-row{
      display:flex;
      align-items:center;
      justify-content:center;
      gap:14px;
      margin-bottom:16px;
    }

    /* ✅ بدل مسار C:\ .. فقط ضعي logo.jpg بجانب الملف */
    .brand-logo{
      width:68px;height:68px;
      border-radius:18px;
      background:linear-gradient(135deg,var(--brand-2), var(--brand-3));
      display:flex;align-items:center;justify-content:center;
      color:#fff;font-size:28px;
      box-shadow:0 16px 30px rgba(0,0,0,.18);
      border:2px solid rgba(255,255,255,.6);
      overflow:hidden;
    }
    .brand-logo img{width:100%;height:100%;object-fit:cover;display:block}

    .brand-title{
      font-weight:900;
      font-size:2.1rem;
      letter-spacing:.2px;
      background:linear-gradient(135deg,#0b2a82, #2563eb, #7c3aed);
      -webkit-background-clip:text;
      background-clip:text;
      -webkit-text-fill-color:transparent;
    }

    .brand-sub{
      color:var(--muted);
      font-weight:700;
      margin-bottom:22px;
      font-size:.98rem;
    }

    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}

    .input-group{margin-bottom:14px;text-align:right}
    body.english .input-group{text-align:left}
    .input-group label{
      display:flex;align-items:center;gap:10px;
      margin-bottom:8px;
      font-weight:800;
      color:var(--text);
      opacity:.92;
    }
    .input-group input,.input-group select, .input-group textarea{
      width:100%;
      border:1.8px solid var(--border);
      background:rgba(255,255,255,.75);
      color:var(--text);
      padding:13px 14px;
      border-radius:14px;
      font-size:1rem;
      outline:none;
      transition:var(--t);
      font-family:"Tajawal",sans-serif;
    }
    body.dark-theme .input-group input,
    body.dark-theme .input-group select,
    body.dark-theme .input-group textarea{
      background:rgba(2,6,23,.20);
    }
    .input-group input:focus,.input-group select:focus,.input-group textarea:focus{
      border-color:rgba(37,99,235,.65);
      box-shadow:0 0 0 4px rgba(37,99,235,.14);
    }

    .login-btn{
      width:100%;
      border:none;
      border-radius:16px;
      padding:14px 16px;
      cursor:pointer;
      font-weight:900;
      font-size:1.05rem;
      color:white;
      background:linear-gradient(135deg,var(--brand-2), var(--brand-3));
      box-shadow:0 18px 35px rgba(37,99,235,.25);
      display:flex;align-items:center;justify-content:center;gap:10px;
      transition:var(--t);
      margin-top:4px;
    }
    .login-btn:hover{transform:translateY(-2px);box-shadow:0 22px 45px rgba(124,58,237,.25)}
    .login-btn.loading{opacity:.9;pointer-events:none}
    .spinner{
      width:18px;height:18px;border-radius:50%;
      border:2px solid rgba(255,255,255,.45);
      border-top-color:#fff;
      animation:spin .8s linear infinite;
    }
    @keyframes spin{to{transform:rotate(360deg)}}

    /* ---------- Dashboard Layout ---------- */
    .dashboard{display:none;min-height:100vh}

    .sidebar{
      width:290px;
      position:fixed;
      inset:0 auto 0 0;
      background:
        radial-gradient(700px 300px at 30% 0%, rgba(147,197,253,.18), transparent 60%),
        linear-gradient(180deg, #0b2a82, #0b1220 70%);
      color:#fff;
      display:flex;flex-direction:column;
      z-index:1000;
      box-shadow: 8px 0 30px rgba(0,0,0,.12);
      overflow:auto;
    }
    body:not(.english) .sidebar{right:auto;left:0}
    body.english .sidebar{left:0}

    .profile{
      padding:26px 18px 18px;
      border-bottom:1px solid rgba(255,255,255,.10);
      text-align:center;
    }
    .avatar{
      width:92px;height:92px;border-radius:22px;
      margin:0 auto 12px;
      background:rgba(255,255,255,.12);
      border:2px solid rgba(255,255,255,.22);
      box-shadow:0 18px 35px rgba(0,0,0,.25);
      display:flex;align-items:center;justify-content:center;
      cursor:pointer;
      overflow:hidden;
    }
    .avatar i{font-size:34px}
    .avatar img{width:100%;height:100%;object-fit:cover}

    .profile .name{font-weight:900;font-size:1.15rem;margin-bottom:4px}
    .profile .role{opacity:.8;font-weight:700;font-size:.92rem}

    .nav{
      padding:16px 10px;
      display:flex;flex-direction:column;gap:6px;
      flex:1;
    }
    .nav-item{
      display:flex;align-items:center;gap:12px;
      padding:12px 14px;
      border-radius:14px;
      color:rgba(255,255,255,.92);
      text-decoration:none;
      cursor:pointer;
      transition:var(--t);
      border-right:4px solid transparent;
    }
    .nav-item:hover{
      background:rgba(255,255,255,.10);
      transform:translateX(-2px);
    }
    body.english .nav-item:hover{transform:translateX(2px)}
    .nav-item.active{
      background:rgba(255,255,255,.14);
      border-right-color:rgba(255,255,255,.90);
      font-weight:900;
    }
    .nav-icon{width:22px;text-align:center;font-size:1.05rem;margin-left:2px}

    .sidebar-footer{
      padding:14px 14px 18px;
      border-top:1px solid rgba(255,255,255,.10);
    }
    .mini-pill{
      display:flex;align-items:center;justify-content:space-between;gap:12px;
      padding:12px 12px;border-radius:14px;
      background:rgba(255,255,255,.10);
      border:1px solid rgba(255,255,255,.12);
      font-weight:800;
    }

    /* main */
    .main-content{
      margin-left:290px;
      min-height:100vh;
      display:flex;flex-direction:column;
    }
    body:not(.english) .main-content{margin-left:290px}
    body.english .main-content{margin-left:290px}

    .topbar{
      position:sticky;top:0;z-index:900;
      background:rgba(255,255,255,.78);
      border-bottom:1px solid var(--border);
      backdrop-filter: blur(10px);
      padding:14px 18px;
      display:flex;align-items:center;justify-content:space-between;gap:14px;
    }
    body.dark-theme .topbar{background:rgba(15,28,51,.72)}
    .left-top{
      display:flex;align-items:center;gap:12px;min-width:220px;
    }
    .mobile-btn{
      display:none;
      width:44px;height:44px;border:none;border-radius:14px;
      background:rgba(37,99,235,.10);
      color:var(--brand-2);
      cursor:pointer;
      transition:var(--t);
    }
    .mobile-btn:hover{transform:translateY(-1px)}
    .brand-chip{
      display:flex;align-items:center;gap:10px;
    }
    .chip-logo{
      width:44px;height:44px;border-radius:14px;
      background:linear-gradient(135deg,var(--brand-2),var(--brand-3));
      display:flex;align-items:center;justify-content:center;color:#fff;
      overflow:hidden;
      box-shadow:0 14px 25px rgba(0,0,0,.12);
      border:1px solid rgba(0,0,0,.06);
    }
    .chip-logo img{width:100%;height:100%;object-fit:cover}
    .chip-title{font-weight:900;font-size:1.15rem}

    .search-box{flex:1;max-width:640px;position:relative}
    .search-box input{
      width:100%;
      padding:12px 44px 12px 18px;
      border-radius:999px;
      border:1.8px solid var(--border);
      background:rgba(255,255,255,.75);
      outline:none;
      transition:var(--t);
      color:var(--text);
      font-weight:700;
    }
    body.dark-theme .search-box input{background:rgba(2,6,23,.20)}
    .search-box input:focus{border-color:rgba(124,58,237,.55);box-shadow:0 0 0 4px rgba(124,58,237,.12)}
    .search-box i{
      position:absolute;left:16px;top:50%;transform:translateY(-50%);
      color:rgba(15,23,42,.55);
    }
    body.dark-theme .search-box i{color:rgba(241,245,249,.55)}
    body:not(.english) .search-box i{left:auto;right:16px}
    body:not(.english) .search-box input{padding:12px 18px 12px 44px}

    .right-top{
      display:flex;align-items:center;gap:12px;
      min-width:240px;justify-content:flex-end;
    }

    .select-pill{
      display:flex;align-items:center;gap:10px;
      padding:8px 12px;
      border-radius:14px;
      border:1.6px solid var(--border);
      background:rgba(255,255,255,.70);
    }
    body.dark-theme .select-pill{background:rgba(2,6,23,.18)}
    .select-pill select{
      border:none;background:transparent;outline:none;
      font-weight:900;color:var(--text);
      font-family:"Tajawal",sans-serif;
      cursor:pointer;
    }

    .icon-btn{
      position:relative;
      width:46px;height:46px;border-radius:14px;border:none;
      cursor:pointer;
      color:#fff;
      background:linear-gradient(135deg,var(--brand-2),var(--brand-3));
      box-shadow:0 16px 30px rgba(37,99,235,.18);
      transition:var(--t);
      display:flex;align-items:center;justify-content:center;
    }
    .icon-btn:hover{transform:translateY(-2px);box-shadow:0 20px 38px rgba(124,58,237,.20)}
    .badge{
      position:absolute;top:-6px;right:-6px;
      width:22px;height:22px;border-radius:999px;
      background:var(--danger);color:#fff;
      display:flex;align-items:center;justify-content:center;
      font-size:.75rem;font-weight:900;
      border:2px solid #fff;
    }

    .notif-panel{
      position:absolute;
      top:66px;
      width:360px;
      background:var(--card);
      border:1px solid var(--border);
      border-radius:18px;
      box-shadow:var(--shadow);
      overflow:hidden;
      display:none;
      z-index:9999;
    }
    .notif-head{
      padding:16px 16px;
      color:#fff;
      background:linear-gradient(135deg,var(--brand-2),var(--brand-3));
      font-weight:900;
      display:flex;align-items:center;justify-content:space-between;
    }
    .notif-list{max-height:420px;overflow:auto}
    .notif-item{
      padding:14px 16px;
      border-bottom:1px solid var(--border);
      cursor:pointer;
      transition:var(--t);
    }
    .notif-item:hover{background:rgba(37,99,235,.06)}
    .notif-item.unread{background:rgba(124,58,237,.06);border-right:4px solid rgba(124,58,237,.65)}
    body.english .notif-item.unread{border-right:none;border-left:4px solid rgba(124,58,237,.65)}
    .notif-title{font-weight:900;margin-bottom:6px}
    .notif-msg{color:var(--muted);font-weight:700;font-size:.95rem;margin-bottom:6px}
    .notif-time{color:rgba(37,99,235,.9);font-weight:900;font-size:.85rem}

    .content-area{
      padding:22px;
      flex:1;
    }

    .card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:var(--shadow2);
      padding:18px;
      margin-bottom:18px;
    }

    .section-header{
      display:flex;align-items:center;justify-content:space-between;gap:12px;
      padding-bottom:12px;margin-bottom:14px;
      border-bottom:1px solid var(--border);
    }
    .section-title{
      display:flex;align-items:center;gap:10px;
      font-size:1.15rem;
      font-weight:900;
      color:var(--text);
    }
    .section-title i{color:rgba(37,99,235,.95)}

    .btn{
      border:none;
      border-radius:14px;
      padding:10px 14px;
      cursor:pointer;
      font-weight:900;
      display:inline-flex;align-items:center;gap:10px;
      transition:var(--t);
      height:42px;
      user-select:none;
      font-family:"Tajawal",sans-serif;
    }
    .btn-primary{
      color:#fff;
      background:linear-gradient(135deg,var(--brand-2),var(--brand-3));
      box-shadow:0 16px 30px rgba(124,58,237,.18);
    }
    .btn-primary:hover{transform:translateY(-2px);box-shadow:0 20px 38px rgba(124,58,237,.22)}
    .btn-success{
      color:#fff;
      background:linear-gradient(135deg,#10b981,#0ea371);
      box-shadow:0 16px 30px rgba(16,185,129,.14);
    }
    .btn-success:hover{transform:translateY(-2px);box-shadow:0 20px 38px rgba(16,185,129,.18)}
    .btn-secondary{
      background:rgba(15,23,42,.04);
      border:1.6px solid var(--border);
      color:var(--text);
    }
    body.dark-theme .btn-secondary{background:rgba(255,255,255,.05)}
    .btn-danger{
      color:#fff;
      background:linear-gradient(135deg,#ef4444,#dc2626);
      box-shadow:0 16px 30px rgba(239,68,68,.14);
    }
    .btn-danger:hover{transform:translateY(-2px);box-shadow:0 20px 38px rgba(239,68,68,.18)}

    .stats{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
      gap:14px;
      margin-bottom:16px;
    }
    .stat{
      background:
        radial-gradient(500px 180px at 20% 0%, rgba(37,99,235,.10), transparent 60%),
        radial-gradient(500px 180px at 85% 90%, rgba(124,58,237,.10), transparent 60%),
        var(--card);
      border:1px solid var(--border);
      border-radius:18px;
      padding:16px;
      box-shadow:var(--shadow2);
      transition:var(--t);
    }
    .stat:hover{transform:translateY(-3px)}
    .stat-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
    .stat-ico{
      width:46px;height:46px;border-radius:14px;
      background:linear-gradient(135deg,var(--brand-2),var(--brand-3));
      color:#fff;display:flex;align-items:center;justify-content:center;
      box-shadow:0 14px 26px rgba(37,99,235,.18);
    }
    .stat-value{font-weight:900;font-size:1.7rem}
    .stat-label{color:var(--muted);font-weight:800}

    .data-table{
      width:100%;
      border-collapse:collapse;
      border-radius:16px;
      overflow:hidden;
      border:1px solid var(--border);
      background:var(--card);
    }
    .data-table th{
      text-align:right;
      padding:14px 12px;
      color:#fff;
      font-weight:900;
      background:linear-gradient(90deg,var(--brand-2),var(--brand-3));
      letter-spacing:.2px;
      font-size:.95rem;
    }
    .data-table td{
      text-align:right;
      padding:12px 12px;
      border-bottom:1px solid var(--border);
      font-weight:700;
      color:var(--text);
      font-size:.95rem;
    }
    .data-table tr:hover{background:rgba(37,99,235,.05)}
    .table-actions{display:flex;gap:8px;flex-wrap:wrap}

    .tag{
      display:inline-flex;align-items:center;gap:8px;
      padding:6px 12px;border-radius:999px;
      font-weight:900;font-size:.85rem;
      border:1px solid var(--border);
    }
    .tag.ok{background:rgba(16,185,129,.10);color:#10b981}
    .tag.bad{background:rgba(239,68,68,.10);color:#ef4444}

    .btn-icon{
      height:40px;
      padding:8px 12px;
      border-radius:12px;
      border:1px solid var(--border);
      background:rgba(15,23,42,.04);
      color:var(--text);
      font-weight:900;
      cursor:pointer;
      transition:var(--t);
      display:inline-flex;align-items:center;gap:8px;
    }
    body.dark-theme .btn-icon{background:rgba(255,255,255,.05)}
    .btn-icon:hover{transform:translateY(-2px)}
    .btn-icon.view{border-color:rgba(16,185,129,.22);color:#10b981;background:rgba(16,185,129,.08)}
    .btn-icon.edit{border-color:rgba(37,99,235,.22);color:var(--brand-2);background:rgba(37,99,235,.08)}
    .btn-icon.del{border-color:rgba(239,68,68,.22);color:#ef4444;background:rgba(239,68,68,.08)}

    /* ---------- Modal ---------- */
    .modal{
      display:none;
      position:fixed; inset:0;
      background:rgba(0,0,0,.55);
      z-index:12000;
      align-items:center;justify-content:center;
      padding:16px;
      backdrop-filter: blur(6px);
    }
    .modal.active{display:flex}
    .modal-content{
      width:100%;
      max-width:540px;
      background:var(--card);
      border:1px solid var(--border);
      border-radius:20px;
      box-shadow:var(--shadow);
      padding:18px;
      max-height:92vh;
      overflow:auto;
    }
    .modal-header{
      display:flex;align-items:center;justify-content:space-between;gap:12px;
      padding-bottom:12px;margin-bottom:12px;
      border-bottom:1px solid var(--border);
    }
    .modal-title{font-weight:900;font-size:1.1rem;display:flex;align-items:center;gap:10px}
    .close-modal{
      width:44px;height:44px;border-radius:14px;
      border:1px solid var(--border);
      background:rgba(15,23,42,.04);
      cursor:pointer;
      font-size:1.2rem;
      color:var(--text);
      transition:var(--t);
    }
    body.dark-theme .close-modal{background:rgba(255,255,255,.05)}
    .close-modal:hover{transform:translateY(-1px)}
    .form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:12px}

    /* ---------- Toast ---------- */
    .toast{
      position:fixed;top:20px;right:20px;
      z-index:13000;
      border-radius:16px;
      padding:14px 16px;
      color:#fff;
      box-shadow:0 18px 45px rgba(0,0,0,.22);
      display:flex;align-items:center;gap:12px;
      font-weight:900;
      animation:toastIn .25s ease;
      border:1px solid rgba(255,255,255,.18);
      backdrop-filter: blur(8px);
    }
    @keyframes toastIn{from{transform:translateX(30px);opacity:0}to{transform:translateX(0);opacity:1}}
    @keyframes toastOut{from{transform:translateX(0);opacity:1}to{transform:translateX(30px);opacity:0}}
    .toast.success{background:linear-gradient(135deg,#10b981,#0ea371)}
    .toast.error{background:linear-gradient(135deg,#ef4444,#dc2626)}
    .toast.info{background:linear-gradient(135deg,var(--brand-2),var(--brand-3))}

    /* ---------- Responsive ---------- */
    @media (max-width: 992px){
      .mobile-btn{display:inline-flex}
      .sidebar{
        transform:translateX(-310px);
        transition:var(--t);
      }
      body.english .sidebar{transform:translateX(-310px)}
      .sidebar.active{transform:translateX(0)}
      .main-content{margin-left:0}
      .topbar{flex-wrap:wrap}
      .left-top{min-width:auto}
      .right-top{min-width:auto}
    }

    @media (max-width: 768px){
      .content-area{padding:14px}
      .grid-2{grid-template-columns:1fr}
      .table-actions{flex-direction:column}
      .btn-icon{width:100%;justify-content:center}
      .notif-panel{width:92vw}
    }
  </style>
</head>

<body>
  <!-- ============ LOGIN ============ -->
  <div class="login-page" id="loginPage">
    <div class="login-box">
      <div class="brand-row">
        <!-- ✅ إذا عندك شعار: ضعي logo.jpg جنب الملف -->
        <div class="brand-logo" id="loginLogo">
          <img src="logo.jpg" alt="LingoPulse" onerror="this.remove(); document.getElementById('loginLogo').innerHTML='<i class=&quot;fa-solid fa-wave-square&quot;></i>';">
        </div>
        <div style="text-align: right;">
          <div class="brand-title">LingoPulse</div>
          <div class="brand-sub" id="brandSub">لوحة تحكم المشرف - إدارة المحتوى والمستخدمين</div>
        </div>
      </div>

      <div class="input-group">
        <label for="username"><i class="fa-solid fa-user"></i><span id="usernameLabel">اسم المستخدم</span></label>
        <input id="username" type="text" placeholder="أدخل اسم المستخدم" autocomplete="username" />
      </div>

      <div class="input-group">
        <label for="password"><i class="fa-solid fa-lock"></i><span id="passwordLabel">كلمة المرور</span></label>
        <input id="password" type="password" placeholder="أدخل كلمة المرور" autocomplete="current-password" />
      </div>

      <div class="grid-2" style="margin-top:10px;margin-bottom:12px;">
        <div class="input-group" style="margin:0;">
          <label for="languageSelect"><i class="fa-solid fa-globe"></i><span id="languageLabel">اللغة</span></label>
          <select id="languageSelect">
            <option value="ar">العربية</option>
            <option value="en">English</option>
          </select>
        </div>
        <div class="input-group" style="margin:0;">
          <label for="themeSelect"><i class="fa-solid fa-palette"></i><span id="themeLabel">المظهر</span></label>
          <select id="themeSelect">
            <option value="light">فاتح</option>
            <option value="dark">غامق</option>
          </select>
        </div>
      </div>

      <button class="login-btn" id="loginBtn">
        <span id="loginBtnIcon"><i class="fa-solid fa-right-to-bracket"></i></span>
        <span id="loginBtnText">تسجيل الدخول</span>
      </button>

      <div style="margin-top:14px;color:rgba(255,255,255,.0);"></div>
      <div style="margin-top:12px;color:rgba(15,23,42,.55);font-weight:800;font-size:.92rem;">
        <span id="hintText">بيانات تجريبية:</span>
        <span style="font-weight:900;">admin / admin123</span>
      </div>
    </div>
  </div>

  <!-- ============ DASHBOARD ============ -->
  <div class="dashboard" id="dashboard">
    <aside class="sidebar" id="sidebar">
      <div class="profile">
        <div class="avatar" id="adminAvatar" title="اضغط لتغيير الصورة">
          <i class="fa-solid fa-user-shield"></i>
        </div>
        <div class="name" id="adminName">المشرف العام</div>
        <div class="role" id="adminRole">مدير النظام</div>
      </div>

      <nav class="nav">
        <a class="nav-item active" data-section="home">
          <i class="nav-icon fa-solid fa-gauge-high"></i>
          <span id="navHome">لوحة التحكم</span>
        </a>
        <a class="nav-item" data-section="users">
          <i class="nav-icon fa-solid fa-users"></i>
          <span id="navUsers">إدارة المستخدمين</span>
        </a>
        <a class="nav-item" data-section="courses">
          <i class="nav-icon fa-solid fa-book"></i>
          <span id="navCourses">إدارة الدورات</span>
        </a>
        <a class="nav-item" data-section="content">
          <i class="nav-icon fa-solid fa-database"></i>
          <span id="navContent">إدارة المحتوى</span>
        </a>
        <a class="nav-item" data-section="settings">
          <i class="nav-icon fa-solid fa-gear"></i>
          <span id="navSettings">الإعدادات</span>
        </a>
        <a class="nav-item" id="logoutBtnSidebar">
          <i class="nav-icon fa-solid fa-right-from-bracket"></i>
          <span id="logoutText">تسجيل الخروج</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="mini-pill">
          <span id="sidebarFooterText">حالة النظام</span>
          <span style="display:flex;align-items:center;gap:8px;">
            <span style="width:10px;height:10px;border-radius:99px;background:#22c55e;display:inline-block;"></span>
            <span id="sidebarFooterStatus" style="font-weight:900;">Online</span>
          </span>
        </div>
      </div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <div class="left-top">
          <button class="mobile-btn" id="mobileMenuBtn" aria-label="menu">
            <i class="fa-solid fa-bars"></i>
          </button>
          <div class="brand-chip">
            <div class="chip-logo" id="topLogo">
              <img src="logo.jpg" alt="LingoPulse" onerror="this.remove(); document.getElementById('topLogo').innerHTML='<i class=&quot;fa-solid fa-wave-square&quot;></i>';">
            </div>
            <div class="chip-title">LingoPulse</div>
          </div>
        </div>

        <div class="search-box">
          <input id="searchInput" type="text" placeholder="ابحث عن طالب، معلم، دورة، سؤال..." />
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="right-top" style="position:relative;">
          <div class="select-pill">
            <i class="fa-solid fa-globe"></i>
            <select id="languageSwitchTop">
              <option value="ar">العربية</option>
              <option value="en">English</option>
            </select>
          </div>

          <button class="icon-btn" id="notificationBtn" aria-label="notifications">
            <i class="fa-solid fa-bell"></i>
            <span class="badge" id="notificationBadge">0</span>
          </button>

          <div class="notif-panel" id="notificationPanel">
            <div class="notif-head">
              <span id="notificationsTitle">الإشعارات</span>
              <button class="btn btn-secondary" style="height:36px;padding:8px 10px;border-radius:12px;" id="markAllReadBtn">
                <i class="fa-solid fa-check"></i><span id="markAllReadText">قراءة الكل</span>
              </button>
            </div>
            <div class="notif-list" id="notificationList"></div>
          </div>
        </div>
      </header>

      <section class="content-area" id="contentArea"></section>
    </main>
  </div>

  <!-- ============ MODALS ============ -->
  <div class="modal" id="addUserModal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title"><i class="fa-solid fa-user-plus"></i><span id="addUserModalTitle">إضافة مستخدم</span></div>
        <button class="close-modal" id="closeAddUserModal"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <form id="addUserForm">
        <div class="input-group">
          <label for="userName" id="userNameLabel">الاسم الكامل</label>
          <input type="text" id="userName" required />
        </div>
        <div class="input-group">
          <label for="userEmail" id="userEmailLabel">البريد الإلكتروني</label>
          <input type="email" id="userEmail" required />
        </div>
        <div class="grid-2">
          <div class="input-group">
            <label for="userType" id="userTypeLabel">نوع المستخدم</label>
            <select id="userType" required>
              <option value="student">طالب</option>
              <option value="teacher">معلم</option>
            </select>
          </div>
          <div class="input-group">
            <label for="userLevel" id="userLevelLabel">المستوى</label>
            <select id="userLevel">
              <option value="beginner">مبتدئ</option>
              <option value="intermediate">متوسط</option>
              <option value="advanced">متقدم</option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="cancelAddUser"><i class="fa-solid fa-ban"></i><span id="cancelText1">إلغاء</span></button>
          <button type="submit" class="btn btn-primary" id="submitAddUser"><i class="fa-solid fa-plus"></i><span id="submitText1">إضافة</span></button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="editUserModal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title"><i class="fa-solid fa-user-pen"></i><span id="editUserModalTitle">تعديل مستخدم</span></div>
        <button class="close-modal" id="closeEditUserModal"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" id="editUserForm">
          @csrf
          <input type="hidden" name="id" id="editUserId">
          <div class="input-group">
            <label id="lblEditUserName">الاسم كامل</label>
            <input type="text" name="full_name" id="editUserName" class="form-control" required>
          </div>
          <div class="input-group">
            <label id="lblEditUserEmail">البريد</label>
            <input type="email" name="email" id="editUserEmail" class="form-control" required>
          </div>
          <div class="input-group">
            <label id="lblEditUserRole">الدور</label>
            <select name="role" id="editUserType" class="form-control" required>
              <option value="student">Student</option>
              <option value="teacher">Teacher</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="input-group">
            <label id="lblEditUserLevel">المستوى (للطلاب)</label>
            <input type="text" name="level" id="editUserLevel" class="form-control">
          </div>
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="hideModal('editUserModal')" id="btnEditUserCancel"><i class="fa-solid fa-ban"></i><span>إلغاء</span></button>
            <button type="submit" class="btn btn-primary" id="btnEditUserSave"><i class="fa-solid fa-save"></i><span>حفظ التعديلات</span></button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- User Profile Modal -->
  <div class="modal-overlay" id="userProfileModal">
    <div class="modal-content" style="max-width:700px;">
      <div class="modal-header">
        <h2 class="modal-title"><i class="fa-solid fa-address-card"></i> <span id="lblUserProfileTitle">الملف الشخصي</span></h2>
        <button class="modal-close" onclick="hideModal('userProfileModal')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div id="profile-loading" style="text-align: center; padding: 20px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i>
        </div>
        <div id="profile-content" style="display:none;">
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div><strong>الاسم:</strong> <span id="up-name"></span></div>
                <div><strong>البريد:</strong> <span id="up-email"></span></div>
                <div><strong>الدور:</strong> <span id="up-role"></span></div>
                <div><strong>تاريخ الانضمام:</strong> <span id="up-joined"></span></div>
                <div><strong>أخر تواجد:</strong> <span id="up-last"></span></div>
            </div>
            
            <div style="margin-bottom:15px;">
                <h3 style="border-bottom:1px solid var(--border); padding-bottom:5px; margin-bottom:10px;">الفصول</h3>
                <ul id="up-enrollments" style="padding-right:20px; color:var(--muted);"></ul>
            </div>
            <div style="margin-bottom:15px;">
                <h3 style="border-bottom:1px solid var(--border); padding-bottom:5px; margin-bottom:10px;">درجات المواد</h3>
                <ul id="up-grades" style="padding-right:20px; color:var(--muted);"></ul>
            </div>
            <div style="margin-bottom:15px;">
                <h3 style="border-bottom:1px solid var(--border); padding-bottom:5px; margin-bottom:10px;">التسليمات</h3>
                <ul id="up-submissions" style="padding-right:20px; color:var(--muted);"></ul>
            </div>
            <div style="margin-bottom:15px;">
                <h3 style="border-bottom:1px solid var(--border); padding-bottom:5px; margin-bottom:10px;">نتائج الاختبارات العامة</h3>
                <ul id="up-tests" style="padding-right:20px; color:var(--muted);"></ul>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="addCourseModal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title"><i class="fa-solid fa-book-medical"></i><span id="addCourseModalTitle">إضافة دورة</span></div>
        <button class="close-modal" id="closeAddCourseModal"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <form id="addCourseForm">
        <div class="input-group">
          <label for="courseName" id="courseNameLabel">اسم الدورة</label>
          <input type="text" id="courseName" required />
        </div>

        <div class="input-group">
          <label for="courseDescription" id="courseDescriptionLabel">الوصف</label>
          <textarea id="courseDescription" rows="3" placeholder="وصف مختصر..."></textarea>
        </div>

        <div class="grid-2">
          <div class="input-group">
            <label for="courseLevel" id="courseLevelLabel">المستوى</label>
            <select id="courseLevel" required>
              <option value="beginner">مبتدئ</option>
              <option value="intermediate">متوسط</option>
              <option value="advanced">متقدم</option>
            </select>
          </div>
          <div class="input-group">
            <label for="courseDuration" id="courseDurationLabel">المدة (أسابيع)</label>
            <input type="number" id="courseDuration" min="1" max="52" value="4" required />
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="cancelAddCourse"><i class="fa-solid fa-ban"></i><span id="cancelText2">إلغاء</span></button>
          <button type="submit" class="btn btn-primary" id="submitAddCourse"><i class="fa-solid fa-plus"></i><span id="submitText2">إضافة</span></button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="editCourseModal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title"><i class="fa-solid fa-pen-to-square"></i><span id="editCourseModalTitle">تعديل دورة</span></div>
        <button class="close-modal" id="closeEditCourseModal"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <form id="editCourseForm" method="POST">
        @csrf
        <input type="hidden" id="editCourseId" name="class_id" />
        <div class="input-group">
          <label for="editCourseName">اسم الدورة</label>
          <input type="text" id="editCourseName" name="class_name" required />
        </div>

        <div class="input-group">
          <label for="editCourseDescription">الوصف</label>
          <textarea id="editCourseDescription" name="description" rows="3" placeholder="وصف مختصر..."></textarea>
        </div>

        <div class="grid-2">
          <div class="input-group">
            <label for="editCourseLevel">المستوى</label>
            <select id="editCourseLevel" name="level" required>
              <option value="beginner">مبتدئ</option>
              <option value="intermediate">متوسط</option>
              <option value="advanced">متقدم</option>
            </select>
          </div>
          <div class="input-group">
            <label for="editCourseDuration">المدة (أسابيع)</label>
            <input type="number" id="editCourseDuration" name="duration" min="1" max="52" />
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="cancelEditCourse"><i class="fa-solid fa-ban"></i><span>إلغاء</span></button>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i><span>حفظ التعديلات</span></button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="addQuestionModal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title"><i class="fa-solid fa-circle-question"></i><span id="addQuestionModalTitle">إضافة سؤال</span></div>
        <button class="close-modal" id="closeAddQuestionModal"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <form id="addQuestionForm">
        <div class="input-group">
          <label for="questionText" id="questionTextLabel">نص السؤال</label>
          <textarea id="questionText" rows="3" required></textarea>
        </div>

        <div class="grid-2">
          <div class="input-group">
            <label for="questionType" id="questionTypeLabel">نوع السؤال</label>
            <select id="questionType" required>
              <option value="multiple-choice">اختيار من متعدد</option>
              <option value="true-false">صواب / خطأ</option>
              <option value="fill-blank">فراغات</option>
            </select>
          </div>
          <div class="input-group">
            <label for="questionDifficulty" id="questionDifficultyLabel">الصعوبة</label>
            <select id="questionDifficulty" required>
              <option value="easy">سهل</option>
              <option value="medium">متوسط</option>
              <option value="hard">صعب</option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="cancelAddQuestion"><i class="fa-solid fa-ban"></i><span id="cancelText3">إلغاء</span></button>
          <button type="submit" class="btn btn-primary" id="submitAddQuestion"><i class="fa-solid fa-plus"></i><span id="submitText3">إضافة</span></button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="editQuestionModal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title"><i class="fa-solid fa-pen"></i><span id="editQuestionModalTitle">تعديل سؤال</span></div>
        <button class="close-modal" id="closeEditQuestionModal"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <form id="editQuestionForm" method="POST">
        @csrf
        <!-- ID is dynamically appended to action url -->
        <input type="hidden" id="editQuestionId" name="question_id" />
        <div class="input-group">
          <label for="editQuestionText">نص السؤال</label>
          <textarea id="editQuestionText" name="question_text" rows="3" required></textarea>
        </div>

        <div class="grid-2">
          <div class="input-group">
            <label for="editQuestionType">نوع السؤال</label>
            <select id="editQuestionType" name="question_type" required>
              <option value="multiple-choice">اختيار من متعدد</option>
              <option value="true-false">صواب / خطأ</option>
              <option value="fill-blank">فراغات</option>
            </select>
          </div>
          <div class="input-group">
            <label for="editQuestionDifficulty">الصعوبة</label>
            <select id="editQuestionDifficulty" name="difficulty_level" required>
              <option value="easy">سهل</option>
              <option value="medium">متوسط</option>
              <option value="hard">صعب</option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="cancelEditQuestion"><i class="fa-solid fa-ban"></i><span>إلغاء</span></button>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i><span>حفظ التعديلات</span></button>
        </div>
      </form>
    </div>
  </div>

  <script>
    /* =========================
       Translations (AR/EN)
    ========================== */
    const translations = {
      ar: {
        brandSub: "لوحة تحكم المشرف - إدارة المحتوى والمستخدمين",
        hintText: "بيانات تجريبية:",
        usernameLabel: "اسم المستخدم",
        passwordLabel: "كلمة المرور",
        languageLabel: "اللغة",
        themeLabel: "المظهر",
        loginBtnText: "تسجيل الدخول",
        adminName: "المشرف العام",
        adminRole: "مدير النظام",
        navHome: "لوحة التحكم",
        navUsers: "إدارة المستخدمين",
        navCourses: "إدارة الدورات",
        navContent: "إدارة المحتوى",
        navSettings: "الإعدادات",
        logoutText: "تسجيل الخروج",
        notificationsTitle: "الإشعارات",
        markAllReadText: "قراءة الكل",
        sidebarFooterText: "حالة النظام",
        sidebarFooterStatus: "Online",
        searchPlaceholder: "ابحث عن طالب، معلم، دورة، سؤال...",
        dashboardTitle: "لوحة التحكم",
        usersTitle: "إدارة المستخدمين",
        coursesTitle: "إدارة الدورات",
        contentTitle: "إدارة المحتوى",
        settingsTitle: "الإعدادات",
        addUserText: "إضافة مستخدم",
        addCourseText: "إضافة دورة",
        addQuestionText: "إضافة سؤال",
        exportText: "تصدير",
        studentsLabel: "الطلاب",
        teachersLabel: "المعلمين",
        activeCoursesLabel: "الدورات النشطة",
        totalQuestionsLabel: "إجمالي الأسئلة",
        viewText: "عرض",
        editText: "تعديل",
        deleteText: "حذف",
        addUserModalTitle: "إضافة مستخدم",
        userNameLabel: "الاسم الكامل",
        userEmailLabel: "البريد الإلكتروني",
        userTypeLabel: "نوع المستخدم",
        userLevelLabel: "المستوى",
        addCourseModalTitle: "إضافة دورة",
        courseNameLabel: "اسم الدورة",
        courseDescriptionLabel: "الوصف",
        courseLevelLabel: "المستوى",
        courseDurationLabel: "المدة (أسابيع)",
        addQuestionModalTitle: "إضافة سؤال",
        questionTextLabel: "نص السؤال",
        questionTypeLabel: "نوع السؤال",
        questionDifficultyLabel: "الصعوبة",
        cancel: "إلغاء",
        submit: "إضافة",
        confirmDelete: "هل أنت متأكد من حذف هذا العنصر؟",
        confirmLogout: "هل أنت متأكد من تسجيل الخروج؟",
        loginSuccess: "تم تسجيل الدخول بنجاح",
        loginError: "اسم المستخدم أو كلمة المرور غير صحيحة",
        logoutSuccess: "تم تسجيل الخروج بنجاح",
        addSuccess: "تمت الإضافة بنجاح",
        deleteSuccess: "تم الحذف بنجاح",
        updateSuccess: "تم التحديث بنجاح",
        exportSuccess: "تم التصدير بنجاح",
        noData: "لا توجد بيانات",
        recentActivity: "النشاط الأخير"
      },
      en: {
        brandSub: "Admin Console - Manage users and content",
        hintText: "Demo credentials:",
        usernameLabel: "Username",
        passwordLabel: "Password",
        languageLabel: "Language",
        themeLabel: "Theme",
        loginBtnText: "Login",
        adminName: "Admin",
        adminRole: "System Administrator",
        navHome: "Dashboard",
        navUsers: "Users",
        navCourses: "Courses",
        navContent: "Content",
        navSettings: "Settings",
        logoutText: "Logout",
        notificationsTitle: "Notifications",
        markAllReadText: "Mark all read",
        sidebarFooterText: "System status",
        sidebarFooterStatus: "Online",
        searchPlaceholder: "Search for student, teacher, course, question...",
        dashboardTitle: "Dashboard",
        usersTitle: "Users",
        coursesTitle: "Courses",
        contentTitle: "Content",
        settingsTitle: "Settings",
        addUserText: "Add User",
        addCourseText: "Add Course",
        addQuestionText: "Add Question",
        exportText: "Export",
        studentsLabel: "Students",
        teachersLabel: "Teachers",
        activeCoursesLabel: "Active Courses",
        totalQuestionsLabel: "Total Questions",
        viewText: "View",
        editText: "Edit",
        deleteText: "Delete",
        addUserModalTitle: "Add User",
        userNameLabel: "Full name",
        userEmailLabel: "Email",
        userTypeLabel: "User type",
        userLevelLabel: "Level",
        addCourseModalTitle: "Add Course",
        courseNameLabel: "Course name",
        courseDescriptionLabel: "Description",
        courseLevelLabel: "Level",
        courseDurationLabel: "Duration (weeks)",
        addQuestionModalTitle: "Add Question",
        questionTextLabel: "Question text",
        questionTypeLabel: "Question type",
        questionDifficultyLabel: "Difficulty",
        cancel: "Cancel",
        submit: "Add",
        confirmDelete: "Are you sure you want to delete this item?",
        confirmLogout: "Are you sure you want to logout?",
        loginSuccess: "Logged in successfully",
        loginError: "Invalid username or password",
        logoutSuccess: "Logged out successfully",
        addSuccess: "Added successfully",
        deleteSuccess: "Deleted successfully",
        updateSuccess: "Updated successfully",
        exportSuccess: "Exported successfully",
        noData: "No data available",
        recentActivity: "Recent activity"
      }
    };

    /* =========================
       Data Loading
    ========================== */
    let studentsData = @json($allStudents->items());
    let teachersData = @json($allTeachers->items());
    let coursesData = @json($allCourses->items());
    let questionsData = @json($allQuestions->items());

    let studentsPagination = `{!! $allStudents->appends(['tab' => 'users', 'view' => 'students'])->links('pagination::tailwind')->toHtml() !!}`;
    let teachersPagination = `{!! $allTeachers->appends(['tab' => 'users', 'view' => 'teachers'])->links('pagination::tailwind')->toHtml() !!}`;
    let coursesPagination = `{!! $allCourses->appends(['tab' => 'courses'])->links('pagination::tailwind')->toHtml() !!}`;
    let questionsPagination = `{!! $allQuestions->appends(['tab' => 'content'])->links('pagination::tailwind')->toHtml() !!}`;

    let currentTab = new URLSearchParams(window.location.search).get('tab') || 'home';
    let currentUsersView = new URLSearchParams(window.location.search).get('view') || 'students';

    @php
        $userSessionId = session('user_id');
        $currentUser = $userSessionId ? \App\Models\User_Model::find($userSessionId) : null;
        $dbNotifications = $currentUser ? $currentUser->notifications : [];
    @endphp

    let notificationsData = [
      @foreach($dbNotifications as $n)
      {
        id: "{{ $n->id }}",
        title: currentLanguage === 'ar' ? 'إشعار جديد' : 'New Notification',
        message: "{!! addslashes($n->data['message'] ?? '') !!}",
        time: "{{ $n->created_at->diffForHumans() }}",
        read: {{ $n->read_at ? 'true' : 'false' }},
        url: "{{ $n->data['url'] ?? '#' }}"
      }{{ $loop->last ? '' : ',' }}
      @endforeach
    ];

    let currentUsersView = "students"; // students | teachers

    /* =========================
       Helpers
    ========================== */
    const levelName = (lvl) => {
      const ar = { beginner: "مبتدئ", intermediate: "متوسط", advanced: "متقدم" };
      const en = { beginner: "Beginner", intermediate: "Intermediate", advanced: "Advanced" };
      return currentLanguage === "ar" ? (ar[lvl] || lvl) : (en[lvl] || lvl);
    };

    const qTypeName = (t) => {
      const ar = { "multiple-choice": "اختيار من متعدد", "true-false": "صواب/خطأ", "fill-blank": "فراغات" };
      const en = { "multiple-choice": "Multiple choice", "true-false": "True/False", "fill-blank": "Fill blank" };
      return currentLanguage === "ar" ? (ar[t] || t) : (en[t] || t);
    };

    const diffName = (d) => {
      const ar = { easy: "سهل", medium: "متوسط", hard: "صعب" };
      const en = { easy: "Easy", medium: "Medium", hard: "Hard" };
      return currentLanguage === "ar" ? (ar[d] || d) : (en[d] || d);
    };

    function showToast(message, type="success"){
      const toast = document.createElement("div");
      toast.className = `toast ${type}`;
      toast.innerHTML = `
        <i class="fa-solid ${type==="success"?"fa-circle-check":type==="error"?"fa-circle-xmark":"fa-circle-info"}"></i>
        <span>${message}</span>
      `;
      document.body.appendChild(toast);
      setTimeout(()=>{ toast.style.animation="toastOut .22s ease"; setTimeout(()=>toast.remove(),220); }, 2600);
    }

    function applyTheme(theme){
      currentTheme = theme;
      localStorage.setItem("lingopulse_theme", theme);
      if(theme==="dark") document.body.classList.add("dark-theme");
      else document.body.classList.remove("dark-theme");
    }

    function applyLanguage(lang){
      currentLanguage = lang;
      localStorage.setItem("lingopulse_language", lang);

      if(lang==="en"){
        document.body.classList.add("english");
        document.documentElement.lang = "en";
        document.documentElement.dir = "ltr";
      }else{
        document.body.classList.remove("english");
        document.documentElement.lang = "ar";
        document.documentElement.dir = "rtl";
      }

      // write translated texts
      const t = translations[lang];
      Object.entries(t).forEach(([key,val])=>{
        const el = document.getElementById(key);
        if(!el) return;
        el.textContent = val;
      });

      // placeholders
      const search = document.getElementById("searchInput");
      if(search) search.placeholder = t.searchPlaceholder;

      // re-render current section
      const active = document.querySelector(".nav-item.active")?.getAttribute("data-section") || "home";
      loadSection(active);
      loadNotifications();
    }

    function showModal(id){ document.getElementById(id).classList.add("active"); }
    function hideModal(id){ document.getElementById(id).classList.remove("active"); }

    function loadNotifications(){
      const list = document.getElementById("notificationList");
      const badge = document.getElementById("notificationBadge");
      if(!list || !badge) return;

      list.innerHTML = "";
      let unread = 0;

      // Ensure notifications are sorted by most recent
      notificationsData.forEach(n=>{
        if(!n.read) unread++;
        const item = document.createElement("div");
        item.className = `notif-item ${n.read ? "" : "unread"}`;
        item.innerHTML = `
          <div class="notif-title">${n.title}</div>
          <div class="notif-msg">${n.message}</div>
          <div class="notif-time">${n.time}</div>
        `;
        item.addEventListener("click", ()=>{
          if (!n.read) {
            n.read = true;
            fetch(`/notifications/${n.id}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            loadNotifications();
          }
          if (n.url && n.url !== '#') {
            window.location.href = n.url;
          }
        });
        list.appendChild(item);
      });

      badge.textContent = unread;
    }

    function markAllRead(){
      fetch(`/notifications/mark-all-read`, {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Content-Type': 'application/json'
          }
      }).then(() => {
          notificationsData = notificationsData.map(n=>({ ...n, read:true }));
          loadNotifications();
          showToast(currentLanguage==="ar" ? "تمت قراءة جميع الإشعارات" : "All notifications marked as read", "success");
      });
    }

    function fetchUnreadNotifications() {
        fetch("{{ route('notifications.unread') }}")
        .then(res => res.json())
        .then(data => {
            if(data.success && data.notifications) {
                let newNotifs = false;
                data.notifications.forEach(notif => {
                    // Check if we already have it
                    let exists = false;
                    for (let i = 0; i < notificationsData.length; i++) {
                        if (notificationsData[i].id == notif.id) {
                            exists = true;
                            break;
                        }
                    }
                    if (!exists) {
                        notificationsData.unshift({
                            id: notif.id,
                            title: currentLanguage === 'ar' ? 'إشعار جديد' : 'New Notification',
                            message: notif.message,
                            time: notif.time,
                            read: notif.read,
                            url: notif.url
                        });
                        newNotifs = true;
                    }
                });
                if(newNotifs) loadNotifications();
            }
        }).catch(err => console.error("Error fetching notifications:", err));
    }

    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("active");
    }

    function logout(){
      if(!confirm(translations[currentLanguage].confirmLogout)) return;
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route("logout") }}';
      const csrf = document.createElement('input');
      csrf.type = 'hidden';
      csrf.name = '_token';
      csrf.value = '{{ csrf_token() }}';
      form.appendChild(csrf);
      document.body.appendChild(form);
      form.submit();
    }

    /* =========================
       Sections
    ========================== */
    function updateURL(tab, view = null) {
      const url = new URL(window.location);
      url.searchParams.set('tab', tab);
      if (view) url.searchParams.set('view', view);
      window.history.pushState({}, '', url);
    }

    function loadSection(section){
      document.querySelectorAll(".nav-item").forEach(x=>x.classList.remove("active"));
      document.querySelector(`.nav-item[data-section="${section}"]`)?.classList.add("active");

      updateURL(section, (section==='users' ? currentUsersView : null));

      if(section==="home") return loadDashboard();
      if(section==="users") return loadUsers();
      if(section==="courses") return loadCourses();
      if(section==="content") return loadContent();
      if(section==="settings") return loadSettings();
      return loadDashboard();
    }

    function loadDashboard(){
      const area = document.getElementById("contentArea");
      const t = translations[currentLanguage];

      const stats = {
        totalStudents: studentsData.filter(s=>s.status==="active").length,
        totalTeachers: teachersData.filter(s=>s.status==="active").length,
        activeCourses: coursesData.filter(c=>c.status==="active").length,
        totalQuestions: questionsData.length
      };

      area.innerHTML = `
        <div class="card">
          <div class="section-header">
            <div class="section-title"><i class="fa-solid fa-gauge-high"></i><span>${t.dashboardTitle}</span></div>
          </div>

          <div class="stats">
            <div class="stat">
              <div class="stat-top">
                <div>
                  <div class="stat-value">${stats.totalStudents}</div>
                  <div class="stat-label">${t.studentsLabel}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-user-graduate"></i></div>
              </div>
            </div>

            <div class="stat">
              <div class="stat-top">
                <div>
                  <div class="stat-value">${stats.totalTeachers}</div>
                  <div class="stat-label">${t.teachersLabel}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-chalkboard-user"></i></div>
              </div>
            </div>

            <div class="stat">
              <div class="stat-top">
                <div>
                  <div class="stat-value">${stats.activeCourses}</div>
                  <div class="stat-label">${t.activeCoursesLabel}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-book"></i></div>
              </div>
            </div>

            <div class="stat">
              <div class="stat-top">
                <div>
                  <div class="stat-value">${stats.totalQuestions}</div>
                  <div class="stat-label">${t.totalQuestionsLabel}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-circle-question"></i></div>
              </div>
            </div>
          </div>

          <div class="grid-2" style="margin-top:20px; gap: 20px;">
            <div class="card" style="margin:0;">
              <h3 style="margin-bottom:15px; color:var(--dark-text); font-size: 1.1rem;">${currentLanguage==='ar'?'الاشتراكات الشهرية':'Monthly Registrations'}</h3>
              <canvas id="registrationsChart"></canvas>
            </div>
            <div class="card" style="margin:0;">
              <h3 style="margin-bottom:15px; color:var(--dark-text); font-size: 1.1rem;">${currentLanguage==='ar'?'توزيع الأدوار':'User Roles'}</h3>
              <canvas id="rolesChart"></canvas>
            </div>
          </div>

          <div class="section-header" style="margin-top:20px;">
            <div class="section-title"><i class="fa-solid fa-chart-line"></i><span>${t.recentActivity}</span></div>
          </div>

          <div class="card" style="margin:0;box-shadow:none;">
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;">
              <div class="stat-ico" style="width:44px;height:44px;border-radius:14px;"><i class="fa-solid fa-user-plus"></i></div>
              <div>
                <div style="font-weight:900;">${currentLanguage==="ar"?"تسجيل جديد":"New registration"}</div>
                <div style="color:var(--muted);font-weight:800;font-size:.95rem;">${currentLanguage==="ar"?"تم تسجيل مستخدم جديد اليوم":"A new user registered today"}</div>
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;">
              <div class="stat-ico" style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#10b981,#0ea371);"><i class="fa-solid fa-book-open"></i></div>
              <div>
                <div style="font-weight:900;">${currentLanguage==="ar"?"تحديث محتوى":"Content update"}</div>
                <div style="color:var(--muted);font-weight:800;font-size:.95rem;">${currentLanguage==="ar"?"تمت إضافة أسئلة جديدة للمستويات":"New questions added for levels"}</div>
              </div>
            </div>
          </div>
        </div>
      `;

      area.innerHTML += `
        <div class="card" id="ai-analysis-container" style="margin-top:20px; border-left: 4px solid #6366f1; min-height: 150px; display: flex; align-items: center; justify-content: center;">
          <div style="text-align: center; color: var(--muted); font-weight: bold;">
             <i class="fa-solid fa-spinner fa-spin fa-2x" style="margin-bottom: 10px; color: #6366f1;"></i><br>
             ${currentLanguage === 'ar' ? 'جاري تحليل البيانات...' : 'Analyzing data with AI...'}
          </div>
        </div>
      `;

      fetch("{{ route('admin.api.ai') }}")
        .then(r => r.json())
        .then(aiAnalysisData => {
            const container = document.getElementById('ai-analysis-container');
            if(!container || !aiAnalysisData || !aiAnalysisData.strengths_ar) {
                if(container) container.style.display = 'none';
                return;
            }
            let isAr = currentLanguage === 'ar';
            let titleText = isAr ? 'تحليل الأداء بواسطة الذكاء الاصطناعي' : 'AI Performance Analysis';
            let strengthsTitle = isAr ? 'نقاط القوة' : 'Strengths';
            let weaknessesTitle = isAr ? 'مجالات التحسين' : 'Areas for Improvement';
            let adviceTitle = isAr ? 'نصيحة استراتيجية' : 'Strategic Advice';

            let strengthsHTML = isAr 
                ? aiAnalysisData.strengths_ar.map(s => `<li><i class="fa-solid fa-check" style="color:#10b981;"></i> ${s}</li>`).join('')
                : aiAnalysisData.strengths_en.map(s => `<li><i class="fa-solid fa-check" style="color:#10b981;"></i> ${s}</li>`).join('');
            let weaknessesHTML = isAr 
                ? aiAnalysisData.weaknesses_ar.map(w => `<li><i class="fa-solid fa-triangle-exclamation" style="color:#f59e0b;"></i> ${w}</li>`).join('')
                : aiAnalysisData.weaknesses_en.map(w => `<li><i class="fa-solid fa-triangle-exclamation" style="color:#f59e0b;"></i> ${w}</li>`).join('');
            let adviceHTML = isAr ? aiAnalysisData.advice_ar : aiAnalysisData.advice_en;

            // Reset container styles for actual content
            container.style.display = 'block';
            container.innerHTML = `
              <div class="section-header">
                <div class="section-title">
                    <i class="fa-solid fa-robot" style="color:#6366f1;"></i>
                    <span>${titleText}</span>
                </div>
              </div>
              <div class="grid-2" style="margin-top:15px; font-weight:800;">
                <div>
                  <h4 style="margin-bottom:10px; color:#10b981;">${strengthsTitle}</h4>
                  <ul style="list-style:none; padding:0; margin:0; display:grid; gap:8px;">
                    ${strengthsHTML}
                  </ul>
                </div>
                <div>
                  <h4 style="margin-bottom:10px; color:#f59e0b;">${weaknessesTitle}</h4>
                  <ul style="list-style:none; padding:0; margin:0; display:grid; gap:8px;">
                    ${weaknessesHTML}
                  </ul>
                </div>
              </div>
              <div style="margin-top:20px; padding:15px; background:rgba(99,102,241,0.1); border-radius:12px;">
                  <h4 style="margin-bottom:8px; color:#6366f1;">${adviceTitle}</h4>
                  <p style="margin:0; font-weight:800; line-height:1.6;">${adviceHTML}</p>
              </div>
            `;
        }).catch(err => {
            const container = document.getElementById('ai-analysis-container');
            if(container) {
                container.innerHTML = `
                    <div style="text-align:center; padding: 20px; color: var(--danger-color);">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i><br>
                        ${currentLanguage === 'ar' ? 'فشل تحميل تحليل الذكاء الاصطناعي. الرجاء المحاولة لاحقاً.' : 'Failed to load AI Analysis. Please try again later.'}
                    </div>
                `;
            }
        });
    }

    function loadUsers(){
      const area = document.getElementById("contentArea");
      const t = translations[currentLanguage];

      area.innerHTML = `
        <div class="card">
          <div class="section-header">
            <div class="section-title"><i class="fa-solid fa-users"></i><span>${t.usersTitle}</span></div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
              <button class="btn ${currentUsersView==="students" ? "btn-primary":"btn-secondary"}" id="studentsTab">
                <i class="fa-solid fa-user-graduate"></i><span>${t.studentsLabel}</span>
              </button>
              <button class="btn ${currentUsersView==="teachers" ? "btn-primary":"btn-secondary"}" id="teachersTab">
                <i class="fa-solid fa-chalkboard-user"></i><span>${t.teachersLabel}</span>
              </button>
              <button class="btn btn-success" id="addUserBtn">
                <i class="fa-solid fa-user-plus"></i><span>${t.addUserText}</span>
              </button>
            </div>
          </div>

          <div id="usersTableContainer"></div>
        </div>
      `;

      document.getElementById("studentsTab").addEventListener("click", ()=>{ 
        currentUsersView="students"; 
        updateURL('users', 'students');
        loadUsers(); 
      });
      document.getElementById("teachersTab").addEventListener("click", ()=>{ 
        currentUsersView="teachers"; 
        updateURL('users', 'teachers');
        loadUsers(); 
      });
      document.getElementById("addUserBtn").addEventListener("click", ()=>showModal("addUserModal"));

      renderUsersTable();
    }

    function renderUsersTable(){
      const container = document.getElementById("usersTableContainer");
      const t = translations[currentLanguage];
      const users = currentUsersView==="students" ? studentsData : teachersData;

      if(!users.length){
        container.innerHTML = `<div style="padding:26px;color:var(--muted);font-weight:900;text-align:center;">${t.noData}</div>`;
        return;
      }

      const th4 = currentUsersView==="students"
        ? (currentLanguage==="ar" ? "المستوى" : "Level")
        : (currentLanguage==="ar" ? "التخصص" : "Specialization");

      container.innerHTML = `
        <table class="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>${currentLanguage==="ar"?"الاسم":"Name"}</th>
              <th>${currentLanguage==="ar"?"البريد":"Email"}</th>
              <th>${th4}</th>
              <th>${currentLanguage==="ar"?"الحالة":"Status"}</th>
              <th>${currentLanguage==="ar"?"الإجراءات":"Actions"}</th>
            </tr>
          </thead>
          <tbody>
            ${users.map(u=>`
              <tr>
                <td>${u.id}</td>
                <td>${u.name}</td>
                <td>${u.email}</td>
                <td>${currentUsersView==="students" ? levelName(u.level) : u.specialization}</td>
                <td>
                  <span class="tag ${u.status==="active" ? "ok":"bad"}">
                    <i class="fa-solid ${u.status==="active"?"fa-circle-check":"fa-circle-xmark"}"></i>
                    ${u.status==="active" ? (currentLanguage==="ar"?"نشط":"Active") : (currentLanguage==="ar"?"غير نشط":"Inactive")}
                  </span>
                </td>
                <td class="table-actions">
                  <button class="btn-icon view" onclick="viewUser(${u.id}, '${currentUsersView}')"><i class="fa-solid fa-eye"></i>${t.viewText}</button>
                  <button class="btn-icon edit" onclick="editUser(${u.id}, '${currentUsersView}')"><i class="fa-solid fa-pen"></i>${t.editText}</button>
                  <button class="btn-icon del" onclick="deleteUser(${u.id}, '${currentUsersView}')"><i class="fa-solid fa-trash"></i>${t.deleteText}</button>
                </td>
              </tr>
            `).join("")}
          </tbody>
        </table>
        <div style="margin-top:20px; direction:ltr; display:flex; justify-content:center;">
          ${currentUsersView==="students" ? studentsPagination : teachersPagination}
        </div>
      `;
    }

    function loadCourses(){
      const area = document.getElementById("contentArea");
      const t = translations[currentLanguage];

      area.innerHTML = `
        <div class="card">
          <div class="section-header">
            <div class="section-title"><i class="fa-solid fa-book"></i><span>${t.coursesTitle}</span></div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
              <button class="btn btn-success" id="addCourseBtn">
                <i class="fa-solid fa-plus"></i><span>${t.addCourseText}</span>
              </button>
              <button class="btn" id="autoGroupAIBtn" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); color: #fff; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: 600; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-wand-magic-sparkles"></i><span>${currentLanguage === 'ar' ? 'توليد فصول بالذكاء الاصطناعي' : 'Auto-Group with AI'}</span>
              </button>
            </div>
          </div>

          <div id="coursesTableContainer"></div>
        </div>
      `;

      document.getElementById("addCourseBtn").addEventListener("click", ()=>showModal("addCourseModal"));
      
      document.getElementById("autoGroupAIBtn").addEventListener("click", function() {
          const btn = this;
          const originalHTML = btn.innerHTML;
          btn.disabled = true;
          btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>' + (currentLanguage === 'ar' ? 'جاري التوليد...' : 'Generating...') + '</span>';
          btn.style.opacity = '0.7';

          fetch("{{ route('admin.autoGroupClasses') }}", {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
          })
          .then(r => r.json())
          .then(data => {
              btn.disabled = false;
              btn.innerHTML = originalHTML;
              btn.style.opacity = '1';
              if (data.success) {
                  alert((currentLanguage === 'ar' ? 'تم بنجاح! ' : 'Success! ') + data.message);
                  location.reload();
              } else {
                  alert((currentLanguage === 'ar' ? 'خطأ: ' : 'Error: ') + data.message);
              }
          })
          .catch(err => {
              btn.disabled = false;
              btn.innerHTML = originalHTML;
              btn.style.opacity = '1';
              alert((currentLanguage === 'ar' ? 'حدث خطأ غير متوقع.' : 'An unexpected error occurred.'));
              console.error(err);
          });
      });
      renderCoursesTable();
    }

    function renderCoursesTable(){
      const container = document.getElementById("coursesTableContainer");
      const t = translations[currentLanguage];

      if(!coursesData.length){
        container.innerHTML = `<div style="padding:26px;color:var(--muted);font-weight:900;text-align:center;">${t.noData}</div>`;
        return;
      }

      container.innerHTML = `
        <table class="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>${currentLanguage==="ar"?"اسم الدورة":"Course"}</th>
              <th>${currentLanguage==="ar"?"المستوى":"Level"}</th>
              <th>${currentLanguage==="ar"?"المدة":"Duration"}</th>
              <th>${currentLanguage==="ar"?"الطلاب":"Students"}</th>
              <th>${currentLanguage==="ar"?"الحالة":"Status"}</th>
              <th>${currentLanguage==="ar"?"الإجراءات":"Actions"}</th>
            </tr>
          </thead>
          <tbody>
            ${coursesData.map(c=>`
              <tr>
                <td>${c.id}</td>
                <td>${c.name}</td>
                <td>${levelName(c.level)}</td>
                <td>${c.duration} ${currentLanguage==="ar"?"أسبوع":"weeks"}</td>
                <td>${c.students}</td>
                <td>
                  <span class="tag ${c.status==="active" ? "ok":"bad"}">
                    <i class="fa-solid ${c.status==="active"?"fa-circle-check":"fa-circle-xmark"}"></i>
                    ${c.status==="active" ? (currentLanguage==="ar"?"نشط":"Active") : (currentLanguage==="ar"?"غير نشط":"Inactive")}
                  </span>
                </td>
                <td class="table-actions">
                  <button class="btn-icon view" onclick="viewCourse(${c.id})"><i class="fa-solid fa-eye"></i>${t.viewText}</button>
                  <button class="btn-icon edit" onclick="editCourse(${c.id})"><i class="fa-solid fa-pen"></i>${t.editText}</button>
                  <button class="btn-icon del" onclick="deleteCourse(${c.id})"><i class="fa-solid fa-trash"></i>${t.deleteText}</button>
                </td>
              </tr>
            `).join("")}
          </tbody>
        </table>
        <div style="margin-top:20px; direction:ltr; display:flex; justify-content:center;">
          ${coursesPagination}
        </div>
      `;
    }

    function loadContent(){
      const area = document.getElementById("contentArea");
      const t = translations[currentLanguage];

      area.innerHTML = `
        <div class="card">
          <div class="section-header">
            <div class="section-title"><i class="fa-solid fa-database"></i><span>${t.contentTitle}</span></div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
              <button class="btn btn-secondary" id="exportBtn"><i class="fa-solid fa-download"></i><span>${t.exportText}</span></button>
              <button class="btn btn-success" id="addQuestionBtn"><i class="fa-solid fa-plus"></i><span>${t.addQuestionText}</span></button>
            </div>
          </div>

          <div id="questionsTableContainer"></div>
        </div>
      `;

      document.getElementById("addQuestionBtn").addEventListener("click", ()=>showModal("addQuestionModal"));
      document.getElementById("exportBtn").addEventListener("click", ()=>showToast(t.exportSuccess, "success"));

      renderQuestionsTable();
    }

    function renderQuestionsTable(){
      const container = document.getElementById("questionsTableContainer");
      const t = translations[currentLanguage];

      if(!questionsData.length){
        container.innerHTML = `<div style="padding:26px;color:var(--muted);font-weight:900;text-align:center;">${t.noData}</div>`;
        return;
      }

      container.innerHTML = `
        <table class="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>${currentLanguage==="ar"?"نص السؤال":"Question"}</th>
              <th>${currentLanguage==="ar"?"النوع":"Type"}</th>
              <th>${currentLanguage==="ar"?"الصعوبة":"Difficulty"}</th>
              <th>${currentLanguage==="ar"?"التاريخ":"Date"}</th>
              <th>${currentLanguage==="ar"?"الإجراءات":"Actions"}</th>
            </tr>
          </thead>
          <tbody>
            ${questionsData.map(q=>`
              <tr>
                <td>${q.id}</td>
                <td style="max-width:360px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${q.text}</td>
                <td>${qTypeName(q.type)}</td>
                <td>${diffName(q.difficulty)}</td>
                <td>${q.date}</td>
                <td class="table-actions">
                  <button class="btn-icon edit" onclick="editQuestion(${q.id})"><i class="fa-solid fa-pen"></i>${t.editText}</button>
                  <button class="btn-icon del" onclick="deleteQuestion(${q.id})"><i class="fa-solid fa-trash"></i>${t.deleteText}</button>
                </td>
              </tr>
            `).join("")}
          </tbody>
        </table>
        <div style="margin-top:20px; direction:ltr; display:flex; justify-content:center;">
          ${questionsPagination}
        </div>
      `;
    }

    function loadSettings(){
      const area = document.getElementById("contentArea");
      const t = translations[currentLanguage];

      area.innerHTML = `
        <div class="card">
          <div class="section-header">
            <div class="section-title"><i class="fa-solid fa-gear"></i><span>${t.settingsTitle}</span></div>
          </div>

          <div class="stats">
            <div class="stat">
              <div class="stat-top">
                <div>
                  <div style="font-weight:900;margin-bottom:6px;">${currentLanguage==="ar"?"المظهر":"Theme"}</div>
                  <div style="color:var(--muted);font-weight:800;">${currentLanguage==="ar"?"اختر فاتح أو غامق":"Choose light or dark"}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-palette"></i></div>
              </div>
              <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:10px;">
                <button class="btn ${currentTheme==="light"?"btn-primary":"btn-secondary"}" id="lightBtn">
                  <i class="fa-solid fa-sun"></i><span>${currentLanguage==="ar"?"فاتح":"Light"}</span>
                </button>
                <button class="btn ${currentTheme==="dark"?"btn-primary":"btn-secondary"}" id="darkBtn">
                  <i class="fa-solid fa-moon"></i><span>${currentLanguage==="ar"?"غامق":"Dark"}</span>
                </button>
              </div>
            </div>

            <div class="stat">
              <div class="stat-top">
                <div>
                  <div style="font-weight:900;margin-bottom:6px;">${currentLanguage==="ar"?"اللغة":"Language"}</div>
                  <div style="color:var(--muted);font-weight:800;">${currentLanguage==="ar"?"تغيير اتجاه وواجهة النظام":"Switch UI direction + text"}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-globe"></i></div>
              </div>
              <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:10px;">
                <button class="btn ${currentLanguage==="ar"?"btn-primary":"btn-secondary"}" id="arBtn">
                  <i class="fa-solid fa-language"></i><span>العربية</span>
                </button>
                <button class="btn ${currentLanguage==="en"?"btn-primary":"btn-secondary"}" id="enBtn">
                  <i class="fa-solid fa-language"></i><span>English</span>
                </button>
              </div>
            </div>

            <div class="stat">
              <div class="stat-top">
                <div>
                  <div style="font-weight:900;margin-bottom:6px;">${currentLanguage==="ar"?"الإشعارات":"Notifications"}</div>
                  <div style="color:var(--muted);font-weight:800;">${currentLanguage==="ar"?"إعدادات شكلية للعرض":"UI demo toggles"}</div>
                </div>
                <div class="stat-ico"><i class="fa-solid fa-bell"></i></div>
              </div>
              <div style="margin-top:10px;display:grid;gap:10px;">
                ${toggleRow(currentLanguage==="ar"?"إشعارات البريد الإلكتروني":"Email notifications","emailN")}
                ${toggleRow(currentLanguage==="ar"?"إشعارات داخل النظام":"In-app notifications","appN")}
                ${toggleRow(currentLanguage==="ar"?"إشعارات النظام":"System notifications","sysN")}
              </div>
            </div>
          </div>
        </div>
      `;

      document.getElementById("lightBtn").addEventListener("click", ()=>{ applyTheme("light"); loadSettings(); showToast(t.updateSuccess,"success"); });
      document.getElementById("darkBtn").addEventListener("click", ()=>{ applyTheme("dark"); loadSettings(); showToast(t.updateSuccess,"success"); });
      document.getElementById("arBtn").addEventListener("click", ()=>{ applyLanguage("ar"); document.getElementById("languageSwitchTop").value="ar"; document.getElementById("languageSelect").value="ar"; });
      document.getElementById("enBtn").addEventListener("click", ()=>{ applyLanguage("en"); document.getElementById("languageSwitchTop").value="en"; document.getElementById("languageSelect").value="en"; });
    }

    function toggleRow(label, id){
      // CSS-free tiny toggle (pure HTML)
      return `
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 12px;border:1px solid var(--border);border-radius:14px;background:rgba(15,23,42,.03);">
          <span style="font-weight:900;">${label}</span>
          <label style="display:inline-flex;align-items:center;gap:10px;cursor:pointer;font-weight:900;color:var(--muted);">
            <input type="checkbox" id="${id}" checked style="width:18px;height:18px;accent-color:#2563eb;">
          </label>
        </div>
      `;
    }

    /* =========================
       CRUD Operations
    ========================== */
    window.viewUser = function(id, type){
      showModal("userProfileModal");
      const loading = document.getElementById('profile-loading');
      const content = document.getElementById('profile-content');
      loading.style.display = 'block';
      content.style.display = 'none';

      fetch(`/admin/user/${id}/profile`)
          .then(res => res.json())
          .then(data => {
              loading.style.display = 'none';
              if (data.success) {
                  renderUserProfile(data);
                  content.style.display = 'block';
              } else {
                  showToast('Failed to load profile', 'error');
                  hideModal("userProfileModal");
              }
          })
          .catch(err => {
              loading.style.display = 'none';
              showToast('Error loading profile', 'error');
              hideModal("userProfileModal");
          });
    };

    function renderUserProfile(data) {
        document.getElementById('up-name').textContent = data.profile.name;
        document.getElementById('up-email').textContent = data.profile.email;
        document.getElementById('up-role').textContent = data.profile.role;
        document.getElementById('up-joined').textContent = data.profile.joined;
        document.getElementById('up-last').textContent = data.profile.last_login;
        
        const enrolls = document.getElementById('up-enrollments');
        enrolls.innerHTML = data.enrollments.map(e => `<li>${e.name} (${e.level})</li>`).join('') || '<li>لا يوجد</li>';

        const grades = document.getElementById('up-grades');
        grades.innerHTML = data.grades.map(g => `<li>${g.class}: نصفي(${g.midterm}), نهائي(${g.final})</li>`).join('') || '<li>لا يوجد</li>';

        const subs = document.getElementById('up-submissions');
        subs.innerHTML = data.submissions.map(s => `<li>${s.assignment} - ${s.status} (درجة: ${s.grade || '-'})</li>`).join('') || '<li>لا يوجد</li>';

        const tests = document.getElementById('up-tests');
        tests.innerHTML = data.tests.map(t => `<li>${t.test}: ${t.score}%</li>`).join('') || '<li>لا يوجد</li>';
    }

    window.editUser = function(id, type){ 
      const users = type==="students" ? studentsData : teachersData;
      const u = users.find(x=>x.id===id);
      if(!u) return;
      document.getElementById('editUserId').value = u.id;
      document.getElementById('editUserName').value = u.name;
      document.getElementById('editUserEmail').value = u.email;
      document.getElementById('editUserType').value = type === 'students' ? 'student' : 'teacher';
      // In a real app we'd map level or specialization cleanly. Setting default here.
      document.getElementById('editUserLevel').value = u.level || 'beginner';
      document.getElementById('editUserForm').action = '{{ url("/admin/user/update") }}/' + u.id;
      showModal("editUserModal");
    };
    // Helper: submit a hidden POST form (real DB operation)
    function submitPostForm(url, extraFields) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = url;
      const csrf = document.createElement('input');
      csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
      form.appendChild(csrf);
      if (extraFields) {
        Object.entries(extraFields).forEach(([k, v]) => {
          const inp = document.createElement('input');
          inp.type = 'hidden'; inp.name = k; inp.value = v;
          form.appendChild(inp);
        });
      }
      document.body.appendChild(form);
      form.submit();
    }

    window.deleteUser = function(id, type){
      if(!confirm(translations[currentLanguage].confirmDelete)) return;
      submitPostForm('{{ url("/admin/user/delete") }}/' + id);
    };

    window.viewCourse = function(id){
      const c = coursesData.find(x=>x.id===id);
      if(!c) return;
      showToast((currentLanguage==="ar"?"عرض الدورة: ":"View course: ") + c.name, "info");
    };
    window.editCourse = function(id){ 
      const c = coursesData.find(x=>x.id===id);
      if(!c) return;
      document.getElementById('editCourseId').value = c.id;
      document.getElementById('editCourseName').value = c.name;
      document.getElementById('editCourseLevel').value = c.level || 'beginner';
      document.getElementById('editCourseDuration').value = c.duration || 4;
      document.getElementById('editCourseDescription').value = c.description || '';
      document.getElementById('editCourseForm').action = '{{ url("/admin/class/update") }}/' + c.id;
      showModal("editCourseModal");
    };
    window.deleteCourse = function(id){
      if(!confirm(translations[currentLanguage].confirmDelete)) return;
      submitPostForm('{{ url("/admin/class/delete") }}/' + id);
    };

    window.editQuestion = function(id){ 
      const q = questionsData.find(x => x.id === id);
      if(!q) return;
      document.getElementById('editQuestionId').value = q.id;
      document.getElementById('editQuestionText').value = q.text;
      document.getElementById('editQuestionType').value = q.type;
      document.getElementById('editQuestionDifficulty').value = q.difficulty;
      document.getElementById('editQuestionForm').action = '{{ url("/admin/question/update") }}/' + q.id;
      showModal("editQuestionModal");
    };
    
    window.deleteQuestion = function(id){
      if(!confirm(translations[currentLanguage].confirmDelete)) return;
      submitPostForm('{{ url("/admin/question/delete") }}/' + id);
    };

    /* =========================
       Search (Simple)
    ========================== */
    function searchSystem(q){
      q = q.trim();
      if(!q) return;

      const query = q.toLowerCase();
      const hits = [];

      studentsData.forEach(s=>{
        if(s.name.toLowerCase().includes(query) || s.email.toLowerCase().includes(query)) hits.push({type:"student", id:s.id});
      });
      teachersData.forEach(t=>{
        if(t.name.toLowerCase().includes(query) || t.email.toLowerCase().includes(query)) hits.push({type:"teacher", id:t.id});
      });
      coursesData.forEach(c=>{
        if(c.name.toLowerCase().includes(query)) hits.push({type:"course", id:c.id});
      });
      questionsData.forEach(qq=>{
        if(qq.text.toLowerCase().includes(query)) hits.push({type:"question", id:qq.id});
      });

      if(!hits.length){
        showToast(currentLanguage==="ar" ? "لا توجد نتائج" : "No results", "error");
        return;
      }

      showToast((currentLanguage==="ar"?"تم العثور على ":"Found ") + hits.length, "info");

      // navigate to first relevant section
      const first = hits[0].type;
      if(first==="student" || first==="teacher") loadSection("users");
      else if(first==="course") loadSection("courses");
      else loadSection("content");
    }

    /* =========================
       Login & Init
    ========================== */
    function login(){
      const btn = document.getElementById("loginBtn");
      btn.classList.add("loading");
      document.getElementById("loginBtnIcon").innerHTML = `<span class="spinner"></span>`;

      setTimeout(()=>{
        const user = document.getElementById("username").value.trim();
        const pass = document.getElementById("password").value.trim();

        if(user==="admin" && pass==="admin123"){
          document.getElementById("loginPage").style.display="none";
          document.getElementById("dashboard").style.display="block";

          // apply chosen login settings
          applyLanguage(document.getElementById("languageSelect").value);
          applyTheme(document.getElementById("themeSelect").value);
          document.getElementById("languageSwitchTop").value = currentLanguage;

          loadNotifications();
          loadDashboard();
          showToast(translations[currentLanguage].loginSuccess, "success");
        }else{
          showToast(translations[currentLanguage].loginError, "error");
        }

        btn.classList.remove("loading");
        document.getElementById("loginBtnIcon").innerHTML = `<i class="fa-solid fa-right-to-bracket"></i>`;
      }, 450);
    }

    function setupEvents(){
      // login
      document.getElementById("loginBtn").addEventListener("click", login);
      document.getElementById("password").addEventListener("keydown",(e)=>{ if(e.key==="Enter") login(); });

      // language/theme selects in login
      document.getElementById("languageSelect").addEventListener("change",(e)=>applyLanguage(e.target.value));
      document.getElementById("themeSelect").addEventListener("change",(e)=>applyTheme(e.target.value));

      // top language switch
      document.getElementById("languageSwitchTop").addEventListener("change",(e)=>applyLanguage(e.target.value));

      // sidebar nav
      document.querySelectorAll(".nav-item[data-section]").forEach(a=>{
        a.addEventListener("click",(e)=>{
          e.preventDefault();
          loadSection(a.getAttribute("data-section"));
          if(window.innerWidth<=992) document.getElementById("sidebar").classList.remove("active");
        });
      });

      // mobile menu
      document.getElementById("mobileMenuBtn").addEventListener("click", toggleSidebar);

      // notifications
      document.getElementById("notificationBtn").addEventListener("click",(e)=>{
        e.stopPropagation();
        const p = document.getElementById("notificationPanel");
        p.style.display = (p.style.display==="block") ? "none" : "block";
      });
      document.getElementById("markAllReadBtn").addEventListener("click",(e)=>{ e.stopPropagation(); markAllRead(); });

      document.addEventListener("click",(e)=>{
        const panel = document.getElementById("notificationPanel");
        if(panel) panel.style.display = "none";
      });

      // logout
      document.getElementById("logoutBtnSidebar").addEventListener("click", logout);

      // search
      document.getElementById("searchInput").addEventListener("keydown",(e)=>{
        if(e.key==="Enter"){
          searchSystem(e.target.value);
          e.target.value="";
        }
      });

      // modals close
      document.getElementById("closeAddUserModal").addEventListener("click", ()=>hideModal("addUserModal"));
      document.getElementById("cancelAddUser").addEventListener("click", ()=>hideModal("addUserModal"));

      document.getElementById("closeAddCourseModal").addEventListener("click", ()=>hideModal("addCourseModal"));
      document.getElementById("cancelAddCourse").addEventListener("click", ()=>hideModal("addCourseModal"));

      document.getElementById("closeAddQuestionModal").addEventListener("click", ()=>hideModal("addQuestionModal"));
      document.getElementById("cancelAddQuestion").addEventListener("click", ()=>hideModal("addQuestionModal"));

      document.getElementById("closeEditQuestionModal").addEventListener("click", ()=>hideModal("editQuestionModal"));
      document.getElementById("cancelEditQuestion").addEventListener("click", ()=>hideModal("editQuestionModal"));

      // forms
      // Add User — real form submission to backend
      document.getElementById("addUserForm").addEventListener("submit",(e)=>{
        e.preventDefault();
        submitPostForm('{{ route("admin.addUser") }}', {
          full_name: document.getElementById("userName").value,
          email: document.getElementById("userEmail").value,
          role: document.getElementById("userType").value,
          level: document.getElementById("userLevel") ? document.getElementById("userLevel").value : ''
        });
      });

      // Add Course — real form submission to backend
      document.getElementById("addCourseForm").addEventListener("submit",(e)=>{
        e.preventDefault();
        submitPostForm('{{ route("admin.createClass") }}', {
          class_name: document.getElementById("courseName").value,
          level: document.getElementById("courseLevel").value,
          description: document.getElementById("courseDuration") ? document.getElementById("courseDuration").value + ' weeks' : ''
        });
      });

      // Add Question — real form submission to backend
      document.getElementById("addQuestionForm").addEventListener("submit",(e)=>{
        e.preventDefault();
        submitPostForm('{{ route("admin.addQuestion") }}', {
          question_text: document.getElementById("questionText").value,
          question_type: document.getElementById("questionType").value,
          difficulty_level: document.getElementById("questionDifficulty").value
        });
      });

      // avatar upload
      const avatar = document.getElementById("adminAvatar");
      avatar.addEventListener("click", ()=>{
        const inp = document.createElement("input");
        inp.type="file";
        inp.accept="image/*";
        inp.onchange=(ev)=>{
          const file = ev.target.files[0];
          if(!file) return;
          
          // Preview immediately
          const r = new FileReader();
          r.onload=(x)=>{
            avatar.innerHTML = `<img src="${x.target.result}" alt="Admin">`;
          };
          r.readAsDataURL(file);
          
          // Upload to server
          const formData = new FormData();
          formData.append('avatar', file);
          fetch('{{ route("avatar.upload") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
          })
          .then(res => res.json())
          .then(data => {
            if(data.success) {
              showToast(currentLanguage==="ar" ? "تم تحديث الصورة الشخصية" : "Avatar updated successfully", "success");
            } else {
              showToast(data.message || "Upload failed", "error");
            }
          })
          .catch(() => showToast("Upload failed", "error"));
        };
        inp.click();
      });

      // close sidebar if click outside on mobile
      document.addEventListener("click",(e)=>{
        const sb = document.getElementById("sidebar");
        const mb = document.getElementById("mobileMenuBtn");
        if(window.innerWidth<=992 && sb.classList.contains("active")){
          if(!sb.contains(e.target) && !mb.contains(e.target)){
            sb.classList.remove("active");
          }
        }
      });
    }

    function init(){
      // apply saved settings
      applyTheme(currentTheme);
      applyLanguage(currentLanguage);

      // sync selects
      document.getElementById("languageSelect").value = currentLanguage;
      document.getElementById("themeSelect").value = currentTheme;
      document.getElementById("languageSwitchTop").value = currentLanguage;

      // bypass JS login - rely on Laravel auth
      document.getElementById("loginPage").style.display="none";
      document.getElementById("dashboard").style.display="block";

      // set translated placeholders
      document.getElementById("brandSub").textContent = translations[currentLanguage].brandSub;
      document.getElementById("hintText").textContent = translations[currentLanguage].hintText;
      document.getElementById("searchInput").placeholder = translations[currentLanguage].searchPlaceholder;

      setupEvents();
      loadNotifications();
      loadSection(currentTab);
      
      // Real-time polling: refresh notifications every 30s
      setInterval(() => {
        fetchUnreadNotifications();
      }, 30000);
    }

    document.addEventListener("DOMContentLoaded", init);
  </script>
</body>
</html>