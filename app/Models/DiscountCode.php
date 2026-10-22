<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = ['code', 'type', 'value', 'course_key', 'max_uses', 'used_count', 'expires_at', 'is_active'];

    protected $casts = [
        'value'      => 'decimal:3',
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    public static function findByCode(string $code): ?self
    {
        return static::where('code', strtoupper(trim($code)))->first();
    }

    /**
     * Returns null when the code can be used for the course, otherwise the reason it can't.
     */
    public function unusableReason(string $courseKey): ?string
    {
        if (!$this->is_active) return 'inactive';
        if ($this->course_key && $this->course_key !== $courseKey) return 'wrong_course';
        if ($this->expires_at && $this->expires_at->endOfDay()->isPast()) return 'expired';
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) return 'used_up';
        return null;
    }

    /** Discount in KWD for the given price, never more than the price itself. */
    public function discountFor(float $price): float
    {
        $discount = $this->type === 'percent'
            ? $price * ((float) $this->value / 100)
            : (float) $this->value;

        return round(min($discount, $price), 3);
    }
}
