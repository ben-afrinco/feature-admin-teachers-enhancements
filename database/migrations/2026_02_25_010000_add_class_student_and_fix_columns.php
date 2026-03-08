<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add description column to classes table
        if (!Schema::hasColumn('classes', 'description')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->text('description')->nullable()->after('level');
            });
        }

        // Add difficulty_level column to questions table
        if (!Schema::hasColumn('questions', 'difficulty_level')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->string('difficulty_level', 20)->default('medium')->after('question_type');
            });
        }

        // Create class_student pivot table
        if (!Schema::hasTable('class_student')) {
            Schema::create('class_student', function (Blueprint $table) {
                $table->id();
                $table->foreignId('class_id')->constrained('classes', 'class_id')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('student', 'student_id')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['class_id', 'student_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('class_student');

        if (Schema::hasColumn('classes', 'description')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
        if (Schema::hasColumn('questions', 'difficulty_level')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->dropColumn('difficulty_level');
            });
        }
    }
};
