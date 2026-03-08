# AI Reading Test Detail

The Reading module assesses comprehension through passages and adaptive question sets.

## 📖 Component Overview
- **Static**: Loads from `Test` where `skill = 'reading'`.
- **Dynamic**: Generated via Groq (Llama-3.1).
- **View**: `resources/views/dynamicReading.blade.php`.

## 🔄 Interaction Flow
1.  **Loading**: The passage is displayed on the left, questions on the right.
2.  **Submission**: Student selects options for 10 questions.
3.  **Persistence**: Logic in `TestController@submitReading` collects responses in session or DB.
4.  **Grading**: Score = `(Correct / Total) * 100`.

## 🤖 AI Prompt Logic
The AI is instructed to generate balanced stories (100-150 words) suitable for beginners. 
Questions must be:
- Fact-based (directly from text).
- Inference-based (contextual understanding).
- Vocabulary-based.

## ⚠️ Edge Cases
- **Refresh**: Middle-of-test refresh is handled by session persistence.
- **Empty Answers**: Unselected questions are treated as incorrect.

---
Next: [Listening Test Detail](LISTENING.md)
