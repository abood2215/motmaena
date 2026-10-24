<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = ['code', 'type', 'value', 'course_key', 'owner_registration_id', 'kind', 'max_uses', 'used_count', 'expires_at', 'is_active'];

    protected $casts = [
        'value'      => 'decimal:3',
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    /** Set for referral codes: the paid registration whose owner shares it. */
    public function owner()
    {
        return $this->belongsTo(CourseRegistration::class, 'owner_registration_id');
    }

    /** An unpaid checkout holds a limited code this long, so two people can't pay with its last use at once. */
    public const HOLD_MINUTES = 120;

    /** Paid registrations that used this code (who used it, and when). */
    public function paidUses()
    {
        return $this->hasMany(CourseRegistration::class)->where('status', 'paid')->latest('paid_at');
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', strtoupper(trim($code)))->first();
    }

    /**
     * Returns null when the code can be used for the course, otherwise the reason it can't.
     * $phone: the customer's own unpaid checkouts don't hold the code against them (they're retrying).
     */
    public function unusableReason(string $courseKey, ?string $phone = null): ?string
    {
        if (!$this->is_active) return 'inactive';
        if ($this->course_key && $this->course_key !== $courseKey) return 'wrong_course';
        if ($this->expires_at && $this->expires_at->endOfDay()->isPast()) return 'expired';
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) return 'used_up';
        if ($this->max_uses !== null && $this->used_count + $this->heldCount($phone) >= $this->max_uses) return 'in_use';
        return null;
    }

    /** Recent unpaid checkouts by other people that are using this code. */
    private function heldCount(?string $phone): int
    {
        return CourseRegistration::where('discount_code_id', $this->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subMinutes(self::HOLD_MINUTES))
            ->when($phone, fn ($q) => $q->where('phone', '!=', $phone))
            ->count();
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
