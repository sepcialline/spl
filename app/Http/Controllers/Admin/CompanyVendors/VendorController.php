<?php

namespace App\Http\Controllers\Admin\CompanyVendors;

use Illuminate\Http\RedirectResponse;
use App\Models\Vendor;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $data['vendors'] = Vendor::where('related_to', Null)->with('companies')->orderBy('id', 'desc')->paginate('50');
        return view('admin.VendorsCompany.VendorsMng.index', $data);
    }
    public function search(Request $request)
    {
        //  return $request->all();
        $result = Vendor::where('name->en', 'LIKE', '%' . $request->search . '%')->orWhere('name->ar', 'LIKE', '%' . $request->search . '%')->with('companies')->get();
        return ['results' => $result->all()];
    }

    public function create()
    {
        $data['countries'] = Country::get();
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        return view('admin.VendorsCompany.VendorsMng.create', $data);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'vendor_name_ar' => 'required',
            'vendor_name_en' => 'required',
            'vendor_mobile' => 'required',
            'vendor_email' => 'required|email|unique:vendors,email',
            'password' => 'required',
            'nationality_id' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'required',
            // 'companies' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $companies = $request->companies;
            $vendor_avatar = Null;
            if ($request->hasFile('avatar')) {
                $vendor_avatar =  time() . '_' . $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('build/assets/img/uploads/vendors/'), $vendor_avatar);
            } else {
                $vendor_avatar = Null;
            }



            $vendor = Vendor::create([
                'name' => ['ar' => $request->vendor_name_ar, 'en' => $request->vendor_name_en],
                'mobile' => $request->vendor_mobile,
                'email' => $request->vendor_email,
                'password' => Hash::make($request->password),
                'nationality_id' => $request->nationality_id,
                'birthdate' => $request->birth_date,
                'gender' => $request->gender,
                'avatar' => $vendor_avatar,
                'status' => 1,
                'created_by' => Auth::guard('admin')->user()->name
            ]);

            if ($vendor) {


                // اضافة دور  ادمن للتاجر
                if (Role::where('name', 'Super Admin')->where('guard_name', 'vendor')->exists()) {
                    $role_vendor = Role::where('name', 'Super Admin')->where('guard_name', 'vendor')->first();
                } else {
                    $role_vendor = Role::create([
                        'name' => 'Super Admin',
                        'guard_name' => 'vendor'
                    ]);
                }

                DB::insert('insert into model_has_roles (role_id, model_type , model_id) values (?, ?,?)', [$role_vendor->id, 'App\Models\Vendor', $vendor->id]);


                if ($request->companies) {
                    foreach ($companies as $company_id) {
                        $company = VendorCompany::where('id',$company_id)->first();
                        if($company){
                            $company->update(['vendor_id'=> $vendor->id]);
                        }
                    }
                }
            } else {
                toastr()->error(__('admin.msg_something_error'));
                return redirect()->back();
            }
        });
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->route('admin.vendors_index');
    }

    public function edit($id)
    {
        $data['vendor'] = Vendor::find($id);
        $data['countries'] = Country::get();
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        return view('admin.VendorsCompany.VendorsMng.edit', $data);
    }

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
                'updated_by' => Auth::guard('admin')->user()->name,
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

    public function show($id){
        $data['vendor'] = Vendor::find($id);
        $data['countries'] = Country::get();
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        return view('admin.VendorsCompany.VendorsMng.show', $data);
    }
    public function destroy($id)
    {
        $user = Auth::User()->name;
        $vendor = Vendor::find($id);
        if ($vendor->delete()) {
            try {
                //code...
                $vendor->update(array('delete_by' => $user));
                // toastr()->success('Success');
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        return response()->json([
            'success' => 'success',
            'user' => $user
        ]);
    }

    public function update_status(Request $request, String $id)
    {

        try {
            //code...
            $vendor = Vendor::find($id);

            $vendor->status = $request->status;

            $result = $vendor->save();

            return response($vendor, 200);

            //return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function change_password(Request $request){
        $vendor = Vendor::find($request->id);
        if($vendor){
            $vendor->update(['password'=>Hash::make($request->get('password'))]);

            toastr()->success('Password has been successfully updated.');
            return redirect()->back();
        }
    }
}
