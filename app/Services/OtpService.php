<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SendOtpCode;
use Illuminate\Support\Str;

class OtpService
{
    public function generate(User $user, string $type = '2fa'): void
    {
        // Generate a 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Calculate expiration from .env or default to 60 minutes
        $expiresMinutes = config('auth.otp_expires_in', 60);

        $user->otpVerifications()->create([
            'code' => $code,
            'type' => $type,
            'expires_at' => now()->addMinutes($expiresMinutes),
            'is_used' => false,
        ]);

        $user->notify(new SendOtpCode($code));
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
