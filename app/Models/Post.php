<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Sluggable;
    
    protected $guarded = ['id'];

    protected $with = ['unit', 'category', 'topic', 'comments', 'user'];

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeFilter($query, array $filters) {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when($filters['topic'] ?? false, function ($query, $topic) {
            return $query->whereHas('topic', function ($query) use ($topic) {
                $query->where('slug', $topic);
            });
        });
    }

    public function scopeFinished($query)
    {
        return $query->where('is_finished', '=', 1);
    }

    public function scopeUnfinished($query)
    {
        return $query->where('is_finished', '=', 0);
    }

    public function scopeUnit($query)
    {
        return $query->where('unit_id', '=', auth()->user()->unit_id);
    }
}