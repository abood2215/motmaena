<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CourseOffer extends Model
{
    public const DEFAULT_IMAGE = 'courses-img/dr-tariq.png';

    protected $fillable = [
        'slug', 'title_ar', 'title_en', 'trainer_ar', 'trainer_en', 'price', 'date',
        'time_ar', 'time_en', 'location_ar', 'location_en', 'certificate_ar', 'certificate_en',
        'topics_ar', 'topics_en', 'image', 'is_active', 'is_featured',
    ];

    protected $casts = [
        'price'       => 'decimal:3',
        'date'        => 'date',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    public static function findActive(?string $slug): ?self
    {
        return $slug ? static::where('slug', $slug)->where('is_active', true)->first() : null;
    }

    /** The course shown in the homepage banner and announcement strip. */
    public static function featured(): ?self
    {
        return static::where('is_active', true)->where('is_featured', true)->orderBy('date')->first();
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
        ];
    }
}
