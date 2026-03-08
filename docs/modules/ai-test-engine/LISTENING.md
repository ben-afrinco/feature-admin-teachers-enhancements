# AI Listening Test Detail

The Listening module evaluates auditory comprehension using high-quality Text-to-Speech (TTS) generated on-the-fly.

## 🎧 Component Overview
- **View**: `resources/views/dynamicListening.blade.php`.
- **Controller**: `TestController@generateListeningTestsFromOpenRouter`.
- **Audio Generation**: Integration with Google Translate TTS.

## 🔄 Technical Flow
1.  **Script Generation**: OpenRouter creates a dialogue or story.
2.  **Audio Conversion**: Script is sent to TTS API; MP3 is downloaded to `public/storage/audio/`.
3.  **Playback**: Blade uses the native HTML5 `<audio>` player with controls.
4.  **Submission**: Handled by `TestController@submitListening`.

## 🤖 AI Logic
The system generates 3 tests per batch but primarily presents the first valid one to the student to maintain focused testing.

## ⚠️ Performance Note
Generating TTS audio increases the loading time of the "Start Test" action. This is mitigated by high timeout settings (60s) in the Guzzle client.

---
Next: [Writing Test Detail](WRITING.md)
