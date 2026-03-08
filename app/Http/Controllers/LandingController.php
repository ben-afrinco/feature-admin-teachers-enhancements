<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\TestResultsMail;
use App\Models\User_Model;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use App\Models\Classes;
use App\Models\Question;
use App\Models\Result;
use App\Models\Test;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Class LandingController
 * 
 * Orchestrates the primary user experience across different roles.
 * Manages dashboards for Students, Teachers, and Admins, handles user registration
 * flows, results processing, and integration with Gemini AI for educational insights.
 * 
 * @package App\Http\Controllers
 */
class LandingController extends Controller
{
    /**
     * Show the application landing page.
     * 
     * @return View
     */
    public function index() { return view('landing.index'); }

    /**
     * Show test-taking instructions to students.
     * 
     * @return View
     */
    public function test_instructions() { return view('student.tests.instructions'); }

    /**
     * Show the account registration/info completion page.
     * 
     * @return View
     */
    public function info_account() { return view('auth.info_account'); }

    /**
     * Admin "teat" view — provides a specialized layout for managing students and classes.
     * 
     * Aggregates students and groups them by their assigned classes to facilitate
     * high-level administrative oversight.
     * 
     * @return View
     */
    public function teat() 
    {
        $students = User_Model::where('role', 'student')->get();

        // Build classes data
        $classesRaw = Classes::with('teacher.user')->get();
        $classes = $classesRaw->map(function($cls) {
            return [
                'id' => $cls->class_id,
                'name' => $cls->classes_name,
                'code' => 'CLS-' . $cls->class_id,
                'description' => $cls->description ?? 'فصل دراسي',
                'students' => $cls->students()->count(),
                'level' => $cls->level ?? 'Mixed'
            ];
        });

        // Build students grouped by class
        $studentsByClass = [];
        foreach($classesRaw as $cls) {
            $classStudents = $cls->students()->with('user')->get()->map(function($student) {
                return [
                    'id' => $student->user->user_id ?? $student->student_id,
                    'name' => $student->user->full_name ?? 'N/A',
                    'email' => $student->user->email ?? '',
                    'level' => $student->level ?? 'General',
                    'avatar' => $student->user->avatar ? asset('storage/' . $student->user->avatar) : mb_substr($student->user->full_name ?? 'NA', 0, 2)
                ];
            });
            $studentsByClass[$cls->class_id] = $classStudents->toArray();
        }

        return view('admin.dashboard', compact('students', 'classes', 'studentsByClass'));
    }

    /**
     * Comprehensive Admin Dashboard.
     * 
     * Fetches and paginates students, teachers, courses, and questions.
     * Aggregates platform-wide statistics and generates data for registration 
     * and role-distribution charts.
     * 
     * @return View
     */
    public function developerDashboard() 
    {
        $allStudents = User_Model::where('role', 'student')->paginate(15, ['*'], 'students_page');
        $allStudents->getCollection()->transform(function($user) {
            $student = $user->student;
            return [
                'id' => $user->user_id,
                'name' => $user->full_name,
                'email' => $user->email,
                'level' => $student && $student->level ? $student->level : 'N/A',
                'status' => 'active', 
                'joinDate' => $user->created_at ? $user->created_at->format('Y-m-d') : now()->format('Y-m-d')
            ];
        });

        $allTeachers = User_Model::where('role', 'teacher')->paginate(15, ['*'], 'teachers_page');
        $allTeachers->getCollection()->transform(function($user) {
            return [
                'id' => $user->user_id,
                'name' => $user->full_name,
                'email' => $user->email,
                'specialization' => 'English', 
                'status' => 'active', 
                'joinDate' => $user->created_at ? $user->created_at->format('Y-m-d') : now()->format('Y-m-d')
            ];
        });

        $allCourses = Classes::with('teacher.user')->paginate(15, ['*'], 'courses_page');
        $allCourses->getCollection()->transform(function($cls) {
            return [
                'id' => $cls->class_id,
                'name' => $cls->classes_name,
                'level' => $cls->level ?? 'Mixed',
                'duration' => 12,
                'students' => $cls->students()->count(),
                'status' => 'active'
            ];
        });

        $allQuestions = Question::paginate(15, ['*'], 'questions_page');
        $allQuestions->getCollection()->transform(function($q) {
            return [
                'id' => $q->question_id,
                'text' => $q->question_text ?? $q->content ?? '',
                'type' => $q->question_type ?? 'multiple-choice',
                'difficulty' => $q->difficulty_level ?? 'medium',
                'date' => $q->created_at ? $q->created_at->format('Y-m-d') : now()->format('Y-m-d')
            ];
        });
        
        $stats = [
            'total_users' => User_Model::count(),
            'students' => User_Model::where('role', 'student')->count(),
            'teachers' => User_Model::where('role', 'teacher')->count(),
            'admins' => User_Model::where('role', 'admin')->count(),
        ];

        // Chart Data Aggregation
        $monthlyRegs = User_Model::select('created_at')->get()
            ->groupBy(fn($u) => $u->created_at ? $u->created_at->format('Y-m') : now()->format('Y-m'))
            ->map->count()->take(-6);
            
        $userRoles = User_Model::select('role')->get()
            ->groupBy('role')->map->count();

        $chartsData = [
            'labels_regs' => $monthlyRegs->keys()->toArray(),
            'data_regs' => $monthlyRegs->values()->toArray(),
            'labels_roles' => $userRoles->keys()->toArray(),
            'data_roles' => $userRoles->values()->toArray(),
        ];

        $aiAnalysis = null; // We will load this async via API

        return view('admin.dashboard', compact('stats', 'allStudents', 'allTeachers', 'allCourses', 'allQuestions', 'aiAnalysis', 'chartsData'));
    }


