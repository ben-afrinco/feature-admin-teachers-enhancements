<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Class AssignmentController
 * 
 * Manages the lifecycle of academic assignments, including creation by teachers,
 * retrieval by students, and tracking of submissions and attachments.
 * 
 * @package App\Http\Controllers
 */
class AssignmentController extends Controller
{
    /**
     * Get all assignments for a specific class.
     * 
     * Primarily used for API consumption or dynamic front-end updates.
     * Includes related attachments and submissions for a comprehensive view.
     * 
     * @param int $class_id The ID of the class to fetch assignments for.
     * @return JsonResponse
     */
    public function getAssignmentsForClass($class_id)
    {
        // For API use, but we can also return a view if needed.
        $assignments = Assignment::with(['attachments', 'submissions'])
            ->where('class_id', $class_id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $assignments
        ]);
    }

    /**
     * Get all student submissions for a given assignment.
     * 
     * Restricted to the teacher who created the assignment.
     * Includes student user details and submission versions.
     * 
     * @param int $assignment_id The ID of the assignment to fetch submissions for.
     * @return JsonResponse
     */
    public function getSubmissions($assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        
        $teacherRecord = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacherRecord || $assignment->teacher_id !== $teacherRecord->teacher_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $submissions = \App\Models\AssignmentSubmission::with(['student.user', 'versions'])
            ->where('assignment_id', $assignment->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $submissions
        ]);
    }

    /**
     * Show assignments relevant to the currently logged-in student.
     * 
     * Checks all classes the student is enrolled in and retrieves associated
     * assignments along with the student's specific submission status.
     * 
     * @return View|JsonResponse Redirects or shows abort if not a student.
     */
    public function studentIndex()
    {
        $userId = session('user_id');
        $student = \App\Models\Student::with('classes')->where('user_id', $userId)->first();

        if (!$student) {
            abort(403, 'Unauthorized');
        }

        $classIds = $student->classes->pluck('class_id');

        $assignments = Assignment::with(['attachments', 'submissions' => function($q) use ($student) {
            $q->where('student_id', $student->student_id)->with('versions');
        }])
        ->whereIn('class_id', $classIds)
        ->orderBy('due_date', 'asc')
        ->get();

        return view('student.assignments', compact('assignments'));
    }

    /**
     * Store a newly created assignment.
     * 
     * Handles creation of the assignment record, attachment of multiple files
     * to secure private storage, and dispatching notifications to all students in the class.
     * 
     * @param Request $request [class_id, title, description, due_date, max_grade, files[]]
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,class_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:now',
            'max_grade' => 'nullable|numeric|min:0',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:20480', // Max 20MB per file
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $teacherRecord = Teacher::where('user_id', session('user_id'))->first();
        if (!$teacherRecord) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Verify ownership of the class
        $class = Classes::where('class_id', $request->class_id)
            ->where('teacher_id', $teacherRecord->teacher_id)
            ->first();

        if (!$class) {
            return response()->json(['success' => false, 'message' => 'Class not found or unauthorized'], 403);
        }

        $assignment = DB::transaction(function () use ($request, $class, $teacherRecord) {
            $assignment = Assignment::create([
                'class_id' => $class->class_id,
                'teacher_id' => $teacherRecord->teacher_id,
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'max_grade' => $request->max_grade ?? 100.00,
            ]);

            // Handle File Uploads (Secure Storage)
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    // Store in private disk
                    $path = $file->storeAs('private/assignments', $fileName, 'local');
                    
                    AssignmentAttachment::create([
                        'assignment_id' => $assignment->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            // Trigger Notification Queue here
            $students = $class->students()->with('user')->get();
            foreach ($students as $student) {
                if ($student->user) {
                    $student->user->notify(new \App\Notifications\AssignmentCreated($assignment->title, $class->classes_name));
                }
            }

            return $assignment;
        });

        return response()->json([
            'success' => true,
            'message' => 'Assignment created successfully.',
            'data' => $assignment->load('attachments')
        ]);
    }
}

