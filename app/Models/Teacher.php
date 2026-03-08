<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Teacher
 * 
 * This model represents an instructor or educator within the system.
 * It acts as an extension of the User_Model, specifically identifying users
 * with the authority to manage classes, create assessments, and evaluate 
 * student performance. It bridges the gap between core user data and 
 * class management functionality.
 * 
 * @package App\Models
 * 
 * @property int $teacher_id The unique internal primary key identifying the teacher record.
 * @property int $user_id The foreign key establishing the relationship with the base User_Model authentication system.
 * @property \Illuminate\Support\Carbon $created_at Timestamp of the instructor's initial registration/onboarding.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the latest modification to the teacher's profile or assignment data.
 * 
 * @property-read \App\Models\User_Model $user The base user account providing authentication and core personal details for the instructor.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Classes[] $classes A collection of all academic classes currently or previously managed and taught by this instructor.
 */
class Teacher extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'teachers';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'teacher_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['user_id'];

    /**
     * Get the base user profile for this teacher.
     * 
     * @return BelongsTo
     */
    public function user()    
    { 
        return $this->belongsTo(User_Model::class, 'user_id'); 
    }

    /**
     * Get the classes associated with this teacher.
     * 
     * @return HasMany
     */
    public function classes() 
    { 
        return $this->hasMany(Classes::class, 'teacher_id'); 
    }
}