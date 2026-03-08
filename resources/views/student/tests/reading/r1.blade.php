<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Advanced Reading Exam</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#0b132b;
    color:white;
    user-select:none;
}

.container{
    display:flex;
    height:100vh;
}

/* Passage */
.passage{
    width:50%;
    padding:40px;
    overflow-y:auto;
    border-right:1px solid rgba(255,255,255,0.1);
    line-height:1.8;
}

/* Questions */
.questions{
    width:50%;
    padding:40px;
    overflow-y:auto;
}

h2{margin-top:0;}

.question{
    margin-bottom:20px;
    padding:15px;
    background:rgba(255,255,255,0.05);
    border-radius:8px;
}

/* Button */
button{
    padding:12px 25px;
    background:#00c896;
    border:none;
    border-radius:6px;
    color:white;
    cursor:pointer;
    margin-top:20px;
    font-size:16px;
}

button:hover{background:#00a57c;}

/* TIMER */
#timer{
    position:fixed;
    top:25px;
    right:25px;
    background:linear-gradient(135deg,#00c896,#007f5f);
    padding:12px 22px;
    border-radius:50px;
    font-weight:bold;
    font-size:18px;
    z-index:10000;
    box-shadow:0 4px 15px rgba(0,0,0,0.4);
}

/* Warning Modal */
.modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.8);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-content{
    background:#1c2541;
    padding:40px;
    border-radius:12px;
    text-align:center;
    width:90%;
    max-width:400px;
}

