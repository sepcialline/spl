<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login()
    {
        // return '<h2>الموقع تحت الصيانة شاكرين صابركم<h2>
        // <h2>System under maintenance .. thank you<h2>';
        return view('vendor.auth.login');
    }

    public function LoginRequest(Request $request)
    {

        $check = $request->all();
        try {
            //code...
            if ((Auth::guard('vendor')->attempt(['mobile' => $check['mobile'], 'password' => $check['password']]) ||
                Auth::guard('vendor')->attempt(['email' => $check['mobile'], 'password' => $check['password']])) && Auth::guard('vendor')->user()->status == 1) {

                toastr()->success('login Successfully');
                //return back();
                return redirect()->route('vendor.index');
            } else {
                toastr()->error('An error has occurred please try again later.');
                return back();
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function Logout()
    {
        Auth::guard('vendor')->logout();
        $notification = array(
            'message' => __('admin.toster_user_admin_Signed_out_successfully'),
            'alert-type' => 'success'
        );
        return redirect()->route('vendor.login.form')->with($notification);
    }
}
