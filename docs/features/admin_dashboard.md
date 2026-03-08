# Admin (Developer) Dashboard

## Overview
The management interface for system-wide configuration, user management, and class setup.

## UI Components
- **User Management**: Create, update, and delete users (Teachers, Admins, Students).
- **Class Management**: Configure class structures and assignments.
- **Question Bank**: Manage the repository of test questions.

## Technical Implementation
- **Route**: `GET /developer` (named `developer`)
- **Controller**: `LandingController@developerDashboard`
- **Logic**: Performs CRUD operations on `User_Model`, `Class`, and `Question`.

## How to use from Browser
1. Login as an Admin.
2. Select categories (Users, Classes, Questions).
3. Use the modal forms to add or edit data.
4. Save changes to update the SQLite database.
