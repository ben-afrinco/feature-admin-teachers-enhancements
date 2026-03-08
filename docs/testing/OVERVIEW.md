# Testing & Verification

LingoPulse maintains reliability through a combination of automated and manual testing strategies.

## 🧪 Automated Testing
Run the following to execute the test suite:
```bash
composer run test
```
*Note: This clears the application config cache before running PHPUnit to ensure a clean environment.*

## 📋 Areas of Coverage

### 1. Feature Tests
- **Authentication**: Login/Logout/Registration flows.
- **Role Access**: Middleware verification for Admin/Teacher routes.
- **Assignments**: Verification of the Create -> Submit -> Grade lifecycle.

### 2. Unit Tests
- **Formula Logic**: Ensuring score normalization and percentage calculations are mathematically correct.
- **String Handling**: Stripping markers and sanitizing inputs for AI prompts.

### 3. Service Mocks
- During testing, AI providers (Gemini, Groq) are typically mocked or pointed to a sandbox environment to avoid token drainage.

## 👥 Manual Verification
Core UI interactions, especially the **Speaking (Web Speech)** and **Online Sessions (Jitsi)**, should be verified in modern browsers (Chrome/Safari) as they depend on native browser APIs.

---
Next: [Development Overview](../development/OVERVIEW.md)
