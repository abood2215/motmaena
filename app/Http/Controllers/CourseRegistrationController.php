<?php

namespace App\Http\Controllers;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use App\Services\Deema;
use App\Services\MyFatoorah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseRegistrationController extends Controller
{
    private const CODE_ERRORS = [
        'not_found'    => ['ar' => 'كود الخصم غير صحيح', 'en' => 'Invalid discount code'],
        'inactive'     => ['ar' => 'كود الخصم غير مفعّل', 'en' => 'This discount code is not active'],
        'wrong_course' => ['ar' => 'كود الخصم غير صالح لهذه الدورة', 'en' => 'This code is not valid for this course'],
        'expired'      => ['ar' => 'انتهت صلاحية كود الخصم', 'en' => 'This discount code has expired'],
        'used_up'      => ['ar' => 'تم استنفاد كود الخصم', 'en' => 'This discount code has been fully used'],
        'own_code'     => ['ar' => 'هذا كود الإحالة الخاص بك — شاركه مع أصدقائك ليحصلوا على الخصم', 'en' => 'This is your own referral code — share it with friends'],
        'not_yours'    => ['ar' => 'هذا الكود شخصي لصاحبه — سجّل بنفس رقم الهاتف اللي أخذت عليه الكود', 'en' => 'This personal code only works with the phone number it was issued to'],
    ];

    public function __construct(private MyFatoorah $myFatoorah, private Deema $deema) {}

    public function show(string $offerKey)
    {
        $offer = $this->offerOrFail($offerKey);
        $deemaEnabled = $this->deema->enabled() && $offer['show_installments'];

        return view('course-register', compact('offer', 'offerKey', 'deemaEnabled'));
    }

    public function checkCode(Request $request, string $offerKey)
    {
        $offer = $this->offerOrFail($offerKey);
        $request->validate(['code' => 'required|string|max:40']);

        $quote = $this->quote($offerKey, $offer, $request->code);

        if ($quote['error']) {
            return response()->json(['ok' => false, 'message' => $quote['error']], 422);
        }

        return response()->json([
            'ok'       => true,
            'original' => $quote['original'],
            'discount' => $quote['discount'],
            'final'    => $quote['final'],
        ]);
    }

    public function store(Request $request, string $offerKey)
    {
        $offer = $this->offerOrFail($offerKey);

        $data = $request->validate([
            'name'  => 'required|string|max:120',
            'phone' => ['required', 'string', 'regex:/^\+?[0-9\s\-]{8,16}$/'],
            'email' => 'nullable|email|max:150',
            'code'  => 'nullable|string|max:40',
            'method' => 'nullable|in:card,deema',
        ]);
        $data['phone'] = $this->localMobile($data['phone']);

        if ($offer['is_full']) {
            return back()->withInput()->withErrors(['payment' => $this->t(
                'اكتمل العدد في هذه الدورة. اترك رقمك وسنبلغك بالموعد القادم.',
                'This course is full. Leave your number and we will tell you about the next date.'
            )]);
        }

        $quote = $this->quote($offerKey, $offer, $data['code'] ?? null);
        $owner = $quote['code']?->owner;
        $reason = match (true) {
            $quote['error'] !== null || !$owner                                     => null,
            $quote['code']->kind === 'self' && $owner->phone !== $data['phone']     => 'not_yours',
            $quote['code']->kind === 'referral' && $owner->phone === $data['phone'] => 'own_code',
            default                                                                 => null,
        };
        if ($reason) {
            $quote['error'] = self::CODE_ERRORS[$reason][app()->getLocale()] ?? self::CODE_ERRORS[$reason]['ar'];
        }
        if ($quote['error']) {
            return back()->withInput()->withErrors(['code' => $quote['error']]);
        }

        $registration = CourseRegistration::create([
            'course_key'       => $offerKey,
            'name'             => $data['name'],
            'phone'            => $data['phone'],
            'email'            => $data['email'] ?? null,
            'discount_code_id' => $quote['code']?->id,
            'discount_code'    => $quote['code']?->code,
            'original_amount'  => $quote['original'],
            'discount_amount'  => $quote['discount'],
            'final_amount'     => $quote['final'],
        ] + array_filter(session('visit_source', []), fn ($v) => $v !== null));

        // 100% discount: nothing to charge
        if ($quote['final'] <= 0) {
            $registration->markPaid(null, 'discount');
            return redirect()->route('registration.done', $registration->review_token);
        }

        if (($data['method'] ?? null) === 'deema' && $offer['show_installments'] && $this->deema->enabled()) {
            return $this->payWithDeema($registration);
        }

        try {
            $invoice = $this->myFatoorah->sendPayment([
                'InvoiceValue'       => $quote['final'],
                'CustomerName'       => $data['name'],
                'CustomerEmail'      => $data['email'] ?? null,
                'MobileCountryCode'  => '+965',
                'CustomerMobile'     => $data['phone'],
                'CustomerReference'  => (string) $registration->id,
                'Language'           => app()->getLocale() === 'ar' ? 'AR' : 'EN',
                'CallBackUrl'        => route('payment.callback'),
                'ErrorUrl'           => route('payment.callback'),
                'InvoiceItems'       => [[
                    'ItemName'  => $offer['title'][app()->getLocale()] ?? $offer['title']['ar'],
                    'Quantity'  => 1,
                    'UnitPrice' => $quote['final'],
                ]],
            ]);
        } catch (\Throwable $e) {
            Log::error('MyFatoorah SendPayment error', ['registration' => $registration->id, 'error' => $e->getMessage()]);
            $registration->update(['status' => 'failed']);

            return back()->withInput()->withErrors(['payment' => $this->t(
                'تعذّر إنشاء رابط الدفع حالياً، حاول مرة أخرى أو تواصل معنا عبر واتساب.',
                'Could not create the payment link right now. Please try again or contact us on WhatsApp.'
            )]);
        }

        $registration->update(['invoice_id' => (string) $invoice['InvoiceId']]);

        return redirect()->away($invoice['InvoiceURL']);
    }

    /** MyFatoorah redirects here (success and error) with ?paymentId=... */
    public function callback(Request $request)
    {
        $paymentId = (string) $request->query('paymentId', '');
        abort_if($paymentId === '', 404);

        try {
            $status = $this->myFatoorah->getPaymentStatus($paymentId, 'PaymentId');
        } catch (\Throwable $e) {
            Log::error('MyFatoorah GetPaymentStatus error', ['paymentId' => $paymentId, 'error' => $e->getMessage()]);
            abort(502);
        }

        $registration = CourseRegistration::where('invoice_id', (string) $status['InvoiceId'])->firstOrFail();
        $this->applyStatus($registration, $status, $paymentId);

        return $registration->status === 'paid'
            ? redirect()->route('registration.done', $registration->review_token)
            : $this->result($registration);
    }

    private function payWithDeema(CourseRegistration $registration)
    {
        $registration->update(['payment_method' => 'deema']);
        $returnUrl = route('payment.deema.return', ['registration' => $registration->id, 'sig' => self::deemaSignature($registration)]);

        try {
            $order = $this->deema->createPurchase((float) $registration->final_amount, 'REG-' . $registration->id, $returnUrl, $returnUrl);
        } catch (\Throwable $e) {
            Log::error('deema purchase error', ['registration' => $registration->id, 'error' => $e->getMessage()]);
            $registration->update(['status' => 'failed']);

            return back()->withInput()->withErrors(['payment' => $this->t(
                'تعذّر التقسيط عبر deema حالياً. جرّب الدفع بالبطاقة أو تواصل معنا عبر واتساب.',
                'Could not start deema installments right now. Try paying by card or contact us on WhatsApp.'
            )]);
        }

        $registration->update(['invoice_id' => (string) $order['order_reference']]);

        return redirect()->away($order['redirect_link']);
    }

    /** deema sends the customer back here (success and failure). */
    public function deemaReturn(Request $request, CourseRegistration $registration)
    {
        abort_unless(
            $registration->payment_method === 'deema' && $registration->invoice_id
                && hash_equals(self::deemaSignature($registration), (string) $request->query('sig')),
            404
        );

        if ($registration->status !== 'paid') {
            try {
                self::applyDeemaStatus($registration, $this->deema->order($registration->invoice_id));
            } catch (\Throwable $e) {
                Log::error('deema order lookup error', ['registration' => $registration->id, 'error' => $e->getMessage()]);
            }
        }

        return $registration->status === 'paid'
            ? redirect()->route('registration.done', $registration->review_token)
            : $this->result($registration);
    }

    /** deema calls this whenever an order's status changes. */
    public function deemaWebhook(Request $request)
    {
        $secret = (string) config('services.deema.webhook_secret');
        $given  = (string) $request->header(config('services.deema.webhook_header'));
        abort_unless($secret !== '' && hash_equals($secret, $given), 401);

        $reference    = (string) $request->input('order_ref');
        $registration = $reference === '' ? null
            : CourseRegistration::where('invoice_id', $reference)->where('payment_method', 'deema')->first();

        if (!$registration) {
            Log::warning('deema webhook for unknown order', $request->only('order_ref', 'merchant_order_ref', 'status'));
            return response()->json(['received' => true]);
        }

        // Don't trust the body: ask deema for the order's real status
        try {
            self::applyDeemaStatus($registration, $this->deema->order($reference));
        } catch (\Throwable $e) {
            Log::error('deema webhook lookup error', ['registration' => $registration->id, 'error' => $e->getMessage()]);
            return response()->json(['received' => false], 503); // deema retries
        }

        return response()->json(['received' => true]);
    }

    /** Updates a registration from a deema order. Shared with the webhook and the admin "verify" button. */
    public static function applyDeemaStatus(CourseRegistration $registration, array $order): void
    {
        $status = $order['status'] ?? null;
        $isPaid = in_array($status, Deema::PAID, true)
            && (float) ($order['amount'] ?? 0) + 0.001 >= (float) $registration->final_amount;

        if ($isPaid) {
            $registration->markPaid((string) ($order['deema_order_id'] ?? $registration->invoice_id), 'deema');
        } elseif (in_array($status, Deema::FAILED, true) && $registration->status !== 'paid') {
            $registration->update(['status' => 'failed']);
        } elseif ($registration->status === 'paid' && str_ends_with((string) $status, 'refunded')) {
            Log::info('deema order refunded', ['registration' => $registration->id, 'status' => $status]);
        }
    }

    /** Unguessable key for the deema return link, so registration ids can't be browsed. */
    private static function deemaSignature(CourseRegistration $registration): string
    {
        return hash_hmac('sha256', 'deema-return:' . $registration->id, config('app.key'));
    }

    public function done(string $token)
    {
        $registration = CourseRegistration::where('review_token', $token)->where('status', 'paid')->firstOrFail();

        return $this->result($registration);
    }

    /**
     * Updates a registration from a GetPaymentStatus response. Shared with the admin "verify" button.
     */
    public static function applyStatus(CourseRegistration $registration, array $status, ?string $paymentId = null): void
    {
        $transactions = collect($status['InvoiceTransactions'] ?? []);
        $transaction  = ($paymentId ? $transactions->firstWhere('PaymentId', $paymentId) : null) ?? $transactions->last();

        $isPaid = ($status['InvoiceStatus'] ?? null) === 'Paid'
            && (float) ($status['InvoiceValue'] ?? 0) + 0.001 >= (float) $registration->final_amount;

        if ($isPaid) {
            $registration->markPaid($transaction['PaymentId'] ?? $paymentId, $transaction['PaymentGateway'] ?? null);
        } elseif ($registration->status !== 'paid') {
            $registration->update(['status' => 'failed', 'payment_id' => $paymentId]);
        }
    }

    private function result(CourseRegistration $registration)
    {
        return view('course-register-result', [
            'registration' => $registration,
            'offer'        => $registration->offer(),
        ]);
    }

    /** @return array{original: float, discount: float, final: float, code: ?DiscountCode, error: ?string} */
    private function quote(string $offerKey, array $offer, ?string $code): array
    {
        $original = round((float) $offer['price'], 3);
        $quote = ['original' => $original, 'discount' => 0.0, 'final' => $original, 'code' => null, 'error' => null];

        if (blank($code)) {
            return $quote;
        }

        $discountCode = DiscountCode::findByCode($code);
        $reason = $discountCode ? $discountCode->unusableReason($offerKey) : 'not_found';

        if ($reason) {
            $quote['error'] = self::CODE_ERRORS[$reason][app()->getLocale()] ?? self::CODE_ERRORS[$reason]['ar'];
            return $quote;
        }

        $quote['code']     = $discountCode;
        $quote['discount'] = $discountCode->discountFor($original);
        $quote['final']    = round($original - $quote['discount'], 3);

        return $quote;
    }

    private function offerOrFail(string $offerKey): array
    {
        $offer = CourseOffer::findActive($offerKey);
        abort_unless($offer, 404);

        return $offer->toOfferArray();
    }

    /** MyFatoorah wants the number without the country code (max 11 digits). */
    private function localMobile(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (str_starts_with($digits, '00965')) $digits = substr($digits, 5);
        elseif (str_starts_with($digits, '965') && strlen($digits) > 8) $digits = substr($digits, 3);

        return substr($digits, 0, 11);
    }

    private function t(string $ar, string $en): string
    {
        return app()->getLocale() === 'ar' ? $ar : $en;
    }
}