    /**
     * API endpoint to get strategic AI insights for the Admin Dashboard.
     * 
     * @return JsonResponse
     */
    public function getAdminGeminiAnalysisApi()
    {
        $stats = [
            'total_users' => User_Model::count(),
            'students' => User_Model::where('role', 'student')->count(),
            'teachers' => User_Model::where('role', 'teacher')->count(),
            'admins' => User_Model::where('role', 'admin')->count(),
        ];
        $aiAnalysis = $this->getAdminGeminiAnalysis($stats);
        return response()->json($aiAnalysis);
    }

    /**
     * Teacher Dashboard.
     * 
     * Personalized for the logged-in teacher. Fetches assigned classes, students 
     * (grouped by class), upcoming online sessions, active assignments, and 
     * compiled student grades/notes.
     * 
     * @return View
     */
    public function teacherDashboard()
    {
        $teacherUserId = session('user_id');
        $teacherRecord = Teacher::where('user_id', $teacherUserId)->first();
        
        // Fetch classes assigned to this teacher
        $classes = collect();
        if ($teacherRecord) {
            $classes = Classes::where('teacher_id', $teacherRecord->teacher_id)->get()->map(function($cls) {
                return [
                    'id' => $cls->class_id,
                    'name' => $cls->classes_name,
                    'code' => 'CLS-' . $cls->class_id,
                    'description' => $cls->description ?? 'فصل دراسي',
                    'students' => $cls->students()->count(),
                    'level' => $cls->level ?? 'Mixed'
                ];
            });
        }
        
        // Build students grouped by class — real data from pivot table
        $studentsByClass = [];
        if ($teacherRecord) {
            $teacherClasses = Classes::where('teacher_id', $teacherRecord->teacher_id)->get();
            foreach($teacherClasses as $cls) {
                $classStudents = $cls->students()->with('user')->get()->map(function($student) {
                    return [
                        'id' => $student->user->user_id ?? $student->student_id,
                        'name' => $student->user->full_name ?? 'N/A',
                        'email' => $student->user->email ?? '',
                        'level' => $student->level ?? 'General',
                        'avatar' => $student->user->avatar ? asset('storage/' . $student->user->avatar) : mb_substr($student->user->full_name ?? 'NA', 0, 2)
                    ];
                });
                $studentsByClass[$cls->class_id] = $classStudents->toArray();
            }
        }

        // Fetch online sessions
        $sessions = collect();
        if ($teacherRecord) {
            $sessions = \App\Models\OnlineSession::with('classRoom')
                            ->where('teacher_id', $teacherRecord->teacher_id)
                            ->orderBy('start_time', 'desc')->paginate(10, ['*'], 'sessions_page');
        } else {
            $sessions = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        // Fetch assignments
        $assignments = collect();
        if ($teacherRecord) {
            $assignments = \App\Models\Assignment::with('classRoom', 'submissions.student')
                            ->where('teacher_id', $teacherRecord->teacher_id)
                            ->orderBy('created_at', 'desc')->paginate(10, ['*'], 'assignments_page');
        } else {
            $assignments = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        // Fetch grades and notes for these classes
        $grades = \App\Models\Grade::whereIn('class_id', $classes->pluck('id'))->get();
        
        $gradesData = [];
        $notesData = [];
        foreach ($grades as $grade) {
            $gradesData[$grade->class_id][$grade->user_id] = [
                'midterm' => $grade->midterm ?? 0,
                'final' => $grade->final ?? 0,
                'oral' => $grade->oral ?? 0
            ];
            if ($grade->notes) {
                $notesData[$grade->class_id][$grade->user_id] = [
                    'text' => $grade->notes,
                    'date' => $grade->updated_at->format('Y-m-d')
                ];
            }
        }
        // Fetch teacher quizzes (tests created by this teacher)
        $quizzes = collect();
        if ($teacherRecord) {
            $quizzes = Test::where('teacher_id', $teacherRecord->teacher_id)
                          ->with('questions')
                          ->orderBy('created_at', 'desc')
                          ->get();
        }

        return view('teacher.dashboard', compact('classes', 'studentsByClass', 'sessions', 'assignments', 'gradesData', 'notesData', 'quizzes'));
    }

    /**
     * Submit account creation form.
     * 
     * Handles manual user creation by admins or self-registration if enabled.
     * Assigns specific role records (Student, Teacher, Admin) and triggers 
     * notifications for new student registrations.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function submitAccount(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:user,email',
            'role' => 'required|in:student,teacher,admin',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً، يرجى استخدام بريد آخر.',
        ]);

        $user = User_Model::create([
            'full_name' => $request->firstName . ' ' . $request->lastName,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'role' => $request->role,
        ]);

        if ($request->role == 'student') {
            Student::create(['user_id' => $user->user_id]);
            
            // Notify admins
            $admins = User_Model::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\StudentRegistered($user->full_name));
            }
        } elseif ($request->role == 'teacher') {
            Teacher::create(['user_id' => $user->user_id]);
        } elseif ($request->role == 'admin') {
            Admin::create(['user_id' => $user->user_id]);
        }

        session(['user_id' => $user->user_id, 'role' => $user->role, 'name' => $user->full_name]);

        switch ($request->role) {
            case 'student':
                return redirect()->route('test_instructions');
            case 'teacher':
                return redirect()->route('teacher');
            case 'admin':
                return redirect()->route('developer');
            default:
                return redirect()->route('index');
        }
    }

    /**
     * Student Results page.
     * 
     * Aggregates scores from reading, listening, writing, and speaking skills.
     * Triggers an automated results email on first load and invokes Gemini AI
     * to provide a qualitative performance analysis.
     * 
     * @return View|RedirectResponse
     */
    public function results()
    {
        $user_id = session('user_id');
        if (!$user_id) return redirect()->route('info_account')->with('error','Please register first.');

        $user = User_Model::find($user_id);

        $scores = [
            'reading' => 0,
            'listening' => 0,
            'writing' => 0,
            'speaking' => 0
        ];

        $results = Result::where('user_id', $user_id)->get();

        foreach($results as $res) {
            $test = Test::find($res->test_id);
            if ($test && array_key_exists($test->skill, $scores)) {
                $scores[$test->skill] = $res->final_score;
            }
        }

        // Send results email to the student
        if ($user && $user->email && array_sum(array_values($scores)) > 0) {
            try {
                // Use score-hash based key so email re-sends if scores change
                $emailKey = 'results_email_sent_' . md5(json_encode($scores));
                if (!session($emailKey)) {
                    Mail::to($user->email)->send(new TestResultsMail($user->full_name, $scores));
                    session([$emailKey => true]);
                    Log::info("Results email sent to {$user->email} with scores: " . json_encode($scores));
                }
            } catch (\Exception $e) {
                Log::error("Failed to send results email to {$user->email}: " . $e->getMessage());
            }
        }

        // --- Gemini AI Analysis ---
        $aiAnalysis = $this->getGeminiAnalysis($scores);
        
        return view('student.dashboard', compact('scores', 'aiAnalysis'));
    }


    /**
     * Call Gemini API to generate AI-powered analysis of student performance.
     * 
     * Uses session caching to avoid redundant API calls for the same scores.
     * Implements multi-model fallback and rigorous JSON parsing to handle AI output variants.
     * 
     * @param array $scores Key-value pairs of skills and their numeric scores.
     * @return array Analysis containing strengths, weaknesses, advice, and CEFR level.
     */
    private function getGeminiAnalysis(array $scores): array
    {
        // Default fallback structure
        $fallback = [
            'strengths_ar' => [],
            'strengths_en' => [],
            'weaknesses_ar' => [],
            'weaknesses_en' => [],
            'advice_ar' => '',
            'advice_en' => '',
            'cefr_level' => '',
            'cefr_description_ar' => '',
            'cefr_description_en' => '',
        ];

        // Don't call API if all scores are 0
        if (array_sum(array_values($scores)) <= 0) {
            return $fallback;
        }

        // Use cached analysis from session to avoid redundant API calls
        $cacheKey = 'ai_analysis_' . md5(json_encode($scores));
        if (session()->has($cacheKey)) {
            return session($cacheKey);
        }

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::warning('Gemini API key missing for results analysis.');
            return $fallback;
        }

        $reading = (int) $scores['reading'];
        $listening = (int) $scores['listening'];
        $writing = (int) $scores['writing'];
        $speaking = (int) $scores['speaking'];
        $overall = (int) round(($reading + $listening + $writing + $speaking) / 4);

        $prompt = <<<PROMPT
You are an expert English language assessment analyst. A student just completed an English proficiency test with these scores (out of 100):

- Reading: {$reading}%
- Listening: {$listening}%
- Writing: {$writing}%
- Speaking: {$speaking}%
- Overall Average: {$overall}%

Based on these scores, provide a detailed analysis. Reply ONLY with valid JSON in this exact structure (no markdown, no code fences):
{
  "strengths_ar": ["نقطة قوة 1 مفصلة", "نقطة قوة 2 مفصلة", "نقطة قوة 3 مفصلة"],
  "strengths_en": ["Detailed strength 1", "Detailed strength 2", "Detailed strength 3"],
  "weaknesses_ar": ["نقطة ضعف 1 مفصلة مع سبب", "نقطة ضعف 2 مفصلة مع سبب", "نقطة ضعف 3 مفصلة مع سبب"],
  "weaknesses_en": ["Detailed weakness 1 with reason", "Detailed weakness 2 with reason", "Detailed weakness 3 with reason"],
  "advice_ar": "فقرة تحليل مفصلة بالعربية...",
  "advice_en": "A detailed analysis paragraph in English...",
  "cefr_level": "B1",
  "cefr_description_ar": "وصف مختصر للمستوى بالعربية بناءً على الأداء الفعلي",
  "cefr_description_en": "Brief CEFR level description based on actual performance"
}

Rules:
- Strengths should highlight what the student did well, mentioning specific skills and scores.
- Weaknesses should identify areas needing improvement with actionable reasons.
- If a skill score is below 50%, it must appear in weaknesses.
- If a skill score is above 70%, it should appear in strengths.
- The advice section should be comprehensive, encouraging, and provide specific learning strategies.
- All Arabic text must be fluent and natural Arabic (not translated).
- Provide exactly 3 strengths and 3 weaknesses.
- cefr_level MUST be one of: A1, A2, B1, B2, C1, C2 based on the overall performance.
- cefr_description should explain why this level was assigned based on the scores.
PROMPT;

        $models = ['gemini-flash-latest'];
        $client = \Gemini::client($apiKey);

        foreach ($models as $modelName) {
            try {
                $response = $client->generativeModel($modelName)->generateContent($prompt);
                $raw = trim($response->text());

                // Strip markdown code fences if present
                $jsonString = preg_replace('/^```(?:json)?\s*/i', '', $raw);
                $jsonString = preg_replace('/\s*```$/i', '', $jsonString);
                $jsonString = trim($jsonString);

                $result = json_decode($jsonString, true);

                if (json_last_error() === JSON_ERROR_NONE &&
                    isset($result['strengths_ar']) && isset($result['weaknesses_ar']) && isset($result['advice_ar'])) {
                    
                    $analysis = [
                        'strengths_ar' => (array) $result['strengths_ar'],
                        'strengths_en' => (array) ($result['strengths_en'] ?? $result['strengths_ar']),
                        'weaknesses_ar' => (array) $result['weaknesses_ar'],
                        'weaknesses_en' => (array) ($result['weaknesses_en'] ?? $result['weaknesses_ar']),
                        'advice_ar' => (string) $result['advice_ar'],
                        'advice_en' => (string) ($result['advice_en'] ?? $result['advice_ar']),
                        'cefr_level' => (string) ($result['cefr_level'] ?? ''),
                        'cefr_description_ar' => (string) ($result['cefr_description_ar'] ?? ''),
                        'cefr_description_en' => (string) ($result['cefr_description_en'] ?? ''),
                    ];

                    // Cache in session
                    session([$cacheKey => $analysis]);
                    Log::info("Gemini ($modelName) generated results analysis successfully.");
                    return $analysis;
                } else {
                    Log::warning("Gemini ($modelName) returned unparseable analysis: $raw");
                    continue;
                }
            } catch (\Exception $e) {
                Log::warning("Gemini ($modelName) analysis failed: " . $e->getMessage());
                continue;
            }
        }

        Log::error("All Gemini models failed for results analysis. Using fallback.");
        return $fallback;
    }

    /**
     * Retrieve a comprehensive user profile for administrative review.
     * 
     * Includes personal info, class enrollments, grades, assignment submissions,
     * and test results.
     * 
     * @param int $id The user object ID.
     * @return JsonResponse
     */
    public function getUserProfile($id)
    {
        $user = User_Model::with(['student.classes', 'teacher', 'results.test'])->find($id);
        if (!$user) return response()->json(['success' => false, 'message' => 'User not found']);

        $profile = [
            'id' => $user->user_id,
            'name' => $user->full_name,
            'email' => $user->email,
            'role' => $user->role,
            'joined' => $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A',
            'last_login' => $user->updated_at ? $user->updated_at->format('Y-m-d H:i') : 'N/A',
        ];

        $enrollments = [];
        $grades = [];
        $submissions = [];

        if ($user->role === 'student' && $user->student) {
            $enrollments = $user->student->classes->map(fn($c) => ['name' => $c->classes_name, 'level' => $c->level]);

            $dbGrades = \App\Models\Grade::with('classRoom')->where('user_id', $user->user_id)->get();
            $grades = $dbGrades->map(fn($g) => [
                'class' => $g->classRoom ? $g->classRoom->classes_name : 'N/A',
                'midterm' => $g->midterm, 'final' => $g->final, 'oral' => $g->oral, 'notes' => $g->notes
            ]);

            $dbSubmissions = \App\Models\AssignmentSubmission::with('assignment')->where('student_id', $user->student->student_id)->get();
            $submissions = $dbSubmissions->map(fn($s) => [
                'assignment' => $s->assignment ? $s->assignment->title : 'N/A',
                'status' => $s->status, 'grade' => $s->grade,
            ]);
        } elseif ($user->role === 'teacher' && $user->teacher) {
            $enrollments = \App\Models\Classes::where('teacher_id', $user->teacher->teacher_id)->get()->map(fn($c) => ['name' => $c->classes_name, 'level' => $c->level]);
        }

        return response()->json([
            'success' => true,
            'profile' => $profile,
            'enrollments' => $enrollments,
            'grades' => $grades,
            'submissions' => $submissions,
            'tests' => $user->results->map(fn($r) => ['test' => $r->test ? $r->test->test_name : 'N/A', 'score' => $r->final_score])
        ]);
    }

    /**
     * Delete a user and all their associated role records and results.
     * 
     * @param int $id The user ID.
     * @return RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User_Model::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'المستخدم غير موجود.');
        }

        // Delete related records
        Student::where('user_id', $id)->delete();
        Teacher::where('user_id', $id)->delete();
        Admin::where('user_id', $id)->delete();
        Result::where('user_id', $id)->delete();
        $user->delete();

        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح.');
    }

    /**
     * Edit user basic information and level (if student).
     * 
     * @param Request $request [full_name, email, role, level]
     * @param int $id
     * @return RedirectResponse
     */
    public function editUser(Request $request, $id)
    {
        $user = User_Model::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'المستخدم غير موجود.');
        }

        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:user,email,' . $user->user_id . ',user_id',
            'role' => 'required|in:student,teacher,admin',
            'level' => 'nullable|string|max:50',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني مستخدم مسبقاً لشخص آخر.',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Handle Role specific data (Level for student)
        if ($request->role === 'student' && $request->filled('level')) {
            $student = Student::firstOrCreate(['user_id' => $user->user_id]);
            $student->update(['level' => $request->level]);
        }

