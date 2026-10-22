<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseRegistration extends Model
{
    protected $fillable = [
        'course_key', 'name', 'phone', 'email',
        'discount_code_id', 'discount_code',
        'original_amount', 'discount_amount', 'final_amount',
        'status', 'invoice_id', 'payment_id', 'payment_method', 'paid_at', 'admin_notes',
    ];

    protected $casts = [
        'original_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'final_amount'    => 'decimal:3',
        'paid_at'         => 'datetime',
    ];

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    public function offer(): ?array
    {
        return config("course_offers.{$this->course_key}");
    }

    /**
     * Mark as paid exactly once (safe against double callbacks), and count the discount code use.
     */
    public function markPaid(?string $paymentId, ?string $method): void
    {
        DB::transaction(function () use ($paymentId, $method) {
            $fresh = static::whereKey($this->id)->lockForUpdate()->first();
            if ($fresh->status === 'paid') return;

            $fresh->update([
                'status'         => 'paid',
                'payment_id'     => $paymentId,
                'payment_method' => $method,
                'paid_at'        => now(),
            ]);

            if ($fresh->discount_code_id) {
                DiscountCode::whereKey($fresh->discount_code_id)->increment('used_count');
            }
        });

        $this->refresh();
    }
}
