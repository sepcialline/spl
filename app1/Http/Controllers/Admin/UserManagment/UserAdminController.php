<?php

namespace App\Http\Controllers\Admin\UserManagment;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branches;
use App\Models\Cities;
use App\Models\Department;
use App\Models\Emirates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserAdminController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:admin-admin-Show-Page'], ['only' => ['index']]);
        $this->middleware(['permission:admin-admin-add'], ['only' => ['create','store']]);
        $this->middleware(['permission:admin-admin-show'], ['only' => ['show']]);
        $this->middleware(['permission:admin-admin-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:admin-admin-delete'], ['only' => ['delete_admin']]);
        $this->middleware(['permission:admin-admin-Change-Status'], ['only' => ['update_status']]);

    }

    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Admin::paginate(50);


        //  return $data->toArray()['links'];
        return view('admin.users.admin.index', compact('data'));
    }

    // Search Admins
    public function search(Request $request)
    {
        $result = Admin::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('mobile', 'LIKE', '%' . $request->search . '%')->get();
        return ['results' => $result->all()];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emirates = Emirates::get();
        $branches = Branches::get();
        $cities = Cities::get();
        $departments = Department::get();
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.users.admin.create', compact('emirates', 'branches', 'cities', 'roles','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validated = $request->validate(
            [
                'admin_name_english' => 'required|max:255',
                'admin_name_arabic' => 'required|max:255',
                'admin_mobile' => 'required|max:255', //|min:9|max:15',
                'admin_password' => 'required|max:255', //|min:9|max:15',
                'admin_email' => 'required|email|max:255',
                'user_emirate' => 'required|max:255',
                'admin_address_english' => 'required|max:255',
                'admin_status' => 'required',
                'admin_is_sale' => '',
                'admin_desc' => '',
                'admin_image' => 'required',

            ],
            [
                'admin_name_english.required' => __('admin.this_field_is_required'),
                'admin_name_arabic.required' => __('admin.this_field_is_required'),
                'admin_mobile.required' => __('admin.this_field_is_required'),
                'admin_password.required' => __('admin.this_field_is_required'),
                'admin_email.required' => __('admin.this_field_is_required'),
                'admin_status.required' => __('admin.this_field_is_required'),
                'user_emirate.required' => __('admin.this_field_is_required'),
                'admin_address_english.required' => __('admin.this_field_is_required'),
                'admin_address_arabic.required' => __('admin.this_field_is_required'),
                'admin_desc.required' => __('admin.this_field_is_required'),
                'admin_image.required' => __('admin.this_field_is_required'),

            ]
        );

        $admin = new Admin();

        if ($request->file()) {

            if ($request->hasFile('admin_image')) {
                $admin_image_name = $request->admin_image != null ? time() . '_' . $request->admin_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $admin_image_name);
                $admin->photo = $admin_image_name;
            }
        } else {
            // echo 'No';
        }

        //code...
        $admin->name = ['en' => $request->admin_name_english, 'ar' => $request->admin_name_arabic];
        $admin->mobile = $request->admin_mobile;
        $admin->email = $request->admin_email;
        $admin->password = Hash::make($request->admin_password);
        $admin->department_id = $request->department_id;
        $admin->city_id = $request->user_city;
        $admin->emirate_id = $request->user_emirate;
        $admin->branch_id = $request->user_branch;
        $admin->description = $request->admin_desc;
        $admin->address = $request->admin_address_english;
        $admin->is_sales = $request->admin_is_sale;
        $admin->status = $request->admin_status;
        $admin->save();

        foreach ($request->admin_role as $role) {
            # code...
            $admin->assignRole("$role");
        }
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function update_password(Request $request)
    {
        $admin = Admin::find($request->id);
        $admin->password = Hash::make($request->new_password);
        $admin->save();
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Admin::find($id);
        // $current_role = DB::table('model_has_roles')->where('model_id', $id)->get();
        $current_role = DB::table('model_has_roles')->where('model_type','App\\Models\\Admin')->where('model_id', $id)->get();
        $role = Role::query()->where('id', $current_role[0]->role_id)->get();
        return view('admin.users.admin.show', compact('data', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $departments = Department::get();
        $data = Admin::find($id);
        $emirates = Emirates::get();
        $branches = Branches::get();
        $cities = Cities::get();
        $roles = Role::where('guard_name', 'admin')->get();
        $current_roles = DB::table('model_has_roles')->where('model_type','App\\Models\\Admin')->where('model_id', $id)->get();
        $values = array();
        foreach ($current_roles as $current_role) {
            # code...
            $role = Role::query()->where('id', $current_role->role_id)->get()[0];
            array_push($values, $role->name);
        }
        //return $data;
        return view('admin.users.admin.update', compact('data', 'emirates', 'branches', 'cities', 'roles', 'current_role', 'values','departments'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, string $id)
    {
        // return $request->all();
        $validated = $request->validate(
            [
                'admin_name_english' => 'required|max:255',
                'admin_name_arabic' => 'required|max:255',
                'admin_mobile' => 'required|max:255', //|min:9|max:15',
                'admin_password' => 'required|max:255', //|min:9|max:15',
                'admin_email' => 'required|email|max:255',
                'user_emirate' => 'required|max:255',
                'admin_address_english' => 'required|max:255',

                //'admin_address_arabic' => 'required|max:255',
                'admin_desc' => '',
                'admin_status' => 'required',
                'admin_image' => 'required',

            ],
            [
                'admin_name_english.required' => __('admin.this_field_is_required'),
                'admin_name_arabic.required' => __('admin.this_field_is_required'),
                'admin_mobile.required' => __('admin.this_field_is_required'),
                'admin_password.required' => __('admin.this_field_is_required'),
                'admin_email.required' => __('admin.this_field_is_required'),
                'user_emirate.required' => __('admin.this_field_is_required'),
                'admin_status.required' => __('admin.this_field_is_required'),
                'admin_address_english.required' => __('admin.this_field_is_required'),
                'admin_address_arabic.required' => __('admin.this_field_is_required'),
                'admin_desc.required' => __('admin.this_field_is_required'),
                'admin_image.required' => __('admin.this_field_is_required'),

            ]
        );
        $admin = Admin::find($id);

        if ($request->file()) {

            if ($request->hasFile('admin_image')) {
                $admin_image_name = $request->admin_image != null ? time() . '_' . $request->admin_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $admin_image_name);
                $admin->photo = $admin_image_name;
            }
        } else {
            // echo 'No';
        }
        //code...
        $admin->name = ['en' => $request->admin_name_english, 'ar' => $request->admin_name_arabic];
        $admin->mobile = $request->admin_mobile;
        $admin->email = $request->admin_email;
        // $admin->password = Hash::make($request->admin_password);
        $admin->department_id = $request->department_id;
        $admin->city_id = $request->user_city;
        $admin->emirate_id = $request->user_emirate;
        $admin->branch_id = $request->user_branch;
        $admin->description = $request->admin_desc;
        $admin->address = $request->admin_address_english;
        $admin->is_sales = $request->admin_is_sale;
        $admin->status = $request->admin_status;
        $admin->save();

        $admin->assignRole("$request->admin_role");
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }

    public function updateAdmin(Request $request)
    {
        //return $request->all();
        $validated = $request->validate(
            [
                'admin_name_english' => 'required|max:255',
                'admin_name_arabic' => 'required|max:255',
                'admin_mobile' => 'required|max:255', //|min:9|max:15',
                //'admin_password' => 'required|max:255',//|min:9|max:15',
                'admin_email' => 'required|email|max:255',
                'user_emirate' => 'required|max:255',
                'admin_address_english' => 'required|max:255',
                //'admin_address_arabic' => 'required|max:255',
                'admin_status' => 'required',
                'admin_desc' => '',
                'admin_image' => '',

            ],
            [
                'admin_name_english.required' => __('admin.this_field_is_required'),
                'admin_name_arabic.required' => __('admin.this_field_is_required'),
                'admin_mobile.required' => __('admin.this_field_is_required'),
                //'admin_password.required' => __('admin.this_field_is_required'),
                'admin_email.required' => __('admin.this_field_is_required'),
                'user_emirate.required' => __('admin.this_field_is_required'),
                'admin_address_english.required' => __('admin.this_field_is_required'),
                'admin_status.required' => __('admin.this_field_is_required'),
                'admin_address_arabic.required' => __('admin.this_field_is_required'),
                'admin_desc.required' => __('admin.this_field_is_required'),
                'admin_image.required' => __('admin.this_field_is_required'),

            ]
        );
        $admin = Admin::find($request->admin_id);

        if ($request->file()) {

            if ($request->hasFile('admin_image')) {
                $admin_image_name = $request->admin_image != null ? time() . '_' . $request->admin_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$admin_image_name;
                $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $admin_image_name);
                $admin->photo = $admin_image_name;
            }
        } else {
            // echo 'No';
        }
        //code...
        $admin->name = ['en' => $request->admin_name_english, 'ar' => $request->admin_name_arabic];
        $admin->mobile = $request->admin_mobile;
        $admin->email = $request->admin_email;
        $admin->password = Hash::make($request->admin_password);
        $admin->department_id = $request->department_id;
        $admin->city_id = $request->user_city;
        $admin->emirate_id = $request->user_emirate;
        $admin->branch_id = $request->user_branch;
        $admin->description = $request->admin_desc;
        $admin->address = $request->admin_address_english;
        $admin->is_sales = $request->admin_is_sale;
        $admin->status = $request->admin_status;
        $admin->save();
        DB::table('model_has_roles')->where('model_id', $request->admin_id)->delete();
        foreach ($request->admin_role as $role) {
            # code...
            $admin->assignRole("$role");
        }

        toastr()->success('Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $admin = Admin::find($id);
        if ($admin->delete()) {
            return response()->json([
                'success' => 'success',
            ]);
        } else {
            return response()->json([
                'error' => 'error',
            ]);
        }
    }


    public function update_status(Request $request, String $id )
    {

        try {
            //code...
            $admin = Admin::find($id);

            $admin->status = $request->status;

            $result=$admin->save();
           // if($result){
                // toastr()->success('Success');
            //}
            return response($admin,200);

            //return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }

        //$branchStatus->update(['status'=>'1']);
        //return redirect::to('administrator/logo/view');

    }

    // delete branch
    public function delete_admin($id)
    {

        // $user=Auth::User()->name;
        $admin = Admin::find($id);
        if ($admin->delete()) {
            return response()->json([
                'success' => 'success',
            ]);
        } else {
            return response()->json([
                'error' => 'error',
            ]);
        }
    }
}
