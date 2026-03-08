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
        Schema::create('submission_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id');
            $table->text('content')->nullable(); // Text answer if applicable
            $table->string('file_path')->nullable(); // Uploaded file if applicable
            $table->integer('version')->default(1);
            $table->boolean('is_late')->default(false); // Flag if this version was submitted after the due date
            $table->timestamps(); // created_at serves as submitted_at

            // Setup foreign keys
            $table->foreign('submission_id')->references('id')->on('assignment_submissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_versions');
    }
};
