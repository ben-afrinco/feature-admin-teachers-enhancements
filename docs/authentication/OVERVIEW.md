# Authentication Overview

LingoPulse uses a custom, lightweight session-based authentication system rather than integrated Laravel packages like Breeze or Jetstream. This allows for fine-grained control over the login/registration process for students, teachers, and admins.

## 🔐 Auth Mechanism
- **Driver**: Laravel Session.
- **Data Points**: Upon successful login, the following keys are stored in the session:
  - `user_id`: The ID of the authenticated user.
  - `role`: One of `student`, `teacher`, or `admin`.
  - `name`: The full name of the user for UI display.

## 🚪 Entry Points

### 1. Account Discovery (`/account-selection`)
Users choose their path (New Student vs. Existing Account).

### 2. Student Quick Register (`/account/store`)
Allows students to register quickly by providing basic details. Password is defaulted to `123456` in current implementation (intended for supervised lab environments).

### 3. Unified Login (`/auth/login`)
Standard email/password login. Supports both Bcrypt hashing and legacy plain-text comparisons (for migration compatibility).

## 🛡 Session Persistence
Sessions are managed via standard Laravel session drivers (configured in `config/session.php`). By default, sessions persist until the browser is closed or the user explicitly logs out via the `/logout` route.

---
Next: [RBAC Matrix](RBAC.md)
