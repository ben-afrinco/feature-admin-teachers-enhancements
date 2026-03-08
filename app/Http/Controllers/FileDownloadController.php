<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AssignmentAttachment;
use App\Models\SubmissionVersion;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classes;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class FileDownloadController
 * 
 * Centralizes file download logic for the application. Implements strict
 * authorization checks to ensure only teachers or enrolled students can
 * access specific assignment materials and submissions.
 * 
 * @package App\Http\Controllers
 */
class FileDownloadController extends Controller
{
    /**
     * Download an Assignment Attachment.
     * 
     * Authorization logic:
     * - Teachers can download if they own the assignment.
     * - Students can download if they are enrolled in the class associated with the assignment.
     * 
     * @param int $id The ID of the AssignmentAttachment.
     * @return BinaryFileResponse
     */
    public function downloadAttachment($id)
    {
        $attachment = AssignmentAttachment::with('assignment')->findOrFail($id);
        
        $userId = session('user_id');
        $userRole = session('role');

        $isAuthorized = false;

        if ($userRole === 'teacher') {
            $teacherRecord = Teacher::where('user_id', $userId)->first();
            if ($teacherRecord && $attachment->assignment->teacher_id === $teacherRecord->teacher_id) {
                $isAuthorized = true;
            }
        } elseif ($userRole === 'student') {
            // Verify student is enrolled in the assignment's class
            $student = Student::where('user_id', $userId)->first();
            if ($student) {
                $enrolled = $student->classes()->where('classes.class_id', $attachment->assignment->class_id)->exists();
                if ($enrolled) {
                    $isAuthorized = true;
                }
            }
        }

        if (!$isAuthorized) {
            abort(403, 'Unauthorized access to this file.');
        }

        if (!Storage::disk('local')->exists($attachment->file_path)) {
            abort(404, 'File not found on server.');
        }

        return Storage::disk('local')->download($attachment->file_path, $attachment->file_name);
    }

    /**
     * Download a specific Submission Version.
     * 
     * Authorization logic:
     * - Teachers can download if they own the class for this assignment.
     * - Students can download only their own submission versions.
     * 
     * @param int $id The ID of the SubmissionVersion.
     * @return BinaryFileResponse
     */
    public function downloadSubmission($id)
    {
        $version = SubmissionVersion::with(['submission.assignment'])->findOrFail($id);
        
        $userId = session('user_id');
        $userRole = session('role');

        $isAuthorized = false;

        if ($userRole === 'teacher') {
            $teacherRecord = Teacher::where('user_id', $userId)->first();
            if ($teacherRecord && $version->submission->assignment->teacher_id === $teacherRecord->teacher_id) {
                $isAuthorized = true;
            }
        } elseif ($userRole === 'student') {
            // Compare with student_id from student table
            $student = Student::where('user_id', $userId)->first();
            if ($student && $version->submission->student_id == $student->student_id) {
                $isAuthorized = true;
            }
        }

        if (!$isAuthorized) {
            abort(403, 'Unauthorized access to this file.');
        }

        if (!$version->file_path || !Storage::disk('local')->exists($version->file_path)) {
            abort(404, 'File not found on server.');
        }

        return Storage::disk('local')->download($version->file_path);
    }
}