        return redirect()->back()->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    /**
     * Create a new classroom.
     * 
     * @param Request $request [class_name, teacher_id, level, description]
     * @return RedirectResponse
     */
    public function createClass(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:100',
            'teacher_id' => 'nullable|integer',
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
        ]);

        Classes::create([
            'classes_name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
            'level' => $request->level ?? 'Mixed',
            'description' => $request->description ?? '',
        ]);

        return redirect()->back()->with('success', 'تم إنشاء الفصل بنجاح.');
    }

    /**
     * Edit classroom details.
     * 
     * @param Request $request [class_name, teacher_id, level, description]
     * @param int $id The class ID.
     * @return RedirectResponse
     */
    public function editClass(Request $request, $id)
    {
        $class = Classes::where('class_id', $id)->first();
        if (!$class) {
            return redirect()->back()->with('error', 'الفصل غير موجود.');
        }

        $request->validate([
            'class_name' => 'required|string|max:100',
            'teacher_id' => 'nullable|integer',
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
        ]);

        $class->update([
            'classes_name' => $request->class_name,
            'teacher_id' => $request->teacher_id,
            'level' => $request->level ?? 'Mixed',
            'description' => $request->description ?? '',
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات الفصل بنجاح.');
    }


    /**
     * Delete a class (admin only)
     */
    public function deleteClass($id)
    {
        $class = Classes::where('class_id', $id)->first();
        if (!$class) {
            return redirect()->back()->with('error', 'الفصل غير موجود.');
        }

        // Delete assignments associated with this class
        \App\Models\Assignment::where('class_id', $id)->delete();
        // Detach students if a pivot table was used, or if there's a StudentClass model handle it here
        // Currently, class_id might be set on student directly, or via pivot. 
        // For safe cascading, assuming it's safe to just delete the class entity.
        $class->delete();

        return redirect()->back()->with('success', 'تم حذف الفصل بنجاح.');
    }

    /**
     * Add a new user (admin only) — real DB operation
     */
    public function addUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:user,email',
            'role' => 'required|in:student,teacher',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً.',
        ]);

        $user = User_Model::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'role' => $request->role,
        ]);

        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->user_id,
                'level' => $request->level ?? null,
            ]);
        } elseif ($request->role === 'teacher') {
            Teacher::create(['user_id' => $user->user_id]);
        }

        return redirect()->back()->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    /**
     * Add a new question (admin only) — real DB operation
     */
    public function addQuestion(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:multiple-choice,true-false,fill-blank',
            'difficulty_level' => 'required|string|in:easy,medium,hard',
        ]);

        // Find or create a general test to attach the question to
        $test = Test::first();
        if (!$test) {
            $test = Test::create([
                'test_name' => 'General Test',
                'level' => 'Beginner',
                'skill' => 'reading',
            ]);
        }

        Question::create([
            'test_id' => $test->test_id,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'difficulty_level' => $request->difficulty_level,
        ]);

        return redirect()->back()->with('success', 'تم إضافة السؤال بنجاح.');
    }

    /**
     * Edit a question (admin only) — real DB operation
     */
    public function editQuestion(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|string|in:multiple-choice,true-false,fill-blank',
            'difficulty_level' => 'required|string|in:easy,medium,hard',
        ]);

        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->with('error', 'السؤال غير موجود.');
        }

        $question->update([
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
            'difficulty_level' => $request->difficulty_level,
        ]);

        return redirect()->back()->with('success', 'تم تعديل السؤال بنجاح.');
    }

    /**
     * Delete a question (admin only) — real DB operation
     */
    public function deleteQuestion($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->with('error', 'السؤال غير موجود.');
        }

        // Delete associated options and answers first if necessary (assuming cascading deletes aren't set up)
        \App\Models\Option::where('question_id', $id)->delete();
        \App\Models\DentAnswer::where('question_id', $id)->delete();
        
        $question->delete();

        return redirect()->back()->with('success', 'تم حذف السؤال بنجاح.');
    }

    /**
     * Call Gemini API to generate AI-powered insights for the Admin Dashboard
     */
    private function getAdminGeminiAnalysis(array $stats): array
    {
        $fallback = [
            'strengths_ar' => ['لا توجد بيانات كافية حالياً.', 'أداء النظام مستقر.', 'تفاعل المستخدمين ضمن المعدل.'],
            'strengths_en' => ['Not enough data currently.', 'System performance is stable.', 'User engagement is average.'],
            'weaknesses_ar' => ['يحتاج النظام إلى مزيد من المستخدمين للتحليل الدقيق.', 'لا توجد بيانات مقارنة كافية.', 'يرجى مراجعة تفاعل الطلاب مع الدورات.'],
            'weaknesses_en' => ['The system needs more users for accurate analysis.', 'Not enough comparative data.', 'Please review student engagement with courses.'],
            'advice_ar' => 'هذه رؤى أولية. يرجى التركيز على زيادة عدد الطلاب المسجلين وإضافة المزيد من الدورات والأسئلة لتحقيق أقصى استفادة من تحليل النظام.',
            'advice_en' => 'These are preliminary insights. Please focus on increasing enrolled students and adding more courses and questions to maximize system analysis.'
        ];

        // Ensure we don't spam the API unnecessarily if the site is nearly empty
        if ($stats['total_users'] <= 1) {
            return $fallback;
        }

        $cacheKey = 'admin_ai_analysis_' . md5(json_encode($stats) . date('Y-m-d'));
        if (session()->has($cacheKey)) {
            return session($cacheKey);
        }

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::warning('Gemini API key missing for Admin insights.');
            return $fallback;
        }

        $studentsCount = $stats['students'];
        $teachersCount = $stats['teachers'];
        $totalUsers = $stats['total_users'];
        $coursesCount = Classes::count();
        $questionsCount = Question::count();

        $prompt = <<<PROMPT
