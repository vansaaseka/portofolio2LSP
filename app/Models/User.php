<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'unit_id',
        'admin_category_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['unit', 'detail', 'role'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function adminCategory() {
        return $this->belongsTo(AdminCategory::class, 'admin_category_id');
    }

    public function detail() {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeUnit($query)
    {
        return $query->where('unit_id', '=', auth()->user()->unit_id);
    }
}