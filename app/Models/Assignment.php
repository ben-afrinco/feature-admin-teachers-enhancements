<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Assignment
 * 
 * This model represents a specific coursework task or project assigned by a teacher.
 * It tracks the task details, primary class assignment, and assessment parameters
 * like maximum grades and deadlines.
 * 
 * @package App\Models
 * 
 * @property int $id The unique primary key identifier for the assignment record.
 * @property int $class_id The foreign key linking this assignment to a specific academic class.
 * @property int $teacher_id The foreign key identifying the instructor who created and manages this assignment.
 * @property string $title The descriptive title for the assignment task.
 * @property string|null $description Comprehensive instructions or requirements provided to the students.
 * @property \Illuminate\Support\Carbon $due_date The strict deadline by which all students must submit their work.
 * @property float $max_grade The maximum attainable score or grade for this assignment.
 * @property \Illuminate\Support\Carbon $created_at Timestamp marking when the assignment was first published.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp marking the latest modification to assignment details.
 * 
 * @property-read \App\Models\Classes $classRoom The specific academic class for which this assignment was created.
 * @property-read \App\Models\Teacher $teacher The instructor responsible for creating and grading this assignment.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AssignmentAttachment[] $attachments A collection of supplementary files or resources attached to the assignment.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AssignmentSubmission[] $submissions A collection of all student work submitted in response to this assignment.
 */
class Assignment extends Model
{
    use HasFactory;

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_id',
        'teacher_id',
        'title',
        'description',
        'due_date',
        'max_grade',
    ];

    /**
     * @var array The attributes that should be cast.
     */
    protected $casts = [
        'due_date' => 'datetime',
        'max_grade' => 'decimal:2',
    ];

    /**
     * Get the class room this assignment belongs to.
     * 
     * Named 'classRoom' because 'class' is a reserved PHP keyword.
     * 
     * @return BelongsTo
     */
    public function classRoom()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }

    /**
     * Get the teacher who created this assignment.
     * 
     * @return BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    /**
     * Get the attachments associated with this assignment.
     * 
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(AssignmentAttachment::class);
    }

    /**
     * Get the student submissions for this assignment.
     * 
     * @return HasMany
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}

