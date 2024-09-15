<?php

namespace App\Http\Controllers\Admin\UserManagment;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Cities;
use App\Models\Department;
use App\Models\Emirates;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:admin-Employees-show-page'], ['only' => ['index']]);
        $this->middleware(['permission:admin-Employees-add'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:admin-Employees-show'], ['only' => ['show']]);
        $this->middleware(['permission:admin-Employees-edit'], ['only' => ['edit', 'updateEmployee']]);
        $this->middleware(['permission:admin-Employees-delete'], ['only' => ['delete_admin']]);
        $this->middleware(['permission:admin-Employees-change-status'], ['only' => ['update_status']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Employee::paginate(10);
        return view('admin.users.employee.index', compact('data'));
    }

    // search
    public function search(Request $request)
    {
        $result = Employee::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('mobile', 'LIKE', '%' . $request->search . '%')->get();
        return ['results' => $result->all()];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $departments = Department::select('id', 'name')->get();
        $emirates = Emirates::get();
        $branches = Branches::where('is_main', 0)->get();
        $cities = Cities::get();
        $roles = Role::where('guard_name', 'employee')->get();
        return view('admin.users.employee.create', compact('emirates', 'branches', 'cities', 'roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // return $request->all();
        if ($request->file()) {

            if ($request->hasFile('admin_image')) {
                $admin_image_name = $request->admin_image != null ? time() . '_' . $request->admin_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $admin_image_name);
            }
        } else {
            // echo 'No';
        }
        $employee = new Employee();
        // Employee::create([
        $employee->name = ['en' => $request->admin_name_english, 'ar' => $request->admin_name_arabic];
        $employee->mobile = $request->admin_mobile;
        $employee->email = $request->admin_email;
        $employee->is_sales = $request->admin_is_sale;
        $employee->password = Hash::make($request->admin_password);
        $employee->department_id = $request->user_department;
        $employee->is_department_head = $request->user_department;
        $employee->emirate_id = $request->user_department;
        $employee->city_id = $request->user_department;
        $employee->branch_id = $request->user_branch;
        $employee->is_branch_manager = $request->is_branch_manager;
        $employee->status = $request->admin_status;
        $employee->address = $request->admin_address_english;
        $employee->description = $request->admin_desc;
        // ]);
        $employee->photo = $admin_image_name;
        $employee->save();
        foreach ($request->employee_role as $role) {
            # code...
            $employee->assignRole("$role");
        }

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
        // $current_role = DB::table('model_has_roles')->where('model_id', $id)->get();
        $current_role = DB::table('model_has_roles')->where('model_type','App\\Models\\Employee')->where('model_id', $id)->get();
        $role = Role::query()->where('id', $current_role[0]->role_id)->get();
        return view('admin.users.employee.show', compact('data', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $departments = Department::select('id', 'name')->get();
        $data = Employee::find($id);
        $emirates = Emirates::get();
        $branches = Branches::where('is_main', 0)->get();
        $cities = Cities::get();
        $roles = Role::where('guard_name', 'employee')->get();
        $values = array();
        $current_roles = DB::table('model_has_roles')->where('model_id', $id)->get();
        foreach ($current_roles as $current_role) {
            # code...
            $role = Role::query()->where('id', $current_role->role_id)->get()[0];
            array_push($values, $role->name);
        }
        return view('admin.users.employee.update', compact('emirates', 'branches', 'cities', 'roles', 'data', 'values', 'departments'));
    }
    public function updateEmployee(Request $request)
    {

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
        $employee->department_id = $request->user_department;
        // $employee->password = Hash::make($request->employee_password);
        // $employee->department_id = $request->department_id;
        $employee->city_id = $request->user_city;
        $employee->emirate_id = $request->user_emirate;
        $employee->branch_id = $request->user_branch;
        $employee->description = $request->employee_desc;
        $employee->address = $request->employee_address_english;
        $employee->is_sales = $request->employee_is_sale;
        $employee->status = $request->employee_status;
        $employee->save();
        DB::table('model_has_roles')->where('model_id', $request->employee_id)->where('model_type','App\\Models\\Employee')->delete();
        foreach ($request->employee_role as $role) {
            # code...
            $employee->assignRole("$role");
        }

        toastr()->success('Success');
        return redirect()->back();
    }

    public function update_password(Request $request)
    {
        $admin = Employee::find($request->id);
        $admin->password = Hash::make($request->new_password);
        $admin->save();
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    //update status
    public function update_status(Request $request, String $id)
    {

        try {
            //code...
            $rider = Employee::find($id);

            $rider->status = $request->status;

            $result = $rider->save();
            // if($result){
            // toastr()->success('Success');
            //}
            return response($rider, 200);

            //return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }

        //$branchStatus->update(['status'=>'1']);
        //return redirect::to('administrator/logo/view');

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
