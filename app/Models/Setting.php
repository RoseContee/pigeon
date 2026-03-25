<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_key', 'meta_value',
    ];

    public static function getSetting($key = null)
    {
        if (is_array($key)) {
            $setting = self::whereIn('meta_key', $key)->get();
        } else if (gettype($key) == 'string') {
            $setting = self::where('meta_key', $key)->first();
            return empty($setting) ? null : $setting['meta_value'];
        } else {
            $setting = self::get();
        }
        $result = [];
        foreach ($setting as $s) {
            $result[$s['meta_key']] = $s['meta_value'];
        }
        return $result;
    }

    public static function saveSetting($setting, $value = null)
    {
        if (is_array($setting)) {
            foreach ($setting as $key => $value) {
                self::updateOrCreate([
                    'meta_key' => $key,
                ], [
                    'meta_value' => $value,
                ]);
            }
        } else if (gettype($setting) == 'string') {
            self::updateOrCreate([
                'meta_key' => $setting,
            ], [
                'meta_value' => $value,
            ]);
        }
    }
}
