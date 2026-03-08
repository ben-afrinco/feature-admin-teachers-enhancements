<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

/**
 * Class AvatarController
 * 
 * Handles user profile picture operations, including secure upload, 
 * replacement of old avatars, and deletion.
 * 
 * @package App\Http\Controllers
 */
class AvatarController extends Controller
{
    /**
     * Upload and update the user's avatar.
     * 
     * Validates that the file is an image, deletes any existing avatar from storage,
     * saves the new file to the public disk, and updates the user record.
     * 
     * @param Request $request Encapsulates the uploaded file ('avatar').
     * @return JsonResponse Returns status and the public URL of the new avatar.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $userId = session('user_id');
        $user = User_Model::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'avatar_url' => asset('storage/' . $path),
        ]);
    }

    /**
     * Delete the user's current avatar.
     * 
     * Removes the file from storage and clears the avatar field in the user model.
     * 
     * @return JsonResponse
     */
    public function delete()
    {
        $userId = session('user_id');
        $user = User_Model::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return response()->json(['success' => true]);
    }
}

