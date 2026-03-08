<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Option;
use App\Models\Teacher;
use App\Models\Classes;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    /**
     * Store a manually created quiz.
     */
    public function store(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,class_id',
            'level' => 'required|string',
            'skill' => 'required|string',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string|in:multiple-choice,true-false,fill-blank',
            'questions.*.options' => 'required|array',
            'questions.*.correct_option' => 'required|string',
        ]);

        $teacher = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacher) {
            return redirect()->back()->with('error', 'غير مصرح لك.');
        }

        try {
            \DB::beginTransaction();

            $test = Test::create([
                'test_name' => $request->test_name,
                'level' => $request->level,
                'skill' => $request->skill,
                'teacher_id' => $teacher->teacher_id,
                'class_id' => $request->class_id,
                'content' => $request->content ?? null,
            ]);

            foreach ($request->questions as $qData) {
                $question = Question::create([
                    'test_id' => $test->test_id,
                    'question_text' => $qData['text'],
                    'question_type' => $qData['type'],
                    'difficulty_level' => $request->level,
                ]);

                foreach ($qData['options'] as $index => $optText) {
                    // correct_option could be passed as the index (e.g. "0")
                    $isCorrect = ($qData['correct_option'] == $index) ? 1 : 0;
                    Option::create([
                        'question_id' => $question->question_id,
                        'optione_text' => $optText,
                        'is_correct' => $isCorrect,
                    ]);
                }
            }

            \DB::commit();
            return redirect()->back()->with('success', 'تم إنشاء الاختبار بنجاح.');
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Quiz Creation Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ الاختبار.');
        }
    }

    /**
     * Generate a quiz automatically using Gemini AI and directly save it.
     */
    public function generateAI(Request $request)
    {
        $request->validate([
            'topic' => 'required|string',
            'level' => 'required|string',
            'question_count' => 'required|integer|min:1|max:20',
            'class_id' => 'required|exists:classes,class_id',
        ]);

        $teacher = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacher) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك.']);
        }

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['success' => false, 'message' => 'Gemini API keys missing.']);
        }

        $prompt = "You are an expert English language teacher. Generate a quiz on the topic: '{$request->topic}'. 
The difficulty level is '{$request->level}'. 
Please generate exactly {$request->question_count} multiple-choice questions.

Respond ONLY with a valid JSON object matching the following structure exactly (NO markdown code blocks, NO extra text):

{
  \"test_name\": \"A suitable title for the quiz\",
  \"skill\": \"grammar\",
  \"questions\": [
    {
      \"text\": \"Question text here\",
      \"type\": \"multiple-choice\",
      \"options\": [\"Option A\", \"Option B\", \"Option C\", \"Option D\"],
      \"correct_option_index\": 0
    }
  ]
}";

        try {
            $client = \Gemini::client($apiKey);
            $response = $client->generativeModel('gemini-1.5-flash')->generateContent($prompt);
            $raw = trim($response->text());

            $jsonString = preg_replace('/^```(?:json)?\s*/i', '', $raw);
            $jsonString = preg_replace('/\s*```$/i', '', $jsonString);
            $jsonString = trim($jsonString);

            $result = json_decode($jsonString, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($result['questions'])) {
                return response()->json(['success' => false, 'message' => 'Failed to parse AI output. Try again.']);
            }

            \DB::beginTransaction();

            $test = Test::create([
                'test_name' => collect([$result['test_name'] ?? 'AI Quiz: ' . $request->topic, 255])->first(),
                'level' => $request->level,
                'skill' => $result['skill'] ?? 'reading',
                'teacher_id' => $teacher->teacher_id,
                'class_id' => $request->class_id,
                'content' => 'Generated by AI on topic: ' . $request->topic,
            ]);

            foreach ($result['questions'] as $qData) {
                $question = Question::create([
                    'test_id' => $test->test_id,
                    'question_text' => collect([$qData['text'], 255])->first(),
                    'question_type' => 'multiple-choice',
                    'difficulty_level' => strtolower($request->level),
                ]);

                foreach ($qData['options'] as $index => $optText) {
                    $isCorrect = (isset($qData['correct_option_index']) && $qData['correct_option_index'] == $index) ? 1 : 0;
                    if (!isset($qData['correct_option_index']) && $index === 0) {
                        // Fallback if missing
                        $isCorrect = 1; 
                    }
                    Option::create([
                        'question_id' => $question->question_id,
                        'optione_text' => $optText,
                        'is_correct' => $isCorrect,
                    ]);
                }
            }

            \DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'تم استخراج وحفظ الاختبار بالذكاء الاصطناعي بنجاح.',
                'test_id' => $test->test_id
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('AI Quiz Generation Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a quiz (teacher only)
     */
    public function destroy($id)
    {
        $teacher = Teacher::where('user_id', session('user_id'))->first();
        $test = Test::where('test_id', $id)->where('teacher_id', $teacher->teacher_id ?? -1)->first();

        if (!$test) {
            return redirect()->back()->with('error', 'الاختبار غير موجود أو غير مصرح لك بحذفه.');
        }

        // The options and answers should ideally cascade delete, but let's manual delete to be safe if no cascade setup
        $questionIds = $test->questions()->pluck('question_id');
        Option::whereIn('question_id', $questionIds)->delete();
        \App\Models\DentAnswer::whereIn('question_id', $questionIds)->delete();
        $test->questions()->delete();
        $test->results()->delete();
        $test->delete();

        return redirect()->back()->with('success', 'تم حذف الاختبار بنجاح.');
    }
}
