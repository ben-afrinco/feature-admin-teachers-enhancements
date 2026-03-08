# Function: deleteUser (Admin)

## Path
`app/Http/Controllers/LandingController.php`

## Description
Permanently removes a user account from the system.

## How it works in code
- Finds the `User_Model` by ID.
- Deletes the record and any associated student/teacher records depending on role.

## How to use from Browser
- Admins click the "Delete" (trash icon) button in the user management table.
