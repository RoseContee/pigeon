<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'meta_key', 'meta_value',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public static function getSetting($user_id, $key = null, $like = null)
    {
        $setting = self::where('user_id', $user_id);
        if (is_array($key)) {
            if (empty($like)) {
                $setting = $setting->whereIn('meta_key', $key)->get();
            } else {
                $setting = $setting->where(function($q) use ($key) {
                    foreach ($key as $k) {
                        $q = $q->orWhere('meta_key', 'like', $k);
                    }
                })->get();
            }
        } else if (gettype($key) == 'string') {
            if (empty($like)) {
                $setting = $setting->where('meta_key', $key)->first();
                return $setting ? $setting['meta_value'] : null;
            } else {
                $setting = $setting->where('meta_key', 'like', $key)->get();
            }
        } else {
            $setting = $setting->get();
        }
        $result = [];
        foreach ($setting as $s) {
            $result[$s['meta_key']] = $s['meta_value'];
        }
        return $result;
    }

    public static function saveSetting($user_id, $setting, $value = null)
    {
        if (is_array($setting)) {
            foreach ($setting as $key => $value) {
                self::updateOrCreate([
                    'user_id' => $user_id,
                    'meta_key' => $key,
                ], [
                    'meta_value' => $value,
                ]);
            }
        } else if (gettype($setting) == 'string') {
            self::updateOrCreate([
                'user_id' => $user_id,
                'meta_key' => $setting,
            ], [
                'meta_value' => $value,
            ]);
        }
    }
}
