<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Option
 * 
 * This model represents a potential answer choice for a multiple-choice question.
 * It contains the option text and a flag indicating its correctness for 
 * automated grading purposes.
 * 
 * @package App\Models
 * 
 * @property int $option_id The unique primary key identifier for the answer option.
 * @property int $question_id The foreign key linking this option to its parent Question.
 * @property string $optione_text The text content displayed to the user as a possible choice. (Note: typo 'optione_text' preserved for DB consistency).
 * @property bool $is_correct A boolean flag; true if this option is the officially correct answer.
 * @property \Illuminate\Support\Carbon $created_at Timestamp when the option was first established.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the latest modification to the option text or status.
 * 
 * @property-read \App\Models\Question $question The parent question that this choice belongs to.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DentAnswer[] $answers A collection of all student answers that selected this specific option.
 */
class Option extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'options';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'option_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['question_id', 'optione_text', 'is_correct'];

    /**
     * Get the question that owns this option.
     * 
     * @return BelongsTo
     */
    public function question() 
    { 
        return $this->belongsTo(Question::class, 'question_id'); 
    }

    /**
     * Get the student answers that chose this option.
     * 
     * @return HasMany
     */
    public function answers()  
    { 
        return $this->hasMany(DentAnswer::class, 'option_id'); 
    }
}