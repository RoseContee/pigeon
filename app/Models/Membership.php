<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_package_id', 'name', 'price', 'limitation', 'event', 'schedule', 'description', 'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function membership_package() {
        return $this->belongsTo('App\Models\MembershipPackage');
    }
}
