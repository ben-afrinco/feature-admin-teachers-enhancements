# Public Landing Interface

## Overview
The public landing interface serves as the entry point for all users (Guest, Student, Teacher, Admin). it provides general information about the platform and the "Next" button to begin the journey.

## UI Components
- **Heading**: "Welcome to LingoPulse AI"
- **Translate Button**: Allows switching language context.
- **Logo**: Site branding.
- **Next Button**: Forwards user to the account role selection screen.
- **How It Works**: Modal or section explaining platform features.

## Technical Implementation
- **Route**: `GET /` (named `index`)
- **Controller**: `App\Http\Controllers\LandingController@index`
- **View**: `resources/views/index.blade.php` (referenced via controller)

## How to use from Browser
1. Navigate to `http://localhost:8000`.
2. View the welcome message and branding.
3. Click "Next" to proceed to role selection.
