<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CourseRegistration extends Model
{
    protected $fillable = [
        'course_key', 'name', 'phone', 'email',
        'discount_code_id', 'discount_code',
        'original_amount', 'discount_amount', 'final_amount',
        'status', 'invoice_id', 'payment_id', 'payment_method', 'paid_at', 'admin_notes',
        'utm_source', 'utm_medium', 'utm_campaign', 'referrer', 'followed_up_at',
        'review_token', 'review_requested_at',
    ];

    protected $casts = [
        'original_amount' => 'decimal:3',
        'discount_amount' => 'decimal:3',
        'final_amount'    => 'decimal:3',
        'paid_at'         => 'datetime',
        'followed_up_at'  => 'datetime',
        'review_requested_at' => 'datetime',
    ];

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }

    /** The review this trainee left through their review link. */
    public function testimonial()
    {
        return $this->hasOne(Testimonial::class, 'registration_id');
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
            $this->update(['review_token' => $this->review_token ?: Str::random(32)]);
            $this->issueGiftCode();
            $this->notifyAdmin();
        }
    }

    public static function giftAmount(): float
    {
        return (float) (SiteSetting::current()['gift_code_kwd'] ?? 0);
    }

    /** Gift amount for display: 10.000 -> "10", 7.5 -> "7.5". */
    public static function giftAmountText(): string
    {
        return rtrim(rtrim(number_format(self::giftAmount(), 3), '0'), '.');
    }

    /** Paid without any discount code while gift codes are switched on. */
    public function rewardEligible(): bool
    {
        return $this->status === 'paid' && !$this->discount_code_id && self::giftAmount() > 0;
    }

    /** The gift code this registration earned. */
    public function rewardCode(): ?DiscountCode
    {
        return DiscountCode::where('owner_registration_id', $this->id)->first();
    }

    /**
     * Fixed-amount, single-use gift code for any course — the customer can use it or pass it on.
     * Created once, right after paying without a code.
     */
    public function issueGiftCode(): ?DiscountCode
    {
        if ($existing = $this->rewardCode()) return $existing;
        if (!$this->rewardEligible()) return null;

        do {
            $code = 'GIFT' . strtoupper(Str::random(4));
        } while (DiscountCode::where('code', $code)->exists());

        return DiscountCode::create([
            'code' => $code, 'type' => 'fixed', 'value' => self::giftAmount(),
            'owner_registration_id' => $this->id, 'kind' => 'gift', 'max_uses' => 1, 'is_active' => true,
        ]);
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
