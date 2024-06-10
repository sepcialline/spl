<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Branch;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\MapSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:admin-Branch-Show-Page'], ['only' => ['index']]);
        $this->middleware(['permission:admin-Branch-add'], ['only' => ['create','store']]);
        $this->middleware(['permission:admin-Branch-show'], ['only' => ['show']]);
        $this->middleware(['permission:admin-Branch-edit'], ['only' => ['edit','updateBranch','updateStatus']]);
        $this->middleware(['permission:admin-Branch-delete'], ['only' => ['delete_branch','destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Branches::get();
        //echo $data;
        return view('admin.branchs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $emirates = Emirates::get();
        $maps = MapSetting::first();
        // return $maps;
        return view('admin.branchs.create', compact('emirates', 'maps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //return json_encode($request->all());
        // return;
        $validated = $request->validate(
            [
                'branch_english_name' => 'required|max:255',
                'branch_arabic_name' => 'required|max:255',
                'landline' => 'required|numeric', //|min:9|max:15',
                'mobile' => 'required|numeric', //|min:9|max:15',
                'email' => 'required|email|max:255',
                'emirates' => 'required|max:255',
                'branch_percentage' => 'required|numeric|max:255',
                'branch_status' => 'required',
                'percentage_in' => 'required|numeric|max:100|min:1',
                'percentage_out' => 'required|numeric|max:100|min:1',
                'map_longitude' => 'required|numeric|max:255',
                'map_latitude' => 'required|numeric|max:255',
                'is_main' => 'required',
            ],
            [
                'branch_english_name.required' => __('admin.this_field_is_required'),
                'branch_arabic_name.required' => __('admin.this_field_is_required'),
                'landline.required' => __('admin.this_field_is_required'),
                'mobile.required' => __('admin.this_field_is_required'),
                'email.required' => __('admin.this_field_is_required'),
                'emirates.required' => __('admin.this_field_is_required'),
                'branch_percentage.required' => __('admin.this_field_is_required'),
                'branch_status.required' => __('admin.this_field_is_required'),
                'percentage_in.required' => __('admin.this_field_is_required'),
                'percentage_out.required' => __('admin.this_field_is_required'),
                'map_longitude.required' => __('admin.this_field_is_required'),
                'map_latitude.required' => __('admin.this_field_is_required'),
                'is_main.required' => __('admin.this_field_is_required'),
            ]
        );

        $branches = new Branches();
        $branches->branch_name     = ['ar' => $request->branch_arabic_name, 'en' => $request->branch_english_name];
        $branches->branch_address     = ['ar' => $request->branch_arabic_address, 'en' => $request->branch_english_address];
        $branches->branch_landline = $request->landline;
        $branches->branch_mobile = $request->mobile;
        $branches->branch_email = $request->email;
        $branches->branch_emirat_id = $request->emirates;
        $branches->percentage = $request->branch_percentage;
        $branches->percentage_in = $request->percentage_in;
        $branches->percentage_out = $request->percentage_out;
        $branches->status = $request->branch_status;
        $branches->longitude = $request->map_longitude;
        $branches->latitude = $request->map_latitude;
        $branches->branch_postal_code = $request->postal_code;
        $branches->is_main = $request->is_main;

        $branches->save();

        toastr()->success('Success');
        return redirect()->back(); //->withSuccess('Success message');;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $data = Branches::query()->find($id);
        $data->emirate_id = Emirates::query()->find($data->branch_emirat_id)->name;

        return view('admin.branchs.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data = Branches::query()->find($id);
        $data->emirates = Emirates::get();
        //echo $data;
        return view('admin.branchs.update', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function updateBranch(Request $request)
    {
        $validated = $request->validate(
            [
                'branch_english_name' => 'required|max:255',
                'branch_arabic_name' => 'required|max:255',
                'landline' => 'required|numeric', //|min:9|max:15',
                'mobile' => 'required|numeric', //|min:9|max:15',
                'email' => 'required|email|max:255',
                'emirates' => 'required|max:255',
                'branch_percentage' => 'required|numeric|max:255',
                'branch_status' => 'required',
                'percentage_in' => 'required|numeric|max:100|min:1',
                'percentage_out' => 'required|numeric|max:100|min:1',
                'map_longitude' => 'required|numeric|max:255',
                'map_latitude' => 'required|numeric|max:255',
                'is_main' => 'required',
            ],
            [
                'branch_english_name.required' => __('admin.this_field_is_required'),
                'branch_arabic_name.required' => __('admin.this_field_is_required'),
                'landline.required' => __('admin.this_field_is_required'),
                'mobile.required' => __('admin.this_field_is_required'),
                'email.required' => __('admin.this_field_is_required'),
                'emirates.required' => __('admin.this_field_is_required'),
                'branch_percentage.required' => __('admin.this_field_is_required'),
                'branch_status.required' => __('admin.this_field_is_required'),
                'percentage_in.required' => __('admin.this_field_is_required'),
                'percentage_out.required' => __('admin.this_field_is_required'),
                'map_longitude.required' => __('admin.this_field_is_required'),
                'map_latitude.required' => __('admin.this_field_is_required'),
                'is_main.required' => __('admin.this_field_is_required'),
            ]
        );

        $data = Branches::query()->find($request->id);


        $data->branch_name     = ['ar' => $request->branch_arabic_name, 'en' => $request->branch_english_name];
        $data->branch_address     = ['ar' => $request->branch_arabic_address, 'en' => $request->branch_english_address];
        $data->branch_landline = $request->landline;
        $data->branch_mobile = $request->mobile;
        $data->branch_email = $request->email;
        $data->branch_emirat_id = $request->emirates;
        $data->percentage = $request->branch_percentage;
        $data->percentage_in = $request->percentage_in;
        $data->percentage_out = $request->percentage_out;
        $data->status = $request->branch_status;
        $data->longitude = $request->map_longitude;
        $data->latitude = $request->map_latitude;
        $data->branch_postal_code = $request->postal_code;
        $data->is_main = $request->is_main;
        $data->save();


        // return $data;
        toastr()->success('Success');
        return redirect()->route('admin.branch_index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Branches::find($id)->delete();
        return back();
    }

    //update status
    public function updateStatus(Request $request, String $id)
    {

        try {
            //code...
            $branch = Branches::find($id);

            $branch->status = $request->status;

            $result = $branch->save();
            // if($result){
            // toastr()->success('Success');
            //}
            return response($branch, 200);

            //return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }

        //$branchStatus->update(['status'=>'1']);
        //return redirect::to('administrator/logo/view');

    }

    // delete branch
    public function delete_branch($id)
    {

        $user = Auth::User()->name;
        $branch = Branches::find($id);
        if ($branch->delete()) {
            try {
                //code...
                $branch->update(array('delete_by' => $user));
                // toastr()->success('Success');
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        return response()->json([
            'success' => 'success',
            //'message' => $message,
            'user' => $user
        ]);
    }
}
