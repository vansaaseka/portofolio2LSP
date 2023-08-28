<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function units() {
        return $this->hasMany(Unit::class);
    }
}