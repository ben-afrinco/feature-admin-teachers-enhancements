<?php

namespace Database\Seeders;

use App\Models\User_Model;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * 
 * Orchestrates the initial data population of the application.
 * Creates default user accounts for each role (Admin, Teacher, Student)
 * and triggers specific seeders for tests and content.
 * 
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create admin user
        if (!User_Model::where('email', 'admin@lingopulse.com')->exists()) {
            $admin = User_Model::create([
                'full_name' => 'مدير النظام',
                'email' => 'admin@lingopulse.com',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
            ]);
            Admin::create(['user_id' => $admin->user_id]);
        }

        // Create teacher user
        if (!User_Model::where('email', 'teacher@lingopulse.com')->exists()) {
            $teacher = User_Model::create([
                'full_name' => 'فاطمة المعلمة',
                'email' => 'teacher@lingopulse.com',
                'password' => \Illuminate\Support\Facades\Hash::make('teacher123'),
                'role' => 'teacher',
            ]);
            $teacherModel = Teacher::create(['user_id' => $teacher->user_id]);
            
            \App\Models\Classes::create([
                'classes_name' => 'Class A Default',
                'teacher_id' => $teacherModel->teacher_id,
                'level' => 'A1',
                'description' => 'Test class for E2E'
            ]);
        }

        // Create student user
        if (!User_Model::where('email', 'student@lingopulse.com')->exists()) {
            $student = User_Model::create([
                'full_name' => 'طالب تجريبي',
                'email' => 'student@lingopulse.com',
                'password' => \Illuminate\Support\Facades\Hash::make('student123'),
                'role' => 'student',
            ]);
            Student::create(['user_id' => $student->user_id]);
        }

        // Seed test questions
        $this->call([
            TestSeeder::class,
        ]);
    }
}
