# LingoPulse AI — Graduation Project (Django Migration)

This project has been fully migrated from Laravel to Django. It features a modular architecture, AI-powered English proficiency assessments, and role-based dashboards.

---

## 🚀 Getting Started

### 1. Environment Setup

```bash
python3 -m venv venv
source venv/bin/activate
pip install -r requirements.txt
```

### 2. Configuration

Create a `.env` file based on `.env.example`:
```env
APP_KEY=your-secret-key
DEBUG=True
ALLOWED_HOSTS=localhost,127.0.0.1

GROQ_API_KEY=your-groq-key
GEMINI_API_KEY=your-gemini-key
OPENROUTER_API_KEY=your-openrouter-key
OLLAMA_URL=http://localhost:11434
```

### 3. Database & Run

```bash
python manage.py migrate
python manage.py runserver
```

---

## 🏗 Modular Architecture

- **`accounts/`**: Unified user model, Student/Teacher/Admin profiles, and session-based auth.
- **`testing/`**: MCQ and AI-graded test engine (Reading, Listening, Writing, Speaking).
- **`classroom/`**: Virtual classrooms, assignments, and Jitsi-powered live sessions.
- **`ai_engine/`**: Integration layer for Ollama, Groq, Gemini, and OpenRouter.
- **`core/`**: Common middleware, shared templates, and global static assets.
