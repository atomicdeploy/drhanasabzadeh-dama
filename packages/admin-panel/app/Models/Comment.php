<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'parent_id',
        'content',
        'rating',
        'status',
        'is_pinned',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_pinned' => 'boolean',
    ];

    // Relationships
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    // Check if comment has replies
    public function hasReplies()
    {
        return $this->replies()->count() > 0;
    }
}
