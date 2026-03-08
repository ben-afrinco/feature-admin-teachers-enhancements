<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SubmissionVersion
 * 
 * Represents a specific version or file upload in an assignment submission.
 * Supports multiple iterations/fixes for a single assignment.
 * 
 * @package App\Models
 * 
 * @property int $id Unique identifier for the version.
 * @property int $submission_id Foreign key linking to the AssignmentSubmission model.
 * @property string|null $content Text content or summary of the version.
 * @property string|null $file_path Path to the uploaded file for this version.
 * @property int $version The version number (increments over time).
 * @property bool $is_late Flag indicating if this version was submitted after the deadline.
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \App\Models\AssignmentSubmission $submission The parent submission record.
 */
class SubmissionVersion extends Model
{
    use HasFactory;

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'submission_id',
        'content',
        'file_path',
        'version',
        'is_late',
    ];

    /**
     * Get the submission that owns this version.
     * 
     * @return BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class, 'submission_id');
    }
}

