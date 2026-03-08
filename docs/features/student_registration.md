# Student Registration Interface

## Overview
Allows students to register their personal details (names, email, phone) to create a session for taking the proficiency tests.

## UI Components
- **Input Fields**: First Name, Last Name, Email, Confirm Email, Phone (with country code dropdown).
- **Privacy Policy Checkbox**: Mandatory for proceeding.
- **Continue Button**: Triggers the `account.store` action.

## Technical Implementation
- **Route (GET)**: `/info_accountStudents`
- **Route (POST)**: `/account/store` (named `account.store`)
- **Logic**: 
  - Validates input.
  - Checks if user exists by email (auto-logins if yes).
  - Creates new `User_Model` and `Student` entry if new.
  - Sets session data: `user_id`, `role`, `name`.

## How to use from Browser
1. Select "Student" in Role Selection.
2. Fill in first/last name and email.
3. Check the privacy policy.
4. Click "Continue" to proceed to test instructions.