.modal-content h2{color:#ff4d4d;}

.modal-content button{
    background:#ff4d4d;
}

/* Responsive */
@media(max-width:900px){
    .container{flex-direction:column;}
    .passage,.questions{
        width:100%;
        height:50vh;
    }
}
</style>
</head>

<body oncontextmenu="return false;">

<div id="timer">30:00</div>

<div class="container">

<div class="passage">
<h2>Reading Passage</h2>

<p>
Throughout the early decades of the twenty-first century, artificial intelligence (AI) evolved from a largely theoretical discipline into a transformative force embedded within global infrastructure. Initially confined to narrowly defined computational tasks, AI systems were constrained by rigid programming structures that limited adaptability. However, the advent of machine learning—particularly deep neural networks—enabled systems to process immense volumes of structured and unstructured data. This capacity for autonomous pattern recognition revolutionized fields ranging from predictive analytics in finance to diagnostic imaging in medicine.
</p>

<p>
Yet, the exponential growth of AI technologies has not been without controversy. Ethical dilemmas have emerged as algorithms increasingly influence decisions once reserved for human judgment. Critics argue that algorithmic opacity—often referred to as the “black box” problem—undermines accountability and transparency. Moreover, AI systems trained on historically biased datasets risk perpetuating systemic inequalities. Instances of discriminatory hiring algorithms and predictive policing software illustrate how technological neutrality can be illusory when underlying data reflect social prejudices.
</p>

<p>
Despite these challenges, proponents maintain that AI possesses unparalleled potential to augment human capabilities rather than supplant them. By enhancing analytical precision and optimizing resource allocation, AI-driven systems can accelerate scientific discovery and improve responses to global crises such as climate change and pandemics. The fundamental question, therefore, is not whether AI should advance, but how societies can construct regulatory frameworks that ensure innovation aligns with ethical responsibility, inclusivity, and sustainable development.
</p>

</div>

<div class="questions">
<h2>Questions</h2>

<form id="quizForm">

<div class="question">
1. What is the central theme of the passage?<br>
<input type="radio" name="q1"> AI should be banned globally<br>
<input type="radio" name="q1"> The evolution of AI and its ethical implications<br>
<input type="radio" name="q1"> Financial technology only<br>
<input type="radio" name="q1"> Climate policy reforms<br>
</div>

<div class="question">
2. The word “supplant” most nearly means:<br>
<input type="radio" name="q2"> Support<br>
<input type="radio" name="q2"> Replace<br>
<input type="radio" name="q2"> Observe<br>
<input type="radio" name="q2"> Protect<br>
</div>

<div class="question">
3. The “black box” problem refers to:<br>
<input type="radio" name="q3"> Hardware malfunction<br>
<input type="radio" name="q3"> Lack of transparency in algorithms<br>
<input type="radio" name="q3"> Financial fraud<br>
<input type="radio" name="q3"> Climate data errors<br>
</div>

<div class="question">
4. According to the passage, biased datasets may:<br>
<input type="radio" name="q4"> Improve fairness<br>
<input type="radio" name="q4"> Reinforce social inequalities<br>
<input type="radio" name="q4"> Increase transparency<br>
<input type="radio" name="q4"> Reduce automation<br>
</div>

<div class="question">
5. The author’s tone is best described as:<br>
<input type="radio" name="q5"> Balanced and analytical<br>
<input type="radio" name="q5"> Emotional and critical<br>
<input type="radio" name="q5"> Humorous<br>
<input type="radio" name="q5"> Completely negative<br>
</div>

<div class="question">
6. Which field is mentioned as benefiting from AI?<br>
<input type="radio" name="q6"> Medicine<br>
<input type="radio" name="q6"> Agriculture only<br>
<input type="radio" name="q6"> Tourism only<br>
<input type="radio" name="q6"> Literature only<br>
</div>

<div class="question">
7. The passage implies that AI is:<br>
<input type="radio" name="q7"> Entirely harmful<br>
<input type="radio" name="q7"> Neutral without impact<br>
<input type="radio" name="q7"> Powerful but requires regulation<br>
<input type="radio" name="q7"> Irrelevant<br>
</div>

<div class="question">
8. “Augment” suggests:<br>
<input type="radio" name="q8"> Replace completely<br>
<input type="radio" name="q8"> Enhance or improve<br>
<input type="radio" name="q8"> Destroy<br>
<input type="radio" name="q8"> Delay<br>
</div>

<div class="question">
9. The main challenge discussed is:<br>
<input type="radio" name="q9"> Programming speed<br>
<input type="radio" name="q9"> Ethical governance of AI<br>
<input type="radio" name="q9"> Marketing AI products<br>
<input type="radio" name="q9"> Reducing hardware cost<br>
</div>

<div class="question">
10. The author would most likely agree that AI development should:<br>
<input type="radio" name="q10"> Continue without regulation<br>
<input type="radio" name="q10"> Be aligned with ethical responsibility<br>
<input type="radio" name="q10"> Stop immediately<br>
<input type="radio" name="q10"> Be limited to finance only<br>
</div>

<!-- Next button uses Laravel route -->
<button type="button" onclick="checkBeforeNext('{{ route('reading.done') }}')">Next</button>

</form>
</div>
</div>

<div id="warningBox" class="modal">
<div class="modal-content">
<h2>⚠ Warning</h2>
<p>You must answer all questions before proceeding.</p>
<button onclick="closeWarning()">OK</button>
</div>
</div>

<script>

/* منع النسخ */
document.addEventListener("copy", e => e.preventDefault());
document.addEventListener("selectstart", e => e.preventDefault());

/* منع الرجوع */
history.pushState(null, null, location.href);
window.onpopstate = function () { history.go(1); };

/* منع إعادة التحميل */
window.onbeforeunload = function() {
    return "You cannot reload this page.";
};

/* TIMER */
let time = 30 * 60;
let timerElement = document.getElementById("timer");

let countdown = setInterval(function(){
    let minutes = Math.floor(time / 60);
    let seconds = time % 60;
    seconds = seconds < 10 ? "0" + seconds : seconds;
    timerElement.innerHTML = minutes + ":" + seconds;

    if(time <= 300){
        timerElement.style.background = "linear-gradient(135deg,#ff4d4d,#b30000)";
    }

    if(time <= 0){
        clearInterval(countdown);
        alert("Time is up!");
        window.location.href = "{{ route('reading.done') }}";
    }

    time--;
},1000);

function checkBeforeNext(url){
    let total = 10;
    let answered = 0;

    for(let i=1;i<=total;i++){
        let radios = document.getElementsByName("q"+i);
        for(let r of radios){
            if(r.checked){ answered++; break; }
        }
    }

    if(answered < total){
        document.getElementById("warningBox").style.display = "flex";
        return;
    }

    window.location.href = url;
}

function closeWarning(){
    document.getElementById("warningBox").style.display = "none";
}

</script>

</body>
</html>