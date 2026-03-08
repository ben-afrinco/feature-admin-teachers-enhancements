# Online Live Sessions (Jitsi)

## Overview
Integrates Jitsi Meet to allow live video communication between teachers and students.

## UI Components
- **Session Create Form**: Modal for teachers.
- **Join Button**: Appears in dashboards for active sessions.
- **Video Interface**: Embedded Jitsi iFrame.

## Technical Implementation
- **Route (Store)**: `/teacher/session/create`
- **Route (Join)**: `/live-session/{id}/join`
- **Controller**: `App\Http\Controllers\OnlineSessionController`
- **Integration**: Generates JWT (optional) or public URLs for `meet.jit.si`.

## How to use from Browser
1. **Teacher**: Navigates to Dashboard -> Live Session -> Create.
2. **Student**: Navigates to Dashboard -> Join Active Session.
3. **Both**: Enter the video conference in-browser.
