# LingoPulse Documentation Hub

Welcome to the official documentation for **LingoPulse**, an enterprise-level English language learning and AI-powered assessment platform.

## 📖 Table of Contents

### 1. [System Overview](SYSTEM_OVERVIEW.md)
A high-level view of what LingoPulse is and what problems it solves.

### 2. [Architecture](architecture/OVERVIEW.md)
Detailed breakdown of the system architecture, folder structure, and design patterns.
- [Folder Structure](architecture/FOLDER_STRUCTURE.md)
- [Architecture Decisions](ARCHITECTURE_DECISIONS.md)

### 3. [Authentication & Security](authentication/OVERVIEW.md)
How we secure the application and manage user roles.
- [User Roles & Permissions](security/PERMISSIONS.md)
- [RBAC Flow](authentication/RBAC.md)

### 4. [Database Schema](database/OVERVIEW.md)
Documentation of models, relationships, and migrations.
- [Model Reference](database/MODELS.md)

### 5. [Core Modules](modules/OVERVIEW.md)
Documentation for specific system features.
- [AI Test Engine](modules/ai-test-engine/OVERVIEW.md)
- [Assignments & Submissions](modules/assignments/OVERVIEW.md)
- [Online Sessions (Jitsi)](modules/online-sessions/OVERVIEW.md)

### 6. [Dashboards](modules/DASHBOARDS.md)
- [Admin Section](admin/OVERVIEW.md)
- [Teacher Section](teachers/OVERVIEW.md)

### 7. [Development & Operations](development/OVERVIEW.md)
- [Onboarding Guide](guides/ONBOARDING.md)
- [Deployment Guide](deployment/OVERVIEW.md)
- [Scaling & Performance](development/SCALING_PERFORMANCE.md)
- [Troubleshooting](guides/TROUBLESHOOTING.md)

### 8. [Resources](guides/OVERVIEW.md)
- [Project Glossary](guides/GLOSSARY.md)
- [Contributing](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)

---

## 🚀 Key Technologies
- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade, Tailwind CSS 4, Vite
- **AI Engine:** Google Gemini AI
- **Video:** Jitsi Meet Integration
- **Database:** SQLite/MySQL (Eloquent ORM)

---
© 2026 LingoPulse Team. All rights reserved.
