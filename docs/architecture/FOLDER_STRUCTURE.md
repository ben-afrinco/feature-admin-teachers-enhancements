# Folder Structure Breakdown

LingoPulse maintains a clean Laravel structure with clear separation between business logic, data, and presentation.

## 📂 Root Directory Map

| Folder | Description |
|---|---|
| `app/` | Core PHP application code (Models, Controllers, Middleware). |
| `bootstrap/` | Framework bootstrapping and cache files. |
| `config/` | Application configuration (Database, Mail, Services). |
| `database/` | Migrations, Factories, and Seeders. |
| `docs/` | Comprehensive technical documentation (You are here). |
| `public/` | Publicly accessible assets (CSS, JS, Images). |
| `resources/` | Blade templates and uncompiled frontend assets. |
| `routes/` | Route definitions (Web, API, Console). |
| `storage/` | Logs, compiled views, and private user files. |
| `tests/` | Feature and Unit tests. |

## 🚀 Key Directories Detail

### `app/Http/Controllers/`
Contains the business logic for all modules.
- `AssignmentController.php`: Teaching staff tasks and assignment creation.
- `SubmissionController.php`: Student submission logic and grading.
- `TestController.php`: Core logic for the AI-powered testing engine.
- `LandingController.php`: Dashboard views, Admin management, and Gemini API coordination.

### `app/Models/`
Contains Eloquent ORM classes with relationships defined.
- `User_Model.php`: Master user table for all roles.
- `Student.php` / `Teacher.php`: Role-specific metadata linked to users.
- `Assignment.php` / `AssignmentSubmission.php`: Assignment lifecycle data.

### `resources/views/`
Contains the UI templates.
- `admin/` / `teacher/`: Dashboard layouts.
- `student_assignments.blade.php`: Dedicated student assignment tracking.
- `results.blade.php`: The master results and AI feedback view.

### `storage/app/private/`
**Critical Security Layer.**
- `assignments/`: Worksheets and files uploaded by teachers.
- `submissions/`: Work uploaded by students.
- *Note:* These are protected by binary stream controllers and are **not** accessible via direct URL.

---
Next: [Authentication Overview](../authentication/OVERVIEW.md)
