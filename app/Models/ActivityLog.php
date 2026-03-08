<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ActivityLog - Tracks all data changes in the admin panel.
 */
class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id',
        'model_label', 'old_values', 'new_values',
        'changed_fields', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changed_fields' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User_Model::class, 'user_id', 'user_id');
    }

    /**
     * Log an activity.
     */
    public static function log(string $action, string $modelType, $modelId = null, array $extra = []): self
    {
        return static::create(array_merge([
            'user_id'    => session('user_id'),
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $extra));
    }
}
