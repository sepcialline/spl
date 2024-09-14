<?php

namespace App\Http\Controllers\Admin\CompanyVendors;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $data['from'] = Carbon::now()->format('Y-m-d');
        $data['to'] = Carbon::now()->format('Y-m-d');
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        $data['status_list'] = [
            ["status" => 1, 'name' => __('admin.pending_approval')],
            ["status" => 2, 'name' => __('admin.approved')],
            ["status" => 3, 'name' => __('admin.declined')],
            ["status" => 4, 'name' => __('admin.delayed')],
        ];

        $data['requests'] = ServiceRequest::orderBy('request_number', 'desc')->paginate(50);
        return view('admin.VendorsCompany.serviceRequest.index', $data);
    }

    public function show($id)
    {

        $data['request'] = ServiceRequest::where('id', $id)->first();
        $data['created_by'] = ($data['request']->created_by != Null && $data['request']->guard_created == "vendor") ? Vendor::where('id', $data['request']->created_by)->first() : Admin::where('id', $data['request']->created_by)->first();
        $data['approved_by'] = ($data['request']->approved_by != Null && $data['request']->guard_approved == "vendor") ? Vendor::where('id', $data['request']->approved_by)->first() : Admin::where('id', $data['request']->approved_by)->first();
        $data['declined_by'] = ($data['request']->declined_by != Null && $data['request']->guard_declined == "vendor") ? Vendor::where('id', $data['request']->declined_by)->first() : Admin::where('id', $data['request']->declined_by)->first();
        $data['delayed_by'] = ($data['request']->delayed_by != Null && $data['request']->guard_delyed == "vendor") ? Vendor::where('id', $data['request']->delayed_by)->first() : Admin::where('id', $data['request']->delayed_by)->first();

        return view('admin.VendorsCompany.serviceRequest.show', $data);
    }
    public function edit($id)
    {

        $data['request'] = ServiceRequest::where('id', $id)->first();
        $data['created_by'] = ($data['request']->created_by != Null && $data['request']->guard_created == "vendor") ? Vendor::where('id', $data['request']->created_by)->first() : Admin::where('id', $data['request']->created_by)->first();
        $data['approved_by'] = ($data['request']->approved_by != Null && $data['request']->guard_approved == "vendor") ? Vendor::where('id', $data['request']->approved_by)->first() : Admin::where('id', $data['request']->approved_by)->first();
        $data['declined_by'] = ($data['request']->declined_by != Null && $data['request']->guard_declined == "vendor") ? Vendor::where('id', $data['request']->declined_by)->first() : Admin::where('id', $data['request']->declined_by)->first();
        $data['delayed_by'] = ($data['request']->delayed_by != Null && $data['request']->guard_delyed == "vendor") ? Vendor::where('id', $data['request']->delayed_by)->first() : Admin::where('id', $data['request']->delayed_by)->first();

        return view('admin.VendorsCompany.serviceRequest.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'approved_at' => ['required_if:status,==,2'],
            // 'declined_at' => ['required_if:status,==,3'],
            // 'delayed_at' => ['required_if:status,==,4'],
            'cause' => ['required_if:status,==,3'],
            'cause' => ['required_if:status,==,4'],
        ]);


        $service = ServiceRequest::where('id', $id)->first();
        $auth_id = Auth::guard('admin')->user()->id;
        if ($request->status == 2) {
            $service->update([
                'approved_date' => Carbon::now(),
                'approved_by' => $auth_id,
                'guard_approved' => 'admin',
            ]);
        } else if ($request->status == 3) {
            $service->update([
                'declined_date' => Carbon::now(),
                'declined_by' => $auth_id,
                'guard_declined' => 'admin'
            ]);
        } else if ($request->status == 4) {
            $service->update([
                'delayed_date' => Carbon::now(),
                'delayed_by' => $auth_id,
                'guard_delyed'=>'admin'
            ]);
        }

        $service->update([
            'notes' => $request->notes ?? Null,
            'cause' => $request->cause ?? Null,
        ]);




        return redirect()->back()->with('success', __('admin.msg_success_update'));
    }
}
