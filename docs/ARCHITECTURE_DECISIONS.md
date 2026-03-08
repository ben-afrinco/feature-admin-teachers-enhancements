# Architecture Decisions (ADR)

This document records the major architectural decisions made during the development of LingoPulse.

## ADR 1: Monolithic Architecture with Laravel
**Status:** Accepted
**Context:** We needed a robust, rapid-development framework to handle complex business logic (Test Engine) and UI (Dashboards) in a single unified codebase.
**Decision:** We chose Laravel (v12) for its excellent ORM, routing, and ecosystem.
**Consequences:** Easier deployment, unified auth, but must maintain strict code organization to avoid "God Controllers."

## ADR 2: Jitsi Meet for Video Conferencing
**Status:** Accepted
**Context:** Needed a scalable, open-source video solution without heavy per-user fees.
**Decision:** Integrated Jitsi Meet via generated room URLs.
**Consequences:** No server-side video hosting costs. Privacy is maintained via unique, non-predictable room names.

## ADR 3: Google Gemini for AI Assessment
**Status:** Accepted
**Context:** Required high-quality NLP for grading open-ended writing and speaking responses.
**Decision:** Use `google-gemini-php/client` to interact with Gemini 1.5.
**Consequences:** Dependency on external API, but provides state-of-the-art feedback that traditional algorithms cannot match.

## ADR 4: Session-Based Custom Authentication
**Status:** Accepted
**Context:** The project requires a straightforward yet secure role-based access system without the complexity of Laravel Breeze/Jetstream for the initial version.
**Decision:** Implemented `EnsureSessionAuth` middleware using Laravel's native session storage.
**Consequences:** Lightweight, but requires manual handling of login/logout redirects.

## ADR 5: Versioned Assignment Submissions
**Status:** Accepted
**Context:** Students often need to resubmit improved work.
**Decision:** Use a one-to-many relationship between `AssignmentSubmission` and `SubmissionVersion`.
**Consequences:** Preserves history of student progress and avoids accidental data loss during resubmission.

## ADR 6: Secure File Storage
**Status:** Accepted
**Context:** Assignment attachments and student submissions contain sensitive educational data.
**Decision:** Store all files in the `private/` directory (non-publicly accessible) and serve them through an authorized `FileDownloadController`.
**Consequences:** Ensures only enrolled students and their teachers can access specific files.

---
Next: [Architecture Overview](architecture/OVERVIEW.md)
