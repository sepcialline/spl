<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Models\Admin;
use App\Models\Cities;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Auth::guard('admin')->user();
        //return $user;
        return view('admin.profile.index', compact('data'));
    }

    public function update_password(Request $request)
    {
        //
        //return $request->all();
        $admin = Admin::find(Auth::guard('admin')->id());
        $current_password = $request->current_password;
        //  return Hash::check($current_password,$current_password);
        if (Hash::check($current_password, $admin->password)) {
            // return 'Match';
            $admin->password = Hash::make($request->new_password);
            $admin->save();
            $msg = __('admin.msg_success_update');
            toastr()->success('Success');
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('admin.login.form');
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
        $data['departments'] = Department::get();
        $data['data'] = Auth::guard('admin')->user();
        $data['emirates'] = Emirates::get();
        $data['branches'] = Branches::get();
        $data['cities'] = Cities::get();
        $data['roles'] = Role::where('guard_name', 'admin')->get();
        $data['current_roles'] = DB::table('model_has_roles')->where('model_type', 'App\\Models\\Admin')->where('model_id', $data['data']->id)->get();
        $data['values'] = array();
        foreach ( $data['current_roles'] as $current_role) {
            # code...
            $role = Role::query()->where('id', $current_role->role_id)->get()[0];
            array_push($data['values'], $role->name);
        }

        return view('admin.profile.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($request->file()) {

            if ($request->hasFile('admin_image')) {
                $admin_image_name = $request->admin_image != null ? time() . '_' . $request->admin_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $admin_image_name);
                $admin->photo = $admin_image_name;
            }
        } 
        //code...
        $admin->name = ['en' => $request->admin_name_english, 'ar' => $request->admin_name_arabic];
        $admin->mobile = $request->admin_mobile;
        $admin->email = $request->admin_email;
        $admin->department_id = $admin->department_id;
        $admin->city_id = $request->user_city;
        $admin->emirate_id = $request->user_emirate;
        $admin->branch_id = $admin->branch_id;
        $admin->description = $request->admin_desc;
        $admin->address = $request->admin_address_english;
        $admin->is_sales = $admin->is_sale;
        $admin->status = $admin->status;
        $admin->save();

        // $admin->assignRole("$request->admin_role");
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
