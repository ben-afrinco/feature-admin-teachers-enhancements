# Function: join (OnlineSession)

## Path
`app/Http/Controllers/OnlineSessionController.php`

## Description
Authorizes and redirects a user to an ongoing live Jitsi session.

## How it works in code
- Validates the user has permission to join the specific session.
- Redirects to the Jitsi meeting URL with proper parameters.

## How to use from Browser
- Students and Teachers click the "Join Now" button on an active live class item.
