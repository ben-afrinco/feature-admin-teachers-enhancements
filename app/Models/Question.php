<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Question
 * 
 * This model represents an individual item or prompt within a structured test.
 * It contains the instructional content, defines the response format type,
 * and maintains metadata like difficulty for assessment analysis.
 * 
 * @package App\Models
 * 
 * @property int $question_id The unique primary key identifier for the question record.
 * @property int $test_id The foreign key linking this question to a parent Test model.
 * @property string $question_text The primary text content or prompt for the student.
 * @property string $question_type The classification of the response format (e.g., 'multiple_choice', 'true_false').
 * @property string $difficulty_level The assigned complexity rating (e.g., 'Easy', 'Medium', 'Hard').
 * @property \Illuminate\Support\Carbon $created_at Timestamp when the question was first added to the curriculum.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp of the most recent change to the question.
 * 
 * @property-read \App\Models\Test $test The parent examination that includes this question.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Option[] $options A collection of all possible answer choices for multiple-choice formats.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DentAnswer[] $answers A collection of student-submitted responses to this specific question.
 */
class Question extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'questions';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'question_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['test_id', 'question_text', 'question_type', 'difficulty_level'];

    /**
     * Get the test that owns this question.
     * 
     * @return BelongsTo
     */
    public function test()    
    { 
        return $this->belongsTo(Test::class, 'test_id'); 
    }

    /**
     * Get the options associated with this question.
     * 
     * @return HasMany
     */
    public function options() 
    { 
        return $this->hasMany(Option::class, 'question_id'); 
    }

    /**
     * Get the student answers submitted for this question.
     * 
     * @return HasMany
     */
    public function answers() 
    { 
        return $this->hasMany(DentAnswer::class, 'question_id'); 
    }
}