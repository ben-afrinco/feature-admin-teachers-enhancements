# Scaling & Performance Optimization

LingoPulse is designed for efficiency, but as the user base grows, the following scaling strategies should be considered.

## ⚡ Performance Optimization

### 1. Caching Strategy
- **Application Cache**: Use `Redis` or `Memcached` instead of the `file` driver for faster session and data caching.
- **View Caching**: Always run `php artisan view:cache` in production to avoid JIT compilation of Blade templates.

### 2. Database Optimization
- **Eager Loading**: Prevent N+1 query problems by using `.with('relationship')`. 
  - *Current Status:* Implemented in `LandingController` for assignments and sessions.
- **Indexing**: Frequent lookup columns like `user_id`, `class_id`, and `email` are indexed by default in migrations.

### 3. Frontend Assets
- **Vite/Build**: All assets are minified and versioned during the `npm run build` process to ensure optimal browser load times.
- **CDN**: Serve static assets (images, CSS, JS) from a Content Delivery Network.

## 📈 Scaling Strategy

### Vertical Scaling
Increase server resources (CPU/RAM) as the number of concurrent AI Test sessions grows.

### Horizontal Scaling
1.  **Stateless Sessions**: Move session storage from `file` to `database` or `Redis` to allow multiple web servers behind a Load Balancer.
2.  **Centralized File Storage**: Switch the `local` private disk to `S3` (or compatible) storage for assignment files.
3.  **Queue Workers**: Offload AI generation (Groq/OpenRouter) to background queue workers (`php artisan queue:work`) to keep the web interface responsive.

---
Next: [Monitoring & Logging](MONITORING_LOGGING.md)
