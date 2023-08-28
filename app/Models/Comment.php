<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}