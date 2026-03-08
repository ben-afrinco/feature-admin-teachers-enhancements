# AI Writing Test Detail

The Writing module uses state-of-the-art Generative AI to provide qualitative feedback that exceeds traditional binary grading.

## ✍️ Component Overview
- **View**: `resources/views/dynamicWriting.blade.php`.
- **Primary AI**: Gemini 1.5-Flash.
- **Evaluation**: `TestController@evaluateWithGemini`.

## 🔄 Evaluation Rubric
Gemini is prompted to grade based on:
1.  **Grammar (30%)**: Tense usage, subject-verb agreement.
2.  **Vocabulary (25%)**: Range and appropriateness of words.
3.  **Coherence (25%)**: Logic flow and connector usage.
4.  **Task Completion (20%)**: Did the student stay on topic?

## 📊 Result Structure
The response is parsed from JSON:
```json
{
  "score": 85,
  "feedback": "Excellent task completion. Your grammar is strong, but try to use more varied adjectives to improve your vocabulary score."
}
```

## ⚠️ Fallbacks
If Gemini API fails, the system provides a "Mock 50" score with a message that the teacher will review the work manually.

---
Next: [Speaking Test Detail](SPEAKING.md)
