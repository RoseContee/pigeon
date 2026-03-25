<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'mon', 'tue', 'wed', 'thu', 'fri', 'active'
    ];

    public function scopeActive($query) {
        return $query->where('active', 1);
    }
}
