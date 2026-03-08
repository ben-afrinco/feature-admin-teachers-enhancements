<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Classes
 * 
 * This model represents a specific academic class or study group.
 * It serves as the organizational unit for instructional activities, linking 
 * students, teachers, and online sessions.
 * 
 * @package App\Models
 * 
 * @property int $class_id The unique primary key identifier for the class record.
 * @property string $classes_name The descriptive name or title of the class.
 * @property int $teacher_id The foreign key linking to the Teacher model who manages this class.
 * @property string $level The target proficiency level the class is designed for (e.g., 'Beginner', 'Intermediate').
 * @property string|null $description A detailed overview of the class objectives or curriculum.
 * @property \Illuminate\Support\Carbon $created_at Timestamp when the class was first established.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the most recent modification to the class details.
 * 
 * @property-read \App\Models\Teacher $teacher The instructor assigned to lead and manage this specific class.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students A collection of all students currently enrolled in this class.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OnlineSession[] $onlineSessions A collection of all online live sessions scheduled for this class.
 */
class Classes extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'classes';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'class_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['classes_name', 'teacher_id', 'level', 'description'];

    /**
     * Get the teacher that owns the class.
     * 
     * @return BelongsTo
     */
    public function teacher() 
    { 
        return $this->belongsTo(Teacher::class, 'teacher_id'); 
    }

    /**
     * Get the students enrolled in this class (many-to-many relationship).
     * 
     * @return BelongsToMany
     */
    public function students() 
    { 
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id'); 
    }

    /**
     * Get the online sessions scheduled for this class.
     * 
     * @return HasMany
     */
    public function onlineSessions() 
    { 
        return $this->hasMany(OnlineSession::class, 'class_id'); 
    }
}
