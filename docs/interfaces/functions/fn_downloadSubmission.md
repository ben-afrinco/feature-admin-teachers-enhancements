# Function: downloadSubmission

## Path
`app/Http/Controllers/FileDownloadController.php`

## Description
Allows authorized users (Teachers/Admins) to download a student's assignment submission.

## How it works in code
- Verifies user role and submission existence.
- Streams the file from `storage/app/submissions`.

## How to use from Browser
- Teachers click the "Download" icon next to a student submission in the grade view.
