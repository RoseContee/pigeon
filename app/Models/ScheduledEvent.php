<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'invitee_name', 'invitee_email', 'invitee_phone', 'scheduled_date', 'timezone',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function event() {
        return $this->belongsTo('App\Models\UserEvent', 'event_id', 'id');
    }
}
