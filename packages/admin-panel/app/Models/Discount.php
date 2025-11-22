<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'usage_limit_per_user',
        'usage_limit_total',
        'used_count',
        'minimum_purchase_amount',
        'applicable_type',
        'applicable_ids',
        'status',
        'description',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_purchase_amount' => 'decimal:2',
        'applicable_ids' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'used_count' => 'integer',
        'usage_limit_per_user' => 'integer',
        'usage_limit_total' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now())
                    ->orWhere('status', 'expired');
    }

    // Check if discount is valid
    public function isValid()
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        if ($this->usage_limit_total && $this->used_count >= $this->usage_limit_total) {
            return false;
        }

        return true;
    }

    // Calculate discount amount
    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return $amount * ($this->value / 100);
        }

        return min($this->value, $amount);
    }
}
