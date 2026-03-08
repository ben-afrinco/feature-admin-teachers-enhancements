<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class AssignmentSubmission
 * 
 * This model represents the formal delivery of student work for an assignment.
 * It tracks the overall progress of a student's attempt, including current 
 * grading status, awarded score, and qualitative feedback from the instructor.
 * 
 * @package App\Models
 * 
 * @property int $id The unique primary key for the student's submission record.
 * @property int $assignment_id The foreign key linking back to the parent Assignment definition.
 * @property int $student_id The foreign key identifying the student who authored the work.
 * @property string $status The current state of the submission workflow (e.g., 'submitted', 'returned', 'graded').
 * @property float|null $grade The final quantitative evaluation score awarded to the student.
 * @property string|null $teacher_comment Personalised guidance and critique provided by the evaluator.
 * @property \Illuminate\Support\Carbon $created_at Timestamp when the first version of the work was uploaded.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the most recent evaluation or file update.
 * 
 * @property-read \App\Models\Assignment $assignment The specific coursework definition being responded to.
 * @property-read \App\Models\Student $student The author/student who provided this specific delivery.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubmissionVersion[] $versions A collection of all iterative versions and files uploaded for this submission.
 */
class AssignmentSubmission extends Model
{
    use HasFactory;

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'assignment_id',
        'student_id',
        'status',
        'grade',
        'teacher_comment',
    ];

    /**
     * Get the assignment that this submission belongs to.
     * 
     * @return BelongsTo
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student who submitted the assignment.
     * 
     * @return BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    /**
     * Get the versions/files for this submission.
     * 
     * @return HasMany
     */
    public function versions()
    {
        return $this->hasMany(SubmissionVersion::class, 'submission_id');
    }
}

