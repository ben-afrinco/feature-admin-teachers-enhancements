<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Student
 * 
 * This model represents a student participant within the educational platform.
 * It extends the core User_Model by adding domain-specific attributes such as
 * the student's proficiency level and their class assignments. It acts as a 
 * central hub for tracking a student's educational journey, including test 
 * performance and class participation.
 * 
 * @package App\Models
 * 
 * @property int $student_id The unique primary key identifier for the student record.
 * @property int $user_id The foreign key linking this student record to the base User_Model authentication profile.
 * @property int|null $class_id The foreign key identifying the primary class room to which the student is currently assigned.
 * @property string|null $level Represents the student's current English language proficiency level (e.g., 'A1', 'B2', 'C1') as mapped to the CEFR standard.
 * @property \Illuminate\Support\Carbon $created_at Timestamp marking the creation of the student profile.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp marking the last update to the student's proficiency or enrollment status.
 * 
 * @property-read \App\Models\User_Model $user The underlying user authentication profile and core personal details.
 * @property-read \App\Models\Classes|null $classRoom The primary class room entity associated with the student's current enrollment.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DentAnswer[] $answers An extensive collection of all test answers submitted by the student for assessment.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Classes[] $classes A collection of all classes (historical and current) the student has participated in via the class_student pivot.
 */
class Student extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'student';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'student_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'class_id', 'level'];

    /**
     * Get the base user profile for this student.
     * 
     * @return BelongsTo
     */
    public function user()      
    { 
        return $this->belongsTo(User_Model::class, 'user_id'); 
    }

    /**
     * Get the primary class room this student is assigned to.
     * 
     * @return BelongsTo
     */
    public function classRoom() 
    { 
        return $this->belongsTo(Classes::class, 'class_id'); 
    }

    /**
     * Get the answers submitted by this student.
     * 
     * @return HasMany
     */
    public function answers()   
    { 
        return $this->hasMany(DentAnswer::class, 'student_id'); 
    }

    /**
     * Get all classes the student is enrolled in (many-to-many relationship).
     * 
     * @return BelongsToMany
     */
    public function classes()   
    { 
        return $this->belongsToMany(Classes::class, 'class_student', 'student_id', 'class_id'); 
    }
}