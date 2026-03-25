<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'membership_id', 'limitation', 'event', 'schedule', 'start_date', 'end_date',
        'booking_number', 'active', 'api_token', 'google_id', 'avatar', 'slug',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function membership() {
        return $this->belongsTo('App\Models\Membership', 'membership_id', 'id');
    }

    public function guests() {
        return $this->hasMany('App\Models\Guest');
    }

    public function meetings() {
        return $this->hasMany('App\Models\Meeting');
    }

    public function metas() {
        return $this->hasMany('App\Models\UserMeta');
    }

    public function schedules() {
        return $this->hasMany('App\Models\UserSchedule');
    }

    public function events() {
        return $this->hasMany('App\Models\UserEvent');
    }
}
