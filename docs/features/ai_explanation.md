# AI Explanation (Ollama)

## Overview
Provides students with instant, AI-generated explanations for why their answers were incorrect.

## UI Components
- **AI Explanation Box**: Appears on result details pages.
- **Streaming UI**: Tokens appear in real-time.

## Technical Implementation
- **Route (SSE)**: `POST /api/ollama/explain` (named `ollama.explain`)
- **Controller**: `App\Http\Controllers\OllamaController@explain`
- **Engine**: Uses a local Ollama instance (defaulting to `tinyllama:1.1b`).
- **Communication**: Backend performs a CURL request to `OLLAMA_URL` (host machine) and streams the response back to the frontend using Server-Sent Events (SSE).

## How to use from Browser
1. Complete a test (e.g., Reading).
2. Go to "Details" for a specific skill.
3. For any incorrect answer, click "Explain with AI".
4. View the real-time generated explanation.
