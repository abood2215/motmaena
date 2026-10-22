<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['key', 'value'];

    private const CACHE_KEY = 'site_settings';

    /** Defaults used before the settings table exists or when a value is empty. */
    public const DEFAULTS = [
        'whatsapp'        => '96555665161',
        'phone'           => '96599880140',
        'address_ar'      => 'الكويت - برج أحمد - بجوار المستشفى الأميري',
        'address_en'      => 'Kuwait - Burj Ahmed - near Al-Amiri Hospital',
        'announcement_ar' => '',
        'announcement_en' => '',
        'gift_code_kwd'   => '10', // gift code (fixed KWD) for paying without a code; 0 turns it off
    ];

    public static function current(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = Schema::hasTable('site_settings') ? static::pluck('value', 'key')->all() : [];
            return array_merge(self::DEFAULTS, array_filter($stored, fn ($v) => $v !== null && $v !== ''));
        });
    }

    public static function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget(self::CACHE_KEY);
    }

    /** "96555665161" -> "+965 5566 5161" */
    public static function pretty(string $digits): string
    {
        $digits = preg_replace('/\D/', '', $digits);
        if (str_starts_with($digits, '965') && strlen($digits) === 11) {
            return '+965 ' . substr($digits, 3, 4) . ' ' . substr($digits, 7);
        }
        return '+' . $digits;
    }
}
