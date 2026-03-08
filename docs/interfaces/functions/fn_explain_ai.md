# Function: explain

## Path
`app/Http/Controllers/OllamaController.php`

## Description
Generates an AI explanation for a specific question using Ollama.

## How it works in code
- Uses a local Ollama instance via CURL.
- Streams the explanation context back as Server-Sent Events (SSE).

## How to use from Browser
- Invoked when a student clicks "Explain with AI" on a test result details page.
