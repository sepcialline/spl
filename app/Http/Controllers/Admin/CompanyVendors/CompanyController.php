<?php

namespace App\Http\Controllers\Admin\CompanyVendors;

use App\Models\COA;
use App\Models\Admin;
use App\Models\Cities;
use App\Models\Emirates;
use App\Models\COALevelI;
use App\Models\COALevelII;
use App\Models\COALevelIII;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Http\Middleware\Vendor;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\AccountTree;
use App\Models\MapSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor as ModelsVendor;
use Faker\Provider\ar_EG\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $data['companies'] = VendorCompany::whereHas('vendors', function ($query) {
            return $query->where('related_to', Null);
        })->with('vendors')->paginate('50');
        return view('admin.VendorsCompany.Companies.index', $data);
    }

        // Search Admins
        public function search(Request $request)
        {
            //  return $request->all();
            $result = VendorCompany::where('name->en', 'LIKE', '%' . $request->search . '%')->orWhere('name->ar', 'LIKE', '%' . $request->search . '%')->with('emirate')->with('vendors')->get();
            return ['results' => $result->all()];
        }


    public function create()
    {
        // $data['sales'] = Admin::where('is_sales', 1)->select('name', 'id')->get();
        $data['sales'] = Admin::select('name', 'id')->get();
        $data['emirates'] = Emirates::select('name', 'id')->get();
        $data['maps'] = MapSetting::first();
        return view('admin.VendorsCompany.Companies.create', $data);
    }


    public function getCieiesByEmirate(Request $request)
    {
        $data['cities'] = Cities::where('emirate_id', $request->id)->select("name", "id")->get();
        return $data['cities'];
    }



    public function store(Request $request)
    {

        // return $request;
        // $validated = $request->validate([
        //     'name_en' => 'required',
        //     'name_ar' => 'required',
        //     'vendor_rate' => 'required|numeric',
        //     'customer_rate' => 'required|numeric',
        //     'commission_rate' => 'required|numeric',
        //     'emirate_id' => 'required',
        //     'city_id' => 'required',
        //     'address_ar' => 'required',
        //     'address_en' => 'required',
        //     'description' => 'required',
        //     'map_longitude' => 'required',
        //     'map_latitude' => 'required',
        //     'logo' => 'image',
        //     'vendor_name_ar' => 'required',
        //     'vendor_name_en' => 'required',
        //     'vendor_mobile' => 'required|unique:vendors,mobile',
        //     'vendor_email' => 'email|required|unique:vendors,email',
        //     'password' => 'required|min:6',
        //     'vendor_avatar' => 'image',
        // ], [
        //     'name_en.required' => __('admin.this_field_is_required'),
        //     'name_ar.required' => __('admin.this_field_is_required'),
        //     'vendor_rate.required' => __('admin.this_field_is_required'),
        //     'customer_rate.required' => __('admin.this_field_is_required'),
        //     'commission_rate.required' => __('admin.this_field_is_required'),
        //     'emirate_id.required' => __('admin.this_field_is_required'),
        //     'city_id.required' => __('admin.this_field_is_required'),
        //     'address_ar.required' => __('admin.this_field_is_required'),
        //     'address_en.required' => __('admin.this_field_is_required'),
        //     'description.required' => __('admin.this_field_is_required'),
        //     'map_longitude.required' => __('admin.this_field_is_required'),
        //     'map_latitude.required' => __('admin.this_field_is_required'),
        //     'vendor_name_ar.required' => __('admin.this_field_is_required'),
        //     'vendor_name_en.required' => __('admin.this_field_is_required'),
        //     'vendor_mobile.required' => __('admin.this_field_is_required'),
        //     'vendor_email.required' => __('admin.this_field_is_required'),
        //     'vendor_email.required' => __('admin.this_field_is_required'),
        //     'password.required' => __('admin.this_field_is_required'),
        // ]);

        $account = null;
        // التحقق من وجود حساب للتجار في شجرة الحسابات تحت الاصول المتداولة
        if (AccountTree::where('account_code', 12)->exists()) {

            //في حال وجود الحساب خزنه في متغير
            $account = AccountTree::where('account_code', 12)->latest()->first();
        } else {

            // والا أنشأ ريكورد داخل الشجرة
            $account = new AccountTree();
            $account->account_level = 2;
            $account->account_code = 12;
            $account->account_name = ['ar' => 'الموجودات المتداولة', 'en' => 'Current assets'];
            $account->account_type = 1;
            $account->account_dc_type =  AccountTree::where('account_code', 1)->latest()->first()->account_dc_type;
            $account->account_parent = AccountTree::where('account_code', 1)->latest()->first()->id;
            $account->account_final = AccountTree::where('account_code', 1)->latest()->first()->account_final;
            $account->created_by = Auth::guard('admin')->user()->name;
            $account->save();
        }

        // تحقق في حال كان الزبائن موجود في الموجودات المتداولة
        if (AccountTree::where('account_code', '121')->exists()) {
            // في حال كان موجود خزنه في متغير
            $account2  = AccountTree::where('account_code', '121')->latest()->first();
        } else {
            // والا أنشأ ريكورد زبائن داخل الشجرة
            $account2 = new AccountTree();
            $account2->account_level = 3;
            $account2->account_code = 121;
            $account2->account_name = ['ar' => 'الزبائن', 'en' => 'customers'];
            $account2->account_type = 1;
            $account2->account_dc_type =  AccountTree::where('account_code', 12)->latest()->first()->account_dc_type;
            $account2->account_parent = AccountTree::where('account_code', 12)->latest()->first()->id;
            $account2->account_final = AccountTree::where('account_code', 12)->latest()->first()->account_final;
            $account2->created_by = Auth::guard('admin')->user()->name;
            $account2->save();
        }

        $account_vendor =  AccountTree::where('account_level', 4)->where('account_parent', $account2->id)->latest()->first();

        $code = Null;
        // ادخال الشركة في شركة الحسابات
        if ($account_vendor) {
            $code = $account_vendor->account_code + 1;
        } else {
            $code = 12100001;
        }
        $account_vendor = new AccountTree();
        $account_vendor->account_level = 4;
        $account_vendor->account_code = $code;
        $account_vendor->account_name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $account_vendor->account_type = 1;
        $account_vendor->account_type = $account2->account_type;
        $account_vendor->account_parent = $account2->id;
        $account_vendor->account_dc_type =  $account2->account_dc_type;
        $account_vendor->account_final = $account2->account_final;
        $account_vendor->created_by = Auth::guard('admin')->user()->name;
        $account_vendor->save();



        if ($request->hasFile('vendor_avatar')) {
            $vendor_avatar =  time() . '_' . $request->vendor_avatar->getClientOriginalName();
            //$data->	logo_en=$admin_image_name;
            $request->vendor_avatar->move(public_path('build/assets/img/uploads/vendors/'), $vendor_avatar);
        } else {
            $vendor_avatar = '';
        }


        if ($request->hasFile('logo')) {
            $logo =  time() . '_' . $request->logo->getClientOriginalName();
            //$data->	logo_en=$admin_image_name;
            $request->logo->move(public_path('build/assets/img/uploads/logos/'), $logo);
        } else {
            $logo = '';
        }

        // انشاء حساب الشركة في جدول الشركات
        $vendor_company = VendorCompany::create([
            'sales_id' => $request->sales_id,
            'account_number' => $code,
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            'vendor_rate' => $request->vendor_rate,
            'customer_rate' => $request->customer_rate,
            'logo' => $logo,
            'emirate_id' => $request->emirate_id,
            'has_stock' => $request->has_stock,
            'city_id' => $request->city_id,
            'has_api' => $request->has_api,
            'address' => ['en' => $request->address_en, 'ar' => $request->address_ar],
            'latitude' => $request->map_latitude,
            'longitude' => $request->map_longitude,
            'description' => $request->description,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'commission_rate' => $request->commission_rate,
            'created_by' => Auth::guard('admin')->user()->name,
            'status' => $request->status
        ]);





        if ($vendor_company->save()) {
            // انشاء حساب التاجر للشركة
            $vendor = new ModelsVendor();
            $vendor->related_to = Null;
            $vendor->name = ['ar' => $request->vendor_name_ar, 'en' => $request->vendor_name_en];
            $vendor->email = $request->vendor_email;
            $vendor->mobile = $request->vendor_mobile;
            $vendor->avatar = $vendor_avatar;
            $vendor->password = Hash::make($request->password);
            $vendor->company_id = $vendor_company->id;
            $vendor->status = 1;
            $vendor->created_by = Auth::guard('admin')->user()->name;
            $vendor->save();
            if ($vendor->save()) {


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

                toastr()->success(__('admin.msg_success_add'));
                return redirect()->route('admin.vendors_company_index');
            } else {
                toastr()->error(__('admin.msg_something_error'));
                return redirect()->back();
            }
        } else {
            toastr()->error(__('admin.msg_something_error'));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $data['maps'] = MapSetting::first();
        $data['company'] = VendorCompany::where('id', $id)->first();
        $data['vendor'] = ModelsVendor::where('related_to', null)->where('company_id', $data['company']->id)->first();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name', 'emirate_id')->get();
        $data['sales'] = Admin::select('id','name')->get();


        return view('admin.VendorsCompany.Companies.edit', $data);
    }

    public function update(Request $request)
    {
        $company = VendorCompany::where('id', $request->company_id)->first();

        $logo = $company->logo;
        if ($request->hasFile('logo')) {
            $logo =  time() . '_' . $request->logo->getClientOriginalName();
            //$data->	logo_en=$admin_image_name;
            $request->logo->move(public_path('build/assets/img/uploads/logos/'), $logo);
            $company->update([
                'logo'=>$logo
            ]);
        }
        $company->update([
            'name' => ['ar' => $request->name_ar, 'en' => $request->name_en],
            'sales_id' => $request->sales_id,
            'vendor_rate' => $request->vendor_rate,
            'customer_rate' => $request->customer_rate,
            'emirate_id' => $request->emirate_id,
            'city_id' => $request->city_id,
            'address' => ['ar' => $request->address_ar, 'en' => $request->address_en],
            'description' => $request->description,
            'status' => $request->status,
            'status' => $request->status,
            'has_stock' => $request->has_stock,
            'has_api' => $request->has_api,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'longitude' => $request->map_longitude,
            'latitude' => $request->map_latitude,
        ]);

        $vendor = ModelsVendor::where('id', $request->vendor_id)->first();


        $avatar = $vendor->avatar;
        if ($request->hasFile('vendor_avatar')) {
            $vendor_avatar =  time() . '_' . $request->vendor_avatar->getClientOriginalName();
            //$data->	logo_en=$admin_image_name;
            $request->vendor_avatar->move(public_path('build/assets/img/uploads/vendors/'), $vendor_avatar);
            $vendor->update([
                'avatar'=>$avatar
            ]);
        }


        $password = $vendor->password;
        if ($request->password == Null) {
            $password = $password;
        } else {
            $vendor->update(['password' => Hash::make($request->password)]);
        }
        $vendor->update([
            'name' => ['ar' => $request->vendor_name_ar, 'en' => $request->vendor_name_en],
            'mobile' => $request->vendor_mobile,
            'email' => $request->vendor_email,
        ]);

        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = Auth::User()->name;
        $company = VendorCompany::find($id);
        if ($company->delete()) {
            try {
                //code...
                $company->update(array('delete_by' => $user));
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

    public function update_status(Request $request, String $id)
    {

        try {
            //code...
            $company = VendorCompany::find($id);

            $company->status = $request->status;

            $result = $company->save();
            // if($result){
            // toastr()->success('Success');
            //}
            return response($company, 200);

            //return redirect()->back();
        } catch (\Throwable $th) {
            return $th;
        }

        //$branchStatus->update(['status'=>'1']);
        //return redirect::to('administrator/logo/view');

    }
}
