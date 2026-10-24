<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Minimal deema (buy now, pay later) merchant API client.
 * Docs: https://docs.deema.me/reference/getting-started-with-deema-apis
 */
class Deema
{
    /** Order statuses that mean the money was taken. */
    public const PAID = ['captured', 'fully_captured'];

    /** Order statuses that mean the customer will not pay this order. */
    public const FAILED = ['declined', 'declined_by_regulator', 'declined_by_deema', 'payment_cancelled', 'expired'];

    public function enabled(): bool
    {
        return filled(config('services.deema.api_key'));
    }

    private function client(): PendingRequest
    {
        $key = config('services.deema.api_key');
        if (!$key) {
            throw new RuntimeException('DEEMA_API_KEY is not set.');
        }

        return Http::withHeaders(['Authorization' => 'Basic ' . $key])
            ->acceptJson()
            ->timeout(30)
            ->baseUrl(rtrim(config('services.deema.base_url'), '/') . '/api/merchant/v1');
    }

    private function data($response, string $action): array
    {
        $json = $response->json() ?? [];

        if (!$response->successful() || !is_array($json['data'] ?? null)) {
            throw new RuntimeException("deema {$action} failed: " . ($json['message'] ?? $json['error'] ?? $response->status()));
        }

        return $json['data'];
    }

    /** Creates a checkout and returns ['order_reference' => ..., 'redirect_link' => ..., ...]. */
    public function createPurchase(float $amount, string $merchantOrderId, string $successUrl, string $failureUrl): array
    {
        return $this->data($this->client()->post('purchase', [
            'amount'            => $amount,
            'currency_code'     => 'KWD',
            'merchant_order_id' => $merchantOrderId,
            'merchant_urls'     => ['success' => $successUrl, 'failure' => $failureUrl],
        ]), 'purchase');
    }

    /** Order details: ['status' => 'fully_captured', 'amount' => ..., 'deema_order_id' => ..., ...]. */
    public function order(string $orderReference): array
    {
        return $this->data($this->client()->get('purchase/' . rawurlencode($orderReference) . '/retrieve_by_reference'), 'retrieve');
    }
}
