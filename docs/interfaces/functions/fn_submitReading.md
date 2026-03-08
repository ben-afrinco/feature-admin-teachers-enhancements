# Function: submitReading

## Path
`app/Http/Controllers/TestController.php`

## Description
Processes a student's answer for a reading test question.

## How it works in code
- Receives reading question ID and selected answer.
- Stores results in the database or session.
- Redirects to the next reading question or the next skill.

## How to use from Browser
- Triggered by clicking "Submit" on any reading test question page.
