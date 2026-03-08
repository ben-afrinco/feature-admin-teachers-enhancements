/**
 * LingoPulse Web Routes
 * 
 * This file defines the core routing architecture for the LingoPulse platform.
 * Routes are logically grouped by user role (Admin, Teacher, Student) and 
 * protected by custom session-based middleware.
 */

/*
|--------------------------------------------------------------------------
| 1️⃣ Public Routes (No Auth Required)
|--------------------------------------------------------------------------
| Includes landing pages, onboarding, and the custom authentication entry points.
*/
Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('/how-it-works', function () { return view('landing.how_it_works'); })->name('how');
Route::get('/account-selection', [LandingController::class, 'info_account'])->name('info_account');
Route::post('/account-submit', [LandingController::class, 'submitAccount'])->name('config.submit');
Route::get('/test_instructions', [LandingController::class, 'test_instructions'])->name('test_instructions');
Route::get('/info_accountStudents', function () { return view('auth.info_account_students'); })->name('info.students');

Route::post('/account/store', function (Request $request) {
    /**
     * Custom Registration/Login for Students.
     * Automatically handles both new account creation and session restoration 
     * based on email presence.
     */
    $request->validate([
        'first_name'     => 'required|string|max:100',
        'last_name'      => 'required|string|max:100',
        'email'          => 'required|email|max:255',
        'email_confirm'  => 'required|same:email|max:255',
        'phone'          => 'nullable|string|max:30',
        'country_code'   => 'nullable|string|max:10',
    ]);

    $existing = \App\Models\User_Model::where('email', $request->email)->first();
    if ($existing) {
        session(['user_id' => $existing->user_id, 'role' => $existing->role, 'name' => $existing->full_name]);
        return redirect()->route('test_instructions');
    }

    $user = \App\Models\User_Model::create([
        'full_name' => $request->first_name . ' ' . $request->last_name,
        'email'     => $request->email,
        'password'  => \Illuminate\Support\Facades\Hash::make('123456'),
        'role'      => 'student',
    ]);

    \App\Models\Student::create(['user_id' => $user->user_id]);

    session(['user_id' => $user->user_id, 'role' => 'student', 'name' => $user->full_name]);

    return redirect()->route('test_instructions');
})->name('account.store');

Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('index')->with('success', 'تم تسجيل الخروج بنجاح.');
})->name('logout');

Route::post('/auth/login', function (Request $request) {
    /**
     * Standard Login Logic.
     * Supports legacy plain-text password fallback and automatic Argon2 re-hashing
     * for users with insecure passwords.
     */
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = \App\Models\User_Model::where('email', $request->email)->first();
    
    $isMatch = false;
    if ($user) {
        try {
            $isMatch = \Illuminate\Support\Facades\Hash::check($request->password, $user->password);
        } catch (\RuntimeException $e) {
            $isMatch = ($request->password === $user->password);
        }
    }

    if ($user && $isMatch) {
        // Transparently upgrade password hashing to Argon2id if it's old (bcrypt, plain, etc)
        if (\Illuminate\Support\Facades\Hash::needsRehash($user->password)) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->save();
        }

        session(['user_id' => $user->user_id, 'role' => $user->role, 'name' => $user->full_name]);
        if ($user->role === 'admin') return redirect()->route('developer');
        if ($user->role === 'teacher') return redirect()->route('teacher');
        return redirect()->route('index');
    }

    return back()->with('login_error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة.');
})->name('auth.login');

