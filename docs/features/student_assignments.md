# Student Assignments Interface

## Overview
Allows students to view tasks assigned by teachers and upload their submissions.

## UI Components
- **Assignment List**: Table showing task title and description.
- **File Upload**: Drag-and-drop or file selector for submissions.
- **Download Buttons**: Retrieve teacher attachments.

## Technical Implementation
- **Route**: `GET /student/assignments`
- **Route (Upload)**: `POST /student/assignments/{id}/submit`
- **Controllers**: `AssignmentController`, `SubmissionController`.

## How to use from Browser
1. Click "Assignments" from the student dashboard.
2. Select a task to see details.
3. Upload your completed work file.
4. Click "Submit".
