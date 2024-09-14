<?php

namespace App\Http\Controllers\API\VendorApi\Auth;

use App\Models\Vendor;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors',
            'mobile' => 'required|string|max:14|unique:vendors',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors(), 'code' => 422], 422);
        }

        $user = Vendor::create([
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer', 'code' => 200]);
    }

    public function login(Request $request)
    {
        if (
            !Auth::guard('vendor')->attempt($request->only('email', 'password')) ||
            (Auth::guard('vendor')->user() && Auth::guard('vendor')->user()->status != 1)
        ) {
            return response()->json(['message' => 'Invalid login details', 'code' => 401], 401);
        }

        $user = Vendor::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Login successful', 'access_token' => $token, 'token_type' => 'Bearer', 'code' => 200], 200);
    }


    public function forgotPassword(Request $request, OTPService $otpService)
    {
        $request->validate(['email' => 'required|email']);

        // إرسال OTP
        if (Vendor::where('email', $request->email)->first()) {
            if ($otpService->sendOTP($request->email)) {
                return response()->json(['message' => 'OTP sent successfully', 'code' => 200], 200);
            } else {
                return response()->json(['message' => 'Unable to send OTP', 'code' => 400], 400);
            }
        } else {
            return response()->json(['message' => 'email not found in our app', 'code' => 500], 500);
        }
    }

    public function verifyOTP(Request $request, OTPService $otpService)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string'
        ]);

        $isValid = $otpService->verifyOTP($request->email, $request->otp);
        if ($isValid) {
            $user = Vendor::where('email', $request->email)->first();
            $user->status = 1;
            $user->save();
            Auth::guard('vendor')->login($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now(),
            ]);
            return response()->json(['message' => 'OTP verified successfully', 'token' => $token, 'code' => 200], 200);
        } else {
            return response()->json(['message' => 'Invalid or expired OTP', 'code' => 400], 400);
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:vendors',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'token'=>'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return response()->json(['message' => 'password updated faild', 'code' => 400], 400);
        }

        $user = Vendor::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return response()->json(['message'=>  'Your password has been changed!', 'code' => 200], 200);
    }
}
