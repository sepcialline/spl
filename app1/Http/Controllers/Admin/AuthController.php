<?php

namespace App\Http\Controllers\Admin;

use toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function Login()
    {
        return view('admin.auth.login');
    }

    public function Forget()
    {
        return view('admin.auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')

        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    public function LoginRequest(Request $request)
    {

        $check = $request->all();
        if ((Auth::guard('admin')->attempt(['mobile' => $check['mobile'], 'password' => $check['password']]) ||
        Auth::guard('admin')->attempt(['email' => $check['mobile'], 'password' => $check['password']])) && Auth::guard('admin')->user()->status == 1) {
            toastr()->success('Data has been saved successfully!');
            return redirect()->route('admin.index');
        } else {
            toastr()->error('An error has occurred please try again later.');
            return back();
        }
    }
    public function Logout()
    {
        Auth::guard('admin')->logout();
        $notification = array(
            'message' => __('admin.toster_user_admin_Signed_out_successfully'),
            'alert-type' => 'success'
        );
        return redirect()->route('admin.login.form')->with($notification);
    }
}
