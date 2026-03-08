# Detailed API & Route Reference

This document provides technical details for the primary endpoints used in LingoPulse.

## 🔐 Auth & Identity

### `POST /auth/login`
- **Controller**: `Closure` (Main Web Route).
- **Request**: `email`, `password`.
- **Response**: Redirect to dashboard or back with errors.
- **Middleware**: `guest`.

### `POST /account/store`
- **Controller**: `Closure` (Main Web Route).
- **Request**: `first_name`, `last_name`, `email`, `email_confirm`.
- **Logic**: Creates `User_Model` and `Student` profile. Sets default password `123456`.

---

## 🤖 AI Assessment Engine

### `GET /test/start`
- **Controller**: `TestController@startAI`.
- **Auth**: `auth.session:student`.
- **Action**: Triggers background calls to Groq/OpenRouter.
- **Result**: Populates `session('dynamic_test_ids')`.

### `POST /test/reading/q1`
- **Controller**: `TestController@submitReading`.
- **Request**: `q1`, `q2`, ... `q10`.
- **Logic**: Saves results to `dent_answers`.

### `POST /test/writing`
- **Controller**: `TestController@submitWriting`.
- **Request**: `essay` (long text).
- **Action**: Forwards to Gemini for evaluation. Saves to `evaluations`.

---

## 👩‍🏫 Teacher Operations

### `POST /teacher/assignments`
- **Controller**: `AssignmentController@store`.
- **Request**: `class_id`, `title`, `description`, `due_date`, `max_grade`, `files[]`.
- **Logic**: Creates assignment and attachments. Dispatches `NewAssignmentNotification`.

### `POST /teacher/submissions/{id}/grade`
- **Controller**: `SubmissionController@grade`.
- **Request**: `selected_grade`, `teacher_comment`.
- **Action**: Updates submission status to `graded`. Dispatches `AssignmentGradedNotification`.

---

## 🔑 Admin Operations

### `POST /admin/class/create`
- **Controller**: `LandingController@createClass`.
- **Request**: `className`, `teacherId`, `level`, `description`.

### `POST /admin/user/create`
- **Controller**: `LandingController@addUser`.
- **Request**: `firstName`, `lastName`, `email`, `role`.

---
Next: [Architecture Overview](../architecture/OVERVIEW.md)
