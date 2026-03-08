<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class NotificationController
 * 
 * Manages user-specific notifications, including marking notifications as read
 * and retrieving unread alerts for real-time UI updates.
 * 
 * @package App\Http\Controllers
 */
class NotificationController extends Controller
{
    /**
     * Mark all unread notifications for the current user as read.
     * 
     * @return JsonResponse
     */
    public function markAllAsRead()
    {
        $userId = session('user_id');
        if ($userId) {
            $user = \App\Models\User_Model::find($userId);
            if ($user) {
                $user->unreadNotifications->markAsRead();
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * Mark a single specific notification as read.
     * 
     * @param string|int $id The UUID or incrementing ID of the notification.
     * @return JsonResponse
     */
    public function markAsRead($id)
    {
        $userId = session('user_id');
        if ($userId) {
            $user = \App\Models\User_Model::find($userId);
            if ($user) {
                $notification = $user->notifications()->where('id', $id)->first();
                if ($notification) {
                    $notification->markAsRead();
                }
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * Retrieve all unread notifications for the user.
     * 
     * Formats notification data for frontend display, including human-friendly time diffs.
     * 
     * @return JsonResponse Contains an array of notification objects.
     */
    public function getUnread()
    {
        $userId = session('user_id');
        $notifications = [];
        if ($userId) {
            $user = \App\Models\User_Model::find($userId);
            if ($user) {
                foreach ($user->unreadNotifications as $n) {
                    $notifications[] = [
                        'id' => $n->id,
                        'message' => $n->data['message'] ?? '',
                        'url' => $n->data['url'] ?? '#',
                        'time' => $n->created_at->diffForHumans(),
                        'read' => false
                    ];
                }
            }
        }
        return response()->json(['success' => true, 'notifications' => $notifications]);
    }
}

