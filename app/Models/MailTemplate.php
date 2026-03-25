<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category', 'subject', 'body',
    ];

    /**
     *
     * Scope a query to only include users of a given category.
     *
     * @param $query
     * @param $category
     * @return mixed
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
