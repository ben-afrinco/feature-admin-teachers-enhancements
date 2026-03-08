<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Result
 * 
 * This model represents the finalized evaluation outcome for a test taker.
 * It records the quantitative performance of a user after completing a 
 * specific assessment, linking the user to their achievement.
 * 
 * @package App\Models
 * 
 * @property int $result_id The unique internal primary key for the test result.
 * @property int $user_id The foreign key linking this result to the User_Model who took the test.
 * @property int $test_id The foreign key linking this result to the specific Test that was completed.
 * @property float $final_score The total numerical score or percentage achieved by the user.
 * @property \Illuminate\Support\Carbon $created_at Timestamp marking when the result was first recorded.
 * @property \Illuminate\Support\Carbon $updated_at Timestamp marking the latest update to the result record.
 * 
 * @property-read \App\Models\User_Model $user The specific user/student associated with this score.
 * @property-read \App\Models\Test $test The specific examination or assessment that generated this result.
 */
class Result extends Model 
{
    /**
     * @var string The table associated with the model.
     */
    protected $table = 'result';

    /**
     * @var string The primary key for the model.
     */
    protected $primaryKey = 'result_id';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'test_id', 'final_score'];

    /**
     * Get the user who owns the result.
     * 
     * @return BelongsTo
     */
    public function user() 
    { 
        return $this->belongsTo(User_Model::class, 'user_id'); 
    }

    /**
     * Get the test associated with the result.
     * 
     * @return BelongsTo
     */
    public function test() 
    { 
        return $this->belongsTo(Test::class, 'test_id'); 
    }
}