/*
|--------------------------------------------------------------------------
| 2️⃣ Student Protected Routes (auth.session:student)
|--------------------------------------------------------------------------
| Manages the test-taking experience, AI-dynamic test generation, and results viewing.
*/
Route::middleware('auth.session:student')->group(function () {
    // AI Test Entry point
    Route::get('/test/start', [TestController::class, 'startAI'])->name('test.startAI');

    // Reading
    Route::get('/reading-get-ready', function () { return view('student.tests.reading.get_ready'); })->name('reading.getready');
    Route::get('/test/reading/q1', function () { 
        if (session('dynamic_tests_ready', false) && session()->has('dynamic_test_ids.reading')) {
            $test = \App\Models\Test::with('questions.options')->find(session('dynamic_test_ids')['reading']);
            if ($test) return view('student.tests.reading.dynamic', compact('test'));
        }
        return view('student.tests.reading.q1'); 
    })->name('reading.q1');
    Route::post('/test/reading/{q}', [TestController::class, 'submitReading'])->name('reading.submit');
    Route::get('/test/reading/q2', function () { return view('student.tests.reading.q2'); })->name('reading.q2');
    Route::get('/reading-done', function () { return view('student.tests.reading.done'); })->name('reading.done');
    Route::get('/test/reading', function () { return redirect()->route('reading.q1'); })->name('reading.start');
    Route::get('/test/r1', function () { return view('student.tests.reading.r1'); })->name('test.r1');

    // Listening
    Route::get('/listening-get-ready', function () { return view('student.tests.listening.get_ready'); })->name('listening.getready');
    Route::get('/test/listening/q1', function () { 
        if (session('dynamic_tests_ready', false) && session()->has('dynamic_test_ids.listening')) {
            $test = \App\Models\Test::with('questions.options')->find(session('dynamic_test_ids')['listening']);
            if ($test) return view('student.tests.listening.dynamic', compact('test'));
        }
        return view('student.tests.listening.q1'); 
    })->name('listening.q1');
    Route::post('/test/listening/{q}', [TestController::class, 'submitListening'])->name('listening.submit');
    Route::get('/test/listening/q2', function () { return view('student.tests.listening.q2'); })->name('listening.q2');
    Route::get('/test/listening/done', function () { return view('student.tests.listening.done'); })->name('listening.done');
    Route::get('/test/listening', function () { return redirect()->route('listening.q1'); })->name('test.listening');

    // Writing
    Route::get('/writing-get-ready', function () { return view('student.tests.writing.get_ready'); })->name('writing.getready');
    Route::get('/test/writing/q1', function () { 
        if (session('dynamic_tests_ready', false) && session()->has('dynamic_test_ids.writing')) {
            $test = \App\Models\Test::find(session('dynamic_test_ids')['writing']);
            if ($test) return view('student.tests.writing.dynamic', compact('test'));
        }
        return view('student.tests.writing.q1'); 
    })->name('writing.q1');
    Route::post('/test/writing', [TestController::class, 'submitWriting'])->name('writing.submit');
    Route::get('/test/writing/done', function () { return view('student.tests.writing.done'); })->name('writing.done');
    Route::get('/writingdone', function () { return redirect()->route('writing.done'); })->name('writingdone');
    Route::get('/test/writing', function () { return redirect()->route('writing.getready'); })->name('test.writing');

    // Speaking
    Route::post('/test/speaking', [TestController::class, 'submitSpeaking'])->name('speaking.submit');
    Route::get('/speaking-get-ready', function () { return view('student.tests.speaking.get_ready'); })->name('speaking.getready');
    Route::get('/allow-speaking', function () { return view('student.tests.speaking.allow'); })->name('speaking.allow');
    Route::get('/allowSpeaking', function () { return redirect()->route('speaking.allow'); })->name('allowSpeaking');
    Route::get('/test/speaking/q1', function () { 
        if (session('dynamic_tests_ready', false) && session()->has('dynamic_test_ids.speaking')) {
            $test = \App\Models\Test::find(session('dynamic_test_ids')['speaking']);
            if ($test) return view('student.tests.speaking.dynamic', compact('test'));
        }
        return view('student.tests.speaking.q1'); 
    })->name('speaking.q1');
    Route::get('/test/speaking/done', function () { return view('student.tests.speaking.done'); })->name('speaking.done');
    Route::get('/test/speaking', function () { return redirect()->route('speaking.getready'); })->name('test.speaking');
    Route::get('/test/speaking/skip', function () {
        session(['speaking.skipped' => true]);
        return redirect()->route('test.results');
    })->name('speaking.skip');

    // Results & Details
    Route::get('/check-system', function () { return view('landing.check_system'); })->name('system.check');
    Route::get('/test/results', [LandingController::class, 'results'])->name('test.results');
    Route::get('/results/skill/{skill}', [ResultsController::class, 'skill'])->name('results.skill');

    Route::get('/results/details/reading', [ResultsController::class, 'detailReading'])->name('detailsReading');
    Route::get('/results/details/listening', [ResultsController::class, 'detailListening'])->name('detailsListening');
    Route::get('/results/details/writing', [ResultsController::class, 'detailWriting'])->name('detailsWriting');
    Route::get('/results/details/speaking', [ResultsController::class, 'detailSpeaking'])->name('detailsSpeaking');

    // Ollama AI explain endpoint (streaming SSE)
    Route::post('/api/ollama/explain', [\App\Http\Controllers\OllamaController::class, 'explain'])->name('ollama.explain');

    // Assignments
    Route::post('/student/assignments/{assignment_id}/submit', [\App\Http\Controllers\SubmissionController::class, 'submit'])->name('student.assignment.submit');
    Route::get('/student/assignments', [\App\Http\Controllers\AssignmentController::class, 'studentIndex'])->name('student.assignments.index');
    Route::get('/downloads/submissions/{id}', [\App\Http\Controllers\FileDownloadController::class, 'downloadSubmission'])->name('download.submission');
    Route::get('/downloads/attachments/{id}', [\App\Http\Controllers\FileDownloadController::class, 'downloadAttachment'])->name('download.attachment');
});

