# Monitoring & Logging

Reliability is critical for an educational platform. We use a multi-tiered approach to monitor system health.

## 📝 Logging Standards
LingoPulse uses Laravel's native `Log` facade, which routes to `storage/logs/laravel.log` by default.

### Log Levels
- **Log::info**: General system events (e.g., "AI Test Started").
- **Log::warning**: Non-critical failures (e.g., "AI API rate limit hit, using fallback").
- **Log::error**: Critical issues (e.g., "Database connection failed", "Gemini evaluation failed").

## 🛠 Key Monitoring Targets

### 1. AI API Health
We log the success/failure rates of Groq, OpenRouter, and Gemini calls. High failure rates indicate API downtime or key exhaustion.

### 2. Disk Space
Since we store student submissions locally by default, monitoring disk usage on the `storage` partition is essential.

### 3. Application Performance
Tracking request times for the `TestController` actions is vital, as AI generation can be time-consuming.

## 🚀 Recommended Production Stack
For enterprise deployment, it is recommended to integrate:
- **Sentry/Flare**: For real-time error tracking and exception notifications.
- **Prometheus/Grafana**: For server health metrics.
- **Laravel Pulse**: For real-time monitoring of application vitals (Queues, Slow Routes, etc).

---
Next: [Troubleshooting Guide](../guides/TROUBLESHOOTING.md)
