<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Grade
 * 
 * Represents final grading records for a user in a specific class.
 * Includes various components like midterm, final, and oral scores.
 * 
 * @package App\Models
 * 
 * @property int $id Unique identifier for the grade record.
 * @property int $user_id Foreign key linking to the base User_Model.
 * @property int $class_id Foreign key linking to the Classes model.
 * @property float|null $midterm Midterm examination score.
 * @property float|null $final Final examination score.
 * @property float|null $oral Oral examination or participation score.
 * @property string|null $notes Additional notes or feedback regarding the grade.
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Grade extends Model
{
    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'class_id',
        'midterm',
        'final',
        'oral',
        'notes',
    ];
}