You are an expert AI Data Analyst evaluating an e-learning platform's overall metrics.
Here are the current platform statistics:
- Total Registered Users: {$totalUsers}
- Total Students: {$studentsCount}
- Total Teachers: {$teachersCount}
- Total Active Courses: {$coursesCount}
- Total Questions in Bank: {$questionsCount}

Provide a strategic analysis of these metrics for the Platform Administrator. Reply ONLY with valid JSON in this exact structure:
{
  "strengths_ar": ["نقطة قوة في أداء المنصة", "نقطة قوة 2", "نقطة قوة 3"],
  "strengths_en": ["Platform strength 1", "Platform strength 2", "Platform strength 3"],
  "weaknesses_ar": ["نقطة تحتاج للتطوير أو تحدي تواجهه المنصة", "تحدي 2", "تحدي 3"],
  "weaknesses_en": ["Area for improvement 1", "Area for improvement 2", "Area for improvement 3"],
  "advice_ar": "نصيحة استراتيجية عامة باللغة العربية بناءً على الأرقام الحالية لتحسين أداء المنصة وجذب المزيد من المستخدمين والمعلمين.",
  "advice_en": "General strategic advice in English based on current numbers to improve platform performance."
}

Rules:
- Strengths should focus on the current ratios (e.g., student-to-teacher ratio, content volume).
- Weaknesses should realistically point out what might be lacking based on the numbers.
- The advice must be strategic, professional, and actionable for an Admin.
- Only respond with the JSON. Exactly 3 strengths and 3 weaknesses.
PROMPT;

        $models = ['gemini-flash-latest'];
        $client = \Gemini::client($apiKey);

        foreach ($models as $modelName) {
            try {
                $response = $client->generativeModel($modelName)->generateContent($prompt);
                $raw = trim($response->text());

                $jsonString = preg_replace('/^```(?:json)?\s*/i', '', $raw);
                $jsonString = preg_replace('/\s*```$/i', '', $jsonString);
                $jsonString = trim($jsonString);

                $result = json_decode($jsonString, true);

                if (json_last_error() === JSON_ERROR_NONE &&
                    isset($result['strengths_ar']) && isset($result['weaknesses_ar']) && isset($result['advice_ar'])) {
                    
                    $analysis = [
                        'strengths_ar' => (array) $result['strengths_ar'],
                        'strengths_en' => (array) ($result['strengths_en'] ?? $result['strengths_ar']),
                        'weaknesses_ar' => (array) $result['weaknesses_ar'],
                        'weaknesses_en' => (array) ($result['weaknesses_en'] ?? $result['weaknesses_ar']),
                        'advice_ar' => (string) $result['advice_ar'],
                        'advice_en' => (string) ($result['advice_en'] ?? $result['advice_ar']),
                    ];

                    session([$cacheKey => $analysis]);
                    return $analysis;
                }
            } catch (\Exception $e) {
                Log::warning("Gemini ($modelName) admin analysis failed: " . $e->getMessage());
                continue;
            }
        }

        return $fallback;
    }

    /**
     * Auto-group ungrouped students into small classes using the Gemini AI endpoint.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function autoGroupStudentsAI(Request $request)
    {
        // 1. Find ungrouped students (students not in any class based on pivot table)
        // Also load their user data and results to provide context for AI
        $ungroupedStudents = Student::with(['user', 'answers' => function ($query) {
            $query->select('student_id', 'question_id', 'is_correct');
        }])->whereDoesntHave('classes')->get();

        if ($ungroupedStudents->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No ungrouped students found to group.'
            ]);
        }

        // 2. Format student data for AI
        $studentsData = $ungroupedStudents->map(function ($student) {
            $correctAnswers = $student->answers->where('is_correct', 1)->count();
            $totalAnswers = $student->answers->count();
            $avgScore = $totalAnswers > 0 ? ($correctAnswers / $totalAnswers) * 100 : 0;

            return [
                'id' => $student->student_id,
                'name' => $student->user->name ?? 'Student',
                'level' => $student->level ?? 'Unknown',
                'average_score' => round($avgScore, 2)
            ];
        })->values()->toArray();

        // 3. Get available teachers
        $availableTeachers = Teacher::with('user')->get()->map(function ($teacher) {
            return [
                'id' => $teacher->teacher_id,
                'name' => $teacher->user->name ?? 'Teacher'
            ];
        })->values()->toArray();

        $teachersContext = !empty($availableTeachers) ? json_encode($availableTeachers, JSON_UNESCAPED_UNICODE) : '[]';

        // 4. Prepare Gemini prompt
        $studentsJson = json_encode($studentsData, JSON_UNESCAPED_UNICODE);
        
        $prompt = "You are an expert educational coordinator. I have a list of ungrouped students and a list of available teachers. 
I need you to group these students into small classes (maximum 5 students per class). Try to group them logically based on their level or average scores if available.

Students Data:
" . json_encode($studentsData, JSON_UNESCAPED_UNICODE) . "

Available Teachers Data:
" . $teachersContext . "

Please return the grouping as a valid JSON object with the following structure (do NOT include Markdown formatting or code blocks):
{
  \"groups\": [
    {
      \"class_name\": \"Creative and inspiring class name (e.g., The Pioneers)\",
      \"description\": \"A short engaging description for the class.\",
      \"level\": \"Recommended level for the class based on students\",
      \"teacher_id\": integer_id_of_recommended_teacher_or_null,
      \"student_ids\": [array of student integer IDs]
    }
  ]
}";

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['success' => false, 'message' => 'Gemini API Key is missing.']);
        }

        $client = \Gemini::client($apiKey);
        $models = ['gemini-flash-latest', 'gemini-1.5-flash'];
        $aiGroups = null;

        foreach ($models as $modelName) {
            try {
                $response = $client->generativeModel($modelName)->generateContent($prompt);
                $raw = trim($response->text());

                // Strip markdown formatting if present
                $jsonString = preg_replace('/^```(?:json)?\s*/i', '', $raw);
                $jsonString = preg_replace('/\s*```$/i', '', $jsonString);
                $jsonString = trim($jsonString);

                $result = json_decode($jsonString, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($result['groups'])) {
                    $aiGroups = $result['groups'];
                    break;
                } else {
                    Log::warning("Gemini Auto-Grouping ($modelName) returned unparseable output: $raw");
                }
            } catch (\Exception $e) {
                Log::warning("Gemini Auto-Grouping ($modelName) failed: " . $e->getMessage());
            }
        }

        if (!$aiGroups) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate grouping via AI. Please try again later.'
            ]);
        }

        // 5. Create the classes and attach students
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $createdClassesCount = 0;
            foreach ($aiGroups as $group) {
                if (empty($group['student_ids'])) {
                    continue;
                }

                $newClass = Classes::create([
                    'classes_name' => collect([$group['class_name'] ?? 'Generated Class', 100])->first(),
                    'teacher_id' => $group['teacher_id'] ?? null,
                    'level' => $group['level'] ?? 'Mixed',
                    'description' => $group['description'] ?? 'AI Auto-Generated Class',
                ]);

                // Attach students via pivot
                $newClass->students()->syncWithoutDetaching($group['student_ids']);

                // Also update the primary class_id on the Student model
                Student::whereIn('student_id', $group['student_ids'])->update(['class_id' => $newClass->class_id]);

                $createdClassesCount++;
            }
            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully auto-grouped students into {$createdClassesCount} new classes via AI.",
                'groups' => $aiGroups
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            Log::error("Failed to save AI generated classes: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Generated grouping successfully but failed to save to database. Error: ' . $e->getMessage()
            ]);
        }
    }
}