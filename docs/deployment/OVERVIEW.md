# Deployment Guide

LingoPulse is built on Laravel, making it compatible with most modern PHP cloud hosting environments (DigitalOcean, AWS, Heroku, or traditional VPS).

## 🛠 Prerequisites
- PHP 8.2+
- Composer 2.x
- Node.js & NPM
- SQLite (Default) or MySQL/PostgreSQL
- Groq / OpenRouter / Gemini API Keys

## 🚀 Standard Deployment (VPS)

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/Lingolpuse/Lingolpuse.git
    cd Lingolpuse
    ```

2.  **Install Dependencies**
    ```bash
    composer install --optimize-autoloader --no-dev
    npm install
    npm run build
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Fill in database, mail, and AI API keys in `.env`.*

4.  **Database Preparation**
    ```bash
    php artisan migrate --force
    ```

5.  **Optimization**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

## 📦 Directory Permissions
Ensure the following directories are writable by the web server (e.g., `www-data`):
- `storage`
- `bootstrap/cache`
- `public/storage` (if using `php artisan storage:link`)

## 🕒 Cron Jobs & Queues
If AI generation or email sending is moved to queues, add this to your server's crontab:
```cron
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---
Next: [Scaling & Performance](../development/SCALING_PERFORMANCE.md)
