<?php

namespace App\Http\Controllers\API\VendorApi;

use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Http\Controllers\Controller;
use App\Http\Resources\GetCompaniesResource;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getVendorCompanies()
    {
        Request()->page_size ? $page_size = Request()->page_size : $page_size = 5;
        $companies = VendorCompany::where('vendor_id', Auth::guard()->id())
            ->whereNull('deleted_at')
            ->where('status', 1)
            ->paginate($page_size);

        if ($companies->count() > 0) {
            $data = GetCompaniesResource::collection($companies);
            return response()->json([
                'code' => 200,
                'message' => 'Companies retrieved successfully.',
                'data' => $data->response()->getData(true)
            ], 200);
        } else {
            return response()->json(['code' => 404, 'message' => 'There is no company found.'], 404);
        }
    }



    public function get_current_company($id)
    {
        $company = VendorCompany::where('vendor_id', Auth::guard()->id())
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->where('status', 1)
            ->first();

        if ($company) {
            $data = new GetCompaniesResource($company);
            return response()->json([
                'code' => 200,
                'message' => 'Company retrieved successfully.',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['code' => 404, 'message' => 'There is no company found.'], 404);
        }
    }
}
