<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Test;
use App\Models\Student;
use App\Models\DentAnswer;
use App\Models\Evaluation;
use App\Models\Question;

/**
 * Class ResultsController
 * 
 * Manages the presentation of detailed test results for students.
 * Breaks down student performance by specific language skills (Reading, Listening,
 * Writing, Speaking) and provides granular feedback, including AI-generated
 * reviews and score comparisons.
 * 
 * @package App\Http\Controllers
 */
class ResultsController extends Controller
{
    /**
     * Show high-level result overview for a specific skill.
     * 
     * @param string $skill enum: reading, listening, writing, speaking
     * @return View|RedirectResponse
     */
    public function skill($skill) 
    {
        $user_id = session('user_id');
        if(!$user_id) {
            return redirect()->route('index')->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        $test = Test::where('skill', $skill)->first();
        $result = Result::where('user_id', $user_id)
                        ->where('test_id', $test ? $test->test_id : null)
                        ->first();
        
        $score = $result ? $result->final_score : 0;
                        
        return view("student.results." . strtolower($skill), compact('score'));
    }

    /**
     * Show granular results for the 'Reading' skill.
     * 
     * Includes the student's selected options vs correct ones, pulled from session.
     * 
     * @return View
     */
    public function detailReading()
    {
        $user_id = session('user_id');
        $studentAnswers = session('reading_answers', []);
        
        // Get score from DB
        $test = Test::where('skill', 'reading')->first();
        $result = $test ? Result::where('user_id', $user_id)->where('test_id', $test->test_id)->first() : null;
        $dbScore = $result ? $result->final_score : 0;

        return view('student.results.reading', compact('studentAnswers', 'dbScore'));
    }

    /**
     * Show granular results for the 'Listening' skill.
     * 
     * @return View
     */
    public function detailListening()
    {
        $user_id = session('user_id');
        $studentAnswers = session('listening_answers', []);

        $test = Test::where('skill', 'listening')->first();
        $result = $test ? Result::where('user_id', $user_id)->where('test_id', $test->test_id)->first() : null;
        $dbScore = $result ? $result->final_score : 0;

        return view('student.results.listening', compact('studentAnswers', 'dbScore'));
    }

    /**
     * Show granular results for the 'Writing' skill.
     * 
     * Incorporates qualitative AI sentiment and scoring analysis from Eval table.
     * 
     * @return View
     */
    public function detailWriting()
    {
        $user_id = session('user_id');
        $student = Student::where('user_id', $user_id)->first();

        $studentText = '';
        $aiFeedback = '';
        $aiScore = 0;

        if ($student) {
            $test = Test::where('skill', 'writing')->first();
            if ($test) {
                $question = Question::where('test_id', $test->test_id)->first();
                if ($question) {
                    $answer = DentAnswer::where('student_id', $student->student_id)
                                        ->where('question_id', $question->question_id)
                                        ->first();
                    if ($answer) {
                        $studentText = $answer->answer_text ?? '';
                        $eval = Evaluation::where('answer_id', $answer->answer_id)->first();
                        if ($eval) {
                            $aiFeedback = $eval->ai_feedback ?? '';
                            $aiScore = $eval->ai_score ?? 0;
                        }
                    }
                }
            }
        }

        // Get result score from DB
        $test = Test::where('skill', 'writing')->first();
        $result = $test ? Result::where('user_id', $user_id)->where('test_id', $test->test_id)->first() : null;
        $dbScore = $result ? $result->final_score : 0;

        return view('student.results.writing', compact('studentText', 'aiFeedback', 'aiScore', 'dbScore'));
    }

    /**
     * Show granular results for the 'Speaking' skill.
     * 
     * @return View
     */
    public function detailSpeaking()
    {
        $user_id = session('user_id');
        $student = Student::where('user_id', $user_id)->first();

        $transcript = '';
        $aiFeedback = '';
        $aiScore = 0;

        if ($student) {
            $test = Test::where('skill', 'speaking')->first();
            if ($test) {
                $question = Question::where('test_id', $test->test_id)->first();
                if ($question) {
                    $answer = DentAnswer::where('student_id', $student->student_id)
                                        ->where('question_id', $question->question_id)
                                        ->first();
                    if ($answer) {
                        $transcript = $answer->answer_text ?? '';
                        $eval = Evaluation::where('answer_id', $answer->answer_id)->first();
                        if ($eval) {
                            $aiFeedback = $eval->ai_feedback ?? '';
                            $aiScore = $eval->ai_score ?? 0;
                        }
                    }
                }
            }
        }

        $test = Test::where('skill', 'speaking')->first();
        $result = $test ? Result::where('user_id', $user_id)->where('test_id', $test->test_id)->first() : null;
        $dbScore = $result ? $result->final_score : 0;

        return view('student.results.speaking', compact('transcript', 'aiFeedback', 'aiScore', 'dbScore'));
    }
}

