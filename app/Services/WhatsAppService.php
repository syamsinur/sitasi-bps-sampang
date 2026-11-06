<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim pesan WhatsApp ke satu nomor via Arsipin Gateway.
     *
     * @param  string  $phone   Nomor HP (08xx, +62xx, atau 62xx)
     * @param  string  $message Isi pesan
     * @param  string  $source  Label sumber (untuk logging gateway)
     * @return array{success: bool, message: string, message_id: string|null}
     */
    public static function send(string $phone, string $message, string $source = 'pojur'): array
    {
        $url      = rtrim(config('services.whatsapp.url'), '/');
        $token    = config('services.whatsapp.token');
        $timeout  = config('services.whatsapp.timeout', 15);
        $attempts = config('services.whatsapp.retry_attempts', 2);

        $normalizedPhone = self::normalizePhone($phone);

        $payload = [
            'phone'   => $normalizedPhone,
            'message' => $message,
            'source'  => $source,
        ];

        $lastError = null;

        for ($i = 0; $i < $attempts; $i++) {
            try {
                $response = Http::withToken($token)
                    ->timeout($timeout)
                    ->post("{$url}/api/whatsapp/send", $payload);

                if ($response->successful()) {
                    $body = $response->json();
                    Log::info('[WhatsApp] Pesan terkirim', [
                        'phone'      => $normalizedPhone,
                        'source'     => $source,
                        'message_id' => $body['message_id'] ?? null,
                    ]);
                    return [
                        'success'    => true,
                        'message'    => $body['message'] ?? 'Pesan berhasil dikirim',
                        'message_id' => $body['message_id'] ?? null,
                    ];
                }

                $lastError = $response->json('message') ?? "HTTP {$response->status()}";
                Log::warning('[WhatsApp] Respon tidak sukses', [
                    'attempt' => $i + 1,
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                ]);
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
                Log::error('[WhatsApp] Gagal mengirim pesan', [
                    'attempt' => $i + 1,
                    'error'   => $e->getMessage(),
                    'phone'   => $normalizedPhone,
                ]);
            }

            // Tunggu 1 detik sebelum retry (kecuali percobaan terakhir)
            if ($i < $attempts - 1) {
                sleep(1);
            }
        }

        return [
            'success'    => false,
            'message'    => $lastError ?? 'Gagal menghubungi WhatsApp Gateway',
            'message_id' => null,
        ];
    }

    /**
     * Cek status koneksi WhatsApp Gateway.
     */
    public static function status(): array
    {
        $url     = rtrim(config('services.whatsapp.url'), '/');
        $timeout = config('services.whatsapp.timeout', 15);

        try {
            $response = Http::timeout($timeout)->get("{$url}/api/whatsapp/status");

            if ($response->successful()) {
                $body = $response->json();
                return [
                    'connected' => $body['connected'] ?? false,
                    'status'    => $body['status'] ?? 'UNKNOWN',
                    'user'      => $body['user'] ?? null,
                ];
            }
        } catch (\Throwable $e) {
            Log::warning('[WhatsApp] Gagal cek status gateway: ' . $e->getMessage());
        }

        return ['connected' => false, 'status' => 'OFFLINE', 'user' => null];
    }

    /**
     * Normalisasi nomor HP Indonesia ke format 628xxxxxxxx.
     * Mendukung: 08xx, +62xx, 62xx
     */
    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '62')) {
            return $digits;
        }

        return '62' . $digits;
    }
}
