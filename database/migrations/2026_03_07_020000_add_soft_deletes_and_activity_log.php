<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Admin Panel Infrastructure Migration
 * 
 * Adds soft delete support to all core tables and creates
 * the activity_log table for tracking all data changes.
 */
return new class extends Migration {
    public function up(): void
    {
        // Add soft deletes to all core tables
        $tables = [
            'user', 'admin', 'teachers', 'classes', 'student',
            'test', 'questions', 'options', 'dent_answer', 'result',
            'ai_evaluations', 'online_sessions', 'assignments',
            'assignment_attachments', 'assignment_submissions',
            'submission_versions', 'grades', 'chat_sessions',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->softDeletes();
                });
            }
        }

        // Create activity_log table
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action', 30); // create, update, delete, restore, force_delete, export, import, login
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_label', 255)->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('changed_fields')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log');

        $tables = [
            'user', 'admin', 'teachers', 'classes', 'student',
            'test', 'questions', 'options', 'dent_answer', 'result',
            'ai_evaluations', 'online_sessions', 'assignments',
            'assignment_attachments', 'assignment_submissions',
            'submission_versions', 'grades', 'chat_sessions',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropSoftDeletes();
                });
            }
        }
    }
};
