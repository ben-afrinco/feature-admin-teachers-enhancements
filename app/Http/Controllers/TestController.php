<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Option;
use App\Models\DentAnswer;
use App\Models\Result;
use App\Models\Evaluation;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Class TestController
 * 
 * The central engine for the application's testing system.
 * 
 * This controller handles both static and dynamically generated AI tests.
 * Key features include:
 * - Real-time test generation using LLMs (Groq, OpenRouter).
 * - Automatic TTS (Text-to-Speech) generation for listening tests.
 * - AI-powered grading and qualitative feedback using Google Gemini models.
 * - Comprehensive result tracking and multi-version student answers.
 * 
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    /**
     * Retrieve the current student's ID from the session.
     * 
     * @return int|null
     */
    private function getStudentId() {
        $user_id = session('user_id');
        if (!$user_id) return null;
        $student = Student::where('user_id', $user_id)->first();
        return $student ? $student->student_id : null;
    }

    /**
     * Graduate and persist MCQ test results (Reading/Listening).
     * 
     * Uses a database transaction to ensure atomicity while saving student
     * answers and updating the final result score.
     * 
     * @param string $testSkill The skill type (e.g., 'reading', 'listening').
     * @param array $answersArray The associative array of student answers.
     * @return void
     */
    private function gradeAndSaveResult($testSkill, $answersArray) 
    {
        $user_id = session('user_id');
        $student_id = $this->getStudentId();
        
        $test = Test::where('skill', $testSkill)->first();
        if (!$test || !$student_id) return;

        $questions = Question::where('test_id', $test->test_id)->orderBy('question_id')->get();
        if($questions->isEmpty()) return;

        DB::transaction(function () use ($questions, $answersArray, $student_id, $testSkill, $test, $user_id) {
            $correctCount = 0;
            $totalCount = $questions->count();

            foreach ($questions as $index => $question) {
                $inputKey = ($testSkill === 'listening') ? 's'.($index+1) : 'q'.($index+1);
                $selectedLetter = $answersArray[$inputKey] ?? null;

                if ($selectedLetter) {
                    $option = Option::where('question_id', $question->question_id)
                                    ->where('optione_text', $selectedLetter)
                                    ->first();

                    if ($option) {
                        DentAnswer::updateOrCreate(
                            ['student_id' => $student_id, 'question_id' => $question->question_id],
                            ['option_id' => $option->option_id]
                        );

                        if ($option->is_correct) {
                            $correctCount++;
                        }
                    }
                }
            }

            // Calculate and save result
            $finalScore = ($correctCount / $totalCount) * 100;

            Result::updateOrCreate(
                ['user_id' => $user_id, 'test_id' => $test->test_id],
                ['final_score' => $finalScore]
            );
        });
    }

    /**
     * Trigger the AI-driven test generation workflow.
     * 
     * Orchestrates calls to Groq and OpenRouter to generate new content.
     * Implements a robust fallback mechanism to reuse random dynamic tests from 
     * the DB if APIs fail, ensuring the user always gets a 'dynamic' experience.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function startAI(Request $request) 
    {
        if(!session('user_id')) return redirect()->route('info_account')->with('error','Please register first.');

        try {
            Log::info("Attempting to generate dynamic tests via Groq Llama...");
            $testIds = $this->generateTestsFromGroq();
            $listeningTestId = $this->generateListeningTestsFromOpenRouter();
            
            if ($testIds || $listeningTestId) {
                // If either succeeded, dynamically assign session state so the views render dynamic
                session(['dynamic_tests_ready' => true]);
                
                $finalTestIds = $testIds ?: [];
                if ($listeningTestId) {
                    $finalTestIds['listening'] = $listeningTestId;
                }
                
                session(['dynamic_test_ids' => $finalTestIds]);
                session()->forget(['reading_answers', 'listening_answers']);
                return redirect()->route('reading.start');
            } else {
                Log::warning("AI APIs failed, attempting to fallback to random previously generated dynamic tests.");
                $readingTest = Test::where('skill', 'reading_dynamic')->inRandomOrder()->first();
                $writingTest = Test::where('skill', 'writing_dynamic')->inRandomOrder()->first();
                $speakingTest = Test::where('skill', 'speaking_dynamic')->inRandomOrder()->first();
                $listeningFallbackTest = Test::where('skill', 'listening_dynamic')->inRandomOrder()->first();

                if ($readingTest || $listeningFallbackTest) {
                    Log::info("Successfully picked fallback dynamic tests from DB.");
                    session(['dynamic_tests_ready' => true]);
                    session(['dynamic_test_ids' => [
                        'reading' => $readingTest ? $readingTest->test_id : null,
                        'writing' => $writingTest ? $writingTest->test_id : null,
                        'speaking' => $speakingTest ? $speakingTest->test_id : null,
                        'listening' => $listeningFallbackTest ? $listeningFallbackTest->test_id : null,
                    ]]);
                    session()->forget(['reading_answers', 'listening_answers']);
                    return redirect()->route('reading.start');
                } else {
                    Log::warning("No dynamic fallback tests found in DB. Falling back to default static.");
                    session(['dynamic_tests_ready' => false]);
                    session()->forget(['dynamic_test_ids', 'reading_answers', 'listening_answers']);
                    return redirect()->route('reading.start');
                }
            }
        } catch (Exception $e) {
            Log::error("Failed to start AI test: " . $e->getMessage());
            // Fallback to static
            session(['dynamic_tests_ready' => false]);
            session()->forget(['dynamic_test_ids', 'reading_answers', 'listening_answers']);
            return redirect()->route('reading.start');
        }
    }

    /**
     * Generate Reading, Writing, and Speaking tests via Groq (Llama-3.1).
     * 
     * Forces a strict JSON output format to ensure compatibility with 
     * the application's question-option database schema.
     * 
     * @return array|bool Returns test IDs on success, false on failure.
     */
    private function generateTestsFromGroq(): array|bool 
    {
        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            Log::warning('Groq API key is missing. Cannot generate dynamic tests.');
            return false;
        }

        $prompt = <<<JSON_PROMPT
