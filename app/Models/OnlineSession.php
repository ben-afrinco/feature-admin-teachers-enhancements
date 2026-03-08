<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OnlineSession
 * 
 * This model represents a scheduled virtual instructional meeting.
 * It facilitates remote learning by managing room details, access links, 
 * and integration parameters for online live classroom environments.
 * 
 * @package App\Models
 * 
 * @property int $session_id The unique primary key identifying the virtual session.
 * @property int $class_id The foreign key linking this session to a specific academic class.
 * @property int $teacher_id The foreign key identifying the instructor hosting the session.
 * @property string $room_name The unique identifier or name used for the external virtual meeting room.
 * @property string $topic The subject or agenda for the live instructional meeting.
 * @property string|null $join_url The validated hyperlink allowing participants to access the live session.
 * @property \Illuminate\Support\Carbon $start_time The specific date and hour the session is scheduled to commence.
 * @property int $duration The total length of the session expressed in minutes.
 * @property string $status The current operational status (e.g., 'scheduled', 'live', 'completed').
 * @property \Illuminate\Support\Carbon $created_at Timestamp when the session was first created in the system.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the most recent modification to session details.
 * 
 * @property-read \App\Models\Classes $classRoom The formal academic group for which this session is being provided.
 * @property-read \App\Models\Teacher $teacher The primary instructor or host of this virtual instructional event.
 */
class OnlineSession extends Model
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'online_sessions';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'session_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'class_id',
        'teacher_id',
        'room_name',
        'topic',
        'join_url',
        'start_time',
        'duration',
        'status',
    ];

    /**
     * @var array The attributes that should be cast.
     */
    protected $casts = [
        'start_time' => 'datetime',
    ];

    /**
     * Get the class room this session belongs to.
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
     * Get the teacher that hosts the session.
     * 
     * @return BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }
}

