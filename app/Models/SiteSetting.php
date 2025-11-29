<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get current catalog PDF path
     */
    public static function getCatalogPath()
    {
        return self::get('catalog_pdf', 'catalogs/katalog_shinta.pdf');
    }

    /**
     * Update catalog PDF path
     */
    public static function setCatalogPath($path)
    {
        return self::set('catalog_pdf', $path);
    }
}
