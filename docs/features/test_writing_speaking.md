# Writing & Speaking Proficiency Tests

## Overview
Advanced assessment modules focusing on production skills (typed and spoken).

## UI Components (Writing)
- **Prompt Area**: Essay or short paragraph topic.
- **Rich Text / Textarea**: Student input area.
- **Word Count**: Dynamic tracking.

## UI Components (Speaking)
- **Record Button**: Microphone access trigger.
- **Allow Mic Modal**: Permission handling.
- **Progress bar**: Recording duration.

## Technical Implementation
- **Controllers**: `TestController@submitWriting`, `TestController@submitSpeaking`.
- **Media Handling**: Speaking test requires local microphone and potentially API integration for speech-to-text scoring.
- **Redirects**: Automatically sequence to next test or final results.

## How to use from Browser
1. **Writing**: Read the prompt and type at least the minimum word count, then click submit.
2. **Speaking**: Grant microphone permissions, record your answer to the prompt, and wait for confirmation.
