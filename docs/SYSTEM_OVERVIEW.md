# System Overview: LingoPulse

## 🎯 Purpose
LingoPulse is a comprehensive platform designed to assess and improve English language proficiency through traditional methods and advanced AI-driven testing. It serves three primary user groups: **Students**, **Teachers**, and **Administrators**.

## 🌟 Core Value Propositions
1.  **AI-Powered Assessment**: Uses Google Gemini to dynamically generate tests and provide deep qualitative feedback on speaking, writing, reading, and listening.
2.  **Live Interaction**: Integrated Jitsi Meet for online real-time classrooms.
3.  **Assignment Management**: A full-cycle submission and grading system with version control for student work.
4.  **Skill Performance Tracking**: Granular breakdown of strengths and weaknesses across all language skills.

## 👥 User Roles & Capabilities

### 🎓 Student
- Take initial and dynamic AI-powered language tests.
- View detailed performance results and AI-generated improvement tips.
- Join live online sessions scheduled by teachers.
- View, submit, and track assignments.
- Practice language skills through specialized interfaces.

### 👩‍🏫 Teacher
- Manage classes and enrolled students.
- Schedule and manage Jitsi-based online sessions.
- Create and distribute assignments with attachments.
- Grade student submissions and provide feedback/notes.
- Monitor student progress through the teacher dashboard.

### 🔑 Admin
- Oversee the entire system.
- Manage users (creation, deletion, role assignment).
- Create and manage classes.
- Manage the question bank for the assessment engine.
- Monitor system-wide statistics.

## 🔄 Core Workflows

### 1. Assessment Workflow
`Entry` -> `Skill Baseline` -> `Dynamic AI Test` -> `Gemini Analysis` -> `Results Dashboard`

### 2. Assignment Workflow
`Teacher Creates` -> `Student Notified` -> `Student Submits (Versioned)` -> `Teacher Grades` -> `Student Notified`

### 3. Online Session Workflow
`Teacher Schedules` -> `Meeting ID Generated` -> `Room Available in Dashboard` -> `Join via Jitsi`

## 🛠 High-Level Tech Stack
- **Framework**: Laravel 12 (Modern PHP).
- **Communication**: Custom Session-based Auth (EnsureSessionAuth).
- **Intelligence**: Gemini-1.5-Pro / Flash integration.
- **Frontend**: Responsive Tailwind-driven Blade templates.
- **Storage**: Laravel Filesystem (Private disks for secure assignment storage).

---
Next: [Architecture Overview](architecture/OVERVIEW.md)
