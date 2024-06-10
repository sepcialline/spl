<?php

namespace App\Http\Controllers\Vendor\UserManagment;

use App\Models\Cities;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Employee::where('branch_id',Auth::guard('employee')->user()->branch_id)->paginate(10);
        return view('employee.users.employee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $emirates = Emirates::get();
        $branches = Branches::get();
        $cities = Cities::get();
        $roles = Role::where('guard_name', 'employee')->get();
        return view('employee.users.employee.create', compact('emirates', 'branches', 'cities', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //return $request->all();
        if ($request->file()) {

            if ($request->hasFile('employee_image')) {
                $employee_image_name = $request->employee_image != null ? time() . '_' . $request->employee_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->employee_image->move(public_path('build/assets/img/uploads/avatars'), $employee_image_name);
            }
        } else {
            // echo 'No';
        }
        $employee = new Employee();
        // Employee::create([
        $employee->name = ['en' => $request->employee_name_english, 'ar' => $request->employee_name_arabic];
        $employee->mobile = $request->employee_mobile;
        $employee->email = $request->employee_email;
        $employee->is_sales = $request->employee_is_sale;
        $employee->password = bcrypt($request->password);
        $employee->department_id = $request->user_department;
        $employee->is_department_head = $request->user_department;
        $employee->emirate_id = $request->user_department;
        $employee->city_id = $request->user_department;
        $employee->branch_id = $request->user_branch;
        $employee->is_branch_manager = $request->is_branch_manager;
        $employee->status = $request->employee_status;
        $employee->address = $request->employee_address_english;
        $employee->description = $request->employee_desc;
        $employee->photo = $employee_image_name;
        $employee->save();

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Employee::find($id);
        $current_role = DB::table('model_has_roles')->where('model_id', $id)->get();
        $role = Role::query()->where('id', $current_role[0]->role_id)->get();
        return view('employee.users.employee.show', compact('data', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Employee::find($id);
        $emirates = Emirates::get();
        $branches = Branches::get();
        $cities = Cities::get();
        $roles = Role::where('guard_name', 'employee')->get();
        $values = array();
        $current_roles = DB::table('model_has_roles')->where('model_id', $id)->get();
        foreach ($current_roles as $current_role) {
            # code...
            $role = Role::query()->where('id', $current_role->role_id)->get()[0];
            array_push($values, $role->name);
        }
        return view('employee.users.employee.update', compact('emirates', 'branches', 'cities', 'roles', 'data', 'values'));
    }
    public function updateEmployee(Request $request)
    {
        //return $request->all();
        // $validated = $request->validate(
        //     [
        //         'employee_name_english' => 'required|max:255',
        //         'employee_name_arabic' => 'required|max:255',
        //         'employee_mobile' => 'required|max:255', //|min:9|max:15',
        //         //'employee_password' => 'required|max:255',//|min:9|max:15',
        //         'employee_email' => 'required|email|max:255',
        //         'user_emirate' => 'required|max:255',
        //         'employee_address_english' => 'required|max:255',
        //         //'employee_address_arabic' => 'required|max:255',
        //         'employee_status' => 'required',
        //         'employee_desc' => '',
        //         'employee_image' => '',

        //     ],
        //     [
        //         'employee_name_english.required' => __('admin.this_field_is_required'),
        //         'employee_name_arabic.required' => __('admin.this_field_is_required'),
        //         'employee_mobile.required' => __('admin.this_field_is_required'),
        //         //'employee_password.required' => __('admin.this_field_is_required'),
        //         'employee_email.required' => __('admin.this_field_is_required'),
        //         'user_emirate.required' => __('admin.this_field_is_required'),
        //         'employee_address_english.required' => __('admin.this_field_is_required'),
        //         'employee_status.required' => __('admin.this_field_is_required'),
        //         'employee_address_arabic.required' => __('admin.this_field_is_required'),
        //         'employee_desc.required' => __('admin.this_field_is_required'),
        //         'employee_image.required' => __('admin.this_field_is_required'),

        //     ]
        // );
        $employee = Employee::find($request->employee_id);

        if ($request->file()) {

            if ($request->hasFile('employee_image')) {
                $employee_image_name = $request->employee_image != null ? time() . '_' . $request->employee_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$employee_image_name;
                $request->employee_image->move(public_path('build/assets/img/uploads/avatars'), $employee_image_name);
                $employee->photo = $employee_image_name;
            }
        } else {
            // echo 'No';
        }
        // //code...
        $employee->name = ['en' => $request->employee_name_english, 'ar' => $request->employee_name_arabic];
        $employee->mobile = $request->employee_mobile;
        $employee->email = $request->employee_email;
        $employee->city_id = $request->user_city;
        $employee->emirate_id = $request->user_emirate;
        $employee->branch_id = $request->user_branch;
        $employee->description = $request->employee_desc;
        $employee->address = $request->employee_address_english;
        $employee->is_sales = $request->employee_is_sale;
        $employee->status = $request->employee_status;
        $employee->save();
        DB::table('model_has_roles')->where('model_id', $request->employee_id)->delete();
        foreach ($request->employee_role as $role) {
            # code...
            $employee->assignRole("$role");
        }

        toastr()->success('Success');
        return redirect()->back();
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
        Employee::where('id', $id)->delete();
        return response()->json([
            'success' => 'success',
        ]);
    }
}
