# Model Reference

This document provides a detailed breakdown of the primary Eloquent models in LingoPulse.

## 👤 User & Roles

### `User_Model`
- **Table:** `user`
- **Primary Key:** `user_id`
- **Fields:** `full_name`, `email`, `password`, `role` (student, teacher, admin).
- **Relationships:**
  - `hasOne(Student)`
  - `hasOne(Teacher)`
  - `hasOne(Admin)`
  - `hasMany(Result)`
- **Traits:** `Notifiable` (Laravel Notifications).

### `Student`
- **Table:** `student`
- **Primary Key:** `student_id`
- **Fields:** `user_id`, `class_id`, `level`.
- **Relationships:**
  - `belongsTo(User_Model)`
  - `belongsTo(Classes)`
  - `belongsToMany(Classes)` via `class_student`.

### `Teacher`
- **Table:** `teachers`
- **Primary Key:** `teacher_id`
- **Fields:** `user_id`.
- **Relationships:**
  - `belongsTo(User_Model)`
  - `hasMany(Classes)`

## 📚 Educational Content

### `Classes`
- **Table:** `classes`
- **Primary Key:** `class_id`
- **Fields:** `classes_name`, `teacher_id`, `level`, `description`.
- **Relationships:**
  - `belongsTo(Teacher)`
  - `belongsToMany(Student)` via `class_student`.
  - `hasMany(OnlineSession)`

### `Assignment`
- **Table:** `assignments`
- **Fields:** `class_id`, `teacher_id`, `title`, `description`, `due_date`, `max_grade`.
- **Relationships:**
  - `belongsTo(Classes)` (accessor: `classRoom`)
  - `hasMany(AssignmentAttachment)`
  - `hasMany(AssignmentSubmission)`

### `AssignmentSubmission`
- **Table:** `assignment_submissions`
- **Fields:** `assignment_id`, `student_id`, `status` (submitted, late, graded), `grade`, `teacher_comment`.
- **Relationships:**
  - `belongsTo(Assignment)`
  - `belongsTo(Student)`
  - `hasMany(SubmissionVersion)`

## 🤖 Testing Engine

### `Test`
- **Table:** `test`
- **Fields:** `test_name`, `level`, `skill` (reading, writing, etc), `content`.
- **Relationships:**
  - `hasMany(Question)`
  - `hasMany(Result)`

### `Question` & `Option`
- Models for the static and AI-generated assessment bank.

---
Next: [Authentication Overview](../authentication/OVERVIEW.md)
