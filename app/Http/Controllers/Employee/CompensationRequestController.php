<?php

namespace App\Http\Controllers\Employee;

use App\Events\CompensationRequestEvent;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use Illuminate\Support\Facades\DB;
use App\Models\CompensationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        return view('employee.compensation_requests.index', $data);
    }

    public function create()
    {
        $data['companies'] = VendorCompany::where('status', 1)->select('id', 'name')->get();
        return view('employee.compensation_requests.create', $data);
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
                $number = $number + 1;
            } else {
                $number = $number;
            }

            $CompensationRequest = CompensationRequest::create([
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'number' => $number,
                'company_id' => $request->company_id,
                'store_report' => $request->store_report,
                'store_keeper' => Auth::guard('employee')->user()->name,
                'store_check' => 1,
            ]);

            foreach ($request->shipment_no as $key => $shipment) {
                CompensationRequest_info::create([
                    'compensation_request_id' => $CompensationRequest->id,
                    'shipment' => $shipment,
                    'amount' => $request->amount[$key]
                ]);
            }

            event(new CompensationRequestEvent('This is testing data'));

            $operationUsers = Admin::role('Operation Manager','admin')->get();

            foreach ($operationUsers as $operationUser) {
                $data=[
                    'title'=>'تقديم ملف تعويض للتاجر',
                    'number'=>$CompensationRequest->number,
                    'created_by'=> $CompensationRequest->store_keeper,
                    'company'=>$CompensationRequest->company->name
                ];
                $operationUser->notify(new CompensationRequestNotification($data));
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
        return view('employee.compensation_requests.edit', $data);
    }


    public function update(Request $request)
    {

        DB::transaction(function () use($request) {

            $CompensationRequest = CompensationRequest::where('id', $request->id)->first();
            $CompensationRequest->update([
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'number' => $CompensationRequest->number,
                'company_id' => $request->company_id,
                'store_report' => $request->store_report,
                'store_keeper' => Auth::guard('employee')->user()->name,
                'store_check' => 1,
            ]);

            CompensationRequest_info::where('compensation_request_id', $request->id)->delete();

            foreach ($request->shipment_no as $key => $shipment) {
                CompensationRequest_info::create([
                    'compensation_request_id' => $CompensationRequest->id,
                    'shipment' => $shipment,
                    'amount' => $request->amount[$key]
                ]);
            }
        });
        toastr()->success(__('admin.msg_success_update'));
        return redirect()->back();
    }


    public function show($id){
        $data['request'] = CompensationRequest::find($id);
        $data['request_infos'] = CompensationRequest_info::where('compensation_request_id', $id)->get();
        return view('employee.compensation_requests.show', $data);
    }
}
