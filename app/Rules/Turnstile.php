<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Turnstile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Turnstile bisa dimatikan sementara lewat TURNSTILE_ENABLED=false.
        if (! config('services.turnstile.enabled')) {
            return;
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            $fail('Verifikasi keamanan gagal, silakan coba lagi.');
        }
    }
}