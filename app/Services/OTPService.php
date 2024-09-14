<?php 

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\OTP;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OTPService
{
    public function sendOTP($email)
    {
        // توليد OTP عشوائي
        $otp = random_int(1000, 9999);

        // حفظ OTP في قاعدة البيانات
        OTP::updateOrCreate(
            ['email' => $email],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        // إرسال OTP عبر البريد الإلكتروني
        Mail::to($email)->send(new \App\Mail\OTPMail($otp));

        return true;
    }

    public function verifyOTP($email, $otp)
    {
        $otpRecord = OTP::where('email', $email)
            ->where('otp', $otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return $otpRecord !== null;
    }
}
