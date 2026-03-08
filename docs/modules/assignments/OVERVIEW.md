# Assignments & Submissions Module

LingoPulse provides a robust framework for non-automated, teacher-led assignments.

## 📋 Module Overview
Teachers can assign specific tasks to classes. Students receive notifications, download attachments, and upload their work.

## 🧱 Key Entities
- **Assignment**: The task definition (Title, Description, Due Date, Max Grade).
- **AssignmentAttachment**: Files (PDFs, Images, Worksheets) provided by the teacher.
- **AssignmentSubmission**: The student's response container.
- **SubmissionVersion**: Tracking of multiple uploads for the same assignment.

## 🔄 Functional Workflow

### 1. Assignment Creation
- **Role**: Teacher.
- **Logic**: Assignment is created for a specific `class_id`. New assignment notifications are dispatched to all students in that class.
- **Storage**: Attachments are stored in `private/assignments/`.

### 2. Student Submission
- **Role**: Student.
- **Logic**: Students can upload one or more files. Each submission creates a new instance in `assignment_submissions`. If a student uploads again before grading, it is tracked as a new `SubmissionVersion`.
- **Validation**: File size and type checks are enforced at the controller level.
- **Storage**: Files stored in `private/submissions/`.

### 3. Grading & Feedback
- **Role**: Teacher.
- **Logic**: Teachers review submissions through their dashboard. They can download the student's file, assign a numeric score (up to `max_grade`), and provide qualitative feedback.
- **Completion**: Once a grade is saved, the student receives a notification.

## 📂 Secure Download System
Because files are stored in a private directory, the system uses a shared `FileDownloadController`:
1.  **Request**: User clicks download link.
2.  **Auth Check**: Controller verifies the `user_id` and checks if they are the owner (student) or the supervisor (teacher) of that specific assignment/submission.
3.  **Stream**: If authorized, the file is streamed to the browser.

---
Next: [Online Sessions](online-sessions/OVERVIEW.md)
