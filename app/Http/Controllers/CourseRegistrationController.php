<?php

namespace App\Http\Controllers;

use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
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
    ];

    public function __construct(private MyFatoorah $myFatoorah) {}

    public function show(string $offerKey)
    {
        $offer = $this->offerOrFail($offerKey);

        return view('course-register', compact('offer', 'offerKey'));
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
        ]);

        $quote = $this->quote($offerKey, $offer, $data['code'] ?? null);
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
            return $this->result($registration);
        }

        try {
            $invoice = $this->myFatoorah->sendPayment([
                'InvoiceValue'       => $quote['final'],
                'CustomerName'       => $data['name'],
                'CustomerEmail'      => $data['email'] ?? null,
                'MobileCountryCode'  => '+965',
                'CustomerMobile'     => $this->localMobile($data['phone']),
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
