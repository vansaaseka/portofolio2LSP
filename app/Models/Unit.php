<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'tickets'];

    
    public function users() {
        return $this->hasMany(User::class);
    }

    public function category() {
        return $this->belongsTo(UnitCategory::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function topics() {
        return $this->hasMany(Topic::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}