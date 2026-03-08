# Online Sessions (Video Classrooms)

LingoPulse integrates with **Jitsi Meet** to provide synchronous learning sessions without external meeting software dependencies.

## 🎥 Jitsi Meet Integration
Jitsi Meet is chosen for its open-source nature, privacy, and ease of embedding. No student or teacher accounts are required on the Jitsi platform.

## 🔄 The Session Lifecycle

### 1. Scheduling
- **Initiator**: Teacher.
- **Input**: Topic, Start Time, Duration.
- **Room Generation**: A unique, cryptographically secure `room_name` and `join_url` are generated automatically based on the session topic and timestamps.

### 2. Live Access
- **Discovery**: Sessions appear in the Teacher Dashboard (under "Sessions List") and the Student Dashboard for the respective class.
- **Joining**: Users click "Join Session". They are redirected to the integrated Jitsi interface (or the standalone URL depending on the blade implementation).

### 3. Management
- **Status tracking**: Sessions can be marked as `active`, `scheduled`, or `completed`.
- **Deletion**: Teachers can remove sessions they created, which immediately revokes access for students.

## 🏗 Data Structure: `online_sessions`
- `room_name`: Unique identifier for the Jitsi instance.
- `join_url`: Direct link to the meeting.
- `status`: Lifecycle state of the session.
- `class_id`: Links the session to a specific group of students.

## 🛡 Security & Privacy
- **Endpoint Protection**: Only authorized students of the specific class can see the `join_url`.
- **Ephemeral Meeting Rooms**: Meeting rooms are created on the fly and effectively expire once all users leave.

---
Next: [Admin Dashboard](../../admin/OVERVIEW.md)
