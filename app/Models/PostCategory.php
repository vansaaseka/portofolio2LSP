<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posts() {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'category_id');
    }

    public function getRouteKeyName() {
        return 'slug';
    }
}