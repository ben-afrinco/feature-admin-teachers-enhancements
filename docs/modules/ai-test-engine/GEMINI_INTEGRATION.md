# Gemini API Integration

The core evaluation feature of LingoPulse is powered by Google's Gemini Models via the native `gemini-laravel` package. The integration exists primarily in two places:
1. Real-time assessment during test answers (`TestController`).
2. Post-test aggregate analysis for the Student Results Page (`LandingController`).

## Test Answers Evaluation (`TestController`)
For open-ended inputs (e.g., Writing or Speaking transcripts), the controller forwards the student's text to Gemini alongside a specific grading rubric.
- **Model Target**: The system defaults to `gemini-2.0-flash-lite`, with a graceful fallback to `gemini-2.0-flash`.
- **Response Format**: Strictly enforced JSON payload containing `{ "score": 85, "feedback": "..." }`.

## Student Results Analysis (`LandingController::getGeminiAnalysis`)
When a student finishes all assignments, their overall scores (Reading, Writing, Listening, Speaking) are passed to the AI to construct actionable, bilingual feedback.

- **Inputs**: Integers ranging from 0-100 indicating performance percentages.
- **AI Prompt**: Acts as an "expert English language assessment analyst."
- **Expected Outputs (Bilingual JSON)**:
  - `strengths_ar` / `strengths_en` (Top performing skills/areas)
  - `weaknesses_ar` / `weaknesses_en` (Skills below 50% requiring focus)
  - `advice_ar` / `advice_en` (An actionable paragraph suggesting resources and next steps)

### Fallback Mechanisms
To prevent server 500 crashes during Rate Limiting (429) or API Key Configuration issues:
- Requests use `try-catch` blocks and loop through models.
- If all models fail, a **static array** with fallback values (e.g., empty arrays or standard text responses) is returned, and the UI adapts automatically rather than crashing.
- Results Analysis strings are cached in the Laravel session with an md5 hash of the score arrays to reduce token consumption significantly.
