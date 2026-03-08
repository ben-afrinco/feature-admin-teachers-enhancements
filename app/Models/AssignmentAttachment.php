<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AssignmentAttachment
 * 
 * This model represents a supplementary file or resource linked to an assignment.
 * It maintains the reference between an assignment and its instructional 
 * materials or supporting documentation stored on the server.
 * 
 * @package App\Models
 * 
 * @property int $id The unique primary key identifier for the attachment record.
 * @property int $assignment_id The foreign key linking this file to a parent Assignment record.
 * @property string $file_path The internal relative directory path where the physical file is stored.
 * @property string $file_name The human-readable original name of the uploaded document.
 * @property \Illuminate\Support\Carbon $created_at Timestamp marking when the file was first attached.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the last modification to attachment metadata.
 * 
 * @property-read \App\Models\Assignment $assignment The parent assignment definition that includes this supplementary resource.
 */
class AssignmentAttachment extends Model
{
    use HasFactory;

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'assignment_id',
        'file_path',
        'file_name',
    ];

    /**
     * Get the assignment that owns this attachment.
     * 
     * @return BelongsTo
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}

