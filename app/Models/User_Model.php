<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User_Model
 * 
 * This model serves as the primary authentication and profile management entity within the system.
 * It stores core user attributes such as identification, credentials, and role assignments.
 * Through its relationships, it links to specific role-based profiles (Student, Teacher, Admin)
 * providing a unified entry point for user-related data access across the platform.
 * 
 * @package App\Models
 * 
 * @property int $user_id The unique primary key identifier for the user record.
 * @property string $full_name The user's complete name, stored in an encrypted format to ensure privacy and security.
 * @property string $email The unique email address used as the primary login credential and for system notifications.
 * @property string $password The securely hashed password string used for authentication during login.
 * @property string $role Categorizes the user's permissions and functionality within the system (e.g., 'student', 'teacher', 'admin').
 * @property string|null $avatar The storage path or URL to the user's profile image/avatar.
 * @property \Illuminate\Support\Carbon $created_at Timestamp indicating when the user account was first registered.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp indicating the last time the user's profile information was modified.
 * 
 * @property-read \App\Models\Student|null $student The detailed student-specific profile associated with this user core, if the role is 'student'.
 * @property-read \App\Models\Teacher|null $teacher The detailed teacher-specific profile associated with this user core, if the role is 'teacher'.
 * @property-read \App\Models\Admin|null $admin The administrative profile linked to this user, grant access to system-wide management features.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Result[] $results A collection of all test results associated with this user, facilitating progress tracking.
 */
class User_Model extends Model 
{
    use Notifiable;

    /**
     * @var string The table associated with the model.
     */
    protected $table = 'user';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'user_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['full_name', 'email', 'password', 'role', 'avatar'];

    /**
     * @var array The attributes that should be cast.
     */
    protected $casts = [
        'full_name' => 'encrypted',
    ];

    /**
     * Get the student profile associated with the user.
     * 
     * @return HasOne
     */
    public function student() 
    { 
        return $this->hasOne(Student::class, 'user_id'); 
    }

    /**
     * Get the teacher profile associated with the user.
     * 
     * @return HasOne
     */
    public function teacher() 
    { 
        return $this->hasOne(Teacher::class, 'user_id'); 
    }

    /**
     * Get the admin profile associated with the user.
     * 
     * @return HasOne
     */
    public function admin()   
    { 
        return $this->hasOne(Admin::class, 'user_id'); 
    }

    /**
     * Get the test results for the user.
     * 
     * @return HasMany
     */
    public function results() 
    { 
        return $this->hasMany(Result::class, 'user_id'); 
    }
}