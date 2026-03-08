# Test Results & Skill Breakdown

## Overview
Displays the student's proficiency levels across Reading, Listening, Writing, and Speaking after test completion.

## UI Components
- **Score Cards**: Overall CEFR level (A1-C2).
- **Skill Graphs**: Visual representation of performance.
- **Details Buttons**: Link to per-answer reviews.

## Technical Implementation
- **Route (Overview)**: `/test/results`
- **Route (Skill Drilldown)**: `/results/skill/{skill}`
- **Route (Details)**: `/results/details/{skill}`
- **Controller**: `App\Http\Controllers\ResultsController`

## How to use from Browser
1. Finish all four test sections.
2. View the generated score on the results redirect page.
3. Click on a specific skill card to see which questions were right or wrong.
