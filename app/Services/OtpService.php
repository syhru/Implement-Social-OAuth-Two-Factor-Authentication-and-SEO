<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SendOtpCode;
use Illuminate\Support\Facades\Log;
use Exception;

class OtpService
{
    /**
     * Generate an OTP code, save it to DB, and attempt to send via email.
     * Returns the generated code so callers can handle SMTP failures gracefully.
     */
    public function generate(User $user, string $type = '2fa'): string
    {
        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Calculate expiration from .env or default to 60 minutes
        $expiresMinutes = (int) env('OTP_EXPIRY_MINUTES', 60);

        $user->otpVerifications()->create([
            'code' => $code,
            'type' => $type,
            'expires_at' => now()->addMinutes($expiresMinutes),
            'is_used' => false,
        ]);

        // Attempt to send email — if SMTP is blocked, log a warning but don't crash
        try {
            $user->notify(new SendOtpCode($code));
        } catch (Exception $e) {
            Log::warning('OTP email delivery failed: ' . $e->getMessage());
        }

        return $code;
    }

    public function verify(User $user, string $code, string $type = '2fa'): bool
    {
        $otp = $user->otpVerifications()
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if ($otp && hash_equals($otp->code, $code)) {
            $otp->update(['is_used' => true]);
            return true;
        }

        return false;
    }
}