/*
|--------------------------------------------------------------------------
| 3️⃣ Admin Protected Routes (auth.session:admin)
|--------------------------------------------------------------------------
| System management including user administration, class assignment,
| and global test pool management.
*/
Route::middleware('auth.session:admin,developer')->group(function () {
    Route::get('/developer', [LandingController::class, 'developerDashboard'])->name('developer');
    Route::get('/developer/students', [DeveloperController::class, 'students'])->name('admin.students');
    Route::get('/developer/teachers', [DeveloperController::class, 'teachers'])->name('admin.teachers');
    Route::get('/developer/api/ai-analysis', [LandingController::class, 'getAdminGeminiAnalysisApi'])->name('admin.api.ai');
    Route::get('/account-teat', [LandingController::class, 'teat'])->name('teat');

    Route::post('/admin/user/create', [LandingController::class, 'addUser'])->name('admin.addUser');
    Route::post('/admin/user/update/{id}', [LandingController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/user/delete/{id}', [LandingController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::post('/admin/class/create', [LandingController::class, 'createClass'])->name('admin.createClass');
    Route::post('/admin/class/update/{id}', [LandingController::class, 'editClass'])->name('admin.editClass');
    Route::post('/admin/class/delete/{id}', [LandingController::class, 'deleteClass'])->name('admin.deleteClass');
    Route::post('/developer/classes/auto-group', [LandingController::class, 'autoGroupStudentsAI'])->name('admin.autoGroupClasses');

    Route::post('/admin/question/create', [\App\Http\Controllers\LandingController::class, 'addQuestion'])->name('admin.addQuestion');
    Route::post('/admin/question/update/{id}', [\App\Http\Controllers\LandingController::class, 'editQuestion'])->name('admin.editQuestion');
    Route::post('/admin/question/delete/{id}', [\App\Http\Controllers\LandingController::class, 'deleteQuestion'])->name('admin.deleteQuestion');

    // Admin user profile fetching
    Route::get('/admin/user/{id}/profile', [\App\Http\Controllers\LandingController::class, 'getUserProfile'])->name('admin.user.profile');
});

/*
|--------------------------------------------------------------------------
| 4️⃣ Teacher Protected Routes (auth.session:teacher)
|--------------------------------------------------------------------------
| Classroom operations including live session coordination, assignment
| creation, and manual student evaluation.
*/
Route::middleware('auth.session:teacher')->group(function () {
    Route::get('/teacher', [LandingController::class, 'teacherDashboard'])->name('teacher');
    Route::post('/teacher/session/create', [\App\Http\Controllers\OnlineSessionController::class, 'store'])->name('teacher.session.create');
    Route::delete('/teacher/session/delete/{id}', [\App\Http\Controllers\OnlineSessionController::class, 'destroy'])->name('teacher.session.delete');
    Route::get('/live-session/{id}/join', [\App\Http\Controllers\OnlineSessionController::class, 'join'])->name('session.join');

    // Assignments
    Route::post('/teacher/assignments', [\App\Http\Controllers\AssignmentController::class, 'store'])->name('teacher.assignment.store');
    Route::get('/teacher/assignments/class/{class_id}', [\App\Http\Controllers\AssignmentController::class, 'getAssignmentsForClass'])->name('teacher.assignments.get');
    Route::get('/teacher/assignments/{assignment_id}/submissions', [\App\Http\Controllers\AssignmentController::class, 'getSubmissions'])->name('teacher.assignments.submissions');
    Route::post('/teacher/submissions/{submission_id}/grade', [\App\Http\Controllers\SubmissionController::class, 'grade'])->name('teacher.submission.grade');
    
    // Grades & Notes
    Route::post('/teacher/grades/save', [\App\Http\Controllers\GradeController::class, 'saveGrades'])->name('teacher.grades.save');
    Route::post('/teacher/note/save', [\App\Http\Controllers\GradeController::class, 'saveNote'])->name('teacher.note.save');
    
    // Quizzes
    Route::post('/teacher/quizzes', [\App\Http\Controllers\QuizController::class, 'store'])->name('teacher.quiz.store');
    Route::post('/teacher/quizzes/generate-ai', [\App\Http\Controllers\QuizController::class, 'generateAI'])->name('teacher.quiz.generateAI');
    Route::delete('/teacher/quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'destroy'])->name('teacher.quiz.destroy');
});

/**
 * shared Authenticated Routes
 * 
 * Downloads and utility services accessible by any valid session holder.
 */
Route::middleware(\App\Http\Middleware\EnsureSessionAuth::class)->group(function () {
    Route::get('/shared/downloads/submissions/{id}', [\App\Http\Controllers\FileDownloadController::class, 'downloadSubmission'])->name('shared.download.submission');
    Route::get('/shared/downloads/attachments/{id}', [\App\Http\Controllers\FileDownloadController::class, 'downloadAttachment'])->name('shared.download.attachment');
    
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
    
    // Chatbot Routes
    Route::get('/chatbot/history', [\App\Http\Controllers\ChatbotController::class, 'getHistory'])->name('chatbot.history');
    Route::post('/chatbot/send', [\App\Http\Controllers\ChatbotController::class, 'sendMessage'])->name('chatbot.send');
    
    // Avatar Routes
    Route::post('/avatar/upload', [\App\Http\Controllers\AvatarController::class, 'upload'])->name('avatar.upload');
    Route::delete('/avatar/delete', [\App\Http\Controllers\AvatarController::class, 'delete'])->name('avatar.delete');
});

/*
|--------------------------------------------------------------------------
| 5️⃣ Admin Panel (Django-Like) Routes
|--------------------------------------------------------------------------
| Advanced data management panel with CRUD, smart tables, bulk actions,
| file management, activity logging, and API explorer.
*/
Route::middleware('auth.session:admin,developer')->prefix('admin-panel')->name('admin-panel.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\AdminPanelController::class, 'dashboard'])->name('dashboard');

    // Dynamic Resource CRUD
    Route::get('/resource/{resource}', [\App\Http\Controllers\AdminPanelController::class, 'index'])->name('resource.index');
    Route::get('/resource/{resource}/{id}', [\App\Http\Controllers\AdminPanelController::class, 'show'])->name('resource.show');
    Route::post('/resource/{resource}', [\App\Http\Controllers\AdminPanelController::class, 'store'])->name('resource.store');
    Route::put('/resource/{resource}/{id}', [\App\Http\Controllers\AdminPanelController::class, 'update'])->name('resource.update');
    Route::patch('/resource/{resource}/{id}/inline', [\App\Http\Controllers\AdminPanelController::class, 'inlineUpdate'])->name('resource.inline');
    Route::delete('/resource/{resource}/{id}', [\App\Http\Controllers\AdminPanelController::class, 'destroy'])->name('resource.destroy');
    Route::post('/resource/{resource}/{id}/restore', [\App\Http\Controllers\AdminPanelController::class, 'restore'])->name('resource.restore');
    Route::delete('/resource/{resource}/{id}/force', [\App\Http\Controllers\AdminPanelController::class, 'forceDelete'])->name('resource.forceDelete');
    Route::post('/resource/{resource}/{id}/duplicate', [\App\Http\Controllers\AdminPanelController::class, 'duplicate'])->name('resource.duplicate');
    Route::post('/resource/{resource}/bulk', [\App\Http\Controllers\AdminPanelController::class, 'bulkAction'])->name('resource.bulk');
    Route::get('/resource/{resource}/export/csv', [\App\Http\Controllers\AdminPanelController::class, 'export'])->name('resource.export');
    Route::post('/resource/{resource}/import', [\App\Http\Controllers\AdminPanelController::class, 'import'])->name('resource.import');
    Route::get('/resource/{resource}/relation-options/{field}', [\App\Http\Controllers\AdminPanelController::class, 'getRelationOptions'])->name('resource.relationOptions');

    // File Manager
    Route::get('/file-manager', [\App\Http\Controllers\FileManagerController::class, 'index'])->name('files.index');
    Route::post('/file-manager/upload', [\App\Http\Controllers\FileManagerController::class, 'upload'])->name('files.upload');
    Route::post('/file-manager/directory', [\App\Http\Controllers\FileManagerController::class, 'createDirectory'])->name('files.mkdir');
    Route::delete('/file-manager/delete', [\App\Http\Controllers\FileManagerController::class, 'delete'])->name('files.delete');
    Route::patch('/file-manager/rename', [\App\Http\Controllers\FileManagerController::class, 'rename'])->name('files.rename');

    // API Explorer
    Route::get('/api-explorer', [\App\Http\Controllers\ApiExplorerController::class, 'index'])->name('api.index');
    Route::post('/api-explorer/execute', [\App\Http\Controllers\ApiExplorerController::class, 'execute'])->name('api.execute');

    // Activity Log
    Route::get('/activity-log', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/activity-log/{id}', [\App\Http\Controllers\ActivityLogController::class, 'show'])->name('activity-log.show');
});

/*
|--------------------------------------------------------------------------
| 6️⃣ Practice Interfaces (Open/Beta)
|--------------------------------------------------------------------------
| Static practice modules for public consumption.
*/
Route::get('/strengthening', function () { return view('student.strengthening'); })->name('test.strengthening');
Route::get('/practice/readings', function () { view('student.practice.readings'); })->name('practice.readings');
Route::get('/practice/listenings', function () { return view('student.practice.listenings'); })->name('practice.listenings');
Route::get('/practice/writings', function () { return view('student.practice.writings'); })->name('practice.writings');
Route::get('/practice/speakings', function () { return view('student.practice.speakings'); })->name('practice.speakings');