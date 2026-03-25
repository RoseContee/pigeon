<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'start_date', 'end_date',
        'schedule_id', 'mon', 'tue', 'wed', 'thu', 'fri', 'duration', 'break_time', 'timezone', 'active',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function schedule() {
        return $this->belongsTo('App\Models\UserSchedule', 'schedule_id', 'id');
    }

    public function scopeActive($query) {
        return $query->where('active', 1);
    }
}
