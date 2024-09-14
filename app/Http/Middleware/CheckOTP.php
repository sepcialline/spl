<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\OTPService;

class CheckOTP
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $isValid = $this->otpService->validateOTP($request->email, $request->otp);

        if (!$isValid) {
            return response()->json(['message' => 'Invalid OTP'], 401);
        }

        return $next($request);
    }
}
