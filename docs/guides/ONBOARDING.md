# Developer Onboarding Guide

Welcome to the LingoPulse development team! This guide will help you set up your environment and understand our standards.

## 🛠 One-Click Setup
We utilize a custom Composer script to automate the initial setup.

```bash
# Clone the project and enter the directory
git clone ...
cd Lingolpuse

# Run the setup script
composer run setup
```
**This script will:**
1. Install PHP dependencies.
2. Create your `.env` file.
3. Generate the application key.
4. Run database migrations.
5. Install and build frontend assets.

## 💻 Local Development Environment
Run the following to start the local development stack:
```bash
composer run dev
```
This uses **Concurrently** to run `php artisan serve`, the `queue listener`, and the `Vite` dev server in a single terminal session.

## 📐 Technical Standards
- **Coding Style**: We follow PSR-12. Run `composer run lint` (if configured) or use Laravel Pint.
- **Git Flow**: Use descriptive branch names (e.g., `feature/ai-speaking`, `fix/login-redirect`).
- **Commits**: Follow [Conventional Commits](https://www.conventionalcommits.org/).

## 🧩 Architectural Mindset
1.  **Keep Controllers Lean**: If logic reaches >50 lines, consider moving it to a Service or Action class.
2.  **Blade Components**: Re-use UI elements (buttons, inputs) in `resources/views/components`.
3.  **Strict Typing**: Type-hint method arguments and return types wherever possible.

## 📚 Essential Reading
1.  [Architecture Overview](../architecture/OVERVIEW.md)
2.  [Database Models](../database/MODELS.md)
3.  [AI Test Flow](../modules/ai-test-engine/OVERVIEW.md)

---
Next: [Troubleshooting Guide](TROUBLESHOOTING.md)
