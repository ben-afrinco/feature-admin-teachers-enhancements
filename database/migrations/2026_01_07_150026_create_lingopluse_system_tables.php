<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * LingoPulse Core Schema Migration
 * 
 * This migration initializes the 11 foundational tables of the system, including
 * users, roles (admin/teacher/student), classes, tests, results, and AI evaluations.
 * It establishes all foreign key constraints and cascade rules.
 */
return new class extends Migration {
    /**
     * Run the migrations - Create all 11 core system tables.
     */
    public function up(): void {

        // 1. user
        Schema::create('user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('full_name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('role', 20);
            $table->timestamps();
        });

        // 2. admin
        Schema::create('admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->foreignId('user_id')->constrained('user', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teacher_id');
            $table->foreignId('user_id')->constrained('user', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });

        // 4. classes
        Schema::create('classes', function (Blueprint $table) {
            $table->id('class_id');
            $table->string('classes_name', 50);
            $table->foreignId('teacher_id')->nullable()->constrained('teachers', 'teacher_id')->onDelete('set null');
            $table->string('level', 50);
            $table->timestamps();
        });

        // 5. student
        Schema::create('student', function (Blueprint $table) {
            $table->id('student_id');
            $table->foreignId('user_id')->constrained('user', 'user_id')->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->constrained('classes', 'class_id')->onDelete('set null');
            $table->string('level', 50)->nullable();
            $table->timestamps();
        });

        // 6. test
        Schema::create('test', function (Blueprint $table) {
            $table->id('test_id');
            $table->string('test_name');
            $table->string('level');
            $table->string('skill');
            $table->timestamps();
        });

        // 7. questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignId('test_id')->constrained('test', 'test_id')->onDelete('cascade');
            $table->text('question_text');
            $table->string('question_type');
            $table->timestamps();
        });

        // 8. options
        Schema::create('options', function (Blueprint $table) {
            $table->id('option_id');
            $table->foreignId('question_id')->constrained('questions', 'question_id')->onDelete('cascade');
            $table->string('optione_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        // 9. dent_answer
        Schema::create('dent_answer', function (Blueprint $table) {
            $table->id('answer_id');
            $table->foreignId('student_id')->constrained('student', 'student_id');
            $table->foreignId('question_id')->constrained('questions', 'question_id');
            $table->foreignId('option_id')->nullable()->constrained('options', 'option_id');
            $table->text('answer_text')->nullable();
            $table->timestamps();
        });

        // 10. result
        Schema::create('result', function (Blueprint $table) {
            $table->id('result_id');
            $table->foreignId('user_id')->constrained('user', 'user_id');
            $table->foreignId('test_id')->constrained('test', 'test_id');
            $table->float('final_score');
            $table->timestamps();
        });

        // 11. ai_evaluations
        Schema::create('ai_evaluations', function (Blueprint $table) {
            $table->id('ai_eval_id');
            $table->foreignId('answer_id')->constrained('dent_answer', 'answer_id')->onDelete('cascade');
            $table->float('ai_score');
            $table->text('ai_feedback');
            $table->timestamps();
        });
    }

public function down(): void {
        Schema::dropIfExists('ai_evaluations');
        Schema::dropIfExists('result');
        Schema::dropIfExists('dent_answer');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('test');
        Schema::dropIfExists('student');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('user');
    }
};