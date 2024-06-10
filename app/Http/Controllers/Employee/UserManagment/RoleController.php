<?php

namespace App\Http\Controllers\Employee\UserManagment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:employee-role-show-page,employee', ['only' => ['index']]);
        $this->middleware('permission:employee-role-add,employee', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-role-edit,employee', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee-role-delete,employee', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::where('guard_name', 'employee')->orderBy('id', 'ASC')->get();
        $permission_gp = Permission::where('guard_name', 'employee')->groupBy('group_id')->select('group_id', 'group_name')->get();
        return view('employee.roles.index', compact('roles', 'permission_gp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::where('guard_name', 'employee')->get();
        return view('employee.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'permission' => 'required',
            ],
            [
                'name.required' => __('admin.this_field_is_required'),
            ]
        );

        if (Role::where([['name', $request->name], ['guard_name', 'employee']])->exists()) {
            toastr()->error('admin.msg_already_exits');
            return redirect()->back();
        }
        $role = Role::create(['guard_name' => 'employee', 'name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));


        toastr()->success(__('admin.msg_success_add'));

        return redirect()->route('employee.roles_employee_index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('employee.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::where('guard_name', 'employee')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'permission' => 'required',
            ],
            [
                'name.required' => __('admin.this_field_is_required'),
            ]
        );
        if (Role::where([['name', $request->name], ['guard_name', 'employee'], ['id', '!=', $request->id]])->exists()) {
            toastr()->error('admin.msg_already_exits');
            return redirect()->back();
        }
        $role = Role::where('guard_name', 'employee')->find($request->id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        toastr()->success(__('admin.msg_success_update'));

        return redirect()->route('employee.roles_employee_index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        toastr()->success(__('admin.msg_success_delete'));
        return redirect()->back();
    }
}
