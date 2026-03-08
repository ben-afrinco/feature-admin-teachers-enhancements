# Function: delete (Avatar)

## Path
`app/Http/Controllers/AvatarController.php`

## Description
Removes the custom profile picture and reverts to the default placeholder.

## How it works in code
- Deletes the file from disk storage.
- Nullifies the `avatar` field in the user's database record.

## How to use from Browser
- Click "Remove Avatar" in the profile settings section.
