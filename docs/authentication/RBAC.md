# Role-Based Access Control (RBAC)

LingoPulse enforces access control through a combination of database roles and route-level middleware.

## 🎭 Role Definitions

| Role | Description |
|---|---|
| **Admin** | Full system access. Manages users, classes, and site configuration. |
| **Teacher** | Manages specific classes, sessions, and grading for enrolled students. |
| **Student** | Accesses learning materials, takes tests, and submits assignments. |

## 🕹 Implementation: `EnsureSessionAuth` Middleware
The custom middleware `App\Http\Middleware\EnsureSessionAuth` is responsible for gatekeeping. It accepts an optional list of roles.

**Logic Flow:**
1. Check if `user_id` exists in session. If not, redirect to `/account-selection`.
2. If roles are provided (e.g., `auth.session:admin`), check if `session('role')` matches one of the allowed roles.
3. If no match, return a `403 Forbidden` error.

## 📍 Route Mapping Examples

```php
// Student Only
Route::middleware('auth.session:student')->group(function () {
    Route::get('/test/start', ...);
});

// Admin Only
Route::middleware('auth.session:admin')->group(function () {
    Route::get('/developer', ...);
});

// Multi-role (Shared)
Route::middleware(\App\Http\Middleware\EnsureSessionAuth::class)->group(function () {
    Route::get('/shared/downloads/...', ...);
});
```

---
Next: [Security Overview](../security/OVERVIEW.md)
