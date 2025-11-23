<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'teacher_id',
        'price',
        'discount_price',
        'level',
        'duration_hours',
        'language',
        'thumbnail',
        'status',
        'published_at',
        'enrollment_count',
        'rating',
        'rating_count',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'duration_hours' => 'integer',
        'enrollment_count' => 'integer',
        'rating' => 'decimal:2',
        'rating_count' => 'integer',
        'view_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function liveSession()
    {
        return $this->hasMany(LiveSession::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }
}
