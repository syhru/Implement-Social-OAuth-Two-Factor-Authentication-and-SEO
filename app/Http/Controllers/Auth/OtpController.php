<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showVerifyForm()
    {
        // Optional: you might want to automatically send an OTP if they just arrived
        // For security, checking if they just logged in might be wise before generating.
        return view('auth.otp-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($this->otpService->verify($user, $request->code)) {
            session(['2fa_verified' => true]);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'The provided OTP code is invalid or has expired.']);
    }

    public function resend()
    {
        $user = Auth::user();
        $this->otpService->generate($user);

        return back()->with('status', 'A new OTP code has been sent to your email.');
    }
}
