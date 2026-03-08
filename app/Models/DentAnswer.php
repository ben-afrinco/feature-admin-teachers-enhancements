<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class DentAnswer
 * 
 * This model represents a student's individual response to a specific test question.
 * It serves as the bridge between a student, their choice (Option), and 
 * optionally provides space for open-ended text and associated AI evaluations.
 * 
 * @package App\Models
 * 
 * @property int $answer_id The unique primary key identifier for the submitted answer.
 * @property int $student_id The foreign key identifying the student who submitted the response.
 * @property int $question_id The foreign key linking this answer to the specific Question being addressed.
 * @property int|null $option_id The foreign key to the selected Option (used for closed-ended questions).
 * @property string|null $answer_text The raw text input provided by the student (used for open-ended questions).
 * @property \Illuminate\Support\Carbon $created_at Timestamp marking when the answer was first submitted.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of any subsequent modifications to the response.
 * 
 * @property-read \App\Models\Student $student The student who authored and submitted this specific response.
 * @property-read \App\Models\Question $question The assessment question that this response answers.
 * @property-read \App\Models\Option|null $option The specific choice selected by the student (if multiple choice).
 * @property-read \App\Models\Evaluation|null $aiEvaluation Detailed AI-powered analysis and scoring associated with this response.
 */
class DentAnswer extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'dent_answer';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'answer_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['student_id', 'question_id', 'option_id', 'answer_text'];

    /**
     * Get the student who owns the answer.
     * 
     * @return BelongsTo
     */
    public function student()  
    { 
        return $this->belongsTo(Student::class, 'student_id'); 
    }

    /**
     * Get the question associated with the answer.
     * 
     * @return BelongsTo
     */
    public function question() 
    { 
        return $this->belongsTo(Question::class, 'question_id'); 
    }

    /**
     * Get the specific option selected (for multi-choice questions).
     * 
     * @return BelongsTo
     */
    public function option()   
    { 
        return $this->belongsTo(Option::class, 'option_id'); 
    }

    /**
     * Get the associated AI evaluation for this answer.
     * 
     * @return HasOne
     */
    public function aiEvaluation() 
    { 
        return $this->hasOne(Evaluation::class, 'answer_id'); 
    }
}