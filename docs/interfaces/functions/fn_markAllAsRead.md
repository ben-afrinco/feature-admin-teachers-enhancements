# Function: markAllAsRead

## Path
`app/Http/Controllers/NotificationController.php`

## Description
Marks every notification for the current user as "read" simultaneously.

## How it works in code
- Updates all notifications for given `user_id` where `read_at` is NULL.

## How to use from Browser
- Users click the "Mark all as read" link at the top of their notification drawer.
