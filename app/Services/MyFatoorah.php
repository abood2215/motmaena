<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Minimal MyFatoorah API v2 client.
 * Docs: https://docs.myfatoorah.com/docs/send-payment
 */
class MyFatoorah
{
    private function request(string $endpoint, array $payload): array
    {
        $key = config('services.myfatoorah.api_key');
        if (!$key) {
            throw new RuntimeException('MYFATOORAH_API_KEY is not set.');
        }

        $response = Http::withToken($key)
            ->acceptJson()
            ->timeout(30)
            ->post(rtrim(config('services.myfatoorah.base_url'), '/') . '/v2/' . $endpoint, $payload);

        $json = $response->json() ?? [];

        if (!$response->successful() || !($json['IsSuccess'] ?? false)) {
            $errors = collect($json['ValidationErrors'] ?? [])->pluck('Error')->implode(' | ');
            throw new RuntimeException("MyFatoorah {$endpoint} failed: " . ($json['Message'] ?? $response->status()) . ($errors ? " ({$errors})" : ''));
        }

        return $json['Data'];
    }

    /** Creates an invoice and returns ['InvoiceId' => ..., 'InvoiceURL' => ...]. */
    public function sendPayment(array $payload): array
    {
        return $this->request('SendPayment', $payload + [
            'NotificationOption' => 'LNK',
            'DisplayCurrencyIso' => 'KWD',
        ]);
    }

    /** $keyType is 'PaymentId' (from the callback) or 'InvoiceId'. */
    public function getPaymentStatus(string $key, string $keyType = 'PaymentId'): array
    {
        return $this->request('GetPaymentStatus', ['Key' => $key, 'KeyType' => $keyType]);
    }
}
