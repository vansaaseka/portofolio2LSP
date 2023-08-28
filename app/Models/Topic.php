<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['category'];
    
    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function category() {
        return $this->belongsTo(PostCategory::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName() {
        return 'slug';
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($topics) {
            $topics->posts()->delete();
        });
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function scopeUnit($query)
    {
        return $query->where('unit_id', '=', auth()->user()->unit_id);
    }
}