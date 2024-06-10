<?php

namespace App\Http\Controllers\Admin\UserManagment;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Cities;
use App\Models\Emirates;
use App\Models\Rider;
use App\Models\VehicleTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRiderController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:admin-rider-show-page'], ['only' => ['index']]);
        $this->middleware(['permission:admin-rider-add'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:admin-rider-show'], ['only' => ['show']]);
        $this->middleware(['permission:admin-rider-edit'], ['only' => ['edit', 'updateRider','update_password']]);
        $this->middleware(['permission:admin-rider-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:admin-rider-change-status'], ['only' => ['update_status']]);
    }
    //
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Rider::paginate(50);


        //return $data->toArray();
        return view('admin.users.rider.index', compact('data'));
    }

    // Search Admins
    public function search(Request $request)
    {
        //  return $request->all();
        $result = Rider::where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere('mobile', 'LIKE', '%' . $request->search . '%')->with('vehicleType')->get();
        return ['results' => $result->all()];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emirates = Emirates::get();
        $branches = Branches::where('is_main', 0)->get();
        $cities = Cities::get();
        $vehicles = VehicleTypes::get();
        // $roles=Role::get();
        return view('admin.users.rider.create', compact('emirates', 'branches', 'cities', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();
        $validated = $request->validate(
            [
                'rider_name_english' => 'required|max:255',
                //'rider_name_arabic' => 'required|max:255',
                'rider_mobile' => 'required|max:255', //|min:9|max:15',
                'rider_password' => 'required|max:255', //|min:9|max:15',
                'rider_email' => 'required|email|max:255',
                'user_emirate' => 'required|max:255',
                'rider_address_english' => 'required|max:255',
                'rider_status' => 'required',
                'vehicle_type' => 'required',
                //'rider_desc' => '',
                // 'rider_image' => 'required',

            ],
            [
                'rider_name_english.required' => __('admin.this_field_is_required'),
                // 'rider_name_arabic.required' => __('admin.this_field_is_required'),
                'rider_mobile.required' => __('admin.this_field_is_required'),
                'rider_password.required' => __('admin.this_field_is_required'),
                'rider_email.required' => __('admin.this_field_is_required'),
                'rider_status.required' => __('admin.this_field_is_required'),
                'user_emirate.required' => __('admin.this_field_is_required'),
                'rider_address_english.required' => __('admin.this_field_is_required'),
                //'rider_address_arabic.required' => __('admin.this_field_is_required'),
                'vehicle_type.required' => __('admin.this_field_is_required'),
                // 'rider_image.required' => __('admin.this_field_is_required'),

            ]
        );

        $rider = new Rider();

        if ($request->file()) {

            if ($request->hasFile('rider_image')) {
                $rider_image_name = $request->rider_image != null ? time() . '_' . $request->rider_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$rider_image_name;
                $request->rider_image->move(public_path('build/assets/img/uploads/avatars'), $rider_image_name);
                $rider->image = $rider_image_name;
            }
        } else {
            // echo 'No';
        }


        $rider->name = ['en' => $request->rider_name_english, 'ar' => $request->rider_name_arabic];
        $rider->mobile = $request->rider_mobile;
        $rider->email = $request->rider_email;
        $rider->password = Hash::make($request->rider_password);
        // $rider->department_id=$request->department_id;
        $rider->city_id = $request->user_city;
        $rider->emirate_id = $request->user_emirate;
        $rider->branch_id = $request->user_branch;
        $rider->address = $request->rider_address_english;
        $rider->vehicle_type = $request->vehicle_type;
        $rider->status = $request->rider_status;
        $rider->save();

        //     foreach ($request->admin_role as $role) {
        //         # code...
        //         $admin->assignRole("$role");
        //     }
        toastr()->success('Success');
        return redirect()->back();
    }

    // update status
    //update status
    public function update_status(Request $request, String $id)
    {

        try {
            //code...
            $rider = Rider::find($id);

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

    public function update_password(Request $request)
    {
        // return $request;
        $rider = Rider::find($request->id);
        $rider->password = Hash::make($request->new_password);
        $rider->save();
        toastr()->success('Success');
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = Rider::find($id);

        return view('admin.users.rider.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Rider::find($id);
        $emirates = Emirates::get();
        $branches = Branches::where('is_main', 0)->get();
        $cities = Cities::get();
        $vehicles = VehicleTypes::get();
        //return $data;
        return view('admin.users.rider.update', compact('data', 'emirates', 'branches', 'cities', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, string $id)
    {
        // return $request->all();
        //     $validated = $request->validate([
        //         'admin_name_english' => 'required|max:255',
        //         'admin_name_arabic' => 'required|max:255',
        //         'admin_mobile' => 'required|max:255',//|min:9|max:15',
        //         'admin_password' => 'required|max:255',//|min:9|max:15',
        //         'admin_email' => 'required|email|max:255',
        //         'user_emirate' => 'required|max:255',
        //         'admin_address_english' => 'required|max:255',

        //         //'admin_address_arabic' => 'required|max:255',
        //         'admin_desc' => '',
        //         'admin_status'=>'required',
        //         'admin_image' => 'required',

        //     ],
        //     [
        //         'admin_name_english.required' => __('admin.this_field_is_required'),
        //         'admin_name_arabic.required' => __('admin.this_field_is_required'),
        //         'admin_mobile.required' => __('admin.this_field_is_required'),
        //         'admin_password.required' => __('admin.this_field_is_required'),
        //         'admin_email.required' => __('admin.this_field_is_required'),
        //         'user_emirate.required' => __('admin.this_field_is_required'),
        //         'admin_status.required' => __('admin.this_field_is_required'),
        //         'admin_address_english.required' => __('admin.this_field_is_required'),
        //         'admin_address_arabic.required' => __('admin.this_field_is_required'),
        //         'admin_desc.required' => __('admin.this_field_is_required'),
        //         'admin_image.required' => __('admin.this_field_is_required'),

        //     ]);
        //     $admin= Admin::find($id) ;

        //     if($request->file()){

        //         if($request->hasFile('admin_image')){
        //             $admin_image_name = $request->admin_image != null ? time().'_'.$request->admin_image->getClientOriginalName():$request->logo_en;
        //             //$data->	logo_en=$admin_image_name;
        //             $request->admin_image->move(public_path('build/assets/img/uploads/avatars'), $admin_image_name);
        //             $admin->photo=$admin_image_name;
        //         }
        //     }else{
        //        // echo 'No';
        //     }
        //     //code...
        //     $admin->name=['en'=>$request->admin_name_english,'ar'=>$request->admin_name_arabic];
        //     $admin->mobile=$request->admin_mobile;
        //     $admin->email=$request->admin_email;
        //     $admin->password=Hash::make( $request->admin_password);
        //     $admin->department_id=$request->department_id;
        //     $admin->city_id=$request->user_city;
        //     $admin->emirate_id=$request->user_emirate;
        //     $admin->branch_id=$request->user_branch;
        //     $admin->description=$request->admin_desc;
        //     $admin->address=$request->admin_address_english;
        //     $admin->is_sales=$request->admin_is_sale;
        //     $admin->status=$request->admin_status;
        //     $admin->save();

        //     $admin->assignRole("$request->admin_role");
        //     toastr()->success('Success');
        //     return redirect()->back();
    }

    public function updateRider(Request $request)
    {
        // return $request->all();
        $validated = $request->validate(
            [
                'rider_name_english' => 'required|max:255',
                //'rider_name_arabic' => 'required|max:255',
                'rider_mobile' => 'required|max:255', //|min:9|max:15',
                //'rider_password' => 'required|max:255',//|min:9|max:15',
                'rider_email' => 'required|email|max:255',
                'user_emirate' => 'required|max:255',
                'rider_address_english' => 'required|max:255',
                'rider_status' => 'required',
                'vehicle_type' => 'required',
                //'rider_desc' => '',
                'rider_image' => '',

            ],
            [
                'rider_name_english.required' => __('admin.this_field_is_required'),
                // 'rider_name_arabic.required' => __('admin.this_field_is_required'),
                'rider_mobile.required' => __('admin.this_field_is_required'),
                //'rider_password.required' => __('admin.this_field_is_required'),
                'rider_email.required' => __('admin.this_field_is_required'),
                'rider_status.required' => __('admin.this_field_is_required'),
                'user_emirate.required' => __('admin.this_field_is_required'),
                'rider_address_english.required' => __('admin.this_field_is_required'),
                //'rider_address_arabic.required' => __('admin.this_field_is_required'),
                'vehicle_type.required' => __('admin.this_field_is_required'),
                // 'rider_image.required' => __('admin.this_field_is_required'),

            ]
        );
        $rider = Rider::find($request->rider_id);

        if ($request->file()) {

            if ($request->hasFile('rider_image')) {
                $rider_image_name = $request->rider_image != null ? time() . '_' . $request->rider_image->getClientOriginalName() : $request->logo_en;
                //$data->	logo_en=$rider_image_name;
                $request->rider_image->move(public_path('build/assets/img/uploads/avatars'), $rider_image_name);
                $rider->image = $rider_image_name;
            }
        } else {
            // echo 'No';
        }
        //code...
        $rider->name = ['en' => $request->rider_name_english, 'ar' => $request->rider_name_arabic];
        $rider->mobile = $request->rider_mobile;
        $rider->email = $request->rider_email;
        $rider->password = Hash::make($request->rider_password);
        $rider->city_id = $request->user_city;
        $rider->emirate_id = $request->user_emirate;
        $rider->branch_id = $request->user_branch;
        $rider->address = $request->rider_address_english;
        $rider->vehicle_type = $request->vehicle_type;
        $rider->status = $request->rider_status;
        $rider->save();


        toastr()->success('Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $rider = Rider::find($id);
        //return $rider;
        if ($rider->delete()) {
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
