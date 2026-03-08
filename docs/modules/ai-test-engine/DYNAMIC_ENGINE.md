# Dynamic Test Engine

The Dynamic Test Engine is the core mechanism of LingoPulse that allows for infinite, personalized English tests. It manages AI generation, persistent storage, and graceful fallback.

## 1. Generation Lifecycle

When a student clicks "Generate My Test", the following sequence occurs:

1. **`startAI(Request $request)` Trigger**:
    - The system clears previous dynamic session data.
    - It triggers `generateTestsFromGroq()` (Reading/Writing/Speaking).
    - It triggers `generateListeningTestsFromOpenRouter()`.
2. **Batching**:
    - For Listening, the AI generates 3 tests per request to optimize API usage.
3. **Session Anchoring**:
    - Successful test IDs are stored in `session('dynamic_test_ids')`. 
    - This "anchors" the specific test to the student for the duration of the exam.
4. **Readiness Check**:
    - `session('dynamic_tests_ready')` is set to `true`.

---

## 2. Persistent Question Bank

Unlike standard "on-the-fly" generators, LingoPulse treats every AI generation as a permanent contribution to the system's content bank.

- **Storage Method**: `Test::create()`, `Question::create()`, and `Option::create()`.
- **Media Pathing**: Audio generated via TTS is saved to local storage, and the path is registered in the `test.content` column.
- **Benefit**: Over time, the system becomes self-sufficient. Every test generated for one student exists forever and can be served to future students via the fallback mechanism.

---

## 3. Fallback Mechanism (The "No-Fail" Policy)

To ensure student exams are never interrupted by external API limits (Groq Rate Limits or OpenRouter/Gemini downtimes), the engine implements a tiered fallback:

### Tier 1: Real-Time AI
The system attempts to call the AI providers. If successful, IDs are collected.

### Tier 2: Targeted Fallback
If an API call fails or returns invalid/null content:
- The system catches the exception/error.
- It queries the `test` table: `Test::where('skill', $skill)->where('level', $level)->inRandomOrder()->first()`.
- This ensures that a student ALWAYS receives a valid test, even if the AI is offline.

### Tier 3: Static Fallback
In extremely rare cases where a specific level/skill has zero entries in the DB, the system points to the static hardcoded Blade views.

---

## 4. Grading Dynamic Tests

Grading is uniquely handled for dynamic tests via ID-based identification:

- **MCQ Grading**: The system fetches the `Option` records matching the IDs submitted by the student and compares `is_correct`.
- **AI Evaluation**: For Writing, the text is sent to Gemini alongside a performance rubric.
- **Routing**: Routes in `web.php` use a closure to check if a dynamic ID exists in the session. If it does, the `dynamicListening` or `dynamicReading` view is served using the `test_id` as a reference.
