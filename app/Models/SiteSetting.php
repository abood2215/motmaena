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
        'whatsapp'        => '96556551112',
        'phone'           => '96556551112',
        'address_ar'      => 'الكويت - برج أحمد - بجوار المستشفى الأميري',
        'address_en'      => 'Kuwait - Burj Ahmed - near Al-Amiri Hospital',
        'announcement_ar' => '',
        'announcement_en' => '',
        'dr_tariq_thursday' => '1', // "Appointments with Dr. Tariq" request box on the homepage and consultations page
        'dr_tariq_date'   => '', // optional: one day he sees people (the box shows it and hides after it); empty = open booking
        'psych_soon'      => '1', // homepage "psychological center — coming soon" ad; 0 hides it
        'gift_code_kwd'   => '10', // gift code (fixed KWD) for paying without a code; 0 turns it off
        // Ad / analytics tracking (Admin → Content → التتبّع والإعلانات); empty = use the .env value, if any
        'tr_ga4'                 => '',
        'tr_meta_pixel'          => '',
        'tr_tiktok_pixel'        => '',
        'tr_snap_pixel'          => '',
        'tr_google_verification' => '',
        'tr_meta_verification'   => '',
    ];

    /** Tracking keys → their .env fallback in config('services.analytics'). */
    public const TRACKING = [
        'tr_ga4'                 => 'ga4',
        'tr_meta_pixel'          => 'meta_pixel',
        'tr_tiktok_pixel'        => 'tiktok_pixel',
        'tr_snap_pixel'          => 'snap_pixel',
        'tr_google_verification' => 'google_verification',
        'tr_meta_verification'   => 'meta_verification',
    ];

    /**
     * Whether analytics and ad pixels may load on this request. Development copies of the site
     * must never send visits to the center's real Google Analytics / ad accounts.
     */
    public static function trackingAllowed(): bool
    {
        $forced = config('services.tracking_enabled');
        if ($forced !== null) {
            return (bool) $forced;
        }
        // Only the live site tracks: staging, local, testing, development… never do
        if (!app()->environment('production')) {
            return false;
        }

        return !in_array(request()->getHost(), ['localhost', '127.0.0.1', '::1', '[::1]'], true);
    }

    /** The tracking IDs in use: ['ga4' => 'G-…', 'meta_pixel' => '…', …], admin first, then .env. */
    public static function tracking(): array
    {
        $settings = rescue(fn () => static::current(), self::DEFAULTS, false);
        $env = (array) config('services.analytics', []);
        $out = [];
        foreach (self::TRACKING as $key => $name) {
            $out[$name] = filled($settings[$key] ?? null) ? $settings[$key] : ($env[$name] ?? null);
        }
        return $out;
    }

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

    /** "96556551112" -> "+965 56551112" */
    public static function pretty(string $digits): string
    {
        $digits = preg_replace('/\D/', '', $digits);
        if (str_starts_with($digits, '965') && strlen($digits) === 11) {
            return '+965 ' . substr($digits, 3);
        }
        return '+' . $digits;
    }
}
