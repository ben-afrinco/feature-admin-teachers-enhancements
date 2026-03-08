# Teacher Dashboard

## Overview
The central hub for teachers to manage classes, assignments, and view student progress.

## UI Components
- **Session Manager**: Create/Delete Jitsi Meet live sessions.
- **Assignment Manager**: Create assignments for specific classes.
- **Grade View**: Access student submissions and provide grades/notes.

## Technical Implementation
- **Route**: `GET /teacher` (named `teacher`)
- **Controller**: `LandingController@teacherDashboard`
- **Protected by**: `auth.session:teacher` middleware.

## How to use from Browser
1. Login as a Teacher.
2. Use the "Create Session" button for live lessons.
3. Access "Assignments" to post new tasks.
4. Open sub-menus to grade student files.
