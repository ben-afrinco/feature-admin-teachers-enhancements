<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Listening Test - LingoPulse</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body {
    margin: 0;
    background: #000c1d;
    font-family: "Poppins", sans-serif;
    color: #fff;
    overflow-x: hidden;
    min-height: 100vh;
}
.light {
    position: fixed;
    width: 650px;
    height: 650px;
    background: radial-gradient(circle, rgba(0,200,255,0.3), transparent);
    animation: moveLight 8s infinite alternate ease-in-out;
    filter: blur(80px);
    z-index: 0;
}
@keyframes moveLight { 0% {top:-100px; left:-150px;} 100% {top:70%; left:60%;} }

.top-bar {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    width: 100%;
    padding: 12px 20px;
    background: rgba(10, 20, 40, 0.85);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    backdrop-filter: blur(20px);
}
.logo-text { font-size:20px; color:#00c6ff; font-weight:700; display:flex; align-items:center; gap:10px; }
.timer { font-size: 18px; font-weight: bold; color:#00c6ff; }

.main-container { padding: 100px 20px 60px; display:flex; justify-content:center; z-index:1; }

.card {
    background: rgba(255,255,255,0.06);
    border-radius: 30px;
    padding: 40px;
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    width: 95%;
    max-width: 800px;
}

h1 { font-size:2rem; color:#fff; margin-bottom:15px; background:linear-gradient(to right,#fff,#00c6ff); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
.desc { color:#b0c4de; font-size:1rem; margin-bottom:30px; line-height:1.6; }

.audio-wrapper { background: rgba(0,0,0,0.2); padding:20px; border-radius:15px; margin-bottom:30px; }
.audio-info { display:flex; align-items:center; gap:10px; color:#00c6ff; font-weight:600; margin-bottom:10px; }

.question-card { background: rgba(255,255,255,0.08); padding:15px 20px; margin-bottom:15px; border-radius:12px; text-align:left; border:1px solid rgba(255,255,255,0.15); }
.option { display:block; padding:8px 10px; margin:5px 0; background: rgba(0,200,255,0.05); border-radius:8px; cursor:pointer; transition:0.2s; }
.option:hover { background: rgba(0,200,255,0.15); }

.btn-next { display:inline-block; background: linear-gradient(135deg,#00c6ff,#0072ff); color:#fff; padding:12px 35px; border-radius:50px; font-weight:700; text-decoration:none; margin-top:20px; transition:0.3s; }
.btn-next:hover { transform: translateY(-2px); box-shadow:0 0 15px rgba(0,198,255,0.5); }
</style>
</head>
<body>

<div class="light"></div>

<div class="top-bar">
    <a href="{{ url()->previous() }}" class="back-link" style="color:#94a3b8; text-decoration:none; display:flex; align-items:center; gap:8px;"><i class="fas fa-arrow-left"></i> Back</a>
    <div class="logo-text"><i class="fas fa-headphones-alt"></i> Listening Section</div>
    <div class="timer" id="timer">20:00</div>
</div>

<div class="main-container">
    <div class="card">
        <h1>Listening Test</h1>
        <p class="desc">Listen carefully to the audio below. Then answer the 10 questions that follow.</p>

        <div class="audio-wrapper">
            <div class="audio-info"><i class="fas fa-play-circle"></i> Official Listening Test Audio</div>
            <audio controls>
                <source src="{{ asset('audio/listening_test_1.mp3') }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>

        <!-- Questions -->
        @for($i=1;$i<=10;$i++)
        <div class="question-card" id="q{{$i}}">
            <strong>Question {{$i}}:</strong> Sample question text here.
            <div class="options">
                <label class="option"><input type="radio" name="q{{$i}}"> Option A</label>
                <label class="option"><input type="radio" name="q{{$i}}"> Option B</label>
                <label class="option"><input type="radio" name="q{{$i}}"> Option C</label>
                <label class="option"><input type="radio" name="q{{$i}}"> Option D</label>
            </div>
        </div>
        @endfor

        <a href="{{ route('test.writing') }}" class="btn-next">Submit & Go to Writing</a>
    </div>
</div>

<script>
let time = 20*60;
const timerEl = document.getElementById('timer');
setInterval(()=>{
    if(time>0){time--; const m=Math.floor(time/60); const s=time%60; timerEl.textContent=`${m}:${s<10?'0':''}${s}`;}
},1000);
</script>

</body>
</html>