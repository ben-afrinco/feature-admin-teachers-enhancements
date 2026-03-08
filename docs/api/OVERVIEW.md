# API & Route Reference

LingoPulse primarily operates as a **Stateful Web Application** using Blade templates, but it exposes various endpoints for data submission, AJAX operations, and integration.

## 🛰 Architecture
- **Web Routes**: Handled in `routes/web.php`.
- **API (Future)**: Placeholder for headless growth in `routes/api.php`.
- **Middleware**: All protected routes require the `auth.session` middleware.

## 📋 Primary Endpoint Categories

### 1. Authentication
| Method | URL | Description |
|---|---|---|
| `POST` | `/auth/login` | Session login. |
| `POST` | `/account/store` | Student self-registration. |
| `POST` | `/logout` | Session flush and redirect. |

### 2. AI Testing Engine
| Method | URL | Description |
|---|---|---|
| `GET` | `/test/start` | Trigger AI dynamic generation. |
| `POST` | `/test/reading/{q}` | Submit reading answer(s). |
| `POST` | `/test/writing` | Submit essay to Gemini for evaluation. |
| `POST` | `/test/speaking` | Submit transcription and accuracy score. |

### 3. Teacher Operations
| Method | URL | Description |
|---|---|---|
| `POST` | `/teacher/assignments` | Create a new assignment. |
| `POST` | `/teacher/session/create` | Start Jitsi session. |
| `POST` | `/teacher/submissions/{id}/grade` | Save grade and feedback. |

### 4. Shared Utilities
| Method | URL | Description |
|---|---|---|
| `GET` | `/shared/downloads/attachments/{id}` | Secure file stream for attachments. |
| `GET` | `/shared/downloads/submissions/{id}` | Secure file stream for student work. |

## 📦 Request/Response Standards
- **Form Data**: Used for standard Blade form submissions.
- **JSON**: Used for AJAX calls in dashboard modals (e.g., Assignment creation feedback).
- **Errors**: Standard Laravel validation exception responses (Redirect with Errors or 422 JSON).

---
Next: [Deployment Guide](../deployment/OVERVIEW.md)
