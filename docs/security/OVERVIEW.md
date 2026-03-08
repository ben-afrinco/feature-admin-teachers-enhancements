# Security Overview

Security in LingoPulse is applied at multiple layers: Infrastructure, Application, and Data.

## 🛡 Application Security

### 1. CSRF Protection
Laravel's built-in CSRF protection is enabled for all `POST`, `PUT`, `PATCH`, and `DELETE` requests. All forms in Blade templates must include the `@csrf` directive.

### 2. SQL Injection Prevention
All database queries are executed using **Eloquent ORM** or **Query Builder** with parameter binding, which inherently prevents SQL injection attacks.

### 3. XSS Mitigation
- **Blade Templating**: Automatically escapes output using `{{ ... }}`.
- **Security Headers**: Custom middleware applies standard protection headers.

## 🛰 Security Headers Implementation
The `SecurityHeaders` middleware adds the following to every response:
- `X-Content-Type-Options: nosniff`: Prevents MIME-sniffing.
- `X-Frame-Options: SAMEORIGIN`: Protects against clickjacking.
- `Referrer-Policy: strict-origin-when-cross-origin`.
- `Permissions-Policy`: Restricts browser features (camera/mic limited to self).

## 📁 Data & File Security
- **Private Storage**: Student submissions and teacher attachments are stored in `storage/app/private`.
- **Authorized Downloads**: Files are not linked directly. They are served via `FileDownloadController`, which checks class enrollment before streaming the file content.

---
Next: [Permissions Detail](PERMISSIONS.md)
