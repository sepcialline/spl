<?php

namespace App\Http\Controllers\Vendor\Profile;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Auth::guard('vendor')->user();
        //return $user;
        return view('vendor.profile.index', compact('data'));
    }

    public function update_password(Request $request)
    {
        //
        //return $request->all();
        $vendor = Vendor::find(Auth::guard('vendor')->id());
        $current_password = $request->current_password;
        //  return Hash::check($current_password,$current_password);
        if (Hash::check($current_password, $vendor->password)) {
            // return 'Match';
            $vendor->password = Hash::make($request->new_password);
            $vendor->save();
            $msg = __('admin.msg_success_update');
            toastr()->success('Success');
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/vendor');
        } else {
            // return 'Not Match';
            $msg = __('admin.msg_something_error');
            toastr()->error($msg);
            return redirect()->back();
        }
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
}
