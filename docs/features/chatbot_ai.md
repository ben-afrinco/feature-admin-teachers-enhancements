# AI Chatbot Interface

## Overview
A general AI assistant for students and teachers to ask English proficiency related questions.

## UI Components
- **Chat Window**: Floating or embedded message interface.
- **Message Input**: Text box for user queries.
- **History Viewer**: Displays past conversation tokens.

## Technical Implementation
- **Route (GET history)**: `/chatbot/history`
- **Route (POST send)**: `/chatbot/send`
- **Controller**: `App\Http\Controllers\ChatbotController`

## How to use from Browser
1. Open the Chatbot icon (usually bottom right).
2. Type a question about grammar or vocabulary.
3. Receive responses from the AI.
4. View history to track your learning.
