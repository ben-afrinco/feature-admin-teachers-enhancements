<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('online_sessions', function (Blueprint $table) {
            $table->id('session_id'); // Primary key
            $table->unsignedBigInteger('class_id'); // Foreign key to Classes
            $table->unsignedBigInteger('teacher_id'); // Foreign key to Teacher
            $table->string('room_name')->unique(); // Unique identifier for Jitsi Meet room
            $table->string('topic'); // e.g., "Math Unit 1 Review"
            $table->string('join_url')->nullable(); // Pre-constructed Jitsi URL
            $table->dateTime('start_time'); // When the session is scheduled
            $table->integer('duration'); // in minutes
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'canceled'])->default('scheduled');
            $table->timestamps();

            // Setup foreign keys assuming the tables exist.
            // Using constrained() implicitly looks for the standard table names, but defining explicitly is safer here:
            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_sessions');
    }
};
