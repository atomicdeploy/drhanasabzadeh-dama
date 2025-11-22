<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image_url',
        'link_url',
        'expires_at',
        'order',
        'view_count',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'order' => 'integer',
        'view_count' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now())
                    ->orWhere('status', 'expired');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Check if story is expired
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // Auto-set expiration (24 hours by default)
    public static function boot()
    {
        parent::boot();

        static::creating(function ($story) {
            if (!$story->expires_at) {
                $story->expires_at = now()->addHours(24);
            }
            if (!isset($story->order)) {
                $story->order = static::max('order') + 1 ?? 0;
            }
        });
    }
}
