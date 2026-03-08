# Function: saveGrades

## Path
`app/Http/Controllers/GradeController.php`

## Description
Saves numerical grades for a student's submission.

## How it works in code
- Updates the `Submission` model with new grade values.
- Triggers notification to the student.

## How to use from Browser
- Teachers enter numbers in the grading input fields and click "Save".
