# AI Test Engine: Detailed Overview

The AI Test Engine is the centerpiece of LingoPulse, providing real-time, dynamic English proficiency assessments.

## 🧩 Structure of an Assessment
Each assessment covers four core language skills:
1.  **Reading**: Reading comprehension passages with MCQs.
2.  **Listening**: Audio-based comprehension with MCQs.
3.  **Writing**: Essay or paragraph response to a prompt.
4.  **Speaking**: Reading aloud a passage for fluency and pronunciation scoring.

## 🔄 The Generation Flow

### 1. Static vs. Dynamic
- **Static**: Pre-defined tests stored in the question bank.
- **Dynamic**: Real-time generation using LLMs when a student starts a new "AI Test".

### 2. Multi-Model Generation Strategy
LingoPulse uses a distributed AI strategy to ensure reliability and quality:
- **Groq (Llama-3.1-8b)**: Generates Reading passages, Writing topics, and Speaking passages. Chosen for high speed and strict JSON compliance.
- **OpenRouter (Llama-3.3-70b)**: Generates Listening scripts and questions.
- **Google Translate TTS API**: Automatically converts Listening scripts into high-quality audio files stored on the server.

## 📝 Assessment Logic

### MCQ Skills (Reading & Listening)
- **Grading**: Handled by `gradeAndSaveResult`. Compares user's selected `optione_text` with the `is_correct` flag in the `options` table.
- **Storage**: Individual answers stored in `dent_answers`.

### Writing Assessment (AI-Powered)
- **Engine**: Google Gemini 1.5.
- **Flow**: User submits text -> Gemini evaluates based on grammar, vocabulary, coherence, and task completion -> 0-100 score + personalized feedback generated.

### Speaking Assessment (Phonetic Accuracy)
- **Engine**: Browser Web Speech API (Transcription) + Levenshtein distance (for accuracy).
- **Flow**: User speaks -> Transcription compared to target passage -> Accuracy percentage calculated -> Result saved.

## 📉 Results Persistence
Final scores are normalized to a 100-point scale and stored in the `results` table, enabling the skill breakdown visualization in the results dashboard.

---
Next: [Assignments & Submissions](assignments/OVERVIEW.md)
