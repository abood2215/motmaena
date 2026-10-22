<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CourseOffer extends Model
{
    public const DEFAULT_IMAGE = 'courses-img/dr-tariq.png';
    public const DEFAULT_THEME = '#6d1b2b';
    /** Registration, payment and thank-you pages always use the center's wine colour. */
    public const CHECKOUT_THEME = '#6d1b2b';

    /** Ready-made banner colours offered in the admin (any colour can still be picked). */
    public const THEMES = [
        '#6d1b2b' => 'عنابي خمري (لون المركز)',
        '#1d4e89' => 'أزرق',
        '#8a2f2f' => 'أحمر',
        '#0f5e4a' => 'أخضر',
        '#4c2a85' => 'بنفسجي',
        '#0e5a6b' => 'تركوازي',
        '#7a4b14' => 'بني ذهبي',
        '#9d2c5f' => 'وردي',
        '#1f2937' => 'كحلي غامق',
    ];

    protected $fillable = [
        'slug', 'title_ar', 'title_en', 'trainer_ar', 'trainer_en', 'price', 'seats', 'date',
        'time_ar', 'time_en', 'location_ar', 'location_en', 'certificate_ar', 'certificate_en',
        'topics_ar', 'topics_en', 'image', 'theme_color', 'badge_ar', 'badge_en', 'show_installments', 'share_image',
        'is_active', 'is_featured',
    ];

    protected $casts = [
        'price'       => 'decimal:3',
        'date'        => 'date',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'show_installments' => 'boolean',
    ];

    /** Open for registration: switched on and the course date hasn't passed. */
    public function scopeOpen($query)
    {
        return $query->where('is_active', true)->whereDate('date', '>=', now()->toDateString());
    }

    public static function findActive(?string $slug): ?self
    {
        return $slug ? static::open()->where('slug', $slug)->first() : null;
    }

    /** The course shown in the homepage banner and announcement strip. */
    public static function featured(): ?self
    {
        return static::open()->where('is_featured', true)->orderBy('date')->first();
    }

    public static function upcoming()
    {
        return static::open()->orderBy('date')->get();
    }

    public function seatsTaken(): int
    {
        return CourseRegistration::where('course_key', $this->slug)->where('status', 'paid')->count();
    }

    /** null = no seat limit */
    public function seatsLeft(): ?int
    {
        return $this->seats ? max(0, $this->seats - $this->seatsTaken()) : null;
    }

    public function isFull(): bool
    {
        return $this->seatsLeft() === 0;
    }

    /**
     * Array shape the views were written against: ['title' => ['ar' => .., 'en' => ..], ...].
     * English falls back to Arabic when left empty in the admin.
     */
    public function toOfferArray(): array
    {
        $pair = fn (string $field) => ['ar' => (string) $this->{$field . '_ar'}, 'en' => (string) ($this->{$field . '_en'} ?: $this->{$field . '_ar'})];
        $lines = fn (?string $text) => array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $text))));
        $date = Carbon::parse($this->date);

        return [
            'slug'        => $this->slug,
            'active'      => $this->is_active,
            'title'       => $pair('title'),
            'trainer'     => $pair('trainer'),
            'price'       => rtrim(rtrim(number_format((float) $this->price, 3, '.', ''), '0'), '.'),
            'date'        => $date->toDateString(),
            'day'         => ['ar' => $date->copy()->locale('ar')->dayName, 'en' => $date->copy()->locale('en')->dayName],
            'time'        => $pair('time'),
            'location'    => $pair('location'),
            'certificate' => $pair('certificate'),
            'topics'      => ['ar' => $lines($this->topics_ar), 'en' => $lines($this->topics_en) ?: $lines($this->topics_ar)],
            'image'       => $this->image ?: self::DEFAULT_IMAGE,
            'theme'       => $this->theme_color ?: self::DEFAULT_THEME,
            'badge'       => [
                'ar' => $this->badge_ar ?: 'دورة جديدة · التسجيل مفتوح',
                'en' => $this->badge_en ?: ($this->badge_ar ?: 'New course · Registration open'),
            ],
            'show_installments' => (bool) ($this->show_installments ?? true),
            'share_image' => $this->share_image,
            'seats'       => $this->seats,
            'seats_left'  => $this->seatsLeft(),
            'is_full'     => $this->isFull(),
            'starts_at'   => $date->toDateString() . 'T' . $this->startTime() . '+03:00', // Kuwait time
        ];
    }

    /**
     * CSS custom properties for a course's colour, derived from one base colour so any pick
     * still looks right: --c1 (deep) … --c4 (soft), --cb (buttons), --ca (light accent on the
     * coloured panel), --cbg/--ct (page and box tints), --cbd (borders).
     */
    public static function paletteCss(?string $hex): string
    {
        $hex = preg_match('/^#[0-9a-f]{6}$/i', (string) $hex) ? $hex : self::DEFAULT_THEME;
        $rgb = array_map('hexdec', str_split(substr($hex, 1), 2));
        $mix = function (float $white) use ($rgb) {
            return '#' . implode('', array_map(fn ($c) => str_pad(dechex((int) round($c + (255 - $c) * $white)), 2, '0', STR_PAD_LEFT), $rgb));
        };

        return implode(';', [
            "--c1:{$hex}", '--c2:' . $mix(.18), '--c3:' . $mix(.35), '--c4:' . $mix(.5),
            '--cb:' . $mix(.1), '--ca:' . $mix(.72), '--cbg:' . $mix(.92), '--ct:' . $mix(.94), '--cbd:' . $mix(.82),
        ]);
    }

    /** Best-effort start time for the countdown, read from the Arabic/English time text ("7:00 - 9:00 مساءً"). */
    private function startTime(): string
    {
        $text = (string) ($this->time_en ?: $this->time_ar);
        if (!preg_match('/(\d{1,2})(?::(\d{2}))?/', $text, $m)) return '00:00:00';
        $hour = (int) $m[1];
        $isPm = preg_match('/pm|مساء/iu', $text) || ($hour < 9 && !preg_match('/am|صباح/iu', $text));
        if ($isPm && $hour < 12) $hour += 12;
        return sprintf('%02d:%02d:00', $hour, (int) ($m[2] ?? 0));
    }
}
