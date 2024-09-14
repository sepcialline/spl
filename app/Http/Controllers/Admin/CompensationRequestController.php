<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use Illuminate\Support\Facades\DB;
use App\Models\CompensationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\CompensationRequestEvent;
use App\Models\CompensationRequest_info;
use App\Notifications\CompensationRequestNotification;

class CompensationRequestController extends Controller
{
    public function index()
    {
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        $data['from'] = Carbon::now()->format('Y-m-d');
        $data['to'] = Carbon::now()->format('Y-m-d');
        // $data['status_list'] = [
        //     '1' => __('admin.need_operation_confirmation'),
        //     '2' => __('admin.need_ceo_confirmation'),
        //     '3' => __('admin.declined')
        // ];

        $data['requests'] = CompensationRequest::orderBy('updated_at', 'desc')->get();
        return view('admin.compensation_requests.index', $data);
    }

    public function create()
    {
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        return view('admin.compensation_requests.create', $data);
    }

    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {
            // if (Request()->has('store_kaper_signeture') && !empty($request->store_kaper_signeture)) {
            //     $folderPath = public_path('sig/');

            //     $image_parts = explode(";base64,", $request->store_kaper_signeture);

            //     $image_type_aux = explode("image/", $image_parts[0]);

            //     $image_type = $image_type_aux[1];

            //     $image_base64 = base64_decode($image_parts[1]);

            //     $file = $folderPath . uniqid() . '.' . $image_type;
            //     file_put_contents($file, $image_base64);
            // }

            $number = 1000000;
            $last_number = CompensationRequest::latest()->first();
            if ($last_number) {
                $number = $last_number->number + 1;
            } else {
                $number = $number;
            }
            $user = Auth::guard('admin')->user();
            if ($user->hasRole(['Super Admin', 'Operation Manager'], 'admin')) {
                $CompensationRequest = CompensationRequest::create([
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'number' => $number,
                    'company_id' => $request->company_id,
                    'operation_report' => $request->operation_report,
                    'operation' => Auth::guard('admin')->user()->name,
                    'operation_check' => 1,
                ]);
            }
            if ($user->hasRole(['Super Admin', 'Admin'], 'admin')) {
                $CompensationRequest = CompensationRequest::create([
                    'date' => Carbon::parse($request->date)->format('Y-m-d'),
                    'number' => $number,
                    'company_id' => $request->company_id,
                    'ceo_report' => $request->ceo_report,
                    'ceo' => Auth::guard('admin')->user()->name,
                    'ceo_check' => 1,
                ]);
            }


            foreach ($request->shipment_no as $key => $shipment) {
                CompensationRequest_info::create([
                    'compensation_request_id' => $CompensationRequest->id,
                    'shipment' => $shipment,
                    'amount' => $request->amount[$key]
                ]);
            }
        });

        toastr()->success(__('admin.msg_success_add'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        $data['request'] = CompensationRequest::find($id);
        $data['request_infos'] = CompensationRequest_info::where('compensation_request_id', $id)->get();
        return view('admin.compensation_requests.edit', $data);
    }


    public function update(Request $request)
    {

        DB::transaction(function () use ($request) {

            $CompensationRequest = CompensationRequest::where('id', $request->id)->first();
            $company = $CompensationRequest->company->name;
            $user = Auth::guard('admin')->user();

            $CompensationRequest->update([
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'number' => $CompensationRequest->number,
                'company_id' => $request->company_id,
            ]);
            if ($user->hasRole(['Super Admin', 'Operation Manager'], 'admin')) {

                $CompensationRequest->update([
                    'operation_report' => $request->operation_report,
                    'operation' => Auth::guard('admin')->user()->name,
                    'operation_check' => 1,

                    'store_report' => $CompensationRequest->store_report ?? Null,
                ]);

                event(new CompensationRequestEvent('This is testing data'));

                $adminUsers = Admin::role('Admin', 'admin')->get();

                foreach ($adminUsers as $adminUser) {
                    $data = [
                        'title' => 'تصديق تعويض للتاجر',
                        'number' => $CompensationRequest->number,
                        'created_by' => $CompensationRequest->operation,
                        'company' => $company
                    ];
                    $adminUser->notify(new CompensationRequestNotification($data));
                }
            }

            if ($user->hasRole(['Super Admin', 'Admin'], 'admin')) {
                $CompensationRequest->update([
                    'ceo_report' => $request->ceo_report,
                    'ceo' => Auth::guard('admin')->user()->name,
                ]);

                if ($request->ceo_check == 1) {
                    $CompensationRequest->update([
                        'ceo_check' => 1,
                        'decline_check' => 0
                    ]);
                    $title = 'موافقة على  تعويض التاجر';
                } else {
                    $CompensationRequest->update([
                        'ceo_check' => 0,
                        'decline_check' => 1
                    ]);
                    $title = 'رفض  تعويض التاجر';
                }

                event(new CompensationRequestEvent('This is testing data'));

                $AccaountUsers = Admin::role('Accountant', 'admin')->get();

                foreach ($AccaountUsers as $AccaountUser) {
                    $data = [
                        'title' => $title,
                        'number' => $CompensationRequest->number,
                        'created_by' => $CompensationRequest->ceo,
                        'company' => $company
                    ];
                    $AccaountUser->notify(new CompensationRequestNotification($data));
                }
            }



            if ($request->shipment_no) {
                $infos = CompensationRequest_info::where('compensation_request_id', $request->id)->delete();
                foreach ($request->shipment_no as $key => $shipment) {
                    CompensationRequest_info::create([
                        'compensation_request_id' => $CompensationRequest->id,
                        'shipment' => $shipment,
                        'amount' => $request->amount[$key]
                    ]);
                }
            }
        });
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }


    public function show($id)
    {
        $data['request'] = CompensationRequest::find($id);
        $data['request_infos'] = CompensationRequest_info::where('compensation_request_id', $id)->get();
        return view('admin.compensation_requests.show', $data);
    }
}
