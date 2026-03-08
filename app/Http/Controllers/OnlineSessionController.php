<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\OnlineSession;
use App\Models\User_Model;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;

/**
 * Class OnlineSessionController
 * 
 * Manages the lifecycle of live virtual classrooms, including scheduling,
 * Jitsi Meet integration, and secure JWT-based authentication for participants.
 * 
 * @package App\Http\Controllers
 */
class OnlineSessionController extends Controller
{

    /**
     * Store a newly created online session in storage using Jitsi Meet.
     * 
     * Validates teacher permissions and class associations before generating
     * a unique room name for the Jitsi conference.
     * 
     * @param Request $request [class_id, topic, duration, start_time]
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,class_id',
            'topic' => 'required|string|max:255',
            'duration' => 'required|integer|min:15|max:300',
            'start_time' => 'required|date',
        ]);

        $teacherRecord = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacherRecord) {
            return redirect()->back()->with('error', 'غير مصرح لك بإنشاء الجلسات.');
        }

        // Verify the class belongs to this teacher
        $class = Classes::where('class_id', $request->class_id)
                        ->where('teacher_id', $teacherRecord->teacher_id)
                        ->first();

        if (!$class) {
            return redirect()->back()->with('error', 'الفصل غير موجود أو غير مرتبط بحسابك.');
        }

        // Generate a unique room name for Jitsi
        $roomName = 'LingoPulse-' . Str::slug($request->topic) . '-' . uniqid();

        // Save meeting info in database — join_url will be generated dynamically with JWT
        $session = OnlineSession::create([
            'class_id' => $class->class_id,
            'teacher_id' => $teacherRecord->teacher_id,
            'room_name' => $roomName,
            'topic' => $request->topic,
            'join_url' => null, // Will be generated on join
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'status' => 'scheduled',
        ]);

        return redirect()->back()->with('success', 'تم جدولة الجلسة المباشرة بنجاح.');
    }

    /**
     * Join a session — generates a fresh JWT for the current user.
     * 
     * If Jitsi app credentials are provided, a secure JWT is created including 
     * the user's name, email, and roles (moderator vs member). Otherwise, 
     * falls back to a public Jitsi URL.
     * 
     * @param int $id The session ID.
     * @return RedirectResponse
     */
    public function join($id)
    {
        $session = OnlineSession::find($id);
        if (!$session) {
            return redirect()->back()->with('error', 'الجلسة غير موجودة.');
        }

        $userId = session('user_id');
        $user = User_Model::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        $role = $user->role; // 'teacher', 'student', 'admin'
        $isModerator = in_array($role, ['teacher', 'admin']);

        $jitsiDomain = env('JITSI_DOMAIN', 'meet.jit.si');
        $jitsiAppId = env('JITSI_APP_ID');
        $jitsiSecret = env('JITSI_APP_SECRET');

        // If Jitsi JWT credentials are configured, generate a signed token
        if ($jitsiAppId && $jitsiSecret) {
            $payload = [
                'context' => [
                    'user' => [
                        'name' => $user->full_name,
                        'email' => $user->email,
                        'affiliation' => $isModerator ? 'owner' : 'member',
                    ],
                ],
                'aud' => 'jitsi',
                'iss' => $jitsiAppId,
                'sub' => $jitsiDomain,
                'room' => $session->room_name,
                'moderator' => $isModerator,
                'iat' => time(),
                'exp' => time() + ($session->duration * 60) + 600, // session duration + 10 min buffer
            ];

            $jwt = JWT::encode($payload, $jitsiSecret, 'HS256');
            $joinUrl = "https://{$jitsiDomain}/{$session->room_name}?jwt={$jwt}";
        } else {
            // Fallback to public Jitsi (no JWT)
            $joinUrl = "https://{$jitsiDomain}/{$session->room_name}";
        }

        // Update session status if teacher is joining
        if ($isModerator && $session->status === 'scheduled') {
            $session->update(['status' => 'in_progress']);
        }

        return redirect($joinUrl);
    }

    /**
     * Remove the specified online session from the database.
     * 
     * Validates that the requesting user is the owner (teacher) of the session.
     * 
     * @param int $id The session ID.
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $session = OnlineSession::find($id);

        if (!$session) {
            return redirect()->back()->with('error', 'الجلسة غير موجودة.');
        }

        $teacherRecord = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacherRecord || $session->teacher_id != $teacherRecord->teacher_id) {
            return redirect()->back()->with('error', 'غير مصرح لك بحذف هذه الجلسة.');
        }

        $session->delete();

        return redirect()->back()->with('success', 'تم حذف الجلسة المباشرة بنجاح.');
    }
}

