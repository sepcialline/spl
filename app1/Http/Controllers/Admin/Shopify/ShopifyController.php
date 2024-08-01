<?php

namespace App\Http\Controllers\Admin\Shopify;

use App\Helpers\GetOrdersHelper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\ShopifyConfig;
use App\Models\ShopifyOrder;
use App\Models\VendorCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use function App\Helpers\getOrders;

class ShopifyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-shopify-show-page', ['only' => ['index']]);
        $this->middleware('permission:admin-shopify-add-merchant', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-shopify-config', ['only' => ['saveShopifyConfig']]);
        $this->middleware('permission:admin-shopify-show', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        // $data = Company::get();
        // foreach ($data as $row) {
        //     # code...
        //     $row['config'] = ShopifyConfig::query()->where('company_id', $row['id'])->first();
        //     // dd($row['config']);
        //     $response = Http::withHeaders([
        //         'X-Shopify-Access-Token' =>  $row['config']['access_token'],

        //     ])->get('https://'.$row['config']['store_name'].'/admin/api/2023-10/orders/count.json?status=open',);
        //     $resp_decoded = json_decode($response);
        //     //return $resp_decoded;
        //     $row['count'] = $resp_decoded->count;
        // }
        $data = GetOrdersHelper::getOrders();
        return view('admin.shopify.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shopify.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $company = new Company();
        $company->name = $request->merchant_name;
        $company->save();
        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function saveShopifyConfig(Request $request)
    {
        // return $request->all();
        //
        // $config=new ShopifyConfig();
        // $config->app_id=$request->app_id;
        // $config->access_token=$request->access_token;
        // $config->company_id=$request->company_id;

        ShopifyConfig::updateOrCreate(
            [
                'company_id' => $request->company_id
            ],
            [
                'company_id' => $request->company_id,
                'store_name' => $request->store_name,
                'access_token' => $request->access_token
            ]
        );
        // $config->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        GetOrdersHelper::getOrders();
        $data = ShopifyOrder::where('status', 0)->where('company_id',$id)->get();
        $data->company_id = $id;
        return view('admin.shopify.show', compact('data'));
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
