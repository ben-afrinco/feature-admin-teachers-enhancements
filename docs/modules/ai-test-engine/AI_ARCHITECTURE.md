# AI Multi-Model Architecture

LingoPulse utilizes a distributed AI strategy, leveraging different Large Language Models (LLMs) and providers to optimize for speed, cost, and specific skill evaluation.

## LLM Strategy Overview

The system uses three primary providers:
1. **Groq**: Used for fast generation of Reading, Writing, and Speaking test items (Llama 3 70B/8B).
2. **OpenRouter**: Specifically used for batch Listening test generation (Llama 3.3 70B).
3. **Google Gemini (Vertex AI/API)**: Primary evaluator for complex student output (Writing/Speaking) and result analysis.

---

## 1. Groq Integration (Content Generation)
Groq is selected for its extreme low latency (LPPU).
- **Service**: `generateTestsFromGroq()` in `TestController.php`.
- **Model**: `llama3-70b-8192`.
- **Primary Use**:
    - Generates 10-question Reading tests with a contextually relevant story.
    - Generates Writing prompts.
    - Generates Speaking prompts.
- **Output Format**: Enforced JSON structure to ensure the database parser can create `Question` and `Option` records without manual intervention.

---

## 2. OpenRouter Integration (Listening & Batching)
OpenRouter provides access to the latest models like Llama 3.3.
- **Service**: `generateListeningTestsFromOpenRouter()`.
- **Model**: `meta-llama/llama-3.3-70b-instruct:free`.
- **Why OpenRouter?**: It allows LingoPulse to utilize "Free Tier" models across various upstreams (like Venice or DeepInfra) while providing specific headers to identify the application.
- **Batching Logic**: Generates 3 tests in one call to avoid hitting rate limits frequently.

---

## 3. Gemini Integration (Grading & Insight)
Gemini is the "Brain" of the assessment.
- **Service**: `LandingController.php` (for results analysis) and `TestController` (for writing evaluation).
- **Models**: `gemini-1.5-flash` or `gemini-2.0-flash-lite`.
- **Functions**:
    - **Writing Evaluation**: Processes `answer_text` and provides a score + breakdown (Strengths/Weaknesses).
    - **Results Analysis**: Takes the scores from all 4 skills and writes a comprehensive report in Arabic and English for the student.

---

## Error Handling & Fallbacks

### API Failure Tiers
1. **Dynamic Generation**: If Groq or OpenRouter fails (HTTP 4xx/5xx/429), the system logs the error and triggers a "Database Fallback".
2. **Database Fallback**: The system queries the `test` table using `inRandomOrder()` for the requested skill and level.
3. **Implicit Grading**: If Gemini fails during result analysis, the system falls back to a template-based "Standard Feedback" to ensure the student doesn't see a 500 Error.

### Key Logic Location
`app/Http/Controllers/TestController.php` -> `startAI()`
- This method orchestrates the calls to both Groq and OpenRouter and manages the `dynamic_test_ids` session.
