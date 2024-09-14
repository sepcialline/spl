<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Bank;
use App\Models\Admin;
use App\Models\Cities;
use App\Models\Vendor;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Branches;
use App\Models\Emirates;
use App\Models\Shipment;
use App\Models\JounalType;
use App\Models\MapSetting;
use Illuminate\Support\Str;
use App\Models\CompanyBanks;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\ProductDetails;
use App\Helpers\ShipmentHelper;
use App\Models\AccountingEntries;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ->select('product_details.*',DB::raw("SUM('product_details.quantity')"))
        $data['products'] =
            ProductDetails::selectRaw('product_details.*,SUM(quantity) as qty')
            ->groupBy('product_details.product_id')
            ->whereHas('product', function ($q) {
                $q->where('company_id', Auth::guard('vendor')->user()->company_id);
            })
            ->get();
        $data['delivered_shipments'] = Shipment::where('status_id', 3)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();
        $data['returned_shipments'] = Shipment::where('status_id', 9)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();
        $data['delayed_shipments'] = Shipment::where('status_id', 4)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();
        $data['canceled_shipments'] = Shipment::where('status_id', 6)->where('company_id', Auth::guard('vendor')->user()->company_id)->orderBy('delivered_date', 'desc')->take(5)->get();

        // amount for vendor
        $query = Shipment::query();
        $request = request();

        $data['companies'] = VendorCompany::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        $data['vendor'] = Vendor::where('id', Auth::guard('vendor')->user()->id)->first();

        return view('vendor.dashboard.dashboard', $data);
    }


    public function company_profile($company_id)
    {

        $data['branches'] = Branches::where('is_main', 0)->select('branch_name', 'id')->get();
        $data['vendors'] = Vendor::where('id', Auth::guard('vendor')->user()->id)->where('status', 1)->select('id', 'name')->get();
        $data['banks'] = Bank::select('id', 'name_bank')->get();
        $data['maps'] = MapSetting::first();
        $data['company'] = VendorCompany::where('id', $company_id)->first();
        $data['emirates'] = Emirates::select('id', 'name')->get();
        $data['cities'] = Cities::select('id', 'name', 'emirate_id')->get();
        $data['sales'] = Admin::select('id', 'name')->get();

        return view('vendor.dashboard.company_profile', $data);
    }

    public function company_profile_update(Request $request) {
        $validatedData = $request->validate([
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'emirate_id' => ['required'],
            'city_id' => ['required'],
            'address_en' => ['required'],
            'address_ar' => ['required'],
            'description' => ['required'],
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
                'vendor_rate' => $company->vendor_rate,
                'sales_id' => $company->sales_id  ?? Null,
                'emirate_id' => $request->emirate_id,
                'city_id' => $request->city_id,
                'branch_id' => $company->branch_id ?? Null,
                'address' => ['en' => $request->address_en, 'ar' => $request->address_ar],
                'phone_number' => $request->phone_number,
                'mobile_number' => $request->mobile_number,
                'description' => $request->description,
                'status' => $company->status ?? Null,
                'has_stock' => $company->has_stock ?? Null,
                'has_api' => $company->has_api ?? Null,
                'latitude' => $request->map_latitude,
                'longitude' => $request->map_longitude,
                'logo' => $logo,
                'updated_by' => Auth::guard('vendor')->user()->name,
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
                                'name_owner' => $request->name_owner[$key]
                            ],
                            [
                                'company_id' => $company->id,
                                'bank_id' => $bank,
                                'iban_number' => $request->ibans[$key],
                                'name_owner' => $request->name_owner[$key]
                            ]
                        );
                    }
                }
            }
        });

        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }

    public function deleteAccountBank($bank_id)
    {
        $bank = CompanyBanks::find($bank_id);
        if ($bank) {
            $bank->delete();
        }
        toastr()->success(__('admin.msg_success_delete'));
        return redirect()->back();
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
    public function edit(string $id)
    {
        //
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
    }
}
