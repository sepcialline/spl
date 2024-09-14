<?php

namespace App\Http\Controllers\Vendor\Profile;

use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

            return redirect()->route('vendor.login.form');
        } else {
            // return 'Not Match';
            $msg = __('admin.current_password_is_wrong');
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
    public function edit()
    {   
        $data['vendor'] = Vendor::find(Auth::guard('vendor')->user()->id);
        $data['countries'] = Country::get();
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        return view('vendor.profile.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $vendor = Vendor::find($request->vendor_id);

        // Validation with proper unique rule
        $validated = $request->validate([
            'vendor_name_ar' => 'required',
            'vendor_name_en' => 'required',
            'vendor_mobile' => 'required',
            'vendor_email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'nationality_id' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'required',
            // 'companies' => 'required',
        ]);

        DB::transaction(function () use ($request, $vendor) {
            $companies = $request->companies;
            $vendor_avatar = null;

            if ($request->hasFile('avatar')) {
                $vendor_avatar = time() . '_' . $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('build/assets/img/uploads/vendors/'), $vendor_avatar);
            } else {
                $vendor_avatar = $vendor->avatar;
            }

            $vendor->update([
                'name' => ['ar' => $request->vendor_name_ar, 'en' => $request->vendor_name_en],
                'mobile' => $request->vendor_mobile,
                'email' => $request->vendor_email,
                'password' => $vendor->password,
                'nationality_id' => $request->nationality_id,
                'birthdate' => $request->birth_date,
                'gender' => $request->gender,
                'avatar' => $vendor_avatar,
                'status' => $vendor->status,
                'updated_by' => Auth::guard('vendor')->user()->name,
            ]);

            if ($companies) {
                foreach ($companies as $company_id) {
                    VendorCompany::updateOrCreate(
                        ['id' => $company_id],
                        ['vendor_id' => $vendor->id]
                    );
                }
            }
        });

        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