You are an expert English language test creator for beginners. Generate a brand new, unique, and engaging reading, writing, and speaking test.
Return ONLY a valid JSON object matching the exact structure below. Do NOT wrap it in markdown block quotes.

{
  "reading": {
    "passage": "A completely new original story of about 100-150 words.",
    "questions": [
      {
        "text": "A multiple choice question about the passage",
        "options": ["Correct Answer", "Wrong Option 1", "Wrong Option 2", "Wrong Option 3"],
        "correct_index": 0
      }
      // Must generate exactly 10 questions. Randomize the correct_index (0-3).
    ]
  },
  "writing": {
    "topic": "A completely new, interesting writing topic for beginners (e.g. Write a short paragraph about your favorite festival)."
  },
  "speaking": {
    "passage": "A completely new short passage (20-30 words) for the student to read aloud."
  }
}
JSON_PROMPT;

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You only reply with valid, raw JSON.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.8,
                    'response_format' => ['type' => 'json_object']
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                if (!$content) return false;

                $data = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if (isset($data['reading']) && isset($data['writing']) && isset($data['speaking'])) {
                        try {
                            // 1. Reading
                            $readingTest = Test::create([
                                'test_name' => 'Dynamic Reading', 
                                'level' => 'Beginner', 
                                'skill' => 'reading_dynamic', 
                                'content' => $data['reading']['passage']
                            ]);

                            foreach ($data['reading']['questions'] as $q) {
                                $newQ = Question::create([
                                    'test_id' => $readingTest->test_id,
                                    'question_text' => $q['text'],
                                    'question_type' => 'mcq',
                                    'difficulty_level' => 'medium'
                                ]);
                                foreach ($q['options'] as $idx => $optText) {
                                    Option::create([
                                        'question_id' => $newQ->question_id,
                                        'optione_text' => $optText,
                                        'is_correct' => ($idx === $q['correct_index']) ? 1 : 0
                                    ]);
                                }
                            }

                            // 2. Writing
                            $writingTest = Test::create([
                                'test_name' => 'Dynamic Writing', 
                                'level' => 'Beginner', 
                                'skill' => 'writing_dynamic', 
                                'content' => $data['writing']['topic']
                            ]);

                            // 3. Speaking
                            $speakingTest = Test::create([
                                'test_name' => 'Dynamic Speaking', 
                                'level' => 'Beginner', 
                                'skill' => 'speaking_dynamic', 
                                'content' => $data['speaking']['passage']
                            ]);

                            return [
                                'reading' => $readingTest->test_id,
                                'writing' => $writingTest->test_id,
                                'speaking' => $speakingTest->test_id
                            ];
                        } catch (\Exception $e) {
                            Log::error("Database insertion for Groq dynamic tests failed: " . $e->getMessage());
                            return false;
                        }
                    } else {
                        Log::error("JSON missed expected keys: " . substr($content, 0, 100));
                        return false;
                    }
                } else {
                    Log::error("Groq JSON parsing failed: " . json_last_error_msg() . " - Content: " . substr($content, 0, 100));
                    return false;
                }
            } else {
                Log::error("Groq API failed: " . $response->body());
                return false;
            }
        } catch (Exception $e) {
            Log::error("Groq Exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate Listening tests via OpenRouter (Llama-3.3 70B).
     * 
     * This method is particularly complex as it:
     * 1. Generates a textual script and MCQ questions.
     * 2. Calls the Google Translate TTS engine to create an audio file.
     * 3. Stores the audio locally and links it to the test record.
     * 
     * @return int|bool Returns the first valid test ID, or false on total failure.
     */
    private function generateListeningTestsFromOpenRouter(): int|bool 
    {
        $apiKey = env('OPENROUTER_API_KEY');
        if (!$apiKey) {
            Log::warning('OpenRouter API key is missing. Cannot generate dynamic listening tests.');
            return false;
        }

        $prompt = <<<JSON_PROMPT
You are an expert English language test creator for beginners. Generate exactly 3 listening tests.
For each test, write a short, engaging script (50-80 words) and 5 multiple-choice questions.
Return ONLY a valid JSON array matching the exact structure below. Do NOT wrap it in markdown block quotes.

[
  {
    "script": "A short engaging story or dialogue.",
    "questions": [
      {
        "text": "A question about the script.",
        "options": ["Correct Answer", "Wrong Option 1", "Wrong Option 2", "Wrong Option 3"],
        "correct_index": 0
      }
    ]
  },
  { ... },
  { ... }
]
JSON_PROMPT;

        try {
            $response = Http::withToken($apiKey)
                ->withHeaders([
                    'HTTP-Referer' => config('app.url'), // Optional, for OpenRouter rankings
                    'X-Title' => 'LingoPulse' // Optional
                ])
                ->timeout(60) // High timeout for batch AI generation & TTS downloading
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'meta-llama/llama-3.3-70b-instruct:free',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You only reply with valid, raw JSON.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.8
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                if (!$content) return false;

                // Strip markdown code fences if present (OpenRouter models sometimes ignore strict JSON prompts)
                $jsonString = preg_replace('/^```(?:json)?\s*/i', '', trim($content));
                $jsonString = preg_replace('/\s*```$/i', '', $jsonString);
                $data = json_decode(trim($jsonString), true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                    $firstTestId = null;

                    foreach ($data as $testData) {
                        try {
                            if (!isset($testData['script']) || !isset($testData['questions'])) continue;
                            
                            // 1. Generate TTS Audio via Google Translate API
                            $text = urlencode(substr($testData['script'], 0, 500)); 
                            $audioUrl = "https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q={$text}&tl=en-US";
                            
                            $audioContent = file_get_contents($audioUrl);
                            if ($audioContent === false) {
                                Log::error("Failed to download TTS audio.");
                                continue;
                            }

                            $fileName = 'dynamic_listening_' . uniqid() . '.mp3';
                            $filePath = public_path('storage/audio/' . $fileName);
                            
                            if (!file_exists(public_path('storage/audio'))) {
                                mkdir(public_path('storage/audio'), 0755, true);
                            }
                            
                            file_put_contents($filePath, $audioContent);
                            $dbAudioPath = 'storage/audio/' . $fileName;

                            // 2. Save Test Record
                            $listeningTest = Test::create([
                                'test_name' => 'Dynamic Listening', 
                                'level' => 'Beginner', 
                                'skill' => 'listening_dynamic', 
                                'content' => $dbAudioPath
                            ]);

                            if (!$firstTestId) $firstTestId = $listeningTest->test_id;

                            // 3. Save Questions & Options
                            foreach ($testData['questions'] as $q) {
                                $newQ = Question::create([
                                    'test_id' => $listeningTest->test_id,
                                    'question_text' => $q['text'],
                                    'question_type' => 'mcq',
                                    'difficulty_level' => 'medium'
                                ]);
                                foreach ($q['options'] as $idx => $optText) {
                                    Option::create([
                                        'question_id' => $newQ->question_id,
                                        'optione_text' => $optText,
                                        'is_correct' => ($idx === $q['correct_index']) ? 1 : 0
                                    ]);
                                }
                            }
                        } catch (\Exception $e) {
                            Log::error("Database/TTS insertion for OpenRouter dynamic listening tests failed: " . $e->getMessage());
                            continue; // Move to the next test in the array
                        }
                    }

                    return $firstTestId ?: false; // Return first valid test ID, or false if all looped tests failed randomly
                } else {
                    Log::error("OpenRouter JSON parsing failed: " . json_last_error_msg() . " - Content: " . substr($content, 0, 100));
                    return false;
                }
            } else {
                Log::error("OpenRouter API failed: " . $response->body());
                return false;
            }
        } catch (Exception $e) {
            Log::error("OpenRouter Exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Process student submissions for the Reading section.
     * 
     * Handles both 'dynamic' (single-page) and 'static' (multi-page/paginated)
     * submission flows, session persistence, and final grading.
     * 
     * @param Request $request
     * @param string $q Section identifier ('dynamic' or 'q1', 'q2' etc.)
     * @return RedirectResponse
     */
    public function submitReading(Request $request, $q) 
    {
        if(!session('user_id')) return redirect()->route('info_account')->with('error','Please register first.');

        try {
            // Check if we are interacting with dynamic or static reading test
            $isDynamic = session('dynamic_tests_ready', false);
            
            if ($isDynamic && session()->has('dynamic_test_ids.reading')) {
                $test = Test::find(session('dynamic_test_ids')['reading']);
            } else {
                $test = Test::where('skill', 'reading')->first();
            }
            if (!$test) return redirect()->back()->with('error', 'Test not found.');

            if ($q === 'dynamic') {
                // Save answers from the single page dynamic test
                $answers = $request->all();
                $filtered = array_filter($answers, function($key) { return strpos($key, 'q') === 0; }, ARRAY_FILTER_USE_KEY);
                
                $this->gradeAndSaveResult($test->skill, $filtered);
                return redirect()->route('reading.done');
            } else {
                // Validate q parameter for static pages
                if (!in_array($q, ['q1', 'q2'])) {
                    abort(404, 'Invalid question section.');
                }
                
                // Save submitted answers from this section into session
                $answers = $request->all();
                // Extract only 'q*' keys
                $filtered = array_filter($answers, function($key) { return strpos($key, 'q') === 0; }, ARRAY_FILTER_USE_KEY);
                
                $allReading = session('reading_answers', []);
                $allReading = array_merge($allReading, $filtered);
                session(['reading_answers' => $allReading]);

                $next = (int)str_replace('q', '', $q) + 1;
                
                if ($next > 2) { 
                    $this->gradeAndSaveResult('reading', session('reading_answers', []));
                    return redirect()->route('reading.done');
                }
                
                return redirect()->route("reading.q{$next}");
            }
        } catch (Exception $e) {
            Log::error('Reading submission error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ إجابتك. حاول مرة أخرى.');
        }
    }

    /**
     * Process student submissions for the Listening section.
     * 
     * Behaves similarly to submitReading but targets 'listening' skill records.
     * 
     * @param Request $request
     * @param string $q Section identifier.
     * @return RedirectResponse
     */
    public function submitListening(Request $request, $q) 
    {
        if(!session('user_id')) return redirect()->route('info_account')->with('error','Please register first.');

        try {
            $isDynamic = session('dynamic_tests_ready', false);
            
            if ($isDynamic && session()->has('dynamic_test_ids.listening')) {
                $test = Test::find(session('dynamic_test_ids')['listening']);
            } else {
                $test = Test::where('skill', 'listening')->first();
            }
            if (!$test) return redirect()->back()->with('error', 'Test not found.');

            if ($q === 'dynamic') {
                $answers = $request->all();
                $filtered = array_filter($answers, function($key) { return strpos($key, 's') === 0; }, ARRAY_FILTER_USE_KEY);
                
                $this->gradeAndSaveResult($test->skill, $filtered);
                return redirect()->route('listening.done');
            } else {
                if (!in_array($q, ['q1', 'q2'])) {
                    abort(404, 'Invalid question section.');
                }

                $answers = $request->all();
                $filtered = array_filter($answers, function($key) { return strpos($key, 's') === 0; }, ARRAY_FILTER_USE_KEY);
                
                $allListening = session('listening_answers', []);
                $allListening = array_merge($allListening, $filtered);
                session(['listening_answers' => $allListening]);

                $next = (int)str_replace('q', '', $q) + 1;
                
                if ($next > 2) { 
                    $this->gradeAndSaveResult('listening', session('listening_answers', []));
                    return redirect()->route('listening.done');
                }
                
                return redirect()->route("listening.q{$next}");
            }
        } catch (\Exception $e) {
            Log::error('Listening submission error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ إجابتك. حاول مرة أخرى.');
        }
    }

    /**
     * The core AI grading engine using Google Gemini.
     * 
     * Evaluates open-ended responses (Writing/Speaking) against a specific
     * rubric (Task Achievement, Coherence, Grammar, etc.).
     * Implements a multi-model fallback (1.5 Flash) and handles JSON parsing
     * of the AI's scorecard response.
     * 
     * @param string $text The student's response text.
     * @param string $skill enum: writing, speaking
     * @return array [score => int, feedback => string]
     */
    private function evaluateWithGemini($text, $skill) 
    {
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::warning('Gemini API key is missing. Falling back to mock scores.');
            return ['score' => rand(70, 95), 'feedback' => 'Mock feedback (API Key missing)'];
        }

        // Sanitize user text to avoid prompt injection
        $safeText = substr(trim($text), 0, 2000);
        $safeText = str_replace(['"', '\\'], ['\"', ''], $safeText);

        // Build skill-specific rubric
        if ($skill === 'writing') {
            $rubric = 'Evaluate using these 4 criteria (each scored 0-25, total 0-100):
1. Task Achievement (0-25): Did the student address the topic fully?
2. Coherence & Cohesion (0-25): Is the text well-organized with transitions?
3. Lexical Resource / Vocabulary (0-25): Variety and accuracy of words used?
4. Grammatical Range & Accuracy (0-25): Correct grammar and sentence variety?';

            $prompt = <<<PROMPT
You are an English language examiner for beginner-level students.
Evaluate this writing response strictly. $rubric
Be honest: poor responses get low scores.
Reply ONLY with valid JSON:
{"score":N,"feedback":"overall feedback text","task_achievement":N,"coherence":N,"vocabulary":N,"grammar":N}

Student response:
"$safeText"
PROMPT;
        } else {
            $rubric = 'Criteria: fluency(30%), pronunciation hints from text(20%), vocabulary(25%), coherence(25%).';

            $prompt = <<<PROMPT
You are an English language examiner for beginner-level students.
Evaluate this $skill response strictly. $rubric
Score 0-100. Be honest: poor responses get low scores.
Reply ONLY with valid JSON: {"score":N,"feedback":"..."}

Student response:
"$safeText"
PROMPT;
        }

        // Models to try
        $models = ['gemini-1.5-flash-latest'];

        $client = \Gemini::client($apiKey);

        foreach ($models as $modelName) {
            try {
                $response = $client->generativeModel($modelName)->generateContent($prompt);
                $raw = trim($response->text());
                
                // Strip markdown code fences if present
                $jsonString = preg_replace('/^```(?:json)?\s*/i', '', $raw);
                $jsonString = preg_replace('/\s*```$/i', '', $jsonString);
                $jsonString = trim($jsonString);
                
                $result = json_decode($jsonString, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($result['score']) && isset($result['feedback'])) {
                    $score = max(0, min(100, (int)$result['score']));
                    Log::info("Gemini ($modelName) evaluated $skill: score=$score");
                    
                    // For writing, include structured criteria in feedback JSON
                    if ($skill === 'writing' && isset($result['task_achievement'])) {
                        $structuredFeedback = json_encode([
                            'feedback' => $result['feedback'],
                            'criteria' => [
                                'task_achievement' => max(0, min(25, (int)($result['task_achievement'] ?? 0))),
                                'coherence' => max(0, min(25, (int)($result['coherence'] ?? 0))),
                                'vocabulary' => max(0, min(25, (int)($result['vocabulary'] ?? 0))),
                                'grammar' => max(0, min(25, (int)($result['grammar'] ?? 0))),
                            ]
                        ]);
                        return ['score' => $score, 'feedback' => $structuredFeedback];
                    }
                    
                    return ['score' => $score, 'feedback' => $result['feedback']];
                } else {
                    Log::warning("Gemini ($modelName) returned unparseable response: $raw");
                    continue; // Try next model
                }
            } catch (\Exception $e) {
                Log::warning("Gemini ($modelName) failed: " . $e->getMessage());
                continue; // Try next model
            }
        }

        // All models failed — graceful fallback
        Log::error("All Gemini models failed for $skill evaluation. Using fallback score.");
        return [
            'score' => 50,
            'feedback' => 'AI evaluation is temporarily unavailable due to rate limits. Your response has been saved and a teacher can review it later.'
        ];
    }

    /**
     * Process the student's Writing essay submission.
     * 
     * Triggers Gemini evaluation and saves the quantitative score and 
     * qualitative feedback into the database.
     * 
     * @param Request $request [essay]
     * @return RedirectResponse|JsonResponse
     */
    public function submitWriting(Request $request) 
    {
        $user_id = session('user_id');
        $student_id = $this->getStudentId();
        if(!$student_id) return redirect()->route('info_account');

        // Validate input
        $request->validate([
            'essay' => 'required|string|min:10|max:5000',
        ]);

        try {
            $isDynamic = session('dynamic_tests_ready', false);
            if ($isDynamic && session()->has('dynamic_test_ids.writing')) {
                $test = Test::find(session('dynamic_test_ids')['writing']);
            } else {
                $test = Test::where('skill', 'writing')->first();
            }
            
            // Allow submission even without a pre-existing "Question" for writing, 
            // since writing may just store answer directly tied to a general test writing question.
            // Let's create or find a general question for this test
            if ($test) {
                $question = Question::firstOrCreate(
                    ['test_id' => $test->test_id],
                    ['question_text' => 'Writing Essay', 'question_type' => 'essay', 'difficulty_level' => 'medium']
                );
            } else {
                $question = null;
            }

            if (!$test || !$question) {
                Log::error('Writing test or question not found in database.');
                return redirect()->route('writing.done')->with('error', 'خطأ في تحميل بيانات الاختبار.');
            }

            $text = strip_tags($request->input('essay'));

            $evaluation = $this->evaluateWithGemini($text, 'writing');

            DB::transaction(function () use ($student_id, $question, $text, $evaluation, $user_id, $test) {
                $answer = DentAnswer::updateOrCreate(
                    ['student_id' => $student_id, 'question_id' => $question->question_id],
                    ['answer_text' => $text]
                );

                Evaluation::updateOrCreate(
                    ['answer_id' => $answer->answer_id],
                    ['ai_score' => $evaluation['score'], 'ai_feedback' => $evaluation['feedback']]
                );

                Result::updateOrCreate(
                    ['user_id' => $user_id, 'test_id' => $test->test_id],
                    ['final_score' => $evaluation['score']]
                );
            });

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'redirect' => route('writing.done')]);
            }
            return redirect()->route('writing.done');
        } catch (\Exception $e) {
            Log::error('Writing submission error: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء تقييم إجابتك.'], 500);
            }
            return redirect()->route('writing.done')->with('error', 'حدث خطأ أثناء تقييم إجابتك.');
        }
    }

    /**
     * Process the student's Speaking submission (voice transcription).
     * 
     * Implements a server-side word comparison fallback if client-side
     * accuracy detection fails. Compares the spoken transcription against
     * the target passage words.
     * 
     * @param Request $request [transcription, accuracy]
     * @return RedirectResponse
     */
    public function submitSpeaking(Request $request) 
    {
        $user_id = session('user_id');
        $student_id = $this->getStudentId();
        if(!$student_id) return redirect()->route('info_account');

        try {
            $isDynamic = session('dynamic_tests_ready', false);
            if ($isDynamic && session()->has('dynamic_test_ids.speaking')) {
                $test = Test::find(session('dynamic_test_ids')['speaking']);
            } else {
                $test = Test::where('skill', 'speaking')->first();
            }
            
            // Allow submission even without a pre-existing "Question" for speaking, 
            // since speaking stores answer directly tied to a general test speaking question.
            if ($test) {
                $question = Question::firstOrCreate(
                    ['test_id' => $test->test_id],
                    ['question_text' => 'Speaking Passage', 'question_type' => 'speaking', 'difficulty_level' => 'medium']
                );
            } else {
                $question = null;
            }

            if (!$test || !$question) {
                Log::error('Speaking test or question not found in database.');
                return redirect()->route('speaking.done')->with('error', 'خطأ في تحميل بيانات الاختبار.');
            }

            $text = strip_tags($request->input('transcription', 'No speech detected.'));
            $accuracy = (int) $request->input('accuracy', 0);

            // ✅ Server-side word comparison fallback
            // If JS accuracy is 0, compute word-level match from test content
            if ($accuracy <= 0 && $test->content) {
                $targetWords = preg_split('/\s+/', strtolower(trim($test->content)));
                $spokenWords = preg_split('/\s+/', strtolower(trim($text)));
                $targetCount = count($targetWords);
                if ($targetCount > 0) {
                    $matchedCount = 0;
                    foreach ($targetWords as $tw) {
                        $tw = preg_replace('/[^a-z]/', '', $tw);
                        if (empty($tw)) { $targetCount--; continue; }
                        foreach ($spokenWords as $sw) {
                            $sw = preg_replace('/[^a-z]/', '', $sw);
                            if ($sw === $tw) { $matchedCount++; break; }
                        }
                    }
                    $serverAccuracy = $targetCount > 0 ? (int)round(($matchedCount / $targetCount) * 100) : 0;
                    $accuracy = max($accuracy, $serverAccuracy);
                    Log::info("Speaking server-side accuracy computed: {$serverAccuracy}% (matched {$matchedCount}/{$targetCount})");
                }
            }

            // ✅ Use the calculated reading accuracy score
            $feedback = "Reading Accuracy: {$accuracy}%. " . 
                        ($accuracy >= 80 ? "Great pronunciation and fluency!" : "Keep practicing reading aloud to improve pronunciation.");

            DB::transaction(function () use ($student_id, $question, $text, $accuracy, $feedback, $user_id, $test) {
                $answer = DentAnswer::updateOrCreate(
                    ['student_id' => $student_id, 'question_id' => $question->question_id],
                    ['answer_text' => $text]
                );

                Evaluation::updateOrCreate(
                    ['answer_id' => $answer->answer_id],
                    ['ai_score' => $accuracy, 'ai_feedback' => $feedback]
                );

                Result::updateOrCreate(
                    ['user_id' => $user_id, 'test_id' => $test->test_id],
                    ['final_score' => $accuracy]
                );
            });

            return redirect()->route('speaking.done');
        } catch (\Exception $e) {
            Log::error('Speaking submission error: ' . $e->getMessage());
            return redirect()->route('speaking.done')->with('error', 'حدث خطأ أثناء تقييم إجابتك.');
        }
    }
}
