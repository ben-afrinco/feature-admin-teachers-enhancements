<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\SubmissionVersion;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class SubmissionController
 * 
 * Orchestrates assignment responses, supporting multi-version archiving
 * and teacher-led grading reviews with automated feedback notifications.
 * 
 * @package App\Http\Controllers
 */
class SubmissionController extends Controller
{
    /**
     * Store a new submission or add a new version to an existing submission.
     * 
     * Maintains a permanent trail of all student revisions via the SubmissionVersion table.
     * Automatically triggers a notification to the responsible teacher.
     * 
     * @param Request $request [content, file]
     * @param int $assignment_id
     * @return RedirectResponse|JsonResponse
     */
    public function submit(Request $request, $assignment_id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:20480', // Max 20MB
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Must have at least one: content or file
        if (!$request->filled('content') && !$request->hasFile('file')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'يجب إرسال نص أو إرفاق ملف.'], 422);
            }
            return back()->with('error', 'يجب إرسال نص أو إرفاق ملف.')->withInput();
        }

        $assignment = Assignment::findOrFail($assignment_id);
        $student = Student::where('user_id', session('user_id'))->first();
        if (!$student) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized / Not a student'], 403);
            }
            abort(403, 'Unauthorized');
        }

        $isLate = Carbon::now()->gt(Carbon::parse($assignment->due_date));

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('private/submissions', $fileName, 'local');
        }

        DB::transaction(function () use ($assignment, $student, $isLate, $request, $filePath) {
            // Find or create the main submission tracker
            $submission = AssignmentSubmission::firstOrCreate(
                ['assignment_id' => $assignment->id, 'student_id' => $student->student_id],
                ['status' => $isLate ? 'late' : 'submitted']
            );

            // Even if found, update status to late if this version is late and it wasn't already graded
            if ($submission->status !== 'graded') {
                $submission->update(['status' => $isLate ? 'late' : 'submitted']);
            }

            $currentVersionNumber = $submission->versions()->max('version') ?? 0;

            SubmissionVersion::create([
                'submission_id' => $submission->id,
                'content' => $request->content,
                'file_path' => $filePath,
                'version' => $currentVersionNumber + 1,
                'is_late' => $isLate,
            ]);

            // Notify Teacher
            if ($assignment->teacher && $assignment->teacher->user) {
                $assignment->teacher->user->notify(new \App\Notifications\AssignmentSubmitted($student->user->full_name, $assignment->title, $submission->id));
            }
        });

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تسليم التكليف بنجاح.',
                'is_late' => $isLate
            ]);
        }

        $msg = $isLate ? 'تم تسليم التكليف بنجاح (متأخر).' : 'تم تسليم التكليف بنجاح.';
        return redirect()->route('student.assignments.index')->with('success', $msg);
    }

    /**
     * Assign a grade and provide qualitative feedback for a student submission.
     * 
     * Triggers the 'GradePublished' notification workflow.
     * 
     * @param Request $request [grade, teacher_comment]
     * @param int $submission_id
     * @return JsonResponse
     */
    public function grade(Request $request, $submission_id)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|numeric|min:0',
            'teacher_comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $submission = AssignmentSubmission::with('assignment')->findOrFail($submission_id);

        $teacherRecord = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacherRecord || $submission->assignment->teacher_id !== $teacherRecord->teacher_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized / Not the teacher of this class'], 403);
        }

        if ($request->grade > $submission->assignment->max_grade) {
            return response()->json(['success' => false, 'message' => 'الدرجة تتجاوز الحد الأقصى للتكليف.'], 422);
        }

        DB::transaction(function () use ($submission, $request) {
            $submission->update([
                'grade' => $request->grade,
                'teacher_comment' => $request->teacher_comment,
                'status' => 'graded'
            ]);

            // Trigger GradePublished Notification here
            if ($submission->student && $submission->student->user) {
                $submission->student->user->notify(new \App\Notifications\GradePublished($submission->assignment->title, $request->grade));
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'تم رصد الدرجة بنجاح.',
            'data' => $submission
        ]);
    }
}

