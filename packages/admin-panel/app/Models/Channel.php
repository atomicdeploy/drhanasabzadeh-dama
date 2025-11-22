<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'status',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function posts()
    {
        return $this->hasMany(ChannelPost::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
