<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class OllamaController
 * 
 * Integrates with a local Ollama instance (using tinyllama:1.1b) to provide
 * instant, AI-driven explanations for student errors.
 * Uses Server-Sent Events (SSE) to stream text responses for a fluid user experience.
 * 
 * @package App\Http\Controllers
 */
class OllamaController extends Controller
{
    /**
     * Stream an AI explanation for why a student's answer was incorrect.
     * 
     * Orchestrates a cURL request to the Ollama API, processing the stream 
     * and echoing SSE data packets ('data: {token: ...}\n\n') in real-time.
     * Handles network timeouts and API errors by returning a standard fallback message.
     * 
     * @param Request $request [question, correct_answer, student_answer]
     * @return StreamedResponse
     */
    public function explain(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
            'correct_answer' => 'required|string|max:500',
            'student_answer' => 'required|string|max:500',
        ]);

        $question = $request->input('question');
        $correctAnswer = $request->input('correct_answer');
        $studentAnswer = $request->input('student_answer');

        $prompt = <<<PROMPT
You are a helpful English teacher. A student answered a question incorrectly on an English test.

Question: {$question}
Student's answer: {$studentAnswer}
Correct answer: {$correctAnswer}

Explain briefly (3-4 sentences max) why the student's answer is wrong and why the correct answer is right. Be encouraging and clear. Use simple English.
PROMPT;

        return new StreamedResponse(function () use ($prompt) {
            // Set headers for SSE
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            header('Connection: keep-alive');
            header('X-Accel-Buffering: no');

            try {
                $ollamaUrl = env('OLLAMA_URL', 'http://localhost:11434') . '/api/generate';
                $ch = curl_init($ollamaUrl);
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode([
                        'model' => 'tinyllama:1.1b',
                        'prompt' => $prompt,
                        'stream' => true,
                        'options' => [
                            'temperature' => 0.7,
                            'num_predict' => 256,
                        ],
                    ]),
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                    CURLOPT_RETURNTRANSFER => false,
                    CURLOPT_TIMEOUT => 60,
                    CURLOPT_WRITEFUNCTION => function ($ch, $data) {
                        $lines = explode("\n", trim($data));
                        foreach ($lines as $line) {
                            if (empty($line)) continue;
                            $json = json_decode($line, true);
                            if ($json && isset($json['response'])) {
                                echo "data: " . json_encode(['token' => $json['response']]) . "\n\n";
                                if (ob_get_level()) ob_flush();
                                flush();
                            }
                            if ($json && ($json['done'] ?? false)) {
                                echo "data: [DONE]\n\n";
                                if (ob_get_level()) ob_flush();
                                flush();
                            }
                        }
                        return strlen($data);
                    },
                ]);

                curl_exec($ch);

                if (curl_errno($ch)) {
                    Log::error('Ollama curl error: ' . curl_error($ch));
                    echo "data: " . json_encode(['token' => 'AI explanation is temporarily unavailable.']) . "\n\n";
                    echo "data: [DONE]\n\n";
                    flush();
                }

                curl_close($ch);
            } catch (\Exception $e) {
                Log::error('Ollama streaming error: ' . $e->getMessage());
                echo "data: " . json_encode(['token' => 'AI explanation is temporarily unavailable.']) . "\n\n";
                echo "data: [DONE]\n\n";
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering: no',
        ]);
    }
}

