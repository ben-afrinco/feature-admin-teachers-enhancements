# Function: getHistory (Chatbot)

## Path
`app/Http/Controllers/ChatbotController.php`

## Description
Retrieves the logged conversation history between the AI chatbot and the current user.

## How it works in code
- Queries the `ChatbotHistory` model filtered by `user_id`.
- Returns a JSON collection of questions and answers.

## How to use from Browser
- Automatically triggered when the user opens the chatbot interface to populate previous messages.
