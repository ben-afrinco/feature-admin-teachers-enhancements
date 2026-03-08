<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

/**
 * Class ChatbotController
 * 
 * Managed integration with the Gemini AI API to provide an educational
 * assistant for students. Handles conversation history and real-time messaging.
 * 
 * @package App\Http\Controllers
 */
class ChatbotController extends Controller
{
    /**
     * Retrieve the chat history for the authenticated user.
     * 
     * Ordered chronologically to reconstruct conversation flow in the UI.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getHistory(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $history = ChatSession::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get(['role', 'content']);

        return response()->json(['success' => true, 'history' => $history]);
    }

    /**
     * Send a message to the AI chatbot and receive a response.
     * 
     * Persists the student message, builds context from recent history,
     * queries Gemini Pro via API, and stores the AI reply before returning it.
     * 
     * @param Request $request [message]
     * @return JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $userMessage = $request->input('message');

        // Output user message to DB
        ChatSession::create([
            'user_id' => $userId,
            'role' => 'user',
            'content' => $userMessage
        ]);

        $apiKey = env('GEMINI_API_KEY') ?: config('services.gemini.api_key');
        if (!$apiKey) {
            return response()->json([
                'success' => false, 
                'message' => 'الخدمة غير متوفرة حالياً (مفتاح API مفقود).'
            ]);
        }

        try {
            $client = \Gemini::client($apiKey);
            
            // Build Context from recent history (last 10 messages)
            $recentHistory = ChatSession::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->reverse();
                
            $prompt = "You are LingoPulse's AI student assistant. You answer questions helpfully, concisely, and creatively in Arabic or English according to the user's language. Keep answers short and formatted nicely.\n\nConversation History:\n";
            foreach($recentHistory as $msg) {
                $roleLabel = ($msg->role === 'user') ? 'Student' : 'Assistant';
                $prompt .= $roleLabel . ': ' . $msg->content . "\n";
            }
            $prompt .= "Assistant: ";

            $response = $client->geminiPro()->generateContent($prompt);
            $botReply = $response->text();

            if (empty($botReply)) {
                $botReply = "عذراً، لم أتمكن من معالجة طلبك.";
            }

            // Save bot reply
            ChatSession::create([
                'user_id' => $userId,
                'role' => 'model',
                'content' => $botReply
            ]);

            return response()->json([
                'success' => true,
                'reply' => $botReply
            ]);
            
        } catch (\Exception $e) {
            Log::error("Chatbot API Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'عذراً، أواجه صعوبات فنية حالياً. يرجى المحاولة لاحقاً.'
            ]);
        }
    }
}

