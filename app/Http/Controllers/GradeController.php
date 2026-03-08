<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;

/**
 * Class GradeController
 * 
 * Manages student grading within a class. Allows teachers to batch update
 * grades (midterm, final, oral) and add personal notes for each student.
 * 
 * @package App\Http\Controllers
 */
class GradeController extends Controller
{
    /**
     * Save/Update grades for multiple students in a specific class.
     * 
     * Validates teacher authorization for the class, then uses updateOrCreate
     * to persist multiple grade components simultaneously.
     * 
     * @param Request $request [class_id, grades[] -> {student_id, midterm, final, oral}]
     * @return JsonResponse
     */
    public function saveGrades(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,class_id',
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:user,user_id',
            'grades.*.midterm' => 'nullable|integer|min:0|max:100',
            'grades.*.final' => 'nullable|integer|min:0|max:100',
            'grades.*.oral' => 'nullable|integer|min:0|max:100',
        ]);

        $teacherId = Teacher::where('user_id', session('user_id'))->value('teacher_id');
        if (!$teacherId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        // Verify class belongs to teacher
        $classExists = Classes::where('class_id', $request->class_id)
            ->where('teacher_id', $teacherId)
            ->exists();

        if (!$classExists) {
            return response()->json(['success' => false, 'message' => 'Class not authorized for this teacher']);
        }

        foreach ($request->grades as $gradeData) {
            Grade::updateOrCreate(
                [
                    'user_id' => $gradeData['student_id'],
                    'class_id' => $request->class_id,
                ],
                [
                    'midterm' => $gradeData['midterm'] ?? null,
                    'final' => $gradeData['final'] ?? null,
                    'oral' => $gradeData['oral'] ?? null,
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Grades saved successfully.']);
    }

    /**
     * Save or update a private note for a specific student in a class.
     * 
     * Primarily used for qualitative feedback or internal teacher commentary.
     * 
     * @param Request $request [class_id, student_id, notes]
     * @return JsonResponse
     */
    public function saveNote(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,class_id',
            'student_id' => 'required|exists:user,user_id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $teacherId = Teacher::where('user_id', session('user_id'))->value('teacher_id');
        if (!$teacherId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        // Verify class belongs to teacher
        $classExists = Classes::where('class_id', $request->class_id)
            ->where('teacher_id', $teacherId)
            ->exists();

        if (!$classExists) {
            return response()->json(['success' => false, 'message' => 'Class not authorized for this teacher']);
        }

        Grade::updateOrCreate(
            [
                'user_id' => $request->student_id,
                'class_id' => $request->class_id,
            ],
            [
                'notes' => $request->notes,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Note saved successfully.']);
    }
}

