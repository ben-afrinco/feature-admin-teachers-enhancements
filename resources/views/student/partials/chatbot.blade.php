<style>
/* Chatbot Widget Styles */
.chatbot-widget {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 9999;
    direction: ltr; /* Set LTR for widget positioning */
}

/* Ensure inner content respects current language direction */
[lang="ar"] .chatbot-widget {
    left: auto;
    right: 20px;
    direction: rtl;
}

.chatbot-btn {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--neon-blue), var(--ai-purple));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.8rem;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(0, 198, 255, 0.4);
    transition: transform 0.3s, box-shadow 0.3s;
    border: none;
    outline: none;
}
.chatbot-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 15px 35px rgba(168, 85, 247, 0.5);
}

.chatbot-window {
    position: absolute;
    bottom: 75px;
    left: 0;
    width: 350px;
    max-width: calc(100vw - 40px);
    height: 500px;
    max-height: calc(100vh - 100px);
    background: rgba(10, 15, 30, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(0, 198, 255, 0.3);
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    opacity: 0;
    pointer-events: none;
    transform: translateY(20px);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Respect RTL inside window if ar */
[lang="ar"] .chatbot-window {
    left: auto;
    right: 0;
}

.chatbot-window.active {
    opacity: 1;
    pointer-events: all;
    transform: translateY(0);
}

.chat-header {
    background: linear-gradient(90deg, rgba(0, 198, 255, 0.15), rgba(168, 85, 247, 0.15));
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 800;
    color: #fff;
}
.chat-title i {
    color: var(--neon-blue);
    font-size: 1.2rem;
}
.chat-close {
    background: none;
    border: none;
    color: #aaa;
    font-size: 1.2rem;
    cursor: pointer;
    transition: 0.2s;
}
.chat-close:hover {
    color: var(--danger-red);
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.chat-messages::-webkit-scrollbar { width: 6px; }
.chat-messages::-webkit-scrollbar-track { background: transparent; }
.chat-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

.chat-msg {
    max-width: 85%;
    padding: 12px 16px;
    border-radius: 15px;
    font-size: 0.95rem;
    line-height: 1.5;
    word-break: break-word;
    white-space: pre-wrap;
    animation: fadeInMsg 0.3s ease-out forwards;
}
@keyframes fadeInMsg {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.msg-user {
    align-self: flex-end;
    background: linear-gradient(135deg, var(--neon-blue), #0072ff);
    color: #fff;
    border-bottom-right-radius: 4px;
}

[lang="ar"] .msg-user {
    align-self: flex-start;
    border-bottom-right-radius: 15px;
    border-bottom-left-radius: 4px;
}

.msg-bot {
    align-self: flex-start;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255,255,255,0.05);
    color: #e0e0e0;
    border-bottom-left-radius: 4px;
}

[lang="ar"] .msg-bot {
    align-self: flex-end;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 4px;
}

.chat-input-area {
    padding: 15px;
    border-top: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.2);
    display: flex;
    gap: 10px;
}
.chat-input {
    flex: 1;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 10px 15px;
    color: #fff;
    font-family: inherit;
    font-size: 0.95rem;
    outline: none;
    transition: 0.3s;
}
.chat-input:focus {
    border-color: var(--neon-blue);
    background: rgba(255,255,255,0.1);
}
.chat-send {
    background: var(--neon-blue);
    color: #000;
    border: none;
    border-radius: 50%;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s;
    font-size: 1.1rem;
}
.chat-send:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0,198,255,0.5);
}
.chat-send:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}
.typing-indicator {
    display: none;
    align-self: flex-start;
    color: #aaa;
    font-size: 0.85rem;
    font-style: italic;
    padding: 0 10px;
    margin-bottom: 10px;
}
[lang="ar"] .typing-indicator { align-self: flex-end; }
</style>

