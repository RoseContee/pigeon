<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function app() {
        return $this->belongsTo('App\Models\App');
    }
}
