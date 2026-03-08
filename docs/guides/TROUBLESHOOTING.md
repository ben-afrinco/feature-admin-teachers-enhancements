# Troubleshooting & Incident Handling

This guide provides solutions to common issues and protocols for handling production incidents.

## 🛠 Common Technical Issues

### 1. "AI Generation Failed" (Timeout or Error)
- **Symptom**: Student clicks "Start AI Test" but is redirected back to index with an error.
- **Cause**: Groq or OpenRouter API is down, or Rate Limit reached.
- **Solution**:
  - Verify API keys in `.env`.
  - Check `storage/logs/laravel.log` for specific API error messages.
  - The system has a fallback to "Random Static Dynamic" tests; ensure there are records in the `test` table with `skill` like `reading_dynamic`.

### 2. "File Download Forbidden" (403)
- **Symptom**: Student/Teacher cannot download a submission.
- **Cause**: Authorization check in `FileDownloadController` failed.
- **Solution**: Verify the student is correctly enrolled in the class via the `class_student` pivot table.

### 3. Jitsi Room Not Found
- **Symptom**: "Meeting does not exist" on Jitsi side.
- **Cause**: Room name generation mismatch or session deletion.
- **Solution**: Ensure the `room_name` in the `online_sessions` table matches the one in the iframe URL.

## 🚨 Production Incident Protocol

### 1. Detect & Assess
- Monitor Sentry/Logs for spikes in `500` errors.
- Confirm if the issue is a bug, infrastructure failure, or third-party (AI) outage.

### 2. Communicate
- Update the internal status page (if available).
- Notify teachers if scheduled Online Sessions are affected.

### 3. Contain & Fix
- If a recent deployment caused the issue: **Roll back immediately.**
- If an AI provider is down: Enable "Static Fallback Mode" in `.env`.

### 4. Post-Mortem
- Document the root cause.
- Update this guide if a new failure pattern is discovered.

---
Next: [System Glossary](GLOSSARY.md)
