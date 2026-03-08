<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ChatSession
 * 
 * Represents an AI-powered chat session or individual message exchange.
 * Used for storing history of interactions between users and the AI assistant.
 * 
 * @package App\Models
 * 
 * @property int $id Unique identifier for the chat session.
 * @property int $user_id Foreign key linking to the base User_Model.
 * @property string $role The role of the message sender ('user' or 'assistant').
 * @property string $content The text content of the message.
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \App\Models\User_Model $user The user involved in the chat session.
 */
class ChatSession extends Model
{
    use HasFactory;
    
    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'role', 'content'];

    /**
     * Get the user that owns the chat session.
     * 
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User_Model::class, 'user_id', 'user_id');
    }
}

