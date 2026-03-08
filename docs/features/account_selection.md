# Account Selection Interface

## Overview
Allows users to specify their role before entering the main application flow.

## UI Components
- **Role Buttons**: "Student Exam", "Teacher Manage", and "Admin Control".
- **Back Button**: Returns to the landing page.
- **Next Button**: Confirms selection and redirects to the appropriate sub-flow.

## Technical Implementation
- **Route**: `GET /account-selection` (named `info_account`)
- **Controller**: `App\Http\Controllers\LandingController@info_account`
- **View**: `resources/views/landing/account_selection.blade.php`

## How to use from Browser
1. Click "Next" from the landing page.
2. Select one of the three role icons.
3. Click "Next" to continue.
