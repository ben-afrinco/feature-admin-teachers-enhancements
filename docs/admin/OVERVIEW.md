# Admin Dashboard Overview

The Admin Dashboard is the central command center for LingoPulse, accessible only to users with the `admin` role.

## 🔑 Key Responsibilities
- **User Orchestration**: Creating, managing, and deleting Students, Teachers, and other Admins.
- **Academic Structure**: Defining Classes and linking them to Teachers.
- **Content Management**: Managing the static question bank for the assessment engine.
- **System Monitoring**: Viewing platform-wide statistics.

## 🛠 Feature Breakdown

### 1. User Management
- **Add User**: Admins can create new accounts directly.
- **User Roles**: Ability to toggle roles between Student, Teacher, and Admin.
- **Security**: The `LandingController@addUser` logic handles user creation with default passwords and role-specific profile generation (Student/Teacher/Admin records).

### 2. Class & Enrollment Management
- **Create Class**: Admins create the "rooms" for learning.
- **Assign Teacher**: Every class must be associated with a `teacher_id`.
- **Enrollment**: While primarily handled via admin, enrollment links students to classes via the `class_student` pivot table.

### 3. Question Bank Control
- **Manual Questions**: Admins can add Reading, Listening, and Writing questions manually to the `questions` and `options` tables.
- **Difficulty Mapping**: Assigning `easy`, `medium`, or `hard` difficulty to ensure the test engine pulls balanced content.

## 📊 Statistics View
The `LandingController@developerDashboard` provides a summary of:
- Total Users count.
- Students vs. Teachers distribution.
- Admin activity logs (Future).

---
Next: [Teacher Dashboard](../teachers/OVERVIEW.md)
