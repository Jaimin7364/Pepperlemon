<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected static $cachedSettings = null;

    /**
     * Retrieve a setting by its key with request-level caching.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (self::$cachedSettings === null) {
            self::$cachedSettings = self::pluck('value', 'key')->all();
        }
        return self::$cachedSettings[$key] ?? $default;
    }
}
