<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writing Test - LingoPulse</title>
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

        /* Moving neon light */
        .light {
            position: fixed;
            width: 650px;
            height: 650px;
            background: radial-gradient(circle, rgba(0,255,255,0.3), transparent);
            animation: moveLight 8s infinite alternate ease-in-out;
            filter: blur(80px);
            z-index: 0;
        }
        @keyframes moveLight {
            0% { top: -100px; left: -150px; }
            100% { top: 70%; left: 60%; }
        }

        /* Top Bar */
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

        .logo-text {
            font-size: 20px;
            color: #00c6ff;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .timer {
            font-size: 18px;
            font-weight: bold;
            color: #00c6ff;
            margin-right: 20px;
        }

        /* Content */
        .main-container {
            position: relative;
            z-index: 1;
            padding: 100px 20px 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 30px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 800px;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .desc {
            text-align: center;
            color: #b0c4de;
            margin-bottom: 30px;
        }

        /* Writing Box */
        .writing-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        textarea {
            width: 100%;
            height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 20px;
            color: #fff;
            font-size: 1.1rem;
            font-family: inherit;
            resize: none;
            outline: none;
            transition: 0.3s;
        }

        textarea:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00c6ff;
            box-shadow: 0 0 20px rgba(0, 198, 255, 0.2);
        }

        .word-count {
            position: absolute;
            bottom: 15px;
            right: 20px;
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Validation Message */
        .validation-msg {
            color: #ff4b2b;
            font-size: 0.9rem;
            margin-top: -15px;
            margin-bottom: 15px;
            display: none;
            text-align: left;
            padding-left: 10px;
        }

        /* Buttons */
        .btn {
            display: block;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: white;
            box-shadow: 0 10px 20px rgba(0, 114, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 198, 255, 0.5);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #0da271);
            color: white;
            margin-top: 15px;
            display: none;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .back-link:hover {
            color: #fff;
        }

    </style>
</head>
<body>
    <div class="light"></div>

    <div class="top-bar">
        <a href="{{ url()->previous() }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div class="logo-text">
            <i class="fas fa-pen-nib"></i> Writing Section
        </div>
        <div class="timer" id="timer">40:00</div>
    </div>

    <div class="main-container">
        <div class="card">
            <h1>Writing Task</h1>
            <p class="desc">Write a short paragraph (120–250 words) about your career goals in English only.</p>
            
            <div class="writing-wrapper">
                <textarea id="writingText" placeholder="Start typing your response here..." oninput="validateInput()"></textarea>
                <div class="word-count" id="wordCountCounter">Words: 0</div>
            </div>
            
            <div id="englishOnlyMsg" class="validation-msg">
                <i class="fas fa-exclamation-circle"></i> Only English characters are allowed. Please remove non-English text.
            </div>

            <button id="saveBtn" class="btn btn-primary" onclick="submitWriting()">
                Save Response <i class="fas fa-save" style="margin-left: 10px;"></i>
            </button>

            <a id="nextBtn" href="{{ route('test.speaking') }}" class="btn btn-success">
                Continue to Speaking Test <i class="fas fa-chevron-right" style="margin-left: 10px;"></i>
            </a>
        </div>
    </div>

    <script>
        // Countdown Timer
        let time = 35 * 60;
        const timerEl = document.getElementById('timer');
        timerEl.textContent = "35:00";
        
        setInterval(() => {
            if (time > 0) {
                time--;
                const mins = Math.floor(time / 60);
                const secs = time % 60;
                timerEl.textContent = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
            }
        }, 1000);

        // English Only Validation
        function validateInput() {
            const textarea = document.getElementById("writingText");
            const msg = document.getElementById("englishOnlyMsg");
            const saveBtn = document.getElementById("saveBtn");
            const val = textarea.value;
            
            // Regex to detect Arabic characters
            const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
            
            if (arabicRegex.test(val)) {
                msg.style.display = "block";
                saveBtn.disabled = true;
                saveBtn.style.opacity = "0.5";
            } else {
                msg.style.display = "none";
                saveBtn.disabled = false;
                saveBtn.style.opacity = "1";
            }

            // Word count
            const words = val.trim() ? val.trim().split(/\s+/).length : 0;
            document.getElementById("wordCountCounter").textContent = "Words: " + words;
        }

        function submitWriting() {
            const textarea = document.getElementById("writingText");
            const text = textarea.value.trim();
            
            if (text.length === 0) {
                alert("Please write your response before saving.");
                return;
            }

            const saveBtn = document.getElementById("saveBtn");
            const nextBtn = document.getElementById("nextBtn");

            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving & Evaluating with AI...';
            saveBtn.disabled = true;

            fetch("{{ route('writing.submit') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ essay: text })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    saveBtn.style.display = "none";
                    nextBtn.style.display = "block";
                    nextBtn.href = data.redirect;
                } else {
                    alert(data.message || "فشل التقييم. حاول مرة أخرى.");
                    saveBtn.innerHTML = 'Save Response <i class="fas fa-save" style="margin-left: 10px;"></i>';
                    saveBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error("Submission failed:", error);
                alert("حدث خطأ في الاتصال. الرجاء المحاولة لاحقاً.");
                saveBtn.innerHTML = 'Save Response <i class="fas fa-save" style="margin-left: 10px;"></i>';
                saveBtn.disabled = false;
            });
        }
    </script>
</body>
</html>
