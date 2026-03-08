<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * List all students for admin developer view.
     */
    public function students()
    {
        $students = Student::with(['user', 'classRoom'])->get();
        return view('developer.students', compact('students'));
    }

    /**
     * List all teachers for admin developer view.
     */
    public function teachers()
    {
        $teachers = Teacher::with('user')->get();
        return view('developer.teachers', compact('teachers'));
    }
}
