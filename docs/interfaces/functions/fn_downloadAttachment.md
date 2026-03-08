# Function: downloadAttachment

## Path
`app/Http/Controllers/FileDownloadController.php`

## Description
Allows students to download files attached to assignments by their teachers.

## How it works in code
- Finds the `Assignment` by ID.
- Downloads the file from the path stored in the database.

## How to use from Browser
- Students click the "Download Attachment" link on their personal assignment view.
