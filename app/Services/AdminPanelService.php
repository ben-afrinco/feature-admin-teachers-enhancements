<?php

namespace App\Services;

use App\Models\{User_Model, Admin, Teacher, Student, Classes, Test, Question, Option, DentAnswer, Result, Evaluation, OnlineSession, Assignment, AssignmentAttachment, AssignmentSubmission, SubmissionVersion, Grade, ChatSession, ActivityLog};

/**
 * AdminPanelService - Dynamic model registry and configuration for the admin panel.
 * Maps resource slugs to model classes with display/search/filter configuration.
 */
class AdminPanelService
{
    /**
     * Resource configuration registry.
     * Each key is a URL slug, mapping to model config.
     */
    public static function getResources(): array
    {
        return [
            'users' => [
                'model'       => User_Model::class,
                'label_ar'    => 'المستخدمين',
                'label_en'    => 'Users',
                'icon'        => 'fa-users',
                'primaryKey'  => 'user_id',
                'columns'     => [
                    'user_id'    => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'full_name'  => ['label_ar' => 'الاسم', 'label_en' => 'Name', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'email'      => ['label_ar' => 'البريد', 'label_en' => 'Email', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'role'       => ['label_ar' => 'الدور', 'label_en' => 'Role', 'sortable' => true, 'editable' => true, 'type' => 'select', 'options' => ['admin', 'teacher', 'student']],
                    'created_at' => ['label_ar' => 'تاريخ التسجيل', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['student', 'teacher', 'admin', 'results'],
                'formFields'  => [
                    'full_name' => ['label_ar' => 'الاسم الكامل', 'label_en' => 'Full Name', 'type' => 'text', 'required' => true],
                    'email'     => ['label_ar' => 'البريد', 'label_en' => 'Email', 'type' => 'email', 'required' => true],
                    'password'  => ['label_ar' => 'كلمة المرور', 'label_en' => 'Password', 'type' => 'password', 'required' => 'create'],
                    'role'      => ['label_ar' => 'الدور', 'label_en' => 'Role', 'type' => 'select', 'options' => ['admin' => 'مشرف', 'teacher' => 'معلم', 'student' => 'طالب'], 'required' => true],
                ],
                'filters' => [
                    'role'       => ['label_ar' => 'الدور', 'label_en' => 'Role', 'type' => 'select', 'options' => ['admin', 'teacher', 'student']],
                    'created_at' => ['label_ar' => 'تاريخ التسجيل', 'label_en' => 'Created', 'type' => 'date_range'],
                ],
            ],

            'students' => [
                'model'       => Student::class,
                'label_ar'    => 'الطلاب',
                'label_en'    => 'Students',
                'icon'        => 'fa-user-graduate',
                'primaryKey'  => 'student_id',
                'columns'     => [
                    'student_id' => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'user_id'    => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'sortable' => true, 'relation' => 'user', 'display' => 'full_name'],
                    'class_id'   => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'sortable' => true, 'relation' => 'classRoom', 'display' => 'classes_name', 'editable' => true, 'type' => 'relation_select'],
                    'level'      => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'created_at' => ['label_ar' => 'تاريخ التسجيل', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['user', 'classRoom', 'answers'],
                'formFields'  => [
                    'user_id'  => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'type' => 'relation_select', 'relation_model' => 'users', 'display' => 'full_name', 'required' => true],
                    'class_id' => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'type' => 'relation_select', 'relation_model' => 'classes', 'display' => 'classes_name'],
                    'level'    => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'type' => 'text'],
                ],
                'filters' => [
                    'level'    => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'type' => 'text'],
                    'class_id' => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'type' => 'relation_select', 'relation_model' => 'classes', 'display' => 'classes_name'],
                ],
            ],

            'teachers' => [
                'model'       => Teacher::class,
                'label_ar'    => 'المعلمين',
                'label_en'    => 'Teachers',
                'icon'        => 'fa-chalkboard-teacher',
                'primaryKey'  => 'teacher_id',
                'columns'     => [
                    'teacher_id' => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'user_id'    => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'sortable' => true, 'relation' => 'user', 'display' => 'full_name'],
                    'created_at' => ['label_ar' => 'تاريخ التسجيل', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['user', 'classes'],
                'formFields'  => [
                    'user_id' => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'type' => 'relation_select', 'relation_model' => 'users', 'display' => 'full_name', 'required' => true],
                ],
                'filters' => [],
            ],

            'classes' => [
                'model'       => Classes::class,
                'label_ar'    => 'الفصول',
                'label_en'    => 'Classes',
                'icon'        => 'fa-school',
                'primaryKey'  => 'class_id',
                'columns'     => [
                    'class_id'     => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'classes_name' => ['label_ar' => 'اسم الفصل', 'label_en' => 'Class Name', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'teacher_id'   => ['label_ar' => 'المعلم', 'label_en' => 'Teacher', 'sortable' => true, 'relation' => 'teacher.user', 'display' => 'full_name', 'editable' => true, 'type' => 'relation_select'],
                    'level'        => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'created_at'   => ['label_ar' => 'التاريخ', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['teacher', 'students', 'onlineSessions'],
                'formFields'  => [
                    'classes_name' => ['label_ar' => 'اسم الفصل', 'label_en' => 'Class Name', 'type' => 'text', 'required' => true],
                    'teacher_id'   => ['label_ar' => 'المعلم', 'label_en' => 'Teacher', 'type' => 'relation_select', 'relation_model' => 'teachers', 'display' => 'teacher_id'],
                    'level'        => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'type' => 'text', 'required' => true],
                ],
                'filters' => [
                    'level'      => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'type' => 'text'],
                    'teacher_id' => ['label_ar' => 'المعلم', 'label_en' => 'Teacher', 'type' => 'relation_select', 'relation_model' => 'teachers', 'display' => 'teacher_id'],
                ],
            ],

            'tests' => [
                'model'       => Test::class,
                'label_ar'    => 'الاختبارات',
                'label_en'    => 'Tests',
                'icon'        => 'fa-clipboard-check',
                'primaryKey'  => 'test_id',
                'columns'     => [
                    'test_id'    => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'test_name'  => ['label_ar' => 'اسم الاختبار', 'label_en' => 'Test Name', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'level'      => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'sortable' => true, 'editable' => true],
                    'skill'      => ['label_ar' => 'المهارة', 'label_en' => 'Skill', 'sortable' => true, 'editable' => true],
                    'created_at' => ['label_ar' => 'التاريخ', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['questions', 'results'],
                'formFields'  => [
                    'test_name' => ['label_ar' => 'اسم الاختبار', 'label_en' => 'Test Name', 'type' => 'text', 'required' => true],
                    'level'     => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'type' => 'text', 'required' => true],
                    'skill'     => ['label_ar' => 'المهارة', 'label_en' => 'Skill', 'type' => 'select', 'options' => ['reading' => 'Reading', 'listening' => 'Listening', 'writing' => 'Writing', 'speaking' => 'Speaking', 'grammar' => 'Grammar'], 'required' => true],
                    'content'   => ['label_ar' => 'المحتوى', 'label_en' => 'Content', 'type' => 'textarea'],
                ],
                'filters' => [
                    'level' => ['label_ar' => 'المستوى', 'label_en' => 'Level', 'type' => 'text'],
                    'skill' => ['label_ar' => 'المهارة', 'label_en' => 'Skill', 'type' => 'select', 'options' => ['reading', 'listening', 'writing', 'speaking', 'grammar']],
                ],
            ],

            'questions' => [
                'model'       => Question::class,
                'label_ar'    => 'الأسئلة',
                'label_en'    => 'Questions',
                'icon'        => 'fa-circle-question',
                'primaryKey'  => 'question_id',
                'columns'     => [
                    'question_id'   => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'test_id'       => ['label_ar' => 'الاختبار', 'label_en' => 'Test', 'sortable' => true, 'relation' => 'test', 'display' => 'test_name'],
                    'question_text' => ['label_ar' => 'نص السؤال', 'label_en' => 'Question', 'sortable' => false, 'searchable' => true, 'editable' => true, 'type' => 'text_long'],
                    'question_type' => ['label_ar' => 'النوع', 'label_en' => 'Type', 'sortable' => true, 'editable' => true],
                    'created_at'    => ['label_ar' => 'التاريخ', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['test', 'options', 'answers'],
                'formFields'  => [
                    'test_id'       => ['label_ar' => 'الاختبار', 'label_en' => 'Test', 'type' => 'relation_select', 'relation_model' => 'tests', 'display' => 'test_name', 'required' => true],
                    'question_text' => ['label_ar' => 'نص السؤال', 'label_en' => 'Question Text', 'type' => 'textarea', 'required' => true],
                    'question_type' => ['label_ar' => 'النوع', 'label_en' => 'Type', 'type' => 'select', 'options' => ['multiple_choice' => 'اختيار متعدد', 'true_false' => 'صح/خطأ', 'essay' => 'مقالي'], 'required' => true],
                ],
                'filters' => [
                    'test_id'       => ['label_ar' => 'الاختبار', 'label_en' => 'Test', 'type' => 'relation_select', 'relation_model' => 'tests', 'display' => 'test_name'],
                    'question_type' => ['label_ar' => 'النوع', 'label_en' => 'Type', 'type' => 'select', 'options' => ['multiple_choice', 'true_false', 'essay']],
                ],
            ],

            'options' => [
                'model'       => Option::class,
                'label_ar'    => 'الخيارات',
                'label_en'    => 'Options',
                'icon'        => 'fa-list-check',
                'primaryKey'  => 'option_id',
                'columns'     => [
                    'option_id'    => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'question_id'  => ['label_ar' => 'السؤال', 'label_en' => 'Question', 'sortable' => true, 'relation' => 'question', 'display' => 'question_text'],
                    'optione_text' => ['label_ar' => 'نص الخيار', 'label_en' => 'Option Text', 'sortable' => false, 'editable' => true, 'searchable' => true],
                    'is_correct'   => ['label_ar' => 'صحيح؟', 'label_en' => 'Correct?', 'sortable' => true, 'editable' => true, 'type' => 'boolean'],
                ],
                'relations'   => ['question'],
                'formFields'  => [
                    'question_id'  => ['label_ar' => 'السؤال', 'label_en' => 'Question', 'type' => 'relation_select', 'relation_model' => 'questions', 'display' => 'question_text', 'required' => true],
                    'optione_text' => ['label_ar' => 'نص الخيار', 'label_en' => 'Option Text', 'type' => 'text', 'required' => true],
                    'is_correct'   => ['label_ar' => 'إجابة صحيحة', 'label_en' => 'Is Correct', 'type' => 'boolean'],
                ],
                'filters' => [
                    'is_correct' => ['label_ar' => 'صحيح؟', 'label_en' => 'Correct?', 'type' => 'boolean'],
                ],
            ],

            'results' => [
                'model'       => Result::class,
                'label_ar'    => 'النتائج',
                'label_en'    => 'Results',
                'icon'        => 'fa-chart-bar',
                'primaryKey'  => 'result_id',
                'columns'     => [
                    'result_id'   => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'user_id'     => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'sortable' => true, 'relation' => 'user', 'display' => 'full_name'],
                    'test_id'     => ['label_ar' => 'الاختبار', 'label_en' => 'Test', 'sortable' => true, 'relation' => 'test', 'display' => 'test_name'],
                    'final_score' => ['label_ar' => 'الدرجة', 'label_en' => 'Score', 'sortable' => true, 'editable' => true, 'type' => 'number'],
                    'created_at'  => ['label_ar' => 'التاريخ', 'label_en' => 'Created', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['user', 'test'],
                'formFields'  => [
                    'user_id'     => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'type' => 'relation_select', 'relation_model' => 'users', 'display' => 'full_name', 'required' => true],
                    'test_id'     => ['label_ar' => 'الاختبار', 'label_en' => 'Test', 'type' => 'relation_select', 'relation_model' => 'tests', 'display' => 'test_name', 'required' => true],
                    'final_score' => ['label_ar' => 'الدرجة النهائية', 'label_en' => 'Final Score', 'type' => 'number', 'required' => true],
                ],
                'filters' => [
                    'test_id'    => ['label_ar' => 'الاختبار', 'label_en' => 'Test', 'type' => 'relation_select', 'relation_model' => 'tests', 'display' => 'test_name'],
                    'created_at' => ['label_ar' => 'التاريخ', 'label_en' => 'Date', 'type' => 'date_range'],
                ],
            ],

            'assignments' => [
                'model'       => Assignment::class,
                'label_ar'    => 'الواجبات',
                'label_en'    => 'Assignments',
                'icon'        => 'fa-file-pen',
                'primaryKey'  => 'id',
                'columns'     => [
                    'id'         => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'title'      => ['label_ar' => 'العنوان', 'label_en' => 'Title', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'class_id'   => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'sortable' => true, 'relation' => 'classRoom', 'display' => 'classes_name'],
                    'teacher_id' => ['label_ar' => 'المعلم', 'label_en' => 'Teacher', 'sortable' => true, 'relation' => 'teacher.user', 'display' => 'full_name'],
                    'due_date'   => ['label_ar' => 'الموعد', 'label_en' => 'Due Date', 'sortable' => true, 'type' => 'datetime', 'editable' => true],
                    'max_grade'  => ['label_ar' => 'الدرجة القصوى', 'label_en' => 'Max Grade', 'sortable' => true, 'editable' => true, 'type' => 'number'],
                ],
                'relations'   => ['classRoom', 'teacher', 'attachments', 'submissions'],
                'formFields'  => [
                    'title'       => ['label_ar' => 'العنوان', 'label_en' => 'Title', 'type' => 'text', 'required' => true],
                    'description' => ['label_ar' => 'الوصف', 'label_en' => 'Description', 'type' => 'textarea'],
                    'class_id'    => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'type' => 'relation_select', 'relation_model' => 'classes', 'display' => 'classes_name', 'required' => true],
                    'teacher_id'  => ['label_ar' => 'المعلم', 'label_en' => 'Teacher', 'type' => 'relation_select', 'relation_model' => 'teachers', 'display' => 'teacher_id', 'required' => true],
                    'due_date'    => ['label_ar' => 'الموعد النهائي', 'label_en' => 'Due Date', 'type' => 'datetime', 'required' => true],
                    'max_grade'   => ['label_ar' => 'الدرجة القصوى', 'label_en' => 'Max Grade', 'type' => 'number', 'required' => true],
                ],
                'filters' => [
                    'class_id' => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'type' => 'relation_select', 'relation_model' => 'classes', 'display' => 'classes_name'],
                    'due_date' => ['label_ar' => 'الموعد', 'label_en' => 'Due Date', 'type' => 'date_range'],
                ],
            ],

            'online-sessions' => [
                'model'       => OnlineSession::class,
                'label_ar'    => 'الجلسات المباشرة',
                'label_en'    => 'Online Sessions',
                'icon'        => 'fa-video',
                'primaryKey'  => 'session_id',
                'columns'     => [
                    'session_id' => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'topic'      => ['label_ar' => 'الموضوع', 'label_en' => 'Topic', 'sortable' => true, 'editable' => true, 'searchable' => true],
                    'class_id'   => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'sortable' => true, 'relation' => 'classRoom', 'display' => 'classes_name'],
                    'start_time' => ['label_ar' => 'وقت البدء', 'label_en' => 'Start Time', 'sortable' => true, 'type' => 'datetime'],
                    'duration'   => ['label_ar' => 'المدة (دقيقة)', 'label_en' => 'Duration (min)', 'sortable' => true, 'editable' => true, 'type' => 'number'],
                    'status'     => ['label_ar' => 'الحالة', 'label_en' => 'Status', 'sortable' => true, 'editable' => true, 'type' => 'select', 'options' => ['scheduled', 'live', 'completed']],
                ],
                'relations'   => ['classRoom', 'teacher'],
                'formFields'  => [
                    'topic'      => ['label_ar' => 'الموضوع', 'label_en' => 'Topic', 'type' => 'text', 'required' => true],
                    'class_id'   => ['label_ar' => 'الفصل', 'label_en' => 'Class', 'type' => 'relation_select', 'relation_model' => 'classes', 'display' => 'classes_name', 'required' => true],
                    'teacher_id' => ['label_ar' => 'المعلم', 'label_en' => 'Teacher', 'type' => 'relation_select', 'relation_model' => 'teachers', 'display' => 'teacher_id', 'required' => true],
                    'room_name'  => ['label_ar' => 'اسم الغرفة', 'label_en' => 'Room Name', 'type' => 'text', 'required' => true],
                    'join_url'   => ['label_ar' => 'رابط الانضمام', 'label_en' => 'Join URL', 'type' => 'url'],
                    'start_time' => ['label_ar' => 'وقت البدء', 'label_en' => 'Start Time', 'type' => 'datetime', 'required' => true],
                    'duration'   => ['label_ar' => 'المدة (دقيقة)', 'label_en' => 'Duration (min)', 'type' => 'number', 'required' => true],
                    'status'     => ['label_ar' => 'الحالة', 'label_en' => 'Status', 'type' => 'select', 'options' => ['scheduled' => 'مجدول', 'live' => 'مباشر', 'completed' => 'مكتمل']],
                ],
                'filters' => [
                    'status'     => ['label_ar' => 'الحالة', 'label_en' => 'Status', 'type' => 'select', 'options' => ['scheduled', 'live', 'completed']],
                    'start_time' => ['label_ar' => 'وقت البدء', 'label_en' => 'Start Time', 'type' => 'date_range'],
                ],
            ],

            'activity-log' => [
                'model'       => ActivityLog::class,
                'label_ar'    => 'سجل النشاط',
                'label_en'    => 'Activity Log',
                'icon'        => 'fa-clock-rotate-left',
                'primaryKey'  => 'id',
                'readonly'    => true,
                'columns'     => [
                    'id'         => ['label_ar' => '#', 'label_en' => '#', 'sortable' => true],
                    'user_id'    => ['label_ar' => 'المستخدم', 'label_en' => 'User', 'sortable' => true, 'relation' => 'user', 'display' => 'full_name'],
                    'action'     => ['label_ar' => 'الإجراء', 'label_en' => 'Action', 'sortable' => true, 'type' => 'badge'],
                    'model_type' => ['label_ar' => 'النوع', 'label_en' => 'Model', 'sortable' => true],
                    'model_id'   => ['label_ar' => 'معرف السجل', 'label_en' => 'Record ID', 'sortable' => true],
                    'model_label'=> ['label_ar' => 'الوصف', 'label_en' => 'Label', 'searchable' => true],
                    'created_at' => ['label_ar' => 'التاريخ', 'label_en' => 'Date', 'sortable' => true, 'type' => 'datetime'],
                ],
                'relations'   => ['user'],
                'formFields'  => [],
                'filters' => [
                    'action'     => ['label_ar' => 'الإجراء', 'label_en' => 'Action', 'type' => 'select', 'options' => ['create', 'update', 'delete', 'restore', 'export', 'import']],
                    'model_type' => ['label_ar' => 'النوع', 'label_en' => 'Model', 'type' => 'text'],
                    'created_at' => ['label_ar' => 'التاريخ', 'label_en' => 'Date', 'type' => 'date_range'],
                ],
            ],
        ];
    }

