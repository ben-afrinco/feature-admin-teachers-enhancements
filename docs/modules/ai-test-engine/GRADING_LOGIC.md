# Grading Logic and AI Rubrics

This document details how LingoPulse evaluates student performance, from automatic MCQ checking to complex AI-driven linguistic analysis.

## 1. Automated Grading (Reading & Listening)

For objective questions (Multiple Choice), the system uses a direct comparison method.

- **Logic**: 
    - The student's `option_id` is compared against the `is_correct` boolean in the `options` table.
    - **Session Handling**: Answers are stored in `session('reading_answers')` or `session('listening_answers')` as an array before the final submission to the `result` table.
- **Score Calculation**: 
    - `(Number of Correct Answers / Total Questions) * 100`.
    - This provides a percentage-based `final_score` saved in the `result` table.

---

## 2. AI Evaluation (Writing)

Writing tasks are graded using Google Gemini. The system sends the student's text to the AI with a specific evaluation prompt.

### The Rubric
The AI is instructed to grade based on the following criteria (CEFR Aligned):
1. **Grammar and Syntax**: Accuracy of sentence structures.
2. **Vocabulary Range**: Use of appropriate and varied words.
3. **Task Completion**: How well the student addressed the prompt.
4. **Coherence**: Logical flow and organization.

### Feedback Structure
The response from Gemini is parsed into:
- **`ai_score`**: A numeric value (0-100).
- **`ai_feedback`**: A structured text including:
    - **Strengths**: What the student did well.
    - **Weaknesses**: Areas of grammar/spelling that need work.
    - **Improvement Tips**: Specific advice to reach the next level.

---

## 3. Results Analysis (The Final Report)

After completing all four skills, the `LandingController::results()` method aggregates the data to create a high-level summary.

- **Aggregation**: It pulls the last `result` record for each of the four skills.
- **Gemini Insight**: 
    - The AI receives all four scores simultaneously.
    - It writes a "Professional Recommendation" summarizing the overall level.
    - **Language**: The feedback is provided in both **Arabic** and **English** to ensure the student understands the technical feedback fully.

## 4. Teacher Override

Teachers have the ability to view these AI-generated scores and feedback in their dashboard. 
- **Validation**: Teachers can review the `ai_evaluations` records and use them to inform their own grading or feedback to the student within the classroom context.
