<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'feedback_type',
        'priority',
        'status',
        'assigned_to',
        'response',
        'responded_by',
        'responded_at',
        'user_id', // if you have user authentication
        'ip_address',
        'user_agent'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'new',
        'priority' => 'medium',
    ];

    /**
     * Get the user that submitted the feedback (if applicable).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user this feedback is assigned to.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the admin user who responded to this feedback.
     */
    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Scope a query to only include feedback of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('feedback_type', $type);
    }

    /**
     * Scope a query to only include feedback with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include feedback with a specific priority.
     */
    public function scopeWithPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Check if the feedback has been responded to.
     */
    public function getIsRespondedAttribute()
    {
        return !is_null($this->response);
    }

    /**
     * Check if the feedback is assigned to someone.
     */
    public function getIsAssignedAttribute()
    {
        return !is_null($this->assigned_to);
    }
}