    /**
     * Get a resource config by slug
     */
    public static function getResource(string $slug): ?array
    {
        return static::getResources()[$slug] ?? null;
    }

    /**
     * Get sidebar navigation grouped
     */
    public static function getSidebarNav(): array
    {
        $resources = static::getResources();
        $nav = [
            'data' => ['label_ar' => 'إدارة البيانات', 'label_en' => 'Data Management', 'items' => []],
            'system' => ['label_ar' => 'النظام', 'label_en' => 'System', 'items' => []],
        ];

        $systemSlugs = ['activity-log'];

        foreach ($resources as $slug => $config) {
            $item = [
                'slug'     => $slug,
                'label_ar' => $config['label_ar'],
                'label_en' => $config['label_en'],
                'icon'     => $config['icon'],
            ];

            if (in_array($slug, $systemSlugs)) {
                $nav['system']['items'][] = $item;
            } else {
                $nav['data']['items'][] = $item;
            }
        }

        // Add system pages that are not resources
        $nav['system']['items'][] = ['slug' => 'file-manager', 'label_ar' => 'إدارة الملفات', 'label_en' => 'File Manager', 'icon' => 'fa-folder-open'];
        $nav['system']['items'][] = ['slug' => 'api-explorer', 'label_ar' => 'مستكشف API', 'label_en' => 'API Explorer', 'icon' => 'fa-code'];

        return $nav;
    }
}