<div class="chatbot-widget">
    <button class="chatbot-btn" id="chatbotToggleBtn" onclick="toggleChatbot()">
        <i class="fas fa-comment-dots"></i>
    </button>
    
    <div class="chatbot-window" id="chatbotWindow">
        <div class="chat-header">
            <div class="chat-title">
                <i class="fas fa-robot"></i>
                <span id="chatTitleText">AI Assistant</span>
            </div>
            <button class="chat-close" onclick="toggleChatbot()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="chat-msg msg-bot" id="chatInitialMsg">
                مرحباً! أنا مساعدك الذكي من LingoPulse. كيف يمكنني مساعدتك اليوم؟
            </div>
        </div>
        <div class="typing-indicator" id="chatTypingIndicator">
            Assistant is typing...
        </div>
        
        <div class="chat-input-area">
            <input type="text" class="chat-input" id="chatInput" placeholder="Type a message..." onkeypress="handleChatKeyPress(event)" autocomplete="off">
            <button class="chat-send" id="chatSendBtn" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
let chatInitialized = false;

function toggleChatbot() {
    const windowEl = document.getElementById('chatbotWindow');
    const btn = document.getElementById('chatbotToggleBtn');
    
    if (windowEl.classList.contains('active')) {
        windowEl.classList.remove('active');
        btn.innerHTML = '<i class="fas fa-comment-dots"></i>';
    } else {
        windowEl.classList.add('active');
        btn.innerHTML = '<i class="fas fa-times"></i>';
        
        if (!chatInitialized) {
            loadChatHistory();
            chatInitialized = true;
        }
        
        setTimeout(() => document.getElementById('chatInput').focus(), 300);
    }
}

function updateChatbotLanguage() {
    const docLang = document.documentElement.lang || 'ar';
    const isAr = (typeof lang !== 'undefined' ? lang : docLang) === 'ar';
    
    document.getElementById('chatTitleText').innerText = isAr ? 'المساعد الذكي' : 'AI Assistant';
    document.getElementById('chatInput').placeholder = isAr ? 'اكتب رسالتك هنا...' : 'Type a message...';
    document.getElementById('chatTypingIndicator').innerText = isAr ? 'المساعد يكتب...' : 'Assistant is typing...';
    document.getElementById('chatInitialMsg').innerText = isAr ? 'مرحباً! أنا مساعدك الذكي من LingoPulse. كيف يمكنني مساعدتك اليوم؟' : 'Hello! I am your AI assistant from LingoPulse. How can I help you today?';
}

function appendMessage(role, content) {
    const messagesContainer = document.getElementById('chatMessages');
    const msgDiv = document.createElement('div');
    msgDiv.className = `chat-msg ${role === 'user' ? 'msg-user' : 'msg-bot'}`;
    
    msgDiv.textContent = content; 
    
    messagesContainer.appendChild(msgDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function loadChatHistory() {
    updateChatbotLanguage();
    fetch('{{ route("chatbot.history") }}')
        .then(res => res.json())
        .then(data => {
            if(data.success && data.history.length > 0) {
                data.history.forEach(msg => {
                    appendMessage(msg.role, msg.content);
                });
            }
        })
        .catch(err => console.error('Failed to load chat history', err));
}

function handleChatKeyPress(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
}

function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    if (!message) return;
    
    appendMessage('user', message);
    input.value = '';
    
    const sendBtn = document.getElementById('chatSendBtn');
    const typingIndicator = document.getElementById('chatTypingIndicator');
    const messagesContainer = document.getElementById('chatMessages');
    
    sendBtn.disabled = true;
    typingIndicator.style.display = 'block';
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    
    fetch('{{ route("chatbot.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: message })
    })
    .then(res => res.json())
    .then(data => {
        sendBtn.disabled = false;
        typingIndicator.style.display = 'none';
        
        if(data.success) {
            appendMessage('model', data.reply);
        } else {
            appendMessage('model', data.message || 'Error occurred.');
        }
    })
    .catch(err => {
        console.error(err);
        sendBtn.disabled = false;
        typingIndicator.style.display = 'none';
        const docLang = document.documentElement.lang || 'ar';
        const isAr = (typeof lang !== 'undefined' ? lang : docLang) === 'ar';
        appendMessage('model', isAr ? 'عذراً، حدث خطأ في الاتصال بالشبكة.' : 'Network error. Please try again later.');
    });
}

// Check language updates periodically
setInterval(() => {
    if(chatInitialized) updateChatbotLanguage();
}, 2000);
</script>
