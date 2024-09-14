<?php

namespace App\Http\Controllers\Admin\CompanyVendors;

use App\Models\COA;
use App\Models\Bank;
use App\Models\Admin;
use App\Models\Cities;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\COALevelI;
use App\Models\COALevelII;
use App\Models\MapSetting;
use App\Models\AccountTree;
use App\Models\COALevelIII;
use Illuminate\Support\Str;
use App\Models\CompanyBanks;
use Illuminate\Http\Request;
use App\Models\ComapanyBanks;
use App\Models\VendorCompany;
use App\Http\Middleware\Vendor;
use Illuminate\Validation\Rule;
use Faker\Provider\ar_EG\Company;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor as ModelsVendor;

class CompanyController extends Controller
{
    public function index()
    {
        $data['companies'] = VendorCompany::with('owner')->orderBy('id', 'desc')->paginate('50');
        return view('admin.VendorsCompany.Companies.index', $data);
    }

    // Search Admins
    public function search(Request $request)
    {
        //  return $request->all();
        $result = VendorCompany::where('name->en', 'LIKE', '%' . $request->search . '%')->orWhere('name->ar', 'LIKE', '%' . $request->search . '%')->with('emirate')->with('vendor')->with('branch')->get();
        return ['results' => $result->all()];
    }


    public function create()
    {
        $data['branches'] = Branches::where('is_main', 0)->select('branch_name', 'id')->get();
        $data['sales'] = Admin::select('name', 'id')->get();
        $data['emirates'] = Emirates::select('name', 'id')->get();
        $data['maps'] = MapSetting::first();
        $data['vendors'] = ModelsVendor::where('status', 1)->select('id', 'name')->get();
        $data['banks'] = Bank::select('id', 'name_bank')->get();

        return view('admin.VendorsCompany.Companies.create', $data);
    }


