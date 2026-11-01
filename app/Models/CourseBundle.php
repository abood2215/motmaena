<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Several courses at one price (e.g. both November courses for 45 KWD).
 * Open only while every course in it is open for registration and has seats.
 */
class CourseBundle extends Model
{
    protected $fillable = ['slug', 'title_ar', 'title_en', 'course_keys', 'price', 'is_active'];

    protected $casts = [
        'course_keys' => 'array',
        'price'       => 'decimal:3',
        'is_active'   => 'boolean',
    ];

    /** The bundle's courses, in date order (only the ones that still exist). */
    public function courses(): Collection
    {
        return CourseOffer::whereIn('slug', $this->course_keys ?? [])->orderBy('date')->get();
    }

    public function isOpen(): bool
    {
        if (!$this->is_active) return false;

        $open = CourseOffer::open()->whereIn('slug', $this->course_keys ?? [])->get();

        return count($this->course_keys ?? []) >= 2
            && $open->count() === count($this->course_keys)
            && $open->every(fn (CourseOffer $c) => !$c->isFull());
    }

    public static function findOpen(?string $slug): ?self
    {
        $bundle = $slug ? static::where('slug', $slug)->first() : null;

        return $bundle?->isOpen() ? $bundle : null;
    }

    /** The first open bundle, for the homepage. */
    public static function current(): ?self
    {
        return rescue(fn () => static::where('is_active', true)->orderBy('id')->get()->first(fn ($b) => $b->isOpen()), null, false);
    }

    /** What the courses cost on their own. */
    public function fullPrice(): float
    {
        return round((float) $this->courses()->sum('price'), 3);
    }

    public function savings(): float
    {
        return round(max(0, $this->fullPrice() - (float) $this->price), 3);
    }

    /** Each course's share of the bundle price (the last one takes any rounding remainder). */
    public function shares(): array
    {
        $courses = $this->courses();
        $count = $courses->count();
        $each = floor((float) $this->price / $count * 1000) / 1000;
        $shares = [];
        foreach ($courses->values() as $i => $course) {
            $shares[$course->slug] = $i === $count - 1 ? round((float) $this->price - $each * ($count - 1), 3) : $each;
        }
        return $shares;
    }

    public function title(string $lang): string
    {
        return $lang === 'en' && $this->title_en ? $this->title_en : $this->title_ar;
    }

    public static function fmt(float $v): string
    {
        return rtrim(rtrim(number_format($v, 3, '.', ''), '0'), '.');
    }
}
