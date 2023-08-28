<?php

namespace App\Models;

use App\Mail\MailNotify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $with = ['user', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeFinished($query)
    {
        return $query->where('is_finished', '=', 2);
    }

    public function scopeUnfinished($query)
    {
        return $query->where('is_finished', '!=', 2);
    }

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%'.$search.'%')
                ->orWhere('id', 'like', $search);
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

    public function scopeUnit($query)
    {
        return $query->where('unit_id', '=', auth()->user()->unit_id);
    }
}