    public function getCieiesByEmirate(Request $request)
    {
        $data['cities'] = Cities::where('emirate_id', $request->id)->select("name", "id")->get();
        return $data['cities'];
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'vendor_rate' => ['required'],
            // 'sales_id' => ['required'],
            'branch_id' => ['required'],
            'emirate_id' => ['required'],
            'city_id' => ['required'],
            'address_en' => ['required'],
            'address_ar' => ['required'],
            'description' => ['required'],
            'status' => ['required', Rule::in([0, 1])],
            'has_stock' => ['required', Rule::in([0, 1])],
            'has_api' => ['required', Rule::in([0, 1])],
            'map_longitude' => ['required'],
            'map_latitude' => ['required'],

        ]);

        DB::transaction(function () use ($request) {

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


            if ($request->hasFile('logo')) {
                $logo =  time() . '_' . $request->logo->getClientOriginalName();
                //$data->	logo_en=$admin_image_name;
                $request->logo->move(public_path('build/assets/img/uploads/logos/'), $logo);
            } else {
                $logo = '';
            }

            // انشاء حساب الشركة في جدول الشركات
            $vendor_company = VendorCompany::create([
                'account_number' => $code,
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'slug' => Str::slug($request->name_en),
                'vendor_rate' => $request->vendor_rate,
                'sales_id' => $request->sales_id,
                'emirate_id' => $request->emirate_id,
                'city_id' => $request->city_id,
                'branch_id' => $request->branch_id,
                'address' => ['en' => $request->address_en, 'ar' => $request->address_ar],
                'phone_number' => $request->phone_number,
                'mobile_number' => $request->mobile_number,
                'description' => $request->description,
                'status' => $request->status,
                'has_stock' => $request->has_stock,
                'has_api' => $request->has_api,
                'latitude' => $request->map_latitude,
                'longitude' => $request->map_longitude,
                'logo' => $logo,
                'created_by' => Auth::guard('admin')->user()->name,
                'vendor_id' => $request->vendor ? $request->vendor : Null,
            ]);

            // Add banks if requested
            if (isset($request->banks_name) && count($request->banks_name) > 0) {
                foreach ($request->banks_name as $key => $bank) {
                    if ($bank) { // Check if bank_id is not null
                        CompanyBanks::create([
                            'company_id' => $vendor_company->id,
                            'bank_id' => $bank,
                            'iban_number' => $request->ibans[$key],
                        ]);
                    }
                }
            }
        });
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->route('admin.vendors_company_index');
    }

    public function show($id)
    {

        $data['branches'] = Branches::where('is_main', 0)->select('branch_name', 'id')->get();
        $data['vendors'] = ModelsVendor::where('status', 1)->select('id', 'name')->get();
        $data['banks'] = CompanyBanks::where('company_id', $id)->get();
        $data['maps'] = MapSetting::first();
        $data['company'] = VendorCompany::where('id', $id)->first();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name', 'emirate_id')->get();
        $data['sales'] = Admin::select('id', 'name')->get();


        return view('admin.VendorsCompany.Companies.show', $data);
    }

    public function edit($id)
    {

        $data['branches'] = Branches::where('is_main', 0)->select('branch_name', 'id')->get();
        $data['vendors'] = ModelsVendor::where('status', 1)->select('id', 'name')->get();
        $data['banks'] = Bank::select('id', 'name_bank')->get();
        $data['maps'] = MapSetting::first();
        $data['company'] = VendorCompany::where('id', $id)->first();
        $data['vendor'] = ModelsVendor::where('related_to', null)->where('company_id', $data['company']->id)->first();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name', 'emirate_id')->get();
        $data['sales'] = Admin::select('id', 'name')->get();


        return view('admin.VendorsCompany.Companies.edit', $data);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'vendor_rate' => ['required'],
            // 'sales_id' => ['required'],
            'branch_id' => ['required'],
            'emirate_id' => ['required'],
            'city_id' => ['required'],
            'address_en' => ['required'],
            'address_ar' => ['required'],
            'description' => ['required'],
            'status' => ['required', Rule::in([0, 1])],
            'has_stock' => ['required', Rule::in([0, 1])],
            'has_api' => ['required', Rule::in([0, 1])],
            'map_longitude' => ['required'],
            'map_latitude' => ['required'],
        ]);


        DB::transaction(function () use ($request) {
            $company = VendorCompany::where('id', $request->company_id)->first();

            if ($request->hasFile('logo')) {
                $logo =  time() . '_' . $request->logo->getClientOriginalName();
                $request->logo->move(public_path('build/assets/img/uploads/logos/'), $logo);
            } else {
                $logo = $company->logo;
            }


            // انشاء حساب الشركة في جدول الشركات
            $company->update([
                'account_number' => $company->account_number,
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'slug' => Str::slug($request->name_en),
                'vendor_rate' => $request->vendor_rate,
                'sales_id' => $request->sales_id,
                'emirate_id' => $request->emirate_id,
                'city_id' => $request->city_id,
                'branch_id' => $request->branch_id,
                'address' => ['en' => $request->address_en, 'ar' => $request->address_ar],
                'phone_number' => $request->phone_number,
                'mobile_number' => $request->mobile_number,
                'description' => $request->description,
                'status' => $request->status,
                'has_stock' => $request->has_stock,
                'has_api' => $request->has_api,
                'latitude' => $request->map_latitude,
                'longitude' => $request->map_longitude,
                'logo' => $logo,
                'updated_by' => Auth::guard('admin')->user()->name,
                'vendor_id' => $request->vendor ? $request->vendor : Null,
            ]);

            if ($request->banks_name) {
                foreach ($request->banks_name as $key => $bank) {
                    if ($bank) {
                        CompanyBanks::updateOrCreate(
                            [
                                'company_id' => $company->id,
                                'bank_id' => $bank,
                                'iban_number' => $request->ibans[$key],
                                'name_owner'=>$request->name_owner[$key]
                            ],
                            [
                                'company_id' => $company->id,
                                'bank_id' => $bank,
                                'iban_number' => $request->ibans[$key],
                                'name_owner'=>$request->name_owner[$key]
                            ]
                        );
                    }
                }
            }
        });

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

    public function deleteAccountBank($bank_id)
    {
        $bank = CompanyBanks::find($bank_id);
        if ($bank) {
            $bank->delete();
        }
        return redirect()->back();
    }
}
