<?php

namespace App\Http\Controllers\Employee\Profile;

use App\Models\Admin;
use App\Models\Cities;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Auth::guard('employee')->user();
        //return $user;
        return view('employee.profile.index', compact('data'));
    }

    public function update_password(Request $request)
    {
        //
        //return $request->all();
        $employee = Employee::find(Auth::guard('employee')->id());
        $current_password = $request->current_password;
        //  return Hash::check($current_password,$current_password);
        if (Hash::check($current_password, $employee->password)) {
            // return 'Match';
            $employee->password = Hash::make($request->new_password);
            $employee->save();
            $msg = __('admin.msg_success_update');
            toastr()->success('Success');
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('employee.login.form');
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
        $data['data'] = Auth::guard('employee')->user();
        $data['emirates'] = Emirates::get();
        $data['branches'] = Branches::get();
        $data['cities'] = Cities::get();
        $data['roles'] = Role::where('guard_name', 'employee')->get();
        $data['current_roles'] = DB::table('model_has_roles')->where('model_type', 'App\\Models\\Employee')->where('model_id', $data['data']->id)->get();
        $data['values'] = array();
        foreach ($data['current_roles'] as $current_role) {
            # code...
            $role = Role::query()->where('id', $current_role->role_id)->get()[0];
            array_push($data['values'], $role->name);
        }

        return view('employee.profile.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if ($request->file()) {

            if ($request->hasFile('admin_image')) {
                $employee_image_name = $request->admin_image != null ? time() . '_' . $request->admin_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $employee_image_name);
                $employee->photo = $employee_image_name;
            }
        }
        //code...
        $employee->name = ['en' => $request->admin_name_english, 'ar' => $request->admin_name_arabic];
        $employee->mobile = $request->admin_mobile;
        $employee->email = $request->admin_email;
        $employee->department_id = $employee->department_id;
        $employee->city_id = $request->user_city;
        $employee->emirate_id = $request->user_emirate;
        $employee->branch_id = $employee->branch_id;
        $employee->description = $request->admin_desc;
        $employee->address = $request->admin_address_english;
        $employee->status = $employee->status;
        $employee->save();

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
