# Database Overview

LingoPulse uses a relational database structure designed to support hierarchical user relationships and complex educational workflows.

## 🗄 Storage Engine
The application is configured to support both **SQLite** (for development/local testing) and **MySQL/PostgreSQL** (for production). Eloquent ORM is used exclusively for all database interactions.

## 🗺 Entity Relationship Diagram (Conceptual)

```mermaid
erDiagram
    USER ||--|o STUDENT : is
    USER ||--|o TEACHER : is
    USER ||--|o ADMIN : is
    
    CLASSES }|--|| TEACHER : managed_by
    STUDENT }|--|{ CLASSES : enrolled_in
    
    ASSIGNMENT }|--|| CLASSES : assigned_to
    ASSIGNMENT }|--|| TEACHER : created_by
    
    ASSIGNMENT_SUBMISSION }|--|| ASSIGNMENT : for
    ASSIGNMENT_SUBMISSION }|--|| STUDENT : from
    ASSIGNMENT_SUBMISSION ||--|{ SUBMISSION_VERSION : has
    
    ONLINE_SESSION }|--|| CLASSES : for
    ONLINE_SESSION }|--|| TEACHER : held_by
    
    TEST ||--|{ QUESTION : contains
    QUESTION ||--|{ OPTION : has
    
    USER ||--|{ RESULT : achieves
    RESULT }|--|| TEST : of
```

## 🏗 Key Migration History
- `2026_01_07`: Core system tables (Users, Students, Teachers, Classes, Tests, Questions).
- `2026_02_25`: Introduction of `class_student` pivot table and enrollment fixes.
- `2026_02_27`: Online Sessions, Assignments, and Submission tracking (including versions).
- `2026_02_27`: System-wide notifications infrastructure.

---
Next: [Model Reference](MODELS.md)
