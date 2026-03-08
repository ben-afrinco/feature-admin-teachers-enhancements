# Login Interface (Teacher/Admin)

## Overview
A secure entry point for Teacher and Admin roles via a modal or specific form.

## UI Components
- **Email Field**: User identification.
- **Password Field**: Secure credential input.
- **Login Button**: Submits the credentials to `auth.login`.

## Technical Implementation
- **Route (POST)**: `/auth/login` (named `auth.login`)
- **Logic**:
  - Validates email/password presence.
  - Checks against `User_Model` via Hash comparison.
  - Implements password re-hashing for security upgrades (transparent migration to Argon2id).
  - Redirects based on role:
    - Admin -> `/developer`
    - Teacher -> `/teacher`

## How to use from Browser
1. Select Teacher or Admin role in Role Selection.
2. Enter email and password (e.g., initial 123456).
3. Click "Login".
