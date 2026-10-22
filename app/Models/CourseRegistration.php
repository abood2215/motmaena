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
        'utm_source', 'utm_medium', 'utm_campaign', 'referrer', 'followed_up_at',
    ];

    protected $casts = [
        'original_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'final_amount'    => 'decimal:3',
        'paid_at'         => 'datetime',
        'followed_up_at'  => 'datetime',
    ];

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    /**
     * Started but never paid, not yet contacted, and the same phone hasn't paid for that course since.
     */
    public function scopeNeedsFollowUp($query)
    {
        return $query->where('status', '!=', 'paid')
            ->whereNull('followed_up_at')
            ->whereNotExists(function ($q) {
                $q->selectRaw('1')->from('course_registrations as paid_reg')
                    ->whereColumn('paid_reg.phone', 'course_registrations.phone')
                    ->whereColumn('paid_reg.course_key', 'course_registrations.course_key')
                    ->where('paid_reg.status', 'paid');
            });
    }

    /** Short label for where this registration came from, e.g. "instagram / story" or "google.com". */
    public function sourceLabel(): string
    {
        if ($this->utm_source) {
            return $this->utm_source . ($this->utm_medium ? ' / ' . $this->utm_medium : '');
        }
        return $this->referrer ?: 'مباشر';
    }

    public function offer(): ?array
    {
        return CourseOffer::where('slug', $this->course_key)->first()?->toOfferArray();
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
