<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $newlyPaid = DB::transaction(function () use ($paymentId, $method) {
            $fresh = static::whereKey($this->id)->lockForUpdate()->first();
            if ($fresh->status === 'paid') return false;

            $fresh->update([
                'status'         => 'paid',
                'payment_id'     => $paymentId,
                'payment_method' => $method,
                'paid_at'        => now(),
            ]);

            if ($fresh->discount_code_id) {
                DiscountCode::whereKey($fresh->discount_code_id)->increment('used_count');
            }

            return true;
        });

        $this->refresh();

        if ($newlyPaid) {
            $this->notifyAdmin();
        }
    }

    /** Emails the center about a new paid registration. Never breaks the payment flow. */
    private function notifyAdmin(): void
    {
        $to = config('app.admin_notify_email');
        if (!$to) return;

        $lines = [
            'تسجيل مدفوع جديد #' . $this->id,
            '',
            'الدورة: ' . ($this->offer()['title']['ar'] ?? $this->course_key),
            'الاسم: ' . $this->name,
            'الهاتف: ' . $this->phone,
            'الإيميل: ' . ($this->email ?: '—'),
            'المبلغ: ' . number_format((float) $this->final_amount, 3) . ' د.ك' . ($this->discount_code ? ' (كود: ' . $this->discount_code . ')' : ''),
            'طريقة الدفع: ' . ($this->payment_method ?: '—'),
            '',
            route('admin.registrations'),
        ];

        try {
            Mail::raw(implode("\n", $lines), function ($message) use ($to) {
                $message->to($to)->subject('تسجيل مدفوع جديد #' . $this->id . ' — ' . $this->name);
            });
        } catch (\Throwable $e) {
            Log::warning('Registration notification email failed', ['registration' => $this->id, 'error' => $e->getMessage()]);
        }
    }
}
