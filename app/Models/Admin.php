<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Admin
 * 
 * This model encapsulates administrative users who possess system-wide 
 * management privileges. It extends the core User_Model, enabling these 
 * specific users to oversee educational content, manage user roles, and 
 * perform critical system maintenance tasks.
 * 
 * @package App\Models
 * 
 * @property int $admin_id The unique primary key identifier for the administrative record.
 * @property int $user_id The foreign key that links this administrative role to a base User_Model profile.
 * @property \Illuminate\Support\Carbon $created_at Timestamp tracking when the administrative account was first established.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp tracking the most recent modification to the admin's details.
 * 
 * @property-read \App\Models\User_Model $user The underlying user profile providing core authentication and identity data.
 */
class Admin extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'admin';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'admin_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['user_id'];

    /**
     * Get the base user profile for this admin.
     * 
     * @return BelongsTo
     */
    public function user() 
    { 
        return $this->belongsTo(User_Model::class, 'user_id'); 
    }
}