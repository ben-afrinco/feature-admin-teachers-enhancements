# Function: detailReading

## Path
`app/Http/Controllers/ResultsController.php`

## Description
Generates the detailed answer-by-answer report for the reading section of the test.

## How it works in code
- Retrives all questions from the reading test taken by the current student.
- Cross-references student answers with correct answers.
- Calculates sub-scores for the reading skill.

## How to use from Browser
- Click on "Review Reading Results" from the final results page.
