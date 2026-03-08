<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class TestSeeder
 * 
 * Populates the system with initial proficiency tests for Reading, Listening,
 * Writing, and Speaking. Generates 10 multiple-choice questions for 
 * receptive skills and open-ended prompts for productive skills.
 * 
 * @package Database\Seeders
 */
class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1. Create Tests
        $readingId = DB::table('test')->insertGetId(['test_name' => 'Reading Exam', 'level' => 'Beginner', 'skill' => 'reading']);
        $listeningId = DB::table('test')->insertGetId(['test_name' => 'Listening Exam', 'level' => 'Beginner', 'skill' => 'listening']);
        $writingId = DB::table('test')->insertGetId(['test_name' => 'Writing Exam', 'level' => 'Beginner', 'skill' => 'writing']);
        $speakingId = DB::table('test')->insertGetId(['test_name' => 'Speaking Exam', 'level' => 'Beginner', 'skill' => 'speaking']);

        // 2. Reading Questions (10 questions, typical answers)
        // Correct answers for Reading logic:
        // q1: a, q2: a, q3: a, q4: a, q5: a, q6: a, q7: a, q8: a, q9: a, q10: a (from the HTML view, the first option is correct and usually 'a' is marked required)
        // I will seed just 'a' as correct for simplicity to match the mock views.
        for ($i = 1; $i <= 10; $i++) {
            $qId = DB::table('questions')->insertGetId(['test_id' => $readingId, 'question_text' => "Reading Q$i", 'question_type' => 'mcq']);
            
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'a', 'is_correct' => true]);
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'b', 'is_correct' => false]);
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'c', 'is_correct' => false]);
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'd', 'is_correct' => false]);
        }

        // 3. Listening Questions
        for ($i = 1; $i <= 10; $i++) {
            $qId = DB::table('questions')->insertGetId(['test_id' => $listeningId, 'question_text' => "Listening Q$i", 'question_type' => 'mcq']);
            
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'a', 'is_correct' => true]);
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'b', 'is_correct' => false]);
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'c', 'is_correct' => false]);
            DB::table('options')->insert(['question_id' => $qId, 'optione_text' => 'd', 'is_correct' => false]);
        }

        // 4. Writing Question
        DB::table('questions')->insert([
            'test_id' => $writingId, 
            'question_text' => 'Write about your favorite day.', 
            'question_type' => 'text'
        ]);

        // 5. Speaking Question
        DB::table('questions')->insert([
            'test_id' => $speakingId, 
            'question_text' => 'Talk about your family.', 
            'question_type' => 'audio'
        ]);
    }
}
